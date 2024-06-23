<?php
require_once("../ajax/glutLibGrab.php");
require_once("../macroGlobalLib/lib.php");

function BasicInputFilter($inputVarName, $colName, $tempTpVarName, $def=null){
$ret="
	SET $inputVarName =JSON_UNQUOTE(JSON_EXTRACT(dat, '\$.$colName'));
";

if(!is_null($def)){
	$ret.="
IF $inputVarName IS NULL THEN SET $inputVarName=$def; END IF;
";
}

$ret.="SET $tempTpVarName=JSON_TYPE($inputVarName);
	IF $tempTpVarName = 'NULL' OR $inputVarName='' OR $inputVarName IS NULL THEN 
		SET $inputVarName=NULL;
	ELSEIF  $tempTpVarName = 'BOOLEAN' THEN
		SET $inputVarName=($inputVarName='true');
	END IF;
";
	return $ret;
}
function BasicOgFilter($inputVarName, $colName, $tempTpVarName){
$ret="
	SET $inputVarName =JSON_UNQUOTE(JSON_EXTRACT(dat, '\$.OGvalue.$colName'));
	SET $tempTpVarName=JSON_TYPE($inputVarName);
	IF $tempTpVarName = 'NULL' OR $inputVarName='' OR $inputVarName IS NULL THEN 
		SET $inputVarName=NULL;
	ELSEIF  $tempTpVarName = 'BOOLEAN' THEN
		SET $inputVarName=($inputVarName='true');
	END IF;
	
";
	return $ret;
}

function TblInputFilter(
		$tempJsonVarName,
		$colName, 
		$tempTpVarName, 
		$varCatcherName, 
		$ctName, 
		$localErrStringVarName
	){
	$ret="
		SET $tempJsonVarName=JSON_UNQUOTE(JSON_EXTRACT(dat, '\$.$colName'));
		SET $tempTpVarName=JSON_TYPE($tempJsonVarName);
		IF $tempJsonVarName IS NULL OR $tempTpVarName = 'NULL' OR $tempJsonVarName = '' THEN 
			SET $varCatcherName=NULL;
		ELSEIF IFNULL(@{$ctName}_RESOLVE_recDepth,0) < IFNULL(@{$ctName}_RESOLVE_recLimit,1) THEN
			CALL rmf.{$ctName}_RESOLVE($tempJsonVarName, $localErrStringVarName);
			IF $localErrStringVarName IS NOT NULL AND $localErrStringVarName != '' THEN 
				IF $localErrStringVarName = 'empty' THEN 
					SET $varCatcherName=NULL;
				ELSE 
					SET errString='$colName was not resolvable';
					LEAVE jumpOut;
				END IF;
			ELSE 
				SET $varCatcherName=JSON_EXTRACT($tempJsonVarName, '\$.pk');
			END IF;
		ELSE 
			SET $tempJsonVarName=JSON_EXTRACT($tempJsonVarName, '\$.pk');
			IF JSON_TYPE($tempJsonVarName) != 'NULL' AND $tempJsonVarName != '' AND $tempJsonVarName IS NOT NULL THEN 
				SET $varCatcherName=$tempJsonVarName;
			ELSE
				SET $varCatcherName=NULL;
			END IF;
		END IF;
		
	";
	
	return $ret;
}
function TblInputFilterRequired(
		$tempJsonVarName,
		$colName, 
		$tempTpVarName, 
		$varCatcherName, 
		$ctName, 
		$localErrStringVarName
	){
	$ret="
		SET $tempJsonVarName=JSON_UNQUOTE(JSON_EXTRACT(dat, '\$.$colName'));
		SET $tempTpVarName=JSON_TYPE($tempJsonVarName);
		IF $tempJsonVarName IS NULL OR $tempTpVarName = 'NULL' OR $tempjsonVarName = '' THEN 
			SET $varCatcherName=NULL;
		ELSEIF IFNULL(@{$ctName}_RESOLVE_recDepth,0) < IFNULL(@{$ctName}_RESOLVE_recLimit,1) THEN
			CALL rmf.{$ctName}_RESOLVE($tempJsonVarName, $localErrStringVarName);
			IF $localErrStringVarName IS NOT NULL AND $localErrStringVarName != '' THEN 
				
					SET errString=CONCAT('$colName was not resolvable: ', $localErrStringVarName);
					LEAVE jumpOut;
				
			ELSE 
				SET $varCatcherName=JSON_EXTRACT($tempJsonVarName, '\$.pk');
			END IF;
		ELSE 
			SET $tempJsonVarName=JSON_EXTRACT($tempJsonVarName, '\$.pk');
			IF JSON_TYPE($tempJsonVarName) != 'NULL' AND $tempJsonVarName != '' AND $tempJsonVarName IS NOT NULL THEN 
				SET $varCatcherName=$tempJsonVarName;
			ELSE
				SET $varCatcherName=NULL;
			END IF;
		END IF;
		
	";
	
	return ret;
}
function TblOgFilter($tempJsonVarName,$colName, $tempTpVarName, $varCatcherName, $ctName, $localErrStringVarName){
	$ret="
		SET $tempJsonVarName=JSON_UNQUOTE(JSON_EXTRACT(dat, '\$.OGvalue.$colName'));
		SET $tempTpVarName=JSON_TYPE($tempJsonVarName);
		IF $tempJsonVarName IS NULL OR $tempTpVarName = 'NULL' OR $tempJsonVarName = '' THEN 
			SET $varCatcherName=NULL;
		ELSE
			CALL rmf.{$ctName}_RESOLVE($tempJsonVarName, $localErrStringVarName);
			IF $localErrStringVarName IS NOT NULL AND $localErrStringVarName != '' THEN 
				IF $localErrStringVarName = 'empty' THEN 
					SET $varCatcherName=NULL;
				ELSE 
					SET errString='$colName was not resolvable';
					LEAVE jumpOut;
				END IF;
			ELSE 
				SET $varCatcherName=JSON_EXTRACT($tempJsonVarName, '\$.pk');
			END IF;
		END IF;
		
	";
	
	return $ret;
}

