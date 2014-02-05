<?php
/*
Template Name: About page
*/
?>

<?php get_header(); ?>

			<div id="content" class="about">

				<div id="inner-content" class="wrap clearfix">

						<div id="main" class="eightcol first clearfix jcenter" role="main">
							
							
								<!-- main page content -->
								
								<div id="tick-top"><img width="35" height="35" src="<?php bloginfo('template_directory'); ?>/library/images/about-dash.png"></div>

								<div id="about-header">
                                	<div id="about-intro"><?php echo do_shortcode('[post-content id=386]'); ?></div>
									<div id="about-intro1"><?php echo do_shortcode('[post-content id=382]'); ?></div>
									<div id="about-intro2"><?php echo do_shortcode('[post-content id=384]'); ?></div>
								</div>
                                
                                <hr>
								
								<div id="midsection">
									<p class="subhead">How we do it.</p>
										<div id="block1"><?php echo do_shortcode('[post-content id=373]'); ?></div>
										<div id="block2"><?php echo do_shortcode('[post-content id=375]'); ?></div>
										<div id="block3"><?php echo do_shortcode('[post-content id=376]'); ?></div>
								</div>	
	
                                <hr>
	
								<div id="about-desc1"><?php echo do_shortcode('[post-content id=366]'); ?></div>
								<div id="about-desc2"><?php echo do_shortcode('[post-content id=370]'); ?></div>
	
                                <hr class="extended">
	
								<div id="tick-bottom"><img width="35" height="35" src="<?php bloginfo('template_directory'); ?>/library/images/about-dash.png">
								    <p class="subfooter">Happy Listening.</p>
								</div>
								
								
									
								


						</div> <!-- end #main -->

						<?php //get_sidebar(); ?>

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
