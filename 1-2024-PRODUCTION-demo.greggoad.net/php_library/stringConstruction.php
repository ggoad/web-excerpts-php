<?php
function FirstSet(...$args){
	foreach($args as $a)
	{
		if(isset($a)){
			if(is_null($a)){continue;}
			if($a || "$a" === '0'){
				return $a;
			}
		}
	}
	return '';
}
function PrepIfExists($prep,$str){
	if($str || $str === '0'){
		return $prep.$str;
	}
	return '';
}
function AppIfExists($str, $app){
	if($str || $str === '0'){
		return $str.$app;
	}return '';
}
function PrepAppIfExists($prep, $str, $app){
	return PrepIfExists($prep,AppIfExists($str, $app));
}
?>