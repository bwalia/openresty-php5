<?php
define("SITE_ID","3320");
define("SITE_GUID","986EE753-5087-4FB2-BDB0-64DE15A77FFF");
define("SERVER_NUMBER","22");
define("SEOFRIENDLYURLSBOOL",true);
define("HOST",$_SERVER['SERVER_NAME']);
define("SITE_NAME",'Marshall Harber');
date_default_timezone_set("Europe/London");

// define("DB_USER",$dbUserStr);
// define("DB_PASSWORD",$dbPasswordStr);
// define("DB_NAME",$dbNameStr);
// define("DB_HOST",$dbHostStr);
 
$MAIL_HOST = getenv('MAIL_HOST');
$MAIL_USERNAME = getenv('MAIL_USERNAME');
$MAIL_PASSWORD = getenv('MAIL_PASSWORD');

$dbUserStr = getenv('MYSQL_USER');
$dbPasswordStr = getenv('MYSQL_PASSWD');
$dbNameStr = getenv('MYSQL_DATABASE');
$dbHostStr = getenv('MYSQL_HOST');

define("DB_USER",$dbUserStr);
define("DB_PASSWORD",$dbPasswordStr);
define("DB_NAME",$dbNameStr);
define("DB_HOST",$dbHostStr);

$site_path= "http://".$_SERVER['HTTP_HOST'];
define("SITE_PATH",$site_path);
define("SITE_WS_PATH",$site_path);
define("SERVER",$server);

define("MAIL_HOST",$MAIL_HOST);
define("MAIL_USERNAME",$MAIL_USERNAME);
define("MAIL_PASSWORD",$MAIL_PASSWORD);
?>