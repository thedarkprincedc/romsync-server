<?php


namespace Tests\Functional;
error_reporting(E_ALL | E_STRICT);
class RomsyncTest extends BaseTestCase{
    protected $app;
    public function setUp()
    {
        //$this->app = (new App())->get();
    }
    /**
     * Test that the index route returns a rendered response containing the text 'SlimFramework' but not a greeting
     */
    public function testGames(){
        $response = $this->runApp('GET', '/');
        //var_dump($response);
        //$this->assertEquals(200, 200);
        // $env = Environment::mock([
        //     'REQUEST_METHOD' => 'GET',
        //     'REQUEST_URI'    => '/',
        //     ]);
        // $req = Request::createFromEnvironment($env);
        // $this->app->getContainer()['request'] = $req;
        // $response = $this->app->run(true);
        // $this->assertSame($response->getStatusCode(), 200);
        // $this->assertSame((string)$response->getBody(), "Hello, Todo");
    }
    
}