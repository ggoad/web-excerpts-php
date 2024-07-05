<?php 

	require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/ajaxOnlyLoggedIn.php");
	
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/ensureDirectory.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/emptyDirectory.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/deleteDirectory.php");
	
	require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/basicLibrary.php");
	
	require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/RMF/lib.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/RMF/TBL_WAArenderBlog_articles/lib.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/RMF/TBL_WAArenderBlog_articles/validation.php");
	
	
	require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/RMF/TBL_WAArenderBlog_categoryTies/lib.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/RMF/TBL_WAArenderBlog_categoryTies/validation.php");
	
	PostVarSet("artPk", $artPk);
	PostVarSet('top',$top);
		$top=json_decode($top, true);
	
	ObVarSet($top, 'published', $published, true);
	$published=$published ? 1 : 0;


	if($published){
		require_once(__DIR__."/publishArticle.php");
	}else{
		require_once(__DIR__."/unpublishArticle.php");
	}
	
	
?>