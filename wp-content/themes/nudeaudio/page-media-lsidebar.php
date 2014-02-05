<?php
/*
Template Name: Media with left sidebar
*/
?>

<?php get_header(); ?>



			<div id="content" class="product">
				
				<!--<div id="press-mobile"><?php //echo do_shortcode('[widgets_on_pages id=press-mobile]'); ?></div>-->
				
				

				<div id="inner-content" class="wrap clearfix navbar">

						<div id="main" class="presspage eightcol first clearfix" role="main">
							
							

												
							<div id="pressrelease-side">
							
								<div id="press-offices"><?php echo do_shortcode('[post-content id=519]'); ?></div>
								
								<div id="twitter"><img src="<?php bloginfo('template_directory'); ?>/library/images/press-twitter-icon.png" width="25" height="25">
										   <p><a href="#">Follow NudeAudio on Twitter</a></p>	
								</div>
								
								<img id="media-library" src="<?php bloginfo('template_directory'); ?>/library/images/press-media-library-pic.png" width="300" height="240">
							
							</div>
							
							
							<div id="pressrelease-main">
								<!--
								Catalogue of releases<br>
								
								[[drop-down list]]
								-->
								<div id="prelease"><?php echo do_shortcode('[post-content id=509 show_title=1]'); ?></div>

							</div>
							
							
							<div id="pressrelease-about">
								<?php echo do_shortcode('[post-content id=513]'); ?>
							</div>
							
							
							
							
							
							
							

						</div> <!-- end #main -->

						<?php //get_sidebar(); ?>

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
