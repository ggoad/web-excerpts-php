<?php 
	
	require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/ajaxOnlyLoggedIn.php");
	
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");

	$sqlite=SQLite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/db.db");
	
	$result=$sqlite->query("SELECT * FROM categories;");
	
	$ret=[];
	
	while($row=$result->fetchArray(SQLITE3_ASSOC))
	{
		$row['shareImage']=json_decode($row['shareImage'], true);
		$shareImage=$row['shareImage'];
		if($shareImage['slug'] && $shareImage['ext']){
			$row['shareImage']['src']="https://demo.greggoad.net/news/c/$row[slug]/$shareImage[slug].$shareImage[ext]";
		}
		$ret[]=$row;
	}
	$sqlite->close();
	die(json_encode([
		'success'=>true,
		'data'=>$ret
	]));
?>