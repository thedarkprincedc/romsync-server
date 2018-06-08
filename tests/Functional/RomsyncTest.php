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
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testGamesWithQuery(){
        $response = $this->request('GET', '/api/games?q=Street');
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testSystems(){
        $response = $this->request('GET', '/api/systems');
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testDecades(){
        $response = $this->request('GET', '/api/decades');
        $this->assertEquals(201, $response->getStatusCode()); 
    }
    public function testYears(){
        $response = $this->request('GET', '/api/years');
        $this->assertEquals(201, $response->getStatusCode()); 
    }
    public function testGamesDB(){
        $response = $this->request('GET', '/api/gamesdb/search');
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testYoutube(){
        $response = $this->request('GET', '/api/youtube/search');
        $this->assertEquals(200, $response->getStatusCode()); 
    }
}