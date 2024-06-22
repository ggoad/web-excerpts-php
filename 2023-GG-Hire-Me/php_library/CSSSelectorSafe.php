<?php 
function CSSSelectorSafe($str){
	$cstr='()[]<>{}./\\,?$^#+=@ ';
	return str_replace(str_split($cstr),'-',$str);
}
?>