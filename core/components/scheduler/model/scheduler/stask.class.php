<?php

/**
 * Class sTask
 *
 * @package Scheduler
 *
 * @property int $id
 * @property string $class_key
 * @property string $content
 * @property string $namespace
 * @property string $reference
 * @property string $description
 * @property int $max_retries
 * @property int $retry_delay
 */
class sTask extends xPDOSimpleObject
{
    /**
     * @param int|string $when
     * @param array $data
     * @return false|sTaskRun
     */
    public function schedule($when, array $data = array(), string $task_key = '')
    {
        /** @var sTaskRun $run */
        $run = $this->xpdo->newObject('sTaskRun');
        $run->fromArray(array(
            'task' => $this->get('id'),
            'data' => $data,
            'task_key' => $task_key,
        ));
        $run->setTiming($when);

        if ($run->save()) {
            return $run;
        }
        return false;
    }

    /**
     * @param sTaskRun $run
     * @param bool $statusAlreadySet If true, EXECUTING status was already set atomically
     * @return sTask $this
     */
    public function run($run, bool $statusAlreadySet = false)
    {
        // Set status to executing (and save) so other triggers don't also run this one
        // If status was already set atomically in run.php, skip this step
        if (!$statusAlreadySet) {
            $run->set('status', sTaskRun::STATUS_EXECUTING);
            $run->save();
        }

        // Run the task
        try {
            $return = $this->_run($run);
        } catch (\Throwable $e) {
            // Throwable catches both Exception and Error (PHP 7+)
            $run->addError(get_class($e), [
                'exception' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            $return = '';
        }

        // All done! Update status, completed date and save.
        $finalStatus = $run->hasErrors() ? sTaskRun::STATUS_FAILURE : sTaskRun::STATUS_SUCCESS;
        $run->set('status', $finalStatus);
        $run->set('message', $return);
        $run->set('executedon', time());
        $run->save();

        // Schedule next run for recurring tasks
        if ($this->get('recurring')) {
            $continueOnFailure = (bool) $this->xpdo->getOption(
                'scheduler.recurring_on_failure',
                null,
                false
            );

            if ($finalStatus === sTaskRun::STATUS_SUCCESS || $continueOnFailure) {
                $this->scheduleNext($run);
            } else {
                $this->xpdo->log(
                    xPDO::LOG_LEVEL_WARN,
                    "[Scheduler] Recurring task '{$this->get('reference')}' stopped due to failure. " .
                    "Set scheduler.recurring_on_failure=true to continue on errors."
                );
            }
        }

        if ($run->hasErrors()) {
            $this->notifyFailure($run);
            $this->handleRetry($run);
        }

        return $this;
    }

    /**
     * Handle retry logic for failed tasks
     *
     * @param sTaskRun $run
     * @return void
     */
    protected function handleRetry(sTaskRun $run)
    {
        $maxRetries = (int) $this->get('max_retries');
        $retryCount = (int) $run->get('retry_count');
        $retryDelay = (int) $this->get('retry_delay') ?: 60; // default 60 seconds

        if ($maxRetries > 0 && $retryCount < $maxRetries) {
            /** @var sTaskRun $newRun */
            $newRun = $this->xpdo->newObject('sTaskRun');
            $newRun->fromArray([
                'task' => $this->get('id'),
                'data' => $run->get('data'),
                'task_key' => $run->get('task_key'),
                'retry_count' => $retryCount + 1,
            ]);
            $newRun->setTiming('+' . $retryDelay . ' seconds');

            if ($newRun->save()) {
                $this->xpdo->log(
                    \xPDO::LOG_LEVEL_INFO,
                    "[Scheduler] Retry {$newRun->get('retry_count')}/{$maxRetries} scheduled for task {$this->get('namespace')}::{$this->get('reference')}"
                );
            }
        }
    }

    /**
     * Schedule next run for recurring task
     *
     * @param sTaskRun $completedRun The completed run
     * @return sTaskRun|null The new scheduled run or null
     */
    public function scheduleNext(sTaskRun $completedRun)
    {
        if (!$this->get('recurring')) {
            return null;
        }

        $interval = $this->get('interval');
        if (empty($interval)) {
            $this->xpdo->log(
                xPDO::LOG_LEVEL_WARN,
                "[Scheduler] Recurring task '{$this->get('reference')}' has no interval set"
            );
            return null;
        }

        $nextTime = strtotime($interval);
        if ($nextTime === false || $nextTime <= time()) {
            $this->xpdo->log(
                xPDO::LOG_LEVEL_ERROR,
                "[Scheduler] Invalid interval '{$interval}' for task '{$this->get('reference')}'"
            );
            return null;
        }

        $nextRun = $this->schedule($interval);

        if ($nextRun) {
            $this->xpdo->log(
                xPDO::LOG_LEVEL_INFO,
                "[Scheduler] Recurring task '{$this->get('reference')}' scheduled next run at " .
                date('Y-m-d H:i:s', $nextRun->get('timing'))
            );
        }

        return $nextRun;
    }

    /**
     * Gets the namespace object for the task.
     *
     * @return null|modNamespace
     */
    public function _getNamespace()
    {
        $ns = $this->get('namespace');
        if (!empty($ns)) {
            $namespace = $this->xpdo->getObject('modNamespace', $ns);
            if ($namespace instanceof modNamespace) {
                return $namespace;
            }
        }
        return null;
    }

    /**
     * @param sTaskRun $run
     * @return mixed
     */
    protected function _run(&$run)
    {

        /* This method should be abstract, but because of using xPDO::loadClass() in the main model, it cannot handle it */

        $run->addError('stask_direct_run_failure', array(
            'message' => 'Not allowed to run the sTask::_run() method directly!',
        ));
        return false;
    }

    /**
     * Send notification about task execution failure
     *
     * @param sTaskRun $run
     * @return void
     */
    protected function notifyFailure(sTaskRun $run)
    {
        $recipients = $this->xpdo->getOption('scheduler.email_failure');
        $recipients = array_filter(array_map('trim', explode(',', $recipients)));
        if (count($recipients) === 0) {
            return;
        }

        $task = $run->getOne('Task');
        if (!$task) {
            $this->xpdo->log(\xPDO::LOG_LEVEL_ERROR, 'Error notifying about failed task; could not find task for run ' . $run->get('id'));
            return;
        }

        // Prepare data for template
        $placeholders = [
            'task_namespace' => $task->get('namespace'),
            'task_reference' => $task->get('reference'),
            'task_description' => $task->get('description'),
            'run_id' => $run->get('id'),
            'run_message' => $run->get('message'),
            'run_errors' => $run->get('errors'),
            'run_errors_formatted' => print_r($run->get('errors'), true),
            'run_retry_count' => $run->get('retry_count'),
            'site_name' => $this->xpdo->getOption('site_name'),
            'site_url' => $this->xpdo->getOption('site_url'),
            'executed_on' => date('Y-m-d H:i:s', $run->get('executedon')),
        ];

        // Get email template
        $message = $this->getFailureEmailBody($placeholders);
        $subject = $this->getFailureEmailSubject($placeholders);

        /** @var \modMail|\MODX\Revolution\Mail\modMail $mail */
        $mail = $this->xpdo->getService('mail', 'mail.modPHPMailer');
        $mail->set('mail_body', $message);
        $mail->set('mail_from', $this->xpdo->getOption('emailsender'));
        $mail->set('mail_from_name', 'Scheduler at ' . $this->xpdo->getOption('site_name'));
        $mail->set('mail_subject', $subject);
        foreach ($recipients as $recipient) {
            $mail->address('to', $recipient);
        }
        $mail->setHTML(true);
        if (!$mail->send()) {
            $this->xpdo->log(\modX::LOG_LEVEL_ERROR, 'An error occurred while trying to send email: ' . $mail->mailer->ErrorInfo);
        }
        $mail->reset();
    }

    /**
     * Get failure email subject
     *
     * @param array $placeholders
     * @return string
     */
    protected function getFailureEmailSubject(array $placeholders): string
    {
        $subject = $this->xpdo->getOption('scheduler.email_failure_subject', null, '');

        if (empty($subject)) {
            $subject = "Error running {$placeholders['task_namespace']} :: {$placeholders['task_reference']}";
        } else {
            $subject = $this->parsePlaceholders($subject, $placeholders);
        }

        return $subject;
    }

    /**
     * Get failure email body.
     * Supports custom chunk via scheduler.email_failure_tpl setting
     *
     * @param array $placeholders
     * @return string
     */
    protected function getFailureEmailBody(array $placeholders): string
    {
        $tpl = $this->xpdo->getOption('scheduler.email_failure_tpl', null, '');

        // If chunk is specified, use it
        if (!empty($tpl)) {
            $chunk = $this->xpdo->getObject('modChunk', ['name' => $tpl]);
            if ($chunk) {
                return $chunk->process($placeholders);
            }
        }

        // Fallback to built-in template
        return $this->getDefaultFailureEmailBody($placeholders);
    }

    /**
     * Default failure email template
     *
     * @param array $placeholders
     * @return string
     */
    protected function getDefaultFailureEmailBody(array $placeholders): string
    {
        $retryInfo = '';
        if ($placeholders['run_retry_count'] > 0) {
            $retryInfo = "<p><strong>Retry attempt:</strong> {$placeholders['run_retry_count']}</p>";
        }

        $message = <<<HTML
<p>Hi there,</p>

<p>An error occurred running <code>{$placeholders['task_namespace']} :: {$placeholders['task_reference']}</code>, run {$placeholders['run_id']}, on {$placeholders['site_name']}.</p>

<p><strong>Executed at:</strong> {$placeholders['executed_on']}</p>
{$retryInfo}
HTML;

        if (!empty($placeholders['run_message'])) {
            $message .= '<p><strong>Message:</strong></p><blockquote>' . htmlspecialchars($placeholders['run_message']) . '</blockquote>';
        }

        if (!empty($placeholders['run_errors'])) {
            $message .= '<p><strong>Errors:</strong></p><pre><code>' . htmlspecialchars($placeholders['run_errors_formatted']) . '</code></pre>';
        }

        return $message;
    }

    /**
     * Replace placeholders in string
     *
     * @param string $string
     * @param array $placeholders
     * @return string
     */
    protected function parsePlaceholders(string $string, array $placeholders): string
    {
        foreach ($placeholders as $key => $value) {
            if (is_string($value) || is_numeric($value)) {
                $string = str_replace('[[+' . $key . ']]', $value, $string);
            }
        }
        return $string;
    }
}
