<?php
require_once(__DIR__."/validation.php");
if(is_file(__DIR__."/user.php")){
  require_once(__DIR__."/user.php");
}else if(is_file(__DIR__."/../user.php")){
  require_once(__DIR__."/../user.php");
}
require_once(__DIR__."/../lib.php");
if(is_file(__DIR__."/lib.php")){
	require_once(__DIR__."/lib.php");
}

$validActions=json_decode(file_get_contents(__DIR__."/actions.json"),true);

PostVarSet('dat',$dat);
$encodedQuotedDat=sQuote($dat);
$encodedDat=$dat;
$dat=json_decode($dat, true);


if(!isset($_GET['action'])){
   die("invalid action");
}
$action=$_GET['action'];

if(!in_array($action, $validActions)){
   die("invalid action");
}

RMF_TBL_WAArenderAdmin_members_FILTERVALIDATE($dat);

include(__DIR__."/$action.php");

dbSoftExit();
?>