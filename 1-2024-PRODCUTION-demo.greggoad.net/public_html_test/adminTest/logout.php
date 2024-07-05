<?php 
session_start();
unset($_SESSION['ggtestadmin']);
unset($_SESSION['ggtestadmin_role']);
unset($_SESSION['ggtestadmin_pk']);
unset($_SESSION['ggtestadmin_name']);

header("location: .");
die();
?>