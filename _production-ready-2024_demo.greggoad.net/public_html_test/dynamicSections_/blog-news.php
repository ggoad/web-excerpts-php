<?php 
				require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/dynamicSectionDefinitions.php");
				require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/postVarSet.php");
				
				PostVarSet("ob",$ob,true);
				$ob=json_decode($ob);
				if(!$ob){$ob=[];}
				die(json_encode([
					"success"=>true,
					"data"=>$DynamicSectionFunctions['blog-news']["dataCalculator"]($ob)
				]));
				
			?>