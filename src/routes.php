<?php
// Routes
$app->get('/', "\RomsyncController:index");
$app->group('/api', function () use ($app) {
    $app->get('/games', "\RomsyncController:games");
    $app->get('/systems', "\RomsyncController:systems");
    $app->get('/years', "\RomsyncController:years");
    $app->get('/decades', "\RomsyncController:decades");
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


