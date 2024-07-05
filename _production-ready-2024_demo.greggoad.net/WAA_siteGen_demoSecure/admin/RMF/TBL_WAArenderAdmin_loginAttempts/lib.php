<?php
function psAddWAArenderAdmin_loginAttempts($dat){

	global $sqlite;
	$insertCols=[];
	$insertValLabels=[];
	$bindArr=[];
	$needsReset=false;
	if(!$sqlite){
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/db.db");
		$needsReset=true;
	}
	

			if(OBSANE($dat, 'timeAttempted')){
				if(!RMF_date_time_FILTERVALIDATE($dat['timeAttempted'])){
					return ('timeAttempted was invalid');
				}
				
				array_push($insertCols, 'timeAttempted');
				array_push($insertValLabels, ':timeAttempted');
				array_push($bindArr, [
					'value'=>$dat['timeAttempted'],
					'tag'=>':timeAttempted',
					'type'=>SQLITE3_TEXT
				]);
			}
		
			if(OBSANE($dat, 'res')){
				if(!RMF_boolean_FILTERVALIDATE($dat['res'])){
					return ('res was invalid');
				}
				
				array_push($insertCols, 'res');
				array_push($insertValLabels, ':res');
				array_push($bindArr, [
					'value'=>$dat['res'],
					'tag'=>':res',
					'type'=>SQLITE3_TEXT
				]);
			}
		
			if(!OBSANE($dat,'email')){
				return 'failed: the column email was not provided';
			}
		
			if(OBSANE($dat, 'email')){
				if(!RMF_string_FILTERVALIDATE($dat['email'])){
					return ('email was invalid');
				}
				
				array_push($insertCols, 'email');
				array_push($insertValLabels, ':email');
				array_push($bindArr, [
					'value'=>$dat['email'],
					'tag'=>':email',
					'type'=>SQLITE3_TEXT
				]);
			}
		
			if(!OBSANE($dat,'ip')){
				return 'failed: the column ip was not provided';
			}
		
			if(OBSANE($dat, 'ip')){
				if(!RMF_string_FILTERVALIDATE($dat['ip'])){
					return ('ip was invalid');
				}
				
				array_push($insertCols, 'ip');
				array_push($insertValLabels, ':ip');
				array_push($bindArr, [
					'value'=>$dat['ip'],
					'tag'=>':ip',
					'type'=>SQLITE3_TEXT
				]);
			}
		
		$statement=$sqlite->prepare('INSERT INTO loginAttempts
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

function psEditWAArenderAdmin_loginAttempts($dat){

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
	$resResult=RMF_TBL_WAArenderAdmin_loginAttempts_SQLITE_RESOLVE($sqlite, $OGvalue);
	
	if($resResult){
		return 'failed to resolve og: '.$resResult;
	}
	$ogPk=$OGvalue['pk'];

			if(OBSANE($dat, 'timeAttempted')){
				if(!RMF_date_time_FILTERVALIDATE($dat['timeAttempted'])){
					return ('timeAttempted was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':timeAttempted',
					'value'=>$dat['timeAttempted']
				]);
				array_push($setExpressions, 'timeAttempted=:timeAttempted' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':timeAttempted',
					'value'=>$OGvalue['timeAttempted']
				]);
				array_push($setExpressions, 'timeAttempted=:timeAttempted');
			}
		
			if(OBSANE($dat, 'res')){
				if(!RMF_boolean_FILTERVALIDATE($dat['res'])){
					return ('res was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':res',
					'value'=>$dat['res']
				]);
				array_push($setExpressions, 'res=:res' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':res',
					'value'=>$OGvalue['res']
				]);
				array_push($setExpressions, 'res=:res');
			}
		
			if(OBSANE($dat, 'email')){
				if(!RMF_string_FILTERVALIDATE($dat['email'])){
					return ('email was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':email',
					'value'=>$dat['email']
				]);
				array_push($setExpressions, 'email=:email' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':email',
					'value'=>$OGvalue['email']
				]);
				array_push($setExpressions, 'email=:email');
			}
		
			if(OBSANE($dat, 'ip')){
				if(!RMF_string_FILTERVALIDATE($dat['ip'])){
					return ('ip was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':ip',
					'value'=>$dat['ip']
				]);
				array_push($setExpressions, 'ip=:ip' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':ip',
					'value'=>$OGvalue['ip']
				]);
				array_push($setExpressions, 'ip=:ip');
			}
		
	array_push($bindArr, [
		'value'=>$ogPk,
		'tag'=>':ogPk',
		'type'=>SQLITE3_INTEGER
	]);

		$statement=$sqlite->prepare('UPDATE loginAttempts
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

function psDropWAArenderAdmin_loginAttempts($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLITE3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/db.db");
	}

		$res=RMF_TBL_WAArenderAdmin_loginAttempts_SQLITE_RESOLVE($sqlite, $dat);
	
	if($res !== ''){
		return ("failed to drop: $res");
	}
	$bindArr=[[
		'value'=>$dat['pk'],
		'type'=>SQLITE3_INTEGER,
		'tag'=>':pk'
	]];

		$statement=$sqlite->prepare('DELETE FROM loginAttempts
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

function psGetWAArenderAdmin_loginAttempts($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/db.db");
	}
	$resResult=RMF_TBL_WAArenderAdmin_loginAttempts_SQLITE_RESOLVE($sqlite, $dat);
	if($resResult !== ''){
		return ('failed to resolve '.$resResult);
	}
	if($needsReset){$sqlite->close();}
	return (json_encode($dat));

}

function psSearchWAArenderAdmin_loginAttempts($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/db.db");
	}
	$whereCols=[];
	$bindArr=[];

			if(OBSANE($dat, 'timeAttempted')){
				if(!RMF_date_time_FILTERVALIDATE($dat['timeAttempted'])){
					return ('timeAttempted was invalid');
				}
				array_push($bindArr,[
					'tag'=>':timeAttempted',
					'value'=>'%'.$dat['timeAttempted'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'timeAttempted LIKE :timeAttempted' );

			}
		
			if(OBSANE($dat, 'res')){
				if(!RMF_boolean_FILTERVALIDATE($dat['res'])){
					return ('res was invalid');
				}
				array_push($bindArr,[
					'tag'=>':res',
					'value'=>'%'.$dat['res'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'res LIKE :res' );

			}
		
			if(OBSANE($dat, 'email')){
				if(!RMF_string_FILTERVALIDATE($dat['email'])){
					return ('email was invalid');
				}
				array_push($bindArr,[
					'tag'=>':email',
					'value'=>'%'.$dat['email'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'email LIKE :email' );

			}
		
			if(OBSANE($dat, 'ip')){
				if(!RMF_string_FILTERVALIDATE($dat['ip'])){
					return ('ip was invalid');
				}
				array_push($bindArr,[
					'tag'=>':ip',
					'value'=>'%'.$dat['ip'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'ip LIKE :ip' );

			}
		
	if(!count($whereCols)){
		array_push($whereCols, '1');
	}

		$statement=$sqlite->prepare('SELECT timeAttempted,res,email,ip FROM loginAttempts
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
		
	}
	
	if($needsReset){$sqlite->close();}
	
	return json_encode($ret);

}


?>