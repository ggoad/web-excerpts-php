<?php 

require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/ajaxOnlyLoggedIn.php");

require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");

require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/lib.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/libReplace.php");

$sqlite=Sqlite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/db.db");

ObVarSet($_GET,'artSlug',$artSlug);
	$artSlug=str_replace('..','',$artSlug);
ObVarSet($_GET, 'resource', $resource);
	$resource=str_replace('..','',$resource);

$endpoint="$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/articles/{$artSlug}$resource";
if(!is_file($endpoint)){
	header("HTTP/1.1 404 Not Found");
	die("No Such File... ".$endpoint);
}
if(preg_match('/\.php$/',$resource)){
	include($endpoint);
	die();
}else{
	
	header("Content-Type: ".mime_content_type($endpoint));
	readfile($endpoint);
	die();
}

?>