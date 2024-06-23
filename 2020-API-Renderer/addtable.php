<?php 
require_once("glutLibGrab.php");

// global declarations
$success=true;
$undoSuccess=true;
$failStringCatcher="";
$undoFailStringCatcher="";

$sibKeysFromFile=[];
$sibKeysTodo=[];
$childKeysTodo=[];

$madeCols=[];
$madePKey=null;
$madeUKeys=[];
$madeFKeys=[];
$madeSibKeys=[];
$madeChildKeys=[];
$madeFuncts=[];
$madeProcs=[];
$madePhpFuncts=[];
$madeTables=[];
$madeType=null;



// parse POST data
PostVarSet('dat',$dat);
//die($dat);
//die($dat);

$dat=json_decode($dat, true);
//die(json_encode($dat));

ObVarSet($dat,'name', $name);

ObVarSet($dat,'db',$db);
RESOLVE_db($db, 'Could not resolve db');

$principleInfo=false;
$principleFiltered="NULL";
ObVarSet($dat, 'principleTable', $principleInfo, true);
if($principleInfo !== "" && $principleInfo){
   RESOLVE_tbl($principleInfo, "A principle table was indicated, but was unable to be resolved.");
   $principleFiltered=$principleInfo['pk'];
}

ObVarSet($dat,'customType',$customType);


//die(json_encode($_POST));

ObVarSet($dat,'columns',$cols);
ObVarSet($dat,'keys',$keys);
ObVarSet($dat,'procedures',$procs);
ObVarSet($dat,'functions',$functs);
ObVarSet($dat,'phpFuncts', $phpFuncts);
ObVarSet($dat,'childTables', $tables, true);

if(!$tables){
	$tables=[];
}
$tblData=['name'=>$name, 'db'=>$db];



//die(json_encode($_POST));



// make change


//
queryORerror(
	str_replace(
		["VA1", "VA2", "VA3"],
		[$db['name'], $name, $tableTrashColName ],
		"CREATE TABLE VA1.VA2(VA3 INT);"
	),
	"failed to create table $db[name].$name", $success, true,
	$failStringCatcher, "createTable"
);




queryORerror(
	str_replace(
		["VA1","VA2","VA3"],
		[sQuote($name), $db['pk'], $principleFiltered],
		"INSERT INTO tbls (name, db, principle_tbl) VALUES (VA1, VA2, VA3);"
	),
	"Failed logging table success",$success, true,
	$failStringCatcher, "logTable"
);



$tblid=null;
if($success){
	$tblid=mysqli_insert_id($sqlConn);
}






/*queryORexit("DROP TABLE ".$db['name'].".".$tblData['name'].";",'fail on drop');
queryORexit("DELETE FROM tbls WHERE pk=$tblid;",'fail on delete');
die();*/



$indKeeper=0;
foreach($cols as &$col)
{
	if($success){
	   $col['tbl']=$tblData;
	   $strm=postStream("http://localhost/_DATABASE_MANAGER_/v3/ajax/addcol.php",['dat'=>$col]);
	   if($strm !== "SUCCESS"){
		   $success=false;
		   $failStringCatcher="addCol";
		   echo "failed on add col $indKeeper:> $strm";
		   break;
	   }
		$resolveResult=RESOLVE_col($col);
		if(!$resolveResult){
			$success=false;
			$failStringCatcher="resolveCol";
			echo "failed on resolve col $indKeeper";
			break;
		}
		$indKeeper++;
		array_push($madeCols, GetReinstatementObject(true));
	}
}




