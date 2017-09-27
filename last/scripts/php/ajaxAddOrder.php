<?php
	session_start();
	
	require_once("ManageDB.php");
	require_once("MessageHandler.php");

	$db = new ManageDB();
	$db->connect();
	
	$cart = json_decode($_COOKIE["cart"]);
	$date = date("Y-m-d");
	$orderDate = $db->escape($_GET["dataConsegna"]);
	$fascia = $db->escape($_GET["fascia"]);
	
	$query = "SELECT MAX(Codice_ordine) AS Codice_massimo FROM ordini";
	$result = $db->query($query);
	$codice = $result->fetch_array(MYSQLI_ASSOC)["Codice_massimo"];
	$codice++;
	$quequed = "true";
	
	$query = "";
	foreach($cart->products as $product){
		$query = "
			INSERT INTO ordini VALUES (
				$codice,
				'$_SESSION[Codice_fiscale]',
				'$product->id',
				$product->price,
				'$_SESSION[codiceNegozio]',
				$product->number,
				'$date',
				'$orderDate',
				1,
				0
			);
		";
		$result = $db->query($query);
		if($db->affectedRows() != 1){
			$quequed = "false";
		}
	}
	
	//echo $query;
	
	
	if($quequed == "true"){
		$msg = new MessageHandler("Ordine accodato!", "success", "$codice");
	}else{
		$errors = $db->error();
		$msg = new MessageHandler("Ordine non aggiunto!", "error", "$errors");
	}
	
	echo $msg->toJSON();
	
	$db->close();	
?>