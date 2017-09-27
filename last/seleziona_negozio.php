<?php
	require_once("security.php");
	if(isset($_SESSION['tipologiaUtente']) && $_SESSION['tipologiaUtente']=="010"){
		header("Location: incarichi.php?getnew=true");
	}
	
?>
<html>
	<head>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1" >
		<meta charset="utf-8" />

		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap-theme.min.css" />
		<link rel="stylesheet" type="text/css" href="styles/style.css" />
		<link rel="stylesheet" type="text/css" href="styles/jquery/jquery-ui.css" />

		<title>Emerize - Seleziona negozio</title>	
	</head>
	<body>
		<?php
			require_once("scripts/php/header_footer.php");
			require_once("scripts/php/tools.php");
			//getHeaderNoCart();
		?>
		
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php">Emerize - Servizi a domicilio</a>
				</div>
				<div class="collapse navbar-collapse" style="float: right">
					 <ul class="nav navbar-nav">
					   <li><a href="index.php?logout=true">Esci</a></li>
					 </ul>
				</div>
			</div>
		</nav>

		<center>
			<div class="title">Seleziona il supermercato</div>
			<small>Scegli il supermercato nel quale devi affettuare la spesa.</small>
			<div class="container container-login">			
					<div class="card card-container">
						<img id="profile-img" class="profile-img-card" src="/public/images/usersUpload/<?php echo $_SESSION['Image']; ?>" />
						<p id="profile-name" class="profile-name-card"><?php echo $_SESSION['Username']; ?></p>
						
							<input id="cap" type="text" value="" name="cap" placeholder="CAP o Citt&agrave;" class="form-control" autocomplete="off"/>
							<div class="animation_image" style="display:none" align="center"><img src="/public/images/ajax-loader.gif"></div>
						

					</div>
			</div>
			
			<div id="results" class="container">
				<ul class="list-group"><li class="list-group-item">Immettere un CAP o il nome di un comune</li></ul>
			</div>
			
		</center>
		
		
		<script type="text/javascript" src="scripts/js/jquery/jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="scripts/js/jquery/jquery-ui.min.js"></script>
		<script type="text/javascript" src="scripts/js/bootstrap/bootstrap.min.js"></script>
		<script type="text/javascript" src="scripts/js/tools.js"></script>
		<script>
			$("#cap").bind("keyup", function(){
				if($(this).val().length>=3){
					$(".animation_image").show();
					$.post( "scripts/php/ajaxNegozi.php",{CAP:$("#cap").val()}, function(result, status){
						$("#results").html(result);
						$(".animation_image").hide();
						loadJQ();
					});
				}else{
					$("#results").html('<ul class="list-group"><li class="list-group-item">Immettere un CAP o il nome di un comune</li></ul>');
				}
			});
			
			function loadJQ(){
				$('a[href=""]').click(function(event){
					event.preventDefault();
					post("home.php", {negozio: $(this).attr("negozio"), nome: $(this).attr("nome")} );
				});  
			}
		</script>
	</body>
</html>