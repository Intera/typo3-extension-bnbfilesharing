<?php
$lllPrefix = 'LLL:EXT:bnbfilesharing/Resources/Private/Language/locallang_db.xlf:';
$lllColumnPrefix = $lllPrefix . 'tx_bnbfilesharing_domain_model_folder.';

return [
    'ctrl' => [
        'title' => $lllPrefix . 'tx_bnbfilesharing_domain_model_folder',
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
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('bnbfilesharing')
            . 'Resources/Public/Icons/tx_bnbfilesharing_domain_model_folder.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource,
            hidden, name, children, files, feuser',
    ],
    'types' => [
        '1' => [
            'showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, name, feuser, children, files,
                --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, hidden, starttime, endtime'
        ],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => [
                    ['LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1],
                    ['LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0]
                ],
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_bnbfilesharing_domain_model_folder',
                'foreign_table_where' => 'AND tx_bnbfilesharing_domain_model_folder.pid=###CURRENT_PID###'
                    . ' AND tx_bnbfilesharing_domain_model_folder.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ]
        ],
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'starttime' => [
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
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
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
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
            'label' => $lllColumnPrefix . 'name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'children' => [
            'exclude' => 0,
            'label' => $lllColumnPrefix . 'children',
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
        'feuser' => [
            'exclude' => 0,
            'label' => $lllColumnPrefix . 'feuser',
            'config' => [
                'foreign_table' => 'fe_users',
                'minitems' => 0,
                'maxitems' => 1,
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'size' => 1,
                'eval' => 'int'
            ],
        ],
        'files' => [
            'label' => $lllColumnPrefix . 'files',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_bnbfilesharing_domain_model_file',
                'foreign_field' => 'folder',
            ],
        ],
    ],
];
