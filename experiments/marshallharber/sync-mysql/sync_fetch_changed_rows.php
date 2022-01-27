<?php 

include_once("include_sync/sync_config.php");

$startTimestampFromNum=isset($_GET["start_timestamp"]) ? $_GET["start_timestamp"] : 0;
$endTimestampFromNum= isset($_GET["end_timestamp"]) ? $_GET["end_timestamp"] : 0;

if($startTimestampFromNum>0 && $endTimestampFromNum==0){
	$endTimestampFromNum=$startTimestampFromNum+86400;
}

$tablenameStr= isset($_GET["table"]) ? $_GET["table"] : "";
$uniqueFieldStr= isset($_GET["key"]) ? $_GET["key"] : "";
$startLim= isset($_GET["start"]) ? $_GET["start"] : 0;
$endLim= isset($_GET["end"]) ? $_GET["end"] : 99999;
$result=array();

if($startTimestampFromNum>0 && $endTimestampFromNum>0 && $tablenameStr!="" && $uniqueFieldStr!=""){
	// Include ezSQL core
	include_once "include_sync/ez_sql_core.php";
	// Include ezSQL database specific component
	include_once "include_sync/ez_sql_mysql.php";

require_once("../../private_config/constants.php"); // defined all constants
	
	$fetchfromdb = new ezSQL_mysql(DB_USER,DB_PASSWORD,DB_NAME,DB_HOST);
 	//$importtodb = new ezSQL_mysql($db_user,$db_pass,$db_name,"hh4.tenthmatrix.co.uk");	
 
 	$findquery="SELECT * FROM `".$tablenameStr."` WHERE `Modified`<" . $endTimestampFromNum . " AND `Modified`>" . $startTimestampFromNum . " ORDER BY `Modified`" . " DESC LIMIT " . $startLim . ", " . $endLim;
 	//$findquery .= " Limit $startLim,$endLim ";
 	//echo $findquery;
 	
 	$recordsFound=$fetchfromdb->get_results($findquery);
 	if(count($recordsFound)>0){
 		foreach($recordsFound as $fetchedRow){
 			$result[]= $fetchedRow->$uniqueFieldStr;
 			
 			/**		
 			//this is the code for insert and update
 				
 			$checkExistence="select * from ".$tablenameStr." where GUID=".$fetchedRow->GUID;
 			if($importtodb->get_row(checkExistence)){
 				//update in importtodb
 				$queryStr="";
 				foreach($fetchedRow as $key=>$value){
 					if($queryStr!=""){
 						$queryStr.=", ".$key."= '".$value."'";
 					}else{
 						$queryStr.=$key."= '".$value."'";
 					}
 				}
 				$updateQry="UPDATE ".$tablenameStr." SET ".$queryStr." WHERE  ".$uniqueFieldStr."='".$fetchedRow->$uniqueFieldStr."'";
 				$importtodb->query($updateQry);
 			}else{
 				//insert in importtodb
 				$keyStr="";
 				$valueStr="";
 				foreach($fetchedRow as $key=>$value){
 					if($keyStr!=""){
 						$keyStr.=", ".$key;
 					}else{
 						$keyStr.=$key;
 					}
 					if($valueStr!=""){
 						$valueStr.=", '".$value."'";
 					}else{
 						$valueStr.="'".$value."'";
 					}
 				}
 				$insertQry="INSERT INTO documents (".$keyStr.")  VALUES (".$valueStr.")";
				$importtodb->query($insertQry);
 			}
 			**/
 		}
 	}else{
 		$result['error']= "no records found";
 	}
}else{
	$result['error']= "pass table name and timestamp";
}
echo json_encode($result);
?>