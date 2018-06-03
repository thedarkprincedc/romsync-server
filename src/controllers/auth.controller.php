<?php
use \Firebase\JWT\JWT;

class AuthController {
    protected $ci;
    protected $logger;
    protected $settings;
    public function __construct($ci) {
        $this->ci = $ci;
        $this->logger = $this->ci->get("logger");
        $this->settings = $this->ci->get("settings");
    }
    public function loginPage($request, $response, $args){
        //$this->logger->info("Slim-Skeleton '/' route");
        $args["version"] = "2.0.2";
        $args["ip"] = "localhost";
        $args["database"] = new stdClass();
        $args["database"]->status = true;
        $args["database"]->ip = "localhost";
        $args["database"]->port = 3307;
        return $this->ci->get("renderer")
                ->render($response, 'login.phtml', $args);
    }
    public function login($request, $response, $args){ 
        $arr = new stdClass();
        $usename = $request->getParam("username");
        $password = $request->getParam("password");

       
        //$config = Factory::fromFile('/src/config/config.php', true);
        $data = file_get_contents (__DIR__."/../config/config.json");
        $json = json_decode($data, true);
       
        if($usename && $password){
            try{
             
              
                if($this->verify()){
               
                    $tokenId    = base64_encode(openssl_random_pseudo_bytes(32));
                    $issuedAt   = time();
                    $notBefore  = $issuedAt + 10;  //Adding 10 seconds
                    $expire     = $notBefore + 60; // Adding 60 seconds
                    $serverName = $json->serverName;

                    $data = [
                        'iat'  => $issuedAt,         // Issued at: time when the token was generated
                        'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
                        'iss'  => $serverName,       // Issuer
                        'nbf'  => $notBefore,        // Not before
                        'exp'  => $expire,           // Expire
                        'data' => [                  // Data related to the signer user
                            'userId'   => $rs['id'], // userid from the users table
                            'userName' => $username, // User name
                        ]
                    ];
                 
                    //header('Content-type: application/json');
                    $secretKey = base64_decode($json->jwt->key);
                    $algorithm = $json->jwt->algorithm;
                    
                    $jwt = JWT::encode(
                        $data,      //Data to be encoded in the JWT
                        $secretKey, // The signing key
                        "HS512"  // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
                    );
                 
                    $unencodedArray = ['jwt' => $jwt];
                   
                    //echo json_encode($unencodedArray);
                    return $response->withStatus(302)->withHeader('Location', 'http://localhost:');
                    //return $response->withJson($unencodedArray, 200)->withAddedHeader('Access-Control-Allow-Origin', '*');
                } else{

                }
            } catch(Exception $e){
                echo $e;
                header('HTTP/1.0 500 Internal Server Error');
            }
        }
        //$arr->jwt = "ttvtvt";
        //return $response->withJson($arr, 201)->withAddedHeader('Access-Control-Allow-Origin', '*');
    }
    public function logout($request, $response, $args){
        $arr = new stdClass();
        return $response->withJson($arr, 201)->withAddedHeader('Access-Control-Allow-Origin', '*');
    }
    public function verify(){
        return true;
    }
}