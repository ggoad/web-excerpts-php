<?php 

set_time_limit(0);
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sQuote.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postStream.php");
require_once("rmfSupplement.php");

PostVarSet("start",$start);
PostVarSet("end",$end);

$start.=" 00:00:00";
$end.=" 23:59:59";

PostVarSet("stops",$stops);
$stops=json_decode($stops, true);

require_once("RMF/user.php");

$existingPks=array_map(function($st){return $st['pk'];},array_filter($stops,function($st){return @$st['pk'];}));


$queryStr="DELETE FROM dayLog.stop
WHERE 
	(
		(arrivalTime <= ? AND arrivalTime >= ?)
		OR 
		(departureTime <= ? AND departureTime >= ?)
		OR 
		(arrivalTime >= ? AND departureTime IS NULL)
	)
";
$tpStr='';
$vArr=[];
if($existingPks){
	
	$queryStr.="AND pk NOT IN(".InStringPrep($existingPks,$tpStr, $vArr).")";
}


$stmt=$sqlConn->prepare($queryStr);


$stmt->bind_param('sssss'.$tpStr, $end, $start, $end, $start, $start,...$vArr);
$stmt->execute();

$ret=[];
foreach($stops as $st)
{
	$st['place']['location']['lat']=number_format(floatval($st['place']['location']['lat']),4);
	$st['place']['location']['lng']=number_format(floatval($st['place']['location']['lng']),4);
	$encodedDat=json_encode($st);
	if(@$st['pk']){
		unset($st['OGvalue']['place']['location']['lat']);unset($st['OGvalue']['place']['location']['lng']);
		$stmt=$sqlConn->prepare("CALL dayLog.mpEditdayLog_stop(?, @out);");
		$stmt->bind_param('s', $encodedDat);
		$stmt->execute();
		$editError=mysqli_error($sqlConn);
		//die("ERROR : ".mysqli_error($sqlConn));
		$result=$sqlConn->query("SELECT @out");
		$result=$result->fetch_row()[0];
		if($result !== "SUCCESS"){
			die("failed $result ::: ERROR: $editError ... ".mysqli_error($sqlConn).' ::: dat: '.json_encode($st));
		}
		$stmt=$sqlConn->prepare("SELECT rmf.TBL_dayLog_stop_RESOLVEFUNCT(?);");
		$stmt->bind_param('i',$st['pk']);
		$stmt->execute();
		$result=$stmt->get_result();
		$r=json_decode($result->fetch_row()[0]);
	}else{
		$stmt=$sqlConn->prepare("CALL dayLog.mpAdddayLog_stop(?, @out);");
		$stmt->bind_param('s',$encodedDat);
		$stmt->execute();
		
		$result=$sqlConn->query("SELECT @out");
		$result=$result->fetch_row()[0];
		if($result !== "SUCCESS"){
			die("failed to add $result :: $encodedDat");
		}
		$result=$sqlConn->query("SELECT rmf.TBL_dayLog_stop_RESOLVEFUNCT(LAST_INSERT_ID());");
		$r=json_decode($result->fetch_row()[0]);
	}
	$r->OGvalue=['pk'=>$r->pk];
	array_push($ret,$r);
}

usort($ret,function($a, $b){return $a->arrivalTime > $b->arrivalTime;});

