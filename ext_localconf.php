<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Filesharing',
	array(
		'Folder' => 'list, ajaxAddFolder,ajaxEditFolder, ajaxRepaintFolder, ajaxRepaintFiles, ajaxDeleteFolder, ajaxCanDeleteFolder',
		'Files' => 'list,ajaxEdit, ajaxDelete, ajaxUpload, ajaxRepaint, ajaxDownload',		
	),
	// non-cacheable actions
	array(
		'Folder' => 'create, update, delete',
		'Files' => 'create, update, delete',
		
	)
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '<INCLUDE_TYPOSCRIPT: source="FILE: EXT:bnbfilesharing/Configuration/PageTSconfig/NewContentElementWizard.pagets">

    // Woraround for TYPO3 6.2 which does not support EXT: syntax for icons.
    mod.wizards.newContentElement.wizardItems.special.elements.bnbfilesharing_filesharing.icon ='
    . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY)
    . '/Resources/Public/Icons/NewContentElementWizard.jpg'
);
