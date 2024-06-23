<?php
function psAdd_redacted__categoryTies($dat){

	global $sqlite;
	$insertCols=[];
	$insertValLabels=[];
	$bindArr=[];
	$needsReset=false;
	if(!$sqlite){
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../_redacted_/blogs/news/db.db");
		$needsReset=true;
	}
	

			if(!OBSANE($dat,'article')){
				return 'failed: the column article was not provided';
			}
		
				if(OBSANE($dat, 'article')){
					if(($res=RMF__redacted__articles_SQLITE_RESOLVE($sqlite,$dat['article'])) !== 'empty'){	
						if($res !== ''){
							return 'a resolve went wrong '.$res;
						}
						if(!RMF__redacted__articles_FILTERVALIDATE($dat['article'])){
							return ('article was invalid');
						}
						array_push($insertCols, 'article');
						array_push($insertValLabels, ':article');
						array_push($bindArr, [
							'value'=>$dat['article']['pk'],
							'tag'=>':article',
							'type'=>SQLITE3_INTEGER
						]);
					}else{
						return 'no valid article provided. Resolve empty';
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
		
			if(!OBSANE($dat,'category')){
				return 'failed: the column category was not provided';
			}
		
				if(OBSANE($dat, 'category')){
					if(($res=RMF__redacted__categories_SQLITE_RESOLVE($sqlite,$dat['category'])) !== 'empty'){	
						if($res !== ''){
							return 'a resolve went wrong '.$res;
						}
						if(!RMF__redacted__categories_FILTERVALIDATE($dat['category'])){
							return ('category was invalid');
						}
						array_push($insertCols, 'category');
						array_push($insertValLabels, ':category');
						array_push($bindArr, [
							'value'=>$dat['category']['pk'],
							'tag'=>':category',
							'type'=>SQLITE3_INTEGER
						]);
					}else{
						return 'no valid category provided. Resolve empty';
					}
				}
			
		$statement=$sqlite->prepare('INSERT INTO categoryTies
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

function psEdit_redacted__categoryTies($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../_redacted_/blogs/news/db.db");
	}
	$setExpressions=[];
	$bindArr=[];
	$ogPk='';
	
	
	ObVarSet($dat,'OGvalue', $OGvalue);
	$resResult=RMF__redacted__categoryTies_SQLITE_RESOLVE($sqlite, $OGvalue);
	
	if($resResult){
		return 'failed to resolve og: '.$resResult;
	}
	$ogPk=$OGvalue['pk'];

			if(OBSANE($dat, 'article')){
				$res=RMF__redacted__articles_SQLITE_RESOLVE($sqlite, $dat['article']);
				
				if($res === ''){
					if(!RMF__redacted__articles_FILTERVALIDATE($dat['article'])){
						return ('article was invalid');
					}
					array_push($setExpressions, 'article=:article');
					array_push($bindArr, [
						'value'=>$dat['article']['pk'],
						'tag'=>':article',
						'type'=>SQLITE3_INTEGER
					]);
					
				}else if($res !== 'empty'){
					return 'a resolve went wrong '.$res;
				}
			}else if(!is_null($OGvalue['article'])){
				array_push($setExpressions, 'article=:article');
				array_push($bindArr, [
					'value'=>$OGvalue['article']['pk'],
					'tag'=>':article',
					'type'=>SQLITE3_INTEGER
				]);
			}else{
				array_push($setExpressions, 'article=:article');
				array_push($bindArr,[
					'value'=>null,
					'tag'=>':article',
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
		
			if(OBSANE($dat, 'category')){
				$res=RMF__redacted__categories_SQLITE_RESOLVE($sqlite, $dat['category']);
				
				if($res === ''){
					if(!RMF__redacted__categories_FILTERVALIDATE($dat['category'])){
						return ('category was invalid');
					}
					array_push($setExpressions, 'category=:category');
					array_push($bindArr, [
						'value'=>$dat['category']['pk'],
						'tag'=>':category',
						'type'=>SQLITE3_INTEGER
					]);
					
				}else if($res !== 'empty'){
					return 'a resolve went wrong '.$res;
				}
			}else if(!is_null($OGvalue['category'])){
				array_push($setExpressions, 'category=:category');
				array_push($bindArr, [
					'value'=>$OGvalue['category']['pk'],
					'tag'=>':category',
					'type'=>SQLITE3_INTEGER
				]);
			}else{
				array_push($setExpressions, 'category=:category');
				array_push($bindArr,[
					'value'=>null,
					'tag'=>':category',
					'type'=>SQLITE3_INTEGER
				]);
			}
		
	array_push($bindArr, [
		'value'=>$ogPk,
		'tag'=>':ogPk',
		'type'=>SQLITE3_INTEGER
	]);

		$statement=$sqlite->prepare('UPDATE categoryTies
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

function psDrop_redacted__categoryTies($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLITE3("$_SERVER[DOCUMENT_ROOT]/../_redacted_/blogs/news/db.db");
	}

		$res=RMF__redacted__categoryTies_SQLITE_RESOLVE($sqlite, $dat);
	
	if($res !== ''){
		return ("failed to drop: $res");
	}
	$bindArr=[[
		'value'=>$dat['pk'],
		'type'=>SQLITE3_INTEGER,
		'tag'=>':pk'
	]];

		$statement=$sqlite->prepare('DELETE FROM categoryTies
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

function psGet_redacted__categoryTies($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../_redacted_/blogs/news/db.db");
	}
	$resResult=RMF__redacted__categoryTies_SQLITE_RESOLVE($sqlite, $dat);
	if($resResult !== ''){
		return ('failed to resolve '.$resResult);
	}
	if($needsReset){$sqlite->close();}
	return (json_encode($dat));

}

function psSearch_redacted__categoryTies($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../_redacted_/blogs/news/db.db");
	}
	$whereCols=[];
	$bindArr=[];

			if(OBSANE($dat, 'article')){
				$res=RMF__redacted__articles_SQLITE_RESOLVE($sqlite, $dat['article']);
				
				if($res === ''){
					if(!RMF__redacted__articles_FILTERVALIDATE($dat['article'])){
						return ('article was invalid');
					}
					array_push($bindArr, [
						'type'=>SQLITE3_INTEGER,
						'value'=>$dat['article']['pk'],
						'tag'=>':article'
					]);
					array_push($whereCols, 'article=:article');
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
		
			if(OBSANE($dat, 'category')){
				$res=RMF__redacted__categories_SQLITE_RESOLVE($sqlite, $dat['category']);
				
				if($res === ''){
					if(!RMF__redacted__categories_FILTERVALIDATE($dat['category'])){
						return ('category was invalid');
					}
					array_push($bindArr, [
						'type'=>SQLITE3_INTEGER,
						'value'=>$dat['category']['pk'],
						'tag'=>':category'
					]);
					array_push($whereCols, 'category=:category');
				}else if($res !== 'empty'){
					return 'a resolve went wrong '.$res;
				}
			}
		
	if(!count($whereCols)){
		array_push($whereCols, '1');
	}

		$statement=$sqlite->prepare('SELECT article,pk,category FROM categoryTies
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
		
			if($finalReturn['article']){
				$finalReturn['article']=['pk'=>$finalReturn['article']];
				
				RMF__redacted__articles_SQLITE_RESOLVE($sqlite, $finalReturn['article']);
			}
		
			if($finalReturn['category']){
				$finalReturn['category']=['pk'=>$finalReturn['category']];
				
				RMF__redacted__categories_SQLITE_RESOLVE($sqlite, $finalReturn['category']);
			}
		
	}
	
	if($needsReset){$sqlite->close();}
	
	return json_encode($ret);

}


?>