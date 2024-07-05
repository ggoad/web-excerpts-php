<?php 
function CopyDirectory($dir, $target){
	$dirs=scandir($dir);
	
	@mkdir($target);
	
	$skip=['.','..'];
	foreach($dirs as $d)
	{
		if(in_array($d, $skip)){continue;}
		if(is_dir("$dir/$d")){
			CopyDirectory("$dir/$d", "$target/$d");
		}else if(is_file("$dir/$d")){
			copy("$dir/$d", "$target/$d");
		}
	}
}
?>