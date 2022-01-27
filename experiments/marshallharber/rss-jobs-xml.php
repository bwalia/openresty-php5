<?php

//error_reporting(E_ALL); ini_set('display_errors', 1);
// Turn off all error reporting
error_reporting(0);

//BSW simple cache start, note you must call include/cache_end.php at the end of the file.
require_once("include/lib.inc.php");
	
	$kLimit = isset($_GET["limit"]) ? $_GET["limit"] : "1000";
	$whereKeyword='';
	
	$iOSBool = true;
	if(isset($_GET["q"])){
		$searchKeyword = trim($_GET["q"]);
		$keyArr = explode('-',$searchKeyword);
		if(empty($_GET["o"]) == true){
			$_GET["o"]='AND';
		}
	}

	if(isset($_GET["q"]) && isset($_GET["o"]) && $_GET["o"]=='OR'){
		for($i=0;$i<count($keyArr);$i++){
			$whereKeyword.= " `Body` LIKE '%".$keyArr[$i]."%' OR ";
		}
		$whereKeyword = substr($whereKeyword,0,-3);
		$query = "Select Code, Document, Body, Published_timestamp from `documents` WHERE Status=1 AND
		`Type`='job' AND SiteID='".SITE_ID."' AND ($whereKeyword) ORDER BY `Published_timestamp` DESC limit " . 
		$kLimit;
	}
	elseif(isset($_GET["q"]) && isset($_GET["o"]) && $_GET["o"]=='AND'){
		for($i=0;$i<count($keyArr);$i++){
			$whereKeyword.= " `Body` LIKE '%".$keyArr[$i]."%' AND ";
		}
		$whereKeyword = substr($whereKeyword,0,-4);
		$query = "Select Code, Document, Body, Published_timestamp from `documents` WHERE Status=1 AND
		`Type`='job' AND SiteID='".SITE_ID."' AND ($whereKeyword) ORDER BY `Published_timestamp` DESC limit " . 
		$kLimit;
	}
	else{
		$query = "Select Code, Document, Body, Published_timestamp from `documents` WHERE Status=1 AND
		`Type`='job' AND SiteID='".SITE_ID."' ORDER BY `Published_timestamp` DESC limit " . $kLimit;
	}
	//echo $query;
	$results = $db->get_results( $query );
	$now = date("D, d M Y H:i:s T");
	
	$doc = new DOMDocument();
	$doc->formatOutput = true;
	$doc->encoding = "utf-8";
	$doc->xmlVersion = "1.0";
	
	$rs1 = $doc->createElement( "rss" );
	$rs1->setAttribute("version","2.0");
	$doc->appendChild( $rs1 );

$siteTitleStr = "Marshall Harber - Jobs by RSS Feed";

	$channel = $doc->createElement( "channel" );
	$rs1->appendChild( $channel );

	$title = $doc->createElement( "title" );
	$channel->appendChild( $title );
			
						$title->appendChild(
				$doc->createTextNode( $siteTitleStr )
			);

	$total_items = $doc->createElement( "total_items" );
	$channel->appendChild( $total_items );
			
						$total_items->appendChild(
				$doc->createTextNode( $db->num_rows )
			);

			
				$link = $doc->createElement( "link" );
	$channel->appendChild( $link );
			
						$link->appendChild(
				$doc->createTextNode( "https://www.marshallharber.com/" )
			);
			
			$lang = $doc->createElement( "language" );
	$channel->appendChild( $lang );
			
						$lang->appendChild(
				$doc->createTextNode( "en-us" )
			);

			$email = $doc->createElement( "email" );
	$channel->appendChild( $email );
			
						$email->appendChild(
				$doc->createTextNode( "info@marshallharber.com" )
			);
			
			$now = date("D, d M Y H:i:s T");
						$pubDate = $doc->createElement( "pubDate" );
	$channel->appendChild( $pubDate );
			
						$pubDate->appendChild(
				$doc->createTextNode( $now )
			);
			
									$lastBuildDate = $doc->createElement( "lastBuildDate" );
	$channel->appendChild( $lastBuildDate );
			
						$lastBuildDate->appendChild(
				$doc->createTextNode( $now )
			);

									$generator = $doc->createElement( "generator" );
	$channel->appendChild( $lastBuildDate );
			
						$lastBuildDate->appendChild(
				$doc->createTextNode( "Jobshout" )
			);
if(count($results>0)){
	foreach ($results as $result)
		{
			$now = date("D, d M Y H:i:s T", $result->Published_timestamp);

			$rs2 = $doc->createElement( "item" );
			$title = $doc->createElement("title");

$jobTitleStr = preg_replace("/\W/"," ",$result->Document);//$jobTitleStr = str_replace('&pound;', '£', htmlentities ( $result->Document) ); 
			$title->appendChild(
				$doc->createTextNode( $jobTitleStr )
			);
			$rs2->appendChild( $title);
			
			$link = $doc->createElement( "link" );
			$link->appendChild(
				$doc->createTextNode( "https://www.marshallharber.com/". $result->Code .".html" )
			);
			$rs2->appendChild( $link );

			$description = $doc->createElement( "description" );
$truncate = 300;
			
			$descriptionTxt = strip_tags($result->Body);
			$descriptionTxt = nl2br($descriptionTxt);
			$descriptionTxt = substr($descriptionTxt,0,$truncate) . "&hellip;";

			$description->appendChild(
$doc->createTextNode( $descriptionTxt )
			);
			$rs2->appendChild( $description );

			$pubDate = $doc->createElement( "pubDate" );
			$pubDate->appendChild(
				$doc->createTextNode( $now )
			);
			$rs2->appendChild( $pubDate );

			$channel->appendChild( $rs2 );
		}
}
	// save rss xml file on disk
	//$doc->save("rss.xml");
	
	// set content type to be XML, so that browsers will recognise it as xml
	header("Content-Type: application/xml; charset=utf-8");
	
	// show output in browser
	echo $doc->saveXML();
?>