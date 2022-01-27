<?php

$thisPage=$_SERVER['PHP_SELF'];

$timestampFromNum= isset($_GET["timestamp"]) ? $_GET["timestamp"] : "";
$tablenameStr= isset($_GET["table"]) ? $_GET["table"] : "";
$uniqueFieldStr= isset($_GET["key"]) ? $_GET["key"] : "";
$startLim= isset($_GET["start"]) ? $_GET["start"] : 1;
$endLim= isset($_GET["end"]) ? $_GET["end"] : 10;

$stopBool=false;
$syncNewRowsOnlyBool=true;


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

function log_print($logTxt)
{
echo $logTxt . "<br />";
}


//echo "In sync_changed_rows_to_local_db.php</br>";
        // Include ezSQL core                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
        include_once "include_sync/ez_sql_core.php";
        // Include ezSQL database specific component                                                                                                                                                                                                                                                                                                                                                                                                                                            
        include_once "include_sync/ez_sql_mysql.php";

require_once("../../private_config/constants.php"); // defined all constants                                                                                                                                                                                                                                                                                                                                                                                                                    
$importtodb = new ezSQL_mysql(DB_USER,DB_PASSWORD,DB_NAME,DB_HOST);

$sync_url = "http://sync2-marshallharber.tenthmatrix.co.uk/sync-mysql/sync_fetch_changed_rows.php?table=".$tablenameStr."&key=".$uniqueFieldStr."&timestamp=" . $timestampFromNum;

try {
  $content = file_get_contents($sync_url);

  if ($content === false) {
    echo "Handle the error</br></br>";


  } else {
#    echo $content;                                                                                                                                                                                                                                                                                                                                                                                                                                                                             

    $uuid_str_arr=json_decode($content);

    foreach($uuid_str_arr as $uuid_str){

         //this is the code for insert and update                                                                                                                                                                                                                                                                                                                                                                                                                                               

         $checkExistence="SELECT * FROM `".$tablenameStr."` WHERE `".$uniqueFieldStr."`='".$uuid_str."'";

//echo $checkExistence . "</br>";                                                                                                                                                                                                                                                                                                                                                                                                                                                               

$sync_url = "http://sync2-marshallharber.tenthmatrix.co.uk/sync-mysql/sync_fetch_row.php?table=".$tablenameStr."&key=".$uniqueFieldStr."&uuid=" . $uuid_str;
log_print("sync fetch row url " . $sync_url);                                                                                                                                                                                                                                                                                                                                                                                                                                               

/**/
try {
  $content = file_get_contents($sync_url);

  if ($content === false) {
    echo "Handle the error</br></br>";

  } else {

    //   echo $content;                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
$fetchedRow = json_decode($content);
//print_r($fetchedRow);                                                                                                                                                                                                                                                                                                                                                                                                                                                                         


if($importtodb->get_row($checkExistence)){
  //update in importtodb                                                                                                                                                                                                                                                                                                                                                                                                                                                                        

//  echo "updateQry" . "</br>";                                                                                                                                                                                                                                                                                                                                                                                                                                                                 

if($syncNewRowsOnlyBool===false){

  $queryStr="";
  foreach($fetchedRow as $key=>$value){

 $colTypeStr = f_getColType($importtodb, $tablenameStr, $key);

  if ($colTypeStr === 'text' || $colTypeStr === 'tinytext' || $colTypeStr === 'longtext') {
        $value=f_escapeColData($value);
  }

  if (strpos($colTypeStr, 'int') !== false) {
    echo $key . " type is " . $colTypeStr;
    $value=f_fixNumColData($value);
  }

  if (strpos($colTypeStr, 'varchar') !== false) {
    echo  $colStr . ' is varchar<br />';
    $escapeCharsBool=true;
  }

 if($key=="short_url"){
      echo "short_url before: " . $value;
      $value = isset($value) ? $value : uniqid();
      if($value===''){$value=uniqid();}
      echo "short_url after: " . $value;
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

  $updateQry="UPDATE ".$tablenameStr." SET ".$queryStr." WHERE  ".$uniqueFieldStr."='".$fetchedRow->$uniqueFieldStr."'";

   echo $updateQry;                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
  if( $importtodb->query($updateQry) )
    {
      echo $updateQry . " OK";
    } else {
    echo $updateQry . " : ";
    $importtodb->debug();
  }
  
}


}else{

  //insert in importtodb                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
echo "insertQry" . "</br>";

  $keyStr="";
  $valueStr="";

  foreach($fetchedRow as $key=>$value){

 $colTypeStr = f_getColType($importtodb, $tablenameStr, $key);

    if($keyStr!=""){
      $keyStr.=", ".$key;
    }else{
      $keyStr.=$key;
    }

  if ($colTypeStr === 'text' || $colTypeStr === 'tinytext' || $colTypeStr === 'longtext') {
        $value=f_escapeColData($value);
  }

  if (strpos($colTypeStr, 'int') !== false) {
    echo $key . " type is " . $colTypeStr;
    $value=f_fixNumColData($value);
  }

  if (strpos($colTypeStr, 'varchar') !== false) {
    echo  $colStr . ' is varchar<br />';
    $escapeCharsBool=true;
  }

 if($key=="short_url"){
      echo "short_url before: " . $value;
      $value = isset($value) ? $value : uniqid();
      if($value===''){$value=uniqid();}
      echo "short_url after: " . $value;
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


#  $insertQry="INSERT INTO ".$tablenameStr." (".$keyStr.")  VALUES (".$valueStr.")";                                                                                                                                                                                                                                                                                                                                                                                                            
  $insertQry="INSERT INTO ".$tablenameStr." (".$keyStr.")  VALUES (".$valueStr.")";

#  echo $insertQry. "</br></br></br></br></br>";                                                                                                                                                                                                                                                                                                                                                                                                                                                
  if( $importtodb->query($insertQry) )
    {
      echo $insertQry . " OK";
    } else {
    echo $insertQry . " : ";
    $importtodb->debug();
  }
  
}


if($stopBool){    exit;}

  }
}
catch (Exception $e) {
  echo "Handle exception</br></br>";
  }


    }

  }

} catch (Exception $e) {
  echo "Handle exception</br></br>";
  }










?>