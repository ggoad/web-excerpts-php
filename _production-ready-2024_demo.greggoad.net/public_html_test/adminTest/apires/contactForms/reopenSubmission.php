<?php 
	require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/ajaxOnlyLoggedIn.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");
	
	PostVarSet("subPk",$subPk);
	
	$sqlite=SQLite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/contactForms/db.db");
	
	$stmt=$sqlite->prepare("UPDATE submissions SET categoryState='new' WHERE pk=:pk");
	$stmt->bindValue(":pk", $subPk, SQLITE3_TEXT);
	$stmt->execute();
	
	$sqlite->close();
	
	die("SUCCESS");
?>