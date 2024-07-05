<?php
require_once(__DIR__.'/../string/validation.php');
require_once(__DIR__.'/../para/validation.php');
require_once(__DIR__.'/../integer/validation.php');
require_once(__DIR__.'/../basicPk/validation.php');
require_once(__DIR__.'/../date_time/validation.php');


function RMF_TBL_WAArenderContactForms_submissions_EXTRAVALIDATE($dat){
return true;
}


		$TBL_WAArenderContactForms_submissions_VALIDATION_recDepth=-1;
		$TBL_WAArenderContactForms_submissions_VALIDATION_recLimit=1;
	function RMF_TBL_WAArenderContactForms_submissions_VALIDATE($dat, $fullCall=0){

		global $TBL_WAArenderContactForms_submissions_VALIDATE_recDepth;
		global $TBL_WAArenderContactForms_submissions_VALIDATE_recLimit;
		if( $TBL_WAArenderContactForms_submissions_VALIDATE_recDepth>$TBL_WAArenderContactForms_submissions_VALIDATE_recLimit){
			return "validateCallLimit";
		}
		$TBL_WAArenderContactForms_submissions_VALIDATE_recDepth++;
		$keyTypeArray=json_decode('{"categoryState":"string","dat":"para","form":"string","ipAddress":"string","monthSubmitted":"integer","pk":"basicPk","timeSubmitted":"date_time","yearSubmitted":"integer"}',true);
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
	   $dynamicFunctName="RMF_TBL_WAArenderContactForms_submissions_EXTRAVALIDATE";
	   if(function_exists($dynamicFunctName) && $fullCall){
			$ret=($ret && $dynamicFunctName($dat));
	   }
	   $TBL_WAArenderContactForms_submissions_VALIDATE_recDepth--;
	   return $ret;
	
}

function RMF_TBL_WAArenderContactForms_submissions_EXTRAFILTER(&$dat){

}


		$TBL_WAArenderContactForms_submissions_FILTER_recDepth=-1;
		$TBL_WAArenderContactForms_submissions_FILTER_recLimit=1;
	function RMF_TBL_WAArenderContactForms_submissions_FILTER(&$dat, $fullCall=0){

		global $TBL_WAArenderContactForms_submissions_FILTER_recDepth;
		global $TBL_WAArenderContactForms_submissions_FILTER_recLimit;
		if($TBL_WAArenderContactForms_submissions_FILTER_recDepth > $TBL_WAArenderContactForms_submissions_FILTER_recLimit){
			return "filterCallLimit";
		}
		$TBL_WAArenderContactForms_submissions_FILTER_recDepth++;
		$keyTypeArray=json_decode('{"categoryState":"string","dat":"para","form":"string","ipAddress":"string","monthSubmitted":"integer","pk":"basicPk","timeSubmitted":"date_time","yearSubmitted":"integer"}',true);
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
	   $dynamicFunctName="RMF_TBL_WAArenderContactForms_submissions_EXTRAFILTER";
	   if(function_exists($dynamicFunctName) && $fullCall){
			$dynamicFunctName($dat);
	   }
	   $TBL_WAArenderContactForms_submissions_FILTER_recDepth--;
	
}

