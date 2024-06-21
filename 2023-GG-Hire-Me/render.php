<?php 
set_time_limit(0);
define("siteGenPath","../../siteGenerator/v1/appdata.json");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/htmlRenderers.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/urlAndFileSafe.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/CSSSelectorSafe.php");

function StartEndSwitch($tp, $s,$e,$rawElem=false){
	switch($tp){
		case "year":
			return JustYear($s,$e,$rawElem);
			break;
		default:
			return StartEnd($s,$e,$rawElem);
			break;
	}
}
function JustYear($s, $e, $rawElem=false){
	$str=date("Y", strtotime($s));
	if(!$e){
		$str.=" - Present";
	}else if($s !== $e){
		$str.=' - '.date("Y", strtotime($e));
	}
	if(!$rawElem){
		return [
			'tag'=>'div',
			'properties'=>[
				'class'=>'date-line'
			],
			'children'=>[
				$str
			]
		];
	}else{
		return HTML_element('div',[
			'properties'=>[
				'class'=>'date-line'
			]
		],[$str]);
	}
}
function StartEnd($s,$e,$rawElem=false){
	$str=date("M 'y", strtotime($s));
	if(!$e){
		$str.=" - Present";
	}else if($s !== $e){
		$str.=' - '.date("M 'y", strtotime($e));
	}
	
	if(!$rawElem){
		return [
			'tag'=>'div',
			'properties'=>[
				'class'=>'date-line'
			],
			'children'=>[
				$str
			]
		];
	}else{
		return HTML_element('div',[
			'properties'=>[
				'class'=>'date-line'
			]
		],[$str]);
	}
	
}
function BegFamButton($ob){
	$k=$ob['name'];
	return HTML_element('a',[
		'class'=>'invisiAnchors',
		'onclick'=>"VCR.main.EventCHANGE(event, '$k')",
		'href'=>"`--AbsolutePrefix--`/".urlAndFileSafe($k)
	],[
		[
			'tag'=>'h2',
			'properties'=>[
			],
			'children'=>[
				[
					'tag'=>'span',
					'properties'=>[
						'class'=>'famTieHeaders'
					],
					'children'=>[
						$k
					]
				]
			]
		]
	]);
}
function FamButton($ob){
	$k=$ob['name'];
	return HTML_element('a',[
		'class'=>'invisiAnchors',
		'onclick'=>"VCR.main.EventCHANGE(event, '$k')",
		'href'=>"`--AbsolutePrefix--`/".urlAndFileSafe($k)
	],[
		[
			'tag'=>'h2',
			'properties'=>[
			],
			'children'=>[
				[
					'tag'=>'span',
					'properties'=>[
						'class'=>'famTieHeaders'
					],
					'children'=>[
						"Related ".$k
					]
				]
			]
		]
	]);
}


