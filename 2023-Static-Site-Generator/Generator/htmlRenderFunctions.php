<?php 
require_once(__DIR__.'/stringSupplement.php');
function HTML_parseElement($inf, $raw=false){
	switch(gettype($inf)){
		case "string":
			if($raw){return $inf;}
			return htmlentities($inf);
			break;
		case "array":
			if(!isset($inf['properties'])){$inf['properties']=[];}
			if(!isset($inf['children'])){$inf['children']=false;}
			if(!isset($inf['raw'])){$inf['raw']=false;}
			return HTML_element($inf['tag'], $inf['properties'],$inf['children'], $inf['raw']);
			break;
		default:
			return "";
			break;
	}
}

function HTML_parseProperties($propertyObject=[]){
	$properties=[];
	foreach($propertyObject as $prop=>$val)
	{
		if(!$val){
			array_push($properties, $prop);
			continue;
		}
		$val=htmlentities($val);
		array_push($properties, "$prop=\"$val\"");
	}
	$properties=join(' ', $properties);
	if($properties){
		$properties=" $properties ";
	}
	return $properties;
}

function HTML_element($tag, $propertyObject=[], $children=false, $raw=false){
	$properties=[];
	//if(gettype($propertyObject) !== 'array'){echo $tag.' '.gettype($propertyObject).' '.$propertyObject;}
	foreach($propertyObject as $prop=>$val)
	{
		$val=htmlentities($val);
		array_push($properties, "$prop=\"$val\"");
	}
	$properties=join(' ', $properties);
	
	if($properties){$properties=" $properties ";}
	
	if($children === false){
		return "<$tag{$properties}/>";
	}
	$childText=array_map(function($m) use ($raw){ 
		return HTML_parseElement($m, $raw);
	},$children);
	
	$childText=array_filter($childText);
	
	$childText=join("\n", $childText);
	return "<$tag{$properties}>$childText</$tag>";
	
	
}

?>