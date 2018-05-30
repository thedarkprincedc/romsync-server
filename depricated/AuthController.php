<?php
class AuthController {
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
     public function logout($request, $response, $args) {

     }
     public function login($request, $response, $args) {
          $data = new stdClass();
          $stmt = $this-> pdo -> prepare("SELECT * FROM `romsync.userlist` WHERE username = ? AND password = ?");
          $stmt -> execute(
               array(
                    $request->getParam('username'),
                    $request->getParam('password')
                    )
               );
               if ($retObject = $stmt -> fetchAll()) {
                    $header = new stdClass();
                    $header -> type = "JWT";
                    $header -> alg = "HS256";
                    $tokHeader = base64_encode(json_encode($header));

                    //$retArr->header = $header;
                    //$retArr->tokHeader = base64_encode(json_encode($header));

                    $payload = new stdClass();
                    $payload -> name = sprintf("%s %s", $retObject[0]["firstname"], $retObject[0]["lastname"]);
                    $payload -> username = $retObject[0]["username"];
                    $payload -> exp = strtotime("+30 minutes");
                    $payload -> admin = true;
                    $payload -> permissions = $retObject[0]["permissions"];
                    $tokPayload = base64_encode(json_encode($payload));
                    //$retArr->payload = $payload;
                    //$retArr->tokPayload = base64_encode(json_encode($payload));
                    $hmacSecret = $this->settings["HMAC_SECRET"];
                    //print_r($hmacSecret);
                    $tokHeader_tokPayload = base64UrlEncode($tokHeader) . "." . base64UrlEncode($tokPayload);
                    $signature = hash_hmac("sha256", $tokHeader_tokPayload, $hmacSecret);
                    $data->token = implode(".", array($tokHeader, $tokPayload, $signature));
               }
               $this->logger->info(sprintf("Login Data = %s:%s\t%s",
                    $request->getParam('username'),
                    $request->getParam('password'),
                    print_r($payload, true)
               ));

               return $response->withJson($data)->withAddedHeader('Access-Control-Allow-Origin', '*');
          }
     public function validate($tokenArray) {
		$header = base64_decode($tokenArray[0]);
		$payload = base64_decode($tokenArray[1]);
		$signature = $tokenArray[2];
		return $this->generateSignature($header, $payload, $this->settings["HMAC_SECRET"]);

          //return (strcasecmp($signature, $generatedSignature) == 0) ? true : false;
     }
     function generateSignature($tokenHeader, $tokenPayload, $hmacSecret = null){
		$tokenHeader = base64_encode($tokenHeader);
		$tokenPayload = base64_encode($tokenPayload);
		return hash_hmac("sha256", implode(".", array(base64_encode($tokenHeader), base64_encode($tokenPayload))), $hmacSecret);
	}
     function decodeTokenArr($tokenArr){
		$retDataObj = new stdClass();
		$retDataObj->header = json_decode(base64_decode($tokenArr[0]));
		$retDataObj->payload = json_decode(base64_decode($tokenArr[1]));
		$retDataObj->signature = $tokenArr[2];
		return $retDataObj;
	}
     public function validateSignature($tokenArr){
          return hash_hmac("sha256", $tokenArr[0] .".". $tokenArr[1], $this->settings["HMAC_SECRET"]);

     }
     public function tokenValidate($request, $response, $args) {
          $data = new stdClass();
          $data->validated="false";

          if($request->hasHeader('HTTP_X_AUTHTOKEN') || $request->getParam('token')){
               $token = ($request->hasHeader('HTTP_X_AUTHTOKEN')) ? $request->getHeader('HTTP_X_AUTHTOKEN')[0] : $request->getParam('token');
               $tokenElems = explode(".",$token);
               if(count($tokenElems) !== 3){
				//throw new Exception($this->error_messages->token_length);
			}
               //
               $this->logger->info("/api/validate " . print_r($tokenElems,true));
               $vSignature = $this->validateSignature($tokenElems);
               $this->logger->info("/api/validate oSign={$tokenElems[0]} vSign={$vSignature}");

               //$data->Token = $tokenElems[0];
               //$data->TokenD = $this->decodeToken($request->getHeader('HTTP_X_AUTHTOKEN')[0]);
               //$data->vToken = $this->validate($token);
          }
          /*if(!empty($token)){

			//$hmacSecret = "pirateB00ty";
			if($this->validateToken($token, $this->getHMACSecret())){
				if(!$this->is_expired($token)){
					$retObject->validate = "true";
				}
			}
		}*/
		// Read Token
		// if token not expired
			// send token ok
		// if token is going to expire within 5 mins issue new token
		// if token expired
			// send token failed
		return $response->withJson($data)->withAddedHeader('Access-Control-Allow-Origin', '*');
     }
}
