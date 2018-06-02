<?php
class GamesDBController {
    protected $ci;
    protected $logger;
    protected $settings;
    public function __construct($ci) {
        $this->ci = $ci;
        $this->logger = $this->ci->get("logger");
        $this->settings = $this->ci->get("settings"); 
    }
    public function search($request, $response, $args){
        $string = http_build_query($request->getParams());
        $ch = curl_init($this->settings->get("url")["gamesdb_search"]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
        return $response->write($data)
                ->withAddedHeader('Content-type', 'text/xml')
                ->withAddedHeader('Access-Control-Allow-Origin', '*');
    }
}