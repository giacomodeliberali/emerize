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
				<script type="text/javascript" src="scripts/js/jquery/jquery-ui-slider-pips.js"></script>
		<link rel="stylesheet" type="text/css" href="styles/jquery/jquery-ui-slider-pips.css" />
		<script src="scripts/js/md5.js"></script>
		<link rel="stylesheet" href="styles/bootstrap/bootstrap-table.css">
		<script src="scripts/js/bootstrap/bootstrap-table.js"></script>
		<script src="scripts/js/bootstrap/bootstrap-table-it-IT.js"></script>
		<script src="scripts/js/bootstrap/bootstrap-table-mobile.js"></script>
		<script src="scripts/js/config.js"></script>
		<script src="scripts/js/tools.js"></script>
		<title>VadoIO 2015</title>	
	</head>
	<body>
		<?php
			require_once("scripts/php/header_footer.php");
			require_once("scripts/php/tools.php");
			require_once("scripts/php/ManageDB.php");
			getHeaderNoCart();
		?>


		<div class="container">
				<?php 
					if(isset($_GET['eseguiti']) && $_GET['eseguiti']=="true"){
						$var=1;
					}else if(isset($_GET['getnew']) && $_GET['getnew']=="true"){
						$var=2;
					} else {
						$var=0;
					}

					$db=new ManageDB();
					$db->connect();
					if($var==2) {
						$query='select * from ordini o 
						inner join fattorini f on o.Codice_Ordine=f.Scontrino 
						inner join utenti u on u.Codice_fiscale=f.Fattorino
						where u.Username="'.$_SESSION['Username'].'" and o.Stato=0;';
						$result=$db->query($query);
						
						if($db->affectedRows()==0) {
							include("templateNewAssignments.html");
						} else {
							echo getActualAssignment();
						}
					} else {
						include("templateDoneAssignments.html");
					}
				?>
	    	</div>
	    </div>
	</body>
</html>