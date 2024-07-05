<?php
require_once(__DIR__.'/../TBL_WAArenderBlog_articles/validation.php');
require_once(__DIR__.'/../TBL_WAArenderBlog_categories/validation.php');
require_once(__DIR__.'/../basicPk/validation.php');


function RMF_TBL_WAArenderBlog_categoryTies_EXTRAVALIDATE($dat){
return true;
}


		$TBL_WAArenderBlog_categoryTies_VALIDATION_recDepth=-1;
		$TBL_WAArenderBlog_categoryTies_VALIDATION_recLimit=1;
	function RMF_TBL_WAArenderBlog_categoryTies_VALIDATE($dat, $fullCall=0){

		global $TBL_WAArenderBlog_categoryTies_VALIDATE_recDepth;
		global $TBL_WAArenderBlog_categoryTies_VALIDATE_recLimit;
		if( $TBL_WAArenderBlog_categoryTies_VALIDATE_recDepth>$TBL_WAArenderBlog_categoryTies_VALIDATE_recLimit){
			return "validateCallLimit";
		}
		$TBL_WAArenderBlog_categoryTies_VALIDATE_recDepth++;
		$keyTypeArray=json_decode('{"article":"TBL_WAArenderBlog_articles","category":"TBL_WAArenderBlog_categories","pk":"basicPk"}',true);
	   $ret=true;
	   foreach($keyTypeArray as $k=>$v)
	   {
		   if(is_null($v) || is_null($dat)){continue;}
		   if(isset($_GLOBALS["{$v}_VALIDATE_recDepth"])){
			   $globalRecDepth=$_GLOBALS["{$v}_VALIDATE_recDepth"];
		   }else{
			   $globalRecDepth=-1;
		   }
		   if(isset($_GLOBALS["{$v}_VALIDATE_recLimit"])){
			   $globalRecLimit=$_GLOBALS["{$v}_VALIDATE_recLimit"];
		   }else{
			   $globalRecLimit=1;
		   }
		   if($globalRecDepth < $globalRecLimit){
			  $dynamicFunctName="RMF_{$v}_VALIDATE";
			  $ret=($ret && $dynamicFunctName($dat[$k]));
		   }
	   }
	   $dynamicFunctName="RMF_TBL_WAArenderBlog_categoryTies_EXTRAVALIDATE";
	   if(function_exists($dynamicFunctName) && $fullCall){
			$ret=($ret && $dynamicFunctName($dat));
	   }
	   $TBL_WAArenderBlog_categoryTies_VALIDATE_recDepth--;
	   return $ret;
	
}

function RMF_TBL_WAArenderBlog_categoryTies_EXTRAFILTER(&$dat){

}


		$TBL_WAArenderBlog_categoryTies_FILTER_recDepth=-1;
		$TBL_WAArenderBlog_categoryTies_FILTER_recLimit=1;
	function RMF_TBL_WAArenderBlog_categoryTies_FILTER(&$dat, $fullCall=0){

		global $TBL_WAArenderBlog_categoryTies_FILTER_recDepth;
		global $TBL_WAArenderBlog_categoryTies_FILTER_recLimit;
		if($TBL_WAArenderBlog_categoryTies_FILTER_recDepth > $TBL_WAArenderBlog_categoryTies_FILTER_recLimit){
			return "filterCallLimit";
		}
		$TBL_WAArenderBlog_categoryTies_FILTER_recDepth++;
		$keyTypeArray=json_decode('{"article":"TBL_WAArenderBlog_articles","category":"TBL_WAArenderBlog_categories","pk":"basicPk"}',true);
		if(!is_null($dat)){
		   foreach($keyTypeArray as $k=>$v)
		   {
			   if(isset($_GLOBALS["{$v}_FILTER_recDepth"])){
				   $globalRecDepth=$_GLOBALS["{$v}_FILTER_recDepth"];
			   }else{
				   $globalRecDepth=-1;
			   }
			   if(isset($_GLOBALS["{$v}_FILTER_recLimit"])){
				   $globalRecLimit=$_GLOBALS["{$v}_FILTER_recLimit"];
			   }else{
				   $globalRecLimit=1;
			   }
			   if($globalRecDepth < $globalRecLimit){
				$dynamicFunctName="RMF_{$v}_FILTER";
				$dynamicFunctName($dat[$k]);
			   }
		   }
		}
	   $dynamicFunctName="RMF_TBL_WAArenderBlog_categoryTies_EXTRAFILTER";
	   if(function_exists($dynamicFunctName) && $fullCall){
			$dynamicFunctName($dat);
	   }
	   $TBL_WAArenderBlog_categoryTies_FILTER_recDepth--;
	
}

