<?php
function StringMixit(...$strs){
	$ret="";
	
	$ss=array_map(function($s){return str_split($s);},$strs);
	
	while(array_reduce($ss, function($carr, $sa){return $carr+count($sa);},0))
	{
		foreach($ss as &$s)
		{
			$temp=array_shift($s);
			if($temp){
				$ret.=$temp;
			}
		}
		unset($s);
	}
	return $ret;
}
?>