<?php 

define('URLnFileUnsafeCharacters','|\\/. ?&|<>,:;\'"{}[]=%#@`~$^*');
define('URLnFileUnsafeArr', str_split(URLnFileUnsafeCharacters));
function UrlAndFileSafe($str, $lowerCase=false){
	$str=preg_replace('/[[:^ascii:]]/','',$str);
	$str=str_replace(URLnFileUnsafeArr,'-',$str);
	$str=preg_replace('/\\s/','-',$str);
	
	if($lowerCase){
		$str=strtolower($str);
	}
	
	return $str;
}
?>