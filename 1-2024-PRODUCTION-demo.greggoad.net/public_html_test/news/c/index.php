<!DOCTYPE html><html><head><title>Categories | News</title><meta name="description" content="News Categories"><style>.invisiAnchors{color:inherit;text-decoration:inherit}.Blog-CategoryButton{font-size:18px;margin-top:12px;padding:12px 20px;background-color:#007bff;color:#fff;border:2px solid #007bff;border-radius:5px;transition:background-color .3s ease,color .3s ease}.Blog-CategoryButton:hover,.Blog-CategoryButton:focus{background-color:#0056b3;color:#fff}</style></head><body><h1>Select a Category</h1><br><?php 

function CatButton($c){
	$href='/news';
	if(isset($c['slug'])){
		$href.="/c/$c[slug]";
	}
	return HTML_element('a',[
		'href'=>$href,
		'class'=>'invisiAnchors'
	],[
		[
			'tag'=>'div',
			'properties'=>[
				'class'=>'Blog-CategoryButton'
			],
			'children'=>[$c['name']]
		]
	]);
}

require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/htmlRenderers.php");

$sqlite=SQLite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/db.db");

$result=$sqlite->query("SELECT * FROM categories");

echo(CatButton(['name'=>'All']));

while($row=$result->fetchArray(SQLITE3_ASSOC))
{
	echo(CatButton($row));
}

?></body></html>