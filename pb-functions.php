<?php
/**
 * Outputs checked="checked" if the value is checked
 */
function pb_checked( $value, $optionname ) {
	if ($optionname == $value)
		echo ' checked="checked"';
}


/**
 * Outputs selected="selected" if the value is selected
 */
function pb_selected( $value, $optionname ) {
	if ($optionname == $value)
		echo ' selected="selected"';	
}


/**
 * Add options page
 */
function pb_plugin_menu() {
	// Create a new options page
	$plugin_page = add_options_page( 'Pirobox Extended', 'Pirobox Extended', 'manage_options', 'pb-options', 'pb_options');
	add_action ('admin_head-' . $plugin_page, 'pb_add_scripts');
}


/**
 * Add scripts to admin page
 */
function pb_add_scripts() {
	echo '<link href="' . PB_URL . 'css/pb-admin.css?v=' . PB_VERSION .'" rel="stylesheet" type="text/css" />';
	echo '<script src="' . PB_URL . 'scripts/pb-admin.js?v=' . PB_VERSION .'" type="text/javascript" /></script>';
}


/**
 * Register settings
 */
function pb_register_settings() {
	// Register the settings
	register_setting( 'pb_settings', 'pb_settings' );
}


/**
 * Plugin activation hook
 */
function pb_activate() {
	// Only send if the plugin hasn't been activated before
	$isinstalled = get_option('pb_version');
	
	if (!$isinstalled) {
		// Send email to the adminstrator of the site
	}
	
	// Update version
	update_option( 'pb_version', PB_VERSION );
	
	// Check to see if there are any default settings
	$hasglobaloptions = get_option('pb_settings');
	
	if (!$hasglobaloptions) {
		$defaultoptions = array(
			'global_speed'			=>		'900',
			'global_opacity'		=>		'0.5',
			'global_center'			=>		'true',
			'zoom_option'			=>		'true',
			'zoom_animation'		=>		'mousemove',
			'enable_post_type_post' =>		1,
			'enable_post_type_page' =>		1,
			'enable_by_default' 	=>		'on',
			'default_style' 		=>		'style_2',
			'global_share'			=>		'true',
			'resize'				=>		'true'
		);
		update_option('pb_settings', $defaultoptions);
	}
}


/**
 * Global Options Page
 */
