<?php
$source_host_str= isset($_GET["source_host"]) ? $_GET["source_host"] : "www1.marshallharber.com";
//header('Access-Control-Allow-Origin: http://www.marshallharber.com', false);
header('Access-Control-Allow-Origin: http://' . $source_host_str, false);
//header('Access-Control-Allow-Origin: *.marshallharber.com');
header('Access-Control-Allow-Methods: GET, POST');
?>