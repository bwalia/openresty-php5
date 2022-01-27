<?php 

if(true)
  {
//session_start();
require_once("include/lib.inc.php"); 

function send_mail($msg, $pMail) {
	
echo $msg; 

}

$current_date=date("Y-m-d");
$old_date= date('Y-m-d', strtotime("now -7 days") );
$old_date=strtotime($old_date);

$debug=false;
$pretend=false;
$pMail_send=false;
$message='<div style="font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:13;color:#333">Auto Expire Old CVs.</div>';

    $querySql='DELETE FROM jobapplications WHERE Created < ' . $old_date;
    $debug=true;                                                                                                                                                                                                                                                     
    if($pretend)
      {
       	echo $querySql;
	$delete_cvs=true;
      } else {
      $delete_cvs=$db->query($querySql);
      if($debug)
      {
         $db->debug();
      }
  
      $querySql='DELETE FROM jobbriefs WHERE Created < ' . $old_date;
      echo "<br>".$querySql."<br><br>";

      $delete_job_briefs=$db->query($querySql);
      if($debug)
      {
       	$db->debug();
      }

      $querySql='DELETE FROM web_enquiries WHERE Created < ' . $old_date;
      echo "<br>".$querySql."<br><br>";

      $delete_web_enquiries=$db->query($querySql);
      if($debug)
      {
       	$db->debug();
      }
    }

    if(isset ($delete_cvs)){
      echo "<br>success<br>";
    }else{
      echo "error<br>";
    }
    if($pMail_send){
      send_mail($message, $mail);
    }

  } echo "disabled";
?>