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
class Tx_Bnbfilesharing_Domain_Model_Files extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * file
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $file;

	/**
	 * beschriftung
	 *
	 * @var string
	 */
	protected $beschriftung;

	/**
	 * feuserid
	 *
	 * @var integer
	 */
	protected $feuserid;
	
	/**
	 * feuserug
	 *
	 * @var string
	 */
	protected $feuserug;
	

	/**
	 * folder
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Bnbfilesharing_Domain_Model_Folder>
	 */
	protected $folder;

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all Tx_Extbase_Persistence_ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		* Do not modify this method!
		* It will be rewritten on each save in the extension builder
		* You may modify the constructor of this class instead
		*/
		$this->folder = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * Returns the file
	 *
	 * @return string $file
	 */
	public function getFile() {
		return $this->file;
	}

	/**
	 * Sets the file
	 *
	 * @param string $file
	 * @return void
	 */
	public function setFile($file) {
		$this->file = $file;
		return $this;
	}

	/**
	 * Returns the beschriftung
	 *
	 * @return string $beschriftung
	 */
	public function getBeschriftung() {
		return $this->beschriftung;
	}

	/**
	 * Sets the beschriftung
	 *
	 * @param string $beschriftung
	 * @return void
	 */
	public function setBeschriftung($beschriftung) {
		$this->beschriftung = $beschriftung;
		return $this;
	}

	/**
	 * Returns the feuserid
	 *
	 * @return integer $feuserid
	 */
	public function getFeuserid() {
		return $this->feuserid;
	}

	/**
	 * Sets the feuserid
	 *
	 * @param integer $feuserid
	 * @return void
	 */
	public function setFeuserid($feuserid) {
		$this->feuserid = $feuserid;
		return $this;
	}
	
	
		/**
	 * Returns the feuserid
	 *
	 * @return integer $feuserid
	 */
	public function getFeuserug() {
		return $this->feuserug;
	}

	/**
	 * Sets the feuserid
	 *
	 * @param integer $feuserid
	 * @return void
	 */
	public function setFeuserug($feuserug) {
		$this->feuserug = $feuserug;
		return $this;
	}

	
	/**
	 * Adds a Folder
	 *
	 * @param Tx_Bnbfilesharing_Domain_Model_Folder $folder
	 * @return void
	 */
	public function addFolder(Tx_Bnbfilesharing_Domain_Model_Folder $folder) {
		$this->folder->attach($folder);
	}

	/**
	 * Removes a Folder
	 *
	 * @param Tx_Bnbfilesharing_Domain_Model_Folder $folderToRemove The Folder to be removed
	 * @return void
	 */
	public function removeFolder(Tx_Bnbfilesharing_Domain_Model_Folder $folderToRemove) {
		$this->folder->detach($folderToRemove);
	}

	/**
	 * Returns the folder
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Bnbfilesharing_Domain_Model_Folder> $folder
	 */
	public function getFolder() {
		return $this->folder;
	}

	/**
	 * Sets the folder
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Bnbfilesharing_Domain_Model_Folder> $folder
	 * @return void
	 */
	public function setFolder(Tx_Extbase_Persistence_ObjectStorage $folder) {
		$this->folder = $folder;
		return $this;
	}

}
?>