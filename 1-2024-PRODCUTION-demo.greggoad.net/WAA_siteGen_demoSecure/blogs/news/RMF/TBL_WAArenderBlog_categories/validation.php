<?php
require_once(__DIR__.'/../para/validation.php');
require_once(__DIR__.'/../string/validation.php');
require_once(__DIR__.'/../basicPk/validation.php');


function RMF_TBL_WAArenderBlog_categories_EXTRAVALIDATE($dat){
return true;
}


		$TBL_WAArenderBlog_categories_VALIDATION_recDepth=-1;
		$TBL_WAArenderBlog_categories_VALIDATION_recLimit=1;
	function RMF_TBL_WAArenderBlog_categories_VALIDATE($dat, $fullCall=0){

		global $TBL_WAArenderBlog_categories_VALIDATE_recDepth;
		global $TBL_WAArenderBlog_categories_VALIDATE_recLimit;
		if( $TBL_WAArenderBlog_categories_VALIDATE_recDepth>$TBL_WAArenderBlog_categories_VALIDATE_recLimit){
			return "validateCallLimit";
		}
		$TBL_WAArenderBlog_categories_VALIDATE_recDepth++;
		$keyTypeArray=json_decode('{"description":"para","name":"string","pk":"basicPk","shareImage":"para","slug":"string"}',true);
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
	   $dynamicFunctName="RMF_TBL_WAArenderBlog_categories_EXTRAVALIDATE";
	   if(function_exists($dynamicFunctName) && $fullCall){
			$ret=($ret && $dynamicFunctName($dat));
	   }
	   $TBL_WAArenderBlog_categories_VALIDATE_recDepth--;
	   return $ret;
	
}

function RMF_TBL_WAArenderBlog_categories_EXTRAFILTER(&$dat){

}


		$TBL_WAArenderBlog_categories_FILTER_recDepth=-1;
		$TBL_WAArenderBlog_categories_FILTER_recLimit=1;
	function RMF_TBL_WAArenderBlog_categories_FILTER(&$dat, $fullCall=0){

		global $TBL_WAArenderBlog_categories_FILTER_recDepth;
		global $TBL_WAArenderBlog_categories_FILTER_recLimit;
		if($TBL_WAArenderBlog_categories_FILTER_recDepth > $TBL_WAArenderBlog_categories_FILTER_recLimit){
			return "filterCallLimit";
		}
		$TBL_WAArenderBlog_categories_FILTER_recDepth++;
		$keyTypeArray=json_decode('{"description":"para","name":"string","pk":"basicPk","shareImage":"para","slug":"string"}',true);
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
	   $dynamicFunctName="RMF_TBL_WAArenderBlog_categories_EXTRAFILTER";
	   if(function_exists($dynamicFunctName) && $fullCall){
			$dynamicFunctName($dat);
	   }
	   $TBL_WAArenderBlog_categories_FILTER_recDepth--;
	
}

