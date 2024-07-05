<?php 
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");

require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/ajaxOnlyLoggedIn.php");

ObVarSet($_GET, 'formName', $formName);
ObVarSet($_GET, 'sub', $sub);
ObVarSet($_GET, 'pic', $pic);

$sub=intval($sub);
$expl=explode('.', $pic);
$picName=$expl[0];
$picName=intval($picName);
$ext=$expl[1];
$formName=preg_replace('/[^A-Za-z0-9]/','-',$formName);

$validPics=['png','jpg','jpeg','webp', 'gif'];

if(array_search($ext,$validPics) === false){
	header('HTTP/1.1 415 Unsupported Media Type');
	die();
}
$imgPath="$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/contactForms/$formName/$sub/$picName.$ext";
if(is_file($imgPath)){
	$imageInfo=getimagesize($imgPath);
	header('Content-type: '.$imageInfo['mime']);
	readfile($imgPath);
}else{
	header('HTTP/1.1 404 Not Found');
	die();
}

?>