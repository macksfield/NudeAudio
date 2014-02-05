<?php
/*
Template Name: Blog homepage
*/
get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix navbar">

					<div id="main" class="eightcol first clearfix” role="main">
					
						
						
						<div id="plain-inner" class="blog blog-homepage">
						
							<div class="blog-title">
								<h1><?php echo the_title(); ?></h1>
							</div>
						
							<?php 
								// get all blog categories for the filter list below
								$blog_cat_id = get_cat_ID( 'Blog' );
								$args = array(
									'use_desc_for_title' => 0,
									'child_of'			=> $blog_cat_id,
									'echo'				=> 0,
									'title_li'			=> ''
								);
								$blog_cats = wp_list_categories($args);
							?>
						
							<div class="filters">
								<span>Filter:</span>
								<ul>
									<li class="all"><a href="<?php echo home_url('/'); ?>news">All</a></li>
									<?php echo $blog_cats; ?>
								</ul>
							</div>
						
							<!-- Show any page regular content -->
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
								<?php the_content(); ?>
							<?php endwhile; endif; ?>
							
							<!-- List all posts in the 'News' and 'Events' categories -->
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
								
								// get posts from either the 'events' or 'news' category
								$args['category_name']	= $blog_categories_slugs;
								// Limit the query
								$args['posts_per_page'] = get_option('posts_per_page');
								// Pagination
								$paged 					= get_query_var('paged');
								$args['paged'] 			= $paged;	
								// We use $paged below to indicate which page we're on, on the first page $paged will be 0, we need it to be 1 for display
								if ($paged == 0) $paged = 1;
	
								$posts_query = new WP_Query( $args );
	
								if ($posts_query->have_posts()) :
							?>
								<ul class="posts masonry js-masonry" data-masonry-options='{ "columnWidth": ".grid-sizer", "itemSelector": ".post", "gutter": ".gutter-sizer" }'>
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

										?>
										
										<li class="post <?php echo $li_class; ?>  recent-posts">
											<div>
												<?php if (has_post_thumbnail()) : ?>
													<a href="<?php echo $full_slug; ?>"><?php echo the_post_thumbnail('full'); ?></a>
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
										</li>
									
									<?php endwhile; ?>
								</ul>
								
<div class="nomorenews" style="text-transform: uppercase; display:none; text-align: center;" >No more news</div>
								<!-- Pagination -->
								<?php
									if (  $posts_query->max_num_pages > 1 ) : 
								?>
									<nav class="pagination">
										<div class="newer-stories" style=“display:none”>
											<?php echo get_previous_posts_link( '&lt;&nbsp;Newer stories', $posts_query->max_num_pages ); ?>
										</div>
										<div class="page-indicator"><!--Page <?php echo $paged; ?> of <?php echo $posts_query->max_num_pages; ?>--></div>
										<div class="older-stories" style=“display:none”>
											<?php echo get_next_posts_link( 'Older stories&nbsp;&gt;', $posts_query->max_num_pages ); ?>
										</div>
									</nav>	
								<?php endif; ?>
								
								<?php if (function_exists('bones_page_navi')) { ?>
										<?php bones_page_navi(); ?>
								<?php } else { ?>
										<nav class="wp-prev-next">
											<ul class="clearfix">
												<li class="prev-link"><?php next_posts_link(__('&laquo; Older', "bonestheme")) ?></li>
												<li class="next-link"><?php previous_posts_link(__('Newer &raquo;', "bonestheme")) ?></li>
											</ul>
										</nav>
								<?php } ?>
								
							<?php endif; ?>

						
						</div> <!-- end #plain-inner -->

					</div> <!-- end #main -->

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