function pb_options(){ 
	global $pb_style_array, $pb_background_opacity, $pb_animation_speed, $pb_zoom_animation;	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"></div><h2><?php _e('Pirobox Extended'); ?></h2>
		<p><?php _e('Insert beautiful and flexible lightboxes into your Wordpress site with ease.'); ?></p>
        <p><strong><?php _e('NOTE:'); ?></strong> <?php _e('Depending on server configuration, you might have to change the file permissions of the '); ?><code>pb-popup.php</code><?php _e('file to 755.');?></p>
		
		<form method="post" action="options.php">
			<?php
			settings_fields( 'pb_settings' );
			$options = get_option( 'pb_settings' );
			?>
			<h3><?php _e('Global Behavior'); ?></h3>
		<table class="form-table">
            <tr valign="middle">
			<td width="178" align="right" style="font-weight:700;"><?php _e( 'Default Style' ); ?></td>
			<td width="25px">
                      <img src="<?php echo PB_URL; ?>images/help.png" alt="help" class="help_images" />
                      <div class="tooltip_images">
                      <?php _e( 'Select pirobox style' ); ?><br />
                          <img src="<?php echo PB_URL;?>/images/style1.jpg" alt="" />
                          <img src="<?php echo PB_URL;?>/images/style2.jpg" alt="" />
                          <img src="<?php echo PB_URL;?>/images/style3.jpg" alt="" />
                          <img src="<?php echo PB_URL;?>/images/style4.jpg" alt="" />
                          <img src="<?php echo PB_URL;?>/images/style5.jpg" alt="" />
                          <img src="<?php echo PB_URL;?>/images/style6.jpg" alt="" />
                          <img src="<?php echo PB_URL;?>/images/style7.jpg" alt="" />
                          <img src="<?php echo PB_URL;?>/images/style8.jpg" alt="" />
                    </div>
                </td>
                <td width="auto">
                    <select id="pb_settings[default_style]" name="pb_settings[default_style]">
                        <?php foreach ($pb_style_array as $style) : ?>
                        <option value="<?php echo $style['value']; ?>" <?php pb_selected($style['value'], $options['default_style']); ?>>
                        <?php echo $style['label']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
				</td>                             
			</tr>
            
			<tr valign="middle">
				<td align="right" style="font-weight:700;"><?php _e( 'Transition Speed' ); ?></td>
				<td>
					<img src="<?php echo PB_URL; ?>images/help.png" alt="help" class="help" />
					<div class="tooltip"><?php _e( 'Enter a number in milliseconds used for transition speed.' ); ?></div>
				</td>
				<td>
					<select id="pb_settings[global_speed]" name="pb_settings[global_speed]">
						<?php foreach ($pb_animation_speed as $speed) : ?>
                        <option value="<?php echo $speed['value']; ?>" <?php pb_selected($speed['value'], $options['global_speed']); ?>>
                        <?php echo $speed['label']; ?>
                        </option>
                        <?php endforeach; ?>
					</select>
				</td>                                 
			</tr>
            
			<tr valign="middle">
				<td align="right" style="font-weight:700;"><?php _e( 'Zoom Option' ); ?></td>
				<td>
					<img src="<?php echo PB_URL; ?>images/help.png" alt="help" class="help" />
					<div class="tooltip"><?php _e('Enable zooming for large images'); ?></div>
				</td>
				<td>
					<label for="pb_settings_zoom_option_on" class="pb_mode_label">
						<input type="radio" name="pb_settings[zoom_option]" id="pb_settings_zoom_option_on" value="true" <?php if ($options['zoom_option'] == 'true') echo ' checked="checked"'; ?>/> 
                        <?php _e('Enabled'); ?>
					</label>
					<label for="pb_settings_zoom_option_off" class="pb_mode_label">
						<input type="radio" name="pb_settings[zoom_option]" id="pb_settings_zoom_option_off" value="false" <?php if ($options['zoom_option'] == 'false') echo ' checked="checked"'; ?> /> 
                        <?php _e('Disabled'); ?>
                     </label>
				</td>                       
			</tr>
				
            <tr valign="middle">
                <td align="right" style="font-weight:700;"><?php _e( 'Zoom Animation' ); ?></td>
                <td>
                    <img src="<?php echo PB_URL; ?>images/help.png" alt="help" class="help" />
                    <div class="tooltip"><?php _e('Select the type of animation for large images.'); ?></div>
                </td> 
                <td>
                    <select id="pb_settings[zoom_animation]" name="pb_settings[zoom_animation]">
                        <?php foreach ($pb_zoom_animation as $animation) : ?>
                            <option value="<?php echo $animation['value']; ?>" <?php pb_selected($animation['value'], $options['zoom_animation']); ?>>
							<?php echo $animation['label']; ?>
                           	</option>
                        <?php endforeach; ?>
                    </select>
                </td>                 
            </tr>
				
            <tr valign="middle">
                <td align="right" style="font-weight:700;"><?php _e( 'Resize' ); ?></td>
                <td>
                    <img src="<?php echo PB_URL; ?>images/help.png" alt="help" class="help" />
                    <div class="tooltip"><?php _e('This option will make larger images fit the screen.'); ?></div>
                </td> 
                <td>
                    <label for="pb_settings_resize_on" class="pb_mode_label">
                        <input type="radio" name="pb_settings[resize]" id="pb_settings_resize_on" value="true" <?php if ($options['resize'] == 'true') echo ' checked="checked"'; ?>/> 
                    <?php _e('True'); ?>
					</label>
                    <label for="pb_settings_resize_off" class="pb_mode_label">
                        <input type="radio" name="pb_settings[resize]" id="pb_settings_resize_off" value="false" <?php if ($options['resize'] == 'false') echo ' checked="checked"'; ?> /> 
                    <?php _e('False'); ?>
                    </label>
                </td>                             
            </tr>
				
            <tr valign="middle">
                <td align="right" style="font-weight:700;"><?php _e( 'Opacity' ); ?></td>
                <td>
                    <img src="<?php echo PB_URL; ?>images/help.png"  alt="help" class="help" />
                    <div class="tooltip"><?php _e( 'Enter a decimal that will be used to determine the Priobox\'s opacity.' ); ?></div>
                </td>
                <td>
                    <select id="pb_settings[global_opacity]" name="pb_settings[global_opacity]">
                        <?php foreach ($pb_background_opacity as $opacity) : ?>
                            <option value="<?php echo $opacity['value']; ?>" <?php pb_selected($opacity['value'], $options['global_opacity']); ?>>
							<?php echo $opacity['label']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>                                
            </tr>
				
            <tr valign="middle">
                <td align="right" style="font-weight:700;">
				<?php _e( 'Center Pirobox on page' ); ?></td>
                <td>
                    <img src="<?php echo PB_URL; ?>images/help.png"  alt="help" class="help" />
                    <div class="tooltip"><?php _e('Keeping this option on will make sure that the Pirobox is always display in the center of the page.'); ?></div>
                </td> 
                <td>
                    <label for="pb_settings_global_center_on" class="pb_mode_label">
                        <input type="radio" name="pb_settings[global_center]" id="pb_settings_global_center_on" value="true" <?php if ($options['global_center'] == 'true') echo ' checked="checked"'; ?>/> 
                    <?php _e('Enabled'); ?>
                    </label>
                    <label for="pb_settings_global_center_off" class="pb_mode_label">
                        <input type="radio" name="pb_settings[global_center]" id="pb_settings_global_center_off" value="false" <?php if ($options['global_center'] == 'false') echo ' checked="checked"'; ?> /> 
                    <?php _e('Disabled'); ?>
                    </label>
                </td>                            
            </tr>
				
            <tr valign="middle">
                <td align="right" style="font-weight:700;"><?php _e( 'Enable Share Features' ); ?></td>
                <td>	
                    <img src="<?php echo PB_URL; ?>images/help.png"  alt="help" class="help" />
                    <div class="tooltip"><?php _e('This option will enabling sharing of Pirobox content via Facebook and Twitter.'); ?></div>
                </td> 
                <td>
                    <label for="pb_settings_global_share_on" class="pb_mode_label">
                        <input type="radio" name="pb_settings[global_share]" id="pb_settings_global_share_on" value="true" <?php if ($options['global_share'] == 'true') echo ' checked="checked"'; ?>/> 
                    <?php _e('Enabled'); ?>
                    </label>
                    <label for="pb_settings_global_share_off" class="pb_mode_label">
                        <input type="radio" name="pb_settings[global_share]" id="pb_settings_global_share_off" value="false" <?php if ($options['global_share'] == 'false') echo ' checked="checked"'; ?> /> 
                    <?php _e('Disabled'); ?>
                    </label>
                </td>                                
            </tr>
		</table>
			
        <h3><?php _e('Implementation'); ?></h3>
        <table class="form-table">
            <tr valign="middle">
                <td width="178" align="right" style="font-weight:700;"><?php _e( 'Enable on these post types' ); ?></td>
                <td width="24px">
                    <img src="<?php echo PB_URL; ?>images/help.png"  alt="help" class="help" />
                    <div class="tooltip"><?php _e('Select which post types you wish you use Pirobox on.'); ?></div>
                </td> 
                <td width="auto">
                    <?php
                    $post_types=get_post_types();
                    foreach ($post_types as $post_type ) :
                    ?>
                        <label class="description pb_mode_label"  for="pb_settings[enable_post_type_<?php echo $post_type; ?>]">
                        	<input type="checkbox" id="pb_settings[enable_post_type_<?php echo $post_type; ?>]" name="pb_settings[enable_post_type_<?php echo $post_type; ?>]" value="1" <?php pb_checked($options['enable_post_type_' . $post_type], 1); ?> />
                        <?php _e( $post_type ); ?>
                        </label>
                    <?php endforeach; ?>
                </td>                               
            </tr>
                
            <tr valign="middle">
                <td align="right" style="font-weight:700;"><?php _e( 'Enable on a post per post basis' ); ?></td>
                <td><img src="<?php echo PB_URL; ?>images/help.png"  alt="help" class="help" />
                    <div class="tooltip"><?php _e('This option will enable the global Pirobox options on all the above selected post types by default.'); ?></div>
				</td>          
                <td>
                    <label for="pb_settings_enable_by_default_on" class="pb_mode_label">
                        <input type="radio" name="pb_settings[enable_by_default]" id="pb_settings_enable_by_default_on" value="on" <?php if ($options['enable_by_default'] == 'on') echo ' checked="checked"'; ?>/> 
                        <?php _e('On'); ?>
                    </label>
                    <label for="pb_settings_enable_by_default_off" class="pb_mode_label">
                        <input type="radio" name="pb_settings[enable_by_default]" id="pb_settings_enable_by_default_off" value="off" <?php if ($options['enable_by_default'] == 'off') echo ' checked="checked"'; ?> />
                        <?php _e('Off'); ?>
                    </label>
                </td>                
            </tr>
        </table>
			<p class="submit">
		    	<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		    </p>
		</form>
	</div><!-- .wrap -->
<?php }


