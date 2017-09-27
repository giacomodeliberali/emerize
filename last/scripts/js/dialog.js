$(function() {

	$( "#dialog" ).dialog({
		width: "auto", 
		maxWidth: 800,
		autoOpen: false,
		fluid: true,
		resizable: false,
		draggable: false,
		modal: true,
		position: { my: 'top', at: 'top+150' },
		show: {
			effect: "fade",
			duration: 400,
		},
		hide: {
			effect: "fade",
			duration: 100
		}, open: function(event, ui) {
			//alert(scrollY + 30 + "px");
			$(".ui-dialog").css("top", scrollY + 30 + "px");
			if (highlight != "") {
				$("tr.cartProductRow#" + highlight).css("background-color", "rgba(91, 192, 222, 0.22);");
				$("tr.cartProductRow#" + highlight).wtf();
				highlight = "none";
			}
			
		}
	});
	
	$( "#opener" ).click(function() {
		openDialog();
	});

});

function openDialog(){
	scrollY = document.body.scrollTop;
	cart.refreshGUI();
	highlight = "none";
	$("#dialog").dialog("open");
}

function closeCartDialog(){
	$("#dialog").dialog("close");
}

$(window).resize(function () {
	fluidDialog();
});

function fluidDialog() {
	var $visible = $(".ui-dialog:visible");
	// each open dialog
	$visible.each(function () {
		var $this = $(this);
		var dialog = $this.find(".ui-dialog-content").data("ui-dialog");
		// if fluid option == true
		if (dialog.options.fluid) {
			var wWidth = $(window).width();
			// check window width against dialog width
			if (wWidth < (parseInt(dialog.options.maxWidth) + 50))  {
				// keep dialog from filling entire screen
				$this.css("max-width", "90%");
			} else {
				// fix maxWidth bug
				$this.css("max-width", dialog.options.maxWidth + "px");
			}
			//reposition dialog
			dialog.option("position", dialog.options.position);
		}
	});

}
