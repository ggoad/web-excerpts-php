<?php




function RMF_date_time_VALIDATE($dat){
return true;
}



function RMF_date_time_FILTER(&$dat){

}

function RMF_date_time_FILTERVALIDATE(&$dat){

	RMF_date_time_FILTER($dat);
	return RMF_date_time_VALIDATE($dat);
	
}

###resolveFunct###
?>