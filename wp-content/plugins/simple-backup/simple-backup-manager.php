<?php


class Simple_Backup_Manager{

	private $backup_table;
	
	private $ftp_backup_table;
	
	private $ftp_tools;
	
	public $opt;
	
	
	public function __construct($options){
	
		$this->opt = $options;
		
		add_action('init', array($this, 'create_backup_directory'));
		
		
		//delete local backup file
		if(array_key_exists('delete_backup_file', $_GET)){
			$this->delete_local_backup_file($_GET['delete_backup_file']);	
		}
		
		//download local backup file
		if(array_key_exists('download_backup_file', $_GET)){
			$this->download_local_backup_file($_GET['download_backup_file']);	
		}
		
		
		
		if(isset($this->opt['backup_settings']['enable_ftp_backup_system']) && "true" == $this->opt['backup_settings']['enable_ftp_backup_system']){
			
			$this->ftp_tools = new Simple_Backup_FTP_Tools($this->opt);
			
			//delete file on FTP server
			if(array_key_exists('ftp_delete_backup_file', $_GET)){
				$this->ftp_tools->delete_ftp_file($_GET['ftp_delete_backup_file']);
			}			
			
			//download file from ftp server and relay to web browser for download
			if(array_key_exists('ftp_download_backup_file', $_GET)){
				$this->ftp_tools->ftp_download_file($_GET['ftp_download_backup_file']);
			}	
		
		
			//add action handler for ftp file put transfer
			if(array_key_exists('ftp_put_backup_file', $_GET)){
				add_action( 'admin_head', array($this->ftp_tools, 'put_ftp_file') );	
			}
			
			//add action handler for ftp file get transfer
			if(array_key_exists('ftp_get_backup_file', $_GET)){			
				add_action( 'admin_head', array($this->ftp_tools, 'get_ftp_file') );	
			}
				
			
			//ajax handler to check file transfer status
			add_action('wp_ajax_get_file_transfer_status', array($this->ftp_tools, 'get_file_transfer_status'));
			
			//setup cron handlers for copying files
			add_action('ftp_put_backup',  array($this->ftp_tools,'cron_put_ftp_file'));
			add_action('ftp_get_backup',  array($this->ftp_tools,'cron_get_ftp_file'));
			
			
			//setup ftp file transfer monitor for the backup_manager page
			if(array_key_exists('page', $_GET) && "backup_manager" == $_GET['page']){
				wp_enqueue_script('jquery');
				wp_enqueue_script('jquery-ui-cdn', 'http://code.jquery.com/ui/1.10.0/jquery-ui.js');
				wp_enqueue_style('jquery-ui-cdn', 'http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css');
				
				add_action( 'admin_head', array($this->ftp_tools, 'monitor_ftp_transfer') );
			}
			
		}	
		
	}
	
	
	public function create_backup_directory(){
		if( isset($_GET['page']) && ($_GET['page'] == "backup_manager" || $_GET['page'] == "simple-backup-settings" ) ){
			$bk_dir = ABSPATH."simple-backup";
				
			if(!is_dir($bk_dir)){
				if(mkdir($bk_dir)){
					echo "<div class='updated'><p>Successfully Created backup directory!<br>$bk_dir</p></div>";
				}
			}
			
			
			if(!is_dir($bk_dir)){
				echo "<div class='error'><p>Can not access: $bk_dir</p></div>";
				return;
			}

			if(!is_writeable($bk_dir)){
				echo "<div class='error'><p>Can not write to Backup Directory: $bk_dir <br>Please be sure that the directory has is Write Permission.</p></div>";
				return;
			}			
		

			
			//check for .htaccess file and create one if it does not exist.
			$htaccess_name = "$bk_dir/.htaccess";
			
			if ( !is_file( $htaccess_name ) ) {
			// open the .htaccess file for editing
	
				$htaccess = "order deny,allow\n\r";
				$htaccess .= "deny from all\n\r";
				$htaccess .= "allow from none\n\r";
				
				$file_handle = @ fopen( $htaccess_name, 'w+' );
				@ fwrite( $file_handle, $htaccess );
				@ fclose( $file_handle );
				@ chmod( $file_handle, 0665 );
				
				echo "<div class='updated'><p>Successfully Created .htaccess file to secure backup directory!</p></div>";
	
			}
			
			if ( !is_file( $htaccess_name ) ) {
				echo "<div class='error'><p>Can not create .htaccess file to secure backup directory</p></div>";
			}
		}
	}
		
	
	
	
	private function delete_local_backup_file($filename){
	
		$bk_dir = ABSPATH."simple-backup/";
		//echo $bk_dir . $filename;
		unlink($bk_dir . $filename);
	
	}
	
	
	private function download_local_backup_file($filename){
	
		$bk_dir = ABSPATH."simple-backup";
		
		//unlink($bk_dir . $filename);
		$file = "$bk_dir/$filename";
		//$url = "ftp://{$this->user}:{$this->pass}@{$this->server}/{$this->directory}/$filename";
		
		clearstatcache();
		$size = filesize($file);

		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');		
		header("Content-Disposition: attachment; filename=$filename");
		header("Content-Length: $size");
		header('Connection: close');  

		//ob_clean();
		ob_end_clean();
		flush();
		
		readfile($file);
		
		die();
	
	}
	
	

