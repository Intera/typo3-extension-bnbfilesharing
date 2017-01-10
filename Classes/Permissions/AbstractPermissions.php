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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

abstract class AbstractPermissions
{
    /**
     * @var ConfigurationManagerInterface
     */
    private $configurationManager;

    /**
     * @var FrontendUserAuthentication
     */
    private $currentFrontendUser;

    /**
     * @var FrontendUserRepository
     */
    private $frontendUserRepository;

    /**
     * @var array
     */
    private $permissionSettings;

    /**
     * @var TypoScriptFrontendController
     */
    private $typoscriptFrontendController;

    /**
     * @param ConfigurationManagerInterface $configurationManager
     */
    public function injectConfigurationManager(ConfigurationManagerInterface $configurationManager)
    {
        $this->configurationManager = $configurationManager;
    }

    /**
     * @param FrontendUserRepository $frontendUserRepository
     */
    public function injectFrontendUserRepository(FrontendUserRepository $frontendUserRepository)
    {
        $this->frontendUserRepository = $frontendUserRepository;
    }

    /**
     * @return FrontendUser
     */
    public function getCurrentFrontendUserModel()
    {
        $frontendUser = $this->frontendUserRepository->findByUid($this->getCurrentFrontendUserUid());
        if ($frontendUser instanceof FrontendUser) {
            return $frontendUser;
        }
        throw new \RuntimeException('No frontend user found.');
    }

    /**
     * @param FrontendUserAuthentication $currentFrontendUser
     */
    public function setCurrentFrontendUser(FrontendUserAuthentication $currentFrontendUser)
    {
        $this->currentFrontendUser = $currentFrontendUser;
    }

    /**
     * @param array $permissionSettings
     */
    public function setPermissionSettings(array $permissionSettings)
    {
        $this->permissionSettings = $permissionSettings;
    }

    /**
     * @param TypoScriptFrontendController $typoscriptFrontendController
     */
    public function setTypoScriptFrontendController(TypoScriptFrontendController $typoscriptFrontendController)
    {
        $this->typoscriptFrontendController = $typoscriptFrontendController;
    }

    /**
     * Checks if the current user has access to the action configured in the given $configName
     * from the permission settings.
     *
     * @param string $configName
     * @return bool
     */
    protected function checkFrontendUserPermissionsGeneric($configName)
    {
        $settings = $this->getPermissionSettings();

        if ($settings[$configName] === 'all') {
            return true;
        }

        if ($this->currentUserIsInAdminGroup()) {
            return true;
        }

        return $this->currentUserIsInGroup($settings[$configName]);
    }

    /**
     * @return bool
     */
    protected function currentUserIsInAdminGroup()
    {
        $permissionSettings = $this->getPermissionSettings();
        return $this->currentUserIsInGroup($permissionSettings['userGroupAdmin']);
    }

    /**
     * @param string $groupIdList
     * @return bool
     */
    protected function currentUserIsInGroup($groupIdList)
    {
        $allowedGroupIds = GeneralUtility::intExplode(',', $groupIdList, true);
        if ($allowedGroupIds === []) {
            return false;
        }

        if (empty($this->getCurrentFrontendUser()->groupData['uid'])) {
            return false;
        }

        $currentFrontendGroups = $this->getCurrentFrontendUser()->groupData['uid'];
        foreach ($allowedGroupIds as $allowedGroupId) {
            if (array_key_exists($allowedGroupId, $currentFrontendGroups)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return FrontendUserAuthentication
     */
    protected function getCurrentFrontendUser()
    {
        if ($this->currentFrontendUser !== null) {
            return $this->currentFrontendUser;
        }
        return $this->getTypoScriptFrontendController()->fe_user;
    }

    /**
     * @return int
     */
    protected function getCurrentFrontendUserUid()
    {
        $frontendUser = $this->getCurrentFrontendUser();
        if ($frontendUser === null) {
            return 0;
        }
        if (empty($frontendUser->user['uid'])) {
            return 0;
        }
        return (int)$frontendUser->user['uid'];
    }

    /**
     * @return array
     */
    protected function getPermissionSettings()
    {
        if (is_array($this->permissionSettings)) {
            return $this->permissionSettings;
        }
        $settings = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS
        );
        return $settings['permissions'];
    }

    /**
     * @return TypoScriptFrontendController
     */
    protected function getTypoScriptFrontendController()
    {
        if ($this->typoscriptFrontendController !== null) {
            return $this->typoscriptFrontendController;
        }
        return $GLOBALS['TSFE'];
    }
}
