<?php

/**
 * Scheduler Build Script for MODX 3
 *
 * @package scheduler
 */

$tstart = explode(' ', microtime());
$tstart = $tstart[1] + $tstart[0];
set_time_limit(0);

if (!defined('MOREPROVIDER_BUILD')) {
    /* define version */
    define('PKG_NAME', 'Scheduler');
    define('PKG_NAME_LOWER', strtolower(PKG_NAME));
    define('PKG_VERSION', '1.9.0');
    define('PKG_RELEASE', 'pl');

    /* load modx 3 */
    require_once dirname(dirname(__FILE__)) . '/config.core.php';
    require_once MODX_CORE_PATH . 'vendor/autoload.php';

    $modx = new \MODX\Revolution\modX();
    $modx->initialize('mgr');
    $modx->setLogLevel(\MODX\Revolution\modX::LOG_LEVEL_INFO);
    $modx->setLogTarget('ECHO');

    echo '<pre>';
    flush();
    $targetDirectory = dirname(dirname(__FILE__)) . '/_packages/';
} else {
    $targetDirectory = MOREPROVIDER_BUILD_TARGET;
}

/* define build paths */
$root = dirname(dirname(__FILE__)) . '/';
$sources = [
    'root' => $root,
    'build' => $root . '_build/',
    'data' => $root . '_build/data/',
    'validators' => $root . '_build/validators/',
    'resolvers' => $root . '_build/resolvers/',
    'chunks' => $root . 'core/components/' . PKG_NAME_LOWER . '/elements/chunks/',
    'snippets' => $root . 'core/components/' . PKG_NAME_LOWER . '/elements/snippets/',
    'plugins' => $root . 'core/components/' . PKG_NAME_LOWER . '/elements/plugins/',
    'lexicon' => $root . 'core/components/' . PKG_NAME_LOWER . '/lexicon/',
    'docs' => $root . 'core/components/' . PKG_NAME_LOWER . '/docs/',
    'elements' => $root . 'core/components/' . PKG_NAME_LOWER . '/elements/',
    'source_assets' => $root . 'assets/components/' . PKG_NAME_LOWER . '/',
    'source_core' => $root . 'core/components/' . PKG_NAME_LOWER . '/',
];
unset($root);

/* create package builder */
$builder = new \MODX\Revolution\Transport\modPackageBuilder($modx);
$builder->directory = $targetDirectory;
$builder->createPackage(PKG_NAME_LOWER, PKG_VERSION, PKG_RELEASE);
$builder->registerNamespace(
    PKG_NAME_LOWER,
    false,
    true,
    '{core_path}components/' . PKG_NAME_LOWER . '/',
    '{assets_path}components/' . PKG_NAME_LOWER . '/'
);

/* add core files */
$modx->log(\MODX\Revolution\modX::LOG_LEVEL_INFO, 'Packaging core files...');
$builder->package->put(
    [
        'source' => $sources['source_core'],
        'target' => "return MODX_CORE_PATH . 'components/';",
    ],
    [
        'vehicle_class' => \xPDO\Transport\xPDOFileVehicle::class,
        'validate' => [
            [
                'type' => 'php',
                'source' => $sources['validators'] . 'requirements.script.php'
            ]
        ]
    ]
);

/* add assets files */
$modx->log(\MODX\Revolution\modX::LOG_LEVEL_INFO, 'Packaging assets files...');
$builder->package->put(
    [
        'source' => $sources['source_assets'],
        'target' => "return MODX_ASSETS_PATH . 'components/';",
    ],
    [
        'vehicle_class' => \xPDO\Transport\xPDOFileVehicle::class,
    ]
);

