<?php 
include_once("include_sync/sync_config.php");

$tablesNameStr= isset($_GET["tables"]) ? $_GET["tables"] : "";
$debug = false;

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

		foreach($tablesNameArr as $tableNameStr){
			$columnsArr=array();
			$queryColNameStr="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_NAME = '".$tableNameStr."' AND TABLE_SCHEMA = '".DB_NAME."'";
			$fetchAllColumns=$fetchfromdb->get_results($queryColNameStr);
			if(count($fetchAllColumns)>0){
				foreach($fetchAllColumns as $row) {	
					$columnsArr[]=$row->COLUMN_NAME;
				}	
			}
			$result[$tableNameStr]=$columnsArr;
		}
	}else{
		$result['error']="Please pass table(s)";
	}
}else{
	$result['error']="Please select table(s)";
}
echo json_encode($result);


?>