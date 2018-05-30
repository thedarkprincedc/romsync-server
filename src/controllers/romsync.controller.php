<?php
class RomsyncController {
    protected $ci;
    protected $logger;
    protected $settings;
    public function __construct($ci) {
        $this->ci = $ci;
        $this->logger = $this->ci->get("logger");
        $this->settings = $this->ci->get("settings");
    }
    public function index($request, $response, $args){
        //$this->logger->info("Slim-Skeleton '/' route");
        $args["version"] = "2.0.2";
        //     // $args["dbstatus"] = ($this->pdo!==null)?DBSTATUS_OK:DBSTATUS_FAILED;
        $args["serverip"] = $_SERVER["SERVER_ADDR"];
        return $this->ci->get("renderer")->render($response, 'index.phtml', $args);
    }
    public function games($request, $response, $args){
        $host = "192.168.2.27";
        $user = "romsync_admin";
        $pass = "DricasM4x";
        $db   = "romsync";
        R::setup("mysql:host=$host:3307;dbname=$db", $user, $pass); 
        
        $q = '%';
        if($request->getParam('q')){
            $q = $request->getParam('q') . "%";
        }
        $system = '%';
        if($request->getParam('system')){
            $system = $request->getParam('system');
        }
        $page = $request->getParam('page');
        $limit = 25;
        $offset = $page * $limit;
        
        $result = R::find('roms', 
            'name LIKE :name AND system LIKE :system ORDER BY name LIMIT :limit OFFSET :offset', 
            array(
                ':limit' => $limit,
                ':offset' => $offset,
                ':system' => $system,
                ':name' => $q
            )
        );
        $arr = [];
        foreach( $result as $employee ) {
            $arr[] = ($employee);
        }
        return  $response->withJson($arr, 201)->withAddedHeader('Access-Control-Allow-Origin', '*');
    }
    public function systems($request, $response, $args){
        // $host = "192.168.2.27";
        // $user = "romsync_admin";
        // $pass = "DricasM4x";
        // $db   = "romsync";
        // R::setup("mysql:host=$host:3307;dbname=$db", $user, $pass); 
        // $result = R::exec( 'SELECT system FROM roms GROUP BY system' );
        
        $arr = [];
        $arr[0] = new stdClass();
        $arr[0]->name = "Arcade";
        $arr[0]->code = "arcade";
        return  $response->withJson($arr, 201)->withAddedHeader('Access-Control-Allow-Origin', '*');
    }
    public function years($request, $response, $args){

    }
    public function decades($request, $response, $args){

    }
}