	function simple_backup_admin_menu(){
	
        global $simple_backup_file_manager_page;
		
		$simple_backup_file_manager_page = add_submenu_page( 'tools.php', __('Simple Backup File Manager', 'simple_backup'), __('Backup Manager', 'simple_backup'), 'manage_options', 'backup_manager', array(&$this, 'backup_manager') );
		
		if($simple_backup_file_manager_page){
			add_action("load-". $simple_backup_file_manager_page, array('Simple_Backup_Plugin', 'admin_help'));	
		}
    }
	
	
	
	public function backup_processor_form(){
		
		$bk_dir = ABSPATH."simple-backup";
		
		if(!is_dir($bk_dir)){
			mkdir($bk_dir);
		}
		
		if(!is_dir($bk_dir)){
			echo "Can not access: $bk_dir<br>";
			return;
		}
		
		
		if(!is_writeable($bk_dir)){
			echo "<div class='error'><p>Can not write to Backup Directory: $bk_dir <br>Please be sure that the directory has is Write Permission.</p></div>";
			return;
		}	
		

		//check for .htaccess file and create one if it does not exist.
		$htaccess_name = "$bk_dir/.htaccess";
		
		if ( !is_file( $htaccess_name ) ) {
		// open the .htaccess file for editing

			$htaccess = "order deny,allow\n\r";
			$htaccess .= "deny from all\n\r";
			$htaccess .= "allow from none\n\r";
			
			$file_handle = @ fopen( $htaccess_name, 'w+' );
			@ fwrite( $file_handle, $htaccess );
			@ fclose( $file_handle );
			@ chmod( $file_handle, 0665 );

		}
		

		
		
		
		if(array_key_exists('simple-backup', $_POST)) {
		
			set_time_limit(0);
			
			$action = false;

			
			echo "<div class='updated' style='overflow-y:auto; max-height:250px;  padding-left:10px;'>";
			
			
			
			//process wordpress optimizations
			if(isset($this->opt['wp_optimizer_settings'])){
			
				$wp_opt = $this->opt['wp_optimizer_settings'];
	
				if( isset($wp_opt) ){
	
					$action = $this->performWordPressOptimization();
					
				}
			}
			
			
			
			//process db optimizations
			if(isset($this->opt['db_optimizer_settings'])){
			
				$db_opt = $this->opt['db_optimizer_settings'];
			
				if( isset($db_opt) && $db_opt['check_database'] == "true"){
	
					$this->performDatabaseCheck();
					$action = true;
	
				}
	
				if( isset($db_opt) && $db_opt['repair_database'] == "true"){
				
					$this->performDatabaseRepair();
					$action = true;
				}
	
				if( isset($db_opt) && $db_opt['optimize_database'] == "true"){			
	
					$this->performDatabaseOptimization();
					$action = true;
				}
			}	
			
			
			
			//process backup functions
			if(isset($this->opt['backup_settings'])){
			
				$opt = $this->opt['backup_settings'];
				
				if( isset($opt) && $opt['enable_db_backup'] === "true"){
					$this->performDatabaseBackup();
					$action = true;
				}
				
				if( isset($opt) && $opt['enable_file_backup'] === "true"){
					$this->performWebsiteBackup();
					$action = true;
				}
			}
			
			
			
			
			if($action === false){
				echo "<p>Nothing to do... <a href='".admin_url()."/options-general.php?page=simple-backup-settings'>Change Backup Settings</a></p>";
			}
			
			echo "</div>";
			
		}
			

	}
	
	
		
	
	public function performWordPressOptimization(){
	
		global $wpdb;
		$action = false;
		
		$optimization_queries = array(
			'delete_spam_comments' => "DELETE FROM $wpdb->comments WHERE comment_approved = 'spam'",
			'delete_unapproved_comments' => "DELETE FROM $wpdb->comments WHERE comment_approved = '0'",
			'delete_revisions' => "DELETE FROM $wpdb->posts WHERE post_type = 'revision'",
			'delete_auto_drafts' => "DELETE FROM $wpdb->posts WHERE post_status = 'auto-draft'",
			'delete_transient_options' => "DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_%'"
		);
		
		$wp_optimization_methods = $this->opt['wp_optimizer_settings'];
	
		$queries = $optimization_queries;
	
		foreach($queries as $method => $query){
			if(isset($wp_optimization_methods[$method]) && $wp_optimization_methods[$method] === "true"){
			
				echo "<p>Performing Optimization: " . $method."<br>";
				$result = $wpdb->query($query);
				echo "$result items deleted.</p>";
				$action = true;	
			}
		}
		
		return $action;
	}
	
	
	public function performDatabaseCheck(){
		$debug_enabled = 'false';
		//$debug_enabled = get_option('debug_enabled');

		echo "<p>";
		echo "Checking Database...<br>";
		
		$local_query = 'SHOW TABLE STATUS FROM `'. DB_NAME.'`';
		$result = mysql_query($local_query);
		if (mysql_num_rows($result)){
			
			while ($row = mysql_fetch_array($result)){
			
				$check_query = "CHECK TABLE ".$row['Name'];
				$check_result = mysql_query($check_query);
				if (mysql_num_rows($check_result)){
					while($rrow = mysql_fetch_assoc($check_result)){
						if( $debug_enabled == "true"){
							echo "Table: " . $row['Name'] ." ". $rrow['Msg_text'];
							echo "<br>";
						}
					}
				}
				
				//$initial_table_size += $table_size; 
				
			}
			
			echo "Done!<br>";
			
		}
	
		echo "</p>";
	
	}



