<?php
class SyncController {
    protected $ci;
    protected $logger;
    protected $settings;
    public function __construct($ci) {
        $this->ci = $ci;
        $this->logger = $this->ci->get("logger");
        $this->settings = $this->ci->get("settings");
    }
    public function sync($request, $response, $args){
        
    }
    public function unsync($request, $response, $args){
        
    }
}