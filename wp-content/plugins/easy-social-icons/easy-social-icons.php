<?php
/*
Plugin Name: Easy Social Icons
Plugin URI: http://www.cybernetikz.com
Description: You can upload your own social icon, set your social URL, choose weather you want to display vertical or horizontal. You can use the shortcode <strong>[cn-social-icon]</strong> in page/post, template tag for php file <strong>&lt;?php if ( function_exists('cn_social_icon') ) echo cn_social_icon(); ?&gt;</strong> also you can use the widget <strong>"Easy Social Icons"</strong> for sidebar.
Version: 1.0
Author: cybernetikz
Author URI: http://www.cybernetikz.com
License: GPL2
*/

$pluginsURI = plugins_url('/easy-social-icons/');
function cnss_my_script() {
	global $pluginsURI;
	wp_enqueue_script( 'jquery' );	
	wp_enqueue_script('jquery-ui-sortable');
	wp_register_script('cnss_js', $pluginsURI . 'js/cnss.js', array(), '1.0' );
	wp_enqueue_script( 'cnss_js' );	
	
	wp_register_style('cnss_css', $pluginsURI . 'css/cnss.css', array(), '1.0' );
	wp_enqueue_style( 'cnss_css' );	
}
add_action('init', 'cnss_my_script');
add_action('wp_ajax_update-social-icon-order', 'cnss_save_ajax_order' );
add_action('admin_menu', 'cnss_add_menu_pages');

function cnss_add_menu_pages() {
	add_menu_page('Easy Social Icon', 'Easy Social Icon', 'manage_options', 'cnss_social_icon_page', 'cnss_social_icon_page_fn',plugins_url('/images/scc-sc.png', __FILE__) );
	
	add_submenu_page('cnss_social_icon_page', 'Manage Icons', 'Manage Icons', 'manage_options', 'cnss_social_icon_page', 'cnss_social_icon_page_fn');
	
	add_submenu_page('cnss_social_icon_page', 'Add Icons', 'Add Icons', 'manage_options', 'cnss_social_icon_add', 'cnss_social_icon_add_fn');
	
	add_submenu_page('cnss_social_icon_page', 'Sort Icons', 'Sort Icons', 'manage_options', 'cnss_social_icon_sort', 'cnss_social_icon_sort_fn');
	
	add_submenu_page('cnss_social_icon_page', 'Options', 'Options', 'manage_options', 'cnss_social_icon_option', 'cnss_social_icon_option_fn');
	
	add_action( 'admin_init', 'register_cnss_settings' );
	
}

function register_cnss_settings() {
	register_setting( 'cnss-settings-group', 'cnss-width' );
	register_setting( 'cnss-settings-group', 'cnss-height' );
	register_setting( 'cnss-settings-group', 'cnss-margin' );
	register_setting( 'cnss-settings-group', 'cnss-row-count' );
	register_setting( 'cnss-settings-group', 'cnss-vertical-horizontal' );
}

function cnss_social_icon_option_fn() {
	
	$cnss_width = get_option('cnss-width');
	$cnss_height = get_option('cnss-height');
	$cnss_margin = get_option('cnss-margin');
	$cnss_rows = get_option('cnss-row-count');
	$vorh = get_option('cnss-vertical-horizontal');
	$vertical ='';
	$horizontal ='';
	if($vorh=='vertical') $vertical = 'checked="checked"';
	if($vorh=='horizontal') $horizontal = 'checked="checked"';
	?>
	<div class="wrap">
	<h2>Social Icon Options</h2>
	<form method="post" action="options.php">
		<?php settings_fields( 'cnss-settings-group' ); ?>
		<table class="form-table">
			<tr valign="top">
			<th scope="row">Icon Width</th>
			<td><input type="text" name="cnss-width" id="cnss-width" class="small-text" value="<?php echo $cnss_width?>" />px</td>
			</tr>
			<tr valign="top">
			<th scope="row">Icon Height</th>
			<td><input type="text" name="cnss-height" id="cnss-height" class="small-text" value="<?php echo $cnss_height?>" />px</td>
			</tr>
			<tr valign="top">
			<th scope="row">Icon Margin <em><small>(Gap between each icon)</small></em></th>
			<td><input type="text" name="cnss-margin" id="cnss-margin" class="small-text" value="<?php echo $cnss_margin?>" />px</td>
			</tr>

			<tr valign="top">
			<th scope="row">Number of Rows</th>
			<td><input type="text" name="cnss-row-count" id="cnss-row-count" class="small-text" value="<?php echo $cnss_rows?>" /></td>
			</tr>
			
			<tr valign="top">
			<th scope="row">Display Icon</th>
			<td>
				<input <?php echo $horizontal ?> type="radio" name="cnss-vertical-horizontal" id="horizontal" value="horizontal" />&nbsp;<label for="horizontal">Horizontally</label><br />
				<input <?php echo $vertical ?> type="radio" name="cnss-vertical-horizontal" id="vertical" value="vertical" />&nbsp;<label for="vertical">Vertically</label></td>
			</tr>
		</table>
		
		<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
	</div>
	<?php 
}


