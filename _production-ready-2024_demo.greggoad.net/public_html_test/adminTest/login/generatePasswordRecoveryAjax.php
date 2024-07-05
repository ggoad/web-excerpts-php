<?php 


require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/ajaxOnlyLoggedOut.php");

require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sendMail.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");

PostVarSet('email', $email, true);

$email=trim($email);
if(!$email){
   die("No email provided");
}

$sqlite=SQLite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/db.db");

$sqlite->query("DELETE FROM passwordRecoveryRequests WHERE (JULIANDAY(CURRENT_TIMESTAMP)- JULIANDAY(timeAdded))*24*60 > 15");

$stmt = $sqlite->prepare('SELECT * FROM  members WHERE email = :email');

// Bind the parameter
$stmt->bindValue(':email', $email, SQLITE3_TEXT);

// Execute the statement
$result = $stmt->execute();

// Fetch the results
if (!$row = $result->fetchArray(SQLITE3_ASSOC)) {
    // Process each row
    die("SUCCESS");
}
$stmt=$sqlite->prepare("DELETE FROM passwordRecoveryRequests WHERE member=:member");
$stmt->bindValue(':member', $row['pk'], SQLITE3_TEXT);
$stmt->execute();

$_GET['action']="psAdd";
$token=bin2hex(random_bytes(20));
$_POST['dat']=json_encode([
	'member'=>['pk'=>$row['pk']],
	'token'=>$token
]);



$confLink="https://demo.greggoad.net/adminTest/login/resetPassword.php?t=$token";
$cancelLink="https://demo.greggoad.net/adminTest/login/resetPasswordCancel.php?t=$token";
$eBody='<h1>Demo Greg Goad Dot Net Admin Password Reset Request</h1>
<h2>Please visit this link to complete the reset:</h2>
<a href="'.$confLink.'"><p>Reset Here</p></a>
<br><br>
<h2>Didn\'t request this? Visit this link to cancel:</h2>
<a href="'.$cancelLink.'"><p>Cancel Here</p></a>
<br><br>
<h3>This request will be available for 15 minutes.</h3>
<h4>The link for the password reset is only valid once.</h4>';
$eAltBody='Demo Greg Goad Dot Net Admin Password Reset Request

Please visit this link to complete the reset:

'.$confLink.'


Didn\'t request this? Copy this link to cancel:

'.$cancelLink.'

This request will be available for 15 minutes.

The link for the password reset is only valid once.';

$eBodys=[
	'body'=>$eBody,
	'altBody'=>$eAltBody
];

if(($res=BasicSendMailComplete('greggoad.net', ['fromEmail'=>'PassRecovery@greggoad.net','user'=>'pr@greggoad.net'], 'Password Recovery', 'NotReal', $email, "Password Recovery Request", $eBodys,[],[],[
	'port'=>587,
	'isSMTP'=>true,
	'SMTPAuth'=>true,
	'SMTPSecure'=>'tls'
])) !== "SUCCESS"){
	die("SUCCESS");
}



require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/RMF/TBL_WAArenderAdmin_passwordRecoveryRequests/action.php");

$sqlite->close();
?>