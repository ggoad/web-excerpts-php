<?php 

	define('POSTVARSET_OBREPLY', true);
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");

	require_once('projectLibrary.php');


	PostVarSet('title', $title);
	
	$projectInfo=GetProjectInfo($title);
	$dat=$projectInfo['data'];


	$localDirectory=CalcLocalDirectory($projectInfo['slug']);
		$localPubDirectory="$localDirectory";
	$liveDirectory=CalcLiveDirectory($projectInfo['slug']);
		$livePubDirectory="$liveDirectory/".$dat['top']['main']['livePubFolder'];


	function UnBrotliDirectory($d){
		$sd=scandir($d);
		
		foreach($sd as $s)
		{
			if(is_dir("$d/$s") && array_search($s,['.','..'])=== false){
				UnBrotliDirectory("$d/$s");
		}else if(is_file("$d/$s") && preg_match('#\.(br|min)$#', $s)){
				unlink("$d/$s");
			}
		}
	}
	UnBrotliDirectory($localPubDirectory);
	UnBrotliDirectory($livePubDirectory);
	
	die(json_encode(['success'=>true]));

?>