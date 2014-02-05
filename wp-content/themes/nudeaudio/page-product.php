<?php
/*
Template Name: Product Page
*/
?>








<?php get_header(); ?>


<?
	global $post;
	$slug = get_post( $post )->post_name;
	$id =  get_post( $post )->ID;
?>



<!-- For scalable header images -->
        <script>if ( window != window.top ) { document.documentElement.style.minHeight = "125%"; }</script>
        <script src="<?php bloginfo('stylesheet_directory'); ?>/library/js/jquery.backgroundSize.js" type="text/javascript"></script>
        <script src="<?php bloginfo('stylesheet_directory'); ?>/library/js/jquery.transform2d.js" type="text/javascript"></script>
				
        <script type="text/javascript">

//
// System detect (OS, browser version etc. Needed to detect for iOS below and adjust width and height of <video> element
//
var systemDetect = {
  init: function () {

    /* Browser & OS */
    this.userAgent = navigator.userAgent;
    this.browser = this.searchString(this.dataBrowser) || "unknown";
    this.browserVersion = this.searchVersion(navigator.userAgent) || this.searchVersion(navigator.appVersion) || "unknown";
    this.OS = this.searchString(this.dataOS) || "unknown";
    this.device = this.searchString(this.dataDevice) || "unknown";
    this.UA = navigator.userAgent;

    /* Browser detect, reject, accept */
    this.DRA = 'accept';

    /* Viewport */
    this.viewPort();

    var data = this.dataDRA;
    for (var i = 0; i < data.length; i++)  {

      if(this.browser == data[i].browser || data[i].browser == 'all') {
        if(this.OS == data[i].OS || data[i].OS == "all") {
          if(data[i].version !== "all") {
            if(parseFloat(this.browserVersion) < parseFloat(data[i].version)) {
              this.DRA = data[i].DRA;
            }
          } else {
            this.DRA = data[i].DRA;
          }
        }
      }
    }

  },
  searchString: function (data) {
    for (var i = 0; i < data.length; i++)  {
      var dataString = data[i].string;
      var dataProp = data[i].prop;
      this.versionSearchString = data[i].versionSearch;
      if (dataString) {
        if (dataString.indexOf(data[i].subString) != -1) {
          return data[i].identity;
        }
      }
      else if (dataProp)
        return data[i].identity;
    }
  },
  searchVersion: function (dataString) {
    var start = dataString.indexOf(this.versionSearchString);
    if (start == -1) return;
    start = start + this.versionSearchString.length;
    var finish = dataString.indexOf(" ", start);
    if (finish == -1) {
      return dataString.substring(start);
    } else {
      return dataString.substring(start, finish);
    }
  },
  viewPort: function () {
    // the more standards compliant browsers (mozilla/netscape/opera/IE7) use window.innerWidth and window.innerHeight
    if (typeof window.innerWidth != 'undefined') {
      this.viewportWidth = window.innerWidth;
      this.viewportHeight = window.innerHeight;
    }

    // IE6 in standards compliant mode (i.e. with a valid doctype as the first line in the document)
    else if (typeof document.documentElement != 'undefined' && typeof document.documentElement.clientWidth != 'undefined' && document.documentElement.clientWidth !== 0) {
      this.viewportWidth = document.documentElement.clientWidth;
      this.viewportHeight = document.documentElement.clientHeight;
    }

    // older versions of IE
    else {
      this.viewportWidth = document.getElementsByTagName('body')[0].clientWidth;
      this.viewportHeight = document.getElementsByTagName('body')[0].clientHeight;
    }
  },
  dataBrowser:[   { string: navigator.userAgent, subString: "Chrome", versionSearch: "Chrome/", identity: "chrome" },
          { string: navigator.userAgent, subString: "Safari", identity: "safari", versionSearch: "Version/" },
          { prop: window.opera, identity: "opera", versionSearch: "Version/" },
          { string: navigator.userAgent, subString: "Firefox", identity: "firefox", versionSearch: "Firefox/" },
          { string: navigator.userAgent, subString: "MSIE", identity: "explorer", versionSearch: "MSIE " }
        ],
  dataOS:     [   { string: navigator.platform, subString: "Win", identity: "windows" },
          { string: navigator.platform, subString: "Mac", identity: "mac" },
          { string: navigator.userAgent, subString: "iPhone", identity: "ios" },
          { string: navigator.userAgent, subString: "iPad", identity: "ios" },
          { string: navigator.userAgent, subString: "iPod", identity: "ios" },
          { string: navigator.userAgent, subString: "Android", identity: "android" },
          { string: navigator.platform, subString: "Linux", identity: "linux" }
        ],
  dataDevice: [   { string: navigator.userAgent, subString: "iPad", identity: "ipad" },
          { string: navigator.platform, subString: "iPhone", identity: "iphone" },
          { string: navigator.userAgent, subString: "iPod", identity: "ipod" }
        ],
  dataDRA:    [   { browser: "chrome", version: "20", OS: "all", DRA: "warn" },
          { browser: "safari", version: "4", OS: "all", DRA: "warn" },
          { browser: "opera", version: "9", OS: "all", DRA: "warn" },
          { browser: "firefox", version: "17", OS: "all", DRA: "warn"  }
        ]

};
systemDetect.init();
        
        /* iOS video dimensions fix */
        function iosVideoDimensions () {
	        var video_player = document.getElementById('video-player');
	        if(video_player !== null) {
		        var t = ((video_player.offsetWidth / 16) * 9);
		        video_player.style.height = t.toString() + "px";
		    }
		}
      
        // For scalable header images
        jQuery(function() {
        
        	//if (systemDetect.OS == "ios") iosVideoDimensions();
			
			// Hide video for all iOS devices
			if (systemDetect.OS == "ios") {
				jQuery("video").hide();
				jQuery(".video-fallback").show();
			} else {
				if (Modernizr.video) {
					jQuery(".video-fallback").hide();			
				} else {
					jQuery(".video-fallback").show();
				}			
			}


        });
        
        </script>


