<?php
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
class SyncController {
    protected $ci;
    protected $logger;
    protected $settings;
    public function __construct($ci) {
        $this->ci = $ci;
        $this->logger = $this->ci->get("logger");
        $this->settings = $this->ci->get("settings");
        $this->ampqConnection = $this->ci->get("AMQPStreamConnection");
        $this->channel = $this->ampqConnection->channel();
        $this->channel->queue_declare('hello', false, false, false, false);
    }
    // public function __destruct(){
    //     $this->channel->close();
    // }
    public function sync($request, $response, $args){
        $id = "";
        if($request->getParam('id')){
            $id = $request->getParam('id');
        }
        //$connection = new AMQPStreamConnection('192.168.2.27', 32782, 'guest', 'guest');
       // $channel = $ampqConnection->channel();

       $message = new stdClass();
       $message->uuid = "";
       $message->type = "download";
       $message->timestamp = date("Y-m-d H:i:s", time() - date("Z"));
       $message->username = "";
       $message->deviceId = "";

       $game = new stdClass();
       $game->url = 'http://romsync.thedarkprincedc.com/download/sfii.zip';
       $message->data = [$game];
        
        $messageJSON = json_encode($message);
        $msg = new AMQPMessage($messageJSON);
        $this->channel->basic_publish($msg, '', 'hello');
        return $response->withJson($message, 200);
        //echo " [x] Sent '{$message}'\n";
        //$this->channel->close();
        //$this->ampqConnection->close();
    }
    public function unsync($request, $response, $args){
        $id = "";
        if($request->getParam('id')){
            $id = $request->getParam('id');
        }
        $message = [
            'uuid' => '',
            'type' => 'remove',
            'timestamp' => '',
            'username' => '',
            'deviceId' => '',
            'data' => [
                'path' => 'sfii.zip'
            ]
        ];
    }

}