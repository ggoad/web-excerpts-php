<?php 
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");


PostVarSet('ne',$ne);
PostVarSet('sw',$sw);

$ne=json_decode($ne, true);
$sw=json_decode($sw, true);
$r=$ne['lng'];
$t=$ne['lat'];
$b=$sw['lat'];
$l=$sw['lng'];

require_once("RMF/lib.php");
require_once("RMF/sqlConnFunctions.php");
require_once("RMF/user.php");

$stmt=$sqlConn->prepare("SELECT rmf.TBL_world_places_RESOLVEFUNCT(pl.pk) FROM world.places pl JOIN world.location ll ON pl.location = ll.pk WHERE ll.lat >= ? AND ll.lat <= ? AND ll.lng >= ? AND ll.lng <=?");
$stmt->bind_param('dddd', $b, $t, $l, $r);
$result=$stmt->execute(); 
$result=$stmt->get_result();


//die(json_encode('message'=>"l $l r $r t $t b $b"));

$ret=$result->fetch_all(MYSQLI_NUM);
$ret=array_map(function($r){return json_decode($r[0]);},$ret);
$ret=['success'=>true, 'data'=>$ret];
die(json_encode($ret));

?>