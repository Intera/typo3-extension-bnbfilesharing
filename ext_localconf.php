<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Tx.' . $_EXTKEY,
    'Filesharing',
    [
        'Folder' => 'list,editForm,edit,createForm,createRootForm,create,deleteForm,delete',
        'File' => 'list,uploadForm,upload,uploadExistingForm,uploadExisting,editForm,edit,deleteForm,delete,download',
    ],
    // Non-cacheable actions
    [
        'Folder' => 'editForm,edit,createForm,createRootForm,create,deleteForm,delete',
        'File' => 'uploadForm,upload,uploadExistingForm,uploadExisting,editForm,edit,deleteForm,delete,download',
    ]
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '<INCLUDE_TYPOSCRIPT: source="FILE: EXT:bnbfilesharing/Configuration/PageTSconfig/NewContentElementWizard.pagets">

    // Woraround for TYPO3 6.2 which does not support EXT: syntax for icons.
    mod.wizards.newContentElement.wizardItems.special.elements.bnbfilesharing_filesharing.icon ='
    . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY)
    . '/Resources/Public/Icons/NewContentElementWizard.jpg'
);
