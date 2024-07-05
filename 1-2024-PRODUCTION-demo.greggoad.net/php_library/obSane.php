<?php 
function SetAndNotEmpty($str,$k){
	if(isset($str[$k])){
		if($str[$k] !== ''){
			return true;
		}
	}return false;
}

?>