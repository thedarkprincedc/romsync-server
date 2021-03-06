<?php
use RedBeanPHP\R as R;

class RomsyncController {
    protected $ci;
    protected $logger;
    protected $settings;
    public function __construct($ci) {
        $this->ci = $ci;
        $this->logger = $this->ci->get("logger");
        $this->settings = $this->ci->get("settings");
        $this->mysql_sql = $this->ci->get("mysql_sql");
        $this->ci->get("database");
        
        // if(!R::testConnection()){
        //     R::setup($this->mysql_sql, $user, $pass);
        // }
        
    }
    public function index($request, $response, $args){
        //$this->logger->info("Slim-Skeleton '/' route");
        // $args["version"] = "2.0.2";
        // $args["ip"] = "localhost";
        // $args["database"] = new stdClass();
        // $args["database"]->status = true;
        // $args["database"]->ip = "localhost";
        // $args["database"]->port = 3307;
        //$this->settings
        return $this->ci->get("renderer")
                ->render($response, 'index.phtml', $args);
    }
    public function error($request, $response, $args){
        return $this->ci->get("renderer")
            ->render($response, 'error-404-template.phtml', $args);
    }
    public function games($request, $response, $args){
       // $this->logger->critical("tgw4jngojn4wojgn3jongoj");
        $q = '%';
        if($request->getParam('q')){
            $q = $request->getParam('q') . "%";
        }
        $system = '%';
        if($request->getParam('system')){
            $system = $request->getParam('system');
        }
        $gameType = null;
        if($request->getParam("gameType")){
            $gameType = $request->getParam("gameType");
            if(strcasecmp($gameType, "primary") == 0){
                $gameType = "primary";
            } else if(strcasecmp($gameType, "clones") == 0){
                $gameType = "clones";
            }
        }

        $page = $request->getParam('page');
        $limit = 25;
        $offset = $page * $limit;
        $whereClause = [
            'clones' => 'name LIKE :name AND system LIKE :system AND cloneof IS NOT NULL ORDER BY name LIMIT :limit OFFSET :offset',
            'primary' => 'name LIKE :name AND system LIKE :system AND cloneof IS NULL ORDER BY name LIMIT :limit OFFSET :offset',
            'default' => 'name LIKE :name AND system LIKE :system ORDER BY name LIMIT :limit OFFSET :offset'
        ];
        $clause = ($whereClause[$gameType])?$whereClause[$gameType]: $whereClause["default"];
       
        $result = R::find('roms', $clause, 
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
        return $response->withJson($arr, 200);
    }
    public function systems($request, $response, $args){
        // $result = R::exec( 'SELECT system FROM roms GROUP BY system' );
        $arr = [];
        $arr[0] = new stdClass();
        $arr[0]->name = "Arcade";
        $arr[0]->code = "arcade";
        return $response->withJson($arr, 200);
    }
    public function years($request, $response, $args){
        $result = R::findAll('years');
        $arr = [];
        foreach( $result as $employee ) {
            $arr[] = ($employee);
        }
        return $response->withJson($arr, 201);
    }
    public function decades($request, $response, $args){
        $result = R::findAll('decades');
        $arr = [];
        foreach( $result as $employee ) {
            $arr[] = ($employee);
        }
        return $response->withJson($arr, 201);
    }
    public function image($request, $response, $args) {
        $filename = $args['filename'];
        $path = $this->settings["locations"]["images"];
        $filepath = "{$path}/{$filename}.jpg";
        if(!is_file($filepath)){
            $errorMsg = new stdClass();
            $errorMsg->error = true;
            $errorMsg->message = "File could not be found";
            $errorMsg->filePath =$filePath;
            return $response->withJson($errorMsg, 404);
        }
        $image = file_get_contents($filepath);
        $response->write($image);
        return $response->withHeader('Content-Type', FILEINFO_MIME_TYPE); 
   }
    public function download($request, $response, $args){
        $filename = $args['filename'];
        $path = $this->settings["locations"][$args['path']];
        $filePath = $path.$filename.".zip";
        if(!file_exists($filePath)){
            $errorMsg = new stdClass();
            $errorMsg->error = true;
            $errorMsg->message = "File could not be found";
            $errorMsg->filePath =$filePath;
            return $response->withJson($errorMsg, 404);
        //     //$this->logger->addError("{$file} could not be found");
        //     //                //throw new Exception("{$file} could not be found");
        }
        $response->headers->set('Content-Description', 'File Transfer');
        $response->headers->set('Expires', '0');
        $response->headers->set('Content-Type', "application/octet-stream");
        $response->headers->set('Pragma', "public");
        $response->headers->set('Content-disposition:', 'attachment; filename=' . $filePath);
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        $response->headers->set('Content-Length', filesize($filePath));
        $response->headers->set('Cache-Control', "must-revalidate'");
        $response->setBody($filePath);
    }
}