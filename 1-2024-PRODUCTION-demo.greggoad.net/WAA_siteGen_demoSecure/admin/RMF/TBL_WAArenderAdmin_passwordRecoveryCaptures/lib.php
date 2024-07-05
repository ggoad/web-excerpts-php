<?php
function psAddWAArenderAdmin_passwordRecoveryCaptures($dat){

	global $sqlite;
	$insertCols=[];
	$insertValLabels=[];
	$bindArr=[];
	$needsReset=false;
	if(!$sqlite){
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/db.db");
		$needsReset=true;
	}
	

			if(!OBSANE($dat,'token')){
				return 'failed: the column token was not provided';
			}
		
			if(OBSANE($dat, 'token')){
				if(!RMF_string_FILTERVALIDATE($dat['token'])){
					return ('token was invalid');
				}
				
				array_push($insertCols, 'token');
				array_push($insertValLabels, ':token');
				array_push($bindArr, [
					'value'=>$dat['token'],
					'tag'=>':token',
					'type'=>SQLITE3_TEXT
				]);
			}
		
			if(!OBSANE($dat,'captureToken')){
				return 'failed: the column captureToken was not provided';
			}
		
			if(OBSANE($dat, 'captureToken')){
				if(!RMF_string_FILTERVALIDATE($dat['captureToken'])){
					return ('captureToken was invalid');
				}
				
				array_push($insertCols, 'captureToken');
				array_push($insertValLabels, ':captureToken');
				array_push($bindArr, [
					'value'=>$dat['captureToken'],
					'tag'=>':captureToken',
					'type'=>SQLITE3_TEXT
				]);
			}
		
			if(OBSANE($dat, 'timeAdded')){
				if(!RMF_date_time_FILTERVALIDATE($dat['timeAdded'])){
					return ('timeAdded was invalid');
				}
				
				array_push($insertCols, 'timeAdded');
				array_push($insertValLabels, ':timeAdded');
				array_push($bindArr, [
					'value'=>$dat['timeAdded'],
					'tag'=>':timeAdded',
					'type'=>SQLITE3_TEXT
				]);
			}
		
			if(!OBSANE($dat,'member')){
				return 'failed: the column member was not provided';
			}
		
				if(OBSANE($dat, 'member')){
					if(($res=RMF_TBL_WAArenderAdmin_members_SQLITE_RESOLVE($sqlite,$dat['member'])) !== 'empty'){	
						if($res !== ''){
							return 'a resolve went wrong '.$res;
						}
						if(!RMF_TBL_WAArenderAdmin_members_FILTERVALIDATE($dat['member'])){
							return ('member was invalid');
						}
						array_push($insertCols, 'member');
						array_push($insertValLabels, ':member');
						array_push($bindArr, [
							'value'=>$dat['member']['pk'],
							'tag'=>':member',
							'type'=>SQLITE3_INTEGER
						]);
					}else{
						return 'no valid member provided. Resolve empty';
					}
				}
			
			if(OBSANE($dat, 'pk')){
				if(!RMF_basicPk_FILTERVALIDATE($dat['pk'])){
					return ('pk was invalid');
				}
				
				array_push($insertCols, 'pk');
				array_push($insertValLabels, ':pk');
				array_push($bindArr, [
					'value'=>$dat['pk'],
					'tag'=>':pk',
					'type'=>SQLITE3_TEXT
				]);
			}
		
		$statement=$sqlite->prepare('INSERT INTO passwordRecoveryCaptures
		('.implode(',' , $insertCols).')
		VALUES
		('.implode(',' , $insertValLabels).');');
		if(!$statement){
			return 'failed on prepare '.$sqlite->lastErrorMsg();
		}
		
		if(count($bindArr)){
			foreach($bindArr as $ba)
			{
				$statement->bindValue($ba['tag'], $ba['value'], $ba['type']);
			}
		}
		
		if(!$executeResult=$statement->execute()){
			return 'failed to execute :> '.($sqlite->lastErrorMsg());
		}
	
	if($needsReset){
		$sqlite->close();
	}
	return 'SUCCESS';

}

function psEditWAArenderAdmin_passwordRecoveryCaptures($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/db.db");
	}
	$setExpressions=[];
	$bindArr=[];
	$ogPk='';
	
	
	ObVarSet($dat,'OGvalue', $OGvalue);
	$resResult=RMF_TBL_WAArenderAdmin_passwordRecoveryCaptures_SQLITE_RESOLVE($sqlite, $OGvalue);
	
	if($resResult){
		return 'failed to resolve og: '.$resResult;
	}
	$ogPk=$OGvalue['pk'];

			if(OBSANE($dat, 'token')){
				if(!RMF_string_FILTERVALIDATE($dat['token'])){
					return ('token was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':token',
					'value'=>$dat['token']
				]);
				array_push($setExpressions, 'token=:token' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':token',
					'value'=>$OGvalue['token']
				]);
				array_push($setExpressions, 'token=:token');
			}
		
			if(OBSANE($dat, 'captureToken')){
				if(!RMF_string_FILTERVALIDATE($dat['captureToken'])){
					return ('captureToken was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':captureToken',
					'value'=>$dat['captureToken']
				]);
				array_push($setExpressions, 'captureToken=:captureToken' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':captureToken',
					'value'=>$OGvalue['captureToken']
				]);
				array_push($setExpressions, 'captureToken=:captureToken');
			}
		
			if(OBSANE($dat, 'timeAdded')){
				if(!RMF_date_time_FILTERVALIDATE($dat['timeAdded'])){
					return ('timeAdded was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':timeAdded',
					'value'=>$dat['timeAdded']
				]);
				array_push($setExpressions, 'timeAdded=:timeAdded' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':timeAdded',
					'value'=>$OGvalue['timeAdded']
				]);
				array_push($setExpressions, 'timeAdded=:timeAdded');
			}
		
			if(OBSANE($dat, 'member')){
				$res=RMF_TBL_WAArenderAdmin_members_SQLITE_RESOLVE($sqlite, $dat['member']);
				
				if($res === ''){
					if(!RMF_TBL_WAArenderAdmin_members_FILTERVALIDATE($dat['member'])){
						return ('member was invalid');
					}
					array_push($setExpressions, 'member=:member');
					array_push($bindArr, [
						'value'=>$dat['member']['pk'],
						'tag'=>':member',
						'type'=>SQLITE3_INTEGER
					]);
					
				}else if($res !== 'empty'){
					return 'a resolve went wrong '.$res;
				}
			}else if(!is_null($OGvalue['member'])){
				array_push($setExpressions, 'member=:member');
				array_push($bindArr, [
					'value'=>$OGvalue['member']['pk'],
					'tag'=>':member',
					'type'=>SQLITE3_INTEGER
				]);
			}else{
				array_push($setExpressions, 'member=:member');
				array_push($bindArr,[
					'value'=>null,
					'tag'=>':member',
					'type'=>SQLITE3_INTEGER
				]);
			}
		
			if(OBSANE($dat, 'pk')){
				if(!RMF_basicPk_FILTERVALIDATE($dat['pk'])){
					return ('pk was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':pk',
					'value'=>$dat['pk']
				]);
				array_push($setExpressions, 'pk=:pk' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':pk',
					'value'=>$OGvalue['pk']
				]);
				array_push($setExpressions, 'pk=:pk');
			}
		
	array_push($bindArr, [
		'value'=>$ogPk,
		'tag'=>':ogPk',
		'type'=>SQLITE3_INTEGER
	]);

		$statement=$sqlite->prepare('UPDATE passwordRecoveryCaptures
		SET 
			'.implode(',' , $setExpressions).'
		WHERE pk=:ogPk');
		if(!$statement){
			return 'failed on prepare '.$sqlite->lastErrorMsg();
		}
		
		foreach($bindArr as $ba)
		{
			$statement->bindValue($ba['tag'], $ba['value'], $ba['type']);
		}
		
		if(!$executeResult=$statement->execute()){
			return 'failed to execute :> '.($sqlite->lastErrorMsg());
		}
	
	if($needsReset){
		$sqlite->close();
	}
	return 'SUCCESS';

}

