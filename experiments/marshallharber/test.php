<?php

  //phpinfo();
exit;

session_start();
require_once("include/lib.inc.php");

$monitoringBool=true;
$returnJsonArr=array();
$returnJsonArr['session_path']=session_save_path();

if (!is_writable(session_save_path())) {
  $monitoringBool=false;
  $returnJsonArr['session_path_writable']='no';
}else {
  $returnJsonArr['session_path_writable']='yes';
}


echo json_encode($returnJsonArr);
exit;
?>
<?php require_once("include/lib.inc.php"); ?>

<?php 
echo SITE_PATH.'--';
echo $_SERVER['SERVER_NAME'];
exit;

function create_code($str)
{
$str=str_replace("+"," ",$str);
$str=str_replace("-"," ",$str);
$str=str_replace("("," ",$str);
$str=str_replace(")"," ",$str);
$str=str_replace(" /","/",$str);
$str=str_replace("/ ","/",$str);
$str=preg_replace("/\s+/"," ",$str);
$str=trim($str);
$str=str_replace(" ","-",$str);
$str=strtolower($str);
return $str;
}

$sql_cats= $db->get_results("select GUID, Code from categories where SiteID='".SITE_ID."'");
foreach($sql_cats as $cat){
	$code= create_code($cat->Code);
	$db->query("update categories set Code= '".$code."' where SiteID='".SITE_ID."' and GUID='".$cat->GUID."'");
}

?>
