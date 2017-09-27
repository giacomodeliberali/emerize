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
		
		<title>Emerize - Lista Prodotti</title>
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
        	<div id="ProdottiToolbar" class="btn-group">
				<div class="title">Lista prodotti</div>
			</div>
			<table 	data-toggle="table" id="prodotti" data-url="scripts/php/listProducts.php" data-pagination="true"
					data-search="true"
					data-show-columns="true"
					data-toolbar="#ProdottiToolbar"
					data-height="500"
					data-pagination="true"
					data-page-list="[10, 20, 50, 100, 200]"
					data-show-toggle="true"
					data-show-refresh="true"
					class="table table-striped table-condensed">
				<thead>
				<tr>
					<th data-formatter="runningFormatter" data-visible="false" data-width="30px">Index</th>
					<th data-field="Codice_prodotto" data-sortable="true">Codice prodotto</th>
					<th data-field="Nome" data-sortable="true">Nome</th>
					<th data-field="Marca" data-sortable="true">Marca</th>
					<th data-field="Descrizione" data-sortable="true" data-visible="false">Descrizione</th>
					<th data-field="Peso" data-sortable="true" data-visible="false">Peso</th>
					<th data-field="Tipologia" data-sortable="true" data-visible="false">Tipologia</th>
					<th data-field="Sottotipologia" data-sortable="true">Sottotipologia</th>
					

				</tr>
				
				</thead>
			</table>
			
			<div style="display: none" id="dialog-confirm"></div>
			
		</div>
	</body>
</html>

