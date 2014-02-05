<?php
/* 
Plugin Name: Jquery Validation For Contact Form 7
Plugin URI: http://dineshkarki.com.np/jquery-validation-for-contact-form-7
Description: This plugin integrates jquery validation in contact form 7
Author: Dinesh Karki
Version: 0.3
Author URI: http://www.dineshkarki.com.np
*/

/*  Copyright 2012  Dinesh Karki  (email : dnesskarki@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//add_action('admin_enqueue_scripts', 'jvcf7_validation_js');   


$jvcf7_show_label_error 						= get_option('jvcf7_show_label_error');
$jvcf7_highlight_error_field 					= get_option('jvcf7_highlight_error_field');	
$jvcf7_hide_contact_form_7_validation_error 	= get_option('jvcf7_hide_contact_form_7_validation_error');	

if (empty($jvcf7_show_label_error)){
	update_option('jvcf7_show_label_error', 'yes');
	$jvcf7_show_label_error 						= get_option('jvcf7_show_label_error');
}

if (empty($jvcf7_highlight_error_field)){
	update_option('jvcf7_highlight_error_field', 'yes');
	$jvcf7_highlight_error_field 					= get_option('jvcf7_highlight_error_field');	
}

if (empty($jvcf7_hide_contact_form_7_validation_error)){
	update_option('jvcf7_hide_contact_form_7_validation_error', 'yes');
	$jvcf7_hide_contact_form_7_validation_error 	= get_option('jvcf7_hide_contact_form_7_validation_error');	
}

$styleSheet = '.wpcf7-form span.wpcf7-not-valid-tip{ display:none !important;}';
if ($jvcf7_show_label_error == 'yes'){
	$styleSheet.='.wpcf7-form label.error{color:#900; font-size:11px; float:none;}';
} else {
	$styleSheet.='.wpcf7-form label.error{display:none !important;}';
}

if ($jvcf7_highlight_error_field == 'yes'){
	$styleSheet.='.wpcf7-form input.error, .wpcf7-form select.error, .wpcf7-form textarea.error{border-bottom:2px solid #900;outline: none;}';
}

function jvcf7_validation_js(){
  global $styleSheet;
  echo '<script> jvcf7_loading_url= "'.plugins_url('contact-form-7/images/ajax-loader.gif').'"</script>';
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-form');
  wp_enqueue_script('jvcf7_jquery_validate', plugins_url('jquery-validation-for-contact-form-7/js/jquery.validate.min.js'), array('jquery'), '', true);
  wp_dequeue_script( 'contact-form-7' );  
  wp_enqueue_script('jvcf7_validation_custom', plugins_url('jquery-validation-for-contact-form-7/js/jquery.jvcf7_validation.js'), '', '', true);
  echo '<style>'.$styleSheet.'</style>';

}

add_action('wp_enqueue_scripts', 'jvcf7_validation_js');

include('plugin_interface.php');
?>