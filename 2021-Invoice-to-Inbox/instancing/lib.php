<?php 
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/ensureDirectory.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postStream.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/deleteDirectory.php");


require_once("$_SERVER[DOCUMENT_ROOT]/updateViaFTP/v2/RMF/_redacted__job/lib.php");
require_once("$_SERVER[DOCUMENT_ROOT]/updateViaFTP/v2/RMF/_redacted__job/validation.php");
require_once("$_SERVER[DOCUMENT_ROOT]/updateViaFTP/v2/RMF/lib.php");


set_time_limit(0);

function SecureRelSafe($priv, $pub){
	$sames=0;
	for($i=0,$privl=strlen($priv),$publ=strlen($pub); $i < $privl && $i<$publ; $i++) 
	{
		if ($priv[$i] === $pub[$i]) {
			$sames++;
		}
	}
	return substr($priv, $sames);
	
}


$fileCount=0;
$directoryStack=[];
$remoteDirectoryStack=[];
$consecutiveFiles=0;
$ftpConn=false;
function dieSlow($msg){
	global $ftpConn;
	if($ftpConn){
		@ftp_close($ftpConn);
	}
	
	die($msg);
}
function GetFtpConnection(){
	global $info;
	global $ftpConn;
	if(!$ftpConn){
		if(!($ftpConn=ftp_ssl_connect($info['ftpServer']))){
			//if(!($ftpob=ftp_connect('webappsactualized.com'))){
			dieSlow("failed to connect to the ftpServer");
		}
		   
		if(!(@ftp_login($ftpConn, $info['ftpUser'], $info['ftpPass']))){
			dieSlow("failed on login to the ftp server");
		}
		ftp_set_option($ftpConn, FTP_USEPASVADDRESS, false);
		ftp_pasv($ftpConn, true);

	}
	return $ftpConn;
}
function Transfer($dirString, $remoteDirString, $s){
	global $info;
	//die(SecureRelSafe($info['privTarget'], $info['pubTarget']));
	$cnt=file_get_contents("$dirString/$s");
	$cnt=str_replace(
		["_redacted_",'_redacted_','//####LiveMailFunctionCallHere'],
		[SecureRelSafe($info['privTarget'], $info['pubTarget']), $info['loginSessionVarName'], '
			require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sendMail.php");
			$emailInfo=json_decode(file_get_contents(__DIR__."/emailPass.json"),true);
			BasicSendMail($emailInfo[\'host\'], $emailInfo[\'user\'], $emailInfo[\'fromName\'], $emailInfo[\'pass\'], $customer[\'email\'],
			$subject, $body, $mailAttachments, [$emailInfo[\'cc\']]);
		'],
		$cnt
	);
	
	file_put_contents("$remoteDirString/$s",$cnt);
	
}
function RunFolder($newDir=false){
	  global $fileCount;
      global $hashSaves;
      global $directoryStack;
      global $remoteDirectoryStack;

      if($newDir){
         array_push($directoryStack,$newDir);
         array_push($remoteDirectoryStack,$newDir);
      }

      $dirString=implode('/',$directoryStack);
      $remoteDirString=implode('/', $remoteDirectoryStack);
      
	  @mkdir($remoteDirString);
	  

      
      $sd=scanDir($dirString);
      
      
      
      foreach($sd as $s)
      {
          if(in_array($s, ["..",".", 'ProjectExportChecksums.json'], true)){
             continue;
          }
          if(is_dir("$dirString/$s")){
              RunFolder($s);
          }else if(is_file("$dirString/$s")){
             //$hash=hash_file("crc32c","$dirString/$s");
             //if(isset($hashSaves["$dirString/$s"])){
             //   if($hashSaves["$dirString/$s"] === $hash){
             //      continue;
             //   }
             //}
			 Transfer($dirString, $remoteDirString, $s);

             //$hashSaves["$dirString/$s"]=$hash;
          }
      }

      if($newDir){
         array_pop($directoryStack);
         array_pop($remoteDirectoryStack);
      }
   }

PostVarSet('pk',$pk);
$pk=intval($pk);
$globSqlite=new SQLite3('db.db');

$result=$globSqlite->query("
	SELECT * FROM jobs WHERE pk=$pk;
");
if($result){
	if(!($row=$result->fetchArray(SQLITE3_ASSOC))){
		die("no results");
	}
	$info=$row;
}else{
	die("unable to find result");
}


function renderFiles(){
	global $info;
	global $pk;
	global $globSqlite;
	global $directoryStack;
	global $remoteDirectoryStack;
	
	DeleteDirectory("../CLIENTS/$info[companyName]");
	EnsureDirectory("../CLIENTS/$info[companyName]/server/$info[privTarget]");
	EnsureDirectory("../CLIENTS/$info[companyName]/server/$info[pubTarget]");
	EnsureDirectory("../CLIENTS/$info[companyName]/configs");
	
	
	$directoryStack=["../MASTER_EXPORT/login"];
	$remoteDirectoryStack=["../CLIENTS/$info[companyName]/server/$info[pubTarget]/login"];
	
	RunFolder();

	$directoryStack=["../MASTER_EXPORT/v1"];
	$remoteDirectoryStack=["../CLIENTS/$info[companyName]/server/$info[pubTarget]/v1"];
	
	RunFolder();
	
	file_put_contents("../CLIENTS/$info[companyName]/server/$info[pubTarget]/index.php", "<?php header('Location: login');  ?>");
	
	$directoryStack=["../MASTER_EXPORT/_redacted_"];
	$remoteDirectoryStack=["../CLIENTS/$info[companyName]/server/$info[privTarget]"];
	
	RunFolder();
	
	file_put_contents("../CLIENTS/$info[companyName]/configs/pass.json", json_encode([
		'user'=>hash('_redacted_',$info['loginSalt'].$info['loginUser']),
		'pass'=>hash('_redacted_', $info['loginPass'].$info['loginSalt'])
	]));
	file_put_contents("../CLIENTS/$info[companyName]/configs/salt.txt",$info['loginSalt']);
	file_put_contents("../CLIENTS/$info[companyName]/configs/emailPass.json",json_encode([
		'user'=>$info['emailUser'],
		'pass'=>$info['emailPass'],
		'host'=>$info['emailHost'],
		'cc'=>$info['emailCC'],
		'fromName'=>$info['emailFromName']
	]));
	//$info['basicConfig']
	//$info['basicConfig']['shopAddress']=json_decode($info['basicConfig']['shopAddress']);
	file_put_contents("../CLIENTS/$info[companyName]/configs/config.json",$info['basicConfig']);
	@unlink("emilioTool/CLIENTS/$info[companyName]/configs/db.db");
	$result=postStream("http://localhost/_DATABASE_MANAGER_/v3/sqliteScripts/writeSqlite.php",[
		'dat'=>[
			'db'=>'emilioTool',
			'file'=>"emilioTool/CLIENTS/$info[companyName]/configs/db.db"
		]
	]);
	
	if($result !== "SUCCESS"){
		die("error writing db");
	}
	
	/*$result=postStream("http://localhost/_DATABASE_MANAGER_/v3/sqliteScripts/writeSqlite.php",[
		'dat'=>[
			'db'=>'emilioTool',
			'file'=>"emilioTool/CLIENTS/$info[companyName]/configs/db.db",
			'justText'=>true
		]
	]);
	file_put_contents("../CLIENTS/$info[companyName]/configs/dbStructureCommands.json", $result);
	Transfer(".","../CLIENTS/$info[companyName]/configs","adminRenderDb.php");*/
	
	$found=true;
	$othSqlite=new SQLite3("$_SERVER[DOCUMENT_ROOT]/updateViaFTP/v2/db.db");
	if($info['ftpId']){
		$res=$othSqlite->querySingle("SELECT COUNT(*) FROM job WHERE pk=$info[ftpId];");
		if(intval($res) === 0){
			$found=false;
		}
	}
	if(!$info['ftpId'] || !$found){
		psAddupdateViaFTP_job([
			'server'=>$info['ftpServer'],
			'pass'=>$info['ftpPass'],
			'user'=>$info['ftpUser'],
			'sourceFile'=>"emilioTool/CLIENTS/$info[companyName]/server",
			'targetFile'=>'/'
		]);
		$ftpPk=$othSqlite->querySingle('SELECT pk FROM job ORDER BY pk DESC;');
		$globSqlite->query("
			UPDATE jobs SET ftpId=$ftpPk WHERE pk=$pk;
		");
	}
	
		$othSqlite->close();
}

function runFTP(){
	global $info;
	ini_set("default_socket_timeout",-1);
	
	$result=postStream("http://localhost/updateViaFTP/v2/runJob.php",['pk'=>$info['ftpId']]);
	if(!preg_match('#^SUCCESS#',$result)){
		
		dieSlow("FTP problem: $result");
	}
}
function writePasswords(){
	global $info;
	$ftpConn=GetFtpConnection();
	
	
	if(!ftp_put($ftpConn, "$info[privTarget]/pass.json","../CLIENTS/$info[companyName]/configs/pass.json" , FTP_ASCII)){
	  
		dieSlow("failed to make new file: $info[privTarget]/pass.json");
	}
	
}

function writeSalt(){
	global $info;
	$ftpConn=GetFtpConnection();
	
	
	if(!ftp_put($ftpConn, "$info[privTarget]/salt.txt", "../CLIENTS/$info[companyName]/configs/salt.txt", FTP_ASCII)){
		dieSlow("failed to make new file: $info[privTarget]/salt.txt");
	}
}
function writeEmailPasswords(){
	
	global $info;
	$ftpConn=GetFtpConnection();
	
	
	if(!ftp_put($ftpConn, "$info[privTarget]/emailPass.json", "../CLIENTS/$info[companyName]/configs/emailPass.json", FTP_ASCII)){
		dieSlow("failed to make new file: $info[privTarget]/emailPass.json");
	}
}
function writeConfig(){
	global $info;
	$ftpConn=GetFtpConnection();

	
	if(!ftp_put($ftpConn, "$info[privTarget]/config.json", "../CLIENTS/$info[companyName]/configs/config.json", FTP_ASCII)){
		dieSlow("failed to make new file: $info[privTarget]/config.json");
	}
	
}
function writeEmptyDatabase(){
	global $info;
	$ftpConn=GetFtpConnection();
	
	$currentContents=ftp_nlist($ftpConn, "$info[privTarget]");
	if(in_array("db.db", $currentContents)){
		$tempInd=0;
		$tempPad="0000";
		while(in_array("db.db$tempPad.bak", $currentContents))
		{
			$tempInd++;
			$tempPad=str_pad($tempInd,4,"0",STR_PAD_LEFT);
		}
		if(!ftp_rename($ftpConn, "$info[privTarget]/db.db", "$info[privTarget]/db.db$tempPad.bak")){
			dieSlow("the db rename has failed");
		}
	}
	
	if(!ftp_put($ftpConn, "$info[privTarget]/db.db", "../CLIENTS/$info[companyName]/configs/db.db", FTP_BINARY)){
		dieSlow("could not write sqlite database");
	}
	/*if(!ftp_put($ftpConn, "$info[pubTarget]/dbStructureCommands.json", "../CLIENTS/$info[companyName]/configs/dbStructureCommands.json", FTP_ASCII)){
		dieSlow("could not write sqlite db structure commands");
	}
	if(!ftp_put($ftpConn, "$info[pubTarget]/adminRenderDb.php", "../CLIENTS/$info[companyName]/configs/adminRenderDb.php", FTP_ASCII)){
		dieSlow("could not write sqlite renderer script");
	}*/
	
	//$result=postStream("$info[publicWebAddress]/runJob.php",[]);
	//if(!preg_match('#^SUCCESS#',$result)){
		
//		dieSlow("FTP problem: $result");
	//}
	
}
function runAll(){
	renderFiles();
	runFTP();
	writePasswords();
	writeSalt();
	writeEmailPasswords();
	writeConfig();
	writeEmptyDatabase();
}

?>