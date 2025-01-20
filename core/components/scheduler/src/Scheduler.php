<?php

namespace Scheduler;

use MODX\Revolution\modX;
use Scheduler\Model\sTask;
use xPDO\xPDO;

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
    public function __construct(modX $modx, array $config = array())
    {
        $this->modx = $modx;

        $basePath = $this->modx->getOption('scheduler.core_path', $config, $this->modx->getOption('core_path') . 'components/scheduler/');
        $assetsUrl = $this->modx->getOption('scheduler.assets_url', $config, $this->modx->getOption('assets_url') . 'components/scheduler/');
        $assetsPath = $this->modx->getOption('scheduler.assets_path', $config, $this->modx->getOption('assets_path') . 'components/scheduler/');
        $managerUrl = $this->modx->getOption('manager_url', $config, $this->modx->getOption('base_url') . 'manager/');

        $this->config = array_merge(array(
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
            'managerUrl' => $managerUrl,
            'hideLogo' => $this->modx->getOption('scheduler.hideLogo', null, false),
        ), $config);
    }

    /**
     * Gets a task by its ID or namespace and reference
     *
     * @param string|int $namespaceOrId
     * @param string $reference
     * @return null|sTask
     */
    public function getTask($namespaceOrId, $reference = '')
    {
        if (is_numeric($namespaceOrId) && empty($reference)) {
            $condition = $namespaceOrId;
        }
        else {
            $condition = array(
                'namespace' => $namespaceOrId,
                'reference' => $reference,
            );
        }
        return $this->modx->getObject(sTask::class, $condition);
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
