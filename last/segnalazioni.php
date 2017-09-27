<?php
	require_once("securityAdmin.php");
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
				<script type="text/javascript" src="scripts/js/bootstrap/bootstrap-select.js"></script>
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap-select.css" />
		<script src="scripts/js/md5.js"></script>
		
		<title>Emerize</title>	
	</head>
	<body>
		<?php
			require_once("scripts/php/header_footer.php");
			require_once("scripts/php/tools.php");
			getHeaderNoCart();
		?>
		<script>
			function Controllo() {
		    	if((document.form.Oggetto.value && document.form.Testo.value)=="") {
                	alert("Compilare tutti i campi");
            	} else {
            			/*$.post("scripts/php/updateSegnalazioni.php?Oggetto="+document.form.Oggetto.value+"&Tipologia="+document.form.Tipologia.options[document.form.Tipologia.options.selectedIndex].value+"&Testo="+document.form.Testo.value, function(result, status){
            				alert(result);
						});*/
					document.form.submit();
            	}
			}
		</script>
		
		<div class="container">
			<div class="title">Segnalazioni</div><br>
			<form id="form" name="form" action="scripts/php/updateSegnalazioni.php" method="POST">
					<label for="#Oggetto">Oggetto:</label>
					<input type="text" id="Oggetto" name="Oggetto" class="form-control" placeholder="Titolo segnalazione"/>
				
				<div class="tipologia" style="margin-top: 20px">
					<div class="btn-group">
						<label for="#Tipologia">Tipologia:</label>
						<?php getNotificationTologies() ?>
					</div>
				</div>
				<div class="testo">
					<textarea cols="40" rows="4" id="Testo" name="Testo" class="form-control" placeholder="Descrizione segnalazione...." style="margin-top: 20px;"></textarea>
				</div>
				<button onclick="Controllo()" class="btn btn-info" style="float: rightl">Invia richiesta</button>
			</form>
		</div>
	</body>
</html>