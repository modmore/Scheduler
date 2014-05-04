<?php
/**
 * Class sTaskRun
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
     * @param mixed $when
     * @param bool $roundUp
     * @return bool
     */
    public function setTiming($when, $roundUp=true) {
        if (strpos($when, '+') !== false || (strpos($when, '-') !== false && strpos($when, ':'))) {
            $when = strtotime($when);
        }

        // runs can only be applied on whole minutes, because the crontab cannot run in seconds
        // because of that, a time like 8:26:22 will run at 8:27:00..
        // To avoid delayed views in the manager, round it up!
        list($year, $month, $day) = explode('-', date('Y-n-j', $when));
        list($hour, $minute, $seconds) = explode(':', date('G:i:s', $when));
        $when = mktime($hour, (($roundUp) ? $minute+1 : $minute), 0, $month, $day, $year);

        $this->set('timing', $when);
        return true;
    }
}
