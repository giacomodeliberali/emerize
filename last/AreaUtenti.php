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
		<script src="scripts/js/md5.js"></script>
		
		<title>Emerize - Sezione utenti</title>	
	</head>
	<body onLoad="UpdateTimer();"> 
		<?php
			require_once("scripts/php/header_footer.php");
			require_once("scripts/php/tools.php");
			require_once("scripts/php/ManageDB.php");
			getHeaderNoCart();
		?>
		<div class="container">
			<div class="title">Area utenti</div><br>
			<form id="form" name="form" method="POST">
				<div class="container1">
					<div class="message-wrap">
					
						<div id="boxMessage" class="msg-wrap"></div>
						
						<div class="send-wrap">
							<textarea id="Messaggio" class="form-control" rows="3" placeholder="Scrivi un messaggio..."></textarea>
						</div>
						
						<button type="button" class="btn btn-default" onclick="Controllo()" class="invia" class="btn btn-default btn-sm dropdown-toggle" width="400px" data-toggle="dropdown">Invia messaggio</button>
					</div>
				
			</form>
			</div>
		</div>

		<script>
			function Message() {
				$.post("scripts/php/ajaxMessage.php", function(result, status){
					document.getElementById("boxMessage").innerHTML=result;
				});
			}
			
			function UpdateTimer() {
				Message();    
				timerID = setTimeout("UpdateTimer()", 2000); 
			}
			
			function Controllo() {
				if(document.getElementById("Messaggio").value=="") {
					alert("Errore, il messaggio è vuoto")
				} else {
					$.post("scripts/php/updateMessage.php?q="+document.getElementById("Messaggio").value, function(result, status){

					});
					document.getElementById("Messaggio").value="";
					$.post("scripts/php/ajaxMessage.php", function(result, status){
						document.getElementById("boxMessage").innerHTML=result;
					});
				}
			}
		</script>
	</body>
</html>