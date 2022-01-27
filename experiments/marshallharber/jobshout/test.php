<?php
require_once("include/lib.inc.php");
//ini_set('file_uploads', 1); 
?>
<form enctype="multipart/form-data" action="" method="post"> 
    Choose file: 
<input name="testfile" type="file"></br> 
<input type="submit" value="UPLOAD"> 
</form> 
<?php 

    if (is_uploaded_file($_FILES['testfile']['tmp_name'])) { 
      print_r($_FILES);      
// move_uploaded_file($_FILES['testfile']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $_FILES['testfile']['name']); 
      //echo $_FILES['testfile']['name']." uploaded successfully!";
    } else{
      echo "failed";
    }

?>
<?php 
exit;
// Include ezSQL core
	include_once "ez_sql_core.php";
	// Include ezSQL database specific component
	include_once "ez_sql_mysql.php";
$db_user="marshalluser";
	$db_host='mysql.jobshout.co.uk';
	$db_name='jobshout_live_marshallharber';
	$db_pass='!ChBi2K1ngS';
	
	
	$dictionary_db_user="jobshout_admin";
	$dictionary_db_name='dictionary';
	
	
	
 echo $dictionary_db_user.",".$db_pass.",".$dictionary_db_name.",".$db_host;
$dbdictionary = new ezSQL_mysql($dictionary_db_user,$db_pass,$dictionary_db_name,$db_host);
echo "<br/>select word from 'words' ";
$dic_result= $dbdictionary->get_results("SELECT * FROM `words` limit 10");
echo $dic_result.'---------';
$dbdictionary->debug();
exit;


?>