<?php
	session_start();
	
	require_once("ManageDB.php");
	

	
	$cap = $_POST['CAP'];


	$db = new ManageDB();
	$db->connect();
	
	$cap = $db->escape($cap);

	//$query = "SELECT negozi.Partita_iva, negozi.Nome, negozi.Comune, negozi.Indirizzo FROM negozi, tipologienegozi where negozi.Tipologia=tipologienegozi.Codice_tipologia_negozio AND negozi.CAP='$cap'";
	$query = 'SELECT negozi.Partita_iva, negozi.Nome, negozi.Comune, negozi.Indirizzo
					FROM negozi, tipologienegozi
					WHERE negozi.Tipologia=tipologienegozi.Codice_tipologia_negozio
					AND negozi.CAP="'. $cap .'"
				UNION
				SELECT negozi.Partita_iva, negozi.Nome, negozi.Comune, negozi.Indirizzo
				FROM negozi, tipologienegozi
				WHERE negozi.Tipologia=tipologienegozi.Codice_tipologia_negozio
				AND negozi.CAP IN ( SELECT CAP FROM comuni WHERE Nome LIKE "%'. $cap .'%")';
	
	
	$result = $db->query($query);
	$found = false;
	
	echo "<ul class='list-group'>";
	
	if($result){
		
		
		while($row = $result->fetch_array(MYSQL_ASSOC)){
			//echo "<li class='list-group-item'><a onclick='showProducts(this)' href='home.php?negozio=" . $row['Partita_iva'] . "&nome=" . $row['Nome'] . "'>" . $row['Nome'] . " | " . $row['Comune'] . " | " . $row['Indirizzo'] . "</a></li>";
			echo "<li class='list-group-item'><a style='text-decoration: none' href='' nome='$row[Nome]' negozio='$row[Partita_iva]'>$row[Nome] | $row[Comune] | $row[Indirizzo]</a></li>";
			$found = true;
		}
		
	}
	
	if(!$found){
		echo "<li class='list-group-item'>Nessun risultato</li>";
	}
	echo "</ul>";
	
	$db->close();	
?>