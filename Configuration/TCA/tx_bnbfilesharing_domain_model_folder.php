<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:bnbfilesharing/Resources/Private/Language/locallang_db.xml:tx_bnbfilesharing_domain_model_folder',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => true,
        'versioningWS' => 2,
        'versioning_followPages' => true,
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY)
            . 'Resources/Public/Icons/tx_bnbfilesharing_domain_model_folder.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, children, files, feuserid',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, name, feuserid, children, files,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => [
                    ['LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1],
                    ['LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0]
                ],
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_bnbfilesharing_domain_model_folder',
                'foreign_table_where' => 'AND tx_bnbfilesharing_domain_model_folder.pid=###CURRENT_PID### AND tx_bnbfilesharing_domain_model_folder.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ]
        ],
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'starttime' => [
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => [
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ],
            ],
        ],
        'endtime' => [
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => [
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ],
            ],
        ],
        'name' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:bnbfilesharing/Resources/Private/Language/locallang_db.xml:tx_bnbfilesharing_domain_model_folder.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'children' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:bnbfilesharing/Resources/Private/Language/locallang_db.xml:tx_bnbfilesharing_domain_model_folder.children',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_bnbfilesharing_domain_model_folder',
                'foreign_field' => 'folder',
                'maxitems' => 9999,
                'appearance' => [
                    'collapse' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],
        ],
        'folder' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'feuserid' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:bnbfilesharing/Resources/Private/Language/locallang_db.xml:tx_bnbfilesharing_domain_model_folder.feuserid',
            'config' => [
                'foreign_table' => 'fe_users',
                'minitems' => 0,
                'maxitems' => 1,
                'type' => 'select',
                'size' => 1,
                'eval' => 'int'
            ],
        ],
        'feuserug' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:bnbfilesharing/Resources/Private/Language/locallang_db.xml:tx_bnbfilesharing_domain_model_folder.feuserug',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'trim'
            ],
        ],
        'files' => [
            'label' => 'files',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_bnbfilesharing_domain_model_file',
                'foreign_field' => 'folder',
            ],
        ],
    ],
];
