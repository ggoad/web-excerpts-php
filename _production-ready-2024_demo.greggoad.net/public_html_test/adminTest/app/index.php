<?php 
require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/onlyLoggedIn.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sQuote.php");
/*
So, view data is defined as this 
obj 
'viewName':{
	funct:function that is a view function,
	title: either a string or a function that calculates the title,
	urlEndpoint: a url enpoint to be concatenated to https://demo.greggoad.net/adminTest/,
	StartHistory: a function that accepts the top part of the url to act as data. 
}
*/
echo str_replace([
	'`--AdminSuperViewData--`',
	'`--AdminSuperRMFData--`',
	'`--AdminSuperCSS--`',
	'`--USERDATA--`'
],[
	(
		($_SESSION['ggtestadmin_role'] === 'super') ? '
		;
		' : 
		""
	),
	(
		($_SESSION['ggtestadmin_role'] === 'super') ? '
		;
		' : 
		""
	),
	(
		($_SESSION['ggtestadmin_role'] === 'super') ? '
		
		' : 
		""
	),
	json_encode([
		'name'=>$_SESSION['ggtestadmin_name'],
		'email'=>$_SESSION['ggtestadmin'],
		'role'=>$_SESSION['ggtestadmin_role'],
		'pk'=>$_SESSION['ggtestadmin_pk']
	])
],file_get_contents("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/app.html.temp"));

?>