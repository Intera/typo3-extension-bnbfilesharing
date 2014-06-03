<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_bnbfilesharing_domain_model_files'] = array(
	'ctrl' => $TCA['tx_bnbfilesharing_domain_model_files']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, file, beschriftung, feuserid, folder',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, file, beschriftung, feuserid, folder,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
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
				'foreign_table' => 'tx_bnbfilesharing_domain_model_files',
				'foreign_table_where' => 'AND tx_bnbfilesharing_domain_model_files.pid=###CURRENT_PID### AND tx_bnbfilesharing_domain_model_files.sys_language_uid IN (-1,0)',
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
		'file' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bnbfilesharing/Resources/Private/Language/locallang_db.xml:tx_bnbfilesharing_domain_model_files.file',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file',
				'uploadfolder' => 'uploads/tx_bnbfilesharing',
				'allowed' => '*',
				'disallowed' => '',
				'size' => 5,
				'eval' => 'required'					
			),
		),
		'beschriftung' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bnbfilesharing/Resources/Private/Language/locallang_db.xml:tx_bnbfilesharing_domain_model_files.beschriftung',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
	'feuserid' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bnbfilesharing/Resources/Private/Language/locallang_db.xml:tx_bnbfilesharing_domain_model_files.feuserid',
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
			'label' => 'LLL:EXT:bnbfilesharing/Resources/Private/Language/locallang_db.xml:tx_bnbfilesharing_domain_model_files.feuserug',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'trim'
			),
		),
		
		'folder' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bnbfilesharing/Resources/Private/Language/locallang_db.xml:tx_bnbfilesharing_domain_model_files.folder',
			'config' => array(
				'type' => 'select',
				'renderMode' => 'tree',
         'treeConfig' => array(
         	 'parentField' => 'folder',
           'appearance' => array(
             'expandAll' => true,
             'showHeader' => true,
           ),
         ),				
				
				'foreign_table' => 'tx_bnbfilesharing_domain_model_folder',
				'minitems' => 0,
				'maxitems' => 1,
				'eval' => 'required',				
				'appearance' => array(
					'collapse' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
	),
);
?>