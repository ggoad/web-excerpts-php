<?php




function RMF_integer_VALIDATE($dat){
if(is_null($dat)){return $dat;}
$dat=''.$dat;
if(preg_match('#[^0-9\-]#',$dat)){
   return false;
}
$sc=substr_count($dat,'-');
if($sc > 1 || $sc === 1 && $dat[0] !== '-'){
   return false;
}

$dat=intval($dat);

if($dat > 2147483647){return false;}

return true;
}



function RMF_integer_FILTER(&$dat){
if(is_null($dat)){
   return;
}
$dat=intval($dat);
}

function RMF_integer_FILTERVALIDATE(&$dat){

	RMF_integer_FILTER($dat);
	return RMF_integer_VALIDATE($dat);
	
}

###resolveFunct###
?>