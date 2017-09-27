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

		<title>Emerize</title>	
	</head>
	<body>
		<?php
			require_once("scripts/php/header_footer.php");
			require_once("scripts/php/tools.php");
			getHeaderNoCart();

			$db=new ManageDB();
			$db->connect();

			$Prova;
			
			$Username= $db->escape($_POST['InputUsername']);
			if($Username==$_SESSION['Username']) {
				$Prova=1;
			} else {
				$Prova=0;
			}
			
			$Nome= $db->escape($_POST['InputName']);
			$Cognome= $db->escape($_POST['InputSurname']);
			$Nascita= $db->escape($_POST['InputBirthday']);
			$Telefono= $db->escape($_POST['InputTelephone']);
			$CAP= $db->escape($_POST['InputCAP']);
			$Comune= $db->escape($_POST['InputMunicipality']);
			$Provincia= $db->escape($_POST['InputProvince']);
			$Regione= $db->escape($_POST['InputRegion']);
			$Via= $db->escape($_POST['InputStreet']);

			$result=$db->query('update utenti set Username="'.$Username.'", Nome="'.$Nome.'", Cognome="'.$Cognome.'", Data_nascita="'.$Nascita.'", Telefono="'.$Telefono.'", CAP="'.$CAP.'", Comune="'.$Comune.'", Provincia="'.$Provincia.'", Regione="'.$Regione.'", Indirizzo="'.$Via.'" where Username="'.$_SESSION['Username'].'";');

			$db->close();
		?>

	<p>Salvataggio.....</p>

		<script>
            var variabile_js=0;
			variabile_js = <?php echo($Prova);?> ;
			if(variabile_js==1) {
				window.location.href="informazioni.php";
			} else {
				if(variabile_js==0) {
            		window.location.href="templateNoAuth.php?changedUsername=true";
            	}
            }
        </script>
	</body>
</html>