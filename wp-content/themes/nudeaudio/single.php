<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix navbar">

					<div id="main" class="eightcol first clearfix" role="main">
					
						<!-- Show category or categories -->
						<div class="categories">
						<?php
						$post_id = get_the_ID();
						/*foreach((get_the_category($post_id)) as $category) :
							echo '<div class="category">' . $category->cat_name . '</div>';
						endforeach;*/
						
						echo get_the_category_list();
						
						// Prepare URLs for Pinterest links below
						$permalink_encoded = urlencode(get_permalink());
						// Prepare image URL
						if (has_post_thumbnail()) {

							$featured_image_id = get_post_thumbnail_id();
							$image_attributes = wp_get_attachment_image_src( $featured_image_id, 'full' );
							$img_url = $image_attributes[0];
							
							$img_url_encoded = urlencode($img_url);
							
						} else {
							$fallback_img_url = 'http://nudeaudio.com/wp-content/themes/eddiemachado-bones-d1b3b54/library/images/pintrest_holder.png';
							$img_url_encoded = urlencode($fallback_img_url);
						}
						// Prepare post title for description parameter
						$title_encoded = urlencode(get_the_title());
						
						// http://pinterest.com/pin/create/button/?url={URI-encoded URL of the page to pin}&media={URI-encoded URL of the image to pin}&description={optional URI-encoded description}
						$pinterest_url = 'http://pinterest.com/pin/create/button/?url=' . $permalink_encoded . '&media=' . $img_url_encoded . '&description=' . $title_encoded;
						?>
						</div>
						
						<div id="plain-inner" class="blog single">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">
								
									<p class="back-to-blog-index"><a href="<?php echo home_url('/'); ?>news">Back to News Index</a></p>

									<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
									<div class="meta">
										<p class="byline vcard align-left">Posted: <?php echo get_the_time('d_m_Y'); ?></p>
										<div class="social">
											<span>Share:</span>
											<ul class="align-right">
												<li><a href="http://www.facebook.com/sharer.php?u=<?php echo the_permalink(); ?>&t=<?php echo get_the_title(); ?>" class="facebook" target="_blank">Facebook</a></li>
												<li><a href="http://twitter.com/home?status=<?php echo get_the_title(); ?> <?php echo the_permalink(); ?>" class="twitter" target="_blank">Twitter</a></li>
												<li><a href="<?php echo $pinterest_url; ?>" class="pinterest" target="_blank">Pinterest</a></li>
												<li><a href="<?php echo home_url('/'); ?>contact-us/" class="contact">Contact</a></li>
											</ul>
										</div>
										
									</div>									

								</header> <!-- end article header -->

								<section class="entry-content clearfix" itemprop="articleBody">
									<?php the_content(); ?>
								</section> <!-- end article section -->
								
								<div class="meta bottom">
									<p class="back"><a href="<?php echo home_url('/'); ?>news">Back</a></p>
									<div class="social">
										<span>Share:</span>
										<ul class="align-right">
											<li><a href="http://www.facebook.com/sharer.php?u=<?php echo the_permalink(); ?>&t=<?php echo get_the_title(); ?>" class="facebook" target="_blank">Facebook</a></li>
											<li><a href="http://twitter.com/home?status=<?php echo get_the_title(); ?> <?php echo the_permalink(); ?>" class="twitter" target="_blank">Twitter</a></li>
											<li><a href="<?php echo $pinterest_url; ?>" class="pinterest" target="_blank">Pinterest</a></li>
											<li><a href="<?php echo home_url('/'); ?>contact-us/" class="contact">Contact</a></li>
										</ul>
									</div>									
								</div>

								<footer class="article-footer">
									<?php the_tags('<p class="tags"><span class="tags-title">' . __('Tags:', 'bonestheme') . '</span> ', ', ', '</p>'); ?>

								</footer> <!-- end article footer -->

							</article> <!-- end article -->

						<?php endwhile; ?>

						<?php else : ?>

							<article id="post-not-found" class="hentry clearfix">
									<header class="article-header">
										<h1><?php _e("Oops, Post Not Found!", "bonestheme"); ?></h1>
									</header>
									<section class="entry-content">
										<p><?php _e("Uh Oh. Something is missing. Try double checking things.", "bonestheme"); ?></p>
									</section>
									<footer class="article-footer">
											<p><?php _e("This is the error message in the single.php template.", "bonestheme"); ?></p>
									</footer>
							</article>

						<?php endif; ?>
						
						<div class="blog-sidebar">
							<p class="other-recent-posts">Other recent news posts</p>
							
<?php

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
	// exclude the current post
	$args['post__not_in'] 	= array(get_the_id());
	// Limit the query (set through Reading > Settings)
//	$args['posts_per_page'] = get_option('posts_per_page');
	// Limit the query
	$args['posts_per_page'] = 3;
	
	
	$recent_posts_query = new WP_Query( $args );
	
	if ($recent_posts_query->have_posts()) :
?>
		<div class="recent-posts masonry js-masonry" data-masonry-options='{ "columnWidth": ".grid-sizer", "itemSelector": ".recent-post", "gutter": ".gutter-sizer" }'>
			<div class="grid-sizer"></div>
			<div class="gutter-sizer"></div>
<?php
		$loopCount = 0;
		while ( $recent_posts_query->have_posts() ) :

			$loopCount++;
			$recent_posts_query->the_post();
		
			$postID 			= get_the_id();
			$headline			= get_the_title();
			$date				= get_the_date();
			$full_slug			= get_permalink();
			$categories			= get_the_category($postID);
			// style odd number posts with the grey overlay, even numbers with the mint overlay
			!is_odd($loopCount) ? $info_panel_class = 'even' : $info_panel_class = 'odd';
?>
			<div class="recent-post">
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
					</div>					<?php endif; ?>				
				</div>
			</div>
<?php endwhile; ?>
		</div>
<?php endif; ?>


							
						</div> <!-- end sidebar -->
						
						</div> <!-- end #plain-inner -->

					</div> <!-- end #main -->

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
