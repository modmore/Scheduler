<?php

$_lang['scheduler'] = "Scheduler";
$_lang['scheduler.menu_desc'] = "Bevorstehende und erledigte Aufgaben, die im Hintergrund ausgeführt werden.";
$_lang['scheduler.search...'] = "Suche...";
$_lang['scheduler.filter_type...'] = "Aufgaben filtern...";
$_lang['scheduler.filter_namespace...'] = "Namensräume filtern...";
$_lang['scheduler.search_clear'] = "Filter zurücksetzen";

$_lang['scheduler.tbar.queued'] = "Ausstehend";
$_lang['scheduler.tbar.pastdue'] = "Überfällig";
$_lang['scheduler.tbar.running'] = "Laufend";
$_lang['scheduler.tbar.completed'] = "Erledigt";

$_lang['scheduler.upcoming'] = "Bevorstehende Aufgaben";
$_lang['scheduler.future'] = "Geplante Durchläufe";
$_lang['scheduler.history'] = "Erledigte Durchläufe";

$_lang['scheduler.tasks_desc'] = "Aufgaben die Sie für einen Durchlauf nutzen können.";
$_lang['scheduler.future_desc'] = "Hier sehen Sie eine Liste von Aufgaben, die in Kürze ausgeführt werden.";
$_lang['scheduler.history_desc'] = "Hier sehen Sie eine Liste von Aufgaben, die bereits erledigt und in der Vergangenheit durchlaufen wurden.";

$_lang['scheduler.class_key'] = "Typ";
$_lang['scheduler.content'] = "Inhalt";
$_lang['scheduler.content.file'] = "Relativer Dateipfad";
$_lang['scheduler.content.file_desc'] = "Geben Sie hier den Pfad zu der Datei an die für diese Aufgabe ausgeführt werden soll. Der Pfad muss relativ zum Core-Pfad des gewählten Namensraum sein.";
$_lang['scheduler.content.snippet'] = "Wählen Sie ein Snippet";
$_lang['scheduler.content.snippet_desc'] = "Wählen Sie ein Snippet aus der Liste das für diese Aufgabe ausgeführt werden soll.";
$_lang['scheduler.content.processor'] = "Name des Prozessors";
$_lang['scheduler.content.processor_desc'] = "Geben Sie den Namen des Prozessors ein der für diese Aufgabe ausgeführt werden soll. Dies ist relativ zum Prozessor-Ordner innerhalb des gewählten Namensraum und ohne (.class).php Endung.";
$_lang['scheduler.namespace'] = "Namensraum";
$_lang['scheduler.reference'] = "Referenz";
$_lang['scheduler.description'] = "Beschreibung";
$_lang['scheduler.status'] = "Status";
$_lang['scheduler.task'] = "Aufgabe";
$_lang['scheduler.tasks'] = "Aufgaben";
$_lang['scheduler.timing'] = "Zeit";
$_lang['scheduler.timing.inabout'] = "In ungefährt";
$_lang['scheduler.timing.desc'] = "Hinweis: Wenn Sie eine exakte Zeit eingeben wird die \"In ungefähr\" Einstellung ignoriert!";
$_lang['scheduler.data'] = "Daten";
$_lang['scheduler.errors'] = "Fehler";
$_lang['scheduler.message'] = "Nachricht";
$_lang['scheduler.next_run'] = "Nächster Durchlauf";
$_lang['scheduler.runs'] = "Durchläufe";
$_lang['scheduler.executedon'] = "Ausgeführt am";

$_lang['scheduler.task_create'] = "Neue Aufgabe anlegen";
$_lang['scheduler.task_update'] = "Aufgabe bearbeiten";
$_lang['scheduler.task_remove'] = "Aufgabe löschen";
$_lang['scheduler.task_remove_confirm'] = "Sind Sie sicher, dass Sie die Aufgabe \"[[+reference]]\" löschen möchten?";

$_lang['scheduler.run_create'] = "Neuen Durchlauf planen";
$_lang['scheduler.run_update'] = "Geplanten Durchlauf bearbeiten";
$_lang['scheduler.run_remove'] = "Geplanten Durchlauf  löschen";
$_lang['scheduler.run_remove_confirm'] = "Sind Sie sicher, dass Sie diesen Durchlauf planen möchten?";

$_lang['scheduler.data.add'] = "Neue Eigenschaft hinzufügen";
$_lang['scheduler.data.key'] = "Schlüssel";
$_lang['scheduler.data.value'] = "Wert";
$_lang['scheduler.data.update'] = "Eigenschaft bearbeiten";
$_lang['scheduler.data.remove'] = "Eigenschaft löschen";
$_lang['scheduler.data.remove_confirm'] = "Sind Sie sicher, dass Sie diese Eigenschaft löschen möchten?";

$_lang['scheduler.status_0'] = "Ausstehend";
$_lang['scheduler.status_1'] = "Laufend";
$_lang['scheduler.status_2'] = "Erfolgreich";
$_lang['scheduler.status_3'] = "Fehlgeschlagen";

$_lang['scheduler.class.sFileTask'] = "Datei-basierte Aufgabe";
$_lang['scheduler.class.sSnippetTask'] = "Snippet-basierte Aufgabe";
$_lang['scheduler.class.sProcessorTask'] = "Prozessor-basierte Aufgabe";

$_lang['scheduler.time.m'] = "Minute(n)";
$_lang['scheduler.time.h'] = "Stunde(n)";
$_lang['scheduler.time.d'] = "Tag(e)";
$_lang['scheduler.time.mnt'] = "Monat(e)";
$_lang['scheduler.time.y'] = "Jahr(e)";

$_lang['scheduler.reschedule'] = "Aufgabe erneut planen";

$_lang['scheduler.error.noresults'] = "Keine Einträge gefunden.";
$_lang['scheduler.error.no-file-content'] = "Bitte geben Sie einen Dateipfad für diese Aufgabe an.";
$_lang['scheduler.error.no-snippet-content'] = "Bitte wählen Sie für diese Aufgabe ein Snippet aus der Liste.";
$_lang['scheduler.error.no-processor-content'] = "Bitte geben Sie für diese Aufgabe einen Prozessor an.";
$_lang['scheduler.error.no-timing'] = "Bitte geben Sie eine Zeit für die geplante Ausführung der Aufgabe an.";