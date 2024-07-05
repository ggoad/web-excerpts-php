<?php




function RMF_basicPk_VALIDATE($dat){
if(is_null($dat)){return true;}

$dat=intval($dat);

if($dat <= 0 || $dat === PHP_INT_MAX){
   return false;
}

return true;
}



function RMF_basicPk_FILTER(&$dat){
if(is_null($dat)){return;}
$dat=intval($dat);
if($dat === 0){$dat = '';}
}

function RMF_basicPk_FILTERVALIDATE(&$dat){

	RMF_basicPk_FILTER($dat);
	return RMF_basicPk_VALIDATE($dat);
	
}

###resolveFunct###
?>