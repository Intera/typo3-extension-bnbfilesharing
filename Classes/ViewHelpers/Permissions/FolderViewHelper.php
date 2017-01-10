<?php
namespace Tx\Bnbfilesharing\ViewHelpers\Permissions;

/*                                                                        *
 * This script belongs to the TYPO3 Extension "bnbfilesharing".           *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use Tx\Bnbfilesharing\Permissions\FolderPermissions;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractConditionViewHelper;

class FolderViewHelper extends AbstractConditionViewHelper
{
    /**
     * @param string $permission
     * @param \Tx\Bnbfilesharing\Domain\Model\Folder $folder
     * @return string
     */
    public function render($permission, $folder = null)
    {
        $folderPermissions = $this->objectManager->get(FolderPermissions::class);
        $arguments = [];

        if ($folder !== null) {
            $arguments[] = $folder;
        }
        if (call_user_func_array([$folderPermissions, 'can' . ucfirst($permission)], $arguments)) {
            $result = $this->renderThenChild();
        } else {
            $result = $this->renderElseChild();
        }

        return $result;
    }
}
