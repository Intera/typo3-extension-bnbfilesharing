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
 * Test case for class Tx_Bnbfilesharing_Domain_Model_Files.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage bnb filesharing
 *
 */
class Tx_Bnbfilesharing_Domain_Model_FilesTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Bnbfilesharing_Domain_Model_Files
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Bnbfilesharing_Domain_Model_Files();
	}

	public function tearDown() {
		unset($this->fixture);
	}
	
	
	/**
	 * @test
	 */
	public function getFileReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setFileForStringSetsFile() { 
		$this->fixture->setFile('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getFile()
		);
	}
	
	/**
	 * @test
	 */
	public function getBeschriftungReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setBeschriftungForStringSetsBeschriftung() { 
		$this->fixture->setBeschriftung('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getBeschriftung()
		);
	}
	
	/**
	 * @test
	 */
	public function getFeuseridReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getFeuserid()
		);
	}

	/**
	 * @test
	 */
	public function setFeuseridForIntegerSetsFeuserid() { 
		$this->fixture->setFeuserid(12);

		$this->assertSame(
			12,
			$this->fixture->getFeuserid()
		);
	}
	
	/**
	 * @test
	 */
	public function getFolderReturnsInitialValueForObjectStorageContainingTx_Bnbfilesharing_Domain_Model_Folder() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getFolder()
		);
	}

	/**
	 * @test
	 */
	public function setFolderForObjectStorageContainingTx_Bnbfilesharing_Domain_Model_FolderSetsFolder() { 
		$folder = new Tx_Bnbfilesharing_Domain_Model_Folder();
		$objectStorageHoldingExactlyOneFolder = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneFolder->attach($folder);
		$this->fixture->setFolder($objectStorageHoldingExactlyOneFolder);

		$this->assertSame(
			$objectStorageHoldingExactlyOneFolder,
			$this->fixture->getFolder()
		);
	}
	
	/**
	 * @test
	 */
	public function addFolderToObjectStorageHoldingFolder() {
		$folder = new Tx_Bnbfilesharing_Domain_Model_Folder();
		$objectStorageHoldingExactlyOneFolder = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneFolder->attach($folder);
		$this->fixture->addFolder($folder);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneFolder,
			$this->fixture->getFolder()
		);
	}

	/**
	 * @test
	 */
	public function removeFolderFromObjectStorageHoldingFolder() {
		$folder = new Tx_Bnbfilesharing_Domain_Model_Folder();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($folder);
		$localObjectStorage->detach($folder);
		$this->fixture->addFolder($folder);
		$this->fixture->removeFolder($folder);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getFolder()
		);
	}
	
}
?>