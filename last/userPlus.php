<?php
	require_once("scripts/php/tools.php");
?>

<h3>Utente</h3>
<span id="nomeSpan" class="label label-default">Nome</span>
<input id="nome" type="text" value="" name="nome" placeholder="Nome" class="form-control" />

<span id="cognomeSpan" class="label label-default">Cognome</span>
<input id="cognome" type="text" value="" name="cognome" placeholder="Cognome" class="form-control" />

<span id="codiceFiscaleSpan" class="label label-default">Codice fiscale</span>
<input id="codiceFiscale" style="text-transform: uppercase" maxlength="16" minlength="16" type="text" value="" name="codiceFiscale" placeholder="Codice fiscale" class="form-control" />

<span id="dataNascitaSpan" class="label label-default">Data di nascita</span>
<div class="input-append date">
	<input id="dataNascita" type="text" value="" name="dataNascita" placeholder="Data di nascita" class="form-control" />
</div>
<div id="dataNascitaErrorMessage" class="alert alert-danger"  role="alert" style="display: none">Devi essere maggiorenne</div>

<span id="telefonoSpan" class="label label-default">Telefono/cellulare</span>
<input id="telefono" type="text" value="" name="telefono" placeholder="Telefono/cellulare" class="form-control" />


<select class="selectpicker" id="regione" name="regione" data-width="100%" data-live-search="true">
	 <option data-hidden="true">Seleziona una regione</option>
	<?php echo getRegioni(); ?>
</select>
<!-- <span id="regioneSpan" class="label label-default">Regione</span> -->


<select class="selectpicker" id="provincia" disabled name="provincia" data-width="100%" data-live-search="true">
	 <option data-hidden="true">Seleziona una provincia</option>
	
</select>


<select class="selectpicker" id="comune" name="comune" disabled data-width="100%" data-live-search="true">
	 <option data-hidden="true">Seleziona un comune</option>
	
</select><br>

<script>							
	$('#comune, #provincia, #regione, #tipologia').selectpicker();
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
    	$('#comune, #provincia, #regione, #tipologia').selectpicker('mobile');
	}


	$("#regione").on("change", function(){
		regione = true;
		provincia = comune = false;
		
		regioneName = $('#regione option:selected').first().val();
		backgroundSuccessStyle(this.nextElementSibling.firstElementChild, false);
		$('#provincia').prop('disabled',true);
		$('#comune').prop('disabled',true);
		
		$(".bootstrap-select:gt(1):lt(3)").each(function(){
			defaultStyleNoBackground(this.firstElementChild, false);
		});
		
		$.ajax({url: "scripts/php/ajaxProvince.php?regione=" + regioneName, success: 
			function(result){
				$("#provincia").html(result);
				$('#provincia').prop('disabled',false);
				$('#provincia').selectpicker('refresh');
			}
		});
	});
	
				
	$("#provincia").on("change", function(){
		provincia = true;
		comune = false;
		
		comuneName = $('#provincia option:selected').first().val();
		backgroundSuccessStyle(this.nextElementSibling.firstElementChild, false);
		$('#comune').prop('disabled',true);
		
		$(".bootstrap-select:eq(3)").each(function(){
			defaultStyleNoBackground(this.firstElementChild, false);
		});
		
		$.ajax({url: "scripts/php/ajaxComuni.php?provincia=" + comuneName, success: 
			function(result){
				$("#comune").html(result);
				$('#comune').prop('disabled',false);
				$('#comune').selectpicker('refresh');
			}
		});
	});
	
	$("#comune").on("change", function(){
		comune = true;
		backgroundSuccessStyle(this.nextElementSibling.firstElementChild, false);
	});
	
</script>


<span id="indirizzoSpan" class="label label-default">Indirizzo</span>
<input id="indirizzo" type="text" value="" name="indirizzo" placeholder="Indirizzo" class="form-control" />


<script>
$("#telefono").on("keyup", function(){
	telefono = false;
	if($(this).val().length < 8){
		backgroundErrorStyle(this);
		if($(this).val().length == 0){
			defaultStyleNoBackground(this);
		}
	}else{
		backgroundSuccessStyle(this);
		telefono = true;
	}
});
$("#indirizzo").on("keyup", function(){
	spanID = "#" + $(this).attr("id") + "Span";
	indirizzo = false;
	
	if($(this).val().length < 4){
		backgroundErrorStyle(this);
		if($(this).val().length == 0){
			defaultStyleNoBackground(this);
		}
	}else{
		backgroundSuccessStyle(this);
		indirizzo = true;
	}
});


$("#nome, #cognome").on("keyup", function(){
	if($(this).attr("id") == "nome")
		nome = false;
	if($(this).attr("id") == "cognome")
		cognome = false;
		
	if($(this).val().length < 2 && $(this).val().length > 0){
		backgroundErrorStyle(this);
	}else if($(this).val().length >= 2){
		backgroundSuccessStyle(this);
		if($(this).attr("id") == "nome")
			nome = true;
		if($(this).attr("id") == "cognome")
			cognome = true;
	}else{
		defaultStyleNoBackground(this);
	}
});


$("#codiceFiscale").on("keyup", function(){
	codiceFiscale = false;
	
	if($(this).val().length != 16){
		backgroundErrorStyle(this);
		if($(this).val().length == 0){
			defaultStyleNoBackground(this);
		}
	}else{
		backgroundSuccessStyle(this);
		codiceFiscale = true;
	}
});

$(function(){
	$( "#dataNascita" ).datepicker("option", "showAnim", "slideDown");
	$('#dataNascita').datepicker( {
		onSelect: function(date) {
			dob = new Date(date);
			today = new Date();
			if (dob.getFullYear() + 18 > today.getFullYear())
			{
				$("#dataNascitaErrorMessage").slideDown();
				backgroundErrorStyle(this);
			}
			else
			{
				$("#dataNascitaErrorMessage").slideUp();
				backgroundSuccessStyle(this);
			}
		},
		changeMonth: true,
		changeYear: true,
		yearRange: "-100:+0"
	});
	
	$( "#dataNascita" ).datepicker($.datepicker.regional["it"]);
	$( "#dataNascita" ).datepicker( "option", "dateFormat", "yy-mm-dd");
});
</script>
