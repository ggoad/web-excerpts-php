<?php 
	
	define('POSTVARSET_OBREPLY',true);
	require_once("$_SERVER[DOCUMENT_ROOT]/../-redacted-/admin/ajaxOnlyLoggedIn.php");
	
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/ensureDirectory.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/emptyDirectory.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/deleteDirectory.php");
	
	require_once("$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/basicLibrary.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/adminLibrary.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/libReplace.php");
	
	require_once("$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/RMF/lib.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/RMF/-redacted-_articles/lib.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/RMF/-redacted-_articles/validation.php");
	
	
	require_once("$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/RMF/-redacted-_categoryTies/lib.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/RMF/-redacted-_categoryTies/validation.php");
	
	PostVarSet('dat',$dat);
	$dat=explode(";base64,",$dat);
	$dat=base64_decode(array_pop($dat));
	$dat=mb_convert_encoding($dat, 'utf-8');
	$dat=json_decode($dat, true);
	
	ObVarSet($dat, 'top',$top);
		ObVarSet($top, 'title', $title);
		ObVarSet($top, 'article', $article,true);
		ObVarSet($top,'pk',$pk, true);
		ObVarSet($top,'originalTitle',$originalTitle, true);
		ObVarSet($top,'originalSlug',$originalSlug, true);
		ObVarSet($top,'categories',$categories, true);
		ObVarSet($top,'published', $published, true);
		if(!$published){
			$published=0;
		}else{$published=1;}
	ObVarSet($dat,'advHtml', $advHtml);
		ObVarSet($advHtml, 'css',$css,true);
		ObVarSet($advHtml, 'js',$js,true);
		ObVarSet($advHtml, 'igniter',$igniter,true);
	ObVarSet($dat, 'scripts',$scripts);
	ObVarSet($dat, 'imgs',$imgs);
	ObVarSet($dat, 'audios',$audios);
	ObVarSet($dat, 'videos',$videos);
	ObVarSet($dat, 'meta',$meta);
	if(!$categories){
		$categories=[];
	}
	
	$sqlite=SQLite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/db.db");
	
	if($pk){
		$artPk=$pk;
		
		
		if($title !== $originalTitle){
			$slug=Blog_StrToSlug($title, "$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/articles");
			rename("$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/articles/$originalSlug","$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/articles/$slug");
			if(is_dir("$_SERVER[DOCUMENT_ROOT]/../public_html/news/$originalSlug")){
				rename("$_SERVER[DOCUMENT_ROOT]/../public_html/news/$originalSlug","$_SERVER[DOCUMENT_ROOT]/../public_html/news/$slug");
			}
		}else{
			$slug=$originalSlug;
		}
		
		$jDat=[
			'OGvalue'=>[
				'pk'=>$pk
			],
			'title'=>$title,
			'slug'=>$slug,
			'article'=>$article,
			
			'css'=>$css,
			'js'=>$js,
			'igniter'=>$igniter,
			
			'meta'=>json_encode($meta),
			'imgs'=>json_encode($imgs),
			'vids'=>json_encode($videos),
			'auds'=>json_encode($audios),
			'scripts'=>json_encode($scripts)
		];
		
		
		$res=psEdit_redacted__articles($jDat);
		
		if($res !== "SUCCESS"){
			die(json_encode(['success'=>false,'msg'=>"failed to add article: $res"]));
		}
	}else{
		$slug=Blog_StrToSlug($title, "$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/articles");
		
		$tPrevDir="$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/articles/$slug";
		EnsureDirectory($tPrevDir);
			EnsureDirectory("$tPrevDir/imgs");
			EnsureDirectory("$tPrevDir/vids");
			EnsureDirectory("$tPrevDir/auds");
			EnsureDirectory("$tPrevDir/scripts");
			
		//copy("$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/article.php.temp", "$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/articles/$slug/index.php");
		file_put_contents("$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/articles/$slug/index.php", "<?php require_once(\"$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/article.php.temp\"); ?>");
		foreach($scripts['list'] as $s)
		{
			file_put_contents("$tPrevDir/scripts/$s[name]", $s['content']);
		}
		
		$jDat=[
			'title'=>$title,
			'slug'=>$slug,
			'article'=>$article,
			
			'css'=>$css,
			'js'=>$js,
			'igniter'=>$igniter,
			
			'meta'=>json_encode($meta),
			'imgs'=>json_encode($imgs),
			'vids'=>json_encode($videos),
			'auds'=>json_encode($audios),
			'scripts'=>json_encode($scripts)
		];
		
		
		$res=psAdd_redacted__articles($jDat);
		
		if($res !== "SUCCESS"){
			die(json_encode(['success'=>false,'msg'=>"failed to add article: $res"]));
		}
		
		$artPk=$sqlite->lastInsertRowID();
		
	}
	
	if($css){
		file_put_contents("$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/articles/$slug/css.css", ArticleReplace($slug,$css));
	}
	if($js){
		file_put_contents("$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/articles/$slug/js.js", ArticleReplace($slug,$js));
	}

	$stmt=$sqlite->prepare("DELETE FROM categoryTies WHERE article=:artPk");
	$stmt->bindValue(":artPk", $artPk, SQLITE3_TEXT);
	$stmt->execute();
	
	foreach($categories as $cat)
	{
		$res=psAdd_redacted__categoryTies([
			'article'=>['pk'=>$artPk],
			'category'=>['name'=>$cat]
		]);
		if($res !== "SUCCESS"){
			die("Failed to add category tie: $res");
		}
	}
	
	

	
	$sqlite->close();
	
	
	
	die(json_encode([
		'success'=>true,
		'artPk'=>$artPk,
		'artSlug'=>$slug
	]));
?>