/**
 * Add our meta box
 */
function pb_add_meta() {
	$options = get_option( 'pb_settings' );
	$post_types = get_post_types();
	foreach ($post_types as $post_type ) :
		if ($options['enable_post_type_' . $post_type]) {
			add_meta_box('pb_meta_section',
				__( 'Pirobox Settings', 'pb_domain' ), 
				'pb_output_meta',
				$post_type
			);
		}
	endforeach;
}


/**
 * Save the meta information
 */
function pb_save_post( $post_id ) {
	/**
	 * Verify if this is an auto save routine. 
	 * If it is our form has not been submitted, so we dont want to do anything
	 */
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;


	/**
	 * Verify this came from the our screen and with proper authorization,
	 * because save_post can be triggered at other times
	 */
	if ( !wp_verify_nonce( $_POST['pb_noncename'], plugin_basename( __FILE__ ) ) )
		return;


	/**
	 * Check permissions
	 */
	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
			return;
	}
	else {
		if ( !current_user_can( 'edit_post', $post_id ) )
			return;
	}

	
	/**
	 * OK, we're authenticated: we need to find and save the data
	 */
	$mydata = $_POST['pb_meta'];
	//$mydata = $_POST;
	update_post_meta($post_id, '_pb_meta', $mydata);
}


/**
 * Output the meta information
 */
