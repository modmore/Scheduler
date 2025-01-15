<?php

namespace Scheduler\Model;

use MODX\Revolution\Mail\modMail;
use MODX\Revolution\Mail\modPHPMailer;
use MODX\Revolution\modNamespace;
use MODX\Revolution\modX;
use xPDO\xPDO;
use xPDO\Om\xPDOSimpleObject;

class sTask extends xPDOSimpleObject
{
    /**
     * @param int|string $when
     * @param array $data
     * @return false|sTaskRun
     */
    public function schedule(int|string $when, array $data = [])
    {

        /** @var sTaskRun $run */
        $run = $this->xpdo->newObject(sTaskRun::class);
        $run->fromArray([
            'task' => $this->get('id'),
            'data' => $data,
        ]);
        $run->setTiming($when);

        if ($run->save()) {
            return $run;
        }
        return false;
    }

    /**
     * @param sTaskRun $run
     * @return sTask $this
     */
    public function run($run)
    {
        // Set status to executing (and save) so other triggers don't also run this one
        $run->set('status', sTaskRun::STATUS_EXECUTING);
        $run->save();

        // Run the task
        try {
            $return = $this->_run($run);
        } catch (\Exception $e) {
            $run->addError(get_class($e), [
                'exception' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            $return = '';
        } catch (\Error $e) {
            $run->addError(get_class($e), [
                'exception' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            $return = '';
        }

        // All done! Update status, completed date and save.
        $run->set('status', $run->hasErrors() ? sTaskRun::STATUS_FAILURE : sTaskRun::STATUS_SUCCESS);
        $run->set('message', $return);
        $run->set('executedon', time());
        $run->save();

        if ($run->hasErrors()) {
            $this->notifyFailure($run);
        }

        return $this;
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
    protected function _run($run)
    {
        $run->addError('stask_direct_run_failure', [
            'message' => 'Not allowed to run the sTask::_run() method directly!',
        ]);
        return false;
    }

    protected function notifyFailure(sTaskRun $run)
    {
        $recipients = $this->xpdo->getOption('scheduler.email_failure');
        $recipients = array_filter(array_map('trim', explode(',', $recipients)));
        if (count($recipients) === 0) {
            return;
        }

        $task = $run->getOne('Task');
        if (!$task) {
            $this->xpdo->log(xPDO::LOG_LEVEL_ERROR, 'Error notifying about failed task; could not find task for run ' . $run->get('id'));
            return;
        }

        $message = <<<HTML
<p>Hi there,</p>

<p>An error occurred running <code>{$task->get('namespace')} :: {$task->get('reference')}</code>, run {$run->get('id')}, on {$this->xpdo->getOption('site_name')}.</p>
HTML;

        if ($msg = $run->get('message')) {
            $message .= '<blockquote>' . $msg . '</blockquote>';
        }

        if ($run->hasErrors()) {
            $errors = $run->get('errors');
            $message .= '<p>Errors:</p><pre><code>' . print_r($errors, true) . '</code></pre>';
        }

        $mail = new modPHPMailer($this->xpdo);
        $mail->set(modMail::MAIL_BODY, $message);
        $mail->set(modMail::MAIL_FROM, $this->xpdo->getOption('emailsender'));
        $mail->set(modMail::MAIL_FROM_NAME, 'Scheduler at ' . $this->xpdo->getOption('site_name'));
        $mail->set(modMail::MAIL_SUBJECT, "Error running {$task->get('namespace')} :: {$task->get('reference')}");
        foreach ($recipients as $recipient) {
            $mail->address('to', $recipient);
        }
        $mail->setHTML(true);
        if (!$mail->send()) {
            $this->xpdo->log(modX::LOG_LEVEL_ERROR, 'An error occurred while trying to send email: ' . $mail->mailer->ErrorInfo);
        }
        $mail->reset();
    }
}
