<html>
	<head>
		<meta name="description" content="Devi fare la spesa ma non hai tempo? Hai una bolletta da pagare ma devi andare via? Sei nel posto giusto!">
		<meta name="keywords" content="spesa, domicilio, spesa domicilio, spesa a domicilio, servizi, servizi a domicilio, bollette, tempo">
		<meta name="author" content="De Liberali Giacomo, Antonucci Filippo">
		
		<title>Emerize</title>
	</head>
<html>

<?php
	if(isset($_GET["show"]) && ($_GET["show"]=="true" || $_GET["show"]=="show")){
		$path = '.'; // '.' for current
		foreach (new DirectoryIterator($path) as $file) {
			if ($file->isDot()) continue;
		
			if ($file->isDir()) {
				echo "<a href='" . $file->getFilename() . "'>" . $file->getFilename() . '</><br>';
			}
		}
	}else{
		header("location: last/");
	}
?>