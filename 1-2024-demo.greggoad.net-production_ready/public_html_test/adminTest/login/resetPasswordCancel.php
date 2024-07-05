<?php 
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");
ObVarSet($_GET,'t',$token,true);

if($token){

	$sqlite=SQLite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/db.db");

	$stmt = $sqlite->prepare('SELECT member FROM passwordRecoveryRequests WHERE token = :token');

	// Bind the parameter
	$stmt->bindValue(':token', $token, SQLITE3_TEXT);

	// Execute the statement
	$result = $stmt->execute();

	// Fetch the results
	if($row = $result->fetchArray(SQLITE3_ASSOC)) {
		$stmt = $sqlite->prepare('DELETE FROM passwordRecoveryRequests WHERE member = :member');

		// Bind the parameter
		$stmt->bindValue(':member', $row['member'], SQLITE3_TEXT);

		// Execute the statement
		$result = $stmt->execute();
	}

	$sqlite->close();
}
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="robots" content="noindex|nofollow"/>
<title>Password Recovery Cancellation | Demo Greg Goad Dot Net</title>

<meta name="description" content="Demo Greg Goad Dot Net Password Reset Canceled"/>
<link rel="apple-touch-icon" sizes="180x180" href="/adminTest/appMedia/icons/regalG/180.png" />
<link rel="apple-touch-icon" sizes="152x152" href="/adminTest/appMedia/icons/regalG/152.png" />
<link rel="apple-touch-icon" sizes="120x120" href="/adminTest/appMedia/icons/regalG/120.png" />
<link rel="icon" sizes="16x16" href="/adminTest/appMedia/icons/regalG/16.png" />
<link rel="icon" sizes="32x32" href="/adminTest/appMedia/icons/regalG/32.png" />
<link rel="icon" sizes="57x57" href="/adminTest/appMedia/icons/regalG/57.png" />
<link rel="icon" sizes="76x76" href="/adminTest/appMedia/icons/regalG/76.png" />
<link rel="icon" sizes="96x96" href="/adminTest/appMedia/icons/regalG/96.png" />
<link rel="icon" sizes="120x120" href="/adminTest/appMedia/icons/regalG/120.png" />
<link rel="icon" sizes="128x128" href="/adminTest/appMedia/icons/regalG/128.png" />
<link rel="icon" sizes="144x144" href="/adminTest/appMedia/icons/regalG/144.png" />
<link rel="icon" sizes="152x152" href="/adminTest/appMedia/icons/regalG/152.png" />
<link rel="icon" sizes="167x167" href="/adminTest/appMedia/icons/regalG/167.png" />
<link rel="icon" sizes="180x180" href="/adminTest/appMedia/icons/regalG/180.png" />
<link rel="icon" sizes="192x192" href="/adminTest/appMedia/icons/regalG/192.png" />
<link rel="icon" sizes="195x195" href="/adminTest/appMedia/icons/regalG/195.png" />
<link rel="icon" sizes="196x196" href="/adminTest/appMedia/icons/regalG/196.png" />
<link rel="icon" sizes="228x228" href="/adminTest/appMedia/icons/regalG/228.png" />
<link rel="shortcut icon" sizes="196x196" href="/adminTest/appMedia/icons/regalG/196.png" />
<meta name="msapplication-TileImage" content="/adminTest/appMedia/icons/regalG/144.png" />
<meta property="og:image" content="/adminTest/appMedia/images/Mochobo/source.png" />
<meta property="og:image:alt" content="This is Crazy" />
</head>
<body>
  <h1>Demo Greg Goad Dot Net Password Recovery Cancellation</h1>
  <p>Your password recovery request has been cancelled.</p>
  <p>If you didn't initiate this request, please contact our support team.</p>
  
  <p><a href=".">Return to Home</a></p>
</body>
</html>
