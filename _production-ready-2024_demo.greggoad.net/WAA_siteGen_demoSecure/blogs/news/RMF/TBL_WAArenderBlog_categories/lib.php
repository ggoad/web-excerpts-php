<?php
function psAddWAArenderBlog_categories($dat){

	global $sqlite;
	$insertCols=[];
	$insertValLabels=[];
	$bindArr=[];
	$needsReset=false;
	if(!$sqlite){
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/db.db");
		$needsReset=true;
	}
	

			if(OBSANE($dat, 'description')){
				if(!RMF_para_FILTERVALIDATE($dat['description'])){
					return ('description was invalid');
				}
				
				array_push($insertCols, 'description');
				array_push($insertValLabels, ':description');
				array_push($bindArr, [
					'value'=>$dat['description'],
					'tag'=>':description',
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
		
			if(OBSANE($dat, 'shareImage')){
				if(!RMF_para_FILTERVALIDATE($dat['shareImage'])){
					return ('shareImage was invalid');
				}
				
				array_push($insertCols, 'shareImage');
				array_push($insertValLabels, ':shareImage');
				array_push($bindArr, [
					'value'=>$dat['shareImage'],
					'tag'=>':shareImage',
					'type'=>SQLITE3_TEXT
				]);
			}
		
			if(!OBSANE($dat,'slug')){
				return 'failed: the column slug was not provided';
			}
		
			if(OBSANE($dat, 'slug')){
				if(!RMF_string_FILTERVALIDATE($dat['slug'])){
					return ('slug was invalid');
				}
				
				array_push($insertCols, 'slug');
				array_push($insertValLabels, ':slug');
				array_push($bindArr, [
					'value'=>$dat['slug'],
					'tag'=>':slug',
					'type'=>SQLITE3_TEXT
				]);
			}
		
		$statement=$sqlite->prepare('INSERT INTO categories
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

function psEditWAArenderBlog_categories($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/db.db");
	}
	$setExpressions=[];
	$bindArr=[];
	$ogPk='';
	
	
	ObVarSet($dat,'OGvalue', $OGvalue);
	$resResult=RMF_TBL_WAArenderBlog_categories_SQLITE_RESOLVE($sqlite, $OGvalue);
	
	if($resResult){
		return 'failed to resolve og: '.$resResult;
	}
	$ogPk=$OGvalue['pk'];

			if(OBSANE($dat, 'description')){
				if(!RMF_para_FILTERVALIDATE($dat['description'])){
					return ('description was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':description',
					'value'=>$dat['description']
				]);
				array_push($setExpressions, 'description=:description' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':description',
					'value'=>$OGvalue['description']
				]);
				array_push($setExpressions, 'description=:description');
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
		
			if(OBSANE($dat, 'shareImage')){
				if(!RMF_para_FILTERVALIDATE($dat['shareImage'])){
					return ('shareImage was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':shareImage',
					'value'=>$dat['shareImage']
				]);
				array_push($setExpressions, 'shareImage=:shareImage' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':shareImage',
					'value'=>$OGvalue['shareImage']
				]);
				array_push($setExpressions, 'shareImage=:shareImage');
			}
		
			if(OBSANE($dat, 'slug')){
				if(!RMF_string_FILTERVALIDATE($dat['slug'])){
					return ('slug was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':slug',
					'value'=>$dat['slug']
				]);
				array_push($setExpressions, 'slug=:slug' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':slug',
					'value'=>$OGvalue['slug']
				]);
				array_push($setExpressions, 'slug=:slug');
			}
		
	array_push($bindArr, [
		'value'=>$ogPk,
		'tag'=>':ogPk',
		'type'=>SQLITE3_INTEGER
	]);

		$statement=$sqlite->prepare('UPDATE categories
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

function psDropWAArenderBlog_categories($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLITE3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/db.db");
	}

		$res=RMF_TBL_WAArenderBlog_categories_SQLITE_RESOLVE($sqlite, $dat);
	
	if($res !== ''){
		return ("failed to drop: $res");
	}
	$bindArr=[[
		'value'=>$dat['pk'],
		'type'=>SQLITE3_INTEGER,
		'tag'=>':pk'
	]];

		$statement=$sqlite->prepare('DELETE FROM categories
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

function psGetWAArenderBlog_categories($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/db.db");
	}
	$resResult=RMF_TBL_WAArenderBlog_categories_SQLITE_RESOLVE($sqlite, $dat);
	if($resResult !== ''){
		return ('failed to resolve '.$resResult);
	}
	if($needsReset){$sqlite->close();}
	return (json_encode($dat));

}

function psSearchWAArenderBlog_categories($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/db.db");
	}
	$whereCols=[];
	$bindArr=[];

			if(OBSANE($dat, 'description')){
				if(!RMF_para_FILTERVALIDATE($dat['description'])){
					return ('description was invalid');
				}
				array_push($bindArr,[
					'tag'=>':description',
					'value'=>'%'.$dat['description'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'description LIKE :description' );

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
		
			if(OBSANE($dat, 'shareImage')){
				if(!RMF_para_FILTERVALIDATE($dat['shareImage'])){
					return ('shareImage was invalid');
				}
				array_push($bindArr,[
					'tag'=>':shareImage',
					'value'=>'%'.$dat['shareImage'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'shareImage LIKE :shareImage' );

			}
		
			if(OBSANE($dat, 'slug')){
				if(!RMF_string_FILTERVALIDATE($dat['slug'])){
					return ('slug was invalid');
				}
				array_push($bindArr,[
					'tag'=>':slug',
					'value'=>'%'.$dat['slug'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'slug LIKE :slug' );

			}
		
	if(!count($whereCols)){
		array_push($whereCols, '1');
	}

		$statement=$sqlite->prepare('SELECT description,name,pk,shareImage,slug FROM categories
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