<?php
function psAddWAArenderAdmin_members($dat){

	global $sqlite;
	$insertCols=[];
	$insertValLabels=[];
	$bindArr=[];
	$needsReset=false;
	if(!$sqlite){
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/db.db");
		$needsReset=true;
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
		
			if(!OBSANE($dat,'name')){
				return 'failed: the column name was not provided';
			}
		
			if(OBSANE($dat, 'name')){
				if(!RMF_string_FILTERVALIDATE($dat['name'])){
					return ('name was invalid');
				}
				
				array_push($insertCols, 'name');
				array_push($insertValLabels, ':name');
				array_push($bindArr, [
					'value'=>$dat['name'],
					'tag'=>':name',
					'type'=>SQLITE3_TEXT
				]);
			}
		
			if(!OBSANE($dat,'pass')){
				return 'failed: the column pass was not provided';
			}
		
			if(OBSANE($dat, 'pass')){
				if(!RMF_string_FILTERVALIDATE($dat['pass'])){
					return ('pass was invalid');
				}
				
				array_push($insertCols, 'pass');
				array_push($insertValLabels, ':pass');
				array_push($bindArr, [
					'value'=>$dat['pass'],
					'tag'=>':pass',
					'type'=>SQLITE3_TEXT
				]);
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
		
			if(!OBSANE($dat,'role')){
				return 'failed: the column role was not provided';
			}
		
			if(OBSANE($dat, 'role')){
				if(!RMF_string_FILTERVALIDATE($dat['role'])){
					return ('role was invalid');
				}
				
				array_push($insertCols, 'role');
				array_push($insertValLabels, ':role');
				array_push($bindArr, [
					'value'=>$dat['role'],
					'tag'=>':role',
					'type'=>SQLITE3_TEXT
				]);
			}
		
		$statement=$sqlite->prepare('INSERT INTO members
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

function psEditWAArenderAdmin_members($dat){

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
	$resResult=RMF_TBL_WAArenderAdmin_members_SQLITE_RESOLVE($sqlite, $OGvalue);
	
	if($resResult){
		return 'failed to resolve og: '.$resResult;
	}
	$ogPk=$OGvalue['pk'];

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
		
			if(OBSANE($dat, 'name')){
				if(!RMF_string_FILTERVALIDATE($dat['name'])){
					return ('name was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':name',
					'value'=>$dat['name']
				]);
				array_push($setExpressions, 'name=:name' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':name',
					'value'=>$OGvalue['name']
				]);
				array_push($setExpressions, 'name=:name');
			}
		
			if(OBSANE($dat, 'pass')){
				if(!RMF_string_FILTERVALIDATE($dat['pass'])){
					return ('pass was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':pass',
					'value'=>$dat['pass']
				]);
				array_push($setExpressions, 'pass=:pass' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':pass',
					'value'=>$OGvalue['pass']
				]);
				array_push($setExpressions, 'pass=:pass');
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
		
			if(OBSANE($dat, 'role')){
				if(!RMF_string_FILTERVALIDATE($dat['role'])){
					return ('role was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':role',
					'value'=>$dat['role']
				]);
				array_push($setExpressions, 'role=:role' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':role',
					'value'=>$OGvalue['role']
				]);
				array_push($setExpressions, 'role=:role');
			}
		
	array_push($bindArr, [
		'value'=>$ogPk,
		'tag'=>':ogPk',
		'type'=>SQLITE3_INTEGER
	]);

		$statement=$sqlite->prepare('UPDATE members
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

function psDropWAArenderAdmin_members($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLITE3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/db.db");
	}

		$res=RMF_TBL_WAArenderAdmin_members_SQLITE_RESOLVE($sqlite, $dat);
	
	if($res !== ''){
		return ("failed to drop: $res");
	}
	$bindArr=[[
		'value'=>$dat['pk'],
		'type'=>SQLITE3_INTEGER,
		'tag'=>':pk'
	]];

		$statement=$sqlite->prepare('DELETE FROM members
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

function psGetWAArenderAdmin_members($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/db.db");
	}
	$resResult=RMF_TBL_WAArenderAdmin_members_SQLITE_RESOLVE($sqlite, $dat);
	if($resResult !== ''){
		return ('failed to resolve '.$resResult);
	}
	if($needsReset){$sqlite->close();}
	return (json_encode($dat));

}

function psSearchWAArenderAdmin_members($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/db.db");
	}
	$whereCols=[];
	$bindArr=[];

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
		
			if(OBSANE($dat, 'name')){
				if(!RMF_string_FILTERVALIDATE($dat['name'])){
					return ('name was invalid');
				}
				array_push($bindArr,[
					'tag'=>':name',
					'value'=>'%'.$dat['name'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'name LIKE :name' );

			}
		
			if(OBSANE($dat, 'pass')){
				if(!RMF_string_FILTERVALIDATE($dat['pass'])){
					return ('pass was invalid');
				}
				array_push($bindArr,[
					'tag'=>':pass',
					'value'=>'%'.$dat['pass'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'pass LIKE :pass' );

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
		
			if(OBSANE($dat, 'role')){
				if(!RMF_string_FILTERVALIDATE($dat['role'])){
					return ('role was invalid');
				}
				array_push($bindArr,[
					'tag'=>':role',
					'value'=>'%'.$dat['role'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'role LIKE :role' );

			}
		
	if(!count($whereCols)){
		array_push($whereCols, '1');
	}

		$statement=$sqlite->prepare('SELECT email,name,pass,pk,role FROM members
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