<?php
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");

function SortIfNeeded(&$info){
	if(array_search($info['name'],["Projects"]) !== false){
		usort($info['list'], function($a,$b){
			$acmp=$a['end'] ? $a['end'] : $a['start'];
			$bcmp=$b['end'] ? $b['end'] : $b['start'];
			if($acmp === $bcmp){return 0;}
			return ($acmp > $bcmp) ? -1 : 1;
			
		});
	}
}

PostVarSet('dat',$dat);

$dat=json_decode($dat, true);

foreach($dat['otherFams'] as &$of)
{
	SortIfNeeded($of);
}

$dat=json_encode($dat);

file_put_contents("saved.json", $dat);

die("SUCCESS");

?>