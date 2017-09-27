<?php
	require_once("scripts/php/tools.php");
?>

<hr>
<h3>Negozio</h3>

<span id="partitaIvaSpan" class="label label-default">Partita Iva</span>
<input id="partitaIva" style="text-transform: uppercase" maxlength="11" minlength="11" type="text" value="" name="partitaIva" placeholder="Partita Iva" class="form-control" />

<span id="nomeNegozioSpan" class="label label-default">Nome negozio</span>
<input id="nomeNegozio" type="text" value="" name="nomeNegozio" placeholder="Nome negozio" class="form-control" />

<select class="selectpicker" id="tipologia" name="tipologia" data-width="100%">
	 <option data-hidden="true">Seleziona una tipologia</option>
	<?php echo getTipologiaNegozio(); ?>
</select>


<span id="telefonoNegozioSpan" class="label label-default">Telefono/cellulare Negozio</span>
<input id="telefonoNegozio" type="text" value="" name="telefonoNegozio" placeholder="Telefono/cellulare" class="form-control" />


<select class="selectpicker" id="regioneNegozio" name="regioneNegozio" data-width="100%" data-live-search="true">
	 <option data-hidden="true">Seleziona una regione</option>
	<?php echo getRegioni(); ?>
</select>


<select class="selectpicker" id="provinciaNegozio" disabled name="provinciaNegozio" data-width="100%" data-live-search="true">
	 <option data-hidden="true">Seleziona una provincia</option>
	
</select>


<select class="selectpicker" id="comuneNegozio" name="comuneNegozio" disabled data-width="100%" data-live-search="true">
	 <option data-hidden="true">Seleziona un comune</option>
	
</select><br>

<span id="indirizzoNegozioSpan" class="label label-default">Indirizzo</span>
<input id="indirizzoNegozio" type="text" value="" name="indirizzoNegozio" placeholder="Indirizzo negozio" class="form-control" />

<hr>

<script>
	
	 if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
    	$('#comuneNegozio, #provinciaNegozio, #regioneNegozio, #tipologia').selectpicker('mobile');
	}
	 
	
	$("#regioneNegozio").on("change", function(){
		regioneNegozio = true;	
		provinciaNegozio = comuneNegozio = false;
		
		regioneName = $('#regioneNegozio option:selected').first().val();
		backgroundSuccessStyle(this.nextElementSibling.firstElementChild);

		$('#provinciaNegozio').prop('disabled',true);
		$('#comuneNegozio').prop('disabled',true);
		
		$(".bootstrap-select:gt(5):lt(7)").each(function(){
			defaultStyleNoBackground(this.firstElementChild);
		});
		
		$.ajax({url: "scripts/php/ajaxProvince.php?regione=" + regioneName, success: 
			function(result){
				$("#provinciaNegozio").html(result);
				$('#provinciaNegozio').prop('disabled',false);
				$('#provinciaNegozio').selectpicker('refresh');
			}
		});
	});
	
				
	$("#provinciaNegozio").on("change", function(){
		provinciaNegozio = true;
		comuneNegozio = false;
		
		comuneName = $('#provinciaNegozio option:selected').first().val();
		backgroundSuccessStyle(this.nextElementSibling.firstElementChild);
		$('#comuneNegozio').prop('disabled',true);
		
		$(".bootstrap-select:gt(6)").each(function(){
			defaultStyleNoBackground(this.firstElementChild);
		});
		
		$.ajax({url: "scripts/php/ajaxComuni.php?provincia=" + comuneName, success: 
			function(result){
				$("#comuneNegozio").html(result);
				$('#comuneNegozio').prop('disabled',false);
				$('#comuneNegozio').selectpicker('refresh');
			}
		});
	});
	
	$("#comuneNegozio").on("change", function(){
		comuneNegozio = true;
		backgroundSuccessStyle(this.nextElementSibling.firstElementChild);
	});
	
	$("#tipologia").on("change", function(){
		backgroundSuccessStyle(this.nextElementSibling.firstElementChild);
	});
	
	$('#comuneNegozio, #provinciaNegozio, #regioneNegozio, #tipologia').selectpicker();
	
	$("#partitaIva").on("keyup", function(){
		piva = $(this).val();
		if(piva.length != 11){
			backgroundErrorStyle(this);
			if(piva.length == 0){
				defaultStyleNoBackground(this);
			}
			partitaIva = false;
		}else{
			backgroundSuccessStyle(this);
			partitaIva = true;
		}
	});
	
	$("#telefonoNegozio").on("keyup", function(){
		telefonoNegozio = false;
		if($(this).val().length < 8){
			backgroundErrorStyle(this);
			if($(this).val().length == 0){
				defaultStyleNoBackground(this);
			}
		}else{
			backgroundSuccessStyle(this);
			telefonoNegozio = true;
		}
	});
	$("#indirizzoNegozio").on("keyup", function(){
		indirizzoNegozio = false;
		if($(this).val().length < 4){
			backgroundErrorStyle(this);
			if($(this).val().length == 0){
				defaultStyleNoBackground(this);
			}
		}else{
			backgroundSuccessStyle(this);
			indirizzoNegozio = true;
		}
	});
	
	$("#nomeNegozio").on("keyup", function(){
		if($(this).attr("id") == "nome")
			nomeNegozio = false;
			
		if($(this).val().length < 2 && $(this).val().length > 0){
			nomeNegozioSpan = false;
			backgroundErrorStyle(this);
		}else if($(this).val().length >= 2){
		
			backgroundSuccessStyle(this);
				nomeNegozio = true;
		}else{
			defaultStyleNoBackground(this);
			nomeNegozio = false;
		}
	});

</script>

