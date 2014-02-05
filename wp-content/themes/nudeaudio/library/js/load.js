jQuery(document).ready(function(){
/*
jQuery('.content1').click(function(){
    jQuery('.content2').width("125%");
});

jQuery('.content2').click(function(){
    jQuery('.content2').width("0%");
});*/

	var jQuerywindow = jQuery(window);
	var documentHeight = jQuery(document).height();
	var windowHeight = jQuerywindow.height();
	var windowWidth = jQuerywindow.width();
	var scrollTop = jQuerywindow.scrollTop();
	var divOffset = jQuery('#productswipe').offset().top;
	var offset = ((windowWidth-1096)/2+800);
	
	
	//initial resize
	function resizeHelper() {
		
			if(windowWidth > 983) {
			//jQuery('.page').css('margin', '0 0 0 '+ -windowWidth*.5 +'px');
			jQuery('#productswipe').css('height', '713px');
			jQuery('.products').css('margin', '0 0 0 '+ offset +'px');
			jQuery('.products').css('width', 'auto');
			//jQuery('.products').css('height', '768px');
			jQuery('#content').css('height', 'auto');
		}
		if(windowWidth <= 983) {
			jQuery('.products').css('width', windowWidth + 'px');
			if(jQuery('.page.content2').width() > (windowWidth * .5))
			{	
				jQuery('.page.content2').css('width', '95%');
				//jQuery('.arrow-left').each(function () {
				//	jQuery(this).show("fast");
				//});
			}
			else 
			{	
				jQuery('.page.content2').css('width', '5%');
				//jQuery('.arrow-left').each(function () {
				//	jQuery(this).hide("fast");
				//});
			}
			jQuery(window).off("mousewheel DOMMouseScroll MozMousePixelScroll", myHandler);
			//jQuery('.products').css('margin', '0 0 0 ' + (windowWidth/2 - 175) + 'px');
			//jQuery('.products').css('margin', '0');
			jQuery('.products').css('margin', '0 auto');
			//jQuery('.product').css('margin', '0 auto');
			//console.log(windowWidth);
			//jQuery('.products').css('margin', '0 0 0 ' + (windowWidth/2 - 175) + 'px');
			prodsHeight = jQuery('.products').height();
			//console.log(prodsHeight);
			jQuery('#productswipe').css('height', prodsHeight +'px');
			footerOffset = prodsHeight + jQuery('#overview-header').height();
			jQuery('#content').css('height', footerOffset +'px'); 
			//jQuery('.wrapper').css('height', jQuery('.page').height() +'px');
			
			/*var arr = jQuery('#main').contents().filter(function(){return this.nodeType == 1;});
			var sum = 0;
			jQuery.each( arr, function(index, value) {
					sum += jQuery(this).height();
			});
			
			jQuery('#main').css('height', sum +'px');*/
			
			//$('#inner-content').height();
		}
	}
	

	
	jQuerywindow.on("resize", function(){
		windowHeight = jQuerywindow.height();
		windowWidth = jQuerywindow.width();
		offset = ((windowWidth-1096)/2+800);
	}).resize(function () {
		resizeHelper();
	});
	resizeHelper();
	
	function arrowFade() {
		jQuery('.arrow-left').each(function () {
			jQuery(this).toggle("fast");
		});
	}

	jQuery([jQuery('#grey'), jQuery('.arrow-right')]).each(function () {
		jQuery(this).click(function() {
		//console.log(jQuery(this));
			if(windowWidth <= 983) {
				if(jQuery('.page.content2').width() < (windowWidth * .5))
				{	
					jQuery('.page.content2').css('width', '95%');
					
					//arrowFade();
				}
			}
		});
	});
	jQuery([jQuery('#white'), jQuery('.arrow-left')]).each(function () {
		jQuery(this).click(function() {
			if(windowWidth <= 983) {
				if(jQuery('.page.content2').width() > (windowWidth * .5))
				{	
					jQuery('.page.content2').css('width', '5%');
					//arrowFade();
				}
			}
		});
	});
		
/*
    var isDragging = false;
   jQuery('.page.content2')
    .mousedown(function() {
        $(window).mousemove(function(event) {
            isDragging = true;
            
			//console.log(windowWidth, event.pageX, event.pageY);
			jQuery('.page.content2').css('width', event.pageX + 'px');
			
        });

    })
    .mouseup(function() {
        var wasDragging = isDragging;
        isDragging = false;
        $(window).unbind("mousemove");
        if (!wasDragging) {
            //click event
			console.log('click');
        }
    });

*/
	
	jQuery(window).scroll(function() 
	{
		if(windowWidth > 983) {
			//console.log(windowWidth);
			//console.log(jQuery(window).scrollTop());
			var headerHeight = 65;
			var scrollTop = jQuery(window).scrollTop(),
				divOffset = jQuery('#productswipe').offset().top - headerHeight,
				dist = (divOffset - scrollTop);
				//console.log(dist);

			//console.log(divOffset, dist);
			if (dist < 100 && dist > -50) {
				
				jQuery(window).scrollTop(divOffset);
				jQuery(window).on("mousewheel DOMMouseScroll MozMousePixelScroll", myHandler);  

				
				//console.log('hit');
			}
				//jQuery(window).off("mousewheel DOMMouseScroll MozMousePixelScroll", myHandler); 
			}
	});
	var wheelPos = 0;
	function myHandler(event, delta) { 
	//jQuery(document).unbind('mousewheel DOMMouseScroll')
	//jQuery(document).on('mousewheel DOMMouseScroll MozMousePixelScroll', function(event, delta) {	
		//console.log(delta, wheelPos);
	
				if(delta < 0)
				{
					if(wheelPos < 200)
					{wheelPos += 5;}
					else if(wheelPos == 200)
					{jQuery(window).off("mousewheel DOMMouseScroll MozMousePixelScroll", myHandler);return  }	
				}
				else
				{
					if(wheelPos > 0)
					{wheelPos -= 5;}
					else if(wheelPos == 0)
					{jQuery(window).off("mousewheel DOMMouseScroll MozMousePixelScroll", myHandler);return  }
				}

				jQuery('.content2').width(wheelPos + "%");
				
				return false;
		//});
	}
			
//HOVER
//1
	jQuery('#Swired').hover(function () {
		if(windowWidth > 983) {
			jQuery('#Swired').addClass("shadow");
			jQuery('#Swiredg').addClass("shadow")
			}
	});
	jQuery("#Swired").mouseleave(function () {
		jQuery('#Swired').removeClass("shadow")
		jQuery('#Swiredg').removeClass("shadow")
		});
	jQuery('#Swiredg').hover(function () {
		if(windowWidth > 983) {
		jQuery('#Swired').addClass("shadow")
		jQuery('#Swiredg').addClass("shadow")
			}
	});
	jQuery("#Swiredg").mouseleave(function () {
		jQuery('#Swired').removeClass("shadow")
		jQuery('#Swiredg').removeClass("shadow")
		});
	//2
	jQuery('#S').hover(function () {
		if(windowWidth > 983) {
		jQuery('#S').addClass("shadow")
		jQuery('#Sg').addClass("shadow")
			}
	});
	jQuery("#S").mouseleave(function () {
		jQuery('#S').removeClass("shadow")
		jQuery('#Sg').removeClass("shadow")
		});
	jQuery('#Sg').hover(function () {
		if(windowWidth > 983) {
		jQuery('#S').addClass("shadow")
		jQuery('#Sg').addClass("shadow")
			}
	});
	jQuery("#Sg").mouseleave(function () {
		jQuery('#S').removeClass("shadow")
		jQuery('#Sg').removeClass("shadow")
		});
	//3
	jQuery('#M').hover(function () {
		if(windowWidth > 983) {
		jQuery('#M').addClass("shadow")
		jQuery('#Mg').addClass("shadow")
			}
	});
	jQuery("#M").mouseleave(function () {
		jQuery('#M').removeClass("shadow")
		jQuery('#Mg').removeClass("shadow")
		});
	jQuery('#Mg').hover(function () {
		if(windowWidth > 983) {
		jQuery('#M').addClass("shadow")
		jQuery('#Mg').addClass("shadow")
			}
	});
	jQuery("#Mg").mouseleave(function () {
		jQuery('#M').removeClass("shadow")
		jQuery('#Mg').removeClass("shadow")
		});

	//4
	jQuery('#L').hover(function () {
		if(windowWidth > 983) {
		jQuery('#L').addClass("shadow")
		jQuery('#Lg').addClass("shadow")
			}
	});
	jQuery("#L").mouseleave(function () {
		jQuery('#L').removeClass("shadow")
		jQuery('#Lg').removeClass("shadow")
		});
	jQuery('#Lg').hover(function () {
		if(windowWidth > 983) {
		jQuery('#L').addClass("shadow")
		jQuery('#Lg').addClass("shadow")
			}
	});
	jQuery("#Lg").mouseleave(function () {
		jQuery('#L').removeClass("shadow")
		jQuery('#Lg').removeClass("shadow")
	});

});