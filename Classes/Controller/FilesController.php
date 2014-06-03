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
class Tx_Bnbfilesharing_Controller_FilesController extends Tx_Extbase_MVC_Controller_ActionController {


	protected $filesRepository;
	protected	$configuration;		
	protected	$forbiddenFileType;
	protected	$allowedFileType;
	protected	$storagePid;
	protected	$createLocalRecords;	
	protected	$not_translated_wrap;		
	protected	$maxUploadFilesize = 1024;
	protected	$Path="uploads/tx_bnbfilesharing/";	
	

	
	public function injectFilesRepository(Tx_Bnbfilesharing_Domain_Repository_FilesRepository $filesRepository) {
		$this->filesRepository = $filesRepository;
	}

	/***********************************************
	Edit files
	************************************************/ 			
	public function ajaxEditAction() {
										
		if($this->request->hasArgument('uid'))
			$file = $this->filesRepository->findByUid($this->request->getArgument('uid'));		
		else
			die;	
						
		if(!$this->canEditFiles($GLOBALS['TSFE']->fe_user->user['usergroup'],$file->getFeuserid(),$GLOBALS['TSFE']->fe_user->user['uid']))
				die("Action forbidden");						
		
		if($this->request->hasArgument('bezeichnung'))
			$file->setBeschriftung($this->request->getArgument('bezeichnung'));
			
		//Uid of parent folder
		$storageFolder = $file->getFolder();
		$folderobj	=	$storageFolder->current();

  	return ('');			
	}	
	/***********************************************
	Delete file
	************************************************/ 				
	public function ajaxDeleteAction() {
		
		if($this->request->hasArgument('uid'))
			$file = $this->filesRepository->findByUid($this->request->getArgument('uid'));		
		else
			die("uid not submitted");
						
		if( !$this->canDeleteFiles($GLOBALS['TSFE']->fe_user->user['usergroup'],$file->getFeuserid(),$GLOBALS['TSFE']->fe_user->user['uid']))
	 		die("Action forbidden");						

		$this->filesRepository->remove($file);								
		//mark localization records as deleted			
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_bnbfilesharing_domain_model_files',
  		'l10n_parent='.$this->request->getArgument('uid'),
	  	array('deleted'=>'1')
		);  	

