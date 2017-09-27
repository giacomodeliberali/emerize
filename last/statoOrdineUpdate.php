<?php
	require_once("security.php");
?>
<html>
	<head>
		<title>VadoIO 2015</title>	
	</head>
	<body>
		<?php
			require_once("scripts/php/header_footer.php");
			require_once("scripts/php/tools.php");
			
			$db=new ManageDB();
			$db->connect();
			
			$Ordine=$db->escape($_GET['codice']);

            $query="update ordini set Stato=1 where Codice_ordine='$Ordine'";
			$result=$db->query($query);
			$db->close();
		?>

	<p>Aggiornamento.....</p>

		<script>
           window.location.href="incarichi.php?getnew=true";
        </script>
	</body>
</html>