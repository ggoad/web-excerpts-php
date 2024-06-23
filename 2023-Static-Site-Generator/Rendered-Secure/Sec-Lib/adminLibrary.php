<?php 
function RenderBlogArticle($artInfo, $published=false){
	$bTemp=file_get_contents("$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/blogTemplate.html");
	
	$content="";
	
	
	
	copy(
		"$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/articleIndex.php.temp",
		"$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/articles/$artInfo[slug]/index.php"
	);
	file_put_contents(
		"$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/articles/$artInfo[slug]/content.html",
		$content
	);
	
	if($artInfo['css']){
		file_put_contents("$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/articles/$artInfo[slug]/css.css",$artInfo['css']);
	}else{
		@unlink("$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/articles/$artInfo[slug]/css.css");
	}
	
	if($artInfo['js']){
		file_put_contents("$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/articles/$artInfo[slug]/js.js",$artInfo['js']);
	}else{
		@unlink("$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/articles/$artInfo[slug]/js.js");
	}
	
	if($published){
		DeleteDirectory("$_SERVER[DOCUMENT_ROOT]/../public_html/news/$artInfo[slug]");
		CopyDirectory("$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/articles/$artInfo[slug]","$_SERVER[DOCUMENT_ROOT]/../public_html/news/$artInfo[slug]");
	}
	
}
?>