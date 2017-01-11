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
    'Tx.' . $_EXTKEY,
    'Filesharing',
    'bnbFilesharing'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bnbfilesharing_domain_model_folder');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bnbfilesharing_domain_model_file');
