<?php
	session_start();
	
	require_once("ManageDB.php");
	require_once("tools.php");
	include("config.php");

	$badwords=array("cretino", "cazzo", "puttana", "vaffanculo", "stronzo", "coglione", "figa", "culo");
	
	$db=new ManageDB();
	$db->connect();
	
	$message=$db->escape($_GET['q']);
	
	$message=explode(' ', $message);

	foreach($badwords as $badword) {
		for($i=0; $i<count($message); $i++) {
			similar_text($message[$i], $badword, $sim);
			if($sim>80) {
				$message[$i]='@4!f9#ç. They don\'t teach you right manners!?';
			}
		}
	}
	$message=implode(' ', $message);

	foreach($badwords as $badword) {
		$message=ereg_replace($badword,'@4!f9#ç. They don\'t teach you right manners!?',$message);
	}

	//$message=htmlentities($message,ENT_QUOTES);
	$data=date("Y-m-d H:i:s");


	$query='select max(Id) as Id from areautenti;';
	$result=$db->query($query);
	$row=$result->fetch_array(MYSQL_ASSOC);
	$id=$row['Id']+1;

	$query='insert into areautenti values('.$id.', "'.$_SESSION['Username'].'", "'.$message.'", "'.$data.'");';
	$result=$db->query($query);
?>
