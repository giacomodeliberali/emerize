<?php
	session_start();
	
	require_once("ManageDB.php");
	

	
	$username = $_POST['Username'];
	$password = $_POST['Password'];



	$db = new ManageDB();
	$db->connect();
	
	$username = $db->escape($username);
	$password = $db->escape($password);
	
	$query = "SELECT * FROM utenti where Username='$username' AND Password=MD5('$password')";
	
	//echo "<script>alert('$query');</script>";
	
	
	$result = $db->query($query);
	$row = $result->fetch_array(MYSQL_ASSOC);
	
	
	$codiceFiscale = $row['Codice_fiscale'];
	
	//echo $query;
	
	if($codiceFiscale == ""){
		echo 'not authorized';
	}else{
		$_SESSION['Username'] = $row['Username'];
		$_SESSION['Codice_fiscale'] = $row['Codice_fiscale'];
		$_SESSION['tipologiaUtente'] = $row['Tipo'];
		$_SESSION['Image'] = $row["Immagine"];
		$_SESSION['LAST_ACTIVITY'] = time();
		
		if(substr($_SESSION['tipologiaUtente'], 0, 1) == "1"){
			//sono un negozio
			$query = "SELECT Partita_iva, Nome, Comune from negozi where Codice_utente='$_SESSION[Codice_fiscale]'";
			$result = $db->query($query);
			$row = $result->fetch_array(MYSQL_ASSOC);
			$_SESSION['personalMarket'] = $row['Partita_iva'];
			$_SESSION['personalMarketName'] = $row['Nome'];
			$_SESSION['personalMarketComune'] = $row['Comune'];
			
		}
		if($_SESSION['tipologiaUtente'] == "000"){ //admin
			echo '<script>location.href="admin.php"</script>';
		}else{
			echo '<script>location.href="selezionaOperazione.php"</script>';
		}
		$db->close();
	}	
	
?>