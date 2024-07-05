<?php 
if(!isset($UNIREP_computeFunctions)){
	$UNIREP_computeFunctions=[];
}
function UnirepCheckMatches($str, $pat){
	foreach($pat as $k=>$v)
	{
		if(strpos($str, $k) !== false){
			return true;
		}
	}
	return false;
}

define('UNIREP_levels',[
['open'=>'`--','close'=>'--`'],
['open'=>'`~~','close'=>'~~`'],
['open'=>'#~~','close'=>'~~#']
]);
$UNIREP_liveOrLocal='live';
$UNIREP_levelIndex=0;
function UnirepTagLevelUp($str){
	$temp=UNIREP_levels;
	
	$moveto=array_shift($temp);
	while($mover=array_shift($temp))
	{
		$str=str_replace([$mover['open'],$mover['close']],[$moveto['open'],$moveto['close']],$str);
		$moveto=$mover;
	}
	return $str;
	
}
function Unirep($str, ...$pat){
	global $UNIREP_computeFunctions;
	$globPat=[];
	foreach($UNIREP_computeFunctions as $key=>$v)
	{
		$globPat[$key]='';
	}
	foreach($pat as $p)
	{
		foreach($p as $k=>$v)
		{
			$globPat[$k]=$v;
		}
	}
	
	$maxExecute=25;
	$executions=0;
	
	while(UnirepCheckMatches($str, $globPat) && $executions < $maxExecute)
	{
		
		foreach($globPat as $k=>$v)
		{
			$subExecutions=0;
			while(strpos($str, $k) !== false && $subExecutions < 100)
			{
				$subExecutions++;
				
				$subV=$v;
				if(isset($UNIREP_computeFunctions[$k])){
					$matches=[];
					preg_match("#$k(.*--`)#",$str, $matches);
					//echo(json_encode($matches));
					$matches[0]= $matches[0] ?? '`--';
					$m=explode("`--",$matches[0]);
					//if(!isset($m[1])){continue;}
					$m=$m[1] ?? '';
					$m=explode("--`", $m);
					array_pop($m);
					array_shift($m);
					$subV=$UNIREP_computeFunctions[$k](...$m);
					if($m){
						$k.=join('--`',$m).'--`';
					}
				}
				$count=1;
				$str=str_replace($k, $subV, $str, $count);
			}
			
		}
		//$str=str_replace(array_keys($globPat), array_values($globPat), $str);
		
		$executions++;
	}
	return $str;
	
}
?>