<?php
/**
 * Gets a list of sTask objects.
 */
class sTaskGetHistoricalListProcessor extends modObjectGetListProcessor {
    public $classKey = 'sTask';
    public $languageTopics = array('scheduler:default');
    public $defaultSortField = 'executeon';
    public $defaultSortDirection = 'DESC';

    /**
     * Only load variations for current test.
     *
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c->where(array(
            'status:!=' => sTask::STATUS_PENDING,
        ));
        return $c;
    }

    public function prepareRow(xPDOObject $object) {
        $array = $object->toArray();

        if (!empty($array['errors'])) {
            $errors = array();
            foreach ($array['errors'] as $e) {
                $error = array();
                foreach ($e as $key => $value) {
                    if (in_array($key, array('type', 'timestamp'))) continue;
                    $error[] = '<li><b>' . $key . '</b>: ' . $value . '</li>';
                }
                $error = '<h4>' . $e['type'] . ' - ' . date('Y-m-d H:i:s', $e['timestamp']) . '</h4>'
                    . '<ul class="scheduler-list">' . implode('', $error) . '</ul>';
                $errors[] = $error;
            }
            $array['errors'] = implode('', $errors);
        }
        else {
            $array['errors'] = '';
        }

        return $array;
    }
}
return 'sTaskGetHistoricalListProcessor';
