<?php
/*
Template Name: Legal with subnav
*/
?>

<?php get_header(); ?>

			<div id="content" class="legal-inner" style="margin-top:0">
				
					

				<div id="inner-content" class="wrap clearfix navbar">
					
				<h2>Legal</h2>	
				
					
					
			

						<div id="main" class="eightcol first clearfix" role="main">
							
							
						<div id="legal-subnav">
							
							<?php echo do_shortcode('[widgets_on_pages id=legal]'); ?>
							
						</div>	
					
						
						<div class="legal-content">	
							<div class="inner" style="width:700px; margin:auto;">
						    <div id="block1">
								<?php echo do_shortcode('[post-content id=221]'); ?>
							</div>

							<div id="block2"> 
								<?php echo do_shortcode('[post-content id=405]'); ?>
							</div>

							<div id="block3"> 
								<?php echo do_shortcode('[post-content id=409]'); ?>
							</div>

							<div id="block4"> 
								<?php echo do_shortcode('[post-content id=403]'); ?>
							</div>
						</div>
						</div>	

						</div> <!-- end #main -->

						<?php //get_sidebar(); ?>

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
