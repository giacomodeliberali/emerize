<?php
	require_once("security.php");
	
	if(isset($_POST['negozio'])){
		$_SESSION['codiceNegozio'] = $_POST['negozio'];
	}
	if(isset($_POST['nome'])){
		$_SESSION['marketName'] = $_POST['nome'];
	}
	if(isset($_GET['sottotipologia'])){
		$_SESSION['sottotipologia'] = $_GET['sottotipologia'];
	}else{
		$_SESSION['sottotipologia'] = "";
		unset($_SESSION['sottotipologia']);
	}
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		header("Location: home.php"); //pattern PRG
	}
	require_once("scripts/php/header_footer.php");
	require_once("scripts/php/tools.php");
?>
<html class="noselect">
	<head>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1" >
		<meta charset="utf-8" />

		<link rel="stylesheet" type="text/css" href="styles/jquery/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap-theme.min.css" />
		<link rel="stylesheet" type="text/css" href="styles/style.css" />
		<title>Emerize - Home Prodotti</title>
		

	</head>
	<body>

		
		<?php
			getHeader();
		?>

		<div class="container">
			<div class="header">
			<h3>
				Prodotti <?php echo $_SESSION['marketName'] ?>
			
				<div class="input-group" style="float: right; max-width: 350px">
				  <input type="text" id="cerca" class="form-control" placeholder="Cerca prodotto..." title="Digita il nome di un prodotto. Per le categorie usa il men&ugrave; <br>Prodotti -> Categoria" data-toggle="tooltip">
				  <span class="input-group-btn">
					<button class="btn btn-default" type="button" onclick="getHints(this.parentNode.parentNode.firstElementChild.value)">Cerca!</button>
				  </span>
				</div><!-- /input-group -->			
			</h3>
			</div>

			
			<hr>
			<div id="productsContainer">
			
			</div>
			<div class="animation_image" style="display:none" align="center"><img src="/public/images/ajax-loader.gif"></div>
		</div>
		
		
		<?php
			getCartStructure();
			setDelay();
		?>
		
		<script type="text/javascript" src="scripts/js/jquery/jquery-1.11.2.min.js"></script> <!-- jQuery -->
		<script type="text/javascript" src="scripts/js/jquery/jquery-ui.min.js"></script>
		<script type="text/javascript" src="scripts/js/bootstrap/bootstrap.min.js"></script>
		<script type="text/javascript" src="scripts/js/jquery/jquery.mobile.custom.min.js"></script>
		<script type="text/javascript" src="scripts/js/config.js"></script>
		<script type="text/javascript" src="scripts/js/cookies.js"></script> <!-- caricati in testa -->
		<script type="text/javascript" src="scripts/js/cart.js"></script>
		<script type="text/javascript" src="scripts/js/tools.js"></script>
		<script>
			var total_groups = "<?php echo getTotalProducts($_SESSION['codiceNegozio']); ?>";
			/*$.getScript("scripts/js/autoload.js"); // vanno caricati dopo la creazione del DOM
			$.getScript("scripts/js/loadCart.js");
			$.getScript("scripts/js/dialog.js");*/
		</script>
		<script type="text/javascript" src="scripts/js/loadCart.js"></script>
		<script type="text/javascript" src="scripts/js/autoload.js"></script>
		<script type="text/javascript" src="scripts/js/dialog.js"></script>

		<script> // se l ultima volta ho selezionato un altro negozio, svuoto il carrello
			var lastMarket = getCookie("lastMarket");
			if (lastMarket != "<?php echo $_SESSION['codiceNegozio'] ?>") {
				cart.empty();
			}
			setCookie("lastMarket", "<?php echo $_SESSION['codiceNegozio'] ?>", 15);
	
			function getHints(value){
				if (value!="") {
					$(".animation_image").show();
					value = value.replace(/\ /g, '+');
					$.get("scripts/php/ajaxProdotti.php?q=" + value + "&full=true&search=true", function(result, status){
					   $("#productsContainer").html(result);
					   $(".animation_image").hide();
				   });
				}else{
					location.href="home.php";
				}
			}
			$("#cerca").on("keyup", function(){
				if($(this).val().length==0){
					//getHints("");
				}
			});
			
			$(function(){
				if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) { // se sono in mobile
					$("[data-toggle=tooltip]").tooltip({placement:"bottom", html: "true"});
				}else{
					$("[data-toggle=tooltip]").tooltip({placement:"left", html: "true"});
				}
			});
		</script>
		
		<script>
			function updateCartHighlight(self){
				cart.refreshGUI();
					cart.refreshGUI();
					highlight = $(self).parent().parent().parent().parent().attr("id");
					$("#dialog").dialog("open");
			
			}
		</script>
		
	</body>
</html>