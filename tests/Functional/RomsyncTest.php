<?php
namespace Tests\Functional;
use Tests\BaseTestCase;

class RomsyncTest extends BaseTestCase{
     /**
     * Test that the index route returns a rendered response containing the text 'SlimFramework' but not a greeting
     */
    /** @test */
    public function testGames(){
        $response = $this->request('GET', '/api/games');
        $this->assertEquals($response->getStatusCode(), 200);
    }
    public function testGamesWithQuery(){
        $response = $this->request('GET', '/api/games?q=Street');
        $this->assertEquals($response->getStatusCode(), 200);
    }
    public function testSystems(){
        $response = $this->request('GET', '/api/systems');
        $this->assertEquals($response->getStatusCode(), 200);
    }
    public function testDecades(){
        $response = $this->request('GET', '/api/decades');
        $this->assertEquals($response->getStatusCode(), 201);  
    }
    public function testYears(){
        $response = $this->request('GET', '/api/years');
        $this->assertEquals($response->getStatusCode(), 201);  
    }
    public function testGamesDB(){
        $response = $this->request('GET', '/api/gamesdb/search');
        $this->assertEquals($response->getStatusCode(), 200);  
    }
    public function testYoutube(){
        $response = $this->request('GET', '/api/youtube/search');
        $this->assertEquals($response->getStatusCode(), 200);  
    }
}