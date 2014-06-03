
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
class Tx_Bnbfilesharing_Domain_Model_Folder extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * children
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Bnbfilesharing_Domain_Model_Folder>
	 */
	protected $children;

	/**
	 * files
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Bnbfilesharing_Domain_Model_Files>
	 */
	protected $files;

	/**
	 * __construct
	 *
	 * @return void
	 */
	 
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
	 * pid
	 *
	 * @var string
	 */	 
	protected $pid;
	
	 
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
		$this->children = new Tx_Extbase_Persistence_ObjectStorage();
		
		$this->files = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * Returns the name
	 *
	 * @return string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		
		$this->name = $name;
		return $this;
	}



	public function setEndtime($uid) {
		
		$this->endtime = 33;
		return $this;		
	}
	
	
	
	public function setFolder($folder) {
		$this->folder = $folder;
		return $this;
	}
	
	
	
	public function getFolder() {
		return $this->folder;
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
	 * @return integer $feuserug
	 */
	public function getFeuserug() {
		return $this->feuserug;
	}

	/**
	 * Sets the feuserid
	 *
	 * @param integer $feuserug
	 * @return void
	 */
	public function setFeuserug($feuserug) {
		$this->feuserug = $feuserug;
		return $this;
	}




	/**
	 * Adds a Folder
	 *
	 * @param Tx_Bnbfilesharing_Domain_Model_Folder $child
	 * @return void
	 */
	public function addChild(Tx_Bnbfilesharing_Domain_Model_Folder $child) {
		$this->children->attach($child);
	}

	/**
	 * Removes a Folder
	 *
	 * @param Tx_Bnbfilesharing_Domain_Model_Folder $childToRemove The Folder to be removed
	 * @return void
	 */
	public function removeChild(Tx_Bnbfilesharing_Domain_Model_Folder $childToRemove) {
		$this->children->detach($childToRemove);
	}

	/**
	 * Returns the children
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Bnbfilesharing_Domain_Model_Folder> $children
	 */
	public function getChildren() {
		return $this->children;
	}

	/**
	 * Sets the children
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Bnbfilesharing_Domain_Model_Folder> $children
	 * @return void
	 */
	public function setChildren(Tx_Extbase_Persistence_ObjectStorage $children) {
		$this->children = $children;
		return $this;
	}

	/**
	 * Adds a Files
	 *
	 * @param Tx_Bnbfilesharing_Domain_Model_Files $file
	 * @return void
	 */
	public function addFile(Tx_Bnbfilesharing_Domain_Model_Files $file) {
		$this->files->attach($file);
	}

	/**
	 * Removes a Files
	 *
	 * @param Tx_Bnbfilesharing_Domain_Model_Files $fileToRemove The Files to be removed
	 * @return void
	 */
	public function removeFile(Tx_Bnbfilesharing_Domain_Model_Files $fileToRemove) {
		$this->files->detach($fileToRemove);
	}

	/**
	 * Returns the files
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Bnbfilesharing_Domain_Model_Files> $files
	 */
	public function getFiles() {
		return $this->files;
	}

	/**
	 * Sets the files
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_Bnbfilesharing_Domain_Model_Files> $files
	 * @return void
	 */
	public function setFiles(Tx_Extbase_Persistence_ObjectStorage $files) {
		$this->files = $files;
		return $this;
	}

}
?>