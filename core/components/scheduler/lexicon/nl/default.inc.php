<?php

$_lang['scheduler'] = "Scheduler";
$_lang['scheduler.menu_desc'] = "Aankomende en historische taken, uitgevoerd op de achtergrond.";
$_lang['scheduler.search...'] = "Zoeken...";
$_lang['scheduler.filter_type...'] = "Filter taken...";
$_lang['scheduler.filter_namespace...'] = "Filter namespace...";
$_lang['scheduler.search_clear'] = "Reset filter";

$_lang['scheduler.tbar.queued'] = "Wachtrij";
$_lang['scheduler.tbar.pastdue'] = "Verlopen";
$_lang['scheduler.tbar.running'] = "Lopend";
$_lang['scheduler.tbar.completed'] = "Afgerond";

$_lang['scheduler.upcoming'] = "Aankomende taken";
$_lang['scheduler.future'] = "Geplande Activiteiten";
$_lang['scheduler.history'] = "Historische Activiteiten";

$_lang['scheduler.tasks_desc'] = "Toont alle taken welke je kunt plannen voor uitvoering.";
$_lang['scheduler.future_desc'] = "Hieronder de lijst met geplande taken, voor uitvoering in de nabije toekomst.";
$_lang['scheduler.history_desc'] = "De lijst hieronder bevat taken welke reeds afgerond en uitgevoerd zijn in het verleden.";

$_lang['scheduler.class_key'] = "Type";
$_lang['scheduler.content'] = "Content";
$_lang['scheduler.content.file'] = "Relatieve bestandslocatie";
$_lang['scheduler.content.file_desc'] = "Vul het pad naar het bestand in welke uitgevoerd moet worden voor deze taak. Dit pad moet relatief zijn aan het pad voor de geselecteerde namespace.";
$_lang['scheduler.content.snippet'] = "Selecteer een Snippet";
$_lang['scheduler.content.snippet_desc'] = "Kies een snippet uit de lijst, welke jij wilt uitvoeren voor deze taak.";
$_lang['scheduler.content.processor'] = "De naam van de processor";
$_lang['scheduler.content.processor_desc'] = "Vul de naam van de processor in welke jij wilt uitvoeren voor deze taak. Dit pad is relatief aan de processors map binnen de geselecteerde namespace en zonder (.class).php extensie.";
$_lang['scheduler.namespace'] = "Namespace";
$_lang['scheduler.reference'] = "Referentie";
$_lang['scheduler.description'] = "Omschrijving";
$_lang['scheduler.status'] = "Status";
$_lang['scheduler.task'] = "Taak";
$_lang['scheduler.tasks'] = "Taken";
$_lang['scheduler.timing'] = "Planning";
$_lang['scheduler.timing.inabout'] = "Ongeveer over";
$_lang['scheduler.timing.desc'] = "Let op: wanneer je een exacte planning invult, wordt de \"Ongeveer over\" genegeerd.";
$_lang['scheduler.data'] = "Data";
$_lang['scheduler.errors'] = "Fouten";
$_lang['scheduler.message'] = "Bericht";
$_lang['scheduler.next_run'] = "Volgende Activiteit";
$_lang['scheduler.runs'] = "Activiteiten";
$_lang['scheduler.executedon'] = "Uitgevoerd op";

$_lang['scheduler.task_create'] = "Nieuwe taak toevoegen";
$_lang['scheduler.task_update'] = "Taak bewerken";
$_lang['scheduler.task_remove'] = "Verwijder taak";
$_lang['scheduler.task_remove_confirm'] = "Weet je zeker dat je de taak \"[[+reference]]\" wilt verwijderen?";

$_lang['scheduler.run_create'] = "Plan nieuwe uitvoering";
$_lang['scheduler.run_update'] = "Bewerk geplande activiteit";
$_lang['scheduler.run_remove'] = "Verwijder geplande activiteit";
$_lang['scheduler.run_remove_confirm'] = "Weet je zeker dat je deze activiteit uit de planning wilt verwijderen?";

$_lang['scheduler.data.add'] = "Nieuwe eigenschap toevoegen";
$_lang['scheduler.data.key'] = "Eigenschap naam";
$_lang['scheduler.data.value'] = "Eigenschap waarde";
$_lang['scheduler.data.update'] = "Eigenschap bewerken";
$_lang['scheduler.data.remove'] = "Verwijder eigenschap";
$_lang['scheduler.data.remove_confirm'] = "Weet je zeker dat je deze eigenschap wilt verwijderen?";

$_lang['scheduler.status_0'] = "In afwachting";
$_lang['scheduler.status_1'] = "In uitgevoering";
$_lang['scheduler.status_2'] = "Succesvol";
$_lang['scheduler.status_3'] = "Mislukt";

$_lang['scheduler.class.sFileTask'] = "Bestand gebaseerde taak";
$_lang['scheduler.class.sSnippetTask'] = "Snippet gebaseerde taak";
$_lang['scheduler.class.sProcessorTask'] = "Processor gebaseerde taak";

$_lang['scheduler.time.m'] = "Minuut(en)";
$_lang['scheduler.time.h'] = "Uur(en)";
$_lang['scheduler.time.d'] = "Dag(en)";
$_lang['scheduler.time.mnt'] = "Maand(en)";
$_lang['scheduler.time.y'] = "Jaar(en)";

$_lang['scheduler.reschedule'] = "Taak opnieuw plannen";

$_lang['scheduler.error.noresults'] = "Geen records gevonden.";
$_lang['scheduler.error.no-file-content'] = "Vul aub een bestandslocatie in voor deze taak.";
$_lang['scheduler.error.no-snippet-content'] = "Selecteer aub een Snippet uit de lijst voor deze taak.";
$_lang['scheduler.error.no-processor-content'] = "Vul aub een processor naam in voor deze taak.";
$_lang['scheduler.error.no-timing'] = "Vul aub een planning in voor deze taak.";