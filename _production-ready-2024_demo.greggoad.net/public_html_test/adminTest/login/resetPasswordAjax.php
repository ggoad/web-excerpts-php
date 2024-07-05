<?php 
require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/ajaxOnlyLoggedOut.php");

require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/stringMixit.php");



require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/RMF/lib.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/RMF/TBL_WAArenderAdmin_passwordRecoveryCaptures/lib.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/RMF/TBL_WAArenderAdmin_passwordRecoveryCaptures/validation.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/RMF/TBL_WAArenderAdmin_members/lib.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/RMF/TBL_WAArenderAdmin_members/validation.php");



PostVarSet('password',$password);
PostVarSet('passwordMatch',$passwordMatch);
PostVarSet('token',$token, true);
PostVarSet('captureToken',$captureToken,true);

if(!$token || !$captureToken){
	die("EXPIRED");
}

if($password !== $passwordMatch){
	die("PASSWORDS DIDN'T MATCH");
}

$sqlite=SQLite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/db.db");

$sqlite->query("DELETE FROM passwordRecoveryCaptures WHERE (JULIANDAY(CURRENT_TIMESTAMP)- JULIANDAY(timeAdded))*24*60 > 5");

$stmt=$sqlite->prepare("SELECT 
prc.pk PassCoverPk,
mm.email email,
mm.pk pk
FROM passwordRecoveryCaptures prc JOIN  members mm ON mm.pk=prc.member WHERE token = :token AND captureToken = :captureToken;");

$stmt->bindValue(":token",$token, SQLITE3_TEXT);
$stmt->bindValue(":captureToken",$captureToken, SQLITE3_TEXT);

$result=$stmt->execute();

if(!($row=$result->fetchArray(SQLITE3_ASSOC))){
	$sqlite->close();
	die("EXPIRED");
}
$userHash=hash('md5', $row['email']);

$constantSalt='ThisDemoIsAlsoMassivelySecure';

$insertPass=hash('sha3-256', StringMixit($password,$constantSalt, $userHash));



$res=psEditWAArenderAdmin_members([
	'OGvalue'=>['pk'=>$row['pk']],
	'pass'=>$insertPass
]);

if($res !== "SUCCESS"){
	$sqlite->close();
	die("Server Error");
}

$res=psDropWAArenderAdmin_passwordRecoveryCaptures([
	'pk'=>$row['PassCoverPk']
]);

$sqlite->close();

if($res !== "SUCCESS"){
	die("Server Error2");
}

die("SUCCESS");

?>