<?php
/**
 * Scheduler
 *
 * Copyright 2013 by Mark Hamstra <support@modmore.com>
 *
 * This file is part of Scheduler.
 *
 * @package scheduler
 */

class Scheduler
{
    /**
     * @var \modX $modx
     */
    public $modx;
    /**
     * Array of configuration options, primarily paths.
     *
     * @var array
     */
    public $config = array();
    /**
     * xPDO Cache Manager configuration
     *
     * @var array
     */
    public $cacheOptions = array(
        xPDO::OPT_CACHE_KEY => 'scheduler',
    );

    /**
     * @param \modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = array())
    {
        $this->modx =& $modx;

        $basePath = $this->modx->getOption(
            'scheduler.core_path',
            $config,
            $this->modx->getOption('core_path') . 'components/scheduler/'
        );
        $assetsUrl = $this->modx->getOption(
            'scheduler.assets_url',
            $config,
            $this->modx->getOption('assets_url') . 'components/scheduler/'
        );
        $assetsPath = $this->modx->getOption(
            'scheduler.assets_path',
            $config,
            $this->modx->getOption('assets_path') . 'components/scheduler/'
        );
        $this->config = array_merge(
            array(
                'basePath' => $basePath,
                'corePath' => $basePath,
                'modelPath' => $basePath . 'model/',
                'processorsPath' => $basePath . 'processors/',
                'elementsPath' => $basePath . 'elements/',
                'templatesPath' => $basePath . 'templates/',
                'assetsPath' => $assetsPath,
                'assetsUrl' => $assetsUrl,
                'jsUrl' => $assetsUrl . 'js/',
                'cssUrl' => $assetsUrl . 'css/',
                'connectorUrl' => $assetsUrl . 'connector.php',
            ),
            $config
        );

        //$this->modx->lexicon->load('scheduler:default');

        $modelPath = $this->config['modelPath'];
        $this->modx->addPackage('scheduler', $modelPath);
        $this->modx->loadClass('sTask', $modelPath.'scheduler/');
    }


    /**
     *
     *
     *
     *  $scheduler->addTask(
     *      'login', // namespace
     *      'remindverify', // task
     *      '+ 1 week', // timestamp (relative)
     *      'test/random.php', // content
     *      array(...), // data
     *      'Performs a random task.', // Summary for the user
     *      'foo', // reference id (calculated md5 if not set)
     *      //sTask::RUN_SNIPPET, // To indicate it's a snippet-based task
     *  );
     *
     */
    public function setTask($namespace, $task, $timestamp, $content, array $data = array(), $summary = '', $referenceId = null, $type = sTask::RUN_FILE) {
        $reference = $namespace . '-' . $task . '-';
        if (!empty($referenceId)) $reference .= $referenceId;
        else $reference .= md5($this->modx->toJSON($data));

        /**
         * @var sTask $task
         */
        $task = $this->modx->newObject('sTask');
        $task->set('reference', $reference);
        $task->set('status', sTask::STATUS_PENDING);
        $task->set('type', $type);

        if (!is_numeric($timestamp)) {
            $timestamp = strtotime($timestamp);
        }
        $task->set('executeon', $timestamp);

        $task->set('content', $content);
        $task->set('data', $data);
        $task->set('namespace', $namespace);
        $task->set('task', $task);
        $task->set('summary', $summary);

        return $task->save();
    }

    /**
     * Transforms the value into entities, and also escapes [, ] and ` to allow using
     * HTML and MODX tags without getting parsed.
     *
     * @param $value
     *
     * @return string
     */
    public function escape($value) 
    {
        return str_replace(array(
                '[', ']', '`'
            ), array(
                '&#91;', '&#93;', '&#96;'
            ), htmlentities($value, ENT_QUOTES, $this->modx->getOption('modx_charset', null, 'UTF-8'))
        );
    }
}

