<?php
	$dhnd_image_dir = ABSPATH.'wp-content/header-images/';
	$dhnd_image_url_base = get_bloginfo('wpurl').'/wp-content/header-images/';

	$path = ABSPATH."wp-content/header-images/";
	
	if(is__writable($dhnd_image_dir) != true){
		echo '<div class="error"><p>';
			echo 'It looks like <strong>wp-content/header-images/</strong> is not writable or does not exist.<br /><br /> You will need to create this directory make this directory writable in order for the plugin to work.<br /><br />Maybe <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">This Article</a> from WordPress will help.';
		echo '</p></div><br />';
	}
?>