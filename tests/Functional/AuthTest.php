<?php
namespace Tests\Functional;
use Tests\BaseTestCase;

class AuthTest extends BaseTestCase{
    /**
     * Test that the index route returns a rendered response containing the text 'SlimFramework' but not a greeting
     */
    public function testLogin(){
        $response = $this->request('POST', '/auth/login');
        $this->assertEquals($response->getStatusCode(), 200);  
    }
    public function testLoginWithCorrectCredentials(){
        // $credentials = [
        //     "username" => "bmosley",
        //     "password" => "erergrege"
        // ];
        // $response = $this->request('POST', '/auth/login', $credentials);
        // $this->assertEquals($response->getStatusCode(), 200);

    }
    public function testLoginWithInCorrectCredentials(){
        
    }
    public function testLogout(){
        $response = $this->request('GET', '/auth/logout');
        $this->assertEquals($response->getStatusCode(), 201);  
    }
}