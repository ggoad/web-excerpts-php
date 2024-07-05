<?php 
	require_once(__DIR__."/onlyLoggedIn.php");
	$good=false;
	if(isset($_SESSION['ggtestadmin_role'])){
		if($_SESSION['ggtestadmin_role'] === 'super'){
			$good=true;
		}
	}
	if(!$good){
		header("location: https://demo.greggoad.net/adminTest/app");
		die();
	}
?>