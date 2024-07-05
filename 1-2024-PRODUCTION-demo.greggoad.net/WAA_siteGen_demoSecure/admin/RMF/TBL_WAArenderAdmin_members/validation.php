<?php
require_once(__DIR__.'/../string/validation.php');
require_once(__DIR__.'/../basicPk/validation.php');


function RMF_TBL_WAArenderAdmin_members_EXTRAVALIDATE($dat){
return true;
}


		$TBL_WAArenderAdmin_members_VALIDATION_recDepth=-1;
		$TBL_WAArenderAdmin_members_VALIDATION_recLimit=1;
	function RMF_TBL_WAArenderAdmin_members_VALIDATE($dat, $fullCall=0){

		global $TBL_WAArenderAdmin_members_VALIDATE_recDepth;
		global $TBL_WAArenderAdmin_members_VALIDATE_recLimit;
		if( $TBL_WAArenderAdmin_members_VALIDATE_recDepth>$TBL_WAArenderAdmin_members_VALIDATE_recLimit){
			return "validateCallLimit";
		}
		$TBL_WAArenderAdmin_members_VALIDATE_recDepth++;
		$keyTypeArray=json_decode('{"email":"string","name":"string","pass":"string","pk":"basicPk","role":"string","uSalt":"string"}',true);
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
	   $dynamicFunctName="RMF_TBL_WAArenderAdmin_members_EXTRAVALIDATE";
	   if(function_exists($dynamicFunctName) && $fullCall){
			$ret=($ret && $dynamicFunctName($dat));
	   }
	   $TBL_WAArenderAdmin_members_VALIDATE_recDepth--;
	   return $ret;
	
}

function RMF_TBL_WAArenderAdmin_members_EXTRAFILTER(&$dat){

}


		$TBL_WAArenderAdmin_members_FILTER_recDepth=-1;
		$TBL_WAArenderAdmin_members_FILTER_recLimit=1;
	function RMF_TBL_WAArenderAdmin_members_FILTER(&$dat, $fullCall=0){

		global $TBL_WAArenderAdmin_members_FILTER_recDepth;
		global $TBL_WAArenderAdmin_members_FILTER_recLimit;
		if($TBL_WAArenderAdmin_members_FILTER_recDepth > $TBL_WAArenderAdmin_members_FILTER_recLimit){
			return "filterCallLimit";
		}
		$TBL_WAArenderAdmin_members_FILTER_recDepth++;
		$keyTypeArray=json_decode('{"email":"string","name":"string","pass":"string","pk":"basicPk","role":"string","uSalt":"string"}',true);
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
	   $dynamicFunctName="RMF_TBL_WAArenderAdmin_members_EXTRAFILTER";
	   if(function_exists($dynamicFunctName) && $fullCall){
			$dynamicFunctName($dat);
	   }
	   $TBL_WAArenderAdmin_members_FILTER_recDepth--;
	
}

