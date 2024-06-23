<?php 

require_once("basicdbcredz.php");

/// procCreate placeholder
function procCreate($procpk, $oldName="", $oldActionProcedureName=""){
	global $sqlConn;
        $proc=["pk"=>$procpk];
	RESOLVE_proc($proc, "could not resolve proc");
             $customType="";
             if($proc['tbl']){
                $customType="TBL_".$proc['tbl']['db']['name']."_".$proc['tbl']['name'];
             }
			 
	if(($proc['actionProcedure'] || $oldActionProcedureName) && !$customType){
		return "action procedure asked for, but no type detected";
	}
	if($oldName){
		if(!($result=mysqli_query($sqlConn,$sss=str_replace(
			["VA1"],
			[$procpk],
			"SELECT CONCAT('DROP PROCEDURE IF EXISTS ',dd.name, '.$oldName')
			FROM procs pp 
			JOIN dbs dd ON pp.db=dd.pk
			WHERE pp.pk=VA1;"
		)))){
			return "failed to select drop proc concat oldName ... ".mysqli_error($sqlConn)." ".$sss;
		}

		if(!mysqli_query($sqlConn, $sss=mysqli_fetch_row($result)[0])){return "Failed to drop procedure oldName ".mysqli_error($sqlConn)." ".$sss;}
	}
	if($oldActionProcedureName){
		RemoveMysqlProcedureActionProcedure($customType,$oldActionProcedureName);
	}
    if(!($result=mysqli_query($sqlConn,$sss=str_replace(
		["VA1"],
		[$procpk],
		"SELECT CONCAT('DROP PROCEDURE IF EXISTS ',dd.name, '.',pp.name)
		FROM procs pp 
		JOIN dbs dd ON pp.db=dd.pk
		WHERE pp.pk=VA1;"
	)))){
		return "failed to select drop proc concat ... ".mysqli_error($sqlConn)." ".$sss;
	}

	if(!mysqli_query($sqlConn, $sss=mysqli_fetch_row($result)[0])){return "Failed to drop procedure ".mysqli_error($sqlConn)." ".$sss;}
	//"Failed to drop procedure"

    if(!($result=mysqli_query($sqlConn, $sss=str_replace(
		["VA1"],
		[$procpk],
		'SELECT CONCAT("CREATE PROCEDURE ",dd.name,".",pp.name, "(" , 
		IFNULL(GROUP_CONCAT(CONCAT(pa.direction," ", pa.name, " ", NativeTypeByName(tt.name)) SEPARATOR ","),"") , 
		")
		BEGIN
		",
		pp.body,
		"
		END")
		FROM procs pp 
		JOIN dbs dd ON dd.pk = pp.db
		JOIN proc_args pa ON pp.pk = pa.proc
		JOIN custom_types tt ON tt.pk=pa.type 
		WHERE pp.pk=VA1
		ORDER BY pa.ord;'
    )))){
		return "failed to concat create string. ".mysqli_error($sqlConn)." ".$sss;
	}
	//"failed to concat create string"
	if(!mysqli_query($sqlConn, $sss=mysqli_fetch_row($result)[0])){return "failded to create procedure ".mysqli_error($sqlConn)." ".$sss;}
	//"failed to create proc"

	/// HANDLE ACTION PROCEDURE STUFF
	if($proc['actionProcedure']){
		CreateMysqlProcedureActionProcedure($customType, $proc['actionProcedure'], $proc['name'], $proc['db']['name']);
	}
    
	return true;
}
/// functCreate placeholder
function functCreate($fpk, $oldName="", $oldActionProcedureName=""){
	global $sqlConn;


	$dd;
	$funct=["pk"=>$fpk];
        RESOLVE_funct($funct,'could not resolve funct');

            $customType="";
            if($funct['tbl']){
                $customType="TBL_{$funct['tbl']['db']['name']}_{$funct['tbl']['name']}";
            }
	if(($funct['actionProcedure'] || $oldActionProcedureName) && !$customType){
		return "action procedure asked for, but no type detected";
	}
	if($oldName){
		if(!($result=mysqli_query($sqlConn, str_replace(
			["VA1"],
			[$fpk],
			"SELECT CONCAT('DROP FUNCTION IF EXISTS ',dd.name, '.$oldName')
			FROM functs ff 
			JOIN dbs dd ON ff.db=dd.pk
			WHERE ff.pk=VA1;"
			)))
		){
				return "failed to select drop funct concat oldName ".mysqli_error($sqlConn);
		}
		//"failed to select  drop func concat"
		if(!mysqli_query($sqlConn, mysqli_fetch_row($result)[0])){
			return "failed to drop function oldName";
		}
	}
	if($oldActionProcedureName){
		RemoveMysqlFunctionActionProcedure($customType, $oldActionProcedureName);
	}
	if(!($result=mysqli_query($sqlConn, str_replace(
		["VA1"],
		[$fpk],
		"SELECT CONCAT('DROP FUNCTION IF EXISTS ',dd.name, '.',ff.name)
		FROM functs ff 
		JOIN dbs dd ON ff.db=dd.pk
		WHERE ff.pk=VA1;"
	)))){
		return "failed to select drop funct concat ".mysqli_error($sqlConn);
	}
	//"failed to select  drop func concat"
	if(!mysqli_query($sqlConn, mysqli_fetch_row($result)[0])){
		return "failed to drop function";
	}
	//"Failed to drop function"



	if(!($result=mysqli_query($sqlConn, str_replace(["VA1"],[$fpk],'
		SELECT CONCAT("CREATE FUNCTION ",dd.name,".",ff.name,"(",IFNULL(GROUP_CONCAT(CONCAT(fa.name," ",NativeTypeByName(tt.name))),""),") RETURNS ",NativeTypeByName(ct.name), " BEGIN
		",ff.body," 
		END")
		FROM functs ff
		JOIN dbs dd ON dd.pk = ff.db
		JOIN funct_args fa ON ff.pk = fa.funct
		JOIN custom_types tt ON tt.pk=fa.type
		JOIN custom_types ct ON ct.pk=ff.return_type
		WHERE ff.pk=VA1
		ORDER BY fa.ord;')))){
			return "failed to concat create string. ".mysqli_error($sqlConn)." ".$strGetter;
	}

	//"failed to concat create string"

	if(!mysqli_query($sqlConn,$strGetter=mysqli_fetch_row($result)[0])){
		return "failed to create func ".mysqli_error($sqlConn)." ".$strGetter;
    }
	//"failed to create func"

	if($funct['actionProcedure']){
		CreateMysqlFunctionActionProcedure($customType, $funct['actionProcedure'], $funct['name'], $funct['db']['name']);
	}

	

	return true;
}

function obSANE($ob, $keyArray){
	$ret=true;
	foreach ($keyArray as $k)
	{
		$ret=($ret && (isset($ob[$k]) && (!empty($ob[$k])|| $ob[$k] === "0")));
	}return $ret;
}
function SWITCHdb($db){
   if($result=mysqli_query($sqlConn, "SELECT DATABASE();")){
      $ret=mysqli_fetch_row($result)[0];
    }
    mysqli_select_db($db);
    return $ret;
}

function NSNED($v, $tojson=false){
   if(!SETandNOTEMPTY($_POST[$v])){
       dbSoftExit("No ".$v.' given.');
   }
   if($tojson){
      return TOjson($_POST[$v],$v);  
   }return $_POST[$v];
}

function NSNEN($v, $tojson=false){
   if(!SETandNOTEMPTY($_POST[$v])){
       return null;
   }
   if($tojson){
      return TOjson($_POST[$v],$v);
   }return $_POST[$v];
}

function TOjson($str, $xtr=''){
  if($str == "null"){
     return null;
  }
  $ret=json_decode($str,true);
   if($ret === null){
      if($xtr === ''){
         dbSoftExit("Invalid json: ".$str);
      }dbSoftExit("invalid json: ".$str." ...> ".$xtr);
   }return $ret;
}

$sibFile="sibKeys.json";
function WRITE_sibFile($inf){
	global $sibFile;
	file_put_contents($sibFile, json_encode($inf));
}
function GET_sibFile(){
	global $sibFile;
	
	if(!is_file($sibFile)){
		return [];
	}
	$ret=json_decode(file_get_contents($sibFile),true);
	unlink($sibFile);
	return $ret;
}

function nullFilter($s){
   if(is_null($s) || $s === ''){return "NULL";}return $s;
}

function postStream($url, $postVarObject){
  $postVarObject=obTOhttp1level($postVarObject);
  //echo(json_encode($postVarObject));
   $options=[
     'http'=>[
       'method'=>"POST",
       'header'=>'Content-Type: application/x-www-form-urlencoded',
       'content'=>$postVarObject
     ]
   ];
  // echo($options['http']['content']);
  // echo(json_encode($options));
   $context=stream_context_create($options);
   //echo(($context));
    //$j= file_get_contents($url, false, $context);
   // echo($j);
    return file_get_contents($url, false, $context);
}


function SETandNOTEMPTY(&$op){
  return (isset($op) && !empty($op));
}


function dbQuery1string($q){
    global $sqlConn;
    if($result = mysqli_query($sqlConn, $q)){
       return mysqli_fetch_row($result)[0];
    }else{
       echo $q;
    }
}

function obTOhttp1level($ob){
   $ret="";
   foreach($ob as $k=>$v)
   {
      if($ret){$ret.="&";}
      $ret.=$k."=";
      switch(getType($v)){
         case "boolean":
         case "integer":
         case "double":
         case "string":
            $ret.=urlencode($v);
            break;
         case "array":
         case "object":
            $ret.=urlencode(json_encode($v));
            break;
         default:
            $cat[$k]="";
            break;
      }
   }
   return $ret;
}

function objectTOhttp1level($ob){
   $cat=[];
   foreach($ob as $k=>$o)
   {
      switch(getType($o)){
         case "boolean":
         case "integer":
         case "double":
         case "string":
            $cat[$k]=$o;
            break;
         case "array":
         case "object":
            $cat[$k]=json_encode($o);
            break;
         default:
            $cat[$k]="";
            break;
      }
   }
   return $cat;
}

function objectTOpostVars($ob){
   $cat=objectTOhttp1level($ob);
   foreach($cat as $k=>$o)
   {
      $_POST[$k]=$o;
   }
}

function sQuote($str){
   return "'".str_replace("'","\\'",str_replace("\\","\\\\",$str))."'";
}
function sQuoteR(&$str){
   $str="'".str_replace("'","\\'",str_replace("\\","\\\\",$str))."'";
}


function Reinstate($ob, $type){
	WriteReinstatementObject($ob);
	return postStream("http://localhost/_DATABASE_MANAGER_/v3/ajax/reinstatementTest.php?type=$type", []);
}
function GetReinstatementObject($toJson=false){
	$ret=file_get_contents("reinstatementObject.json");
	if($toJson){
		return json_decode($ret, true);
	}return $ret;
}
function WriteReinstatementObject($ob){
	file_put_contents("reinstatementObject.json",json_encode($ob));
}


$tableTrashColName = 'trashBcMysqlNoHasEmptyTbls'; 
$aiKeyName="defaultUniqueForAi";


?>