<?php 
require_once(__DIR__.'/deleteDirectory.php');

function EmptyDirectory($dir){
	$sd=scandir($dir);
	
	foreach($sd as $s)
	{
		if(array_search($s,['.','..']) !== false){
			continue;
		}
		if(is_file("$dir/$s")){
			unlink("$dir/$s");
		}else if(is_dir("$dir/$s")){
			DeleteDirectory("$dir/$s");
		}
	}
	
}
?>