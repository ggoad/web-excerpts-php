<?php 
function EnsureDirectory($dir){
    //echo $dir;

	$dir=explode('/',$dir);
	$carry=[];
	$str='';
	//echo json_encode($dir);
	while($dir)
	{
	    array_push($carry, array_shift($dir));
	   // echo $s."\n";
		//if($str && $str !== '/'){$str.="/";}
		$str=join('/',$carry);
		if(!is_dir($str)){
			@mkdir($str);
		}
	}
}
?>