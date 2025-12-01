<?php
/**
 * Requirements validator for Scheduler
 * Supports both MODX 2.x and MODX 3.x
 *
 * @var xPDO|modX $modx
 * @var array $options
 */
$modx =& $transport->xpdo;

// Detect MODX version for proper constant usage
$isModx3 = class_exists('MODX\Revolution\modX');

// Use appropriate constants based on MODX version
if ($isModx3) {
    $logLevelInfo = \xPDO\xPDO::LOG_LEVEL_INFO;
    $logLevelWarn = \xPDO\xPDO::LOG_LEVEL_WARN;
    $logLevelError = \xPDO\xPDO::LOG_LEVEL_ERROR;
    $actionInstall = \xPDO\Transport\xPDOTransport::ACTION_INSTALL;
    $actionUpgrade = \xPDO\Transport\xPDOTransport::ACTION_UPGRADE;
    $actionUninstall = \xPDO\Transport\xPDOTransport::ACTION_UNINSTALL;
    $packageAction = \xPDO\Transport\xPDOTransport::PACKAGE_ACTION;
} else {
    $logLevelInfo = xPDO::LOG_LEVEL_INFO;
    $logLevelWarn = xPDO::LOG_LEVEL_WARN;
    $logLevelError = xPDO::LOG_LEVEL_ERROR;
    $actionInstall = xPDOTransport::ACTION_INSTALL;
    $actionUpgrade = xPDOTransport::ACTION_UPGRADE;
    $actionUninstall = xPDOTransport::ACTION_UNINSTALL;
    $packageAction = xPDOTransport::PACKAGE_ACTION;
}

if (!function_exists('checkSchedulerVersion')) {
    /**
     * @param string $description
     * @param string $current
     * @param array $definition
     * @param modX $modx
     * @param int $logLevelInfo
     * @param int $logLevelWarn
     * @param int $logLevelError
     * @return bool
     */
    function checkSchedulerVersion($description, $current, array $definition, $modx, $logLevelInfo, $logLevelWarn, $logLevelError)
    {
        $pass = true;
        $passGlyph = '✔';
        $failGlyph = '×';
        $warnGlyph = '⚠';

        // Determine the minimum version (the one that we require today) and the recommended version
        $realMinimum = false;
        $recommended = false;
        $recommendedDate = false;
        foreach ($definition as $date => $minVersion) {
            $date = strtotime($date);
            if ($date <= time()) {
                $realMinimum = $minVersion;
            }
            if ($date <= time() + (60 * 60 * 24 * 270)) {
                $recommended = $minVersion;
                $recommendedDate = $date;
            }
        }

        if ($realMinimum) {
            $level = $logLevelInfo;
            $glyph = $passGlyph;
            if (version_compare($current, $realMinimum . '.0') < 0) {
                $level = $logLevelError;
                $pass = false;
                $glyph = $failGlyph;
            }
            $modx->log($level, "- {$description} {$realMinimum}+ (minimum): {$glyph} {$current}");
        }
        if ($pass && $recommended) {
            $level = $logLevelInfo;
            $glyph = $passGlyph;
            if (version_compare($current, $recommended . '.0') < 0) {
                $level = $logLevelWarn;
                $glyph = $warnGlyph;
            }
            $recommendedDateFormatted = date('Y-m-d', $recommendedDate);
            $modx->log($level, "- {$description} {$recommended}+ (minimum per {$recommendedDateFormatted}): {$glyph} {$current}");
        }

        return $pass;
    }
}

$success = false;
switch ($options[$packageAction]) {
    case $actionInstall:
    case $actionUpgrade:
        $success = true;
        $modx->log($logLevelInfo, 'Checking if the minimum requirements are met...');

        $modxVersion = $modx->getVersionData();

        // Check MODX version - support both 2.7+ and 3.0+
        if (!checkSchedulerVersion('MODX', $modxVersion['full_version'], [
            '2019-11-27 12:00:00' => '2.7',
            '2024-01-01 12:00:00' => '2.8',
        ], $modx, $logLevelInfo, $logLevelWarn, $logLevelError)) {
            $success = false;
        }

        // Check PHP version - updated requirements for 2024+
        if (!checkSchedulerVersion('PHP', PHP_VERSION, [
            '2019-07-01 12:00:00' => '7.1',
            '2020-03-01 12:00:00' => '7.2',
            '2020-11-30 12:00:00' => '7.3',
            '2022-01-01 12:00:00' => '7.4',
            '2023-01-01 12:00:00' => '8.0',
            '2024-01-01 12:00:00' => '8.1',
        ], $modx, $logLevelInfo, $logLevelWarn, $logLevelError)) {
            $success = false;
        }

        if ($success) {
            $modx->log($logLevelInfo, 'Requirements look good!');
        } else {
            $modx->log($logLevelError, 'Unfortunately, the minimum requirements aren\'t met. Installation cannot continue.');
        }

        break;
    case $actionUninstall:
        $success = true;
        break;
}
return $success;