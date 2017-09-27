<?php
	
	session_start();
	
	require_once("ManageDB.php");


	$db = new ManageDB();
	$db->connect();
	
	$regione = $_GET['regione'];
	
	$regione = $db->escape($regione);
	
	$query="SELECT * FROM province WHERE Codice_regione=" . $regione;
	$result = $db->query($query);
	
	echo '<option data-hidden="true">Seleziona una provincia</option>';
	
	while($row = $result->fetch_array(MYSQL_ASSOC)){
		echo "<option value='" . $row['Codice_provincia'] . "'>" . $row['Nome'] . "</option>";
	}	
	
    $db->close();
?>