<?php
/* Get the core config */
if (!file_exists(dirname(dirname(__FILE__)).'/config.core.php')) {
    die('ERROR: missing '.dirname(dirname(__FILE__)).'/config.core.php file defining the MODX core path.');
}

echo "<pre>";
/* Boot up MODX */
echo "Loading modX...\n";
require_once dirname(dirname(__FILE__)).'/config.core.php';
require_once MODX_CORE_PATH.'model/modx/modx.class.php';
$modx = new modX();
echo "Initializing manager...\n";
$modx->initialize('mgr');
$modx->getService('error','error.modError', '', '');

$componentPath = dirname(dirname(__FILE__));

$Scheduler = $modx->getService('scheduler','Scheduler', $componentPath.'/core/components/scheduler/model/scheduler/', array(
    'scheduler.core_path' => $componentPath.'/core/components/scheduler/',
));


/* Namespace */
if (!createObject('modNamespace',array(
    'name' => 'scheduler',
    'path' => $componentPath.'/core/components/scheduler/',
    'assets_path' => $componentPath.'/assets/components/scheduler/',
),'name', false)) {
    echo "Error creating namespace scheduler.\n";
}

/* Path settings */
if (!createObject('modSystemSetting', array(
    'key' => 'scheduler.core_path',
    'value' => $componentPath.'/core/components/scheduler/',
    'xtype' => 'textfield',
    'namespace' => 'scheduler',
    'area' => 'Paths',
    'editedon' => time(),
), 'key', false)) {
    echo "Error creating scheduler.core_path setting.\n";
}

if (!createObject('modSystemSetting', array(
    'key' => 'scheduler.assets_path',
    'value' => $componentPath.'/assets/components/scheduler/',
    'xtype' => 'textfield',
    'namespace' => 'scheduler',
    'area' => 'Paths',
    'editedon' => time(),
), 'key', false)) {
    echo "Error creating scheduler.assets_path setting.\n";
}

/* Fetch assets url */
$url = 'http';
if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) {
    $url .= 's';
}
$url .= '://'.$_SERVER["SERVER_NAME"];
if ($_SERVER['SERVER_PORT'] != '80') {
    $url .= ':'.$_SERVER['SERVER_PORT'];
}
$requestUri = $_SERVER['REQUEST_URI'];
$bootstrapPos = strpos($requestUri, '_bootstrap/');
$requestUri = rtrim(substr($requestUri, 0, $bootstrapPos), '/').'/';
$assetsUrl = "{$url}{$requestUri}assets/components/scheduler/";

if (!createObject('modSystemSetting', array(
    'key' => 'scheduler.assets_url',
    'value' => $assetsUrl,
    'xtype' => 'textfield',
    'namespace' => 'scheduler',
    'area' => 'Paths',
    'editedon' => time(),
), 'key', false)) {
    echo "Error creating scheduler.assets_url setting.\n";
}


if (!createObject('modMenu', array(
    'text' => 'scheduler',
    'parent' => 'components',
    'description' => 'scheduler.menu_desc',
    'icon' => 'images/icons/plugin.gif',
    'menuindex' => '0',
    'action' => 'index',
    'namespace' => 'scheduler',
), 'text', false)) {
    echo "Error creating menu.\n";
}
$manager = $modx->getManager();

/* Create the tables */
$objectContainers = array(
    'sTask',
    'sTaskRun',
);
echo "Creating tables...\n";

foreach ($objectContainers as $oC) {
    $manager->createObjectContainer($oC);
}

$modx->getCacheManager()->refresh();
echo "Done.\n";


/**
 * Creates an object.
 *
 * @param string $className
 * @param array $data
 * @param string $primaryField
 * @param bool $update
 * @return bool
 */
function createObject ($className = '', array $data = array(), $primaryField = '', $update = true) {
    global $modx;
    /* @var xPDOObject $object */
    $object = null;

    /* Attempt to get the existing object */
    if (!empty($primaryField)) {
        $object = $modx->getObject($className, array($primaryField => $data[$primaryField]));
        if ($object instanceof $className) {
            if ($update) {
                $object->fromArray($data);
                return $object->save();
            } else {
                echo "Skipping {$className} {$data[$primaryField]}: already exists.\n";
                return true;
            }
        }
    }

    /* Create new object if it doesn't exist */
    if (!$object) {
        $object = $modx->newObject($className);
        $object->fromArray($data, '', true);
        return $object->save();
    }

    return false;
}