function pb_output_meta( $post ) {
	global $pb_style_array, $pb_background_opacity, $pb_animation_speed, $pb_zoom_animation;

	/**
	 * Use nonce for verification
	 */
	wp_nonce_field( plugin_basename( __FILE__ ), 'pb_noncename' );

	
	/**
	 * Get global options
	 */
	$options = get_option( 'pb_settings' );

	
	/**
	 * Get the data and populate with
	 * global data if nothing is found
	 */
	$meta = get_post_meta($post->ID,'_pb_meta',TRUE);
	
	
	if (!$meta) {
		if ($options['enable_by_default'] == 'on')
			$option_translation = 'global';
		else
			$option_translation = 'off';
			
		$meta = array(
			'mode'				=>		$option_translation,
			'speed'				=>		$options['global_speed'],
			'opacity'			=>		$options['global_opacity'],
			'center'			=>		$options['global_center'],
			'style'				=>		$options['default_style'],
			'share'				=>		$options['global_share'],
			'zoom_option'		=>		$options['zoom_option'],
			'zoom_animation'	=>		$options['zoom_animation'],
			'resize'			=>		$options['resize']
		);
	}
	else {
		$meta = pb_populate_meta ($meta);
	}
	?>
	<style type="text/css">
		
		.pb_custom select { width: 240px; padding:5px 10px; height:auto; }
		.pb_mode_label{
			display:inline-block;
			margin:0 5px 0 0;
			padding:6px 10px; 
			background:#eee; 
			border:1px solid #dfdfdf;
			-webkit-border-radius: 4px;
			-moz-border-radius: 4px;
			border-radius: 4px;
			background:url(<?php echo PB_URL  ?>images/checkbox_gradient.gif) left bottom repeat-x;
		}
		.pb_mode_label:hover{
			background:url(<?php echo PB_URL  ?>images/checkbox_gradient_h.gif) left bottom repeat-x;
		}
		.tooltip{
			top:0;
			left:0;
			position:absolute;
			background:#f9f9f9;
			border:1px solid #ccc;
			padding:10px;
			z-index:100;
			display:none;
			-webkit-border-radius: 6px;
			-moz-border-radius: 6px;
			border-radius: 6px;
			cursor:pointer;
			-moz-box-shadow: 0 0 10px rgba(0,0,0,0.2);
			-webkit-box-shadow: 0 0 10px rgba(0,0,0,0.2);
			box-shadow: 0 0 10px rgba(0,0,0,0.2);
		}
		.tooltip_images{
			top:0;
			left:0;
			width:480px;
			position:absolute;
			background:#f9f9f9;
			border:1px solid #ccc;
			padding:10px;
			z-index:100;
			display:none;
			-webkit-border-radius: 6px;
			-moz-border-radius: 6px;
			border-radius: 6px;
			cursor:pointer;
			-moz-box-shadow: 0 0 10px rgba(0,0,0,0.2);
			-webkit-box-shadow: 0 0 10px rgba(0,0,0,0.2);
			box-shadow: 0 0 10px rgba(0,0,0,0.2);
		}
		.tooltip_images img{
			float:left;
			border:3px solid #ccc;
			padding:5px;
			margin:0 4px 4px 0;
			-webkit-border-radius: 6px;
			-moz-border-radius: 6px;
			border-radius: 6px;
		}
		.help{ position:relative; z-index:99; cursor:pointer;display:block;}
		.help_images{ position:relative; z-index:99; cursor:pointer;display:block;}
		.overlay{width:100%; height:100%; position:absolute; top:0; left:0; background:white; z-index:98; display:none;}
		.wp-editor-tools{
			position:relative;
		}
		.wp-media-buttons a{
			float:left;
			margin:0 5px 0 0
		}
	</style>
    <script type="text/javascript">
	jQuery(function($) {
		$('<div class="overlay" />').appendTo('body').css('opacity',0);
		$('.help').hover(function(){
			var height = $(document).height();
			var position = $(this).position();
			$('.overlay').show().css({'height':height,'opacity':.5});
			$(this).next('.tooltip').css({
				'left':position.left+30,
				'top':position.top-($(this).next('.tooltip').height()/2)
			}).show();
			},function(){
				$('.overlay').hide();
				$(this).next('.tooltip').hide()
			});
		$('.help_images').hover(function(){
			var height = $(document).height();
			var position = $(this).position();
			$('.overlay').show().css({'height':height,'opacity':.5});
			$(this).next('.tooltip_images').css({
				'left':position.left+30,
				'top':position.top-($(this).next('.tooltip_images').height()/2)
			}).show();
			},function(){
				$('.overlay').hide();
				$(this).next('.tooltip_images').hide()
			});
		});
	</script>
	<h4><?php _e('Mode'); ?></h4>
	<p>
    	<label for="pb_mode_off" class="pb_mode_label">
			<input type="radio" name="pb_meta[mode]" id="pb_mode_off" value="off" class="pb_mode" <?php if ($meta['mode'] == 'off') echo ' checked="checked"'; ?> /> 
        	Off
        </label>
		<label for="pb_mode_global" class="pb_mode_label">
			<input type="radio" name="pb_meta[mode]" id="pb_mode_global" value="global" class="pb_mode" <?php if ($meta['mode'] == 'global') echo ' checked="checked"'; ?> /> 
        	Use Global Settings
        </label>
		<label for="pb_mode_perpage" class="pb_mode_label">
			<input type="radio" name="pb_meta[mode]" id="pb_mode_perpage" value="perpage" class="pb_mode" <?php if ($meta['mode'] == 'perpage') echo ' checked="checked"'; ?> /> 
        	Use Per Page Settings
         </label>
	</p>
	<div class="pb_global" <?php if (($meta['mode'] == 'off') || ($meta['mode'] == 'perpage')) echo ' style="display: none;"'; ?>>
		<h4 style="margin: 0; padding: 1.33em 0 1em;"><?php _e('Global Settings'); ?></h4>
		<table class="form-table" style="margin-top: 0;">
			<tr valign="top">
            	<th scope="row" style="padding-left: 0; padding-right: 0; padding-top: 0;"><?php _e( 'Style' ); ?></th>
				<td style="padding-top: 0;">
					<strong><?php echo $options['default_style']; ?></strong>
				</td>
			</tr>
			<tr valign="top">
            	<th scope="row" style="padding-left: 0; padding-right: 0; padding-top: 0;"><?php _e( 'Transition Speed' ); ?></th>
				<td style="padding-top: 0;">
					<strong><?php echo $options['global_speed']; ?></strong>
				</td>
			</tr>
			<tr valign="top">
            	<th scope="row" style="padding-left: 0; padding-right: 0; padding-top: 0;"><?php _e( 'Zoom Option' ); ?></th>
				<td style="padding-top: 0;">
					<strong><?php echo $options['zoom_option']; ?></strong>
				</td>
			</tr>
			<tr valign="top">
            	<th scope="row" style="padding-left: 0; padding-right: 0; padding-top: 0;"><?php _e( 'Zoom Animation' ); ?></th>
				<td style="padding-top: 0;">
					<strong><?php echo $options['zoom_animation']; ?></strong>
				</td>
			</tr>
			<tr valign="top">
            	<th scope="row" style="padding-left: 0; padding-right: 0; padding-top: 0;"><?php _e( 'Resize' ); ?></th>
				<td style="padding-top: 0;">
					<strong><?php echo $options['resize']; ?></strong>
				</td>
			</tr>
			<tr valign="top">
            	<th scope="row" style="padding-left: 0; padding-right: 0; padding-top: 0;"><?php _e( 'Opacity' ); ?></th>
				<td style="padding-top: 0;">
					<strong><?php echo $options['global_opacity']; ?></strong>
				</td>
			</tr>
			<tr valign="top">
            	<th scope="row" style="padding-left: 0; padding-right: 0; padding-top: 0;"><?php _e( 'Center Pirobox on page' ); ?></th>
				<td style="padding-top: 0;">
					<strong><?php echo $options['global_center']; ?></strong>
				</td>
			</tr>
			<tr valign="top">
            	<th scope="row" style="padding-left: 0; padding-right: 0; padding-top: 0;"><?php _e( 'Enable Sharing Features' ); ?></th>
				<td style="padding-top: 0;">
					<strong><?php echo $options['global_share']; ?></strong>
				</td>
			</tr>
		</table>
	</div>
	<div class="pb_custom" <?php if (($meta['mode'] == 'off') || ($meta['mode'] == 'global')) echo ' style="display: none;"'; ?>>
		<h4 style="margin: 0; padding: 1.33em 0;"><?php _e('Per Page Settings'); ?></h4>
		<table class="form-table" style="margin-top: 0;">
			<tr valign="middle">
            	<td align="right" style="font-weight:700;" width="140px"><?php _e( 'Style' ); ?></td>
				<td width="25px">
                      <img src="<?php echo PB_URL; ?>images/help.png" alt="help" class="help_images" />
                      <div class="tooltip_images">
                      <?php _e( 'Select pirobox style' ); ?><br />
                          <img src="<?php echo PB_URL;?>/images/style1.jpg" alt="" />
                          <img src="<?php echo PB_URL;?>/images/style2.jpg" alt="" />
                          <img src="<?php echo PB_URL;?>/images/style3.jpg" alt="" />
                          <img src="<?php echo PB_URL;?>/images/style4.jpg" alt="" />
                          <img src="<?php echo PB_URL;?>/images/style5.jpg" alt="" />
                          <img src="<?php echo PB_URL;?>/images/style6.jpg" alt="" />
                          <img src="<?php echo PB_URL;?>/images/style7.jpg" alt="" />
                          <img src="<?php echo PB_URL;?>/images/style8.jpg" alt="" />
                    </div>
                </td>
				<td width="auto">
					<select id="pb_meta[style]" name="pb_meta[style]">
						<?php foreach ($pb_style_array as $style) : ?>
							<option value="<?php echo $style['value']; ?>" <?php pb_selected($style['value'], $meta['style']); ?>><?php echo $style['label']; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
		
			<tr valign="middle">
            	<td align="right" style="font-weight:700;"><?php _e( 'Transition Speed' ); ?></td>
				<td>
					<img src="<?php echo PB_URL; ?>images/help.png" alt="help" class="help" />
					<div class="tooltip"><?php _e( 'Select animation speed' ); ?></div>
				</td>
				<td style="padding-top: 0;">
					<select id="pb_meta[speed]" name="pb_meta[speed]">
						<?php foreach ($pb_animation_speed as $speed) : ?>
							<option value="<?php echo $speed['value']; ?>" <?php pb_selected($speed['value'], $meta['speed']); ?>><?php echo $speed['label']; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			
			<tr valign="middle">
            	<td align="right" style="font-weight:700;"><?php _e( 'Zoom Option' ); ?></td>
				<td>
					<img src="<?php echo PB_URL; ?>images/help.png" alt="help" class="help" />
					<div class="tooltip"><?php _e('How to handle large images'); ?></div>
				</td>
				<td>
                	<label for="pb_meta_zoom_option_on" class="pb_mode_label">
						<input type="radio" name="pb_meta[zoom_option]" id="pb_meta_zoom_option_on" value="true" <?php if ($meta['zoom_option'] == 'true') echo ' checked="checked"'; ?>/> 
                    <?php _e('Enabled'); ?>
                    </label>
                    <label for="pb_meta_zoom_option_off"  class="pb_mode_label">
						<input type="radio" name="pb_meta[zoom_option]" id="pb_meta_zoom_option_off" value="false" <?php if ($meta['zoom_option'] == 'false') echo ' checked="checked"'; ?> /> 
                    <?php _e('Disabled'); ?></label>
				</td>
			</tr>
			
			<tr valign="middle">
            	<td align="right" style="font-weight:700;"><?php _e( 'Zoom Animation' ); ?></td>
                <td>
                    <img src="<?php echo PB_URL; ?>images/help.png" alt="help" class="help" />
                    <div class="tooltip"><?php _e('Large image zoom animation type'); ?></div>
                </td>             
				<td style="padding-top: 0;">
					<select id="pb_meta[zoom_animation]" name="pb_meta[zoom_animation]">
						<?php foreach ($pb_zoom_animation as $animation) : ?>
							<option value="<?php echo $animation['value']; ?>" <?php pb_selected($animation['value'], $meta['zoom_animation']); ?>><?php echo $animation['label']; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			
			<tr valign="middle">
            	<td align="right" style="font-weight:700;"><?php _e( 'Resize' ); ?></td>
                <td>
                    <img src="<?php echo PB_URL; ?>images/help.png" alt="help" class="help" />
                    <div class="tooltip"><?php _e('Enable image resizing'); ?></div>
                </td>             
				<td>
                	<label for="pb_meta_resize_on" class="pb_mode_label">
						<input type="radio" name="pb_meta[resize]" id="pb_meta_resize_on" value="true" <?php if ($meta['resize'] == 'true') echo ' checked="checked"'; ?>/> 
                    <?php _e('True'); ?>
                    </label>
                    <label for="pb_meta_resize_off"  class="pb_mode_label">
						<input type="radio" name="pb_meta[resize]" id="pb_meta_resize_off" value="false" <?php if ($meta['resize'] == 'false') echo ' checked="checked"'; ?> /> 
                    <?php _e('False'); ?></label>
				</td>
			</tr>
			
			<tr valign="middle">
            	<td align="right" style="font-weight:700;"><?php _e( 'Opacity' ); ?></td>
                <td>
                    <img src="<?php echo PB_URL; ?>images/help.png"  alt="help" class="help" />
                    <div class="tooltip"><?php _e( 'Enter a decimal that will be used to determine the Priobox\'s opacity.' ); ?></div>
                </td>                
				<td>
					<select id="pb_meta[opacity]" name="pb_meta[opacity]">
						<?php foreach ($pb_background_opacity as $opacity) : ?>
							<option value="<?php echo $opacity['value']; ?>" <?php pb_selected($opacity['value'], $meta['opacity']); ?>><?php echo $opacity['label']; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			
			<tr valign="middle">
            	<td align="right" style="font-weight:700;"><?php _e( 'Center Pirobox on page' ); ?></td>
                <td>
                    <img src="<?php echo PB_URL; ?>images/help.png"  alt="help" class="help" />
                    <div class="tooltip"><?php _e('Keeping this option on will make sure that the Pirobox is always display in the center of the page.'); ?></div>
                </td>
                <td>	
                	<label for="pb_meta_global_center_on" class="pb_mode_label">
						<input type="radio" name="pb_meta[center]" id="pb_meta_global_center_on" value="true" <?php if ($meta['center'] == 'true') echo ' checked="checked"'; ?>/> 
                    <?php _e('Enabled'); ?></label>
                    <label for="pb_meta_global_center_off" class="pb_mode_label">
						<input type="radio" name="pb_meta[center]" id="pb_meta_global_center_off" value="false" <?php if ($meta['center'] == 'false') echo ' checked="checked"'; ?> /> 
                    <?php _e('Disabled'); ?></label>
				</td>
			</tr>
			
			
			<tr valign="middle">
            	<td align="right" style="font-weight:700;"><?php _e( 'Enable sharing features' ); ?></td>
                <td>	
                    <img src="<?php echo PB_URL; ?>images/help.png"  alt="help" class="help" />
                    <div class="tooltip"><?php _e('This option will enabling sharing of Pirobox content via Facebook and Twitter.'); ?></div>
                </td>                 
				<td>
                	<label for="pb_meta_global_share_on" class="pb_mode_label">
						<input type="radio" name="pb_meta[share]" id="pb_meta_global_share_on" value="true" <?php if ($meta['share'] == 'true') echo ' checked="checked"'; ?>/> 
                    <?php _e('Enabled'); ?></label>
                    <label for="pb_meta_global_share_off" class="pb_mode_label">
						<input type="radio" name="pb_meta[share]" id="pb_meta_global_share_off" value="false" <?php if ($meta['share'] == 'false') echo ' checked="checked"'; ?> /> 
                    <?php _e('Disabled'); ?></label>
				</td>
			</tr>
		</table>
	</div>
	
	<script type="text/javascript">
		jQuery(function($){
			$('.pb_mode:radio').click(function(){
				mode = $(this).val();
				
				switch (mode) {
					case 'off':
						$('.pb_global').slideUp('fast');
						$('.pb_custom').slideUp('fast');
						break;
					case 'global':						
						$('.pb_custom').slideUp('fast', function(){
							$('.pb_global').slideDown('fast');
						});
						break;
					case 'perpage':
						$('.pb_global').slideUp('fast', function(){
							$('.pb_custom').slideDown('fast');
						});
						break;
				}
			});
		});
	</script>
	
<?php }


