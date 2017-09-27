<?php
	require_once("securityAdmin.php");
	require_once("scripts/php/header_footer.php");
	require_once("scripts/php/tools.php");
?>
<html class="noselect">
	<head>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1" >
		<meta charset="utf-8" />
		<script type="text/javascript" src="scripts/js/jquery/jquery-1.11.2.min.js"></script> <!-- jQuery -->
		<script type="text/javascript" src="scripts/js/jquery/jquery-ui.min.js"></script>
		<script type="text/javascript" src="scripts/js/bootstrap/bootstrap.min.js"></script>
		<script type="text/javascript" src="scripts/js/jquery/jquery.mobile.custom.min.js"></script>
		<link rel="stylesheet" type="text/css" href="styles/jquery/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap-theme.min.css" />
		
		<title>Emerize - Aggiungi prodotto</title>
		<link rel="stylesheet" type="text/css" href="styles/style.css" />


		<link rel="stylesheet" href="styles/bootstrap/bootstrap-table.css">
		<script src="scripts/js/bootstrap/bootstrap-table.js"></script>
		<script src="scripts/js/bootstrap/bootstrap-table-it-IT.js"></script>
		<script src="scripts/js/bootstrap/bootstrap-table-mobile.js"></script>
		<script src="scripts/js/tools.js"></script>
		<script src="scripts/js/lists.js"></script>
		<script type="text/javascript" src="scripts/js/bootstrap/bootstrap-select.js"></script>
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap-select.css" />
	</head>
	<body>
		
		<?php
			getHeaderNoCart();
		?>
        <div class="container">
        	
            <center><div class="title">Aggiunta nuovo prodotto</div></center>
            
            <form id="formSubmit" class="form-horizontal" action="scripts/php/addProducts.php" method="POST" enctype="multipart/form-data">
                
              <div class="form-group">
                <label class="control-label col-sm-2" for="nome">Nome:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="nome" placeholder="Nome">
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-sm-2" for="marca">Marca</label>
                <div class="col-sm-10"> 
                  <input type="text" class="form-control" name="marca" placeholder="Marca">
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-sm-2" for="descrizione">Descrizione:</label>
                <div class="col-sm-10"> 
                  <textarea id="descrizione" class="form-control" name="descrizione" placeholder="Descrizione" style="max-width: 100%"></textarea>
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-sm-2" for="descrizione">Tipologia:</label>
                <div class="col-sm-10"> 
                  <?php getAllTipologie(); ?>
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-sm-2" for="descrizione">Sottotipologia:</label>
                <div class="col-sm-10"> 
                   <?php getAllSottotipologie(); ?>
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-sm-2" for="peso">Peso (grammi):</label>
                <div class="col-sm-10"> 
                  <input type="number" class="form-control" name="peso" placeholder="Peso (grammi)" min="0">
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-sm-2" for="immagine">Immagine:</label>
                <div class="col-sm-10"> 
                    
                <input type="file" id="image" name="immagine" class="btn btn-default" style="width: 100%">

				
                </div>
              </div>
              <div id="resultDiv" class="alert" style="float: left"></div>
			  
              <button id="submitButton" type="submit" class="btn btn-info" style="float: right">Aggiungi</button>
            
			
			  
            </div>
            
            <div class="animation_image" style="display:none" align="center"><img src="/public/images/ajax-loader.gif"></div>
            
		</form>
        
        <script>
			$("#formSubmit").on("submit", function(e){
				e.preventDefault();
				$("#submitButton").html("Caricamento...");
				$("#submitButton").attr("disabled", "disabled");
				
				var formData = new FormData(this);
				$.ajax({
					type:'POST',
					url: $(this).attr('action'),
					data:formData,
					cache:false,
					contentType: false,
					processData: false,
					success:function(data){
						try{
							obj = JSON.parse(data);
							if (obj.state == "success") {
								$("#resultDiv").addClass("alert-success").removeClass("alert-danger").html(obj.message);
							}else{
								$("#resultDiv").addClass("alert-danger").removeClass("alert-success").html(obj.message);
							}
						}catch(error){
							console.log(data);
							alert(error.message);
						}
						hideResultDiv();
						$("#submitButton").html("Aggiungi");
						$("#submitButton").removeAttr("disabled");
					},
					error: function(data){
						$("#resultDiv").addClass("alert-danger").removeClass("alert-success").html("Errore");
						hideResultDiv();
					}
				});
			});
			
			function hideResultDiv(){
				setTimeout(function(){
					$("#resultDiv").slideUp();
				}, 1000);
				$("input").val("");
				$("#descrizione").val("");
			}
      
        </script>
        
	</body>
</html>