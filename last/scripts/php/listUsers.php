<?php
	
	session_start();
	
		if(isset($_SESSION['Username']) && (isset($_SESSION['tipologiaUtente']) && $_SESSION['tipologiaUtente']) == "000"){
				require_once("ManageDB.php");
				
				
				$db = new ManageDB();
				$db->connect();
				
				$query = "
					SELECT
						Codice_fiscale, CONCAT(Cognome, ' ', Nome) AS Nome,
						Data_nascita, Telefono, Indirizzo, Comune, CAP, Provincia, Regione, Tipo, Username
					FROM
						utenti
				";
				$result = $db->query($query);
				$users = array();
				while($row = $result->fetch_array(MYSQLI_ASSOC)){
					$users[] = $row;
				}
				echo json_encode($users);
				
				$db->close();
				
		}else{
			require_once("MessageHandler.php");
			$msg = new MessageHandler("NO_AUTH", $MESSAGE_NO_AUTH, "Non disponi delle autorizzazioni necessarie.");
			header("Location: /index.php");
		}

	
	

?>