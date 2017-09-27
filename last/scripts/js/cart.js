

function Product(price, id, productTitle, productDescription){
	this.price = price;
	this.id = id;
	this.productTitle = productTitle;
	this.productDescription = productDescription;
	this.number = 1;
}



function Cart(rowJSON){
	this.products = [];
	this.total = 0;
	
	if(typeof rowJSON === 'undefined'){

	}else{
		for(i=0;i<rowJSON.products.length;i++){
			this.products[i] = rowJSON.products[i];
		}
		this.total = rowJSON.total;
	}

	
	
	this.add = function(product){
		// guardo nell'array se c'è già il prodotto, in caso affermativo aggiorno la quantità (e il prezzo), altrimenti lo aggiungo
		
		this.total += +product.price;
		
		//alert("Il prodotto da aggiungere/aggiornare è " + product.id);
		var found = false;
		for(i=0;i<this.products.length;i++){
			//alert("product["+i+"].id = " + this.products[i].id + ", product.id = " + product.id + ", product.number = " + this.products[i].number);
			if(this.products[i].id == product.id){ // il prdotto c'è già
				productToUpdate = this.products[i];
				//alert("Il prodotto " + productToUpdate.id + " esiste già. La sua quantità è " + productToUpdate.number);
				productToUpdate.number++;
				//alert("Quantita aggiornata di "+productToUpdate.id+" è " + productToUpdate.number);
				found = true;
			}
		}
		
		if (!found){
			this.products.push(product);
			//alert("Il prodotto appena aggiunto è " + product.id);
		}
		
		this.refreshGUI();
		
		

	}//fine add()
	
	this.remove = function(product){
		this.total -= +product.price;
		//productsToString();
		for(i=0;i<this.products.length;i++){
			if(this.products[i].id == product.id){
				productToUpdate = this.products[i];
				if(productToUpdate.number>1){
					productToUpdate.number--;
				}else{
					 $("#badge" + this.products[i].id).html("0");
					 this.products.splice(i, 1); // rimuovo dal'array dall'indice i un solo elemento
				}
				this.refreshGUI();
			}
		}
	}//fine remove
	
	this.getNumber = function(product){ // ritorna la quantità di prodotti prodotto nel carrello
		for(i=0;i<this.products.length;i++){
			if(this.products[i].id == product.id){
				return this.products[i].number;
			}
		}
	}	
	this.refreshGUI = function(){
		$(".cartProductRow").remove();
		
		totalElements = 0;
		overPrice = 0;
		totalPrice = 0;
		productsPrice = 0;

		
		for(i=0;i<this.products.length;i++){
			$("#badge" + this.products[i].id).html(cart.getNumber(this.products[i]));
			productsPrice+=this.products[i].number * this.products[i].price;
			totalElements += this.products[i].number;
			$("#cartAppendProduct").prepend("<tr class='cartProductRow' id="+this.products[i].id+"><td>"+this.products[i].productTitle+"</td><td>"+this.products[i].number+"</td><td>"+this.products[i].price+"&nbsp&#8364;</td><td style='width: 30px;'><center><div class='btn-remove' onclick='removeProduct(this)'>X</div></center></td></tr>");
		}
		
		
		percentage = productsPrice*earnQuote;
		overPrice = +percentage + +fixedPrice;
		if (overPrice>maxOverPrice) {
			overPrice = maxOverPrice;
		}
		totalPrice = +productsPrice + +overPrice;
		this.total = arrotonda(totalPrice);
		$("#cartAppendTotalPrice").html(arrotonda(productsPrice)); 
		$("#cartAppendTotalPriceConsegna").html(arrotonda(totalPrice));
		$("#cartAppendOverPrice").html(arrotonda(overPrice));
		
		$("#appendCartSize").html(totalElements); // imposto gli elementi del carrello nel header
		
		
		if(this.products.length==0){
			$(".badgeProducts").html("0");
			$("#cartAppendProduct").prepend("<tr class='cartProductRow' id='empty'><td>Carrello vuoto</td><td>0</td><td>0&nbsp&#8364;</td><td></td></tr>");
		}
	}
	
	this.empty = function(){	
		this.products = [];
		this.refreshGUI();
	}
	
	this.removeAll = function(id){ // togliere dal carrello il prodotto con id passato
		for(i=0;i<this.products.length;i++){
			if(this.products[i].id == id){
				//console.log(this.products);
				this.products.splice(i, 1);
				//console.log(this.products);
			}
		}
		this.refreshGUI();
	}
	

} // function Cart

function addToCart(self){ // self = buttonAggiungi
	id = $(self).closest(".productContent").attr("id");
	price = $(self).children().first().html();
	productTitle = $(self).parent().parent().find("#productTitle").html();
	productDescription = $(self).parent().parent().find("#productDescription").html();
	
	
	productToAdd = new Product(price, id, productTitle, productDescription);
	cart.add(productToAdd);
	buttonStyleAdded(self);
	setTimeout(restoreDefaults, 500, self);
	
				
	$(self).parent().find(".badge").first().html(cart.getNumber(productToAdd));
			
}

function buttonStyleAdded(self){
	$(self).children().first().next().next().html("&#10004;");
}

function restoreDefaults(self){
	//$(self).children().first().next().next().css("padding-left", "10px");
	$(self).children().first().next().next().html("Aggiungi");
}
				
function removeProduct(self){
	id = self.parentNode.parentNode.parentNode.id 
	cart.remove(new Product("", id, "", ""));
}

function emptyCart(){
	cart.products = [];
	cart.refreshGUI();
}

function runOrder(){
	if (cart.total>35) {
		//post("overview.php", {cart: JSON.stringify(cart)});
		location.href = "overview.php";
	}else{
		$("#cartAlert").slideDown();
		setTimeout(function(){$("#cartAlert").slideUp();}, 3000)
		//alert("Spesa minima 35 euro");
	}
}



