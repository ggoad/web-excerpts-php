<?php 
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/ensureDirectory.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/deleteDirectory.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postStream.php");

require_once("$_SERVER[DOCUMENT_ROOT]/../-redacted-/admin/enc/contactForms/Contact/lib.php");

require_once("$_SERVER[DOCUMENT_ROOT]/../-redacted-/admin/contactForms/RMF/lib.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../-redacted-/admin/contactForms/RMF/TBL__redacted__submissions/validation.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../-redacted-/admin/contactForms/RMF/TBL__redacted__submissions/lib.php");


//$safeExtensions=['jpg', 'jpeg', 'png', 'gif','bmp','txt','tiff','svg','avif','raw', 'mp4', 'mp3','wav'];

PostVarSet('recaptchaToken',$recaptchaToken);

$ip=$_SERVER['REMOTE_ADDR'];

$resp=postStream("https://www.google.com/recaptcha/api/siteverify",[
	'secret'=>'-redacted-',
	'response'=>$recaptchaToken,
	'remoteip'=>$ip
]);

$respJson=json_decode($resp, true);
if(!$respJson){
	die("Failed");
}
if(!$respJson['success']){
	die("Failed");
}


PostVarSet('email', $email);
PostVarSet('question', $question);



$sqlite=SQLite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../-redacted-/admin/contactForms/db.db");
$yearAdded=date('Y');
$monthAdded=date('m');

$tempInd=0;
$tempDirPrep="$_SERVER[DOCUMENT_ROOT]/../-redacted-/admin/contactForms/Contact";
EnsureDirectory($tempDirPrep);
$tempDir="$tempDirPrep/temp{$tempInd}";
while(is_dir($tempDir))
{
	$tempInd++;
	$tempDir="$tempDirPrep/temp{$tempInd}";
}
//echo $tempDir;
EnsureDirectory($tempDir);
$fileIndex=0;


$dat=[
	'form'=>'Contact',
	'dat'=>ContactForm_Contact_encrypt(json_encode(array_merge(['email'=>$email,'question'=>$question],[
		'spamScore'=>$respJson['score'] ?? ''
	]))),
	'yearSubmitted'=>$yearAdded,
	'monthSubmitted'=>$monthAdded,
	'ipAddress'=>$ip,
	'categoryState'=>'new'
];

if(($res = psAdd_redacted__submissions($dat)) !== "SUCCESS"){
	$sqlite->close();
	die("Fail ");
}
$insertId=$sqlite->lastInsertRowID();

// this being isolated here is a side effect of the meta programming, 
//   and the option to have file-upload support (not included in this rendered application)
if($fileIndex > 0){
	rename($tempDir, $tempDirPrep."/$insertId");
}else{
	DeleteDirectory($tempDir);
}





die("SUCCESS");
?>