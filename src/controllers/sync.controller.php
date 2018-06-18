<?php
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use RedBeanPHP\R as R;

class SyncController {
    protected $ci;
    protected $logger;
    protected $settings;
    public function __construct($ci) {
        $this->ci = $ci;
        $this->logger = $this->ci->get("logger");
        $this->settings = $this->ci->get("settings");
        $this->mysql_sql = $this->ci->get("mysql_sql");
        $this->ci->get("database");
        $this->ampqConnection = $this->ci->get("AMQPStreamConnection");
        $this->channel = $this->ampqConnection->channel();
        $this->channel->queue_declare('hello', false, false, false, false);
    }
    public function __destruct(){
        // $this->channel->close();
        // $this->ampqConnection->close();
    }
    public function sync($request, $response, $args){
        $message = new stdClass();
        $message->deviceId = null; // null means all devices
        $message->type = "download"; // dowload is the default
        $message->uuid = ""; // this is to match ack in db
        $message->timestamp = date("Y-m-d H:i:s", time() - date("Z"));
        $message->username = "unknown";
        $message->data = [];
        $romUrl = $this->settings["url"]["rom_location"];
        $ids = null;
        $messageJSON = "";
        if($request->getParam('deviceId')){
            $message->deviceId = $request->getParam('deviceId');
        }
        if($request->getParam('type')){
            $message->type = $request->getParam('type');
        }
        if($request->getParam('id')){ // builds query of games to download
            $message->gameIds =  explode(",",$request->getParam('id'));
            $result = R::find('roms', 'id IN ('.R::genSlots($message->gameIds).')', $message->gameIds);
            foreach( $result as $rom ) {
                $game = new stdClass();
                $game->name = $rom->name;
                $game->url = implode("/", [$romUrl, $rom->filename]);
                $game->url = implode(".", [$game->url, 'zip']);
                $game->system = $rom->system;
                array_push($message->data, $game);
            }
            $msg = new AMQPMessage(json_encode($message));
            $this->channel->basic_publish($msg, '', 'hello');
            return $response->withJson($message, 200);
        }
        $message = new stdClass();
        $message->error = "Missing entity";
        return $response->withJson( $message, 422);
    //     //echo " [x] Sent '{$message}'\n";
    //     //$this->channel->close();
    //     //$this->ampqConnection->close();
    }
    public function processOrder($msg){
        var_dump($msg);
    }
    public function getQueue($request, $response, $args){
        $autoAck = false;
       $message = $this->channel->basic_get('hello', true);
       print($message->body);
        $message = array(
            array(
                "make" => "ggrtgrtgr",
                "model" => "Rgrvrgvrgvrg",
                "price" => "gbtbtgbgrbrb"
            ), array(
                "make" => "ggrtgrtgr",
                "model" => "Rgrvrgvrgvrg",
                "price" => "gbtbtgbgrbrb"
            )
        );

        return $response->withJson($message, 200);
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