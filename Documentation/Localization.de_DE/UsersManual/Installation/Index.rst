

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

#. Create a neLegen Sie eine neue Seite an und erstellen Sie eine
   Inhaltselement vom Typ “ **allgemeinens Plugin** ”

   Wählen Sie unter dem  **Reiter** “ **Plugin** ”das Plugin “
   **filesharing** ” aus. wieso klein? ohen bnb?

#. Erstellen Sie einen O **dner** . In diesem Ordner werden die
   Datensätze gespeichert.

#. Fügen sie das  **static Template** in Ihren Typoscript Setup
   ein.Wechseln Sie hierzu im Modulmenü auf “ **Template** ”, wählen ihre
   Wurzelseite und klicken da auf “ ` **Vollständigen Template-Datensatz
   bearbeiten**  <http://ernie/cms_tests/typo3-test2/typo3/sysext/tstempl
   ate/ts/index.php?id=1&&createExtension=0#>`_ ”. Unter dem Reiter “
   **Enthält** ” können Sie das  **static Template** “ **bnb
   filesharing** ” einbinden.Bitte beachten Sie dass ” **CSS Styled
   Content”** unbedingt vor“ **bnb filesharing”** eingebunden werden muß!

#. Erstellen Sie ein Erweiterungstemplate für die Seite in die das Plugin
   geladen wurde. Konfigurieren Sie hier auf alle Fälle die “
   **storagePid** ” des Folders, den Sie in Schritt 3 erstellt haben:eg.
   plugin.tx\_bnbfilesharing.persistence.storagePid = 21

   Bitte beachten Sie:  **storagePid** unterGeneral Record Storage
   Pageeingeben funktioniert nicht.

   Konfigurieren Sie hier bei Bedarf weitere Einstellungen, die von der
   Default-Konfiguration in  **typo3conf/ext/bnbfilesharing/Configuration
   /TypoScript/constants.txt** abweichen.

#. Die Extension sollte jetzt in der Basiskonfiguration lauffähig sein.

#. Wenn Sie das Plugin auf mehreren Seiten einsetzen wollen, z.B. für
   versch. Themen oder Bereiche, dann wiederholen Sie auf diesen weiteren
   Seiten die Schritte 2 bis 5 und passen die storagePid jeweils an.

