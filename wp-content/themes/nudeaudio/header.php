<!doctype html class="no-js">

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">
        
        

		<!-- favicon -->
        <link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/favicon2.ico" />

		<script> var ISOLDIE = false; </script>
		<!--[if lt IE 9]>
     	<script> 
		//var ISOLDIE = true; 
		</script>
		<![endif]-->

		<!-- Google Chrome Frame for IE -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title><?php wp_title(''); ?></title>
		
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="460">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) -->
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-touch.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<!-- or, set /favicon.ico for IE10 win -->
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">
		
		<? $isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
		if($isiPad){?>
		<!--<meta name="viewport" content="width=1200, initial-scale=0.8, maximum-scale=1">-->
		<?}else{?>
		<!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
		<?}?>
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		<script type="text/JavaScript" src="<?php echo get_template_directory_uri(); ?>/library/js/imagesloaded_2.js"></script> 
		
		<!-- link to modernizr -->
		<script type="text/JavaScript" src="<?php echo get_template_directory_uri(); ?>/library/js/modernizr.custom.65122.js"></script> 
		
		<!-- wordpress head functions -->		
		<?php wp_head(); ?>
		<!-- end of wordpress head -->
		

		<script>

		     if(ISOLDIE) {
		          alert("Your browser is too old to view this site - please either use Firefox/Chrome or upgrade your version of Internet Explorer");
		          window.location = 'http://windows.microsoft.com/en-GB/internet-explorer/download-ie';
		     }

		</script>


	    <script>

		function scrollToElement(selector, time, verticalOffset) {
			time = typeof(time) != 'undefined' ? time : 500;
			verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;
			element = $(selector);
			offset = element.offset();
			offsetTop = offset.top + verticalOffset;
			$('html, body').animate({
				scrollTop: offsetTop
			}, time);			
		}
		
		// Nudge the spacing on the main nav
		function NudgeTopNav_old() {
			var top_nav_width = jQuery('.top-nav').outerWidth();
			var list_elements = jQuery('.top-nav > li').length;

			var total_elements_width = 0;
			var total_elements_outerwidth = 0;
			var total_margins = 0;
			jQuery('.top-nav > li').each(function() {
				var outer_width = jQuery(this).outerWidth(true);
				total_elements_outerwidth += outer_width;
				var margin = outer_width - jQuery(this).outerWidth();
				total_margins += margin;				
  			});
			var breathing_space = total_margins + (top_nav_width - total_elements_outerwidth);
			//console.info('breathing_space: ' + breathing_space);
			//console.info('total_margins: ' + total_margins);
			var space_multiple = breathing_space / total_margins;

  			var loopCount = 0;
  			jQuery('.top-nav > li').each(function(){
  				loopCount++;
  				var margin = jQuery(this).outerWidth(true) - jQuery(this).outerWidth();
  				var new_margin = margin * space_multiple;
  				// nudge it down slightly to allow for space anomalies
  				new_margin = new_margin * 0.99;
  				// Don't alter the last list element (which needs to have 0 right-margin)
				if (loopCount < list_elements) {
					jQuery(this).css( "margin-right", new_margin );
				}				
  			});			
		}
		
		// Nudge the spacing on the main nav
		function NudgeTopNav() {
			var top_nav_width = jQuery('.top-nav').outerWidth();
			//console.info('top_nav_width: ' + top_nav_width);
			var list_elements = jQuery('.top-nav > li').length;

			var total_elements_width = 0;
			jQuery('.top-nav > li').each(function() {
				//console.info('element width:' + jQuery(this).outerWidth());
				total_elements_width += jQuery(this).outerWidth();				
  			});
  			//console.info('total_elements_width: ' + total_elements_width);
			var breathing_space = top_nav_width - total_elements_width;

			// Don't include the last list element which needs to have 0 right-margin
			var new_margin = breathing_space / (list_elements - 1);
			//console.info('new_margin: ' + new_margin);
			// nudge it down slightly to allow for space anomalies
  			new_margin = new_margin * 0.95;

  			var loopCount = 0;
  			jQuery('.top-nav > li').each(function(){
  				loopCount++;
  				// Don't alter the last list element (which needs to have 0 right-margin)
				if (loopCount < list_elements) {
					jQuery(this).css( "margin-right", new_margin );
				}				
  			});			
		}
		
		jQuery(document).ready(function ($) {
			
			var showMenu = function() {
				// Reset to the default CSS for 'header' if 'sidebar-left' is being closed
				jQuery('body').hasClass('active-nav') ? jQuery('header').removeClass('relative') : jQuery('header').addClass('relative');
				jQuery('body').toggleClass("active-nav");
			}
			// Toggle for small screen nav menu and small screen nav mask
			jQuery('.menu-opener a, .mask').click(function(e) {
				e.preventDefault();
				showMenu();
			});
			
			// Callback at end of .mask transition, make sure the top of .sidebar-left nav is shown
			jQuery(".mask").bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(){
				scrollToElement('.sidebar-left');
			});

			// Add click action to 'social-mobile' element
			jQuery("#social-mobile a").toggle(function(){
					jQuery("#social").addClass('active');
				}, function() {
					jQuery("#social").removeClass('active');
			});

			// legal subnav tabs
			jQuery("#menu-item-483").click(function(){
				jQuery('#block1').css("display", "block");
				jQuery('#block2, #block3, #block4').css("display", "none");
  				//alert("tab1");
			});

			jQuery("#menu-item-480").click(function(){
				jQuery('#block2').css("display", "block");
				jQuery('#block1, #block3, #block4').css("display", "none");
  				//alert("tab2");
			});

			jQuery("#menu-item-481").click(function(){
				jQuery('#block3').css("display", "block");
				jQuery('#block1, #block2, #block4').css("display", "none");
  				//alert("tab3");
			});

			jQuery("#menu-item-482").click(function(){
				jQuery('#block4').css("display", "block");
				jQuery('#block1, #block2, #block3').css("display", "none");
  				//alert("tab4");
			});


			// support subnav tabs
			jQuery("#menu-item-1051").click(function(){
				jQuery('#block1').css("display", "block");
				jQuery('#block2, #block3, #block4').css("display", "none");
  				//alert("tab1");
			});

			jQuery("#menu-item-1052").click(function(){
				jQuery('#block2').css("display", "block");
				jQuery('#block1, #block3, #block4').css("display", "none");
  				//alert("tab2");
			});

			jQuery("#menu-item-1053").click(function(){
				jQuery('#block3').css("display", "block");
				jQuery('#block1, #block2, #block4').css("display", "none");
  				//alert("tab3");
			});

			jQuery("#menu-item-1054").click(function(){
				jQuery('#block4').css("display", "block");
				jQuery('#block1, #block2, #block3').css("display", "none");
  				//alert("tab4");
			});
	
			
			// scroll bar on homepage/overview/product pages	
			$("#scrollbar").click(function() {
     			$('html, body').animate({
         			scrollTop: $("#scrollbar").offset().top
     			}, 1000);
 			});
			
			
			
			
			 ccol = "";      
/*			
			$("#product-header-inner").ezBgResize({
				img     : "<?php bloginfo('stylesheet_directory'); ?>/images/Products/Move-m/product-m-heroshot.jpg", 
				opacity : 1, // Opacity. 1 = 100%.  This is optional.
				center  : true // Boolean (true or false). This is optional. Default is true.
				
			});*/
			
			
			// changes header panel
			var t = $(".header").offset().top;
			
			<?php
				global $post;
				$slug = get_post( $post )->post_name;
				$p =  get_post( $post )->ID;
			?>

			<?php // hide background on load to pages with top image panel
			//$p = get_the_ID(); // get post/page id
			$abposts=array(6,13,14,15,16,56); //posts/pages not to show background and bottom border
			
			if (in_array( $p, $abposts)) {
				$p = 2;
			}
			
			else {
				$p = 0;	
			}
			
			?>
			
			<?php if (isset($p) && ($p != '')) : ?>
			//var z = <?php $p ?>;
			<?php endif; ?>
  
			jQuery(document).scroll(function(){

				h = <?php echo get_the_ID(); ?>;
				jj= window.innerHeight;
				kk= 0;
				ss= 0; //detect if slider is showing white or grey products

				if (h == 13 || h == 14 || h == 15 || h == 16)
					kk = 2; // product pages


				// t = position from container div - to work out positioning
				// h = page id - to specify pages


				if(jQuery(this).scrollTop() > t && h !== 6 ) // has no top image banner like legal and support and not homepage
					{   
						$('.header').css('background-color','rgba(234, 237, 239, 0.85)');
						$('.header').css({"border-bottom":"1px solid #b4b6c0"});
						$('#socialbar').css({opacity:1});
						//console.log(h);
				}


				if(jQuery(this).scrollTop() <= t && h !== 6 ) // reset for all pages except home
					{   
						$('.header').css('background-color','rgba(234, 237, 239, 0.85)');
						$('.header').css({"border-bottom":"none"});
						//$('#socialbar').css({opacity:0.5});
				}


			    if (h == 6 ) { // homepage
			    	$('.header').css('background-color','#545458');
			    	$('.socialicon').css('background-position','0 28px');
			    }


			    if (kk >= 0 ) { // product pages
			    	isgreyslider = 1; // varible to detect slider is grey
			    }


				if(jQuery(this).scrollTop() < 605 && h == 6 ) // homepage change ontop of dark grey section
					{   
						navBar ();

						//greyPartOn()

						$("#logo").hover(function() {
						    $(this).css('background','url("<?php bloginfo('stylesheet_directory'); ?>/library/images/logo-mainON.png") no-repeat scroll right top transparent');
						}, function() {
						    $(this).css('background','url("<?php bloginfo('stylesheet_directory'); ?>/library/images/logo-mainONGRE.png") no-repeat scroll right top transparent');
						});	

						$(".socialicon").hover(function() {
						    $(this).css('background-position','0 56px');
						}, function() {
						    $(this).css('background-position','0 27px');
						});

						$(".home .nav li a").hover(function() {
						    $(this).css('color','#ef4a5d');
						}, function() {
						    $(this).css('color','#98e2bf');
						});
				}
			    
			    if(jQuery(this).scrollTop() >= 605 && h == 6 ) // homepage change color after dark grey area
					{   
						navBarON ();
			
						//greyPartOff();
						$("#logo").hover(function() {
						    $(this).css('background','url("<?php bloginfo('stylesheet_directory'); ?>/library/images/logo-mainON.png") no-repeat scroll right top transparent');
						}, function() {
						    $(this).css('background','url("<?php bloginfo('stylesheet_directory'); ?>/library/images/logo-main.png") no-repeat scroll right top transparent');
						});

						$(".socialicon").hover(function() {
						    $(this).css('background-position','0 56px');
						}, function() {
						    $(this).css('background-position','0 0');
						});

						$(".home .nav li a").hover(function() {
						    $(this).css('color','#ef4a5d');
						}, function() {
						    $(this).css('color','#545458');
						});
				}


				function navBarON () {
					$('.home .nav li a').css('color','#545458');
					$('.socialicon').css('background-position','0 0');
					$('.header').css('background-color','rgba(234, 237, 239, 0.85)');
					$('#logo').css('background','url("<?php bloginfo('stylesheet_directory'); ?>/library/images/logo-main.png") no-repeat scroll right top transparent');

				}

				function navBar (){
					$('.home .nav li a').css('color','#98e2bf');
					$('#logo').css('background','url("<?php bloginfo('stylesheet_directory'); ?>/library/images/logo-mainONGRE.png") no-repeat scroll right top transparent');
					$('.header').css('background-color','rgba(84, 84, 88, 0.85)');
				}

				
			}); // end scroll
			

			// Nudge top-nav element widths and margins according to available width, on load and on resize
			NudgeTopNav();
			
			var resizeTimer;
			$(window).resize(function() {
				clearTimeout(resizeTimer);
				resizeTimer = setTimeout(function(){NudgeTopNav()}, 50);
			});
					
			//rollovers for product overview page
		
			function rolloverActive(m) {

				checkActiveProduct (m);
				checkBrowWidth()
				
				//jQuery('#cta'+m).css("display", "block");
				jQuery('#block'+m+' p img').css({ opacity: 1 });
				
				if ( wid == 2 ) {  // only work for mobile
					//jQuery('#block'+m).css("background-image", "url("+ l +")");	
					jQuery('#block'+m).css("background-color", "#ddd");	

				}
				
				else {
					jQuery('#block'+m+' .product-image').css("background-image", "url("+ k +")");
					jQuery('#block'+m).css("background-color", "none");	
					//
					
				}
				
				
			}
			
			function rolloverInactive(m) {

				checkActiveProduct (m);
				checkBrowWidth()
				
				jQuery('#cta'+m).css("display", "none");
				jQuery('#block'+m+' p img').css({ opacity: 0.5 });
				
				if ( wid ==2 ) {
					//jQuery('#block'+m).css("background-image", "url("+ m +")");
					jQuery('#block'+m).css("background-color", "#ccc");	
				}
				
				else {
					jQuery('#block'+m+' .product-image').css("background-image", "url("+ j +")");
					jQuery('#block'+m).css("background-color", "none");	
				}
				
					
			}
			
			<?php if ( function_exists( 'kd_mfi_get_featured_image_url' ) ) : ?>
			function checkActiveProduct (m) {
				if (m == 1) {
					k = '<?php echo kd_mfi_get_featured_image_url( 'featured-image-14', 'page' , $size, '16' ); ?>';
					j = '<?php echo kd_mfi_get_featured_image_url( 'featured-image-13', 'page' , $size, '16' ); ?>';	
					l = '<?php echo kd_mfi_get_featured_image_url( 'featured-image-15', 'page' , $size, '16' ); ?>';
					m = '<?php echo kd_mfi_get_featured_image_url( 'featured-image-16', 'page' , $size, '16' ); ?>';
				}
				if (m == 2) {
					k = '<?php echo kd_mfi_get_featured_image_url( 'featured-image-14', 'page' , $size, '15' ); ?>';
					j = '<?php echo kd_mfi_get_featured_image_url( 'featured-image-13', 'page' , $size, '15' ); ?>';
					l = '<?php echo kd_mfi_get_featured_image_url( 'featured-image-16', 'page' , $size, '15' ); ?>';
					m = '<?php echo kd_mfi_get_featured_image_url( 'featured-image-15', 'page' , $size, '15' ); ?>';
				}
				if (m == 3) {
					k = '<?php echo kd_mfi_get_featured_image_url( 'featured-image-14', 'page' , $size, '14' ); ?>';
					j = '<?php echo kd_mfi_get_featured_image_url( 'featured-image-13', 'page' , $size, '14' ); ?>';
					l = '<?php echo kd_mfi_get_featured_image_url( 'featured-image-16', 'page' , $size, '14' ); ?>';
					m = '<?php echo kd_mfi_get_featured_image_url( 'featured-image-15', 'page' , $size, '14' ); ?>';	
				}
				if (m == 4) {
					k = '<?php echo kd_mfi_get_featured_image_url( 'featured-image-14', 'page' , $size, '13' ); ?>';
					j = '<?php echo kd_mfi_get_featured_image_url( 'featured-image-13', 'page' , $size, '13' ); ?>';
					l = '<?php echo kd_mfi_get_featured_image_url( 'featured-image-16', 'page' , $size, '13' ); ?>';
					m = '<?php echo kd_mfi_get_featured_image_url( 'featured-image-15', 'page' , $size, '13' ); ?>';	
				}
			}
			<?php endif; ?>
			
			function checkBrowWidth() {
				 wi = $(window).width();
				 wid = "0";
				 
				 if (wi <= 481){
					//console.log('mobile detected');
					wid = 2;
				 }
				 
				 else {
					 wid = 0;
				 }
			}
		
		}); // end document.ready

		</script>		

		<!-- drop Google Analytics Here -->
		<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		  ga('create', 'UA-43036657-1', 'nudeaudio.com');
		  ga('send', 'pageview');</script>
		<!-- end analytics -->

		<!-- gallery slider skin -->
		<link rel='stylesheet' href='<?php echo get_template_directory_uri(); ?>/library/js/slider/skin.css' type='text/css' media='all' />
		<!-- webfonts -->
		<script type="text/javascript" src="http://fast.fonts.com/jsapi/d6fc2c68-8371-43fd-8d1f-55485b83a5b0.js"></script>
		
		<!-- CSS theme overrides for responsive layout -->
		<link rel='stylesheet' href='<?php echo get_template_directory_uri(); ?>/overrides.css' type='text/css' media='all' />
		<link rel='stylesheet' href='<?php echo get_template_directory_uri(); ?>/library/css/blog/blog-v2.css' type='text/css' media='all' />

		<link rel='stylesheet' href='<?php echo get_template_directory_uri(); ?>/override.css' type='text/css' media='all' />
		
		<?php if(is_page_template('page-overview.php')) :?>
		<link rel='stylesheet' href='<?php echo get_template_directory_uri(); ?>/library/css/skew.css' type='text/css' media='all' />
		<link rel='stylesheet' href='<?php echo get_template_directory_uri(); ?>/library/css/overview.css' type='text/css' media='all' />
		<link rel='stylesheet' href='<?php echo get_template_directory_uri(); ?>/library/css/mobile.css' type='text/css' media='all' />

		<?php endif;?>
	
	</head>

	<body 
	
	<?php body_class(); ?> >
					
