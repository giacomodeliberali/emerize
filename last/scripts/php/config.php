<?php
	$items_per_group = 3;
	
	$db_server = "89.46.111.29";			
	$db_user = "Sql1023490";
	$db_password = "o3g57zl40z";

	
	// $db_server = "localhost";			
	// $db_user = "tesina";
	// $db_password = "tesinapassword";

	$db_name = "Sql1023490_1";
	
	$earnQuote = 0.2; // 30%
	$fixedPrice = 1; // quota per comprare l'ordine
	$maxOverPrice = 30;
	
	$SEC_PER_PRODUCT = 45; // secondi impiegati per acquistare in media un prodotto
	$EXTRA_TIME = 300; // tempo addizionale, secondi
	
	$MAX_WEIGHT_ON_FOOT = 10; //chilogrammi
	$MAX_WEIGHT_ON_BIKE = 15;
	$MAX_WEIGHT_ON_BUS = 20;
	$MAX_WEIGHT_ON_CAR = 999;
	
	$MAX_DISTANCE_ON_FOOT = 3; //km
	$MAX_DISTANCE_ON_BIKE = 15;
	$MAX_DISTANCE_ON_BUS = 20;
	$MAX_DISTANCE_ON_CAR = 50;
	
	$STATE_SUCCESS = "success";
	$STATE_ERROR = "error";
	$STATE_FAIL = $STATE_ERROR;
	
	$MESSAGE_NO_AUTH = "Non hai i permessi per accedere a questo file.";
	
	$SESSION_EXPIRE_MAX_TIME = 60*60; // 60*60sec = 60 minuti
	
	$MESSAGE_FOR_PUSSIES = "Stop injecting my Code :P<br>";
	//global $earnQuote, $fixedPrice;
	
	/*
		hostinger giacomo.wc.lt --> https://cpanel.hostinger.it
		email: biologo.jack@libero.it
		pass: tesinapassword123
	*/
?>