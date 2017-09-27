<html>
    <head>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1" >
		<meta charset="utf-8" />

		<link rel="stylesheet" type="text/css" href="styles/jquery/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap-theme.min.css" />
		<link rel="stylesheet" type="text/css" href="styles/style.css" />
        <title><?php echo ($sessionExpired=="true"?"Session expired":"Not authorized") ?></title>
    </head>
    
    <body>
        <script>
			expired = <?php echo ($sessionExpired=="true"?"true":"false"); ?>;
				
			
		</script>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php">Emerize - Servizi a domicilio</a>
				</div>
			</div>
		</nav>
        
        <div class="container">
            <div class="title" id="title">
				
			</div>
			
            <p id="message">
                
            </p>
            <p id="message1">
                
            </p>
        </div>
        
        <script type="text/javascript" src="scripts/js/jquery/jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="scripts/js/jquery/jquery-ui.min.js"></script>
		<script type="text/javascript" src="scripts/js/bootstrap/bootstrap.min.js"></script>
		<script type="text/javascript" src="scripts/js/jquery/jquery.mobile.custom.min.js"></script>
        <script>
			
			var noAuthTitle = "Non autorizzato.";
			var noAuthMessage = "Non disponi delle autorizzazioni sufficienti alla visualizzazione di questa pagina.";
			var noAuthMessage1 = 'Verrai reindirizzato alla <a href="index.php?logout=true">pagina principale</a> in <b><span id="sec">10</span></b> secondi.';
			
			
			var sessionExpiredTitle = "Sessione scaduta.";
			var sessionExpiredMessage = "La sessione per questa navigazione è scaduta. Rieffettuare nuovamente il login.";
			var sessionExpiredMessage1 = 'Effettua nuovamente il login per riprendere a navigare. Verrai reindirizzato alla <a href="index.php?logout=true">pagina di login</a> in 	<b><span id="sec">10</span></b> secondi.';
			
			var changedUsernameTitle = "Username modificato";
			var changedUsernameMessage = "Username modificato. Effettuare nuovamente il login.";
			var changedUsernameMessage1 = 'Verrai reindirizzato alla <a href="index.php?logout=true">pagina principale</a> in <b><span id="sec">10</span></b> secondi.';
			
			if (expired) {
				$("#title").html(sessionExpiredTitle);
				$("#message").html(sessionExpiredMessage);
				$("#message1").html(sessionExpiredMessage1);
				
			}
			<?php 
				if(isset($_GET['changedUsername'])){
					echo '
						else if(' . $_GET['changedUsername'] .'){
							$("#title").html(changedUsernameTitle);
							$("#message").html(changedUsernameMessage);
							$("#message1").html(changedUsernameMessage1);
						}
					';
				}
			?>
			else{
				$("#title").html(noAuthTitle);
				$("#message").html(noAuthMessage);
				$("#message1").html(noAuthMessage1);
			}
			
            setInterval(function(){
                    var value = $("#sec").html();
                    
                    if (value<=1) {
                        location.href = "index.php?logout=true";
                    }
                    
                    $("#sec").html(value - 1);
            }, 1000);
        </script>
        
    </body>
</html>