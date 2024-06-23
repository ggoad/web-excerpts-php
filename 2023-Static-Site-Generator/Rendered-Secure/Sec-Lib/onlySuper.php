<?php 
	require_once(__DIR__."/onlyLoggedIn.php");
	$good=false;
	if(isset($_SESSION['_redacted_'])){
		if($_SESSION['_redacted_'] === 'super'){
			$good=true;
		}
	}
	if(!$good){
		header("location: https://greggoad.net/_redacted_");
		die();
	}
?>