function RMF_TBL_WAArenderBlog_categories_FILTERVALIDATE(&$dat, $fullCall=0){

	RMF_TBL_WAArenderBlog_categories_FILTER($dat, $fullCall);
	return RMF_TBL_WAArenderBlog_categories_VALIDATE($dat, $fullCall);
}


		$TBL_WAArenderBlog_categories_RESOLVE_recDepth=-1;
		$TBL_WAArenderBlog_categories_RESOLVE_recLimit=1;
	function RMF_TBL_WAArenderBlog_categories_RESOLVE(&$dat){

		global $sqlConn;
		global $TBL_WAArenderBlog_categories_RESOLVE_recDepth;
		global $TBL_WAArenderBlog_categories_RESOLVE_recLimit;
		$whereArr=[];
		$whereTypeArr=[];
		$whereVarArr=[];
		
		if($TBL_WAArenderBlog_categories_RESOLVE_recDepth>$TBL_WAArenderBlog_categories_RESOLVE_recLimit){return 'callLimit';}
		
		$TBL_WAArenderBlog_categories_RESOLVE_recDepth++;
		
	
				if(OBSANE($dat, 'description')){
					
					array_push($whereArr,'description=?');
					array_push($whereTypeArr,'s');
					$description=$dat['description'];
					array_push($whereVarArr,$description);
					
				}
			
				if(OBSANE($dat, 'name')){
					
					array_push($whereArr,'name=?');
					array_push($whereTypeArr,'s');
					$name=$dat['name'];
					array_push($whereVarArr,$name);
					
				}
			
				if(OBSANE($dat, 'pk')){
					
					array_push($whereArr,'pk=?');
					array_push($whereTypeArr,'s');
					$pk=$dat['pk'];
					array_push($whereVarArr,$pk);
					
				}
			
				if(OBSANE($dat, 'shareImage')){
					
					array_push($whereArr,'shareImage=?');
					array_push($whereTypeArr,'s');
					$shareImage=$dat['shareImage'];
					array_push($whereVarArr,$shareImage);
					
				}
			
				if(OBSANE($dat, 'slug')){
					
					array_push($whereArr,'slug=?');
					array_push($whereTypeArr,'s');
					$slug=$dat['slug'];
					array_push($whereVarArr,$slug);
					
				}
			
		if(!count($whereArr)){return 'empty';}
		$statement=$sqlConn->prepare(
			'SELECT * FROM WAArenderBlog.categories
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
		
	
				if(OBSANE($res , 'description')){
					$dat['description']=$res['description'];
				}
			
				if(OBSANE($res , 'name')){
					$dat['name']=$res['name'];
				}
			
				if(OBSANE($res , 'pk')){
					$dat['pk']=$res['pk'];
				}
			
				if(OBSANE($res , 'shareImage')){
					$dat['shareImage']=$res['shareImage'];
				}
			
				if(OBSANE($res , 'slug')){
					$dat['slug']=$res['slug'];
				}
			
		$TBL_WAArenderBlog_categories_RESOLVE_recDepth--;
		return '';
	
}

 
		$TBL_WAArenderBlog_categories_SQLITE_RESOLVE_recDepth=-1;
		$TBL_WAArenderBlog_categories_SQLITE_RESOLVE_recLimit=1;
	function RMF_TBL_WAArenderBlog_categories_SQLITE_RESOLVE($sqlite, &$dat){

		global $TBL_WAArenderBlog_categories_SQLITE_RESOLVE_recDepth;
		global $TBL_WAArenderBlog_categories_SQLITE_RESOLVE_recLimit;
		$whereArr=[];
		$whereTypeArr=[];
		$whereVarArr=[];
		$bindArr=[];
		
		
		if($TBL_WAArenderBlog_categories_SQLITE_RESOLVE_recDepth>$TBL_WAArenderBlog_categories_SQLITE_RESOLVE_recLimit){return 'callLimit';}
		
		$TBL_WAArenderBlog_categories_SQLITE_RESOLVE_recDepth++;
		
	
				if(OBSANE($dat, 'description')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':description',
						'value'=>$dat['description']
					]);
					array_push($whereArr,'description=:description');
					
				}
			
				if(OBSANE($dat, 'name')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':name',
						'value'=>$dat['name']
					]);
					array_push($whereArr,'name=:name');
					
				}
			
				if(OBSANE($dat, 'pk')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':pk',
						'value'=>$dat['pk']
					]);
					array_push($whereArr,'pk=:pk');
					
				}
			
				if(OBSANE($dat, 'shareImage')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':shareImage',
						'value'=>$dat['shareImage']
					]);
					array_push($whereArr,'shareImage=:shareImage');
					
				}
			
				if(OBSANE($dat, 'slug')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':slug',
						'value'=>$dat['slug']
					]);
					array_push($whereArr,'slug=:slug');
					
				}
			
		if(!count($whereArr)){return 'empty';}
		$statement=$sqlite->prepare(
			'SELECT * FROM categories
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
		
	
				if(OBSANE($res , 'description')){
					$dat['description']=$res['description'];
				}else{
					$dat['description']=null;
				}
			
				if(OBSANE($res , 'name')){
					$dat['name']=$res['name'];
				}else{
					$dat['name']=null;
				}
			
				if(OBSANE($res , 'pk')){
					$dat['pk']=$res['pk'];
				}else{
					$dat['pk']=null;
				}
			
				if(OBSANE($res , 'shareImage')){
					$dat['shareImage']=$res['shareImage'];
				}else{
					$dat['shareImage']=null;
				}
			
				if(OBSANE($res , 'slug')){
					$dat['slug']=$res['slug'];
				}else{
					$dat['slug']=null;
				}
			
		$TBL_WAArenderBlog_categories_SQLITE_RESOLVE_recDepth--;
		return '';
	
}
?>