<?php

$_lang['scheduler'] = "Scheduler";
$_lang['scheduler.menu_desc'] = "Upcoming and historical tasks executed in the background.";
$_lang['scheduler.search...'] = "Search...";
$_lang['scheduler.filter_type...'] = "Filter tasks...";
$_lang['scheduler.filter_namespace...'] = "Filter namespace...";
$_lang['scheduler.search_clear'] = "Clear filter";

$_lang['scheduler.tbar.queued'] = "Queued";
$_lang['scheduler.tbar.pastdue'] = "Past Due";
$_lang['scheduler.tbar.running'] = "Running";
$_lang['scheduler.tbar.completed'] = "Completed";

$_lang['scheduler.upcoming'] = "Upcoming Tasks";
$_lang['scheduler.future'] = "Scheduled Runs";
$_lang['scheduler.history'] = "Historic Runs";

$_lang['scheduler.tasks_desc'] = "View the tasks you can schedule for a run.";
$_lang['scheduler.future_desc'] = "Below the list of tasks scheduled for running in the near future.";
$_lang['scheduler.history_desc'] = "The list below are tasks which already has been finished and runned in the past.";

$_lang['scheduler.class_key'] = "Type";
$_lang['scheduler.content'] = "Content";
$_lang['scheduler.content.file'] = "Relative file path";
$_lang['scheduler.content.file_desc'] = "Enter the path to the file you want to execute for this task. This path should be relative to the core path of the selected namespace.";
$_lang['scheduler.content.snippet'] = "Select a snippet";
$_lang['scheduler.content.snippet_desc'] = "Choose a snippet from the list which you want to execute for this task.";
$_lang['scheduler.content.processor'] = "The name of the processor";
$_lang['scheduler.content.processor_desc'] = "Enter the name of the processor which should be executed each run. This is relative to the processors folder inside the selected namespace and without (.class).php extension.";
$_lang['scheduler.namespace'] = "Namespace";
$_lang['scheduler.reference'] = "Reference";
$_lang['scheduler.description'] = "Description";
$_lang['scheduler.status'] = "Status";
$_lang['scheduler.task'] = "Task";
$_lang['scheduler.tasks'] = "Tasks";
$_lang['scheduler.timing'] = "Timing";
$_lang['scheduler.timing.inabout'] = "In about";
$_lang['scheduler.timing.desc'] = "Note: when you enter an exact timing, the \"In about\" setting is ignored!";
$_lang['scheduler.data'] = "Data";
$_lang['scheduler.errors'] = "Errors";
$_lang['scheduler.message'] = "Message";
$_lang['scheduler.next_run'] = "Next Run";
$_lang['scheduler.runs'] = "Runs";
$_lang['scheduler.executedon'] = "Executed On";

$_lang['scheduler.task_create'] = "Create new task";
$_lang['scheduler.task_update'] = "Update task";
$_lang['scheduler.task_remove'] = "Remove task";
$_lang['scheduler.task_remove_confirm'] = "Are you sure you want to remove \"[[+reference]]\" task?";

$_lang['scheduler.run_create'] = "Schedule new run";
$_lang['scheduler.run_update'] = "Update scheduled run";
$_lang['scheduler.run_remove'] = "Remove scheduled run";
$_lang['scheduler.run_remove_confirm'] = "Are you sure you want to remove this from scheduled run?";

$_lang['scheduler.data.add'] = "Add new property";
$_lang['scheduler.data.key'] = "Property key";
$_lang['scheduler.data.value'] = "Property value";
$_lang['scheduler.data.update'] = "Update property";
$_lang['scheduler.data.remove'] = "Remove property";
$_lang['scheduler.data.remove_confirm'] = "Are you sure you want to remove this property?";

$_lang['scheduler.status_0'] = "Pending";
$_lang['scheduler.status_1'] = "Executing";
$_lang['scheduler.status_2'] = "Successful";
$_lang['scheduler.status_3'] = "Failed";

$_lang['scheduler.class.sFileTask'] = "File based task";
$_lang['scheduler.class.sSnippetTask'] = "Snippet based task";
$_lang['scheduler.class.sProcessorTask'] = "Processor based task";

$_lang['scheduler.time.m'] = "Minute(s)";
$_lang['scheduler.time.h'] = "Hour(s)";
$_lang['scheduler.time.d'] = "Day(s)";
$_lang['scheduler.time.mnt'] = "Month(s)";
$_lang['scheduler.time.y'] = "Year(s)";

$_lang['scheduler.reschedule'] = "Re-schedule Task";

$_lang['scheduler.error.noresults'] = "No records found.";
$_lang['scheduler.error.no-file-content'] = "Please enter a file path for this task.";
$_lang['scheduler.error.no-snippet-content'] = "Please select a snippet from the list for this task.";
$_lang['scheduler.error.no-processor-content'] = "Please enter a processor name for this task.";
$_lang['scheduler.error.no-timing'] = "Please specify a timing for this task.";