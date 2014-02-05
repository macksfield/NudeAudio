/******************************************************
    * jQuery plug-in
    * Easy Background Image Resizer
    * Developed by J.P. Given (http://johnpatrickgiven.com)
    * Useage: anyone so long as credit is left alone
******************************************************/

(function(jQuery) {
	// Global Namespace
    var jqez = {};

    // Define the plugin
    jQuery.fn.ezBgResize = function(options) {
		
		// Set global to obj passed
		jqez = options;
		
		// If img option is string convert to array.
		// This is in preparation for accepting an slideshow of images.
		if (!jQuery.isArray(jqez.img)) {
			var tmp_img = jqez.img;
			jqez.img = [tmp_img]
		}
		
		jQuery("<img/>").attr("src", jqez.img).load(function() {
			jqez.width = this.width;
			jqez.height = this.height;
			
			// Create a unique div container
			jQuery("body").append('<div id="jq_ez_bg"></div>');

			// Add the image to it.
			jQuery("#jq_ez_bg").html('<img src="' + jqez.img[0] + '" width="' + jqez.width + '" height="' + jqez.height + '" border="0">');

			// First position object
	        jQuery("#jq_ez_bg").css("visibility","hidden");

			// Overflow set to hidden so scroll bars don't mess up image size.
	        jQuery("body").css({
	            "overflow":"hidden"
	        });

			resizeImage();
		});
    };

	jQuery(window).bind("resize", function() {
		resizeImage();
	});
	
	// Actual resize function
    function resizeImage() {
	
        jQuery("#jq_ez_bg").css({
            "position":"fixed",
            "top":"0px",
            "left":"0px",
            "z-index":"-1",
            "overflow":"hidden",
            "width":jQuery(window).width() + "px",
            "height":jQuery(window).height() + "px",
			"opacity" : jqez.opacity
        });
		
		// Image relative to its container
		jQuery("#jq_ez_bg").children('img').css("position", "relative");

        // Resize the img object to the proper ratio of the window.
        var iw = jQuery("#jq_ez_bg").children('img').width();
        var ih = jQuery("#jq_ez_bg").children('img').height();
        
        if (jQuery(window).width() > jQuery(window).height()) {
            //console.log(iw, ih);
            if (iw > ih) {
                var fRatio = iw/ih;
                jQuery("#jq_ez_bg").children('img').css("width",jQuery(window).width() + "px");
                jQuery("#jq_ez_bg").children('img').css("height",Math.round(jQuery(window).width() * (1/fRatio)));

                var newIh = Math.round(jQuery(window).width() * (1/fRatio));

                if(newIh < jQuery(window).height()) {
                    var fRatio = ih/iw;
                    jQuery("#jq_ez_bg").children('img').css("height",jQuery(window).height());
                    jQuery("#jq_ez_bg").children('img').css("width",Math.round(jQuery(window).height() * (1/fRatio)));
                }
            } else {
                var fRatio = ih/iw;
                jQuery("#jq_ez_bg").children('img').css("height",jQuery(window).height());
                jQuery("#jq_ez_bg").children('img').css("width",Math.round(jQuery(window).height() * (1/fRatio)));
            }
        } else {
            var fRatio = ih/iw;
            jQuery("#jq_ez_bg").children('img').css("height",jQuery(window).height());
            jQuery("#jq_ez_bg").children('img').css("width",Math.round(jQuery(window).height() * (1/fRatio)));
        }
		
		// Center the image
		if (typeof(jqez.center) == 'undefined' || jqez.center) {
			if (jQuery("#jq_ez_bg").children('img').width() > jQuery(window).width()) {
				var this_left = (jQuery("#jq_ez_bg").children('img').width() - jQuery(window).width()) / 2;
				jQuery("#jq_ez_bg").children('img').css({
					"top"  : 0,
					"left" : -this_left
				});
			}
			if (jQuery("#jq_ez_bg").children('img').height() > jQuery(window).height()) {
				var this_height = (jQuery("#jq_ez_bg").children('img').height() - jQuery(window).height()) / 2;
				jQuery("#jq_ez_bg").children('img').css({
					"left" : 0,
					"top" : -this_height
				});
			}
		}

        jQuery("#jq_ez_bg").css({
			"visibility" : "visible"
		});

		// Allow scrolling again
		jQuery("body").css({
            "overflow":"auto"
        });
		
        
    }
})(jQuery);