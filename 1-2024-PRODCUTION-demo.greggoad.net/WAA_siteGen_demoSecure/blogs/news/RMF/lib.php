<?php
//require_once("$_SERVER[DOCUMENT_ROOT]/php_library/delete_directory.php");
require_once(__DIR__."/sqlConnFunctions.php");
if(!function_exists("OBSANE")){
	function OBSANE($ob, $name){
		if(isset($ob[$name])){
			//die(json_encode($ob));
			if($ob[$name] !== ''){
				return true;
			}
		}return false;
	}
}
if(!function_exists('PostVarSet')){
	function PostVarSet($name, &$catcher,$opt=false){
	   return ObVarSet($_POST, $name, $catcher, $opt);
	}
}
if(!function_exists('ObVarSet')){
	function ObVarSet($ob, $name, &$catcher, $opt=false){
	   if(isset($ob[$name])){
		  if($ob[$name] === ""){
			 if(!$opt){
				die("no $name provided in the object. $name is required");
			 }
		  }
		  $catcher=$ob[$name];
		  return;
	   }
	   if(!$opt){
		  die("No $name given. $name is require");
	   }
	   $catcher="";
	}
}
function ExtractDynamicOnRadio($inf, &$val, &$fo){
   foreach($inf as $k=>$v)
   {
        $val=$k; $fo=$v; return;
   }
}
if(!function_exists('sQuote')){
	function sQuote($str){
		return "'".str_replace(
			"'","\\'",str_replace(
				"\\","\\\\",$str
			)
		)."'";
}
}
if(!function_exists('DeleteDirectory')){
	function DeleteDirectory($dir){
		if(substr($dir, -1) == "/"){
			$dir = substr($dir, 0, strlen($dir)-1);
		}
		if(!file_exists($dir)){
			return true;
		}
		
		if(!is_dir($dir)){
			return unlink($dir);
		}
		foreach(scandir($dir) as $item)
		{
			if($item == "." || $item == ".."){
				continue;
			}
			if(!DeleteDirectory($dir.DIRECTORY_SEPARATOR.$item)){
				return false;
			}
		}
		return rmdir($dir);
	}
}
?>