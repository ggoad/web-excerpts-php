<?php
	require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/ajaxOnlyLoggedIn.php");
	
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/ensureDirectory.php");
	
function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    $max = strlen($characters) - 1;

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $max)];
    }

    return $randomString;
}

	$str=generateRandomString();
	while(is_dir("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/temporaryUpload/$str"))
	{
		$str=generateRandomString();
	}
	EnsureDirectory("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/blogs/news/temporaryUpload/$str");
	
	die(json_encode([
		'success'=>true,
		'uploadToken'=>$str
	]));
?>