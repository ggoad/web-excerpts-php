<?php 
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/unirep.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/htmlRenderers.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/github/jsObToJSON_liaz.php");


$gSqlite=SQLite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/db.db");
$GLOBAL_articleSlug='';
$UNIREP_computeFunctions['`--Article-Picture--`']=function($name,$config=false){
	global $gSqlite;
	global $GLOBAL_articleSlug;
	
	if($config){
		$config=loose_json_decode($config);
	}
	if(!$config){
		$config=[];
	}
	
	$stmt=$gSqlite->prepare("SELECT imgs FROM articles WHERE slug=:slug");
	$stmt->bindValue(':slug', $GLOBAL_articleSlug, SQLITE3_TEXT);
	$result=$stmt->execute();
	$row=$result->fetchArray(SQLITE3_NUM);
	$imgs=json_decode($row[0], true);
	
	foreach($imgs['list'] as $li)
	{
		if($li['name'] === $name){
			$sizes=json_decode($li['sizes'], true);
			natsort($sizes);
			$sizes=array_values($sizes);
			$sizes=array_reverse($sizes);
			$thumbyProps=[
				'src'=>"/news/$GLOBAL_articleSlug/imgs/$li[slug]/source.$li[ext]",
				'width'=>$config['mainWidth'] ?? $li['width'],
				'height'=>$config['mainHeight'] ?? $li['height'],
			];
			
			if($li['alt']){
				$thumbyProps['alt']=$li['alt'];
			}
			
			$classProps=[];
			if(isset($config['class'])){
				$classProps['class'] = $config['class'];
			}
			if(isset($config['id'])){
				$classProps['id']=$config['id'];
			}
			
			if($sizes){
				$lastVal='';
				return HTML_element('picture', $classProps, [
					...array_map(function($s) use ($GLOBAL_articleSlug, &$lastVal, $config, $li){
						
						$curVal="/news/$GLOBAL_articleSlug/imgs/$li[slug]/$s.$li[ext]";
						$sz=explode("x", $s);
						$ret= [
							'tag'=>'source',
							'properties'=>[
								'srcset'=>$curVal.(($lastVal)? " 1x, $lastVal 2x":''),
								'media'=>'(min-width:'.floor($sz[0]*($config['sizeFactor'] ?? 1.1)).'px)',
								'type'=>$li['mime'],
								'width'=>$sz[0],
								'height'=>$sz[1]
							]
						];
						$lastVal=$curVal;
						
						return $ret;
					},$sizes),
					[
						'tag'=>'img',
						'properties'=>array_merge($thumbyProps,$classProps)
					]
				]);
			}else{
				return HTML_element('img', $thumbyProps);
			}
		}
	}
	
};

function ArticleReplace($artSlug, $str){
	global $gSqlite;
	global $GLOBAL_articleSlug;
	
	$GLOBAL_articleSlug=$artSlug;
	return Unirep($str, [
		'`--Article-Slug--`'=>$artSlug,
		'`--Article-FSlug--`'=>str_replace('-','_',$artSlug),
		'`--Article-AbsolutePrefix--`'=>"/news/`--Article-Slug--`"
	]);
} 
?>