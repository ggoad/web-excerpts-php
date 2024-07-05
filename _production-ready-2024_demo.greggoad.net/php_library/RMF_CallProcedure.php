<?php 
require_once(__DIR__.'/sQuote.php');
function RMF_CallProcedure($sqlConn,$procName, $dat){
	$dat=sQuote(json_encode($dat));
	$result=$sqlConn->query("CALL $procName($dat, @mylongnamedout);");
	if(!$result){
		die("Failed to call procedure-> ".mysqli_error($sqlConn));
	}
	$result=$sqlConn->query("SELECT @mylongnamedout;");
	if(!$result){
		die("Failed to call procedure-> ".mysqli_error($sqlConn));
	}
	$out=$result->fetch_row()[0];
	return $out;
}
?>