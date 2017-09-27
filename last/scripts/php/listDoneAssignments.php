<?php
	
		session_start();
		require_once("config.php");
		
		if(isset($_SESSION['Username'])){
			
				require_once("ManageDB.php");
				require_once("tools.php");
				
				$db = new ManageDB();
				$db->connect();
				
				$query='
                    SELECT
                        o.Codice_Ordine as Ordine,
                        o.Data_consegna as Data,
                        u1.Comune as ComuneUtente,
                        n.Nome as NomeNegozio,
                        n.Comune as ComuneNegozio,
                        (sum(pn.Prezzo*o.Quantita)) as Prezzo,
                        o.Stato
                    FROM
                        fattorini f 
                        inner join ordini o on o.Codice_ordine=f.Scontrino
                        inner join utenti u on u.Codice_fiscale=f.Fattorino
                        inner join utenti u1 on u1.Codice_fiscale=o.Codice_utente
                        inner join prodottinegozio pn on pn.Codice_prodotto=o.Codice_prodotto and pn.Codice_negozio=o.Codice_negozio
                        inner join negozi n on n.Partita_iva=pn.Codice_negozio
                     WHERE
                        u.Username="'.$_SESSION['Username'].'"
                        AND o.Stato=1
                    
                    GROUP BY  o.Codice_Ordine
                    ORDER BY Data
				';
				
				$result=$db->query($query);
		
				$orders = array();
		
				while($row = $result->fetch_array(MYSQLI_ASSOC)){
					
				
						$singleRow["Ordine"] = $row["Ordine"];	
						$singleRow["Data"] = $row["Data"];	
						$singleRow["ComuneUtente"] = $row["ComuneUtente"];	
						$singleRow["NomeNegozio"] = $row["NomeNegozio"];	
						$singleRow["ComuneNegozio"] = $row["ComuneNegozio"];	
						$singleRow["Prezzo"] = $row["Prezzo"];
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