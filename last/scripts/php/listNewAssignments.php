<?php
	
		session_start();
		require_once("config.php");
		
		if(isset($_SESSION['Username'])){
			
				require_once("ManageDB.php");
				require_once("tools.php");
				
				$db = new ManageDB();
				$db->connect();
				
                if(isset($_GET['type'])){
                    $type = $db->escape($_GET['type']);
                }else{
                    $type = "car";
                }
				
                if(isset($_GET['time'])){
                    $maxTime = $db->escape($_GET['time']);
                }else{
                    $maxTime = "120";
                }
				
				if(isset($_GET['full']) && $_GET['full']=="true"){
					$full = "true";
				}
				
				global $MAX_WEIGHT_ON_FOOT, $MAX_WEIGHT_ON_BIKE, $MAX_WEIGHT_ON_BUS, $MAX_WEIGHT_ON_CAR;
				global $MAX_DISTANCE_ON_FOOT, $MAX_DISTANCE_ON_BIKE, $MAX_DISTANCE_ON_BUS, $MAX_DISTANCE_ON_CAR;
				
				switch($type){
					case "foot":
					case "nessun_mezzo":
						$maxWeight = $MAX_WEIGHT_ON_FOOT;
						$maxDistance = $MAX_DISTANCE_ON_FOOT;
						$mode = "walking";
						break;
					case "bike":
					case "bicicletta":
						$maxWeight = $MAX_WEIGHT_ON_BIKE;
						$maxDistance = $MAX_DISTANCE_ON_BIKE;
						//$mode = "bicycling";
						$mode = "driving";
						break;
					case "bus":
					case "autobus":
						$maxWeight = $MAX_WEIGHT_ON_BUS;
						$maxDistance = $MAX_DISTANCE_ON_BUS;
						$mode = "driving";
						break;
					case "car":
					case "automobile":
						$maxWeight = $MAX_WEIGHT_ON_CAR;
						$maxDistance = $MAX_DISTANCE_ON_CAR;
						$mode = "driving";
						break;
					default:
						$maxWeight = $MAX_WEIGHT_ON_CAR;
						$maxDistance = $MAX_DISTANCE_ON_CAR;
						$mode = "driving";
				}
				
				
				

				
				$query='
					SELECT
						utenti.Indirizzo AS IndirizzoFattorino,
						utenti.CAP AS CAPFattorino,
						CONCAT(utenti.Nome, " ", utenti.Cognome) AS NomeFattorino,
						utenti.Codice_fiscale as CodiceFattorino,
						utenti.Regione AS RegioneFattorino
					FROM
						utenti
					WHERE
						utenti.Codice_fiscale="' . $_SESSION["Codice_fiscale"] . '"
				';
				
				$result=$db->query($query);
				$row = $result->fetch_array(MYSQLI_ASSOC);
				
				$indirizzoFattorino = str_replace(" ", "+" , $row["IndirizzoFattorino"]) . $row['CAPFattorino'];
				$nomeFattorino = $row['NomeFattorino'];
				$codiceFattorino = $row['CodiceFattorino'];
				$regioneFattorino = $row['RegioneFattorino'];
				
				$query = "
						SELECT 
							o.Codice_Ordine, 
							o.Data_Ordine AS DataOrdine, 
							o.Data_Consegna AS DataConsegna,
							u.Indirizzo AS IndirizzoUtente, 
							u.Comune as ComuneUtente, 
							u.CAP AS CAP_utente, 
							fat.Codice_fiscale AS CodiceFattorino,
							n.Indirizzo AS IndirizzoNegozio, 
							n.Comune as ComuneNegozio, 
							n.CAP as CAP_negozio, 
							n.Nome as Negozio,
							u.Regione AS RegioneUtente,
							n.Regione AS RegioneNegozio,
							sum(o.Quantita) as Prodotti,
							sum(prodotti.Peso * o.Quantita) AS Peso
						FROM ordini o 
							LEFT join fattorini f on f.Scontrino=o.Codice_Ordine
							inner join utenti u on u.Codice_fiscale=o.Codice_utente
							LEFT join utenti fat on fat.Codice_fiscale = f.Fattorino
							inner join negozi n on o.Codice_negozio=n.Partita_iva
							INNER join prodotti on prodotti.Codice_prodotto=o.Codice_prodotto
						GROUP BY o.Codice_Ordine
				";
				$result = $db->query($query);
				$orders = array();
				$singleRow = array();
				$fullAssignments = array();
				
				if(isset($_GET['all']) && $_GET['all']=="true"){
						if($_SESSION['tipologiaUtente'] == "000"){
								while($row = $result->fetch_array(MYSQLI_ASSOC)){
										$singleRow["Codice_Ordine"] = $row["Codice_Ordine"];	
										$singleRow["DataConsegna"] = $row["DataConsegna"];	
										$singleRow["ComuneUtente"] = $row["ComuneUtente"];	
										$singleRow["ComuneNegozio"] = $row["ComuneNegozio"];	
										$singleRow["Negozio"] = $row["Negozio"];
										$singleRow["Prodotti"] = $row["Prodotti"];
										$orders[] = $singleRow;
								}
								echo json_encode($orders);
						}else{
								require_once("MessageHandler.php");
								
								global $STATE_ERROR, $MESSAGE_NO_AUTH;
								$msg = new MessageHandler("Non autorizzato", $STATE_ERROR, $MESSAGE_NO_AUTH);
								echo json_encode($msg);
						}
						exit(0); 
				}
				
				
				
				while($row = $result->fetch_array(MYSQLI_ASSOC)){
				
						$regioneUtente = $row["RegioneUtente"];
						$regioneNegozio = $row["RegioneNegozio"];
						
						if($regioneUtente == $regioneFattorino && $regioneUtente == $regioneNegozio && $row['DataConsegna'] >= date("Y-m-d")){
								$indirizzoNegozio = $row["ComuneNegozio"];
								$indirizzoNegozio = str_replace(" ", "+", $indirizzoNegozio);
								$indirizzoNegozio .= "+" . $row["CAP_negozio"];
								$indirizzoNegozio .= "+" . str_replace(" ", "+", $row['IndirizzoNegozio']);
								
								$indirizzoUtente = $row["ComuneUtente"];
								$indirizzoUtente = str_replace(" ", "+", $indirizzoUtente);
								$indirizzoUtente .= "+" . $row["CAP_utente"];
								$indirizzoUtente .= "+" . str_replace(" ", "+", $row['IndirizzoUtente']);
								
								$googleAPI = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $indirizzoFattorino . '&destinations=' . $indirizzoNegozio . '&mode=' . $mode;
								//echo $googleAPI . "<br>";
								$distanceMatrix = file_get_contents($googleAPI);
								$obj = json_decode($distanceMatrix);
								
								$fattorino_negozio_distance = $obj->rows[0]->elements[0]->distance->value;
								$fattorino_negozio_time = $obj->rows[0]->elements[0]->duration->value;
								
								$googleAPI = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $indirizzoNegozio . '&destinations=' . $indirizzoUtente . '&mode=' . $mode;
								//echo $googleAPI . "<br>";
								$distanceMatrix = file_get_contents($googleAPI);
								$obj = json_decode($distanceMatrix);
								
								$negozio_utente_distance = $obj->rows[0]->elements[0]->distance->value;
								$negozio_utente_time = $obj->rows[0]->elements[0]->duration->value;
								
								
								$googleAPI = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $indirizzoUtente . '&destinations=' . $indirizzoFattorino . '&mode=' . $mode;
								//echo $googleAPI . "<br>";
								$distanceMatrix = file_get_contents($googleAPI);
								$obj = json_decode($distanceMatrix);
								
								$utente_fattorino_distance = $obj->rows[0]->elements[0]->distance->value;
								$utente_fattorino_time = $obj->rows[0]->elements[0]->duration->value;
								
								
								$totalDistance = arrotonda(($fattorino_negozio_distance + $negozio_utente_distance + $utente_fattorino_distance)/1000);
								$roadTime = round(($fattorino_negozio_time + $negozio_utente_time + $utente_fattorino_time)/60);
								//echo $roadTime . '<br>';
								
								global $SEC_PER_PRODUCT, $EXTRA_TIME;
								$shoppingTime = round(($SEC_PER_PRODUCT*$row['Prodotti'] + $EXTRA_TIME)/60);
								$totalTime = $shoppingTime + $roadTime;
								
								$row['TotalDistance'] = $totalDistance;
								$row['TotalTime'] = $totalTime;
								$row['Peso'] = floor($row['Peso']/1000*10)/10; // converto in kg con 1 decimale
								
								$row['NomeFattorino'] = $nomeFattorino;
								$row['CodiceFattorino'] = $codiceFattorino;
								
								
								
								//echo ">>peso: " . $row["Peso"] . "<<<br>";
								//echo ">>max peso: " . $maxWeight . "<<<br>";
								//echo ">>time: " . $totalTime. "<<<br>";
								//echo ">>max time: " . $maxTime. "<<<br>";
								//echo ">>distance: " . $totalDistance. "<<<br>";
								//echo ">>max distance: " . $maxDistance. "<<<br>";
								
								if($row['Peso'] <= $maxWeight && $totalTime <= $maxTime && $totalDistance <= $maxDistance){
										//$orders["Ordini"] = $row;
										
										$singleRow["Codice_Ordine"] = $row["Codice_Ordine"];	
										$singleRow["DataConsegna"] = $row["DataConsegna"];	
										$singleRow["ComuneUtente"] = $row["ComuneUtente"];	
										$singleRow["ComuneNegozio"] = $row["ComuneNegozio"];	
										$singleRow["Negozio"] = $row["Negozio"];	
										$singleRow["Prodotti"] = $row["Prodotti"];
										$singleRow["TotalDistance"] = $row["TotalDistance"];
										
										if($singleRow["TotalDistance"] =="0"){
												$singleRow["TotalTime"] = "non disponibile";
												$singleRow["TotalDistance"] = "non disponibile";
										}else{
												$singleRow["TotalTime"] = $row["TotalTime"];
										}
								
								
										$orders[] = $singleRow;
								
										$fullAssignments['Ordini'][] = $row;
								
								}
						}
				}
				
				//$orders['Results'] = count($orders);
				$fullAssignments['Results'] = count($fullAssignments['Ordini']);
				
				if($full == "true"){
					echo json_encode($fullAssignments);	
				}else{
					echo json_encode($orders);	
				}
				
				$db->close();
				
				
		}else{
			require_once("MessageHandler.php");
			
			global $STATE_ERROR, $MESSAGE_NO_AUTH;
			$msg = new MessageHandler("Non autorizzato", $STATE_ERROR, $MESSAGE_NO_AUTH);
			echo json_encode($msg);
		}

	
	

?>