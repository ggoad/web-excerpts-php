<?php 
	require_once("$_SERVER[DOCUMENT_ROOT]/../-redacted-/admin/ajaxOnlyLoggedIn.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");
	
	PostVarSet("subPk",$subPk);
	
	$sqlite=SQLite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../-redacted-/admin/contactForms/db.db");
	
	$stmt=$sqlite->prepare("UPDATE submissions SET categoryState='archived' WHERE pk=:pk");
	$stmt->bindValue(":pk", $subPk, SQLITE3_TEXT);
	$stmt->execute();
	
	$sqlite->close();
	
	die("SUCCESS");
?>