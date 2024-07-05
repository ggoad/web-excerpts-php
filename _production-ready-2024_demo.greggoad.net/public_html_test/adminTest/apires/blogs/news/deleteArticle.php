<?php
	require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/ajaxOnlyLoggedIn.php");
	
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/deleteDirectory.php");
	
	PostVarSet('artPk',$artPk);
	
	
	$sqlite=SQLite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/db.db");
	
	$stmt=$sqlite->prepare("SELECT * FROM articles WHERE pk = :pk");
	$stmt->bindValue(':pk',$artPk, SQLITE3_INTEGER);
	$result=$stmt->execute();
	
	$row=$result->fetchArray(SQLITE3_ASSOC);
	if(!$row){
		$sqlite->close();
		die("No such article exists.");
	}
	
	DeleteDirectory("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/articles/$row[slug]");
	
	if(is_dir("$_SERVER[DOCUMENT_ROOT]/../public_html_test/news/$row[slug]")){
		DeleteDirectory("$_SERVER[DOCUMENT_ROOT]/../public_html_test/news/$row[slug]");
	}
	
	$stmt=$sqlite->prepare("DELETE FROM articles WHERE pk = :pk");
	$stmt->bindValue(':pk',$artPk, SQLITE3_INTEGER);
	$result=$stmt->execute();
	
	$sqlite->close();
	die("SUCCESS");
?>