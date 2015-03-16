<?php

// paths
// =========================================================

// main paths
define('APP_PATH', __DIR__.'/');
define('ROOT_PATH', __DIR__.'/../');

// root paths
define('TEMP_PATH', ROOT_PATH.'temp/');
define('ASSETS_PATH', ROOT_PATH.'assets/');
define('DATA_PATH', ROOT_PATH.'data/');
define('VENDOR_PATH', ROOT_PATH.'vendor/');

// app paths
define('CONFIG_PATH', APP_PATH.'config/');
define('VIEWS_PATH', APP_PATH.'views/');
define('LANG_PATH', APP_PATH.'lang/');

// temp paths
define('CACHE_PATH', TEMP_PATH.'cache/');
define('LOGS_PATH', TEMP_PATH.'logs/');
define('SESSIONS_PATH', TEMP_PATH.'sessions/');
define('UPLOADS_PATH', TEMP_PATH.'uploads/');


// environment
// =========================================================
define('ENVIRONMENT', getenv('ENVIRONMENT') ?: 'development');
require CONFIG_PATH.'constants.'.ENVIRONMENT.'.php';
require CONFIG_PATH.'constants.all.php';

// composer
// =========================================================
require VENDOR_PATH.'autoload.php'; // composer

// laravel
// =========================================================

// ex-autoload.php
// ----------------------------------------------------------
define('LARAVEL_START', microtime(true));

// setup Patchwork UTF-8 Handling
Patchwork\Utf8\Bootup::initMbstring();

// register The Laravel Auto Loader
Illuminate\Support\ClassLoader::register();

// register The Workbench Loaders
if (is_dir($workbench = __DIR__.'/../workbench')) {
	Illuminate\Workbench\Starter::start($workbench);
}

// ex-start.php
// ----------------------------------------------------------

// new Laravel application instance
$app = new Illuminate\Foundation\Application;

$env = $app->detectEnvironment(function() {
	return ENVIRONMENT;
});

// binding the paths configured in paths.php
$app->bindInstallPaths([
	'app'     => APP_PATH,
	'base'    => APP_PATH,
	'public'  => ROOT_PATH.'/public',
	'storage' => TEMP_PATH
]);

// load the Illuminate application: 
$framework = VENDOR_PATH.'laravel/framework/src';
require $framework.'/Illuminate/Foundation/start.php';

// global functions / objects
// =========================================================
$GLOBALS['translate'] = new \Yeb\Laravel\Translate();

function __($text)
{
	return vsprintf($GLOBALS['translate']->zendTranslate->translate($text), array_slice(func_get_args(), 1));
}

// run laravel app: ex-index.php
// =========================================================
if ( !defined('ARTISAN') and !defined('TESTING') ) {
	$app->run();
	$app->shutdown();

// testing
} else {
	return $app;
}
