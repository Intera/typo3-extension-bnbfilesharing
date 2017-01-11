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
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;

/**
 * Test case for class tx_bnbfilesharing_domain_model_file.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class FileTest extends BaseTestCase
{
    /**
     * @var File
     */
    protected $fixture;

    public function setUp()
    {
        $this->fixture = new File();
    }

    public function tearDown()
    {
        unset($this->fixture);
    }

    /**
     * @test
     */
    public function addFolderToObjectStorageHoldingFolder()
    {
        $folder = new Folder();
        $this->fixture->setFolder($folder);

        $this->assertEquals(
            $folder,
            $this->fixture->getFolder()
        );
    }

    /**
     * @test
     */
    public function getBeschriftungReturnsInitialValueForString()
    {
    }

    /**
     * @test
     */
    public function getFeuseridReturnsInitialValueForInteger()
    {
        $this->assertSame(
            null,
            $this->fixture->getFeuser()
        );
    }

    /**
     * @test
     */
    public function getFileReturnsInitialValueForString()
    {
    }

    /**
     * @test
     */
    public function getFolderReturnsInitialValueForObjectStorageContainingTx_Bnbfilesharing_Domain_Model_Folder()
    {
        $this->assertEquals(
            null,
            $this->fixture->getFolder()
        );
    }

    /**
     * @test
     * @expectedException \PHPUnit_Framework_Error
     */
    public function removeFolderFromObjectStorageHoldingFolder()
    {
        $this->fixture->setFolder(null);
    }

    /**
     * @test
     */
    public function setBeschriftungForStringSetsBeschriftung()
    {
        $this->fixture->setLabel('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->fixture->getLabel()
        );
    }

    /**
     * @test
     */
    public function setFeuseridForIntegerSetsFeuserid()
    {
        $frontendUser = new FrontendUser();
        $frontendUser->setUsername('testuser');

        $this->fixture->setFeuser($frontendUser);

        $this->assertSame(
            $frontendUser,
            $this->fixture->getFeuser()
        );
    }

    /**
     * @test
     */
    public function setFileForStringSetsFile()
    {
        $this->fixture->setFile('Conceived at T3CON10');

        $this->assertSame(
            'Conceived at T3CON10',
            $this->fixture->getFile()
        );
    }
}
