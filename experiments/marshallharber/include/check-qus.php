<?php
session_start();

$res=array();
/**if(isset($_POST['answer'])){
  $res['post_val']=$_POST['answer'];
}
if(isset($_SESSION['answer'])){
$res['session_val']=$_SESSION['answer'];
}**/
if ($_SESSION['answer'] == $_POST['answer'] ) {
	$res['success']= "Correct";
	$_SESSION['correct']=true;
}
/**else if(isset($_COOKIE['answer']) && ($_COOKIE['answer'] == $_POST['answer'])) {
  $res['success']= "Correct";
  $_SESSION['correct']=true;
  }**/
else{
	$res['error']= "Incorrect answer. Please try again!!!";
	$_SESSION['correct']=false;
}
echo json_encode($res);
?>
