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
		
		<title>Emerize - Lista Ordini</title>
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
        	<div id="OrdiniToolbar" class="btn-group">
				<div class="title">Lista ordini</div>
			</div>
			<table 	data-toggle="table" id="ordini" data-url="scripts/php/listNewAssignments.php?all=true" data-pagination="true"
					data-search="true"
					data-show-columns="true"
					data-toolbar="#OrdiniToolbar"
					data-height="500"
					data-pagination="true"
					data-show-toggle="true"
					data-show-refresh="true"
					class="table table-striped table-condensed">
				<thead>
				<tr>
					<th data-field="Codice_Ordine" data-sortable="true" data-visible="false" data-width="30px">#</th>
					<th data-field="DataConsegna" data-sortable="true" data-switchable="false">Data Consegna</th>
					<th data-field="ComuneUtente" data-sortable="true">Comune Utente</th>
					<th data-field="ComuneNegozio" data-sortable="true" data-visible="true">Comune Negozio</th>
					<th data-field="Negozio" data-sortable="true">Negozio</th>
					<th data-field="Prodotti" data-sortable="true" data-visible="false">Prodotti</th>
					<th data-field="action" data-width="30px" data-align="center" data-formatter="actionFormatter" data-switchable="false" data-events="actionEvents" data-width="30px"></th>
					
				</tr>
				
				</thead>
			</table>
			
			<div style="display: none" id="dialog-confirm"></div>
			
		</div>
	</body>
</html>