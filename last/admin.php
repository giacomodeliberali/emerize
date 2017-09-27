<?php
    if(session_id() == '' || !isset($_SESSION)) { 
		session_start();
	}
    
	require_once("scripts/php/config.php");
	global $SESSION_EXPIRE_MAX_TIME;
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $SESSION_EXPIRE_MAX_TIME)) {
		session_unset();     
		session_destroy();
		$sessionExpired="true";
		include("templateNoAuth.php");
		die();
	}
	
	if(!isset($_SESSION['Username']) || $_SESSION['Username'] == ""){
		include("templateNoAuth.php");
		die();
	}
	
	require_once("scripts/php/header_footer.php");
	require_once("scripts/php/tools.php");
?>
<html class="noselect">
	<head>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1" >
		<meta charset="UTF-8">
		
		<script type="text/javascript" src="scripts/js/jquery/jquery-1.11.2.min.js"></script> <!-- jQuery -->
		<script type="text/javascript" src="scripts/js/jquery/jquery-ui.min.js"></script>
		<script type="text/javascript" src="scripts/js/bootstrap/bootstrap.min.js"></script>
		<script type="text/javascript" src="scripts/js/jquery/jquery.mobile.custom.min.js"></script>
		<link rel="stylesheet" type="text/css" href="styles/jquery/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap-theme.min.css" />
		
		<link rel="stylesheet" type="text/css" href="styles/style.css" />

		<link rel="stylesheet" href="styles/bootstrap/bootstrap-table.css">
		<script src="scripts/js/bootstrap/bootstrap-table.js"></script>
		<script src="scripts/js/bootstrap/bootstrap-table-it-IT.js"></script>
		<script src="scripts/js/bootstrap/bootstrap-table-mobile.js"></script>
		
		<title>Emerize - Sezione Admin</title>

	</head>
	<body>
		
		<?php
			getHeaderNoCart();
		?>
        <div class="container">
			
			<ul class='list-group'>
				<li class='list-group-item'><a href="listaUtenti.php">Lista utenti registrati</a></li>
				<li class='list-group-item'><a href="listaNegozi.php">Lista negozi iscritti</a></li>
				<li class='list-group-item'><a href="listaOrdini.php">Lista ordini</a></li>
				<li class='list-group-item'><a href="listaProdotti.php">Lista prodotti</a></li>
				<li class='list-group-item'><a href="listaSegnalazioni.php">Lista segnalazioni</a></li>
				<li class='list-group-item'><a href="statistiche.php">Statistiche</a></li>
				<li class='list-group-item'><a href="nuovoprodotto.php">Aggiungi nuovo prodotto</a></li>
			</ul>
			
        </div>
	</body>
</html>