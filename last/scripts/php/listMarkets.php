<?php
	
	session_start();
	
		if(isset($_SESSION['Username']) && (isset($_SESSION['tipologiaUtente']) && $_SESSION['tipologiaUtente']) == "000"){
				require_once("ManageDB.php");
				require_once("MessageHandler.php");
				
				$db = new ManageDB();
				$db->connect();
				
				$query = "
					SELECT 
                    	negozi.Partita_iva,
                        negozi.Codice_utente,
                        negozi.Nome,
                    	CONCAT(utenti.Nome, ' ', utenti.Cognome) as Nome_utente,
                        tipologienegozi.Tipo,
                        negozi.Telefono,
                        negozi.Indirizzo,
                        negozi.Comune,
                        negozi.CAP,
                        negozi.Provincia,
                        negozi.Regione
					FROM 
                    	negozi, utenti, tipologienegozi
					WHERE 
                    	negozi.Codice_utente = utenti.Codice_fiscale
						AND tipologienegozi.Codice_tipologia_negozio = negozi.Tipologia
				";
				$result = $db->query($query);
				$markets = array();
				while($row = $result->fetch_array(MYSQLI_ASSOC)){
					$markets[] = $row;
				}
				echo json_encode($markets);
				
				$db->close();
				
		}else{
			require_once("MessageHandler.php");
			
			global $STATE_ERROR, $MESSAGE_NO_AUTH;
			$msg = new MessageHandler("Non autorizzato", $STATE_ERROR, $MESSAGE_NO_AUTH);
			echo json_encode($msg);
		}

	
	

?>