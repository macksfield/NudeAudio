<div class="wrap">
	<h2>Dynamic Headers - About</h2>
<?php include("header.php"); ?>
	
	This plugin was written and is maintained by Dan Cannon of <a href="http://blog.nicasiodesign.com" target="_blank">Nicasio Design and Development</a>.<br />
	<br />
	Nicasio Design is a full service web design firm specializing in WordPress.<br />
	<br />
	Feel free to <a href="http://nicasiodesign.com/contact-us.php" target="_blank">Contact Us Today</a>  to discuss your next WordPress project.<br />
	<br />
	Follow Nicasio on Twitter: <a href="http://twitter.com/nicasiodesign">http://twitter.com/nicasiodesign</a>
	<br />
	<h2>The Nicasio Team</h2>
	<strong>Dan Cannon</strong> - Chief Technology Officer<br />
	<strong>Chris Underwood</strong> - Chief Design Officer<br />
	<strong>Felix Figuereo</strong> - Chief Executive Officer<br />
	<strong>Jeff Carpenter</strong> - Account Manager<br />
	<br />
	Thanks to Chris Underwood for some of the design elements related to this plugin.
	
	<?php require_once (ABSPATH . WPINC . '/rss-functions.php'); ?>
	<?php $today = current_time('mysql', 1); ?>
	<div class="main">
	  <h2>Nicasio News</h2>

		<?php
		$rss = @fetch_rss('http://blog.nicasiodesign.com/feed/');
		if ( isset($rss->items) && 0 != count($rss->items) ) {
		?>
			<ul>
			<?php
			$rss->items = array_slice($rss->items, 0, 10);
			foreach ($rss->items as $item ) {
			?>
			<li>
			  <a href='<?php echo wp_filter_kses($item['link']); ?>'>
			  <?php echo wp_specialchars($item['title']); ?>
			  <small>-
				<?php echo human_time_diff( strtotime($item['pubdate'], time() ) ); ?>
				<?php _e('ago'); ?>
			  </small>
			  </a>
			</li>
		<?php
		}
		}
		?>
		</ul>
</div>