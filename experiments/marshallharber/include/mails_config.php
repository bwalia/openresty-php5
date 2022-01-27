<?php
switch($_SERVER['SERVER_NAME']){
	case "local.marshallharber.com":
		$admin_from_emailStr = 'noreply@tenthmatrix.co.uk';
		$admin_emailStr = 'neha.kapoor@tenthmatrix.co.uk';
		$cc_emailStr1 = 'jobshout421@gmail.com';
		$cc_emailStr2 = 'developers@tenthmatrix.co.uk';
		break;
	case "staging.marshallharber.com":
		$tokenxmasTxt = __token_getValue($db, 'admin-from-email');
		if($tokenxmasTxt!="" ){ 
			$admin_from_emailStr = $tokenxmasTxt;
		}else{
			$admin_from_emailStr = 'noreply@tenthmatrix.co.uk';
		}
		$tokenxmasTxt = __token_getValue($db, 'admin-email');
		if($tokenxmasTxt!="" ){ 
			$admin_emailStr = $tokenxmasTxt;
		}else{
			$admin_emailStr = 'info@marshallharber.com';
		}
		$tokenxmasTxt = __token_getValue($db, 'cc-email');
		if($tokenxmasTxt!="" ){ 
			$cc_emailStr1 = $tokenxmasTxt;
		}else{
			$cc_emailStr1 = 'jobshout421@gmail.com';
		}
		$cc_emailStr2 = 'developers@tenthmatrix.co.uk';
		break;
	default:
		$tokenxmasTxt = __token_getValue($db, 'admin-from-email');
		if($tokenxmasTxt!="" ){ 
			$admin_from_emailStr = $tokenxmasTxt;
		}else{
			$admin_from_emailStr = 'noreply@tenthmatrix.co.uk';
		}
		$tokenxmasTxt = __token_getValue($db, 'admin-email');
		if($tokenxmasTxt!="" ){ 
			$admin_emailStr = $tokenxmasTxt;
		}else{
			$admin_emailStr = 'info@marshallharber.com';
		}
		$tokenxmasTxt = __token_getValue($db, 'cc-email');
		if($tokenxmasTxt!="" ){ 
			$cc_emailStr1 = $tokenxmasTxt;
		}else{
			$cc_emailStr1 = 'jobshout421@gmail.com';
		}
		$cc_emailStr2 = 'neha.kapoor@tenthmatrix.co.uk';
		break;
}
define("ADMIN_FROM_MAIL",$admin_from_emailStr);
define("ADMIN_MAIL",$admin_emailStr);
define("CC_MAIL_1",$cc_emailStr1);
define("CC_MAIL_2",$cc_emailStr2);
?>