<?php
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/urlAndFileSafe.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/deleteDirectory.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/copyDirectory.php");
function Blog_StrToSlug($str, $prep=''){
	$ret= UrlAndFileSafe($str);
	
	$ind=0;
	
	$temp="$ret";
	while(is_dir("$prep/$temp"))
	{
		$ind++;
		$temp="{$ret}_$ind";
	}
	return $temp;
	
}



?>