<?php
namespace Tx\Bnbfilesharing\Permissions;

/*                                                                        *
 * This script belongs to the TYPO3 Extension "bnbfilesharing".           *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use Tx\Bnbfilesharing\Domain\Model\Folder;

class FolderPermissions extends AbstractPermissions
{
    /**
     * Can user create Folder?
     *
     * @param Folder $parentFolder
     * @return bool
     */
    public function canCreate(Folder $parentFolder)
    {
        return $this->checkFrontendUserPermissionsFolder('userGroupAllowCreateFolders', $parentFolder);
    }

    /**
     * Can user create RootFolder?
     *
     * @return bool
     */
    public function canCreateRoot()
    {
        return $this->checkFrontendUserPermissionsGeneric('userGroupAllowCreateRootFolders');
    }

    /**
     * Can user Delete Folder?
     *
     * @param Folder $folder
     * @return bool
     */
    public function canDelete(Folder $folder)
    {
        if ($folder->getFiles()->count() > 0) {
            return false;
        }
        if ($folder->getChildren()->count() > 0) {
            return false;
        }
        return $this->checkFrontendUserPermissionsFolder('userGroupAllowDeleteFolders', $folder);
    }

    /**
     * Can user edit Folder?
     *
     * @param Folder $folder
     * @return bool
     */
    public function canEdit(Folder $folder)
    {
        return $this->checkFrontendUserPermissionsFolder('userGroupAllowEditFolders', $folder);
    }

    /**
     * Checks if the current user has access to the action configured in the given $configName
     * from the permission settings.
     *
     * @param string $configName
     * @param Folder $folder
     * @return bool
     */
    private function checkFrontendUserPermissionsFolder($configName, Folder $folder)
    {
        if ($this->checkFrontendUserPermissionsGeneric($configName)) {
            return true;
        }
        return $this->isFolderOwnerAllowed($configName, $folder);
    }

    /**
     * @param string $configName
     * @param Folder $folder
     * @return bool
     */
    private function isFolderOwnerAllowed($configName, Folder $folder)
    {
        $settings = $this->getPermissionSettings();

        $configValue = $settings[$configName];
        if ($configValue !== 'owner') {
            return false;
        }

        $owner = $folder->getFeuser();
        if ($owner === null) {
            return false;
        }

        return $this->getCurrentFrontendUserUid() === $owner->getUid();
    }

}
