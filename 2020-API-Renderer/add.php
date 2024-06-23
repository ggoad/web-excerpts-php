<?php 
	require_once('macroRendererHelpers.php');
	
	PostVarSet("dat",$dat);
$dat=json_decode($dat, true);

ObVarSet($dat,'actProcName', $actProcName );
ObVarSet($dat,'functName',$functName);
ObVarSet($dat,'addCols',$addCols);
ObVarSet($dat,'tableName',$tableName);
ObVarSet($dat,'dbName',$dbName);
$typeName = "TBL_{$dbName}_{$tableName}";
// the return structure will be different mysql functs and procs
/*
procedure ret
$ret=[
	"actionProcedureFam"=>[
		"name"=>$actProcName,
		"jsFormList"=>[]
	],
	"arguments"=>[
		[
			'direction'=>'IN||OUT||INOUT',
			'name'=>'argName',
			'typeExistingOrNew'=>[
				'existing'=>[
					'type'=>['pk'=>number]
				]
			]
		]
	],
	"name"=>$functName,
	"body"=>''
];

// function ret
$ret=[
	"actionProcedureFam"=>[
		"name"=>$actProcName,
		"jsFormList"=>[]
	],
	"arguments"=>[
		[
			'name'=>'argName',
			'typeExistingOrNew'=>[
				'existing'=>[
					'type'=>['pk'=>number]
				]
			]
		]
	],
	"name"=>$functName,
	"body"=>'',
	'returnType'=>[
		'existing'=>[
			'type'=>[
				'pk'=>number
			]
		]
	]
];


*/
$ret=[
	"actionProcedureFam"=>[
		"name"=>$actProcName,
		"jsFormList"=>[]
	],
	"arguments"=>[
		[
			
			'name'=>'dat',
			'typeExistingOrNew'=>[
				'existing'=>[
					'type'=>['pk'=>GET_rmfTypePkFromName('json')]
				]
			],
		],
		[
			'direction'=>'OUT',
			'name'=>'errString',
			'typeExistingOrNew'=>[
				'existing'=>[
					'type'=>['pk'=>GET_rmfTypePkFromName('para')]
				]
			]
		]
	],
	"name"=>$functName,
	"body"=>''
];
$jsFormList=[];
$allNameList=[];
$colString=[];
$valString=[];

$bodyDeclaration='
	DECLARE obHolder JSON;
	DECLARE localErrString TEXT;
	DECLARE validateSuccess INT;
	DECLARE tempHolder TEXT;
	DECLARE tempTp TEXT;
';



$bodyImp="
	jumpOut:BEGIN
	CALL rmf.{$typeName}_FILTERVALIDATE(dat, validateSuccess, 0);
	IF validateSuccess = 0 THEN 
		SET errString = 'Invalid dat';
		LEAVE jumpOut;
	END IF;
