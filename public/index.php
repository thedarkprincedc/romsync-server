<?php

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}
date_default_timezone_set('America/New_York');
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/RedBeanPHP5_1_0/rb.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';
require __DIR__ . '/../src/middleware/auth.middleware.php';

// Register controllers
require __DIR__ . '/../src/controllers/romsync.controller.php';
require __DIR__ . '/../src/controllers/auth.controller.php';
require __DIR__ . '/../src/controllers/gamesdb.controller.php';
require __DIR__ . '/../src/controllers/youtube.controller.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Register Controllers
/*foreach (Resolver::resolve($container, $controllers) as $controller => $callback) {
    $container[$controller] = $callback;
}*/
//print_r($app->getContainer()->get('router')->getRoutes());
// Run app
$app->run();
