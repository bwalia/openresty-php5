<?php
session_start();
require_once("../private_config/constants.php"); // defined all constants
include_once "include/ez_sql_core.php";
include_once "include/ez_sql_mysql.php";
$db = new ezSQL_mysql(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);

$monitoringBool=false;
$returnJsonArr=array(); $warningMsg='';

function bytesConvertor($Bytes){
  $Type=array("", "K", "M", "G", "T", "P", "E", "Z", "Y");
  $Index=0;
  while($Bytes>=1024)
    {
      $Bytes/=1024;
      $Index++;
    }
  $Bytes= round($Bytes, 2);
  return("".$Bytes." ".$Type[$Index]."B");
}

$returnJsonArr['session_path']=session_save_path();
if (!is_writable(session_save_path())) {
  $monitoringBool=true;
  $returnJsonArr['session_path_writable']='no';
}else {
  $returnJsonArr['session_path_writable']='yes';
}

try {
  if($checkDBConn = $db->get_var("select count(*) from documents")){
    $returnJsonArr['database']='OK';
  }else{
    $returnJsonArr['database']='Failed';
    $monitoringBool=true;
  }
}
catch (customException $e) {
  $returnJsonArr['database']='Failed';
  $monitoringBool=true;
}

$totalSpace=disk_total_space("/");
$freeSpace=disk_free_space("/");

$returnJsonArr['total_space'] = bytesConvertor($totalSpace);
$returnJsonArr['free_space'] = bytesConvertor($freeSpace);

if($freeSpace<=2000000000){ //check if space is less than equal to 1GB
  $warningMsg = "Only ".bytesConvertor($freeSpace)." memory is left<br>";
  $monitoringBool=true;
}

$returnJsonArr['memory_get_usage'] = bytesConvertor(memory_get_usage(true));

function get_server_cpu_usage(){
  $load = sys_getloadavg();
  $loadStr= round($load[0], 2);
  return $loadStr;
}

$returnJsonArr['server_cpu_usage'] = get_server_cpu_usage()."%";
if(get_server_cpu_usage()>=90){
  $warningMsg = "CPU utilisation ".get_server_cpu_usage()."%<br>";
  $monitoringBool=true;
}
if($monitoringBool){
  require_once('include/class.phpmailer.php');
  require_once("include/mailer-details.php");
  $email="nehak189@gmail.com";
  
  try {
    $mail->Subject = "Monitoring Result of MH";
    $mail->AddAddress($email);
    $mail->AddCC('neha.kapoor@tenthmatrix.co.uk');
    $mail->SetFrom("bwalia@tenthmatrix.co.uk","Marshall Harber");
    $mail_body ='';
    if($warningMsg){
      $mail_body .= "<b>Warning:</b>".$warningMsg;
    }
    $mail_body .= json_encode($returnJsonArr);
    $mail->MsgHTML($mail_body);
    
    if($mail->Send()) {
      echo "Message sent!";
    } else {
      echo "Mailer Error: " . $mail->ErrorInfo;
    }
  }
  catch (phpmailerException $e) {
    $error= $e->errorMessage(); 
    echo "Mailer Error: " . $mail->ErrorInfo;
  }
  catch (Exception $e) {
    $error= $e->getMessage(); 
    echo "Mailer Error: " . $mail->ErrorInfo;
  }
}else {
  echo json_encode($returnJsonArr);
}
exit;

?>