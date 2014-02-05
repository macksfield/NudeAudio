<?php
// create custom plugin settings menu
add_action('admin_menu', 'jvcf7_create_menu');

function jvcf7_create_menu() {
	add_options_page('Jquery Validation For Contact Form 7', 'Jquery Validation For Contact Form 7', 'administrator', __FILE__, 'jvcf7_settings_page');
	add_action('admin_init', 'register_jvcf7settings');
}

function register_jvcf7settings() {
	register_setting('jvcf7-settings-group', 'jvcf7_show_label_error');
	register_setting('jvcf7-settings-group', 'jvcf7_highlight_error_field');
}

function jvcf7_settings_page() {	
	$jvcf7_show_label_error 						= get_option('jvcf7_show_label_error');
	$jvcf7_highlight_error_field 					= get_option('jvcf7_highlight_error_field');
	
	include('includes/jvcf7_header.php');
	include('includes/jvcf7_settings.php');
	include('includes/jvcf7_instructions.php');
	include('includes/jvcf7_footer.php');	
}