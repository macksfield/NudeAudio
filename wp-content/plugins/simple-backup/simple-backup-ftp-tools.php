<?php


class Simple_Backup_FTP_Tools{

	private $opt;
	
	private $server;
	private $port;
	private $user;
	private $pass;
	private $directory;


	public function __construct(){
		ignore_user_abort(true);
		set_time_limit(0);
		//ini_set('max_input_time', '60000');

		$this->opt 			= get_option('simple-backup-settings');
		
		if(isset($this->opt['ftp_server_settings'])){
			$this->server 		= $this->opt['ftp_server_settings']['ftp_server_hostname'];
			$this->port 		= $this->opt['ftp_server_settings']['ftp_server_port'];
			$this->user 		= $this->opt['ftp_server_settings']['ftp_server_username'];
			$this->pass 		= $this->opt['ftp_server_settings']['ftp_server_password'];
			$this->directory 	= $this->opt['ftp_server_settings']['ftp_server_directory'];
		}
	}
	
	


	//Main FTP stuff
	
	//watches the backup_manager page for FTP file transfers to monitor and display stats
	public function monitor_ftp_transfer(){
		
		$transfer_status = get_option('simple-backup-file-transfer');
		
		if($transfer_status['code'] == "PROCESSING"){
			echo "<div id='ajax_ftp_transfer' class='updated'><p><img src='".admin_url()."images/loading.gif' style='vertical-align: top;'> Transfer in Progress!!!</p></div>";
		}	
		?>
		
		<style>
			#progressbar {
				margin-top:10px;
				margin-bottom:5px;
			}
			.progress-label {
				float:left;
				margin-top: 5px;
				margin-left: 45%;
				text-shadow: 1px 1px 0 #fff;
				text-align:center;
				font-weight: bold;
			}
		</style>
  
  
		<script type="text/javascript">
		
			jQuery(document).ready(function($) {
			
				plugin_url = '<?php echo admin_url()."tools.php?page=backup_manager"; ?>';
						
				transfer_monitor = setTimeout('check_transfer_status()', 1000);
				
			});
		
		

			function check_transfer_status(){
				var data = {
					action: 'get_file_transfer_status',
					_ajax_nonce: '<?php echo wp_create_nonce( 'simple_backup_ajax_nonce' ); ?>'
					
				};
	
				jQuery.ajax({
					type: "POST",
					url: ajaxurl,
					data: data,
					dataType: "json",
					success: function(result) {
	
						if(result.code == "PROCESSING"){
	
							message = result.message+'<div id="progressbar"><div class="progress-label">'+result.percentage+'%</div></div>';
							jQuery('div#ajax_ftp_transfer').show();
							jQuery('div#ajax_ftp_transfer p').html(message);
							
							jQuery( "#progressbar" ).progressbar({
								value: parseInt(result.percentage)
							});
							
							setTimeout('check_transfer_status()', 100);
						}
						
						if(result.code == "PENDING"){
						
							message = result.message+'<div id="progressbar"></div>';
							jQuery('div#ajax_ftp_transfer').show();
							jQuery('div#ajax_ftp_transfer p').html(message);
							
							jQuery( "#progressbar" ).progressbar({value: false});
							
							setTimeout('check_transfer_status()', 500);		
						}
						
						if(result.code == "FINISHED"){
							
							message = "<strong style='float:right;'><a href='"+plugin_url+"'>(Close) <font style='font-size:+1.5em;'>&#10008;</font></a></strong>";
							message =  message + result.message + '<div id="progressbar"><div class="progress-label">'+result.percentage+'%</div></div>';
							
							jQuery('div#ajax_ftp_transfer p').html(message);
						
							jQuery( "#progressbar" ).progressbar({
								value: parseInt(result.percentage)
							});
						}
					}
				});
			}
	