function RMF_TBL_WAArenderBlog_categoryTies_FILTERVALIDATE(&$dat, $fullCall=0){

	RMF_TBL_WAArenderBlog_categoryTies_FILTER($dat, $fullCall);
	return RMF_TBL_WAArenderBlog_categoryTies_VALIDATE($dat, $fullCall);
}


		$TBL_WAArenderBlog_categoryTies_RESOLVE_recDepth=-1;
		$TBL_WAArenderBlog_categoryTies_RESOLVE_recLimit=1;
	function RMF_TBL_WAArenderBlog_categoryTies_RESOLVE(&$dat){

		global $sqlConn;
		global $TBL_WAArenderBlog_categoryTies_RESOLVE_recDepth;
		global $TBL_WAArenderBlog_categoryTies_RESOLVE_recLimit;
		$whereArr=[];
		$whereTypeArr=[];
		$whereVarArr=[];
		
		if($TBL_WAArenderBlog_categoryTies_RESOLVE_recDepth>$TBL_WAArenderBlog_categoryTies_RESOLVE_recLimit){return 'callLimit';}
		
		$TBL_WAArenderBlog_categoryTies_RESOLVE_recDepth++;
		
	
				if(!isset($GLOBALS['TBL_WAArenderBlog_articles_RESOLVE_recDepth'])){
					$GLOBALS['TBL_WAArenderBlog_articles_RESOLVE_recDepth']=-1;
				}
				if(!isset($GLOBALS['TBL_WAArenderBlog_articles_RESOLVE_recLimit'])){
					$GLOBALS['TBL_WAArenderBlog_articles_RESOLVE_recLimit']=1;
				}
				if(OBSANE($dat, 'article') && $GLOBALS['TBL_WAArenderBlog_articles_RESOLVE_recDepth'] < $GLOBALS['TBL_WAArenderBlog_articles_RESOLVE_recLimit']){
					$reso=RMF_TBL_WAArenderBlog_articles_RESOLVE($dat['article']);
					if($reso === ''){
						array_push($whereArr,'article=?');
						array_push($whereTypeArr,'i');
						$article=$dat['article']['pk'];
						array_push($whereVarArr,$article);
					}else if($reso !== 'empty'){
						return 'sub object fail '.$reso;
					}
				}
			
				if(!isset($GLOBALS['TBL_WAArenderBlog_categories_RESOLVE_recDepth'])){
					$GLOBALS['TBL_WAArenderBlog_categories_RESOLVE_recDepth']=-1;
				}
				if(!isset($GLOBALS['TBL_WAArenderBlog_categories_RESOLVE_recLimit'])){
					$GLOBALS['TBL_WAArenderBlog_categories_RESOLVE_recLimit']=1;
				}
				if(OBSANE($dat, 'category') && $GLOBALS['TBL_WAArenderBlog_categories_RESOLVE_recDepth'] < $GLOBALS['TBL_WAArenderBlog_categories_RESOLVE_recLimit']){
					$reso=RMF_TBL_WAArenderBlog_categories_RESOLVE($dat['category']);
					if($reso === ''){
						array_push($whereArr,'category=?');
						array_push($whereTypeArr,'i');
						$category=$dat['category']['pk'];
						array_push($whereVarArr,$category);
					}else if($reso !== 'empty'){
						return 'sub object fail '.$reso;
					}
				}
			
				if(OBSANE($dat, 'pk')){
					
					array_push($whereArr,'pk=?');
					array_push($whereTypeArr,'s');
					$pk=$dat['pk'];
					array_push($whereVarArr,$pk);
					
				}
			
		if(!count($whereArr)){return 'empty';}
		$statement=$sqlConn->prepare(
			'SELECT * FROM WAArenderBlog.categoryTies
			WHERE '.implode(' AND ', $whereArr).'
			
			'
		);
		$statement->bind_param(implode('', $whereTypeArr),...$whereVarArr);
		$statement->execute();
		$result=$statement->get_result();
		$allArr=mysqli_fetch_all($result, MYSQLI_ASSOC);
		$allArrCount=count($allArr);
		if($allArrCount === 0){
			return 'no result';
		}else if($allArrCount > 1){
			return 'failed because too many: '.$allArrCount;
		}
		
		$res=$allArr[0];
		
	
				if(OBSANE($res , 'article') && $GLOBALS['TBL_WAArenderBlog_articles_RESOLVE_recDepth'] < $GLOBALS['TBL_WAArenderBlog_articles_RESOLVE_recLimit']){
					$res['article']=['pk'=>$res['article']];
					RMF_TBL_WAArenderBlog_articles_RESOLVE($res['article']);
					$dat['article']=$res['article'];
				}
			
				if(OBSANE($res , 'category') && $GLOBALS['TBL_WAArenderBlog_categories_RESOLVE_recDepth'] < $GLOBALS['TBL_WAArenderBlog_categories_RESOLVE_recLimit']){
					$res['category']=['pk'=>$res['category']];
					RMF_TBL_WAArenderBlog_categories_RESOLVE($res['category']);
					$dat['category']=$res['category'];
				}
			
				if(OBSANE($res , 'pk')){
					$dat['pk']=$res['pk'];
				}
			
		$TBL_WAArenderBlog_categoryTies_RESOLVE_recDepth--;
		return '';
	
}

 
		$TBL_WAArenderBlog_categoryTies_SQLITE_RESOLVE_recDepth=-1;
		$TBL_WAArenderBlog_categoryTies_SQLITE_RESOLVE_recLimit=1;
	function RMF_TBL_WAArenderBlog_categoryTies_SQLITE_RESOLVE($sqlite, &$dat){

		global $TBL_WAArenderBlog_categoryTies_SQLITE_RESOLVE_recDepth;
		global $TBL_WAArenderBlog_categoryTies_SQLITE_RESOLVE_recLimit;
		$whereArr=[];
		$whereTypeArr=[];
		$whereVarArr=[];
		$bindArr=[];
		
		
		if($TBL_WAArenderBlog_categoryTies_SQLITE_RESOLVE_recDepth>$TBL_WAArenderBlog_categoryTies_SQLITE_RESOLVE_recLimit){return 'callLimit';}
		
		$TBL_WAArenderBlog_categoryTies_SQLITE_RESOLVE_recDepth++;
		
	
				if(!isset($GLOBALS['TBL_WAArenderBlog_articles_SQLITE_RESOLVE_recDepth'])){
					$GLOBALS['TBL_WAArenderBlog_articles_SQLITE_RESOLVE_recDepth']=-1;
				}
				if(!isset($GLOBALS['TBL_WAArenderBlog_articles_SQLITE_RESOLVE_recLimit'])){
					$GLOBALS['TBL_WAArenderBlog_articles_SQLITE_RESOLVE_recLimit']=1;
				}
				if(OBSANE($dat, 'article') && $GLOBALS['TBL_WAArenderBlog_articles_SQLITE_RESOLVE_recDepth'] < $GLOBALS['TBL_WAArenderBlog_articles_SQLITE_RESOLVE_recLimit']){
					$reso=RMF_TBL_WAArenderBlog_articles_SQLITE_RESOLVE($sqlite, $dat['article']);
					if($reso === ''){
						array_push($whereArr,'article=:article');
						array_push($bindArr, [
							'type'=>SQLITE3_INTEGER,
							'tag'=>':article',
							'value'=>$dat['article']['pk']
						]);
					}else if($reso !== 'empty'){
						return 'sub object fail '.$reso;
					}
				}
			
				if(!isset($GLOBALS['TBL_WAArenderBlog_categories_SQLITE_RESOLVE_recDepth'])){
					$GLOBALS['TBL_WAArenderBlog_categories_SQLITE_RESOLVE_recDepth']=-1;
				}
				if(!isset($GLOBALS['TBL_WAArenderBlog_categories_SQLITE_RESOLVE_recLimit'])){
					$GLOBALS['TBL_WAArenderBlog_categories_SQLITE_RESOLVE_recLimit']=1;
				}
				if(OBSANE($dat, 'category') && $GLOBALS['TBL_WAArenderBlog_categories_SQLITE_RESOLVE_recDepth'] < $GLOBALS['TBL_WAArenderBlog_categories_SQLITE_RESOLVE_recLimit']){
					$reso=RMF_TBL_WAArenderBlog_categories_SQLITE_RESOLVE($sqlite, $dat['category']);
					if($reso === ''){
						array_push($whereArr,'category=:category');
						array_push($bindArr, [
							'type'=>SQLITE3_INTEGER,
							'tag'=>':category',
							'value'=>$dat['category']['pk']
						]);
					}else if($reso !== 'empty'){
						return 'sub object fail '.$reso;
					}
				}
			
				if(OBSANE($dat, 'pk')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':pk',
						'value'=>$dat['pk']
					]);
					array_push($whereArr,'pk=:pk');
					
				}
			
		if(!count($whereArr)){return 'empty';}
		$statement=$sqlite->prepare(
			'SELECT * FROM categoryTies
			WHERE '.implode(' AND ', $whereArr).'
			
			'
		);
		foreach($bindArr as $ba)
		{
			$statement->bindValue($ba['tag'], $ba['value'], $ba['type']);
		}
		$result=$statement->execute();
		$allArr=[];
		while($row=$result->fetchArray(SQLITE3_ASSOC))
		{
			array_push($allArr, $row);
		}
		$allArrCount=count($allArr);
		if($allArrCount === 0){
			return 'no result';
		}else if($allArrCount > 1){
			return 'failed because too many: '.$allArrCount;
		}
		
		$res=$allArr[0];
		
	
				if(OBSANE($res , 'article')){
					$res['article']=['pk'=>$res['article']];
					if($GLOBALS['TBL_WAArenderBlog_articles_SQLITE_RESOLVE_recDepth'] < $GLOBALS['TBL_WAArenderBlog_articles_SQLITE_RESOLVE_recLimit']){
						RMF_TBL_WAArenderBlog_articles_SQLITE_RESOLVE($sqlite, $res['article']);
					}
					$dat['article']=$res['article'];
				}else{
					$dat['article']=null;
				}
			
				if(OBSANE($res , 'category')){
					$res['category']=['pk'=>$res['category']];
					if($GLOBALS['TBL_WAArenderBlog_categories_SQLITE_RESOLVE_recDepth'] < $GLOBALS['TBL_WAArenderBlog_categories_SQLITE_RESOLVE_recLimit']){
						RMF_TBL_WAArenderBlog_categories_SQLITE_RESOLVE($sqlite, $res['category']);
					}
					$dat['category']=$res['category'];
				}else{
					$dat['category']=null;
				}
			
				if(OBSANE($res , 'pk')){
					$dat['pk']=$res['pk'];
				}else{
					$dat['pk']=null;
				}
			
		$TBL_WAArenderBlog_categoryTies_SQLITE_RESOLVE_recDepth--;
		return '';
	
}
?>