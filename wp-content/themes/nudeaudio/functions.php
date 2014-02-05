<?php
/*
Author: Eddie Machado
URL: htp://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

/************* INCLUDE NEEDED FILES ***************/

/*
1. library/bones.php
	- head cleanup (remove rsd, uri links, junk css, ect)
	- enqueueing scripts & styles
	- theme support functions
	- custom menu output & fallbacks
	- related post function
	- page-navi function
	- removing <p> from around images
	- customizing the post excerpt
	- custom google+ integration
	- adding custom fields to user profiles
*/
require_once('library/bones.php'); // if you remove this, bones will break
/*
2. library/custom-post-type.php
	- an example custom post type
	- example custom taxonomy (like categories)
	- example custom taxonomy (like tags)
*/
require_once('library/custom-post-type.php'); // you can disable this if you like
/*
3. library/admin.php
	- removing some default WordPress dashboard widgets
	- an example custom dashboard widget
	- adding custom login css
	- changing text in footer of admin
*/
// require_once('library/admin.php'); // this comes turned off by default
/*
4. library/translation/translation.php
	- adding support for other languages
*/
// require_once('library/translation/translation.php'); // this comes turned off by default

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bones-thumb-600', 600, 150, true );
add_image_size( 'bones-thumb-300', 300, 100, true );
/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'footer-column1',
		'name' => __('footer-column1', 'bonestheme'),
		'description' => __('Insert content for 1st column in footer here', 'bonestheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	
	register_sidebar(array(
		'id' => 'footer-column2',
		'name' => __('footer-column2', 'bonestheme'),
		'description' => __('Insert content for 2nd column in footer here', 'bonestheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	
	register_sidebar(array(
		'id' => 'footer-column3',
		'name' => __('footer-column3', 'bonestheme'),
		'description' => __('Insert content for 3rd column in footer here', 'bonestheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	
	register_sidebar(array(
		'id' => 'footer-column4',
		'name' => __('footer-column4', 'bonestheme'),
		'description' => __('Insert content for 4th column in footer here', 'bonestheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	
	register_sidebar(array(
		'id' => 'footer-column5',
		'name' => __('footer-column5', 'bonestheme'),
		'description' => __('Insert content for 5th column in footer here', 'bonestheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	
	register_sidebar(array(
		'id' => 'footer-mobile',
		'name' => __('footer-mobile', 'bonestheme'),
		'description' => __('Insert content for mobile footer here', 'bonestheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	
	register_sidebar(array(
		'id' => 'legal',
		'name' => __('legal', 'bonestheme'),
		'description' => __('Insert content for sub sections here', 'bonestheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	
	register_sidebar(array(
		'id' => 'press-releases',
		'name' => __('press-releases', 'bonestheme'),
		'description' => __('Insert content for press releases here', 'bonestheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	
	register_sidebar(array(
		'id' => 'support',
		'name' => __('support', 'bonestheme'),
		'description' => __('Insert content for support here', 'bonestheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	
	register_sidebar(array(
		'id' => 'press-mobile',
		'name' => __('press-mobile', 'bonestheme'),
		'description' => __('Insert content for press mobile here', 'bonestheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	
	
	

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __('Sidebar 2', 'bonestheme'),
		'description' => __('The second (secondary) sidebar.', 'bonestheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!

/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-author vcard">
				<?php
				/*
					this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
					echo get_avatar($comment,$size='32',$default='<path_to_url>' );
				*/
				?>
				<!-- custom gravatar call -->
				<?php
					// create variable
					$bgauthemail = get_comment_author_email();
				?>
				<img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5($bgauthemail); ?>?s=32" class="load-gravatar avatar avatar-48 photo" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
				<!-- end custom gravatar call -->
				<?php printf(__('<cite class="fn">%s</cite>', 'bonestheme'), get_comment_author_link()) ?>
				<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__('F jS, Y', 'bonestheme')); ?> </a></time>
				<?php edit_comment_link(__('(Edit)', 'bonestheme'),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
				<div class="alert alert-info">
					<p><?php _e('Your comment is awaiting moderation.', 'bonestheme') ?></p>
				</div>
			<?php endif; ?>
			<section class="comment_content clearfix">
				<?php comment_text() ?>
			</section>
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</article>
	<!-- </li> is added by WordPress automatically -->
<?php
} // don't remove this bracket!

/************* SEARCH FORM LAYOUT *****************/

// Search Form
function bones_wpsearch($form) {
	$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	<label class="screen-reader-text" for="s">' . __('Search for:', 'bonestheme') . '</label>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'.esc_attr__('Search the Site...','bonestheme').'" />
	<input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
	</form>';
	return $form;
} // don't remove this bracket!

/************* SHOW MULTIPLE FEATURED IMAGES *****************/

$args1 = array(
          'id' => 'featured-image-2',
          'post_type' => 'page',      // Set this to post or page
          'labels' => array(
              'name'      => 'Featured image 2',
              'set'       => 'Set featured image 2',
              'remove'    => 'Remove featured image 2',
              'use'       => 'Use as featured image 2',
          )
  );

  $args2 = array(
          'id' => 'featured-image-3',
          'post_type' => 'page',      // Set this to post or page
          'labels' => array(
              'name'      => 'Featured image 3',
              'set'       => 'Set featured image 3',
              'remove'    => 'Remove featured image 3',
              'use'       => 'Use as featured image 3',
          )
  );

  $args3 = array(
          'id' => 'featured-image-4',
          'post_type' => 'page',      // Set this to post or page
          'labels' => array(
              'name'      => 'Featured image 4',
              'set'       => 'Set featured image 4',
              'remove'    => 'Remove featured image 4',
              'use'       => 'Use as featured image 4',
          )
  );

  $args4 = array(
          'id' => 'featured-image-5',
          'post_type' => 'page',      // Set this to post or page
          'labels' => array(
              'name'      => 'Featured image 5',
              'set'       => 'Set featured image 5',
              'remove'    => 'Remove featured image 5',
              'use'       => 'Use as featured image 5',
          )
  );

  $args5 = array(
          'id' => 'featured-image-6',
          'post_type' => 'page',      // Set this to post or page
          'labels' => array(
              'name'      => 'Featured image 6',
              'set'       => 'Set featured image 6',
              'remove'    => 'Remove featured image 6',
              'use'       => 'Use as featured image 6',
          )
  );

  $args6 = array(
          'id' => 'featured-image-7',
          'post_type' => 'page',      // Set this to post or page
          'labels' => array(
              'name'      => 'Featured image 7',
              'set'       => 'Set featured image 7',
              'remove'    => 'Remove featured image 7',
              'use'       => 'Use as featured image 7',
          )
  );

  $args7 = array(
          'id' => 'featured-image-7',
          'post_type' => 'page',      // Set this to post or page
          'labels' => array(
              'name'      => 'Featured image 7',
              'set'       => 'Set featured image 7',
              'remove'    => 'Remove featured image 7',
              'use'       => 'Use as featured image 7',
          )
  );

  $args8 = array(
          'id' => 'featured-image-8',
          'post_type' => 'page',      // Set this to post or page
          'labels' => array(
              'name'      => 'Featured image 8',
              'set'       => 'Set featured image 8',
              'remove'    => 'Remove featured image 8',
              'use'       => 'Use as featured image 8',
          )
  );

  $args9 = array(
          'id' => 'featured-image-9',
          'post_type' => 'page',      // Set this to post or page
          'labels' => array(
              'name'      => 'Featured image 9',
              'set'       => 'Set featured image 9',
              'remove'    => 'Remove featured image 9',
              'use'       => 'Use as featured image 9',
          )
  );

  $args10 = array(
          'id' => 'featured-image-10',
          'post_type' => 'page',      // Set this to post or page
          'labels' => array(
              'name'      => 'Featured image 10',
              'set'       => 'Set featured image 10',
              'remove'    => 'Remove featured image 10',
              'use'       => 'Use as featured image 10',
          )
  );

  $args11 = array(
          'id' => 'featured-image-11',
          'post_type' => 'page',      // Set this to post or page
          'labels' => array(
              'name'      => 'Featured image 11',
              'set'       => 'Set featured image 11',
              'remove'    => 'Remove featured image 11',
              'use'       => 'Use as featured image 11',
          )
  );

  $args12 = array(
          'id' => 'featured-image-12',
          'post_type' => 'page',      // Set this to post or page
          'labels' => array(
              'name'      => 'Featured image 12',
              'set'       => 'Set featured image 12',
              'remove'    => 'Remove featured image 12',
              'use'       => 'Use as featured image 12',
          )
  );
  
  
  $args13 = array(
          'id' => 'featured-image-13',
          'post_type' => 'page',      // Set this to post or page
          'labels' => array(
              'name'      => 'Product Overview image',
              'set'       => 'Set Product Overview image',
              'remove'    => 'Remove Product Overview image',
              'use'       => 'Use as Product Overview image',
          )
  );

  $args14 = array(
          'id' => 'featured-image-14',
          'post_type' => 'page',      // Set this to post or page
          'labels' => array(
              'name'      => 'Product Overview highlighted image',
              'set'       => 'Set Product Overview highlighted image',
              'remove'    => 'Remove Product Overview highlighted image',
              'use'       => 'Use as Product Overview highlighted image',
          )
  );
  
  $args15 = array(
          'id' => 'featured-image-15',
          'post_type' => 'page',      // Set this to post or page
          'labels' => array(
              'name'      => 'Mobile Product Overview image',
              'set'       => 'Set Mobile Product Overview image',
              'remove'    => 'Remove Mobile Product Overview image',
              'use'       => 'Use as Mobile Product Overview image',
          )
  );

  $args16 = array(
          'id' => 'featured-image-16',
          'post_type' => 'page',      // Set this to post or page
          'labels' => array(
              'name'      => 'Mobile Product Overview highlighted image',
              'set'       => 'Set Mobile Product Overview highlighted image',
              'remove'    => 'Remove Mobile Product Overview highlighted image',
              'use'       => 'Use as Mobile Product Overview highlighted image',
          )
  );
  
  $args17 = array(
          'id' => 'featured-image-17',
          'post_type' => 'page',      // Set this to post or page
          'labels' => array(
              'name'      => 'Product packaging',
              'set'       => 'Set Product packaging',
              'remove'    => 'Remove Product packaging',
              'use'       => 'Use as Product packaging',
          )
  );
  
  $args18 = array(
          'id' => 'featured-image-18',
          'post_type' => 'post',      // Set this to post or page
          'labels' => array(
              'name'      => 'Secondary featured image',
              'set'       => 'Set secondary featured image',
              'remove'    => 'Remove secondary featured image',
              'use'       => 'Use as secondary featured image',
          )
  );

if ( function_exists( 'kdMultipleFeaturedImages' ) ) {
  	new kdMultipleFeaturedImages( $args1 );
  	new kdMultipleFeaturedImages( $args2 );
	new kdMultipleFeaturedImages( $args3 );
	new kdMultipleFeaturedImages( $args4 );
	new kdMultipleFeaturedImages( $args5 );
	new kdMultipleFeaturedImages( $args6 );
	new kdMultipleFeaturedImages( $args7 );
	new kdMultipleFeaturedImages( $args8 );
	new kdMultipleFeaturedImages( $args9 );
	new kdMultipleFeaturedImages( $args10 );
	new kdMultipleFeaturedImages( $args11 );
	new kdMultipleFeaturedImages( $args12 );
	new kdMultipleFeaturedImages( $args13 );
	new kdMultipleFeaturedImages( $args14 );
	new kdMultipleFeaturedImages( $args15 );
	new kdMultipleFeaturedImages( $args16 );
	new kdMultipleFeaturedImages( $args17 );
	new kdMultipleFeaturedImages( $args18 );
}


// Enqueue ez-bg-resize and imagesloaded and masonry javascripts

function ez_bg_resize_js() {
	wp_register_script( 'ez_bg_resize', get_template_directory_uri() . '/library/js/jquery.ez-bg-resize.js', array('jquery'),null,true );
	wp_enqueue_script('ez_bg_resize');	
}
add_action('wp_enqueue_scripts', 'ez_bg_resize_js');

function masonry_js() {
	wp_register_script( 'masonry', get_template_directory_uri() . '/library/js/masonry.pkgd.min.js', array('jquery'),null,true );
	wp_enqueue_script('masonry');	
}
add_action('wp_enqueue_scripts', 'masonry_js');

function imagesloaded_js() {
	wp_register_script( 'imagesloaded', get_template_directory_uri() . '/library/js/imagesloaded.js', array('jquery'),null,true );
	wp_enqueue_script('imagesloaded');	
}
add_action('wp_enqueue_scripts', 'imagesloaded_js');

?>
