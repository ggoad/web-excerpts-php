<?php
require_once(__DIR__.'/../string/validation.php');
require_once(__DIR__.'/../basicPk/validation.php');


function RMF_TBL_WAArenderContactForms_forms_EXTRAVALIDATE($dat){
return true;
}


		$TBL_WAArenderContactForms_forms_VALIDATION_recDepth=-1;
		$TBL_WAArenderContactForms_forms_VALIDATION_recLimit=1;
	function RMF_TBL_WAArenderContactForms_forms_VALIDATE($dat, $fullCall=0){

		global $TBL_WAArenderContactForms_forms_VALIDATE_recDepth;
		global $TBL_WAArenderContactForms_forms_VALIDATE_recLimit;
		if( $TBL_WAArenderContactForms_forms_VALIDATE_recDepth>$TBL_WAArenderContactForms_forms_VALIDATE_recLimit){
			return "validateCallLimit";
		}
		$TBL_WAArenderContactForms_forms_VALIDATE_recDepth++;
		$keyTypeArray=json_decode('{"formName":"string","inps":"string","pk":"basicPk"}',true);
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
	   $dynamicFunctName="RMF_TBL_WAArenderContactForms_forms_EXTRAVALIDATE";
	   if(function_exists($dynamicFunctName) && $fullCall){
			$ret=($ret && $dynamicFunctName($dat));
	   }
	   $TBL_WAArenderContactForms_forms_VALIDATE_recDepth--;
	   return $ret;
	
}

function RMF_TBL_WAArenderContactForms_forms_EXTRAFILTER(&$dat){

}


		$TBL_WAArenderContactForms_forms_FILTER_recDepth=-1;
		$TBL_WAArenderContactForms_forms_FILTER_recLimit=1;
	function RMF_TBL_WAArenderContactForms_forms_FILTER(&$dat, $fullCall=0){

		global $TBL_WAArenderContactForms_forms_FILTER_recDepth;
		global $TBL_WAArenderContactForms_forms_FILTER_recLimit;
		if($TBL_WAArenderContactForms_forms_FILTER_recDepth > $TBL_WAArenderContactForms_forms_FILTER_recLimit){
			return "filterCallLimit";
		}
		$TBL_WAArenderContactForms_forms_FILTER_recDepth++;
		$keyTypeArray=json_decode('{"formName":"string","inps":"string","pk":"basicPk"}',true);
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
	   $dynamicFunctName="RMF_TBL_WAArenderContactForms_forms_EXTRAFILTER";
	   if(function_exists($dynamicFunctName) && $fullCall){
			$dynamicFunctName($dat);
	   }
	   $TBL_WAArenderContactForms_forms_FILTER_recDepth--;
	
}

function RMF_TBL_WAArenderContactForms_forms_FILTERVALIDATE(&$dat, $fullCall=0){

	RMF_TBL_WAArenderContactForms_forms_FILTER($dat, $fullCall);
	return RMF_TBL_WAArenderContactForms_forms_VALIDATE($dat, $fullCall);
}


		$TBL_WAArenderContactForms_forms_RESOLVE_recDepth=-1;
		$TBL_WAArenderContactForms_forms_RESOLVE_recLimit=1;
	function RMF_TBL_WAArenderContactForms_forms_RESOLVE(&$dat){

		global $sqlConn;
		global $TBL_WAArenderContactForms_forms_RESOLVE_recDepth;
		global $TBL_WAArenderContactForms_forms_RESOLVE_recLimit;
		$whereArr=[];
		$whereTypeArr=[];
		$whereVarArr=[];
		
		if($TBL_WAArenderContactForms_forms_RESOLVE_recDepth>$TBL_WAArenderContactForms_forms_RESOLVE_recLimit){return 'callLimit';}
		
		$TBL_WAArenderContactForms_forms_RESOLVE_recDepth++;
		
	
				if(OBSANE($dat, 'formName')){
					
					array_push($whereArr,'formName=?');
					array_push($whereTypeArr,'s');
					$formName=$dat['formName'];
					array_push($whereVarArr,$formName);
					
				}
			
				if(OBSANE($dat, 'inps')){
					
					array_push($whereArr,'inps=?');
					array_push($whereTypeArr,'s');
					$inps=$dat['inps'];
					array_push($whereVarArr,$inps);
					
				}
			
				if(OBSANE($dat, 'pk')){
					
					array_push($whereArr,'pk=?');
					array_push($whereTypeArr,'s');
					$pk=$dat['pk'];
					array_push($whereVarArr,$pk);
					
				}
			
		if(!count($whereArr)){return 'empty';}
		$statement=$sqlConn->prepare(
			'SELECT * FROM WAArenderContactForms.forms
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
		
	
				if(OBSANE($res , 'formName')){
					$dat['formName']=$res['formName'];
				}
			
				if(OBSANE($res , 'inps')){
					$dat['inps']=$res['inps'];
				}
			
				if(OBSANE($res , 'pk')){
					$dat['pk']=$res['pk'];
				}
			
		$TBL_WAArenderContactForms_forms_RESOLVE_recDepth--;
		return '';
	
}

 
		$TBL_WAArenderContactForms_forms_SQLITE_RESOLVE_recDepth=-1;
		$TBL_WAArenderContactForms_forms_SQLITE_RESOLVE_recLimit=1;
	function RMF_TBL_WAArenderContactForms_forms_SQLITE_RESOLVE($sqlite, &$dat){

		global $TBL_WAArenderContactForms_forms_SQLITE_RESOLVE_recDepth;
		global $TBL_WAArenderContactForms_forms_SQLITE_RESOLVE_recLimit;
		$whereArr=[];
		$whereTypeArr=[];
		$whereVarArr=[];
		$bindArr=[];
		
		
		if($TBL_WAArenderContactForms_forms_SQLITE_RESOLVE_recDepth>$TBL_WAArenderContactForms_forms_SQLITE_RESOLVE_recLimit){return 'callLimit';}
		
		$TBL_WAArenderContactForms_forms_SQLITE_RESOLVE_recDepth++;
		
	
				if(OBSANE($dat, 'formName')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':formName',
						'value'=>$dat['formName']
					]);
					array_push($whereArr,'formName=:formName');
					
				}
			
				if(OBSANE($dat, 'inps')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':inps',
						'value'=>$dat['inps']
					]);
					array_push($whereArr,'inps=:inps');
					
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
			'SELECT * FROM forms
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
		
	
				if(OBSANE($res , 'formName')){
					$dat['formName']=$res['formName'];
				}else{
					$dat['formName']=null;
				}
			
				if(OBSANE($res , 'inps')){
					$dat['inps']=$res['inps'];
				}else{
					$dat['inps']=null;
				}
			
				if(OBSANE($res , 'pk')){
					$dat['pk']=$res['pk'];
				}else{
					$dat['pk']=null;
				}
			
		$TBL_WAArenderContactForms_forms_SQLITE_RESOLVE_recDepth--;
		return '';
	
}
?>