<?php
	
	session_start();
	
		if(isset($_SESSION['Username']) && (isset($_SESSION['tipologiaUtente']) && $_SESSION['tipologiaUtente']) == "000"){
				require_once("ManageDB.php");
				require_once("MessageHandler.php");
				
				$db = new ManageDB();
				$db->connect();
				$db->query("SET CHARACTER SET utf8;");
				$query = "
                    SELECT
						prodotti.Codice_prodotto,
						prodotti.Nome,
						prodotti.Marca,
						prodotti.Descrizione,
						prodotti.Peso,
						tipologieprodotti.Tipo AS Tipologia,
						sottotipologie.Nome AS Sottotipologia
                    FROM
						prodotti, tipologieprodotti, sottotipologie
                    WHERE
						prodotti.Tipologia = tipologieprodotti.Codice_tipologia_prodotto
						AND prodotti.Sottotipologia = sottotipologie.Codice_sottotipologia
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
			
			global $STATE_ERROR, $MESSAGE_NO_AUTH;
			$msg = new MessageHandler("Non autorizzato", $STATE_ERROR, $MESSAGE_NO_AUTH);
			echo json_encode($msg);
		}

	
	

?>