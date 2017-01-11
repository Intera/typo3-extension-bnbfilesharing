<?php
namespace Tx\Bnbfilesharing\Controller;

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

use Tx\Bnbfilesharing\Domain\Model\File;
use Tx\Bnbfilesharing\Domain\Model\Folder;
use Tx\Bnbfilesharing\Domain\Repository\FileRepository;
use Tx\Bnbfilesharing\Domain\Repository\FolderRepository;
use Tx\Bnbfilesharing\Permissions\FilePermissions;
use Tx\Intsvnbrowser\Exception\Exception;
use Tx\Uploadhandler\Extbase\FileArgumentMapper;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * @package filesharing
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class FileController extends ActionController
{
    /**
     * @var FileArgumentMapper
     */
    protected $fileArgumentMapper;

    /**
     * @var FilePermissions
     */
    protected $filePermissions;

    /**
     * @var FileRepository
     */
    protected $fileRepository;

    /**
     * @var FolderRepository
     */
    protected $folderRepository;

    /**
     * @var int
     */
    protected $storagePid;

    /**
     * Initializes the file permissions object.
     */
    public function initializeAction()
    {
        parent::initializeAction();
        $this->filePermissions = $this->objectManager->get(FilePermissions::class);
        $this->fileArgumentMapper = $this->objectManager->get(FileArgumentMapper::class);
    }

    /**
     * Checks if the user is allowed to upload a new file.
     */
    public function initializeUploadAction()
    {
        $permissionCallback = function () {
            return $this->filePermissions->canUpload();
        };
        $this->checkPermissionOrRedirectToList($permissionCallback, 'upload');
    }

    /**
     * Checks if the user is allowed to replace an existing file.
     */
    public function initializeUploadExistingAction()
    {
        $fileData = $this->request->getArgument('file');
        $file = $this->fileRepository->findByUid($fileData['__identity']);
        $permissionCallback = function () use ($file) {
            return $this->filePermissions->canReplace($file);
        };
        $this->checkPermissionOrRedirectToList($permissionCallback, 'replace');
    }

    /**
     * @param FileRepository $filesRepository
     */
    public function injectFilesRepository(FileRepository $filesRepository)
    {
        $this->fileRepository = $filesRepository;
    }

    /**
     * @param FolderRepository $folderRepository
     */
    public function injectFolderRepository(FolderRepository $folderRepository)
    {
        $this->folderRepository = $folderRepository;
    }

    /**
     * @param \Tx\Bnbfilesharing\Domain\Model\File $file
     */
    public function deleteAction(File $file)
    {
        $permissionCallback = function () use ($file) {
            return $this->filePermissions->canDelete($file);
        };
        $this->checkPermissionOrRedirectToList($permissionCallback, 'delete');

        $this->fileRepository->remove($file);
        $this->addFlashMessage('Die Datei wurde erfolgreich gelöscht.');
        $this->redirect('list', 'Folder');
    }

    /**
     * @param \Tx\Bnbfilesharing\Domain\Model\File $file
     */
    public function deleteFormAction(File $file)
    {
        $permissionCallback = function () use ($file) {
            return $this->filePermissions->canDelete($file);
        };
        $this->checkPermissionOrRedirectToList($permissionCallback, 'delete');

        $this->view->assign('file', $file);
    }

    public function downloadAction(File $file)
    {
        $permissionCallback = function () use ($file) {
            return $this->filePermissions->canDownload($file);
        };
        $this->checkPermissionOrRedirectToList($permissionCallback, 'download');

        try {
            $fileObject = $file->getFileObject();
            $fileObject->getStorage()->dumpFileContents($fileObject);
            die();
        } catch (Exception $e) {
            $this->addFlashMessage('Die Datei kann nicht heruntergeladen werden: ' . $e->getMessage());
            $this->redirect('list');
        }
    }

    /**
     * @param \Tx\Bnbfilesharing\Domain\Model\File $file
     */
    public function editAction(File $file)
    {
        $permissionCallback = function () use ($file) {
            return $this->filePermissions->canEdit($file);
        };
        $this->checkPermissionOrRedirectToList($permissionCallback, 'edit');

        $this->fileRepository->update($file);
        $this->addFlashMessage('Die Datei wurde erfolgreich aktualisiert.');
        $this->redirect('list', 'Folder');
    }

    /**
     * @param \Tx\Bnbfilesharing\Domain\Model\File $file
     * @ignorevalidation $file
     */
    public function editFormAction(File $file)
    {
        $permissionCallback = function () use ($file) {
            return $this->filePermissions->canEdit($file);
        };
        $this->checkPermissionOrRedirectToList($permissionCallback, 'edit');

        $this->view->assign('file', $file);
    }

    /**
     * @param \Tx\Bnbfilesharing\Domain\Model\File $file
     * @see initializeUploadAction()
     */
    public function uploadAction(File $file)
    {
        // Permission check is done in initializeUploadAction() to prevent file processing during argument mapping.
        $this->fileRepository->add($file);
        $this->addFlashMessage('Die Datei wurde erfolgreich hochgeladen.');
        $this->redirect('list', 'Folder');
    }

    /**
     * @param \Tx\Bnbfilesharing\Domain\Model\File $file
     * @see initializeUploadExistingAction()
     */
    public function uploadExistingAction(File $file)
    {
        // Permission check is done in initializeUploadExistingAction()
        // to prevent file processing during argument mapping.
        $this->fileRepository->update($file);
        $this->addFlashMessage('Die Datei wurde erfolgreich ausgetauscht.');
        $this->redirect('list', 'Folder');
    }

    /**
     * @param \Tx\Bnbfilesharing\Domain\Model\File $file
     * @ignorevalidation $file
     */
    public function uploadExistingFormAction(File $file)
    {
        $permissionCallback = function () use ($file) {
            return $this->filePermissions->canReplace($file);
        };
        $this->checkPermissionOrRedirectToList($permissionCallback, 'replace');

        $this->view->assign('file', $file);
    }

    /**
     * @param \Tx\Bnbfilesharing\Domain\Model\Folder $folder
     */
    public function uploadFormAction(Folder $folder)
    {
        $permissionCallback = function () {
            return $this->filePermissions->canUpload();
        };
        $this->checkPermissionOrRedirectToList($permissionCallback, 'upload');

        $this->view->assign('folder', $folder);
    }

    /**
     * Extends the callActionMethod method of Tx_Extbase_MVC_Controller_ActionController
     * On error, uploaded files will be removed.
     */
    protected function callActionMethod()
    {
        $this->fileArgumentMapper->cleanupObsoleteFiles($this->arguments->getValidationResults());
        parent::callActionMethod();
    }

    /**
     * Extends the mapRequestArgumentsToControllerArguments method of
     * Tx_Extbase_MVC_Controller_ActionController with mapping functionality
     * for uploaded files.
     */
    protected function mapRequestArgumentsToControllerArguments()
    {
        $this->fileArgumentMapper->mapFilesToRequestArguments($this->arguments, $this->buildControllerContext());
        parent::mapRequestArgumentsToControllerArguments();
        $this->fileArgumentMapper->mergeFileMappingResultsToArguments($this->arguments);
    }

    /**
     * @param callable $permissionCallback
     * @param string $permissionName
     */
    private function checkPermissionOrRedirectToList($permissionCallback, $permissionName)
    {
        if ($permissionCallback()) {
            return;
        }
        $this->addFlashMessage('Sie haben keine Berechtigung für ' . $permissionName);
        $this->redirect('list', 'Folder');
    }
}
