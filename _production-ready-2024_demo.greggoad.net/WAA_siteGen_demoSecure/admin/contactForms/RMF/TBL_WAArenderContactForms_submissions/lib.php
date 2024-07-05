<?php
function psAddWAArenderContactForms_submissions($dat){

	global $sqlite;
	$insertCols=[];
	$insertValLabels=[];
	$bindArr=[];
	$needsReset=false;
	if(!$sqlite){
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/contactForms/db.db");
		$needsReset=true;
	}
	

			if(!OBSANE($dat,'categoryState')){
				return 'failed: the column categoryState was not provided';
			}
		
			if(OBSANE($dat, 'categoryState')){
				if(!RMF_string_FILTERVALIDATE($dat['categoryState'])){
					return ('categoryState was invalid');
				}
				
				array_push($insertCols, 'categoryState');
				array_push($insertValLabels, ':categoryState');
				array_push($bindArr, [
					'value'=>$dat['categoryState'],
					'tag'=>':categoryState',
					'type'=>SQLITE3_TEXT
				]);
			}
		
			if(!OBSANE($dat,'dat')){
				return 'failed: the column dat was not provided';
			}
		
			if(OBSANE($dat, 'dat')){
				if(!RMF_para_FILTERVALIDATE($dat['dat'])){
					return ('dat was invalid');
				}
				
				array_push($insertCols, 'dat');
				array_push($insertValLabels, ':dat');
				array_push($bindArr, [
					'value'=>$dat['dat'],
					'tag'=>':dat',
					'type'=>SQLITE3_TEXT
				]);
			}
		
			if(!OBSANE($dat,'form')){
				return 'failed: the column form was not provided';
			}
		
			if(OBSANE($dat, 'form')){
				if(!RMF_string_FILTERVALIDATE($dat['form'])){
					return ('form was invalid');
				}
				
				array_push($insertCols, 'form');
				array_push($insertValLabels, ':form');
				array_push($bindArr, [
					'value'=>$dat['form'],
					'tag'=>':form',
					'type'=>SQLITE3_TEXT
				]);
			}
		
			if(!OBSANE($dat,'ipAddress')){
				return 'failed: the column ipAddress was not provided';
			}
		
			if(OBSANE($dat, 'ipAddress')){
				if(!RMF_string_FILTERVALIDATE($dat['ipAddress'])){
					return ('ipAddress was invalid');
				}
				
				array_push($insertCols, 'ipAddress');
				array_push($insertValLabels, ':ipAddress');
				array_push($bindArr, [
					'value'=>$dat['ipAddress'],
					'tag'=>':ipAddress',
					'type'=>SQLITE3_TEXT
				]);
			}
		
			if(!OBSANE($dat,'monthSubmitted')){
				return 'failed: the column monthSubmitted was not provided';
			}
		
			if(OBSANE($dat, 'monthSubmitted')){
				if(!RMF_integer_FILTERVALIDATE($dat['monthSubmitted'])){
					return ('monthSubmitted was invalid');
				}
				
				array_push($insertCols, 'monthSubmitted');
				array_push($insertValLabels, ':monthSubmitted');
				array_push($bindArr, [
					'value'=>$dat['monthSubmitted'],
					'tag'=>':monthSubmitted',
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
		
			if(OBSANE($dat, 'timeSubmitted')){
				if(!RMF_date_time_FILTERVALIDATE($dat['timeSubmitted'])){
					return ('timeSubmitted was invalid');
				}
				
				array_push($insertCols, 'timeSubmitted');
				array_push($insertValLabels, ':timeSubmitted');
				array_push($bindArr, [
					'value'=>$dat['timeSubmitted'],
					'tag'=>':timeSubmitted',
					'type'=>SQLITE3_TEXT
				]);
			}
		
			if(!OBSANE($dat,'yearSubmitted')){
				return 'failed: the column yearSubmitted was not provided';
			}
		
			if(OBSANE($dat, 'yearSubmitted')){
				if(!RMF_integer_FILTERVALIDATE($dat['yearSubmitted'])){
					return ('yearSubmitted was invalid');
				}
				
				array_push($insertCols, 'yearSubmitted');
				array_push($insertValLabels, ':yearSubmitted');
				array_push($bindArr, [
					'value'=>$dat['yearSubmitted'],
					'tag'=>':yearSubmitted',
					'type'=>SQLITE3_TEXT
				]);
			}
		
		$statement=$sqlite->prepare('INSERT INTO submissions
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

function psEditWAArenderContactForms_submissions($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/contactForms/db.db");
	}
	$setExpressions=[];
	$bindArr=[];
	$ogPk='';
	
	
	ObVarSet($dat,'OGvalue', $OGvalue);
	$resResult=RMF_TBL_WAArenderContactForms_submissions_SQLITE_RESOLVE($sqlite, $OGvalue);
	
	if($resResult){
		return 'failed to resolve og: '.$resResult;
	}
	$ogPk=$OGvalue['pk'];

			if(OBSANE($dat, 'categoryState')){
				if(!RMF_string_FILTERVALIDATE($dat['categoryState'])){
					return ('categoryState was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':categoryState',
					'value'=>$dat['categoryState']
				]);
				array_push($setExpressions, 'categoryState=:categoryState' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':categoryState',
					'value'=>$OGvalue['categoryState']
				]);
				array_push($setExpressions, 'categoryState=:categoryState');
			}
		
			if(OBSANE($dat, 'dat')){
				if(!RMF_para_FILTERVALIDATE($dat['dat'])){
					return ('dat was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':dat',
					'value'=>$dat['dat']
				]);
				array_push($setExpressions, 'dat=:dat' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':dat',
					'value'=>$OGvalue['dat']
				]);
				array_push($setExpressions, 'dat=:dat');
			}
		
			if(OBSANE($dat, 'form')){
				if(!RMF_string_FILTERVALIDATE($dat['form'])){
					return ('form was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':form',
					'value'=>$dat['form']
				]);
				array_push($setExpressions, 'form=:form' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':form',
					'value'=>$OGvalue['form']
				]);
				array_push($setExpressions, 'form=:form');
			}
		
			if(OBSANE($dat, 'ipAddress')){
				if(!RMF_string_FILTERVALIDATE($dat['ipAddress'])){
					return ('ipAddress was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':ipAddress',
					'value'=>$dat['ipAddress']
				]);
				array_push($setExpressions, 'ipAddress=:ipAddress' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':ipAddress',
					'value'=>$OGvalue['ipAddress']
				]);
				array_push($setExpressions, 'ipAddress=:ipAddress');
			}
		
			if(OBSANE($dat, 'monthSubmitted')){
				if(!RMF_integer_FILTERVALIDATE($dat['monthSubmitted'])){
					return ('monthSubmitted was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':monthSubmitted',
					'value'=>$dat['monthSubmitted']
				]);
				array_push($setExpressions, 'monthSubmitted=:monthSubmitted' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':monthSubmitted',
					'value'=>$OGvalue['monthSubmitted']
				]);
				array_push($setExpressions, 'monthSubmitted=:monthSubmitted');
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
		
			if(OBSANE($dat, 'timeSubmitted')){
				if(!RMF_date_time_FILTERVALIDATE($dat['timeSubmitted'])){
					return ('timeSubmitted was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':timeSubmitted',
					'value'=>$dat['timeSubmitted']
				]);
				array_push($setExpressions, 'timeSubmitted=:timeSubmitted' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':timeSubmitted',
					'value'=>$OGvalue['timeSubmitted']
				]);
				array_push($setExpressions, 'timeSubmitted=:timeSubmitted');
			}
		
			if(OBSANE($dat, 'yearSubmitted')){
				if(!RMF_integer_FILTERVALIDATE($dat['yearSubmitted'])){
					return ('yearSubmitted was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':yearSubmitted',
					'value'=>$dat['yearSubmitted']
				]);
				array_push($setExpressions, 'yearSubmitted=:yearSubmitted' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':yearSubmitted',
					'value'=>$OGvalue['yearSubmitted']
				]);
				array_push($setExpressions, 'yearSubmitted=:yearSubmitted');
			}
		
	array_push($bindArr, [
		'value'=>$ogPk,
		'tag'=>':ogPk',
		'type'=>SQLITE3_INTEGER
	]);

		$statement=$sqlite->prepare('UPDATE submissions
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

function psDropWAArenderContactForms_submissions($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLITE3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/contactForms/db.db");
	}

		$res=RMF_TBL_WAArenderContactForms_submissions_SQLITE_RESOLVE($sqlite, $dat);
	
	if($res !== ''){
		return ("failed to drop: $res");
	}
	$bindArr=[[
		'value'=>$dat['pk'],
		'type'=>SQLITE3_INTEGER,
		'tag'=>':pk'
	]];

		$statement=$sqlite->prepare('DELETE FROM submissions
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

function psGetWAArenderContactForms_submissions($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/contactForms/db.db");
	}
	$resResult=RMF_TBL_WAArenderContactForms_submissions_SQLITE_RESOLVE($sqlite, $dat);
	if($resResult !== ''){
		return ('failed to resolve '.$resResult);
	}
	if($needsReset){$sqlite->close();}
	return (json_encode($dat));

}

function psSearchWAArenderContactForms_submissions($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/contactForms/db.db");
	}
	$whereCols=[];
	$bindArr=[];

			if(OBSANE($dat, 'categoryState')){
				if(!RMF_string_FILTERVALIDATE($dat['categoryState'])){
					return ('categoryState was invalid');
				}
				array_push($bindArr,[
					'tag'=>':categoryState',
					'value'=>'%'.$dat['categoryState'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'categoryState LIKE :categoryState' );

			}
		
			if(OBSANE($dat, 'dat')){
				if(!RMF_para_FILTERVALIDATE($dat['dat'])){
					return ('dat was invalid');
				}
				array_push($bindArr,[
					'tag'=>':dat',
					'value'=>'%'.$dat['dat'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'dat LIKE :dat' );

			}
		
			if(OBSANE($dat, 'form')){
				if(!RMF_string_FILTERVALIDATE($dat['form'])){
					return ('form was invalid');
				}
				array_push($bindArr,[
					'tag'=>':form',
					'value'=>'%'.$dat['form'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'form LIKE :form' );

			}
		
			if(OBSANE($dat, 'ipAddress')){
				if(!RMF_string_FILTERVALIDATE($dat['ipAddress'])){
					return ('ipAddress was invalid');
				}
				array_push($bindArr,[
					'tag'=>':ipAddress',
					'value'=>'%'.$dat['ipAddress'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'ipAddress LIKE :ipAddress' );

			}
		
			if(OBSANE($dat, 'monthSubmitted')){
				if(!RMF_integer_FILTERVALIDATE($dat['monthSubmitted'])){
					return ('monthSubmitted was invalid');
				}
				array_push($bindArr,[
					'tag'=>':monthSubmitted',
					'value'=>'%'.$dat['monthSubmitted'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'monthSubmitted LIKE :monthSubmitted' );

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
		
			if(OBSANE($dat, 'timeSubmitted')){
				if(!RMF_date_time_FILTERVALIDATE($dat['timeSubmitted'])){
					return ('timeSubmitted was invalid');
				}
				array_push($bindArr,[
					'tag'=>':timeSubmitted',
					'value'=>'%'.$dat['timeSubmitted'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'timeSubmitted LIKE :timeSubmitted' );

			}
		
			if(OBSANE($dat, 'yearSubmitted')){
				if(!RMF_integer_FILTERVALIDATE($dat['yearSubmitted'])){
					return ('yearSubmitted was invalid');
				}
				array_push($bindArr,[
					'tag'=>':yearSubmitted',
					'value'=>'%'.$dat['yearSubmitted'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'yearSubmitted LIKE :yearSubmitted' );

			}
		
	if(!count($whereCols)){
		array_push($whereCols, '1');
	}

		$statement=$sqlite->prepare('SELECT categoryState,dat,form,ipAddress,monthSubmitted,pk,timeSubmitted,yearSubmitted FROM submissions
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