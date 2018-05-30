<?php

function getPDODatabase($hostname, $database, $username, $password, $port){
	return new PDO("mysql:host={$hostname};dbname={$database};port={$port}", $username, $password);
}