function RMF_TBL_WAArenderContactForms_submissions_FILTERVALIDATE(&$dat, $fullCall=0){

	RMF_TBL_WAArenderContactForms_submissions_FILTER($dat, $fullCall);
	return RMF_TBL_WAArenderContactForms_submissions_VALIDATE($dat, $fullCall);
}


		$TBL_WAArenderContactForms_submissions_RESOLVE_recDepth=-1;
		$TBL_WAArenderContactForms_submissions_RESOLVE_recLimit=1;
	function RMF_TBL_WAArenderContactForms_submissions_RESOLVE(&$dat){

		global $sqlConn;
		global $TBL_WAArenderContactForms_submissions_RESOLVE_recDepth;
		global $TBL_WAArenderContactForms_submissions_RESOLVE_recLimit;
		$whereArr=[];
		$whereTypeArr=[];
		$whereVarArr=[];
		
		if($TBL_WAArenderContactForms_submissions_RESOLVE_recDepth>$TBL_WAArenderContactForms_submissions_RESOLVE_recLimit){return 'callLimit';}
		
		$TBL_WAArenderContactForms_submissions_RESOLVE_recDepth++;
		
	
				if(OBSANE($dat, 'categoryState')){
					
					array_push($whereArr,'categoryState=?');
					array_push($whereTypeArr,'s');
					$categoryState=$dat['categoryState'];
					array_push($whereVarArr,$categoryState);
					
				}
			
				if(OBSANE($dat, 'dat')){
					
					array_push($whereArr,'dat=?');
					array_push($whereTypeArr,'s');
					$dat=$dat['dat'];
					array_push($whereVarArr,$dat);
					
				}
			
				if(OBSANE($dat, 'form')){
					
					array_push($whereArr,'form=?');
					array_push($whereTypeArr,'s');
					$form=$dat['form'];
					array_push($whereVarArr,$form);
					
				}
			
				if(OBSANE($dat, 'ipAddress')){
					
					array_push($whereArr,'ipAddress=?');
					array_push($whereTypeArr,'s');
					$ipAddress=$dat['ipAddress'];
					array_push($whereVarArr,$ipAddress);
					
				}
			
				if(OBSANE($dat, 'monthSubmitted')){
					
					array_push($whereArr,'monthSubmitted=?');
					array_push($whereTypeArr,'s');
					$monthSubmitted=$dat['monthSubmitted'];
					array_push($whereVarArr,$monthSubmitted);
					
				}
			
				if(OBSANE($dat, 'pk')){
					
					array_push($whereArr,'pk=?');
					array_push($whereTypeArr,'s');
					$pk=$dat['pk'];
					array_push($whereVarArr,$pk);
					
				}
			
				if(OBSANE($dat, 'timeSubmitted')){
					
					array_push($whereArr,'timeSubmitted=?');
					array_push($whereTypeArr,'s');
					$timeSubmitted=$dat['timeSubmitted'];
					array_push($whereVarArr,$timeSubmitted);
					
				}
			
				if(OBSANE($dat, 'yearSubmitted')){
					
					array_push($whereArr,'yearSubmitted=?');
					array_push($whereTypeArr,'s');
					$yearSubmitted=$dat['yearSubmitted'];
					array_push($whereVarArr,$yearSubmitted);
					
				}
			
		if(!count($whereArr)){return 'empty';}
		$statement=$sqlConn->prepare(
			'SELECT * FROM WAArenderContactForms.submissions
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
		
	
				if(OBSANE($res , 'categoryState')){
					$dat['categoryState']=$res['categoryState'];
				}
			
				if(OBSANE($res , 'dat')){
					$dat['dat']=$res['dat'];
				}
			
				if(OBSANE($res , 'form')){
					$dat['form']=$res['form'];
				}
			
				if(OBSANE($res , 'ipAddress')){
					$dat['ipAddress']=$res['ipAddress'];
				}
			
				if(OBSANE($res , 'monthSubmitted')){
					$dat['monthSubmitted']=$res['monthSubmitted'];
				}
			
				if(OBSANE($res , 'pk')){
					$dat['pk']=$res['pk'];
				}
			
				if(OBSANE($res , 'timeSubmitted')){
					$dat['timeSubmitted']=$res['timeSubmitted'];
				}
			
				if(OBSANE($res , 'yearSubmitted')){
					$dat['yearSubmitted']=$res['yearSubmitted'];
				}
			
		$TBL_WAArenderContactForms_submissions_RESOLVE_recDepth--;
		return '';
	
}

 
		$TBL_WAArenderContactForms_submissions_SQLITE_RESOLVE_recDepth=-1;
		$TBL_WAArenderContactForms_submissions_SQLITE_RESOLVE_recLimit=1;
	function RMF_TBL_WAArenderContactForms_submissions_SQLITE_RESOLVE($sqlite, &$dat){

		global $TBL_WAArenderContactForms_submissions_SQLITE_RESOLVE_recDepth;
		global $TBL_WAArenderContactForms_submissions_SQLITE_RESOLVE_recLimit;
		$whereArr=[];
		$whereTypeArr=[];
		$whereVarArr=[];
		$bindArr=[];
		
		
		if($TBL_WAArenderContactForms_submissions_SQLITE_RESOLVE_recDepth>$TBL_WAArenderContactForms_submissions_SQLITE_RESOLVE_recLimit){return 'callLimit';}
		
		$TBL_WAArenderContactForms_submissions_SQLITE_RESOLVE_recDepth++;
		
	
				if(OBSANE($dat, 'categoryState')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':categoryState',
						'value'=>$dat['categoryState']
					]);
					array_push($whereArr,'categoryState=:categoryState');
					
				}
			
				if(OBSANE($dat, 'dat')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':dat',
						'value'=>$dat['dat']
					]);
					array_push($whereArr,'dat=:dat');
					
				}
			
				if(OBSANE($dat, 'form')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':form',
						'value'=>$dat['form']
					]);
					array_push($whereArr,'form=:form');
					
				}
			
				if(OBSANE($dat, 'ipAddress')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':ipAddress',
						'value'=>$dat['ipAddress']
					]);
					array_push($whereArr,'ipAddress=:ipAddress');
					
				}
			
				if(OBSANE($dat, 'monthSubmitted')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':monthSubmitted',
						'value'=>$dat['monthSubmitted']
					]);
					array_push($whereArr,'monthSubmitted=:monthSubmitted');
					
				}
			
				if(OBSANE($dat, 'pk')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':pk',
						'value'=>$dat['pk']
					]);
					array_push($whereArr,'pk=:pk');
					
				}
			
				if(OBSANE($dat, 'timeSubmitted')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':timeSubmitted',
						'value'=>$dat['timeSubmitted']
					]);
					array_push($whereArr,'timeSubmitted=:timeSubmitted');
					
				}
			
				if(OBSANE($dat, 'yearSubmitted')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':yearSubmitted',
						'value'=>$dat['yearSubmitted']
					]);
					array_push($whereArr,'yearSubmitted=:yearSubmitted');
					
				}
			
		if(!count($whereArr)){return 'empty';}
		$statement=$sqlite->prepare(
			'SELECT * FROM submissions
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
		
	
				if(OBSANE($res , 'categoryState')){
					$dat['categoryState']=$res['categoryState'];
				}else{
					$dat['categoryState']=null;
				}
			
				if(OBSANE($res , 'dat')){
					$dat['dat']=$res['dat'];
				}else{
					$dat['dat']=null;
				}
			
				if(OBSANE($res , 'form')){
					$dat['form']=$res['form'];
				}else{
					$dat['form']=null;
				}
			
				if(OBSANE($res , 'ipAddress')){
					$dat['ipAddress']=$res['ipAddress'];
				}else{
					$dat['ipAddress']=null;
				}
			
				if(OBSANE($res , 'monthSubmitted')){
					$dat['monthSubmitted']=$res['monthSubmitted'];
				}else{
					$dat['monthSubmitted']=null;
				}
			
				if(OBSANE($res , 'pk')){
					$dat['pk']=$res['pk'];
				}else{
					$dat['pk']=null;
				}
			
				if(OBSANE($res , 'timeSubmitted')){
					$dat['timeSubmitted']=$res['timeSubmitted'];
				}else{
					$dat['timeSubmitted']=null;
				}
			
				if(OBSANE($res , 'yearSubmitted')){
					$dat['yearSubmitted']=$res['yearSubmitted'];
				}else{
					$dat['yearSubmitted']=null;
				}
			
		$TBL_WAArenderContactForms_submissions_SQLITE_RESOLVE_recDepth--;
		return '';
	
}
?>