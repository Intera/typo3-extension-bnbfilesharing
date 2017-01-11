<?php
namespace Tx\Bnbfilesharing\Domain\Model;

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

use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * @package filesharing
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Folder extends AbstractEntity
{
    /**
     * children
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tx\Bnbfilesharing\Domain\Model\Folder>
     * @lazy
     */
    protected $children;

    /**
     * @var int
     */
    protected $endtime;

    /**
     * feuserid
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     * @lazy
     */
    protected $feuser;

    /**
     * files
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Tx\Bnbfilesharing\Domain\Model\File>
     * @lazy
     */
    protected $files;

    /**
     * @var \Tx\Bnbfilesharing\Domain\Model\Folder
     * @lazy
     */
    protected $folder;

    /**
     * @var string
     * @validate NotEmpty
     */
    protected $name;

    public function __construct()
    {
        // Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Adds a Folder
     *
     * @param Folder $child
     */
    public function addChild(Folder $child)
    {
        $this->children->attach($child);
    }

    /**
     * Adds a Files
     *
     * @param File $file
     */
    public function addFile(File $file)
    {
        $this->files->attach($file);
    }

    /**
     * Returns the children
     *
     * @return ObjectStorage
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Returns the feuserid
     *
     * @return FrontendUser
     */
    public function getFeuser()
    {
        return $this->feuser;
    }

    /**
     * Returns the files
     *
     * @return ObjectStorage
     */
    public function getFiles()
    {
        return $this->files;
    }

    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * Returns the name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Removes a Folder
     *
     * @param Folder $childToRemove The Folder to be removed
     */
    public function removeChild(Folder $childToRemove)
    {
        $this->children->detach($childToRemove);
    }

    /**
     * Removes a Files
     *
     * @param File $fileToRemove The Files to be removed
     */
    public function removeFile(File $fileToRemove)
    {
        $this->files->detach($fileToRemove);
    }

    /**
     * Sets the children
     *
     * @param ObjectStorage $children
     */
    public function setChildren(ObjectStorage $children)
    {
        $this->children = $children;
    }

    public function setEndtime($endtime)
    {
        $this->endtime = $endtime;
    }

    /**
     * Sets the feuserid
     *
     * @param FrontendUser $feuser
     */
    public function setFeuser(FrontendUser $feuser)
    {
        $this->feuser = $feuser;
    }

    /**
     * Sets the files
     *
     * @param ObjectStorage $files
     */
    public function setFiles(ObjectStorage $files)
    {
        $this->files = $files;
    }

    public function setFolder(Folder $folder)
    {
        $this->folder = $folder;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {

        $this->name = $name;
    }

    /**
     * Initializes all ObjectStorage properties.
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        /**
         * Do not modify this method!
         * It will be rewritten on each save in the extension builder
         * You may modify the constructor of this class instead
         */
        $this->children = new ObjectStorage();
        $this->files = new ObjectStorage();
    }
}
