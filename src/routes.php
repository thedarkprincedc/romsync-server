<?php
// Routes
$app->get('/', "\RomsyncController:index");
$app->group('/api', function () use ($app) {
    $app->get('/games', "\RomsyncController:games");
    $app->get('/systems', "\RomsyncController:systems");
    $app->get('/years', "\RomsyncController:years");
    $app->get('/decades', "\RomsyncController:decades");
});
// $app->get('/', function ($request, $response, $args) {
//     // Sample log message
//     $this->logger->info("Slim-Skeleton '/' route");
//     $args["version"] = "2.0.2";
//     // $args["dbstatus"] = ($this->pdo!==null)?DBSTATUS_OK:DBSTATUS_FAILED;
//     // $args["serverip"] = $_SERVER["SERVER_ADDR"];
//     // Render index view
//     return $this->renderer->render($response, 'index.phtml', $args);
// });
/*$app->get('/images/[{name}]', function ($request, $response, $args) {
     $data = $args['name'];
       $image = @file_get_contents("images/{$data}.jpg");
       if($image === FALSE) {
           $handler = $this->notFoundHandler;
           return $handler($request, $response);
       }
    $response->write($image);
    return $response->withHeader('Content-Type', FILEINFO_MIME_TYPE);
});*/

// $app->group('/api2', function () use ($app) {
//     $app->get('/games[/{query}]', "\RSController:search");
//     $app->get('/resource-directory',"\RSController:resourcedirectory");
// });
// $app->group('/api', function () use ($app) {
//      $app->map(['HEAD', 'GET'], '/state', "\RSController:isDbInit");
//      $app->get('/images', "\RSController:getImages");
//      $app->get('/login', "\AuthController:login");
//      $app->get('/validate', "\AuthController:tokenValidate");
//      $app->get('/logout', "\AuthController:logout");
//      $app->get('/search[/{query}]', "\RSController:search");
//      $app->get('/searchyoutube[/{query}]', "\RSController:searchyoutube");
//      $app->get('/getyears', "\RSController:getyears");
//      $app->get('/getdecades', "\RSController:getdecades");
//      $app->get('/getsystems', "\RSController:getsystems");
//      $app->get('/downloadgame/{query}', "\RSController:downloadgame");
//      $app->get('/sync', "\RSController:sync");
//      $app->get('/getsyncstatus', "\RSController:getsyncstatus");
//      $app->get('/resource-directory',"\RSController:resourcedirectory");
//      $app->get('/info', "\RSController:info");
//      $app->get('/infophp', "\RSController:infophp");
//      $app->get('/isDbInit', "\RSController:checkIfDatabaseInit");
//      $app->get('/getGamesDbNetGameList', "\RSController:getGamesDbNetGameList");
//      $app->get('/getGamesDbNetGame', "\RSController:getGamesDbNetGame");
// })->add(function ($request, $response, $next) {
//     //$response->withStatus(400);
//      $response = $next($request, $response);
//      $uriString = $request->getUri()->getPath();
//      $this->logger->info("Slim-Skeleton '{$uriString}' route");
//      $token = ($_SERVER["HTTP_X_AUTHTOKEN"]) ? $_SERVER["HTTP_X_AUTHTOKEN"] : $args["auth-token"];
//      //if(validateUserToken($token)){
//      //    $response = $next($request, $response);
//      //}
//     // die();
     
//      return $response;
//     //  ->withHeader('Access-Control-Allow-Origin', '*')
//     //  ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
//     //  ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
// });
