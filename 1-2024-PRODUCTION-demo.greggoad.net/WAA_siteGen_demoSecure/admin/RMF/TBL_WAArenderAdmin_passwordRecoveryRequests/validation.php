<?php
require_once(__DIR__.'/../TBL_WAArenderAdmin_members/validation.php');
require_once(__DIR__.'/../basicPk/validation.php');
require_once(__DIR__.'/../date_time/validation.php');
require_once(__DIR__.'/../string/validation.php');


function RMF_TBL_WAArenderAdmin_passwordRecoveryRequests_EXTRAVALIDATE($dat){
return true;
}


		$TBL_WAArenderAdmin_passwordRecoveryRequests_VALIDATION_recDepth=-1;
		$TBL_WAArenderAdmin_passwordRecoveryRequests_VALIDATION_recLimit=1;
	function RMF_TBL_WAArenderAdmin_passwordRecoveryRequests_VALIDATE($dat, $fullCall=0){

		global $TBL_WAArenderAdmin_passwordRecoveryRequests_VALIDATE_recDepth;
		global $TBL_WAArenderAdmin_passwordRecoveryRequests_VALIDATE_recLimit;
		if( $TBL_WAArenderAdmin_passwordRecoveryRequests_VALIDATE_recDepth>$TBL_WAArenderAdmin_passwordRecoveryRequests_VALIDATE_recLimit){
			return "validateCallLimit";
		}
		$TBL_WAArenderAdmin_passwordRecoveryRequests_VALIDATE_recDepth++;
		$keyTypeArray=json_decode('{"member":"TBL_WAArenderAdmin_members","pk":"basicPk","timeAdded":"date_time","token":"string"}',true);
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
	   $dynamicFunctName="RMF_TBL_WAArenderAdmin_passwordRecoveryRequests_EXTRAVALIDATE";
	   if(function_exists($dynamicFunctName) && $fullCall){
			$ret=($ret && $dynamicFunctName($dat));
	   }
	   $TBL_WAArenderAdmin_passwordRecoveryRequests_VALIDATE_recDepth--;
	   return $ret;
	
}

function RMF_TBL_WAArenderAdmin_passwordRecoveryRequests_EXTRAFILTER(&$dat){

}


		$TBL_WAArenderAdmin_passwordRecoveryRequests_FILTER_recDepth=-1;
		$TBL_WAArenderAdmin_passwordRecoveryRequests_FILTER_recLimit=1;
	function RMF_TBL_WAArenderAdmin_passwordRecoveryRequests_FILTER(&$dat, $fullCall=0){

		global $TBL_WAArenderAdmin_passwordRecoveryRequests_FILTER_recDepth;
		global $TBL_WAArenderAdmin_passwordRecoveryRequests_FILTER_recLimit;
		if($TBL_WAArenderAdmin_passwordRecoveryRequests_FILTER_recDepth > $TBL_WAArenderAdmin_passwordRecoveryRequests_FILTER_recLimit){
			return "filterCallLimit";
		}
		$TBL_WAArenderAdmin_passwordRecoveryRequests_FILTER_recDepth++;
		$keyTypeArray=json_decode('{"member":"TBL_WAArenderAdmin_members","pk":"basicPk","timeAdded":"date_time","token":"string"}',true);
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
	   $dynamicFunctName="RMF_TBL_WAArenderAdmin_passwordRecoveryRequests_EXTRAFILTER";
	   if(function_exists($dynamicFunctName) && $fullCall){
			$dynamicFunctName($dat);
	   }
	   $TBL_WAArenderAdmin_passwordRecoveryRequests_FILTER_recDepth--;
	
}