function BasicWhereColFilter($intermediaryVar, $varCatcherName, $colName, $whereColsName, $tempTpName, $foundAColumn){

	$ret="

		SET $intermediaryVar=JSON_UNQUOTE(JSON_EXTRACT(dat, '\$.$colName'));
		SET $tempTpName=JSON_TYPE($intermediaryVar);
		IF $tempTpName='NULL' OR $intermediaryVar IS NULL OR $intermediaryVar='' THEN 
			SET $whereColsName=CONCAT_WS(' AND ', $whereColsName, '($colName = ? OR 1)');
			SET $varCatcherName=$intermediaryVar;
		ELSEIF $tempTpName='BOOLEAN' THEN 
			SET $whereColsName=CONCAT_WS(' AND ', $whereColsName, '$colName=?');
			SET $varCatcherName=($intermediaryVar='true');
			---fac---
		ELSE 
			SET $whereColsName=CONCAT_WS(' AND ', $whereColsName, '$colName LIKE ?');
			SET $varCatcherName=CONCAT('%',$intermediaryVar,'%');
			---fac---
		END IF;
	";
	
	if($foundAColumn){
		$ret=str_replace('---fac---', "SET foundAColumn=1;", $ret);
	}else{
		$ret=str_replace('---fac---', "", $ret);
	}
	return $ret;
}

function BasicWhereColFilterStrict($intermediaryVar, $varCatcherName, $colName, $whereColsName, $tempTpName, $foundAColumn){

	$ret="

		SET $intermediaryVar=JSON_UNQUOTE(JSON_EXTRACT(dat, '\$.$colName'));
		SET $tempTpName=JSON_TYPE($intermediaryVar);
		IF $tempTpName='NULL' OR $intermediaryVar IS NULL OR $intermediaryVar='' THEN 
			SET $whereColsName=CONCAT_WS(' AND ', $whereColsName, '($colName = ? OR 1)');
			SET $varCatcherName=$intermediaryVar;
		ELSEIF $tempTpName='BOOLEAN' THEN 
			SET $whereColsName=CONCAT_WS(' AND ', $whereColsName, '$colName=?');
			SET $varCatcherName=($intermediaryVar='true');
			---fac---
		ELSEIF $tempTpName='DOUBLE' THEN 
			SET $whereColsName=CONCAT_WS(' AND ', $whereColsName, 'CONCAT($colName)=CONCAT(?)');
			SET $varCatcherName=$intermediaryVar;
			---fac---
		ELSE 
			SET $whereColsName=CONCAT_WS(' AND ', $whereColsName, '$colName=?');
			SET $varCatcherName=$intermediaryVar;
			---fac---
		END IF;
	";
	
	if($foundAColumn){
		$ret=str_replace('---fac---', "SET foundAColumn=1;", $ret);
	}else{
		$ret=str_replace('---fac---', "", $ret);
	}
	return $ret;
}

?>