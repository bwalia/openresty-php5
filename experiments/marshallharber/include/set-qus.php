<?php
session_start();
unset($_SESSION['correct']);
$digit1 = mt_rand(1,6);
$digit2 = mt_rand(1,6);
$math = "$digit1 + $digit2";
$_SESSION['answer'] = $digit1 + $digit2;
//setcookie("answer", $digit1 + $digit2);
echo $math;
?>