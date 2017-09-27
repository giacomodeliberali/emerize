<?php
	
		session_start();
		require_once("config.php");
		
		if(isset($_SESSION['Username'])){
			
				require_once("ManageDB.php");
	
				$db = new ManageDB();
				$db->connect();
				
				$query='
                    select
                        o.Codice_Ordine as Ordine,
                        o.Data_consegna as Data,
                        (sum(pn.Prezzo*o.Quantita)) as Prezzo,
                        o.Stato
                    from
                        ordini o 
                        inner join utenti u on u.Codice_fiscale=o.Codice_utente
                        inner join prodottinegozio pn on pn.Codice_prodotto=o.Codice_prodotto and pn.Codice_negozio=o.Codice_negozio
                    where
                        u.Username="'.$_SESSION['Username'].'"
                        group by o.Codice_Ordine         
                ';
				
				$result=$db->query($query);
		
				$orders = array();
		
				while($row = $result->fetch_array(MYSQLI_ASSOC)){
					
				
						$singleRow["Ordine"] = $row["Ordine"];	
						$singleRow["Data"] = $row["Data"];		
						$singleRow["Prezzo"] = $row["Prezzo"];
						$singleRow["Stato"] = $row["Stato"];
						$singleRow["Stato"] = $row["Stato"];
                        
						
						$orders[] = $singleRow;

				}
			
	
				echo json_encode($orders);	
				
				
				$db->close();
				
				
		}else{
			require_once("MessageHandler.php");
			
			global $STATE_ERROR, $MESSAGE_NO_AUTH;
			$msg = new MessageHandler("Non autorizzato", $STATE_ERROR, $MESSAGE_NO_AUTH);
			echo json_encode($msg);
		}

	
	

?>