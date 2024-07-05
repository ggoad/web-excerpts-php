<?php 

require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/onlyLoggedIn.php");

require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/unirep.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");

require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/lib.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/libReplace.php");

$sqlite=Sqlite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/db.db");

ObVarSet($_GET, 'artSlug', $artSlug);

$stmt=$sqlite->prepare("SELECT * FROM articles WHERE slug=:slug");
$stmt->bindValue(':slug',$artSlug, SQLITE3_TEXT);
$result=$stmt->execute();

$row=$result->fetchArray(SQLITE3_ASSOC);

if(!$row){
	die("No such article");
}

$globStyles;
$main=file_get_contents("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/app.html.temp");
$matches=[];
$res=preg_match_all('/<style>(.*)<\/style>/sU',$main, $matches,PREG_PATTERN_ORDER);
$res=preg_match_all('/<script>(.*)<\/script>/sU',$main, $scriptMatches,PREG_PATTERN_ORDER);


die(str_replace(
	[
		"/news/$row[slug]",
		"`--Blog-Js-ActiveView--`",
		"`--Blog-Js-CategoryLists--`",
		"`--Blog-Js-Articles--`",
		"`--Blog-Js-ArticleIgniters--`",
		"`--Blog-Js-SavedList--`",
		"`--Blog-Js-ActiveCategory--`",
		"`--Blog-Js-CategoryPage--`",
		"`--Blog-Js-ViewData--`"
	],
	[
		"previewMedia.php?artSlug=$row[slug]&resource=",
		"'article'",
		"''",
		"''",
		"''","''","''","''","{}"
	],

"
<!DOCTYPE html>
<html>
<head>
".HTML_element('title',[],["(Preview) $row[title]"])."
<style>
#articleWrapper{
	width:100%;
	position:relative;
}
".
join("\n",$matches[1])."
".($row['css'] ? ArticleReplace($row['slug'], $row['css']) : '')."
</style>
<script>
CookieManager={
	GetPermission:function(n,e,s){
		s();
	}
};
</script>
<script>
".join("\n",$scriptMatches[1])."
</script>
<script>
CookieManager={
	GetPermission:function(n,e,s){
		s();
	}
};
</script>
<script>
".($row['js'] ? ArticleReplace($row['slug'], $row['js']) : '')."
</script>
</head>
<body class=\"Blog-ArticleActive Blog-ArticleActive-$row[slug]\">
<div id=\"articleWrapper\">
<div>
<article>
".HTML_element('h1',[],[$row['title']])."
".ArticleReplace($row['slug'], $row['article'])."
</article>	
</div>
</div>
<script>
".($row['igniter'] ? "window['".ArticleReplace($row['slug'],$row['igniter'])."']()" : '')."
</script>
</body>
</html>
"));


?>