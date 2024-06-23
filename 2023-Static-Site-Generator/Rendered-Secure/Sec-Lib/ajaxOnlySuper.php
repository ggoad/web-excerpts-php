<?php 
	require_once(__DIR__."/ajaxOnlyLoggedIn.php");
	$good=false;
	if(isset($_SESSION['_redacted_'])){ 
		if($_SESSION['_redacted_'] === 'super'){
			$good=true;
		}
	}
	if(!$good){
		header("HTTP/1.1 401 Unauthorized");
		die();
	}
?>