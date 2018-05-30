<?php
function isQueryID($query){
	return (preg_match("/^[0-9]+$/", $query)==1) ? $query : null;
}
function isQueryFilename($query){
	return (preg_match("/[A-Za-z0-9\s\_]+(.zip)/i", $query)) ? $query : null;
}
function isQueryTitle($query){
	return (preg_match("/[A-Za-z0-9\s\_]+/i", $query)) ? $query : null;
}
function getQueryString($query){
	if($typeId = isQueryID($query)){
		return ($typeId) ? "id LIKE '{$typeId}'" : null;
	}
	if($typeFilename = isQueryFilename($query)){
		return ($typeFilename) ? "filename LIKE '{$typeFilename}%'" : null;
	}
	if($typeTitle = isQueryTitle($query)){
		return ($typeTitle) ? "name LIKE '{$typeTitle}%'" : null;
	}
	return "";
}
function getQueryFilterString($filterType){
	if($filterType){
		if (strcasecmp($filterType, "primary") == 0) {
			return "cloneof = ''";
		}
		if (strcasecmp($filterType, "clones") == 0) {
			return "cloneof <> ''";
		}
	}
	return "";
}
function getQueryLimit($limit){
	return (strlen($limit) > 0) ? "LIMIT {$limit}" : "";
}
function getQueryOffset($offset){
	return ($offset) ? "OFFSET {$offset}" : "";
}
function getQueryYear($year){
	return ($year) ? "year LIKE '{$year}%'" : "";
}
function getQueryDecade($decade){
	return ($decade) ? "year >= {$decade} AND year <= {($decade + 10)}" : "";
}
function getQuerySystem($system){
	return ($system) ? "system LIKE '{$system}'" : "";
}
function getQueryType($type){
	$retObject = new stdClass();
	$equalNotEqual = null;
	$retObject->types = ["Primary", "Clones"];
	if (strcasecmp($type, "primary") == 0) {
		$equalNotEqual = "=";
		$retObject->types = ["Primary"];
	}else if (strcasecmp($type, "clones") == 0) {
		$equalNotEqual = "<>";
		$retObject->types = ["Clones"];
	}
	$retObject->whereclause = ($equalNotEqual) ? sprintf("clone %s ''", $equalNotEqual) : "";
	return $retObject;

}
function generateResourceObj($name, $resourceUrl){
	$obj = new stdClass();
	$obj->name = $name;
	$obj->url = "http://".$_SERVER['HTTP_HOST']."{$resourceUrl}";
	return $obj;
}
function base64UrlEncode($data) {
	return strtr(rtrim(base64_encode($data), '='), '+/', '-_');
}

function base64UrlDecode($base64) {
	return base64_decode(strtr($base64, '-_', '+/'));
}
function validateUserToken($token){
	return true;
}
function getExceptionObj($pdoException) {
	$retArr = new stdClass();
	$retArr -> errcode = $pdoException -> getCode();
	$retArr -> errmsg = $pdoException -> getMessage();
	$retArr -> errfile = $pdoException -> getFile();
	$retArr -> line = $pdoException -> getLine();
	$retArr -> trace = $pdoException -> getTrace();
	$retArr -> tracestring = $pdoException -> getTraceAsString();
	return $retArr;
}
