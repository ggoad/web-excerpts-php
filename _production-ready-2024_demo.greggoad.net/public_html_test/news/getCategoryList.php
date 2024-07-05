<?php 
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");

PostVarSet('category',$category);
PostVarSet('pageNumber',$pageNumber);
	$pageNumber=intval($pageNumber);
	if(!$pageNumber){
		$pageNumber=0;
	}
$pageLength=10;
$offset=$pageNumber*$pageLength;

$sqlite=SQLite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/db.db");


if($category !== 'all'){
	$maxStmt=$sqlite->prepare("
		SELECT COUNT(aa.pk) 
		FROM articles aa 
		JOIN categoryTies ct 
			ON ct.article=aa.pk 
		JOIN categories cc
			ON cc.pk=ct.category
		WHERE cc.slug=:cat AND aa.published=1
	");
	$maxStmt->bindValue(':cat',$category, SQLITE3_TEXT);
	$maxResult=$maxStmt->execute();
	$maxRow=$maxResult->fetchArray(SQLITE3_NUM);
	$max=intval($maxRow[0]);

	$stmt=$sqlite->prepare("
		SELECT aa.article, aa.lastModified, aa.timePublished, aa.slug, aa.pk, aa.title, aa.imgs, aa.js, aa.igniter, aa.css,aa.meta
		FROM articles aa 
		JOIN categoryTies ct 
			ON ct.article=aa.pk 
		JOIN categories cc
			ON cc.pk=ct.category
		WHERE cc.slug=:cat AND aa.published=1
		ORDER BY IFNULL(aa.sortDate, aa.timePublished) DESC
		LIMIT $offset,$pageLength");
	$stmt->bindValue(':cat',$category,SQLITE3_TEXT);
	$result=$stmt->execute();
}else{
	$maxStmt=$sqlite->prepare("
		SELECT COUNT(*) 
		FROM articles 
		WHERE published=1
	");
	$maxStmt->bindValue(':cat',$category, SQLITE3_TEXT);
	$maxResult=$maxStmt->execute();
	$maxRow=$maxResult->fetchArray(SQLITE3_NUM);
	$max=intval($maxRow[0]);

	$stmt=$sqlite->prepare("
		SELECT article, lastModified, timePublished, slug, pk, title, imgs, js, igniter, css,meta
		FROM articles 
		WHERE published=1
		ORDER BY IFNULL(sortDate, timePublished) DESC
		LIMIT $offset,$pageLength");
	$stmt->bindValue(':cat',$category,SQLITE3_TEXT);
	$result=$stmt->execute();
}
$list=['apple'=>'yo'];

$i=$offset;
while($row=$result->fetchArray(SQLITE3_ASSOC))
{
	$m=json_decode($row['meta'], true);
	$imgs=json_decode($row['imgs'], true);
	$thumb='';
	$thumbSizes=[];
	$thumbSlug='';
	$thumbExt='';
	
	$row['thumb']='';
	$row['thumbExt']='';
	$row['thumbSizes']=[];
	$row['thumbSlug']='';
	$row['thumbMime']='';
	$row['thumbName']='';
	$row['thumbAlt']='';
	$row['thumbWidth']=0;
	$row['thumbHeight']=0;
	
	foreach($imgs['list'] as $l)
	{
		if($l['shareImage']){
			$row['thumb']="/news/$row[slug]/imgs/$l[slug]/source.$l[ext]";
			$row['thumbSizes']=json_decode($l['sizes']);
			
			
			natsort($row['thumbSizes']);
			$row['thumbSizes']=array_values($row['thumbSizes']);
			$row['thumbSizes']=array_reverse($row['thumbSizes']);
			
			$row['thumbName']=$row['thumbSlug']=$l['slug'];
			$row['thumbExt']=$l['ext'];
			$row['thumbAlt']=$l['alt'];
			$row['thumbMime']=mime_content_type("$_SERVER[DOCUMENT_ROOT]$row[thumb]");
			
			
			$thumbSourceSize=getimagesize("$_SERVER[DOCUMENT_ROOT]/news/$row[slug]/imgs/$l[slug]/source.png");
			$row['thumbWidth']=150;
			$row['thumbHeight']=floor(150*$thumbSourceSize[1]/$thumbSourceSize[0]);
			
			break;
		}
	}
	$list[$i]=[
		'slug'=>$row['slug'],
		'title'=>$row['title'],
		'pk'=>$row['pk'],
		
		'thumb'=>$row['thumb'],
		'thumbSizes'=>$row['thumbSizes'],
		
		'thumbSlug'=>$row['thumbSlug'],
		'thumbExt'=>$row['thumbExt'],
		'thumbMime'=>$row['thumbMime'],
		'thumbName'=>$row['thumbName'],
		'thumbAlt'=>$row['thumbAlt'],
		'thumbWidth'=>$row['thumbWidth'],
		'thumbHeight'=>$row['thumbHeight'],
		
		
		'description'=>$m['description'] ?? '',
		'lastModified'=>$row['lastModified'],
		'timePublished'=>$row['timePublished']
	];
	$i++;
}
unset($list['apple']);

die(json_encode([
	'success'=>true,
	'list'=>$list,
	'maxResults'=>$max
]));

?>