		return ("");		
	}
	
		/***********************************************
	Upload files
	************************************************/ 				
	public function ajaxUploadAction() {	
		
		$Path=PATH_site."/uploads/tx_bnbfilesharing/";	
					
		$this->getConfiguration();					
				
		//filetype is not allowed	
		if( $this->fileTypeOK($_FILES['userfile']['name']) == false)		
			return("0");
							
		//file is too big
		if( $this->fileSizeOK($_FILES['userfile']['tmp_name']) == false)				
			return("-1");			
			
			
		$_FILES['userfile']['name'] =	$this->getuniquefilename();	
		
		if($this->request->hasArgument('f2bezeichnung') && strlen($this->request->getArgument('f2bezeichnung')) > 0)
			$Bezeichnung = $this->request->getArgument('f2bezeichnung');
		else
			$Bezeichnung = $_FILES['userfile']['name'];
		
				
		if(move_uploaded_file ($_FILES['userfile']['tmp_name'], $Path.$_FILES['userfile']['name'])  != false)	{
			$folderRepository  = new Tx_Bnbfilesharing_Domain_Repository_FolderRepository();	
			
			//File nur updaten			
			if($this->request->hasArgument('f2fileid') && $this->request->getArgument('f2fileid') > 0){				
				$file = $this->filesRepository->findByUid($this->request->getArgument('f2fileid'));						
				
				if($file != null){
						$file->setFile($_FILES['userfile']['name']);									
						
						$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');				
						$persistenceManager->persistAll();														
					}
				}			
				else{
										
					if($this->request->hasArgument('f2folderid'))
						$folderobj = $folderRepository->findByUid($this->request->getArgument('f2folderid'));
					else 
						die("No folderid submitted");	
 				 				
					if(!$this->canUploadFiles($GLOBALS['TSFE']->fe_user->user['usergroup'],$folderobj->getFeuserid(),$GLOBALS['TSFE']->fe_user->user['uid']))
						die("Action forbidden");			

					$newFileObj = new Tx_Bnbfilesharing_Domain_Model_Files();
			
					//mark for non-translated 
					if($this->createLocalRecords && ($GLOBALS['TSFE']->sys_language_uid != 0 || $GLOBALS['TSFE']->sys_language_uid != "") )								
						$newFileObj->setBeschriftung($this->not_translated_wrap[0].$Bezeichnung.$this->not_translated_wrap[1]);			
					else
						$newFileObj->setBeschriftung($Bezeichnung);							
				
					$newFileObj->addFolder($folderobj);	
						
					$newFileObj->setFeuserid($GLOBALS['TSFE']->fe_user->user['uid']);				
			
					$newFileObj->setFeuserug($GLOBALS['TSFE']->fe_user->user['usergroup']);	
								
					$newFileObj->setFile($_FILES['userfile']['name']);	
		
					$this->filesRepository->add($newFileObj);		
			
					$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');				
					$persistenceManager->persistAll();			

					//crate localized records
					if($this->createLocalRecords)
					$this->filesRepository->createLocalRecords($Name=$Bezeichnung,$_FILES['userfile']['name'],$wrap=$this->not_translated_wrap,$pid=$this->storagePid,$folder=$this->request->getArgument('f2folderid'));
				}				
		}//move_uploaded_file		
	return("");
	}

	/***********************************************
	Download files
	************************************************/ 				
	public function ajaxDownloadAction(){
				
		$this->getConfiguration();			
		
		if(!$this->canDownloadFiles($GLOBALS['TSFE']->fe_user->user['usergroup']) )
			die("Action forbidden");			
				
		$file = $this->filesRepository->findByUid($_REQUEST["uid"]);			
		$filename = $file->getFile();		
			
		$beschriftung =	$file->getBeschriftung();
		
		if(substr($beschriftung,strlen($beschriftung)-1,strlen($beschriftung)) == "]")
			$beschriftung = str_replace("]","",$beschriftung);
		
		$pathinfo=pathinfo($filename);
		
		$extension=$pathinfo['extension'];
					
		$pathinfo=pathinfo($beschriftung);
		$extensionbeschriftung=$pathinfo['extension'];
	
		if($extensionbeschriftung == "")
			$beschriftung = $beschriftung.".".$extension;

		header("Content-disposition: attachment; filename=$beschriftung");

		$Path=$this->Path.$filename;
		$fp=fopen($Path,"r");		
		$fs = filesize($Path);
		header("Content-Length: ".$fs);	
	
		if($fs == 0)
			die;
	
		$read=0;
	
		while($read < $fs){
			$str .= fread($fp,1000);
			$read=$read+1000;
		}
		return ($str);
	}
	
	/***********************************************
	get unique filename
	************************************************/ 		
	protected function getuniquefilename(){		
		
		$_FILES['userfile']['name'] = utf8_decode($_FILES['userfile']['name']);				
		$_FILES['userfile']['name'] = stripslashes($_FILES['userfile']['name']);
		$_FILES['userfile']['name'] = mb_strtolower($_FILES['userfile']['name']);
		$_FILES['userfile']['name'] = str_replace("ä","ae",$_FILES['userfile']['name']);
		$_FILES['userfile']['name'] = str_replace("ö","oe",$_FILES['userfile']['name']);
		$_FILES['userfile']['name'] = str_replace("ü","ue",$_FILES['userfile']['name']);
		$_FILES['userfile']['name'] = str_replace("ß","ss",$_FILES['userfile']['name']);
		$_FILES['userfile']['name'] = str_replace(" ","_",$_FILES['userfile']['name']);
		$_FILES['userfile']['name'] = str_replace("'","_",$_FILES['userfile']['name']);
		$_FILES['userfile']['name'] = str_replace('"',"_",$_FILES['userfile']['name']);		
				
		$pathinfo=pathinfo($_FILES['userfile']['name']);
		$file_name =  basename($_FILES['userfile']['name'],".".$pathinfo['extension']);
	
		$files=scandir ($this->Path);
		
		$i = 1;
		do{
			$filenameExists = 0;
			foreach( $files as $file){
				if(strcmp($file,$_FILES['userfile']['name']) == 0){	
					$filenameExists=1;
				}
			}	
						
			if($filenameExists == 1){			
				$file_name = $file_name.$i++;
				$_FILES['userfile']['name'] = $file_name.".".$pathinfo['extension'];
			}
			else
				return($_FILES['userfile']['name']);	
		}
		while($filenameExists ==1 && $i < 100000);
}	 
	/***********************************************
	Checks if filetype is allowed
	************************************************/ 			
	protected function fileTypeOK($file){		

		$this->getConfiguration();
	
		$pathinfo=pathinfo($file);
			
		if(in_array (strtolower($pathinfo['extension']),$this->forbiddenFileType) )
			return false;								
							
		if(in_array ('all',$this->allowedFileType) )
			return true;		
		
		if(in_array (strtolower($pathinfo['extension']),$this->allowedFileType) )
			return true;		
		else 	
			return false;		
	}	
	
	/***********************************************
	Checks if filetype is allowed
	************************************************/ 			
	protected function fileSizeOK($file){		

		$this->getConfiguration();
		
		if(filesize($file) > $this->maxUploadFilesize*1024)
				return false;		
		else 		
				return true;				
	}	

	/*********************************************************
	Can user create RootFolder
	*********************************************************/		
	public function getConfig(){
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
	public function getUsergroupArray($ug)	{
			if( !empty($ug))
				$ug = explode(",",$ug);
			else	
				$ug[0] = -1;
				
		return ($ug);
	}
	
	/*********************************************************
	Can user Edit Files?
	*********************************************************/		
	public function canEditFiles($ug,$owner,$fe_uid)	{
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
	public function getConfiguration(){
		
		$this->getConfig();
			
		$this->storagePid = $this->configuration['persistence']['storagePid'];
		
		$this->configuration['persistence']['forbiddenUploadFileTypes'] = strtolower(str_replace(" ","",$this->configuration['persistence']['forbiddenUploadFileTypes']));			
		$this->forbiddenFileType = explode(",",$this->configuration['persistence']['forbiddenUploadFileTypes']);
		
		$this->configuration['persistence']['allowedUploadFileTypes'] = strtolower(str_replace(" ","",$this->configuration['persistence']['allowedUploadFileTypes']));
		$this->allowedFileType = explode(",",$this->configuration['persistence']['allowedUploadFileTypes']);	
			
		if($this->configuration['persistence']['createLocalRecords'])				
			$this->createLocalRecords = true;
				
		$this->not_translated_wrap[0] =  "[";
		$this->not_translated_wrap[1] =  "]";			
			
				
		if($this->configuration['persistence']['maxUploadFilesize']  > 0)				
			$this->maxUploadFilesize = $this->configuration['persistence']['maxUploadFilesize'];				
	}
}			
?>