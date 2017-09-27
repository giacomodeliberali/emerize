var nome = cognome = codiceFiscale = telefono = regione = provincia = comune = indirizzo = username = password = false;
var nomeNegozio = telefonoNegozio = regioneNegozio = provinciaNegozio = comuneNegozio = indirizzoNegozio = partitaIva = false;

$("#username").on("keyup", function(){
	//ajax su database per verificare che sia univoco
	username = false;
	self = this;
	if($(self).val() != ""){
		backgroundLoadStyle(self);
		$.ajax({url: "scripts/php/ajaxCheckUsername.php?username=" + $(this).val(), success: function(result){
			if(result=="free"){
				backgroundSuccessStyle(self);
				$("#usernameErrorMessage").slideUp();
				username = true;
			}else{
				backgroundErrorStyle(self);
				$("#usernameErrorMessage").slideDown();
				username = false;
			}
		}});
	}else{
		defaultStyleNoBackground(self);
	}
});




$("#passwordRepeat").on("keyup", function(){
	password = false;
	
	if($("#password").val() != $("#passwordRepeat").val()){
		backgroundErrorStyle(this);
		$("#passwordErrorMessage").slideDown();
	}else{
		backgroundSuccessStyle(this)
		$("#passwordErrorMessage").slideUp();
		password = true;
	}
});

$("#password").on("keyup", function(){
	password = false;
	if($("#password").val().length >= 8){
		backgroundSuccessStyle(this);
		$("#passwordTooShort").slideUp();
	}else{
		$("#passwordTooShort").slideDown();
		backgroundErrorStyle(this);
	}
	$("#passwordRepeat").val("");
});

$("#regForm").on("submit", function(event){
	event.preventDefault();
	
	/*
	console.clear();
	console.log("Utente----------------------");
	console.log("Nome: \t\t\t\t\t\t" + nome);
	console.log("Cognome: \t\t\t\t\t" + cognome);
	console.log("codiceFiscale: \t\t\t\t" + codiceFiscale);
	console.log("telefono: \t\t\t\t\t" + telefono);
	console.log("regione: \t\t\t\t\t" + regione);
	console.log("provincia: \t\t\t\t\t" + provincia);
	console.log("comune: \t\t\t\t\t" + comune);
	console.log("indirizzo: \t\t\t\t\t" + indirizzo);
	console.log("username: \t\t\t\t\t" + username);
	console.log("password: \t\t\t\t\t" + password);
	
	console.log("Negozio----------------------");
	console.log("nomeNegozio: \t\t\t\t\t\t" + nomeNegozio);
	console.log("partitaIva: \t\t\t\t\t" + partitaIva);
	console.log("telefonoNegozio: \t\t\t\t" + telefonoNegozio);
	console.log("regioneNegozio: \t\t\t\t\t" + regioneNegozio);
	console.log("provinciaNegozio: \t\t\t\t\t" + provinciaNegozio);
	console.log("comuneNegozio: \t\t\t\t\t" + comuneNegozio);
	console.log("indirizzoNegozio: \t\t\t\t\t" + indirizzoNegozio);
	*/
	submit = false;

	if(!negozio){
		if(nome && cognome && codiceFiscale && telefono && regione && provincia && comune && indirizzo && username && password){
			submit = true;
		}
	}else{
		if(nome && cognome && codiceFiscale && telefono && regione && provincia && comune && indirizzo && nomeNegozio && partitaIva && telefonoNegozio && regioneNegozio && provinciaNegozio && comuneNegozio && indirizzoNegozio && username && password){
			submit = true;
		}
	}

	if(submit){
		//alert("OK");
		$("#uploadingAccount").show();
		var formData = new FormData(this);
		$.ajax({
			type:'POST',
			url: "scripts/php/ajaxRegistration.php",
			data:formData,
			cache:false,
			contentType: false,
			processData: false,
			success:function(result){
				if (result == "success user" || result == "success all") {
					html = "<h3>Registrazione completata, Grazie!</h3><small>Verrai ora reiderizzato al login tra <span id='secs'>5</span> secondi</smaill><script>setInterval(function(){var actualValue = $('#secs').html();if (actualValue == '1') {location.href='index.php';}else{$('#secs').html(+actualValue - +1);}}, 1000);</script>";
					$("#container-login").css("background", "rgba(152, 255, 124, 0.65)").html(html);
				}else{
					html = "<h3>Errore nel processo di registrazione. <br>Riprovare o contattare l'<a href='mailto:deliberali.giacomo@gmail.com'>amministratore</a></h3>";
					$("#container-login").css("background", "rgba(255, 0, 0, 0.4)").html(html);
				}
				$(".animation_image").slideUp();
				$("#uploadingAccount").hide();
			}
		});
	}else{
		//alert("NON OK");
		$(".label-default").addClass("label-danger").removeClass("label-default");
		
		$(":disabled").each(function(){
			$(this).next().children().eq(0).css("border", "1px solid red");
		});
		
		$(".bootstrap-select > button").each(function(){
			if(this.firstElementChild.innerHTML.indexOf("Seleziona") == 0){
				$(this).css("border", "1px solid red");
			}
		});
	}
	

	
});