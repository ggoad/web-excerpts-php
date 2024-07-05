<?php 
require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/onlyLoggedIn.php");

require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");



PostVarSet("cform",$cform);
PostVarSet('category', $category);

$sqlite=SQLite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/contactForms/db.db");

if($category === 'new'){
	$retCat='recents';
	$stmt=$sqlite->prepare("SELECT * FROM submissions WHERE form=:form AND categoryState='new' ORDER BY pk DESC;");
}else if($category === 'archive'){
	$retCat='archives';
	$stmt=$sqlite->prepare("SELECT COUNT(*) num, monthSubmitted, yearSubmitted FROM submissions WHERE form=:form AND categoryState='archived' GROUP BY yearSubmitted, monthSubmitted;");
}else if($category === 'archiveSpecific'){
	$retCat='recents';
	PostVarSet('year', $year);
	PostVarSet('month',$month);
	$year=intval($year);
	$month=intval($month);
	
	$stmt=$sqlite->prepare("SELECT * FROM submissions WHERE form=:form AND categoryState='archived' AND yearSubmitted=:year AND monthSubmitted=:month ORDER BY pk DESC");
	$stmt->bindValue(':year', $year, SQLITE3_TEXT);
	$stmt->bindValue(':month', $month, SQLITE3_TEXT);
	
	//$sqlite->query("");
}
$stmt->bindParam(":form",$cform,SQLITE3_TEXT);

$result=$stmt->execute();
$data=[];
$data[$retCat]=[];

while($row=$result->fetchArray(SQLITE3_ASSOC))
{
	$data[$retCat][]=$row;
}

if(count($data[$retCat]) && $retCat === 'recents'){
	$fileName=preg_replace('/[^A-Za-z0-9]/',"-",$cform);
	$functName=preg_replace('/[^A-Za-z0-9]/',"_",$cform);
	
	require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/enc/contactForms/$fileName/lib.php");
	
	foreach($data[$retCat] as &$dat)
	{
		$dat['dat']=json_decode("ContactForm_{$functName}_decrypt"($dat['dat']),true);
	}
	unset($dat);
}

if(count($data[$retCat]) && $retCat === 'archives'){
	$ret=array_reduce($data[$retCat], function($c, $i){
		if(!isset($c[$i['yearSubmitted']])){
			$c[$i['yearSubmitted']] = [
				'total'=>0,
				'months'=>['apple'=>'']
			];
		}
		$c[$i['yearSubmitted']]['total']+=intval($i['num']);
		$c[$i['yearSubmitted']]['months'][$i['monthSubmitted']]=['total'=>$i['num']];
		unset($c[$i['yearSubmitted']]['months']['apple']);
		return $c;
	}, ['apple'=>'']);
	unset($ret['apple']);
	$data[$retCat]=$ret;
}

$sqlite->close();
die(json_encode([
	'success'=>true,
	'data'=>$data
]));

?>