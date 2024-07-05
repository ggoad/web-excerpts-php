<?php 
	session_start();
	if(!isset($_SESSION['ggtestadmin'])){
		header("HTTP/1.1 401 Unauthorized");
		die();
	}
?>