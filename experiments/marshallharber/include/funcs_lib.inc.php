<?php

function __dataFormatString($pInput)
{
$pOutput = $pInput;
$pOutput = str_replace('¬','',$pOutput);
$pOutput = str_replace('£','&pound;',$pOutput);
return $pOutput;
}



function __token_getValue($pDB, $pTokenCodeStr)
{
	$pTokenValueStr = "";

	$pDB->query('SET NAMES utf8');
	$pToken = $pDB->get_row("select TokenText from tokens WHERE Code='".$pTokenCodeStr."' AND zStatus = 1 AND SiteID='3320'");

	if($pToken){
		if($pToken->TokenText != ""){
			$pTokenValueStr = stripcslashes($pToken->TokenText);
		}
	}
return $pTokenValueStr;
}

 function limit_words($string, $word_limit){
        $words = explode(" ",$string);
        if(count($words)>$word_limit){
           return implode(" ",array_splice($words,0,$word_limit)).' &hellip;';
        }else{
           return $string;
        }
    }
?>