function LargeFamButton($ob){
	
}
function SubFamButton($mainFam, $ob){
	
	
	return HTML_element('a',[
		'onclick'=>"VCR.main.EventCHANGE(event, '$ob[name]')",
		"class"=>'invisiAnchors',
		'href'=>'`--AbsolutePrefix--`/'.MemHref($mainFam,$ob['name'])
		
	],[
		[
			'tag'=>'div',
			'properties'=>[
				'class'=>'continueButtons'
			],
			'children'=>[
				$ob['name']
			]
		]
	]);
}
function LargeSubFamButton($mainFam, $ob){
	return HTML_element('a',[
		'onclick'=>"VCR.main.EventCHANGE(event, '$ob[name]')",
		"class"=>'invisiAnchors',
		'href'=>'`--AbsolutePrefix--`/'.MemHref($mainFam,$ob['name'])
		
	],[
		[
			'tag'=>'div',
			'properties'=>[
				'class'=>'continueButtons'
			],
			'children'=>[
				[
					'tag'=>'span',
					'properties'=>[
						'class'=>'extendedContinueLabel'
					],
					'children'=>[
						$ob['name'],
					]
				],
				...($ob['title'] ? [
					[
						'tag'=>'div',
						'properties'=>[],
						'children'=>[$ob['title']]
					]
				] : []),
				...($ob['start'] ? [
					StartEndSwitch($ob['dateType'],$ob['start'],$ob['end'])
				] : [])
			]
		],
		
	]);
	
}
function LargeDynTieButton($mainFam, $ob){
	$k=$mainFam;
	$p=$ob;
	return HTML_element('a',[
			'class'=>'invisiAnchors',
				'onclick'=>"VCR.main.EventCHANGE(event, '$p[namer]')",
				"href"=>"`--AbsolutePrefix--`/".MemHref($k, $p['namer'])
			
			],[
				[
					'tag'=>'div',
					'properties'=>[
						'class'=>'continueButtons extendedContinueButtons',
					],
					'children'=>[
						[
							'tag'=>'span',
							'properties'=>[
								'class'=>'extendedContinueLabel'
							],
							'children'=>[
								$p['namer']
							]
						],
						...($p['ta'] ? [
							[
								'tag'=>'br'
							],
							[
								'tag'=>'span',
								'properties'=>[
									'class'=>''
								],
								'children'=>[
									$p['ta']
								]
							]
						] : [
							
						])
					]
				]
			]);
}

function MemHref($mainFam, $mem){
	$mainFam=urlAndFileSafe($mainFam);
	$mem=urlAndFileSafe($mem);
	return "$mainFam/$mem";
}

$famObs=[];

