<?php
/*
Template Name: Support with subnav
*/
?>

<?php get_header(); ?>

			<div id="content" class="support-inner">
				
					

				<div id="inner-content" class="wrap clearfix navbar">
					
				<h2>Support</h2>	
				
					
					
			

						<div id="main" class="eightcol first clearfix" role="main">
							
							
						<div id="legal-subnav">
							
							<?php echo do_shortcode('[widgets_on_pages id=support]'); ?>
							
						</div>	
					
						
						<div class="support-content">
                        
                        	<?php //echo do_shortcode('[post-content id=855]'); ?>


                        	<div id="block1">
								<?php echo do_shortcode('[post-content id=855]'); ?>
							</div>

							<div id="block2"> 
								<?php echo do_shortcode('[post-content id=861]'); ?>
							</div>

							<div id="block3"> 
								<?php echo do_shortcode('[post-content id=863]'); ?>
							</div>

							<div id="block4"> 
								<?php echo do_shortcode('[post-content id=862]'); ?>
							</div>
												
							
						</div>	

						</div> <!-- end #main -->

						<?php //get_sidebar(); ?>

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