";
foreach($addCols as $colWrapper)
{
	
	$col=$colWrapper['col'];

	if($colWrapper['syntheticTypeName']){
		$ctName=$colWrapper['syntheticTypeName'];
	}else{
		// die(json_encode($col));
		$result=queryORexit(
			"SELECT name FROM custom_types WHERE pk=".$col['type']['existing']['type']['pk'],
			"failed on get custom type name"
		);
		if(!$result){
			dbSoftExit("couldn't select custom type name");
		}
		$ctName=mysqli_fetch_row($result)[0];
	}
	
	array_push($allNameList, "$col[name]_valHolder");
	array_push($colString, $col['name']);
	array_push($valString, '?');
	
	if(preg_match('/^TBL_/', $ctName)){
		$jsFormMember=[
			'name'=>$col['name'],
			'type'=>'tableSearch',
			'labelText'=>$col['readableName'],
			'typeName'=>$ctName,
			'apName'=>$colWrapper['apName'],
			'searchFile'=>GetSearchFileName($colWrapper['searchFile'])
		];
		if($colWrapper['addFiles']){
			$jsFormMember['includeAdd']=true;
			$jsFormMember['addApName']=$colWrapper['addFiles']['addApName'];
			$jsFormMember['addFile']=$colWrapper['addFiles']['addSearchFile'];
		}
		array_push($jsFormList,$jsFormMember);
	}else{
		array_push($jsFormList,[
			'name'=>$col['name'],
			'labelText'=>$col['readableName'],
			'type'=>$ctName
		]);
	}
	
	if(!$col['can_null'] && !$col['ai'] && !$col['def']){
		$bodyImp.="
			SET tempHolder=JSON_UNQUOTE(JSON_EXTRACT(dat, '\$.$col[name]'));
			IF tempHolder IS NULL OR tempHolder = '' THEN
				SET errString= 'failed: the column $col[name] was not provided';
				LEAVE jumpOut;
			END IF;
		";
	}
	
	if(preg_match('/^TBL_/',$ctName)){
		$bodyDeclaration.="DECLARE $col[name]_valHolder BIGINT UNSIGNED;
		";
		if(!$col['can_null']){
			$bodyImp.="
				SET obHolder=JSON_UNQUOTE(JSON_EXTRACT(dat, '\$.$col[name]'));
				IF obHolder IS NOT NULL AND obHolder != '' AND IFNULL(@{$ctName}_RESOLVE_recDepth,0) < IFNULL(@{$ctName}_RESOLVE_recLimit,1) THEN 
					
					CALL rmf.{$ctName}_RESOLVE(obHolder, localErrString);
					
					IF localErrString = 'empty' THEN 
						SET errString='The required object was empty';
						LEAVE jumpOut;
					ELSEIF localErrString IS NOT NULL THEN
						SET errString=CONCAT('There was an error resolving the object ', localErrString);
						LEAVE jumpOut;
					END IF;
					
					SET $col[name]_valHolder=JSON_UNQUOTE(JSON_EXTRACT(obHolder, '\$.pk'));
					
				ELSE 
					SET errString= 'could not parse object because parse limit was exceeded';
					LEAVE jumpOut;
				END IF;
			";
		}else{
			$bodyImp.="
			
				SET obHolder=JSON_UNQUOTE(JSON_EXTRACT(dat, '\$.$col[name]'));
				IF obHolder IS NOT NULL AND obHolder != '' AND IFNULL(@{$ctName}_RESOLVE_recDepth,0) < IFNULL(@{$ctName}_RESOLVE_recLimit,1) THEN 
					
					CALL rmf.{$ctName}_RESOLVE(obHolder, localErrString);
					
					IF localErrString IS NULL OR localErrString != 'empty' THEN 
						IF localErrString IS NULL OR localErrString = '' THEN 
							SET $col[name]_valHolder=JSON_UNQUOTE(JSON_EXTRACT(obHolder, '\$.pk'));
						ELSE 
							SET errString=CONCAT('An object was indicated, but there was a problem resolving it: ', localErrString);
							LEAVE jumpOut;
						END IF;
					END IF;
				END IF;
				
			";
		}
	}else{
		$bodyDeclaration.="DECLARE $col[name]_valHolder TEXT;
		";
		
		$def=null;
		if($col['def'] || $col['def'] == 0 || $col['def'] === '0'){
			$def=$col['def'];
		}
		$bodyImp.=BasicInputFilter("$col[name]_valHolder", "$col[name]", "tempTp", $def);
		
	}
}

$allNameList=implode(',',$allNameList);
$colString=implode(',',$colString);
$valString=implode(',',$valString);

$bodyImp.="
	SET @{$typeName}_ADD_userVar='INSERT INTO {$dbName}.$tableName ($colString) VALUES ($valString);';
	PREPARE {$typeName}_ADD_stmt FROM @{$typeName}_ADD_userVar;
	EXECUTE {$typeName}_ADD_stmt USING {$allNameList};
	DEALLOCATE PREPARE {$typeName}_ADD_stmt;
	
	IF @@ERROR_COUNT > 0 THEN 
		SET errString='The insert was a failure';
		LEAVE jumpOut;
	END IF;
";

$body=$bodyDeclaration.$bodyImp;
$body.="
	SET errString='SUCCESS';
	END;
";// end the jumpOut 

$ret['body']=$body;
$ret['actionProcedureFam']['jsFormList']=json_encode($jsFormList);



dbSoftExit(json_encode($ret));

?>