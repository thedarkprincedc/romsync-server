<?php

namespace Tests;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;
use \PHPUnit\Framework\TestCase;
ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

// require __DIR__ . '/../../src/helper_functions.php';
// require __DIR__ . '/../../src/database_functions.php';
// require __DIR__ . '/../../src/paramstosql.php';
/**
 * This is an example class that shows how you could set up a method that
 * runs the application. Note that it doesn't cover all use-cases and is
 * tuned to the specifics of this skeleton app, so if your needs are
 * different, you'll need to change it.
 */
class BaseTestCase extends TestCase
{
    /** @var  \Slim\App */
    protected $app;
    /**
     * Use middleware when running application?
     *
     * @var bool
     */
    protected $withMiddleware = true;

    protected function setUp(){
        parent::setUp();
        $this->createApplication();
    }
    protected function tearDown(){
        unset($this->app);
        parent::tearDown();
    }
    public function runApp($requestMethod, $requestUri, $requestData = null, $headers = [])
    {
        // Create a mock environment for testing with
        $environment = Environment::mock(
            array_merge(
                [
                    'REQUEST_METHOD'   => $requestMethod,
                    'REQUEST_URI'      => $requestUri,
                    'Content-Type'     => 'application/json',
                    'X-Requested-With' => 'XMLHttpRequest',
                ],
                $headers
            )
        );
        // Set up a request object based on the environment
        $request = Request::createFromEnvironment($environment);
        // Add request data, if it exists
        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }
        // Set up a response object
        $response = new Response();
        // Process the application and Return the response
        return $this->app->process($request, $response);
    }
    public function request($requestMethod, $requestUri, $requestData = null, $headers = []){
        return $this->runApp($requestMethod, $requestUri, $requestData, $headers);
    }

    protected function createApplication()
    {
        // Use the application settings
        $settings = require __DIR__ . '/../src/settings.php';
   
        // Instantiate the application
        $this->app = $app = new App($settings);
        // Set up dependencies
        require __DIR__ . '/../src/dependencies.php';
        // require_once __DIR__ . '/../vendor/RedBeanPHP5_1_0/rb.php';
        // Register middleware
        if ($this->withMiddleware) {
            require __DIR__ . '/../src/middleware.php';
            //require __DIR__ . '/../src/middleware/auth.middleware.php';
        }
        // require_once __DIR__ . '/../src/controllers/romsync.controller.php';
        // require_once __DIR__ . '/../src/controllers/gamesdb.controller.php';
        // require_once __DIR__ . '/../src/controllers/youtube.controller.php';
        // require_once __DIR__ . '/../src/controllers/auth.controller.php';
        // Register routes
        require __DIR__ . '/../src/routes.php';
    }
    /**
     * Process the application given a request method and URI
     *
     * @param string $requestMethod the request method (e.g. GET, POST, etc.)
     * @param string $requestUri the request URI
     * @param array|object|null $requestData the request data
     * @return \Slim\Http\Response
     */
    // public function runApp($requestMethod, $requestUri, $requestData = null)
    // {
        
    //     // Create a mock environment for testing with
    //     $environment = Environment::mock(
    //         [
    //             'REQUEST_METHOD' => $requestMethod,
    //             'REQUEST_URI' => $requestUri
    //         ]
    //     );

    //     // Set up a request object based on the environment
    //     $request = Request::createFromEnvironment($environment);

    //     // Add request data, if it exists
    //     if (isset($requestData)) {
    //         $request = $request->withParsedBody($requestData);
    //     }

    //     // Set up a response object
    //     $response = new Response();

    //     // Use the application settings
    //     $settings = require __DIR__ . '/../../src/settings.php';
    //     require_once __DIR__ . '/../../vendor/RedBeanPHP5_1_0/rb.php';
    //     // Instantiate the application
    //     $app = new App($settings);

    //     // Set up dependencies
    //     require __DIR__ . '/../../src/dependencies.php';
    //     //require __DIR__ . '/../../src/constants.php';
    //     // Register middleware
    //     if ($this->withMiddleware) {
    //         require __DIR__ . '/../../src/middleware.php';
    //         require __DIR__ . '/../../src/middleware/auth.middleware.php';
    //     }
    //     // require_once( __DIR__ . '/../../src/AuthController.php');
    //     require_once( __DIR__ . '/../../src/controllers/romsync.controller.php');
    //     require_once( __DIR__ . '/../../src/controllers/gamesdb.controller.php');
    //     require_once( __DIR__ . '/../../src/controllers/youtube.controller.php');
    //     require_once( __DIR__ . '/../../src/controllers/auth.controller.php');

    //     // Register routes
    //     require __DIR__ . '/../../src/routes.php';

    //     // Process the application
    //     $response = $app->process($request, $response);

    //     // Return the response
    //     return $response;
    // }
}
