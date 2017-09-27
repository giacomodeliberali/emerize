<?php
	require_once("security.php");
	require_once("scripts/php/tools.php");
	require_once("scripts/php/header_footer.php");
?>
<!-- Form di upload per inerimento di nuovi prodotti da parte dei negozi -->

<!DOCTYPE html>
<html>
<head>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1" >
		<meta charset="utf-8" />
		<script type="text/javascript" src="scripts/js/jquery/jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="scripts/js/jquery/jquery-ui.min.js"></script>
		<script type="text/javascript" src="scripts/js/jquery/datepicker-it.js"></script>
		<script src="scripts/js/md5.js"></script>
		<script src="scripts/js/tools.js"></script>
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap-theme.min.css" />
		<link rel="stylesheet" type="text/css" href="styles/style.css" />
		<link rel="stylesheet" type="text/css" href="styles/jquery/jquery-ui.css" />
		<script type="text/javascript" src="scripts/js/bootstrap/bootstrap.min.js"></script>
		<script type="text/javascript" src="scripts/js/bootstrap/bootstrap-select.js"></script>
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap-select.css" />
		<script type="text/javascript" src="scripts/js/config.js"></script>
		<script type="text/javascript" src="scripts/js/cookies.js"></script> <!-- caricati in testa -->
		<script type="text/javascript" src="scripts/js/cart.js"></script>
		<script type="text/javascript" src="scripts/js/tools.js"></script>
		<title>Emerize - Gestione prodotti</title>
</head>
<body>
		<?php
			getHeaderNoCart();
		?>
		
		<center>
			<div class="container container-login">
					<div class="card card-container">
						<img id="profile-img" class="profile-img-card" src="/public/images/usersUpload/<?php echo $_SESSION['Image']; ?>" />
						<p id="profile-name" class="profile-name-card"><?php echo $_SESSION['Username']; ?></p>
						
						<small>
							<?php
								$msg = "";
								switch($_GET['operation']){
									case "add":
										$msg = "Cerca il prodotto da aggiungere a ";
										break;
									case "update":
										$msg = "Cerca il prodotto da aggiornare da";
										break;
									case "delete":
										$msg = "Cerca il prodotto da eleminare da";
										break;
								}
								echo $msg;
							?>
							<b><?php echo $_SESSION["personalMarketName"]?></b>(<?php echo $_SESSION["personalMarketComune"]?>)
						</small>
						<div class="input-group">
						  <input type="text" class="form-control" placeholder="Cerca prodotto..." title="Digita * (asterisco) per l'elenco completo." data-toggle="tooltip">
						  <span class="input-group-btn">
							<button class="btn btn-default" type="button" onclick="getHints(this.parentNode.parentNode.firstElementChild.value)">Cerca!</button>
						  </span>
						</div><!-- /input-group -->
						<div id="resultMessage" class="alert" style="display: none"></div>
						<hr>
						
		</center>
		<div class="container">
			<div id="productsContainer"></div>
		</div>
		
		<script>
			
			$(function(){
				$('[data-toggle="tooltip"]').tooltip({placement: "bottom"}); 
			});
			
			function getHints(value){
				 // ajax tools.php/getSearchBoxHints(expression)
				 var operation = "<?php echo $_GET['operation']; ?>";
				 $(".animation_image").show();
				 value = value.replace(/\ /g, '+');
				 $.get("scripts/php/ajaxProdotti.php?q=" + value + "&operation=" + operation, function(result, status){
					$("#productsContainer").html(result);
					$(".animation_image").hide();
				});
			}
			
		
			priceOK = false;
			productID = "";
			productprice = "";
			
			function addButtonClick(self){
				_price = $(self).parent().parent().children().first().val();
				_id = $(self).parent().parent().parent().parent().parent().parent().attr("id");
				
				if (checkPrice(_price)) {
					//alert("aggiungo " + _id + " da <?php echo $_SESSION['personalMarket']?> " + _price);
					saveChanges("add", _id, _price, self);
				}else{
					//6, 2 child
					var priceAlert = $(self).parent().parent().parent().children().first().next();
					

					$(priceAlert).slideDown();
					setTimeout(function(){
						$(priceAlert).slideUp();
					}, 3000);
					
					//alert("controlla il prezzo");
				}
			}
			
			function updateButtonClick(self){
				_price = $(self).parent().parent().children().first().val();
				_id = $(self).parent().parent().parent().parent().parent().parent().attr("id");
				
				if (checkPrice(_price)) {
					//alert("aggiorno " + _id + " da <?php echo $_SESSION['personalMarket']?> " + _price);
					saveChanges("update", _id, _price, self);
				}else{
					alert("controlla il prezzo");
				}
			}
			
			function deleteButtonClick(self){
				_id= $(self).parent().parent().parent().parent().attr("id");
				saveChanges("delete", _id, 0, self);
				//alert("elimino " + id + " da <?php echo $_SESSION['personalMarket']?>");
			}
			
			function checkPrice(price){
				if (!(/^\d*(?:\.\d{0,2})?$/.test(price)) || price == 0 || price < 0 || price == "") {
					return false;
				}else{
					return true;
				}
			}
			

			
			function saveChanges(operation, productID, productPrice, _self){
				
				$.post("scripts/php/manageProductMarket.php", {operation: operation, productID: productID, price : productPrice}, function(data, textStatus, jkXHR){
					remove = false;
					hMsg = JSON.parse(data);
					$("#resultMessage").html(hMsg.message);
					if (hMsg.state == "success") {
						$("#resultMessage").addClass("alert-success").removeClass("alert-danger");
						remove = true;
						if (operation == "delete" || operation=="update") {
							cart.removeAll(productID);
						}
					}else{
						$("#resultMessage").removeClass("alert-success").addClass("alert-danger");
					}
					$("#resultMessage").slideDown();
					setTimeout(function(){
						$("#resultMessage").slideUp(400, function(){
							if (remove) {
								$(_self).closest(".productContent").fadeOut(1000, function(){ $(this).remove();});	
							}
						});

					}, 1500)
				});
			}
		</script>
		<script type="text/javascript" src="scripts/js/loadCart.js"></script>
</body>
</html>