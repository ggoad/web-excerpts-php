<?php 
require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/ajaxOnlyLoggedIn.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");

require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/stringMixit.php");

PostVarSet('dat',$dat);

$dat=json_decode($dat,true);
unset($dat['pk']);
unset($dat['role']);

ObVarSet($dat,'pass', $password,true);
ObVarSet($dat,'passwordMatch', $passMatch, true);
ObVarSet($dat,'email', $email);
ObVarSet($dat, 'OGvalue', $ogValue);

if($ogValue['pk'] != $_SESSION['ggtestadmin_pk']){
	header("HTTP/1.1 401 Unauthorized");
	die();
}

if($password){
	$password=trim($password);
	$passMatch=trim($passMatch);
	if($passMatch !== $password){
		die("PASSWORDS DID NOT MATCH");
	}
}
$email=trim($email);
if(!$ogValue['pk']){
	die('fail');
}
if(intval($ogValue['pk']) === 1){
	if(intval($_SESSION['ggtestadmin_pk']) !== 1){
		die("Only the original admin can edit the original admin");
	}
}

if($ogValue['email'] !== $email && !$password){
	die("To change the email, you also have to enter a new password. For security, they are tied together.");
}

if(!$password){
	unset($dat['password']);
}
if(!$email){
	die('fail');
}

if($password){
	$userHash=hash('md5', $email);

	$constantSalt='ThisDemoIsAlsoMassivelySecure';

	$insertPass=hash('sha3-256', StringMixit($password,$constantSalt, $userHash));


	$dat['pass']=$insertPass;
}
$dat['email']=$email;







$sqlite=SQLite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/db.db");

require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/RMF/lib.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/RMF/TBL_WAArenderAdmin_members/validation.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/RMF/TBL_WAArenderAdmin_members/lib.php");

if(($res = psEditWAArenderAdmin_members($dat)) !== "SUCCESS"){
	$sqlite->close();
	die("Fail");
}
$_SESSION['ggtestadmin']=$email;
$_SESSION['ggtestadmin_name']=$dat['name'];
$sqlite->close();

die("SUCCESS");
?>