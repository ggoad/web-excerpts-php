<?php 
function LessifyFile($globalLess,&$LessParser, $DD, $file){
	$DD->loadHTMLFile($file,LIBXML_NOERROR);
	$styles=$DD->getElementsByTagName('style');
	//EnsureDirectory("TEMPLESS");
	//echo (string)count($styles);
	
	foreach($styles as $s)
	{
		//echo "yo dude!";
		$LessParser->Reset();
		$LessParser->parse($globalLess);
		$LessParser->parse(($s->textContent));
		//die(json_encode($LessParser));
		//die(json_encode($LessParser->getParsedFiles()));
		
		$s->textContent=$LessParser->getCss();
		
	}
	$DD->saveHTMLFile($file);
	
}

function LessifyText($globalLess, &$LessParser,$str){
	$LessParser->Reset();
	$LessParser->parse($globalLess);
	$LessParser->parse($str);
	return $LessParser->getCss();
}
function LessifyCssFile($globalLess,&$LessParser, $file){
	$LessParser->Reset();
	$LessParser->parse($globalLess);
	$LessParser->parse(file_get_contents($file));
	return file_put_contents($file,$LessParser->getCss());
}
?>