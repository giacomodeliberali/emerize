<html>
	<head>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1" >
		<meta name="description" content="Devi fare la spesa ma non hai tempo? Hai una bolletta da pagare ma devi andare via? Sei nel posto giusto!">
		<meta name="keywords" content="spesa, domicilio, spesa domicilio, spesa a domicilio, servizi, servizi a domicilio, bollette, tempo">
		<meta name="author" content="De Liberali Giacomo, Antonucci Filippo">
		
		<link rel="stylesheet" type="text/css" href="../last/styles/bootstrap/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="../last/styles/bootstrap/bootstrap-theme.min.css" />
		<link rel="stylesheet" type="text/css" href="../last/styles/style.css" />
		<link rel="stylesheet" type="text/css" href="../last/styles/jquery/jquery-ui.css" />
		
		<title>Emerize</title>
	</head>
	
	<body>
		
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="../last/">Emerize - Docs</a>
				</div>
			</div>
		</nav>
		<div class="container">
			<div class="title">Documenazione</div>
			
			<?php listFolderFiles(getcwd()); ?>
		</div>
		
		<?php
		function listFolderFiles($dir){
			$ffs = scandir($dir);
			
			echo '<ol>';
			foreach($ffs as $ff){
				if($ff != '.' && $ff != '..' && $ff != basename(__FILE__)){
					echo '<li><a href="' . $ff . '">'.$ff;
					if(is_dir($dir.'/'.$ff)) listFolderFiles($dir.'/'.$ff);
					echo '</a></li>';
				}
			}
			echo '</ol>';
		}

		

		?>	
	</body>
	
<html>

