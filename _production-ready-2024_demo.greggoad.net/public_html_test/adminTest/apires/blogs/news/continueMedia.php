<?php 

	require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/ajaxOnlyLoggedIn.php");
	
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/ensureDirectory.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/deleteDirectory.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/mime2ext.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sQuote.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");
	
	
	PostVarSet("uploadToken",$uploadToken);
		$uploadToken=preg_replace('/[^A-Za-z0-9]/','',$uploadToken);
	PostVarSet('final', $final, true);
	
	$tempName=$_FILES['dd']['tmp_name'];
	
	file_put_contents("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/temporaryUpload/$uploadToken/file", file_get_contents($tempName), FILE_APPEND);

	if($final){
		
		$sqlite=SQLite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/db.db");
		
		PostVarSet('blogSection',$blogSection, true);
		
		
		PostVarSet('mediaName',$mediaName);
			$mediaName=str_replace('..','', $mediaName);
			
		
		$mime=mime_content_type("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/temporaryUpload/$uploadToken/file");
		$ext=mime2ext($mime);
		
		if($blogSection === 'category'){
			PostVarSet('categorySlug',$categorySlug);
			
			$stmt=$sqlite->prepare("SELECT shareImage, pk FROM categories WHERE slug=:slug");
			$stmt->bindValue(':slug', $categorySlug, SQLITE3_TEXT);
			$result=$stmt->execute();
			$shareImageRow=$result->fetchArray(SQLITE3_NUM);
			$shareImage=json_decode($shareImageRow[0],true);
			$shareImage['ext']=$ext;
			$catPk=$shareImageRow[1];
			$shareImage=sQuote(json_encode($shareImage));
			
			$sqlite->query("UPDATE categories SET shareImage=$shareImage WHERE pk=$catPk");

			
			$dest="$_SERVER[DOCUMENT_ROOT]/../public_html_test/news/c/$categorySlug/$mediaName.$ext";
		}else if($blogSection === "article"){
			PostVarSet('mediaBroadType', $mediaBroadType);
				if(array_search($mediaBroadType,["Video", "Audio", "Image"]) === false){
					die("illegal media broad type");
				}
			$medBroadMap=[
				'Video'=>'vids','Audio'=>'auds','Image'=>'imgs'
			];
			$medCat=$medBroadMap[$mediaBroadType];
			$mediaSlug=preg_replace('/[^A-Za-z0-9]/','-', $mediaName);
			PostVarSet('mediaSub',$mediaSub);
				$mediaSub=str_replace('..','', $mediaSub);
			PostVarSet('artPk',$artPk);
				$artPk=intval($artPk);
			PostVarSet('artSlug',$artSlug);
				$artSlug=str_replace('..','',$artSlug);
			PostVarSet('originalMime',$originalMime, true);
				$originalExt='';
				if($originalMime){
					$originalExt=mime2ext($originalMime);
				}
			$ext=($originalExt ? $originalExt.'.' : '').$ext;
				
			
			$artResult=$sqlite->query("SELECT * FROM articles WHERE pk=$artPk");
			$artRow=$artResult->fetchArray(SQLITE3_ASSOC);
			$medInfo=json_decode($artRow[$medCat], true);
				
			if(!isset($medInfo['list'])){
				
				die(" ioadnfoida nfoa ".json_encode($medInfo).' ... '.$medCat);
			}	
			// k
			foreach($medInfo['list'] as &$mi)
			{
				if($mi['name'] === $mediaName){
					$mi['slug']=$mediaSlug;
					$mi['ext']=$originalExt ? $originalExt : $ext;
					if($medCat === 'imgs' && $mediaSub !== 'source' && !$originalExt){
						$tempSizes=json_decode($mi['sizes'], true);
						$tempSizes[]=$mediaSub;
						$mi['sizes']=json_encode($tempSizes);
						if(!$mi['sizes']){die("There was an error: ".$mediaSub);}
						//echo('jere '.$mi['sizes']);
					}else if($medCat === "imgs" && $mediaSub === 'source' && !$originalExt){
						$mi['sizes']='[]';
						$mi['mime']=mime_content_type("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/temporaryUpload/$uploadToken/file");
						$intrinsicSizes=getimagesize("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/temporaryUpload/$uploadToken/file");
						$mi['width']=$intrinsicSizes[0];
						$mi['height']=$intrinsicSizes[1];
					}
					//die(json_encode($medInfo));
					break;
				}
			}unset($mi);
				

			
			$jjj=json_encode($medInfo);
			$tstmt=$sqlite->prepare("UPDATE articles SET $medCat = :medInfo WHERE pk=$artPk");
			$tstmt->bindValue(':medInfo', $jjj, SQLITE3_TEXT);
			$tstmt->execute();
			
			EnsureDirectory("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/articles/$artSlug/$medCat/$mediaSlug");
			
			
			$dest="$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/articles/$artSlug/$medCat/$mediaSlug/$mediaSub.$ext";
		}
		
		
		$sqlite->close();
			
		copy("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/temporaryUpload/$uploadToken/file", $dest);
		DeleteDirectory("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/temporaryUpload/$uploadToken/file");
	}
	
	die("SUCCESS");
?>