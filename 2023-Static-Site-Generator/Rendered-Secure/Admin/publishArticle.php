<?php 
	
	require_once("$_SERVER[DOCUMENT_ROOT]/../-redacted-/admin/ajaxOnlyLoggedIn.php");
	
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/ensureDirectory.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/copyDirectory.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/htmlRenderers.php");
	
	PostVarSet('artPk',$artPk);
	
	
	$sqlite=SQLite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/db.db");
	
	$stmt=$sqlite->prepare("SELECT * FROM articles WHERE pk = :pk");
	$stmt->bindValue(':pk',$artPk, SQLITE3_INTEGER);
	$result=$stmt->execute();
	
	$row=$result->fetchArray(SQLITE3_ASSOC);
	if(!$row){
		$sqlite->close();
		die("No such article exists.");
	}
	
	CopyDirectory(
		"$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/articles/$row[slug]",
		"$_SERVER[DOCUMENT_ROOT]/../public_html/news/$row[slug]"
	);
	
	$stmt=$sqlite->prepare("UPDATE articles SET published=1, timePublished=IFNULL(timePublished,datetime('now')), lastModified=datetime('now') WHERE pk = :pk");
	$stmt->bindValue(':pk',$artPk, SQLITE3_INTEGER);
	$result=$stmt->execute();
	
	
	
	$urls=[];
	$rr=$sqlite->query("SELECT slug, title, lastModified FROM articles WHERE published=1");
	
	while($r=$rr->fetchArray(SQLITE3_ASSOC))
	{
		$urls[]=HTML_element('url', [], [
			['tag'=>'loc', 'properties'=>[], 'children'=>["https://greggoad.net/news/$r[slug]/"]],
			['tag'=>'lastmod', 'properties'=>[], 'children'=>[$r['lastModified']]]
		]);
	}
	
	$rr=$sqlite->query("SELECT slug FROM categories");
	$cs=false;
	while($r=$rr->fetchArray(SQLITE3_ASSOC))
	{
		$cs=true;
		$urls[]=HTML_element('url', [], [
			['tag'=>'loc', 'properties'=>[], 'children'=>["https://greggoad.net/news/c/$r[slug]/"]]
		]);
	}
	if($cs){
		$urls[]=HTML_element('url', [], [
			['tag'=>'loc', 'properties'=>[], 'children'=>["https://greggoad.net/news/c/"]]
		]);
		
	}
	
	file_put_contents("$_SERVER[DOCUMENT_ROOT]/../public_html/news/sitemap.xml","<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
".join("\n",$urls)."
</urlset>");
	
	
	$sqlite->close();
	if(!isset($publishArticleNoDie)){
		
	
		die("SUCCESS");
	}
	
?>