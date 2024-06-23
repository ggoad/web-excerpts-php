<?php 
			$DynamicSectionFunctions=['blog-news'=>['dataCalculator'=>function($a=""){
				require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/sqliteSupplement.php");
				$sqlite=SQLite3_Concurrent("$_SERVER[DOCUMENT_ROOT]/../-redacted-/blogs/news/db.db");
				$res=$sqlite->query("SELECT title,slug FROM articles WHERE published=1 ORDER BY IFNULL(sortDate, timePublished) DESC LIMIT 6");
				$ret=[];
				while($row=$res->fetchArray(SQLITE3_ASSOC))
				{
					$ret[]=$row;
				}
				return ["articles"=>$ret];
			},'argumentCalculator'=>function($a=""){return [];}]];
		?>