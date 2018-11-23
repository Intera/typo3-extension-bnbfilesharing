<?php
$lllPrefix = 'LLL:EXT:bnbfilesharing/Resources/Private/Language/locallang_db.xlf:';
$lllColumnPrefix = $lllPrefix . 'tx_bnbfilesharing_domain_model_file.';

return [
    'ctrl' => [
        'title' => $lllPrefix . 'tx_bnbfilesharing_domain_model_file',
        'label' => 'file',
        'hideTable' => true,
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
            . 'Resources/Public/Icons/tx_bnbfilesharing_domain_model_file.gif',
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, file, label,
            feuser, folder',
    ],
    'types' => [
        '1' => [
            'showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, file, label, feuser, folder,
                --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, hidden, starttime, endtime',
        ],
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
                    [
                        'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                        -1,
                    ],
                    [
                        'LLL:EXT:lang/locallang_general.xlf:LGL.default_value',
                        0,
                    ],
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
                    [
                        '',
                        0,
                    ],
                ],
                'foreign_table' => 'tx_bnbfilesharing_domain_model_file',
                'foreign_table_where' => 'AND tx_bnbfilesharing_domain_model_file.pid=###CURRENT_PID###'
                    . ' AND tx_bnbfilesharing_domain_model_file.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => ['type' => 'passthrough'],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => ['type' => 'check'],
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
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y')),
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
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y')),
                ],
            ],
        ],
        'file' => [
            'exclude' => 0,
            'label' => $lllColumnPrefix . 'file',
            'config' => [
                'type' => 'group',
                'internal_type' => 'file',
                'uploadfolder' => 'uploads/tx_bnbfilesharing',
                'allowed' => '*',
                'size' => 1,
                'maxitems' => 1,
                'minitems' => 1,
                'eval' => 'required',
            ],
        ],
        'label' => [
            'exclude' => 0,
            'label' => $lllColumnPrefix . 'label',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
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
                'eval' => 'int',
            ],
        ],
        'folder' => [
            'exclude' => 0,
            'label' => $lllColumnPrefix . 'folder',
            'config' => [
                'type' => 'select',
                'renderMode' => 'tree',
                'treeConfig' => [
                    'parentField' => 'folder',
                    'appearance' => [
                        'expandAll' => true,
                        'showHeader' => true,
                    ],
                ],
                'foreign_table' => 'tx_bnbfilesharing_domain_model_folder',
                'minitems' => 0,
                'maxitems' => 1,
                'eval' => 'required',
                'appearance' => [
                    'collapse' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                ],
            ],
        ],
        'tstamp' => [
            'config' => ['type' => 'passthrough'],
        ],
    ],
];
