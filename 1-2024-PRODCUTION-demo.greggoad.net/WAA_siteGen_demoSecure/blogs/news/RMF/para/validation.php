<?php




function RMF_para_VALIDATE($dat){
return true;
}



function RMF_para_FILTER(&$dat){

}

function RMF_para_FILTERVALIDATE(&$dat){

	RMF_para_FILTER($dat);
	return RMF_para_VALIDATE($dat);
	
}

###resolveFunct###
?>