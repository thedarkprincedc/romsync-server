<?php
namespace Tests\Functional;
use Tests\BaseTestCase;
// use Slim\Environment;
// use Tests\Functional\BaseTestCase;
// use \PHPUnit\Framework\TestCase;

error_reporting(E_ALL | E_STRICT);
class AuthTest extends BaseTestCase{
   // protected $app;
    public function setUp()
    {
        // $this->http = new \GuzzleHttp\Client([
        //     'base_uri' => 'http://localhost:8080/'
        // ]);
    }
    /**
     * Test that the index route returns a rendered response containing the text 'SlimFramework' but not a greeting
     */
    // public function testGames(){
    //     $response = $this->http->request('POST', '/auth/login');
    //     $this->assertEquals($response->getStatusCode(), 200);  
    // }
    // public function testSystem(){
    //     $response = $this->http->request('GET', '/auth/logout');
    //     $this->assertEquals($response->getStatusCode(), 201);  
    // }
}