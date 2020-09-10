<?php
require_once 'filesystem.php';

spl_autoload_register(function($className) {
  $parts = explode('\\', $className);

  $file = realpath(__DIR__ . '//../') . DIRECTORY_SEPARATOR . strtolower(array_shift($parts)) . '\\' . join('\\', $parts) . '.php';

  require_once $file;
});

require_once 'app.php';

$serverType = 'default';

if(isset($_SERVER['SERVER_SOFTWARE'])) {
  $serverData = explode('/', $_SERVER['SERVER_SOFTWARE']);

  $serverType = $serverData[0];
}


$app = Core\Providers\AppProvider::createApp($serverType);

require_once 'helpers.php';

require_once config_path('routes.php');

require_once config_path('extensions.php');