<?php // use featured image 1 as main image header
$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
$j = $feat_image;
?>

<?php
	// used below in #fairpricesection-inner
	$mm = get_the_ID();
?>

<?php

	// The WP uploads directory
	$upload_dir = wp_upload_dir();
	$upload_dir_url = $upload_dir['baseurl'];

	// Which product? Prepare the variables used to show the video and initial product info content
	switch($slug){
		case 'move-s-wired':
			$product_name = 'Move S Wired';
			$video_name = 'S-wired';
			$product_info_post_id = 225;
			$midsection_content_id = 1140;
			$bottomsection_content_id = 1149; // Products > Move S Wired Features – below slider
											// 428 : Features > TeamPlay
											// 910 : 8hr Battery (Move S Wired)
			$fairpricesection_content_id = 839;
			// Workaround to cater for not being able to set a featured image on Move L and Move S Wired pages
			$j = $upload_dir_url . '/2013/08/MoveSWired-cropped.jpg';
			break;
		case 'move-s':
			$product_name = 'Move S';
			$video_name = 'S';
			$product_info_post_id = 224;
			$midsection_content_id = 1139;
			$bottomsection_content_id = 1150; // Products > Move S Features – below slider
											// 166 : Bluetooth (Move S)
											// Previously 910 : 8hr Battery (Move S Wired), Now 164 : 8hr Battery (Move S)
			$fairpricesection_content_id = 825;
			break;
		case 'move-m':
		case 'move-m-debug':
			$product_name = 'Move M';
			$video_name = 'M';
			$product_info_post_id = 142;
			$midsection_content_id = 1138;
			$bottomsection_content_id = 1151; // Products > Move M Features – below slider
											// Previously 166 : Bluetooth (Move S), Now 897 : Bluetooth (Move M)
											// Previously 910 : 8hr Battery (Move S Wired), Now 911 : 8hr Battery (Move M)
			$fairpricesection_content_id = 688;
			break;	
		case 'move-l':
		default:
			$product_name = 'Move L';
			$video_name = 'L';
			$product_info_post_id = 223;
			$midsection_content_id = 1137; // Products > Move L Features – above slider
			$bottomsection_content_id = 1152; // Products > Move L Features – below slider -> 
											// Previously 166 : Bluetooth (Move S), Now 899 : Bluetooth (Move L)
											// Previously 910 : 8hr Battery (Move S Wired), Now 912 : 8hr Battery (Move L)
			$fairpricesection_content_id = 695; // Features > Fair price policy (Move L)
			// Workaround to cater for not being able to set a featured image on Move L and Move S Wired pages
			$j = $upload_dir_url . '/2013/08/MoveL.jpg';
			break;
	}
