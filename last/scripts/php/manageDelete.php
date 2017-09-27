<?php
	
	session_start();
	
	require_once("ManageDB.php");
	require_once("MessageHandler.php");



	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
			$db = new ManageDB();
			$db->connect();
	
		$what= $db->escape($_POST["what"]);
		$id = $db->escape($_POST["id"]);
		
		switch($what){
			case "utenti":
				$query = "DELETE FROM utenti WHERE Codice_fiscale='$id'";
				$returnSuccessMsg = "Utente eliminato.";
				$returnErrorMsg = "Utente non eliminato! Errore. \nE' possibile che l'utente sia titolare di un negozio. Eliminare prima il negozio relativo.";
				break;
			case "negozi":
				$query = "DELETE FROM negozi WHERE Partita_iva='$id'";
				$returnSuccessMsg = "Negozio eliminato.";
				$returnErrorMsg = "Negozio non eliminato! Errore";
				break;
			case "segnalazioni":
				$query = "DELETE FROM segnalazioni WHERE Codice='$id'";
				$returnSuccessMsg = "Segnalazione eliminata.";
				$returnErrorMsg = "Segnalazione non eliminata! Errore";
				break;
			case "ordini":
				$query = "DELETE FROM ordini WHERE Codice_ordine='$id'";
				$returnSuccessMsg = "Ordine eliminato.";
				$returnErrorMsg = "Ordine non eliminato! \nE' possibile che l'ordine sia già stato assegnato ad un fattorino.";
				break;
			default:
				$query = "";
				$returnSuccessMsg = "";
				$returnErrorMsg = "";
		}
        
		if($query!=""){
			$result = $db->query($query);
			if($result){
				$hMsg = new MessageHandler($returnSuccessMsg,"success", "query done");	
			}else{
					$hMsg = new MessageHandler($returnErrorMsg,"fail", $db->error());
			}
		}else{
            $hMsg = new MessageHandler($returnErrorMsg,"fail", $db->error());
        }
		
        $db->close();
		echo $hMsg->toJSON();
	}else{
		echo "bad call";
	}
	
	

?>