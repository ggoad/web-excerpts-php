<?php
if(!function_exists("OBSANE")){
function OBSANE($ob, $name){
		if(isset($ob[$name])){
			//die(json_encode($ob));
			if($ob[$name] !== ''){
				return true;
			}
		}return false;
	}
}
function queryORexit($q, $m){
    global $sqlConn;
    if($result=mysqli_query($sqlConn, $q)){
       return $result;
    }dbSoftExit($m." :-> ".mysqli_error($sqlConn)." query:-> ".$q);
}
function dbSoftExit($str=""){
   global $sqlConn;
   if($sqlConn){
	mysqli_close($sqlConn);
   }
   exit($str);
}
function SWITCHdb($db){
   if($result=mysqli_query($sqlConn, "SELECT DATABASE();")){
      $ret=mysqli_fetch_row($result)[0];
    }
    mysqli_select_db($db);
    return $ret;
}

?>