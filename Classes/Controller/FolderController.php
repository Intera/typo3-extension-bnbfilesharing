<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 3 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 *
 *
 * @package filesharing
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class Tx_Bnbfilesharing_Controller_FolderController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * folderRepository
	 *
	 * @var Tx_Bnbfilesharing_Domain_Repository_FolderRepository
	 */
	public $folderRepository;
	public $filesRepository;
	protected	$imgPfad = "typo3conf/ext/bnbfilesharing/Resources/Public/img/";
	protected	$configuration;	
	protected	$loadjquery;
	protected	$loadFancybox;
	protected	$loadjqueryForm;	
	protected	$createLocalRecords = false;
	protected	$not_translated_wrap;	
	protected	$orderFolderField = 'name';
	protected	$orderFolderOrder = 'ASC';
	protected	$orderFilesField = 'beschriftung';
	protected	$orderFilesOrder = 'ASC';
	

	function __construct(){
		parent::__construct();
		$this->filesRepository  = new Tx_Bnbfilesharing_Domain_Repository_FilesRepository();				
}

	/**
	 * injectFolderRepository
	 *
	 * @param Tx_Bnbfilesharing_Domain_Repository_FolderRepository $folderRepository
	 * @return void
	 */	 	 
	public function injectFolderRepository(Tx_Bnbfilesharing_Domain_Repository_FolderRepository $folderRepository) {
		$this->folderRepository = $folderRepository;
	}
	
	/*********************************************************
	formats folder tree
	*********************************************************/	
	public 	function getfolder($folderid,$nofirstul=0){
		
		$this->getConfiguration();
		
		$fe_uid=$GLOBALS['TSFE']->fe_user->user['uid'];
		
		$folders = $this->folderRepository->findSortedByFolder($folderid,$this->orderFolderField,$this->orderFolderOrder);			
		
		if($folderid != 0)
			$classhide = 'class="hide"';
		
		//functioncall from ajax	
		if($nofirstul == 0)
			$str .= '<ul '.$classhide.'  id="pf'.$folderid.'">'."\n";
		//new folder for root		
		if( $folderid == 0 && $this->canCreateRootFolder($GLOBALS['TSFE']->fe_user->user['usergroup']))
			$str .= '<li><a class="inline" href="#newfolderform" onmousedown="newfolder(0)">'.Tx_Extbase_Utility_Localization::translate('newfolder', 'Bnbfilesharing').'</a></li>';			
								
		foreach($folders as $folder)	{				
			$row = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow(
 		  'folder',
	    'tx_bnbfilesharing_domain_model_folder',
	    'uid = '.$folder->getUid()
			);
			$parentFolder = $row['folder'];
			

			$str .= '<li  class="kategorie"><a class="flip" href="javascript:void(0)"><span class="aufzu">+</span>'."\n";
			$str .= '<span class="name">'.$this->encode($folder->getName())."</span>\n";
			$str .= "</a>"."\n";
			
			if($this->canEditFolder($GLOBALS['TSFE']->fe_user->user['usergroup'],$folder->getFeuserid(),$GLOBALS['TSFE']->fe_user->user['uid']))
				$str .= ' <a class="inline" href="#editfolderform" onmousedown="javascript:editfolder('.$parentFolder.','.$folder->getUid().',\''.$this->encode($folder->getName()).'\')"><img src="'.$this->imgPfad.'edit.gif" alt="edit" width="11" height="14" /></a>';					
			
			if($this->canDeleteFolder($GLOBALS['TSFE']->fe_user->user['usergroup'],$folder->getFeuserid(),$GLOBALS['TSFE']->fe_user->user['uid']))
				$str .= ' <a class="deletefolder" href="javascript:void(0)" onmousedown="deletefolder('.$parentFolder.','.$folder->getUid().',\''.$this->encode($folder->getName()).'\')"><img src="'.$this->imgPfad.'loeschen.gif" alt="delete" width="11" height="14" /></a>';													

					
			$str .= '<ul class="hide" id="ff'.$folder->getUid().'">'."\n";				
			$str .= $this->getfiles($folder->getUid());				
			$str .= "</ul>"."\n";								
			$str .= $this->getfolder($folder->getUid(),0); 											
			$str .= "</li>"."\n";				
		}	
		
		//functioncall from ajax	
		if($nofirstul == 0)			
			$str .= "</ul>"."\n";
		
		return ($str);		
	}
	/*********************************************************
	formats file list
	*********************************************************/	
	public function	getfiles($folderid){
		
		$this->getConfiguration();
		
		$folder = $this->folderRepository->findByUid($folderid);			
		$uidowner = $folder->getFeuserid();
		
		$fe_uid=$GLOBALS['TSFE']->fe_user->user['uid'];		
				
		if($this->canCreateFolder($GLOBALS['TSFE']->fe_user->user['usergroup'],$folder->getFeuserid(),$GLOBALS['TSFE']->fe_user->user['uid']) )
			$str .= '<li ><a class="inline" href="#newfolderform" onmousedown="newfolder('.$folderid.')">'.Tx_Extbase_Utility_Localization::translate('newfolder', 'Bnbfilesharing').'</a></li>';	

			
   if($this->canUploadFiles($GLOBALS['TSFE']->fe_user->user['usergroup'],$uidowner,$GLOBALS['TSFE']->fe_user->user['uid'])) 					
			$str .= '<li class="hochladen"><a class="inline upload" href="#uploadform" onmousedown="javascript:uploadfile('.$folderid.',0)"><img src="'.$this->imgPfad.'upload.gif" alt="" width="11" height="14" />Upload</a></li>'."\n";				
	
		$files = $this->filesRepository->findSortedByFolder($folderid,$this->orderFilesField,$this->orderFilesOrder);
		
		foreach( $files as $file){
			
			$Path = PATH_site."/uploads/tx_bnbfilesharing/";
				
			$filesize=filesize($Path.$file->getFile())/(1024*1024); 
			$filetime = filemtime ($Path.$file->getFile());
								
			if($file->getFeuserid() > 0){				
				$row = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow(
			  'username',
		    'fe_users',
		    'uid = '.$file->getFeuserid() );			
				$feuserName =$row["username"];				
			}
			else	
				$feuserName = "";
								
				$str .= '<li>';
				$str .= '<ul  class="eintrag">
								 <li class="datei" >';
				if($this->canDownloadFiles($GLOBALS['TSFE']->fe_user->user['usergroup']))
					$str .= '<a class="link" href="javascript:downloadfile('.$file->getUid().')" >';
				$str .= $this->encode($file->getBeschriftung());
				
				if($this->canDownloadFiles($GLOBALS['TSFE']->fe_user->user['usergroup']))
					$str .= '</a>';
					$str .= ' ('.sprintf("%.3f",$filesize).' MB)</li>
								 <li class="datum">'.date("d.m.Y",$filetime).'</li>
								 <li class="autor">'.$this->encode($feuserName).'</li>';
			   if($this->createLocalRecords && $this->canUploadFiles($GLOBALS['TSFE']->fe_user->user['usergroup'],$uidowner,$GLOBALS['TSFE']->fe_user->user['uid'])) 					
						$str .= '<li class="upload-lang"><a class="inline upload" href="#uploadform" onmousedown="javascript:uploadfile('.$folderid.','.$file->getUid().')"><img src="'.$this->imgPfad.'upload.gif" alt="" width="11" height="14" /></a></li>';
			
		   if($this->canEditFiles($GLOBALS['TSFE']->fe_user->user['usergroup'],$file->getFeuserid(),$fe_uid))
				 $str .= '<li class="editieren">
								 <a class="inline" href="#editform"  onmousedown="javascript:editfile('.$folderid.','.$file->getUid().',\''.$this->encode(addslashes($file->getBeschriftung())).'\')">
								 <img src="'.$this->imgPfad.'edit.gif" alt="edit" width="14" height="14" />
								 </a></li>';

		   if($this->canDeleteFiles($GLOBALS['TSFE']->fe_user->user['usergroup'],$file->getFeuserid(),$fe_uid))								 					
					$str .= '<li class="delete">
									 <a href="javascript:void(0)" onmousedown="deletefile('.$folderid.','.$file->getUid().',\''.$this->encode(addslashes($file->getBeschriftung())).'\')">
									 <img src="'.$this->imgPfad.'loeschen.gif" alt="delete" width="11" height="14" />
									 </a></li>';								 

				$str .= '</ul>';
				$str .= '</li>';
		}				
		return $str;				
	}
	
	/**
	 * action list
	 *
	 * @return string The rendered list action
	 */
	public function listAction() {
		
		$GLOBALS['TSFE']->no_cache=1;
		
		$this->getConfiguration();
					
		$GLOBALS['TSFE']->additionalHeaderData[$this->prefixId] = '<script type="text/javascript">		
		var lang="'.$GLOBALS['TSFE']->sys_language_uid.'";				
		</script>';
				
		if($this->loadjquery)
			$GLOBALS['TSFE']->additionalHeaderData[$this->prefixId] .='<script type="text/javascript" src="typo3conf/ext/bnbfilesharing/Resources/Public/javascript/jquery.js"></script>';						
		if($this->loadjqueryForm)		
			$GLOBALS['TSFE']->additionalHeaderData[$this->prefixId] .='<script type="text/javascript" src="typo3conf/ext/bnbfilesharing/Resources/Public/javascript/jqueryform.js"></script>';
		$GLOBALS['TSFE']->additionalHeaderData[$this->prefixId] .='<script type="text/javascript" src="typo3conf/ext/bnbfilesharing/Resources/Public/javascript/filesharing.js"></script>';		
		if($this->loadjqueryForm){				
			$GLOBALS['TSFE']->additionalHeaderData[$this->prefixId] .='<script type="text/javascript" src="typo3conf/ext/bnbfilesharing/Resources/Public/javascript/fancybox/jquery.fancybox-1.3.4.js"></script>';		
			$GLOBALS['TSFE']->additionalHeaderData[$this->prefixId] .='<link rel="stylesheet" href="typo3conf/ext/bnbfilesharing/Resources/Public/javascript/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />';		
		}	
						
		$str=$this->getfolder(0); 
				
		$this->view->assign('fileblock', $str);
		$this->view->assign('maxfilesize', $this->configuration['persistence']['maxUploadFilesize']);
	}

	/*********************************************************
	adds a new folder
	*********************************************************/		
	public function ajaxAddFolderAction() {
		
		$this->getConfiguration();
							
		if($this->request->hasArgument('name'))
			$name = $this->request->getArgument('name');	
		else
			die("No name submitted");
			
		if($this->request->hasArgument('parentFolder'))
			$parentFolder = $this->request->getArgument('parentFolder');	
		else
			die("No parentFolder submitted");
									
		//No Root Access	
		if($parentFolder == 0 && ! $this->canCreateRootFolder($GLOBALS['TSFE']->fe_user->user['usergroup']) )
			die("Action Forbidden");
	
		//No Access to Subfolders
		if($parentFolder > 0 ){
			$folder = $this->folderRepository->findByUid($parentFolder);							
			if( ! $this->canCreateFolder($GLOBALS['TSFE']->fe_user->user['usergroup'],$GLOBALS['TSFE']->fe_user->user['uid'],$folder->getFeuserid()) )		
		 		die("Action forbidden");		
		}		
												
		$newFolderObj = new Tx_Bnbfilesharing_Domain_Model_Folder();
		if($this->createLocalRecords &&  ($GLOBALS['TSFE']->sys_language_uid != 0 || $GLOBALS['TSFE']->sys_language_uid != ""))		
			$newFolderObj->setName($this->not_translated_wrap[0].$name.$this->not_translated_wrap[1]);			
		else	
			$newFolderObj->setName($name);			
	
		$newFolderObj->setFeuserid($GLOBALS['TSFE']->fe_user->user['uid']);					
		$newFolderObj->setFeuserug($GLOBALS['TSFE']->fe_user->user['usergroup']);			
			
		$newFolderObj->setFolder($parentFolder);						
							
		$this->folderRepository->add($newFolderObj);		
		
		$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');				
		$persistenceManager->persistAll();
		
		//create local records
		if($this->createLocalRecords == 1){												
			$this->folderRepository->createLocalRecords($name=$name,$wrap=$this->not_translated_wrap,$pid=$this->configuration['persistence']['storagePid'],$parentfolder=$parentFolder);
		}
	}	
	/*********************************************************
	edit folder
	*********************************************************/			
	public function ajaxEditFolderAction() {		
			
		if($this->request->hasArgument('name'))
			$Name = $this->request->getArgument('name');	
		else
			die("No name submitted");
			
		if($this->request->hasArgument('parentFolder'))
			$parentFolder = $this->request->getArgument('parentFolder');	
		else
			die("No parentFolder submitted");	
					
		if($this->request->hasArgument('uid'))
			$folder = $this->folderRepository->findByUid($this->request->getArgument('uid'));		
		else
			die("no uid submitted");	
			
			
		if(!$this->canCreateFolder($GLOBALS['TSFE']->fe_user->user['usergroup'],$folder->getFeuserid(),$GLOBALS['TSFE']->fe_user->user['uid']))
	 		die("Action forbidden");			
			
		$folder->setName($Name);
		
		return($this->getfolder($parentFolder,1));
	}
	
	/*********************************************************
	delete a folder
	*********************************************************/		
	public function ajaxDeleteFolderAction() {
										
		if($this->request->hasArgument('parentFolder'))
			$parentFolder = $this->request->getArgument('parentFolder');	
		else
			die("No parentFolder submitted");		
			
		if($this->request->hasArgument('uid'))
			$folder = $this->folderRepository->findByUid($this->request->getArgument('uid'));		
		else
			die("No uid submitted");		
			
		//No Acces to Delete folder	
		if(!$this->canDeleteFolder($GLOBALS['TSFE']->fe_user->user['usergroup'],$folder->getFeuserid(),$GLOBALS['TSFE']->fe_user->user['uid']))	
	 		die("Action forbidden");						
						
		//delete only empty folders	
		if($this->hasChildren($this->request->getArgument('uid'))	=== false){		
			$this->folderRepository->remove($folder);						

			//mark localization records as deleted			
			$this->folderRepository->deleteLocalRecords($this->request->getArgument('uid'))	;
			
			$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');				
			$persistenceManager->persistAll();			
			
			//no empty string
			$str=$this->getfolder($parentFolder,1)." "; 			
		}	
		else 
			die("no uid submitted");
		
		return($str);			
	}
	/*********************************************************
	check if folder is empty
	*********************************************************/			
	public function ajaxCanDeleteFolderAction() {
		if($this->request->hasArgument('uid'))
			$folder = $this->folderRepository->findByUid($this->request->getArgument('uid'));		
		else
			die("No uid");
		
		if($this->hasChildren($this->request->getArgument('uid'))	=== false)		
			return("1");
		else 
			return("0");	
	}
	/*********************************************************
	repaint the folder tree
	*********************************************************/					
	public function ajaxRepaintFolderAction() {			
		if($this->request->hasArgument('parentFolder'))
			$parentFolder = $this->request->getArgument('parentFolder');	
		else
			die("No parentfolder in RepaintFolderAction");					
			
		if($this->request->hasArgument('deleted'))
			$deleted = $this->request->getArgument('deleted');	
			
		$str=$this->getfolder($parentFolder,1,$deleted); 	
		
		return($str);
	}
	/*********************************************************
	repaint the files tree
	*********************************************************/					
	public function ajaxRepaintFilesAction() {	

		if(empty($_POST["pid"]))
			die("No parentfolder in RepaintFolderAction");					
		else 
			$parentFolder = $_POST["pid"];		
						
			
		if($this->request->hasArgument('deleted'))
			$deleted = $this->request->getArgument('deleted');	
	
		$str=$this->getFiles($parentFolder); 	
		
		return($str);
	}
	/*********************************************************
	Format strings in utf-8 format
	*********************************************************/
	public function encode($str){			
		return htmlentities(utf8_decode($str));										
	}
	/*********************************************************
	Return false if folder is empty
	*********************************************************/
	public function hasChildren($uid){
		$folders = $this->folderRepository->findOneByFolder($uid);			
		$files = $this->filesRepository->findOneByFolder($uid);			
			
		if($folders === null && $files  === null)
			return	false;
		else 	
			return	true;
	}	
	/*********************************************************
	Can user create RootFolder
	*********************************************************/		
	public function getConfig()	{
		if(!isset($this->configuration)){
			$this->configuration = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
			if(empty($this->configuration['persistence']['storagePid']) || !isset($this->configuration['persistence']['storagePid']) ){
				$this->flashMessageContainer->add('No storagePid! You have to include the static template of this extension and set the constant plugin.tx_' . t3lib_div::lcfirst($this->extensionName) . '.persistence.storagePid in the constant editor');
			}
		}	
	}

	/*********************************************************
	get usergrous in an array
	*********************************************************/			
	public function getUsergroupArray($ug){
			if( !empty($ug))
				$ug = explode(",",$ug);
			else	
				$ug[0] = -1;
				
		return ($ug);
	}

	/*********************************************************
	Can user create RootFolder?
	*********************************************************/		
	public function canCreateRootFolder($ug)	{
			$this->getConfig();
			$ug =	$this->getUsergroupArray($ug);
			
			if( ( in_array ($this->configuration['persistence']['userGroupAllowCreateRootFolders'] , $ug) 
						|| in_array ($this->configuration['persistence']['userGroupAdmin'] , $ug) 
						|| $this->configuration['persistence']['userGroupAllowCreateRootFolders'] == 'all'	)  					
						&& !empty($this->configuration['persistence']['userGroupAllowCreateFolders']))			
				return(true);
			else 
				return(false);
	}	
	/*********************************************************
	Can user create Folder?
	*********************************************************/		
	public function canCreateFolder($ug,$owner,$fe_uid)	{
			$this->getConfig();
			$ug =	$this->getUsergroupArray($ug);
			
			if( ( in_array ($this->configuration['persistence']['userGroupAllowCreateFolders'] , $ug) 
						|| $this->configuration['persistence']['userGroupAllowCreateFolders'] == 'all'
						|| in_array ($this->configuration['persistence']['userGroupAdmin'] , $ug) 
						|| ($this->configuration['persistence']['userGroupAllowCreateFolders'] == 'owner' && $ug > 0 && $owner == $fe_uid) )  					
						&& !empty($this->configuration['persistence']['userGroupAllowCreateFolders']))
				return(true);
			else 
				return(false);
	}	

	/*********************************************************
	Can user create Folder?
	*********************************************************/		
	public function canEditFolder($ug,$owner,$fe_uid)	{
			$this->getConfig();
			$ug =	$this->getUsergroupArray($ug);
								
			if( ( in_array ($this->configuration['persistence']['userGroupAdmin'] , $ug) 
						|| in_array ($this->configuration['persistence']['userGroupAllowEditFolders'] , $ug) 
						|| $this->configuration['persistence']['userGroupAllowEditFolders'] == 'all'
						|| ($this->configuration['persistence']['userGroupAllowEditFolders'] == 'owner' && $ug > 0 && $owner == $fe_uid) )  					
						&& !empty($this->configuration['persistence']['userGroupAllowEditFolders']))
				return(true);
			else 
				return(false);
	}	

	/*********************************************************
	Can user Delete Folder?
	*********************************************************/		
	public function canDeleteFolder($ug,$owner,$fe_uid)	{
			$this->getConfig();
			$ug =	$this->getUsergroupArray($ug);
			
			if( ( in_array ($this->configuration['persistence']['userGroupAdmin'] , $ug) 
						|| in_array ($this->configuration['persistence']['userGroupAllowDeleteFolders'] , $ug) 
						|| $this->configuration['persistence']['userGroupAllowDeleteFolders'] == 'all'
						|| ($this->configuration['persistence']['userGroupAllowDeleteFolders'] == 'owner' && $ug > 0 && $owner == $fe_uid) )  					
						&& !empty($this->configuration['persistence']['userGroupAllowDeleteFolders']))
				return(true);
			else 
				return(false);
	}	
	
	/*********************************************************
	Can user Edit Files?
	*********************************************************/		
	public function canEditFiles($ug,$owner,$fe_uid){
			$this->getConfig();
			$ug =	$this->getUsergroupArray($ug);
			
			if( ( in_array ($this->configuration['persistence']['userGroupAdmin'] , $ug) 
						|| in_array ($this->configuration['persistence']['userGroupAllowEditFiles'] , $ug) 
						|| $this->configuration['persistence']['userGroupAllowEditFiles'] == 'all'
						|| ($this->configuration['persistence']['userGroupAllowEditFiles'] == 'owner' && $ug > 0 && $owner == $fe_uid) )  					
						&& !empty($this->configuration['persistence']['userGroupAllowEditFiles']))
				return(true);
			else 
				return(false);
	}	

	/*********************************************************
	Can user Delete Files?
	*********************************************************/		
	public function canDeleteFiles($ug,$owner,$fe_uid)	{
			$this->getConfig();
			$ug =	$this->getUsergroupArray($ug);
			
			if( ( in_array ($this->configuration['persistence']['userGroupAdmin'] , $ug) 
						|| in_array ($this->configuration['persistence']['userGroupAllowDeleteFiles'] , $ug) 
						|| $this->configuration['persistence']['userGroupAllowDeleteFiles'] == 'all'
						|| ($this->configuration['persistence']['userGroupAllowDeleteFiles'] == 'owner' && $ug > 0 && $owner == $fe_uid) )  					
						&& !empty($this->configuration['persistence']['userGroupAllowDeleteFiles']))
				return(true);
			else 
				return(false);
	}	

	/*********************************************************
	Can user Upload Files?
	*********************************************************/		
	public function canUploadFiles($ug,$owner,$fe_uid)	{
			$this->getConfig();
			$ug =	$this->getUsergroupArray($ug);
			
			if( ( in_array ($this->configuration['persistence']['userGroupAdmin'] , $ug) 
						|| in_array ($this->configuration['persistence']['userGroupAllowUpload'] , $ug) 
						|| $this->configuration['persistence']['userGroupAllowUpload'] == 'all'
						|| ($this->configuration['persistence']['userGroupAllowUpload'] == 'owner' && $ug > 0 && $owner == $fe_uid) )  					
						&& !empty($this->configuration['persistence']['userGroupAllowUpload']))
				return(true);
			else 
				return(false);
	}	
	
	/*********************************************************
			Can user Upload Files?
	*********************************************************/		
	public function canDownloadFiles($ug)	{
			$this->getConfig();
			$ug =	$this->getUsergroupArray($ug);
			
			if( ( in_array ($this->configuration['persistence']['userGroupAdmin'] , $ug) 
						|| in_array ($this->configuration['persistence']['userGroupAllowDownload'] , $ug) 
						|| $this->configuration['persistence']['userGroupAllowDownload'] == 'all'	)  					
						&& !empty($this->configuration['persistence']['userGroupAllowDownload']))
				return(true);
			else 
				return(false);
	}	
	
	
	/*********************************************************
	Get Configuration
	*********************************************************/	
	public function getConfiguration()	{
		$this->getConfig();
								
		if($this->configuration['persistence']['loadjquery'])				
			$this->loadjquery;
				
		if($this->configuration['persistence']['loadjquery'])				
			$this->loadjquery = true;
				
		if($this->configuration['persistence']['loadFancybox'])				
			$this->loadFancybox = true;
				
		if($this->configuration['persistence']['loadjqueryForm'])				
			$this->loadjqueryForm = true;
				
		if($this->configuration['persistence']['createLocalRecords'])				
			$this->createLocalRecords = true;
								
		$this->not_translated_wrap[0] =  "[";
		$this->not_translated_wrap[1] =  "]";			
			
		if(strtolower($this->configuration['persistence']['orderFolderField']) == 'name')				
			$this->orderFolderField = 'name';
				
		if(strtolower($this->configuration['persistence']['orderFolderField']) == 'date')				
			$this->orderFolderField = 'crdate';
				
		$this->orderFolderOrder = strtolower($this->configuration['persistence']['orderFolderOrder']);
						
		if(strtolower($this->configuration['persistence']['orderFilesField']) == 'name')				
			$this->orderFilesField = 'beschriftung';
				
		if( strtolower($this->configuration['persistence']['orderFilesField']) == 'date')				
			$this->orderFilesField = 'crdate';
				
		$this->orderFilesOrder = strtolower($this->configuration['persistence']['orderFilesOrder']);
	}
}	
?>