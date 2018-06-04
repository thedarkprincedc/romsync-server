<?php

namespace Tests;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;
use \PHPUnit\Framework\TestCase;
// ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');

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

        // Register middleware
        if ($this->withMiddleware) {
            require __DIR__ . '/../src/middleware.php';
        }
        // Register routes
        require __DIR__ . '/../src/routes.php';
    }
}
