<?php
/*
Template Name: Custom Page Example
*/
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

						<div id="main" class="eightcol first clearfix" role="main">
							
							
								<!-- main page content -->

								<div id="homepage-header"><?php echo do_shortcode('[post-content id=44]'); ?></div>
								
								<p>How we do it<p/>

								<div id="block1"><?php echo do_shortcode('[post-content id=38]'); ?></div>
								<div id="block2"><?php echo do_shortcode('[post-content id=40]'); ?></div>
								<div id="block3"><?php echo do_shortcode('[post-content id=42]'); ?></div>
								

								<div class="button green">See our speakers</div>
								
								
								
								
								
								
								
								
								
								
								
								
								
								

							

						</div> <!-- end #main -->

						<?php //get_sidebar(); ?>

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
