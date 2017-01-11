

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


Installation
^^^^^^^^^^^^

System requirements:  **TYP3 4.5, Extbase 1.3.0, Fluid 1.3.0**

#. Install the extension with the extension manager.

#. Create a new page and insert a content element of type “ **General
   Plugin** ”
   
   Open the  **tab** “ **Plugin** ” and choose the plugin “
   **bnbFilesharing** ”.

#. Create a sysfolder. All records will be stored here.

#. Include the  **static template** in your Typoscript setup.Switch to
   module “ **Template** ”, choose your root template and edit “The whole
   template record”. Change to tab “include” and select the  **static
   template** “ **bnbFilesharing** ”.Please note: ” **CSS Styled
   Content”** must be included before“ **bnbFilesharing”** !

#. Create an extension template for the page, where you inserted the
   bnbFilesharing plugin in step 2. Configure at least the “
   **storagePid** ” of the sysfolder you created in step 3:E.g.
   plugin.tx\_bnbfilesharing.persistence.storagePid = 21
   
   Please note:  **storagePid** underGeneral Record Storage Pagedoes not
   work.
   
   In this extension template you can configure further values differing
   from the default configuration in  **typo3conf/ext/bnbfilesharing/Conf
   iguration/TypoScript/constants.txt** .

#. The extension should now be working.

7. If you want to use the extension on more than one page, e.g. to
seperate different themes, repeat step 2 to 5. Don't forget to adjust
the according storagePid.

Please note: If you use the extension on different pages, you can not
bring together the uploaded files or created folders afterwards.

