<?php
namespace Tests\Functional;
use Tests\BaseTestCase;

class RomsyncTest extends BaseTestCase{
   // protected $app;
    // public function setUp()
    // {
    //    // $this->createApplication();
    //     // $this->http = new \GuzzleHttp\Client([
    //     //     'base_uri' => 'http://localhost:8080/'
    //     // ]);
    // }
    // protected function tearDown(){
    //     unset($this->app);
    //     parent::tearDown();
    // }
    /**
     * Test that the index route returns a rendered response containing the text 'SlimFramework' but not a greeting
     */
    public function testGames(){
        $response = $this->request('GET', '/api/games');
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testSystem(){
        $response = $this->request('GET', '/api/systems');
        $this->assertEquals(200, $response->getStatusCode());
    }
    // public function testDecades(){
    //     $response = $this->http->request('GET', '/api/decades');
    //     $this->assertEquals($response->getStatusCode(), 201);  
    // }
    // public function testYears(){
    //     $response = $this->http->request('GET', '/api/years');
    //     $this->assertEquals($response->getStatusCode(), 201);  
    // }
    // public function testGamesDB(){
    //     $response = $this->http->request('GET', '/api/gamesdb/search');
    //     $this->assertEquals($response->getStatusCode(), 200);  
    // }
    // public function testYoutube(){
    //     $response = $this->http->request('GET', '/api/youtube/search');
    //     $this->assertEquals($response->getStatusCode(), 200);  
    // }
}