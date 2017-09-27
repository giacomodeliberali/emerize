<?php
	require_once("security.php");
	
?>
<html>
	<head>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1" >
		<meta charset="utf-8" />

		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap-theme.min.css" />
		<link rel="stylesheet" type="text/css" href="styles/style.css" />
		<link rel="stylesheet" type="text/css" href="styles/jquery/jquery-ui.css" />

		<title>Emerize - Seleziona Operazione</title>
        
        <style>
            .alert{
                max-width: 400px;
                min-height: 60px;
                cursor: pointer;
            }
            span.label{
				font-size: 60%;
			}
			
            .alert-info:hover{
                border: 2px dashed #9acfea;
            }

            .alert-danger:hover{
                border: 2px dashed #dca7a7;
            }
            .alert-success:hover{
                border: 2px dashed #b2dba1;	
            }
			.table{
				margin-bottom: 0;
			}
			td{
				border-top: 0px !important;
				padding: 2px !important;
			}
        </style>
        
	</head>
	<body>
        
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

			
        <div class="container">
            <center>
                <div class="title">Seleziona il servizio</div>
                <small>Scegli il servizio di cui necessiti</small>
                <hr>
                


				<?php
					if(substr($_SESSION['tipologiaUtente'], 2, 1) == "1"){
						echo '
							<div id="spesa" class="alert alert-success" data-href="seleziona_negozio.php" data-title="Chiedi che un fattorino faccia la spesa per te nel tuo negozio preferito e che te la consegni in data concordata!<small style=\'font-size: 50%\'><br>Prodotti acquistabili solo nei negozi convenzionati<small>">
									<table class="table">
										<tr>
											<td>
												<span class="label label-success">Disponibile</span>
											</td>
										</tr>
										<tr style="text-align: center; color: #3c763d;">
											<td>
												<b>Spesa a domicilio</b>
											</td>
										</tr>
										<tr style="text-align: left">
											<td>
												<small id="spesaSpan" class="todo"></small>
											</td>
										</tr>
									</table>  
							</div>
						';	
					}
				
					if(substr($_SESSION['tipologiaUtente'], 1, 1) == "1"){
						echo '
						<div id="fattorino" class="alert alert-success" data-href="incarichi.php?getnew=true" data-title="Fai la spesa per qualcuno!">
								<table class="table">
									<tr>
										<td>
											<span class="label label-success">Disponibile</span>
										</td>
									</tr>
									<tr style="text-align: center; color: #3c763d;">
										<td>
											<b>Fai il fattorino</b>
										</td>
									</tr>
									<tr style="text-align: left">
										<td>
											<small id="fattorinoSpan" class="todo"></small>
										</td>
									</tr>
								</table>  
						</div>				
						';
					}
					
					if(substr($_SESSION['tipologiaUtente'], 0, 1) == "1"){
						echo '
						<div id="negozio" class="alert alert-success" data-href="negozio" data-title="Gestisci tutti i prodotti del supermercato che hai registrato">
								<table class="table">
									<tr>
										<td>
											<span class="label label-success">Disponibile</span>
										</td>
									</tr>
									<tr style="text-align: center; color: #3c763d;">
										<td>
											<b>Gestisci negozio</b>
										</td>
									</tr>
									<tr style="text-align: left">
										<td>
											<small id="negozioSpan" class="todo"></small>
										</td>
									</tr>
								</table>  
						</div>				
						';
					}
				?>
				<hr>
                <div id="gastronomia" class="alert alert-danger" data-href="#" data-title="Chiedi ad un fattorino che vada a ritirare la cena o dei prodotti al posto tuo. Dal fioraio alla pasticceria al McDonald's!">
						<table class="table">
							<tr>
								<td>
									<span class="label label-danger">Disponibile a breve</span>
								</td>
							</tr>
							<tr style="text-align: center; color: #a94442;">
								<td>
									<b>Servizi di consegna gastronomica</b>
								</td>
							</tr>
							<tr style="text-align: left">
								<td>
									<small id="gastronomiaSpan" class="todo"></small>
								</td>
							</tr>
						</table>  
                </div>
				
                <div id="coda" class="alert alert-danger" data-href="#" data-title="Chiedi ad un tuttofare che vada a fare la coda per un prodotto/servizio al posto tuo. Da pagare un bollettino in Posta alla fila per il nuovo iPhone">
						<table class="table">
							<tr>
								<td>
									<span class="label label-danger">Disponibile a breve</span>
								</td>
							</tr>
							<tr style="text-align: center; color: #a94442;">
								<td>
									<b>Servizi di attesa</b>
								</td>
							</tr>
							<tr style="text-align: left">
								<td>
									<small id="codaSpan" class="todo"></small>
								</td>
							</tr>
						</table>  
                </div>
                

            </center>
        </div>
			
		

		
		<script type="text/javascript" src="scripts/js/jquery/jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="scripts/js/jquery/jquery-ui.min.js"></script>
		<script type="text/javascript" src="scripts/js/bootstrap/bootstrap.min.js"></script>
		<script type="text/javascript" src="scripts/js/tools.js"></script>
        
        <script>
            $("#gastronomia, #coda, #spesa, #negozio, #fattorino").on("mouseover", function(){
                $("#" + $(this).attr("id") + "Span").html($(this).attr("data-title"));
            }).on("mouseout", function(){
                $("#" + $(this).attr("id") + "Span").html("");
            }).on("click", function(){
				if ($(this).attr("data-href")=="negozio") {
					var negozio = "<?php echo $_SESSION['personalMarket']; ?>";
					var marketName = "<?php echo $_SESSION['personalMarketName']; ?>";
					post("home.php", {negozio: negozio, nome: marketName} );
				}else{
					location.href= $(this).attr("data-href");
				}
			});
			
        </script>

	</body>
</html>