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
		<title>VadoIO 2015</title>	
	</head>
	<body>
		<?php
			require_once("scripts/php/header_footer.php");
			require_once("scripts/php/tools.php");
			getHeaderNoCart();
			$db=new ManageDB();
			$db->connect();
			$Password=$db->escape($_POST['InputPassword3']);
			$result=$db->query('update utenti set Password="'.$Password.'" where Username="'.$_SESSION['Username'].'";');
			$db->close();
		?>
		<p>Salvataggio.....</p>
		<script>
    		window.location.href="informazioni.php";
    	</script>
	</body>
</html>