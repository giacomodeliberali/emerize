/**
 * Summary
 * 
 * @param   {string} path url del file su cui fare il post
 * @param   {Type} params   parametri da passare in post: es. {nome:"nome"}
 * @param   {Type} method   optional, post
 * 
 * @returns {Type} Description
 */
function post(path, params, method) {
    method = method || "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
}

function backgroundLoadStyle(self){
        $(self).css("background-image","url(\"images/ajax-loader.gif\")");
        $(self).css("background-repeat","no-repeat");
        $(self).css("background-position","85% 50%");
        
        
        spanID = "#" + $(self).attr("id") + "Span";
        $(spanID).removeClass("label-success").addClass("label-default").removeClass("label-danger");
        $(self).css("border", "1px solid #ccc");
}

function backgroundErrorStyle(self){
        $(self).css("background-image","url(\"images/error1.png\")");
        $(self).css("background-repeat","no-repeat");
        $(self).css("background-position","85% 50%");
        
        spanID = "#" + $(self).attr("id") + "Span";
        $(spanID).removeClass("label-success").addClass("label-default").removeClass("label-danger");
        $(self).css("border", "1px solid #ccc");
}

function backgroundSuccessStyle(self){
        if($(self).css("border-color") === "rgb(255, 0, 0)"){
            $(self).css("border-color", "#ccc");
        }
        
        $(self).css("background-image","url(\"images/tick.png\")").removeClass("label-danger");
        $(self).css("background-repeat","no-repeat");
        $(self).css("background-position","85% 50%");
        
        
        spanID = "#" + $(self).attr("id") + "Span";
        $(spanID).addClass("label-success").removeClass("label-default").removeClass("label-danger");
        $(self).css("border", "1px solid #ccc");
}

function defaultStyleNoBackground(self){
        $(self).css("background-image","none");
        
        spanID = "#" + $(self).attr("id") + "Span";
        $(spanID).removeClass("label-success").addClass("label-default").removeClass("label-danger");
        $(self).css("border", "1px solid #ccc");
}

function arrotonda(numb){
	return (Math.round(numb*100)/100).toFixed(2);
}

function deleteFromTable(what, id){
    $.post("scripts/php/manageDelete.php", {what: what, id:id}, function(result, status){
            
		switch(what){
			case "utenti":
                url = "scripts/php/listUsers.php"
				break;
			case "negozi":
                url = "scripts/php/listMarkets.php"; 
				break;
			case "prodotti":
                url = "scripts/php/listProducts.php";
				break;
			case "segnalazioni":
                url = "scripts/php/listReports.php";
				break;
			case "ordini":
                url = "scripts/php/listNewAssignments.php?all=true";
				break;
		}
            
            $("#"+what).bootstrapTable('refresh', {
                url: url
            });
            objResponse = JSON.parse(result);
            if (objResponse.state == "fail") {
                console.log(objResponse.state);
                console.log(objResponse.message);
                console.log(objResponse.details);
                alert(objResponse.message);
            }
            
    });
}

function htmlEntities(value){
    return value.replace(/[\u00A0-\u9999<>\&]/gim, function(i) {
        return '&#'+i.charCodeAt(0)+';';
    })
}