		</script>
		<?php	

	}
	
	
	
	
	//setup the transfer status and enqueue an FTP get file transfer
	public function get_ftp_file(){
	
		$file = $_GET['ftp_get_backup_file'];
		
		$status['message'] = "$file is Queued for Transfer";
		$status['code'] = "PENDING";
		$status['percentage'] = 0;
		
		update_option('simple-backup-file-transfer', $status);
		
		$args['file'] = $_GET['ftp_get_backup_file'];
		$file_transfer_time = current_time('timestamp', true);
		wp_schedule_single_event($file_transfer_time, 'ftp_get_backup', $args);
		
		echo "<div id='ajax_ftp_transfer' class='updated'><p><img src='".admin_url()."images/loading.gif' style='vertical-align: top;'> Copying Backup File!!!</p></div>";

	}



	
	//setup the transfer status and enqueue an FTP put file transfer	
	public function put_ftp_file(){
	
		$file = $_GET['ftp_put_backup_file'];
		
		$status['message'] = "$file is Queued for Transfer";
		$status['code'] = "PENDING";
		$status['percentage'] = 0;
		
		update_option('simple-backup-file-transfer', $status);
		
		$args['file'] = $_GET['ftp_put_backup_file'];
		$file_transfer_time = current_time('timestamp', true);
		wp_schedule_single_event($file_transfer_time, 'ftp_put_backup', $args);
		
		echo "<div id='ajax_ftp_transfer' class='updated'><p><img src='".admin_url()."images/loading.gif' style='vertical-align: top;'> Queuing Backup File Transfer!!!</p></div>";

	}
	
	

	
	
	
	
	//FTP put file transfer
	private function put_large_ftp_file($file){
		
		$url = "ftp://{$this->user}:{$this->pass}@{$this->server}/{$this->directory}/$file";
		$path = ABSPATH."simple-backup/".$file;
		$file_pointer = fopen($path, "rb");
		
		$start = $this->timer();
		
		clearstatcache();
		$file_size = filesize($path);
		
		$connection = $this->connect();
		
		if($connection === false){
			die('Can not Connect to FTP Server');
		}
		
		if($login = $this->login($connection)){
				
			ftp_pasv($connection,TRUE);

			$upload_path = $this->find_target_dir($connection);
				
			$i = 0; //loop counter
			
			$ret = ftp_nb_fput($connection, $file, $file_pointer, FTP_BINARY, FTP_AUTORESUME);
			while ($ret == FTP_MOREDATA) {
		
				$i++;
				
				if($i % 500 == 0){
				
					$transfer_progress = ftell($file_pointer);
					
					$timer = ($this->timer() - $start);
					
					$pct_complete = ($transfer_progress/$file_size) * 100;
					$percentage_complete = number_format($pct_complete,1);
					$pct_complete = $percentage_complete."%";
						
					$message = ' %2$s of %3$s Transferred (%1$s Complete) in %4$s Seconds!';
					
					$msg = sprintf(
						$message, 
						$pct_complete, 
						size_format($transfer_progress,2), 
						size_format($file_size,2), 
						number_format($timer,2)
					);
					
					$status = array();
					$status['message'] = $msg;
					$status['code'] = "PROCESSING";
					$status['percentage'] = $percentage_complete;
					
					update_option('simple-backup-file-transfer', $status);
				

					echo ".";
					
					if($i % 2000 == 0){
						flush();
						ob_flush();
					}	
				}
				
				
				// Continue upload...	
				$ret = ftp_nb_continue($connection);
				 
			}
			

			if ($ret == FTP_FINISHED) {
				$end = number_format(($this->timer() - $start), 2);
				$rate = size_format((filesize($path) / $end),2) . "/s";

				$message =  "Successfully uploaded $file to $upload_path in $end seconds (rate: $rate)";
				$status['message'] = $message;
				$status['code'] = "FINISHED";
				$status['percentage'] = 100;
				update_option('simple-backup-file-transfer', $status);
				echo "\r\n$message";	
			} else {
				$message = "There was a problem while uploading $file to $upload_path '$ret'";
				$status['message'] = $message;
				$status['code'] = "ERROR";
				update_option('simple-backup-file-transfer', $status);
				echo "\r\n$message";	
			}	
			
			ftp_close($connection);
			fclose($file_pointer);
		}
		
		return true;
	}




	//FTP get file transfer
	private function get_large_ftp_file($file){
		
		$url = "ftp://{$this->user}:{$this->pass}@{$this->server}/{$this->directory}/$file";
		$path = ABSPATH."simple-backup/".$file;
		
		$start = $this->timer();
		
		clearstatcache();
		$file_size = filesize($url);
		
		$connection = $this->connect();
		
		if($connection === false){
			die('Can not Connect to FTP Server');
		}
		
		if($login = $this->login($connection)){
		
			ftp_pasv($connection,TRUE);
			
			$upload_path = $this->find_target_dir($connection);
					
			$i = 0; //loop counter
					
			$ret = @ftp_nb_get($connection, $path, $file, FTP_BINARY, FTP_AUTORESUME);
			while ($ret == FTP_MOREDATA) {
				
				$i++;

				if($i % 500 == 0){
				
					clearstatcache();
					$transfer_progress = filesize($path);
					
					$timer = ($this->timer() - $start);
					
					$pct_complete = ($transfer_progress/$file_size) * 100;
					$percentage_complete = number_format($pct_complete,1);
					$pct_complete = $percentage_complete."%";
						
					$message = ' %2$s of %3$s Transferred (%1$s Complete) in %4$s Seconds!';
					
					$msg = sprintf(
						$message, 
						$pct_complete, 
						size_format($transfer_progress,2), 
						size_format($file_size,2), 
						number_format($timer,2)
					);
					
					$status = array();
					$status['message'] = $msg;
					$status['code'] = "PROCESSING";
					$status['percentage'] = $percentage_complete;
					
					update_option('simple-backup-file-transfer', $status);
				

					echo ".";
					
					if($i % 2000 == 0){
						flush();
						ob_flush();
					}	
				}

				
			   // Continue upload...
			   $ret = ftp_nb_continue($connection);
			   
			}
			
			if ($ret == FTP_FINISHED) {
				$end = number_format(($this->timer() - $start), 2);
				$rate = size_format((filesize($path) / $end),2) . "/s";

				$message =  "Successfully downloaded $file to $path in $end seconds (rate: $rate)";
				$status['message'] = $message;
				$status['code'] = "FINISHED";
				$status['percentage'] = 100;
				update_option('simple-backup-file-transfer', $status);
				echo "\r\n$message";	
			} else {
				$message = "There was a problem while downloading $file to $path '$ret'";
				$status['message'] = $message;
				$status['code'] = "ERROR";
				update_option('simple-backup-file-transfer', $status);
				echo "\r\n$message";	
			}	
						

			ftp_close($connection);

		}
		
		return true;
		
		
	}







	

	//gets a list of files on FTP server in the specified directory
	public function get_ftp_backup_files(){
			
		//Connect to the FTP server
		if($ftp_connection = $this->connect()){
			//echo "<div class='updated success'><p>&#10004; Connected to FTP Server: {$this->server} on Port: {$this->port}</p></div>";
			
			//Login to the FTP server
			$ftp_login = $this->login($ftp_connection);
			if(!$ftp_login) {
				echo "<div class='error'><p>&#10008; ERROR: Could not log in to FTP Server as User: {$this->user}</p></div>";
			}else{	
				//echo "<div class='updated success'><p>&#10004; Logged in to FTP Server as User: {$this->user}</p></div>";

				$root_dirs = ftp_nlist($ftp_connection, ".");
				
				$dir = trim($this->directory, "/");
				$dirs = explode("/", $dir);
				$path = "/";
				
				foreach($dirs as $dir){
					$path = $path . $dir . "/";
					
					if(ftp_chdir($ftp_connection, $dir)){
						//echo "<div class='updated success'><p>&#10004; FTP Server Directory Changed to: $path</p></div>";
					}else{
						echo "<div class='error'><p>&#10008; ERROR: Could not Change Server Directory to: $path</p></div>";
						
						if(ftp_mkdir($ftp_connection, $dir)){
							//echo "<div class='updated success'><p>&#10004; FTP Server Directory: $path Created</p></div>";
						}else{
							echo "<div class='error'><p>&#10008; ERROR: Could not Create: $path</p></div>";
						}
					}
				}
			
			
				//attempt to return to the root
				foreach($dirs as $dir){
					ftp_cdup($ftp_connection);
				}
					
				$data = self::ftp_recursive_file_listing($ftp_connection, $dir);
			
			}
				
			//Close FTP connection
			ftp_close($ftp_connection);
			//echo "<div class='updated success'><p>&#10004; FTP Connection Closed</p></div>";
			
		}else{
			echo "<div class='error'><p>&#10008; ERROR: Could not connect to FTP Server: {$this->server}</p></div>";
		}


		
		$files = array();
		
		if(isset($data[$this->directory])){
			foreach($data[$this->directory] as $item){
				$files[] = $item;
			}
		}

		//print_r($files);
		return $files;
	
	}


	// tests FTP connection, login, directory and finally lists files in the specified directory
	public function connection_test(){
	
		echo "<style>";
		echo "div.updated p, div.updated h3, div.updated pre { color: green; }";
		echo "div.success { border-color: green; background-color:rgba(0,255,0,.05) !important; }";
		echo "div.error p{ color: red; }";
		echo "</style>";
			
		//Connect to the FTP server
		if($ftp_connection = $this->connect()){
			echo "<div class='updated success'><p>&#10004; Connected to FTP Server: {$this->server} on Port: {$this->port}</p></div>";
			
			//Login to the FTP server
			$ftp_login = $this->login($ftp_connection);
			if(!$ftp_login) {
				echo "<div class='error'><p>&#10008; ERROR: Could not log in to FTP Server as User: {$this->user}</p></div>";
			}else{	
				echo "<div class='updated success'><p>&#10004; Logged in to FTP Server as User: {$this->user}</p></div>";
			
				$root_dirs = ftp_nlist($ftp_connection, ".");
				
				$dir = trim($this->directory, "/");
				$dirs = explode("/", $dir);
				$path = "/";
				
				foreach($dirs as $dir){
					$path = $path . $dir . "/";
				
					if(ftp_chdir($ftp_connection, $dir)){
						echo "<div class='updated success'><p>&#10004; FTP Server Directory Changed to: $path</p></div>";
					}else{
						echo "<div class='updated'><p>&#10008; ERROR: Could not Change Server Directory to: $path</p></div>";
						
						if(ftp_mkdir($ftp_connection, $dir)){
							echo "<div class='updated success'><p>&#10004; FTP Server Directory: $path Created</p></div>";
						}else{
							echo "<div class='error'><p>&#10008; ERROR: Could not Create: $path</p></div>";
						}
					}
				}

				
				echo "<div class='updated success'><h3>&#10004; FTP Server Files and Directories</h3><pre>";
					
					//$data = $this->ftp_recursive_file_listing($ftp_connection, ".");
					$data = ftp_rawlist($ftp_connection, ".", true);
					
					print_r($data);
					
				echo "</pre></div>";
			
			}
				
			//Close FTP connection
			ftp_close($ftp_connection);
			echo "<div class='updated success'><p>&#10004; FTP Connection Closed</p></div>";
			
		}else{
			echo "<div class='error'><p>&#10008; ERROR: Could not connect to FTP Server: {$this->server}</p></div>";
		}


		
		$files = array();
		foreach($data[$this->directory] as $item){
			$files[] = $item;
		}

		//print_r($files);
		return $files;
	
	}



	
	//downloads backup file from FTP server and then relays it to browser as a file download
	public function ftp_download_file($filename){
	
		$url = "ftp://{$this->user}:{$this->pass}@{$this->server}/{$this->directory}/$filename";
		
		clearstatcache();
		$size = filesize($url);

		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');		
		header("Content-Disposition: attachment; filename=$filename");
		header("Content-Length: $size");
		header('Connection: close');  

		ob_clean();
		flush();
		
		readfile($url);
		
		die();
	
	}
	
	
	//deletes file from remote FTP server
	public function delete_ftp_file($file){
	
		$path = ABSPATH."simple-backup/".$file;
		
		$connection = $this->connect();
		
		if($connection === false){
			die('Can not Connect to FTP Server');
		}
		
		if($login = $this->login($connection)){
		
			$upload_path = $this->find_target_dir($connection);
			
			if(ftp_delete($connection, $file )){
				echo "<div class='updated'><p>Successfully deleted $file from $upload_path</p></div>\n";
			} else {
				echo "<div class='error'><p>There was a problem while deleting $file from $upload_path</p></div>\n";
			}
			
			ftp_close($connection);

		}
	}
	
	
	
	
	

	//Helper FTP Stuff
	
	private function ftp_recursive_file_listing($ftp_connection, $path = ".") { 
		static $allFiles = array(); 
		$contents = ftp_nlist($ftp_connection, $path); 
	
		foreach($contents as $currentFile) { 
			// assuming its a folder if there's no dot in the name 
			if (strpos($currentFile, '.') === false) { 
				$this->ftp_recursive_file_listing($ftp_connection, $currentFile); 
			} 
			
			$new_file['filename'] = substr($currentFile, strlen($path) + 1);
			
			//$new_file['size'] = ftp_size( $ftp_connection , $currentFile );
			
			$response =  ftp_raw($ftp_connection, "SIZE $currentFile"); 
			$filesize = floatval(str_replace('213 ', '', $response[0])); 
			$new_file['size'] = $filesize;
			
			$new_file['date'] = ftp_mdtm( $ftp_connection , $currentFile );
			$new_file['date']= date_i18n('Y-m-d g:i:s A T', $new_file['date']);
			
			$allFiles[$path][] = $new_file; 
		} 
		return $allFiles; 
	} 
	
	
	

	private function connect(){
	
		if("" == $this->server || "" == $this->port){
			$link = admin_url()."options-general.php?page=simple-backup-settings&tab=ftp_server_settings";
			$message = '<div class="error"><p>The FTP Server Settings need to be configured.';
			$message .= '<br>Please Configure and Save the <a href="%1$s">FTP Server Settings</a> before you continue!!</p></div>';
			echo sprintf($message, $link);
			return false;
		}
	
		$ftp_connection = ftp_connect($this->server, $this->port);
		
		if(false === $ftp_connection){
			return false;
		}else{
			return $ftp_connection;
		}
		
	}
	

	private function login($connection){
		$ftp_login = @ftp_login($connection, $this->user, $this->pass);
		
		if(true === $ftp_login){
			return true;
		}else{
			return false;
		}
	}


	private function find_target_dir($connection){
		$dir = trim($this->directory, "/");
		$dirs = explode("/", $dir);
		$path = "/";
		
		foreach($dirs as $dir){
			$path = $path . $dir . "/";
			if(ftp_chdir($connection, $dir)){
			
			}
		}
		
		return $path;
	}



	
	private function timer(){
		list($usec, $sec) = explode(" ", microtime());
    	return ((float)$usec + (float)$sec);
	}
	
	
	
	
	
	
	
	
	
	
	//AJAX Stuff
	
	public function ajax_put_ftp_file($file){
		//$this->put_large_ftp_file($_REQUEST['filename']);
		die();
	}
	
	public function ajax_get_ftp_file($file){
		//$this->get_large_ftp_file($_REQUEST['filename']);
		die();
	}	
	
	public function get_file_transfer_status(){
		check_ajax_referer('simple_backup_ajax_nonce');
		$status = get_option('simple-backup-file-transfer');
		header('Content-Type: application/json');
		echo json_encode($status);
		die();
	}
	
	
	
	
	
	//CRON Stuff
	
	//schedule FTP put file transfer
	public function cron_put_ftp_file($file){
		$this->clear_cron_last_run_time();
		$this->put_large_ftp_file($file);
		die();
	}
	
	//schedule FTP get file transfer
	public function cron_get_ftp_file($file){
		$this->clear_cron_last_run_time();
		$this->get_large_ftp_file($file);
		die();
	}	
		

	//delete the transient option that keeps track of the last time cron was run.
	//this will basically trigger cron to run when called
	//otherwise it will only run once per minute at most
	private function clear_cron_last_run_time(){
		delete_transient('doing_cron');
	}

}


?>
