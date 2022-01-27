<?php 

$uuid=isset($_GET["uuid"]) ? $_GET["uuid"] : "";

include_once("include_sync/sync_config.php");

// Include ezSQL core
include_once "include_sync/ez_sql_core.php";
// Include ezSQL database specific component
include_once "include_sync/ez_sql_mysql.php";
	
require_once("../../private_config/constants.php"); // defined all constants
	
$db = new ezSQL_mysql(DB_USER,DB_PASSWORD,DB_NAME,DB_HOST);
 	$findquery="select * from documents where GUID='".$uuid."'";
$db->query('SET NAMES utf8');

 	if($recordsFound=$db->get_row($findquery)){
 	echo $recordsFound->FFAlpha80_1 . "<br />";
 	echo $recordsFound->FFAlpha80_2 . "<br />";
 	echo $recordsFound->FFAlpha80_3 . "<br />";
 	echo $recordsFound->FFAlpha80_4 . "<br />";
 	
 	} else {
 	echo 'Row not found';
 	}

?>