	public function performDatabaseRepair(){
		$debug_enabled = 'false';
		//$debug_enabled = get_option('debug_enabled');

		echo "<p>";
		echo "Repairing Database...<br>";
		
		$local_query = 'SHOW TABLE STATUS FROM `'. DB_NAME.'`';
		$result = mysql_query($local_query);
		if (mysql_num_rows($result)){
			
			while ($row = mysql_fetch_array($result)){
			
				$check_query = "REPAIR TABLE ".$row['Name'];
				$check_result = mysql_query($check_query);
				if (mysql_num_rows($check_result)){
					while($rrow = mysql_fetch_assoc($check_result)){
						if( $debug_enabled == "true"){
							echo "Table: " . $row['Name'] ." ". $rrow['Msg_text'];
							echo "<br>";
						}
					}
				}
				
			}
			
			echo "Done!<br>";
			
		}
	
		echo "</p>";
	
	}
	
	
	public function performDatabaseOptimization(){
		
		$initial_table_size = 0;
		$final_table_size = 0;
		
		$debug_enabled = 'false';
		//$debug_enabled = get_option('debug_enabled');
		
			
		echo "<p>";	
		echo "Optimizing Database...<br>";
		
		$local_query = 'SHOW TABLE STATUS FROM `'. DB_NAME.'`';
		$result = mysql_query($local_query);
		if (mysql_num_rows($result)){
			
			while ($row = mysql_fetch_array($result)){
				//var_dump($row);
				
				$table_size = ($row[ "Data_length" ] + $row[ "Index_length" ]) / 1024;
				
				$optimize_query = "OPTIMIZE TABLE ".$row['Name'];
				if(mysql_query($optimize_query)){
				
					if( $debug_enabled == "true"){
						echo "Table: " . $row['Name'] . " optimized!";
						echo "<br>";
					}
				}
				
				$initial_table_size += $table_size; 
				
			}
			
			echo "Done!<br>";
			
		}
		
		
		
		
		$local_query = 'SHOW TABLE STATUS FROM `'. DB_NAME.'`';
		$result = mysql_query($local_query);
		if (mysql_num_rows($result)){
			while ($row = mysql_fetch_array($result)){
				$table_size = ($row[ "Data_length" ] + $row[ "Index_length" ]) / 1024;
				$final_table_size += $table_size;
			}
		}
		
		
		
		echo "<br>";
		echo "Initial DB Size: " . number_format($initial_table_size, 2) . " KB<br>";
		echo "Final DB Size: " . number_format($final_table_size, 2) . " KB<br>";
		
		$space_saved = $initial_table_size - $final_table_size;
		$opt_pctg = 100 * ($space_saved / $initial_table_size);
		echo "Space Saved: " . number_format($space_saved,2) . " KB  (" .  number_format($opt_pctg, 2) . "%)<br>";
		echo "</p>";
	
	}
	


