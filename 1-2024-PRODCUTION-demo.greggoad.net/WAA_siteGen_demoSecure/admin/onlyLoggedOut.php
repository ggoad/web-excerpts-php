<?php 
	session_start();
	if(isset($_SESSION['ggtestadmin'])){
		header("location: https://demo.greggoad.net/adminTest/app");
		die();
	}
?>