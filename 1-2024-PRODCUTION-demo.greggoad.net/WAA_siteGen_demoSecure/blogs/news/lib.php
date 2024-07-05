<?php 
function ArticleExtension($sqlite, $artPk, &$row){
	$catStmt=$sqlite->prepare("SELECT cc.name name, cc.slug slug, cc.pk pk FROM categoryTies ct JOIN categories cc ON ct.category=cc.pk WHERE ct.article=:artPk");
	$catStmt->bindValue(':artPk', $artPk, SQLITE3_INTEGER);
	$catResult=$catStmt->execute();
	
	$row['categories']=[];
	while($catRow=$catResult->fetchArray(SQLITE3_ASSOC))
	{
		$row['categories'][]=$catRow;
	}
	
	$row['relatedArticles']=[];
	
	$tempCatArts=[];
	foreach($row['categories'] as $cat)
	{
		$catStmt=$sqlite->prepare("
			SELECT aa.title, aa.slug, aa.pk
			FROM articles aa
			JOIN categoryTies ct 
				ON ct.article=aa.pk 
			WHERE ct.category=:catPk AND aa.pk != :artPk AND aa.published=1
			ORDER BY IFNULL(sortDate, timePublished) DESC
			LIMIT 15;
		");
		$catStmt->bindValue(':catPk', $cat['pk'], SQLITE3_INTEGER);
		$catStmt->bindValue(':artPk', $artPk, SQLITE3_INTEGER);
		$relCatResult=$catStmt->execute();
		
		$tempArr=[];
		while($relCatRow=$relCatResult->fetchArray(SQLITE3_ASSOC))
		{
			$tempArr[]=$relCatRow;
		}
		$tempCatArts[]=$tempArr;
		
	}
	$jump=false;
	
	for($i=0; !$jump && count($row['relatedArticles']) <6; $i++)
	{
		$jump=true;
		foreach($tempCatArts as $tca)
		{
			if(isset($tca[$i])){
				$jump=false;
				$row['relatedArticles'][]=$tca[$i];
			}
		}
	}
	
	
	$row['relatedArticles']=array_unique($row['relatedArticles'],SORT_REGULAR);
	
	if(count($row['relatedArticles'])<4){
		$pkArr=array_map(function($a){return $a['pk'];},$row['relatedArticles']);
		//echo 'yo';
		$relCatStmt=$sqlite->prepare("SELECT title, slug, pk FROM articles WHERE pk != :artPk AND published=1 AND pk NOT IN(".join(",",$pkArr).") ORDER BY IFNULL(sortDate, timePublished) DESC LIMIT 10");
		$relCatStmt->bindValue(':artPk', $artPk, SQLITE3_INTEGER);
		$relCatResult=$relCatStmt->execute();
		
		while(($relCatRow=$relCatResult->fetchArray(SQLITE3_ASSOC)))
		{
			$row['relatedArticles'][]=$relCatRow;
		}
		//die(json_encode($row['relatedArticles']));
	}
	
	$row['relatedArticles']=array_slice($row['relatedArticles'], 0,8);
}
?>