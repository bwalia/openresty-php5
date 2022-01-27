<?php 
include_once("include_sync/sync_config.php");

$uuid= isset($_GET["uuid"]) ? $_GET["uuid"] : "";
$tableNameStr= isset($_GET["table"]) ? $_GET["table"] : "";
$uniqueFieldStr= isset($_GET["key"]) ? $_GET["key"] : "";
$remote_host= isset($_GET["remote_host"]) ? $_GET["remote_host"] : "http://www2.marshallharber.com";
//echo $remote_host;
$debugStr= isset($_GET["debug"]) ? $_GET["debug"] : "";

$debug=$debugStr==='true';

$result=array();

$stopBool=false;
$syncNewRowsOnlyBool=false;

function f_getColType($db, $tableStr, $colStr)
{

  $queryColTypeStr="SELECT COLUMN_TYPE FROM information_schema.COLUMNS WHERE TABLE_NAME = '".$tableStr."' AND COLUMN_NAME = '".$colStr."'";
  $colType = $db->get_var($queryColTypeStr);
  return $colType;

}


function f_escapeColData($valueStr)
{
if(($valueStr==='') || (!isset($valueStr)))
{
return '';
} else {
return mysql_real_escape_string($valueStr);
}
}

function f_fixNumColData($valueNum)
{
      if(!isset($valueNum)) { $valueNum=0; }
      return $valueNum;
}

function log_print($logTxt, $debugBool=false)
{
// log this to a file on disk 
if( $debugBool ) { echo $logTxt . "<br />"; }
}


