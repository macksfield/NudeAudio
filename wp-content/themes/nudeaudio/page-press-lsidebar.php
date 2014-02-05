<?php
/*
Template Name: Press with left sidebar
*/
?>

<?php get_header(); ?>



			<div id="content" class="product">
				
				<!--<div id="press-mobile"><?php //echo do_shortcode('[widgets_on_pages id=press-mobile]'); ?></div>-->
				
				

				<div id="inner-content" class="wrap clearfix navbar">

						<div id="main" class="presspage eightcol first clearfix" role="main">
							
							

												
							
							
							
							<div id="pressrelease-main">
								
								<!--Catalogue of releases<br>
								
								[[drop-down list]]-->
								<?php
								//WordPress loop for custom post type
								 $my_query = new WP_Query('post_type=press-release&posts_per_page=4');
									  while ($my_query->have_posts()) : $my_query->the_post(); ?>

										<h2><?php the_title(); ?></h2>
                
										<div class="content">
										   <?php the_content(); ?>
										</div>

								<?php endwhile;  wp_reset_query(); ?>
							
							
								

							</div>
							
							<div id="pressrelease-side">
							
								<div id="press-offices"><?php echo do_shortcode('[post-content id=519]'); ?></div>
								
								<div id="twitter"><img src="<?php bloginfo('template_directory'); ?>/library/images/press-twitter-icon.png" width="25" height="25">
										   <p><a href="https://twitter.com/nudeaudio">Follow NudeAudio on Twitter</a></p>	
								</div>
								
								<a href="http://nudeaudio.com/media"><img id="media-library" src="<?php bloginfo('template_directory'); ?>/library/images/press-media-library-pic.png" width="302" height="221"></a>
							
							</div>
							
							
							<div id="pressrelease-about">
								<?php echo do_shortcode('[post-content id=513]'); ?>
							</div>
							
							
							
							
							
							
							

						</div> <!-- end #main -->

						<?php //get_sidebar(); ?>

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
