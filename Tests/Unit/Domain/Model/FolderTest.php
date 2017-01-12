<?php
namespace Tx\Bnbfilesharing\Tests\Unit\Domain\Model;

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

use Tx\Bnbfilesharing\Domain\Model\File;
use Tx\Bnbfilesharing\Domain\Model\Folder;
use TYPO3\CMS\Core\Tests\BaseTestCase;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Test case for class Tx_Bnbfilesharing_Domain_Model_Folder.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class FolderTest extends BaseTestCase
{
    /**
     * @var Folder
     */
    protected $fixture;

    public function setUp()
    {
        $this->fixture = new Folder();
    }

    public function tearDown()
    {
        unset($this->fixture);
    }

    /**
     * @test
     */
    public function addChildToObjectStorageHoldingChildren()
    {
        $child = new Folder();
        $this->fixture->addChild($child);

        $objectStorageHoldingExactlyOneChild = new ObjectStorage();
        $objectStorageHoldingExactlyOneChild->attach($child);

        $this->assertEquals(
            $objectStorageHoldingExactlyOneChild,
            $this->fixture->getChildren()
        );
    }

    /**
     * @test
     */
    public function addFileToObjectStorageHoldingFiles()
    {
        $file = new File();
        $this->fixture->addFile($file);

        $objectStorageHoldingExactlyOneFile = new ObjectStorage();
        $objectStorageHoldingExactlyOneFile->attach($file);

        $this->assertEquals(
            $objectStorageHoldingExactlyOneFile,
            $this->fixture->getFiles()
        );
    }

    /**
     * @test
     */
    public function getChildrenReturnsEmptyObjectStorageForInitialObject()
    {
        $newObjectStorage = new ObjectStorage();
        $this->assertEquals(
            $newObjectStorage,
            $this->fixture->getChildren()
        );
    }

    /**
     * @test
     */
    public function getChildrenReturnsPreviouslySetObjectStorage()
    {
        $child = new Folder();
        $objectStorageHoldingExactlyOneChildren = new ObjectStorage();
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
    public function getFilesResturnPreviouslySetObjectStorage()
    {
        $file = new File();
        $objectStorageHoldingExactlyOneFiles = new ObjectStorage();
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
    public function getFilesReturnsEmptyObjectStorageForInitialObject()
    {
        $newObjectStorage = new ObjectStorage();
        $this->assertEquals(
            $newObjectStorage,
            $this->fixture->getFiles()
        );
    }

    /**
     * @test
     */
    public function removeChildFromObjectStorageHoldingChildren()
    {
        $child = new Folder();
        $this->fixture->addChild($child);
        $this->fixture->removeChild($child);

        $localObjectStorage = new ObjectStorage();
        $localObjectStorage->attach($child);
        $localObjectStorage->detach($child);

        $this->assertEquals(
            $localObjectStorage,
            $this->fixture->getChildren()
        );
    }

    /**
     * @test
     */
    public function removeFileFromObjectStorageHoldingFiles()
    {
        $file = new File();
        $this->fixture->addFile($file);
        $this->fixture->removeFile($file);

        $localObjectStorage = new ObjectStorage();
        $localObjectStorage->attach($file);
        $localObjectStorage->detach($file);

        $this->assertEquals(
            $localObjectStorage,
            $this->fixture->getFiles()
        );
    }

    /**
     * @test
     */
    public function setNameForStringSetsName()
    {
        $this->fixture->setName('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->fixture->getName()
        );
    }
}
