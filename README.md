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
