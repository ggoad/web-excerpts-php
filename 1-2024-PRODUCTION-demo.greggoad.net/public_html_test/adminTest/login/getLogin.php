<?php 
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/stringMixit.php");

require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");

PostVarSet('userName',$user,true);
PostVarSet('password',$pass,true);

if(!$user || !$pass){
	die("No Dice");
}

$userHash=hash('md5', $user);

$constantSalt='ThisDemoIsAlsoMassivelySecure';

$testPass=hash('sha3-256', StringMixit($pass,$constantSalt, $userHash));



$sqlite=SQLite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/db.db");

$stmt=$sqlite->prepare("SELECT role, pk, name FROM members WHERE email=:email AND pass=:pass;");

if(!$stmt){
	die($sqlite->lastErrorMsg());
}

$stmt->bindParam(':email',$user);
$stmt->bindParam(':pass',$testPass);
$result=$stmt->execute();

if(!$result){
	die($sqlite->lastErrorMsg());
}
if(!$row = $result->fetchArray(SQLITE3_NUM)){
	die("No Dice");
}

session_start();
$_SESSION['ggtestadmin']=$user;
$_SESSION['ggtestadmin_role']=$row[0];
$_SESSION['ggtestadmin_pk']=$row[1];
$_SESSION['ggtestadmin_name']=$row[2];

$sqlite->close();
die("SUCCESS");
?>