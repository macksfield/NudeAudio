<?php
/*
Template Name: Homepage 
*/
?>

<?php get_header(); ?>

			<div id="content" class="home">

				<div id="inner-content" class="wrap clearfix">

						<div id="main" class="eightcol first clearfix" role="main">
							
							
								<!-- main page content -->

								<div id="homepage-header" style="background-size: cover;">
                                	<div id="homepage-header-inner">
										<?php //echo do_shortcode('[post-content id=44]'); ?>
<!-- testing -->
										<?php echo do_shortcode( '[responsive_slider]' ); ?>
                                    </div>
                                </div>
 <!-- testing -->
								
								
								
								<div id="midsection">
                                	<div id="midsection-inner">
	                                	<p class="subhead">How we do it.</p>

                                        <div id="block1"><?php echo do_shortcode('[post-content id=38]'); ?></div>
                                              
                                        <div id="hoz-bar1-mobile">
                                        	<img width="112" height="6" src="<?php bloginfo('template_directory'); ?>/library/images/hozbar-mobile.png">
                                        </div>
                                              
                                        <div id="block2"><?php echo do_shortcode('[post-content id=40]'); ?></div>
                                              
                                        <div id="hoz-bar2-mobile">
	                                        <img width="112" height="6" src="<?php bloginfo('template_directory'); ?>/library/images/hozbar-mobile.png">
                                        </div>
                                              
                                        <div id="block3"><?php echo do_shortcode('[post-content id=42]'); ?></div>
                                        <a href="overview/"><div class="button green">See our speakers</div></a>
                                        
                                        <!-- Load the 2 most recent blog posts (the 'News' and 'Events' categories) -->
                                        <?php
                                        
                                        	// Function to check for even or add number of the posts, used below for styling
                                        	function is_odd( $int ) {
	                                        	return( $int & 1 );
	                                        }
	
	                                        // set up the $args array for the wp_query
	                                        $args = array();
	                                        // get only published posts
	                                        $args['post_status'] 	= 'publish';
	                                        // determine the sort order
	                                        $args['orderby'] 		= 'date';
	                                        $args['order'] 			= 'DESC';
	                                        
	                                        // get posts from any child category of 'Blog'
	                                        $blog_cat_id = get_cat_ID( 'Blog' );							
	                                        $args=array( 
	                                        	'child_of' => $blog_cat_id
	                                        ); 
	                                        $blog_categories = get_categories($args);
	                                        $blog_categories_slugs_array = array();
	                                        foreach ($blog_categories as $blog_category) {
		                                        array_push($blog_categories_slugs_array, $blog_category->slug);
		                                    }
		                                    // create comma separated list from $blog_categories_slugs array for use below
		                                    $blog_categories_slugs = implode(',', $blog_categories_slugs_array);
								
	                                        $args['category_name']	= $blog_categories_slugs;
	                                        // Limit the query
	                                        $args['posts_per_page'] = 2;
	                                        
	                                        $posts_query = new WP_Query( $args );

	                                        if ($posts_query->have_posts()) :
	                                    ?>
                                        
                                        <hr />
                                        
                                        <p class="subhead latest-blog-posts">Latest News Posts</p>

                                        <div class="posts masonry js-masonry" data-masonry-options='{ "columnWidth": ".grid-sizer", "itemSelector": ".post", "gutter": ".gutter-sizer" }'>
	                                        <div class="grid-sizer"></div>
	                                        <div class="gutter-sizer"></div>
									
	                                        <?php
	                                        	$loopCount = 0;
	                                        	while ( $posts_query->have_posts() ) : 
	                                        		$loopCount++;
	                                        ?>
									
	                                        	<?php
		                                        	$posts_query->the_post();
		                                        	$postID 			= get_the_id();
		                                        	$headline			= get_the_title();
		                                        	$date				= get_the_date();
		                                        	$full_slug			= get_permalink();
		                                        	$categories			= get_the_category($postID);
		                                        	// style odd number posts with the grey overlay, even numbers with the mint overlay
		                                        	!is_odd($loopCount) ? $info_panel_class = 'even' : $info_panel_class = 'odd';	


		                                        	$attachID = get_post_thumbnail_id( $postID);
												 	$origionalSize = wp_get_attachment_image_src( $attachID,'full',false  ); 
													$divHeight = $origionalSize[2] / $origionalSize[1] * 473; 		

													
													// if the post has a 'secondary featured image' use that, otherwise use the standard featured image
													if (kd_mfi_get_featured_image_id( 'featured-image-18', 'post' ) != '') {
														$img_ref = kd_mfi_get_the_featured_image( 'featured-image-18', 'post', 'full', $postID );
														 
													} else if (has_post_thumbnail()) {
														$img_ref = get_the_post_thumbnail($postID, 'full');
													} else {
														$img_ref = '';
													}															                                    

	                                        	?>
										
	                                        	<div class="post"  style="max-width:450px;">
													<div>
														<?php if ($img_ref != '') : ?>
															<a href="<?php echo $full_slug; ?>"><? echo $img_ref; ?></a>
															<div class="info-panel <?php echo $info_panel_class; ?>">
																<?php echo get_the_category_list(); ?>
																<h4><a href="<?php echo $full_slug; ?>"><?php echo $headline; ?></a></h4>
																<a href="<?php echo $full_slug; ?>" class="more">More &gt;</a>
															</div>					
														<?php else : ?>
															<div class="info-panel no-img <?php echo $info_panel_class; ?>">
																<?php echo get_the_category_list(); ?>
																<h4><a href="<?php echo $full_slug; ?>"><?php echo $headline; ?></a></h4>
																<a href="<?php echo $full_slug; ?>" class="more">More &gt;</a>
															</div>
														<?php endif; ?>				
													</div>
												</div>
									
											<?php endwhile; ?>
										</div>
								
										<a href="<?php echo home_url('/'); ?>news/"><div class="button green">See more news</div></a>                                   
                                        
										<?php else : ?>
											<p>None found</p>                                         
                                        <?php endif; ?>
                                                                                     
                                	</div> <!-- end #midsection-inner -->
								</div> <!-- end #midsection -->

						</div> <!-- end #main -->

						<?php //get_sidebar(); ?>

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
