<div class="wrap">
	<h2>Dynamic Headers - Add New Media File</h2>
<?php
	include("header.php");
	
	if($_POST['upit'] == 'yes'){
		//Set the target using the WordPress ABSPATH constant
		$target = $dhnd_image_dir;
		$target = $target . basename( $_FILES['uploaded']['name']) ;
		
		$uploaded_size = $_FILES['uploaded']['size'];
		
		//Set our error checker to 1
		$ok = 1;
		
		//Check the file extension
		$check_file = strtolower($_FILES['uploaded']['name']);
		$ext_check = end(explode('.', $check_file));
		
		//We will check to see if the user has set a max file size on the settings page.
		//If they have we use that for max file size, otherwise we use 500k.
		if(get_option('dhnd_max_size') != ""){
			$the_max_size = get_option('dhnd_max_size') * 1024;
		} else {
			$the_max_size = 500000;
		}
		
		//Set the path of where the upload is going to take place.
		$path = $dhnd_image_dir;
		
		//Check to see if the directory is writable.
		if(is__writable($path) != true){
			$errors[] = "It looks like <strong>wp-content/header-images/</strong> is not writable.<br /><br /> You will need to make this directory writable in order for the plugin to work.<br />";
			$ok = 0;
		}

		//This is our size condition
		if ($uploaded_size > $the_max_size){
			$errors[] = "Your file is too large.<br />";
			$ok = 0;
		}
		
		//Make sure the file upload box actually has something in it.
		if ($_FILES['uploaded']['name'] == ""){
			$errors[] = "You didn't select a file to upload<br />";
			$ok = 0;
		}

		//This is our limit file type condition
		if ($ext_check != "jpg" && $ext_check != "jpeg" && $ext_check != "gif" && $ext_check != "png" && $ext_check != "swf"){
			$errors[] = "Invalid filetype....<br />";
			$ok = 0;
		}

		//Here we check that $ok was not set to 0 by an error
		if ($ok == 0){
			echo '<div class="error"><p>';
			foreach($errors as $error){
				echo $error.'<br />';
			}
			echo '</p></div>';

		//If everything is ok we try to upload it
		} else {
			if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $target)){
				echo '<div style="background-color: rgb(255, 251, 204);" id="message" class="updated fade">'."<p>The file ". basename( $_FILES['uploadedfile']['name']). " has been uploaded.</p></div>";
			} else {
				echo "Sorry, there was a problem uploading your file. You may need to check your folder permissions or other server settings.";
			}
			
			add_option('dhnd_'.$_FILES['uploaded']['name'].'_alt',$_POST['altText']);
			add_option('dhnd_'.$_FILES['uploaded']['name'].'_link',$_POST['linkurl']);
			add_option('dhnd_'.$_FILES['uploaded']['name'].'_target',$_POST['target']);
		}
	}
?>
	<p>Use this form to upload new media to your website for use in your header.</p>
	<p>Permitted file types: .jpg, .jpeg, .gif, .png, .swf</p>
	<p><strong>Note:</strong> The plugin will not do any resizing of images.<br />
	You will need to make sure your images and flash shows are the right size for your header area.</p>
	<form enctype="multipart/form-data" action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="POST">
	<table class="form-table">
		<tr valign="top">
			<th scope="row">Please choose a file:</th> 
			<td><input name="uploaded" type="file" />
			<input type="hidden" name="upit" value="yes" /></td>
		</tr>
		<tr valign="top">
			<th scope="row">Alt Text:</th>
			<td><input type="text" name="altText" id="altText" />
				<br />
				<span class="setting-description">The alt text is shown when your image can't be displayed by a browser.<br />It is also read by search engines, so make it descriptive.</span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">Link URL:</th>
			<td><input type="text" name="linkurl" id="linkurl" value="http://" />
				<br />
				<span class="setting-description">If you want this image to have a link associated with it, enter the FULL URL (example: http://google.com) here.<br />Leave blank for no link.</span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">Link Target:</th>
			<td>
				<select name="target">
					<option value="">Same Window</option>
					<option value="_blank">New Window</option>
				</select>
				<br />
				<span class="setting-description">This is how the browser will open the link if there is one.</span>
			</td>
		</tr>
	</table>
	<p class="submit">
		<input type="submit" class="button-primary" value="Upload" />
	</p>
	</form>
</div>