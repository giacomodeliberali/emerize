$(window).bind('beforeunload', function(){
			
	var myString = JSON.stringify(cart);
	
	setCookie("cart", myString, 15);
	
	//return "wanna close?";

});


	cookie = getCookie("cart");
	if(cookie == null || cookie == "" || cookie === 'undefined'){
		cart = new Cart();
	}else{
		obj = JSON.parse(cookie);
		cart = new Cart(obj);
	}
	cart.refreshGUI();
