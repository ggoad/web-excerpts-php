<?php 
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/stringMixit.php");

$ADMIN_RMF_string=[];
$ADMIN_CSS_string=[];
$ADMIN_appMeta='';

$ADMIN_notifications=[];

function CrossRender($src, $unipat, $localDest, $localPat, $liveDest, $livePat, $srcIsRaw=false){
	global $UNIREP_liveOrLocal;
	if(!$srcIsRaw){
		$src=file_get_contents($src);
	}
	$UNIREP_liveOrLocal='local';
	file_put_contents($localDest, Unirep($src,...$unipat, ...$localPat));
	
	$UNIREP_liveOrLocal="live";
	file_put_contents($liveDest, Unirep($src,...$unipat, ...$livePat));
}
function RenderAdmin( $dat, $projectInfo){
	global $ADMIN_appMeta;
	global $UNIREP_liveOrLocal;
	global $ADMIN_notifications;
	
	$adminDat=$dat['top']['admin'];
	$secSecureFolder="WAA_siteGen_".$dat['top']['main']['secureFolder'];
	
	$previewSecFolder="$_SERVER[DOCUMENT_ROOT]/../$secSecureFolder";
	
	$liveSecFolder="renders/$projectInfo[slug]/$secSecureFolder";
	
	$liveDataFolder="renders/$projectInfo[slug]/{$secSecureFolder}SPECIAL_data";
		EnsureDirectory($liveDataFolder);
		EmptyDirectory($liveDataFolder);
		EnsureDirectory("$liveDataFolder/$secSecureFolder");
	$liveEncryptionFolder="renders/$projectInfo[slug]/{$secSecureFolder}SPECIAL_encryption";
		EnsureDirectory($liveEncryptionFolder);
		EmptyDirectory($liveEncryptionFolder);
		EnsureDirectory("$liveEncryptionFolder/$secSecureFolder");
	$previewDirectory="adminPreviews/$projectInfo[slug]";
	
	$liveDirectory="renders/$projectInfo[slug]/".$adminDat['config']['targetDirectory'];
	
	EnsureDirectory($previewDirectory);
	EnsureDirectory("$previewDirectory/login");
	EnsureDirectory("$previewDirectory/app");
	EnsureDirectory("$previewDirectory/apires");
	
	EnsureDirectory("$previewSecFolder/admin");
	EnsureDirectory("$previewSecFolder/admin/enc");
		EmptyDirectory("$previewSecFolder/admin/enc");
	
	EnsureDirectory($liveDirectory);
	EnsureDirectory("$liveDirectory/login");
	EnsureDirectory("$liveDirectory/app");
	EnsureDirectory("$liveDirectory/apires");
	
	EnsureDirectory("$liveSecFolder/admin");
	EnsureDirectory("$liveSecFolder/admin/enc");
	
	
	if($adminDat['adminNotificationManager']['include']){
		EnsureDirectory("$liveDataFolder/$secSecureFolder/admin/adminNotifManager");
		EnsureDirectory("$previewSecFolder/admin/adminNotifManager");
		copy('adminTemplates/adminNotificationManager/db.db.temp', "$liveDataFolder/$secSecureFolder/admin/adminNotifManager/db.db");
		copy('adminTemplates/adminNotificationManager/db.db.temp', "$previewSecFolder/admin/adminNotifManager/db.db");
	}
	foreach($adminDat['blogs'] as $b)
	{
		//$fileName=preg_replace('/[^A-Za-z0-9]/','_',$b['title']);
			$fileName=$b['slug'];
		
		EnsureDirectory("$liveSecFolder/blogs/$fileName");
		EnsureDirectory("$liveDataFolder/$secSecureFolder/blogs/$fileName");
		EnsureDirectory("$previewSecFolder/blogs/$fileName");
		
		copy("adminTemplates/blogs/db.db.temp", "$liveDataFolder/$secSecureFolder/blogs/$fileName/db.db");
		copy("adminTemplates/blogs/db.db.temp", "$previewSecFolder/blogs/$fileName/db.db");
		
		
		
	}
	if($adminDat['contactForms']['list']){
		
		EnsureDirectory("$liveSecFolder/admin/contactForms");
		EnsureDirectory("$liveDataFolder/$secSecureFolder/admin/contactForms");
		EnsureDirectory("$previewSecFolder/admin/contactForms");
		copy('adminTemplates/contactForms/db.db.temp', "$liveDataFolder/$secSecureFolder/admin/contactForms/db.db");
		copy('adminTemplates/contactForms/db.db.temp', "$previewSecFolder/admin/contactForms/db.db");
		
		$locContactFormSQLite=new SQLite3("$previewSecFolder/admin/contactForms/db.db");
		$livContactFormSQLite=new SQLite3("$liveDataFolder/$secSecureFolder/admin/contactForms/db.db");
		
		EnsureDirectory("$previewSecFolder/admin/enc/contactForms");
			EmptyDirectory("$previewSecFolder/admin/enc/contactForms");
		EnsureDirectory("$liveEncryptionFolder/$secSecureFolder/admin/enc/contactForms");
			EmptyDirectory("$liveEncryptionFolder/$secSecureFolder/admin/enc/contactForms");
		
		foreach($adminDat['contactForms']['list'] as $cf)
		{
			if($cf['notifyAdmin']['activate']){
				array_push($ADMIN_notifications, "Contact Form: ".$cf['formName']);
			}
			
			$safeName=str_replace(" ","-", $cf['formName']);
			$fSafeName=preg_replace('/[^A-Za-z0-9]/','_',$cf['formName']);
			
			

			
			EnsureDirectory("$previewSecFolder/admin/enc/contactForms/{$safeName}");
				EmptyDirectory("$previewSecFolder/admin/enc/contactForms/{$safeName}");
			EnsureDirectory("$liveEncryptionFolder/$secSecureFolder/admin/enc/contactForms/{$safeName}");
				EmptyDirectory("$liveEncryptionFolder/$secSecureFolder/admin/enc/contactForms/{$safeName}");
				
				//$cf['formName'], $cf['inputs']
			$stmt=$locContactFormSQLite->prepare("INSERT INTO forms (formName,inps) VALUES (:formName, :inputs);");
				$stmt->bindValue(':formName', $cf['formName'], SQLITE3_TEXT);
				$stmt->bindValue(':inputs', json_encode($cf['inputs']), SQLITE3_TEXT);
				$stmt->execute();
			$stmt=$livContactFormSQLite->prepare("INSERT INTO forms (formName,inps) VALUES (:formName, :inputs);");
				$stmt->bindValue(':formName', $cf['formName'], SQLITE3_TEXT);
				$stmt->bindValue(':inputs', json_encode($cf['inputs']), SQLITE3_TEXT);
				$stmt->execute();
			
			
			if($cf['encryption']['method']['name'] === 'original'){
				$key1=base64_encode(openssl_random_pseudo_bytes(32));
				$key2=base64_encode(openssl_random_pseudo_bytes(64));
				
				
				file_put_contents("$previewSecFolder/admin/enc/contactForms/$safeName/lib.php", Unirep(file_get_contents('adminTemplates/encryption/enc.php.temp'),[
					'`--Enc-FName--`'=>'ContactForm_'.$fSafeName,
					'`--Enc-FirstKey--`'=>sQuote($key1),
					'`--Enc-SecondKey--`'=>sQuote($key2),
					'`--Enc-CipherMethod--`'=>sQuote($cf['encryption']['method']['cipherMethod']),
					'`--Enc-HashMethod--`'=>sQuote($cf['encryption']['method']['hashAlgorithm'])
					
				]));
				copy("$previewSecFolder/admin/enc/contactForms/$safeName/lib.php","$liveEncryptionFolder/$secSecureFolder/admin/enc/contactForms/$safeName/lib.php");
			}
			//$aname=$cf['encryption']['algorithm']['name'];$abits=$cf['encryption']['algorithm']['bits'];
			//$safeFile=str_replace("htdocs/../",'', $previewSecFolder);
			//die("ssh-keygen -b $abits -t $aname -f $safeFile/admin/enc/contactForms/$safeName/ -q -N \"\"");
			//exec("ssh-keygen -b $abits -t $aname -f $safeFile/admin/enc/contactForms/$safeName/_ -q -N \"\"");
			//CopyDirectory("$previewSecFolder/admin/enc/contactForms/$safeName","$liveEncryptionFolder/admin/enc/contactForms/$safeName");
		}
		
		$locContactFormSQLite->close();
		$livContactFormSQLite->close();
		
		
			
		
		
		
	}
	
	$adminHeadElems=[];
	EnsureDirectory("$previewDirectory/appMedia");
		EmptyDirectory("$previewDirectory/appMedia");
	EnsureDirectory("$liveDirectory/appMedia");
		EmptyDirectory("$liveDirectory/appMedia");
	
	$icons=[
			ParseSeoIcon('appleTouchLg', 'apple-touch-icon', '180', 'link', $adminDat['config']['metaMedia']['icons'], []),
			ParseSeoIcon('appleTouchMd', 'apple-touch-icon', '152', 'link', $adminDat['config']['metaMedia']['icons'], []),
			ParseSeoIcon('appleTouchSm', 'apple-touch-icon', '120', 'link', $adminDat['config']['metaMedia']['icons'], []),
			ParseSeoIcon('icon16', 'icon', '16', 'link', $adminDat['config']['metaMedia']['icons'], []),
			ParseSeoIcon('icon32', 'icon', '32', 'link', $adminDat['config']['metaMedia']['icons'], []),
			ParseSeoIcon('icon57', 'icon', '57', 'link', $adminDat['config']['metaMedia']['icons'], []),
			ParseSeoIcon('icon76', 'icon', '76', 'link', $adminDat['config']['metaMedia']['icons'], []),
			ParseSeoIcon('icon96', 'icon', '96', 'link', $adminDat['config']['metaMedia']['icons'], []),
			ParseSeoIcon('icon120', 'icon', '120', 'link', $adminDat['config']['metaMedia']['icons'], []),
			ParseSeoIcon('icon128', 'icon', '128', 'link', $adminDat['config']['metaMedia']['icons'], []),
			ParseSeoIcon('icon144', 'icon', '144', 'link', $adminDat['config']['metaMedia']['icons'], []),
			ParseSeoIcon('icon152', 'icon', '152', 'link', $adminDat['config']['metaMedia']['icons'], []),
			ParseSeoIcon('icon167', 'icon', '167', 'link', $adminDat['config']['metaMedia']['icons'], []),
			ParseSeoIcon('icon180', 'icon', '180', 'link', $adminDat['config']['metaMedia']['icons'], []),
			ParseSeoIcon('icon192', 'icon', '192', 'link', $adminDat['config']['metaMedia']['icons'], []),
			ParseSeoIcon('icon195', 'icon', '195', 'link', $adminDat['config']['metaMedia']['icons'], []),
			ParseSeoIcon('icon196', 'icon', '196', 'link', $adminDat['config']['metaMedia']['icons'], []),
			ParseSeoIcon('icon228', 'icon', '228', 'link', $adminDat['config']['metaMedia']['icons'], []),
			ParseSeoIcon('shortcutIcon', 'shortcut icon', '196', 'link', $adminDat['config']['metaMedia']['icons'], []),
			ParseSeoIcon('msAppTile', 'msapplication-TileImage', '144', 'meta', $adminDat['config']['metaMedia']['icons'], []),
	];
	foreach($icons as $ic)
		{
			if($ic['value']){
				if($ic['elType'] === 'link'){
					array_push($adminHeadElems, HTML_element('link',[
						'rel'=>$ic['name'], 
						'sizes'=>$ic['size'].'x'.$ic['size'], 
						'href'=>'`--AdminAbsolutePrefix--`/appMedia/icons/'.$ic['value']
					]));
				}else if($ic['elType'] === 'metaProperty'){
					array_push($adminHeadElems, HTML_element('meta',[
						'property'=>$ic['name'],
						'content'=>'`--AdminAbsolutePrefix--`/appMedia/icons/'.$ic['value']
					]));
				}else{
					array_push($adminHeadElems, HTML_element('meta',[
						'name'=>$ic['name'],
						'content'=>'`--AdminAbsolutePrefix--`/appMedia/icons/'.$ic['value']
					]));
				}
				if(is_file("previews/$projectInfo[slug]/media/icons/$ic[value]")){
					$spl=explode("/", $ic['value']);
					array_pop($spl);
					EnsureDirectory("$previewDirectory/appMedia/icons/".join("/",$spl));
					EnsureDirectory("$liveDirectory/appMedia/icons/".join("/",$spl));
					copy("previews/$projectInfo[slug]/media/icons/$ic[value]", "$previewDirectory/appMedia/icons/$ic[value]");
					copy("previews/$projectInfo[slug]/media/icons/$ic[value]", "$liveDirectory/appMedia/icons/$ic[value]");
				}
			}
		}
	foreach($adminDat['config']['metaMedia']['shareImages']['list'] as $si)
	{
		$im=$si['image'];
		EnsureDirectory("$previewDirectory/appMedia/images/$im[image]");
		EnsureDirectory("$liveDirectory/appMedia/images/$im[image]");
		array_push($adminHeadElems, HTML_element('meta', ['property'=>'og:image', 'content'=>"`--AdminAbsolutePrefix--`/appMedia/images/$im[image]/$im[size].$im[srcType]"]));
		if($si['alt']){
			array_push($adminHeadElems, HTML_element('meta', ['property'=>'og:image:alt', 'content'=>$si['alt']]));
		}
		if(is_file("previews/$projectInfo[slug]/media/images/$im[image]/$im[size].$im[srcType]")){
			copy("previews/$projectInfo[slug]/media/images/$im[image]/$im[size].$im[srcType]", "$previewDirectory/appMedia/images/$im[image]/$im[size].$im[srcType]");
			copy("previews/$projectInfo[slug]/media/images/$im[image]/$im[size].$im[srcType]", "$liveDirectory/appMedia/images/$im[image]/$im[size].$im[srcType]");
		}
	}
	
	
	$ADMIN_appMeta=join("\n", $adminHeadElems);
	$UNIREP_liveOrLocal='local';
	
	file_put_contents("$previewDirectory/index.php", "<?php header('location: login'); die();?>");
	file_put_contents("$liveDirectory/index.php", "<?php header('location: login'); die();?>");
	
	
	
	$livePat=[
		'`--AdminTopURI--`'=>$adminDat['config']['topUri'],
		'`--AdminAbsolutePrefix--`'=>$adminDat['config']['absolutePrefix']
	];
	$locaPat=[
		'`--AdminTopURI--`'=>"http://localhost/siteGenerator/v1/adminPreviews/$projectInfo[slug]",
		'`--AdminAbsolutePrefix--`'=>"/siteGenerator/v1/adminPreviews/$projectInfo[slug]"
		
	];
	$uniPat=[
		'`--AdminSessionVarName--`'=>$adminDat['config']['login']['sessionVarName'],
		'`--SecureFolder--`'=>$secSecureFolder,
		'`--AdminCompanyName--`'=>$adminDat['config']['companyName'],
		'`--AdminAppMeta--`'=>$ADMIN_appMeta
	];
	$loginPat=[
		'`--AdminUserHashAlgo--`'=>$adminDat['config']['login']['userHashAlgo'],
		'`--AdminPassHashAlgo--`'=>$adminDat['config']['login']['passHashAlgo'],
		'`--AdminConstantSalt--`'=>$adminDat['config']['login']['constantSalt'],
		
	];
	$passwordRecoveryPat=[
		'`--AdminPasswordRecoveryWaitTime--`'=>$adminDat['config']['recovery']['requestWaitTime'],
		'`--AdminPasswordRecoveryCaptureWaitTime--`'=>$adminDat['config']['recovery']['captureWaitTime'],
		
	];
	$livePasswordRecoveryPat=[
		'`--AdminPasswordRecovery-EmailHost--`'=>$adminDat['config']['recovery']['live']['host'],
		'`--AdminPasswordRecovery-EmailFromEmail--`'=>$adminDat['config']['recovery']['live']['fromAddress'],
		'`--AdminPasswordRecovery-EmailUser--`'=>$adminDat['config']['recovery']['live']['user'],
		'`--AdminPasswordRecovery-EmailFromName--`'=>$adminDat['config']['recovery']['live']['fromName'],
		'`--AdminPasswordRecovery-EmailPass--`'=>$adminDat['config']['recovery']['live']['password'],
		'`--AdminPasswordRecovery-EmailPort--`'=>$adminDat['config']['recovery']['live']['port'],
		'`--AdminPasswordRecovery-EmailisSMTP--`'=>($adminDat['config']['recovery']['live']['isSMTP'] ? 'true' : 'false'),
		'`--AdminPasswordRecovery-EmailSMTPAuth--`'=>($adminDat['config']['recovery']['live']['smtpAuth'] ? 'true' : 'false'),
		'`--AdminPasswordRecovery-EmailSMTPSecure--`'=>$adminDat['config']['recovery']['live']['smtpSecure'],
	
	];
	$locaPasswordRecoveryPat=[
		'`--AdminPasswordRecovery-EmailHost--`'=>$adminDat['config']['recovery']['local']['host'],
		'`--AdminPasswordRecovery-EmailFromEmail--`'=>$adminDat['config']['recovery']['local']['fromAddress'],
		'`--AdminPasswordRecovery-EmailUser--`'=>$adminDat['config']['recovery']['local']['user'],
		'`--AdminPasswordRecovery-EmailFromName--`'=>$adminDat['config']['recovery']['local']['fromName'],
		'`--AdminPasswordRecovery-EmailPass--`'=>$adminDat['config']['recovery']['local']['password'],
		'`--AdminPasswordRecovery-EmailPort--`'=>$adminDat['config']['recovery']['local']['port'],
		'`--AdminPasswordRecovery-EmailisSMTP--`'=>($adminDat['config']['recovery']['local']['isSMTP'] ? 'true' : 'false'),
		'`--AdminPasswordRecovery-EmailSMTPAuth--`'=>($adminDat['config']['recovery']['local']['smtpAuth'] ? 'true' : 'false'),
		'`--AdminPasswordRecovery-EmailSMTPSecure--`'=>$adminDat['config']['recovery']['local']['smtpSecure'],
	
	];
	
	$pUniPat=[$uniPat, $loginPat,$passwordRecoveryPat];
	$pLivePat=[$livePasswordRecoveryPat,$livePat];
	$pLocPat=[$locaPasswordRecoveryPat, $locaPat];
	
	
	CrossRender("adminTemplates/getLogin.php.temp", $pUniPat, "$previewDirectory/login/getLogin.php",$pLocPat, "$liveDirectory/login/getLogin.php", $pLivePat);
	/*file_put_contents("$previewDirectory/login/getLogin.php", Unirep(file_get_contents("adminTemplates/getLogin.php.temp"), 
		$uniPat,$loginPat,$locaPat
	[
		'`--AdminUserHashAlgo--`'=>$adminDat['config']['login']['userHashAlgo'],
		'`--AdminPassHashAlgo--`'=>$adminDat['config']['login']['passHashAlgo'],
		'`--AdminSessionVarName--`'=>$adminDat['config']['login']['sessionVarName'],
		'`--SecureFolder--`'=>$secSecureFolder,
		'`--AdminConstantSalt--`'=>$adminDat['config']['login']['constantSalt'],
	]));*/
	
	CrossRender("adminTemplates/loginPage.php.temp", $pUniPat, "$previewDirectory/login/index.php",$pLocPat, "$liveDirectory/login/index.php", $pLivePat);
	/*file_put_contents("$previewDirectory/login/index.php",Unirep(file_get_contents("adminTemplates/loginPage.php.temp"),
		$uniPat,$locaPat
	[
		'`--AdminCompanyName--`'=>$adminDat['config']['companyName'],
		'`--SecureFolder--`'=>$secSecureFolder
	]));*/
	
	CrossRender("adminTemplates/generatePasswordRecovery.php.temp", $pUniPat, "$previewDirectory/login/generatePasswordRecovery.php",$pLocPat, "$liveDirectory/login/generatePasswordRecovery.php", $pLivePat);
	/*file_put_contents("$previewDirectory/login/generatePasswordRecovery.php",Unirep(file_get_contents("adminTemplates/generatePasswordRecovery.php.temp"),
	
		$uniPat,$locaPat
	[
		'`--AdminCompanyName--`'=>$adminDat['config']['companyName'],
		'`--SecureFolder--`'=>$secSecureFolder
	]));*/
	
	CrossRender("adminTemplates/generatePasswordRecoveryAjax.php.temp", $pUniPat, "$previewDirectory/login/generatePasswordRecoveryAjax.php",$pLocPat, "$liveDirectory/login/generatePasswordRecoveryAjax.php", $pLivePat);
	/*file_put_contents("$previewDirectory/login/generatePasswordRecoveryAjax.php",Unirep(file_get_contents("adminTemplates/generatePasswordRecoveryAjax.php.temp"),
		$uniPat,$loginPat,$passwordRecoveryPat,$locaPat
	[
		'`--AdminCompanyName--`'=>$adminDat['config']['companyName'],
		'`--SecureFolder--`'=>$secSecureFolder,
		'`--AdminTopUri--`'=>"http://localhost/siteGenerator/v1/adminPreviews/$projectInfo[slug]",
		'`--AdminPasswordRecoveryWaitTime--`'=>$adminDat['config']['recovery']['requestWaitTime'],
		'`--AdminPasswordRecoveryCaptureWaitTime--`'=>$adminDat['config']['recovery']['captureWaitTime'],
		'`--AdminPasswordRecovery-EmailHost--`'=>$adminDat['config']['recovery']['local']['host'],
		'`--AdminPasswordRecovery-EmailFromEmail--`'=>$adminDat['config']['recovery']['local']['fromAddress'],
		'`--AdminPasswordRecovery-EmailUser--`'=>$adminDat['config']['recovery']['local']['user'],
		'`--AdminPasswordRecovery-EmailFromName--`'=>$adminDat['config']['recovery']['local']['fromName'],
		'`--AdminPasswordRecovery-EmailPass--`'=>$adminDat['config']['recovery']['local']['password'],
		'`--AdminPasswordRecovery-EmailPort--`'=>$adminDat['config']['recovery']['local']['port'],
		'`--AdminPasswordRecovery-EmailisSMTP--`'=>($adminDat['config']['recovery']['local']['isSMTP'] ? 'true' : 'false'),
		'`--AdminPasswordRecovery-EmailSMTPAuth--`'=>($adminDat['config']['recovery']['local']['smtpAuth'] ? 'true' : 'false'),
		'`--AdminPasswordRecovery-EmailSMTPSecure--`'=>$adminDat['config']['recovery']['local']['smtpSecure'],
	]));*/
	
	CrossRender("adminTemplates/resetPassword.php.temp", $pUniPat, "$previewDirectory/login/resetPassword.php",$pLocPat, "$liveDirectory/login/resetPassword.php", $pLivePat);
	/*file_put_contents("$previewDirectory/login/resetPassword.php",Unirep(file_get_contents("adminTemplates/resetPassword.php.temp"),
	
		$uniPat,$passwordRecoveryPat,$locaPat
	[
		'`--AdminCompanyName--`'=>$adminDat['config']['companyName'],
		'`--SecureFolder--`'=>$secSecureFolder,
		'`--AdminPasswordRecoveryWaitTime--`'=>$adminDat['config']['recovery']['requestWaitTime']
	]));*/
	
	CrossRender("adminTemplates/resetPasswordCancel.php.temp", $pUniPat, "$previewDirectory/login/resetPasswordCancel.php",$pLocPat, "$liveDirectory/login/resetPasswordCancel.php", $pLivePat);
	
	CrossRender("adminTemplates/resetPasswordExpired.html.temp", $pUniPat, "$previewDirectory/login/resetPasswordExpired.html",$pLocPat, "$liveDirectory/login/resetPasswordExpired.html", $pLivePat);
	/*file_put_contents("$previewDirectory/login/resetPasswordExpired.html",Unirep(file_get_contents("adminTemplates/resetPasswordExpired.html.temp"),
		$uniPat,$passwordRecoveryPat,$locaPat
	[
		'`--AdminCompanyName--`'=>$adminDat['config']['companyName'],
		'`--SecureFolder--`'=>$secSecureFolder,
		'`--AdminPasswordRecoveryWaitTime--`'=>$adminDat['config']['recovery']['requestWaitTime']
	]));*/
	
	CrossRender("adminTemplates/resetPasswordAjax.php.temp", $pUniPat, "$previewDirectory/login/resetPasswordAjax.php",$pLocPat, "$liveDirectory/login/resetPasswordAjax.php", $pLivePat);
	/*file_put_contents("$previewDirectory/login/resetPasswordAjax.php",Unirep(file_get_contents("adminTemplates/resetPasswordAjax.php.temp"),
		$uniPat,$passwordRecoveryPat,$loginPat,$locaPat
	[
		'`--AdminCompanyName--`'=>$adminDat['config']['companyName'],
		'`--SecureFolder--`'=>$secSecureFolder,
		'`--AdminPasswordRecoveryWaitTime--`'=>$adminDat['config']['recovery']['requestWaitTime'],
		'`--AdminPasswordRecoveryCaptureWaitTime--`'=>$adminDat['config']['recovery']['captureWaitTime'],
		'`--AdminPasswordRecovery-EmailHost--`'=>$adminDat['config']['recovery']['local']['host'],
		'`--AdminPasswordRecovery-EmailUser--`'=>$adminDat['config']['recovery']['local']['user'],
		'`--AdminPasswordRecovery-EmailFromEmail--`'=>$adminDat['config']['recovery']['local']['fromAddress'],
		'`--AdminPasswordRecovery-EmailFromName--`'=>$adminDat['config']['recovery']['local']['fromName'],
		'`--AdminPasswordRecovery-EmailPass--`'=>$adminDat['config']['recovery']['local']['password'],
		'`--AdminPasswordRecovery-EmailPort--`'=>$adminDat['config']['recovery']['local']['port'],
		'`--AdminPasswordRecovery-EmailisSMTP--`'=>($adminDat['config']['recovery']['local']['isSMTP'] ? 'true' : 'false'),
		'`--AdminPasswordRecovery-EmailSMTPAuth--`'=>($adminDat['config']['recovery']['local']['smtpAuth'] ? 'true' : 'false'),
		'`--AdminPasswordRecovery-EmailSMTPSecure--`'=>$adminDat['config']['recovery']['local']['smtpSecure'],
		'`--AdminUserHashAlgo--`'=>$adminDat['config']['login']['userHashAlgo'],
		'`--AdminPassHashAlgo--`'=>$adminDat['config']['login']['passHashAlgo'],
		'`--AdminConstantSalt--`'=>$adminDat['config']['login']['constantSalt'],
	]));*/
	
	CrossRender("adminTemplates/logout.php.temp", $pUniPat, "$previewDirectory/logout.php",$pLocPat, "$liveDirectory/logout.php", $pLivePat);
	/*file_put_contents("$previewDirectory/logout.php", Unirep(file_get_contents("adminTemplates/logout.php.temp"),
		$uniPat,$locaPat
	[
		'`--AdminSessionVarName--`'=>$adminDat['config']['login']['sessionVarName']
	]));*/
	
	CrossRender("adminTemplates/onlyLoggedOut.php.temp", $pUniPat, "$previewSecFolder/admin/onlyLoggedOut.php",$pLocPat, "$liveSecFolder/admin/onlyLoggedOut.php", $pLivePat);
	/*file_put_contents("$previewSecFolder/admin/onlyLoggedOut.php", Unirep(file_get_contents("adminTemplates/onlyLoggedOut.php.temp"),
		$uniPat,$locaPat,
	[
		//'`--AdminSessionVarName--`'=>$adminDat['config']['login']['sessionVarName'],
		//'`--AdminTopURI--`'=>"http://localhost/siteGenerator/v1/adminPreviews/$projectInfo[slug]"
	]));*/
	
	CrossRender("adminTemplates/ajaxOnlyLoggedOut.php.temp", $pUniPat, "$previewSecFolder/admin/ajaxOnlyLoggedOut.php",$pLocPat, "$liveSecFolder/admin/ajaxOnlyLoggedOut.php", $pLivePat);
	/*file_put_contents("$previewSecFolder/admin/ajaxOnlyLoggedOut.php", Unirep(file_get_contents("adminTemplates/ajaxOnlyLoggedOut.php.temp"),
		$uniPat,$locaPat
	[
		'`--AdminSessionVarName--`'=>$adminDat['config']['login']['sessionVarName'],
		'`--AdminTopURI--`'=>"http://localhost/siteGenerator/v1/adminPreviews/$projectInfo[slug]"
	]));*/
	
	CrossRender("adminTemplates/onlyLoggedIn.php.temp", $pUniPat, "$previewSecFolder/admin/onlyLoggedIn.php",$pLocPat, "$liveSecFolder/admin/onlyLoggedIn.php", $pLivePat);
	/*file_put_contents("$previewSecFolder/admin/onlyLoggedIn.php", Unirep(file_get_contents("adminTemplates/onlyLoggedIn.php.temp"),
		$uniPat,$locaPat
	[
		'`--AdminSessionVarName--`'=>$adminDat['config']['login']['sessionVarName'],
		'`--AdminTopURI--`'=>"http://localhost/siteGenerator/v1/adminPreviews/$projectInfo[slug]"
	]));*/
	
	CrossRender("adminTemplates/ajaxOnlyLoggedIn.php.temp", $pUniPat, "$previewSecFolder/admin/ajaxOnlyLoggedIn.php",$pLocPat, "$liveSecFolder/admin/ajaxOnlyLoggedIn.php", $pLivePat);
	/*file_put_contents("$previewSecFolder/admin/ajaxOnlyLoggedIn.php", Unirep(file_get_contents("adminTemplates/ajaxOnlyLoggedIn.php.temp"),
		$uniPat,$locaPat
	[
		'`--AdminSessionVarName--`'=>$adminDat['config']['login']['sessionVarName'],
		'`--AdminTopURI--`'=>"http://localhost/siteGenerator/v1/adminPreviews/$projectInfo[slug]"
	]));*/
	
	CrossRender("adminTemplates/onlySuper.php.temp", $pUniPat, "$previewSecFolder/admin/onlySuper.php",$pLocPat, "$liveSecFolder/admin/onlySuper.php", $pLivePat);
	/*file_put_contents("$previewSecFolder/admin/onlySuper.php", Unirep(file_get_contents("adminTemplates/onlySuper.php.temp"),
		$uniPat,$locaPat
	[
		'`--AdminSessionVarName--`'=>$adminDat['config']['login']['sessionVarName'],
		'`--AdminTopURI--`'=>"http://localhost/siteGenerator/v1/adminPreviews/$projectInfo[slug]"
	]));*/
	
	CrossRender("adminTemplates/ajaxOnlySuper.php.temp", $pUniPat, "$previewSecFolder/admin/ajaxOnlySuper.php",$pLocPat, "$liveSecFolder/admin/ajaxOnlySuper.php", $pLivePat);
	/*file_put_contents("$previewSecFolder/admin/ajaxOnlySuper.php", Unirep(file_get_contents("adminTemplates/ajaxOnlySuper.php.temp"),
		$uniPat,$locaPat
	[
		'`--AdminSessionVarName--`'=>$adminDat['config']['login']['sessionVarName'],
		'`--AdminTopURI--`'=>"http://localhost/siteGenerator/v1/adminPreviews/$projectInfo[slug]"
	]));*/
	
	
	$superRmfInfo=[];
	
	
	copy("adminTemplates/db.db.temp", "$previewSecFolder/admin/db.db");
	
	EnsureDirectory("$liveDataFolder/$secSecureFolder/admin");
	
		copy("adminTemplates/db.db.temp", "$liveDataFolder/$secSecureFolder/admin/db.db");
	
	$superRmfInfo=[
		'sqlComm'=>'',
		'sqlData'=>'',
		'rmfAppend'=>'',
	];
	
	$db=new SQLite3("$previewSecFolder/admin/db.db");
	
	
	$user=$adminDat['config']['login']['firstUserName'];
	$email=$adminDat['config']['login']['firstUserEmail'];
	$hashedUser=hash($adminDat['config']['login']['userHashAlgo'],$email);
	$storedPass=hash($adminDat['config']['login']['passHashAlgo'],StringMixit($adminDat['config']['login']['firstUserPass'], $adminDat['config']['login']['constantSalt'], $hashedUser));
	
	$user=sQuote($user);
	$storedPass=sQuote($storedPass);
	$email=sQuote($email);
	$db->query("INSERT INTO members (name, email, pass, role) VALUES ($user,$email,$storedPass, 'super');");
	$db->close();
	
	$db=new SQLite3("$liveDataFolder/$secSecureFolder/admin/db.db");
	
	
	$user=$adminDat['config']['login']['liveFirstUserName'];
	$email=$adminDat['config']['login']['liveFirstUserEmail'];
	$hashedUser=hash($adminDat['config']['login']['userHashAlgo'],$email);
	$storedPass=hash($adminDat['config']['login']['passHashAlgo'],StringMixit($adminDat['config']['login']['liveFirstUserPass'], $adminDat['config']['login']['constantSalt'], $hashedUser));
	
	$user=sQuote($user);
	$storedPass=sQuote($storedPass);
	$email=sQuote($email);
	$db->query("INSERT INTO members (name, email, pass, role) VALUES ($user,$email,$storedPass, 'super');");
	$db->close();
	
	
	
	$superRmfInfo=CopyRmf("WAArenderAdmin","$previewSecFolder/admin/RMF",['`--SecureFolder--`'=>$secSecureFolder]);
	CopyRmf("WAArenderAdmin","$liveSecFolder/admin/RMF",['`--SecureFolder--`'=>$secSecureFolder]);
	
	$regularRmfInfo=[];
	$regRmfDbArray=[];
	$superRmfDbArr=["WAArenderAdmin"];
	if($adminDat['contactForms']['list']){
		array_push($regRmfDbArray,"_redacted_");
		$regularRmfInfo=ConcatRmfInfo($regularRmfInfo,CopyRmf("_redacted_","$previewSecFolder/admin/contactForms/RMF",['`--SecureFolder--`'=>$secSecureFolder]));
		CopyRmf("_redacted_","$liveSecFolder/admin/contactForms/RMF",['`--SecureFolder--`'=>$secSecureFolder]);
	}
	if($adminDat['adminNotificationManager']['include']){
		array_push($regRmfDbArray,"WAArenderAdminNotiManager");
		$regularRmfInfo=ConcatRmfInfo($regularRmfInfo, 
			CopyRmf("WAArenderAdminNotiManager","$previewSecFolder/admin/adminNotifManager/RMF",['`--SecureFolder--`'=>$secSecureFolder])
		
		);
		CopyRmf("WAArenderAdminNotiManager","$liveSecFolder/admin/adminNotifManager/RMF",['`--SecureFolder--`'=>$secSecureFolder]);
	}
	if($adminDat['blogs']){
		array_push($regRmfDbArray,"_redacted_");
		foreach($adminDat['blogs'] as $b)
		{
			//echo 'yo';
			//$fileName=preg_replace('/[^A-Za-z0-9]/','_',$b['title']);
			$fileName=$b['slug'];
			$regularRmfInfo=ConcatRmfInfo($regularRmfInfo, 
				CopyRmf("_redacted_","$previewSecFolder/blogs/$fileName/RMF",['`--SecureFolder--`'=>$secSecureFolder,'`--Blog-Slug--`'=>$fileName])
			
			);
			//die(json_encode($regularRmfInfo));
			CopyRmf("_redacted_","$liveSecFolder/blogs/$fileName/RMF",['`--SecureFolder--`'=>$secSecureFolder, '`--Blog-Slug--`'=>$fileName]);
		}
	}
	
	if($regRmfDbArray){
		$regularRmfInfo=GetRmfArr($regRmfDbArray);
	}
	if($regRmfDbArray){
		$superRmfInfo=GetRmfArr(array_merge($superRmfDbArr,$regRmfDbArray));
	}
	RenderAdminApp($adminDat, $projectInfo,$secSecureFolder,$previewDirectory, $previewSecFolder, $liveDirectory,$liveSecFolder, $regularRmfInfo,$superRmfInfo);
}
function ConcatRmfInfo($info1, $info2){
	$ret=[];
	if(!$info1){
		return $info2;
	}
	foreach($info1 as $k=>$inf)
	{
		$ret[$k]=$info1[$k]."\n".$info2[$k];
	}
	return $ret;
}
function RenderAdminApp($adminDat, $projectInfo, $secSecureFolder, $localApp, $localSec, $liveApp, $liveSec, $rmfInfo, $superRmfInfo){
	global $UNIREP_liveOrLocal;
	global $ADMIN_appMeta;
	global $ADMIN_notifications;
	
	$appIndexTemplate=$adminDat['config']['app']['appIndexPage'];
	$appTemplate=$adminDat['config']['app']['appPage'];
	
	//// `--VCR-ViewData--` `--VCR-Controlers-N-Views--` `--AdminAppScripts--` `--AdminAppStyles--`
	//AdminAppScripts 
	/*
So, view data is defined as this 
obj 
'viewName':{
	funct:function that is a view function,
	title: either a string or a function that calculates the title,
	urlEndpoint: a url enpoint to be concatenated to `--AdminTopURI--`/,
	StartHistory: a function that accepts the top part of the url to act as data. 
}
*/
	//$sectionButtonString="";
	
	$viewData=[];
	
	$jsLibScripts=["fun2", "ob2", "hist","el", "elFetch",'specialFetch','screenCapture','dFCM','rmf','rmfSupplement','basicModal','softNotification'];
	$jsCoreScripts=["start"];
	$adminJsLibScripts=["VCR_admin"];
	$scriptString=[];
	$styleString=[];
	
	$superCSS=[];
	
	
	foreach($jsLibScripts as $s)
	{
		array_push($scriptString, file_get_contents("$_SERVER[DOCUMENT_ROOT]/js_library/$s.js"));
		if(is_file("$_SERVER[DOCUMENT_ROOT]/js_library/$s.css")){
			array_push($styleString, file_get_contents("$_SERVER[DOCUMENT_ROOT]/js_library/$s.css"));
		}
	}
	foreach($adminJsLibScripts as $s)
	{
		
		array_push($scriptString, file_get_contents("$_SERVER[DOCUMENT_ROOT]/js_library_admin/$s.js"));
		if(is_file("$_SERVER[DOCUMENT_ROOT]/js_library_admin/$s.css")){
			array_push($styleString, file_get_contents("$_SERVER[DOCUMENT_ROOT]/js_library_admin/$s.css"));
		}
	}
	foreach($jsCoreScripts as $s)
	{
		array_push($scriptString, file_get_contents("$_SERVER[DOCUMENT_ROOT]/js_core/$s.js"));
		if(is_file("$_SERVER[DOCUMENT_ROOT]/js_core/$s.css")){
			array_push($styleString, file_get_contents("$_SERVER[DOCUMENT_ROOT]/js_core/$s.css"));
		}
	}
	
	if($adminDat['manageAdmins']['include'] && is_file("adminTemplates/manageAdmins/manageAdminsPat.css")){
		array_push($superCSS, file_get_contents("adminTemplates/manageAdmins/manageAdminsPat.css"));
	}
	$viewDataStr=['home:{
		funct:function(a){
			var tar=a.GET_target(true);
			var headers={"":[]};
			for(var mem in VC_viewData)
			{
				if(!VC_viewData[mem].homeButtonText){continue;}
				var headerHol=VC_viewData[mem].homeHeader || "";
				var e=_el.CREATE("div","","mainNavButtons",{DATA_mem:mem,onclick:function(){VCR.main.CHANGE(this.DATA_mem);}},[VC_viewData[mem].homeButtonText]);
				if(headerHol){
					headers[headerHol]=headers[headerHol] || [];
				
					headers[headerHol].push(e);
				}else{
					_el.APPEND(tar, e);
				}
			}
			for(var mem in headers)
			{
				_el.APPEND(tar, [
					_el.CREATE("h3","","",{},[mem]),
					...headers[mem]
				]);
			}
		},
		title:"`--AdminCompanyName--` Admin Console",
		urlEndpoint:""
	}'];
	if($adminDat['contactForms']['list']){
		array_push($viewDataStr, 'contactForms:'.file_get_contents('adminTemplates/contactForms/pat.js'));
		array_push($styleString, file_get_contents('adminTemplates/contactForms/pat.css'));
	}
	
	if($adminDat['blogs']){
		array_push($styleString, file_get_contents('adminTemplates/blogs/pat.css'));
		$needsAdvCss=false;
		$needsCKCss=false;
		$needsImageGalleryCss=false;
		foreach($adminDat['blogs'] as $b)
		{
			array_push($viewDataStr,"'blog-$b[slug]':".Unirep(file_get_contents('adminTemplates/blogs/pat.js'),[
				'`--Admin-BlogTitle--`'=>$b['title'],
				'`--Admin-BlogSlug--`'=>$b['slug'],
				'`--Blog-Slug--`'=>"$b[slug]",
				'`--Blog-EditCategoryLink--`'=>($b['categorized'] ? "_el.CREATE('button','','',{
				onclick:function(){
					VCR.main.CHANGE('blog-`--Admin-BlogSlug--`-categoryEditor');
				}
			},['Edit Categories']),":'')
			]));
			if($b['editorType'] === 'advanced'){
				$needsAdvCss=true;
				array_push($viewDataStr, "'blog-$b[slug]-editor':".Unirep(file_get_contents('adminTemplates/blogs/editorAdvancedPat.js'),[
					'`--Blog-Slug--`'=>"$b[slug]",
					'`--Admin-BlogEditorTitle--`'=>"$b[title] Editor",
					'`--Admin-BlogEditorSlug--`'=>"$b[slug]-editor",
					'`--Admin-BlogEditor-UpText--`'=>"$b[title] Blog List",
					'`--Admin-BlogEditor-UpView--`'=>"blog-$b[slug]",
					'`--Blog-UploadChunkSize--`'=>"$b[uploadChunkSize]",
					'`--Blog-ArticleEditorCategoryInp--`'=>($b['categorized'] ? "{name:'categories',labelText:'Categories', type:'blogCategory'}," :'')
				]));
			}else if($b['editorType'] === 'ckEditor'){
				$needsCKCss=true;
			}else if($b['editorType'] === 'imageGallery'){
				$needsImageGalleryCss=true;
				array_push($viewDataStr, "'blog-$b[slug]-editor':".Unirep(file_get_contents('adminTemplates/blogs/editorImageGalleryPat.js'),[
					'`--Blog-Slug--`'=>"$b[slug]",
					'`--Admin-BlogEditorTitle--`'=>"$b[title] Editor",
					'`--Admin-BlogEditorSlug--`'=>"$b[slug]-editor",
					'`--Admin-BlogEditor-UpText--`'=>"$b[title] Blog List",
					'`--Admin-BlogEditor-UpView--`'=>"blog-$b[slug]",
					'`--Blog-UploadChunkSize--`'=>"$b[uploadChunkSize]",
					'`--Blog-ArticleEditorCategoryInp--`'=>($b['categorized'] ? "{name:'categories',labelText:'Categories', type:'blogCategory'}," :'')
				]));
				
			}
			
			if($b['categorized']){
				array_push($viewDataStr, "'blog-$b[slug]-categoryEditor':".Unirep(file_get_contents("adminTemplates/blogs/categoryPat.js"),[
					'`--Admin-BlogSlug--`'=>"$b[slug]",
					'`--Blog-Slug--`'=>"$b[slug]",
					"`--Admin-BlogCategoryEditorTitle--`"=>"$b[title] Category Editor",
					'`--Blog-UploadChunkSize--`'=>"$b[uploadChunkSize]",
					'`--Admin-BlogCategoryEditor-UpText--`'=>"$b[title] Blog List",
					'`--Admin-BlogCategoryEditor-UpView--`'=>"blog-$b[slug]"
				]));
				array_push($styleString, file_get_contents('adminTemplates/blogs/categoryPat.css'));
			}
			
		}
		if($needsAdvCss){
			array_push($styleString, file_get_contents('adminTemplates/blogs/editorAdvancedPat.css'));
		}
		if($needsCKCss){
			array_push($styleString, file_get_contents('adminTemplates/blogs/editorBasicPat.css'));
		}
		if($needsImageGalleryCss){
			array_push($styleString, file_get_contents('adminTemplates/blogs/editorImageGalleryPat.css'));
		}
	}
	
	
	array_push($viewDataStr, 'adminAccountSettings:'.file_get_contents('adminTemplates/adminAccountSettings/pat.js'));
	if($adminDat['adminNotificationManager']['include']){
		array_push($viewDataStr, 'adminNotificationManager:'.file_get_contents('adminTemplates/adminNotificationManager/pat.js'));
		array_push($styleString, file_get_contents('adminTemplates/adminNotificationManager/pat.css'));
	}
	
	foreach($viewData as $k=>$v)
	{
		
		array_push($viewDataStr,sQuote($k).':{');
		$viewDataDetailArr=[];
		foreach($v as $vk=>$vv)
		{
			array_push($viewDataDetailArr,sQuote($vk).':'.$vv);
		}
		array_push($viewDataStr, join(",",$viewDataDetailArr), "}");
		
	}
	$viewDataStr="{".join(",",$viewDataStr)."};`--AdminSuperViewData--`";


	if($rmfInfo){
		//echo($rmfInfo['rmfAppend']);
		array_push($scriptString, $rmfInfo['rmfAppend']);
	}
	if($superRmfInfo){
		array_push($scriptString, $superRmfInfo['rmfAppend']);
	}
	array_push($scriptString, '`--AdminSuperRMFData--`');
	array_push($styleString, '`--AdminSuperCSS--`');
	
	$scriptString=join("\n", $scriptString);
	$styleString=join("\n", $styleString);
	
	$UNIREP_liveOrLocal="local";
	
	$livePat=[
		'`--AdminTopURI--`'=>$adminDat['config']['topUri'],
		'`--AdminAbsolutePrefix--`'=>$adminDat['config']['absolutePrefix'],
		'`--TopUri--`'=>$projectInfo['data']['top']['main']['topUri'],
		'`--AbsolutePrefix--`'=>$projectInfo['data']['top']['main']['absolutePrefix'],
	
	];
	$locaPat=[
		'`--AdminAbsolutePrefix--`'=>"/siteGenerator/v1/adminPreviews/$projectInfo[slug]",
		'`--AdminTopURI--`'=>"http://localhost/siteGenerator/v1/adminPreviews/$projectInfo[slug]",
		'`--TopUri--`'=>'http://localhost/siteGenerator/v1/previews/'.$projectInfo['slug'],
		'`--AbsolutePrefix--`'=>'/siteGenerator/v1/previews/'.$projectInfo['slug']
	];
	$uniPat=[
		
		'`--AdminCompanyName--`'=>$adminDat['config']['companyName'],
		'`--SecureFolder--`'=>$secSecureFolder,
		'`--AdminSessionVarName--`'=>$adminDat['config']['login']['sessionVarName'],
		'`--VCR-ViewData--`'=>$viewDataStr,
		'`--AdminAppScripts--`'=>$scriptString,
		'`--AdminAppStyles--`'=>$styleString,
		'`--AdminAppMeta--`'=>$ADMIN_appMeta
	];
	$manageAdminPat=[
	
		'`--ManageAdminsPat--`'=>(
			($adminDat['manageAdmins']['include']) ? 
			('VC_viewData.adminManager='.sQuoteEscape(file_get_contents('adminTemplates/manageAdmins/manageAdminsPat.js'))) : 
			('')
		),
		'`--ManageAdminsRMFData--`'=>'',
		'`--ManageAdminsCSS--`'=>sQuoteEscape(implode("\n",$superCSS)),
	];

	$passwordPat=[
			'`--AdminUserHashAlgo--`'=>$adminDat['config']['login']['userHashAlgo'],
			'`--AdminPassHashAlgo--`'=>$adminDat['config']['login']['passHashAlgo'],
			'`--AdminConstantSalt--`'=>$adminDat['config']['login']['constantSalt'],
		
	];
	$recoveryPat=[
		
	];
	$notificationManagerPat=[
		'`--AdminNotificationManager-SupportedMethods--`'=>json_encode(array_merge(
			(($adminDat['adminNotificationManager']['email']) ? [['name'=>'email', 'labelText'=>'Email', 'type'=>'singleLine']] : []),
			(($adminDat['adminNotificationManager']['twillio']) ? [['name'=>'phoneNumber', 'labelText'=>'phone', 'type'=>'singleLine']] : []),
			//(($adminDat['adminNotificationManager']['push']) ? ['text'=>'','type'=>'header']: []),
		)) ,
		'`--AdminNotificationManager-SupportedNotifications--`'=>json_encode($ADMIN_notifications)
	];
	
	$pUniPat=[$uniPat, $manageAdminPat, $passwordPat, $notificationManagerPat];
	$pLocPat=[$locaPat];
	$pLivePat=[$livePat];
	//// `--VCR-ViewData--` `--VCR-Controlers-N-Views--` `--AdminAppScripts--` `--AdminAppStyles--`
	
	
	CrossRender($appIndexTemplate, $pUniPat, "$localApp/app/index.php",$pLocPat, "$liveApp/app/index.php", $pLivePat,true);
	/*file_put_contents("$localApp/app/index.php", Unirep($appIndexTemplate,
		$uniPat, $passwordPat, $manageAdminPat, $locaPat
	[
		'`--AdminAbsolutePrefix--`'=>"/siteGenerator/v1/adminPreviews/$projectInfo[slug]",
		'`--AdminCompanyName--`'=>$adminDat['config']['companyName'],
		'`--SecureFolder--`'=>$secSecureFolder,
		'`--AdminSessionVarName--`'=>$adminDat['config']['login']['sessionVarName'],
		'`--AdminTopURI--`'=>"http://localhost/siteGenerator/v1/adminPreviews/$projectInfo[slug]",
		'`--ManageAdminsPat--`'=>(
			($adminDat['manageAdmins']['include']) ? 
			('VC_viewData.adminManager='.sQuoteEscape(file_get_contents('adminTemplates/manageAdmins/manageAdminsPat.js'))) : 
			('')
		),
		'`--ManageAdminsRMFData--`'=>'',
		'`--ManageAdminsCSS--`'=>sQuoteEscape(implode("\n",$superCSS)),
	]));*/
	
	CrossRender($appTemplate, $pUniPat, "$localSec/admin/app.html.temp",$pLocPat, "$liveSec/admin/app.html.temp", $pLivePat,true);
	/*file_put_contents("$localSec/admin/app.html.temp", Unirep($appTemplate,
		$uniPat, $passwordPat, $manageAdminPat, $locaPat
	[
		'`--AdminAbsolutePrefix--`'=>"/siteGenerator/v1/adminPreviews/$projectInfo[slug]",
		'`--AdminSessionVarName--`'=>$adminDat['config']['login']['sessionVarName'],
		'`--AdminTopURI--`'=>"http://localhost/siteGenerator/v1/adminPreviews/$projectInfo[slug]",
		'`--AdminCompanyName--`'=>$adminDat['config']['companyName'],
		'`--SecureFolder--`'=>$secSecureFolder,
		'`--VCR-ViewData--`'=>$viewDataStr,
		'`--AdminAppScripts--`'=>$scriptString,
		'`--AdminAppStyles--`'=>$styleString
	]));*/
	
	EnsureDirectory("$localApp/apires/adminAccountSettings");
	EnsureDirectory("$liveApp/apires/adminAccountSettings");
	CrossRender("adminTemplates/adminAccountSettings/updateSettings.php.temp", $pUniPat, "$localApp/apires/adminAccountSettings/updateSettings.php",$pLocPat, "$liveApp/apires/adminAccountSettings/updateSettings.php", $pLivePat);
	/*file_put_contents("$localApp/apires/adminAccountSettings/updateSettings.php", Unirep(file_get_contents("adminTemplates/adminAccountSettings/updateSettings.php.temp"),
		$uniPat, $passwordPat, $manageAdminPat, $locaPat
	[
		
		'`--AdminAbsolutePrefix--`'=>"/siteGenerator/v1/adminPreviews/$projectInfo[slug]",
		'`--AdminSessionVarName--`'=>$adminDat['config']['login']['sessionVarName'],
		'`--AdminTopURI--`'=>"http://localhost/siteGenerator/v1/adminPreviews/$projectInfo[slug]",
		'`--AdminCompanyName--`'=>$adminDat['config']['companyName'],
		'`--SecureFolder--`'=>$secSecureFolder,
		'`--VCR-ViewData--`'=>$viewDataStr,
		'`--AdminAppScripts--`'=>$scriptString,
		'`--AdminAppStyles--`'=>$styleString
	]));*/
	
	if($adminDat['manageAdmins']['include']){
		EnsureDirectory("$localApp/apires/manageAdmins");
		EnsureDirectory("$liveApp/apires/manageAdmins");
		CrossRender("adminTemplates/manageAdmins/getAdminList.php.temp", $pUniPat, "$localApp/apires/manageAdmins/getAdminList.php",$pLocPat, "$liveApp/apires/manageAdmins/getAdminList.php", $pLivePat);
		/*file_put_contents("$localApp/apires/manageAdmins/getAdminList.php", Unirep(file_get_contents("adminTemplates/manageAdmins/getAdminList.php.temp"),
			$uniPat, $passwordPat, $manageAdminPat, $locaPat
		[
			
			'`--AdminAbsolutePrefix--`'=>"/siteGenerator/v1/adminPreviews/$projectInfo[slug]",
			'`--AdminSessionVarName--`'=>$adminDat['config']['login']['sessionVarName'],
			'`--AdminTopURI--`'=>"http://localhost/siteGenerator/v1/adminPreviews/$projectInfo[slug]",
			'`--AdminCompanyName--`'=>$adminDat['config']['companyName'],
			'`--SecureFolder--`'=>$secSecureFolder,
			'`--VCR-ViewData--`'=>$viewDataStr,
			'`--AdminAppScripts--`'=>$scriptString,
			'`--AdminAppStyles--`'=>$styleString,
			'`--AdminUserHashAlgo--`'=>$adminDat['config']['login']['userHashAlgo'],
			'`--AdminPassHashAlgo--`'=>$adminDat['config']['login']['passHashAlgo'],
			'`--AdminConstantSalt--`'=>$adminDat['config']['login']['constantSalt'],
		]));*/
		
		CrossRender("adminTemplates/manageAdmins/deleteAdmin.php.temp", $pUniPat, "$localApp/apires/manageAdmins/deleteAdmin.php",$pLocPat, "$liveApp/apires/manageAdmins/deleteAdmin.php", $pLivePat);
		/*file_put_contents("$localApp/apires/manageAdmins/deleteAdmin.php", Unirep(file_get_contents("adminTemplates/manageAdmins/deleteAdmin.php.temp"),
			$uniPat, $passwordPat, $manageAdminPat, $locaPat
		[
			
			'`--AdminAbsolutePrefix--`'=>"/siteGenerator/v1/adminPreviews/$projectInfo[slug]",
			'`--AdminSessionVarName--`'=>$adminDat['config']['login']['sessionVarName'],
			'`--AdminTopURI--`'=>"http://localhost/siteGenerator/v1/adminPreviews/$projectInfo[slug]",
			'`--AdminCompanyName--`'=>$adminDat['config']['companyName'],
			'`--SecureFolder--`'=>$secSecureFolder,
			'`--VCR-ViewData--`'=>$viewDataStr,
			'`--AdminAppScripts--`'=>$scriptString,
			'`--AdminAppStyles--`'=>$styleString
		]));*/
		
		CrossRender("adminTemplates/manageAdmins/addAdmin.php.temp", $pUniPat, "$localApp/apires/manageAdmins/addAdmin.php",$pLocPat, "$liveApp/apires/manageAdmins/addAdmin.php", $pLivePat);
		/*file_put_contents("$localApp/apires/manageAdmins/addAdmin.php", Unirep(file_get_contents("adminTemplates/manageAdmins/addAdmin.php.temp"),
			$uniPat, $passwordPat, $manageAdminPat, $locaPat
		[
			
			'`--AdminUserHashAlgo--`'=>$adminDat['config']['login']['userHashAlgo'],
			'`--AdminPassHashAlgo--`'=>$adminDat['config']['login']['passHashAlgo'],
			'`--AdminConstantSalt--`'=>$adminDat['config']['login']['constantSalt'],
			'`--AdminAbsolutePrefix--`'=>"/siteGenerator/v1/adminPreviews/$projectInfo[slug]",
			'`--AdminSessionVarName--`'=>$adminDat['config']['login']['sessionVarName'],
			'`--AdminTopURI--`'=>"http://localhost/siteGenerator/v1/adminPreviews/$projectInfo[slug]",
			'`--AdminCompanyName--`'=>$adminDat['config']['companyName'],
			'`--SecureFolder--`'=>$secSecureFolder,
			'`--VCR-ViewData--`'=>$viewDataStr,
			'`--AdminAppScripts--`'=>$scriptString,
			'`--AdminAppStyles--`'=>$styleString
		]));*/
		
		CrossRender("adminTemplates/manageAdmins/editAdmin.php.temp", $pUniPat, "$localApp/apires/manageAdmins/editAdmin.php",$pLocPat, "$liveApp/apires/manageAdmins/editAdmin.php", $pLivePat);
		/*file_put_contents("$localApp/apires/manageAdmins/editAdmin.php", Unirep(file_get_contents("adminTemplates/manageAdmins/editAdmin.php.temp"),
			$uniPat, $passwordPat, $manageAdminPat, $locaPat
		[
			
			'`--AdminUserHashAlgo--`'=>$adminDat['config']['login']['userHashAlgo'],
			'`--AdminPassHashAlgo--`'=>$adminDat['config']['login']['passHashAlgo'],
			'`--AdminConstantSalt--`'=>$adminDat['config']['login']['constantSalt'],
			'`--AdminAbsolutePrefix--`'=>"/siteGenerator/v1/adminPreviews/$projectInfo[slug]",
			'`--AdminSessionVarName--`'=>$adminDat['config']['login']['sessionVarName'],
			'`--AdminTopURI--`'=>"http://localhost/siteGenerator/v1/adminPreviews/$projectInfo[slug]",
			'`--AdminCompanyName--`'=>$adminDat['config']['companyName'],
			'`--SecureFolder--`'=>$secSecureFolder,
			'`--VCR-ViewData--`'=>$viewDataStr,
			'`--AdminAppScripts--`'=>$scriptString,
			'`--AdminAppStyles--`'=>$styleString
		]));*/
	}
	if($adminDat['contactForms']['list']){
		EnsureDirectory("$localApp/apires/contactForms");
		EnsureDirectory("$liveApp/apires/contactForms");
		CrossRender("adminTemplates/contactForms/getFormList.php.temp", $pUniPat, "$localApp/apires/contactForms/getFormList.php", $pLocPat, "$liveApp/apires/contactForms/getFormList.php",$pLivePat);
		CrossRender("adminTemplates/contactForms/getList.php.temp", $pUniPat, "$localApp/apires/contactForms/getList.php", $pLocPat, "$liveApp/apires/contactForms/getList.php",$pLivePat);
		CrossRender("adminTemplates/contactForms/getImage.php.temp", $pUniPat, "$localApp/apires/contactForms/getImage.php", $pLocPat, "$liveApp/apires/contactForms/getImage.php",$pLivePat);
		CrossRender("adminTemplates/contactForms/downloadImage.php.temp", $pUniPat, "$localApp/apires/contactForms/downloadImage.php", $pLocPat, "$liveApp/apires/contactForms/downloadImage.php",$pLivePat);
		CrossRender("adminTemplates/contactForms/archiveSubmission.php.temp", $pUniPat, "$localApp/apires/contactForms/archiveSubmission.php", $pLocPat, "$liveApp/apires/contactForms/archiveSubmission.php",$pLivePat);
		CrossRender("adminTemplates/contactForms/reopenSubmission.php.temp", $pUniPat, "$localApp/apires/contactForms/reopenSubmission.php", $pLocPat, "$liveApp/apires/contactForms/reopenSubmission.php",$pLivePat);

	}
	if($adminDat['adminNotificationManager']['include']){
		EnsureDirectory("$localApp/apires/adminNotifManager");
		EnsureDirectory("$liveApp/apires/adminNotifManager");
		
		CrossRender("adminTemplates/adminNotificationManager/emitNotification.php.temp", $pUniPat, "$localSec/admin/adminNotifManager/emitNotification.php", $pLocPat, "$liveSec/admin/adminNotifManager/emitNotification.php",$pLivePat);
		CrossRender("adminTemplates/adminNotificationManager/getUserConfig.php.temp", $pUniPat, "$localApp/apires/adminNotifManager/getUserConfig.php", $pLocPat, "$liveApp/apires/adminNotifManager/getUserConfig.php",$pLivePat);
		CrossRender("adminTemplates/adminNotificationManager/getUserList.php.temp", $pUniPat, "$localApp/apires/adminNotifManager/getUserList.php", $pLocPat, "$liveApp/apires/adminNotifManager/getUserList.php",$pLivePat);
		CrossRender("adminTemplates/adminNotificationManager/saveUserConfig.php.temp", $pUniPat, "$localApp/apires/adminNotifManager/saveUserConfig.php", $pLocPat, "$liveApp/apires/adminNotifManager/saveUserConfig.php",$pLivePat);
		
	}
	
	if($adminDat['blogs']){
		foreach($adminDat['blogs'] as $b)
		{
			//$fileName=preg_replace('/[^A-Za-z0-9]/','_',$b['title']);
			$fileName=$b['slug'];
			
			EnsureDirectory("$localApp/apires/blogs/$fileName");
			EnsureDirectory("$liveApp/apires/blogs/$fileName");
			
			$bpUniPat=$pUniPat;
			array_push($bpUniPat, [
				'`--Blog-Slug--`'=>$fileName,
				'`--Admin-BlogSlug--`'=>$fileName,
				'`--Blog-AbsolutePrefix--`'=>'`--AbsolutePrefix--`/`--Blog-Slug--`'
			]);
			
			$bpLivePat=$pLivePat;
			array_push($bpLivePat,[
				'`--Blog-RelativePathToLive--`'=>'$_SERVER[DOCUMENT_ROOT]/../'.$projectInfo['data']['top']['main']['livePubFolder']."/$b[slug]"
			]);
			
			$bpLocPat=$pLocPat;
			array_push($bpLocPat,[
				'`--Blog-RelativePathToLive--`'=>'$_SERVER[DOCUMENT_ROOT]/../htdocs/siteGenerator/v1/previews/'.$projectInfo['slug']."/$b[slug]"
			]);
			
			CrossRender("adminTemplates/blogs/basicLibrary.php.temp", $bpUniPat, "$localSec/blogs/basicLibrary.php", $bpLocPat, "$liveSec/blogs/basicLibrary.php",$bpLivePat);
			CrossRender("adminTemplates/blogs/perBlogLib.php.temp", $bpUniPat, "$localSec/blogs/$fileName/lib.php", $bpLocPat, "$liveSec/blogs/$fileName/lib.php",$bpLivePat);
			CrossRender("adminTemplates/blogs/libReplace.php.temp", $bpUniPat, "$localSec/blogs/$fileName/libReplace.php", $bpLocPat, "$liveSec/blogs/$fileName/libReplace.php",$bpLivePat);
			CrossRender("adminTemplates/blogs/adminLibrary.php.temp", $bpUniPat, "$localSec/blogs/$fileName/adminLibrary.php", $bpLocPat, "$liveSec/blogs/$fileName/adminLibrary.php",$bpLivePat);
			
			CrossRender("adminTemplates/blogs/saveArticleInfo.php.temp", $bpUniPat, "$localApp/apires/blogs/$fileName/saveArticleInfo.php", $bpLocPat, "$liveApp/apires/blogs/$fileName/saveArticleInfo.php",$bpLivePat);
			CrossRender("adminTemplates/blogs/getArticleInfo.php.temp", $bpUniPat, "$localApp/apires/blogs/$fileName/getArticleInfo.php", $bpLocPat, "$liveApp/apires/blogs/$fileName/getArticleInfo.php",$bpLivePat);
			CrossRender("adminTemplates/blogs/getArticleList.php.temp", $bpUniPat, "$localApp/apires/blogs/$fileName/getArticleList.php", $bpLocPat, "$liveApp/apires/blogs/$fileName/getArticleList.php",$bpLivePat);
			CrossRender("adminTemplates/blogs/deleteArticle.php.temp", $bpUniPat, "$localApp/apires/blogs/$fileName/deleteArticle.php", $bpLocPat, "$liveApp/apires/blogs/$fileName/deleteArticle.php",$bpLivePat);
			CrossRender("adminTemplates/blogs/publishArticle.php.temp", $bpUniPat, "$localApp/apires/blogs/$fileName/publishArticle.php", $bpLocPat, "$liveApp/apires/blogs/$fileName/publishArticle.php",$bpLivePat);
			CrossRender("adminTemplates/blogs/unpublishArticle.php.temp", $bpUniPat, "$localApp/apires/blogs/$fileName/unpublishArticle.php", $bpLocPat, "$liveApp/apires/blogs/$fileName/unpublishArticle.php",$bpLivePat);
			CrossRender("adminTemplates/blogs/sealUpload.php.temp", $bpUniPat, "$localApp/apires/blogs/$fileName/sealUpload.php", $bpLocPat, "$liveApp/apires/blogs/$fileName/sealUpload.php",$bpLivePat);
			CrossRender("adminTemplates/blogs/initMedia.php.temp", $bpUniPat, "$localApp/apires/blogs/$fileName/initMedia.php", $bpLocPat, "$liveApp/apires/blogs/$fileName/initMedia.php",$bpLivePat);
			CrossRender("adminTemplates/blogs/continueMedia.php.temp", $bpUniPat, "$localApp/apires/blogs/$fileName/continueMedia.php", $bpLocPat, "$liveApp/apires/blogs/$fileName/continueMedia.php",$bpLivePat);
			
			
			CrossRender("adminTemplates/blogs/adminPreview.php.temp", $bpUniPat, "$localApp/apires/blogs/$fileName/preview.php", $bpLocPat, "$liveApp/apires/blogs/$fileName/preview.php",$bpLivePat);
			CrossRender("adminTemplates/blogs/adminPreviewMedia.php.temp", $bpUniPat, "$localApp/apires/blogs/$fileName/previewMedia.php", $bpLocPat, "$liveApp/apires/blogs/$fileName/previewMedia.php",$bpLivePat);
			
			if($b['categorized']){
				CrossRender("adminTemplates/blogs/getCategoryList.php.temp", $bpUniPat, "$localApp/apires/blogs/$fileName/getCategoryList.php", $bpLocPat, "$liveApp/apires/blogs/$fileName/getCategoryList.php",$bpLivePat);
				CrossRender("adminTemplates/blogs/saveCategories.php.temp", $bpUniPat, "$localApp/apires/blogs/$fileName/saveCategories.php", $bpLocPat, "$liveApp/apires/blogs/$fileName/saveCategories.php",$bpLivePat);
			}
			
			copy("adminTemplates/blogs/initialize.php.temp", "$localApp/apires/initialize.php");
			
		}
	}
	
	
	file_put_contents("$localApp/app/.htaccess","
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [L]
	");	
	file_put_contents("$liveApp/app/.htaccess","
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [L]
	");
}

?>