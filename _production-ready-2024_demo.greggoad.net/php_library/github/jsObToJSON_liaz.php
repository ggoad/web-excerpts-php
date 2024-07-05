<?php 
require_once(__DIR__."/jsObjectToJSON.php");
function loose_json_decode($arg){
	return \OviDigital\JsObjectToJson\JsConverter::convertToArray($arg);
}

function loose_obToJson($arg){
	return \OviDigital\JsObjectToJson\JsConverter::convertToJson($arg);
}
?>