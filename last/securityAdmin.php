<?php
    if(session_id() == '' || !isset($_SESSION)) { 
		session_start();
	}
    
	require_once("scripts/php/config.php");
	global $SESSION_EXPIRE_MAX_TIME;
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $SESSION_EXPIRE_MAX_TIME)) {
		session_unset();     
		session_destroy();
		$sessionExpired="true";
		include("templateNoAuth.php");
		die();
	}
	
	if(!isset($_SESSION['Username']) || $_SESSION['Username'] == ""){
		include("templateNoAuth.php");
		die();
	}


?>