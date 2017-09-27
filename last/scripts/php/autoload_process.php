<?php

	include("config.php");
	require_once("tools.php");
	
	$db = new ManageDB();
	$db->connect();
	
	if($_POST)
	{
		$group_number = $db->escape($_POST["group_no"]);

		//get current starting point of records
		$position = ($group_number * $items_per_group);
	
		if($_SESSION['sottotipologia'] != "" && !is_numeric($_SESSION['sottotipologia'])){
			die($MESSAGE_FOR_PUSSIES);
		}
		
		if(isset($_SESSION['sottotipologia']) AND $_SESSION['sottotipologia'] != ""){
			$query = "
				SELECT
					prodotti.Marca,
					prodotti.Codice_prodotto AS ID,
					prodotti.Nome AS Nome,
					prodotti.Marca AS Marca,
					prodotti.Descrizione AS Descrizione,
					prodottinegozio.Prezzo AS Prezzo,
					prodotti.Immagine AS Immagine
				FROM
					prodotti, prodottinegozio
				WHERE
					prodotti.Codice_prodotto=prodottinegozio.Codice_prodotto
					AND Codice_negozio='" .$_SESSION['codiceNegozio'] . "'
					AND prodottinegozio.Stato=1
					AND prodotti.Sottotipologia=" . $_SESSION['sottotipologia']. " 
					ORDER BY prodotti.Sottotipologia ASC, prodotti.Marca, prodotti.Nome ASC
					LIMIT $position, $items_per_group
				";
		}else{
			$query = "SELECT
						prodotti.Marca,
						prodotti.Codice_prodotto AS ID,
						prodotti.Nome AS Nome,
						prodotti.Marca AS Marca,
						prodotti.Descrizione AS Descrizione,
						prodottinegozio.Prezzo AS Prezzo,
						prodotti.Immagine AS Immagine
					FROM
						prodotti, prodottinegozio
					WHERE
						prodotti.Codice_prodotto=prodottinegozio.Codice_prodotto
						AND prodottinegozio.Stato=1
						AND Codice_negozio='" .$_SESSION['codiceNegozio']. "' 
						ORDER BY prodotti.Sottotipologia ASC, prodotti.Marca, prodotti.Nome ASC
						LIMIT $position, $items_per_group
					";
		}
		
		$results = $db->query($query);
		
		if ($results) {
			$empty = true;
			while($row = $results->fetch_array(MYSQL_ASSOC))
			{
				$empty = false;
				printProduct($row['Nome'], $row['Prezzo'], $row['ID'], $row['Descrizione'], $row['Immagine'], $row['Marca']);
			}
		}
		
		if($empty){
			
			echo '
				<script>
					var i = $("#productsContainer").find("div").length;
					if(i<=1){
						var text = "<center><div class=\'alert alert-danger\' style=\'text-align: center; max-width: 400px\'>Nessun risultato</div></center>";
						$("#productsContainer").html(text);
					}
				</script>
			';
		}
		
		$db->close();
	}

?>