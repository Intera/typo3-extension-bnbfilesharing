

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


Mehrsprachigkeit
^^^^^^^^^^^^^^^^

Das filesharing Plugin unterstützt Mehrsprachigkeit. Zur Zeit sind
Übersetzungen für Labels, Fehlermeldungen u.ä. in deutsch und english
angelegt (config.language = en/de). Wenn Sie andere oder weitere
Sprachen verwenden, müssen Sie Labels, Fehlermeldungen u.ä.
übersetzen, in Resources/Private/Language/locallang.xml.

Wenn Sie für jede Sprache eigene Datensätze erzeugen möchten, geben
Sie im Setup der Konstante  **CreateLocalRecords** den Wert 1 an. bnb
filesharing erzeugt dann automatisch für jede Sprache einen eigenen
Datensatz. D.h. Sie können dann für jede Sprache eine eigene Datei
hochladen, bzw. Folder unterschiedlich benennen.

Wenn CreateLocalRecords auf 0 gesetzt wird, werden keine lokalisierten
Datensätze angelegt. In allen Sprachen wird der selbe Datensatz
ausgegeben. Setzen Sie in diesem Fall in Ihrem TYPOScript Setup die
Konstante  **config.sys\_language\_mode** auf  **content\_fallback.**

