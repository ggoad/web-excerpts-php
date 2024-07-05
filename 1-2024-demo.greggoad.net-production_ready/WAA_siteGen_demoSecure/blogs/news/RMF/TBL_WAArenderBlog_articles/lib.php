<?php
function psAddWAArenderBlog_articles($dat){

	global $sqlite;
	$insertCols=[];
	$insertValLabels=[];
	$bindArr=[];
	$needsReset=false;
	if(!$sqlite){
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/db.db");
		$needsReset=true;
	}
	

			if(OBSANE($dat, 'article')){
				if(!RMF_para_FILTERVALIDATE($dat['article'])){
					return ('article was invalid');
				}
				
				array_push($insertCols, 'article');
				array_push($insertValLabels, ':article');
				array_push($bindArr, [
					'value'=>$dat['article'],
					'tag'=>':article',
					'type'=>SQLITE3_TEXT
				]);
			}
		
			if(!OBSANE($dat,'auds')){
				return 'failed: the column auds was not provided';
			}
		
			if(OBSANE($dat, 'auds')){
				if(!RMF_para_FILTERVALIDATE($dat['auds'])){
					return ('auds was invalid');
				}
				
				array_push($insertCols, 'auds');
				array_push($insertValLabels, ':auds');
				array_push($bindArr, [
					'value'=>$dat['auds'],
					'tag'=>':auds',
					'type'=>SQLITE3_TEXT
				]);
			}
		
			if(OBSANE($dat, 'css')){
				if(!RMF_para_FILTERVALIDATE($dat['css'])){
					return ('css was invalid');
				}
				
				array_push($insertCols, 'css');
				array_push($insertValLabels, ':css');
				array_push($bindArr, [
					'value'=>$dat['css'],
					'tag'=>':css',
					'type'=>SQLITE3_TEXT
				]);
			}
		
			if(OBSANE($dat, 'igniter')){
				if(!RMF_para_FILTERVALIDATE($dat['igniter'])){
					return ('igniter was invalid');
				}
				
				array_push($insertCols, 'igniter');
				array_push($insertValLabels, ':igniter');
				array_push($bindArr, [
					'value'=>$dat['igniter'],
					'tag'=>':igniter',
					'type'=>SQLITE3_TEXT
				]);
			}
		
			if(!OBSANE($dat,'imgs')){
				return 'failed: the column imgs was not provided';
			}
		
			if(OBSANE($dat, 'imgs')){
				if(!RMF_para_FILTERVALIDATE($dat['imgs'])){
					return ('imgs was invalid');
				}
				
				array_push($insertCols, 'imgs');
				array_push($insertValLabels, ':imgs');
				array_push($bindArr, [
					'value'=>$dat['imgs'],
					'tag'=>':imgs',
					'type'=>SQLITE3_TEXT
				]);
			}
		
			if(OBSANE($dat, 'js')){
				if(!RMF_para_FILTERVALIDATE($dat['js'])){
					return ('js was invalid');
				}
				
				array_push($insertCols, 'js');
				array_push($insertValLabels, ':js');
				array_push($bindArr, [
					'value'=>$dat['js'],
					'tag'=>':js',
					'type'=>SQLITE3_TEXT
				]);
			}
		
			if(OBSANE($dat, 'lastModified')){
				if(!RMF_date_time_FILTERVALIDATE($dat['lastModified'])){
					return ('lastModified was invalid');
				}
				
				array_push($insertCols, 'lastModified');
				array_push($insertValLabels, ':lastModified');
				array_push($bindArr, [
					'value'=>$dat['lastModified'],
					'tag'=>':lastModified',
					'type'=>SQLITE3_TEXT
				]);
			}
		
			if(!OBSANE($dat,'meta')){
				return 'failed: the column meta was not provided';
			}
		
			if(OBSANE($dat, 'meta')){
				if(!RMF_para_FILTERVALIDATE($dat['meta'])){
					return ('meta was invalid');
				}
				
				array_push($insertCols, 'meta');
				array_push($insertValLabels, ':meta');
				array_push($bindArr, [
					'value'=>$dat['meta'],
					'tag'=>':meta',
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
		
			if(OBSANE($dat, 'published')){
				if(!RMF_boolean_FILTERVALIDATE($dat['published'])){
					return ('published was invalid');
				}
				
				array_push($insertCols, 'published');
				array_push($insertValLabels, ':published');
				array_push($bindArr, [
					'value'=>$dat['published'],
					'tag'=>':published',
					'type'=>SQLITE3_TEXT
				]);
			}
		
			if(!OBSANE($dat,'scripts')){
				return 'failed: the column scripts was not provided';
			}
		
			if(OBSANE($dat, 'scripts')){
				if(!RMF_para_FILTERVALIDATE($dat['scripts'])){
					return ('scripts was invalid');
				}
				
				array_push($insertCols, 'scripts');
				array_push($insertValLabels, ':scripts');
				array_push($bindArr, [
					'value'=>$dat['scripts'],
					'tag'=>':scripts',
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
		
			if(OBSANE($dat, 'sortDate')){
				if(!RMF_date_time_FILTERVALIDATE($dat['sortDate'])){
					return ('sortDate was invalid');
				}
				
				array_push($insertCols, 'sortDate');
				array_push($insertValLabels, ':sortDate');
				array_push($bindArr, [
					'value'=>$dat['sortDate'],
					'tag'=>':sortDate',
					'type'=>SQLITE3_TEXT
				]);
			}
		
			if(OBSANE($dat, 'timePublished')){
				if(!RMF_date_time_FILTERVALIDATE($dat['timePublished'])){
					return ('timePublished was invalid');
				}
				
				array_push($insertCols, 'timePublished');
				array_push($insertValLabels, ':timePublished');
				array_push($bindArr, [
					'value'=>$dat['timePublished'],
					'tag'=>':timePublished',
					'type'=>SQLITE3_TEXT
				]);
			}
		
			if(!OBSANE($dat,'title')){
				return 'failed: the column title was not provided';
			}
		
			if(OBSANE($dat, 'title')){
				if(!RMF_string_FILTERVALIDATE($dat['title'])){
					return ('title was invalid');
				}
				
				array_push($insertCols, 'title');
				array_push($insertValLabels, ':title');
				array_push($bindArr, [
					'value'=>$dat['title'],
					'tag'=>':title',
					'type'=>SQLITE3_TEXT
				]);
			}
		
			if(!OBSANE($dat,'vids')){
				return 'failed: the column vids was not provided';
			}
		
			if(OBSANE($dat, 'vids')){
				if(!RMF_para_FILTERVALIDATE($dat['vids'])){
					return ('vids was invalid');
				}
				
				array_push($insertCols, 'vids');
				array_push($insertValLabels, ':vids');
				array_push($bindArr, [
					'value'=>$dat['vids'],
					'tag'=>':vids',
					'type'=>SQLITE3_TEXT
				]);
			}
		
		$statement=$sqlite->prepare('INSERT INTO articles
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

function psEditWAArenderBlog_articles($dat){

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
	$resResult=RMF_TBL_WAArenderBlog_articles_SQLITE_RESOLVE($sqlite, $OGvalue);
	
	if($resResult){
		return 'failed to resolve og: '.$resResult;
	}
	$ogPk=$OGvalue['pk'];

			if(OBSANE($dat, 'article')){
				if(!RMF_para_FILTERVALIDATE($dat['article'])){
					return ('article was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':article',
					'value'=>$dat['article']
				]);
				array_push($setExpressions, 'article=:article' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':article',
					'value'=>$OGvalue['article']
				]);
				array_push($setExpressions, 'article=:article');
			}
		
			if(OBSANE($dat, 'auds')){
				if(!RMF_para_FILTERVALIDATE($dat['auds'])){
					return ('auds was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':auds',
					'value'=>$dat['auds']
				]);
				array_push($setExpressions, 'auds=:auds' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':auds',
					'value'=>$OGvalue['auds']
				]);
				array_push($setExpressions, 'auds=:auds');
			}
		
			if(OBSANE($dat, 'css')){
				if(!RMF_para_FILTERVALIDATE($dat['css'])){
					return ('css was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':css',
					'value'=>$dat['css']
				]);
				array_push($setExpressions, 'css=:css' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':css',
					'value'=>$OGvalue['css']
				]);
				array_push($setExpressions, 'css=:css');
			}
		
			if(OBSANE($dat, 'igniter')){
				if(!RMF_para_FILTERVALIDATE($dat['igniter'])){
					return ('igniter was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':igniter',
					'value'=>$dat['igniter']
				]);
				array_push($setExpressions, 'igniter=:igniter' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':igniter',
					'value'=>$OGvalue['igniter']
				]);
				array_push($setExpressions, 'igniter=:igniter');
			}
		
			if(OBSANE($dat, 'imgs')){
				if(!RMF_para_FILTERVALIDATE($dat['imgs'])){
					return ('imgs was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':imgs',
					'value'=>$dat['imgs']
				]);
				array_push($setExpressions, 'imgs=:imgs' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':imgs',
					'value'=>$OGvalue['imgs']
				]);
				array_push($setExpressions, 'imgs=:imgs');
			}
		
			if(OBSANE($dat, 'js')){
				if(!RMF_para_FILTERVALIDATE($dat['js'])){
					return ('js was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':js',
					'value'=>$dat['js']
				]);
				array_push($setExpressions, 'js=:js' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':js',
					'value'=>$OGvalue['js']
				]);
				array_push($setExpressions, 'js=:js');
			}
		
			if(OBSANE($dat, 'lastModified')){
				if(!RMF_date_time_FILTERVALIDATE($dat['lastModified'])){
					return ('lastModified was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':lastModified',
					'value'=>$dat['lastModified']
				]);
				array_push($setExpressions, 'lastModified=:lastModified' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':lastModified',
					'value'=>$OGvalue['lastModified']
				]);
				array_push($setExpressions, 'lastModified=:lastModified');
			}
		
			if(OBSANE($dat, 'meta')){
				if(!RMF_para_FILTERVALIDATE($dat['meta'])){
					return ('meta was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':meta',
					'value'=>$dat['meta']
				]);
				array_push($setExpressions, 'meta=:meta' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':meta',
					'value'=>$OGvalue['meta']
				]);
				array_push($setExpressions, 'meta=:meta');
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
		
			if(OBSANE($dat, 'published')){
				if(!RMF_boolean_FILTERVALIDATE($dat['published'])){
					return ('published was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':published',
					'value'=>$dat['published']
				]);
				array_push($setExpressions, 'published=:published' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':published',
					'value'=>$OGvalue['published']
				]);
				array_push($setExpressions, 'published=:published');
			}
		
			if(OBSANE($dat, 'scripts')){
				if(!RMF_para_FILTERVALIDATE($dat['scripts'])){
					return ('scripts was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':scripts',
					'value'=>$dat['scripts']
				]);
				array_push($setExpressions, 'scripts=:scripts' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':scripts',
					'value'=>$OGvalue['scripts']
				]);
				array_push($setExpressions, 'scripts=:scripts');
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
		
			if(OBSANE($dat, 'sortDate')){
				if(!RMF_date_time_FILTERVALIDATE($dat['sortDate'])){
					return ('sortDate was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':sortDate',
					'value'=>$dat['sortDate']
				]);
				array_push($setExpressions, 'sortDate=:sortDate' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':sortDate',
					'value'=>$OGvalue['sortDate']
				]);
				array_push($setExpressions, 'sortDate=:sortDate');
			}
		
			if(OBSANE($dat, 'timePublished')){
				if(!RMF_date_time_FILTERVALIDATE($dat['timePublished'])){
					return ('timePublished was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':timePublished',
					'value'=>$dat['timePublished']
				]);
				array_push($setExpressions, 'timePublished=:timePublished' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':timePublished',
					'value'=>$OGvalue['timePublished']
				]);
				array_push($setExpressions, 'timePublished=:timePublished');
			}
		
			if(OBSANE($dat, 'title')){
				if(!RMF_string_FILTERVALIDATE($dat['title'])){
					return ('title was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':title',
					'value'=>$dat['title']
				]);
				array_push($setExpressions, 'title=:title' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':title',
					'value'=>$OGvalue['title']
				]);
				array_push($setExpressions, 'title=:title');
			}
		
			if(OBSANE($dat, 'vids')){
				if(!RMF_para_FILTERVALIDATE($dat['vids'])){
					return ('vids was invalid');
				}
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':vids',
					'value'=>$dat['vids']
				]);
				array_push($setExpressions, 'vids=:vids' );
			}else{
				array_push($bindArr,[
					'type'=>SQLITE3_TEXT,
					'tag'=>':vids',
					'value'=>$OGvalue['vids']
				]);
				array_push($setExpressions, 'vids=:vids');
			}
		
	array_push($bindArr, [
		'value'=>$ogPk,
		'tag'=>':ogPk',
		'type'=>SQLITE3_INTEGER
	]);

		$statement=$sqlite->prepare('UPDATE articles
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

function psDropWAArenderBlog_articles($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLITE3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/db.db");
	}

		$res=RMF_TBL_WAArenderBlog_articles_SQLITE_RESOLVE($sqlite, $dat);
	
	if($res !== ''){
		return ("failed to drop: $res");
	}
	$bindArr=[[
		'value'=>$dat['pk'],
		'type'=>SQLITE3_INTEGER,
		'tag'=>':pk'
	]];

		$statement=$sqlite->prepare('DELETE FROM articles
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

function psGetWAArenderBlog_articles($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/db.db");
	}
	$resResult=RMF_TBL_WAArenderBlog_articles_SQLITE_RESOLVE($sqlite, $dat);
	if($resResult !== ''){
		return ('failed to resolve '.$resResult);
	}
	if($needsReset){$sqlite->close();}
	return (json_encode($dat));

}

function psSearchWAArenderBlog_articles($dat){

	global $sqlite;
	$needsReset=false;
	if(!$sqlite){
		$needsReset=true;
		$sqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/db.db");
	}
	$whereCols=[];
	$bindArr=[];

			if(OBSANE($dat, 'article')){
				if(!RMF_para_FILTERVALIDATE($dat['article'])){
					return ('article was invalid');
				}
				array_push($bindArr,[
					'tag'=>':article',
					'value'=>'%'.$dat['article'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'article LIKE :article' );

			}
		
			if(OBSANE($dat, 'auds')){
				if(!RMF_para_FILTERVALIDATE($dat['auds'])){
					return ('auds was invalid');
				}
				array_push($bindArr,[
					'tag'=>':auds',
					'value'=>'%'.$dat['auds'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'auds LIKE :auds' );

			}
		
			if(OBSANE($dat, 'css')){
				if(!RMF_para_FILTERVALIDATE($dat['css'])){
					return ('css was invalid');
				}
				array_push($bindArr,[
					'tag'=>':css',
					'value'=>'%'.$dat['css'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'css LIKE :css' );

			}
		
			if(OBSANE($dat, 'igniter')){
				if(!RMF_para_FILTERVALIDATE($dat['igniter'])){
					return ('igniter was invalid');
				}
				array_push($bindArr,[
					'tag'=>':igniter',
					'value'=>'%'.$dat['igniter'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'igniter LIKE :igniter' );

			}
		
			if(OBSANE($dat, 'imgs')){
				if(!RMF_para_FILTERVALIDATE($dat['imgs'])){
					return ('imgs was invalid');
				}
				array_push($bindArr,[
					'tag'=>':imgs',
					'value'=>'%'.$dat['imgs'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'imgs LIKE :imgs' );

			}
		
			if(OBSANE($dat, 'js')){
				if(!RMF_para_FILTERVALIDATE($dat['js'])){
					return ('js was invalid');
				}
				array_push($bindArr,[
					'tag'=>':js',
					'value'=>'%'.$dat['js'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'js LIKE :js' );

			}
		
			if(OBSANE($dat, 'lastModified')){
				if(!RMF_date_time_FILTERVALIDATE($dat['lastModified'])){
					return ('lastModified was invalid');
				}
				array_push($bindArr,[
					'tag'=>':lastModified',
					'value'=>'%'.$dat['lastModified'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'lastModified LIKE :lastModified' );

			}
		
			if(OBSANE($dat, 'meta')){
				if(!RMF_para_FILTERVALIDATE($dat['meta'])){
					return ('meta was invalid');
				}
				array_push($bindArr,[
					'tag'=>':meta',
					'value'=>'%'.$dat['meta'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'meta LIKE :meta' );

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
		
			if(OBSANE($dat, 'published')){
				if(!RMF_boolean_FILTERVALIDATE($dat['published'])){
					return ('published was invalid');
				}
				array_push($bindArr,[
					'tag'=>':published',
					'value'=>'%'.$dat['published'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'published LIKE :published' );

			}
		
			if(OBSANE($dat, 'scripts')){
				if(!RMF_para_FILTERVALIDATE($dat['scripts'])){
					return ('scripts was invalid');
				}
				array_push($bindArr,[
					'tag'=>':scripts',
					'value'=>'%'.$dat['scripts'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'scripts LIKE :scripts' );

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
		
			if(OBSANE($dat, 'sortDate')){
				if(!RMF_date_time_FILTERVALIDATE($dat['sortDate'])){
					return ('sortDate was invalid');
				}
				array_push($bindArr,[
					'tag'=>':sortDate',
					'value'=>'%'.$dat['sortDate'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'sortDate LIKE :sortDate' );

			}
		
			if(OBSANE($dat, 'timePublished')){
				if(!RMF_date_time_FILTERVALIDATE($dat['timePublished'])){
					return ('timePublished was invalid');
				}
				array_push($bindArr,[
					'tag'=>':timePublished',
					'value'=>'%'.$dat['timePublished'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'timePublished LIKE :timePublished' );

			}
		
			if(OBSANE($dat, 'title')){
				if(!RMF_string_FILTERVALIDATE($dat['title'])){
					return ('title was invalid');
				}
				array_push($bindArr,[
					'tag'=>':title',
					'value'=>'%'.$dat['title'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'title LIKE :title' );

			}
		
			if(OBSANE($dat, 'vids')){
				if(!RMF_para_FILTERVALIDATE($dat['vids'])){
					return ('vids was invalid');
				}
				array_push($bindArr,[
					'tag'=>':vids',
					'value'=>'%'.$dat['vids'].'%',
					'type'=>SQLITE3_TEXT
				]);
				array_push($whereCols, 'vids LIKE :vids' );

			}
		
	if(!count($whereCols)){
		array_push($whereCols, '1');
	}

		$statement=$sqlite->prepare('SELECT article,auds,css,igniter,imgs,js,lastModified,meta,pk,published,scripts,slug,sortDate,timePublished,title,vids FROM articles
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