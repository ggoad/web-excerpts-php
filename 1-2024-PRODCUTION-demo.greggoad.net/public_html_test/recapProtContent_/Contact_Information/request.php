<?php 
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/ensureDirectory.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/deleteDirectory.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postStream.php");



//$safeExtensions=['jpg', 'jpeg', 'png', 'gif','bmp','txt','tiff','svg','avif','raw', 'mp4', 'mp3','wav'];

PostVarSet('recaptchaToken',$recaptchaToken);

$ip=$_SERVER['REMOTE_ADDR'];

$resp=postStream("https://www.google.com/recaptcha/api/siteverify",[
	'secret'=>'fake',
	'response'=>$recaptchaToken,
	'remoteip'=>$ip
]);

$respJson=json_decode($resp, true);
if(!$respJson){
	die(json_encode([
		'success'=>false,
		'msg'=>"SUCCESS : no resp ".$resp
	]));
}
if(!$respJson['success']){
	die(json_encode([
		'success'=>false,
		'msg'=>"SUCCESS : no success ".json_encode($respJson)
	]));
}


die(json_encode([
	'success'=>true,
	'html'=>file_get_contents("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/recapProtContent/Contact_Information/html.html")
]));
?>