/* menu action */
$modx->log(\MODX\Revolution\modX::LOG_LEVEL_INFO, 'Packaging in menu...');
$menu = $modx->newObject(\MODX\Revolution\modMenu::class);
$menu->fromArray([
    'text' => PKG_NAME_LOWER,
    'parent' => 'components',
    'description' => PKG_NAME_LOWER . '.menu_desc',
    'icon' => '<i class="icon icon-large icon-calendar"></i>',
    'menuindex' => 0,
    'params' => '',
    'handler' => '',
    'permissions' => '',
    'namespace' => PKG_NAME_LOWER,
    'action' => 'index',
], '', true, true);

if (empty($menu)) {
    $modx->log(\MODX\Revolution\modX::LOG_LEVEL_ERROR, 'Could not package in menu.');
}

$vehicle = $builder->createVehicle($menu, [
    \xPDO\Transport\xPDOTransport::PRESERVE_KEYS => true,
    \xPDO\Transport\xPDOTransport::UPDATE_OBJECT => true,
    \xPDO\Transport\xPDOTransport::UNIQUE_KEY => 'text',
    \xPDO\Transport\xPDOTransport::RELATED_OBJECTS => true,
]);

$modx->log(\MODX\Revolution\modX::LOG_LEVEL_INFO, 'Adding resolvers...');
$vehicle->resolve('php', ['source' => $sources['resolvers'] . 'resolve.tables.php']);
$vehicle->resolve('php', ['source' => $sources['resolvers'] . 'resolve.dbchanges.php']);
$builder->putVehicle($vehicle);
unset($vehicle, $menu);

/* system settings */
$modx->log(\MODX\Revolution\modX::LOG_LEVEL_INFO, 'Adding settings...');
$settingSource = include $sources['data'] . 'settings.php';
$settings = [];

foreach ($settingSource as $key => $options) {
    $val = $options['value'];

    if (isset($options['xtype'])) {
        $xtype = $options['xtype'];
    } elseif (is_int($val)) {
        $xtype = 'numberfield';
    } elseif (is_bool($val)) {
        $xtype = 'modx-combo-boolean';
    } else {
        $xtype = 'textfield';
    }

    $setting = $modx->newObject(\MODX\Revolution\modSystemSetting::class);
    $setting->fromArray([
        'key' => 'scheduler.' . $key,
        'xtype' => $xtype,
        'value' => $options['value'],
        'namespace' => PKG_NAME_LOWER,
        'area' => $options['area'],
        'editedon' => time(),
    ], '', true, true);

    $vehicle = $builder->createVehicle($setting, [
        \xPDO\Transport\xPDOTransport::UNIQUE_KEY => 'key',
        \xPDO\Transport\xPDOTransport::PRESERVE_KEYS => true,
        \xPDO\Transport\xPDOTransport::UPDATE_OBJECT => false,
    ]);
    $builder->putVehicle($vehicle);
    $settings[] = $setting;
}
$modx->log(\MODX\Revolution\modX::LOG_LEVEL_INFO, 'Packaged in ' . count($settings) . ' system settings.');
flush();

/* zip up package */
$modx->log(\MODX\Revolution\modX::LOG_LEVEL_INFO, 'Adding package attributes...');
$builder->setPackageAttributes([
    'license' => file_get_contents($sources['docs'] . 'license.txt'),
    'readme' => file_get_contents($sources['docs'] . 'readme.txt'),
    'changelog' => file_get_contents($sources['docs'] . 'changelog.txt'),
]);

$modx->log(\MODX\Revolution\modX::LOG_LEVEL_INFO, 'Packing up transport package zip...');
$builder->pack();

$tend = explode(" ", microtime());
$tend = $tend[1] + $tend[0];
$totalTime = sprintf("%2.4f s", ($tend - $tstart));

$modx->log(\MODX\Revolution\modX::LOG_LEVEL_INFO, "Package Built. Execution time: {$totalTime}\n");
$modx->log(\MODX\Revolution\modX::LOG_LEVEL_INFO, "\n-----------------------------\n" . PKG_NAME . " " . PKG_VERSION . "-" . PKG_RELEASE . " built\n-----------------------------");
flush();
