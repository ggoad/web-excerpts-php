<?php
require_once(__DIR__.'/../para/validation.php');
require_once(__DIR__.'/../date_time/validation.php');
require_once(__DIR__.'/../basicPk/validation.php');
require_once(__DIR__.'/../boolean/validation.php');
require_once(__DIR__.'/../string/validation.php');


function RMF_TBL_WAArenderBlog_articles_EXTRAVALIDATE($dat){
return true;
}


		$TBL_WAArenderBlog_articles_VALIDATION_recDepth=-1;
		$TBL_WAArenderBlog_articles_VALIDATION_recLimit=1;
	function RMF_TBL_WAArenderBlog_articles_VALIDATE($dat, $fullCall=0){

		global $TBL_WAArenderBlog_articles_VALIDATE_recDepth;
		global $TBL_WAArenderBlog_articles_VALIDATE_recLimit;
		if( $TBL_WAArenderBlog_articles_VALIDATE_recDepth>$TBL_WAArenderBlog_articles_VALIDATE_recLimit){
			return "validateCallLimit";
		}
		$TBL_WAArenderBlog_articles_VALIDATE_recDepth++;
		$keyTypeArray=json_decode('{"article":"para","auds":"para","css":"para","description":"para","igniter":"para","imgs":"para","js":"para","lastModified":"date_time","meta":"para","pk":"basicPk","published":"boolean","scripts":"para","slug":"string","sortDate":"date_time","timePublished":"date_time","title":"string","vids":"para"}',true);
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
	   $dynamicFunctName="RMF_TBL_WAArenderBlog_articles_EXTRAVALIDATE";
	   if(function_exists($dynamicFunctName) && $fullCall){
			$ret=($ret && $dynamicFunctName($dat));
	   }
	   $TBL_WAArenderBlog_articles_VALIDATE_recDepth--;
	   return $ret;
	
}

function RMF_TBL_WAArenderBlog_articles_EXTRAFILTER(&$dat){

}


		$TBL_WAArenderBlog_articles_FILTER_recDepth=-1;
		$TBL_WAArenderBlog_articles_FILTER_recLimit=1;
	function RMF_TBL_WAArenderBlog_articles_FILTER(&$dat, $fullCall=0){

		global $TBL_WAArenderBlog_articles_FILTER_recDepth;
		global $TBL_WAArenderBlog_articles_FILTER_recLimit;
		if($TBL_WAArenderBlog_articles_FILTER_recDepth > $TBL_WAArenderBlog_articles_FILTER_recLimit){
			return "filterCallLimit";
		}
		$TBL_WAArenderBlog_articles_FILTER_recDepth++;
		$keyTypeArray=json_decode('{"article":"para","auds":"para","css":"para","description":"para","igniter":"para","imgs":"para","js":"para","lastModified":"date_time","meta":"para","pk":"basicPk","published":"boolean","scripts":"para","slug":"string","sortDate":"date_time","timePublished":"date_time","title":"string","vids":"para"}',true);
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
	   $dynamicFunctName="RMF_TBL_WAArenderBlog_articles_EXTRAFILTER";
	   if(function_exists($dynamicFunctName) && $fullCall){
			$dynamicFunctName($dat);
	   }
	   $TBL_WAArenderBlog_articles_FILTER_recDepth--;
	
}

