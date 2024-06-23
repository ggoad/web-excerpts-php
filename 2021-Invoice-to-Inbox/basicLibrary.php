<?php
	require_once(__DIR__.'/../php_library/obSane.php');
	require_once(__DIR__.'/../php_library/sQuote.php');
	
	function PrepSqlite($filename){
		$sqlite=new SQLite3($filename);
		$sqlite->exec('PRAGMA foreign_keys = ON;');
		//error_reporting(E_ALL ^ E_WARNING); 
		return $sqlite;
	}
	
	function emilioDateEdit($date){
		$months=[
			"01"=>"Jan",
			"02"=>"Feb",
			"03"=>"Mar",
			"04"=>"Apr",
			"05"=>"May",
			"06"=>"Jun",
			"07"=>"Jul",
			"08"=>"Aug",
			"09"=>"Sep",
			"10"=>"Oct",
			"11"=>"Nov",
			"12"=>"Dec"
		];
		
		$spl=explode('-',$date);
		return $months[$spl[1]]." $spl[2], $spl[0]";
	}
	function emilioDateEditEs($date){
		$months=[
			"01"=>"Ene",
			"02"=>"Feb",
			"03"=>"Mar",
			"04"=>"Abr",
			"05"=>"May",
			"06"=>"Jun",
			"07"=>"Jul",
			"08"=>"Ago",
			"09"=>"Sep",
			"10"=>"Oct",
			"11"=>"Nov",
			"12"=>"Dic"
		];
		
		$spl=explode('-',$date);
		return $months[$spl[1]]." $spl[2], $spl[0]";
	}
	function DateToSpanish($dt){
		return str_replace(
			['January','February','March','April','May', 'June', 'July', 'August','September', 'October','November', 'December'],
			['Enero',  'Febrero' ,'Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Deciembre'],
			$dt);
	}
	function invoicePdfFilename($jobName, $dateContext, $pk){
		$ret= "$jobName-$dateContext-($pk)";
		
		$ret=str_replace([
			'\\','/','*','?','%','$','.','>','<','\'','"',':',',','|'
		],['_'],$ret);
		return $ret.".pdf";
	}
	function EmilioAddOrEdit(&$ob, $add, $edit, &$result){
		
		if(SetAndNotEmpty($ob,'pk')){
			//die('edit');
			$ob['OGvalue']=['pk'=>$ob['pk']];
			$re=$edit($ob);
			$result="$re : edit";
		}else{
			//die('add');
			$re= $add($ob);
			$result="$re : add";
			//$resolveFunct($ob, $ret);
			
		}
		if($re === "SUCCESS"){
			
			return 1;
		}return 0;
	}
	function EmilioQuoteArray($lm){
		return sQuote($lm);
	}
	function EmilioLineItemRegulate($list, $job){
		global $sqlite;
		$job=intval($job);
		if(count($list)){
			$list=implode(',', array_map('EmilioQuoteArray',$list));
			$sqlite->query("
				DELETE
				FROM lineItems 
				WHERE pk IN(
					SELECT li.pk
					FROM lineItems li 
					LEFT JOIN issuedInvoices issInv
						ON issInv.invoice=li.invoice
					WHERE issInv.pk IS NOT NULL
				)
					AND job=$job
					AND pk NOT IN($list);
			");
		}else{
			$sqlite->query("
				DELETE
				FROM lineItems 
				WHERE pk IN(
					SELECT li.pk
					FROM lineItems li 
					LEFT JOIN issuedInvoices issInv
						ON issInv.invoice=li.invoice
					WHERE issInv.pk IS NOT NULL
				)
					AND job=$job;
			");
		}
	}

	function EmilioRegulate($tableName, $list, $extraVerification){
		global $sqlite;
		
		if(count($list)){
			$list=implode(',', array_map('EmilioQuoteArray',$list));
		//echo("DELETE FROM $tableName WHERE pk NOT IN($list) AND $extraVerification;");
			$sqlite->query("DELETE FROM $tableName WHERE pk NOT IN($list) AND $extraVerification;");
		}else{
			EmilioFullRegulate($tableName, $extraVerification);
		}
		
		
	}
	function EmilioFullRegulate($tableName, $verification){
		global $sqlite;
		$sqlite->query("DELETE FROM $tableName WHERE $verification;");
	}
	
	function EmilioPluralSwitch($count, $single, $plural){
		if(intval($count) === 1){
			return $single;
		}return $plural;
	}
	function EmilioSoftSwitch($softOrReal, $soft, $real){
		if($softOrReal){
			return $real;
		}return $soft;
	}
	function dateTimeToReadable($dt){
		$temptime=strtotime($dt);
		$dt=date("F d, Y : g:ia", $temptime);
		return $dt;
	}
	function dateTimeToReadableEs($dt){
		return str_replace(
			['January','February','March','April','May', 'June', 'July', 'August','September', 'October','November', 'December'],
			['Enero',  'Febrero' ,'Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Deciembre'],
			dateTimeToReadable($dt)
		);
	}
	function dateToReadable($dt){
		$temptime=strtotime($dt);
		$dt=date("F d, Y", $temptime);
		return $dt;
	}
	function getCustomerRunningBalance($customerPk, $chargeType, $chargePk){
		$customerPk=intval($customerPk);
		$sqlite=new SQLite3('db.db');
	
		$ret=[];
		$result=$sqlite->query("
		SELECT DISTINCT dt.transactionType, dt.jobName, dt.transDate,dt.transDateTime, dt.amount, dt.invoicePk, dt.paymentPk, dt.pk
		FROM customers cst
		JOIN (
			SELECT 
				'' invoicePk,
				'payment' transactionType,
				'' jobName,
				pmt.paymentDate transDate,
				pmt.paymentDateTime transDateTime,
				pmt.amount amount,
				pmt.pk paymentPk,
				pmt.pk pk
				
			FROM payments pmt 
			WHERE pmt.customer=$customerPk
			GROUP BY pmt.pk
			
			UNION 
			SELECT 
				inv.pk invoicePk,
				'invoice' transactionType ,
				jb.jobName jobName,
				issInv.issueDate transDate,
				issInv.issueDateTime transDateTime,
				ROUND(IFNULL(SUM(IFNULL(li.overrideAmount/lisCount.cnt, lis.minutes*inv.hourlyRate/60)),0),2) amount,
				'' paymentPk,
				inv.pk pk
				
			FROM invoices inv 
			JOIN issuedInvoices issInv 
				ON inv.pk=issInv.invoice
			JOIN lineItems li 
				ON li.invoice=inv.pk
			LEFT JOIN lineItemSplits lis
				ON lis.lineItem=li.pk
			JOIN jobs jb 
				ON jb.pk=inv.job 
			JOIN customers cst 
				ON jb.customer=cst.pk 
			LEFT JOIN (
				SELECT MAX(COUNT(lis.pk),1) cnt,
				inv.pk ininv
				FROM customers cst 
					   
					   JOIN jobs jbs 
						 ON jbs.customer=cst.pk
					   JOIN invoices inv
						 ON inv.job=jbs.pk
					   JOIN issuedInvoices issInv
						 ON issInv.invoice=inv.pk
					   JOIN lineItems li 
						 ON li.invoice=inv.pk
					   LEFT JOIN lineItemSplits lis
						 ON lis.lineItem=li.pk
						 WHERE cst.pk=$customerPk
						 GROUP BY inv.pk
			) AS lisCount
			ON inv.pk = lisCount.ininv
			WHERE cst.pk=$customerPk
			GROUP BY inv.pk
		) AS dt
		ORDER BY dt.transDateTime 
		");
		
		$bal=0;
		
		while($row=$result->fetchArray(SQLITE3_ASSOC))
		{
			if($row['transactionType'] === 'invoice'){
				$bal+=$row['amount'];
			}else if($row['transactionType']=== 'payment'){
				$bal-=$row['amount'];
			}else{
				die("unknown transaction type $row[transactionType]");
			}
			if($row['transactionType']===$chargeType && $row['pk'] === $chargePk){
				break;
			}
			//die(json_encode($row));
		}
		return $bal;
	}
	function getCustomerBalance($customerPk){
		global $sqlite;
		$needsReset=false;
		if(!$sqlite){
			$sqlite=PrepSqlite('db.db');
		}
		$customerPk=intval($customerPk);
		$res=$sqlite->query("
				SELECT 
                     ROUND( 
                     IFNULL(SUM( IFNULL( 
                         li.overrideAmount/lisCount.cnt,
                         lis.minutes*inv.hourlyRate/60)
                     ), 0) - IFNULL(pmtSub.amount,0),2) bal
                   FROM customers cst 
                   
                   JOIN jobs jbs 
                     ON jbs.customer=cst.pk
                   JOIN invoices inv
                     ON inv.job=jbs.pk
                   JOIN issuedInvoices issInv
                     ON issInv.invoice=inv.pk
                   JOIN lineItems li 
                     ON li.invoice=inv.pk
                   LEFT JOIN lineItemSplits lis
                     ON lis.lineItem=li.pk
   LEFT JOIN (
      SELECT IFNULL(SUM(amount),0) amount FROM payments WHERE customer=$customerPk GROUP BY customer
   ) AS pmtSub
   LEFT JOIN (
		SELECT MAX(COUNT(lis.pk),1) cnt ,
		inv.pk ininv
		FROM customers cst 
                   
                   JOIN jobs jbs 
                     ON jbs.customer=cst.pk
                   JOIN invoices inv
                     ON inv.job=jbs.pk
                   JOIN issuedInvoices issInv
                     ON issInv.invoice=inv.pk
                   JOIN lineItems li 
                     ON li.invoice=inv.pk
                   LEFT JOIN lineItemSplits lis
                     ON lis.lineItem=li.pk
		WHERE cst.pk = $customerPk
						 GROUP BY inv.pk
			) AS lisCount
			ON inv.pk = lisCount.ininv
                     WHERE cst.pk=$customerPk

		");
		
		if(!$row=$res->fetchArray(SQLITE3_ASSOC)){
			if($needsReset){$sqlite->close();}
			return 0;
		}
		
		if($needsReset){$sqlite->close();}
		
		return $row['bal'];
	}

?>