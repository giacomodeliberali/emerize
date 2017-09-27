<?php
	session_start();
	
	require_once("ManageDB.php");
	

	
	$username = $_GET['username'];
	
	$db = new ManageDB();
	$db->connect();
	
	$username = $db->escape($username);
	
	$query = "SELECT * FROM utenti where Username='$username'";
	$db->query($query);
	if($db->affectedRows() > 0){
		echo 'not_free';
	}else{
		echo 'free';
	}
	$db->close();
	

	
?>