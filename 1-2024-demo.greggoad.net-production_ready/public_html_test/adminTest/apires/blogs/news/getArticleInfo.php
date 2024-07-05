<?php
define('POSTVARSET_OBREPLY',true);
	require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/ajaxOnlyLoggedIn.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");
	
	PostVarSet('artPk', $artPk);
	
	$sqlite=SQLite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/db.db");
	//require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/");
	
	$stmt=$sqlite->prepare("SELECT * FROM articles WHERE pk=:pk");
	$stmt->bindValue(':pk',$artPk,SQLITE3_INTEGER);
	$result=$stmt->execute();
	
	$aRow=$result->fetchArray(SQLITE3_ASSOC);
	if(!$aRow){
		die(json_encode([
			'success'=>false,
			'msg'=>'No Such Article Exists'
		]));
	}
	$encodedColumns=["auds","imgs","meta","scripts","vids"];
	
	foreach($encodedColumns as $ec)
	{
		$aRow[$ec]=json_decode($aRow[$ec],true);
	}
	
	$categories=[];
	$stmt=$sqlite->prepare("SELECT cc.name FROM categoryTies ct JOIN categories cc ON cc.pk=ct.category WHERE ct.article=:pk");
	$stmt->bindValue(':pk',$artPk, SQLITE3_INTEGER);
	$result=$stmt->execute();
	
	while($row=$result->fetchArray(SQLITE3_NUM))
	{
		$categories[]=$row[0];
	}
	
	$sqlite->close();
	
	
	
	$ret=[
		'top'=>[
			'title'=>$aRow['title'],
			'article'=>$aRow['article'],
			'published'=>$aRow['published'],
			'pk'=>$aRow['pk'],
			'categories'=>$categories,
			'originalTitle'=>$aRow['title'],
			'originalSlug'=>$aRow['slug']
		],
		'advHtml'=>[
			'css'=>$aRow['css'],
			'js'=>$aRow['js'],
			'igniter'=>$aRow['igniter'],
		],
		'meta'=>$aRow['meta'],
		'scripts'=>$aRow['scripts'],
		'imgs'=>$aRow['imgs'],
		'vids'=>$aRow['vids'],
		'auds'=>$aRow['auds'],
	];
	
	die(json_encode([
		'success'=>true,
		'data'=>$ret
	]));
	
?>