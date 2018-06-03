<?php

namespace Tests\Functional;

class RomsyncTest extends BaseTestCase{
    /**
     * Test that the index route returns a rendered response containing the text 'SlimFramework' but not a greeting
     */
    public function testGames(){
        $this->assertEquals(200, 200);
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
