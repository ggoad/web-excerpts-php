<?php 
 
	require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/ajaxOnlyLoggedIn.php");
	
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");
	
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/ensureDirectory.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/emptyDirectory.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/deleteDirectory.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sQuote.php");
	
	require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/basicLibrary.php");
	
	require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/RMF/lib.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/RMF/TBL_WAArenderBlog_categories/lib.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/RMF/TBL_WAArenderBlog_categories/validation.php");
	
	PostVarSet('dat',$dat);
	$dat=json_decode($dat, true);
	
	ObVarSet($dat,'list',$list);
	
	
	$pkList=array_map(function($l){return sQuote(intval($l['pk'] ?? ''));},$list);

	function SqliteInList($list, &$fo){
		$vs=[];
		$outArr=[];
		foreach($list as $k=>$v)
		{
			$vs[]=":L$k";
			$outArr[]=[
				'l'=>":L$k",
				'v'=>$v
			];
		}
		
		$fo=function($stmt) use ($outArr){
			foreach($outArr as $o)
			{
				$stmt->bindValue($o['l'],$o['v'],SQLITE3_INTEGER);
			}
		};
		return join(',',$vs);
	}

	$sqlite=SQLite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/db.db");
	
	$stmt=$sqlite->prepare("DELETE FROM categories WHERE pk NOT IN(".SqliteInList($list, $fo).")");
	$fo($stmt);
	$stmt->execute();
	
	$slugList=[];
	$ret=[];
	foreach($list as $l)
	{
		
		$l['slug']=strtolower(preg_replace('/[^A-Za-z0-9]/','-',$l['name']));
		$slugList[]=$l['slug'];
		
		$l['shareImage']['slug'] = preg_replace('/[^0-9a-zA-z]/','-', $l['shareImage']['name']);
		
		
		
		if(isset($l['pk'])){
			$checkStmt=$sqlite->prepare("SELECT * FROM categories WHERE pk = :pk");
			$checkStmt->bindValue(':pk', $l['pk'], SQLITE3_INTEGER);
			$checkRes=$checkStmt->execute();
			$checkData=$checkRes->fetchArray(SQLITE3_ASSOC);
			if($checkData['slug'] !== $l['slug']){
				rename("$_SERVER[DOCUMENT_ROOT]/../public_html_test/news/c/$checkData[slug]", "$_SERVER[DOCUMENT_ROOT]/../public_html_test/news/c/$l[slug]");
			}
			
			$checkData['shareImage']=json_decode($checkData['shareImage'], true);
			
			
			
			if($l['shareImage']['slug'] !== $checkData['shareImage']['slug'] && $checkData['shareImage']['ext']){
				@rename(
					"$_SERVER[DOCUMENT_ROOT]/../public_html_test/news/c/$l[slug]/".$checkData['shareImage']['slug'].'.'.$checkData['shareImage']['ext'],
					"$_SERVER[DOCUMENT_ROOT]/../public_html_test/news/c/$l[slug]/".$l['shareImage']['slug'].'.'.$checkData['shareImage']['ext']
				);
			}
			
			$l['OGvalue']=['pk'=>$l['pk']];
			
			$l['shareImage']=json_encode($l['shareImage']);
			$res=psEditWAArenderBlog_categories($l);
			
			
			
			if($res !== "SUCCESS"){
				die("Failed to edit category: $res");
			}
		}else{
			
			$l['shareImage']=json_encode($l['shareImage']);
			$res=psAddWAArenderBlog_categories($l);
			if($res !== "SUCCESS"){
				die("Failed to add category: $res");
			}
		}
		
		
		
		array_push($ret, $l);
		
	}
	

	
	
	
	//die(json_encode($slugList));
	
	
	if(is_dir("$_SERVER[DOCUMENT_ROOT]/../public_html_test/news/c/")){
		$sd=scandir("$_SERVER[DOCUMENT_ROOT]/../public_html_test/news/c/");
		$sd=array_filter($sd,function($s){
			return array_search($s,['.','..']) === false && is_dir("$_SERVER[DOCUMENT_ROOT]/../public_html_test/news/c/$s");
		});
		foreach($sd as $s)
		{
			if(array_search($s, $slugList) === false){
				DeleteDirectory("$_SERVER[DOCUMENT_ROOT]/../public_html_test/news/c/$s");
				$res=psDropWAArenderBlog_categories(['slug'=>$s]);
			}
		}
	}
	//$catTemp=file_get_contents("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/category.php.temp");
	
	foreach($slugList as $sl)
	{
		EnsureDirectory("$_SERVER[DOCUMENT_ROOT]/../public_html_test/news/c/$sl");

		file_put_contents("$_SERVER[DOCUMENT_ROOT]/../public_html_test/news/c/$sl/index.php", "<?php require_once(\"$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/category.php.temp\"); ?>");
	}
	
	
	$sqlite->close();
	die(json_encode([
		'success'=>true,
		'catData'=>$ret
	]));
	
?>