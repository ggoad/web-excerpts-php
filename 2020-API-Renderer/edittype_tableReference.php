<?php
if(!isset($type)){
	die("please call edittype.php instead. ");
}

// global declarations

$success=true;
$undoSuccess=true;
$failStringCatcher="";
$undoFailStringCatcher="";

// parse POST data
//die(json_encode($type));
//die(json_encode($dat));
ObVarSet($dat, 'tableReference', $tbl);
RESOLVE_tbl($tbl, 'Could not resolve table.');

RESOLVE_tbl($type['tableRef'],"couldn't resolve type table");
$type['tbl']=$type['tableRef'];


//die(json_encode($tbl));
$oldTypeName="TBL_".$tbl['db']['name']."_".$tbl['name'];
$newTypeName=$type['name'];

ObVarSet($dat, "js", $js);
      ObVarSet($js, "rmfdefault", $rmfdefault, true);
       sQuoteR($rmfdefault);
      ObVarSet($js, "rmfspecials", $rmfspecials, true);
       sQuoteR($rmfspecials);
      ObVarSet($js, "coll", $coll, true);
       sQuoteR($coll);
      ObVarSet($js, "set", $set, true);
       sQuoteR($set);
      ObVarSet($js, "bodyFunction", $bodyFunction, true);
       sQuoteR($bodyFunction);
      $labelType="'section'";

      ObVarSet($js, "cardFunction", $cardFunction, true);
       sQuoteR($cardFunction);
      ObVarSet($js, "valueFunction", $valueFunction, true);
       sQuoteR($valueFunction);

      

      ObVarSet($dat, "php", $php);
      ObVarSet($php, "validation",$phpValidation, true);
       if($phpValidation === ""){$phpValidation="return true;";}
       $phpValidationRaw=$phpValidation;
       sQuoteR($phpValidation);
      ObVarSet($php, "filter", $phpFilter, true);
       $phpFilterRaw=$phpFilter;
       sQuoteR($phpFilter);

      ObVarSet($dat, "mySQL", $mysql);

      $result=queryORexit(str_replace(["VA1"],
                              [$tbl['pk']],
                              'SELECT tmi.nativeType
                               FROM pkeys pks
                               JOIN pkeyrefs pkrs ON pkrs.pkey=pks.pk
                               JOIN cols cc ON pkrs.col = cc.pk
                               JOIN custom_types ct ON ct.pk = cc.type
                               JOIN type_mysql_info tmi ON tmi.typeref=ct.pk
                               WHERE pks.tbl=VA1'),
      "failed on query to get the type list of the reference from the primary key");

      if(!($row=mysqli_fetch_row($result))){
         dbSoftExit("empty result getting type from pk");
      }
      $nativeType=sQuote($row[0]);


      ObVarSet($mysql,"validation", $mysqlValidation,true);
		if(!$mysqlValidation){
		   $mysqlValidation="SET outResult= 1;";
		}
	   $mysqlValidationRaw=$mysqlValidation;
	   
       sQuoteR($mysqlValidation);
      ObVarSet($mysql, "filter", $mysqlFilter,true);
	   $mysqlFilterRaw=$mysqlFilter;
       sQuoteR($mysqlFilter);


$newTypeDirectory=$_SERVER['DOCUMENT_ROOT']."/RMF/$newTypeName";
$oldTypeDirectory=$_SERVER['DOCUMENT_ROOT']."/RMF/$oldTypeName";
$actionFile="$oldTypeDirectory/action.php";
$actionListFile="$oldTypeDirectory/actions.json";
$typeValidationFile="$oldTypeDirectory/validation.php";

$typeMetaFile="$oldTypeDirectory/metaData.json";
$newTypeMetaFile="$newTypeDirectory/metaData.json";

$snapShot['type']=$type;
$snapShot['directory']=[];
$snapShot['directory']['action.php']=file_get_contents($actionFile);
$snapShot['directory']['actions.json']=file_get_contents($actionListFile);
$snapShot['directory']['validation.php']=file_get_contents($typeValidationFile);
$snapShot['directory']['metaData.json']=file_get_contents($typeMetaFile);
$snapShot['directory']['lib.php']=file_get_contents("$oldTypeDirectory/lib.php");

$snapShot['sql']=json_decode($snapShot['directory']['metaData.json'], true);

$tempActions=json_decode($snapShot["directory"]['actions.json'], true);
$savedActions=[];
foreach($tempActions as $ta)
{
	$tmp=file_get_contents("$oldTypeDirectory/{$ta}.php");
	$savedActions[$ta] =$tmp;
	$snapShot['directory']["{$ta}.php"]=$tmp;
}


// update SQL functions
// drop first
//  procs
queryORerror(
	"DROP FUNCTION IF EXISTS rmf.{$oldTypeName}_RESOLVEFUNCT;",
	"failed on drop resolve",$success,true,
	$failStringCatcher, "dropResolveFunct"
);
queryORerror(
	"DROP PROCEDURE IF EXISTS rmf.{$oldTypeName}_RESOLVE;",
	"failed on drop resolve",$success,true,
	$failStringCatcher, "dropResolve"
);
// EXTRAFILTER, 
queryORerror(
	"DROP PROCEDURE IF EXISTS rmf.{$oldTypeName}_EXTRAFILTER;",
	"failed on drop extra filter",$success,true,
	$failStringCatcher, "dropExtraFilter"
);



// FILTER, FILTER_JSON, FILTER_JSON_IND 
queryORerror(
	"DROP PROCEDURE IF EXISTS rmf.{$oldTypeName}_FILTER;",
	"failed on drop filter",$success,true,
	$failStringCatcher, "dropFilter"
);


// FILTERVALIDATE, FILTERVALIDATE_JSON, FILTERVALIDATE_JSON_IND
// 
queryORerror(
	"DROP PROCEDURE IF EXISTS rmf.{$oldTypeName}_FILTERVALIDATE;",
	"failed on drop filter validate",$success,true,
	$failStringCatcher, "dropFilterValidate"
);





// functs 
// EXTRAVALIDATE

queryORerror(
	"DROP PROCEDURE IF EXISTS rmf.{$oldTypeName}_EXTRAVALIDATE;",
	"failed on drop extra validate",$success,true,
	$failStringCatcher, "dropExtraValidate"
);


// VALIDATE, VALIDATE_JSON, VALIDATE_JSON_IND 
//
queryORerror(
	"DROP PROCEDURE IF EXISTS rmf.{$oldTypeName}_VALIDATE;",
	"failed on drop validate",$success,true,
	$failStringCatcher, "dropValidate"
);


// make new
CreateTableReferenceRmfMysql($newTypeName,$tbl,$mysqlFilterRaw,$mysqlValidationRaw, $success, $failStringCatcher);

// update php directories
//





if($success){
	if(!DeleteDirectory($oldTypeDirectory)){
		$success=false;
		echo "failed on delete directory ";
		$failStringCatcher="deleteDirectory";
	}
}



CreateTableReferenceRmfPhp($newTypeName, $tbl,$phpValidationRaw, $phpFilterRaw, $success, $failStringCatcher);

file_put_contents("$newTypeDirectory/actions.json", $snapShot['directory']['actions.json']);
file_put_contents("$newTypeDirectory/lib.php", $snapShot['directory']['lib.php']);
foreach($savedActions as $a=>$fileContents)
{
	file_put_contents("$newTypeDirectory/$a.php", $fileContents);
}

// update custom_types 

queryORerror(
	str_replace(
		["VA1","VA2"],
		[sQuote($newTypeName), $type['pk']],
		"UPDATE custom_types 
		SET 
			name=VA1
		WHERE pk=VA2;"
	),"failed to update custom type talbe",$success,true,
	$failStringCatcher, "updateCustomType"
);

queryORerror(
	str_replace(
		["VA1","VA2","VA3","VA4","VA5","VA6","VA7","VA8"],
		[
			$rmfdefault, 
			$rmfspecials,
			$coll,
			$set,   
			$bodyFunction,
			$labelType,
			$cardFunction,
			$valueFunction
		],
		"UPDATE type_js_info
		SET 
			rmfdefault=VA1,
			rmfspecials=VA2,
			coll=VA3,
			setter=VA4,
			bodyFunction=VA5,
			labelType=VA6,
			cardFunction=VA7,
			valueFunction=VA8
		WHERE typeref = $type[pk]"
	),
	"failed on update js_info",$success,true,
	$failStringCatcher, "updateJsInfo"
);
queryORerror(
	str_replace(
		["VA1","VA2"],
		[
			$phpFilter, $phpValidation
		],
		"UPDATE type_php_info
		SET 
			filter=VA1,
			validation=VA2
		WHERE typeref = $type[pk]"
	),
	"failed on update php_info",$success,true,
	$failStringCatcher, "updatePhpInfo"
);

queryORerror(
	str_replace(
		["VA1","VA2","VA3"],
		[
			$nativeType, $mysqlValidation, $mysqlFilter
		],
		"UPDATE type_mysql_info
		SET 
			nativeType=VA1,
			validation=VA2,
			filter=VA3
		WHERE typeref = $type[pk]"
	),
	"failed on update mysql_info",$success,true,
	$failStringCatcher, "updateMysqlInfo"
);


if($success){
	// SQLmetaData is a global variable in rmf.php
	file_put_contents($newTypeMetaFile, json_encode($SQLmetaData));
	WriteReinstatementObject([
		"type"=>$type,
		"action"=>"edit",
		"typeSchema"=>"tableReference",
		'snapShot'=>$snapShot,
		'newName'=>$newTypeName,
		'newDirectory'=>$newTypeDirectory
	]);
	dbSoftExit("SUCCESS");
}

switch($failStringCatcher){
	case "all":
	
		queryORerror(
			str_replace(
				["VA1","VA2","VA3"],
				[
					sQuote($type['mySQL']['nativeType']),
					sQuote($type['mySQL']['filter']),
					sQuote($type['mySQL']['validation']),
				],
				"UPDATE type_mysql_info 
				SET 
					nativeType=VA1,
					filter=VA2,
					validation=VA3
				WHERE typeref=$type[pk];"
			),
			"failed to undo update mysql info",$undoSuccess,true,
			$undoFailStringCatcher, "undoUpdateMysqlInfo"
		);
	case "updateMysqlInfo":
		queryORerror(
			str_replace(
				["VA1","VA2"],
				[
					sQuote($type['php']['validation']),
					sQuote($type['php']['filter'])
				],
				"UPDATE type_php_info 
				SET 
					validation=VA1,
					filter=VA2
				WHERE typeref=$type[pk];"
			),
			"failed to undo update php info",$undoSuccess,true,
			$undoFailStringCatcher, "undoUpdatePhpInfo"
		);
	case "updatePhpInfo":
		queryORerror(
			str_replace(
				["VA1","VA2","VA3","VA4","VA5","VA6","VA7","VA8"],
				[
					sQuote($type['js']['rmfdefault']),
					sQuote($type['js']['rmfspecials']),
					sQuote($type['js']['coll']),
					sQuote($type['js']['setter']),
					sQuote($type['js']['bodyFunction']),
					sQuote($type['js']['labelType']),
					sQuote($type['js']['cardFunction']),
					sQuote($type['js']['valueFunction'])
				],
				"UPDATE type_js_info 
				SET 
					rmfdefault=VA1,
					rmfspecials=VA2,
					coll=VA3,
					setter=VA4,
					bodyFunction=VA5,
					labelType=VA6,
					cardFunction=VA7,
					valueFunction=VA8
				WHERE typeref=$type[pk];"
			),
			"failed to undo update js info",$undoSuccess,true,
			$undoFailStringCatcher, "undoUpdateJsInfo"
		);
	case "updateJsInfo":
		queryORerror(
			str_replace(
				["VA1","VA2"],
				[sQuote($type['name']), $type['pk']],
				"UPDATE custom_types
				SET name = VA1
				WHERE pk=VA2"
			),"failed on undo update custom types",$undoSuccess,true,
			$undoFailStringCatcher, "undoUpdateCustomType"
		);
	case "updateCustomType":
	case "writeTypeValidationFile":
	case "writeBlankActionsList":
	case "writePhpActionProcedureFile":
		
		if($undoSuccess){
			if(!DeleteDirectory($newTypeDirectory)){
				$undoSuccess=false;
				$undoFailStringCatcher="undoMakeTypeDirectory";
				echo "failed on undo make type directory";
			};
		}
	case "makeTypeDirectory":
	
	
	case "getTypeDependencies":
		CreateTableReferenceRmfPhp($type['name'], $type['tbl'],$type['php']['validation'], $type['php']['filter'], $undoSuccess, $undoFailStringCatcher);
		file_put_contents($typeMetaFile, $snapShot['directory']['metaData.json']);
	case "deleteDirectory":
	
	case "mysqlFilterValidate":
	
	case "mysqlFilter":
	case "mysqlExtraFilter":
	
	case "mysqlValidate":
	case "mysqlExtraValidate":
	case "mysqlResolveProc":
	case "mysqlResolveFunct":

	case "getColList":
	
	case "dropValidate":
	case "dropExtraValidate":
	
	case "dropFilterValidate":
	

	case "dropFilter":
	case "dropExtraFilter":
	case "dropResolve":
		$fArr=["RESOLVEFUNCT"];
		$pArr=[
			"RESOLVE",
			"EXTRAVALIDATE",
			"VALIDATE",
			"EXTRAFILTER",
			"FILTER",
			
			"FILTERVALIDATE",
		];
		
		foreach($fArr as $f)
		{
			queryORerror(
				"DROP FUNCTION IF EXISTS rmf.{$newTypeName}_$f ",
				"failed to clear $f",$undoSuccess,true,
				$undoFailStringCatcher, "clear$f"
			);
		}
		foreach($pArr as $p)
		{
			queryORerror(
				"DROP PROCEDURE IF EXISTS rmf.{$newTypeName}_$p ",
				"failed to clear $p",$undoSuccess,true,
				$undoFailStringCatcher, "clear$p"
			);
		}
		
		
		CreateTableReferenceRmfMysql($type['name'],$type['tbl'],$type['mySQL']['filter'],$type['mySQL']['validation'], $undoSuccess, $undoFailStringCatcher);
	case "dropResolveFunct":
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