<?php

/**
 * The main Scheduler Manager Controller.
 */
abstract class SchedulerManagerController extends modExtraManagerController
{
    /** @var Scheduler $scheduler */
    public $scheduler = null;

    /**
     * Initializes the main manager controller.
     */
    public function initialize()
    {
        /* Instantiate the Scheduler class in the controller */
        switch ($this->modx->version['version']) {
            case 2:
                $path = $this->modx->getOption('scheduler.core_path', null, $this->modx->getOption('core_path') . 'components/scheduler/') . 'model/scheduler/';
                $this->scheduler = $this->modx->getService('scheduler', 'Scheduler', $path);
                break;
            case 3:
                if ($this->modx->services->has('scheduler')) {
                    try {
                        $this->scheduler = $this->modx->services->get('scheduler');
                    } catch (\Psr\Container\NotFoundExceptionInterface $e) {
                        $this->modx->log(modX::LOG_LEVEL_ERROR, $e->getMessage());
                    } catch (\Psr\Container\ContainerExceptionInterface $e) {
                        $this->modx->log(modX::LOG_LEVEL_ERROR, $e->getMessage());
                    }
                }
                break;
        }

        /* Add the main javascript class and our configuration */
        $this->addJavascript($this->scheduler->config['jsUrl'] . 'mgr/scheduler.class.js');
        $this->addJavascript($this->scheduler->config['jsUrl'] . 'mgr/combos.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            Scheduler.config = ' . $this->modx->toJSON($this->scheduler->config) . ';
        });
        </script>');
    }

    /**
     * Defines the lexicon topics to load in our controller.
     * @return array
     */
    public function getLanguageTopics()
    {
        return ['scheduler:default'];
    }

    /**
     * We can use this to check if the user has permission to see this
     * controller. We'll apply this in the admin section.
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }

    /**
     * The name for the template file to load.
     * @return string
     */
    public function getTemplateFile()
    {
        return $this->scheduler->config['templatesPath'] . 'mgr.tpl';
    }
}

/**
 * The Index Manager Controller is the default one that gets called when no
 * action is present.
 */
class ControllersIndexManagerController extends SchedulerManagerController
{
    /**
     * Defines the name or path to the default controller to load.
     * @return string
     */
    public static function getDefaultController()
    {
        return 'index';
    }
}
