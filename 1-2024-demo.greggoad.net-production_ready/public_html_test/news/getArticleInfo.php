<?php 
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");


require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/lib.php");

require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/libReplace.php");

PostVarSet('article',$article);

$sqlite=SQLite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/db.db");


$stmt=$sqlite->prepare("SELECT article, lastModified, timePublished, slug, pk, title, imgs, js, igniter, css FROM articles WHERE slug=:slug");
$stmt->bindParam(':slug', $article, SQLITE3_TEXT);

$result=$stmt->execute();

$row=$result->fetchArray(SQLITE3_ASSOC);

if(!$row){
	die(json_encode([
		'success'=>false,
		'msg'=>'No Such Article'
	]));
}

ArticleExtension($sqlite, $row['pk'],$row);
$sqlite->close();

die(json_encode([
	'success'=>true,
	'data'=>[
		'html'=>ArticleReplace($row['slug'],$row['article']),
		'title'=>$row['title'],
		'slug'=>$row['slug'],
		'pk'=>$row['pk'],
		'js'=>!(!$row['js']),
		'css'=>!(!$row['css']),
		'cssLoaded'=>(!$row['css']),
		'jsLoaded'=>(!$row['js']),
		'igniter'=>ArticleReplace($row['slug'],$row['igniter']),
		'categories'=>$row['categories'],
		'relatedArticles'=>$row['relatedArticles']
	]
]));

?>