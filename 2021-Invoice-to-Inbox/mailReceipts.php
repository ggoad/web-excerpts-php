<?php
chdir(__DIR__);
	require_once("ajaxOnlyLoggedIn.php");
	require_once("basicLibrary.php");
	require_once("../php_library/postVarSet.php");
	require_once('../php_library/obSane.php');
	
	require_once('receiptLib.php');
	require_once('emailUtility.php');
	
	require_once(__DIR__.'/RMF/lib.php');
	require_once(__DIR__."/RMF/TBL_emilioTool_receiptMailings/lib.php");
	require_once(__DIR__."/RMF/TBL_emilioTool_receiptMailings/validation.php");
	
	PostVarSet('dat',$dat);
	$dat=json_decode($dat,true);
	
	$sqlite=PrepSqlite('db.db');
	
	$producedEmail=calculateReceiptEmail($dat, true, $sqlite);
	
	$config=json_decode(file_get_contents("config.json"),true);
	
	$mailConfig=json_decode(file_get_contents('emailPass.json'),true);
	// send email here
	$company=[
		'fromEmail'=>$mailConfig['user'],
		'bcc'=>$mailConfig['cc']
	];
	
	
	//die(json_encode($dat));
	$mailId=SendEmail( $producedEmail['customer'],$company, $producedEmail['subject'], $producedEmail['body'], $producedEmail['attachments'], $dat['extraText']);
	
	foreach($dat['payments'] as $pmt)
	{
		$pmt=intval($pmt);
		
		$pmtStmt=$sqlite->prepare("SELECT * FROM payments WHERE pk=:pmt");
		$pmtStmt->bindParam(':pmt',$pmt, SQLITE3_INTEGER);
		$pmtResult=$pmtStmt->execute();
		$pmtInfo=$pmtResult->fetchArray(SQLITE3_ASSOC);
		
		$pmtInfo=json_encode($pmtInfo);
		
		$result=psAddemilioTool_receiptMailings([
			'payment'=>$pmt,
			'paymentSnapshot'=>$pmtInfo,
			'mailing'=>['pk'=>$mailId],
			'edited'=>'0'
		]);
		if($result !== "SUCCESS"){
			die("failed to add receitp mailing $result... $mailId");
		}
	}
	
	die("SUCCESS");

?>