$indKeeper=0;
foreach($keys as $key)
{
	if($success){
	   ExtractDynamicOnRadio($key, $key, $keyFO);
	   $keyFO['tbl']=$tblData;
	   $keyFO['type']=$key;
	   
	   if($key === "child"){
		  array_push($childKeysTodo, $keyFO);
		  continue;
	   }
	   if($key === "sib"){
		   array_push($sibKeysTodo, $keyFO);
		   continue;
	   }
	   
	   $strm=postStream("http://localhost/_DATABASE_MANAGER_/v3/ajax/addkey.php",['dat'=>$keyFO]);
	   if($strm !== "SUCCESS"){
		   $success=false;
		   $failStringCatcher="addKey";
		   echo "failed to add key $indKeeper:> $strm";
		   break;
	   }
	   
		switch($keyFO['type']){
			case "primary":
				$madePKey=GetReinstatementObject(true);
				break;
			case "local":
			case "par":
			case "sib":
			case "child":
			case "foreign":
				array_push($madeFKeys, GetReinstatementObject(true));
				break;
			case "unique":
				array_push($madeUKeys, GetReinstatementObject(true));
				break;
			default:
			
				break;
		}
	}
	$indKeeper++;
}


if($customType && $success){
   $customType['tbl']=$tblData;
	$strm=postStream(
		"http://localhost/_DATABASE_MANAGER_/v3/ajax/addtype_tableReference.php",
		['dat'=>array_merge(
			$customType,
			["tableReference"=>["pk"=>$tblid]]
		)]
	);
   if($strm !== "SUCCESS"){
	   $success=false;
	   $failStringCatcher="addCustomType";
		echo("An error creating  custom type occored. $strm ;;;; ");
   }
}

if($success && $customType){
	$madeType=GetReinstatementObject(true);
}



$indKeeper=0;
foreach($functs as $funct)
{
	if($success){
	   $funct['tbl']=$tblData;
	   $funct['db']=$db;
	   $strm=postStream("http://localhost/_DATABASE_MANAGER_/v3/ajax/addfunct.php",['dat'=>$funct]);
	   if($strm !== "SUCCESS"){
		   $success=false;
		   $failStringCatcher="addFunct";
		  echo("An error occured creating funct $indKeeper -> $strm ;;;; ");
		  break;
	   }
	   $resolveResult=RESOLVE_funct($funct, '', true);
	   if(!$resolveResult){
		   $success=false;
		   $failStringCatcher="'resolveFunct";
		   echo "failed to resolve table $indKeeper ;;;; ";
		   break;
	   }
	   $indKeeper++;
	   array_push($madeFuncts, GetReinstatementObject(true));
	}
}



$indKeeper=0;
foreach($procs as $proc)
{
	if($success){
	   $proc['tbl']=$tblData;
	   $proc['db']=$db;
	   $strm=postStream("http://localhost/_DATABASE_MANAGER_/v3/ajax/addproc.php",['dat'=>$proc]);
	   if($strm !== "SUCCESS"){
		   $success=false;
		   $failStringCatcher="addProc";
		  echo("An error occured creating proc $indKeeper->$strm ;;;; " );
		  break;
	   }
	   $resolveResult=RESOLVE_proc($proc, '', true);
	   if(!$resolveResult){
		   $success=false;
		   $failStringCatcher="resolveProc";
		   echo "failed to resolve the proc $indKeeper ;;; ";
		   break;
	   }
	   array_push($madeProcs, GetReinstatementObject(true));
	}
   $indKeeper++;
}




$indKeeper=0;
foreach($phpFuncts as $pf)
{
	if($success){
		$pf['tblref']=$tblData;
		$strm=postStream(
			"http://localhost/_DATABASE_MANAGER_/v3/ajax/addPhpFunct.php",
			['dat'=>$pf]
		);
	   if($strm !== "SUCCESS"){
		   $success=false;
		   $failStringCatcher="addPhpFunct";
		  echo("An error occured creating phpFunct $indKeeper:>  $strm ;;; ");
		  break;
	   }
	   $resolveResult=RESOLVE_phpFunct($pf, '', true);
	   if(!$resolveResult){
		   $success=false;
		   $failStringCatcher="resolvePhpFunct";
		  echo("An error occured resolving php funct $indKeeper:> ;;; ");
		  break;
	   }
	   array_push($madePhpFuncts, GetReinstatementObject(true));
	}
	$indKeeper++;
}