function RMF_TBL_WAArenderAdmin_members_FILTERVALIDATE(&$dat, $fullCall=0){

	RMF_TBL_WAArenderAdmin_members_FILTER($dat, $fullCall);
	return RMF_TBL_WAArenderAdmin_members_VALIDATE($dat, $fullCall);
}


		$TBL_WAArenderAdmin_members_RESOLVE_recDepth=-1;
		$TBL_WAArenderAdmin_members_RESOLVE_recLimit=1;
	function RMF_TBL_WAArenderAdmin_members_RESOLVE(&$dat){

		global $sqlConn;
		global $TBL_WAArenderAdmin_members_RESOLVE_recDepth;
		global $TBL_WAArenderAdmin_members_RESOLVE_recLimit;
		$whereArr=[];
		$whereTypeArr=[];
		$whereVarArr=[];
		
		if($TBL_WAArenderAdmin_members_RESOLVE_recDepth>$TBL_WAArenderAdmin_members_RESOLVE_recLimit){return 'callLimit';}
		
		$TBL_WAArenderAdmin_members_RESOLVE_recDepth++;
		
	
				if(OBSANE($dat, 'email')){
					
					array_push($whereArr,'email=?');
					array_push($whereTypeArr,'s');
					$email=$dat['email'];
					array_push($whereVarArr,$email);
					
				}
			
				if(OBSANE($dat, 'name')){
					
					array_push($whereArr,'name=?');
					array_push($whereTypeArr,'s');
					$name=$dat['name'];
					array_push($whereVarArr,$name);
					
				}
			
				if(OBSANE($dat, 'pass')){
					
					array_push($whereArr,'pass=?');
					array_push($whereTypeArr,'s');
					$pass=$dat['pass'];
					array_push($whereVarArr,$pass);
					
				}
			
				if(OBSANE($dat, 'pk')){
					
					array_push($whereArr,'pk=?');
					array_push($whereTypeArr,'s');
					$pk=$dat['pk'];
					array_push($whereVarArr,$pk);
					
				}
			
				if(OBSANE($dat, 'role')){
					
					array_push($whereArr,'role=?');
					array_push($whereTypeArr,'s');
					$role=$dat['role'];
					array_push($whereVarArr,$role);
					
				}
			
				if(OBSANE($dat, 'uSalt')){
					
					array_push($whereArr,'uSalt=?');
					array_push($whereTypeArr,'s');
					$uSalt=$dat['uSalt'];
					array_push($whereVarArr,$uSalt);
					
				}
			
		if(!count($whereArr)){return 'empty';}
		$statement=$sqlConn->prepare(
			'SELECT * FROM WAArenderAdmin.members
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
			
				if(OBSANE($res , 'name')){
					$dat['name']=$res['name'];
				}
			
				if(OBSANE($res , 'pass')){
					$dat['pass']=$res['pass'];
				}
			
				if(OBSANE($res , 'pk')){
					$dat['pk']=$res['pk'];
				}
			
				if(OBSANE($res , 'role')){
					$dat['role']=$res['role'];
				}
			
				if(OBSANE($res , 'uSalt')){
					$dat['uSalt']=$res['uSalt'];
				}
			
		$TBL_WAArenderAdmin_members_RESOLVE_recDepth--;
		return '';
	
}

 
		$TBL_WAArenderAdmin_members_SQLITE_RESOLVE_recDepth=-1;
		$TBL_WAArenderAdmin_members_SQLITE_RESOLVE_recLimit=1;
	function RMF_TBL_WAArenderAdmin_members_SQLITE_RESOLVE($sqlite, &$dat){

		global $TBL_WAArenderAdmin_members_SQLITE_RESOLVE_recDepth;
		global $TBL_WAArenderAdmin_members_SQLITE_RESOLVE_recLimit;
		$whereArr=[];
		$whereTypeArr=[];
		$whereVarArr=[];
		$bindArr=[];
		
		
		if($TBL_WAArenderAdmin_members_SQLITE_RESOLVE_recDepth>$TBL_WAArenderAdmin_members_SQLITE_RESOLVE_recLimit){return 'callLimit';}
		
		$TBL_WAArenderAdmin_members_SQLITE_RESOLVE_recDepth++;
		
	
				if(OBSANE($dat, 'email')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':email',
						'value'=>$dat['email']
					]);
					array_push($whereArr,'email=:email');
					
				}
			
				if(OBSANE($dat, 'name')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':name',
						'value'=>$dat['name']
					]);
					array_push($whereArr,'name=:name');
					
				}
			
				if(OBSANE($dat, 'pass')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':pass',
						'value'=>$dat['pass']
					]);
					array_push($whereArr,'pass=:pass');
					
				}
			
				if(OBSANE($dat, 'pk')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':pk',
						'value'=>$dat['pk']
					]);
					array_push($whereArr,'pk=:pk');
					
				}
			
				if(OBSANE($dat, 'role')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':role',
						'value'=>$dat['role']
					]);
					array_push($whereArr,'role=:role');
					
				}
			
				if(OBSANE($dat, 'uSalt')){
					array_push($bindArr, [
						'type'=>SQLITE3_TEXT,
						'tag'=>':uSalt',
						'value'=>$dat['uSalt']
					]);
					array_push($whereArr,'uSalt=:uSalt');
					
				}
			
		if(!count($whereArr)){return 'empty';}
		$statement=$sqlite->prepare(
			'SELECT * FROM members
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
			
				if(OBSANE($res , 'name')){
					$dat['name']=$res['name'];
				}else{
					$dat['name']=null;
				}
			
				if(OBSANE($res , 'pass')){
					$dat['pass']=$res['pass'];
				}else{
					$dat['pass']=null;
				}
			
				if(OBSANE($res , 'pk')){
					$dat['pk']=$res['pk'];
				}else{
					$dat['pk']=null;
				}
			
				if(OBSANE($res , 'role')){
					$dat['role']=$res['role'];
				}else{
					$dat['role']=null;
				}
			
				if(OBSANE($res , 'uSalt')){
					$dat['uSalt']=$res['uSalt'];
				}else{
					$dat['uSalt']=null;
				}
			
		$TBL_WAArenderAdmin_members_SQLITE_RESOLVE_recDepth--;
		return '';
	
}
?>