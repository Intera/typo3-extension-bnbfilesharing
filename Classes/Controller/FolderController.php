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

use Tx\Bnbfilesharing\Domain\Model\Folder;
use Tx\Bnbfilesharing\Domain\Repository\FileRepository;
use Tx\Bnbfilesharing\Domain\Repository\FolderRepository;
use Tx\Bnbfilesharing\Permissions\FolderPermissions;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * @package filesharing
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class FolderController extends ActionController
{
    /**
     * @var FileRepository
     */
    public $filesRepository;

    /**
     * @var FolderRepository
     */
    public $folderRepository;

    /**
     * @var array
     */
    protected $configuration;

    /**
     * @var FolderPermissions
     */
    protected $folderPermissions;

    public function initializeAction()
    {
        parent::initializeAction();
        $this->folderPermissions = $this->objectManager->get(FolderPermissions::class);
    }

    /**
     * injectFolderRepository
     *
     * @param FileRepository $filesRepository
     */
    public function injectFilesRepository(FileRepository $filesRepository)
    {
        $this->filesRepository = $filesRepository;
    }

    /**
     * injectFolderRepository
     *
     * @param FolderRepository $folderRepository
     */
    public function injectFolderRepository(FolderRepository $folderRepository)
    {
        $this->folderRepository = $folderRepository;
    }

    /**
     * @param \Tx\Bnbfilesharing\Domain\Model\Folder $folder
     */
    public function createAction(Folder $folder)
    {
        if ($folder->getFolder() === null) {
            $permissionCallback = function () {
                return $this->folderPermissions->canCreateRoot();
            };
            $this->checkPermissionOrRedirectToList($permissionCallback, 'createRoot');
        } else {
            $parentFolder = $folder->getFolder();
            $permissionCallback = function () use ($parentFolder) {
                return $this->folderPermissions->canCreate($parentFolder);
            };
            $this->checkPermissionOrRedirectToList($permissionCallback, 'create');
        }

        $folder->setFeuser($this->folderPermissions->getCurrentFrontendUserModel());
        $this->folderRepository->add($folder);
        $this->addFlashMessage('Das Verzeichnis wurde erfolgreich angelegt.');
        $this->redirect('list');
    }

    /**
     * @param \Tx\Bnbfilesharing\Domain\Model\Folder $parentFolder
     */
    public function createFormAction(Folder $parentFolder)
    {
        $permissionCallback = function () use ($parentFolder) {
            return $this->folderPermissions->canCreate($parentFolder);
        };
        $this->checkPermissionOrRedirectToList($permissionCallback, 'create');

        $this->view->assign('parentFolder', $parentFolder);
    }

    public function createRootFormAction()
    {
        $permissionCallback = function () {
            return $this->folderPermissions->canCreateRoot();
        };
        $this->checkPermissionOrRedirectToList($permissionCallback, 'createRoot');
    }

    /**
     * @param \Tx\Bnbfilesharing\Domain\Model\Folder $folder
     */
    public function deleteAction(Folder $folder)
    {
        $permissionCallback = function () use ($folder) {
            return $this->folderPermissions->canDelete($folder);
        };
        $this->checkPermissionOrRedirectToList($permissionCallback, 'delete');

        $this->folderRepository->remove($folder);
        $this->addFlashMessage('Das Verzeichnis wurde erfolgreich gelöscht.');
        $this->redirect('list');
    }

    /**
     * @param \Tx\Bnbfilesharing\Domain\Model\Folder $folder
     * @ignorevalidation $folder
     */
    public function deleteFormAction(Folder $folder)
    {
        if ($folder->getFiles()->count() > 0) {
            $this->addFlashMessage(
                'Es können keine Verzeichniss gelöscht werden, die noch Dateien enthalten.',
                '',
                FlashMessage::WARNING
            );
            $this->redirect('list');
        }

        if ($folder->getChildren()->count() > 0) {
            $this->addFlashMessage(
                'Es können keine Verzeichniss gelöscht werden, die Unterverzeichnisse enthalten.',
                '',
                FlashMessage::WARNING
            );
            $this->redirect('list');
        }

        $permissionCallback = function () use ($folder) {
            return $this->folderPermissions->canDelete($folder);
        };
        $this->checkPermissionOrRedirectToList($permissionCallback, 'delete');

        $this->view->assign('folder', $folder);
    }

    /**
     * @param \Tx\Bnbfilesharing\Domain\Model\Folder $folder
     */
    public function editAction(Folder $folder)
    {
        $permissionCallback = function () use ($folder) {
            return $this->folderPermissions->canEdit($folder);
        };
        $this->checkPermissionOrRedirectToList($permissionCallback, 'edit');

        $this->folderRepository->update($folder);
        $this->addFlashMessage('Das Verzeichnis wurde erfolgreich aktualisiert.');
        $this->redirect('list');
    }

    /**
     * @param \Tx\Bnbfilesharing\Domain\Model\Folder $folder
     * @ignorevalidation $folder
     */
    public function editFormAction(Folder $folder)
    {
        $permissionCallback = function () use ($folder) {
            return $this->folderPermissions->canEdit($folder);
        };
        $this->checkPermissionOrRedirectToList($permissionCallback, 'edit');

        $this->view->assign('folder', $folder);
    }

    /**
     * Initialized the configuration.
     */
    public function getConfig()
    {
        if (!isset($this->configuration)) {
            $this->configuration = $this->configurationManager->getConfiguration(
                ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
            );
            if (empty($this->configuration['persistence']['storagePid'])
                || !isset($this->configuration['persistence']['storagePid'])
            ) {
                $this->addFlashMessage(
                    'No storagePid! You have to include the static template of this extension and set the constant '
                    . 'plugin.tx_' . lcfirst($this->extensionName) . '.persistence.storagePid in the constant editor'
                );
            }
        }
    }

    /**
     * action list
     */
    public function listAction()
    {
        $rootFolders = $this->folderRepository->findSortedByFolder(
            0,
            'name',
            'asd'
        );

        $this->view->assign('rootFolders', $rootFolders);
        $this->view->assign('contentUid', $this->configurationManager->getContentObject()->data['uid']);
        $this->view->assign('maxfilesize', $this->configuration['persistence']['maxUploadFilesize']);
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
