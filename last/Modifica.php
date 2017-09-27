<?php
	require_once("security.php");
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
		<title>Emerize - Modifica account</title>	
	</head>
	<body>
		<?php
			require_once("scripts/php/header_footer.php");
			require_once("scripts/php/tools.php");
			getHeaderNoCart();
		?>
		<div class="container">
			<div class="title">Modifica account</div>
			<form>
			  <div class="form-group">
			    <label for="InputUsername">Username</label>
			    <input type="Username" class="form-control" id="InputUsername" placeholder="Username">
			  </div>
			  <div class="form-group">
			    <label for="InputPassword">Password</label>
			    <input type="Password" class="form-control" id="InputPassword" placeholder="Password">
			  </div>
			  <div class="form-group">
			    <label for="InputPassword1">Conferma password</label>
			    <input type="Password" class="form-control" id="InputPassword1" placeholder="Password">
			  </div>
			  <button type="submit" class="btn btn-default">Submit</button>
			</form>
		</div>
	</body>
</html>