$(document).ready(function() {
	
	var track_load = 0; //total loaded record group(s)
	var loading  = false; //to prevents multipal ajax loads
	//var total_groups = '<?php getTotalProducts(); ?>'; //total record group(s)
	
	
	$('.animation_image').show(); //show loading image
	$('#productsContainer').load("scripts/php/autoload_process.php", {'group_no':track_load}, function() {$('.animation_image').hide();track_load++;}); //load first group
	
	$('html').bind('mousewheel DOMMouseScroll', function(e){
		if(e.originalEvent.wheelDelta /120 > 0) {
			//('scrolling up !');
		}
		else{
			loadMore();
		}
	});			
	
	$(window).scroll(function() { //detect page scroll
		// if($(window).scrollTop() + $(window).height() == $(document).height()) // esattamante il bottom
		if($(window).scrollTop() + $(window).height() > $(document).height() -100)  //user scrolled to bottom of the page? // near the bottom
		{
			loadMore();
		}
	});
	
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) { // se sono in mobile
		var ts;
		$(document).on('scrollstart', function (e){
		   ts = e.originalEvent.touches[0].clientY;
		   if(ts>200){ // ## wolkaround per scroll up mobile
			loadMore();
		   }
		});

		$(document).on('scrollstop', function (e){
		   var te = e.originalEvent.changedTouches[1].clientY;
		   //alert("ts: " + ts + "te: " + te);
		   if(ts > te+5){
			  loadMore();
		   }else if(ts < te-5){
			  //alert("up");
		   }
		});
	}
	
	function loadMore(){
			if(track_load <= total_groups && loading==false) //there's more data to load
			{
				loading = true; //prevent further ajax loading
				$('.animation_image').show(); //show loading image
				//load data from the server using a HTTP POST request
				$.post('scripts/php/autoload_process.php',{'group_no': track_load}, function(data){
					$("#productsContainer").append(data); //append received data into the element
					//hide loading image
					$('.animation_image').hide(); //hide loading image once data is received
					track_load++; //loaded group increment
					loading = false; 
				}).fail(function(xhr, ajaxOptions, thrownError) { //any errors?
					alert(thrownError); //alert with HTTP error
					$('.animation_image').hide(); //hide loading image
					loading = false;
				}).done(function() {
					loadEvents();
				});
			}
	}
	
	function loadEvents(){
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) { // se sono in mobile
			/*
			$(".productContent").off("swiperight").on("swiperight",function(event){
				id = $(this).id;
					
				productToRemove = new Product("", id, "", "");
				cart.remove(productToRemove);
				
				styleAdded(this);
				setTimeout(styleDefault, 300, this);

				//alert("Aggiunto " + productTitle);
			});
			
			$(".productContent").off("swipeleft").on("swipeleft",function(event){
		
				id = this.firstElementChild.value;
				price = this.children[4].firstElementChild.firstElementChild.innerHTML;
				productTitle = this.children[2].firstElementChild.innerHTML;
				productDescription = this.children[3].firstElementChild.innerHTML;
					
				productToRemove = new Product(price, id, productTitle, productDescription);
				cart.remove(productToRemove);
		
				$(this).show("slide", { direction: "left" }, 1000);
				 $(this).animate({width:'toggle'},350);

				//alert("Rimosso " + productTitle);
			});
			*/
		}
	}
	

	
	
	
	
});