	public function performDatabaseBackupDebug(){
		$bk_dir = ABSPATH."simple-backup";
		$db_bk_file = $bk_dir . "/db_backup_".date('Y-m-d_His').".sql";
		$command = "mysqldump --single-transaction -u ".DB_USER." -p'".DB_PASSWORD."' ".DB_NAME." -h ".DB_HOST;
			
	}

	public function performDatabaseBackup(){
	
		$bk_dir = ABSPATH."simple-backup";
		
		$base_bk_command = "mysqldump --single-transaction -u ".DB_USER." -p'".DB_PASSWORD."' ".DB_NAME." -h ".DB_HOST;
		
		$db_compression = $this->opt['backup_settings']['db_compression'];
		
		//the syntax for mysqldump requires that there is NOT a space between the -p and the password
		if($db_compression == ".sql"){
			$db_bk_file = $bk_dir . "/db_backup_".date_i18n('Y-m-d_His').".sql";
			$command =  $base_bk_command . " > $db_bk_file";
			
		}elseif($db_compression == ".sql.gz"){
			$db_bk_file = $bk_dir . "/db_backup_".date_i18n('Y-m-d_His').".sql.gz";
			$command = $base_bk_command . " | gzip -c > $db_bk_file ";
			
		}elseif($db_compression == ".sql.bz2"){
			$db_bk_file = $bk_dir . "/db_backup_".date_i18n('Y-m-d_His').".sql.bz2";
			$command = $base_bk_command . " | bzip2 -cq9 > $db_bk_file";
	
		}elseif($db_compression == ".sql.zip"){
			$db_bk_file = $bk_dir . "/db_backup_".date_i18n('Y-m-d_His').".sql.zip";
			$command = $base_bk_command . " | zip > $db_bk_file";
		}
		
	
		echo "<p>";
		echo "<b>Executing Command:</b><br>$command";
		
		ob_flush();
		flush();
		
		echo "<br>";
		
		$debug_enabled = false;
		
		if( $debug_enabled == "true"){
			exec($command);
			
			ob_start();
			passthru($base_bk_command);
			$debug_output = htmlentities(ob_get_clean());
			echo $debug_output;
			
			
		}else{
			exec($command);
		};
		echo "<br>";
		
		echo "Done!";
		echo "</p>";
		
		ob_flush();
		flush();
				
	}
	
	
	public function performWebsiteBackup(){
	
		$bk_dir = ABSPATH."simple-backup";
		//$bk_name = "$bk_dir/backup-".date('Y-m-d-His').".tar.gz";
		$src_name = ABSPATH;
		$exclude = $bk_dir;
		

		$file_compression = $this->opt['backup_settings']['file_compression'];
		
		if($file_compression == ".tar.gz"){
			$bk_name = "$bk_dir/backup-".date_i18n('Y-m-d-His').".tar.gz";
			$command = "tar cvfz $bk_name --exclude=$exclude $src_name ";
			
		}elseif($file_compression == ".tar.bz2"){
			$bk_name = "$bk_dir/backup-".date_i18n('Y-m-d-His').".tar.bz2";
			$command = "tar jcvf $bk_name --exclude=$exclude $src_name";
			
		}elseif($file_compression == ".tar"){
			$bk_name = "$bk_dir/backup-".date_i18n('Y-m-d-His').".tar";
			$command = "tar cvf $bk_name --exclude=$exclude $src_name";
			
		}elseif($file_compression == ".zip"){
			$bk_name = "$bk_dir/backup-".date_i18n('Y-m-d-His').".zip";
			$command = "zip -r $bk_name $src_name -x $exclude/*";
		}
		
		
	
		
		echo "<p>";
		echo "<b>Executing Command in Background:</b><br>$command";
		
		ob_flush();
		flush();
		
		echo "<br>";
		
		
		$debug_enabled = false;
		
		if( $debug_enabled == "true"){
			passthru($command);
		}else{
		
			$this->exec_backup($command, $bk_name);
	
		};
		
		
		
		echo "<br>";
		echo "<img src='".site_url()."/wp-admin/images/loading.gif' style='vertical-align: top;'>";
				echo "  File Backup is Processing in the Background!  <a href=''>(Refresh)</a>";
		//echo "Processing!";
		echo "</p>";
		
		ob_flush();
		flush();
	
	}
	
	
	private function exec_backup($command, $bk_name){
		
		update_option('simple-backup-background-processing', $bk_name);
			
		exec($command . " > /dev/null &");
		
	}
	
	



	
	public function get_backup_files(){
	
		$bk_dir = ABSPATH."simple-backup";
			
		if(!is_dir($bk_dir)){
			mkdir($bk_dir);
		}
		
		if(!is_dir($bk_dir)){
			echo "Can not access: $bk_dir<br>";
		}


		//$tz = get_option('timezone_string') ? get_option('timezone_string') : "UTC+".get_option('gmt_offset');

		$tz = get_option('timezone_string');
		$offset = get_option('gmt_offset');
		
		if($tz == ''){
			 $tz = timezone_name_from_abbr('', $offset * 3600, 1);
		}

		try {
			$date = new DateTime("@".time());
			$date->setTimezone(new DateTimeZone($tz)); 

		} catch (Exception $e) {
			echo '<div class="error" style="padding:10px;">';
			echo "ERROR: <br />";
			echo "Your Timezone is currently set to: " . $tz. "<br />";
			echo "Please Choose A Timezone like 'Chicago' on the <a href='".admin_url()."options-general.php'>Settings Page</a><br />";
			echo "</div>";
		}
		
				

		$allowed_file_types = array('gz', 'sql', 'zip', 'tar', 'bz2');
		
		$bk_file_count = 0;
		
		$bk_files = array();
		
		$iterator = new RecursiveDirectoryIterator($bk_dir);
		foreach (new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST) as  $file) {
			$file_info = pathinfo($file->getFilename());
			if($file->isFile() && in_array(strtolower($file_info['extension']), $allowed_file_types)){ //create list of files
			
				$fileUrl = site_url()."/simple-backup/".$file->getFilename();
				$filePath = ABSPATH."/simple-backup/".$file->getFilename();
		
				
				try {
					
					$date = new DateTime("@".filectime($filePath));
					//$date->setTimezone(new DateTimeZone(get_option('timezone_string'))); 
					$date->setTimezone( new DateTimeZone($tz) ); 
				} catch (Exception $e) {
				

				}

				 
				
				$bk_files[ $bk_file_count ]['date'] = $date->format('Y-m-d g:i:s A T');
				//$bk_files[ $bk_file_count ]['timestamp'] = $date->getTimestamp();
				$bk_files[ $bk_file_count ]['filename'] = $file->getFilename();
				//$bk_files[ $bk_file_count ]['size'] = size_format(filesize($filePath),2);
				$bk_files[ $bk_file_count ]['size'] = filesize($filePath);
				$bk_files[ $bk_file_count ]['link'] = $fileUrl;
				
				$bk_file_count++;
				
			}
		}