/**
 * Populate our post meta information
 */
function pb_populate_post_meta( $postID ) {
	/**
	 * Get out post's meta information
	 */
	$meta = get_post_meta($postID,'_pb_meta',TRUE);
	$options = get_option( 'pb_settings' );
	
	/**
	 * Handle our post having no meta information
	 * or if the post uses global information
	 */
	if ((!$meta) || ($meta['mode'] == 'global')) {
		if (!$meta) {
			if ($options['enable_by_default'] == 'on')
				$option_translation = 'global';
			else
				$option_translation = 'off';
		} else
			$option_translation = $meta['mode'];
		
		$meta = array(
			'mode'				=>		$option_translation,
			'speed'				=>		$options['global_speed'],
			'opacity'			=>		$options['global_opacity'],
			'center'			=>		$options['global_center'],
			'share'				=>		$options['global_share'],
			'style'				=>		$options['default_style'],
			'zoom_option'		=>		$options['zoom_option'],
			'zoom_animation'	=>		$options['zoom_animation'],
			'resize'			=>		$options['resize']
		);
	}
	
	return $meta;
}


/**
 * Add our Pirobox!
 */
function pb_footer(){
	global $post;
	$options = get_option( 'pb_settings' );
	$meta = pb_populate_post_meta( $post->ID );
	
	if ($options['enable_post_type_' . $post->post_type] == 1) {
		if ($meta['mode'] != 'off') { ?>
<script type="text/javascript">
	jQuery(function($) {
		jQuery('a[href$="jpg"], a[href$="bmp"], a[href$="gif"], a[href$="jpeg"], a[href$="png"]').addClass('pirobox_gall_<?php echo $post->ID; ?>').attr('rel','gallery');
		$.pirobox_ext({
			piro_speed : <?php echo $meta['speed']; ?>,
			zoom_mode : <?php echo $meta['zoom_option']; ?>,
			move_mode : '<?php echo $meta['zoom_animation']; ?>',
			bg_alpha : <?php echo $meta['opacity']; ?>,
			piro_scroll : <?php echo $meta['center']; ?>,
			share: <?php echo $meta['share']; ?>,
			resize: <?php echo $meta['resize']; ?>
		});
	});
</script>
			<?php
		}
	}
}


