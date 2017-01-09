<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'Configuration/TypoScript',
    'bnbFilesharing'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY,
    'Filesharing',
    'bnbFilesharing'
);

//$pluginSignature = str_replace('_','',$_EXTKEY) . '_' . filesharing;
//$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
//t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_' .filesharing. '.xml');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
    'tx_bnbfilesharing_domain_model_folder',
    'EXT:bnbfilesharing/Resources/Private/Language/locallang_csh_tx_bnbfilesharing_domain_model_folder.xml'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bnbfilesharing_domain_model_folder');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
    'tx_bnbfilesharing_domain_model_files',
    'EXT:bnbfilesharing/Resources/Private/Language/locallang_csh_tx_bnbfilesharing_domain_model_files.xml'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bnbfilesharing_domain_model_files');
