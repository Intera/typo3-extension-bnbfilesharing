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

use Tx\Bnbfilesharing\Domain\Model\File;

class FilePermissions extends AbstractPermissions
{
    /**
     * Can user Delete Files?
     *
     * @param File $file
     * @return bool
     */
    public function canDelete(File $file)
    {
        return $this->checkFrontendUserPermissionsFile('userGroupAllowDeleteFiles', $file);
    }

    /**
     * Can user Upload Files?
     *
     * @param File $file
     * @return bool
     */
    public function canDownload(File $file)
    {
        return $this->checkFrontendUserPermissionsFile('userGroupAllowDownload', $file);
    }

    /**
     * Can user Edit Files?
     *
     * @param File $file
     * @return bool
     */
    public function canEdit(File $file)
    {
        return $this->checkFrontendUserPermissionsFile('userGroupAllowEditFiles', $file);
    }

    /**
     * Can replace an existing file?
     *
     * @param File $file
     * @return bool
     */
    public function canReplace(File $file)
    {
        return $this->canEdit($file);
    }

    /**
     * Can user Upload Files?
     *
     * @return bool
     */
    public function canUpload()
    {
        return $this->checkFrontendUserPermissionsGeneric('userGroupAllowUpload');
    }

    /**
     * Checks if the current user has access to the action configured in the given $configName
     * from the permission settings.
     *
     * @param string $configName
     * @param File $file
     * @return bool
     */
    private function checkFrontendUserPermissionsFile($configName, File $file)
    {
        if ($this->checkFrontendUserPermissionsGeneric($configName)) {
            return true;
        }
        return $this->isFileOwnerAllowed($configName, $file);
    }

    /**
     * @param string $configName
     * @param File $file
     * @return bool
     */
    private function isFileOwnerAllowed($configName, File $file)
    {
        $settings = $this->getPermissionSettings();

        $configValue = $settings[$configName];
        if ($configValue !== 'owner') {
            return false;
        }

        $owner = $file->getFeuser();
        if ($owner === null) {
            return false;
        }

        return $this->getCurrentFrontendUserUid() === $owner->getUid();
    }
}
