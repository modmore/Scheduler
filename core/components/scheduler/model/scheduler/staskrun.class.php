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

}
