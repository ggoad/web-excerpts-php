<?php
require_once(__DIR__.'/../string/validation.php');
require_once(__DIR__.'/../basicPk/validation.php');
require_once(__DIR__.'/../boolean/validation.php');
require_once(__DIR__.'/../date_time/validation.php');


function RMF_TBL_WAArenderAdmin_loginAttempts_EXTRAVALIDATE($dat){
return true;
}


		$TBL_WAArenderAdmin_loginAttempts_VALIDATION_recDepth=-1;
		$TBL_WAArenderAdmin_loginAttempts_VALIDATION_recLimit=1;
	function RMF_TBL_WAArenderAdmin_loginAttempts_VALIDATE($dat, $fullCall=0){

		global $TBL_WAArenderAdmin_loginAttempts_VALIDATE_recDepth;
		global $TBL_WAArenderAdmin_loginAttempts_VALIDATE_recLimit;
		if( $TBL_WAArenderAdmin_loginAttempts_VALIDATE_recDepth>$TBL_WAArenderAdmin_loginAttempts_VALIDATE_recLimit){
			return "validateCallLimit";
		}
		$TBL_WAArenderAdmin_loginAttempts_VALIDATE_recDepth++;
		$keyTypeArray=json_decode('{"email":"string","ip":"string","pk":"basicPk","res":"boolean","timeAttempted":"date_time"}',true);
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
	   $dynamicFunctName="RMF_TBL_WAArenderAdmin_loginAttempts_EXTRAVALIDATE";
	   if(function_exists($dynamicFunctName) && $fullCall){
			$ret=($ret && $dynamicFunctName($dat));
	   }
	   $TBL_WAArenderAdmin_loginAttempts_VALIDATE_recDepth--;
	   return $ret;
	
}

function RMF_TBL_WAArenderAdmin_loginAttempts_EXTRAFILTER(&$dat){

}


		$TBL_WAArenderAdmin_loginAttempts_FILTER_recDepth=-1;
		$TBL_WAArenderAdmin_loginAttempts_FILTER_recLimit=1;
	function RMF_TBL_WAArenderAdmin_loginAttempts_FILTER(&$dat, $fullCall=0){

		global $TBL_WAArenderAdmin_loginAttempts_FILTER_recDepth;
		global $TBL_WAArenderAdmin_loginAttempts_FILTER_recLimit;
		if($TBL_WAArenderAdmin_loginAttempts_FILTER_recDepth > $TBL_WAArenderAdmin_loginAttempts_FILTER_recLimit){
			return "filterCallLimit";
		}
		$TBL_WAArenderAdmin_loginAttempts_FILTER_recDepth++;
		$keyTypeArray=json_decode('{"email":"string","ip":"string","pk":"basicPk","res":"boolean","timeAttempted":"date_time"}',true);
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
	   $dynamicFunctName="RMF_TBL_WAArenderAdmin_loginAttempts_EXTRAFILTER";
	   if(function_exists($dynamicFunctName) && $fullCall){
			$dynamicFunctName($dat);
	   }
	   $TBL_WAArenderAdmin_loginAttempts_FILTER_recDepth--;
	
}

