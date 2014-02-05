
            
            <footer id="newsletter-signup">

				<div id="inner-newsletter-signup">

					<span><strong>Stay tuned.</strong> Sign up for our newsletter:</span>

					<?php echo do_shortcode('[widgets_on_pages id=email-signup]'); ?> <!--c22c test -->

				</div>
			</footer>


            <footer class="footer" role="contentinfo">

				<div id="inner-footer" class="wrap clearfix">

					<nav role="navigation">
						<?php bones_footer_links(); ?>
					</nav>

					
				
					<ul class="bottomnav">
					<li><?php echo do_shortcode('[widgets_on_pages id=footer-column1]'); ?></li>
					<li><?php echo do_shortcode('[widgets_on_pages id=footer-column2]'); ?></li>
					<!--<li><?php //echo do_shortcode('[widgets_on_pages id=footer-column3]'); ?></li>-->
					<li><?php echo do_shortcode('[widgets_on_pages id=footer-column4]'); ?></li>
					<li><?php echo do_shortcode('[widgets_on_pages id=footer-column5]'); ?></li>
					</ul>
				   
					<?php echo do_shortcode('[widgets_on_pages id=footer-mobile]'); ?>
				
					<p class="source-org copyright">&copy; <?php echo date('Y'); ?> NudeAudio. All rights reserved. See our <a href="<?php echo home_url('/'); ?>legal">terms of use</a>.</p>
                
                </div> <!-- end #inner-footer -->

			</footer> <!-- end footer -->

		</div> <!-- end #container -->

	</div>

	<script type='text/javascript' src='http://nudeaudio.com/wp-includes/js/jquery/ui/jquery.ui.widget.min.js'></script>
<script type='text/javascript' src='http://nudeaudio.com/wp-includes/js/jquery/ui/jquery.ui.mouse.min.js'></script>
<script type='text/javascript' src='http://nudeaudio.com/wp-includes/js/jquery/ui/jquery.ui.sortable.min.js'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var slider = {"effect":"slide","delay":"3200","duration":"600","start":"1"};
/* ]]> */
</script>
<script type='text/javascript' src='http://nudeaudio.com/wp-content/plugins/responsive-slider/responsive-slider.js'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var infinite_scroll = "{\"loading\":{\"msgText\":\"Loading...\",\"finishedMsg\":\"<em>No additional posts.<\\\/em>\",\"img\":\"http:\\\/\\\/nudeaudio.com\\\/wp-content\\\/plugins\\\/infinite-scroll\\\/img\\\/ajax-loader.gif\"},\"nextSelector\":\".older-stories a\",\"navSelector\":\".pagination\",\"itemSelector\":\".post\",\"contentSelector\":\".posts\",\"debug\":false,\"behavior\":\"\",\"callback\":\"var container = jQuery('.posts');\\r\\nvar newElems = jQuery(newElements);\\r\\n\\\/\\\/ hide new items while they are loading\\r\\nnewElems.css({ opacity: 0 });\\r\\n\\\/\\\/ ensure that images load before adding to masonry layout\\r\\nnewElems.imagesLoaded(function(){\\r\\n\\\/\\\/ show elems now they're ready\\r\\nnewElems.animate({ opacity: 1 });\\r\\ncontainer.masonry( 'appended', newElems, true );\\r\\n});\"}";
/* ]]> */
</script>
<script type='text/javascript' src='http://nudeaudio.com/wp-content/plugins/infinite-scroll/js/front-end/jquery.infinitescroll.js'></script>

<script type='text/javascript' src='http://development.jjmarketing.co.uk/nudeaudio/wp-content/themes/nudeaudio/library/js/imagesloaded.js'></script>
<!--<script type='text/javascript' src='http://development.jjmarketing.co.uk/nudeaudio/wp-content/themes/nudeaudio/library/js/scripts.js'></script>-->
<script type="text/javascript">
// Because the `wp_localize_script` method makes everything a string
infinite_scroll = jQuery.parseJSON(infinite_scroll);

jQuery( infinite_scroll.contentSelector ).infinitescroll( infinite_scroll, function(newElements, data, url) { eval(infinite_scroll.callback); });
</script>
	
		<!-- Start wp_footer(); -->
		<?php wp_footer(); ?>
		<!-- End wp_footer(); -->

				


		<!-- all js scripts are loaded in library/bones.php -->
		
		 <!-- gallery slider -->
		<script src="<?php echo get_template_directory_uri(); ?>/library/js/slider/jquery.ui.min.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/library/js/slider/SLIDER.app.js"></script>
		<script>SLIDER.app.init();</script>

		<script src="<?php echo get_template_directory_uri(); ?>/library/js/locator/LOCATION.app.js"></script>
		<script>LOCATION.app.init();</script>

	<?php
		// only load auto-reload code for local version of site
		if (strpos($_SERVER["SERVER_NAME"], 'localhost') !== false) :
	?>
	<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
	<?php endif; ?>


	
	</body>

</html>