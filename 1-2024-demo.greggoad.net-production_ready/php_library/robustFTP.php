<?php 
set_time_limit(0);

$robustFTPConn=false;
$fileCount=0;

if(!is_dir(__DIR__.'/robustFTP')){
	mkdir(__DIR__.'/robustFTP');
	mkdir(__DIR__.'/robustFTP/tempFiles');
	file_put_contents(__DIR__."/hashSaves.json", "{}");
	
}

$hashSaves=json_decode(file_get_contents(__DIR__.'/hashSaves.json'),true);


function RobustFTPGetConnection(){
	
}
function RobustRunFolder($newDir=false){
	global $fileCount;
	global $hashSaves;
	global $directoryStack;
	global $remoteDirectoryStack;
	global $ftpConn;

	if($newDir){
		array_push($directoryStack,$newDir);
		array_push($remoteDirectoryStack,$newDir);
	}

	$dirString=implode('/',$directoryStack);
	$remoteDirString=implode('/', $remoteDirectoryStack);

	if(ftp_nlist($ftpConn, $remoteDirString) === false){
		if(!ftp_mkdir($ftpConn, $remoteDirString)){
			dieSlow("failed to make new directory: $remoteDirString");
		};
	}


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
			$fileCount++;
		}
	}

	if($newDir){
		array_pop($directoryStack);
		array_pop($remoteDirectoryStack);
	}
}
?>