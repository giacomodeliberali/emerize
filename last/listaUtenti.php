<?php
	require_once("securityAdmin.php");
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
		
		<title>Emerize - Lista Utenti</title>
		<link rel="stylesheet" type="text/css" href="styles/style.css" />


		<link rel="stylesheet" href="styles/bootstrap/bootstrap-table.css">
		<script src="scripts/js/bootstrap/bootstrap-table.js"></script>
		<script src="scripts/js/bootstrap/bootstrap-table-it-IT.js"></script>
		<script src="scripts/js/bootstrap/bootstrap-table-mobile.js"></script>
		<script src="scripts/js/tools.js"></script>
		<script src="scripts/js/lists.js"></script>

	</head>
	<body>
		
		<?php
			getHeaderNoCart();
		?>
        <div class="container">
        	<div id="utentiToolbar" class="btn-group">
				<div class="title">Lista utenti</div>
			</div>
			<table 	data-toggle="table" id="utenti" data-url="scripts/php/listUsers.php" data-pagination="true"
					data-search="true"
					data-show-columns="true"
					data-toolbar="#utentiToolbar"
					data-height="500"
					data-mobile-responsive="true"
					data-pagination="true"
					data-show-toggle="true"
					data-show-refresh="true"
					data-page-list="[10, 20, 50, 100, 200]"
					class="table table-striped table-condensed">
				<thead>
				<tr>
					<th data-formatter="runningFormatter" data-visible="false" data-width="30px">Index</th>
					<th data-field="Codice_fiscale" data-sortable="true" data-visible="false">Codice fiscale</th>
					<th data-field="Nome" data-sortable="true">Nome</th>
					<th data-field="Data_nascita" data-sortable="true" data-visible="false">Data nascita</th>
					<th data-field="Telefono" data-sortable="true" data-visible="false">Telefono</th>
					<th data-field="Indirizzo" data-sortable="true" data-visible="false">Indirizzo</th>
					<th data-field="Comune" data-sortable="true" data-visible="false">Comune</th>
					<th data-field="CAP" data-sortable="true" data-visible="false">CAP</th>
					<th data-field="Provincia" data-sortable="true">Provincia</th>
					<th data-field="Regione" data-sortable="true" >Regione</th>
					<th data-field="Tipo" data-sortable="true">Tipo</th>
					<th data-field="Username" data-switchable="false" data-sortable="true">Username</th>
					<th data-field="action" data-width="30px" data-align="center" data-switchable="false" data-formatter="modifyAccount" data-events="actionEvents"></th>
					<th data-field="action" data-width="30px" data-align="center" data-switchable="false" data-formatter="actionFormatter" data-events="actionEvents"></th>
				</tr>
				
				</thead>
			</table>
			
			<div style="display: none" id="dialog-confirm"></div>
			
		</div>
	</body>
</html>