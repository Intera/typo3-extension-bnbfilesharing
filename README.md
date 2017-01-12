# TYPO3 Extension bnbfilesharing

[![Build Status](https://travis-ci.org/Intera/typo3-extension-bnbfilesharing.svg?branch=master)](https://travis-ci.org/Intera/typo3-extension-bnbfilesharing)

Fork of the bnbfilesharing TYPO3 Extension.

This is basically a complete rewrite with the following changes:

* Bootstrap based Accordeons / Glyphicons for the file list
* Bootstrap based Forms
* TYPO3 6.2, 7.6, 8.5 compatibility
* No AJAX calls any more, all forms are default Extbase actions
* JavaScript only used for saving the Accordeon state in a cookie
* Minimal custom styles
* No automatic include of JavaScript / CSS (uncompiled Sass file available)
* Manual migrated to reST

## TODO

Currently there are requirements to non public Extensions that need to be resolved (intdiv, uploadhandler).

## Migration

Currently only manual update from version 1.x is possible. Execute these SQL queries:

```sql
RENAME TABLE tx_bnbfilesharing_domain_model_files TO tx_bnbfilesharing_domain_model_file;

ALTER TABLE `tx_bnbfilesharing_domain_model_file` CHANGE `beschriftung` `label` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';

ALTER TABLE `tx_bnbfilesharing_domain_model_file` CHANGE `feuserid` `feuser` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `tx_bnbfilesharing_domain_model_folder` CHANGE `feuserid` `feuser` INT(11) NOT NULL DEFAULT '0';
```