/*// find debug
if($success){
	$success=false;
	echo "debug after addPhpFunct";
	$failStringCatcher="addChildTable";
}*/

$childTablesFound=false;
$indKeeper=0;
foreach($tables as $table)
{
	$childTablesFound=true;
	if($success){
		$table['db']=$db;
		$table['principleTable']=['pk'=>$tblid];
	   $strm=postStream("http://localhost/_DATABASE_MANAGER_/v3/ajax/addtable.php",['dat'=>$table]);
	   if($strm !== "SUCCESS"){
		   $success=false;
		   $failStringCatcher="addChildTable";
		  echo("An error occured creating table $indKeeper:>  $strm ;;; ");
		  break;
	   }
	   $resolveResult=RESOLVE_tbl($table, '');
	   if(!$resolveResult){
		   $success=false;
		   $failStringCatcher="resolveChildTable";
		  echo("An error occured resolving table $indKeeper:> ;;; ");
		  break;
	   }
	   array_push($madeTables, GetReinstatementObject(true));
	   $sibKeysFromFile= array_merge($sibKeysFromFile, GET_sibFile());
	}
	$indKeeper++;
}

$indKeeper=0;
if($childTablesFound && count($sibKeysFromFile)){
	foreach($sibKeysFromFile as $sibKey)
	{
		if($success){
			$strm=postStream("http://localhost/_DATABASE_MANAGER_/v3/ajax/addkey.php",['dat'=>$sibKey]);
			if($strm !== "SUCCESS"){
			   $success=false;
			   $failStringCatcher="addSibKey";
			   echo "failed to add sib key $indKeeper:> $strm";
			   break;
			}
			
			array_push($madeSibKeys, GetReinstatementObject(true));
		}
		$indKeeper++;
	}
}

$indKeeper=0;
foreach($childKeysTodo as $childKey)
{
	if($success){
		$strm=postStream("http://localhost/_DATABASE_MANAGER_/v3/ajax/addkey.php",['dat'=>$childKey]);
		if($strm !== "SUCCESS"){
		   $success=false;
		   $failStringCatcher="addChildKey";
		   echo "failed to add child key $indKeeper:> $strm";
		   break;
		}
		
		array_push($madeChildKeys, GetReinstatementObject(true));
	}
	$indKeeper++;
}



// check for success
if($success){
	if(!$childTablesFound && count($sibKeysTodo)){
		WRITE_sibFile($sibKeysTodo);
	}
	WriteReinstatementObject([
		'tbl'=>['pk'=>$tblid],
		'action'=>'drop'
	]);
	dbSoftExit("SUCCESS");
}

