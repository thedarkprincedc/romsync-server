<?php
namespace Tests\Functional;
use Tests\BaseTestCase;

class AuthTest extends BaseTestCase{
    /**
     * Test that the index route returns a rendered response containing the text 'SlimFramework' but not a greeting
     */
    public function testLoginWithCorrectCredentials(){
        $credentials = [
            "username" => "bmosley",
            "password" => "erergrege",
            "callback" => "http://localhost:8080#/index"
        ];
        $response = $this->request('POST', '/auth/login', $credentials);
        $this->assertEquals($response->getStatusCode(), 302);
    }
    public function testLoginWithNoPasswordCredentials(){
        $credentials = [
            "username" => "bmosley",
            "password" => ""
        ];
        $response = $this->request('POST', '/auth/login', $credentials);
        $this->assertEquals($response->getStatusCode(), 401);
    }
    public function testLoginWithNoCredentials(){
        $response = $this->request('POST', '/auth/login');
        $this->assertEquals($response->getStatusCode(), 401);
    }
    public function testLogout(){
        $response = $this->request('GET', '/auth/logout');
        $this->assertEquals($response->getStatusCode(), 201);  
    }
}