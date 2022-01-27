<?php 

$uuid=isset($_GET["uuid"]) ? $_GET["uuid"] : "";
$tableNameStr= isset($_GET["table"]) ? $_GET["table"] : "";
$uniqueFieldStr= isset($_GET["key"]) ? $_GET["key"] : "";
$debugStr= isset($_GET["debug"]) ? $_GET["debug"] : "";

$debug=$debugStr==='true';

$result=array();

function f_getColType($db, $tableStr, $colStr)
{

  $queryColTypeStr="SELECT COLUMN_TYPE FROM information_schema.COLUMNS WHERE TABLE_NAME = '".$tableStr."' AND COLUMN_NAME = '".$colStr."'";
  $colType = $db->get_var($queryColTypeStr);
  return $colType;

}
function log_print($logTxt, $debugBool=false)
{
// log this to a file on disk 
if( $debugBool ) { echo $logTxt . "<br />"; }
}


if($uuid !="" && $tableNameStr!= "" && $uniqueFieldStr!=""){
	// Include ezSQL core
	include_once "include_sync/ez_sql_core.php";
	// Include ezSQL database specific component
	include_once "include_sync/ez_sql_mysql.php";
	
require_once("../../private_config/constants.php"); // defined all constants
	
	$fetchfromdb = new ezSQL_mysql(DB_USER,DB_PASSWORD,DB_NAME,DB_HOST);
 	
 	$findquery="select * from ".$tableNameStr." where ".$uniqueFieldStr."='".$uuid."'";

//$fetchfromdb->query('SET NAMES utf8');
 	
 	if($recordsFound=$fetchfromdb->get_row($findquery)){
 		foreach($recordsFound as $key=>$value){
 		
 $colTypeStr = f_getColType($fetchfromdb, $tableNameStr, $key);
/*
  if (stripos($colTypeStr, 'varchar') !== false) {
    log_print($key . ' is varchar<br />', $debug);
        $value=base64_encode($value);
  }


  if ($colTypeStr === 'text' || $colTypeStr === 'tinytext' || $colTypeStr === 'longtext') {
// echo $colTypeStr . '<br />';
        $value=base64_encode($value);
  }
*/

  if ($colTypeStr === 'blob' || $colTypeStr === 'tinyblob' || $colTypeStr === 'longblob') {
// echo $colTypeStr . '<br />';
        $value=base64_encode($value);
  }
 		
 			$result[$key]=$value;
 		}
 	}else{
 		$result['error']= "no records found";
 	}
}else{
	$result['error']= "pass table name and uuid or id";
}
echo json_encode($result);
?>