/**
 * This function injects scripts
 * properly into the header
 */
function pb_enqueue_scripts(){
	global $post;
	$options = get_option( 'pb_settings' );
	$meta = pb_populate_post_meta( $post->ID );

	if ($options['enable_post_type_' . $post->post_type] == 1) {
		if ($meta['mode'] != 'off') { 
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui-draggable');
			
			wp_enqueue_style( 'pirobox', PB_URL . 'css/' . $meta['style'] . '/style.css');
			
			wp_enqueue_script('pirobox-js', PB_URL . 'js/pirobox_extended_v.1.2.js', 'jquery-ui-draggable', null, true);
		}
	}
}


/**
 * Add the media button to the toolbar
 */
function pb_media_button() {
	$url = PB_URL . 'pb-popup.php?tab=add&amp;TB_iframe=true';
	echo '<a style="" href="' . $url . '" class="thickbox help"><img src="' . PB_URL . 'images/pb-icon.gif" alt="' . __('Add Pirobox Video') . '"></a>
	<span class="tooltip">Embed Pirobox External / Video Content and Google Map</span>';
}


/**
 * Clean out our meta information
 * Make sure that if we DON'T have
 * an option populated that it will
 * be populated with the value from
 * the global options array
 */
function pb_populate_meta ($meta) {
	$options = get_option('pb_settings');
	
	if ( !$meta['speed'] ) $meta['speed'] = $options['global_speed'];
	if ( !$meta['opacity'] ) $meta['opacity'] = $options['global_opacity'];
	if ( !$meta['center'] ) $meta['center'] = $options['global_center'];
	if ( !$meta['share'] ) $meta['share'] = $options['global_share'];
	if ( !$meta['style'] ) $meta['style'] = $options['default_style'];
	if ( !$meta['zoom_option'] ) $meta['zoom_option'] = $options['zoom_option'];
	if ( !$meta['zoom_animation'] ) $meta['zoom_animation'] = $options['zoom_animation'];
	if ( !$meta['resize'] ) $meta['resize'] = $options['resize'];
	
	return ($meta);
}


/**
 * Uninstall our Pirobox
 */
function pb_uninstall () {
	global $wpdb;

	$wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key = '_pb_meta'");

	delete_option ( 'pb_version' );
	delete_option ( 'pb_settings' );
}