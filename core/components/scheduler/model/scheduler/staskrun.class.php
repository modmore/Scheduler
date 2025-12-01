<?php
/**
 * Class sTaskRun
 *
 * @package Scheduler
 *
 * @property int $id
 * @property int $status
 * @property int $task
 * @property int $timing
 * @property array $data
 * @property string $task_key
 * @property int $retry_count
 * @property int $executedon
 * @property float $processing_time
 * @property array $errors
 * @property string $message
 */
class sTaskRun extends xPDOSimpleObject
{
    const STATUS_SCHEDULED = 0;
    const STATUS_EXECUTING = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_FAILURE = 3;

    /**
     * Adds an error to the error stack
     *
     * @param string $type
     * @param array $details
     */
    public function addError($type, array $details = array())
    {
        $errors = $this->get('errors');
        if (!is_array($errors) || empty($errors)) $errors = array();

        $errors[] = array_merge(array(
            'type' => $type,
            'timestamp' => microtime(true),
        ), $details);

        $this->set('errors', $errors);
    }

    /**
     * Check if this task has any errors.
     *
     * @return bool
     */
    public function hasErrors() {
        $errors = $this->get('errors');
        if (is_array($errors) && !empty($errors)) return true;
        return false;
    }

    /**
     * Schedules task run based on timing
     *
     * @param mixed $when Unix timestamp, strtotime string, or relative time like '+5 minutes'
     * @param bool $roundUp Round up to next minute (only if seconds > 0)
     * @return bool
     */
    public function setTiming($when, $roundUp = true)
    {
        // Convert string to timestamp if needed
        if (is_string($when)) {
            $when = strtotime($when);
        }

        if ($when === false || $when <= 0) {
            return false;
        }

        // Cron only works with minutes, not seconds
        // Round up only if there are seconds (not 00)
        $seconds = (int) date('s', $when);

        if ($seconds > 0 && $roundUp) {
            // Round up to next minute
            $when = strtotime(date('Y-m-d H:i:00', $when)) + 60;
        } else {
            // Strip seconds without rounding up
            $when = strtotime(date('Y-m-d H:i:00', $when));
        }

        $this->set('timing', $when);
        return true;
    }
}
