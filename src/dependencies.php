<?php
// DIC configuration
use RedBeanPHP\R as R;
$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    $logger->pushHandler(new Monolog\Handler\StreamHandler('php://stdout', \Monolog\Logger::DEBUG));
    return $logger;
};

$container['mysql_sql'] = function ($c){
    $settings = $c->get('settings')["mysql"];
    $hostname = $settings['hostname'];
    $port = $settings['port'];
    $database = $settings['database'];
    return "mysql:host={$hostname}:{$port};dbname={$database};";
};

$container['sqlite_sql'] = function ($c){
    $settings = $c->get('settings')["sqlite"] || "/tmp/dbfile.txt";
    return "sqlite:{$settings}";
};

$container['database'] = function ($c){
    $connString = $c->get('mysql_sql');
    $s = $c->get('settings')['mysql'];
    $user = $s['username'];
    $pass = $s['password'];
    if(!R::testConnection()){
        R::setup($connString,$user,$pass);
        R::debug( TRUE , 1);
    }
};

$container['name'] = function ($c){
	return $c->get('settings')['name'];
};

$container['version'] = function ($c){
	return $c->get('settings')['version'];
};

$container['config'] = function ($c){
	$settings = $c->get('settings')['database'];
	return $settings;
};
