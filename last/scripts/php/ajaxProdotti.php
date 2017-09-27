<?php
	session_start();
	
	require_once("ManageDB.php");
	require_once("tools.php");

	
	$expression = $_GET['q'];
	$expression = str_replace("+"," ",$expression);
	$operation = $_GET["operation"];
	
	
	if($expression != ""){
		$db = new ManageDB();
		$db->connect();
		
		//$operation = $db->escape($operation);
		$expression = $db->escape($expression);
	
		
		
		switch($operation){
			case "add":
					$query = '
						SELECT prodotti.Nome, prodotti.Codice_prodotto, prodotti.Descrizione, prodotti.Immagine, prodotti.Marca, tipologieprodotti.Tipo AS Tipologia, sottotipologie.Nome AS Sottotipologia
							FROM prodotti, tipologieprodotti, sottotipologie
								WHERE MATCH (prodotti.Nome, prodotti.Descrizione, prodotti.Marca) AGAINST (+"' . $expression . '" IN BOOLEAN MODE) 
								AND prodotti.Tipologia = tipologieprodotti.Codice_tipologia_prodotto
								AND prodotti.Sottotipologia = sottotipologie.Codice_sottotipologia
								AND prodotti.Codice_prodotto NOT IN (
										SELECT DISTINCT prodotti.Codice_prodotto
										FROM prodotti, tipologieprodotti, sottotipologie, prodottinegozio
											WHERE MATCH (prodotti.Nome, prodotti.Descrizione, prodotti.Marca) AGAINST (+"' . $expression . '" IN BOOLEAN MODE) 
												AND prodotti.Tipologia = tipologieprodotti.Codice_tipologia_prodotto
												AND prodotti.Sottotipologia = sottotipologie.Codice_sottotipologia
												AND prodottinegozio.Codice_negozio="' . (isset($_GET['search'])?$_SESSION["codiceNegozio"]:$_SESSION["personalMarket"]) . '"
												AND prodottinegozio.Codice_prodotto = prodotti.Codice_prodotto
												AND prodottinegozio.Stato=1
									)
								
					';
				
				break;
			default:
			$query = 'SELECT prodotti.Marca, prodottinegozio.Prezzo, prodotti.Codice_prodotto, prodotti.Nome, prodotti.Marca, prodotti.Descrizione, prodottinegozio.Prezzo, prodotti.Immagine, prodotti.Tipologia, prodotti.Sottotipologia
				FROM prodotti, prodottinegozio where prodotti.Codice_prodotto=prodottinegozio.Codice_prodotto
				AND Codice_negozio="' . (isset($_GET['search'])?$_SESSION["codiceNegozio"]:$_SESSION["personalMarket"]) . '"
				AND  MATCH (prodotti.Nome, prodotti.Descrizione, prodotti.Marca) AGAINST (+"' . $expression . '" IN BOOLEAN MODE)
				AND prodottinegozio.Stato=1
			';
		}

		
		$found = false;
		
		if($expression == "*"){
			if($operation != "add"){
				$query = 'SELECT prodotti.Marca, prodottinegozio.Prezzo, prodotti.Codice_prodotto, prodotti.Nome, prodotti.Marca, prodotti.Descrizione, prodottinegozio.Prezzo, prodotti.Immagine, prodotti.Tipologia, prodotti.Sottotipologia
					FROM prodotti, prodottinegozio WHERE prodotti.Codice_prodotto=prodottinegozio.Codice_prodotto
					AND Codice_negozio="' . (isset($_GET['search'])?$_SESSION["codiceNegozio"]:$_SESSION["personalMarket"]) . '"
					ORDER BY prodotti.Nome ASC
				';
			}else{
					$query = '
						SELECT prodotti.Nome, prodotti.Codice_prodotto, prodotti.Descrizione, prodotti.Immagine, prodotti.Marca, tipologieprodotti.Tipo AS Tipologia, sottotipologie.Nome AS Sottotipologia
							FROM prodotti, tipologieprodotti, sottotipologie
								WHERE
								prodotti.Tipologia = tipologieprodotti.Codice_tipologia_prodotto
								AND prodotti.Sottotipologia = sottotipologie.Codice_sottotipologia
								AND prodotti.Codice_prodotto NOT IN (
										SELECT DISTINCT prodotti.Codice_prodotto
										FROM prodotti, tipologieprodotti, sottotipologie, prodottinegozio
											WHERE
												prodotti.Tipologia = tipologieprodotti.Codice_tipologia_prodotto
												AND prodotti.Sottotipologia = sottotipologie.Codice_sottotipologia
												AND prodottinegozio.Codice_negozio="' . (isset($_GET['search'])?$_SESSION["codiceNegozio"]:$_SESSION["personalMarket"]) . '"
												AND prodottinegozio.Codice_prodotto = prodotti.Codice_prodotto
												AND prodottinegozio.Stato=1
									)
								
					';
			}
		}
		
		
		$result = $db->query($query);
	
		

		
		while($row = $result->fetch_array(MYSQL_ASSOC)){
			//echo "<li class='list-group-item'><a href='#'>" . $row['Nome'] . " | " . $row['Marca'] . " | " . $row['Descrizione'] . "</a></li>";
			$found = true;
			if(isset($row["Prezzo"])){
				if(isset($_GET['full']) && $_GET['full'] == "true"){
					printProduct($row['Nome'], $row["Prezzo"],  $row['Codice_prodotto'], $row['Descrizione'], $row['Immagine'], $row['Marca']);
				}else{
					printSimpleProduct($row['Nome'], $row["Prezzo"],  $row['Codice_prodotto'], $row['Descrizione'], $row['Immagine'], $row['Marca'], $row['Tipologia'], $row['Sottotipologia'], $operation);
				}
			}else{
				printSimpleProduct($row['Nome'], "",  $row['Codice_prodotto'], $row['Descrizione'], $row['Immagine'], $row['Marca'], $row['Tipologia'], $row['Sottotipologia'], $operation);
			}
		}
		$db->close();
	}
	
	//echo "-->" . $query . "<--";
	

	if(!$found){
		echo "<center><div class='alert alert-danger' style='text-align: center; max-width: 400px'>Nessun risultato</div></center>";
	}
	
	
?>