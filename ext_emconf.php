<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "bnbfilesharing".
 *
 * Auto generated 03-06-2014 09:43
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'bnbFilesharing',
	'description' => 'Ajax driven filetree for user up- and downloads. Based on extbase 1.3.0, fluid 1.3.0 and TYPO3 4.5',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '1.0.3',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Soenke Trunk, Catherine de Courten',
	'author_email' => 'trunk@beans-n-bites.de, cat@beans-n-bites.de',
	'author_company' => 'beans-n-bites, beans-n-bites',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'extbase' => '1.3.0',
			'fluid' => '1.3.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:74:{s:12:"ext_icon.gif";s:4:"e922";s:17:"ext_localconf.php";s:4:"78db";s:14:"ext_tables.php";s:4:"66ee";s:14:"ext_tables.sql";s:4:"a708";s:21:"ExtensionBuilder.json";s:4:"5ccc";s:38:"Classes/Controller/FilesController.php";s:4:"0b69";s:39:"Classes/Controller/FolderController.php";s:4:"e353";s:30:"Classes/Domain/Model/Files.php";s:4:"e037";s:31:"Classes/Domain/Model/Folder.php";s:4:"8711";s:45:"Classes/Domain/Repository/FilesRepository.php";s:4:"f4b1";s:46:"Classes/Domain/Repository/FolderRepository.php";s:4:"d9b2";s:44:"Configuration/ExtensionBuilder/settings.yaml";s:4:"22cd";s:27:"Configuration/TCA/Files.php";s:4:"8f1b";s:28:"Configuration/TCA/Folder.php";s:4:"85e2";s:38:"Configuration/TypoScript/constants.txt";s:4:"6756";s:34:"Configuration/TypoScript/setup.txt";s:4:"4030";s:44:"Resources/Private/BackEnd/bnbfilesharing.php";s:4:"1d38";s:40:"Resources/Private/Language/locallang.xml";s:4:"c313";s:81:"Resources/Private/Language/locallang_csh_tx_bnbfilesharing_domain_model_files.xml";s:4:"07e9";s:82:"Resources/Private/Language/locallang_csh_tx_bnbfilesharing_domain_model_folder.xml";s:4:"dae1";s:78:"Resources/Private/Language/locallang_csh_tx_filesharing_domain_model_files.xml";s:4:"07e9";s:79:"Resources/Private/Language/locallang_csh_tx_filesharing_domain_model_folder.xml";s:4:"dae1";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"81d8";s:47:"Resources/Private/Language/locallang_module.xml";s:4:"c2c1";s:35:"Resources/Private/Layouts/Ajax.html";s:4:"7e7e";s:38:"Resources/Private/Layouts/Default.html";s:4:"20c0";s:42:"Resources/Private/Partials/FormErrors.html";s:4:"f5bc";s:48:"Resources/Private/Partials/Files/FormFields.html";s:4:"bfbe";s:49:"Resources/Private/Partials/Folder/FormFields.html";s:4:"eacc";s:44:"Resources/Private/Templates/Folder/List.html";s:4:"94d2";s:33:"Resources/Public/Icons/icon28.jpg";s:4:"9605";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:63:"Resources/Public/Icons/tx_bnbfilesharing_domain_model_files.gif";s:4:"1103";s:64:"Resources/Public/Icons/tx_bnbfilesharing_domain_model_folder.gif";s:4:"905a";s:36:"Resources/Public/css/filesharing.css";s:4:"9645";s:37:"Resources/Public/img/bg-plattform.gif";s:4:"167d";s:29:"Resources/Public/img/edit.gif";s:4:"6f81";s:33:"Resources/Public/img/loeschen.gif";s:4:"61b5";s:31:"Resources/Public/img/upload.gif";s:4:"95f6";s:36:"Resources/Public/img/wait16trans.gif";s:4:"e080";s:31:"Resources/Public/img/wait18.gif";s:4:"1178";s:42:"Resources/Public/javascript/filesharing.js";s:4:"af12";s:37:"Resources/Public/javascript/jquery.js";s:4:"1009";s:41:"Resources/Public/javascript/jqueryform.js";s:4:"44d6";s:46:"Resources/Public/javascript/fancybox/blank.gif";s:4:"3254";s:52:"Resources/Public/javascript/fancybox/fancy_close.png";s:4:"6e28";s:54:"Resources/Public/javascript/fancybox/fancy_loading.png";s:4:"b1d5";s:55:"Resources/Public/javascript/fancybox/fancy_nav_left.png";s:4:"3f3e";s:56:"Resources/Public/javascript/fancybox/fancy_nav_right.png";s:4:"216e";s:55:"Resources/Public/javascript/fancybox/fancy_shadow_e.png";s:4:"fd4f";s:55:"Resources/Public/javascript/fancybox/fancy_shadow_n.png";s:4:"18cd";s:56:"Resources/Public/javascript/fancybox/fancy_shadow_ne.png";s:4:"63ad";s:56:"Resources/Public/javascript/fancybox/fancy_shadow_nw.png";s:4:"c820";s:55:"Resources/Public/javascript/fancybox/fancy_shadow_s.png";s:4:"9b9e";s:56:"Resources/Public/javascript/fancybox/fancy_shadow_se.png";s:4:"a8af";s:56:"Resources/Public/javascript/fancybox/fancy_shadow_sw.png";s:4:"f81c";s:55:"Resources/Public/javascript/fancybox/fancy_shadow_w.png";s:4:"59b0";s:57:"Resources/Public/javascript/fancybox/fancy_title_left.png";s:4:"1582";s:57:"Resources/Public/javascript/fancybox/fancy_title_main.png";s:4:"38da";s:57:"Resources/Public/javascript/fancybox/fancy_title_over.png";s:4:"b886";s:58:"Resources/Public/javascript/fancybox/fancy_title_right.png";s:4:"6cbe";s:51:"Resources/Public/javascript/fancybox/fancybox-x.png";s:4:"1686";s:51:"Resources/Public/javascript/fancybox/fancybox-y.png";s:4:"36a5";s:49:"Resources/Public/javascript/fancybox/fancybox.png";s:4:"11e5";s:62:"Resources/Public/javascript/fancybox/jquery.easing-1.3.pack.js";s:4:"def2";s:62:"Resources/Public/javascript/fancybox/jquery.fancybox-1.3.4.css";s:4:"4638";s:61:"Resources/Public/javascript/fancybox/jquery.fancybox-1.3.4.js";s:4:"e7fc";s:66:"Resources/Public/javascript/fancybox/jquery.fancybox-1.3.4.pack.js";s:4:"8bc3";s:68:"Resources/Public/javascript/fancybox/jquery.mousewheel-3.0.4.pack.js";s:4:"3b0a";s:37:"Tests/Unit/Domain/Model/FilesTest.php";s:4:"63fc";s:38:"Tests/Unit/Domain/Model/FolderTest.php";s:4:"5949";s:19:"doc/filesharing.jpg";s:4:"a251";s:17:"doc/manual-dt.sxw";s:4:"dc03";s:14:"doc/manual.sxw";s:4:"94fc";}',
);

?>