function ProcessSubFamily(&$pages, $mainFam, $info){
	global $famObs;
	
	$mainFamSing=$famObs[$mainFam]['singular'];
	$body=[];
	$body[]="<h1>$info[name] ($mainFamSing)</h1>";
	if($info['title']){
		$body[]="<h2>$info[title]</h2>";
	}
	if($info['description']){
		$body[]="<div><p class=\"shortDescriptions\">$info[description]</p></div>";
	}
	
	if($info['link']){
		$body[]=HTML_element('a',[
			'href'=>$info['link'],
			'class'=>'externalNewWindowLinks subFamLinks',
			'target'=>'_BLANK'
		],[$info['linkText']]).'<br>';
	}
	if($info['youtubeVideo']){
		$cssName=CSSSelectorSafe($info['name']);
		$body[]=HTML_element('div',[
			'id'=>"$cssName-YTtarget",
			'class'=>'embedYoutubeTarget'
		],['']);
		$body[]=HTML_element('script',[],["
			var yttar=document.getElementById('$cssName-YTtarget');
			CookieManager.GetPermission('youtube', yttar, function(){
				_el.APPEND(yttar, [
					_el.CREATE('div','','embedYoutubeWrapper',{innerHTML:'$info[youtubeVideo]'})
				]);
			}, 'to view embedded YouTube videos.');
		"],true);
	}
	if($info['video']){
		die("No Video Implemented");
		$body[]=HTML_element('video',[
			'src'=>''
		],[]);
	}
	if($info['img']){
		$body[]="`--PictureHtml--`$info[img]--`70--`";
	}
	
	foreach($info['familyListeners'] as $k=>$fl)
	{
		$present=[];
		if(!($present=array_filter($fl,function($flm){
			return $flm['chk'];
		}))){
			continue;
		}
		
		$body[]=FamButton(['name'=>$k]);
		foreach($present as $p)
		{
			$famSing=$famObs[$k]['singular'];
			$body[]=LargeDynTieButton($k, $p);
		}
		
	}
	array_unshift($pages,Page(
		// name
		$info['name'],
		// urlTarget
		MemHref($mainFam, $info['name']),
		// include in nav
		false,
		// body
		join("\n", $body),
		//title
		$info['name']." ($mainFamSing)",
		//description
		$info['shortDescription']
	));
}
function ProcessFamilyListener($info){
	
}
function ProcessDynTie($info){
	
}
function SortIfNeeded(&$info){
	if(array_search($info['name'],["Projects"]) !== false){
		usort($info['list'], function($a,$b){
			$acmp=$a['end'] ? $a['end'] : $a['start'];
			$bcmp=$b['end'] ? $b['end'] : $b['start'];
			if($acmp === $bcmp){return 0;}
			return ($acmp > $bcmp) ? -1 : 1;
			
		});
	}
}
function ProcessMainFamily(&$pages, $info){
	$append=[];
	SortIfNeeded($info);
	foreach($info['list'] as $l)
	{
		$append[]=LargeSubFamButton($info['name'], $l);
	}
	
	$append=join("\n", $append);
	array_unshift($pages,Page(
		// name
		$info['name'],
		// urlTarget
		UrlAndFileSafe($info['name']),
		// include in nav
		true,
		// body
		"<h1>$info[name]</h1><div><p class=\"shortDescriptions\">".$info['description']."</p></div>$append",
		//title
		$info['name'],
		//description
		$info['description']
	));
	
	SortIfNeeded($info);
	foreach($info['list'] as $l)
	{
		ProcessSubFamily($pages,$info['name'],$l);
	}
}

$pageExample=json_decode(file_get_contents("pageExample.json"), true);
function Page($name, $urlTarget, $includeInNav, $html, $title, $description){
	global $pageExample;
	
	$pe=$pageExample;
	
	$pe['name']=$name;
	$pe['urlTarget']=$urlTarget;
	$pe['navInclude']=$includeInNav;
	$pe['main']['html']=$html;
	$pe['meta']['general']['title']=$title;
	$pe['meta']['general']['description']=$description;
	
	return $pe;
}

$saveState=json_decode(file_get_contents('saved.json'),true);

$siteGenSave=json_decode(file_get_contents(siteGenPath),true);

$projects=&$siteGenSave['projects'];

$found=false;
foreach($projects as &$hireMe)
{
	//echo $hireMe['title'];
	if($hireMe['title'] === "gghireme.com"){
		$found=true;
		break;
	}
}
if(!$found){die("Error");}
//die(json_encode($hireMe));
//die(json_encode($hireMe['data']['pages'][0]));
$pages=[];
$hireMe['data']['pages']=array_filter($hireMe['data']['pages'], function($p){
	return array_search($p['name'],['Contact', 'Resume']) !== false;
});


$allFamObs=array_merge([$saveState['jobs']],$saveState['otherFams']);
foreach($allFamObs as $afo)
{
	$famObs[$afo['name']]=$afo;
}

//die($append);
//ProcessMainFamily($hireMe['data']['pages'],$saveState['jobs']);
ProcessMainFamily($pages,$saveState['jobs']);

foreach($saveState['otherFams'] as $of)
{
	ProcessMainFamily($pages,$of);
}

$body=[];
$body[]=HTML_element("h1", ['class'=>'parHeading'],["Greg Goad : Programming Portfolio"]);
$body[]=HTML_element("h2", ['class'=>'parHeading subHeading'],["Web Engineer For Hire"]);
$body[]=HTML_element("h2", ['class'=>'subHeading'],["Hundreds of Thousands of Lines of Code"]);
foreach($famObs as $fo)
{
	$body[]=BegFamButton($fo);
	SortIfNeeded($fo);
	foreach($fo['list'] as $l)
	{
		$body[]=LargeSubFamButton($fo['name'],$l);
	}
}
$body=join("\n",$body);

array_push($pages,Page(
	// name
	"Home",
	// urlTarget
	"",
	// include in nav
	true,
	// body
	$body,
	//title
	"Home",
	//description
	"My name is Greg Goad, and I am a full stack developer. Here is my portfolio."
));


$hireMe['data']['pages']=array_merge(array_reverse($pages),$hireMe['data']['pages']);
//die(json_encode($hireMe['data']['pages']));
file_put_contents(siteGenPath, json_encode($siteGenSave));
//die(json_encode($hireMe));

die("SUCCESS");
?>