function psDropWAArenderAdmin_passwordRecoveryCaptures($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLITE3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/db.db");
	}

		$res=RMF_TBL_WAArenderAdmin_passwordRecoveryCaptures_SQLITE_RESOLVE($sqlite, $dat);
	
	if($res !== ''){
		return ("failed to drop: $res");
	}
	$bindArr=[[
		'value'=>$dat['pk'],
		'type'=>SQLITE3_INTEGER,
		'tag'=>':pk'
	]];

		$statement=$sqlite->prepare('DELETE FROM passwordRecoveryCaptures
		WHERE pk=:pk');
		if(!$statement){
			return 'failed on prepare '.$sqlite->lastErrorMsg();
		}
		
		foreach($bindArr as $ba)
		{
			$statement->bindValue($ba['tag'], $ba['value'], $ba['type']);
		}
		
		if(!$executeResult=$statement->execute()){
			return 'failed to execute :> '.($sqlite->lastErrorMsg());
		}
	
	if($needsReset){
		$sqlite->close();
	}
	return 'SUCCESS';

}

function psGetWAArenderAdmin_passwordRecoveryCaptures($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/db.db");
	}
	$resResult=RMF_TBL_WAArenderAdmin_passwordRecoveryCaptures_SQLITE_RESOLVE($sqlite, $dat);
	if($resResult !== ''){
		return ('failed to resolve '.$resResult);
	}
	if($needsReset){$sqlite->close();}
	return (json_encode($dat));

}

