<?php
	if(session_id() == '' || !isset($_SESSION)) {
		session_start();
	}

	require_once("ManageDB.php");
	include("config.php");

	function getAllProducts(){
		$db = new ManageDB();
		$db->connect();

		$result = $db->query("SELECT prodotti.Codice_prodotto AS ID, prodotti.Nome AS Nome, prodotti.Marca AS Marca, prodotti.Descrizione AS Descrizione, prodottinegozio.Prezzo AS Prezzo, prodotti.Immagine AS Immagine from prodotti, prodottinegozio where prodotti.Codice_prodotto=prodottinegozio.Codice_prodotto");

		while($row = $result->fetch_array(MYSQL_ASSOC)){
			printProduct($row['Nome'], $row['Prezzo'], $row['ID'], $row['Descrizione'], $row['Immagine']);
		}

		$db->close();
	}

	function getTipologiaNegozio(){

		$html = "";

		$db = new ManageDB();
		$db->connect();

		$query = "SELECT * FROM tipologienegozi";
		$result = $db->query($query);

		while($row = $result->fetch_array(MYSQL_ASSOC)){
			$html .= "<option value='" . $row['Codice_tipologia_negozio'] . "'>" . $row['Tipo'] . "</option>";
			//$html .= "<li><a class=\"selectType\" id=\"" . $row['Codice_tipologia_negozio'] . "\">" . $row['Tipo'] . "</a></li>";
		}

		$db->close();

		return $html;
	}

	function getRegioni(){
		$html = "";

		$db = new ManageDB();
		$db->connect();
		$query = "select * from regioni";
		$result = $db->query($query);

		while($row = $result->fetch_array(MYSQL_ASSOC)){
			//$html .= "<li><a class='regione-item' id='" . $row['Codice_regione'] . "'>" . $row['Nome'] . "</a></li>";
			$html .= "<option value='" . $row['Codice_regione'] . "'>" . $row['Nome'] . "</option>";
		}

		$db->close();

		return $html;
	}

	function getTotalProducts($negozio){
		$db = new ManageDB();
		$db->connect();

		$query = "SELECT count(*) AS total FROM prodottinegozio WHERE Codice_negozio='$negozio'";

		$result = $db->query($query);
		$row = $result->fetch_array(MYSQL_ASSOC);

		$total_products = -1;

		if($row){
			$total_products = $row['total'];
		}

		$db->close();

		return $total_products;
	}

	function getCategorie($negozio){
		$html = "<li><a href='home.php'>Tutti i prodotti</a></li>";

		$db = new ManageDB();
		$db->connect();
		
		$query = '
			SELECT DISTINCT sottotipologie.Nome, sottotipologie.Codice_sottotipologia
			FROM prodottinegozio INNER JOIN prodotti on prodottinegozio.Codice_prodotto=prodotti.Codice_prodotto
			INNER JOIN tipologieprodotti on tipologieprodotti.Codice_tipologia_prodotto=prodotti.Tipologia
			INNER JOIN sottotipologie on sottotipologie.Codice_sottotipologia=prodotti.Sottotipologia
			WHERE prodottinegozio.Codice_negozio="' .  $negozio . '"
			ORDER BY sottotipologie.Nome ASC
		';
		$result = $db->query($query);

		while($row = $result->fetch_array(MYSQL_ASSOC)){
			$html .= "<li><a href='home.php?sottotipologia=" . $row['Codice_sottotipologia'] . "'>" . $row['Nome'] . "</a></li>";
		}

		$db->close();

		return $html;
	}
	
	function getFasce(){
		$html = '<select class="selectpicker" id="fasceOrarie" data-width="100%" >';
		$db = new ManageDB();
		$db->connect();

		$query = "SELECT Ora, Codice_fascia from fasce_orarie";
		$result = $db->query($query);

		while($row = $result->fetch_array(MYSQL_ASSOC)){
			$html .= "<option value='$row[Codice_fascia]'>$row[Ora]</option>";
		}
		
		$html .= "</select>";

		$db->close();
		
		echo '
			<script>
				$("#fasceOrarie").selectpicker();;
			</script>		
		';

		echo $html;
	}

	function getAllTipologie(){
		$html = '<select class="selectpicker" id="tipologie" name="tipologia" data-width="100%" >';
		$db = new ManageDB();
		$db->connect();

		$query = "SELECT * FROM tipologieprodotti";
		$result = $db->query($query);

		while($row = $result->fetch_array(MYSQL_ASSOC)){
			$html .= "<option value='$row[Codice_tipologia_prodotto]'>$row[Tipo]</option>";
		}
		
		$html .= "</select>";

		$db->close();
		
		echo '
			<script>
				$("#tipologie").selectpicker();;
			</script>		
		';

		echo $html;
	}
	
	function getAllSottotipologie(){
		$html = '<select class="selectpicker" id="sottotipologie" name="sottotipologia" data-width="100%" >';
		$db = new ManageDB();
		$db->connect();

		$query = "SELECT * FROM sottotipologie order by Codice_sottotipologia";
		$result = $db->query($query);

		while($row = $result->fetch_array(MYSQL_ASSOC)){
			$html .= "<option value='$row[Codice_sottotipologia]'>$row[Nome] ($row[Codice_sottotipologia])</option>";
		}
		
		$html .= "</select>";

		$db->close();
		
		echo '
			<script>
				$("#sottotipologie").selectpicker();;
			</script>		
		';

		echo $html;
	}	
	
	function printProduct($productTitle, $productPrice, $productID, $productDescription, $productImage, $brand){
		/*
		echo '
			<div class="row productContainer">
				<div class="col-xs-12 col-sm-12 productContent">

						<input type="hidden" value="' . $productID . '" name="productID"/>

						<div class="col-xs-6 col-sm-3 col-md-2 col-lg-2 productImage" >
							<img src="images/productsUpload/' . $productImage . '"/>
						</div>

						<div class="col-xs-6 col-sm-9 col-md-10 col-lg-10 productTitle">
							<p>' . $productTitle . '</p>
						</div>

						<div class="hidden-xs col-sm-6 col-md-8 col-lg-8 productDescription">
								<p>' . $productDescription . '</p>
						</div>

						<div class="col-xs-4 col-sm-3 col-md-2 col-lg-2 priceBox">
							<div><span id="price">' . $productPrice .'</span><span> &#8364;</span></div>
							<button type="button" class="btn btn-sm btn-info" onclick="addToCart(this)">Aggiungi</button>
							<span class="badge badgeProducts" id="badge' . $productID . '">0</span>
						</div>
				</div>
			</div>
			<script>
				cart.refreshGUI();
			</script>


		';
		*/
		echo '
			<div class="row productContent" id="' . $productID . '">
				<div class="col-xs-12" style="padding: 0">
					<div  class="col-xs-12 col-sm-6 col-md-4" style="text-align: center">
						<img src="/public/images/productsUpload/' . $productImage . '" style="max-width: 250px; max-height: 150px;" alt="Immagine del prodotto"/>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-8">
						<div class="row">
							<h3 id="productTitle"><span>' . $productTitle . '</span><small> ' . $brand . '</small></h3>
						</div>

						<div class="row">
							<p id="productDescription" class="text-justify">' . $productDescription . '</p>
						</div>

						<div class="row" style="width: 100%;">
							<div class="cart-opener" style="cursor: pointer; float: left" onclick="updateCartHighlight(this)">
								<span class="glyphicon glyphicon-shopping-cart"></span>
								<span id="badge' . $productID . '" class="badge badgeProducts">0</span>
							</div>
							<button style="float: right" class="btn btn-success buttonAdd" onclick="addToCart(this)">
								<span id="productPrice">' . $productPrice . '</span>
								<span style="padding-right: 10px;">&nbsp;&euro;</span>
								<div style="padding-left: 10px; border-left: 1px solid white; width: 100%; display: inline">Aggiungi</div>
							</button>
						</div>
					</div>				
				</div>
			</div>
			

		';
	}
	
	function printSimpleProduct($productTitle, $productPrice, $productID, $productDescription, $productImage, $brand, $tipologia, $sottotipologia, $operation){
		$class = "";
		$btnText = "";
		
		switch($operation){
			case "add":
				$class = "btn-success";
				$btnText = "Aggiungi";
				break;
			case "update":
				$class = "btn-info";
				$btnText = "Aggiorna";
				break;
			case "delete":
				$class = "btn-danger";
				$btnText = "Elimina";
				break;
			default:
				$class = "btn-success";
				$btnText = "Aggiorna";
				break;
		}
		$function = $operation . "ButtonClick(this)";
		echo '
			<div class="row productContent" id="' . $productID . '">
				<div class="col-xs-12" style="padding: 0">
					<div  class="col-xs-12 col-sm-6 col-md-4" style="text-align: center">
						<img src="/public/images/productsUpload/' . $productImage . '" style="max-width: 250px; max-height: 150px;" alt="Immagine del prodotto"/>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-8">
						<div class="row">
							<h3 id="productTitle"><span>' . $productTitle . '</span><small> ' . $brand . '</small></h3>
						</div>

						<div class="row">
							<p id="productDescription" class="text-justify">' . $productDescription . '</p>
						</div>

						<div class="row" style="width: 100%;">
							' . ($operation=="add" || $operation=="update" ? '
							<div class="input-group">
								<input id="price" type="text" class="form-control" placeholder="Prezzo" value="' . $productPrice . '">
								<span class="input-group-btn">
									<button style="width: 100px !important;" class="productButton btn ' . $class . ' buttonAdd" onclick="' . $function . '">
										' . $btnText . '
									</button>
								</span>
							</div>
							' : '
								<button style="width: 100px !important; float: right" class="productButton btn ' . $class . ' buttonAdd" onclick="' . $function . '">
									' . $btnText . '
								</button>
								
							' ) . '
							<div id="priceAlert" class="alert alert-danger" style="display: none; padding: 5px">Controlla il prezzo inserito</div>
						</div>
						
					</div>				
				</div>
				
				<span style="display: none" nome="tipologia">' . $tipologia . '</span>
				<span style="display: none" nome="sottotipologia">' . $sottotipologia . '</span>
			</div>';
	}

	function getInformation() {

		$db=new ManageDB();
		$db->connect();
		$query='select * from utenti where username="'.$_SESSION['Username'].'";';
		$result=$db->query($query);
		$row=$result->fetch_array(MYSQL_ASSOC);
		$db->close();
		return "
			<ul class='list-group'>
			  <li id='username' class='list-group-item'><b>Username: </b><span>" . $row['Username'] . "</span></li>
			  <li id='name' class='list-group-item'><b>Nome: </b><span>" . $row['Nome'] . "</span></li>
			  <li id='surname' class='list-group-item'><b>Cognome: </b><span>" . $row['Cognome'] . "</span></li>
			  <li id='birthday' class='list-group-item'><b>Data di nascita: </b><span>" . $row['Data_nascita'] . "</span></li>
			  <li id='telephone' class='list-group-item'><b>Telefono: </b><span>" . $row['Telefono'] . "</span></li>
			  <li id='cap' class='list-group-item'><b>CAP: </b><span>" . $row['CAP'] . "</span></li>
			  <li id='municipality' class='list-group-item'><b>Comune: </b><span>" . $row['Comune'] . "</span></li>
			  <li id='province' class='list-group-item'><b>Provincia: </b><span>" . $row['Provincia'] . "</span></li>
			  <li id='region' class='list-group-item'><b>Regione: </b><span>" . $row['Regione'] . "</span></li>
			  <li id='street' class='list-group-item'><b>Indirizzo: </b><span>" . $row['Indirizzo'] . "</span></li>
			  <li id='password' class='list-group-item' style='display:none;'><b>Password: </b><span>" . $row['Password'] . "</span></li>
			</ul>
		";

	}
	
	function my_ofset($text){
		preg_match('/^\D*(?=\d)/', $text, $m);
		return isset($m[0]) ? strlen($m[0]) : false;
	}
	
	function getOrderBellhop() {

		$db=new ManageDB();
		$db->connect();
		
		$originalCode = $_GET['Codice'];
		$codice = preg_replace("/[^0-9,.]/", '', $_GET['Codice']);
		if($codice != $originalCode){
			global $MESSAGE_FOR_PUSSIES;
			echo $MESSAGE_FOR_PUSSIES;
			exit(0);
		}

		$query='select n.Nome as Negozio, n.Telefono, n.Indirizzo, n.Comune, n.Partita_iva from utenti u
		inner join fattorini f on f.Fattorino=u.Codice_fiscale
		inner join ordini o on o.Codice_ordine=f.Scontrino
		inner join prodotti p on p.Codice_prodotto=o.Codice_Prodotto
		inner join negozi n on o.Codice_negozio=n.Partita_iva
		inner join prodottinegozio pn on pn.codice_prodotto=p.codice_prodotto and pn.Codice_negozio=n.Partita_iva
		where u.username="'.$_SESSION['Username'].'" and Codice_Ordine='.$codice.';';
		$result=$db->query($query);	
		$row=$result->fetch_array(MYSQL_ASSOC);
		
		if($db->affectedRows()==0){
			global $MESSAGE_FOR_PUSSIES;
			echo $MESSAGE_FOR_PUSSIES;
			exit(0);
		}

		echo '<div class="container container-login">
				<div class="title">Scontrino</div><br>
					<div class="card card-container">
						<div id="negozioHeader">
							<b>'.$row['Negozio'].'</b>
						</div>
						<div id="negozioInformation">
							<i>'.$row['Indirizzo'].'<br>'.$row['Comune'].'</i><br>
							TELEFONO '.$row['Telefono'].'<br>
							Part. Iva ' . $row['Partita_iva'] . '
						</div><br>
					<div id="produts">
						<table class="table table-condensed">';

		$query='select o.Quantita, p.Nome as Prodotto, pn.Prezzo from utenti u
		inner join fattorini f on f.Fattorino=u.Codice_fiscale
		inner join ordini o on o.Codice_ordine=f.Scontrino
		inner join prodottinegozio pn on pn.codice_prodotto=o.Codice_prodotto and pn.Codice_negozio=o.Codice_negozio
		inner join prodotti p on p.Codice_prodotto=pn.Codice_prodotto
		where u.username="'.$_SESSION['Username'].'" and Codice_Ordine='.$codice.';';
		$result=$db->query($query);
		while($row=$result->fetch_array(MYSQL_ASSOC)) {

			echo '			<tr>
								<td>'.$row['Quantita'].'x</td>
					            <td>'.$row['Prodotto'].'</td>
								<td style="text-align: right">'.$row['Prezzo'].'&#8364;</td>
							</tr>';
							$Prodotti+=$row['Quantita']*$row['Prezzo'];
							global $earnQuote, $fixedPrice;
							$Totale=$Prodotti+$Prodotti*$earnQuote+$fixedPrice;
		}

		$query='select o.Codice_Ordine as Ordine, o.Data_Consegna as Data, fo.Ora as Ora from utenti u
        inner join fattorini f on f.Fattorino=u.Codice_fiscale 
        inner join ordini o on f.Scontrino=o.Codice_ordine
		inner join fasce_orarie fo on fo.Codice_Fascia=o.Codice_Fascia
		where u.username="'.$_SESSION['Username'].'" and Codice_Ordine='.$codice.';';
		$result=$db->query($query);
		$row=$result->fetch_array(MYSQL_ASSOC);

			echo            '<tr>
								<td><b>Totale</b></td>
								<td></td>
								<td style="text-align: right"><b>'.arrotonda($Totale).'&#8364;</b></td>
							</tr>
							<tr>
								<td>'.$row['Data'].'</td>
								<td></td>
								<td style="text-align: right">'.$row['Ora'].'</td>
							</tr>
							</tr>
						</table>
						<p align="left">Codice ordine: '.$codice.'</p>
					</div>
				</div>
			</div>';

		$db->close();
	}

	function getOrderClient() {

		$db=new ManageDB();
		$db->connect();
		
		$originalCode = $_GET['Codice'];
		$codice = preg_replace("/[^0-9,.]/", '', $_GET['Codice']);
		if($codice != $originalCode){
			global $MESSAGE_FOR_PUSSIES;
			echo $MESSAGE_FOR_PUSSIES;
			exit(0);
		}

		$query='select n.Nome as Negozio, n.Telefono, n.Indirizzo, n.Comune, n.Partita_iva from utenti u
		inner join ordini o on o.Codice_utente=u.Codice_fiscale
		inner join prodotti p on p.Codice_prodotto=o.Codice_Prodotto
		inner join negozi n on o.Codice_negozio=n.Partita_iva
		inner join prodottinegozio pn on pn.codice_prodotto=p.codice_prodotto and pn.Codice_negozio=n.Partita_iva
		where u.username="'.$_SESSION['Username'].'" and Codice_Ordine='.$codice.';';
		$result=$db->query($query);	
		$row=$result->fetch_array(MYSQL_ASSOC);
		
		if($db->affectedRows()==0){
			global $MESSAGE_FOR_PUSSIES;
			echo $MESSAGE_FOR_PUSSIES;
			exit(0);
		}

		echo '<div class="container container-login">
				<div class="title">Scontrino</div><br>
					<div class="card card-container">
						<div id="negozioHeader">
							<b>'.$row['Negozio'].'</b>
						</div>
						<div id="negozioInformation">
							<i>'.$row['Indirizzo'].'<br>'.$row['Comune'].'</i><br>
							TELEFONO '.$row['Telefono'].'<br>
							Part. Iva ' . $row['Partita_iva'] . '
						</div><br>
					<div id="produts">
						<table class="table table-condensed">';

		$query='select o.Quantita, p.Nome as Prodotto, pn.Prezzo from utenti u
		inner join ordini o on o.Codice_utente=u.Codice_fiscale
		inner join prodottinegozio pn on pn.codice_prodotto=o.Codice_prodotto and pn.Codice_negozio=o.Codice_negozio
		inner join prodotti p on p.Codice_prodotto=pn.Codice_prodotto
		where u.username="'.$_SESSION['Username'].'" and Codice_Ordine='.$codice.';';
		$result=$db->query($query);
		while($row=$result->fetch_array(MYSQL_ASSOC)) {

			echo '			<tr>
								<td>'.$row['Quantita'].'x</td>
					            <td>'.$row['Prodotto'].'</td>
								<td style="text-align: right">'.$row['Prezzo'].'&#8364;</td>
							</tr>';
							$Prodotti+=$row['Quantita']*$row['Prezzo'];
							global $earnQuote, $fixedPrice;
							$Totale=$Prodotti+$Prodotti*$earnQuote+$fixedPrice;
		}

		$query='select o.Codice_Ordine as Ordine, o.Data_Consegna as Data, fo.Ora as Ora from utenti u
        inner join ordini o on u.Codice_fiscale=o.Codice_utente
		inner join fasce_orarie fo on fo.Codice_Fascia=o.Codice_Fascia
		where u.username="'.$_SESSION['Username'].'" and Codice_Ordine='.$codice.';';
		$result=$db->query($query);
		$row=$result->fetch_array(MYSQL_ASSOC);

			echo            '<tr>
								<td><b>Totale</b></td>
								<td></td>
								<td style="text-align: right"><b>'.arrotonda($Totale).'&#8364;</b></td>
							</tr>
							<tr>
								<td>'.$row['Data'].'</td>
								<td></td>
								<td style="text-align: right">'.$row['Ora'].'</td>
							</tr>
							</tr>
						</table>
						<p align="left">Codice ordine: '.$codice.'</p>
					</div>
				</div>
			</div>';

		$db->close();
	}

	function setDelay() {

		$db=new ManageDB();
		$db->connect();
		$query='select distinct Data_consegna from ordini;';
		$result=$db->query($query);
		while($row=$result->fetch_array(MYSQL_ASSOC)) {
			if(strtotime($row['Data_consegna'])<strtotime(date("Y-m-d"))) {
				$query='update ordini set Stato=1 where Data_consegna="'.$row['Data_consegna'].'";';
				$db->query($query);
			} 
		}
		$db->close();
	}

	function getReport($codice) {

        	$db=new ManageDB();
            $db->connect();
                $query='select s.Oggetto, st.Nome, s.Data, u.Username, s.Descrizione
					from
						segnalazioni s
					inner join
						tipologiesegnalazioni st
					on
						st.Codice_segnalazione=s.Tipologia
					inner join
						utenti u 
					on
						u.Codice_fiscale=s.Utente
					where 
						s.Codice='.$codice.';';
                
		
				$result=$db->query($query);
                $row=$result->fetch_array(MYSQL_ASSOC);
				

        	echo '<div class="container">
					  <div class="title">Segnalazione</div>
					  <br>
					  <form class="form-horizontal" role="form">
					  	<div class="form-group">
					      <label class="control-label col-sm-2" for="Oggetto">Codice:</label>
					      <div class="col-sm-10">
					        <input type="text" class="form-control" id="Oggetto" value="'.$codice.'" readonly>
					      </div>
					    </div>
					    <div class="form-group">
					      <label class="control-label col-sm-2" for="Oggetto">Oggetto:</label>
					      <div class="col-sm-10">
					        <input type="text" class="form-control" id="Oggetto" value="'.$row['Oggetto'].'" readonly>
					      </div>
					    </div>
					    <div class="form-group">
					      <label class="control-label col-sm-2" for="Tipologia">Tipologia:</label>
					      <div class="col-sm-10">          
					        <input type="text" class="form-control" id="Tipologia" value="'.$row['Nome'].'" readonly>
					      </div>
					    </div>
					    <div class="form-group">
					      <label class="control-label col-sm-2" for="Data">Data:</label>
					      <div class="col-sm-10">          
					        <input type="text" class="form-control" id="Data" value="'.$row['Data'].'" readonly>
					      </div>
					    </div>
					    <div class="form-group">
					      <label class="control-label col-sm-2" for="Mittente">Mittente:</label>
					      <div class="col-sm-10">          
					        <input type="text" class="form-control" id="Mittente" value="'.$row['Username'].'" readonly>
					      </div>
					    </div>
					    <div class="form-group">        
					      <div class="col-sm-offset-2 col-sm-10">
					        <textarea id="Descrizione" class="form-control" cols="40" rows="3" readonly>'.$row['Descrizione'].'</textarea>
					      </div>
					    </div>
					  </form>
					</div>';
			
        }

    function getUser($codice) {

    	$db=new ManageDB();
            $db->connect();
                $query='select *
					from
						utenti u
					where 
						u.Codice_fiscale="'.$codice.'";';
                
		
				$result=$db->query($query);
                $row=$result->fetch_array(MYSQL_ASSOC);
				

        	echo '<div class="container">
					  <div class="title">'.$row['Username'].'</div>
					  <br>
					  <form id="form" name="form" class="form-horizontal" role="form" action="ModificaTipo.php" method="POST">
					  	<div class="form-group">
					      <label class="control-label col-sm-2" for="Codice_fiscale">Codice fiscale:</label>
					      <div class="col-sm-10">
					        <input type="text" class="form-control" id="Codice_fiscale" name="Codice_fiscale" value="'.$codice.'" readonly>
					      </div>
					    </div>
					    <div class="form-group">
					      <label class="control-label col-sm-2" for="Nome">Nome:</label>
					      <div class="col-sm-10">
					        <input type="text" class="form-control" id="Nome" value="'.$row['Nome'].'" readonly>
					      </div>
					    </div>
					    <div class="form-group">
					      <label class="control-label col-sm-2" for="Cognome">Cognome:</label>
					      <div class="col-sm-10">
					        <input type="text" class="form-control" id="Cognome" value="'.$row['Cognome'].'" readonly>
					      </div>
					    </div>
					    <div class="form-group">
					      <label class="control-label col-sm-2" for="Data_nascita">Data di nascita:</label>
					      <div class="col-sm-10">
					        <input type="text" class="form-control" id="Data_nascita" value="'.$row['Data_nascita'].'" readonly>
					      </div>
					    </div>
					    <div class="form-group">
					      <label class="control-label col-sm-2" for="Telefono">Telefono:</label>
					      <div class="col-sm-10">          
					        <input type="text" class="form-control" id="Telefono" value="'.$row['Telefono'].'" readonly>
					      </div>
					    </div>
					    <div class="form-group">
					      <label class="control-label col-sm-2" for="Indirizzo">Indirizzo:</label>
					      <div class="col-sm-10">          
					        <input type="text" class="form-control" id="Indirizzo" value="'.$row['Indirizzo'].'" readonly>
					      </div>
					    </div>
					    <div class="form-group">
					      <label class="control-label col-sm-2" for="CAP">CAP:</label>
					      <div class="col-sm-10">          
					        <input type="text" class="form-control" id="CAP" value="'.$row['CAP'].'" readonly>
					      </div>
					    </div>
					    <div class="form-group">
					      <label class="control-label col-sm-2" for="Comune">Comune:</label>
					      <div class="col-sm-10">          
					        <input type="text" class="form-control" id="Comune" value="'.$row['Comune'].'" readonly>
					      </div>
					    </div>
					    <div class="form-group">
					      <label class="control-label col-sm-2" for="Provincia">Provincia:</label>
					      <div class="col-sm-10">          
					        <input type="text" class="form-control" id="Provincia" value="'.$row['Provincia'].'" readonly>
					      </div>
					    </div>
					    <div class="form-group">
					      <label class="control-label col-sm-2" for="Tipo">Tipologia account:</label>
					      <div class="col-sm-10">          
					        <input type="text" class="form-control" id="Tipo" name="Tipo" value="'.$row['Tipo'].'">
					      </div>
					    </div>
					    <button type="button" onclick="Modifica()" class="btn btn-primary">Modifica</button>
					  </form>
					</div>';

    }
	
    function getNotificationTologies() {
    	$db=new ManageDB();
                $db->connect();
                $query='select Codice_segnalazione as Codice, Nome from tipologiesegnalazioni';
                $result=$db->query($query);
                //<option data-hidden="true">Seleziona una tipologia</option>';
				echo '<select class="selectpicker" id="Tipologia" name="Tipologia" data-width="100%">';	
                //<select id="Tipologia" name="Tipologia" class="form-control">'
                while($row=$result->fetch_array(MYSQL_ASSOC)) {
						echo '<option value="'.$row['Codice'].'">'.$row['Nome'].'</option>';
                }
                echo '
					</select>
					<script>
						$("#Tipologia").selectpicker();
					</script>
				';
        $db->close();
    }

   /* function getOrderAdmin() {
    		global $earnQuote, $fixedPrice;
		$db=new ManageDB();
		$db->connect();
		$query='SELECT 
			n.Nome, 
			n.Comune, 
			n.Telefono, 
			n.Indirizzo, 
			n.Partita_iva 
				FROM fattorini f
					inner join ordini o on f.Scontrino=o.Codice_ordine
					inner join utenti u on f.Fattorino=u.Codice_fiscale
					inner join negozi n on n.Partita_iva=o.Codice_negozio
				WHERE 
					u.Username="'.$_SESSION['Username'].'" 
					AND o.Stato=0;
		';
		
		$result=$db->query($query);


		$row=$result->fetch_array(MYSQL_ASSOC);

		echo '
			<div class="container container-login">
				<div class="title">Incarico in corso</div>
				<small>Porta a termine questo incarico prima di iniziarne un\'altro.</small>
				
				<div class="card card-container" style="padding-bottom: 20px;">
					<center>
						<div id="negozioHeader">
							<b>'.$row['Nome'].'</b>
						</div>
						<div id="negozioInformation">
							<i>'.$row['Indirizzo'].'<br>'.$row['Comune'].'</i><br>
							TELEFONO '.$row['Telefono'].'<br>
							Part. Iva ' . $row['Partita_iva'] . '
						</div>
					</center>
					<br>
					<i>Lista prodotti da acquistare</i>
					<div id="produts">
						<table class="table table-condensed table-striped">';

						$query='
							SELECT 
								p.Nome as Prodotto, 
								o.Quantita, 
								pn.Prezzo 
									FROM fattorini f
										inner join ordini o on o.Codice_ordine=f.Scontrino
										inner join utenti u on u.Codice_fiscale=f.Fattorino
										inner join prodottinegozio pn on pn.Codice_prodotto=o.Codice_prodotto and pn.Codice_negozio=o.Codice_negozio
										inner join prodotti p on p.Codice_prodotto=pn.Codice_prodotto
									WHERE 
										u.username="'.$_SESSION['Username'].'" 
										AND o.Stato=0;
						';
						
						$result=$db->query($query);
						
						while($row=$result->fetch_array(MYSQL_ASSOC)) {
							echo '
								<tr>
									<td>'.$row['Quantita'].'x</td>
									<td>'.$row['Prodotto'].'</td>
									<td style="text-align: right">'.$row['Prezzo'].'&#8364;</td>
								</tr>
							';
							$Prodotti+=$row['Quantita']*$row['Prezzo'];
						}
						
						$Totale = $Prodotti + $Prodotti*$earnQuote + $fixedPrice;

						$query='
							SELECT 
								o.Codice_ordine as Ordine, 
								o.Data_ordine,
								o.Data_consegna as Data,
								fo.Ora, 
								u1.Nome as NomeUtente, 
								u1.Cognome as CognomeUtente, 
								u1.Comune as ComuneUtente, 
								u1.Indirizzo as IndirizzoUtente 
									FROM fattorini f
										inner join ordini o on f.Scontrino=o.Codice_ordine
										inner join utenti u on f.Fattorino=u.Codice_fiscale
										inner join fasce_orarie fo on fo.Codice_fascia=o.Codice_fascia
										inner join utenti u1 on o.Codice_utente=u1.Codice_fiscale
									WHERE 
										u.username="'.$_SESSION['Username'].'" 
										AND o.Stato=0;
						';
						$result=$db->query($query);
						$row=$result->fetch_array(MYSQL_ASSOC);

						echo '
										<tr>
											<td><b>Totale</b></td>
											<td></td>
											<td style="text-align: right"><b>'.arrotonda($Totale).'&#8364;</b></td>
										</tr>
										
										<tr>
											<td colspan="2">
												<i>Guadagno</i>
											</td>
											
											<td style="text-align: right">
												<i>' . arrotonda($Prodotti*$earnQuote) . '€</i>
											</td>
										</tr>
										

								</table>
								
		
								<table class="table-condensed" style="width: 100%">
									<tr>
										<td colspan="3" style="text-align: center"><i>Dettagli</i></td>
									</tr>
								
									<tr style="border-bottom: 1px dotted #ccc">	
										<td>
											<i>Codice ordine:</i>
										</td>
										<td style="text-align: right">
											'.$row['Ordine'].'
										</td>
									</tr>
									
									<tr style="border-bottom: 1px dotted #ccc">	
										<td>
											<i>Destinatario:</i>
										</td>
										<td style="text-align: right">
											'.$row['CognomeUtente'].' '.$row['NomeUtente'].'
										</td>
									</tr>
									
									<tr style="border-bottom: 1px dotted #ccc">	
										<td>
											<i>Comune destinatario:</i>
										</td>
										<td style="text-align: right">
											'.$row['ComuneUtente'].'
										</td>
									</tr>
									
									<tr style="border-bottom: 1px dotted #ccc">	
										<td>
											<i>Indirizzo destrinatario:</i>
										</td>
										<td style="text-align: right">
											'.$row['IndirizzoUtente'].'
										</td>
									</tr>
									
									<tr style="border-bottom: 1px dotted #ccc">	
										<td>
											<i>Data consegna:</i>
										</td>
										<td style="text-align: right">
											'.$row['Data'].'
										</td>
									</tr>
									
									<tr style="border-bottom: 1px dotted #ccc">	
										<td>
											<i>Fascia preferenziale:</i>
										</td>
										<td style="text-align: right">
											' .$row['Ora'] . '
										</td>
									</tr>
									<tr>
										<td colspan="3">';
											echo '<a href="statoOrdineUpdate.php?codice=' . $row["Ordine"] . '"' . (strtotime($row['Data'])<=strtotime(date("Y-m-d")) ? '' : 'disabled="disabled"') . 'class="btn btn-info" style="float: right; margin-top: 20px;">Esegito</a>
										</td>
									</tr>
								</table>
					</div>
					
				</div>
			</div>
							';

		$db->close();
    }*/
	
	function getActualAssignment() {
		global $earnQuote, $fixedPrice;
		$db=new ManageDB();
		$db->connect();
		$query='SELECT 
			n.Nome, 
			n.Comune, 
			n.Telefono, 
			n.Indirizzo, 
			n.Partita_iva 
				FROM fattorini f
					inner join ordini o on f.Scontrino=o.Codice_ordine
					inner join utenti u on f.Fattorino=u.Codice_fiscale
					inner join negozi n on n.Partita_iva=o.Codice_negozio
				WHERE 
					u.Username="'.$_SESSION['Username'].'" 
					AND o.Stato=0;
		';
		
		$result=$db->query($query);


		$row=$result->fetch_array(MYSQL_ASSOC);

		echo '
			<div class="container container-login">
				<div class="title">Incarico in corso</div>
				<small>Porta a termine questo incarico prima di iniziarne un\'altro.</small>
				
				<div class="card card-container" style="padding-bottom: 20px;">
					<center>
						<div id="negozioHeader">
							<b>'.$row['Nome'].'</b>
						</div>
						<div id="negozioInformation">
							<i>'.$row['Indirizzo'].'<br>'.$row['Comune'].'</i><br>
							TELEFONO '.$row['Telefono'].'<br>
							Part. Iva ' . $row['Partita_iva'] . '
						</div>
					</center>
					<br>
					<i>Lista prodotti da acquistare</i>
					<div id="produts">
						<table class="table table-condensed table-striped">';

						$query='
							SELECT 
								p.Nome as Prodotto, 
								o.Quantita, 
								pn.Prezzo 
									FROM fattorini f
										inner join ordini o on o.Codice_ordine=f.Scontrino
										inner join utenti u on u.Codice_fiscale=f.Fattorino
										inner join prodottinegozio pn on pn.Codice_prodotto=o.Codice_prodotto and pn.Codice_negozio=o.Codice_negozio
										inner join prodotti p on p.Codice_prodotto=pn.Codice_prodotto
									WHERE 
										u.username="'.$_SESSION['Username'].'" 
										AND o.Stato=0;
						';
						
						$result=$db->query($query);
						
						while($row=$result->fetch_array(MYSQL_ASSOC)) {
							echo '
								<tr>
									<td>'.$row['Quantita'].'x</td>
									<td>'.$row['Prodotto'].'</td>
									<td style="text-align: right">'.$row['Prezzo'].'&#8364;</td>
								</tr>
							';
							$Prodotti+=$row['Quantita']*$row['Prezzo'];
						}
						
						$Totale = $Prodotti + $Prodotti*$earnQuote + $fixedPrice;

						$query='
							SELECT 
								o.Codice_ordine as Ordine, 
								o.Data_ordine,
								o.Data_consegna as Data,
								fo.Ora, 
								u1.Nome as NomeUtente, 
								u1.Cognome as CognomeUtente, 
								u1.Comune as ComuneUtente, 
								u1.Indirizzo as IndirizzoUtente 
									FROM fattorini f
										inner join ordini o on f.Scontrino=o.Codice_ordine
										inner join utenti u on f.Fattorino=u.Codice_fiscale
										inner join fasce_orarie fo on fo.Codice_fascia=o.Codice_fascia
										inner join utenti u1 on o.Codice_utente=u1.Codice_fiscale
									WHERE 
										u.username="'.$_SESSION['Username'].'" 
										AND o.Stato=0;
						';
						$result=$db->query($query);
						$row=$result->fetch_array(MYSQL_ASSOC);

						echo '
										<tr>
											<td><b>Totale</b></td>
											<td></td>
											<td style="text-align: right"><b>'.arrotonda($Totale).'&#8364;</b></td>
										</tr>
										
										<tr>
											<td colspan="2">
												<i>Guadagno</i>
											</td>
											
											<td style="text-align: right">
												<i>' . arrotonda($Prodotti*$earnQuote) . '€</i>
											</td>
										</tr>
										

								</table>
								
		
								<table class="table-condensed" style="width: 100%">
									<tr>
										<td colspan="3" style="text-align: center"><i>Dettagli</i></td>
									</tr>
								
									<tr style="border-bottom: 1px dotted #ccc">	
										<td>
											<i>Codice ordine:</i>
										</td>
										<td style="text-align: right">
											'.$row['Ordine'].'
										</td>
									</tr>
									
									<tr style="border-bottom: 1px dotted #ccc">	
										<td>
											<i>Destinatario:</i>
										</td>
										<td style="text-align: right">
											'.$row['CognomeUtente'].' '.$row['NomeUtente'].'
										</td>
									</tr>
									
									<tr style="border-bottom: 1px dotted #ccc">	
										<td>
											<i>Comune destinatario:</i>
										</td>
										<td style="text-align: right">
											'.$row['ComuneUtente'].'
										</td>
									</tr>
									
									<tr style="border-bottom: 1px dotted #ccc">	
										<td>
											<i>Indirizzo destrinatario:</i>
										</td>
										<td style="text-align: right">
											'.$row['IndirizzoUtente'].'
										</td>
									</tr>
									
									<tr style="border-bottom: 1px dotted #ccc">	
										<td>
											<i>Data consegna:</i>
										</td>
										<td style="text-align: right">
											'.$row['Data'].'
										</td>
									</tr>
									
									<tr style="border-bottom: 1px dotted #ccc">	
										<td>
											<i>Fascia preferenziale:</i>
										</td>
										<td style="text-align: right">
											' .$row['Ora'] . '
										</td>
									</tr>
									<tr>
										<td colspan="3">';
											echo '<a href="statoOrdineUpdate.php?codice=' . $row["Ordine"] . '"' . (strtotime($row['Data'])<=strtotime(date("Y-m-d")) ? '' : 'disabled="disabled"') . 'class="btn btn-info" style="float: right; margin-top: 20px;">Esegito</a>
										</td>
									</tr>
								</table>
					</div>
					
				</div>
			</div>
							';

		$db->close();
	}

        function getMessage() {
        	$db=new ManageDB();
            $db->connect();
                $query='select * from AreaUtenti;';
                $result=$db->query($query);
                while($row=$result->fetch_array(MYSQL_ASSOC)) {
                	echo '<div class="media msg ">
								<div class="media-body">
		                        	<small class="pull-right time"><i class="fa fa-clock-o"></i>'.$row['Data'].'</small>
		                        	<h5 class="media-heading">'.$row['Mittente'].'</h5>
		                        	<small class="col-lg-10">'.$row['Messaggio'].'</small>
			                    </div> 
							</div>	';
                }
            $db->close();
        }

	function getCartStructure(){
		echo '
			<div id="dialog" title="Carrello" style="display: none;">
				<table class="table table-striped tcart">
					<thead>
						<tr>
						  <th>Prodotto</th>
						  <th>Quantità</th>
						  <th>Prezzo</th>
						  <th></th>
						</tr>
					</thead>
					<tbody id="cartAppendProduct">

						<tr>
						  <td colspan="2" style="border-top: 2px solid rgb(49, 174, 212);">Totale Prodotti</td>
						  <td colspan="2" style="border-top: 2px solid rgb(49, 174, 212);"><span id="cartAppendTotalPrice">0</span><span> &#8364;</span></td>
						</tr>
						<tr>
						  <td colspan="2">Spese di spedizione e sovrapprezzo</td>
						  <td colspan="2"><span id="cartAppendOverPrice">0</span><span> &#8364;</span></td>
						</tr>
						<tr>
						  <th colspan="2">Totale alla consegna</th>
						  <th colspan="2"><span id="cartAppendTotalPriceConsegna">0</span><span> &#8364;</span></th>
						</tr>
						<tr>
							<td><a class="btn btn-info" onclick="closeCartDialog()">Continua</a></td>
							<td><a id="emptyCart" class="btn btn-warning" onclick="emptyCart()">Svuota</a></td>
							<td colspan="2"><a onclick="runOrder()" class="btn btn-danger">Ordina!</a></td>
						</tr>
					</tbody>
				</table>
				<div id="cartAlert" class="alert alert-danger" style="display: none">La spesa minima &egrave di 35 euro</div>
			</div>';
		}
		
		function arrotonda($numb){
			return number_format((float)$numb, 2, '.', '');
		}
		
		function sendMail($text){	
			$to = "deliberali.giacomo@gmail.com";
			$subject = "Registrazione myArchive.it";
			$txt = "$text";
			$headers = "From: registrazione@myarchive.it" . "\r\n";
			mail($to,$subject,$txt,$headers);
		}
	
		function debug($str){
			echo "<script>alert('$str');</script>";
		}
		
		