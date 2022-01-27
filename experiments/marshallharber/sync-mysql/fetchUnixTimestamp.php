<?php 
include_once("include_sync/sync_config.php");

$tablesNameStr=isset($_GET["tables"]) ? $_GET["tables"] : "";
$fetchStr=isset($_GET["fetch"]) ? $_GET["fetch"] : "end";
$remote_host_str=isset($_GET["remote_host"]) ? $_GET["remote_host"] : "";

if($remote_host_str!="")
{

$sync_url = $remote_host_str . "/sync-mysql/fetchUnixTimestamp.php?tables=" . $tablesNameStr . "&fetch=" . $fetchStr;
$content = file_get_contents($sync_url);
echo $content;

} else {

$debug = false;
$dateStr="";
$timestamp="";
$result=array();
if($tablesNameStr!=""){
	$tablesNameArr= explode(",",$tablesNameStr);
	if(count($tablesNameArr)>0){
	
		// Include ezSQL core
		include_once "include_sync/ez_sql_core.php";
		// Include ezSQL database specific component
		include_once "include_sync/ez_sql_mysql.php";
	
		require_once("../../private_config/constants.php"); // defined all constants
	
		$fetchfromdb = new ezSQL_mysql(DB_USER,DB_PASSWORD,DB_NAME,DB_HOST);
		
		$getAllTimeStamps=array();
		foreach($tablesNameArr as $tableNameStr){
			$queryStr="Select ID, Modified from ".$tableNameStr." ORDER BY `Modified` ";
			if($fetchStr=="end"){
				$queryStr.=" DESC ";
			}
			$queryStr.="limit 1";
			if($fetchColumnValues=$fetchfromdb->get_row($queryStr))	{
				if($debug){	$fetchfromdb->debug();	}
				$getAllTimeStamps[]=$fetchColumnValues->Modified;
			}
		}
		if(count($getAllTimeStamps)>0)	{
			if($debug){	print_r($getAllTimeStamps);	}
			if($fetchStr=="end"){
				$timestamp=max($getAllTimeStamps);
				$dateStr= date('m/d/Y', $timestamp);
			}else{
				$timestamp=min($getAllTimeStamps);
				$dateStr= date('m/d/Y', $timestamp);
			}
		}
		$result['date']=$dateStr;
		$result['timestamp']=$timestamp;
	}else{
		$result['error']="Please pass table(s)";
	}
}else{
	$result['error']="Please select table(s)";
}
echo json_encode($result);


}

?>