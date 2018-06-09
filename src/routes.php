<?php
// require_once __DIR__ . '/../vendor/RedBeanPHP5_1_0/rb.php';
// require_once __DIR__ . '/../src/controllers/romsync.controller.php';
// require_once __DIR__ . '/../src/controllers/auth.controller.php';
// require_once __DIR__ . '/../src/controllers/gamesdb.controller.php';
// require_once __DIR__ . '/../src/controllers/youtube.controller.php';
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->add(function (Request $request, Response $response, callable $next) {
    $route = $request->getAttribute('route');
    $this->logger->info($request->getMethod() . ' ' . $route->getPattern(), [$route->getArguments()]);
    
    $response = $next($request, $response);

    $this->logger->info($response->getStatusCode() . ' ' . $response->getReasonPhrase());

    return $response->withHeader('Access-Control-Allow-Origin', '*');
});
$app->add(function($request, $response, $next) {
    $logger = $this->get("logger");
    try {
      return $next($request, $response);
    }
    catch(\App\Exceptions\AppException $e)
    {
      $logger->addCritical('Application Error: ' . $e->getMessage());
      return $response->withJson([
        'status' => 'error',
        'data' => $e->getData(),
        'message' => $e->getMessage()
      ]);
    }
    catch(\Exception $e)
    {
      $logger->addCritical('Unhandled Exception: ' . $e->getMessage());
    //   $container->SMSService->send(getenv('ADMIN_MOBILE'), "Shit has hit the fan! Run to your computer and check the error logs. Beep. Boop.");
      return $response->withJson([
        'status' => 'error',
        'data' => null,
        'message' => 'It is not possible to perform this action right now'
      ]);
    }
  });
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


