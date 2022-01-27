<?php 
include_once("include_sync/sync_config.php");

$tableNameStr= isset($_GET["table"]) ? $_GET["table"] : "";
$fetchColumns= isset($_GET["columns"]) ? $_GET["columns"] : "";

$debug = false;

$result=array();
if($tableNameStr!=""){

// Include ezSQL core
include_once "include_sync/ez_sql_core.php";
// Include ezSQL database specific component
include_once "include_sync/ez_sql_mysql.php";
	
require_once("../../private_config/constants.php"); // defined all constants
	
$fetchfromdb = new ezSQL_mysql(DB_USER,DB_PASSWORD,DB_NAME,DB_HOST);

if($fetchColumns=="pri"){
	$queryColNameStr='show columns from '.$tableNameStr.' where `Key` = "PRI"';
}else	{
	$queryColNameStr="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_NAME = '".$tableNameStr."' AND TABLE_SCHEMA = '".DB_NAME."'";
}
$fetchAllColumns=$fetchfromdb->get_results($queryColNameStr);
	if(count($fetchAllColumns)>0){
		foreach($fetchAllColumns as $row) {	
			if($fetchColumns=="pri"){
				$result[]=$row->Field;
			}else{
				$result[]=$row->COLUMN_NAME;
			}
		}
	}else{
		$result['error']="No columns in ".$tableNameStr." table";
	}
}else{
	$result['error']="Pass table name";
}
echo json_encode($result);


?>