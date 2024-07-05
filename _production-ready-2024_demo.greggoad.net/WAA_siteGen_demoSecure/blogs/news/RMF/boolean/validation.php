<?php




function RMF_boolean_VALIDATE($dat){
if($dat === true || $dat === false || is_null($dat)){
 return true;
}return false;
}



function RMF_boolean_FILTER(&$dat){
if(is_null($dat)){return;}
$dat=''.$dat;
$dat=boolval($dat);
}

function RMF_boolean_FILTERVALIDATE(&$dat){

	RMF_boolean_FILTER($dat);
	return RMF_boolean_VALIDATE($dat);
	
}

###resolveFunct###
?>