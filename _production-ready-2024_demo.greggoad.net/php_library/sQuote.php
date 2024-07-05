<?php
	function sQuote($str){
		return "'".sQuoteEscape($str)."'";
	}
	function sQuoteEscape($str){
		return str_replace("'","\\'", str_replace("\\", "\\\\",$str));
	}
?>