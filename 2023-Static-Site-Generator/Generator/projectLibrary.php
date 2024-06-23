<?php 
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/unirep.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/deleteDirectory.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/ensureDirectory.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/copyDirectory.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/emptyDirectory.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/urlAndFileSafe.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sQuote.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/CSSSelectorSafe.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/github/jsObToJSON_liaz.php");
require_once("lessSupplement.php");

require_once("$_SERVER[DOCUMENT_ROOT]/../lessphp/lib/Less/Autoloader.php");
Less_Autoloader::register();

$LessParser=new Less_Parser();

require_once("rmfCopy.php");
require_once("stringSupplement.php");
require_once("htmlRenderFunctions.php");
require_once("adminRenderers.php");

define('defFolder','defaults-templates-patterns');

set_time_limit(0);

define('basicHtaccess', "RewriteCond %{REQUEST_FILENAME}.min -f
RewriteRule ^(.*)$ $1.min

RewriteCond %{HTTP_ACCEPT} image/webp
RewriteCond %{REQUEST_FILENAME}.webp -f
RewriteRule (.*) %{REQUEST_URI}.webp [T=image/webp]

RewriteCond %{HTTP:Accept-Encoding} br
RewriteCond %{REQUEST_FILENAME}.br -f
RewriteRule ^(.*)$ $1.br

<FilesMatch \"\.br$\">
	# Prevent mime module to set brazilian language header (because the file ends with .br)
	RemoveLanguage .br
	# Set the correct encoding type
	Header set Content-Encoding br
	# Force proxies to cache brotli & non-brotli files separately
	Header append Vary Accept-Encoding
</FilesMatch>

<IfModule mod_headers.c>
	<FilesMatch \"index\\.php\$\">
        Header set Cache-Control \"no-store, no-cache, must-revalidate, max-age=0\"
        Header set Pragma \"no-cache\"
        Header set Expires \"Wed, 11 Jan 1984 05:00:00 GMT\"
    </FilesMatch>
</IfModule>
<IfModule mod_deflate.c> 
    <FilesMatch \"\\.(js|css|html|xml|txt|json|ico|eot|svg|ttf|otf|php|js\\.min|css\\.min|html\\.min)\$\">
		AddOutputFilterByType DEFLATE text/html text/plain text/xml application/xml application/xhtml+xml text/css text/javascript application/javascript application/x-javascript application/rss+xml application/atom_xml image/svg+xml
		<IfModule mod_setenvif.c>
			BrowserMatch ^Mozilla/4 gzip-only-text/html
			BrowserMatch ^Mozilla/4\.0[678] no-gzip
			BrowserMatch \bMSIE !no-gzip !gzip-only-text/html
		</IfModule>
		<IfModule mod_headers.c>
			Header append Vary User-Agent env=!dont-vary
		</IfModule>
    </FilesMatch>
</IfModule>");

$UNIREP_computeFunctions['`--LiveSafeSwitch--`']=function($live, $local){
	global $UNIREP_liveOrLocal;
	if($UNIREP_liveOrLocal === "live"){
		return $live;
	}return $local;
};
$UNIREP_computeFunctions['`--ScriptInjection--`']=function($dir, ...$args){
	$scripts=[];
	$styles=[];
	foreach($args as $a)
	{
		array_push($scripts, file_get_contents("$_SERVER[DOCUMENT_ROOT]/$dir/$a.js"));
		if(is_file("$_SERVER[DOCUMENT_ROOT]/$dir/$a.css")){
			array_push($styles, file_get_contents("$_SERVER[DOCUMENT_ROOT]/$dir/$a.css"));
		}
	}
	$ret='';
	if($scripts){
		$ret.="<script>".join("\n", $scripts)."</script>";
	}
	if($styles){
		$ret.="<style>".join("\n", $styles)."</style>";
		
	}
	return $ret;
};
$UNIREP_computeFunctions['`--StyleInjection--`']=function($dir, ...$args){
	$styles=[];
	foreach($args as $a)
	{
		array_push($styles, file_get_contents("$_SERVER[DOCUMENT_ROOT]/$dir/$a.css"));
	}
	$ret='';
	if($styles){
		$ret.="<style>".join("\n", $styles)."</style>";
		
	}
	return $ret;
};


function GetProjectInfo($title){
	$globDat=json_decode(file_get_contents('appdata.json'),true);


	$titleArr=array_map(function($p){return $p['title'];},$globDat['projects']);

	$ind;
	if(($ind = array_search($title, $titleArr)) === false){
		die(json_encode(['success'=>false,'msg'=>'no title match']));
	}

	$projectInfo=$globDat['projects'][$ind];
	return $projectInfo;
}

function SaveProject($title, $dat){
	
	$globDat=json_decode(file_get_contents('appdata.json'),true);


	$titleArr=array_map(function($p){return $p['title'];},$globDat['projects']);

	$ind;
	if(($ind = array_search($title, $titleArr)) === false){
		die(json_encode(['success'=>false,'msg'=>'no title match']));
	}

	$projectInfo=$globDat['projects'][$ind];
	
	HandleIcons($projectInfo, $dat['top']['media']['iconSources']['icons']);
	HandleImages($projectInfo, $dat['top']['media']['imageSources']['images']);
	
	HandleGeneralFiles($projectInfo, $dat['top']['media']['videoSources']['videos'], 'video');
	//$dat['top']['media']['audioSources']['audios']=[];
	HandleGeneralFiles($projectInfo, $dat['top']['media']['audioSources']['audios'], 'audio');
	HandleGeneralFiles($projectInfo, $dat['top']['media']['generalSources']['generals'], 'general');

	$globDat['projects'][$ind]['data']=$dat;

	file_put_contents('appdata.json',json_encode($globDat));
	return $globDat;
}

function RenderProject($title){
	$globDat=json_decode(file_get_contents('appdata.json'),true);


	$titleArr=array_map(function($p){return $p['title'];},$globDat['projects']);

	$ind;
	if(($ind = array_search($title, $titleArr)) === false){
		die(json_encode(['success'=>false,'msg'=>'no title match']));
	}
	
	$projInfo=$globDat['projects'][$ind];
	$data=$projInfo['data'];
	
	
	
	
	switch($projInfo['type']){
		case "Basic":
			RenderBasicProject($data, $projInfo);
			break;
		default:
			die(json_encode(['success'=>false,'msg'=>'unavailable project type']));
			break;
	}


	
	
	
}

function HandleGeneralFiles($projectInfo, &$genFiles, $tp){
	$oldFiles=[];
	$filesDirectory="siteMedia/$projectInfo[slug]/{$tp}s";
	if(isset($projectInfo['data']['top']['media']["{$tp}Sources"]["{$tp}s"])){
		$oldFiles=$projectInfo['data']['top']['media']["{$tp}Sources"]["{$tp}s"];
	}
	
	$sav=[];
	//die(json_encode(['success'=>false, 'msg'=>'test', 'data'=>$images]));
	foreach($genFiles as &$gf)
	{
		if(!isset($gf['name']) || @(!$gf['name'])){
			die(json_encode(['success'=>false, 'msg'=>'no name', 'data'=>$gf]));
		}
		$ch=UrlAndFileSafe($gf['name']);
		if(isset($sav[$ch])){
			die(json_encode(['success'=>false, 'msg'=>'Duplicate File Slug']));
		}
		$sav[$ch]=true;
		$gf['slug']=$ch;
	}
	unset($gf);
	
	$oldSlugs=array_map(function($m){return $m['slug'];},$oldFiles);
	$newSlugs=array_map(function($m){return $m['slug'];},$genFiles);
	$newOgSlugs=array_map(function($m){return $m['ogSlug'];}, $genFiles);
	
	//die(json_encode(['success'=>false, 'msg'=>'should have deleted', 'data'=>['new'=>$newSlugs, 'old'=>$oldSlugs]]));
	foreach($oldSlugs as $n)
	{
		if(!$n){
			die(json_encode(['success'=>false, 'msg'=>'Something went wrong and an file "n" was empty.']));
			
		}

		if(array_search($n, $newOgSlugs)===false){
			//die(json_encode(['success'=>false, 'msg'=>'should have deleted']));
			DeleteDirectory("$filesDirectory/$n");
		}
	}
	
	foreach($genFiles as $i=>&$gf)
	{
		$oldFileInf=false;
		if($gf['ogSlug']){
			$oldFileInf=array_search($gf['ogSlug'], $oldSlugs);
			if($oldFileInf !== false){
				$oldFileInf=$oldFiles[$oldFileInf];
			}
		}
		
		$gf['src']=HandleGeneralFile($projectInfo, $gf, $oldFileInf, $tp,$i);
		
		unset($gf['ogName']);unset($gf['ogSlug']);unset($gf['srcChange']);
		
		if(isset($gf['renders'])){
			foreach($gf['renders'] as &$r)
			{
				$r['src']="siteMedia/$projectInfo[slug]/{$tp}s/$gf[slug]/$r[sizeType].$r[renderType]";
				unset($r['og']);
			}
		}
	}
}
function HandleGeneralFile($projectInfo, $genInfo, $oldInfo, $tp, $index){
		$filesDir="siteMedia/$projectInfo[slug]/{$tp}s";
	EnsureDirectory($filesDir);
	
	$newSlug=UrlAndFileSafe($genInfo['name']);
	$genInfo['slug']=$newSlug;
	
	if($oldInfo){
		$thisFileDir=$filesDir."/$oldInfo[slug]";
		if($genInfo['srcChange']){
			EmptyDirectory($thisFileDir);
		}
		if($oldInfo['name'] !== $genInfo['name']){
			rename($thisFileDir.'/', $filesDir."/$newSlug/");
			$thisFileDir="$filesDir/$newSlug";
			if($tp === 'general'){
				rename("$thisFileDir/$oldInfo[name]", "$thisFileDir/$genInfo[name]");
			}
		}
		
	}
	$curFileDir="$filesDir/$newSlug";
	EnsureDirectory($curFileDir);
	


	if($tp === 'general'){
		$nm="$curFileDir/$genInfo[name]";
	}else{
		$srcType=$genInfo['srcType'];
		$nm="$curFileDir/source.$srcType";
	}
	if($genInfo['srcChange']){	
		move_uploaded_file($_FILES["{$tp}{$index}"]['tmp_name'], $nm);
	}
	return $nm;
	foreach($genInfo['renders'] as $r)
	{
		if($r['og']){
			continue;
		}
		//file_put_contents("$curImageDir/$r[sizeType].$r[renderType]", base64_decode(explode(',',$r['src'])[1]));
	}
}

function HandleImages($projectInfo, &$images){
	// The future bug of renaiming images similar names can be shimmed in this function
	$oldImages=[];
	$imagesDirectory="siteMedia/$projectInfo[slug]/images";
	if(isset($projectInfo['data']['top']['media']['imageSources']['images'])){
		$oldImages=$projectInfo['data']['top']['media']['imageSources']['images'];
	}
	
	$sav=[];
	//die(json_encode(['success'=>false, 'msg'=>'test', 'data'=>$images]));
	foreach($images as &$im)
	{
		if(!isset($im['name']) || @(!$im['name'])){
			die(json_encode(['success'=>false, 'msg'=>'no name', 'data'=>$im]));
		}
		$ch=UrlAndFileSafe($im['name']);
		if(isset($sav[$ch])){
			die(json_encode(['success'=>false, 'msg'=>'Duplicate Image Slug']));
		}
		$sav[$ch]=true;
		$im['slug']=$ch;
	}
	unset($im);
	
	$oldSlugs=array_map(function($m){return $m['slug'];},$oldImages);
	$newSlugs=array_map(function($m){return $m['slug'];},$images);
	$newOgSlugs=array_map(function($m){return $m['ogSlug'];}, $images);
	
	//die(json_encode(['success'=>false, 'msg'=>'should have deleted', 'data'=>['new'=>$newSlugs, 'old'=>$oldSlugs]]));
	foreach($oldSlugs as $n)
	{
		if(!$n){
			die(json_encode(['success'=>false, 'msg'=>'Something went wrong and an image "n" was empty.']));
			
		}

		if(array_search($n, $newOgSlugs)===false){
			//die(json_encode(['success'=>false, 'msg'=>'should have deleted']));
			DeleteDirectory("$imagesDirectory/$n");
		}
	}
	
	foreach($images as &$im)
	{
		$oldImageInf=false;
		if($im['ogSlug']){
			$oldImageInf=array_search($im['ogSlug'], $oldSlugs);
			if($oldImageInf !== false){
				$oldImageInf=$oldImages[$oldImageInf];
			}
		}
		
		HandleImage($projectInfo, $im, $oldImageInf);
		
		$im['src']="siteMedia/$projectInfo[slug]/images/$im[slug]/source.$im[srcType]";
		unset($im['ogName']);unset($im['ogSlug']);unset($im['srcChange']);
		
		foreach($im['renders'] as &$r)
		{
			$ss=str_replace($r['renderType'].'_', '', $r['sizeType']);
			$r['src']="siteMedia/$projectInfo[slug]/images/$im[slug]/$ss.$r[renderType]";
			unset($r['og']);
		}
		
	}
}
function HandleImage($projectInfo, $imageInfo, $oldInfo){
	$imagesDir="siteMedia/$projectInfo[slug]/images";
	EnsureDirectory($imagesDir);
	
	$newSlug=UrlAndFileSafe($imageInfo['name']);
	$imageInfo['slug']=$newSlug;
	
	if($oldInfo){
		$thisImageDir=$imagesDir."/$oldInfo[slug]";
		if($imageInfo['srcChange']){
			EmptyDirectory($thisImageDir);
		}else{
			$oldSizes=array_map(function($m){return $m['sizeType'];},$oldInfo['renders']);
			//$srcType=$oldInfo['srcType'];
			$newSizes=array_map(function($m){return $m['sizeType'];},$imageInfo['renders']);
			$srcTypes=array_map(function($m){return $m['renderType'];}, $oldInfo['renders']);
			foreach($oldSizes as $i=>$s)
			{
				if(array_search($s, $newSizes) === false){
					$ss=str_replace($srcTypes[$i].'_', '', $s);
					@unlink("$thisImageDir/{$ss}.".$srcTypes[$i]);
				}
			}
			
		}
		if($oldInfo['name'] !== $imageInfo['name']){
			rename($thisImageDir.'/', $imagesDir."/$newSlug/");
			$thisImageDir="$imagesDir/$newSlug";
		}
		
	}
	$curImageDir="$imagesDir/$newSlug";
	EnsureDirectory($curImageDir);
	$srcType=$imageInfo['srcType'];
	if($imageInfo['srcChange']){
		file_put_contents("$curImageDir/source.$srcType", base64_decode(explode(',',$imageInfo['src'])[1]));
	}
	
	foreach($imageInfo['renders'] as $r)
	{
		if($r['og']){
			continue;
		}
		$ss=str_replace($r['renderType'].'_',"", $r['sizeType']);
		file_put_contents(str_replace('.webp.webp','.png.webp',"$curImageDir/$ss.$r[renderType]"), base64_decode(explode(',',$r['src'])[1]));
	}
}

function HandleIcons($projectInfo, &$icons){
	// The future bug of renaiming icons similar names can be shimmed in this function
	$oldIcons=[];
	$iconsDirectory="siteMedia/$projectInfo[slug]/icons";
	if(isset($projectInfo['data']['top']['media']['iconSources']['icons'])){
		$oldIcons=$projectInfo['data']['top']['media']['iconSources']['icons'];
	}
	
	$sav=[];
	//die(json_encode(['success'=>false, 'msg'=>'test', 'data'=>$icons]));
	foreach($icons as &$ic)
	{
		if(!isset($ic['name']) || @(!$ic['name'])){
			die(json_encode(['success'=>false, 'msg'=>'no name', 'data'=>$ic]));
		}
		$ch=UrlAndFileSafe($ic['name']);
		if(isset($sav[$ch])){
			die(json_encode(['success'=>false, 'msg'=>'Duplicate Icon Slug']));
		}
		$sav[$ch]=true;
		$ic['slug']=$ch;
	}
	unset($ic);
	
	$oldSlugs=array_map(function($m){return $m['slug'];},$oldIcons);
	$newSlugs=array_map(function($m){return $m['slug'];},$icons);
	$newOgSlugs=array_map(function($m){return $m['ogSlug'];}, $icons);
	
	//die(json_encode(['success'=>false, 'msg'=>'should have deleted', 'data'=>['new'=>$newSlugs, 'old'=>$oldSlugs]]));
	foreach($oldSlugs as $n)
	{
		if(!$n){
			die(json_encode(['success'=>false, 'msg'=>'Something went wrong and an icon "n" was empty.']));
		}

		if(array_search($n, $newOgSlugs)===false){
			//die(json_encode(['success'=>false, 'msg'=>'should have deleted']));
			DeleteDirectory("$iconsDirectory/$n");
		}
	}
	
	foreach($icons as &$ic)
	{
		$oldIconInf=false;
		if($ic['ogSlug']){
			$oldIconInf=array_search($ic['ogSlug'], $oldSlugs);
			if($oldIconInf !== false){
				$oldIconInf=$oldIcons[$oldIconInf];
			}
		}
		
		HandleIcon($projectInfo, $ic, $oldIconInf);
		
		$ic['src']="siteMedia/$projectInfo[slug]/icons/$ic[slug]/source.$ic[srcType]";
		unset($ic['ogName']);unset($ic['ogSlug']);unset($ic['srcChange']);
		
		foreach($ic['renders'] as &$r)
		{
			$r['src']="siteMedia/$projectInfo[slug]/icons/$ic[slug]/$r[size].$ic[srcType]";
			unset($r['og']);
		}
		
	}
	
}
function HandleIcon($projectInfo, $iconInfo, $oldInfo){
	$iconsDir="siteMedia/$projectInfo[slug]/icons";
	EnsureDirectory($iconsDir);
	
	$newSlug=UrlAndFileSafe($iconInfo['name']);
	$iconInfo['slug']=$newSlug;
	
	if($oldInfo){
		$thisIconDir=$iconsDir."/$oldInfo[slug]";
		if($iconInfo['srcChange']){
			EmptyDirectory($thisIconDir);
		}else{
			$oldSizes=array_map(function($m){return $m['size'];},$oldInfo['renders']);
			$srcType=$oldInfo['srcType'];
			$newSizes=array_map(function($m){return $m['size'];},$iconInfo['renders']);
			foreach($oldSizes as $s)
			{
				if(array_search($s, $newSizes) === false){
					@unlink("$thisIconDir/{$s}.$srcType");
				}
			}
			
		}
		if($oldInfo['name'] !== $iconInfo['name']){
			rename($thisIconDir.'/', $iconsDir."/$newSlug/");
			$thisIconDir="$iconsDir/$newSlug";
		}
		
	}
	$curIconDir="$iconsDir/$newSlug";
	EnsureDirectory($curIconDir);
	$srcType=$iconInfo['srcType'];
	if($iconInfo['srcChange']){
		file_put_contents("$curIconDir/source.$srcType", base64_decode(explode(',',$iconInfo['src'])[1]));
	}
	
	foreach($iconInfo['renders'] as $r)
	{
		if($r['og']){
			continue;
		}
		file_put_contents("$curIconDir/$r[size].$srcType", base64_decode(explode(',',$r['src'])[1]));
	}
	
}

function CalcLocalDirectory($slug){
	return __DIR__."/previews/$slug";
}
function CalcLiveDirectory($slug){
	return __DIR__."/renders/$slug";
}

function RenderBasicProject($dat, $projectInfo){
	global $UNIREP_computeFunctions;
	global $LessParser;
	
	$DD=new DOMDocument();
	$contactForms=$dat['top']['admin']['contactForms']['list'];
	$recapProtContent=$dat['top']['main']['recapProtContent'];
	$cookieManagerSiteCookies=[];
	
	$globalLESS=$dat['top']['main']['globalLESS'];
	
	if($dat['top']['main']['cookieManager']['include']){
		$cm=$dat['top']['main']['cookieManager'];
		$stds=$cm['standards'];
		foreach($stds as $st)
		{
			array_push($cookieManagerSiteCookies, "$st:".file_get_contents("cookieManager/$st.js"));
		}
		foreach($cm['customs'] as $cust)
		{
			array_push($cookieManagerSiteCookies, "$cust[name]:{
				name:".sQuote($cust['name']).",
				readableName:".sQuote($cust['readableName']).",
				category:".sQuote($cust['category']).",
				description:$cust[description],
				added:false,
				level:".(($cust['required']) ? sQuote('any'): 'false').",
				required:".(($cust['required'])?'true':'false').",
				listeners:[],
				adder:''
			}");
		}
	}
	$cookieManagerSiteCookies="{".join(",",$cookieManagerSiteCookies)."}";
	//echo 'yo';
	
	$UNIREP_computeFunctions['`--ContactForm--`']=function($name) use ($contactForms){
		//echo 'here';
	//	echo json_encode($contactForms);
		$inpGen=function($i) use ($name){

			$safeName=str_replace(' ','-', $name);
			$id="contactForm-$safeName-$i[name]";
			$inpProps=[
				'id'=>$id,
				'name'=>$i['name']
			];
			$labelProps=[
				'for'=>$id
			];
			if($i['required']){
				$inpProps['required']='';
			}
			
			$ret=[];
			if($i['labelText']){
				array_push($ret, HTML_element('label', $labelProps, [$i['labelText']]));
			}
			switch($i['type']){
				case "paragraph":
					if($i['maxLength']){
						$inpProps['maxLength']=$i['maxLength'];
					}
					if($i['placeholder']){
						$inpProps['placeholder']=$i['placeholder'];
					}
					if($i['pattern']){
						$inpProps['pattern']=$i['pattern'];
					}
					array_push($ret, HTML_element('textArea',$inpProps, [$i['default']]));
					break;
				case "text":
					$inpProps['autocomplete']='on';
					if($i['subType']){
						$inpProps['type']=$i['subType'];
						if($i['subType'] === 'tel'){
							$inpProps['autocomplete']='tel';
						}
					}
					if($i['maxLength']){
						$inpProps['maxLength']=$i['maxLength'];
					}
					if($i['pattern']){
						$inpProps['pattern']=$i['pattern'];
					}
					if($i['placeholder']){
						$inpProps['placeholder']=$i['placeholder'];
					}
					if($i['default']){
						$inpProps['value']=$i['default'];
					}
					array_push($ret, HTML_element('input', $inpProps));
					break;
				case "select":
					$opts=[];
					if($i['salutation']){
						array_push($opts, ['tag'=>'option','properties'=>['value'=>'', 'disabled'=>'', 'selected'=>'', 'hidden'=>''], 'children'=>[$i['salutation']]]);
					}
					foreach($i['options'] as $o)
					{
						array_push($opts, ['tag'=>'option','properties'=>['value'=>$o], 'children'=>[$o]]);
					}
					array_push($ret, HTML_element('select',$inpProps, $opts));
					break;
				case "image":
					$maxSize=$i['maxSize'];
					$maxSizeSuff='KB';
					if($i['maxSize'] > 1000){
						$maxSizeSuff='MB';
						$maxSize=floor(intval($i['maxSize'])/1000);
					}
					$maxSize="{$maxSize}{$maxSizeSuff}";
					
					$inpProps['type']='file';
					if($i['accept']){
						$inpProps['accept']=join(',',$i['accept']);
					}
					$inpProps['onchange']="if(this.files[0].size/1024 > $i[maxSize]){this.value=''; SoftNotification.Render('File size exceeded.');}";
					array_push($ret, HTML_element("input", $inpProps));
					array_push($ret, HTML_element('br'));
					array_push($ret, HTML_element('span',['class'=>'ContactForm-Form-ExtraInfo'],["Max {$maxSize}"]));
					break;
				case "imageMulti":
					$maxSize=$i['maxSize'];
					$maxSizeSuff='KB';
					if($i['maxSize'] > 1000){
						$maxSizeSuff='MB';
						$maxSize=floor(intval($i['maxSize'])/1000);
					}
					$maxSize="{$maxSize}{$maxSizeSuff}";
					
					$maxFiles=$i['maxNumFiles'];
					$maxFilesSuff=((intval($i['maxNumFiles']) > 1) ? ' Files' : ' File');
					
					$maxFiles="{$maxFiles}$maxFilesSuff";
					
					$inpProps['type']='file';
					$inpProps['name'].='[]';
					$inpProps['multiple']='';
					if($i['accept']){
						$inpProps['accept']=join(',',$i['accept']);
					}
					
					$inpProps['onchange']="if(this.files.length > $i[maxNumFiles]){this.value=''; SoftNotification.Render('Max number of files exceeded.'); return;}if(Array.from(this.files).reduce(function(acc,curr){return acc+curr.size;},0)/1024 > $i[maxSize]){this.value=''; SoftNotification.Render('File size exceeded.');}";
					array_push($ret, HTML_element("input", $inpProps));
					array_push($ret, HTML_element('br'));
					array_push($ret, HTML_element('span',['class'=>'ContactForm-Form-ExtraInfo'],["Max {$maxSize} : $maxFiles"]));
					
					break;
				default: 
					die("Invalid input type");
					break;
			}
			return join("\n",$ret);
		};
		
		
		$found='';
		$fileName=preg_replace('/[^A-Za-z0-9]/','_',$name);
		$safeName=str_replace(['-'],'_',$name);
		foreach($contactForms as $cf)
		{
			//echo $cf['formName'].' '.$name;
			if($cf['formName'] === $name){$found=$cf; break;}
		}
		if(!$found){return '';}
		$jsValidation='';
		$jsValidationCall='';
		if($cf['jsValidation']){
			$jsValidation="function ContactForm_{$safeName}_Validation(frm){{$cf[jsValidation]}};";
			$jsValidationCall="if(!ContactForm_{$safeName}_Validation(frm)){return;}";
		}
		$className="contactForm";
		$id='';
		if($cf['id']){
			$id="id=\"$cf[id]\"";
		}
		if($cf['class']){
			$className.=" $cf[class]";
		}
		$className="class=\"$className\"";
		
		$formProps=[$className, $id, "method=\"POST\"", "name=\"contactForm-$safeName\""];
		$formProps=array_filter($formProps);
		
		if(!$cf['headerLevel']){
			$cf['headerLevel']='2';
		}
		$header='';
		if($cf['header']){
			$header=HTML_element("h$cf[headerLevel]",[],[$cf['header']]);
		}
		
		$inputs=[];
		foreach($cf['inputs'] as $inp)
		{
			array_push($inputs, $inpGen($inp));
		}
		
			array_push($inputs, '<br><br>');
			
			//array_push($inputs, HTML_element('button', [],['Submit']));
		//
		$formProps=' '.join(' ',$formProps).' ';
		$inputs=join("\n", $inputs);
		return "<script>
			$jsValidation
			function ContactForm_{$safeName}_Submit(frm){
				var fd=new FormData(frm);
					  var comEl=document.getElementById('ContactForm-$safeName-CommunicatorEl');
				_el.APPEND(comEl, 'Performing the Recaptcha Check...');
				frm.setAttribute('disabled','');
				$jsValidationCall
				if(!window.grecaptcha || !window.grecaptcha.ready){
					_el.EMPTY(comEl);
					_el.APPEND(comEl, ['The Google Recaptcha library failed to load. You may be disconnected from the internet. Please try again later. ', _el.CREATE('button','','',{onclick:function(){_el.EMPTY(this.parentNode);}},['Dismiss'])]);
					return;
				}
				grecaptcha.ready(function() {
				  grecaptcha.execute('`--RECAPTCHA-PublicKey--`', {action: 'ContactForm/{$fileName}/submit'}).then(function(token) {
					  fd.append('recaptchaToken', token);
					  _el.EMPTY(comEl);
					  frm.removeAttribute('disabled');
					  ElFetch(comEl, 'Sending your information', '`--AbsolutePrefix--`/contactForms_/{$fileName}.php', {method:'POST', body:fd}, 'text',{
						  success:function(){
							  _el.EMPTY(comEl);
							  _el.APPEND(comEl, ['Your Form Was Submitted: ' , _el.CREATE('button','','',{onclick:function(){_el.EMPTY(this.parentNode);}},['Dismiss'])]);
							  _el.EMPTY(frm);
							  _el.APPEND(frm, _el.CREATE('h3','','',{},['Your Submission was Received! Thank you.']));
						  },
						  fail:function(){_el.EMPTY(comEl);_el.APPEND(comEl, ['Your Form Submission Failed ' , _el.CREATE('button','','',{onclick:function(){_el.EMPTY(this.parentNode);}},['Dismiss'])]);}
					  },{
						  form:frm
					  });
				  });
				});
			}
		</script><form onsubmit=\"_el.CancelEvent(event); ContactForm_{$safeName}_Submit(this);\"$formProps>
			$header
			$inputs
			<div id=\"contactForm-$safeName-submitTarget\">
			<noscript>This form uses Recaptcha. Because of this, it is required for JavaSript to be enabled to use this form. Submitting this form without JavaScript will cause it to be rejected automatically.</noscript>
<script>
CookieManager.GetPermission(\"grecaptcha\", (VCR.main.currentTarget || document).querySelector('#contactForm-$safeName-submitTarget'), function(){
   _el.APPEND((VCR.main.currentTarget || document).querySelector('#contactForm-$safeName-submitTarget'), [
      _el.CREATE('button','','contactFormSubmitButton',{},['Submit']),
	  _el.CREATE('div','','',{},[_el.CREATE('span','','',{},['This site is protected by reCAPTCHA (A Google Service) ',_el.CREATE('br'), 'See Google\'s ',_el.CREATE('a','','',{href:'https://policies.google.com/privacy'},['Privacy Policy']), ' and ',_el.CREATE('a','','',{href:'https://policies.google.com/terms'},['Terms of Service'])])])
   ]);
}, 'for the submit button.');
</script>
</div>
<br><br>
Visit our `--PrivacyPolicy-Link--`
<div id=\"ContactForm-$safeName-CommunicatorEl\" class=\"ContactForm-CommunicatorEls\"></div>
		</form>";
	};
	//die(" ,,,,, ".json_encode($dat));
	
	$UNIREP_computeFunctions['`--RecapProtContent--`']=function($name) use ($recapProtContent){
		$foundRpc=false;
		foreach($recapProtContent as $rpc) 
		{
			if($rpc['title'] === $name){
				$foundRpc=$rpc;
				break;
			}
		}
		if(!$foundRpc){die("Failed to find RPC");}
		
		$fileName=preg_replace('/[^A-Za-z0-9_]/','_',$foundRpc['title']);
		return "<div id=\"RPC-$fileName\">
		<noscript>Sorry, but scripting is required for this section to function.</noscript>
		<script>
		CookieManager.GetPermission(\"grecaptcha\", (VCR.main.currentTarget || document).querySelector('#RPC-$fileName'), function(){
		   _el.APPEND((VCR.main.currentTarget || document).querySelector('#RPC-$fileName'), [
		      _el.CREATE('div','','',{},[$foundRpc[explanation]]),
			  _el.CREATE('button','','RPC-ChallengeButton',{onclick:function(){
				  var t=this;
				  var comEl=document.getElementById('RPC-$fileName-CommunicatorEl');
					_el.APPEND(comEl,'Performing Recaptcha Challenge');
				  grecaptcha.ready(function() {
					  grecaptcha.execute('`--RECAPTCHA-PublicKey--`', {action: 'RPC/{$fileName}'}).then(function(token) {
						  var fd=new FormData();
						  fd.append('recaptchaToken', token);
						  _el.EMPTY(comEl);
						  ElFetch(comEl, 'Requesting Information', '`--AbsolutePrefix--`/recapProtContent_/{$fileName}/request.php', {method:'POST', body:fd}, 'json',{
							  success:function(jsn){
								  _el.EMPTY(comEl);
								  var tar=document.querySelector('#RPC-$fileName');
								  
								  _el.EMPTY(tar);
								  tar.innerHTML=jsn.html;
							  },
							  fail:function(){
								  _el.EMPTY(comEl);
								  _el.APPEND(comEl,'Your request failed.');
							  }
						  },{
							  button:t
						  });
					  });
					});
			  }},[$foundRpc[buttonText]]),
			  _el.CREATE('div','RPC-$fileName-CommunicatorEl','',{}),
			  _el.CREATE('div','','',{},[_el.CREATE('span','','',{},['This section is protected by reCAPTCHA (A Google Service) ',_el.CREATE('br'), 'See Google\'s ',_el.CREATE('a','','',{href:'https://policies.google.com/privacy'},['Privacy Policy']), ' and ',_el.CREATE('a','','',{href:'https://policies.google.com/terms'},['Terms of Service'])])])
		   ]);
		}, 'to view '+$foundRpc[contentDescription]);
		</script>
		</div>";
		
	};
	
	$otherDynPat=[
		'`--HamburgerButton--`'=>'',
		'`--CSS-Hamburger-TabletBreakpoint--`'=>'',
		'`-CSS-Hamburger--`'=>'',
		'`--CSS-MainMinHeight--`'=>'',
		'`--History-ScrollRestore--`'=>'',
		'`--JS-histLgger--`'=>'lgger=this.LOG_change;',
		'`--CopyWrite--`'=>'<div id="copyWriteText">'.$dat['top']['main']['copyWriteText'].'</div>',
		'`--PrettyMarginMax--`'=>'775'
	];
	
	$prettyMarginMax=$otherDynPat['`--PrettyMarginMax--`'];
	
	
	
	$secSecureFolder="WAA_siteGen_".$dat['top']['main']['secureFolder'];
	
	$localDirectory=CalcLocalDirectory($projectInfo['slug']);
		$localPubDirectory=$localDirectory;
		$localSecDirectory="$_SERVER[DOCUMENT_ROOT]/../".$secSecureFolder;
	$liveDirectory=CalcLiveDirectory($projectInfo['slug']);
		$livePubDirectory=$liveDirectory."/".$dat['top']['main']['livePubFolder'];
		$liveSecDirectory="$liveDirectory/".$secSecureFolder;
	
	//jsLibs, jsCore
	EnsureDirectory($localPubDirectory);
		EnsureDirectory("$localPubDirectory/js_library");
			EmptyDirectory("$localPubDirectory/js_library");
		EnsureDirectory("$localPubDirectory/js_core");
			EmptyDirectory("$localPubDirectory/js_core");
	
	EnsureDirectory($livePubDirectory);
		EnsureDirectory("$livePubDirectory/js_library");
			EmptyDirectory("$livePubDirectory/js_library");
		EnsureDirectory("$livePubDirectory/js_core");
			EmptyDirectory("$livePubDirectory/js_core");
	
	EnsureDirectory($liveSecDirectory);
		EmptyDirectory($liveSecDirectory);
	EnsureDirectory($localSecDirectory);
		EmptyDirectory($localSecDirectory);
		
	if(!is_file("projectPageHashes.json")){
		file_put_contents("projectPageHashes.json", "{}");
	}
	$pageHashes=json_decode(file_get_contents("projectPageHashes.json"),true);
	if(!isset($pageHashes[$projectInfo['slug']])){
		$pageHashes[$projectInfo['slug']]=[];
	}
	$projectPageHashes=$pageHashes[$projectInfo['slug']];
	
	$mainDocument=file_get_contents(defFolder.'/mainDocument.html.temp');
	
	$mainHTML=$dat['top']['main']['html'];
	
	if($dat['top']['main']['privacyPolicy']['include'] && $dat['top']['main']['privacyPolicy']['autoFooter']){
		//$mainHTML=str_replace("</footer>", "`--PrivacyPolicy-Link--`<br></footer>",$mainHTML);
	}
	if($dat['top']['main']['cookieManager']['launchInFooter'] && $dat['top']['main']['cookieManager']['include']){
		$mainHTML=str_replace("</footer>","`--CookieManager-LaunchButton--`</footer>",$mainHTML);
	}
	
	$globalPat=[
		'`--Doctype--`'=>'<!DOCTYPE html>',
		//'`--HtmlProperties--`'=>'`--HTMLPrefix--`',
		'`--HeadProperties--`'=>'',
		'`--BodyProperties--`'=>" class=\"`--ActiveViewClass--`\"",
		'`--HeadContent--`'=>"`--SEOContent--`\n`--HeadScriptsNStyles--`",
		//'`--BodyProperties--`'=>'',
		'`--BodyContent--`'=>$mainHTML
	];
	$mainPat=[];
	foreach($dat['top']['unirep']['unirepList'] as $l)
	{
		$mainPat[$l['tag']]=$l['value'];
		if($l['tag'] === "`--PrettyMarginMax--`"){$prettyMarginMax=$l['value'];}
	}
	$mainPat['`--SecureFolder--`']= $secSecureFolder;
	$colorPalletArray=[];
	foreach($dat['top']['main']['colorPallet'] as $colorP)
	{
		$colorPalletArray[$colorP['key']]=$colorP['value'];
	}
	
	$breakpointArray=[];
	foreach($dat['top']['main']['mediaBreakpoints'] as $bp)
	{
		$breakpointArray[$bp['key']]=$bp['value'];
	}
	
	
	
	$pictureRepArray=[];
	
	$imageStateSaver=$dat['top']['media']['imageSources']['images'];
	$UNIREP_computeFunctions['`--PictureHtml--`']=function($name, $size='95', $sizeType="percentageMax", $stretchy="static") use ($imageStateSaver){
		return "<picture>`--PictureSourceList--`$name--`$size--`$sizeType--`$stretchy--`</picture>";
	};
	$UNIREP_computeFunctions['`--PictureSourceList--`']=function($name, $size='95', $sizeType='percentageMax', $stretchy="static") use ($imageStateSaver, $prettyMarginMax){
		$im=false;
		$size=intval($size);
		foreach($imageStateSaver as $iss)
		{
			if($iss['name'] === $name){$im=$iss; break;}
		}
		if(!$im){
			die("Fatal Error: there was no image with that name: $name");
		}
		$srcs=[];
		$rend=$im['renders'];
		$getOffsetValue=function($str){if($str === 'webp'){return 0.5;}return 0.25;};
		usort($rend, function($a,$b) use ($getOffsetValue){return ($b['width'])-($a['width']);});
		$rend=array_filter($rend, function($m){return strpos($m['renderType'], 'webp') === false;});
		$rend=array_values($rend);
		$lastSize='';
		foreach($rend as $i=>$r)
		{
			$src=explode('/images/',$r['src'])[1];
			$med='0';
			$combArr=[];
			
			if($sizeType === 'percentage'){
				$med=intval((100/$size)*$r['width']);
			}else if($sizeType === 'percentageMax'){
				if($r['width'] > $prettyMarginMax){
					 continue;
				}
				$med=intval((100/$size)*$r['width']);
			}else if($sizeType === 'padding'){
				$med=($r['width']+$size);
			}else{
				die("Invalid size type: $sizeType");
			}
			//echo(intval($i).' '.(count($rend)-1).'::: ' );
			if(intval($i) === count($rend)-1){$med=1;}
			$med=max(1, $med);
			if($stretchy === 'static'){
				$combArr['width']=$r['width'];
				$combArr['height']=$r['height'];
			}
			$sz="`--AbsolutePrefix--`/media/images/$src";
			array_push($srcs, HTML_element('source',array_merge([
				'srcset'=>"$sz".PrepAppIfExists(' 1x, ',$lastSize,' 2x'),
				'media'=>"(min-width:{$med}px)",
				'type'=>mime_content_type($r['src'])
			],$combArr)));
			$lastSize=$sz;
			if($med === 1){break;}
		}
		$src=explode('/images/',$im['src'])[1];
		
		$sz=getimagesize($im['src']);
		$combArr=[];
		if($stretchy === 'static'){
			$combArr['width']=$sz[0];
			$combArr['height']=$sz[1];
		}
		array_push($srcs, HTML_element('img',array_merge(['src'=>"`--AbsolutePrefix--`/media/images/$src",'alt'=>$im['altText']],$combArr)));
		return join("\n",$srcs);
	};
	
	
	$pages=$dat['pages'];
	$pageNameArray=array_map(function($m){return strtolower($m['name']);},$pages);
	$homePageIndex=array_search('home',$pageNameArray);
	$siteNavMeta=$pages[$homePageIndex]['meta'];
	$siteNavMeta['general']['title']='Site Navigation';
	$siteNavMeta['general']['description']='Use this page to easily get around our site.';
	$htmlSaver;
	$siteNavOb;
	
	$igFunction='';
	if($dat['top']['main']['hamburgerButton']){
		$igFunction='VCR.main.ToggleNav(true);';
	}
	
	array_push($pages, [
		'main'=>['CSSList'=>[],'JSList'=>[],'html'=>'<h1>Select a Page</h1><nav>`--NavButtons--`'.($dat['top']['main']['privacyPolicy']['include'] ? HTML_element('a',[
				'href'=>'`--AbsolutePrefix--`/privacy-policy.html',
			],[
				[
					'tag'=>'div',
					'properties'=>['class'=>'basicNavButton','id'=>"viewButton-PrivacyPolicy"],
					'children'=>['Privacy Policy'],
					'raw'=>true
				]
			], true) : '').'</nav>','igniterFunction'=>$igFunction,'resourceType'=>'document'],
		'sitemap'=>['include'=>true,'changeFrequency'=>'','priority'=>''],
		'unirep'=>['unirepList'=>[]],
		'meta'=>$siteNavMeta,
		'name'=>'siteNav',
		'navInclude'=>false,
		'navOrder'=>'0',
		'navTextOverride'=>'',
		'urlTarget'=>'siteNav'
		
	]);
	
	
	
	$ppp=$dat['pages'];
	$UNIREP_computeFunctions['`--PageButton--`']=function($page, $content, $id="", $class="") use ($ppp){
		$pageNames=array_map(function($m){return $m['name'];}, $ppp);
		$p=$ppp[array_search($page,$pageNames)];
		if($id){$id=" id=\"$id\"";}
		if($class){$class=" $class";}
		return "<a href=\"`--AbsolutePrefix--`/$p[urlTarget]\" class=\"invisiAnchors\"><span{$id} class=\"pageButton $class\" onclick=\"VCR.main.EventCHANGE(event, '$p[name]');\">$content</span></a>";
	};
	
	$UNIREP_computeFunctions['`--PageButton-JSON--`']=function($arg) use ($ppp){
		//die($arg);
		//die(\OviDigital\JsObjectToJson\JsConverter::convertToJson($arg));
		$arg=loose_json_decode($arg);
		//die(json_encode($arg));
		ObVarSet($arg,'page',$page);
		
		$pageNames=array_map(function($m){return $m['name'];}, $ppp);
		$p=$ppp[array_search($page,$pageNames)];
		ObVarSet($arg,'anchorProperties', $anchorProperties, true);
		if(!$anchorProperties){
			$anchorProperties=[];
		}
		
		//$anchorProperties=json_decode($anchorProperties, true);
		$anchorProperties['href']="`--AbsolutePrefix--`/$p[urlTarget]";
		if(!isset($anchorProperties['class'])){$anchorProperties['class']='';}
		$anchorProperties['class']="invisianchors".PrepIfExists(' ',$anchorProperties['class']);
		
		ObVarSet($arg,'buttonProperties', $buttonProperties, true);
		if(!$buttonProperties){
			$buttonProperties=[];
		}
		
		//$buttonProperties=json_decode($buttonProperties, true);
		if(!isset($buttonProperties['class'])){$buttonProperties['class']='';}
		$buttonProperties['class']='pageButton'.PrepIfExists(' ',$buttonProperties['class']);
		$buttonProperties['onclick']="VCR.main.EventCHANGE(event, '$p[name]');";
		
		ObVarSet($arg,'content', $content, true);
		
		
		
		$buttonProperties=HTML_parseProperties($buttonProperties);
		$anchorProperties=HTML_parseProperties($anchorProperties);
		
		$content=UnirepTagLevelUp($content);
		
		return "<a{$anchorProperties}><span{$buttonProperties}>$content</span></a>";
		
	};
	
	
	
	
	if(!$dat['top']['main']['scrollRestore']){
		$otherDynPat['`--History-ScrollRestore--`']='history.scrollRestoration="manual";
		document.addEventListener("scroll", (function(){
			var timeout;
			return function(e){
				clearTimeout(timeout);
				var vcrInd=VCR.main.viewsVisited;
				timeout=setTimeout(function(){
					if(vcrInd !== VCR.main.viewsVisited){return;}
					history.replaceState(_ob.COMBINE(history.state, {lastScroll:""+document.documentElement.scrollTop}),"");
				},100);
				
			}
		})());';
		/*
		I removed this because it ended up not being needed (at first glance) but it in fact may be needed in the future.
		
		$otherDynPat['`--JS-histLgger--`']='var lggerF=this.LOG_change; lgger=function(){
			lggerF();
			//history.replaceState(_ob.COMBINE(history.state, {lastScroll:""+document.documentElement.scrollTop}),"");
			//console.log(history.state, document.documentElement.scrollTop);
			
		}';*/
	}
	
	if($dat['top']['main']['mainMinHeight']){
		$otherDynPat['`--CSS-MainMinHeight--`']="main{min-height:100vh;}\n";
	}
	if($dat['top']['main']['hamburgerButton']){
		$otherDynPat['`--HamburgerButton--`']='<div id="hamburgerCont"><a aria-label="Site Navigation" onclick="_el.CancelEvent(event); VCR.main.ToggleNav(); document.getElementById(\'navWrapper\').querySelector(\'nav\').scrollTop=0;" href="`--AbsolutePrefix--`/siteNav" class="invisiAnchors"><div class="hamburger"></div></a></div>';
		$otherDynPat['`--HamburgerButton--`'].='<div id="hamburgerContSpacer"><a aria-label="Site Navigation" href="`--AbsolutePrefix--`/siteNav" class="invisiAnchors"><div class="hamburger"></div></a></div>';
		$otherDynPat['`--CSS-Hamburger-TabletBreakpoint--`']='
	#hamburgerCont{
		display:block;
		z-index:1;
		position:sticky;
		top:0;
		text-align:right;
		height:0;
	}
	.navActive #hamburgerContSpacer{display:block;}
	.navActive #hamburgerCont{height:0;}
	.hamburger{
		position:relative;
		margin:1%;
		display:inline-block;
		cursor:pointer;
		background-color:`--ColorPalletButtonBackgroundColor--`;
		padding:3px 7px;
		font-size:50px;
		border-radius:25%;
	}
	.hamburger::BEFORE{
		content:\'=\'
	}
	.navActive .hamburger::BEFORE{
		content:\'X\';
	}';
		$otherDynPat['`-CSS-Hamburger--`']='#hamburgerCont, #hamburgerContSpacer{
	display:none;
}
#hamburgerContSpacer{visibility:hidden;height:0;}';
	}
	
	
	$appButtonData=[];
	$appButtonPat=[
		'`--CSS-AppButton--`'=>'',
		'`--CSS-AppButton-TabletBreakpoint--`'=>'',
		'`--JS-AppButton-Data--`'=>'',
		'`--JS-AppButton-ViewProc--`'=>'',
		'`--AppButton-TopOffset--`'=>0
	];
	$appButtonCss=[
		".appButtons{background-color:lightBlue; padding:4px;position:fixed;}",
		".appButton-contents{display:none;}",
		".hideAppButton{display:none}"
	];
	foreach($dat['top']['main']['appButtons']['list'] as $ab)
	{
		$contentStr=[];
		array_push($appButtonCss, "#appButton-$ab[buttonName]{\n{$ab['buttonCss']}\n}");
		$appButtonData[$ab['buttonName']]=[];
		foreach($ab['innerHtmls'] as $i=>$ih)
		{
			foreach($ih['forPages'] as $fp)
			{
				$fp=str_replace(" ","-",$fp);
				array_push($appButtonCss, ".activeView-$fp #appButton-$ab[buttonName]-content$i{display:block;}");
			}
			array_push($contentStr,"<span id=\"appButton-$ab[buttonName]-content$i\" class=\"appButton-contents\">$ih[htmlText]</span>");
		}
		$contentStr=join("", $contentStr);
		
		foreach($ab['destinations'] as $dest)
		{
			foreach($dest['forPages'] as $fp)
			{
				$fpr=str_replace(' ','-',$fp);
				$pIndexes=array_map(function($m){return $m['name'];},$dat['pages']);
				$p=$dat['pages'][array_search($dest['page'], $pIndexes)];
				$appButtonPat["`--AppButton-$ab[buttonName]-Destination-$fp--`"]="`--AbsolutePrefix--`/$p[urlTarget]";
				$appButtonPat["`--AppButton-$ab[buttonName]-DestinationName-$fp--`"]=$p['name'];
				$appButtonPat["`--AppButton-$ab[buttonName]-HiderClass-$fp--`"]='';
				$appButtonPat["`--AppButton-$ab[buttonName]-AriaLabel-$fp--`"]=PrepAppIfExists(' aria-label="',$dest['ariaLabel'],'" ');
				$appButtonPat["`--AppButton-$ab[buttonName]-Title-$fp--`"]=PrepAppIfExists(' title="',$dest['title'],'" ');
				//echo json_encode($dest);
				$appButtonData[$ab['buttonName']][$fp]=['destination'=>"`--AbsolutePrefix--`/$p[urlTarget]", 'name'=>$p['name'], 'ariaLabel'=>$dest['ariaLabel'], 'title'=>$dest['title']];
			}
		}
		$appButtonPat["`--AppButton-$ab[buttonName]--`"]="<a href=\"`--AppButton-$ab[buttonName]-Destination--`\" class=\"invisiAnchors`--AppButton-$ab[buttonName]-HiderClass--``--AppButton-$ab[buttonName]-AriaLabel--``--AppButton-$ab[buttonName]-Title--`\" onclick=\"VCR.main.EventCHANGE(event,APPBUTTONDATA['$ab[buttonName]'][VCR.main.GET_viewName()].name);\"><div id=\"appButton-$ab[buttonName]\" class=\"appButtons\" >$contentStr</div></a>";
	}
	//echo 'hioin'.json_encode($appButtonPat);
	//die(' j '.json_encode($appButtonPat));
	
	foreach($appButtonData as $butName=>&$list)
	{
		foreach($pages as $p)
		{
			if(!isset($list[$p['name']])){
				array_push($appButtonCss, ".activeView-$p[name] #appButton-$butName{display:none;}");
				$list[$p['name']]=['destination'=>'', 'name'=>''];
				$appButtonPat["`--AppButton-$butName-Destination-$p[name]--`"]='`--AbsolutePrefix--`/';
				$appButtonPat["`--AppButton-$butName-HiderClass-$p[name]--`"]=' hideAppButton';
			}
		}
	}
	unset($list);
	if(count($dat['top']['main']['appButtons']['list'])){
		$appButtonPat['`--AppButton-TopOffset--`']='20';
		$appButtonPat['`--CSS-AppButton--`']=join("\n", $appButtonCss);
		$appButtonPat['`--JS-AppButton-Data--`']="APPBUTTONDATA=".json_encode($appButtonData).';';
		$appButtonPat['`--JS-AppButton-ViewProc--`']="var appButtons=Array.from(document.getElementsByClassName('appButtons'));
appButtons.forEach(function(ab){
	var abdat=APPBUTTONDATA[ab.id.replace('appButton-','')][VCR.main.GET_viewName()] || {};
	var sav=ab.parentNode.href=(abdat).destination || '';
	if(!sav){ab.parentNode.classList.add('hideAppButton');}else{ab.parentNode.classList.remove('hideAppButton')};
	ab.parentNode.removeAttribute('title');ab.parentNode.removeAttribute('aria-label');
	if(abdat.title){ab.parentNode.setAttribute('title',abdat.title);}
	if(abdat.ariaLabel){ab.parentNode.setAttribute('aria-label',abdat.ariaLabel);}
});
";
	}
	
	
	/// ANIMATION
	$animationPat=[
		'`--JS-MainTargetFunct--`'=>"function(){
   return document.getElementsByTagName('main')[0];
}",
		'`--JS-LD--`'=>'curTar.innerHTML=\'<div style="height:\'+heightSave+\'px"></div>\';function LD(){
         loadFinished=true;
         curTar.innerHTML=\'\';
         tar.innerHTML=a.pageData[n].html;
		 Array.from(tar.querySelectorAll("script")).forEach(function(s){_el.APPEND(tar, _el.CREATE("script","","",{text:s.text}));});
         if(pd.igniterFunction && (pd.jsLoaded || !pd.js)){
            pd.igniterFunction();
         }
			var botcat=(Array.from(document.getElementsByClassName("appButtons")).filter(function(e){return e.offsetTop < 50;}).reduce(function(acc,e){return Math.max(e.offsetTop+e.offsetHeight, acc);},0));
			var headerOffset=header.offsetTop+header.offsetHeight;
			var newScroll=header.offsetTop+header.offsetHeight - botcat;
			//debugger;
			
			if(history.state && history.state.lastScroll && historyChange){
				//debugger;
				newScroll=parseInt(history.state.lastScroll);
				docElem.scrollTop=newScroll+(botcat-(history.state.botcat || 0));
			}else{
				//debugger;
				if(headerOffset < scrollTopSave && !window.headerBottomAdjusted){
					header.style.paddingBottom=botcat+"px";
					history.replaceState(_ob.COMBINE(history.state,{botcat:botcat}), "");
					headerBottomAdjusted=true;
				}
				docElem.scrollTop=Math.min(scrollTopSave,newScroll);
			}
			
         
         
      }',
		'`--CSS-AnimationCode--`'=>'',
		'`--JS-Ani-FunctionDeclaration--`'=>''
	];
	
	if(array_search($dat['top']['main']['animationType'],['fade','advanced']) !== false){
		$animationPat['`--JS-Ani-Advanced-LDSetup--`']='';
		$animationPat['`--JS-LD-Ani-JS-Function--`']='';
		$animationPat['`--JS-Ani-PreClass--`']='"aniPre"+direction';
		$animationPat['`--JS-Ani-PostClass--`']='"aniAni"+direction';
		$animationPat['`--CSS-Ani-Advanced--`']='';
		$animationPat['`--Ani-Transition-Seconds--`']='1';
		$animationPat['`--JS-MainTargetFunct--`']='(function(){var osc=false; return function(){
			osc=!osc;
			var id="contentTarget1";
			if(osc){id="contentTarget2";}
			return document.getElementById(id);
		};})()';
		
		if($dat['top']['main']['JSAnimationFunction']){
			$animationPat['`--JS-LD-Ani-JS-Function--`']='('.$dat['top']['main']['JSAnimationFunction'].')()';
		}
		
		$animationPat['`--JS-LD--`']='
		function LD(){
			var docuAniWrapper=document.getElementById("docuAniWrapper");
			var direction=curTar.id.replace("contentTarget","")+"-"+tar.id.replace("contentTarget", "");
			var infoToter={curTar:curTar, tar:tar};
			var curViewsVisited=VCR.main.viewsVisited;

			`--JS-Ani-Advanced-LDSetup--`
			
			
			
			curTar.style.removeProperty("top");
			curTar.style.removeProperty("min-height");
			tar.style.removeProperty("top");
			tar.style.removeProperty("min-height");
			mai.style.removeProperty("max-height");
			
			var curTarHeightSave=curTar.scrollHeight;
			
			//debugger;
			loadFinished=true;
			tar.innerHTML=a.pageData[n].html;
			
			
			
			var tarHeightSave=tar.scrollHeight;
			//console.log("heightSave1",tarHeightSave);
			var docHeightSave=document.documentElement.clientHeight;
			
			docuAniWrapper.className=`--JS-Ani-PreClass--`;
			//debugger;
			Array.from(tar.querySelectorAll("script")).forEach(function(s){_el.APPEND(tar, _el.CREATE("script","","",{text:s.text}));});

			
			var botcat=(Array.from(document.getElementsByClassName("appButtons")).filter(function(e){return e.offsetTop < 50;}).reduce(function(acc,e){return Math.max(e.offsetTop+e.offsetHeight, acc);},0));
			var headerOffset=header.offsetTop+header.scrollHeight;
			
			var inc=0;
			
			
			var newScrollTop=Math.min(scrollTopSave,headerOffset);//+(window.headerBottomAdjusted ? -botcat : botcat));
				//console.log("newScrollCheck",scrollTopSave,headerOffset, botcat);
			
				
			`--JS-LD-Ani-JS-Function--`
				
				
			//console.log(history.state.lastScroll);
			if(history.state && history.state.lastScroll && historyChange){
				newScrollTop=parseInt(history.state.lastScroll);
				var scrollTopAdjustment=newScrollTop;
				
				curTar.style.top=""+(scrollTopAdjustment-scrollTopSave)+"px";
				
				curTar.style.minHeight=(docHeightSave+parseInt(history.state.lastScroll || 0))+"px";
				
				docElem.scrollTop=scrollTopAdjustment;
			}else{
				//debugger;
				if(headerOffset < scrollTopSave && !window.headerBottomAdjusted){
					inc=botcat;
					mai.style.marginTop=botcat+"px";
					headerBottomAdjusted=true;
					history.replaceState(_ob.COMBINE(history.state,{botcat:botcat}),"");
				}
					//console.log(a.historyChange, "from inside");
				curTar.style.minHeight=tarHeightSave+"px";
				curTar.style.top="-"+(scrollTopSave-newScrollTop+inc)+"px";
				docElem.scrollTop=newScrollTop;
				
			}
			
			clearTimeout(window.shortAniTimeout);
			clearTimeout(window.mainAniTimeout);
			shortAniTimeout=setTimeout(function(){
				//debugger;
				//if(window.runTest){window.runTest--; if(!window.runTest){clearTimeout(window.mainAniTimeout);return;}}
				//debugger;
				docuAniWrapper.className=`--JS-Ani-PostClass--`;
				//debugger;
				if(infoToter.afterFireIn){infoToter.afterFireIn();}
				if(infoToter.afterFireOut){infoToter.afterFireOut();}

                
				mai.style.maxHeight=(tarHeightSave)+"px";


				clearTimeout(window.mainAniTimeout);
				mainAniTimeout=setTimeout(function(){
					if(curViewsVisited !== VCR.main.viewsVisited){
						return;
					}
					//return;
					mai.style.removeProperty("max-height");
					//console.log("actualHeight", tar.scrollHeight);
					//debugger;
					docuAniWrapper.className="aniRest"+tar.id.replace("contentTarget","");
					//debugger;
					curTar.style.removeProperty("top");
					curTar.style.removeProperty("min-height");
					curTar.innerHTML="";
					//console.log(tarHeightSave, document.documentElement.clientHeight, mai.clientHeight);
					///console.log(tar.clientHeight, tar.offsetHeight, tar.scrollHeight);
					//history.replaceState(_ob.COMBINE(history.state,{collapseOffset:(document.documentElement.scrollHeight-docuAniWrapper.clientHeight)+1}), "");
				},`--Ani-Transition-Seconds--`*1000);
			
			},1);
			
		}';
		$animationPat['`--CSS-AnimationCode--`']='
			main{position:relative;}
			#navWrapper, #hamburger{z-index:1;}
			.aniRest2 #contentTarget1, .aniRest1 #contentTarget2{position:absolute;}
				#contentTarget1, #contentTarget2{display:inline-block; width:100%;}
			footer{
			  position:relative;
			  opacity:1;
			   transition: opacity 0.2s;
			}
			.aniAni1-2 footer, .aniAni2-1 footer{
			   opacity:0;
			   transition: opacity 0s;
			}

			`--CSS-Ani-Advanced--`
		';
		$animationPat['`--CSS-Ani-Advanced--`']="
			#contentTarget1, #contentTarget2{
				transition: opacity `--Ani-Transition-Seconds--`s;
			}
			.aniPre1-2 #contentTarget1,.aniPre2-1 #contentTarget2{
				opacity:1;
				position:relative;
			}
			.aniPre1-2 #contentTarget2, .aniPre2-1 #contentTarget1{
				opacity:0;
				position:absolute;
				min-height:100vh;
				top:0;
				left:0;
			}
			.aniAni1-2 #contentTarget1, .aniAni2-1 #contentTarget2{
				opacity:0;
				position:relative;
			}
			.aniAni1-2 #contentTarget2, .aniAni2-1 #contentTarget1{
				opacity:1;
				min-height:100vh;
				position:absolute;
				top:0; left:0;
			}
			.aniRest2 #contentTarget1, .aniRest1 #contentTarget2{
				position:absolute;
				height:0;
				opacity:0;
			}
			.aniRest2 #contentTarget2, .aniRest1 #contentTarget1{
				opacity:1;
			}";
		if($dat['top']['main']['animationType'] === 'advanced'){
			$jsAniFunctionMap=[];
			
			$jsAniFunctionsStr=[];
			$aniInd=0;
			foreach($dat['top']['main']['animationAdvanced']['animationPaths'] as $i=>$ap)
			{
				if(!$ap['jsOut'] && !$ap['jsIn']){continue;}
				array_push($jsAniFunctionsStr,str_replace(';;',';',"function(it){{$ap['jsOut']};{$ap['jsIn']}}"));
				foreach($ap['from'] as $from=>$toList)
				{
					if(!isset($jsAniFunctionMap[$from])){$jsAniFunctionMap[$from]=[];}
					foreach($toList['to'] as $to)
					{
						$jsAniFunctionMap[$from][$to]=''.$aniInd;
					}
				}
				$aniInd++;
			}
			if($jsAniFunctionsStr){
				$animationPat['`--JS-Ani-FunctionDeclaration--`']="JSANIFUNCTIONMAP=".json_encode($jsAniFunctionMap).";\nJSANIFUNCTIONS=[".join(',',$jsAniFunctionsStr).'];';
				$animationPat['`--JS-LD-Ani-JS-Function--`'].="\nif((JSANIFUNCTIONMAP[from] || {})[to]){JSANIFUNCTIONS[JSANIFUNCTIONMAP[from][to]](infoToter);}";
			}
			$animationPat['`--JS-Ani-Advanced-LDSetup--`']='
				var to = a.GET_viewName();
				var from=a.indexMap[a.safeMap[a.previousView]];
				var toView=a.GET_viewName().replace(/\s/g,"-");
				var fromView=a.indexMap[a.safeMap[a.previousView]].replace(/\s/g,"-");
				var fromTo=fromView+"_to_"+toView;';
			$animationPat['`--JS-Ani-PreClass--`']='"aniPre"+fromTo+direction+" ani"+direction';
			$animationPat['`--JS-Ani-PostClass--`']='"aniAni"+fromTo+direction+" ani"+direction';
			$animationPat['`--CSS-Ani-Advanced--`']='
				main{overflow:hidden;}
				.ani1-2 #contentTarget1, .ani2-1 #contentTarget2{position:relative;}
				.ani2-1 #contentTarget1, .ani1-2 #contentTarget2{position:absolute; min-height:100vh; top:0;}
				
			';
			$animationPat['`--Ani-Transition-Seconds--`']='1';
			
			$cssAni=[];
			array_push($cssAni, $dat['top']['main']['animationAdvanced']['setupCss']);
			foreach($dat['top']['main']['animationAdvanced']['animationPaths'] as $ap)
			{
				if($ap['fromSetup']){array_push($cssAni, $ap['fromSetup']);}
				if($ap['toSetup']){array_push($cssAni, $ap['toSetup']);}
				$fromToFromPreArr=[];
				$fromToFromAniArr=[];
				$fromToToPreArr=[];
				$fromToToAniArr=[];
				
				$fromToFromWindowPreArr=[];
				$fromToFromWindowAniArr=[];
				$fromToToWindowPreArr=[];
				$fromToToWindowAniArr=[];
				foreach($ap['from'] as $from=>$toList)
				{
					foreach($toList['to'] as $to)
					{
						//if($from === $to){continue;}
						$fromTo=str_replace(' ','-',$from).'_to_'.str_replace(' ','-',$to);
						array_push($fromToFromPreArr, ".aniPre{$fromTo}1-2 #contentTarget1",".aniPre{$fromTo}2-1 #contentTarget2");
						
						array_push($fromToFromAniArr, ".aniAni{$fromTo}1-2 #contentTarget1",".aniAni{$fromTo}2-1 #contentTarget2");

						array_push($fromToToPreArr, ".aniPre{$fromTo}1-2 #contentTarget2",".aniPre{$fromTo}2-1 #contentTarget1");

						array_push($fromToToAniArr, ".aniAni{$fromTo}1-2 #contentTarget2",".aniAni{$fromTo}2-1 #contentTarget1");

					}
				}
				
				$fromToFromWindowPreArr=array_map(function($m){return $m.">div:first-child";},$fromToFromPreArr);
				$fromToFromWindowAniArr=array_map(function($m){return $m.">div:first-child";},$fromToFromAniArr);
				$fromToToWindowPreArr=array_map(function($m){return $m.">div:first-child";},$fromToToPreArr);
				$fromToToWindowAniArr=array_map(function($m){return $m.">div:first-child";},$fromToToAniArr);
				
					array_push($cssAni, join(',',$fromToFromPreArr)."{{$ap['fromPre']}}");
					//if($ap['fromPreMarginRemove']){array_push($cssAni, join(',',array_map(function($m){return $m.'>*:first-child';},$fromToFromPreArr))."{margin-top:0;}");}
					array_push($cssAni, join(',',$fromToFromAniArr)."{{$ap['fromAni']}}");
					//if($ap['fromAniMarginRemove']){array_push($cssAni, join(',',array_map(function($m){return $m.'>*:first-child';},$fromToFromAniArr))."{margin-top:0;}");}
					array_push($cssAni, join(',',$fromToToPreArr)."{{$ap['toPre']}}");
					//if($ap['toPreMarginRemove']){array_push($cssAni, join(',',array_map(function($m){return $m.'>*:first-child';},$fromToToPreArr))."{margin-top:0;}");}
					array_push($cssAni, join(',',$fromToToAniArr)."{{$ap['toAni']}}");
					//if($ap['toAniMarginRemove']){array_push($cssAni, join(',',array_map(function($m){return $m.'>*:first-child';},$fromToToAniArr))."{margin-top:0;}");}
					if($ap['fromWindowPre']){
						array_push($cssAni, join(',',$fromToFromWindowPreArr)."{{$ap['fromWindowPre']}}");
					}
					if($ap['fromWindowAni']){
						array_push($cssAni, join(',',$fromToFromWindowAniArr)."{{$ap['fromWindowAni']}}");
						
					}
					if($ap['toWindowPre']){
						array_push($cssAni, join(',',$fromToToWindowPreArr)."{{$ap['toWindowPre']}}");
						
					}
					if($ap['toWindowAni']){
						array_push($cssAni, join(',',$fromToToWindowAniArr)."{{$ap['toWindowAni']}}");
						
					}
			}
			$animationPat['`--CSS-Ani-Advanced--`'].=join("\n", $cssAni);
		}
	}
	
	
	// DYNAMIC SECTION

	$dynamicSectionPrePat=[];
	$dynamicSectionPostPat=[];
	$otherDynPat['`--dynamicSectionObject--`']='';
	
	$dynamicSectionArray=$dat['top']['main']['dynamicSections'];
	$needsDynBlogCss=false;
	foreach($dat['top']['admin']['blogs'] as $binf)
	{
		$needsDynBlogCss=true;
		array_push($dynamicSectionArray, [
			'name'=>'blog-'.$binf['slug'],
			'calcFunction'=>'function($a=""){
				require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");
				$sqlite=SQLite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../`--SecureFolder--`/blogs/'.$binf['slug'].'/db.db");
				$res=$sqlite->query("SELECT title,slug FROM articles WHERE published=1 ORDER BY IFNULL(sortDate, timePublished) DESC LIMIT 6");
				$ret=[];
				while($row=$res->fetchArray(SQLITE3_ASSOC))
				{
					$ret[]=$row;
				}
				return ["articles"=>$ret];
			}',// could be wrapped in a div to lay on
			'elementDefinition'=>'{
				tag:"div",
				children:[
					{tag:"div",properties:{class:"DynamicBlog-Header"},children:["Latest '.$binf['title'].' Articles"]},
					
						{tag:"a", each:"dat[\"articles\"]",properties:{class:"invisiAnchors",target:"dynamicBlogReader",href:"`--AbsolutePrefix--`/'.$binf['slug'].'/$`eac[\"slug\"]`$"},children:[
							{tag:"div", properties:{class:"DynamicBlog-Card"},children:[
								{tag:"div",children:["$`eac[\"title\"]`$"]}
							]}
						]}
					
					
				]
			}',
			'jsConfig'=>[
				'requestType'=>'GET',
				'requestBodyCalc'=>''
			],
			'phpConfig'=>[
				'argCalculator'=>'function($a=""){return [];}'
			]
		]);
	}
	
	
	$needsBasicDynamicCss=false;
	if(count($dynamicSectionArray)){
		
		$dsOb=[];
		$serverOb=[];
		EnsureDirectory("$localPubDirectory/dynamicSections_");
		EmptyDirectory("$localPubDirectory/dynamicSections_");
		EnsureDirectory("$livePubDirectory/dynamicSections_");
		EmptyDirectory("$livePubDirectory/dynamicSections_");
		$datMainSecureFolder=$secSecureFolder;
		$needsBasicDynamicCss=true;
		
		
		foreach($dynamicSectionArray as $ds)
		{
			$repName=str_replace(' ','_',$ds['name']);
			$str='<?php 
				require_once("$_SERVER[DOCUMENT_ROOT]/../'.$datMainSecureFolder.'/dynamicSectionDefinitions.php");
				require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");
				
				PostVarSet("ob",$ob,true);
				$ob=json_decode($ob);
				if(!$ob){$ob=[];}
				die(json_encode([
					"success"=>true,
					"data"=>$DynamicSectionFunctions['.sQuote($ds['name']).']["dataCalculator"]($ob)
				]));
				
			?>';
			file_put_contents("$localPubDirectory/dynamicSections_/$repName.php",$str);
			file_put_contents("$livePubDirectory/dynamicSections_/$repName.php",$str);
			$dsOb[$ds['name']]=[
				'HandleData'=>'',
				'ReqOb'=>''
			];
			$jsConfig=$ds['jsConfig'];
			$phpConfig=$ds['phpConfig'];
			
			array_push($serverOb,"'$ds[name]'=>['dataCalculator'=>$ds[calcFunction],'argumentCalculator'=>$phpConfig[argCalculator]]");
			
			$phpElementLines=[];
			$phpElementLines=[];
			$elementDefinition=loose_json_decode($ds['elementDefinition']);
			
			$jsElems=ObToJsEls($elementDefinition);
			$phpElems=ObToPhpEls($elementDefinition);
			
			$dsOb[$ds['name']]['HandleData']="function(target){
					var dat=this.data;
					_el.EMPTY(target);
					_el.APPEND(target,$jsElems);
				}";
			$dsOb[$ds['name']]['ReqOb']=FirstSet($jsConfig['requestBodyCalc'], "function(){return new FormData();}");
			//die($phpElems.' ^^^^^^^^^^^^^^ '.$jsElems);
			//die($jsElems);
			
			
			$dsNameReplaced=str_replace(' ','-', $ds['name']);
			$dynamicSectionPrePat["`--dynamicSection-$ds[name]--`"]="`--dynamicSection-$ds[name]-JS--`";
			$dynamicSectionPostPat["`--dynamicSection-$ds[name]--`"]="`--dynamicSection-$ds[name]-PHP--`";
			$UNIREP_computeFunctions["`--dynamicSection-$ds[name]-JS--`"]=function($id='') use ($ds,$jsElems,$jsConfig,$repName){
				
				if(!$id){$id="{$repName}_target";}
				return "<div id=\"$id\"></div><script>
				if(DYNAMICSECTIONDATA['$ds[name]'].data){
					DYNAMICSECTIONDATA['$ds[name]'].HandleData(document.getElementById('$id'));
				}else{
					var config={method:'$jsConfig[requestType]'};
					if(config.method === 'POST'){config.body=DYNAMICSECTIONDATA['$ds[name]'].ReqBody();}
					RegularFetch('`--AbsolutePrefix--`/dynamicSections_/".str_replace(' ','_',$ds['name']).".php',config,'json',function(jsn){
						DYNAMICSECTIONDATA['$ds[name]'].data=jsn.data;
						DYNAMICSECTIONDATA['$ds[name]'].HandleData(document.getElementById('$id'));
					});
					_el.APPEND(document.getElementById('$id'),[
						_el.CREATE('div','','DynamicSection-Loading',{},[
							_el.CREATE('span','','',{},['X']),
							_el.CREATE('span','','',{},['Loading Section']),
							_el.CREATE('span','','',{},['X'])
						])
					]);
					
				}
			</script>";};
			$UNIREP_computeFunctions["`--dynamicSection-$ds[name]-PHP--`"]=function($id="") use ($ds,$phpElems,$phpConfig){return "
			<div id=\"$id\"><?php
				require_once(\"\$_SERVER[DOCUMENT_ROOT]/../`--SecureFolder--`/dynamicSectionDefinitions.php\");
				require_once(\"\$_SERVER[DOCUMENT_ROOT]/../php_library/htmlRenderers.php\");
				
				\$dat=\$DynamicSectionFunctions['$ds[name]']['dataCalculator'](\$DynamicSectionFunctions['$ds[name]']['argumentCalculator']());
				
				echo HTML_elementOb($phpElems).'<script>DYNAMICSECTIONDATA[\'$ds[name]\'].data='.json_encode(\$dat).';</script>';
			?></div>
			";};
			
		}
		
		file_put_contents("$localSecDirectory/dynamicSectionDefinitions.php",Unirep('<?php 
			$DynamicSectionFunctions=['.join(',',$serverOb).'];
		?>',[
			'`--SecureFolder--`'=>$secSecureFolder
		]));
		file_put_contents("$liveSecDirectory/dynamicSectionDefinitions.php",Unirep('<?php 
			$DynamicSectionFunctions=['.join(',',$serverOb).'];
		?>',[
			'`--SecureFolder--`'=>$secSecureFolder
		]));
		
		$dsTemp=[];
		foreach($dsOb as $name=>$fs)
		{
			array_push($dsTemp, "'$name':{
				HandleData:$fs[HandleData],
				ReqBody:$fs[ReqOb]
			}");
		}
		
		
		$otherDynPat['`--dynamicSectionObject--`']='DYNAMICSECTIONDATA={'.join(',',$dsTemp).'};';
	}
	
	/// merge
	$otherDynPat=array_merge($otherDynPat, $appButtonPat);
	$otherDynPat=array_merge($otherDynPat, $animationPat);
	

	$csp=$dat['top']['main']['contentSecurityPolicy'];
	if($csp){
		$csp="Header add Content-Security-Policy \"$csp\"";
	}
	$wwwBehaviour=$dat['top']['main']['wwwBehaviour'];
	if($wwwBehaviour === 'force'){
		$wwwBehaviour="RewriteCond %{HTTP_HOST} !^www\. [NC]
RewriteRule ^ %{REQUEST_SCHEME}://www.%{HTTP_HOST}%{REQUEST_URI} [R,L]";
	}else if($wwwBehaviour === "prevent"){
		$wwwBehaviour="RewriteCond %{HTTP_HOST} ^www\.(.*)$ [NC]
RewriteRule ^ %{REQUEST_SCHEME}://%1%{REQUEST_URI} [R,L]";
		
	}else{
		$wwwBehaviour='';
	}
	
	file_put_contents("$localPubDirectory/.htaccess", "
".basicHtaccess."
<If \"%{REQUEST_URI} =~ m#/media/#\">
	Header set Cache-Control max-age=31536000
	Header append Cache-Control public
</If>
$csp

");

	$htaccessHttps="";
	if($dat['top']['main']['https']){$htaccessHttps="RewriteCond %{HTTPS} off 
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI}

";}
	file_put_contents("$livePubDirectory/.htaccess", "{$htaccessHttps}

$wwwBehaviour
".basicHtaccess."
<If \"%{REQUEST_URI} =~ m#/media/#\">
	Header set Cache-Control max-age=31536000
	Header append Cache-Control public
</If>

$csp

");
	
	
	$jsInline='';
	$cssInline='';
	
	$jsFileConsolodate='';
	$cssFileConsolodate='';
	
	$jsImports='';
	$cssImports='';
	
	
	if($needsBasicDynamicCss){
		$cssInline.=file_get_contents("templates/dynamicSection/css.css");
	}
	if($needsDynBlogCss){
		$cssInline.=file_get_contents("adminTemplates/blogs/dynamicRecentCss.css");
	}
	
	foreach($dat['top']['main']['js_library'] as $k=>$v)
	{
		if($v === 'omit'){continue;}
		
		$tempCss=false;
		$tempJs=file_get_contents("$_SERVER[DOCUMENT_ROOT]/js_library/{$k}.js");
		if(is_file("$_SERVER[DOCUMENT_ROOT]/js_library/{$k}.css")){
			$tempCss=file_get_contents("$_SERVER[DOCUMENT_ROOT]/js_library/{$k}.css");
		}
		if($v === 'inline'){
			$jsInline.="\n/*START $k */\n{$tempJs}\n/*END $k*/\n";
			if($tempCss){
				$cssInline.="\n{$tempCss}\n";
			}
		}else if($v === 'lib'){
			file_put_contents("$localPubDirectory/js_library/{$k}.js", Unirep($tempJs, $colorPalletArray, $breakpointArray,$otherDynPat, $mainPat));
			file_put_contents("$livePubDirectory/js_library/{$k}.js", Unirep($tempJs, $colorPalletArray, $breakpointArray, $otherDynPat,$mainPat));
			$jsImports.="<script src=\"js_library/{$k}.js\"></script>\n";
			if($tempCss){
				file_put_contents("$localPubDirectory/js_library/{$k}.css", Unirep($tempCss, $colorPalletArray, $breakpointArray, $otherDynPat,$mainPat));
				file_put_contents("$livePubDirectory/js_library/{$k}.css",Unirep($tempCss, $colorPalletArray, $breakpointArray, $otherDynPat,$mainPat));
				$cssImports.="<link rel=\"stylesheet\" href=\"js_library/{$k}.css\"/>\n";
			}
		}else if($v === 'consolodated'){
			$jsFileConsolodate.="\n // START $k\n{$tempJs}\n//END $k\n";
			if($tempCss){
				$cssFileConsolodate.="\n{$tempCss}\n";
			}
		}
		
	}

	
	
	foreach($dat['top']['main']['js_core'] as $k=>$v)
	{
		if($v === 'omit'){continue;}
		$tempCss=false;
		$tempJs=file_get_contents("$_SERVER[DOCUMENT_ROOT]/js_core/{$k}.js");
		if(is_file("$_SERVER[DOCUMENT_ROOT]/js_core/{$k}.css")){
			$tempCss=file_get_contents("$_SERVER[DOCUMENT_ROOT]/js_core/{$k}.css");
		}
		if($v === 'inline'){
			$jsInline.="\n/*START $k*/ \n{$tempJs}\n/*END $k*/\n";
			if($tempCss){
				$cssInline.="\n{$tempCss}\n";
			}
		}else if($v  === 'lib'){
			file_put_contents("$localPubDirectory/js_core/{$k}.js", Unirep($tempJs, $colorPalletArray, $breakpointArray, $otherDynPat,$mainPat));
			file_put_contents("$livePubDirectory/js_core/{$k}.js", Unirep($tempJs, $colorPalletArray, $breakpointArray, $otherDynPat,$mainPat));
			$jsImports.="<script src=\"js_core/{$k}.js\"></script>\n";
			if($tempCss){
				file_put_contents("$localPubDirectory/js_core/{$k}.css", Unirep($tempCss, $colorPalletArray, $breakpointArray, $otherDynPat,$mainPat));
				file_put_contents("$livePubDirectory/js_core/{$k}.css", Unirep($tempCss, $colorPalletArray, $breakpointArray, $otherDynPat,$mainPat));
				$cssImports.="<link rel=\"stylesheet\" href=\"js_core/{$k}.css\"/>\n";
			}
		}else if($v  === 'consolodated'){
			$jsFileConsolodate.="\n // START $k\n{$tempJs}\n//END $k\n";
			if($tempCss){
				$cssFileConsolodate.="\n{$tempCss}\n";
			}
		}
		
	}
	
	foreach($dat['top']['main']['css_library'] as $k=>$v)
	{
		if($v === 'omit'){continue;}
		$tempCss=file_get_contents("$_SERVER[DOCUMENT_ROOT]/css_library/{$k}.css");

		if($v === 'inline'){
			$cssInline.="\n{$tempCss}\n";
			
		}else if($v  === 'lib'){
			file_put_contents("$localPubDirectory/css_library/{$k}.css", LessifyText(
				$globalLESS,
				$LessParser,
				Unirep($tempCss, $colorPalletArray, $breakpointArray, $otherDynPat,$mainPat)
			));
			file_put_contents("$livePubDirectory/css_library/{$k}.css",LessifyText(
				$globalLESS,
				$LessParser,
				Unirep($tempCss, $colorPalletArray, $breakpointArray, $otherDynPat,$mainPat)
			));
			$cssImports.="<link rel=\"stylesheet\" href=\"css_library/{$k}.css\"/>\n";
			
		}else if($v  === 'consolodated'){
			$cssFileConsolodate.="\n{$tempCss}\n";
		}
	}
	
	
	
	if($jsFileConsolodate){
		file_put_contents("$localPubDirectory/js_library/consolodate.js", Unirep($jsFileConsolodate, $colorPalletArray, $breakpointArray, $otherDynPat,$mainPat));
		file_put_contents("$livePubDirectory/js_library/consolodate.js", Unirep($jsFileConsolodate, $colorPalletArray, $breakpointArray, $otherDynPat,$mainPat));
		$jsImports.="<script src=\"js_library/consolodate.js\"></script>\n";
		if($cssFileConsolodate){
			
			file_put_contents("$localPubDirectory/js_libary/consolodate.css", LessifyText(
				$globalLESS,
				$LessParser,
				Unirep($cssFileConsolodate, $colorPalletArray, $breakpointArray,$otherDynPat, $mainPat)
			));
			file_put_contents("$livePubDirectory/js_libary/consolodate.css", LessifyText(
				$globalLESS,
				$LessParser,
				Unirep($cssFileConsolodate, $colorPalletArray, $breakpointArray, $otherDynPat,$mainPat)
			));
			$cssImports.="<link rel=\"stylesheet\" href=\"js_library/consolodate.css\"/>\n";
		}
	}
	
	foreach($dat['top']['main']['JSList'] as $js)
	{
		$jsInline.="\n/*$js[name]*/\n".$js['content'];
	}
	foreach($dat['top']['main']['CSSList'] as $css)
	{
		$cssInline.="\n/*$css[name]*/\n$css[content]";
	}
	
	$contactFormsHtaccess=[];
	
	if($contactForms){
		$cssInline.="\n".file_get_contents('adminTemplates/contactForms/publicCSS.css');
		
		EnsureDirectory("$localPubDirectory/contactForms_");
		EnsureDirectory("$livePubDirectory/contactForms_");
		foreach($contactForms as $cf)
		{
			if($cf['css']){
				$cssInline.="\n$cf[css]\n";
			}
			$safeName=str_replace([' '],['_'],$cf['formName']);
			$inpGrab=[];
			$fileMove=[];
			$jsonEncoder=[];
			$maxSize=0;
			$maxNumFiles=0;
			foreach($cf['inputs'] as $inp)
			{
				if($inp['basicValidation'] === 'email'){
					$cf['phpValidation'].="\n if(!filter_var(\$$inp[name], FILTER_VALIDATE_EMAIL)){die('invalid email');} \n";
				}else if($inp['basicValidation'] === 'phoneAmerican'){
					$cf['phpValidation'].="\n\$$inp[name]=preg_replace('/[^0-9\\(\\) \\-]/','',\$$inp[name]);\nif(!preg_match('/^[0-9]{10,11}\$/',preg_replace('/[\\(\\) \\-]/','',\$$inp[name]))){die('invalid phone number');}\n";
				}else if($inp['basicValidation'] === 'int'){
					$cf['phpValidation'].="\n\$$inp[name]=intval(\$$inp[name]);\n";
				}
				if(array_search($inp['type'],["image", "imageMulti"]) === false){
					if($inp['required']){
						array_push($inpGrab, "PostVarSet('$inp[name]', \$$inp[name]);");
					}else{
						array_push($inpGrab, "PostVarSet('$inp[name]', \$$inp[name], true);");
					}
					
				}else if($inp['type'] === 'imageMulti'){
					if(!$inp['maxNumFiles']){$inp['maxNumFiles']=2;}
					if(!$inp['maxSize']){
						$inp['maxSize']=intval($inp['maxNumFiles'])*1024;
					}
					if($inp['maxSize']){
						$maxSize+=intval($inp['maxSize']);
					}
					if($inp['maxNumFiles']){
						$maxNumFiles+=intval($inp['maxNumFiles']);
					}
					array_push($fileMove, "
						\$$inp[name]=[];
						\$accepted=".json_encode($inp['accept']).";
						foreach(\$_FILES['$inp[name]']['error'] AS \$key=>\$error)
						{
							if(\$error == UPLOAD_ERR_OK){
								\$tmp_name=\$_FILES['$inp[name]']['tmp_name'][\$key];
								\$ext=@end(explode('.', \$_FILES['$inp[name]']['name'][\$key]));
								\$mime=mime_content_type(\$_FILES['$inp[name]']['tmp_name'][\$key]);
								\$ok=false;
								
								foreach(\$accepted as \$a)
								{
									if(preg_match('`/`',\$a)){
										if(preg_match(\"~^\$a~\",\$mime)){
											\$ok=true;
											break;
										}
									}else if(\$ext === str_replace('.','',\$a)){
										\$ok=true;
										break;
									}
								}
								if(!\$ok){
									die('Invalid file type');
								}
								move_uploaded_file(\$tmp_name, \"\$tempDir/\$fileIndex.\$ext\");
								array_push(\$$inp[name], \$fileIndex.'.'.\$ext);
							}
							\$fileIndex++;
						}
					");
				}else{
					if(!$inp['maxSize']){$inp['maxSize']='1024';}
					if($inp['maxSize']){
						$maxSize+=intval($inp['maxSize']);
					}
						$maxNumFiles+=1;
					
					array_push($fileMove, "
						\$$inp[name]=[];
							if(\$_FILES['$inp[name]']['error'] == UPLOAD_ERR_OK){
								\$tmp_name=\$_FILES['$inp[name]']['tmp_name'];
								\$ext=@end(explode('.', \$_FILES['$inp[name]']['name']));
								\$mime=mime_content_type(\$_FILES['$inp[name]']['tmp_name']);
								
								\$accepted=".json_encode($inp['accept']).";
								
								\$ok=false;
								
								foreach(\$accepted as \$a)
								{
									if(preg_match('`/`',\$a)){
										if(preg_match(\"~^\$a~\",\$mime)){
											\$ok=true;
											break;
										}
									}else if(\$ext === str_replace('.','',\$a)){
										\$ok=true;
										break;
									}
								}
								
								if(!\$ok){
									die('Invalid file type');
								}
								
								move_uploaded_file(\$tmp_name, \"\$tempDir/\$fileIndex.\$ext\");
								array_push(\$$inp[name], \$fileIndex.'.'.\$ext);
							}
							\$fileIndex++;
						
					");
				}
				
					array_push($jsonEncoder, "'$inp[name]'=>\$$inp[name]");
				
				
				
				
			}
			
			if($maxSize || $maxNumFiles){
				if(!$maxNumFiles){$maxNumFiles=1;}
				if(!$maxSize){$maxSize=1024*$maxNumFiles;}
				$maxPSize=$maxSize+1024;
				$dMaxSize=$maxPSize*2;
				array_push($contactFormsHtaccess, "<Files $safeName.php>
    php_flag file_uploads On
    php_value max_file_uploads {$maxNumFiles}
	php_value upload_max_filesize {$maxSize}K
	php_value post_max_size {$maxPSize}K
	php_value memory_limit {$dMaxSize}K
</Files>");
			}
			
			$jsonEncoder='['.join(',',$jsonEncoder).']';
			$repPat=[
				'`--SecureFolder--`'=>$secSecureFolder,
				'`--formName--`'=>$cf['formName'],
				'`--formFileName--`'=>preg_replace('/[^A-Za-z0-9]/','-',$cf['formName']),
				'`--inpGrab--`'=>join("\n",$inpGrab),
				'`--validation--`'=>$cf['phpValidation'],
				'`--fileMove--`'=>join("\n",$fileMove),
				'`--jsonEncoder--`'=>$jsonEncoder,
				'`--SafeFileName--`'=>str_replace(' ','-',$cf['formName']),
				'`--SafeFunctName--`'=>preg_replace('/[^A-Za-z0-9]/','_',$cf['formName']),
				'`--customerNotification--`'=>'',
				'`--adminNotification--`'=>''
			];
			$locRepPat=array_merge($repPat,[
				'`--RECAPTCHA-PrivateKey--`'=>$dat['top']['main']['recaptcha']['privateKeyTest'],
				'`--AdminTopURI--`'=>"http://localhost/siteGenerator/v1/adminPreviews/$projectInfo[slug]",
			]);
			$livRepPat=array_merge($repPat,[
				'`--RECAPTCHA-PrivateKey--`'=>$dat['top']['main']['recaptcha']['privateKey'],
				'`--AdminTopURI--`'=>$dat['top']['admin']['config']['topUri'],
			]);
			
			if($cf['notifyCustEmail']['activate']){
				$locEm=$cf['notifyCustEmail']['emailConfig']['local'];
					$locEm['host']=sQuote($locEm['host']);
					$locEm['user']=sQuote($locEm['user']);
					$locEm['password']=sQuote($locEm['password']);
					$locEm['fromAddress']=sQuote($locEm['fromAddress']);
					$locEm['fromName']=sQuote($locEm['fromName']);
					$locEm['smtpSecure']=sQuote($locEm['smtpSecure']);
					$locEm['smtpAuth']=$locEm['smtpSecure'] ? 'true':'false';
					$locEm['isSMTP']=$locEm['smtpSecure'] ? 'true':'false';
					
					
					
				$locRepPat['`--customerNotification--`']="
					require_once(\"\$_SERVER[DOCUMENT_ROOT]/../php_library/sendMail.php\");
					BasicSendMailComplete(
						$locEm[host], 
						['user'=>$locEm[user],'fromEmail'=>$locEm[fromAddress]], 
						$locEm[fromName], 
						$locEm[password], 
						\$email, 
						'Your Submission was Received', 
						[
							'body'=>'<h1>Thank you for reaching out</h1><p>Your submission of the form $cf[formName] is being processed. You will hear back ASAP.</p>',
							'alt'=>'Thank you for reaching out\n\nYour submission of the form $cf[formName] is being processed. You will hear back ASAP.'
						], 
						[],
						[], 
						[
							'port'=>$locEm[port],
							'smtpSecure'=>$locEm[smtpSecure],
							'smtpAuth'=>$locEm[smtpAuth],
							'isSMTP'=>$locEm[isSMTP]
						]);
				";
				
				$locEm=$cf['notifyCustEmail']['emailConfig']['live'];
					$locEm['host']=sQuote($locEm['host']);
					$locEm['user']=sQuote($locEm['user']);
					$locEm['password']=sQuote($locEm['password']);
					$locEm['fromAddress']=sQuote($locEm['fromAddress']);
					$locEm['fromName']=sQuote($locEm['fromName']);
					$locEm['smtpSecure']=sQuote($locEm['smtpSecure']);
					$locEm['smtpAuth']=$locEm['smtpSecure'] ? 'true':'false';
					$locEm['isSMTP']=$locEm['smtpSecure'] ? 'true':'false';
					
					
					
				$livRepPat['`--customerNotification--`']="
					require_once(\"\$_SERVER[DOCUMENT_ROOT]/../php_library/sendMail.php\");
					BasicSendMailComplete(
						$locEm[host], 
						['user'=>$locEm[user],'fromEmail'=>$locEm[fromAddress]], 
						$locEm[fromName], 
						$locEm[password], 
						\$email, 
						'Your Submission was Received', 
						[
							'body'=>'<h1>Thank you for reaching out</h1><p>Your submission of the form $cf[formName] is being processed. You will hear back ASAP.</p>',
							'alt'=>'Thank you for reaching out\n\nYour submission of the form $cf[formName] is being processed. You will hear back ASAP.'
						], 
						[],
						[], 
						[
							'port'=>$locEm[port],
							'smtpSecure'=>$locEm[smtpSecure],
							'smtpAuth'=>$locEm[smtpAuth],
							'isSMTP'=>$locEm[isSMTP]
						]);
				";
			}
			if($cf['notifyAdmin']['activate']){
				
				$locEm=$cf['notifyAdmin']['emailConfig']['local'];
				
				$locEm['subject']="New $cf[formName] Submission";
				$locEm['bodys']=[
					'body'=>"<h1>New Form Submission</h1><h2>Contact Form: $cf[formName]</h2><p>There is a new submission on the site. <br><br><a href=\"`--AdminTopURI--`\">:You Can Login Here:</a> to view it.<br><br>You can also use that link to unsubscribe.</p>",
					'alt'=>"New Form Submission\nContact Form: $cf[formName]\n\nThere is a new submission on the site. \n\n You can login here to view it: `--AdminTopURI--` \n\n You can also use that link to unsubscribe."
				];
				
				$locEm['userNFromEmail']=[
					'user'=>$locEm['user'],
					'fromEmail'=>$locEm['fromAddress']
				];
				unset($locEm['user']);
				unset($locEm['fromAddress']);
				
				
				$locEm['otherInfo']=[
					'port'=>$locEm['port'],
					'smtpSecure'=>$locEm['smtpSecure'],
					'smtpAuth'=>$locEm['smtpAuth'],
					'isSMTP'=>$locEm['isSMTP']
				];
				
					unset($locEm['port']);
					unset($locEm['smtpSecure']);
					unset($locEm['smtpAuth']);
					unset($locEm['isSMTP']);
				$locEm['CCs']=[];
				$locEm['attachments']=[];
				$locRepPat['`--adminNotification--`']="
					require_once(\"\$_SERVER[DOCUMENT_ROOT]/../`--SecureFolder--`/admin/adminNotifManager/emitNotification.php\");
					EmitAdminNotification('Contact Form: $cf[formName]',['email'=>json_decode(".sQuote(json_encode($locEm)).",true)]);
				";
				
				
				$locEm=$cf['notifyAdmin']['emailConfig']['live'];
				
				$locEm['subject']="New $cf[formName] Submission";
				$locEm['bodys']=[
					'body'=>"<h1>New Form Submission</h1><h2>Contact Form: $cf[formName]</h2><p>There is a new submission on the site. <br><br><a href=\"`--AdminTopURI--`\">:You Can Login Here:</a> to view it.<br><br>You can also use that link to unsubscribe.</p>",
					'alt'=>"New Form Submission\nContact Form: $cf[formName]\n\nThere is a new submission on the site. \n\n You can login here to view it: `--AdminTopURI--` \n\n You can also use that link to unsubscribe."
				];
				
				$locEm['userNFromEmail']=[
					'user'=>$locEm['user'],
					'fromEmail'=>$locEm['fromAddress']
				];
				unset($locEm['user']);
				unset($locEm['fromAddress']);
				
				
				$locEm['otherInfo']=[
					'port'=>$locEm['port'],
					'smtpSecure'=>$locEm['smtpSecure'],
					'smtpAuth'=>$locEm['smtpAuth'],
					'isSMTP'=>$locEm['isSMTP']
				];
				
					unset($locEm['port']);
					unset($locEm['smtpSecure']);
					unset($locEm['smtpAuth']);
					unset($locEm['isSMTP']);
				$locEm['CCs']=[];
				$locEm['attachments']=[];
				
				$livRepPat['`--adminNotification--`']="
					require_once(\"\$_SERVER[DOCUMENT_ROOT]/../`--SecureFolder--`/admin/adminNotifManager/emitNotification.php\");
					EmitAdminNotification('Contact Form: $cf[formName]',['email'=>json_decode(".sQuote(json_encode($locEm)).",true)]);
				";
			}
			
			$contactFormSubmitTemp=file_get_contents("adminTemplates/contactForms/publicSubmit.php.temp");
			file_put_contents("$localPubDirectory/contactForms_/$safeName.php",Unirep($contactFormSubmitTemp,$locRepPat));
			file_put_contents("$livePubDirectory/contactForms_/$safeName.php", Unirep($contactFormSubmitTemp, $livRepPat));
		}
		
		if($contactFormsHtaccess){
			file_put_contents("$localPubDirectory/contactForms_/.htaccess", join("\n", $contactFormsHtaccess));
			file_put_contents("$livePubDirectory/contactForms_/.htaccess", join("\n", $contactFormsHtaccess));
		}
	}
	
	
	$recapProtStaged=[];
	if($recapProtContent){
		$cssInline.="\n".file_get_contents('templates/recapProt/css.css')."\n";
		EnsureDirectory("$localPubDirectory/recapProtContent_");
			EmptyDirectory("$localPubDirectory/recapProtContent_");
		EnsureDirectory("$livePubDirectory/recapProtContent_");
			EmptyDirectory("$livePubDirectory/recapProtContent_");
		EnsureDirectory("$localSecDirectory/recapProtContent");
			EmptyDirectory("$localSecDirectory/recapProtContent");
		EnsureDirectory("$liveSecDirectory/recapProtContent");
			EmptyDirectory("$liveSecDirectory/recapProtContent");
		foreach($recapProtContent as $rpc)
		{
			$fileName=preg_replace('/[^A-Za-z0-9_]/','_',$rpc['title']);
			EnsureDirectory("$livePubDirectory/recapProtContent_/$fileName");
			EnsureDirectory("$localPubDirectory/recapProtContent_/$fileName");
			EnsureDirectory("$liveSecDirectory/recapProtContent/$fileName");
			EnsureDirectory("$localSecDirectory/recapProtContent/$fileName");
			
			if($rpc['css']){
				$cssInline.="\n$rpc[css]\n";
			}
			if($rpc['js']){
				$jsInline.="\n$rpc[js]\n";
			}
			array_push($recapProtStaged, [
				'fileName'=>$fileName,
				'html'=>$rpc['html']
			]);
			
		}
	}
	
	
	
	$dynPat=[
		'`--HeadScriptsNStyles--`'=>"{$jsImports}{$cssImports}
<script>{$jsInline}</script>
<style>{$cssInline}</style>

`--PageScripts--`
`--PageStyles--`
"
	];
	
	//$documentTemp=Unirep($mainDocument, $globalPat, $otherDynPat,$mainPat, $dynPat);
	$documentTemp=Unirep($mainDocument, $globalPat, $otherDynPat, $dynPat);
	
	$navButtons=[];
	$viewFunctions=[];
	
	$pageDataInsert=[];
	$igniterFunctionInsert=[];
	
	usort($dat['pages'],function($a,$b){
		return intval($a['navOrder'])-intval($b['navOrder']);
	});
	
	$cssActiveButtonList=[];
	
	$footerNav=[];
	
	foreach($pages as $p)
	{
		$seoOb=Calc_SeoOb($dat['top']['meta'], $p['meta']);
		$pageDataInsert[$p['name']]=[
			'css'=>!!count($p['main']['CSSList']),
			'js'=>!!count($p['main']['JSList']),
			'cssLoaded'=>false,
			'jsLoaded'=>false,
			'html'=>Unirep($p['main']['html'],$colorPalletArray, $breakpointArray, $otherDynPat,$dynamicSectionPrePat, $mainPat,[
				//'`--NavButtons--`'=>'`--NavButtons-DQEscaped--`',
			]),
			'url'=>$p['urlTarget'],
			'igniterFunction'=>false,
			'title'=>$seoOb['basicTitle']
		];
		
		if($p['main']['igniterFunction']){
			array_push($igniterFunctionInsert, "VC.prototype.pageData['$p[name]'].igniterFunction=function(){\n".$p['main']['igniterFunction']."\n};");
		}
		$activeViewName=CSSSelectorSafe($p['name']);
		if($p['navInclude']){
			$props=['class'=>'basicNavButton','id'=>"viewButton-$activeViewName"];
			if($p['navButtonAriaLabel']){
				$props['aria-label']=$p['navButtonAriaLabel'];
			}
			if($p['navButtonTitle']){
				$props['title']=$p['navButtonTitle'];
			}
			array_push($navButtons,HTML_element('a',[
				'href'=>'`--AbsolutePrefix--`/'.$p['urlTarget'],
				'onclick'=>"VCR.main.MainButtonCHANGE(this.children[0],event,'$p[name]');"
			],[
				[
					'tag'=>'div',
					'properties'=>$props,
					'children'=>[FirstSet($p['navTextOverride'],$p['name'])],
					'raw'=>true
				]
			], true));
			
			
		}
		array_push($cssActiveButtonList, ".activeView-$activeViewName #viewButton-$activeViewName");
		array_push($viewFunctions, "VCR.main.REGISTER_view('$p[name]', VCR.main.BasicProjectView('$p[name]'));");
		
		
		
		if($p['name'] !== 'siteNav'){
			array_push($footerNav, HTML_element('div',[],[["tag"=>"a", "properties"=>["onclick"=>"VCR.main.EventCHANGE(event,'$p[name]');","href"=>"`--AbsolutePrefix--`/$p[urlTarget]"], "children"=>[$p['name']]]]));
		}
		if(!$p['urlTarget']){
			$otherDynPat['`--HomePageName--`']=$p['name'];
		}
	}
	foreach($dat['top']['admin']['blogs'] as $binf)
	{
		array_push($footerNav, HTML_element('div',[],[["tag"=>"a", "properties"=>["href"=>"`--AbsolutePrefix--`/$binf[slug]"], "children"=>[$binf['title']]]]));
	}
	//die(json_encode($dat['admin']));
	foreach($dat['top']['admin']['blogs'] as $bi)
	{
		if($bi['mainNav']){
			$props=['class'=>'basicNavButton'];
			/*if($p['navButtonAriaLabel']){
				$props['aria-label']=$p['navButtonAriaLabel'];
			}
			if($p['navButtonTitle']){
				$props['title']=$p['navButtonTitle'];
			}*/
			array_push($navButtons, HTML_element('a',[
				'href'=>'`--AbsolutePrefix--`/'.$bi['slug']
			],[
				[
					'tag'=>'div',
					'properties'=>$props,
					'children'=>[$bi['title']],
					'raw'=>true
				]
			], true));
		}
	}
	
	if($dat['top']['main']['privacyPolicy']['include']){
		array_push($footerNav, HTML_element('div',[],[["tag"=>"a", "properties"=>["href"=>"`--AbsolutePrefix--`/privacy-policy.html"], "children"=>["Privacy Policy"]]]));
	}
	
	$footerNav='<div class="footerNav">'.join("",$footerNav).'</div>';
	
	$otherDynPat['`--FooterNav--`']=$footerNav;
	
	// todo sort out the pattern this should reside in
	$mainPat['`--CSS-BasicNavButton-SelectList--`']=join(',', $cssActiveButtonList);
	
	
	$igniterFunctionInsert=join("\n", $igniterFunctionInsert);
	
	$siteMapUrls=[];
	
	//$navButtons=array_filter($navButtons);
	//die(json_encode(['success'=>false, 'data'=>$navButtons]));
	
	
	
	foreach($pages as $pageIndex=>$p)
	{// PrepIfExists FirstSet 
		$seoOb=Calc_SeoOb($dat['top']['meta'], $p['meta']);
		$headElems=[];
		//die(json_encode(['success'=>false, 'msg'=>'check network tab', 'data'=>$seoOb]));
		array_push($headElems, HTML_element('meta',['charset'=>'utf-8']));
		array_push($headElems, HTML_element('meta',['name'=>'viewport', 'content'=>'width=device-width, initial-scale=1']));
		//array_push($headElems, HTML_element('meta',['http-equiv'=>'Content-Type', 'content'=>'text/html','charset'=>'utf-8']));
		
		
		//$pageDataInsert[$p['name']]['title']=$seoOb['basicTitle'];
		
		/// BASIC SEO
		if($seoOb['basicTitle']){
			array_push($headElems,HTML_element("title", [], [$seoOb['basicTitle']]));
		}
		SeoMetaCheck($headElems,$seoOb,'basicDescription', 'description');
		SeoMetaCheck($headElems,$seoOb,'pageName', 'pageName');
		SeoMetaCheck($headElems,$seoOb,'application-name', 'application-name');
		SeoMetaCheck($headElems,$seoOb,'keywords', 'keywords');

		
		/// FACEBOOK SEO 
		
		SeoMetaPropCheck($headElems,$seoOb['facebook'],'title', 'og:title');
		SeoMetaPropCheck($headElems,$seoOb['facebook'],'description', 'og:description');
		SeoMetaPropCheck($headElems,$seoOb['facebook']['basic'],'ogType','og:type');
		if(!SeoMetaPropCheck($headElems,$seoOb['facebook']['basic'],'url','og:url')){
			array_push($headElems,  HTML_element('meta', ['property'=>'og:url', 'content'=>"`--TopUri--`/$p[urlTarget]"]));
		}
		SeoMetaPropCheck($headElems,$seoOb['facebook']['basic'],'websiteName','og:site_name');
		
			// fb locale 
			
			SeoMetaPropCheck($headElems, $seoOb['facebook']['locale'],'determiner', 'og:determiner');
			SeoMetaPropCheck($headElems, $seoOb['facebook']['locale'],'locale', 'og:locale');
			
			foreach($seoOb['facebook']['locale']['alternateLocales'] as $k=>$v)
			{
				SeoMetaPropCheck($headElems, $seoOb['facebook']['locale']['alternateLocales'], $k, 'og:locale:alternate');
			}
		
			// fb article
			SeoMetaPropCheck($headElems, $seoOb['facebook']['article'],'author', 'og:article:author');
			SeoMetaPropCheck($headElems, $seoOb['facebook']['article'],'expirationTime', 'og:article:expirationTime');
			SeoMetaPropCheck($headElems, $seoOb['facebook']['article'],'modifiedTime', 'og:article:modifiedTime');
			SeoMetaPropCheck($headElems, $seoOb['facebook']['article'],'publishedTime', 'og:article:publishedTime');
			foreach($seoOb['facebook']['article']['tagList'] as $tag)
			{
				array_push($headElems, HTML_element('meta',[
					'property'=>'og:article:tag',
					'content'=>$tag
				]));
			}
			
			
			
			// fb video
			foreach($seoOb['facebook']['video']['videoList'] as $vl)
			{
				array_push($headElems, HTML_element('meta',[
					'property'=>'og:video',
					'content'=>'`--AbsolutePrefix--`/media/videos/'.$vl['video']
				]));
			}
			foreach($seoOb['facebook']['video']['actors'] as $vl)
			{
				SeoMetaPropCheck($headElems, $vl, 'profile', 'og:video:actor');
				SeoMetaPropCheck($headElems, $vl, 'role', 'og:video:actor:role');
			}
			foreach($seoOb['facebook']['video']['directors'] as $k=>$vl)
			{
				SeoMetaPropCheck($headElems, $seoOb['facebook']['video']['directors'], $k, 'og:video:director');
			}
			
			foreach($seoOb['facebook']['video']['tags'] as $k=>$vl)
			{
				SeoMetaPropCheck($headElems, $seoOb['facebook']['video']['tags'], $k, 'og:video:tag');
			}
			SeoMetaPropCheck($headElems, $seoOb['facebook']['video'],'releaseDate','og:video:release_date');
			SeoMetaPropCheck($headElems, $seoOb['facebook']['video'],'series','og:video:series');
			SeoMetaPropCheck($headElems, $seoOb['facebook']['video'],'duration','og:video:duration');
			
			// fb audio 
			foreach($seoOb['facebook']['audio']['audioList'] as $al)
			{
				array_push($headElems, HTML_element('meta',[
					'property'=>'og:audio',
					'content'=>"`--AbsolutePrefix--`/media/audios/$al[audio]"
				]));
			}
			foreach($seoOb['facebook']['audio']['albumArray'] as $al)
			{
				SeoMetaPropCheck($headElems, $al, 'profile', 'og:music:album');
				SeoMetaPropCheck($headElems, $al, 'albumDisc', 'og:music:album:disc');
				SeoMetaPropCheck($headElems, $al, 'albumTrack', 'og:music:album:track');

			}
			foreach($seoOb['facebook']['audio']['musicians'] as $k=>$al)
			{
				SeoMetaPropCheck($headElems, $seoOb['facebook']['audio']['musicians'], $k, 'og:music:musician');

			}
			foreach($seoOb['facebook']['audio']['songList'] as $al)
			{
				SeoMetaPropCheck($headElems, $al, 'profile', 'og:music:song');
				SeoMetaPropCheck($headElems, $al, 'songDisc', 'og:music:song:disc');
				SeoMetaPropCheck($headElems, $al, 'songTrack', 'og:music:song:track');

			}
			SeoMetaPropCheck($headElems, $seoOb['facebook']['audio'], 'creator', 'og:music:creator');
			SeoMetaPropCheck($headElems, $seoOb['facebook']['audio'], 'releaseDate', 'og:music:release_date');
			SeoMetaPropCheck($headElems, $seoOb['facebook']['audio'], 'duration', 'og:music:duration');
			
			// fb profile 
			SeoMetaPropCheck($headElems, $seoOb['facebook']['profile'], 'firstName', 'og:profile:first_name');
			SeoMetaPropCheck($headElems, $seoOb['facebook']['profile'], 'lastName', 'og:profile:last_name');
			SeoMetaPropCheck($headElems, $seoOb['facebook']['profile'], 'username', 'og:profile:username');
			SeoMetaPropCheck($headElems, $seoOb['facebook']['profile'], 'gender', 'og:profile:gender');
			
			// fb book 
			
			SeoMetaPropCheck($headElems, $seoOb['facebook']['book'], 'author', 'og:book:author');
			SeoMetaPropCheck($headElems, $seoOb['facebook']['book'], 'isbn', 'og:book:isbn');
			SeoMetaPropCheck($headElems, $seoOb['facebook']['book'], 'release_date', 'og:book:release_date');
			foreach($seoOb['facebook']['book']['tagList'] as $k=>$tag)
			{
				SeoMetaPropCheck($headElems, $seoOb['facebook']['book']['tagList'], $k, 'og:book:tag');
			}
			
			// fb image 
			foreach($seoOb['facebook']['image']['list'] as $l)
			{
				$imm=$l['image'];
				array_push($headElems, HTML_element('meta',[
					'property'=>'og:image',
					'content'=>"`--TopUri--`/media/images/$imm[image]/$imm[size].$imm[srcType]"
				]));
				if(!$l['alt'] 
				&& 
				($imOb = 
					array_filter(
						$dat['top']['media']['imageSources']['images'],
						function($i) use($imm){return $i['slug'] === $imm['image'];}))){
					$imOb=array_values($imOb);
					
					$l['alt']=$imOb[0]['altText'];
				}
				SeoMetaPropCheck($headElems, $l, 'alt', 'og:image:alt');
			}
			
		// TWITTER SEO
		
		// Links 
		SeoLink($headElems, $seoOb['links'],'canonical', 'canonical');
		SeoLink($headElems, $seoOb['links'], 'help', 'help');
		SeoLink($headElems, $seoOb['links'], 'search', 'search');
		SeoLink($headElems, $seoOb['links'], 'reply-to', 'reply-to');
		SeoLink($headElems, $seoOb['links'], 'publisher', 'publisher');
		SeoLink($headElems, $seoOb['links'], 'shortLink', 'shortlink');
		
		// Time 
		SeoMetaCheckArr($headElems, $seoOb['time']);
		
		// Geo
		SeoMetaCheckArr($headElems, $seoOb['geo']);
		
		// journalism
		SeoMetaCheckArr($headElems, $seoOb['journalism']);
		
		// devEnvironment 
		SeoMetaCheckArr($headElems, $seoOb['devEnvironment']);
		
		// mobile 
		
		if($seoOb['mobileOptimized']){
			array_push($headElems, HTML_element('meta',['name'=>'mobileOptimized', 'content'=>'true']));
		}
		if($seoOb['handheldFriendly']){
			array_push($headElems, HTML_element('meta',['name'=>'handheldFriendly', 'content'=>'true']));
		}
		
		// Robots 
		
		SeoMetaCheckArr($headElems,$seoOb['robots']);
		
		// Duplin Core
		
		SeoMetaCheckArr($headElems, $seoOb['duplinCore']);
		
		// Icons 
		foreach($seoOb['icons'] as $ic)
		{
			if($ic['value']){
				if($ic['elType'] === 'link'){
					array_push($headElems, HTML_element('link',[
						'rel'=>$ic['name'], 
						'sizes'=>$ic['size'].'x'.$ic['size'], 
						'href'=>'`--AbsolutePrefix--`/media/icons/'.$ic['value']
					]));
				}else if($ic['elType'] === 'metaProperty'){
					array_push($headElems, HTML_element('meta',[
						'property'=>$ic['name'],
						'content'=>'`--AbsolutePrefix--`/media/icons/'.$ic['value']
					]));
				}else{
					array_push($headElems, HTML_element('meta',[
						'name'=>$ic['name'],
						'content'=>'`--AbsolutePrefix--`/media/icons/'.$ic['value']
					]));
				}
			}
		}
		SeoMetaCheck($headElems, $seoOb, 'msAppTileColor', 'msapplication-TileColor');
		
		if($seoOb['raw']){
			array_push($headElems, $seoOb['raw']);
		}
		
		if($dat['top']['main']['browserConfig']['include']){
			array_push($headElems, HTML_element('meta', ['name'=>'msapplication-config', 'content'=>'`--AbsolutePrefix--`/browserconfig.xml']));
		}
		
		if($p['urlTarget']){
			//echo("$p[urlTarget] <br>");
			EnsureDirectory("$localPubDirectory/$p[urlTarget]");
				foreach(scandir("$localPubDirectory/$p[urlTarget]") as $s)
				{
					if(is_file("$localPubDirectory/$p[urlTarget]/$s")){unlink("$localPubDirectory/$p[urlTarget]/$s");}
				}
				//EmptyDirectory("$localPubDirectory/$p[urlTarget]");
			EnsureDirectory("$livePubDirectory/$p[urlTarget]");
				foreach(scandir("$livePubDirectory/$p[urlTarget]") as $s)
				{
					if(is_file("$livePubDirectory/$p[urlTarget]/$s")){unlink("$livePubDirectory/$p[urlTarget]/$s");}
				}
				//EmptyDirectory("$livePubDirectory/$p[urlTarget]");
		}
		$pageScripts='';
		$pageStyles='';
		$pageCss=array_reduce($p['main']['CSSList'],function($carry,$m){
			return "$carry\n/*$m[name]*/\n$m[content]";
		},'');
		$pageJs=array_reduce($p['main']['JSList'],function($carry,$m){
			return "$carry\n//$m[name]\n$m[content]";
		},'');
		if($pageCss){
			$pageStyles="<style>
$pageCss
</style>";
		}
		if($pageJs){
			$pageScripts="<script>
$pageJs
</script>";
		}
		
		$fileTargetRoot="$localPubDirectory/$p[urlTarget]";
		$liveFileTargetRoot="$livePubDirectory/$p[urlTarget]";
		$fileTarget="$localPubDirectory/$p[urlTarget]/index";
		$liveFileTarget="$livePubDirectory/$p[urlTarget]/index";
		if(!$p['urlTarget']){
			$fileTargetRoot="$localDirectory";
			$liveFileTargetRoot="$liveDirectory";
			$fileTarget="$localPubDirectory/index";
			$liveFileTarget="$livePubDirectory/index";
		}
		if($p['main']['igniterFunction']){
			$p['main']['html'].="\n<script>VC.prototype.pageData['$p[name]'].igniterFunction();</script>";
		}
		
		
		$pUnirepArray=[];
		foreach($p['unirep']['unirepList'] as $ur)
		{
			$pUnirepArray[$ur['tag']]=$ur['value'];
		}
		
		$htmlPropertyObject=['lang'=>$dat['top']['main']['lang']];
		if($p['name'] === 'siteNav' && $dat['top']['main']['hamburgerButton']){
			$htmlPropertyObject['class']='navActive';
		}
		
		foreach($dat['top']['main']['appButtons']['list'] as $ab)
		{
			$otherDynPat["`--AppButton-$ab[buttonName]-Destination--`"]="`--AppButton-$ab[buttonName]-Destination-$p[name]--`";
			$otherDynPat["`--AppButton-$ab[buttonName]-DestinationName--`"]="`--AppButton-$ab[buttonName]-DestinationName-$p[name]--`";
			$otherDynPat["`--AppButton-$ab[buttonName]-HiderClass--`"]="`--AppButton-$ab[buttonName]-HiderClass-$p[name]--`";
			$otherDynPat["`--AppButton-$ab[buttonName]-Title--`"]="`--AppButton-$ab[buttonName]-Title-$p[name]--`";
			$otherDynPat["`--AppButton-$ab[buttonName]-AriaLabel--`"]="`--AppButton-$ab[buttonName]-AriaLabel-$p[name]--`";
			
		}
		
		$locRepPat=[
			'`--PageName--`'=>$p['name'],
			'`--PageUrlTarget--`'=>$p['urlTarget'],
			'`--IgniterFunctionInsert--`'=>$igniterFunctionInsert,
			'`--PageScripts--`'=>$pageScripts,
			'`--PageStyles--`'=>$pageStyles,
			'`--SEOContent--`'=>join("\n", $headElems),
			'`--Content--`'=>$p['main']['html'],
			'`--NavButtons--`'=>join("", $navButtons),
			'`--NavButtons-DQEscaped--`'=>str_replace(['"',"\n"],['\\"','\\n'],str_replace('\\','\\\\',join("", $navButtons))),
			'`--AbsolutePrefix--`'=>'/siteGenerator/v1/previews/'.$projectInfo['slug'],
			'`--VCRPages--`'=>join("\n", $viewFunctions),
			'`--TopUri--`'=>'http://localhost/siteGenerator/v1/previews/'.$projectInfo['slug'],
			'`--ActiveViewClass--`'=>'activeView-'.str_replace(' ','-',$p['name']),
			'`--HtmlProperties--`'=>HTML_parseProperties($htmlPropertyObject),
			'`--RECAPTCHA-PublicKey--`'=>$dat['top']['main']['recaptcha']['publicKeyTest'],
			'`--RECAPTCHA-PrivateKey--`'=>$dat['top']['main']['recaptcha']['privateKeyTest'],
			
			'`--PrivacyPolicy-Link--`'=>'<a href="`--AbsolutePrefix--`/privacy-policy.html">Privacy Policy</a>',
			
			'`--CookieManager-StorageName--`'=>$dat['top']['main']['cookieManager']['storageIndex'],
			'`--CookieManager-SiteCookies--`'=>$cookieManagerSiteCookies,
			'`--CookieManager-LaunchButton--`'=>'<div id="cookieManagerButtonWrapper"><button onclick="_el.CancelEvent(event);CookieManager.Render();" class="CookieManager-LaunchButton">Open Cookie Manager</button></div>',
			'`--SecureFolder--`'=>$secSecureFolder
		];
		
		$livRepPat=[
			'`--PageName--`'=>$p['name'],
			'`--PageUrlTarget--`'=>$p['urlTarget'],
			'`--IgniterFunctionInsert--`'=>$igniterFunctionInsert,
			'`--PageScripts--`'=>$pageScripts,
			'`--PageStyles--`'=>$pageStyles,
			'`--SEOContent--`'=>join("\n", $headElems),
			'`--Content--`'=>$p['main']['html'],
			'`--NavButtons--`'=>join("", $navButtons),
			'`--NavButtons-DQEscaped--`'=>str_replace(['"',"\n"],['\\"','\\n'],str_replace('\\','\\\\',join("", $navButtons))),
			'`--AbsolutePrefix--`'=>$dat['top']['main']['absolutePrefix'],
			'`--VCRPages--`'=>join("\n", $viewFunctions),
			'`--TopUri--`'=>$dat['top']['main']['topUri'],
			'`--ActiveViewClass--`'=>'activeView-'.str_replace(' ','-',$p['name']),
			'`--HtmlProperties--`'=>HTML_parseProperties($htmlPropertyObject),
			'`--RECAPTCHA-PublicKey--`'=>$dat['top']['main']['recaptcha']['publicKey'],
			'`--RECAPTCHA-PrivateKey--`'=>$dat['top']['main']['recaptcha']['privateKey'],
			
			'`--PrivacyPolicy-Link--`'=>'<a href="`--AbsolutePrefix--`/privacy-policy.html">Privacy Policy</a>',
			
			'`--CookieManager-StorageName--`'=>$dat['top']['main']['cookieManager']['storageIndex'],
			'`--CookieManager-SiteCookies--`'=>$cookieManagerSiteCookies,
			'`--CookieManager-LaunchButton--`'=>'<div id="cookieManagerButtonWrapper"><button onclick="_el.CancelEvent(event);CookieManager.Render();" class="CookieManager-LaunchButton">Open Cookie Manager</button></div>',
			'`--SecureFolder--`'=>$secSecureFolder
		];
		
		
		$tempPageDataInsert=$pageDataInsert;
		$tempLivePageDataInsert=$tempPageDataInsert;
		$tempLocaPageDataInsert=$tempPageDataInsert;
		foreach($pageDataInsert as $k=>$v)
		{
			$tempLivePageDataInsert[$k]['html']=UniRep($pageDataInsert[$k]['html'],$livRepPat, $colorPalletArray, $breakpointArray, $otherDynPat,$dynamicSectionPostPat,$mainPat,$pUnirepArray);
			$tempLocaPageDataInsert[$k]['html']=UniRep($pageDataInsert[$k]['html'],$locRepPat, $colorPalletArray, $breakpointArray, $otherDynPat,$dynamicSectionPostPat,$mainPat,$pUnirepArray);
		}
		
		
		$tempLivePageDataInsert[$p['name']]['cssLoaded']=true;
		$tempLivePageDataInsert[$p['name']]['jsLoaded']=true;
		
		$tempLocaPageDataInsert[$p['name']]['cssLoaded']=true;
		$tempLocaPageDataInsert[$p['name']]['jsLoaded']=true;
		
		$livRepPat['`--PageDataInsert--`']=json_encode($tempLivePageDataInsert);
		$locRepPat['`--PageDataInsert--`']=json_encode($tempLocaPageDataInsert);
		
		$finalFileTarget=file_put_contents_autoDetect($fileTarget, $pageCat=Unirep($documentTemp,$locRepPat, $colorPalletArray, $breakpointArray,$otherDynPat,$dynamicSectionPostPat, $mainPat,$pUnirepArray));
		
		$finalLiveFileTarget=file_put_contents_autoDetect($liveFileTarget, $pageCat=Unirep($documentTemp,$livRepPat, $colorPalletArray, $breakpointArray, $otherDynPat,$dynamicSectionPostPat,$mainPat,$pUnirepArray));
		
		if($pageCss){
			file_put_contents("$fileTargetRoot/css.css", LessifyText(
				$globalLESS,
				$LessParser,
				Unirep($pageCss, $colorPalletArray, $breakpointArray, $otherDynPat,$mainPat, $pUnirepArray)
			));
			//$LessParser->parse("$fileTargetRoot/css.css", "$fileTargetRoot/css.css");
			file_put_contents("$liveFileTargetRoot/css.css", LessifyText(
				$globalLESS,
				$LessParser,
				Unirep($pageCss, $colorPalletArray, $breakpointArray, $otherDynPat,$mainPat, $pUnirepArray)
			));
			//$LessParser->parse("$liveFileTargetRoot/css.css", "$liveFileTargetRoot/css.css");
		}
		
		LessifyFile($globalLESS,$LessParser, $DD, $finalFileTarget);
		LessifyFile($globalLESS,$LessParser, $DD, $finalLiveFileTarget);
		
		if($pageJs){
			file_put_contents("$fileTargetRoot/js.js", Unirep($pageJs, $colorPalletArray, $breakpointArray, $otherDynPat,$mainPat, $pUnirepArray));
			file_put_contents("$liveFileTargetRoot/js.js", Unirep($pageJs, $colorPalletArray, $breakpointArray, $otherDynPat,$mainPat, $pUnirepArray));
		}
		
		
		$pageHash=hash('crc32c',$pageCat);
		
		if(!isset($projectPageHashes[$p['name']])){
			$projectPageHashes[$p['name']]=[
				'hash'=>$pageHash,
				'lastModified'=>date('Y-m-d'),
				'slug'=>$p['urlTarget']
			];
		}else{
			if($projectPageHashes[$p['name']]['hash'] !== $pageHash){
				$projectPageHashes[$p['name']]['hash']=$pageHash;
				$projectPageHashes[$p['name']]['lastModified']=date('Y-m-d');
				$projectPageHashes[$p['name']]['slug']=$p['urlTarget'];
				
			}
		}
		$projectPageHashes[$p['name']]['sitemapInclude']=$p['sitemap']['include'];
		$projectPageHashes[$p['name']]['sitemapChangeFrequency']=$p['sitemap']['changeFrequency'];
		$projectPageHashes[$p['name']]['sitemapPriority']=$p['sitemap']['priority'];
		
		
		
	}// end page render for loop
	
	
	
	foreach($recapProtStaged as $rps)
	{
		$rpcOb=['`--RPC-FileName--`'=>$rps['fileName']];
		file_put_contents("$localPubDirectory/recapProtContent_/$rps[fileName]/request.php",Unirep(file_get_contents("templates/recapProt/request.php.temp"),$locRepPat,$rpcOb));
		file_put_contents("$livePubDirectory/recapProtContent_/$rps[fileName]/request.php",Unirep(file_get_contents("templates/recapProt/request.php.temp"),$livRepPat,$rpcOb));
		file_put_contents("$localSecDirectory/recapProtContent/$rps[fileName]/html.html", Unirep($rps['html'],$locRepPat,$rpcOb));
		file_put_contents("$liveSecDirectory/recapProtContent/$rps[fileName]/html.html", Unirep($rps['html'],$livRepPat,$rpcOb));
	}
	
	
	file_put_contents("projectPageHashes.json", json_encode($projectPageHashes));
	
	if($dat['top']['main']['includeSiteMap']){
		file_put_contents("$localPubDirectory/sitemap.xml", 
			Unirep(file_get_contents("defaults-templates-patterns/sitemapTemplate.xml.temp"),
				[
					'`--SitemapUrlList--`'=>join("\n", array_filter(array_map(function($m){
						if(!$m['sitemapInclude']){return '';}
						$chArr=[];
						array_push($chArr, 
							['tag'=>'loc', 'properties'=>[], 'children'=>["`--TopUri--`/$m[slug]"]],
							['tag'=>'lastmod', 'properties'=>[], 'children'=>[$m['lastModified']]]
						);
						if($m['sitemapChangeFrequency']){array_push($chArr, ['tag'=>'changefreq', 'properties'=>[], 'children'=>[$m['sitemapChangeFrequency']]]);}
						if($m['sitemapPriority']){array_push($chArr, ['tag'=>'priority', 'properties'=>[], 'children'=>[$m['sitemapPriority']]]);}
						return HTML_element('url',[],$chArr);
					},$projectPageHashes)))
				],
				[
					'`--TopUri--`'=>'http://localhost/siteGenerator/v1/previews/'.$projectInfo['slug']
				]
			)
		);
		file_put_contents("$livePubDirectory/sitemap.xml", 
			Unirep(file_get_contents("defaults-templates-patterns/sitemapTemplate.xml.temp"),
				[
					'`--SitemapUrlList--`'=>join("\n", array_merge(array_filter(array_map(function($m){
						if(!$m['sitemapInclude']){return '';}
						$chArr=[];
						array_push($chArr, 
							['tag'=>'loc', 'properties'=>[], 'children'=>["`--TopUri--`/$m[slug]"]],
							['tag'=>'lastmod', 'properties'=>[], 'children'=>[$m['lastModified']]]
						);
						if($m['sitemapChangeFrequency']){array_push($chArr, ['tag'=>'changefreq', 'properties'=>[], 'children'=>[$m['sitemapChangeFrequency']]]);}
						if($m['sitemapPriority']){array_push($chArr, ['tag'=>'priority', 'properties'=>[], 'children'=>[$m['sitemapPriority']]]);}
						return HTML_element('url',[],$chArr);
					},$projectPageHashes)),
						array_map(function($binf){
							return HTML_element('url',[],[['tag'=>'loc', 'properties'=>[], 'children'=>["`--TopUri--`/$binf[slug]"]]]);
						}, $dat['top']['admin']['blogs'])
					))
				],
				[
					'`--TopUri--`'=>$dat['top']['main']['topUri']
				]
			)
		);
	}
	if($dat['top']['main']['privacyPolicy']['include']){
		RenderPrivacyPolicy($localPubDirectory, $livePubDirectory, $dat['top']['main']['privacyPolicy'], $dat,$livRepPat,$locRepPat);
	}
	if($dat['top']['main']['robots']['include']){
		$txt=[];
		foreach($dat['top']['main']['robots']['agentList'] as $al)
		{
			array_push($txt, "User-agent: $al[userAgent]");
			foreach($al['commands'] as $cm)
			{
				array_push($txt, "$cm[command]: $cm[value]");
			}
		}
		if($dat['top']['main']['includeSiteMap']){
			array_push($txt,"Sitemap: `--TopUri--`/sitemap.xml");
		}
		foreach($dat['top']['admin']['blogs'] as $binf)
		{
			array_push($txt,"Sitemap: `--TopUri--`/$binf[slug]/sitemap.xml");
		}
		$txt=join("\n", $txt);
		file_put_contents("$localPubDirectory/robots.txt", Unirep($txt, [
			'`--TopUri--`'=>'http://localhost/siteGenerator/v1/previews/'.$projectInfo['slug']
		]));
		file_put_contents("$livePubDirectory/robots.txt", Unirep($txt, [
			'`--TopUri--`'=>$dat['top']['main']['topUri']
		]));
	}
	
	if($dat['top']['main']['browserConfig']['include']){
		$chArr=[];
		$msChArr=[];
		$msTileArr=[];
		if($dat['top']['main']['browserConfig']['msapplication']['include']){
			if($seoOb['browserConfig']['large']['value']){
				
				array_push($msTileArr,['tag'=>'square150x150logo', 'properties'=>['src'=>'`--TopUri--`/media/icons/'.$seoOb['browserConfig']['large']['value']]]);
			}
			if($seoOb['browserConfig']['small']['value']){
				array_push($msTileArr,['tag'=>'square70x70logo', 'properties'=>['src'=>'`--TopUri--`/media/icons/'.$seoOb['browserConfig']['small']['value']]]);
			}
			if($seoOb['browserConfig']['tileColor']){
				
				array_push($msTileArr,['tag'=>'TileColor','children'=>[$seoOb['browserConfig']['tileColor']]]);
			}
			array_push($msChArr, ['tag'=>'tile', 'children'=>$msTileArr]);
			array_push($chArr, ['tag'=>'msapplication', 'children'=>$msChArr]);
			
			
		}
		$txt="<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$txt.=HTML_element("browserconfig",[],$chArr);
		file_put_contents("$localPubDirectory/browserconfig.xml", Unirep($txt, [
			'`--TopUri--`'=>'http://localhost/siteGenerator/v1/previews/'.$projectInfo['slug']
		]));
		file_put_contents("$livePubDirectory/browserconfig.xml", Unirep($txt, [
			'`--TopUri--`'=>$dat['top']['main']['topUri']
		]));
	}
	
	
	EnsureDirectory("$liveDirectory/php_library");
		EmptyDirectory("$liveDirectory/php_library");
	
	foreach($dat['top']['main']['php_library'] as $k=>$v)
	{
		if($v){
			copy("$_SERVER[DOCUMENT_ROOT]/../php_library/$k.php", "$liveDirectory/php_library/$k.php");
		}
	}
	
	
	if($dat['top']['main']['cookieManager']['include']){
		file_put_contents("$livePubDirectory/js_library/cookieManager.js", Unirep(file_get_contents("$_SERVER[DOCUMENT_ROOT]/js_library/cookieManager.js"), $livRepPat));
		file_put_contents("$localPubDirectory/js_library/cookieManager.js", Unirep(file_get_contents("$_SERVER[DOCUMENT_ROOT]/js_library/cookieManager.js"), $locRepPat));
		
		copy("$_SERVER[DOCUMENT_ROOT]/js_library/cookieManager.css", "$livePubDirectory/js_library/cookieManager.css");
			LessifyCssFile($globalLESS, $LessParser, "$livePubDirectory/js_library/cookieManager.css");
		copy("$_SERVER[DOCUMENT_ROOT]/js_library/cookieManager.css", "$localPubDirectory/js_library/cookieManager.css");
			LessifyCssFile($globalLESS, $LessParser, "$localPubDirectory/js_library/cookieManager.css");
	}
	
	
	if($dat['top']['admin']['include']){
		RenderAdmin($dat, $projectInfo);
	}
	foreach($dat['top']['admin']['blogs'] as $bi)
	{
		//$binf, $refInf, $locDirs, $livDirs, $uPat, $livPat, $locPat
		RenderPublicBlog($bi, $dat, ['pub'=>$localPubDirectory, 'sec'=>$localSecDirectory],['pub'=>$livePubDirectory, 'sec'=>$liveSecDirectory], [
			// upat
			'`--PageName--`'=>$p['name'],
			'`--PageUrlTarget--`'=>$p['urlTarget'],
			'`--SecureFolder--`'=>$secSecureFolder
		], [
			// locpat
			'`--AbsolutePrefix--`'=>$dat['top']['main']['absolutePrefix'],
			'`--TopUri--`'=>$dat['top']['main']['topUri'],
		], [
			// livpat
			'`--AbsolutePrefix--`'=>'/siteGenerator/v1/previews/'.$projectInfo['slug'],
			'`--TopUri--`'=>'http://localhost/siteGenerator/v1/previews/'.$projectInfo['slug'],
		]);
	}
	
	
	//die(json_encode(['success'=>true, 'msg'=>$documentTemp]));
	
	//BROTLI_directory($localPubDirectory);
	//BROTLI_directory($livePubDirectory);
	
}

function ParseSeoIcon($key, $name, $size, $elType, $main, $page){
	return [
		'name'=>$name,
		'elType'=>$elType,
		'size'=>$size,
		'value'=>FirstSet($page[$key] ?? '', $main[$key] ?? '')
	];
}
function SeoMetaCheck(&$htmlElems,$seoOb,$objectName, $metaName){
	if($seoOb[$objectName]){
		array_push($htmlElems, HTML_element('meta', ['name'=>$metaName, 'content'=>$seoOb[$objectName]]));
		return true;
	}return false;
	
}
function SeoMetaCheckArr(&$htmlElems, $seoOb){
	foreach($seoOb as $k=>$content)
	{
		SeoMetaCheck($htmlElems, $seoOb, $k, $k);
	}
}
function SeoMetaPropCheck(&$htmlElems,$seoOb,$objectName, $metaName){
	if($seoOb[$objectName]){
		array_push($htmlElems, HTML_element('meta', ['property'=>$metaName, 'content'=>$seoOb[$objectName]]));
		return true;
	}return false;
	
}
function SeoLink(&$htmlElems, $seoOb, $objectName, $linkRel){
	if($seoOb[$objectName]){
		array_push($htmlElems, HTML_element('link',['rel'=>$linkRel, 'href'=>$seoOb[$objectName]]));
	}
}
function SeoSimpleFallthrough($page, $main, $item){
	if(!isset($page[$item])){return $main[$item];}
	if(is_array($page[$item])){
		return array_merge($page[$item], $main[$item]);
	}
	return FirstSet($page[$item],$main[$item]);
}
function SeoSimpleFallthroughArr($page, $main){
	$ret=[];
	foreach($page as $k=>$v)
	{
		$ret[$k]=SeoSimpleFallthrough($page, $main, $k);
	}
	return $ret;
}

function Calc_SeoOb($main, $page){
	//die(';ljidja'.json_encode($page));
	return [
		'raw'=>$main['raw'].PrepIfExists("\n",$page['raw']),
		'icons'=>[
			ParseSeoIcon('appleTouchLg', 'apple-touch-icon', '180', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('appleTouchMd', 'apple-touch-icon', '152', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('appleTouchSm', 'apple-touch-icon', '120', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon16', 'icon', '16', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon32', 'icon', '32', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon57', 'icon', '57', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon76', 'icon', '76', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon96', 'icon', '96', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon120', 'icon', '120', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon128', 'icon', '128', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon144', 'icon', '144', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon152', 'icon', '152', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon167', 'icon', '167', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon180', 'icon', '180', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon192', 'icon', '192', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon195', 'icon', '195', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon196', 'icon', '196', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon228', 'icon', '228', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('shortcutIcon', 'shortcut icon', '196', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('msAppTile', 'msapplication-TileImage', '144', 'meta', $main['icons'], $page['icons']),
			
		],
		'msAppTileColor'=>SeoSimpleFallthrough($page['icons'], $main['icons'],'msAppTileColor'),
		'browserConfig'=>[
			'large'=>ParseSeoIcon('browserConfigMsAppLg','square150x150logo', '228', 'xml', $main['icons'], $page['icons']),
			'small'=>ParseSeoIcon('browserConfigMsAppSm','square70x70logo', '76', 'xml', $main['icons'], $page['icons']),
			'tileColor'=>SeoSimpleFallthrough($page['icons'], $main['icons'],'browserConfigMsAppTileColor')
		],
		'mobileOptimized'=>$page['mobile']['mobileOptimized'],
		'handheldFriendly'=>$page['mobile']['handheldFriendly'],
		'pageName'=>SeoSimpleFallthrough($page['general'],$main['general'],'pageName'),
		'application-name'=>SeoSimpleFallthrough($page['application'],$main['application'],'applicationName'),
		'basicTitle'=>PrepAppIfExists(
			AppIfExists(
				FirstSet(
					$main['general']['preTitle']
				),
				' '
			),
			FirstSet(
				$page['general']['title'],
				$main['general']['title']
			),
			PrepIfExists(
				' ',
				FirstSet(
					$main['general']['postTitle']
				)
			)
		),
		'basicDescription'=>PrepAppIfExists(
			AppIfExists(
				FirstSet(
					$main['general']['preDescription']
				),
				' '
			),
			FirstSet(
				$page['general']['description'],
				$main['general']['description']
			),
			PrepIfExists(
				' ',
				FirstSet(
					$main['general']['postDescription']
				)
			)
		),
		'keywords'=>join(',',array_merge($page['general']['keywords'],$main['general']['keywords'])),
		'links'=>[
			'canonical'=>FirstSet($page['links']['canonical'] ?? '',"`--TopUri--`/`--PageUrlTarget--`"),
			'help'=>SeoSimpleFallthrough($page['links'], $main['links'], 'help'),
			'publisher'=>SeoSimpleFallthrough($page['links'], $main['links'], 'publisher'),
			'reply-to'=>SeoSimpleFallthrough($page['links'], $main['links'], 'replyTo'),
			'search'=>SeoSimpleFallthrough($page['links'], $main['links'], 'search'),
			'shortLink'=>SeoSimpleFallthrough($page['links'], $main['links'], 'shortLink'),
		],
		'time'=>[
			'date'=>SeoSimpleFallthrough($page['time'], $main['time'], 'date'),
			'revised'=>SeoSimpleFallthrough($page['time'], $main['time'], 'revised'),
			'search-date'=>SeoSimpleFallthrough($page['time'], $main['time'], 'search-date')
		],
		'geo'=>SeoSimpleFallthroughArr($page['geo'],$main['geo']),
		'journalism'=>SeoSimpleFallthroughArr($page['journalism'],$main['journalism']),
		'devEnvironment'=>SeoSimpleFallthroughArr($page['devEnvironment'],$main['devEnvironment']),
		'robots'=>[
			'revisitAfter'=>$page['robots']['revisitAfter'],
			'robots'=>$page['robots']['robots']['index'].'|'.$page['robots']['robots']['follow']
		],
		'facebook'=>[
			'title'=>PrepAppIfExists(
					AppIfExists(
						FirstSet(
							$main['facebook']['basic']['preTitle'],
							$main['general']['preTitle']
						),
						' '
					),
					FirstSet(
						$page['facebook']['basic']['title'],
						$main['facebook']['basic']['title'],
						$page['general']['title'],
						$main['general']['title']
					),
					PrepIfExists(
						' ',
						FirstSet(
							$main['facebook']['basic']['postTitle'],
							$main['general']['postTitle']
						)
					)
				),
				'description'=>PrepAppIfExists(
					AppIfExists(
						FirstSet(
							$main['facebook']['basic']['preDescription'],
							$main['general']['preDescription']
						),
						' '
					),
					FirstSet(
						$page['facebook']['basic']['description'],
						$main['facebook']['basic']['description'],
						$page['general']['description'],
						$main['general']['description']
					),
					PrepIfExists(
						' ',
						FirstSet(
							$main['facebook']['basic']['postDescription'],
							$main['general']['postDescription']
						)
					)
				),
				'article'=>[
					'author'=>SeoSimpleFallthrough($page['facebook']['article'],$main['facebook']['article'],'author'),
					'expirationTime'=>SeoSimpleFallthrough($page['facebook']['article'],$main['facebook']['article'],'expirationTime'),
					'modifiedTime'=>SeoSimpleFallthrough($page['facebook']['article'],$main['facebook']['article'],'modifiedTime'),
					'publishedTime'=>SeoSimpleFallthrough($page['facebook']['article'],$main['facebook']['article'],'publishedTime'),
					'section'=>SeoSimpleFallthrough($page['facebook']['article'],$main['facebook']['article'],'section'),
					'tagList'=>array_merge($page['facebook']['article']['tagList'], $main['facebook']['article']['tagList']),
				],
				'video'=>[
					'actors'=>array_merge($page['facebook']['video']['actors'],$main['facebook']['video']['actors']),
					'directors'=>array_merge($page['facebook']['video']['directors'],$main['facebook']['video']['directors']),
					'writers'=>array_merge($page['facebook']['video']['writers'],$main['facebook']['video']['writers']),
					'tags'=>array_merge($page['facebook']['video']['tags'],$main['facebook']['video']['tags']),
					'videoList'=>array_merge($page['facebook']['video']['videoList'],$main['facebook']['video']['videoList']),
					'duration'=>SeoSimpleFallthrough($page['facebook']['video'],$main['facebook']['video'],'duration'),
					'releaseDate'=>SeoSimpleFallthrough($page['facebook']['video'],$main['facebook']['video'],'releaseDate'),
					'series'=>SeoSimpleFallthrough($page['facebook']['video'],$main['facebook']['video'],'series'),
				],
				'audio'=>SeoSimpleFallthroughArr($page['facebook']['audio'],$main['facebook']['audio']),
				'profile'=>SeoSimpleFallthroughArr($page['facebook']['profile'], $main['facebook']['profile']),
				'book'=>SeoSimpleFallthroughArr($page['facebook']['book'],$main['facebook']['book']),
				'image'=>SeoSimpleFallthroughArr($page['facebook']['image'],$main['facebook']['image']),
				'locale'=>SeoSimpleFallthroughArr($page['facebook']['locale'],$main['facebook']['locale']),
				'basic'=>[
					'ogType'=>SeoSimpleFallthrough($page['facebook']['basic'], $main['facebook']['basic'],'ogType'),
					'websiteName'=>SeoSimpleFallthrough($page['facebook']['basic'], $main['facebook']['basic'],'websiteName'),
					'url'=>SeoSimpleFallthrough($page['facebook']['basic'], $main['facebook']['basic'],'url')
				],
			],
			'twitter'=>[
				'title'=>PrepAppIfExists(
					AppIfExists(
						FirstSet(
							$main['twitter']['preTitle'],
							$main['general']['preTitle']
						),
						' '
					),
					FirstSet(
						$page['twitter']['title'],
						$main['twitter']['title'],
						$page['general']['title'],
						$main['general']['title']
					),
					PrepIfExists(
						' ',
						FirstSet(
							$main['twitter']['postTitle'],
							$main['general']['postTitle']
						)
					)
				),
				'description'=>PrepAppIfExists(
					AppIfExists(
						FirstSet(
							$main['twitter']['preDescription'],
							$main['general']['preDescription']
						),
						' '
					),
					FirstSet(
						$page['twitter']['description'],
						$main['twitter']['description'],
						$page['general']['description'],
						$main['general']['description']
					),
					PrepIfExists(
						' ',
						FirstSet(
							$main['twitter']['postDescription'],
							$main['general']['postDescription']
						)
					)
				),
			],
			'duplinCore'=>[
				'DC.title'=>PrepAppIfExists(
					AppIfExists(
						FirstSet(
							$main['duplinCore']['preTitle'],
							$main['general']['preTitle']
						),
						' '
					),
					FirstSet(
						$page['duplinCore']['title'],
						$main['duplinCore']['title'],
						$page['general']['title'],
						$main['general']['title']
					),
					PrepIfExists(
						' ',
						FirstSet(
							$main['duplinCore']['postTitle'],
							$main['general']['postTitle']
						)
					)
				),
				'DC.description'=>PrepAppIfExists(
					AppIfExists(
						FirstSet(
							$main['duplinCore']['preDescription'],
							$main['general']['preDescription']
						),
						' '
					),
					FirstSet(
						$page['duplinCore']['description'],
						$main['duplinCore']['description'],
						$page['general']['description'],
						$main['general']['description']
					),
					PrepIfExists(
						' ',
						FirstSet(
							$main['duplinCore']['postDescription'],
							$main['general']['postDescription']
						)
					)
				),
				'DC.contributors'=>SeoSimpleFallthrough($page['duplinCore'], $main['duplinCore'],'contributors'),
				'DC.coverage'=>SeoSimpleFallthrough($page['duplinCore'], $main['duplinCore'],'coverage'),
				'DC.creator'=>SeoSimpleFallthrough($page['duplinCore'], $main['duplinCore'],'creator'),
				'DC.date'=>SeoSimpleFallthrough($page['duplinCore'], $main['duplinCore'],'date'),
				'DC.format'=>SeoSimpleFallthrough($page['duplinCore'], $main['duplinCore'],'format'),
				'DC.identifier'=>SeoSimpleFallthrough($page['duplinCore'], $main['duplinCore'],'identifier'),
				'DC.language'=>SeoSimpleFallthrough($page['duplinCore'], $main['duplinCore'],'language'),
				'DC.publisher'=>SeoSimpleFallthrough($page['duplinCore'], $main['duplinCore'],'publisher'),
				'DC.relation'=>SeoSimpleFallthrough($page['duplinCore'], $main['duplinCore'],'relation'),
				'DC.rights'=>SeoSimpleFallthrough($page['duplinCore'], $main['duplinCore'],'rights'),
				'DC.source'=>SeoSimpleFallthrough($page['duplinCore'], $main['duplinCore'],'source'),
				'DC.subject'=>SeoSimpleFallthrough($page['duplinCore'], $main['duplinCore'],'subject'),
				'DC.type'=>SeoSimpleFallthrough($page['duplinCore'], $main['duplinCore'],'type')
			]
	];
}


function ObToJsEls($arg, $eachDepth=0){
	$eachDepth++;
	if(!isset($arg['properties'])){
		$arg['properties']=[];
	}
	if(!isset($arg['children'])){
		$arg['children']=[];
	}
	$id='';
	if(isset($arg['properties']['id'])){
		$id=$arg['properties']['id'];
		unset($arg['properties']['id']);
	}
	
	$class='';
	if(isset($arg['properties']['class'])){
		$class=$arg['properties']['class'];
		unset($arg['properties']['class']);
	}
	
	
	if(!$arg['properties']){$props="{}";}else{
		$props=[];
		foreach($arg['properties'] as $p=>$v)
		{
			if(preg_match('/^on/',$p)){$v="function(event){$v}";}else{$v=str_replace(['$`','`$'],["'+","+'"],sQuote($v));}
			array_push($props, sQuote($p).':'.$v);
		}
		$props="{".join(',',$props)."}";
	}
	$chil=[];
	
	foreach($arg['children'] as $ch)
	{
		if(is_string($ch)){
			array_push($chil,"'$ch'");
			continue;
		}
		$chPrep='';
		$chOth="''";
		if(@$ch['each']){
			$chJsCond='';
			$chJsCondClose='';
			if(@$ch['childJsCondition']){$chJsCond="($ch[childJsCondition]) ? ("; $chJsCondClose=") : ''";}
			$chStr="$ch[each].map(function(".str_repeat('eac',$eachDepth)."){ return $chJsCond".ObToJsEls($ch,$eachDepth)."$chJsCondClose;})";
			$chPrep='...';$chOth="[]";
		}else{
			$chStr=ObToJsEls($ch, $eachDepth);
		}
		if(@$ch['jsCondition']){
			$chStr="(($ch[jsCondition]) ? ($chStr) : $chOth)";
		}
		$chStr="$chPrep{$chStr}";
		array_push($chil, $chStr);
	}
	$chil="[".join(",",$chil)."].filter(function(a){return a;})";
	return str_replace(["'$`","`$'"],["''+",""],"_el.CREATE('$arg[tag]','$id','$class',$props, $chil)");
}

function GetPhpElsEachClosure($eachDepth){
	$ret='';
	for($i=$eachDepth-1; $i>0; $i--)
	{
		$ret.=',$'.str_repeat('eac',$i);
	}
	return $ret;
}
function ConvertJsDerefToPhp($str){
	$spl=explode('.',$str);
	$f=array_shift($spl);
	return '$'.$f.join('',array_map(function($m){return "['".$m."']";}, $spl));
}
function ObToPhpEls($arg, $eachDepth=0){
	$eachDepth++;
	if(!isset($arg['properties'])){
		$arg['properties']=[];
	}
	if(!isset($arg['children'])){
		$arg['children']=[];
	}
	$chil=[];
	foreach($arg['children'] as $ch)
	{
		if(is_string($ch)){
			array_push($chil, "'$ch'");
			continue;
		}
		$chOth="''";
		$chPrep='';
		if(@$ch['each']){
			$chPhpCond='';
			$chPhpCondClose='';
			if(@$ch['childPhpCondition']){$chPhpCond="($ch[childPhpCondition]) ? ("; $chPhpCondClose=") : ''";}
			$eachStr='$'.($ch['each']);
			$chStr="array_map(function(\$".str_repeat('eac',$eachDepth).") use (\$dat ".GetPhpElsEachClosure($eachDepth)."){return $chPhpCond".ObToPhpEls($ch,$eachDepth)."$chPhpCondClose;}, $eachStr)";
			$chPrep='...';
			$chOth="[]";
		}else{
			$chStr=ObToPhpEls($ch, $eachDepth);
		}
		if(@$ch['phpCondition']){
			$chStr="(($ch[phpCondition]) ? ($chStr) : $chOth)";
		}
		
		$chStr="$chPrep{$chStr}";
		array_push($chil, $chStr);
	}
	
	$chil=join(',',$chil);
	$props=[];//=sQuote(json_encode($arg['properties']));
	foreach($arg['properties'] as $k=>$v)
	{
		$props[]=sQuote($k).'=>'.str_replace(['$`','`$'],["'.\$",".'"],sQuote($v));
	}
	$props='['.join(',',$props).']';
	
	
	return str_replace(["'$`","`$'"],['$',''],"['tag'=>'$arg[tag]','properties'=>$props, 'children'=>array_filter([$chil])]");
}

function file_put_contents_autoDetect($f,$c){
	if(strpos($c,"<?php") === false){$f.=".html";}else{$f.=".php";}
	file_put_contents($f,$c);
	return $f;
	
}

function RenderPrivacyPolicy($localPubDirectory, $livePubDirectory, $pDat, $refDat, $livPat, $locPat){
	$privTemp=file_get_contents('templates/privacyPolicy.html.temp');
	$livPat['`--PageUrlTarget--`']=$locPat['`--PageUrlTarget--`']="privacy-policy.html";
	
	$seoOb=Calc_SeoOb($refDat['top']['meta'], $refDat['top']['meta']);
	

	$headElems=[];
	
		SeoLink($headElems, $seoOb['links'],'canonical', 'canonical');
	// Icons 
		foreach($seoOb['icons'] as $ic)
		{
			if($ic['value']){
				if($ic['elType'] === 'link'){
					array_push($headElems, HTML_element('link',[
						'rel'=>$ic['name'], 
						'sizes'=>$ic['size'].'x'.$ic['size'], 
						'href'=>'`--AbsolutePrefix--`/media/icons/'.$ic['value']
					]));
				}else if($ic['elType'] === 'metaProperty'){
					array_push($headElems, HTML_element('meta',[
						'property'=>$ic['name'],
						'content'=>'`--AbsolutePrefix--`/media/icons/'.$ic['value']
					]));
				}else{
					array_push($headElems, HTML_element('meta',[
						'name'=>$ic['name'],
						'content'=>'`--AbsolutePrefix--`/media/icons/'.$ic['value']
					]));
				}
			}
		}
		SeoMetaCheck($headElems, $seoOb, 'msAppTileColor', 'msapplication-TileColor');
	
	$content=[];
	
	array_push($content, HTML_element('div',[],[
		['tag'=>'span','properties'=>['class'=>''], 'children'=>[
			"Last Modified: $pDat[lastModified]"
		]]
	]));
	
	if($pDat['preface']){
		array_push($content, HTML_element('h2',[],["Preface"]),HTML_element('p',[],[$pDat['preface']], true));
	}
	
	foreach($pDat['sections'] as $s)
	{
		$ch=[];
		array_push($ch, HTML_element('h2',[],[$s['heading']]));
		if($s['contactForms']){
			$formPlur="form";
			if(count($s['contactForms']) >1){
				$formPlur='forms';
				$s['contactForms'][count($s['contactForms'])-1]='and '.$s['contactForms'][count($s['contactForms'])-1];
			}
			$cfString=join(', ',$s['contactForms']);
			$cfString=str_replace(', and', ' and',$cfString);
			array_push($ch, HTML_element('h3',['class'=>'contactFormAsside'],["In regards to the $formPlur: $cfString"]));
		}
		
		if($s['description']){
			array_push($ch, HTML_element('p',[],[$s['description']], true));
		}
		if($s['howUsed']){
			array_push($ch, HTML_element('h3',[],['How we use this Data']), HTML_element('p',[],[$s['howUsed']], true));
		}
		if($s['whoSees']){
			array_push($ch, HTML_element('h3',[],['Who will see this data at our company']), HTML_element('p',[],[$s['whoSees']], true));
		}
		if($s['whoShare']){
			array_push($ch, HTML_element('h3',[],['Who we share this data with']), HTML_element('p',[],[$s['whoShare']], true));
		}
		if($s['whereStored']){
			array_push($ch, HTML_element('h3',[],['Where we store this data']), HTML_element('p',[],[$s['whereStored']], true));
		}
		if($s['storeDuration']){
			array_push($ch, HTML_element('h3',[],['How long we retain the data']), HTML_element('p',[],[$s['storeDuration']], true));
		}
		foreach($s['prefabSub'] as $n=>$pf)
		{
			if(!$pf){
				continue;
			}
			if($n === 'grecaptcha'){
				array_push($ch, HTML_element('h4',[],["Google RECAPTCHA"]),HTML_element("p",[],["Google provides a service called RECAPTCHA that helps secure a website against bot attacks. In the sections of the site protected by RECAPTCHA, we will share your browsing session with Google. Google will have access to all of the information as if you had visited the google website, along with the information that you had visited our site. Also, there is no way for us to garuntee that Google didn't capture the information entered into the forms on the website."]), HTML_element('p',[],["Google provides its own, separate <a href=\"https://policies.google.com/privacy\">Privacy Policy</a> and <a href=\"https://policies.google.com/terms\">Terms of Service</a>"], true));
			}
			if($n === 'youtube'){
				array_push($ch, HTML_element('h4',[],["YouTube"]),HTML_element("p",[],["To embed YouTube videos on our site, we have to share some of your browsing session with YouTube."]), HTML_element('p',[],["Google provides its own, separate <a href=\"https://policies.google.com/privacy\">Privacy Policy</a> and <a href=\"https://policies.google.com/terms\">Terms of Service</a>"], true));
			}
			if($n === 'youtubeApi'){
				array_push($ch, HTML_element('h4',[],["YouTube"]),HTML_element("p",[],["In order to do advanced video control on the site, YouTube provides a library. When we use the library, YouTube could see some of your browsing session."]), HTML_element('p',[],["Google provides its own, separate <a href=\"https://policies.google.com/privacy\">Privacy Policy</a> and <a href=\"https://policies.google.com/terms\">Terms of Service</a>"], true));
			}
		}
		foreach($s['subHeadings'] as $sh)
		{
			array_push($ch, HTML_element('h4',[],[$sh['heading']]), HTML_element('p',[],[$sh['description']], true));
		}
		array_push($content, HTML_element("section",[],$ch,true));
	}
	
	array_push($content, HTML_element('h2',[],["Updates"]), HTML_element("p",[],["Updated to this privacy policy will be published here. The last modified date will be present at the top. And you will be notified where possible and appropriate."]));
	
	$content=join("\n", $content);
	file_put_contents("$localPubDirectory/privacy-policy.html", Unirep(str_replace(
		[
			"`--PrivacyPolicy-Content--`",
			"`--PrivacyPolicy-Meta--`"
		], 
		[
			$content,
			join("\n",$headElems)
		], 
		$privTemp
	),$locPat));
	file_put_contents("$livePubDirectory/privacy-policy.html", Unirep(str_replace(
		[
			"`--PrivacyPolicy-Content--`",
			"`--PrivacyPolicy-Meta--`"
		], 
		[
			$content,
			join("\n", $headElems)
		], 
		$privTemp
	),$livPat));
	
	
}

function RenderPublicBlog($binf, $dat, $locDirs, $livDirs, $uPat, $livPat, $locPat){
	// app.html.temp
	$uPat=[$uPat];
	$livPat=[$livPat];
	$locPat=[$locPat];
	
	$main=['icons'=>$binf['metaMedia']['icons']];
	$page=['icons'=>[]];
	$ics=[
		'icons'=>[
			ParseSeoIcon('appleTouchLg', 'apple-touch-icon', '180', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('appleTouchMd', 'apple-touch-icon', '152', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('appleTouchSm', 'apple-touch-icon', '120', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon16', 'icon', '16', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon32', 'icon', '32', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon57', 'icon', '57', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon76', 'icon', '76', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon96', 'icon', '96', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon120', 'icon', '120', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon128', 'icon', '128', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon144', 'icon', '144', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon152', 'icon', '152', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon167', 'icon', '167', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon180', 'icon', '180', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon192', 'icon', '192', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon195', 'icon', '195', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon196', 'icon', '196', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('icon228', 'icon', '228', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('shortcutIcon', 'shortcut icon', '196', 'link', $main['icons'], $page['icons']),
			ParseSeoIcon('msAppTile', 'msapplication-TileImage', '144', 'meta', $main['icons'], $page['icons']),
			
		],
		'msAppTileColor'=>SeoSimpleFallthrough($page['icons'], $main['icons'],'msAppTileColor'),
		'browserConfig'=>[
			'large'=>ParseSeoIcon('browserConfigMsAppLg','square150x150logo', '228', 'xml', $main['icons'], $page['icons']),
			'small'=>ParseSeoIcon('browserConfigMsAppSm','square70x70logo', '76', 'xml', $main['icons'], $page['icons']),
			'tileColor'=>SeoSimpleFallthrough($page['icons'], $main['icons'],'browserConfigMsAppTileColor')
		],
	];
	
	
	
	$blogIcons=[];
	foreach($ics['icons'] as $ic)
	{
		if($ic){
			$blogIcons[]=$ic;
		}
	}
	SeoMetaCheck($blogIcons, $ics, 'msAppTileColor', 'msapplication-TileColor');
	
	
	$otherJsLibs=[];
	
	if($binf['cookieManager']['include']){
		array_push($otherJsLibs,'`--ScriptInjection--`js_library--`softNotification--`');
		if($binf['cookieManager']['inherit']){
			$cookieManagerInheritPath=$binf['cookieManager']['inheritPath'];
			array_push($otherJsLibs, "<script src=\"$cookieManagerInheritPath/cookieManager.js\"></script><link rel=\"stylesheet\" href=\"$cookieManagerInheritPath/cookieManager.css\"/>");
		}else{
			
			array_push($otherJsLibs, "`--ScriptInjection--`js_library--`cookieManager--`");
		}
	}
	$otherJsLibs=join("\n", $otherJsLibs);
	//die(json_encode($blogIcons));
	array_push($uPat,[
		'`--BlogSlug--`'=>$binf['slug'],
		'`--Blog-AbsolutePrefix--`'=>'`--AbsolutePrefix--`/`--BlogSlug--`',
		'`--Blog-Logo--`'=>$binf['logo'],
		'`--Blog-Footer--`'=>$binf['footer'],
		'`--Blog-TopURI--`'=>'`--TopUri--`/`--BlogSlug--`',
		'`--Blog-Title--`'=>$binf['title'],
		'`--Blog-MainGlobalCSS--`'=>$binf['globalCss'],
		'`--Blog-MainGlobalJs--`'=>$binf['globalJs'] ? "<script>\n$binf[globalJs]\n</script>" : '',
		
		'`--PrivacyPolicy-Link--`'=>'<a href="`--AbsolutePrefix--`/privacy-policy.html">Privacy Policy</a>',
			
		'`--CookieManager-StorageName--`'=>$binf['cookieManager']['storageIndex'],
		'`--CookieManager-SiteCookies--`'=>$binf['cookieManager']['cookieList'],
		'`--CookieManager-LaunchButton--`'=>'<button onclick="_el.CancelEvent(event);CookieManager.Render();" class="CookieManager-LaunchButton">Open Cookie Manager</button>',
		
		'`--Blog-OtherJsLibs--`'=>$otherJsLibs,
		'`--Blog-Icons--`'=>implode("\n", array_map(function($ic){
            //echo(json_encode($ic));
			if($ic['value'] ?? ''){
				if($ic['elType'] === 'link'){
					return HTML_element('link',[
						'rel'=>$ic['name'], 
						'sizes'=>$ic['size'].'x'.$ic['size'], 
						'href'=>'`--AbsolutePrefix--`/media/icons/'.$ic['value']
					]);
				}else if($ic['elType'] === 'metaProperty'){
					return HTML_element('meta',[
						'property'=>$ic['name'],
						'content'=>'`--AbsolutePrefix--`/media/icons/'.$ic['value']
					]);
				}else if($ic['elType'] === 'meta'){
					return HTML_element('meta',[
						'name'=>$ic['name'],
						'content'=>'`--AbsolutePrefix--`/media/icons/'.$ic['value']
					]);
				}
			}else if($ic){
				// may be a mistake. 
				return '';
			}
			return '';
		},$blogIcons))
	]);
	array_push($livPat,[
		
	]);
	array_push($locPat,[
		
	]);
	
	$allMeta=[];
		//$allMeta[]=HTML_element('title',[],["`--Blog-Title--`"]);
		//$allMeta[]=HTML_element('meta',['property'=>'og:title','content'=>"`--Blog-Title--`"]);
		
		$allMeta[]=HTML_element('meta',['property'=>'og:type','content'=>'website']);
		
	$blogDescriptionText='';
	if($binf['mainDescription']){
		$blogDescriptionText==HTML_element('meta', ['name'=>'description', 'content'=>$binf['mainDescription']]);
		$blogDescriptionText=HTML_element('meta', ['property'=>'og:description', 'content'=>$binf['mainDescription']]);
	}
	foreach($binf['metaMedia']['shareImages']['list'] as $ls)
	{
		$im=$ls['image'];
		$allMeta[]=HTML_element('meta', [
			'property'=>'og:image',
			'content'=>"`--TopUri--`/media/images/$im[image]/$im[size].$im[srcType]"
		]);
		if($ls['alt']){
			$allMeta[]=HTML_element('meta',['property'=>'og:image:alt', 'content'=>$ls['alt']]);
		}
	}
	
	$allMetaLive=Unirep(join("\n",$allMeta), ...$uPat, ...$livPat);
	$allMetaLoca=Unirep(join("\n",$allMeta), ...$uPat, ...$locPat);
	$blogDescriptionTextLive=Unirep($blogDescriptionText, ...$uPat, ...$livPat);
	$blogDescriptionTextLoca=Unirep($blogDescriptionText, ...$uPat, ...$locPat);
	
	
	EnsureDirectory("$locDirs[sec]/blogs/$binf[slug]");
		file_put_contents("$locDirs[sec]/blogs/$binf[slug]/allMeta.html",$allMetaLoca);
		file_put_contents("$locDirs[sec]/blogs/$binf[slug]/blogDescription.txt",$blogDescriptionTextLoca);
	EnsureDirectory("$livDirs[sec]/blogs/$binf[slug]");
		file_put_contents("$livDirs[sec]/blogs/$binf[slug]/allMeta.html",$allMetaLive);
		file_put_contents("$livDirs[sec]/blogs/$binf[slug]/blogDescription.txt",$blogDescriptionTextLive);
		
		CrossRender("adminTemplates/blogs/publicBlog.html.temp.temp", $uPat, "$locDirs[sec]/blogs/$binf[slug]/app.html.temp", $locPat, "$livDirs[sec]/blogs/$binf[slug]/app.html.temp",$livPat);
		CrossRender("adminTemplates/blogs/publicBlogCategory.php.temp", $uPat, "$locDirs[sec]/blogs/$binf[slug]/category.php.temp", $locPat, "$livDirs[sec]/blogs/$binf[slug]/category.php.temp",$livPat);
		CrossRender("adminTemplates/blogs/publicBlogArticle.php.temp", $uPat, "$locDirs[sec]/blogs/$binf[slug]/article.php.temp", $locPat, "$livDirs[sec]/blogs/$binf[slug]/article.php.temp",$livPat);
		
	EnsureDirectory("$locDirs[pub]/$binf[slug]");
	EnsureDirectory("$livDirs[pub]/$binf[slug]");
	
	
	$livHtaccess="";
	$locHtaccess="";
	$htaccessHttps='';
	$wwwBehaviour;
	$csp='';
	if($binf['htaccess']['inherit']){
		$livHtaccess="RewriteOptions Inherit";
		$locHtaccess="RewriteOptions Inherit";
	}else{
		$htaccessHttps="";
		$csp=$binf['htaccess']['contentSecurityPolicy'];
		if($csp){
			$csp="Header add Content-Security-Policy \"$csp\"";
		}
		$wwwBehaviour=$dat['top']['main']['wwwBehaviour'];
		if($wwwBehaviour === 'force'){
			$wwwBehaviour="RewriteCond %{HTTP_HOST} !^www\. [NC]
RewriteRule ^ %{REQUEST_SCHEME}://www.%{HTTP_HOST}%{REQUEST_URI} [R,L]";
		}else if($wwwBehaviour === "prevent"){
			$wwwBehaviour="RewriteCond %{HTTP_HOST} ^www\.(.*)\$ [NC]
RewriteRule ^ %{REQUEST_SCHEME}://%1%{REQUEST_URI} [R,L]";
			
		}else{
			$wwwBehaviour='';
		}
		if($binf['htaccess']['https']){$htaccessHttps="RewriteCond %{HTTPS} off 
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI}

";
		}
		$livHtaccess="$wwwBehaviour
".basicHtaccess."
$csp";
		$locHtaccess=basicHtaccess."
$csp";
	}
	$livHtaccess="{$htaccessHttps}

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)[0-9]+/*$ $1index.php
".$livHtaccess;
	$locHtaccess="RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)[0-9]+/*$ $1index.php
".$locHtaccess;

		file_put_contents("$locDirs[pub]/$binf[slug]/.htaccess", $locHtaccess);
		file_put_contents("$livDirs[pub]/$binf[slug]/.htaccess", $livHtaccess);
		//CrossRender("adminTemplates/blogs/publicBlogCategory.php.temp", $uPat, "$locDirs[pub]/$binf[slug]/index.php", $locPat, "$livDirs[pub]/$binf[slug]/index.php",$livPat);

		
		
		CrossRender("adminTemplates/blogs/publicAll.php.temp", $uPat, "$locDirs[pub]/$binf[slug]/index.php", $locPat, "$livDirs[pub]/$binf[slug]/index.php",$livPat);
		
		
		CrossRender("adminTemplates/blogs/publicGetCategoryList.php.temp", $uPat, "$locDirs[pub]/$binf[slug]/getCategoryList.php", $locPat, "$livDirs[pub]/$binf[slug]/getCategoryList.php",$livPat);
		CrossRender("adminTemplates/blogs/publicGetArticleInfo.php.temp", $uPat, "$locDirs[pub]/$binf[slug]/getArticleInfo.php", $locPat, "$livDirs[pub]/$binf[slug]/getArticleInfo.php",$livPat);
		
	
	if($binf['categorized']){
		EnsureDirectory("$locDirs[pub]/$binf[slug]/c/");
		EnsureDirectory("$livDirs[pub]/$binf[slug]/c/");
		CrossRender("adminTemplates/blogs/publicBlogCategorySelection.php.temp", $uPat, "$locDirs[pub]/$binf[slug]/c/index.php", $locPat, "$livDirs[pub]/$binf[slug]/c/index.php",$livPat);
		
	}
	
	
	
}

?>