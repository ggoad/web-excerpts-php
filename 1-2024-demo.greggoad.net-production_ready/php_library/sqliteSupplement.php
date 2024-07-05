<?php 
function SQLite3_Concurrent($file, $flags=SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE,$busyMilli=5000, $journalMode='wal2', $extendedConfig=[]){
	$ret=new SQLite3($file, $flags);
	$ret->busyTimeout($busyMilli);
	$ret->exec("PRAGMA journal_mode = $journalMode;");
	return $ret;
}
?>