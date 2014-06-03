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
*  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class Tx_Bnbfilesharing_Domain_Model_Folder.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage bnb filesharing
 *
 */
class Tx_Bnbfilesharing_Domain_Model_FolderTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Bnbfilesharing_Domain_Model_Folder
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Bnbfilesharing_Domain_Model_Folder();
	}

	public function tearDown() {
		unset($this->fixture);
	}
	
	
	/**
	 * @test
	 */
	public function getNameReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setNameForStringSetsName() { 
		$this->fixture->setName('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getName()
		);
	}
	
	/**
	 * @test
	 */
	public function getChildrenReturnsInitialValueForObjectStorageContainingTx_Bnbfilesharing_Domain_Model_Folder() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getChildren()
		);
	}

	/**
	 * @test
	 */
	public function setChildrenForObjectStorageContainingTx_Bnbfilesharing_Domain_Model_FolderSetsChildren() { 
		$child = new Tx_Bnbfilesharing_Domain_Model_Folder();
		$objectStorageHoldingExactlyOneChildren = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneChildren->attach($child);
		$this->fixture->setChildren($objectStorageHoldingExactlyOneChildren);

		$this->assertSame(
			$objectStorageHoldingExactlyOneChildren,
			$this->fixture->getChildren()
		);
	}
	
	/**
	 * @test
	 */
	public function addChildToObjectStorageHoldingChildren() {
		$child = new Tx_Bnbfilesharing_Domain_Model_Folder();
		$objectStorageHoldingExactlyOneChild = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneChild->attach($child);
		$this->fixture->addChild($child);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneChild,
			$this->fixture->getChildren()
		);
	}

	/**
	 * @test
	 */
	public function removeChildFromObjectStorageHoldingChildren() {
		$child = new Tx_Bnbfilesharing_Domain_Model_Folder();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($child);
		$localObjectStorage->detach($child);
		$this->fixture->addChild($child);
		$this->fixture->removeChild($child);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getChildren()
		);
	}
	
	/**
	 * @test
	 */
	public function getFilesReturnsInitialValueForObjectStorageContainingTx_Bnbfilesharing_Domain_Model_Files() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getFiles()
		);
	}

	/**
	 * @test
	 */
	public function setFilesForObjectStorageContainingTx_Bnbfilesharing_Domain_Model_FilesSetsFiles() { 
		$file = new Tx_Bnbfilesharing_Domain_Model_Files();
		$objectStorageHoldingExactlyOneFiles = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneFiles->attach($file);
		$this->fixture->setFiles($objectStorageHoldingExactlyOneFiles);

		$this->assertSame(
			$objectStorageHoldingExactlyOneFiles,
			$this->fixture->getFiles()
		);
	}
	
	/**
	 * @test
	 */
	public function addFileToObjectStorageHoldingFiles() {
		$file = new Tx_Bnbfilesharing_Domain_Model_Files();
		$objectStorageHoldingExactlyOneFile = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneFile->attach($file);
		$this->fixture->addFile($file);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneFile,
			$this->fixture->getFiles()
		);
	}

	/**
	 * @test
	 */
	public function removeFileFromObjectStorageHoldingFiles() {
		$file = new Tx_Bnbfilesharing_Domain_Model_Files();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($file);
		$localObjectStorage->detach($file);
		$this->fixture->addFile($file);
		$this->fixture->removeFile($file);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getFiles()
		);
	}
	
}
?>