function psSearchWAArenderAdmin_passwordRecoveryCaptures($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/db.db");
	}
	$whereCols=[];
	$bindArr=[];

			if(OBSANE($dat, 'token')){
				if(!RMF_string_FILTERVALIDATE($dat['token'])){
					return ('token was invalid');
				}
				array_push($bindArr,[
					'tag'=>':token',
					'value'=>'%'.$dat['token'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'token LIKE :token' );

			}
		
			if(OBSANE($dat, 'captureToken')){
				if(!RMF_string_FILTERVALIDATE($dat['captureToken'])){
					return ('captureToken was invalid');
				}
				array_push($bindArr,[
					'tag'=>':captureToken',
					'value'=>'%'.$dat['captureToken'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'captureToken LIKE :captureToken' );

			}
		
			if(OBSANE($dat, 'timeAdded')){
				if(!RMF_date_time_FILTERVALIDATE($dat['timeAdded'])){
					return ('timeAdded was invalid');
				}
				array_push($bindArr,[
					'tag'=>':timeAdded',
					'value'=>'%'.$dat['timeAdded'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'timeAdded LIKE :timeAdded' );

			}
		
			if(OBSANE($dat, 'member')){
				$res=RMF_TBL_WAArenderAdmin_members_SQLITE_RESOLVE($sqlite, $dat['member']);
				
				if($res === ''){
					if(!RMF_TBL_WAArenderAdmin_members_FILTERVALIDATE($dat['member'])){
						return ('member was invalid');
					}
					array_push($bindArr, [
						'type'=>SQLITE3_INTEGER,
						'value'=>$dat['member']['pk'],
						'tag'=>':member'
					]);
					array_push($whereCols, 'member=:member');
				}else if($res !== 'empty'){
					return 'a resolve went wrong '.$res;
				}
			}
		
			if(OBSANE($dat, 'pk')){
				if(!RMF_basicPk_FILTERVALIDATE($dat['pk'])){
					return ('pk was invalid');
				}
				array_push($bindArr,[
					'tag'=>':pk',
					'value'=>'%'.$dat['pk'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'pk LIKE :pk' );

			}
		
	if(!count($whereCols)){
		array_push($whereCols, '1');
	}

		$statement=$sqlite->prepare('SELECT token,captureToken,timeAdded,member,pk FROM passwordRecoveryCaptures
		WHERE '.implode(' AND ',$whereCols) );
		if(!$statement){
			return 'failed on prepare '.$sqlite->lastErrorMsg();
		}
		
		if(count($bindArr)){
			foreach($bindArr as $ba)
			{
				$statement->bindValue($ba['tag'], $ba['value'], $ba['type']);
			}
		}
		
		if(!$executeResult=$statement->execute()){
			return 'failed to execute :> '.($sqlite->lastErrorMsg());
		}
	
	
	$ret=[];
	while($row=$executeResult->fetchArray(SQLITE3_ASSOC))
	{
		array_push($ret, $row);
	}
	
	foreach($ret as &$finalReturn)
	{
		
			if($finalReturn['member']){
				$finalReturn['member']=['pk'=>$finalReturn['member']];
				
				RMF_TBL_WAArenderAdmin_members_SQLITE_RESOLVE($sqlite, $finalReturn['member']);
			}
		
	}
	
	if($needsReset){$sqlite->close();}
	
	return json_encode($ret);

}


?>