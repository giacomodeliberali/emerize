<?php
	
	session_start();
	
	require_once("ManageDB.php");
	require_once("MessageHandler.php");



	
	if($_SERVER["REQUEST_METHOD"] == "POST"){

		$db = new ManageDB();
		$db->connect();
		
		$operation = $db->escape($_POST["operation"]);
		$price = $db->escape($_POST["price"]);
		$productID = $db->escape($_POST["productID"]);
		$personalMarket = $_SESSION["personalMarket"];
		
		
		
		switch($operation){
			case "add":
				$query = "INSERT INTO prodottinegozio values('$productID', '$personalMarket', $price, '1')";
				$returnSuccessMsg = "Prodotto inserito con successo!";
				$returnErrorMsg = "Prodotto non inserito.";
				break;
			case "update":
				$query = "UPDATE prodottinegozio SET Prezzo=$price WHERE Codice_negozio='$personalMarket' AND Codice_prodotto='$productID'";
				$returnSuccessMsg = "Prodotto aggiornato con successo!";
				$returnErrorMsg = "Prodotto non aggiornato.";
				break;
			case "delete":
				$query = "UPDATE prodottinegozio SET Stato=0 WHERE Codice_negozio='$personalMarket' AND Codice_prodotto='$productID'";
				$returnSuccessMsg = "Prodotto eliminato con successo!";
				$returnErrorMsg = "Prodotto non eliminato.";
				break;
			default:
				$query = "";
		}
		if($query!=""){

			
			$result = $db->query($query);
			if($result){
				$hMsg = new MessageHandler($returnSuccessMsg,"success", "query done");	
			}else{
				if($operation=="add"){
					$query = "UPDATE prodottinegozio SET Stato=1 WHERE Codice_negozio='$personalMarket' AND Codice_prodotto='$productID'";
					$result = $db->query($query);
					
					if($result){
						$hMsg = new MessageHandler($returnSuccessMsg,"success", "query done");	
					}else{
						$hMsg = new MessageHandler($returnErrorMsg,"fail", $db->error());
					}
				}else{
					$hMsg = new MessageHandler($returnErrorMsg,"fail", $db->error());
				}
			}
			echo $hMsg->toJSON();
			
		}
		
		$db->close();
	}else{
		echo "bad call";
	}
	
	

?>