if($uuid !="" && $tableNameStr!= "" && $uniqueFieldStr!=""){

//echo "In sync_changed_rows_to_local_db.php</br>";
        // Include ezSQL core                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
        include_once "include_sync/ez_sql_core.php";
        // Include ezSQL database specific component                                                                                                                                                                                                                                                                                                                                                                                                                                            
        include_once "include_sync/ez_sql_mysql.php";

require_once("../../private_config/constants.php"); // defined all constants                                                                                                                                                                                                                                                                                                                                                                                                                    
$importtodb = new ezSQL_mysql(DB_USER,DB_PASSWORD,DB_NAME,DB_HOST);

$sync_url = $remote_host . "/sync-mysql/sync_fetch_row.php?table=".$tableNameStr."&key=".$uniqueFieldStr."&uuid=" . $uuid;
log_print("sync fetch row url <a target='_blank' href='" . $sync_url . "' >".$sync_url."</a>", $debug);

/**/
try {
  $content = file_get_contents($sync_url);

  if ($content === false) {
    $result['error']= "Handle the error";

  } else {

//log_print($content);                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
$fetchedRow = json_decode($content);
//print_r($fetchedRow);                                                                                                                                                                                                                                                                                                                                                                                                                                                                         

$checkExistence="SELECT * FROM `".$tableNameStr."` WHERE `".$uniqueFieldStr."`='".$uuid."'";
//echo $checkExistence;

if($importtodb->get_row($checkExistence)){
  //update in importtodb                                                                                                                                                                                                                                                                                                                                                                                                                                                                        

//  log_print("updateQry" . "</br>");                                                                                                                                                                                                                                                                                                                                                                                                                                                                 

if($syncNewRowsOnlyBool===false){

  $queryStr="";
foreach($fetchedRow as $key=>$value){

 $colTypeStr = f_getColType($importtodb, $tableNameStr, $key);


  if ($colTypeStr === 'blob' || $colTypeStr === 'tinyblob' || $colTypeStr === 'longblob') {
        $value=base64_decode($value);
        $value=addslashes($value);
}

  if ($colTypeStr === 'text' || $colTypeStr === 'tinytext' || $colTypeStr === 'longtext') {
        $value=f_escapeColData($value);
  }

  if (stripos($colTypeStr, 'int') !== false) {
    log_print($key . " type is " . $colTypeStr, $debug);
    $value=f_fixNumColData($value);
  }

  if (stripos($colTypeStr, 'varchar') !== false) {
    log_print($key . ' is varchar<br />', $debug);
        $value=f_escapeColData($value);
  }

 if($key=="short_url"){
      log_print("short_url before: " . $value, $debug);
      $value = isset($value) ? $value : uniqid();
      if($value===''){$value=uniqid();}
      log_print("short_url after: " . $value, $debug);
    }

    if(is_numeric($value)){

      if($queryStr!=""){
        $queryStr.=", ".$key."=".$value;
      }else{
        $queryStr.=$key."= ".$value;
      }

    } else {

      if($queryStr!=""){
        $queryStr.=", ".$key."= '".$value."'";
      }else{
        $queryStr.=$key."= '".$value."'";
      }

    }

  }

  $updateQry="UPDATE ".$tableNameStr." SET ".$queryStr." WHERE  ".$uniqueFieldStr."='".$fetchedRow->$uniqueFieldStr."'";
	//$result['query']= $updateQry;
//log_print($updateQry);      
                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
  if( $importtodb->query($updateQry) )
    {
    $result['response']= "Update query OK";
    log_print($updateQry . " OK", $debug);
    } else {
 
$debugTxt='';
ob_start();
$importtodb->debug();
$debugTxt = ob_get_contents();
ob_end_clean();   
   
    $result['debug']= $debugTxt;

    $result['response']= "Update query OK - There is no change detected.";
     
    //log_print($updateQry . " : ERR", $debug);
  }
}


}else{

  //insert in importtodb                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
log_print("insertQry" . "</br>", $debug);

  $keyStr="";
  $valueStr="";

  foreach($fetchedRow as $key=>$value){

 $colTypeStr = f_getColType($importtodb, $tableNameStr, $key);

    if($keyStr!=""){
      $keyStr.=", ".$key;
    }else{
      $keyStr.=$key;
    }

  if ($colTypeStr === 'blob' || $colTypeStr === 'tinyblob' || $colTypeStr === 'longblob') {
        $value=base64_decode($value);
        $value=addslashes($value);
}

  if ($colTypeStr === 'text' || $colTypeStr === 'tinytext' || $colTypeStr === 'longtext') {
        $value=f_escapeColData($value);
  }

  if (stripos($colTypeStr, 'int') !== false) {
    log_print($key . " type is " . $colTypeStr, $debug);
    $value=f_fixNumColData($value);
  }

  if (stripos($colTypeStr, 'varchar') !== false) {
    log_print($key . ' is varchar<br />', $debug);
        $value=f_escapeColData($value);
  }

 if($key=="short_url"){
      log_print("short_url before: " . $value, $debug);
      $value = isset($value) ? $value : uniqid();
      if($value===''){$value=uniqid();}
      log_print("short_url after: " . $value, $debug);
    }

    if(is_numeric($value)){

      if($valueStr!=""){
        $valueStr.=", ".(string)$value;
      }else{
        $valueStr.=(string)$value;
      }

    } else {

    if($valueStr!=""){
      $valueStr.=", '".$value."'";
    }else{
      $valueStr.="'".$value."'";
    }

    }

  }


#  $insertQry="INSERT INTO ".$tableNameStr." (".$keyStr.")  VALUES (".$valueStr.")";                                                                                                                                                                                                                                                                                                                                                                                                            
  $insertQry="INSERT INTO ".$tableNameStr." (".$keyStr.")  VALUES (".$valueStr.")";

#  log_print($insertQry. "</br></br></br></br></br>");                                                                                                                                                                                                                                                                                                                                                                                                                                                
  if( $importtodb->query($insertQry) )
    {
    $result['response']= "Insert query OK";
     log_print($insertQry . " OK", $debug);
    } else {
    $result['response']= "Insert query ERR";
    log_print($insertQry . " : DEBUG", $debug);
    if($debug) { $importtodb->debug(); }
  }
  
}


if($stopBool){    exit;}

  }
}
catch (Exception $e) {
  $result['error']="Handle exception";
  }




 	

}else{
	$result['error']="pass tablename";
}


echo json_encode($result);


?>