?>

			<div id="content" class="product">
				

				<div id="inner-content" class="wrap clearfix navbar">

						<div id="main" class="eightcol first clearfix" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">

								</header> <!-- end article header -->

								<section class="entry-content clearfix" itemprop="articleBody">
									<div id="product-header">
										<div id="video-container-new" style="display:block">
											<img class="video-fallback" src="<?php echo $j; ?>" alt="<?php echo $product_name; ?>" />
											<video id="video-player" autoplay <?php if ($slug !== 'move-l') : ?>loop<?php endif; ?> poster="<?php echo $j; ?>" webkit-playsinline>
												<!--<source src="http://shapeshed.com/examples/HTML5-video-element/video/320x240.m4v" type='video/webm; codecs="vp8, vorbis"'>-->
												<source class="mp4" src="<?php echo get_template_directory_uri(); ?>/video/<?php echo $video_name; ?>.mp4" type="video/mp4; codecs=vp8, vorbis" />
												<source class="webm" src="<?php echo get_template_directory_uri(); ?>/video/<?php echo $video_name; ?>.webm" type="video/webm; codecs=vp8,vorbis" />
												<source class="ogv" src="<?php echo get_template_directory_uri(); ?>/video/<?php echo $video_name; ?>.theora.ogv" type="video/ogg; codecs=theora,vorbis" />
												<source class="mp4" src="<?php echo get_template_directory_uri(); ?>/video/<?php echo $video_name; ?>.iphone.mp4" type="video/mp4; codecs=vp8, vorbis" />
												<source class="mp4" src="<?php echo get_template_directory_uri(); ?>/video/<?php echo $video_name; ?>.ipad.mp4" type="video/mp4; codecs=vp8, vorbis" />
											</video>
											<!-- Reference mp4 for debugging
											<source src="http://shapeshed.com/examples/HTML5-video-element/video/320x240.m4v" type='video/webm; codecs="vp8, vorbis"'> -->
											
											<div id="product-info">
												<?php echo do_shortcode('[post-content id=' . $product_info_post_id . ']'); ?>
											</div><!-- end product-info -->
										</div>
										<a title="Where to buy" href="where-to-buy/">
										</a><!--<a href="where-to-buy/"><div class="button green">Where to buy</div></a>-->
									</div>
																			
									<!--<div id="scrollbar"></div>-->
									
									<div id="midsection" class="bg-grey">
										<div id="midsection-inner">
											<?php echo do_shortcode('[post-content id=' . $midsection_content_id .']'); ?>
										</div>
									</div>
									
									<div style="clear:both"></div>
									<div id="slider-background" class="bg-white">
										<div class="slider-wrapper">
											<ul id="slider">
												<? if($slug=='move-s-wired'){?>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/S-wired/s-5_white.png" class="white" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/S-wired/s-4_white.png" class="white" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/S-wired/s-3_white.png" class="white" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/S-wired/s-2_white.png" class="white" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/S-wired/s-1_white.png" class="white" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/S-wired/s-5_black.png" class="black" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/S-wired/s-4_black.png" class="black" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/S-wired/s-3_black.png" class="black" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/S-wired/s-2_black.png" class="black" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/S-wired/s-1_black.png" class="black" /></li>

												<? } ?>

												<? if($slug=='move-s'){?>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/S/s-5_white.png" class="white" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/S/s-4_white.png" class="white" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/S/s-3_white.png" class="white" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/S/s-2_white.png" class="white" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/S/s-1_white.png" class="white" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/S/s-5_black.png" class="black" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/S/s-4_black.png" class="black" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/S/s-3_black.png" class="black" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/S/s-2_black.png" class="black" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/S/s-1_black.png" class="black" /></li>
												<? } ?>

												<? if($slug=='move-l'){?>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/L/l-5_white.png" class="white" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/L/l-4_white.png" class="white" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/L/l-3_white.png" class="white" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/L/l-2_white.png" class="white" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/L/l-1_white.png" class="white" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/L/l-5_black.png" class="black" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/L/l-4_black.png" class="black" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/L/l-3_black.png" class="black" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/L/l-2_black.png" class="black" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/L/l-1_black.png" class="black" /></li>
												<? } ?>

												<? if(($slug=='move-m')||($slug=='move-m-debug')){?>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/M/m-5_white.png" class="white" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/M/m-4_white.png" class="white" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/M/m-3_white.png" class="white" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/M/m-2_white.png" class="white" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/M/m-1_white.png" class="white" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/M/m-5_black.png" class="black" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/M/m-4_black.png" class="black" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/M/m-3_black.png" class="black" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/M/m-2_black.png" class="black" /></li>
												<li><img src="<?php echo get_template_directory_uri(); ?>/library/js/slider/img/M/m-1_black.png" class="black" /></li>
												
												<? } ?>
											</ul>
										</div>
									</div>

									<div id="bottomsection">
										<div id="bottomsection-inner">
											<?php echo do_shortcode('[post-content id=' . $bottomsection_content_id . ']'); ?>
										</div>
									</div>

							</section> <!-- end article section -->

							</article> <!-- end article -->

							<?php endwhile; else : ?>

									<article id="post-not-found" class="hentry clearfix">
										<header class="article-header">
											<h1><?php _e("Oops, Post Not Found!", "bonestheme"); ?></h1>
										</header>
										<section class="entry-content">
											<p><?php _e("Uh Oh. Something is missing. Try double checking things.", "bonestheme"); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e("This is the error message in the page.php template.", "bonestheme"); ?></p>
										</footer>
									</article>

							<?php endif; ?>
                            
         
							
						

						</div> <!-- end #main -->
					                   
						<div id="fairpricesection">
							<hr />
							<div id="fairpricesection-inner" style="background: url('<?php echo kd_mfi_get_featured_image_url( 'featured-image-17', 'page' , $size, $mm ); ?>') no-repeat scroll 0 60px transparent;">
								<?php echo do_shortcode('[post-content id=' . $fairpricesection_content_id . ']'); ?>
							</div>
						</div>

						<?php //get_sidebar(); ?>

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