function RMF_TBL_WAArenderBlog_articles_FILTERVALIDATE(&$dat, $fullCall=0){

	RMF_TBL_WAArenderBlog_articles_FILTER($dat, $fullCall);
	return RMF_TBL_WAArenderBlog_articles_VALIDATE($dat, $fullCall);
}


		$TBL_WAArenderBlog_articles_RESOLVE_recDepth=-1;
		$TBL_WAArenderBlog_articles_RESOLVE_recLimit=1;
	function RMF_TBL_WAArenderBlog_articles_RESOLVE(&$dat){

		global $sqlConn;
		global $TBL_WAArenderBlog_articles_RESOLVE_recDepth;
		global $TBL_WAArenderBlog_articles_RESOLVE_recLimit;
		$whereArr=[];
		$whereTypeArr=[];
		$whereVarArr=[];
		
		if($TBL_WAArenderBlog_articles_RESOLVE_recDepth>$TBL_WAArenderBlog_articles_RESOLVE_recLimit){return 'callLimit';}
		
		$TBL_WAArenderBlog_articles_RESOLVE_recDepth++;
		
	
				if(OBSANE($dat, 'article')){
					
					array_push($whereArr,'article=?');
					array_push($whereTypeArr,'s');
					$article=$dat['article'];
					array_push($whereVarArr,$article);
					
				}
			
				if(OBSANE($dat, 'auds')){
					
					array_push($whereArr,'auds=?');
					array_push($whereTypeArr,'s');
					$auds=$dat['auds'];
					array_push($whereVarArr,$auds);
					
				}
			
				if(OBSANE($dat, 'css')){
					
					array_push($whereArr,'css=?');
					array_push($whereTypeArr,'s');
					$css=$dat['css'];
					array_push($whereVarArr,$css);
					
				}
			
				if(OBSANE($dat, 'description')){
					
					array_push($whereArr,'description=?');
					array_push($whereTypeArr,'s');
					$description=$dat['description'];
					array_push($whereVarArr,$description);
					
				}
			
				if(OBSANE($dat, 'igniter')){
					
					array_push($whereArr,'igniter=?');
					array_push($whereTypeArr,'s');
					$igniter=$dat['igniter'];
					array_push($whereVarArr,$igniter);
					
				}
			
				if(OBSANE($dat, 'imgs')){
					
					array_push($whereArr,'imgs=?');
					array_push($whereTypeArr,'s');
					$imgs=$dat['imgs'];
					array_push($whereVarArr,$imgs);
					
				}
			
				if(OBSANE($dat, 'js')){
					
					array_push($whereArr,'js=?');
					array_push($whereTypeArr,'s');
					$js=$dat['js'];
					array_push($whereVarArr,$js);
					
				}
			
				if(OBSANE($dat, 'lastModified')){
					
					array_push($whereArr,'lastModified=?');
					array_push($whereTypeArr,'s');
					$lastModified=$dat['lastModified'];
					array_push($whereVarArr,$lastModified);
					
				}
			
				if(OBSANE($dat, 'meta')){
					
					array_push($whereArr,'meta=?');
					array_push($whereTypeArr,'s');
					$meta=$dat['meta'];
					array_push($whereVarArr,$meta);
					
				}
			
				if(OBSANE($dat, 'pk')){
					
					array_push($whereArr,'pk=?');
					array_push($whereTypeArr,'s');
					$pk=$dat['pk'];
					array_push($whereVarArr,$pk);
					
				}
			
				if(OBSANE($dat, 'published')){
					
					array_push($whereArr,'published=?');
					array_push($whereTypeArr,'s');
					$published=$dat['published'];
					array_push($whereVarArr,$published);
					
				}
			
				if(OBSANE($dat, 'scripts')){
					
					array_push($whereArr,'scripts=?');
					array_push($whereTypeArr,'s');
					$scripts=$dat['scripts'];
					array_push($whereVarArr,$scripts);
					
				}
			
				if(OBSANE($dat, 'slug')){
					
					array_push($whereArr,'slug=?');
					array_push($whereTypeArr,'s');
					$slug=$dat['slug'];
					array_push($whereVarArr,$slug);
					
				}
			
				if(OBSANE($dat, 'sortDate')){
					
					array_push($whereArr,'sortDate=?');
					array_push($whereTypeArr,'s');
					$sortDate=$dat['sortDate'];
					array_push($whereVarArr,$sortDate);
					
				}
			
				if(OBSANE($dat, 'timePublished')){
					
					array_push($whereArr,'timePublished=?');
					array_push($whereTypeArr,'s');
					$timePublished=$dat['timePublished'];
					array_push($whereVarArr,$timePublished);
					
				}
			
				if(OBSANE($dat, 'title')){
					
					array_push($whereArr,'title=?');
					array_push($whereTypeArr,'s');
					$title=$dat['title'];
					array_push($whereVarArr,$title);
					
				}
			
				if(OBSANE($dat, 'vids')){
					
					array_push($whereArr,'vids=?');
					array_push($whereTypeArr,'s');
					$vids=$dat['vids'];
					array_push($whereVarArr,$vids);
					
				}
			
		if(!count($whereArr)){return 'empty';}
		$statement=$sqlConn->prepare(
			'SELECT * FROM WAArenderBlog.articles
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
		
	
				if(OBSANE($res , 'article')){
					$dat['article']=$res['article'];
				}
			
				if(OBSANE($res , 'auds')){
					$dat['auds']=$res['auds'];
				}
			
				if(OBSANE($res , 'css')){
					$dat['css']=$res['css'];
				}
			
				if(OBSANE($res , 'description')){
					$dat['description']=$res['description'];
				}
			
				if(OBSANE($res , 'igniter')){
					$dat['igniter']=$res['igniter'];
				}
			
				if(OBSANE($res , 'imgs')){
					$dat['imgs']=$res['imgs'];
				}
			
				if(OBSANE($res , 'js')){
					$dat['js']=$res['js'];
				}
			
				if(OBSANE($res , 'lastModified')){
					$dat['lastModified']=$res['lastModified'];
				}
			
				if(OBSANE($res , 'meta')){
					$dat['meta']=$res['meta'];
				}
			
				if(OBSANE($res , 'pk')){
					$dat['pk']=$res['pk'];
				}
			
				if(OBSANE($res , 'published')){
					$dat['published']=$res['published'];
				}
			
				if(OBSANE($res , 'scripts')){
					$dat['scripts']=$res['scripts'];
				}
			
				if(OBSANE($res , 'slug')){
					$dat['slug']=$res['slug'];
				}
			
				if(OBSANE($res , 'sortDate')){
					$dat['sortDate']=$res['sortDate'];
				}
			
				if(OBSANE($res , 'timePublished')){
					$dat['timePublished']=$res['timePublished'];
				}
			
				if(OBSANE($res , 'title')){
					$dat['title']=$res['title'];
				}
			
				if(OBSANE($res , 'vids')){
					$dat['vids']=$res['vids'];
				}
			
		$TBL_WAArenderBlog_articles_RESOLVE_recDepth--;
		return '';
	
}

 
		$TBL_WAArenderBlog_articles_SQLITE_RESOLVE_recDepth=-1;
		$TBL_WAArenderBlog_articles_SQLITE_RESOLVE_recLimit=1;
	function RMF_TBL_WAArenderBlog_articles_SQLITE_RESOLVE($sqlite, &$dat){

		global $TBL_WAArenderBlog_articles_SQLITE_RESOLVE_recDepth;
		global $TBL_WAArenderBlog_articles_SQLITE_RESOLVE_recLimit;
		$whereArr=[];
		$whereTypeArr=[];
		$whereVarArr=[];
		$bindArr=[];
		
		
		if($TBL_WAArenderBlog_articles_SQLITE_RESOLVE_recDepth>$TBL_WAArenderBlog_articles_SQLITE_RESOLVE_recLimit){return 'callLimit';}
		
		$TBL_WAArenderBlog_articles_SQLITE_RESOLVE_recDepth++;
		
	
				if(OBSANE($dat, 'article')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':article',
						'value'=>$dat['article']
					]);
					array_push($whereArr,'article=:article');
					
				}
			
				if(OBSANE($dat, 'auds')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':auds',
						'value'=>$dat['auds']
					]);
					array_push($whereArr,'auds=:auds');
					
				}
			
				if(OBSANE($dat, 'css')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':css',
						'value'=>$dat['css']
					]);
					array_push($whereArr,'css=:css');
					
				}
			
				if(OBSANE($dat, 'description')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':description',
						'value'=>$dat['description']
					]);
					array_push($whereArr,'description=:description');
					
				}
			
				if(OBSANE($dat, 'igniter')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':igniter',
						'value'=>$dat['igniter']
					]);
					array_push($whereArr,'igniter=:igniter');
					
				}
			
				if(OBSANE($dat, 'imgs')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':imgs',
						'value'=>$dat['imgs']
					]);
					array_push($whereArr,'imgs=:imgs');
					
				}
			
				if(OBSANE($dat, 'js')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':js',
						'value'=>$dat['js']
					]);
					array_push($whereArr,'js=:js');
					
				}
			
				if(OBSANE($dat, 'lastModified')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':lastModified',
						'value'=>$dat['lastModified']
					]);
					array_push($whereArr,'lastModified=:lastModified');
					
				}
			
				if(OBSANE($dat, 'meta')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':meta',
						'value'=>$dat['meta']
					]);
					array_push($whereArr,'meta=:meta');
					
				}
			
				if(OBSANE($dat, 'pk')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':pk',
						'value'=>$dat['pk']
					]);
					array_push($whereArr,'pk=:pk');
					
				}
			
				if(OBSANE($dat, 'published')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':published',
						'value'=>$dat['published']
					]);
					array_push($whereArr,'published=:published');
					
				}
			
				if(OBSANE($dat, 'scripts')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':scripts',
						'value'=>$dat['scripts']
					]);
					array_push($whereArr,'scripts=:scripts');
					
				}
			
				if(OBSANE($dat, 'slug')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':slug',
						'value'=>$dat['slug']
					]);
					array_push($whereArr,'slug=:slug');
					
				}
			
				if(OBSANE($dat, 'sortDate')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':sortDate',
						'value'=>$dat['sortDate']
					]);
					array_push($whereArr,'sortDate=:sortDate');
					
				}
			
				if(OBSANE($dat, 'timePublished')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':timePublished',
						'value'=>$dat['timePublished']
					]);
					array_push($whereArr,'timePublished=:timePublished');
					
				}
			
				if(OBSANE($dat, 'title')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':title',
						'value'=>$dat['title']
					]);
					array_push($whereArr,'title=:title');
					
				}
			
				if(OBSANE($dat, 'vids')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':vids',
						'value'=>$dat['vids']
					]);
					array_push($whereArr,'vids=:vids');
					
				}
			
		if(!count($whereArr)){return 'empty';}
		$statement=$sqlite->prepare(
			'SELECT * FROM articles
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
					$dat['article']=$res['article'];
				}else{
					$dat['article']=null;
				}
			
				if(OBSANE($res , 'auds')){
					$dat['auds']=$res['auds'];
				}else{
					$dat['auds']=null;
				}
			
				if(OBSANE($res , 'css')){
					$dat['css']=$res['css'];
				}else{
					$dat['css']=null;
				}
			
				if(OBSANE($res , 'description')){
					$dat['description']=$res['description'];
				}else{
					$dat['description']=null;
				}
			
				if(OBSANE($res , 'igniter')){
					$dat['igniter']=$res['igniter'];
				}else{
					$dat['igniter']=null;
				}
			
				if(OBSANE($res , 'imgs')){
					$dat['imgs']=$res['imgs'];
				}else{
					$dat['imgs']=null;
				}
			
				if(OBSANE($res , 'js')){
					$dat['js']=$res['js'];
				}else{
					$dat['js']=null;
				}
			
				if(OBSANE($res , 'lastModified')){
					$dat['lastModified']=$res['lastModified'];
				}else{
					$dat['lastModified']=null;
				}
			
				if(OBSANE($res , 'meta')){
					$dat['meta']=$res['meta'];
				}else{
					$dat['meta']=null;
				}
			
				if(OBSANE($res , 'pk')){
					$dat['pk']=$res['pk'];
				}else{
					$dat['pk']=null;
				}
			
				if(OBSANE($res , 'published')){
					$dat['published']=$res['published'];
				}else{
					$dat['published']=null;
				}
			
				if(OBSANE($res , 'scripts')){
					$dat['scripts']=$res['scripts'];
				}else{
					$dat['scripts']=null;
				}
			
				if(OBSANE($res , 'slug')){
					$dat['slug']=$res['slug'];
				}else{
					$dat['slug']=null;
				}
			
				if(OBSANE($res , 'sortDate')){
					$dat['sortDate']=$res['sortDate'];
				}else{
					$dat['sortDate']=null;
				}
			
				if(OBSANE($res , 'timePublished')){
					$dat['timePublished']=$res['timePublished'];
				}else{
					$dat['timePublished']=null;
				}
			
				if(OBSANE($res , 'title')){
					$dat['title']=$res['title'];
				}else{
					$dat['title']=null;
				}
			
				if(OBSANE($res , 'vids')){
					$dat['vids']=$res['vids'];
				}else{
					$dat['vids']=null;
				}
			
		$TBL_WAArenderBlog_articles_SQLITE_RESOLVE_recDepth--;
		return '';
	
}
?>