<div id="emailhideme">

			<section class="sidebar-left" role="navigation">
				<nav role="navigation">
					<?php wp_nav_menu( array('menu' => 'mobile-nav' )); ?>
				</nav>
			</section>
			
		<div id="container" class="productbgd">
			
			
			<?php
			
			
			// show different main pic
			if(is_page(6)){ //homepage
				echo'<div class="homepagebgd">';
			} 
			
			// move M
			else if(is_page(13)){
				echo'<div class="productbgd">';
			}
			
			// move L
			else if(is_page(14)){
				echo'<div class="productbgd">';
			}
			
			// move S
			else if(is_page(15)){
				echo'<div class="productbgd">';
			}
			
			// move S Wired
			else if(is_page(16)){
				echo'<div class="productbgd">';
			}
			
			// overview
			else if(is_page(56)){
				echo'<div class="overviewbgd">';
			}
			
			// contact us
			else if(is_page(2)){
				echo'<div class="contact">';
			}
			
			// contact us
			else if(is_page(53)){
				echo'<div class="legal">';
			}
			
			// galleries so Distributers / Where to buy
			//else if(is_page(57,58)){
				
				
			else if (is_page(57)) {
				echo'<div class="legal">';
			}
			
			else if (is_page(58)) {
				echo'<div class="legal">';
			}		
			
			else if (is_page(59)) {
				echo'<div class="press">';
			}	
			
			else if (is_page(530)) {
				echo'<div class="support">';
			}
	
			
			
			else {
				echo'<div  class="defaultbgd">';
			}
			
			?>
			
			
			<script>
			
	
												

				

			
			
			function showMe2(i,j){
				resetMe ();
				window.setTimeout("showMe3(i,j)",10);
			}
			
			function showMe3(i,j){
				showBlock (i);
				window.setTimeout("showMe4(i,j)",10);
			}
			
			function showMe4(i,j){
				changeOpacity (j);
			}
			
		
			
			
			

			//console.log(showMe);

			function resetMe () {
				jQuery('#highlight-block1','#highlight-block2','#highlight-block3','#highlight-block4','#highlight-block5').css({'display':'none'});
				console.log('reset working');
			}

			function showBlock (x) {
				jQuery('#highlight-block'+x).css({'display':'block'});
				console.log("Block "+x+" should show");
				console.log('show block working');

			}

			function changeOpacity (x) {
				jQuery('#highlight-block'+x).css({opacity:0.5});
				console.log('change opacity working');
			}

			function hideBlock (y) {
				jQuery('#highlight-block'+y).css({'display':'none'});
				console.log('hide block working');
			}
			
				//console.log('hello');
				
			




			function showMe () {
				jQuery("a[class='block1']").css({'display':'block'});
				console.log('mobile nav selected');
				}
				
			function HideMe () {
				jQuery('#mobile-nav').css({'display':'none'});
				console.log('mobile nav deselected');
				}

			
			
			function showMobBlock () {
				jQuery('#mobile-nav').css({'display':'block'});
				console.log('mobile nav selected');
				}
				
			function HideMobBlock () {
				jQuery('#mobile-nav').css({'display':'none'});
				console.log('mobile nav deselected');
				}
			
			
				
			function showSocialBlock () {
				jQuery('#social-nav').css({'display':'block'});
				console.log('social nav selected');
				
				}
				
			function HideSocialBlock () {
				jQuery('#social-nav').css({'display':'none'});
				console.log('social nav deselected');
				}
				
			
			 
			
			function prodHeroShot (){
			
			if(is_post(142)){ 
				prodHeroShot2("l");
			}
			
			if(is_post(223)){ 
				prodHeroShot2("m");	
				alert('should show product m');
				
			}
			
			if(is_post(224)){ 
				prodHeroShot2("s");	
			}
			
			if(is_post(225)){ 
				prodHeroShot2("swired");	
			}
			
			//alert('it works');

		}
			
			
				
			function prodHeroShot2 (s) {
						jQuery(".productbgd").css({'background': url('/wp-content/themes/eddiemachado-bones-d1b3b54/library/images/Products/Move-'+ s +'/product-'+ s +'-heroshot.jpg')});		
				}
				
				
				
				str="1";
				var n=str.replace(".png","b.png");
				
				
				
	
			
		

			</script>
			
			
		

			<header class="header" role="banner">

				<div id="inner-header" class="wrap clearfix">

					<div class="menu-opener"><a href="#menu">Menu</a></div>

					<!-- to use a image just replace the bloginfo('name') with your img src and remove the surrounding <p> -->
					<a href="<?php echo home_url(); ?>" rel="nofollow"><img id="logo" src="<?php echo get_template_directory_uri(); ?>/library/images/shim.gif" width="142" height="25" alt=""></a>
					
					<!-- just used for mobile -->
				
					<a href="javascript:showMobBlock()"><img id="menu-icon" src="<?php bloginfo('template_directory'); ?>/library/images/shim.gif"></img></a>
					
					<a href="javascript:showSocialBlock()"><img id="social-icon-mobile" src="<?php bloginfo('template_directory'); ?>/library/images/shim.gif"></img></a>
					
                    

	             
                	
					

					<!-- if you'd like to use the site description you can un-comment it below -->
					<?php // bloginfo('description'); ?>
					
					
					<div id="social-mobile">
						<a href="#social">Social</a>
					</div>
					
					<div id="social">
						<?php echo do_shortcode('[widgets_on_pages id=socialbar]'); ?>
					</div>


					<nav role="navigation">
						<?php bones_main_nav(); ?>
					</nav>				
					

				</div> <!-- end #inner-header -->

			</header> <!-- end header -->
			
			

			
			<!-- Mask to cover page content when side navigation is open -->
			<a class="mask" href="#container"></a>

