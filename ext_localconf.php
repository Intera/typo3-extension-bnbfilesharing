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

?>