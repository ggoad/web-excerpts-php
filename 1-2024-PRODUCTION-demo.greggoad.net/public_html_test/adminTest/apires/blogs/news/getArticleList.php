<?php
define('POSTVARSET_OBREPLY',true);
	require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/ajaxOnlyLoggedIn.php");
	
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");
	
	PostVarSet('page',$page);
		$page=intval($page);
	PostVarSet('pageLength', $pageLength, true);
		$pageLength=intval($pageLength);
		if(!$pageLength){$pageLength=10;}
		
	$offset=$page*$pageLength;
	
	PostVarSet('published', $published);
		$published=intval($published);
	
	$sqlite=SQLite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/db.db");
	
	$stmt=$sqlite->prepare("SELECT pk, lastModified, timePublished, title FROM articles WHERE published=:pub ORDER BY lastModified DESC LIMIT $offset, $pageLength");
	
	$stmt->bindValue(':pub', $published, SQLITE3_INTEGER);
	
	$result=$stmt->execute();
	
	$dat=[];
	while($row=$result->fetchArray(SQLITE3_ASSOC))
	{
		$dat[]=$row;
	}
	
	
	$stmt=$sqlite->prepare("SELECT COUNT(*) FROM articles WHERE published=:pub");
	$stmt->bindValue(':pub', $published, SQLITE3_INTEGER);
	$result=$stmt->execute();
	$row=$result->fetchArray(SQLITE3_NUM);
	$total=intval($row[0]);
	
	$sqlite->close();
	
	die(json_encode([
		'success'=>true,
		'results'=>$dat,
		'total'=>$total
	]));
?>