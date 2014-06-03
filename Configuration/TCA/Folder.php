<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_bnbfilesharing_domain_model_folder'] = array(
	'ctrl' => $TCA['tx_bnbfilesharing_domain_model_folder']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, children, files, feuserid',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, name, feuserid, children, files,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_bnbfilesharing_domain_model_folder',
				'foreign_table_where' => 'AND tx_bnbfilesharing_domain_model_folder.pid=###CURRENT_PID### AND tx_bnbfilesharing_domain_model_folder.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' =>array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bnbfilesharing/Resources/Private/Language/locallang_db.xml:tx_bnbfilesharing_domain_model_folder.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'children' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bnbfilesharing/Resources/Private/Language/locallang_db.xml:tx_bnbfilesharing_domain_model_folder.children',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_bnbfilesharing_domain_model_folder',
				'foreign_field' => 'folder',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapse' => 1,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'files' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bnbfilesharing/Resources/Private/Language/locallang_db.xml:tx_bnbfilesharing_domain_model_folder.files',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_bnbfilesharing_domain_model_files',
				'foreign_field' => 'folder',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapse' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'folder' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),		
		'feuserid' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bnbfilesharing/Resources/Private/Language/locallang_db.xml:tx_bnbfilesharing_domain_model_folder.feuserid',
			'config' => array(			
				'foreign_table' => 'fe_users',
				'minitems' => 0,				
				'maxitems' => 1,								
				'type' => 'select',
				'size' => 1,
				'eval' => 'int'
			),
		),
		'feuserug' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bnbfilesharing/Resources/Private/Language/locallang_db.xml:tx_bnbfilesharing_domain_model_folder.feuserug',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'trim'
			),
		),
		
		
		
		
		'files' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
	),
);
?>