function RMF_TBL_WAArenderAdmin_loginAttempts_FILTERVALIDATE(&$dat, $fullCall=0){

	RMF_TBL_WAArenderAdmin_loginAttempts_FILTER($dat, $fullCall);
	return RMF_TBL_WAArenderAdmin_loginAttempts_VALIDATE($dat, $fullCall);
}


		$TBL_WAArenderAdmin_loginAttempts_RESOLVE_recDepth=-1;
		$TBL_WAArenderAdmin_loginAttempts_RESOLVE_recLimit=1;
	function RMF_TBL_WAArenderAdmin_loginAttempts_RESOLVE(&$dat){

		global $sqlConn;
		global $TBL_WAArenderAdmin_loginAttempts_RESOLVE_recDepth;
		global $TBL_WAArenderAdmin_loginAttempts_RESOLVE_recLimit;
		$whereArr=[];
		$whereTypeArr=[];
		$whereVarArr=[];
		
		if($TBL_WAArenderAdmin_loginAttempts_RESOLVE_recDepth>$TBL_WAArenderAdmin_loginAttempts_RESOLVE_recLimit){return 'callLimit';}
		
		$TBL_WAArenderAdmin_loginAttempts_RESOLVE_recDepth++;
		
	
				if(OBSANE($dat, 'email')){
					
					array_push($whereArr,'email=?');
					array_push($whereTypeArr,'s');
					$email=$dat['email'];
					array_push($whereVarArr,$email);
					
				}
			
				if(OBSANE($dat, 'ip')){
					
					array_push($whereArr,'ip=?');
					array_push($whereTypeArr,'s');
					$ip=$dat['ip'];
					array_push($whereVarArr,$ip);
					
				}
			
				if(OBSANE($dat, 'pk')){
					
					array_push($whereArr,'pk=?');
					array_push($whereTypeArr,'s');
					$pk=$dat['pk'];
					array_push($whereVarArr,$pk);
					
				}
			
				if(OBSANE($dat, 'res')){
					
					array_push($whereArr,'res=?');
					array_push($whereTypeArr,'s');
					$res=$dat['res'];
					array_push($whereVarArr,$res);
					
				}
			
				if(OBSANE($dat, 'timeAttempted')){
					
					array_push($whereArr,'timeAttempted=?');
					array_push($whereTypeArr,'s');
					$timeAttempted=$dat['timeAttempted'];
					array_push($whereVarArr,$timeAttempted);
					
				}
			
		if(!count($whereArr)){return 'empty';}
		$statement=$sqlConn->prepare(
			'SELECT * FROM WAArenderAdmin.loginAttempts
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
		
	
				if(OBSANE($res , 'email')){
					$dat['email']=$res['email'];
				}
			
				if(OBSANE($res , 'ip')){
					$dat['ip']=$res['ip'];
				}
			
				if(OBSANE($res , 'pk')){
					$dat['pk']=$res['pk'];
				}
			
				if(OBSANE($res , 'res')){
					$dat['res']=$res['res'];
				}
			
				if(OBSANE($res , 'timeAttempted')){
					$dat['timeAttempted']=$res['timeAttempted'];
				}
			
		$TBL_WAArenderAdmin_loginAttempts_RESOLVE_recDepth--;
		return '';
	
}

 
		$TBL_WAArenderAdmin_loginAttempts_SQLITE_RESOLVE_recDepth=-1;
		$TBL_WAArenderAdmin_loginAttempts_SQLITE_RESOLVE_recLimit=1;
	function RMF_TBL_WAArenderAdmin_loginAttempts_SQLITE_RESOLVE($sqlite, &$dat){

		global $TBL_WAArenderAdmin_loginAttempts_SQLITE_RESOLVE_recDepth;
		global $TBL_WAArenderAdmin_loginAttempts_SQLITE_RESOLVE_recLimit;
		$whereArr=[];
		$whereTypeArr=[];
		$whereVarArr=[];
		$bindArr=[];
		
		
		if($TBL_WAArenderAdmin_loginAttempts_SQLITE_RESOLVE_recDepth>$TBL_WAArenderAdmin_loginAttempts_SQLITE_RESOLVE_recLimit){return 'callLimit';}
		
		$TBL_WAArenderAdmin_loginAttempts_SQLITE_RESOLVE_recDepth++;
		
	
				if(OBSANE($dat, 'email')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':email',
						'value'=>$dat['email']
					]);
					array_push($whereArr,'email=:email');
					
				}
			
				if(OBSANE($dat, 'ip')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':ip',
						'value'=>$dat['ip']
					]);
					array_push($whereArr,'ip=:ip');
					
				}
			
				if(OBSANE($dat, 'pk')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':pk',
						'value'=>$dat['pk']
					]);
					array_push($whereArr,'pk=:pk');
					
				}
			
				if(OBSANE($dat, 'res')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':res',
						'value'=>$dat['res']
					]);
					array_push($whereArr,'res=:res');
					
				}
			
				if(OBSANE($dat, 'timeAttempted')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':timeAttempted',
						'value'=>$dat['timeAttempted']
					]);
					array_push($whereArr,'timeAttempted=:timeAttempted');
					
				}
			
		if(!count($whereArr)){return 'empty';}
		$statement=$sqlite->prepare(
			'SELECT * FROM loginAttempts
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
		
	
				if(OBSANE($res , 'email')){
					$dat['email']=$res['email'];
				}else{
					$dat['email']=null;
				}
			
				if(OBSANE($res , 'ip')){
					$dat['ip']=$res['ip'];
				}else{
					$dat['ip']=null;
				}
			
				if(OBSANE($res , 'pk')){
					$dat['pk']=$res['pk'];
				}else{
					$dat['pk']=null;
				}
			
				if(OBSANE($res , 'res')){
					$dat['res']=$res['res'];
				}else{
					$dat['res']=null;
				}
			
				if(OBSANE($res , 'timeAttempted')){
					$dat['timeAttempted']=$res['timeAttempted'];
				}else{
					$dat['timeAttempted']=null;
				}
			
		$TBL_WAArenderAdmin_loginAttempts_SQLITE_RESOLVE_recDepth--;
		return '';
	
}
?>