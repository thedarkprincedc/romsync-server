<?php
class YoutubeController {
    protected $ci;
    protected $logger;
    protected $settings;
    public function __construct($ci) {
        $this->ci = $ci;
        $this->logger = $this->ci->get("logger");
        $this->settings = $this->ci->get("settings");
    }
    public function search($request, $response, $args){
        $params = array(
            'q' => $request->getParam('q'),
            'part' => 'snippet',
            'key' => $this->settings->get("keys")["youtube"],
            'type' => 'video'
        );
        $string = http_build_query($params);
        $ch = curl_init($this->settings->get("url")["youtube_search"]."?".$string );
        curl_setopt($ch,CURLOPT_RETURNTRANSFER , 1);
        $data = curl_exec($ch);
        curl_close($ch);
        return $response->write($data)
                ->withAddedHeader('Content-type', 'application/json')
                ->withAddedHeader('Access-Control-Allow-Origin', '*');
    }
}