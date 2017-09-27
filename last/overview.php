<?php
	require_once("security.php");
?>
<html>
	<head>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1" >
		<meta charset="utf-8" />
		<script type="text/javascript" src="scripts/js/jquery/jquery-1.11.2.min.js"></script> <!-- jQuery -->
		<script type="text/javascript" src="scripts/js/jquery/jquery-ui.min.js"></script>
		<script type="text/javascript" src="scripts/js/jquery/datepicker-it.js"></script>
		<script type="text/javascript" src="scripts/js/bootstrap/bootstrap.min.js"></script>
		<script type="text/javascript" src="scripts/js/jquery/jquery.mobile.custom.min.js"></script>
		<link rel="stylesheet" type="text/css" href="styles/jquery/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap-theme.min.css" />
				<script type="text/javascript" src="scripts/js/bootstrap/bootstrap-select.js"></script>
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap-select.css" />
		
		<title>Emerize - Riepilogo</title>
		<script type="text/javascript" src="scripts/js/config.js"></script>
		<link rel="stylesheet" type="text/css" href="styles/style.css" />
		<script type="text/javascript" src="scripts/js/cookies.js"></script> <!-- caricati in testa -->
		<script type="text/javascript" src="scripts/js/cart.js"></script>
		<script type="text/javascript" src="scripts/js/tools.js"></script>
	</head>
	<body>
		<?php
			require_once("scripts/php/header_footer.php");
			require_once("scripts/php/tools.php");
			getHeaderNoCart();
		?>

		<div class="container">
			<table class="table table-condensed">
                <tr>
                    <th>Prodotto</th>
                    <th style="text-align: right">Prezzo singolo</th>
                </tr>
                <?php
                    $cart = json_decode($_COOKIE["cart"]);
					if($cart->total < 35){
						echo "<script>location.href='home.php';</script>";
					}else{
						foreach($cart->products as $p){
							echo "
								<tr>
									<td>
										$p->number X $p->productTitle
									</td>
									<td style='text-align: right'>
										$p->price
									 &euro;</td>
								</tr>
							";
						}
						
						echo "
							<tr style='border-top: 2px solid #ccc'>
								<th style='text-align: left'>Totale</th>
								<td style='text-align: right'><b>$cart->total &euro;</b></td>
							</tr>
						";
					}
                ?>
				
				<tr>
					<td style="text-align: right">
						<span for="dataConsegna" style="line-height: 30px; margin-right: 10px"><b>Data consegna</b></span>
						<input id="dataConsegna" readonly="readonly" style="cursor: pointer; max-width: 200px; float: right" class="form-control" type="text" placeholder="Data consegna"/>
					</td>
					<td colspan="1" style="text-align: left">
						<?php getFasce(); ?>
					</td>
				</tr>
				<script>
					
					
					$('#dataConsegna').datepicker( {
						changeMonth: true,
						changeYear: false,
						minDate: "+3d",
						yearRange: "-0:+0",
						dateFormat: "yy-mm-dd"
					}).datepicker("setDate", "+5d");
				</script>
				
				<tr>
					<td colspan="1" style="text-align: left">
						<a href="home.php" class="btn btn-danger">Torna al negozio</a>
					</td>
					<td style="text-align: right">
						<button id="conferma" class="btn btn-success">Conferma</button>
					</td>
				</tr>
				
            </table>
			
			
			<script>
				$("#conferma").on("click", function(){
					var fascia = $("#fasceOrarie:selected").val();
					var dataConsegna = $("#dataConsegna").val();
					$.get("scripts/php/ajaxAddOrder.php?dataConsegna=" + dataConsegna + "&fascia=" + fascia, function(result){
						response = JSON.parse(result);
						if (response.state == "success") {
							cart.empty();
							alert("ordine accodato");
							location.href = "ordine.php?Codice=" + response.details;
						}else{
							alert(response.details);
						}
					});
				});
			</script>
			<script type="text/javascript" src="scripts/js/loadCart.js"></script>
		</div>
	</body>
</html>