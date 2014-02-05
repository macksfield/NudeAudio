<div class="wrap">
	<h2>Dynamic Headers - Manage Files</h2>
	
<?php
	include("header.php");
	$conf = 0;
	
	if($_POST['delete'] == 'yes'){
		$myFile = $_POST['mediaHeader'];
		unlink($dhnd_image_dir.$myFile);
		
		echo '<div style="background-color: rgb(255, 251, 204);" id="message" class="updated fade"><p>File: <strong>'.$myFile.'</strong> has been deleted.</p></div>';
	}
	
	if($_POST['altText'] != "" && isset($_POST['altText'])){
		update_option('dhnd_'.$_POST['mediaHeader'].'_alt', $_POST['altText']);
		$conf = 1;
	}
	
	if($_POST['link'] != "" && isset($_POST['link'])){
		update_option('dhnd_'.$_POST['mediaHeader'].'_link', $_POST['link']);
		update_option('dhnd_'.$_POST['mediaHeader'].'_target', $_POST['target']);
		$conf = 1;
	}
	
	if($conf == 1){
		echo '<div style="background-color: rgb(255, 251, 204);" id="message" class="updated fade"><p>File: <strong>'.$_POST['mediaHeader'].'</strong> has been updated.</p></div>';
}	
?>
	<h3>Delete Files</h3>
	<p>Use this form to delete unwanted files on your server.<br />
	<strong>Caution: This action CANNOT be undone.</strong></p>
	<form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="POST">
		<input type="hidden" name="delete" value="yes" />
		<select name="mediaHeader" id="mediaHeader">
			<option value="None">-- No Media Header --</option>
			<?php
			//Print out the media file list
			if($media_dir = opendir($dhnd_image_dir)){
				while ($m_file = readdir($media_dir)) {
					if($m_file != "." && $m_file != ".."){
						if($media_file == $m_file){
							echo '<option value="'.$m_file.'" selected>'.$m_file.'</option>';
						} else {
							echo '<option value="'.$m_file.'">'.$m_file.'</option>';
						}
					}
				}
			}
			?>
		</select>
		<input type="submit" class="button-primary" value="<?php _e('Delete File') ?>" />
	</form>
	<br /><br />
	<h3>Update Files</h3>
	<p>Use this form to add or update the alt/title tags for your images.<br />
	Search engines and browsers read these tags, so be descriptive.</p>
	<form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="POST">
		<input type="hidden" name="altUpdate" value="yes" />
		File to Update:<br />
		<select name="mediaHeader" id="mediaHeader">
			<option value="None">-- No Media Header --</option>
			<?php
			//Print out the media file list
			if($media_dir = opendir($dhnd_image_dir)){
				while ($m_file = readdir($media_dir)) {
					if($m_file != "." && $m_file != ".."){
						if($media_file == $m_file){
							echo '<option value="'.$m_file.'" selected>'.$m_file.'</option>';
						} else {
							echo '<option value="'.$m_file.'">'.$m_file.'</option>';
						}
					}
				}
			}
			?>
		</select>
		<br />
		<br />
		New Alt Tag:<br />
		<input type="text" name="altText" id="altText" />
		<br />
		<br />
		New Link URL:<br />
		<input type="text" name="link" id="link" />
		<br />
		<br />
		New Link Target:<br />
					<select name="target">
					<option value="">Same Window</option>
					<option value="_blank">New Window</option>
				</select>
		<br />
		<br />
		<input type="submit" class="button-primary" value="<?php _e('Update File') ?>" />
	</form>
	
</div>