function cnss_db_install () {
   global $wpdb;
   global $cnss_db_version;
   
	$srcdir   = ABSPATH.'wp-content/plugins/easy-social-icons/images/icon/';
	$upload_dir = wp_upload_dir();
	$targetdir = $upload_dir['basedir'].'/';
	
	$files = scandir($srcdir);
	foreach($files as $fname) 
	{
		if($fname=='.')continue;
		if($fname=='..')continue;
		copy($srcdir.$fname, $targetdir.$fname);
	}

   $table_name = $wpdb->prefix . "cn_social_icon";
   if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
      
	$sql2 = "CREATE TABLE " . $table_name . " (
	`id` BIGINT(20) NOT NULL AUTO_INCREMENT, 
	`title` VARCHAR(255) NULL, 
	`url` VARCHAR(255) NOT NULL, 
	`image_url` VARCHAR(255) NOT NULL, 
	`sortorder` INT NOT NULL DEFAULT '0', 
	`date_upload` VARCHAR(100) NULL, 
	`target` tinyint(1) NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`)) ENGINE = InnoDB;
	INSERT INTO `wp_cn_social_icon` (`id`, `title`, `url`, `image_url`, `sortorder`, `date_upload`, `target`) VALUES
	(1, 'facebook', 'http://facebook.com/your-fan-page', '1368459524_facebook.png', 1, '1368459524', 1),
	(2, 'twitter', 'http://twitter/username', '1368459556_twitter.png', 2, '1368459556', 1),
	(3, 'flickr', 'http://flickr.com/?username', '1368459641_flicker.png', 3, '1368459641', 1),
	(4, 'linkedin', 'http://linkedin.com', '1368459699_in.png', 4, '1368459699', 1),
	(5, 'youtube', 'http://youtube.com/user', '1368459724_youtube.png', 5, '1368459724', 1);	
	";
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql2);
	
	add_option( 'cnss-width', '32');
	add_option( 'cnss-height', '32');
	add_option( 'cnss-margin', '4');
	add_option( 'cnss-row-count', '1');
	add_option( 'cnss-vertical-horizontal', 'horizontal');
	  
  }
}

register_activation_hook(__FILE__,'cnss_db_install');

if (isset($_GET['delete'])) {
	
	if ($_REQUEST['id'] != '')
	{
	
		$table_name = $wpdb->prefix . "cn_social_icon";
		$image_file_path = "../wp-content/uploads/";
		$sql = "SELECT * FROM ".$table_name." WHERE id =".$_REQUEST['id'];
		$video_info = $wpdb->get_results($sql);
		
		if (!empty($video_info))
		{
			@unlink($image_file_path.$video_info[0]->image_url);
		}
		$delete = "DELETE FROM ".$table_name." WHERE id = ".$_REQUEST['id']." LIMIT 1";
		$results = $wpdb->query( $delete );
		$msg = "Delete Successfully!!!"."<br />";
	}

}


if (isset($_POST['submit_button'])) {

	if ($_POST['action'] == 'update')
	{
	
		$err = "";
		$msg = "";
		
		$image_file_path = "../wp-content/uploads/";
		
			if ($_FILES["image_file"]["name"] != "" ){
			
				if( 
					($_FILES["image_file"]["type"] == "image/gif")
				|| ($_FILES["image_file"]["type"] == "image/jpeg")
				|| ($_FILES["image_file"]["type"] == "image/pjpeg")
				|| ($_FILES["image_file"]["type"] == "image/png")
				&& ($_FILES["image_file"]["size"] < 1024*1024*1))
				  {
					if ($_FILES["image_file"]["error"] > 0)
					{
						$err .= "Return Code: " . $_FILES["image_file"]["error"] . "<br />";
					}
				  else
					{
					if (file_exists($image_file_path . $_FILES["image_file"]["name"]))
					  {
					  $err .= $_FILES["image_file"]["name"] . " already exists. ";
					  }
					else
					  {
						$image_file_name = time().'_'.$_FILES["image_file"]["name"];
						$fstatus = move_uploaded_file($_FILES["image_file"]["tmp_name"], $image_file_path . $image_file_name);
						if ($fstatus == true){
							$msg = "File Uploaded Successfully!!!"."<br />";
						}
					  }
					}
				  }
				else
				{
					$err .= "Invalid file type or max file size exceded" . "<br />";
				}
			}
			else
			{
				$err .= "Please input image file". "<br />";
			}// end if image file
		
		if ($err == '')
		{
			$table_name = $wpdb->prefix . "cn_social_icon";
	
			$insert = "INSERT INTO " . $table_name .
			" (title, url, image_url, sortorder, date_upload, target) " .
			"VALUES ('" . 
			$wpdb->escape( $_REQUEST['title']) . "','" . 
			$wpdb->escape( $_REQUEST['url']) . "','" . 
			$image_file_name . "'," . 
			$_REQUEST['sortorder'] . ",'" . 
			time() . "'," . 
			$_REQUEST['target'] . "" . 
			")";
			$results = $wpdb->query( $insert );
			
			if (!$results)
				$err .= "Fail to update database" . "<br />";
			else
				$msg .= "Update Successfull!!!" . "<br />";
		
		}
	}// end if update
	
	if ( $_REQUEST['action'] == 'edit' and $_REQUEST['id'] != '' )
	{
		$err = "";
		$msg = "";

		$url = $_REQUEST['url'];
		$target = $_REQUEST['target'];
		
		$image_file_path = "../wp-content/uploads/";
		$table_name = $wpdb->prefix . "cn_social_icon";
		$sql = "SELECT * FROM ".$table_name." WHERE id =".$_REQUEST['id'];
		$video_info = $wpdb->get_results($sql);
		$image_file_name = $video_info[0]->image_url;
		$update = "";
		
		$imgExtArray = array('image/gif','image/jpeg','image/pjpeg','image/png');
		$type= 1;
		if ($_FILES["image_file"]["name"] != ""){
			if( in_array($_FILES["image_file"]["type"],$imgExtArray) && $_FILES["image_file"]["size"] <= 1024*1024*1 )
			  {
				if ($_FILES["image_file"]["error"] > 0)
				{
					$err .= "Return Code: " . $_FILES["image_file"]["error"] . "<br />";
				}
			  else
				{
				if (file_exists($image_file_path . $_FILES["image_file"]["name"]))
				  {
				  $err .= $_FILES["image_file"]["name"] . " already exists. ";
				  }
				else
				  {
					$image_file_name = time().'_'.$_FILES["image_file"]["name"];
					$fstatus = move_uploaded_file($_FILES["image_file"]["tmp_name"], $image_file_path . $image_file_name);
					
					if ($fstatus == true){
						$msg = "File Uploaded Successfully!!!".'<br />';
						@unlink($image_file_path.$video_info[0]->image_url);
						$update = "UPDATE " . $table_name . " SET " . 
						"image_url='" .$image_file_name . "'" . 
						" WHERE id=" . $_REQUEST['id'];
						$results1 = $wpdb->query( $update );
					}
				  }
				}
			  }
			else
			{
				$err .= "Invalid file type or max file size exceded";
			}
		}
		
		$update = "UPDATE " . $table_name . " SET " . 
		"title='" .$wpdb->escape( $_POST['title']) . "'," . 
		"url='" . $url . "'," . 
		"sortorder=" .$_POST['sortorder'] . "," . 
		"date_upload='" .time(). "'," . 
		"target=$target " .
		" WHERE id=" . $_POST['id'];
		if ($err == '')
		{
			$table_name = $wpdb->prefix . "cn_social_icon";
			$results3 = $wpdb->query( $update );
			
			if (!$results3){
				$err .= "Update Fail!!!". "<br />";
			}
			else
			{
				$msg = "Update Successfull!!!". "<br />";
			}
		}
		
	} // end edit
	
}


function cnss_social_icon_sort_fn() {
	global $wpdb;
	
	$cnss_width = get_option('cnss-width');
	$cnss_height = get_option('cnss-height');
	
	$image_file_path = "../wp-content/uploads/";
	$table_name = $wpdb->prefix . "cn_social_icon";
	$sql = "SELECT * FROM ".$table_name." WHERE 1 ORDER BY sortorder";
	$video_info = $wpdb->get_results($sql);

?>
	<div class="wrap">
		<h2>Sort Icon</h2>

		<div id="ajax-response"></div>
		
		<noscript>
			<div class="error message">
				<p><?php _e('This plugin can\'t work without javascript, because it\'s use drag and drop and AJAX.', 'cpt') ?></p>
			</div>
		</noscript>
		
		<div id="order-post-type">
			<ul id="sortable">
			<?php foreach($video_info as $vdoinfo) { ?>
					<li id="item_<?php echo $vdoinfo->id ?>">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr style="background:#f7f7f7">
						<td width="60">&nbsp;<img src="<?php echo $image_file_path.$vdoinfo->image_url;?>" border="0" class="social-icon" alt="<?php echo $vdoinfo->title;?>" /></td>
						<!-- width="<?php //echo $cnss_width ?>" height="<?php //echo $cnss_height ?>" -->
						<td><span><?php echo $vdoinfo->title;?></span></td>
					  </tr>
					</table>
					</li>
			<?php } ?>
			</ul>
			
			<div class="clear"></div>
		</div>
		
		<p class="submit">
			<a href="#" id="save-order" class="button-primary">Update</a>
		</p>
		
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery("#sortable").sortable({
					tolerance:'intersect',
					cursor:'pointer',
					items:'li',
					placeholder:'placeholder'
				});
				jQuery("#sortable").disableSelection();
				jQuery("#save-order").bind( "click", function() {
					//alert(jQuery("#sortable").sortable("serialize"));
					jQuery.post( ajaxurl, { action:'update-social-icon-order', order:jQuery("#sortable").sortable("serialize") }, function(response) {
						//alert(response);
						jQuery("#ajax-response").html('<div class="message updated fade"><p>Items Order Updated</p></div>');
						jQuery("#ajax-response div").delay(3000).hide("slow");
					});
				});
			});
		</script>
		
	</div>
<?php
}

function cnss_save_ajax_order() 
{
	global $wpdb;
	$table_name = $wpdb->prefix . "cn_social_icon";
	parse_str($_POST['order'], $data);
	if (is_array($data))
	foreach($data as $key => $values ) 
	{
	
		if ( $key == 'item' ) 
		{
			foreach( $values as $position => $id ) 
				{
					$wpdb->update( $table_name, array('sortorder' => $position), array('id' => $id) );
				} 
		} 
	
	}
}


function cnss_social_icon_add_fn() {

	global $err,$msg;

	if (isset($_GET['mode'])) {
		if ( $_REQUEST['mode'] != '' and $_REQUEST['mode'] == 'edit' and  $_REQUEST['id'] != '' )
		{
		
			$cnss_width = get_option('cnss-width');
			$cnss_height = get_option('cnss-height');
			//$cnss_margin = get_option('cnss-margin');
	
		
			$page_title = 'Edit Icon';
			$uptxt = 'Upload Icon';
			
			global $wpdb;
			$table_name = $wpdb->prefix . "cn_social_icon";
			$image_file_path = "../wp-content/uploads/";
			$sql = "SELECT * FROM ".$table_name." WHERE id =".$_REQUEST['id'];
			$video_info = $wpdb->get_results($sql);
			
			if (!empty($video_info))
			{
				$id = $video_info[0]->id;
				$title = $video_info[0]->title;
				$url = $video_info[0]->url;
				$image_url = $image_file_path.$video_info[0]->image_url;
				$sortorder = $video_info[0]->sortorder;
				$target = $video_info[0]->target;
			}
		}
	}
	else
	{
	
		$page_title = 'Add New Icon';
		$title = "";
		$url = "";
		$image_url = "";
		$sortorder = "0";
		$target = "";
		$uptxt = 'Upload Icon';
	
	}
?>
<div class="wrap">
<?php
if($msg!='' or $err!='')
	echo '<div id="message" class="updated fade">'. $msg.$err.'</div>';
?>

<h2><?php echo $page_title;?></h2>

<form method="post" enctype="multipart/form-data" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    
    <table class="form-table">
        <tr valign="top">
			<th scope="row">Icon Title</th>
			<td>
				<input type="text" name="title" id="title" class="regular-text" value="<?php echo $title?>" />
			</td>
        </tr>
		
        <tr valign="top">
			<th scope="row"><?php echo $uptxt;?></th>
			<td>
				<?php if (isset($_GET['mode'])) { ?>
					<br /><img src="<?php echo $image_url?>" border="0" width="<?php echo $cnss_width ?>"  height="<?php echo $cnss_height ?>" alt="<?php echo $title?>" /><br />
				<?php } ?>
				<input type="file" name="image_file" id="image_file" value="" />
			</td>
        </tr>
		
        <tr valign="top">
			<th scope="row">URL</th>
			<td><input type="text" name="url" id="url" class="regular-text" value="<?php echo $url?>" /><br /><i>Example: <strong>http://facebook.com/your-fan-page</strong> &ndash; don't forget the <strong><code>http://</code></strong></i></td>
        </tr>
		
        <tr valign="top">
			<th scope="row">Sort Order</th>
			<td>
				<input type="text" name="sortorder" id="sortorder" class="small-text" value="<?php echo $sortorder?>" />
			</td>
        </tr>
		
		<tr valign="top">
			<th scope="row">Target</th>
			<td>
				<input type="radio" name="target" id="new" checked="checked" value="1" />&nbsp;<label for="new">Open new window</label>&nbsp;<br />
				<input type="radio" name="target" id="same" value="0" />&nbsp;<label for="same">Open same window</label>&nbsp;
			</td>
        </tr>		
        
		
    </table>
	
	
	<?php if (isset($_GET['mode']) ) { ?>
	<input type="hidden" name="action" value="edit" />
	<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
	<?php } else {?>
	<input type="hidden" name="action" value="update" />
	<?php } ?>
	
    
    <p class="submit">
    <input type="submit" id="submit_button" name="submit_button" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>


</div>
<?php 
} 

function cnss_social_icon_page_fn() {
	
	global $wpdb;
	
	$cnss_width = get_option('cnss-width');
	$cnss_height = get_option('cnss-height');
	
	$image_file_path = "../wp-content/uploads/";
	$table_name = $wpdb->prefix . "cn_social_icon";
	$sql = "SELECT * FROM ".$table_name." WHERE 1 ORDER BY sortorder";
	$video_info = $wpdb->get_results($sql);
	?>
	<div class="wrap">
	<h2>Manage Icons</h2>
	<script type="text/javascript">
	function show_confirm(title, id)
	{
		var rpath1 = "";
		var rpath2 = "";
		var r=confirm('Are you confirm to delete "'+title+'"');
		if (r==true)
		{
			rpath1 = '<?php echo $_SERVER['REQUEST_URI']; ?>';
			rpath2 = '&delete=y&id='+id;
			window.location = rpath1+rpath2;
		}
	}
	</script>
	
	
		<table class="widefat page fixed" cellspacing="0">
		
			<thead>
			<tr valign="top">
				<th class="manage-column column-title" scope="col">Title</th>
				<th class="manage-column column-title" scope="col">URL</th>
				<th class="manage-column column-title" scope="col" width="100">Open In</th>
				<th class="manage-column column-title" scope="col" width="100">Icon</th>
				<th class="manage-column column-title" scope="col" width="50">Order</th>
				<th class="manage-column column-title" scope="col" width="50">Edit</th>
				<th class="manage-column column-title" scope="col" width="50">Delete</th>
			</tr>
			</thead>
			
			<tbody>
			<?php foreach($video_info as $vdoinfo){ ?>
			<tr valign="top">
				<td>
					<?php echo $vdoinfo->title;?>
				</td>
				<td>
					<?php echo $vdoinfo->url;?>
				</td>
				<td>
					<?php echo $vdoinfo->target==1?'New Window':'Same Window' ?>
				</td>
				
				<td>
					<img src="<?php echo $image_file_path.$vdoinfo->image_url;?>" border="0" width="<?php echo $cnss_width ?>" height="<?php echo $cnss_height ?>" alt="<?php echo $vdoinfo->title;?>" />
				</td>
	
				<td>
					<?php echo $vdoinfo->sortorder;?>
				</td>
				<td>
					<a href="?page=cnss_social_icon_add&mode=edit&id=<?php echo $vdoinfo->id;?>"><strong>Edit</strong></a>
				</td>
				<td>
					<a onclick="show_confirm('<?php echo $vdoinfo->title?>','<?php echo $vdoinfo->id;?>');" href="#delete"><strong>Delete</strong></a>
				</td>
				
			</tr>
			<?php }?>
			</tbody>
			<tfoot>
			<tr valign="top">
				<th class="manage-column column-title" scope="col">Title</th>
				<th class="manage-column column-title" scope="col">URL</th>
				<th class="manage-column column-title" scope="col" width="100">Open In</th>
				<th class="manage-column column-title" scope="col" width="100">Icon</th>
				<th class="manage-column column-title" scope="col" width="50">Order</th>
				<th class="manage-column column-title" scope="col" width="50">Edit</th>
				<th class="manage-column column-title" scope="col" width="50">Delete</th>
			</tr>
			</tfoot>
		</table>
	</div>
	<?php
}

function cn_social_icon() {

	$cnss_width = get_option('cnss-width');
	$cnss_height = get_option('cnss-height');
	$cnss_margin = get_option('cnss-margin');
	$cnss_rows = get_option('cnss-row-count');
	$vorh = get_option('cnss-vertical-horizontal');

	$upload_dir = wp_upload_dir(); 
	global $wpdb;
	$table_name = $wpdb->prefix . "cn_social_icon";
	$image_file_path = $upload_dir['baseurl'];
	$sql = "SELECT * FROM ".$table_name." WHERE image_url<>'' AND url<>'' ORDER BY sortorder";
	$video_info = $wpdb->get_results($sql);
	$icon_count = count($video_info);
	
	$_collectionSize = count($video_info);
	$_rowCount = $cnss_rows ? $cnss_rows : 1;
	$_columnCount = ceil($_collectionSize/$_rowCount);
	
	if($vorh=='vertical')
		$table_width = $cnss_width;
	else
		$table_width = $_columnCount*($cnss_width+$cnss_margin);
		//$table_width = $icon_count*($cnss_width+$cnss_margin);
	
	$td_width = $cnss_width+$cnss_margin;
		
	ob_start();
	//echo '<table class="cnss-social-icon" style="width:'.$table_width.'px" border="0" cellspacing="0" cellpadding="0">';
	echo '<table class="cnss-social-icon" border="0" cellspacing="0" cellpadding="0">';
	
	//echo $vorh=='horizontal'?'<tr>':'';
	$i=0;
	foreach($video_info as $icon)
	{ 
	$image_url = $image_file_path.'/'.$icon->image_url;
	echo $vorh=='vertical'?'<tr>':'';
	if($i++%$_columnCount==0 && $vorh!='vertical' )echo '<tr>';
	?><td><a <?php echo ($icon->target==1)?'target="_blank"':'' ?> title="<?php echo $icon->title ?>" href="<?php echo $icon->url ?>">


	<!--<img src="<?php //echo $image_url?>" border="0" class="socialicon" width="<?php //echo $cnss_width ?>" height="<?php //echo $cnss_height ?>" alt="<?php //echo $icon->title ?>" />*/-->
	<div class="socialicon" style="background-image: url(<?php echo $image_url?>)"></div>



	</a></td><?php 
	if ( ($i%$_columnCount==0 || $i==$_collectionSize) && $vorh!='vertical' )echo '</tr>';
	echo $vorh=='vertical'?'</tr>':'';
	//$i++;
	}
	//echo $vorh=='horizontal'?'</tr>':'';
	echo '</table>';
	$out = ob_get_contents();
	ob_end_clean();
	return $out;
}

class Cnss_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'cnss_widget', // Base ID
			'Easy Social Icon', // Name
			array( 'description' => __( 'Easy Social Icon Widget for sidebar' ) ) // Args
		);
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		echo cn_social_icon();
		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}

	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}

} // class Cnss_Widget
add_action( 'widgets_init', create_function( '', 'register_widget( "Cnss_Widget" );' ) );

add_shortcode('cn-social-icon', 'cn_social_icon');