<?php 
function DeleteDirectory($dir){
	if(substr($dir, -1) == "/"){
		$dir = substr($dir, 0, strlen($dir)-1);
	}
	if(!file_exists($dir)){
		return true;
	}
	
	if(!is_dir($dir)){
		return unlink($dir);
	}
	foreach(scandir($dir) as $item)
	{
		if($item == "." || $item == ".."){
			continue;
		}
		if(!DeleteDirectory($dir.DIRECTORY_SEPARATOR.$item)){
			return false;
		}
	}
	return rmdir($dir);
}
?>