$sqlConn->query("INSERT INTO dayLog.prevStops (origin, destination)
SELECT  dayLog.GetPreviousStop(ss.pk), ss.pk
FROM dayLog.stop ss 
LEFT JOIN dayLog.prevStops ps 
	ON ps.origin = ss.pk 
WHERE ps.pk IS NULL AND dayLog.GetPreviousStop(ss.pk) IS NOT NULL;");

/* I don't want to lose this, because it was working... but it had poor performance
$res=$sqlConn->query("
SELECT DISTINCT
        ll.pk AS toLoc,
        ll2.pk AS fromLoc,
		CONCAT(ll.lat,',',ll.lng) AS toLatLng,
        CONCAT(ll2.lat,',',ll2.lng) AS fromLatLng
	FROM dayLog.stop ss
	JOIN (
		SELECT 
			subss.pk AS pk,
			dayLog.GetPreviousStop(subss.pk)  AS fromStop
		FROM dayLog.stop subss
	) AS sub
		ON sub.pk = ss.pk
	
	JOIN world.places pp 
		ON ss.place = pp.pk
	JOIN world.location ll
		ON ll.pk=pp.location
    JOIN dayLog.stop ss2 
    	ON ss2.pk= sub.fromStop
    JOIN world.places pp2
    	ON pp2.pk=ss2.place
    JOIN world.location ll2
    	ON ll2.pk=pp2.location
    WHERE CONCAT(ll.pk,':',ll2.pk) NOT IN (
		SELECT CONCAT(location2,':',location1) FROM world.computedDistances
	) 
		AND ll.pk != ll2.pk
	ORDER BY ll2.pk, ll.pk
		
");*/


$res=$sqlConn->query("
SELECT DISTINCT
        ll.pk AS toLoc,
        ll2.pk AS fromLoc,
		CONCAT(ll.lat,',',ll.lng) AS toLatLng,
        CONCAT(ll2.lat,',',ll2.lng) AS fromLatLng
	FROM dayLog.stop ss
	JOIN dayLog.prevStops sub
		ON sub.destination = ss.pk
	
	JOIN world.places pp 
		ON ss.place = pp.pk
	JOIN world.location ll
		ON ll.pk=pp.location
    JOIN dayLog.stop ss2 
    	ON ss2.pk= sub.origin
    JOIN world.places pp2
    	ON pp2.pk=ss2.place
    JOIN world.location ll2
    	ON ll2.pk=pp2.location
    LEFT JOIN world.computedDistances cd
    	ON cd.location1 = ll2.pk AND cd.location2 = ll.pk
    WHERE cd.pk IS NULL
		AND ll.pk != ll2.pk
	ORDER BY ll2.pk, ll.pk
		
");

$actualCalls=[];
$allCommutes=$res->fetch_all(MYSQLI_ASSOC);

$apFailures=[];

foreach($allCommutes as $ac)
{
	$from=$ac['fromLoc'].';;;'.$ac['fromLatLng'];
	$to=$ac['toLoc'].';;;'.$ac['toLatLng'];
	if(!isset($actualCalls[$from])){
		$actualCalls[$from]=[];
	}
	array_push($actualCalls[$from],$to);
}

$googleResponses=[];

$fromIndex=-1;
foreach($actualCalls as $from=>$to)
{
	$fromIndex++;
	$fromExp=explode(';;;',$from);
	$fromId=$fromExp[0];
	$fromLatLng=$fromExp[1];
	
	$toIds=array_map(function($t){
		return explode(';;;',$t)[0];
	},$to);
	$toLatLngs=array_map(function($t){
		return explode(';;;',$t)[1];
	},$to);
	
	$getdata=http_build_query(array(
		'origins'=>$fromLatLng,
		'destinations'=>implode('|',$toLatLngs),
		'units'=>'imperial',
		'key'=>'_redacted_'
	));
	$opts=array('http'=>array(
		'method'=>'GET'
	));
	$context=stream_context_create($opts);
	
	//die(($getdata));
	
	$resp=@file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?'.$getdata , false, $context);
	if(isset($http_response_header)){
		$headers=$http_response_header;
	}else{
		$headers='No Headers';
	}
	
	
	$dat=[
		"headers"=>json_encode($headers),
		"resp"=>$resp
	];
	$googleResponses[]=$dat;
	//$db, $tbl, $ap, $dat, &$res=''

	if(!RunActionProcedure('liveServer','googleDistanceMatrixCalls','mpAdd',$dat,$apResult)){
		die(json_encode([
			'success'=>false,
			'headers'=>$headers,
			'resp'=>$resp ?? "FAIL",
			'msg'=>"Failed to add matrix call: $apResult"
		]));
	}
	$matrixCall=GetLastObject();
	
	$resp=json_decode($resp, true);
	if($resp && $resp['status'] === "OK"){
		$dat=[
			'addr'=>$resp['origin_addresses'][0],
			'googleDistanceCall'=>$matrixCall,
			'location'=>['pk'=>$fromId]
		];
		
		if(!RunActionProcedure('world','googleMapsAddressSaves','mpAdd',$dat, $apResult)){
			array_push($apFailures, [
				'step'=>'fromAddrSave:'.$fromIndex,
				'resp'=>$apResult
			]);
		}
		
		foreach($resp['rows'][0]['elements'] as $i=>$info)
		{//0.000621371 meters to mile
			if($info['status'] === "OK"){
				$dat=[ 
					'addr'=>$resp['destination_addresses'][$i],
					'googleDistanceCall'=>$matrixCall,
					'location'=>['pk'=>$toIds[$i]]
				];
				if(!RunActionProcedure('world','googleMapsAddressSaves','mpAdd',$dat,$apResult)){
					array_push($apFailures, [
						'step'=>"toAddrSave:$fromIndex,$i",
						'resp'=>$apResult
					]);
				}
				$dat=[
					'distance'=>number_format(0.000621371*$info['distance']['value'],'4'),
					'location1'=>['pk'=>$fromId],
					'location2'=>['pk'=>$toIds[$i]]
				];
				if(!RunActionProcedure('world','computedDistances','mpAdd', $dat, $apResult)){
					
					array_push($apFailures, [
						'step'=>"toDistanceSave:$fromIndex,$i",
						'resp'=>$apResult
					]);
				}
			}
		}
	}
	

}

/*
die(json_encode([
	'success'=>false,
	//'resp'=>json_decode($resp),
	//'headers'=>$http_response_header,
	'actualCalls'=>$actualCalls,
	'getdata'=>$getdata,
	'fromLatLng'=>$fromLatLng,
	'toLatLngs'=>$toLatLngs,
	'from'=>$from,
	'to'=>$to
]));
*/

die(json_encode([
	'success'=>true,
	'data'=>$ret,
	'apFailures'=>$apFailures,
	'googleResponses'=>$googleResponses
]));

?>