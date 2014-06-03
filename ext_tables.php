<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_extMgm::addStaticFile ($_EXTKEY, 'Configuration/TypoScript', 'bnbFilesharing' );

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Filesharing',
	'bnbFilesharing'
);

//$pluginSignature = str_replace('_','',$_EXTKEY) . '_' . filesharing;
//$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
//t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_' .filesharing. '.xml');



if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_bnbfilesharing_bnbFilesharing_wizicon'] = t3lib_extMgm::extPath($_EXTKEY) . 'Resources/Private/BackEnd/bnbfilesharing.php';
}



t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'bnbFilesharing');


t3lib_extMgm::addLLrefForTCAdescr('tx_bnbfilesharing_domain_model_folder', 'EXT:bnbfilesharing/Resources/Private/Language/locallang_csh_tx_bnbfilesharing_domain_model_folder.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_bnbfilesharing_domain_model_folder');
$TCA['tx_bnbfilesharing_domain_model_folder'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:bnbfilesharing/Resources/Private/Language/locallang_db.xml:tx_bnbfilesharing_domain_model_folder',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Folder.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_bnbfilesharing_domain_model_folder.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_bnbfilesharing_domain_model_files', 'EXT:bnbfilesharing/Resources/Private/Language/locallang_csh_tx_bnbfilesharing_domain_model_files.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_bnbfilesharing_domain_model_files');
$TCA['tx_bnbfilesharing_domain_model_files'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:bnbfilesharing/Resources/Private/Language/locallang_db.xml:tx_bnbfilesharing_domain_model_files',
		'label' => 'file',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Files.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_bnbfilesharing_domain_model_files.gif'
	),
);

?>