// failure detected, attempt to undo
switch($failStringCatcher){
	case "all":
	case "addChildKey":
		foreach($madeChildKeys as $mci)
		{
			if($undoSuccess){
				$strm=Reinstate($mci, "fkey");
				if($strm !== "SUCCESS"){
					$undoSuccess=false;
					$undoFailStringCatcher="undoCreateChildKey";
					echo "failed to undo create child key:> $strm ;;; ";
					break;
				}
				
			}
		}
	case "addSibKey":
		foreach($madeSibKeys as $msk)
		{
			if($undoSuccess){
				$strm=Reinstate($msk, "fkey");
				if($strm !== "SUCCESS"){
					$undoSuccess=false;
					$undoFailStringCatcher="udnoCreateSibKey";
					echo "failed to undo create sib key:> $strm ;;; ";
					break;
				}
				
			}
		}
	case "resolveChildTable":
	case "addChildTable":
		foreach($madeTables as $table)
		{
			if($undoSuccess){
				$strm=Reinstate($table, "table");
				if($strm !== "SUCCESS"){
					$undoSuccess=false;
					$undoFailStringCatcher="removeChildTable";
					echo "failed to remove childTable:> $strm ;;; ";
					break;
				}
				
			}
		}
		
	case "resolvePhpFunct":
	case "addPhpFunct":
		foreach($madePhpFuncts as $phpFunct)
		{
			if($undoSuccess){
				$strm=Reinstate($phpFunct, "PhpFunct");
				if($strm !== "SUCCESS"){
					$undoSuccess=false;
					$undoFailStringCatcher="removePhpFunct";
					echo "failed to remove phpFunct:> $strm ;;; ";
					break;
				}
			}
		}
	case "resolveProc":
	case "addProc":
		foreach($madeProcs as $proc)
		{
			if($undoSuccess){
				$strm=Reinstate($proc, "proc");
				if($strm !== "SUCCESS"){
					$undoSuccess=false;
					$undoFailStringCatcher="removeProc";
					echo "failed to remove proc:> $strm ;;; ";
					break;
				}
				
			}
		}
	case "resolveFunct":
	case "addFunct":
		foreach($madeFuncts as $funct)
		{
			if($undoSuccess){
				$strm=Reinstate($funct, "funct");
				if($strm !== "SUCCESS"){
					$undoSuccess=false;
					$undoFailStringCatcher="removeFunct";
					echo "failed to remove funct:> $strm ;;; ";
					break;
				}
				
			}
		}
		// drop custom type
		if($undoSuccess && $madeType){
			$strm=Reinstate($madeType, "type");
			if($strm !== "SUCCESS"){
				$undoSuccess=false;
				$undoFailStringCatcher="undoCreateType :: $strm";
				echo "failed to undo make custom type";
			}
		}
	case "addCustomType":
	case "addKey":
		foreach($madeFKeys as $fkey)
		{
			if($undoSuccess){
				$strm=Reinstate($fkey, "fkey");
				if($strm !== "SUCCESS"){
					$undoSuccess=false;
					$undoFailStringCatcher="removeFkey";
					echo "failed to remove fkey:> $strm ;;; ";
					break;
				}
			}
		}
		foreach($madeUKeys as $ukey)
		{
			if($undoSuccess){
				$strm=Reinstate($ukey, "ukey");
				if($strm !== "SUCCESS"){
					$undoSuccess=false;
					$undoFailStringCatcher="removeUkey";
					echo "failed to remove ukey:> $strm ;;; ";
					break;
				}
				
			}
		}
		if($madePKey && $undoSuccess){
			$strm=Reinstate($madePKey, "pkey");
			
			if($strm !== "SUCCESS"){
				$undoSuccess=false;
				$undoFailStringCatcher="removePkey";
				echo "failed to remove pkey :> $strm ;;;; ";
				break;
			}
		}
	case "resolveCol":
	case "addCol":
		foreach($madeCols as $col)
		{
			if($undoSuccess){
				$strm=Reinstate($col, "col");
				if($strm !== "SUCCESS"){
					$undoSuccess=false;
					$undoFailStringCatcher="removeCol";
					echo "failed to remove col :> $strm ;;;";
					break;
				}
			}
		}
		queryORerror(
			"DELETE FROM tbls WHERE pk=$tblid",
			"failed to undo log table",$undoSuccess,true,
			$undoFailStringCatcher, "undoLogTable"
		);
	case "logTable":
		queryORerror(
			"DROP TABLE $db[name].$name;",
			"failed to undo create table",$undoSuccess, true,
			$undoFailStringCatcher, "undoCreateTable"
		);
	case "createTable":
		if(is_file($sibFile)){
			unlink($sibFile);
		}
	case "":
		break;
	default:
		echo "an unknown failstring was given: $failStringCatcher";
		break;
}

$undoString="failed to undo $undoFailStringCatcher";
if($undoSuccess){
	$undoString="undo successful";
}
dbSoftExit("Error: $failStringCatcher. Tried to undo:> $undoString");
?>