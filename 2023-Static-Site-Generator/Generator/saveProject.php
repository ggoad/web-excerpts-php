<?php 
define('POSTVARSET_OBREPLY', true);
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");

require_once('projectLibrary.php');

PostVarSet('title', $title);
PostVarSet('dat',$dat);
$dat=json_decode($dat, true);

//die(json_encode(['success'=>false, 'msg'=>'test see console', 'data'=>$dat]));

$savedDat=SaveProject($title, $dat);

die(json_encode(['success'=>true, 'data'=>$savedDat]));
?>