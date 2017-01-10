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

use Tx\Bnbfilesharing\Permissions\FilePermissions;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractConditionViewHelper;

class FileViewHelper extends AbstractConditionViewHelper
{
    /**
     * @param string $permission
     * @param \Tx\Bnbfilesharing\Domain\Model\File $file
     * @return string
     */
    public function render($permission, $file = null)
    {
        $filePermissions = $this->objectManager->get(FilePermissions::class);
        $arguments = [];

        if ($file !== null) {
            $arguments[] = $file;
        }
        if (call_user_func_array([$filePermissions, 'can' . ucfirst($permission)], $arguments)) {
            $result = $this->renderThenChild();
        } else {
            $result = $this->renderElseChild();
        }

        return $result;
    }
}
