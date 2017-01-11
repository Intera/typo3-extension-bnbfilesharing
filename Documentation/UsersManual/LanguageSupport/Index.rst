

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Language Support
^^^^^^^^^^^^^^^^

The bnbFilesharing extension supports languages. At the moment there
are translations for labels, errormessages etc. in german and english
(config.language = en/de). If you want to use more or other languages,
you need to translate labels, errormessages etc. in
Resources/Private/Language/locallang.xml.

If you want to create different records for each language, set
**CreateLocalRecords** to 1 in your setup. bnbFilesharing will then
automatically create records for each language. I.e. for each language
you can upload a different file or name folders differently.

If  **CreateLocalRecords** is set to 0, no localized records are
generated. All localisations will show the same data records, if
**config.sys\_language\_mode** is set to  **content\_fallback** in
your Typoscript setup.

