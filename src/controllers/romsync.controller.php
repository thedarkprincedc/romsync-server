<?php
class RomsyncController {
    protected $ci;
    protected $logger;
    protected $settings;
    public function __construct($ci) {
        $this->ci = $ci;
        $this->logger = $this->ci->get("logger");
        $this->settings = $this->ci->get("settings");
        $this->mysql_sql = $this->ci->get("mysql_sql");
        $user = "romsync_admin";
        $pass = "DricasM4x";
        R::setup($this->mysql_sql, $user, $pass);
    }
    public function index($request, $response, $args){
        //$this->logger->info("Slim-Skeleton '/' route");
        $args["version"] = "2.0.2";
        $args["ip"] = "localhost";
        $args["database"] = new stdClass();
        $args["database"]->status = true;
        $args["database"]->ip = "localhost";
        $args["database"]->port = 3307;
        return $this->ci->get("renderer")
                ->render($response, 'index.phtml', $args);
    }
    public function games($request, $response, $args){
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
        return $response->withJson($arr, 200)
                ->withAddedHeader('Access-Control-Allow-Origin', '*');
    }
    public function systems($request, $response, $args){
        // $result = R::exec( 'SELECT system FROM roms GROUP BY system' );
        
        $arr = [];
        $arr[0] = new stdClass();
        $arr[0]->name = "Arcade";
        $arr[0]->code = "arcade";
        return $response->withJson($arr, 200)
                ->withAddedHeader('Access-Control-Allow-Origin', '*');
    }
    public function years($request, $response, $args){
        $result = R::findAll('years');
        $arr = [];
        foreach( $result as $employee ) {
            $arr[] = ($employee);
        }
        return $response->withJson($arr, 201)
                ->withAddedHeader('Access-Control-Allow-Origin', '*');
    }
    public function decades($request, $response, $args){
        $result = R::findAll('decades');
        $arr = [];
        foreach( $result as $employee ) {
            $arr[] = ($employee);
        }
        return $response->withJson($arr, 201)
                ->withAddedHeader('Access-Control-Allow-Origin', '*');
    }
}