function RMF_TBL_WAArenderAdmin_passwordRecoveryRequests_FILTERVALIDATE(&$dat, $fullCall=0){

	RMF_TBL_WAArenderAdmin_passwordRecoveryRequests_FILTER($dat, $fullCall);
	return RMF_TBL_WAArenderAdmin_passwordRecoveryRequests_VALIDATE($dat, $fullCall);
}


		$TBL_WAArenderAdmin_passwordRecoveryRequests_RESOLVE_recDepth=-1;
		$TBL_WAArenderAdmin_passwordRecoveryRequests_RESOLVE_recLimit=1;
	function RMF_TBL_WAArenderAdmin_passwordRecoveryRequests_RESOLVE(&$dat){

		global $sqlConn;
		global $TBL_WAArenderAdmin_passwordRecoveryRequests_RESOLVE_recDepth;
		global $TBL_WAArenderAdmin_passwordRecoveryRequests_RESOLVE_recLimit;
		$whereArr=[];
		$whereTypeArr=[];
		$whereVarArr=[];
		
		if($TBL_WAArenderAdmin_passwordRecoveryRequests_RESOLVE_recDepth>$TBL_WAArenderAdmin_passwordRecoveryRequests_RESOLVE_recLimit){return 'callLimit';}
		
		$TBL_WAArenderAdmin_passwordRecoveryRequests_RESOLVE_recDepth++;
		
	
				if(!isset($GLOBALS['TBL_WAArenderAdmin_members_RESOLVE_recDepth'])){
					$GLOBALS['TBL_WAArenderAdmin_members_RESOLVE_recDepth']=-1;
				}
				if(!isset($GLOBALS['TBL_WAArenderAdmin_members_RESOLVE_recLimit'])){
					$GLOBALS['TBL_WAArenderAdmin_members_RESOLVE_recLimit']=1;
				}
				if(OBSANE($dat, 'member') && $GLOBALS['TBL_WAArenderAdmin_members_RESOLVE_recDepth'] < $GLOBALS['TBL_WAArenderAdmin_members_RESOLVE_recLimit']){
					$reso=RMF_TBL_WAArenderAdmin_members_RESOLVE($dat['member']);
					if($reso === ''){
						array_push($whereArr,'member=?');
						array_push($whereTypeArr,'i');
						$member=$dat['member']['pk'];
						array_push($whereVarArr,$member);
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
			
				if(OBSANE($dat, 'timeAdded')){
					
					array_push($whereArr,'timeAdded=?');
					array_push($whereTypeArr,'s');
					$timeAdded=$dat['timeAdded'];
					array_push($whereVarArr,$timeAdded);
					
				}
			
				if(OBSANE($dat, 'token')){
					
					array_push($whereArr,'token=?');
					array_push($whereTypeArr,'s');
					$token=$dat['token'];
					array_push($whereVarArr,$token);
					
				}
			
		if(!count($whereArr)){return 'empty';}
		$statement=$sqlConn->prepare(
			'SELECT * FROM WAArenderAdmin.passwordRecoveryRequests
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
		
	
				if(OBSANE($res , 'member') && $GLOBALS['TBL_WAArenderAdmin_members_RESOLVE_recDepth'] < $GLOBALS['TBL_WAArenderAdmin_members_RESOLVE_recLimit']){
					$res['member']=['pk'=>$res['member']];
					RMF_TBL_WAArenderAdmin_members_RESOLVE($res['member']);
					$dat['member']=$res['member'];
				}
			
				if(OBSANE($res , 'pk')){
					$dat['pk']=$res['pk'];
				}
			
				if(OBSANE($res , 'timeAdded')){
					$dat['timeAdded']=$res['timeAdded'];
				}
			
				if(OBSANE($res , 'token')){
					$dat['token']=$res['token'];
				}
			
		$TBL_WAArenderAdmin_passwordRecoveryRequests_RESOLVE_recDepth--;
		return '';
	
}

 
		$TBL_WAArenderAdmin_passwordRecoveryRequests_SQLITE_RESOLVE_recDepth=-1;
		$TBL_WAArenderAdmin_passwordRecoveryRequests_SQLITE_RESOLVE_recLimit=1;
	function RMF_TBL_WAArenderAdmin_passwordRecoveryRequests_SQLITE_RESOLVE($sqlite, &$dat){

		global $TBL_WAArenderAdmin_passwordRecoveryRequests_SQLITE_RESOLVE_recDepth;
		global $TBL_WAArenderAdmin_passwordRecoveryRequests_SQLITE_RESOLVE_recLimit;
		$whereArr=[];
		$whereTypeArr=[];
		$whereVarArr=[];
		$bindArr=[];
		
		
		if($TBL_WAArenderAdmin_passwordRecoveryRequests_SQLITE_RESOLVE_recDepth>$TBL_WAArenderAdmin_passwordRecoveryRequests_SQLITE_RESOLVE_recLimit){return 'callLimit';}
		
		$TBL_WAArenderAdmin_passwordRecoveryRequests_SQLITE_RESOLVE_recDepth++;
		
	
				if(!isset($GLOBALS['TBL_WAArenderAdmin_members_SQLITE_RESOLVE_recDepth'])){
					$GLOBALS['TBL_WAArenderAdmin_members_SQLITE_RESOLVE_recDepth']=-1;
				}
				if(!isset($GLOBALS['TBL_WAArenderAdmin_members_SQLITE_RESOLVE_recLimit'])){
					$GLOBALS['TBL_WAArenderAdmin_members_SQLITE_RESOLVE_recLimit']=1;
				}
				if(OBSANE($dat, 'member') && $GLOBALS['TBL_WAArenderAdmin_members_SQLITE_RESOLVE_recDepth'] < $GLOBALS['TBL_WAArenderAdmin_members_SQLITE_RESOLVE_recLimit']){
					$reso=RMF_TBL_WAArenderAdmin_members_SQLITE_RESOLVE($sqlite, $dat['member']);
					if($reso === ''){
						array_push($whereArr,'member=:member');
						array_push($bindArr, [
							'type'=>SQLITE3_INTEGER,
							'tag'=>':member',
							'value'=>$dat['member']['pk']
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
			
				if(OBSANE($dat, 'timeAdded')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':timeAdded',
						'value'=>$dat['timeAdded']
					]);
					array_push($whereArr,'timeAdded=:timeAdded');
					
				}
			
				if(OBSANE($dat, 'token')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':token',
						'value'=>$dat['token']
					]);
					array_push($whereArr,'token=:token');
					
				}
			
		if(!count($whereArr)){return 'empty';}
		$statement=$sqlite->prepare(
			'SELECT * FROM passwordRecoveryRequests
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
		
	
				if(OBSANE($res , 'member')){
					$res['member']=['pk'=>$res['member']];
					if($GLOBALS['TBL_WAArenderAdmin_members_SQLITE_RESOLVE_recDepth'] < $GLOBALS['TBL_WAArenderAdmin_members_SQLITE_RESOLVE_recLimit']){
						RMF_TBL_WAArenderAdmin_members_SQLITE_RESOLVE($sqlite, $res['member']);
					}
					$dat['member']=$res['member'];
				}else{
					$dat['member']=null;
				}
			
				if(OBSANE($res , 'pk')){
					$dat['pk']=$res['pk'];
				}else{
					$dat['pk']=null;
				}
			
				if(OBSANE($res , 'timeAdded')){
					$dat['timeAdded']=$res['timeAdded'];
				}else{
					$dat['timeAdded']=null;
				}
			
				if(OBSANE($res , 'token')){
					$dat['token']=$res['token'];
				}else{
					$dat['token']=null;
				}
			
		$TBL_WAArenderAdmin_passwordRecoveryRequests_SQLITE_RESOLVE_recDepth--;
		return '';
	
}
?>