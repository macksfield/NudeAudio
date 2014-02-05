<style>
table.jvcf7_form td{ border:none !important;}
</style>
<table class="wp-list-table widefat fixed bookmarks">
                <thead>
                    <tr>
                        <th>Settings</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                    	
                        <form method="post" action="options.php">
						<?php settings_fields( 'jvcf7-settings-group' ); ?>
                        <table class="form-table jvcf7_form">
                            <tr valign="top">
                                <td scope="row">Show Error Message Next to the Field ?</td>
                                <td>
                                    <select name="jvcf7_show_label_error" style="width:100px;"  />
                                        <option value="yes" <?php echo $jvcf7_show_label_error == 'yes'?'selected="selected"':''; ?>>Yes</option>
                                        <option value="no" <?php echo $jvcf7_show_label_error == 'no'?'selected="selected"':''; ?>>No</option>
                                    </select>
                                    
                                </td>
                                
                                <td><em>Demo:</em> <br/>
                                    <img src="<?php echo plugins_url('jquery-validation-for-contact-form-7/img/show_error_label.png'); ?>" /></td>
                            </tr>
                            
                            <tr valign="top">
                                <td scope="row">Highlight Invalid Fields  ?</td>
                                <td>
                                    <select name="jvcf7_highlight_error_field" style="width:100px;"  />
                                        <option value="yes" <?php echo $jvcf7_highlight_error_field == 'yes'?'selected="selected"':''; ?>>Yes</option>
                                        <option value="no" <?php echo $jvcf7_highlight_error_field == 'no'?'selected="selected"':''; ?>>No</option>
                                    </select>
                                </td>
                                <td>
                                <em>Demo:</em> <br/>
                                    <img src="<?php echo plugins_url('jquery-validation-for-contact-form-7/img/highlight_invalid_fields.png'); ?>" />
                                </td>
                                
                            </tr>
                        </table>
                        
                        <p class="submit">
                        <input type="submit" name="submit-jvcf7" class="button-primary" value="<?php _e('Save Changes') ?>" />
                        </p>
                        
                        
                   	</td>
                    
                </tr>
                </tbody>
            </table>
            <br/>