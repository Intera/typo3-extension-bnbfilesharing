

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


Reference
^^^^^^^^^


.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         Property:
   
   Data type
         Data type:
   
   Description
         Description:
   
   Default
         Default:


.. container:: table-row

   Property
         storagePid
   
   Data type
         integer
   
   Description
         The uid of the sys-folder where the records will be stored.
   
   Default


.. container:: table-row

   Property
         userGroupAllowCreateRootFolders
   
   Data type
         string
   
   Description
         The  **ID** of the usergroup which can create folders on the rootline
         (1. level) of the filesharing page.
         
         **all** if everybody can create folders on the rootline.
   
   Default
         all


.. container:: table-row

   Property
         userGroupAllowCreateFolders
   
   Data type
         string
   
   Description
         The  **ID** of the usergroup which can create subfolders.
         
         **all** if everybody can create subfolders.
         
         **owner** if only the owner of the parentfolder can create subfolders.
   
   Default
         all


.. container:: table-row

   Property
         userGroupAllowEditFolders
   
   Data type
         string
   
   Description
         The  **ID** of the usergroup which can edit foldernames.
         
         **all** if everybody can edit foldernames.
         
         **owner** if only the owner of the parentfolder can edit foldernames.
   
   Default
         all


.. container:: table-row

   Property
         userGroupAllowDeleteFolders
   
   Data type
         string
   
   Description
         The  **ID** of the usergroup which can delete folders.
         
         **all** if everybody can delete folders.
         
         **owner** if only the owner of the folder can delete the folder.
   
   Default
         all


.. container:: table-row

   Property
         userGroupAllowEditFiles
   
   Data type
         string
   
   Description
         The  **ID** of the usergroup which can edit filenames.
         
         **all** if everybody can edit filenames.
         
         **owner** if only the owner of the file can edit the filename.
   
   Default
         all


.. container:: table-row

   Property
         userGroupAllowDeleteFiles
   
   Data type
         string
   
   Description
         The  **ID** of the usergroup which can delete files.
         
         **all** if everybody can delete files.
         
         **owner** if only the owner of the file can delete files.
   
   Default
         all


.. container:: table-row

   Property
         userGroupAllowUpload
   
   Data type
         string
   
   Description
         The  **ID** of the usergroup which can upload files.
         
         **all** if everybody can upload files.
         
         **owner** if only the of owner of the parentfolder can upload files.
   
   Default
         all


.. container:: table-row

   Property
         userGroupAllowDownload
   
   Data type
         string
   
   Description
         The  **ID** of the usergroup which can download files.
         
         **all** if everybody can download files.
   
   Default
         all


.. container:: table-row

   Property
         allowedUploadFileTypes
   
   Data type
         string
   
   Description
         Comma separated list of allowed filetypes, eg. pdf, jpg.
         
         **all** if every filetype is allowed.
   
   Default
         all


.. container:: table-row

   Property
         forbiddenUploadFileTypes
   
   Data type
         string
   
   Description
         Comma separated list of forbidden filetypes.
   
   Default
         php, php3, php4, php5


.. container:: table-row

   Property
         loadjquery
   
   Data type
         Boolean
   
   Description
         If set, JQuery is loaded. Set to 0 if JQuery is already loaded eg. by
         another extension.
   
   Default
         1


.. container:: table-row

   Property
         loadFancybox
   
   Data type
         boolean
   
   Description
         If set, Fancybox is loaded. Set to 0 if Fancybox is already loaded eg.
         by another extension.
   
   Default
         1


.. container:: table-row

   Property
         loadjqueryForm
   
   Data type
         boolean
   
   Description
         If set, JQuery Form is loaded. Set to 0 if JQuery Form is already
         loaded eg. by another extension.
   
   Default
         1


.. container:: table-row

   Property
         createLocalRecords
   
   Data type
         boolean
   
   Description
         If set, localization records are automatically created. Set to true,
         if you want different records for each language.
   
   Default
         1


.. container:: table-row

   Property
         orderFolderField
   
   Data type
         string
   
   Description
         The fieldname, folders are orderd by
         
         Possible values:  **name** ,  **date**
   
   Default
         name


.. container:: table-row

   Property
         orderFolderOrder
   
   Data type
         string
   
   Description
         Ascending or descending order of foldersPossible values:  **ASC** ,
         **DESC**
   
   Default
         ASC


.. container:: table-row

   Property
         orderFilesField
   
   Data type
         string
   
   Description
         The fieldname, files are orderd by
         
         Possible values:  **name** ,  **date**
   
   Default
         name


.. container:: table-row

   Property
         orderFilesOrder
   
   Data type
         string
   
   Description
         Ascending or descending order of filesPossible values:  **ASC** ,
         **DESC**
   
   Default
         ASC


.. container:: table-row

   Property
         maxUploadFilesize
   
   Data type
         integer
   
   Description
         Max filesize in KB. If this value ist larger than
         
         $TYPO3\_CONF\_VARS['BE']['maxFileSize'], this value will be ignored.
   
   Default
         1024


.. ###### END~OF~TABLE ######

