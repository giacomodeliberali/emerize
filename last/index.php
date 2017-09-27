<?php
	if(session_id() == '' || !isset($_SESSION)) { 
		session_start();
	}
	
	if(isset($_GET['logout'])){
		if($_GET['logout'] == "true"){
			session_unset();
			session_commit();
		}
	}
	
	if(isset($_SESSION['Username'])){
		if($_SESSION['Username'] != "" && isset($_SESSION['marketName'])){
			header("location: home.php");
		}else if($_SESSION['Username'] != "" && !isset($_SESSION['marketName'])){
			if($_SESSION['tipologiaUtente']=="000"){ //admin
				header("Location: admin.php");
			}else{
				header("Location: selezionaOperazione.php");
			}
		}
	}
	
?>
<html>
	<head>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1" >
		
		<meta name="description" content="Devi fare la spesa ma non hai tempo? Hai una bolletta da pagare ma devi andare via? Sei nel posto giusto!">
		<meta name="keywords" content="spesa, domicilio, spesa domicilio, spesa a domicilio, servizi, servizi a domicilio, bollette, tempo">
		<meta name="author" content="De Liberali Giacomo, Antonucci Filippo">
		
		<title>Emerize - Servizi a domicilio</title>
		
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap-theme.min.css" />
		<link rel="stylesheet" type="text/css" href="styles/style.css" />
		<link rel="stylesheet" type="text/css" href="styles/jquery/jquery-ui.css" />
		
		
	</head>
	<body>
	
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php">Emerize - Servizi a domicilio</a>
				</div>
			</div>
		</nav>
	
		<center>
			<div class="container container-login">				
					<div class="card card-container">
						<img id="profile-img" class="profile-img-card" src="/public/images/user.jpg" />
						<p id="profile-name" class="profile-name-card"></p>
						<form id="loginForm" class="form-signin">
							<span id="reauth-email" class="reauth-email"></span>
							<input type="email" name="Username" class="form-control" placeholder="Indirizzo Email" value="" required>
							<input type="password" id="Password" name="Password" class="form-control" placeholder="Password" VALUE="" required>
							<button id="loginButton" class="btn btn-sm btn-info" type="button">Entra</button>
							<div class="animation_image" style="display:none" align="center"><img src="/public/images/ajax-loader.gif"></div>
						</form> 
						Non hai un account? 
						<a href="registrazione.php" class="forgot-password">
							<u>Registrati</u>
						</a>
					</div>
				
			
			</div>
		</center>
		
		<!-- scipts loading -->
			<script type="text/javascript" src="scripts/js/jquery/jquery-1.11.2.min.js"></script>
			<script type="text/javascript" src="scripts/js/jquery/jquery-ui.min.js"></script>
			<script type="text/javascript" src="scripts/js/bootstrap/bootstrap.min.js"></script>
			<script>
				$("html").keyup(function(event){
					if(event.keyCode == 13){ //tasto enter (ivio)
						$("#loginButton").click();
					}
				});
				
				$("#loginButton").click(function(){
					self = $(this);
					$(".animation_image").show();
					
					$.post( "scripts/php/ajaxCheckLogin.php", $( "#loginForm" ).serialize(), function(result, status){
						if(result == 'not authorized'){
								wrong(self);
								setTimeout(right, 1000, self);
						}else{
							document.write(result);
						}
						$(".animation_image").hide();
					});
				});
				
				function wrong(self){
					$("#Password").val("");
					$(self).html("Login errato");
					$(self).removeClass("btn-info");
					$(self).addClass("btn-danger");
					
				}
	
				function right(self){
					$(self).html("Entra");
					$(self).removeClass("btn-danger");
					$(self).addClass("btn-info");
				}
	
			</script>
		<!-- end scripts -->
	</body>
</html>