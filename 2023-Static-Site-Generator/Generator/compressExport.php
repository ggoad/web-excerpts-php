<?php 

	define('POSTVARSET_OBREPLY', true);
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");

	require_once('projectLibrary.php');
	//require_once("$_SERVER[DOCUMENT_ROOT]/php_core/minify.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../php_core/goodMinifier3/minify.php"); 
	use Framework\Minify\Minify;
	$minifier=new Minify();
	
	function BROTLI_file($source){
	   exec("C:/xampp/brotli/out/installed/bin/brotli.exe $source -f --output=$source.br");
	}

	function BROTLI_directory($dir, $adminD=''){
		$sd=scandir($dir);
		
		foreach($sd as $s)
		{
			if(is_file("$dir/$s") && array_search($s, ['.htaccess'])=== false && !preg_match('#(\.br|\.php|\.php\.min)$#',$s)){
				//echo("$dir/$s");
				BROTLI_file("$dir/$s");
			}else if(is_dir("$dir/$s") && array_search($s, ['..','.']) === false){
				if(!($adminD && preg_match('#'.$adminD.'$#',"$dir/$s"))){
					BROTLI_directory("$dir/$s");
				}
			}
		}
	}
	function MinifyDirectory($d, $adminD=''){
		global $minifier;
		$sd=scandir($d);
		foreach($sd as $s)
		{
			$matches=[];
			if(is_file("$d/$s") && preg_match('#\.(html|js|css|php)$#',$s,$matches)){
				
				//die('ninl '.json_encode($matches));
				$m=$matches[0];

				if($m === '.js'){
					//file_put_contents("$d/$s.min", minify_js(file_get_contents("$d/$s")));
					file_put_contents("$d/$s.min", $minifier->js(file_get_contents("$d/$s")));
				}else if($m === '.css'){
					//file_put_contents("$d/$s.min", minify_css(file_get_contents("$d/$s")));
					file_put_contents("$d/$s.min", $minifier->css(file_get_contents("$d/$s")));
				}else if($m === '.html'){
					//file_put_contents("$d/$s.min", minify_html(file_get_contents("$d/$s")));
					file_put_contents("$d/$s.min", $minifier->all(file_get_contents("$d/$s")));
				}else if($m === '.php'){
					//file_put_contents("$d/$s.min", minify_php(file_get_contents("$d/$s")));
					$str=$minifier->php(file_get_contents("$d/$s"));
					file_put_contents("$d/$s", $str);
				}
			}else if(is_dir("$d/$s") && array_search($s, ['.','..']) === false){
				//echo "$d/$s<br>$adminD<br><br>";
				if(!($adminD && preg_match('#'.$adminD.'$#',"$d/$s"))){
					//echo "IN<br><br>";
					MinifyDirectory("$d/$s",$adminD);
				}
			}
		}
	}

	PostVarSet('title', $title);
	
	$projectInfo=GetProjectInfo($title);
	$dat=$projectInfo['data'];


	$localDirectory=CalcLocalDirectory($projectInfo['slug']);
		$localPubDirectory="$localDirectory";
	$liveDirectory=CalcLiveDirectory($projectInfo['slug']);
		$livePubDirectory="$liveDirectory/".$dat['top']['main']['livePubFolder'];

	MinifyDirectory($localPubDirectory);
	MinifyDirectory($livePubDirectory, $dat['top']['admin']['config']['targetDirectory'] ?? '');

	BROTLI_directory($localPubDirectory);
	BROTLI_directory($livePubDirectory,$dat['top']['admin']['config']['targetDirectory'] ?? '');
	
	die(json_encode(['success'=>true]));

?>