<?php
	if(session_id() == '' || !isset($_SESSION)) { 
		session_start();
	}
	

	require_once("scripts/php/tools.php");
?>
<html>
	<head>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1" >
		<meta charset="utf-8" />
		<script type="text/javascript" src="scripts/js/jquery/jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="scripts/js/jquery/jquery-ui.min.js"></script>
		<script type="text/javascript" src="scripts/js/jquery/datepicker-it.js"></script>
		<script src="scripts/js/md5.js"></script>
		<script src="scripts/js/tools.js"></script>
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap-theme.min.css" />
		<link rel="stylesheet" type="text/css" href="styles/style.css" />
		<link rel="stylesheet" type="text/css" href="styles/jquery/jquery-ui.css" />
		<script type="text/javascript" src="scripts/js/bootstrap/bootstrap.min.js"></script>
		<script type="text/javascript" src="scripts/js/bootstrap/bootstrap-select.js"></script>
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap-select.css" />
		<title>Emerize - Registrazione</title>
	</head>
	<body>
		<script>
		  $(function() {
			$('input').attr('autocomplete','off');
		  });
		</script>
	
	
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php">Emerize - Nuovo account</a>
				</div>
			</div>
		</nav>
		
		<center>
			<div class="container">

									<div class="container container-login" >			
										<div class="card card-container" id="container-login">
										
											
											<img id="profile-img" class="profile-img-card" src="/public/images/user.jpg" value="/public/images/user.jpg" style="margin-top: 10px; cursor: pointer" />
											<p id="profile-name" class="profile-name-card">Nuovo account</p>
											<form id="regForm" class="form-signin" method="POST" enctype="multipart/form-data" style="text-align:left" >
												<input id="type" type="hidden" name="type" value="">
												<input id="immagine" type="file" name="immagine" style="display:none">
												<center><small>Seleziona le tipologie di utente che intendi registrare.</small></center>
												<div class="animation_image" style="display:none" align="center"><img src="/public/images/ajax-loader.gif"></div>
												
												<select id="tipo" class="selectpicker" multiple title='Nessuna tipologia selezionata'>
													<option>Utente</option>
													<option>Fattorino</option>
													<option>Negozio</option>
												</select>
												
												<div id="regContainer" style="display: none">
													
													<div id="userSpace"></div>
													
													<div id="marketSpace"></div>
													
													<div id="accountSpace">
														<span id="usernameSpan" class="label label-default">Email</span>
														<input id="username" type="text" value="" name="username" placeholder="Email" class="form-control" />
														<div id="usernameErrorMessage" class="alert alert-danger"  role="alert" style="display: none">Email gi&agrave; in uso</div>
														
														<span id="passwordSpan" class="label label-default">Password</span>
														<input id="password" type="password" value="" name="password" placeholder="Password" class="form-control" />
														<div id="passwordTooShort" class="alert alert-danger"  role="alert" style="display: none">Lunghezza minima 8 caratteri</div>
	
														<span id="passwordRepeatSpan" class="label label-default">Ripeti password</span>
														<input id="passwordRepeat" type="password" value="" name="passwordRepeat" placeholder="Ripeti password" class="form-control" />
														<div id="passwordErrorMessage" class="alert alert-danger"  role="alert" style="display: none">Le due password non corrispondono</div>
																								
														<input id="submit" type="submit" value="Registra account" class="btn btn-success" style="float: right" />
														<div id="uploadingAccount" style="display:none" align="center"><img src="/public/images/ajax-loader.gif"></div>
													</div>
													
												</div>
											</form>

										</div>
								</div>
				</div>
			
		</center>
		<script>
			
			$('#tipo').selectpicker({
				style: 'btn-info'
			});
			negozio = fattorino = user = false;
			$('#tipo').on("change", function(){
				
				negozio = fattorino = user = false;
				$('#tipo > option:selected').each(function(){
					if(this.text == "Utente"){
						user = true;			
					}
					if (this.text == "Fattorino") {
						fattorino = true;
					}
					if (this.text == "Negozio") {
						user = true;
						negozio = true;
						//$('.selectpicker').selectpicker('val', ['Utente','Negozio']);
					}
					
				});		
				loadSections(negozio, fattorino, user);
				updateType();
			});
			
			function loadSections(n, f, u){
				updateType();
				$("#regContainer").slideUp(400, function(){
					if (n || f || u) {
						//alert("carico user");
						$("#userSpace").load("userPlus.php");
						if (n) {
							//alert("carico negozio");
							$("#marketSpace").load("marketPlus.php");
						}else{
							$("#marketSpace").html("");
						}
					}else{
						$("#regContainer").slideUp(400, function(){
							$("#userSpace").html("");
							$("#marketSpace").html("");
							$("#accountSpace").hide();
						});
					}
					$("#accountSpace").show();
					$("#regContainer").slideDown();
				});
			}
			
			function updateType(){
				msg = "";
				msg += (negozio ? "1" : "0");
				msg += (fattorino ? "1" : "0");
				msg += (user ? "1" : "0");
				$("#type").val(msg);
			}
	
		$("#profile-img").on("click", function(){
			$("#immagine").click();
		});		

		$("#immagine").on("change", function(e){
			alert("TODO");
		});
		
		</script>
		<script type="text/javascript" src="scripts/js/checkInputRegistration.js"></script>
	</body>
	
</html>