		return $bk_files;
		
	}
	



	function screen_options(){

        //execute only on login_log page, othewise return null
        $page = ( isset($_GET['page']) ) ? esc_attr($_GET['page']) : false;
        if( 'backup_manager' != $page )
            return;

        $current_screen = get_current_screen();

        //define options
        $per_page_field = 'per_page';
        $per_page_option = $current_screen->id . '_' . $per_page_field;

        //Save options that were applied
        if( isset($_REQUEST['wp_screen_options']) && isset($_REQUEST['wp_screen_options']['value']) ){
            update_option( $per_page_option, esc_html($_REQUEST['wp_screen_options']['value']) );
        }

        //prepare options for display

        //if per page option is not set, use default
        $per_page_val = get_option($per_page_option, 20);
        $args = array('label' => __('Files', 'simple-backup'), 'default' => $per_page_val );

        //display options
        add_screen_option($per_page_field, $args);
        $_per_page = get_option('backup_files_per_page');

        //create custom list table class to display  data
        $this->backup_table = new Backup_List_Table;
		$this->ftp_backup_table = new FTP_Backup_List_Table;
		$this->ftp_backup_table->opt = $this->opt;
    }


	private function background_process_check(){
	
		$background = get_option('simple-backup-background-processing', 'false');
	
		if(isset($background) && ("false" <> $background)){
			
			clearstatcache();
		
			if( file_exists($background) && filemtime($background) == time() ){
				echo "<div class='updated'>";
				echo "<p><img src='".site_url()."/wp-admin/images/loading.gif' style='vertical-align: top;'>";
				echo "  File Backup is Processing in the Background!  <a href=''>(Refresh)</a></p></div>";
			}else{
				update_option('simple-backup-background-processing', 'false');
				echo "<div class='updated'><p>File Backup Processing is Finished!  <a href=''>(Close)</a></p></div>";
			}

		}
	
	}


	function backup_manager(){
		
		echo '<style type="text/css">';
			echo '.wp-list-table .column-date { width: 20%; }';
			echo '.wp-list-table .column-size { width: 20%; }';
			echo '.form-table{ clear:left; }';
			echo '.nav-tab-wrapper{ margin-bottom:0px; }';
		echo '</style>';
		
		
		echo Simple_Backup_Plugin::display_social_media();
		
		
		
		echo '<div class="wrap" id="sm_div">';
		
		
		
		echo '<div id="icon-tools" class="icon32"><br /></div>';
        echo '<h2>' . __('Simple Backup File Manager', 'simple-backup') . '</h2>';
		
		//echo "<p float='left'><a  href='".get_option('siteurl')."/wp-admin/options-general.php?page=simple-backup/plugin-admin.php' >View Simple Backup Plugin Settings</a></p>";
		
		$this->show_do_backup_button();
				
		$this->show_tab_nav();		
		
		echo "<h2>Local Backup Files</h2>";
		
		echo '<div id="poststuff" class="metabox-holder has-right-sidebar">';
		
		echo '<div id="post-body" class="metabox-holder columns-2">';	

		$this->background_process_check();
		$this->backup_processor_form();
		

		$backup_table = $this->backup_table;

		$backup_table->prepare_items();
		$backup_table->display();
		
	
		
		echo "</div>";
		
		echo "</div>";
		

		
		if(isset($this->opt['backup_settings']['enable_ftp_backup_system']) && "true" == $this->opt['backup_settings']['enable_ftp_backup_system']){
		
			echo "<br>";
			echo "<br>";
			echo "<br>";
		
			echo "<hr>";
			
			echo "<h2>FTP Server Backup Files</h2>";	
			
			$ftp_table = $this->ftp_backup_table;
	
			$ftp_table->prepare_items();
			$ftp_table->display();
		}
		
		echo "</div>";
		

		
	}
	
	
	
	private function show_tab_nav(){
	
		$tabs = array(
			array('id' => 'backup-settings', 'title' => 'Backup Settings', 'link' => admin_url().'options-general.php?page=simple-backup-settings&tab=backup_settings'),
			array('id' => 'backup-settings', 'title' => 'WordPress Optimization', 'link' => admin_url().'options-general.php?page=simple-backup-settings&tab=wp_optimizer_settings'),
			array('id' => 'backup-settings', 'title' => 'Database Optimization', 'link' => admin_url().'options-general.php?page=simple-backup-settings&tab=db_optimizer_settings'),
		);
			
		if(isset($this->opt['backup_settings']['enable_ftp_backup_system']) && "true" == $this->opt['backup_settings']['enable_ftp_backup_system']){
			$tabs[] = array('id' => 'backup-settings', 'title' => 'FTP Server Settings', 'link' => admin_url().'options-general.php?page=simple-backup-settings&tab=ftp_server_settings');		
		}
			
		
		$tabs[] = array('id' => 'plugin_tutorial', 'title' => 'Plugin Tutorial Video', 'link' => admin_url().'options-general.php?page=simple-backup-settings&tab=plugin_tutorial');
		$tabs[] = array('id' => 'upgrade_plugin', 'title' => 'Plugin Upgrades', 'link' => admin_url().'options-general.php?page=simple-backup-settings&tab=upgrade_plugin');
		
		$tabs[] = array('id' => 'backup-manager', 'title' => 'Backup Manager', 'link' => '');
		
	
		echo '<h3 class="nav-tab-wrapper">';
		
		foreach( $tabs as $tab ){
			$class = ( $tab['id'] == "backup-manager" ) ? ' nav-tab-active' : '';
			echo "<a class='nav-tab$class' href='".$tab['link']."'>".$tab['title']."</a>";
		}
		
		echo '</h3>';
		
	}


	private function show_do_backup_button(){
	
		//if(!isset($_GET['tab']) || ($_GET['tab'] != 'ftp_server_settings')){
		
			echo "<form method='post' action='".admin_url()."tools.php?page=backup_manager' style='display:inline;'>";
				echo '<div style=" margin-left:10px; margin-top:10px;">';
					echo "<input type='hidden' name='simple-backup' value='simple-backup'>";
					echo "<input type='submit' class='button-primary' value='Create WordPress Backup'>";
					
				echo "</div>";
			echo "</form>";
				
		//}
	}


}


?>