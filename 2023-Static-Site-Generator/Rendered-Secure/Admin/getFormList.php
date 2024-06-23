<?php 
require_once("$_SERVER[DOCUMENT_ROOT]/../-redacted-/admin/onlyLoggedIn.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");

$sqlite=SQLite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../-redacted-/admin/contactForms/db.db");

$result=$sqlite->query("SELECT * FROM forms;");

$data = array();
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $data[] = $row;
}

// Close the database connection
$sqlite->close();

// Set the response header to JSON
header('Content-Type: application/json');

// Output the JSON data
die(json_encode(['success'=>true, 'data'=>$data]));
?>