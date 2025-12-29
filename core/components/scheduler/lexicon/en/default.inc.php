<?php

$_lang['scheduler'] = "Scheduler";
$_lang['scheduler.menu_desc'] = "Upcoming and historical tasks executed in the background.";
$_lang['scheduler.search...'] = "Search...";
$_lang['scheduler.filter_task'] = "Filter on task";
$_lang['scheduler.filter_type...'] = "Filter on type";
$_lang['scheduler.filter_namespace...'] = "Filter namespace";
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
$_lang['scheduler.task_key'] = "Task key";
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
$_lang['scheduler.executedon'] = "Executed on";
$_lang['scheduler.processing_time'] = "Processing time";
$_lang['scheduler.avg_processing_time'] = "Average processing time";
$_lang['scheduler.actions'] = "Actions";

$_lang['scheduler.task_create'] = "Create new task";
$_lang['scheduler.task_update'] = "Update task";
$_lang['scheduler.task_remove'] = "Remove task";
$_lang['scheduler.task_remove_confirm'] = "Are you sure you want to remove \"[[+reference]]\" task?";

$_lang['scheduler.run_create'] = "Schedule new run";
$_lang['scheduler.run_update'] = "Update scheduled run";
$_lang['scheduler.run_remove'] = "Remove scheduled run";
$_lang['scheduler.runs_remove'] = "Remove  scheduled runs";
$_lang['scheduler.run_remove_confirm'] = "Are you sure you want to remove this from scheduled run?";
$_lang['scheduler.run_multiple_remove_confirm'] = "Are you sure you want to remove these from scheduled runs?";

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

// Recurring tasks
$_lang['scheduler.recurring'] = 'Recurring';
$_lang['scheduler.recurring_desc'] = 'Enable to automatically reschedule this task after each successful run';
$_lang['scheduler.interval'] = 'Interval';
$_lang['scheduler.interval_desc'] = 'Time interval between runs in strtotime format (e.g., "+30 minutes", "+1 hour", "+1 day")';

$_lang['scheduler.error.no-interval'] = 'Please specify an interval for recurring task.';
$_lang['scheduler.error.invalid-interval'] = 'Invalid interval format. Use strtotime format like "+30 minutes" or "+1 hour".';

$_lang['setting_scheduler.email_failure'] = "Email failures to";
$_lang['setting_scheduler.email_failure_desc'] = "Enter an email address, or multiple comma separated email address, to send an notification when a task fails.";
$_lang['setting_scheduler.email_failure_tpl'] = "Failure email template chunk";
$_lang['setting_scheduler.email_failure_tpl_desc'] = "Name of the chunk to use for failure notification emails. Leave empty to use the built-in template. Available placeholders: [[+task_namespace]], [[+task_reference]], [[+run_id]], [[+run_message]], [[+run_errors_formatted]], [[+site_name]], [[+executed_on]], [[+run_retry_count]].";
$_lang['setting_scheduler.email_failure_subject'] = "Failure email subject";
$_lang['setting_scheduler.email_failure_subject_desc'] = "Custom subject for failure notification emails. Leave empty for default. Supports placeholders: [[+task_namespace]], [[+task_reference]], [[+site_name]].";
$_lang['setting_scheduler.delete_tasks_after'] = "Delete task runs after";
$_lang['setting_scheduler.delete_tasks_after_desc'] = 'Set to a strtotime() compatible time string (such as "-1 year" or "-2 weeks") to automatically remove completed or failed tasks older than that cut-off time. This runs automatically every 30th minute through the run.php cron job.';
$_lang['setting_scheduler.recurring_on_failure'] = 'Continue recurring on failure';
$_lang['setting_scheduler.recurring_on_failure_desc'] = 'If enabled, recurring tasks will continue to be scheduled even after a failed run. Default: disabled (stops on failure).';

$_lang['area_recurring'] = 'Recurring Tasks';
$_lang['setting_scheduler.tasks_per_run'] = "Tasks per cron run";
$_lang['setting_scheduler.tasks_per_run_desc'] = "Maximum number of tasks to execute per cron run. Default is 1. Increase for higher throughput, but be aware of potential timeout issues.";

$_lang['scheduler.max_retries'] = "Max retries";
$_lang['scheduler.max_retries_desc'] = "Maximum number of retry attempts if task fails. Set to 0 to disable retries.";
$_lang['scheduler.retry_delay'] = "Retry delay (seconds)";
$_lang['scheduler.retry_delay_desc'] = "Delay in seconds before retrying a failed task. Default is 60 seconds.";
$_lang['scheduler.retry_count'] = "Retry attempt";
