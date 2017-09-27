	function actionFormatter(value, row, index) {
		return [
			'<a class="remove" style="color: red" title="Elimina">',
			'<i class="glyphicon glyphicon-remove"></i>',
			'</a>'
		].join('');
	}

	function modifyAccount(value, row, index) {
		return [
			'<a onclick="location.href=\'Utente.php?Codice=' + row.Codice_fiscale + '\'" class="btn btn-small btn-info" style="padding: 2px;" title="Modifica">Modifica',
            '</a>'
		].join('');
	}
				
	window.actionEvents = {
		'click .remove': function (e, value, row, index) {
			what = e.target.parentElement.parentElement.parentElement.parentElement.parentElement.id;
			if (what=="utenti") {
				id = row.Codice_fiscale;
				title = "utente";
			}else if (what=="negozi") {
				id = row.Partita_iva;
				title = "negozio";
			}else if (what=="ordini") {
				id = row.Codice_Ordine;
				title = "ordine";
			}else if (what=="segnalazioni") {
				id = row.Codice;
				title = "segnalazione";
			}
			//console.log(e.target.parentElement.parentElement.parentElement.parentElement.parentElement.what);
				$( "#dialog-confirm" ).dialog({
					resizable: false,
					height:180,
					modal: true,
					title: "Eliminare " + title + "?",
					open: function(){
						text = "Vuoi davvero eliminare " + (title=="segnalazione"?"la ": (title=="utente" || title=="ordine"?"l'":"il ")) + title + " con ID: '" + id + "'?";
						$(this).html(text);
					},
					buttons: {
						Confirm : {
								click : function(){
								deleteFromTable(what, id);
								$(this).dialog('close');
								},
								class: "btn btn-sm btn-danger",
								text: "Conferma",
								tabIndex: -1
							},
						Cancel: {
							click : function() {
								$( this ).dialog( "close" );
							},
							class: "btn btn-sm",
							text: "Annulla",
							tabIndex: -1
						}
					}
				});
		}
	};
	
	function openReport(value, row, index) {
        return [
            '<a href="Segnalazione.php?Codice=' + row.Codice + '" class="btn btn-small btn-info" style="padding: 2px;" title="Apri">Apri',
            '</a>'
        ].join('');
    }

    function openOrder(value, row, index) {
    	return [
            '<a href="orderAdmin.php?Codice=' + row.Codice + '" class="btn btn-small btn-info" style="padding: 2px;" title="Apri">Apri',
            '</a>'
        ].join('');
    }
		
				
	function runningFormatter(value, row, index) {
		return index;
	}
		
	