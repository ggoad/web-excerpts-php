<?php

function CreateMysqlFunctionActionProcedure($type, $name, $functName, $dbName){

   if(!$type){
      echo("Action procedure of the name $name was asked for the mysql function $functName, but the type string was empty. Action Procedure creation failed");
      return false;
   }
   $dr=$_SERVER['DOCUMENT_ROOT']."/RMF/$type";
   if(!is_dir($dr)){
      mkdir($dr);
      file_put_contents("$dr/actions.json","[]");
   }
   $actions=json_decode(file_get_contents("$dr/actions.json"),true);
   if(!in_array($name, $actions)){
      array_push($actions, $name);
   }
   file_put_contents("$dr/actions.json", json_encode($actions));

   file_put_contents("$dr/$name.php", str_replace(["###initialQuery###","###queryString###"], ["", '"'."SELECT {$dbName}.$functName(\$encodedDat);".'"'], file_get_contents("MysqlFunctionActionProcedurePhpFile.txt")));
   
}
function RemoveMysqlFunctionActionProcedure($type, $name){
   $dr=$_SERVER['DOCUMENT_ROOT']."/RMF/$type";
   if(!is_dir($dr)){
      return true;
   }
   $actions=json_decode(file_get_contents("$dr/actions.json"),true);
   for($i=0; $i<count($actions); $i++)
   {
      if($actions[$i]===$name){array_splice($actions,$i,1); break;}
   }
   file_put_contents("$dr/actions.json", json_encode($actions));
   unlink("$dr/$name.php");
   return true;
}
function CreateMysqlProcedureActionProcedure($type, $name, $functName, $dbName){
   if(!$type){
      echo("Action procedure of the name $name was asked for the mysql procedure $functName, but the type string was empty. Action Procedure creation failed");
      return false;
   }
   $dr=$_SERVER['DOCUMENT_ROOT']."/RMF/$type";
   if(!is_dir($dr)){
      mkdir($dr);
      file_put_contents("$dr/actions.json","[]");
   }
   $actions=json_decode(file_get_contents("$dr/actions.json"),true);
   if(!in_array($name, $actions)){
      array_push($actions, $name);
   }
   file_put_contents("$dr/actions.json", json_encode($actions));

   file_put_contents("$dr/$name.php", str_replace(
        ["###initialQuery###", "###queryString###"], 
        ['mysqli_query($sqlConn,"'."CALL {$dbName}.$functName(\$encodedDat, @out);".'");', "'SELECT @out;'"], 
        file_get_contents("MysqlFunctionActionProcedurePhpFile.txt"))
   );
   
}
function RemoveMysqlProcedureActionProcedure($type, $name){
   
   $dr=$_SERVER['DOCUMENT_ROOT']."/RMF/$type";
   if(!is_dir($dr)){
      return true;
   }
   $actions=json_decode(file_get_contents("$dr/actions.json"),true);
   for($i=0; $i<count($actions); $i++)
   {
      if($actions[$i]===$name){array_splice($actions,$i,1); break;}
   }
   file_put_contents("$dr/actions.json", json_encode($actions));
   unlink("$dr/$name.php");
   return true;
}
function CreatePhpActionProcedure($type, $name, $functionDeclaration){
   $dr=$_SERVER['DOCUMENT_ROOT']."/RMF/$type";
   if(!is_dir($dr)){
      mkdir($dr);
      file_put_contents("$dr/actions.json","[]");
   }
   preg_match('#function ([a-z_A-Z0-9]+)\(#',$functionDeclaration, $matches);
   $functionCall=$matches[1].'($dat);';

   $actions=json_decode(file_get_contents("$dr/actions.json"),true);
   if(!is_array($actions)){
     die("no actions for this type: $type");
   }
   if(!in_array($name, $actions)){
      array_push($actions, $name);
   }
   file_put_contents("$dr/actions.json", json_encode($actions));

	file_put_contents(
		"$dr/$name.php", 
		str_replace(
			["###functionDeclaration###","###functionCall###"], 
			['', $functionCall], 
			file_get_contents("PhpFunctionActionProcedurePhpFile.txt")
		)
	);
	return true;
}
function RemovePhpActionProcedure($type, $name){
   
   $dr=$_SERVER['DOCUMENT_ROOT']."/RMF/$type";
   if(!is_dir($dr)){
      return true;
   }
   $actions=json_decode(file_get_contents("$dr/actions.json"),true);

   if(!is_array($actions)){
     return false;
   }
   for($i=0; $i<count($actions); $i++)
   {
      if($actions[$i]===$name){array_splice($actions,$i,1); break;}
   }
   file_put_contents("$dr/actions.json", json_encode($actions));
   unlink("$dr/$name.php");
   return true;
}


function WritePhpFunctions($tbl, $makeAp=false){
	$success=true;
	$result=queryORerror(
		"SELECT name, args, body FROM php_action WHERE tblref=$tbl[pk];",
		"", $success
	);
	$str="<?php".PHP_EOL;
	$customType="TBL_{$tbl['db']['name']}_{$tbl['name']}";
	if(!$success){
		return false;
	}
	while($row=mysqli_fetch_row($result))
	{
		$fc=ConstructPhpFunctionCall($row[0],$row[1],$row[2]);
		$str.=$fc.PHP_EOL.PHP_EOL;
		
	}
	$str.=PHP_EOL."?>";
	file_put_contents($_SERVER['DOCUMENT_ROOT']."/RMF/$customType/lib.php", $str);
	return true;
}



?>