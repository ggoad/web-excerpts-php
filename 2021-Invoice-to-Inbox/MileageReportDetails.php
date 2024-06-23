<?php 
chdir(__DIR__);
	require_once("ajaxOnlyLoggedIn.php");
	require_once("basicLibrary.php");
	require_once("../php_library/postVarSet.php");
	require_once("../php_library/sQuote.php");
	require_once('../php_library/obSane.php');
	
	require_once("timeRelatedFrameCalculation.php");

	PostVarSet("reportFrame", $reportFrame);
	
	function byCustomerFrame(&$lowerDate, &$upperDate){
		global $sqlite;
		PostVarSet('reportFrameDetails', $customerPk);
		$customerPk=intval($customerPk);
		
		$ret=[];
		$result=$sqlite->query("
			SELECT 
				me.*,
				cst.name||': '||jb.jobName forName,
				vv.name vehicleName,
				CASE 
				WHEN me.staticMiles = 0 OR me.staticMiles IS NULL 
				THEN me.endingMiles-me.beginningMiles 
				ELSE me.staticMiles
				END actualMiles
			FROM mileageEntry me 
			LEFT JOIN jobs jb
				ON jb.pk=me.job
			LEFT JOIN customers cst 
				ON cst.pk= jb.customer
			LEFT JOIN vehicles vv
				ON vv.pk=me.vehicle
			WHERE cst.pk=$customerPk;
		");
		while($row = $result->fetchArray(SQLITE3_ASSOC))
		{
			array_push($ret, $row);
		}
		die(json_encode($ret));
	}
	
	function byJobFrame(&$lowerDate, &$upperDate){
		global $sqlite;
		PostVarSet('reportFrameDetails', $jobPk);
		$jobPk=intval($jobPk);
		
		$ret=[];
		$result=$sqlite->query("
			SELECT 
				me.*,
				cst.name||': '||jb.jobName forName,
				vv.name vehicleName,
				CASE 
				WHEN me.staticMiles = 0 OR me.staticMiles IS NULL 
				THEN me.endingMiles-me.beginningMiles 
				ELSE me.staticMiles
				END actualMiles
			FROM mileageEntry me 
			LEFT JOIN jobs jb
				ON jb.pk=me.job
			LEFT JOIN customers cst 
				ON cst.pk= jb.customer
			LEFT JOIN vehicles vv
				ON vv.pk=me.vehicle
			WHERE jb.pk=$jobPk;
		");
		while($row = $result->fetchArray(SQLITE3_ASSOC))
		{
			array_push($ret, $row);
		}
		die(json_encode($ret));
		
	}

	if(!function_exists("${reportFrame}Frame")){
		die('bad frame '.$reportFrame);
	}
	
	$sqlite=PrepSqlite('db.db');
	
	("{$reportFrame}Frame")($lowerDate, $upperDate);
	
	$lowerDate=sQuote($lowerDate);
	$upperDate=sQuote($upperDate);
	
	$result=$sqlite->query("
		SELECT 
			me.*,
			cst.name||': '||jb.jobName forName,
			vv.name vehicleName,
			CASE
			WHEN me.staticMiles = 0 OR me.staticMiles IS NULL 
			THEN me.endingMiles-me.beginningMiles 
			ELSE me.staticMiles
			END actualMiles
		FROM mileageEntry me 
		LEFT JOIN jobs jb
			ON jb.pk=me.job
		LEFT JOIN customers cst 
			ON cst.pk= jb.customer
		LEFT JOIN vehicles vv
			ON vv.pk=me.vehicle
		WHERE 
			SUBSTR(me.mileageDate,1,10) >= $lowerDate 
			AND SUBSTR(me.mileageDate,1,10) <= $upperDate	
	");
	
	$ret=[];
	while($row=$result->fetchArray(SQLITE3_ASSOC))
	{
		
		array_push($ret, $row);
	}
	
	die(json_encode($ret));
	
?>