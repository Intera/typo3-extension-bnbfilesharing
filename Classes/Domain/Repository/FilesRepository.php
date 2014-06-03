
<?
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
class Tx_Bnbfilesharing_Domain_Repository_FilesRepository extends Tx_Extbase_Persistence_Repository {
	
	public function findSortedByFolder($uid,$OrderByfild,$Direction) {	
		$query = $this->createQuery();
		if($Direction == 'desc')
			$query->setOrderings(Array($OrderByfild => Tx_Extbase_Persistence_Query::ORDER_DESCENDING));
		else
			$query->setOrderings(Array($OrderByfild => Tx_Extbase_Persistence_Query::ORDER_ASCENDING));
		$constraint = $query->equals('folder',$uid);
		return $query->matching($constraint)->execute();
	}

	public function createLocalRecords($name,$file,$wrap,$pid,$folder){
		
		$objects=$this->getAddedObjects();	
								
		foreach($objects AS $object){
			$Uid = $object->getUid();
		}

		$res=$GLOBALS['TYPO3_DB']->exec_SELECTquery('uid','sys_language','hidden=0');
			
		while($row=mysql_fetch_assoc($res)) {					
			if($row["uid"] != $GLOBALS['TSFE']->sys_language_uid)
				$w = $wrap;					
			else
				$w[0] = $w[1] = "";						
									
			$GLOBALS['TYPO3_DB']->exec_INSERTquery( 'tx_bnbfilesharing_domain_model_files',
			array('Beschriftung' => $w[0].$name.$w[1],
			'feuserid' => $GLOBALS['TSFE']->fe_user->user['uid'],
			'feuserug' => $GLOBALS['TSFE']->fe_user->user['usergroup'],										
			'file' => $file,			
			'folder' => $folder,								
			'pid' => $pid,		
			'crdate' => time(),
			'tstamp' => time(),
			'l10n_parent' => $Uid,
			'sys_language_uid' => $row["uid"]
			));
		}//while				
	}
}
?>
