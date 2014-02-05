<?php get_header(); ?>

<?php

// Function to check for even or add number of the posts, used below for styling
function is_odd( $int ) {
	return( $int & 1 );
}

// get the page title from the Blog homepage
$blog_homepage_slug = 'news';
$blog_homepage = get_page_by_path($blog_homepage_slug);
$blog_homepage_title = get_the_title($blog_homepage->ID);

// get selected category name
$active_cat_name = single_cat_title($prefix = '', $display = false);

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

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

						<div id="main" class="eightcol first clearfix" role="main">
						
						
							<div id="plain-inner" class="blog blog-category">
							
								<div class="blog-title">
									<h1><?php echo $blog_homepage_title; ?></h1>
								</div>
						
								<div class="filters">
									<span>Filter:</span>
									<ul>
										<li class="all"><a href="<?php echo home_url('/'); ?>news">All</a></li>
										<?php echo $blog_cats; ?>
									</ul>
								</div>
								
							<?php if (have_posts()) : ?>
							
								<div class="posts masonry js-masonry" data-masonry-options='{ "columnWidth": ".grid-sizer", "itemSelector": ".post", "gutter": ".gutter-sizer" }'>
									<div class="grid-sizer"></div>
									<div class="gutter-sizer"></div>
									<?php
										$loopCount = 0; 
										while (have_posts()) : the_post();
											$loopCount++;
									?>

										<?php
											$postID 	= get_the_id();
											$categories = get_the_category($postID);
											// style odd number posts with the grey overlay, even numbers with the mint overlay
											!is_odd($loopCount) ? $info_panel_class = 'even' : $info_panel_class = 'odd';
										?>
							
										<div class="post">
											<div>
												<?php if (has_post_thumbnail()) : ?>
													<a href="<?php the_permalink() ?>"><?php echo the_post_thumbnail('full'); ?></a>
													<div class="info-panel <?php echo $info_panel_class; ?>">
														<?php echo get_the_category_list(); ?>
														<h4><a href="<?php the_permalink() ?>"><?php echo the_title(); ?></a></h4>
														<a href="<?php the_permalink() ?>" class="more">More &gt;</a>
													</div>					
												<?php else : ?>
													<div class="info-panel no-img <?php echo $info_panel_class; ?>">
														<?php echo get_the_category_list(); ?>
														<h4><a href="<?php the_permalink() ?>"><?php echo the_title(); ?></a></h4>
														<a href="<?php the_permalink() ?>" class="more">More &gt;</a>
													</div>
												<?php endif; ?>				
											</div>
										</div>

									<?php endwhile; ?>
								
								</div>
																		
								<nav class="pagination">
									<div class="newer-stories">
										<?php previous_posts_link(__('&lt;&nbsp;Newer stories', "bonestheme")) ?>
									</div>
									<div class="page-indicator"><!--Page <?php echo $paged; ?> of <?php echo $posts_query->max_num_pages; ?>--></div>
									<div class="older-stories">
										<?php next_posts_link(__('Older stories&nbsp;&gt;', "bonestheme")) ?>
									</div>
								</nav>		

							<?php else : ?>

								<p>There are no posts in this category</p>

							<?php endif; ?>
							
							</div> <!-- end #plain-inner -->

						</div> <!-- end #main -->

					</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
