<?php




function RMF_string_VALIDATE($dat){
if(!is_string($dat)){
 return false;
}else if(strlen($dat) > 254){
   return false;
}return true;
}



function RMF_string_FILTER(&$dat){
$dat=''.$dat;
$dat=substr($dat, 0, 253);
}

function RMF_string_FILTERVALIDATE(&$dat){

	RMF_string_FILTER($dat);
	return RMF_string_VALIDATE($dat);
	
}

###resolveFunct###
?>