<?php
	
	session_start();
	
	require_once("ManageDB.php");

	$provincia = $_GET['provincia'];

	$db = new ManageDB();
	$db->connect();
	
	
	$db->escape($provincia);
	$query="SELECT * FROM comuni WHERE Codice_provincia=" . $provincia;
	$result = $db->query($query);
	
	echo '<option data-hidden="true">Seleziona un comune</option>';
	while($row = $result->fetch_array(MYSQL_ASSOC)){
		echo "<option value='" . $row['Codice_comune'] . "'>" . $row['Nome'] . "</option>";
	}	
	
    $db->close();
?>