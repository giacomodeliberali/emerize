<?php
	if(session_id() == '' || !isset($_SESSION)) { 
		session_start();
	}
	
	require_once("tools.php");
	
	function getHeader()
	{
		$html = '
			<!----------------- INIZIO HEADER ----------------->
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						
						<!----------------- BOTTONE DI APERTURA MENU HEADER ----------------->
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" id="buttonHeaderCollapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="index.php">Emerize</a>
					</div>
					
					<center>
						<ul class="nav navbar-nav navbar-right">
								<li>
								  <a id="opener" role="button" aria-expanded="false" data-toggle="modal"><span class="badge" id="appendCartSize">0</span> Carrello<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></a>
								</li>
						</ul>
					</center>
					
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav">
						
							<!----------------- VOCI MENU HEADER ----------------->	
							<li class="dropdown dropDownProducts">
							  <a href="#" class="dropdown-toggle aDropDownProducts" data-toggle="dropdown" role="button" aria-expanded="false">Prodotti<span class="caret"></span></a>
							  <ul class="dropdown-menu" role="menu" style="overflow-y: scroll">
								<li><a id="currentMarket">' . $_SESSION['marketName'] . '</a></li>
								<li class="divider"></li>
								' . getCategorie($_SESSION['codiceNegozio']) . '
							  </ul>
							</li>
							
							<li class="dropdown">
							 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">' . $_SESSION['Username'] . ' <span class="glyphicon glyphicon-user"></span></a>
							  <ul class="dropdown-menu" role="menu">
								<li><a href="informazioni.php">Informazioni profilo</a></li>
								<li class="divider"></li>
								<li><a href="index.php?logout=true">Esci</a></li>
							  </ul>
							</li>' .
							
							(substr($_SESSION['tipologiaUtente'], 0, 1) == "1" ? '
							<li class="dropdown">
							 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Negozio <span class="glyphicon glyphicon-cog"></span></a>
							  <ul class="dropdown-menu" role="menu">
								<li><a href="upload_form.php?operation=add">Aggiungi prodotto</a></li>
								<li><a href="upload_form.php?operation=delete">Rimuovi prodotto</a></li>
								<li><a href="upload_form.php?operation=update">Aggiorna prodotto</a></li>
							  </ul>
							</li>
							' : '') .
							
							(substr($_SESSION['tipologiaUtente'], 1, 1) == "1" ? '
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Incarichi <span class="glyphicon glyphicon-list-alt"></span></a>
								<ul class="dropdown-menu" role="menu">
								<li><a href="incarichi.php?getnew=true">Nuovo incarico</a></li>
								<li><a href="incarichi.php?eseguiti=true">Eseguiti</a></li>
								</ul>
							</li>
							' : '') .
							
							'<li class="dropdown">
							  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a>
							  <ul class="dropdown-menu" role="menu">
								<li><a href="seleziona_negozio.php">Cambia negozio</a></li>
								<li><a href="#">Chi siamo</a></li>
								<li><a href="#">Domande frequenti (FAQ)</a></li>
								<li><a href="AreaUtenti.php">Area utenti</a></li>
								<li><a href="segnalazioni.php">Segnalazioni</a></li>
								<li class="divider"></li>
								<li><a href="IlProgetto.php">Il Progetto</a></li>
							  </ul>
							</li>
						</ul>	
						
							
							
						
					</div>
				</div>
			</nav>
			<!----------------- FINE HEADER ----------------->
		';
		echo $html;
	}
	
	function getHeaderNoCart()
	{
		$html = '
			<!----------------- INIZIO HEADER ----------------->
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
					
		
						<!----------------- BOTTONE DI APERTURA MENU HEADER ----------------->
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						
						<a class="navbar-brand hidden-xs" href="index.php">Emerize</a>
						<a class="navbar-brand visible-xs" onclick="javascript:history.back()" role="button" aria-expanded="false"><span class="glyphicon glyphicon-arrow-left"></span> Indietro</a>
					</div>
					
					<center>
						<ul class="nav navbar-nav navbar-right hidden-xs">
								<li>
								  <a onclick="javascript:history.back()" id="opener" role="button" aria-expanded="false" data-toggle="modal"><span class="glyphicon glyphicon-arrow-left"></span> Indietro</a>
								</li>
						</ul>
					</center>
					
				
					
					
				
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav">
						
							<!----------------- VOCI MENU HEADER ----------------->
							
							
							<!--<li class="dropdown dropDownProducts">
							  <a href="#" class="dropdown-toggle aDropDownProducts" data-toggle="dropdown" role="button" aria-expanded="false">Prodotti<span class="caret"></span></a>
							  <ul class="dropdown-menu" role="menu" style="overflow-y: scroll">
								<li><a id="currentMarket">' . $_SESSION['marketName'] . '</a></li>
								<li class="divider"></li>
								' . getCategorie($_SESSION["codiceNegozio"]) . '
							  </ul>
							</li>-->
							
							<li class="dropdown">
							 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">' . $_SESSION['Username'] . ' <span class="glyphicon glyphicon-user"></span></a>
							  <ul class="dropdown-menu" role="menu">
								<li><a href="informazioni.php">Informazioni profilo</a></li>
								<li class="divider"></li>
								<li><a href="index.php?logout=true">Esci</a></li>
							  </ul>
							</li>
							
							' . (substr($_SESSION['tipologiaUtente'], 0, 1) == "1" ? '
							<li class="dropdown">
							 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Negozio <span class="glyphicon glyphicon-cog"></span></a>
							  <ul class="dropdown-menu" role="menu">
								<li><a href="upload_form.php?operation=add">Aggiungi prodotto</a></li>
								<li><a href="upload_form.php?operation=delete">Rimuovi prodotto</a></li>
								<li><a href="upload_form.php?operation=update">Aggiorna prodotto</a></li>
							  </ul>
							</li>
							' : '') .
							
							(substr($_SESSION['tipologiaUtente'], 1, 1) == "1" ? '
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Incarichi <span class="glyphicon glyphicon-list-alt"></span></a>
								<ul class="dropdown-menu" role="menu">
								<li><a href="incarichi.php?getnew=true">Nuovo incarico</a></li>
								<li><a href="incarichi.php?eseguiti=true">Eseguiti</a></li>
								</ul>
							</li>
							' : '') .
							
							($_SESSION['tipologiaUtente'] == "000" ? '
								
								  <li class="dropdown">
							  		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Admin Power <span class="glyphicon glyphicon-king" aria-hidden="true"></span></a>
							  			<ul class="dropdown-menu" role="menu">
											<li><a href="listaUtenti.php">Lista utenti</a></li>
											<li><a href="listaNegozi.php">Lista negozi</a></li>
											<li><a href="listaOrdini.php">Lista ordini</a></li>
											<li><a href="listaProdotti.php">Lista prodotti</a></li>
											<li><a href="listaSegnalazioni.php">Lista segnalazioni</a></li>
											<li><a href="statistiche.php">Statistiche</a></li>
											<li><a href="nuovoprodotto.php">Aggiungi prodotto</a></li>
							  			</ul>
									</li>
								
							 ' : '') .
							
							'<li class="dropdown">
							  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a>
							  <ul class="dropdown-menu" role="menu">
								<li><a href="seleziona_negozio.php">Cambia negozio</a></li>
								<li><a href="#">Chi siamo</a></li>
								<li><a href="#">Domande frequenti (FAQ)</a></li>
								<li><a href="AreaUtenti.php">Area utenti</a></li>
								<li><a href="segnalazioni.php">Segnalazioni</a></li>
								<li class="divider"></li>
								<li><a href="IlProgetto.php">Il Progetto</a></li>
							  </ul>
							</li>
						</ul>	
						
						
							
							
						
					</div>
				</div>
			</nav>
			<!----------------- FINE HEADER ----------------->

		';
		echo $html;
	}
?>