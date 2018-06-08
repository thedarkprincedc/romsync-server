<?php
use RedBeanPHP\Logger as Logger;
class RomsyncQueryLogger implements Logger {
    private $logger;
    public function __construct() {
        $this->logger = $logger->withName('sql'); 
        //$this->app = $app;
    }
    // public function onEvent($eventName, $adapter) {
    //    if ($eventName=="sql_exec") {
    //        $log = $this->app->getLog();
    //        $sql = $adapter->getSQL();
    //        $log->debug($sql);
    //    }
    // }
     public function log() {
        $this->logger->debug(...func_get_args());
    }
}