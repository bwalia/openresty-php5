<?php
exit;
  //phpinfo();exit;
  //echo $_SESSION['answer'].'=====';
session_start();
echo session_id();
ini_set('session.cookie_domain', 'www.marshallharber.com');
echo ini_get('session.cookie_domain');
//$_SESSION['answer'] = 5;
var_dump($_SESSION);
?>