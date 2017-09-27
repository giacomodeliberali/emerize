<?php
	require_once("securityAdmin.php");
?>
<html>
	<head>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1" >
		<meta charset="utf-8" />

		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="styles/bootstrap/bootstrap-theme.min.css" />
		<link rel="stylesheet" type="text/css" href="styles/style.css" />
		<link rel="stylesheet" type="text/css" href="styles/jquery/jquery-ui.css" />
		
		<script src="scripts/js/md5.js"></script>
				
		<link rel="stylesheet" href="styles/bootstrap/bootstrap-table.css">
		
		<title>Emerize - Informazioni utente</title>	
	</head>
	<body>
		<?php
			require_once("scripts/php/header_footer.php");
			require_once("scripts/php/tools.php");
			getHeaderNoCart();
		?>

		<div class="container">
			<div class="title">Il mio account</div>
			<p align="right"><a onclick="ModificaAccount()">Modifica account</a>&nbsp;&nbsp;<a onclick="CambiaPassword()">Cambia password</a></p>
			<div id="account" class="account">
				<?php echo getInformation(); ?>
			</div>
			
			<script type="text/javascript" src="scripts/js/jquery/jquery-1.11.2.min.js"></script>
			<script type="text/javascript" src="scripts/js/jquery/jquery-ui.min.js"></script>		
			<script type="text/javascript" src="scripts/js/bootstrap/bootstrap.min.js"></script>
			<script src="scripts/js/bootstrap/bootstrap-table.js"></script>
			<script src="scripts/js/bootstrap/bootstrap-table-it-IT.js"></script>
			<script src="scripts/js/bootstrap/bootstrap-table-mobile.js"></script>
			<script src="scripts/js/config.js"></script>
			<script src="scripts/js/tools.js"></script>
			<script type="text/javascript">

				var Result;
				var username;
				var Username=$("#username").find("span").html();
				var Name=$("#name").find("span").html();
				var Surname=$("#surname").find("span").html();
				var Birthday=$("#birthday").find("span").html();
				var Telephone=$("#telephone").find("span").html();
				var CAP=$("#cap").find("span").html();
				var Municipality=$("#municipality").find("span").html();
				var Province=$("#province").find("span").html();
				var Region=$("#region").find("span").html();
				var Street=$("#street").find("span").html();
				var Pass=$("#password").find("span").html();
				var NewPass;

			function Controlla() {
				var Ricerca=$("#Ricerca").val();
				if(Ricerca=="") {
                	alert("Inserisci la data dell' ordine");
            	} else {
            		var data=/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/;
                    if(Ricerca.search(data)==-1){
                    	alert("Errore di sintassi sulla data");
                    } else {
                    	$.post("scripts/php/ajaxOrder.php?p="+Ricerca, function(result, status){
							document.getElementById("orders").innerHTML=result;
						});
                    }
            	}
			}

			function ModificaAccount() {
				document.getElementById("account").innerHTML='<form name="AccountForm" method="POST"><div class="form-group"><label for="InputUsername">Username</label><input type="Username" class="form-control" id="InputUsername" name="InputUsername" placeholder="Username"></div><div class="form-group"><label for="InputName">Nome</label><input type="Name" class="form-control" id="InputName" name="InputName" placeholder="Nome"></div><div class="form-group"><label for="InputSurname">Cognome</label><input type="Surname" class="form-control" id="InputSurname" name="InputSurname" placeholder="Cognome"></div><div class="form-group"><label for="InputBirthday">Data di nascita</label><input type="Birthday" class="form-control" id="InputBirthday" name="InputBirthday" placeholder="Data di nascita"></div><div class="form-group"><label for="InputTelephone">Telefono</label><input type="Telephone" class="form-control" id="InputTelephone" name="InputTelephone" placeholder="Telefono"></div><div class="form-group"><label for="InputCAP">CAP</label><input type="CAP" class="form-control" id="InputCAP" name="InputCAP" placeholder="CAP"></div><div class="form-group"><label for="InputMunicipality">Comune</label><input type="Municipality" class="form-control" id="InputMunicipality" name="InputMunicipality" placeholder="Comune"></div><div class="form-group"><label for="InputProvince">Provincia</label><input type="Province" class="form-control" id="InputProvince" name="InputProvince" placeholder="Provincia"></div><div class="form-group"><label for="InputRegion">Regione</label><input type="Region" class="form-control" id="InputRegion" name="InputRegion" placeholder="Regione"></div><div class="form-group"><label for="InputStreet">Indirizzo</label><input type="Street" class="form-control" id="InputStreet" name="InputStreet" placeholder="Indirizzo"></div><button type="button" class="btn btn-default" onclick="Invia1()">Invia</button>&nbsp;&nbsp;<button type="button" class="btn btn-default" onclick="Annulla()">Annulla</button></form>';
				document.getElementById("InputUsername").value=Username;
				document.getElementById("InputName").value=Name;
				document.getElementById("InputSurname").value=Surname;
				document.getElementById("InputBirthday").value=Birthday;
				document.getElementById("InputTelephone").value=Telephone;
				document.getElementById("InputCAP").value=CAP;
				document.getElementById("InputMunicipality").value=Municipality;
				document.getElementById("InputProvince").value=Province;
				document.getElementById("InputRegion").value=Region;
				document.getElementById("InputStreet").value=Street;
			}

			function CambiaPassword() {
				document.getElementById("account").innerHTML='<form name="PasswordForm" method="POST"><div class="form-group"><label for="InputPassword">Old password</label><input type="password" class="form-control" id="InputPassword" name="InputPassword" placeholder="Password"></div><div class="form-group"><label for="InputPassword1">New password</label><input type="password" class="form-control" id="InputPassword1" name="InputPassword1" placeholder="Password"></div><div class="form-group"><label for="InputPassword2">Confirm password</label><input type="password" class="form-control" id="InputPassword2" placeholder="Password"><label style="display:none;" for="InputPassword3">Password</label><input style="display:none;" type="password" class="form-control" id="InputPassword3" name="InputPassword3" placeholder="Password"></div><button type="button" class="btn btn-default" onclick="Invia2()">Invia</button>&nbsp;&nbsp;<button type="button" class="btn btn-default" onclick="Annulla()">Annulla</button></form>';
			}

			function Invia1() {
				 if((document.getElementById("InputUsername").value && document.getElementById("InputName").value && document.getElementById("InputSurname").value && document.getElementById("InputBirthday").value && document.getElementById("InputTelephone").value && document.getElementById("InputMunicipality").value && document.getElementById("InputStreet").value && document.getElementById("InputCAP").value && document.getElementById("InputProvince").value && document.getElementById("InputRegion").value)=="") {
				 	alert("Compilare tutti i campi");
				 } else {
				 	username=document.AccountForm.InputUsername.value;
				 	if(username != Username) {
				 	 	$.get("scripts/php/ajaxCheckUsername.php?username="+username, function(result, status){
				 	 		// alert(result);
							if(result=="free") {
								document.AccountForm.action="modificaAccount.php";
								document.AccountForm.submit();
							} else {
								alert("Errore!!! Username non disponibile")
							}
						});
				 	} else {
				 		document.AccountForm.action="modificaAccount.php";
						document.AccountForm.submit();
				 	}
				 	// alert(Result);
				 	// if(Result == 1 || username == Username) {
				 		// /*var CAP1=document.getElementById("InputCAP").value;
				 		// var Comune=document.getElementById("InputMunicipality").value;
				 		// var Provincia=document.getElementById("InputProvince").value;
				 		// var Regione=document.getElementById("InputRegion").value;
				 		// if(CAP != CAP1) {
				 			// $.get("scripts/php/ajaxCheckHome.php?CAP="+CAP1, function(result, status){
								// alert(result);
							// });
				 		// }*/
							// document.AccountForm.action="modificaAccount.php";
							// document.AccountForm.submit();
					// }
				}
			}

			function Invia2() {
				if((document.getElementById("InputPassword").value && document.getElementById("InputPassword1").value && document.getElementById("InputPassword2").value)=="") {
					alert("Compilare tutti i calmpi");
				} else {
					if(CryptoJS.MD5(document.getElementById("InputPassword").value).toString()!=Pass) {
						alert("Errore vecchia password");
					} else {
						if(document.getElementById("InputPassword1").value!=document.getElementById("InputPassword2").value) {
							alert("Errore le nuove password non coincidono!!!!")
						} else {
							NewPass=CryptoJS.MD5(document.getElementById("InputPassword2").value).toString();
							document.getElementById("InputPassword3").value=NewPass;
							document.PasswordForm.action="modificaPassword.php"
							document.PasswordForm.submit();
						}
					}
				}
			}

			function Annulla() {
				$.post("scripts/php/ajaxInformation.php", function(result, status){
					document.getElementById("account").innerHTML=result;
				});
			}

			function Ordina(sort) {
				$.post("scripts/php/ajaxOrder.php?q="+sort, function(result, status){
					document.getElementById("orders").innerHTML=result;
				});
			}


			$(function(){
			 $( "#InputBirthday" ).datepicker("option", "showAnim", "slideDown");
			 $('#InputBirthday').datepicker( {
			  onSelect: function(date) {
			   dob = new Date(date);
			   today = new Date();
			   if (dob.getFullYear() + 18 > today.getFullYear())
			   {
			   	alert("Errore non sei maggiorenne");
			   }
			  },
			  changeMonth: true,
			  changeYear: true,
			  yearRange: "-100:+0"
			 });
			 
			 $( "#InputBirthday" ).datepicker($.datepicker.regional["it"]);
			 $( "#InputBirthday" ).datepicker( "option", "dateFormat", "yy-mm-dd");
			});

			</script>

			<div class="orders"	id="orders">
				<?php include("templateMyOrders.html"); ?>
				<script>
					/*
					$.post("scripts/php/ajaxOrder.php", function(result, status){
							document.getElementById("orders").innerHTML=result;
					});
					*/
					
				</script>
			</div>	
		</div>
	</body>
</html>