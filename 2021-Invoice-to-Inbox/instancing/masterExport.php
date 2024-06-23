<?php
set_time_limit(0);
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/deleteDirectory.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postStream.php");

function copyDirectory($src, $dest){
	$sd=scandir($src);
	
	@mkdir($dest);
	$blackList=['.','..'];
	foreach($sd as $s)
	{
		if(array_search($s, $blackList) !== false){continue;}
		
		if(is_file("$src/$s")){
			copy("$src/$s", "$dest/$s");
		}else if(is_dir("$src/$s")){
			copyDirectory("$src/$s","$dest/$s");
		}
	}
	
	
}

function specialCopy($src, $dest, $blackList, $dodir=true){
	$sd=scandir($src);
	
	@mkdir($dest);
	foreach($sd as $s)
	{
		if(array_search($s, $blackList) !== false){continue;}
		if(preg_match('#db[0-9]{4}.bak#',$s)){
			continue;
		}
		if(is_file("$src/$s")){
			copy("$src/$s", "$dest/$s");
		}else if(is_dir("$src/$s") && $dodir){
			copyDirectory("$src/$s", "$dest/$s");
		}
	}
}

/// globals 
	$secPrep="$_SERVER[DOCUMENT_ROOT]/../emilioSecure";
	$toolPrep="v1";
	$loginPrep="login";
	
$secTarget="MASTER_EXPORT/emilioSecure";
$toolTarget="MASTER_EXPORT/v1";
$loginTarget="MASTER_EXPORT/login";
	
	
@mkdir("MASTER_EXPORT");



specialCopy($secPrep, $secTarget,
 ['..','.', "EXPORT", "invoices", 'mailings','receipts', 'db.db', "RMFprogram.json",'pass.json','emailPass.json','config.json','salt.txt']);

@mkdir("$secTarget/invoices");
@mkdir("$secTarget/mailings");
@mkdir("$secTarget/receipts");




@mkdir($toolTarget);
@mkdir("$toolTarget/img");

copy("v1/img/amFlag.png", "$toolTarget/img/amFlag.png");
copy("v1/img/mexFlag.png", "$toolTarget/img/mexFlag.png");
copy('v1/favicon.ico', "$toolTarget/favicon.ico");
copy('v1/favicon.ico', "$loginTarget/favicon.ico");

$sd=scandir($toolPrep);
$blacklist=[
	'index.php','config.php','unsecuredIndex.php','viewTimesheets.php','truncatetimesheets.php'
];
foreach($sd as $s)
{
	if(preg_match('#\.php$#', $s) && array_search($s,$blacklist) === false){
		copy("$toolPrep/$s", "$toolTarget/$s");
	}
}


$ind=postStream("http://localhost/emilioTool/v1/unsecuredIndex.php",[]);

file_put_contents("$secTarget/toolTemplate.html",$ind);

file_put_contents("$toolTarget/index.php","<?php
        require_once(\$_SERVER['DOCUMENT_ROOT'].'/../emilioSecure/onlyLoggedIn.php');
        require_once(\$_SERVER['DOCUMENT_ROOT'].'/../emilioSecure/basicState.php');
		
echo RepBasicData(file_get_contents(\$_SERVER['DOCUMENT_ROOT'].'/../emilioSecure/toolTemplate.html'));
?>");

@mkdir($loginTarget);
$sd=scandir($loginPrep);
foreach($sd as $s)
{
	if(preg_match('#\.php$#', $s) && array_search($s,$blacklist) === false){
		copy("$loginPrep/$s", "$loginTarget/$s");
	}
}
$ind=postStream("http://localhost/emilioTool/login/",[]);
$ind=preg_replace("#var languageSetting='[a-z]{2}'#","var languageSetting='---languageSetting---'", $ind);
file_put_contents("$secTarget/loginTemplate.html", $ind);

file_put_contents("$loginTarget/index.php","<?php
  session_start();
   if(isset(\$_SESSION['emilioToolLoggedIn'])){
      if(\$_SESSION['emilioToolLoggedIn']){
         header('Location: ../v1');
      }
   }
   
   define('lockoutFile', \"\$_SERVER[DOCUMENT_ROOT]/../emilioSecure/lockoutState.txt\");
   if(!is_file(lockoutFile)){
      file_put_contents(lockoutFile, '');
   }
   \$lockoutState=file_get_contents(lockoutFile);
   \$sqlite=new SQLite3(\"\$_SERVER[DOCUMENT_ROOT]/../emilioSecure/db.db\");
   \$shortresult=intval(\$sqlite->querySingle(\"SELECT COUNT(*) FROM loginAttempts WHERE loginDateTime >= datetime('now','-1 Minute')\"));

   if(\$lockoutState === \"timeout\"){
      if(\$shortresult === 0){
         // echo \$shortresult;
         file_put_contents(lockoutFile, '');
      }else{
         die(\"The login has been temporarily timed out due to too many unsuccessful login attempts. Please wait a minute. If you can't remember your password please call customer support at 336-406-1319<br/><br/>
             El inicio de sesión se ha agotado temporalmente debido a demasiados intentos de inicio de sesión fallidos. Por favor, espere un minuto. Si no puede recordar su contraseña, llame a atención al cliente al 336-406-1319\");
      }
      
   }else if(\$lockoutState === \"permalock\"){
      die(\"The login has been permanently locked because of too many unsuccessful logins. It may have been a cyber attack. Please contact customer support at 336-406-1319.<br/><br/>
           El inicio de sesión se ha bloqueado permanentemente debido a demasiados inicios de sesión fallidos. Puede haber sido un ataque cibernético. Comuníquese con atención al cliente al 336-406-1319.\");
   }
		
echo str_replace('---languageSetting---',json_decode(file_get_contents(\"\$_SERVER[DOCUMENT_ROOT]/../emilioSecure/config.json\"),true)['interfaceLanguage'],file_get_contents(\$_SERVER['DOCUMENT_ROOT'].'/../emilioSecure/loginTemplate.html'));
?>");
?>