
// $container['pdo'] = function ($c){
//     R::setup('mysql:host=192.168.2.27;dbname=romsync;port=3307;', 'romsync_admin', 'yo4nzGpCLaQFNes4');
//     $database_settings = $c->get('settings')['database'];
//     try{
//       $pdo = getPDODatabase(
//             $database_settings["hostname"],
//             $database_settings["database"],
//             $database_settings["username"],
//             $database_settings["password"],
//             $database_settings["port"]
//         );
//     } catch(PDOException $pdoException){
//         $connectionString = implode(", ", $database_settings);

//         $errmsg = sprintf("\033[1;31m%s\r\n%s\033[0m %s",
//                     $pdoException -> getCode(),
//                     $pdoException -> getMessage(),
//                     $connectionString
//                );
//         $c->logger->addError($errmsg);
//         //print(json_encode(getExceptionObj($pdoException), JSON_PRETTY_PRINT));
//     }
//     return $pdo;
// };
//R::setup("mysql:host=$host:3307;dbname=$db", $user, $pass); 