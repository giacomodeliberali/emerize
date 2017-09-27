<?php
	if(session_id() == '' || !isset($_SESSION)) { 
		session_start();
	}

	
	
	if(!isset($_SESSION['Username']) || $_SESSION['Username'] == ""){
		die("non autorizzato");
	}
		
	if(isset($_POST['negozio'])){
		$_SESSION['codiceNegozio'] = $_POST['negozio'];
	}
	if(isset($_POST['nome'])){
		$_SESSION['marketName'] = $_POST['nome'];
	}
	if(isset($_GET['sottotipologia'])){
		$_SESSION['sottotipologia'] = $_GET['sottotipologia'];
	}else{
		$_SESSION['sottotipologia'] = "";
		unset($_SESSION['sottotipologia']);
	}
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		header("Location: home.php");
	}
	
	require_once("scripts/php/header_footer.php");
	require_once("scripts/php/tools.php");
?>
<html class="noselect">
	<head>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1" >
		<meta charset="utf-8" />
		<script type="text/javascript" src="scripts/js/jquery/jquery-1.11.2.min.js"></script> <!-- jQuery -->
		<script type="text/javascript" src="scripts/js/jquery/jquery-ui.min.js"></script>
		<script type="text/javascript" src="scripts/js/bootstrap/bootstrap.min.js"></script>
		<script type="text/javascript" src="scripts/js/jquery/jquery.mobile.custom.min.js"></script>
		<link rel="stylesheet" type="text/css" href="styles/jquery/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap-theme.min.css" />
		
		<title>Emerize - Lista negozi</title>
		<link rel="stylesheet" type="text/css" href="styles/style.css" />


		<link rel="stylesheet" href="styles/bootstrap/bootstrap-table.css">
		<script src="scripts/js/bootstrap/bootstrap-table.js"></script>
		<script src="scripts/js/bootstrap/bootstrap-table-it-IT.js"></script>
		<script src="scripts/js/bootstrap/bootstrap-table-mobile.js"></script>
		<script src="scripts/js/lists.js"></script>

	</head>
	<body>
		
		<?php
			getHeaderNoCart();
		?>
        <div class="container">
        	<div id="NegoziToolbar" class="btn-group">
				<div class="title">Lista negozi</div>
			</div>
			<table 	data-toggle="table" id="negozi" data-url="scripts/php/listMarkets.php" data-pagination="true"
					data-search="true"
					data-show-columns="true"
					data-toolbar="#NegoziToolbar"
					data-height="500"
					data-pagination="true"
					data-show-toggle="true"
					data-show-refresh="true"
					class="table table-striped table-condensed">
				<thead>
				<tr>
					<th data-formatter="runningFormatter" data-visible="false" data-width="30px">Index</th>
					<th data-field="Partita_iva" data-sortable="true" data-visible="false">Partita Iva</th>
					<th data-field="Nome_utente" data-sortable="true">Nome proprietario</th>
					<th data-field="Nome" data-sortable="true" data-switchable="false">Nome</th>
					<th data-field="Tipo" data-sortable="true" data-visible="true">Tipologia</th>
					<th data-field="Telefono" data-sortable="true" data-visible="false">Telefono</th>
					<th data-field="Indirizzo" data-sortable="true" data-visible="false">Indirizzo</th>
					<th data-field="Comune" data-sortable="true" data-visible="true">Comune</th>
					<th data-field="CAP" data-sortable="true" data-visible="false">CAP</th>
					<th data-field="Provincia" data-sortable="true" data-visible="true">Provincia</th>
					<th data-field="Regione" data-sortable="true" data-visible="trues">Regione</th>
					<th data-field="Codice_utente" data-sortable="true" data-visible="false">Codice utente</th>
					<th data-field="action" data-width="30px" data-align="center" data-formatter="actionFormatter" data-switchable="false" data-events="actionEvents"></th>
				</tr>
				
				</thead>
			</table>
		</div>
	</body>
</html>