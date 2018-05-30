<?php

ini_set('memory_limit', '256M');

define("ROMS","roms");
define("AUDIT","audit");
define("DEVICELOG","devicelog");
define("OPTIONS","options");
define("TRANSFER","transfer");
define("USERLIST","userlist");

class RSController {
     protected $ci;
     protected $pdo;
     protected $logger;
     protected $settings;
     //Constructor
     public function __construct($ci) {
          $this->ci = $ci;
          $this->pdo = $this->ci->get("pdo");
          $this->logger = $this->ci->get("logger");
          $this->settings = $this->ci->get("settings");
     }
     public function checkImportStatus($request, $response, $args) { }
     public function getImages($request, $response, $args) {
          $filepath = sprintf("images/titles/%s", $args['name']);
          if(is_file($filepath)){
                $image = @file_get_contents($filepath);
                if($image === FALSE) {
                     $handler = $this->notFoundHandler;
                     return $handler($request, $response);
                }
                $response->write($image);
                return $response->withHeader('Content-Type', FILEINFO_MIME_TYPE);
          }
     }
      public function processPagination($params, $limit){
            $page = $params["page"];
            $limit = 25;
            $offset = $page * $limit;
            return "ORDER BY name limit {$limit} offset {$offset}";
      }
      public function buildPaginationParams($params){
            $paramlist = null;
            $count = 0;
            foreach($params as $key => $value){
                  $paramlist .= ($count>0) ? "&{$key}={$value}" : "?{$key}={$value}";
                  $count++;
            }
            return $paramlist;
      }
      public function buildPagination($params, $data, $limit){
            $page = $params["page"];
            $total = $data->total;
            $limit = 25;
            $prevPage = $page - 1;
            $nextPage = $page + 1;
            if($prevPage >= 0){
                  $params["page"] = $prevPage;
                  $p = $this->buildPaginationParams($params);
                  $data->prevPage = "http://localhost:9000/resources/public/api/search{$p}";
            }
            if($nextPage * $limit < $total){
                  $params["page"] = $nextPage;
                  $p = $this->buildPaginationParams($params);;
                  $data->nextPage = "http://localhost:9000/resources/public/api/search{$p}";
            }
            return $data;
      }
      public function quer($params){
            $n = [
                  "system" => "ParamsToSql::system",
                  "limit" => "ParamsToSql::attribute",
                  "offset" => "ParamsToSql::attribute",
                  "filterType" => "ParamsToSql::clones",
                  "query" => "ParamsToSql::query"
            ];
            $str = "";
            $count = 0;$countn = 0;
            foreach($params as $index => $value){
                  if($n[$index]){
                        if($n[$index] == "ParamsToSql::variable" || $n[$index] == "ParamsToSql::clones" || $n[$index] == "ParamsToSql::query" || $n[$index] == "ParamsToSql::system"){
                              $str .= ($count>0) ? " AND " : "WHERE ";
                              $count++;
                        }
                        if($n[$index] == "ParamsToSql::attribute"){
                              $str .= ($countn==0) ? "ORDER BY name " : "";
                              $countn++;
                        }
                        $str .= call_user_func($n[$index], $index, $value) . " ";
                  }    
            }
            return $str;
      }
      public function option($request, $response, $args){
            // var obj = new stdClass();
            // obj->systems = [];
            // obj->years = [];
            // obj->decades = [];
              // 
            // $books = R::findAll('game');
            // var_dump($books);
            // R::close();
      }
      public function gamesAll($request, $response, $args){

      }
      public function gamesOne($request, $response, $args){

      }
      public function search($request, $response, $args) {
            $query_string = ($args["query"])?$args["query"]:"";
            $qr = "";
            if($request->isGet()){
                  $query_params = $request->getQueryParams();
                  $qr = $this->quer($query_params);
            }
            $data = new stdClass();
            $pagination = "";
            if($query_params["page"]!=null){
                  $pagination = $this->processPagination($query_params, 25);
            }
            $sqlQuery = "SELECT SQL_CALC_FOUND_ROWS * FROM `roms` {$qr} {$pagination}";
           
            $this->logger->debug(" \033[1;34m sqlQuery: {$sqlQuery} \033[0m");
            $stmt = $this->pdo->query($sqlQuery);
            $data->games = $stmt -> fetchAll(PDO::FETCH_ASSOC);
            $data->sql =$sqlQuery;

            $data->games = array_map(function($value){
                  $ee = explode(".",end(explode("/", $value["filename"])));

                  $value["ff"] = ($ee) ? $ee[0] : "";
                  $value["filepath"] = sprintf("%s/%s", $this->settings["locations"]["rom_location"], $value["filename"]);
                  $value["thumbnailpath"] = sprintf("http://%s/api/images/%s",$_SERVER['HTTP_HOST'], $value["basename"]);
                  return $value;
            }, $data->games);

            $stmt = $this->pdo -> query("SELECT FOUND_ROWS()");
            $data->total = $stmt -> fetchAll(PDO::FETCH_ASSOC)[0]["FOUND_ROWS()"];
            $data->types = $filterTypeObject->types;
            // this pagination controls
            if($query_params["page"]!=null){
                  $this->buildPagination($query_params, $data, 25);
            }
            return $response->withJson($data, 201)->withAddedHeader('Access-Control-Allow-Origin', '*');
     }
     public function getGamesDbNetGameList($request, $response, $args) {
          $query_params = $request->getQueryParams();
          $url = sprintf("http://thegamesdb.net/api/GetGamesList.php?name=%s&platform=%s", urlencode($query_params["name"]), urlencode($query_params["platform"]));
          $ch = curl_init();
          curl_setopt($ch,CURLOPT_URL, $url);
          curl_setopt($ch,CURLOPT_RETURNTRANSFER , 1);
          $data = curl_exec($ch);
          curl_close($ch);
          return  $response->write($data)->withAddedHeader('Content-type', 'text/xml')->withAddedHeader('Access-Control-Allow-Origin', '*');
          //return $response->withJson($data)->withAddedHeader('Access-Control-Allow-Origin', '*');
     }
     public function getGamesDbNetGame($request, $response, $args) {
          $query_params = $request->getQueryParams();

          $url = sprintf("http://thegamesdb.net/api/GetGame.php?id=%s", urlencode($query_params["id"]));
          $ch = curl_init();
          curl_setopt($ch,CURLOPT_URL, $url);
          curl_setopt($ch,CURLOPT_RETURNTRANSFER , 1);
          $data = curl_exec($ch);
          curl_close($ch);
//"Content-type: text/xml"
          return  $response->write($data)->withAddedHeader('Content-type', 'text/xml')->withAddedHeader('Access-Control-Allow-Origin', '*');
          //print($data);
          //die();
          //$data = json_decode($data);
          //return $response->withBody($data)->withAddedHeader('Access-Control-Allow-Origin', '*');
     }
     public function searchyoutube($request, $response, $args) {
          $searchStr = urlencode($queryStr);
          $url = sprintf($this->settings["youtube"]["search_tmpl_url"], $this->settings["youtube"]["key"], urlencode($args["query"]));
          $ch = curl_init();
          curl_setopt($ch,CURLOPT_URL, $url);
          curl_setopt($ch,CURLOPT_RETURNTRANSFER , 1);
          $data = curl_exec($ch);
          curl_close($ch);
          return $response->withJson($data)->withAddedHeader('Access-Control-Allow-Origin', '*');
     }
     public function downloadgame($request, $response, $args) {
          $data = new stdClass();
          if(isQueryID($args["query"]) || isQueryFilename($args["query"])){
               $queryId = (isQueryID($args["query"])) ? $args["query"] : null;
               $queryFilename = (isQueryFilename($args["query"])) ? $args["query"] : null;
               $sqlQuery = "SELECT * FROM `roms` WHERE id = ? OR filename = ?";
               $stmt = $this-> pdo -> prepare($sqlQuery);
               if($stmt->execute(array($queryId, $queryFilename))){
                    $file = $stmt -> fetchAll(PDO::FETCH_ASSOC);
                    $file = ($file[0])?$file[0]["filename"]:null;
                    if(!file_exists($file)){
                         $this->logger->addError("{$file} could not be found");
                         //throw new Exception("{$file} could not be found");
                    }
                    header('Content-Description: File Transfer');
                    header('Expires: 0');
                    $response->headers->set('Content-Type', "application/octet-stream");
                    $response->headers->set('Pragma', "public");
                    $response->headers->set('Content-disposition:', 'attachment; filename=' . $file);
                    $response->headers->set('Content-Transfer-Encoding', 'binary');
                    $response->headers->set('Content-Length', filesize($file));
                    $response->headers->set('Cache-Control', "must-revalidate'");
                    $response->setBody($file);
               }

          }
     }
     public function getsystems($request, $response, $args) {
      
            $data = new stdClass();
            $data->system = [];
            //$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     
                  $stmt = $this->pdo->query("SELECT `systems`.name as name, `roms`.system as link
                                          FROM `roms`
                                          LEFT JOIN `systems`
                                          ON `roms`.system = `systems`.systemid
                                          GROUP BY system ORDER BY name ASC");
           
            

            $list = $stmt -> fetchAll(PDO::FETCH_ASSOC);
            $data->system = $list;
            $data->length = sizeof($list);
            return $response->withStatus(400)->withJson($data)->withAddedHeader('Access-Control-Allow-Origin', '*');
      }
     public function getdecades($request, $response, $args) {
          $data = new stdClass();
          $stmt = $this->pdo->query("SELECT (FLOOR(year / 10) * 10) AS decades, COUNT(id) AS `count` FROM `roms` WHERE year >= 1970 GROUP BY FLOOR(year/10) ORDER BY decades DESC");
          if($list = $stmt -> fetchAll(PDO::FETCH_ASSOC)){
               $data->name = "Decades";
               $data->list = array_map(function($value){
                    return $value["decades"];
               }, $list);
          }
          return $response->withJson($data)->withAddedHeader('Access-Control-Allow-Origin', '*');

     }
     public function getyears($request, $response, $args) {
          $data = new stdClass();
          $stmt = $this->pdo->query("SELECT year FROM `roms` WHERE year NOT LIKE '%?' GROUP BY year ORDER BY year DESC");
          if($list = $stmt -> fetchAll(PDO::FETCH_ASSOC)){
               $data->name = "Year";
               $data->list = array_map(function($value){
                    return $value["year"];
               }, $list);
          }
          return $response->withJson($data)->withAddedHeader('Access-Control-Allow-Origin', '*');
     }
     public function getsyncstatus($request, $response, $args) {
          $data = new stdClass();
          return $response->withJson($data)->withAddedHeader('Access-Control-Allow-Origin', '*');;

     }
     public function checkIfDatabaseInit($request, $response, $args) {
          if($stmt = $this->pdo->query("SELECT * FROM `romsync.options` WHERE name = 'DB_INIT' AND value = true")){

          }
     }
     public function sync($request, $response, $args) { }
     public function resourcedirectory($request, $response, $args) {
      $fileContents = file_get_contents("../head.index.json");
      $data = json_decode($fileContents, true);

      //$roms  = R::find('roms', "GROUP BY year ORDER BY year DESC");
      // var_dump($roms);
      return $response->withJson($data)->withAddedHeader('Access-Control-Allow-Origin', '*');
      /*
$data = new stdClass();
          $stmt = $this->pdo->query("SELECT year FROM `roms` WHERE year NOT LIKE '%?' GROUP BY year ORDER BY year DESC");
          if($list = $stmt -> fetchAll(PDO::FETCH_ASSOC)){
               $data->name = "Year";
               $data->list = array_map(function($value){
                    return $value["year"];
               }, $list);
          }
          return $response->withJson($data)->withAddedHeader('Access-Control-Allow-Origin', '*');
      */
            // $shop = R::dispense( 'shop' );
            // $shop->name = 'Antiques';
            // $vase = R::dispense( 'product' );
            // $vase->price = 25;
            // $shop->ownProductList[] = $vase;
            // R::store( $shop );
            // $book = R::dispense( 'book' );
            // $book->title = 'Learn to Program';
            // $book->rating = 10;
            // $book['price'] = 29.99; //you can use array notation as well
            // $id = R::store( $book );
            // echo R::count('roms');
            // $book  = R::findAll('roms');
            // var_dump($book);
            //R::setup('mysql:host=localhost;dbname=romsync', 'user', 'password');
            //R::setup('mysql:host=192.168.2.27;dbname=romsync;port=3307;', 'romsync_admin', 'yo4nzGpCLaQFNes4');
            
            // $books = R::findAll(`romsync.roms`);
            // var_dump($books);
            // R::close();

      //       $fileContents = file_get_contents("../head.index.json");
      //       $data = json_decode($fileContents, true);
      //      // ResourceNotFoundException();
      //       return $response
      //                   ->withJson($data, 200, JSON_UNESCAPED_UNICODE)
      //                   ->withAddedHeader('Access-Control-Allow-Origin', '*')
      //                   ->withHeader('Content-Type', 'application/json'); 
      //     $data = new stdClass();
      //     $data->name = $this->settings["name"];
      //     $data->version = $this->settings["version"];
      //     $data->urlPrefix = ($this->settings["urlPrefix"])?$this->settings["urlPrefix"]:"";
      //     $data->routes = array();
      //     $data->routes[] = generateResourceObj("search", "{$data->urlPrefix}/search/{query}");
      //     $data->routes[] = generateResourceObj("getsystems", "{$data->urlPrefix}/getsystems");
      //     $data->routes[] = generateResourceObj("getdecades", "{$data->urlPrefix}/getdecades");
      //     $data->routes[] = generateResourceObj("getyears", "{$data->urlPrefix}/getyears");
      //     $data->routes[] = generateResourceObj("youtubesearch", "{$data->urlPrefix}/youtubesearch/{query}");
      //     $data->routes[] = generateResourceObj("download", "{$data->urlPrefix}/download/{query}");
      //     $data->routes[] = generateResourceObj("sync", "{$data->urlPrefix}/sync");
      //     $data->routes[] = generateResourceObj("images", "{$data->urlPrefix}/images/{query}");
      //     $data->routes[] = generateResourceObj("resource-directory", "{$data->urlPrefix}/resource-directory");
      //     $data->routes[] = generateResourceObj("info", "{$data->urlPrefix}/info");
      //     return $response->withJson($data)->withAddedHeader('Access-Control-Allow-Origin', '*');
     }
     public function isDbInit($request, $response, $args) {
          $isDBInit = ($this->pdo)? true : false;
          $isDBTableInit = false;
          $query = "SELECT COUNT(*) AS COUNT FROM `romsync.options` WHERE name = 'DB_INIT' AND value = 'true'";
          if($stmt = $this->pdo->query($query)){
               $isDBTableInit = $stmt-> fetchAll(PDO::FETCH_ASSOC)[0]["COUNT"];
               return $response->withHeader('X-Database-ExistsAndInit', $isDBTableInit );
          }
          return $response->withHeader('X-Database-ExistsAndInit', false);
     }
     public function info($request, $response, $args) {
          $data = new stdClass();
          $data->name = $this->settings["name"];
          $data->version = $this->settings["version"];
          $data->images = (is_dir("./images"))?"true":"false";

          $data->database = ($this->pdo)? "Connected" : "Not Connected";
          $data->database_settings = $this->settings["database"];
          //$data->database_error = $this->pdo->errorCode();
          $status = 200;
          if(!$this->pdo){
            $status = 503;
          } 
          return $response->withStatus($status)->withJson($data)->withAddedHeader('Access-Control-Allow-Origin', '*');
     }
     public function infophp($request, $response, $args) {
          phpinfo();
     }
}
