<?php 
	require_once("../../securityAdmin.php");
	include("config.php");
	
?>
<html>
	<head>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1" >
		<meta charset="utf-8" />
		<script type="text/javascript" src="scripts/js/jquery/jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="scripts/js/jquery/jquery-ui.min.js"></script>
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap-theme.min.css" />
		<link rel="stylesheet" type="text/css" href="styles/style.css" />
		<link rel="stylesheet" type="text/css" href="styles/jquery/jquery-ui.css" />
		<script type="text/javascript" src="scripts/js/bootstrap/bootstrap.min.js"></script>

		<title>Emerize</title>	
	</head>
	<body>
		<?php

			require_once("ManageDB.php");
			require_once("tools.php");
	

			$db=new ManageDB();
		    $db->connect();

			$Codice;
		    $Oggetto=$db->escape($_POST['Oggetto'], ENT_QUOTES);
			$Tipologia=$db->escape($_POST['Tipologia']);
			$Testo=$db->escape($_POST['Testo'], ENT_QUOTES);
			$Data=$db->escape(date("Y-m-d"));
			$Utente;

			$query='select max(Codice) as Massimo from segnalazioni';
			$result=$db->query($query);
		    $row=$result->fetch_array(MYSQL_ASSOC);
		    $Codice=$db->escape($row['Massimo']+1);

		    $query='select Codice_fiscale from utenti where Username="'.$_SESSION['Username'].'";';
		    $result=$db->query($query);
		    $row=$result->fetch_array(MYSQL_ASSOC);
		    $Utente=$db->escape($row['Codice_fiscale']);

		    $query='insert into segnalazioni values('.$Codice.', "'.$Oggetto.'", "'.$Tipologia.'", "'.$Testo.'", "'.$Data.'", "'.$Utente.'");';
		    $result=$db->query($query);
		?>
		<p>Salvataggio.....</p>

		<script>
            //window.location.href="informazioni.php";
            window.location.href="../../segnalazioni.php";
        </script>
	</body>
</html>