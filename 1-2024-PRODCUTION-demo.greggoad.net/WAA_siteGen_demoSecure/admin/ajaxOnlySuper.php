<?php 
	require_once(__DIR__."/ajaxOnlyLoggedIn.php");
	$good=false;
	if(isset($_SESSION['ggtestadmin_role'])){ 
		if($_SESSION['ggtestadmin_role'] === 'super'){
			$good=true;
		}
	}
	if(!$good){
		header("HTTP/1.1 401 Unauthorized");
		die();
	}
?>