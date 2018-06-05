<?php
// require_once __DIR__ . '/../vendor/RedBeanPHP5_1_0/rb.php';
// require_once __DIR__ . '/../src/controllers/romsync.controller.php';
// require_once __DIR__ . '/../src/controllers/auth.controller.php';
// require_once __DIR__ . '/../src/controllers/gamesdb.controller.php';
// require_once __DIR__ . '/../src/controllers/youtube.controller.php';

// Routes
$app->get('/', "\RomsyncController:index");
$app->get('/404', "\RomsyncController:error");
$app->get('/login', "\AuthController:loginPage");

$app->group('/api', function () use ($app) {
    $app->get('/games', "\RomsyncController:games");
    $app->get('/systems', "\RomsyncController:systems");
    $app->get('/years', "\RomsyncController:years");
    $app->get('/decades', "\RomsyncController:decades");
    $app->get('/download/{path}/{filename}', "\RomsyncController:download");
    $app->get('/image/{filename}', "\RomsyncController:image");
    $app->group('/gamesdb', function () use ($app) {
        $app->get('/search', "\GamesDBController:search");
    });
    $app->group('/youtube', function () use ($app) {
        $app->get('/search', "\YoutubeController:search");
    });
});
$app->group('/auth', function () use ($app) {
    $app->post('/login', "\AuthController:login");
    $app->get('/logout', "\AuthController:logout");
});


