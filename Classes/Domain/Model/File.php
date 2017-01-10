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

use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * @package filesharing
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class File extends AbstractEntity
{
    /**
     * @var string
     * @transient
     */
    protected $combinedUploadFolderIdentifier = '0:uploads/tx_bnbfilesharing/';

    /**
     * The user who created this file.
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     * @lazy
     */
    protected $feuser;

    /**
     * file
     *
     * @var string
     * @mapFiles
     * @validate Tx\Uploadhandler\Validation\Validator\FilePropertyValidator(table=tx_bnbfilesharing_domain_model_file,column=file)
     */
    protected $file;

    /**
     * folder
     *
     * @var \Tx\Bnbfilesharing\Domain\Model\Folder
     * @lazy
     * @validate NotEmpty
     */
    protected $folder;

    /**
     * beschriftung
     *
     * @var string
     */
    protected $label;

    /**
     * @var int
     */
    protected $tstamp;

    /**
     * Returns the clean media filenames as comma seperated list
     *
     * @return string
     */
    public function getCleanFile()
    {
        return $this->_getCleanProperty('file');
    }

    /**
     * Returns an array with the clean image filenames
     *
     * @return array
     */
    public function getCleanFileAsArray()
    {
        return GeneralUtility::trimExplode(',', $this->getCleanFile(), 1);
    }

    /**
     * @return bool
     */
    public function getExists()
    {
        return $this->getFileObject()->exists();
    }

    /**
     * @return FrontendUser
     */
    public function getFeuser()
    {
        return $this->feuser;
    }

    /**
     * Returns the file
     *
     * @return string $file
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Getter for files
     *
     * @return array
     */
    public function getFileAsArray()
    {
        return GeneralUtility::trimExplode(',', $this->getFile(), true);
    }

    /**
     * @return \TYPO3\CMS\Core\Resource\File
     */
    public function getFileObject()
    {
        $fileIdentifier = $this->combinedUploadFolderIdentifier . $this->getFile();
        return ResourceFactory::getInstance()->getFileObjectFromCombinedIdentifier($fileIdentifier);
    }

    /**
     * @return \TYPO3\CMS\Core\Resource\File|null
     */
    public function getFileObjectIfExists()
    {
        try {
            $file = $this->getFileObject();
            return $file;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Returns the folder
     *
     * @return Folder $folder
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * Returns the file label.
     *
     * @return string $beschriftung
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->getFileObject()->getSize();
    }

    /**
     * @return string
     */
    public function getSizeReadable()
    {
        return trim(GeneralUtility::formatSize($this->getSize(), ' Byte| KB| MB| GB'));
    }

    /**
     * @return int
     */
    public function getTstamp()
    {
        return $this->tstamp;
    }

    /**
     * @param FrontendUser $feuser
     */
    public function setFeuser(FrontendUser $feuser)
    {
        $this->feuser = $feuser;
    }

    /**
     * Sets the file
     *
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Sets the folder
     *
     * @param Folder $folder
     */
    public function setFolder(Folder $folder)
    {
        $this->folder = $folder;
    }

    /**
     * Sets the file label.
     *
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }
}
