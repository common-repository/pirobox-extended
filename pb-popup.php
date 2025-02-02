<?php
/** Load WordPress Administration Bootstrap */
if(file_exists('../../../wp-load.php')) {
	require_once("../../../wp-load.php");
} else if(file_exists('../../wp-load.php')) {
	require_once("../../wp-load.php");
} else if(file_exists('../wp-load.php')) {
	require_once("../wp-load.php");
} else if(file_exists('wp-load.php')) {
	require_once("wp-load.php");
} else if(file_exists('../../../../wp-load.php')) {
	require_once("../../../../wp-load.php");
} else if(file_exists('../../../../wp-load.php')) {
	require_once("../../../../wp-load.php");
} else {

	if(file_exists('../../../wp-config.php')) {
		require_once("../../../wp-config.php");
	} else if(file_exists('../../wp-config.php')) {
		require_once("../../wp-config.php");
	} else if(file_exists('../wp-config.php')) {
		require_once("../wp-config.php");
	} else if(file_exists('wp-config.php')) {
		require_once("wp-config.php");
	} else if(file_exists('../../../../wp-config.php')) {
		require_once("../../../../wp-config.php");
	} else if(file_exists('../../../../wp-config.php')) {
		require_once("../../../../wp-config.php");
	} else {
		echo '<p>Failed to load bootstrap.</p>';
		exit;
	}

}

require_once(ABSPATH.'wp-admin/admin.php');

################################################################################
// REPLACE ADMIN URL
################################################################################

if (function_exists('admin_url')) {
	wp_admin_css_color('classic', __('Blue'), admin_url("css/colors-classic.css"), array('#073447', '#21759B', '#EAF3FA', '#BBD8E7'));
	wp_admin_css_color('fresh', __('Gray'), admin_url("css/colors-fresh.css"), array('#464646', '#6D6D6D', '#F1F1F1', '#DFDFDF'));
} else {
	wp_admin_css_color('classic', __('Blue'), get_bloginfo('wpurl').'/wp-admin/css/colors-classic.css', array('#073447', '#21759B', '#EAF3FA', '#BBD8E7'));
	wp_admin_css_color('fresh', __('Gray'), get_bloginfo('wpurl').'/wp-admin/css/colors-fresh.css', array('#464646', '#6D6D6D', '#F1F1F1', '#DFDFDF'));
}

wp_enqueue_script( 'common' );
wp_enqueue_script( 'jquery-color' );

@header('Content-Type: ' . get_option('html_type') . '; charset=' . get_option('blog_charset'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php do_action('admin_xml_ns'); ?> <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
	<title><?php _e('Embed Pirobox External / Video Content and google map'); ?></title>
	<?php
		wp_enqueue_style( 'global' );
		wp_enqueue_style( 'wp-admin' );
		wp_enqueue_style( 'colors' );
		wp_enqueue_style( 'media' );
	?>
	<script type="text/javascript">
	//<![CDATA[
		function addLoadEvent(func) {if ( typeof wpOnload!='function'){wpOnload=func;}else{ var oldonload=wpOnload;wpOnload=function(){oldonload();func();}}}
	//]]>
	</script>
	<?php
		do_action('admin_print_styles');
		do_action('admin_print_scripts');
		do_action('admin_head');
		if ( isset($content_func) && is_string($content_func) )
			do_action( "admin_head_{$content_func}" );
	?>
	<style type="text/css">
		form, h3 { margin-top: 0!important; padding-top: 10px; }
		textarea { height: 100px; }
		#wpadminbar { display:none; }
	</style>
</head>
<body>
<form class="media-upload-form type-form validate">
	<h3 class="media-title"><?php _e('Embed Pirobox External / Video Content and Google Map'); ?></h3>
	<div class="media-items">
		<div class="media-item media-blank">
			<table class="describe">
				<tr>
					<th class="label"><?php _e('Embed Code'); ?></th>
					<td class="field">
						<textarea id="pb-paste-box"></textarea>
						<p class="help">
							<?php _e('Paste the embed code here and Pirobox Extended will convert the code into a usable Pirobox format.'); ?>
						</p>
					</td>
				</tr>
				<tr>
					<th class="label"><?php _e('Link Caption'); ?></th>
					<td class="field">
						<input type="text" id="pb-link-name" />
						<p class="help">
							<?php _e('Enter the caption of the link to be embeded.'); ?>
						</p>
					</td>
				</tr>
				<tr>
					<th class="label"><?php _e('Width'); ?></th>
					<td class="field">
						<input type="text" id="pb-width" style="width: 200px" />
						<p class="help">
							<?php _e('Enter the width to override the default.'); ?>
						</p>
					</td>
				</tr>
				<tr>
					<th class="label"><?php _e('Height'); ?></th>
					<td class="field">
						<input type="text" id="pb-height" style="width: 200px" />
						<p class="help">
							<?php _e('Enter the height to override the default.'); ?>
						</p>
					</td>
				</tr>
				<tr>
					<th class="label"></th>
					<td class="field"><button type="button" class="button upload-button"><?php _e('Insert Media'); ?></button></td>
				</tr>
			</table>
		</div>
	</div>
</form>
</body>
</html>

<script type="text/javascript">
	/* <![CDATA[ */
		jQuery('form').submit(function(e){
			e.preventDefault();
			jQuery('.upload-button').click();
		});
		jQuery('.upload-button').click(function() {
			/**
			 * Get the URL of the video, check to see if it is
			 * http:// first and if not found then https:// second
			 * if neither are found yeild an error
			 */
			msg = '';
			embedcode = jQuery('#pb-paste-box').val();
			positionstart = embedcode.indexOf('http://');
			
			if (!positionstart)
				positionstart = embedcode.indexOf('https://');
				
			if (positionstart < 0)
				positionstart = 0;
				
			positionend = embedcode.indexOf('"', positionstart);
			
			if (positionend < 0)
				positionend = embedcode.length;
							
			srcval = embedcode.substr(positionstart, (positionend - positionstart));
			
			
			/**
			 * Get the width of the video
			 */
			widthval = jQuery('#pb-width').val().replace(/[^-\d\.]/g, '');;
			
			if (!widthval) {
				widthstart = embedcode.indexOf('width') + 7;
				widthend = embedcode.indexOf('"', widthstart);
			
				widthval = embedcode.substr(widthstart, (widthend - widthstart));
			}	
			
			
			/**
			 * Get the height of the video
			 */
			heightval = jQuery('#pb-height').val().replace(/[^-\d\.]/g, '');;

			if (!heightval) {
				heightstart = embedcode.indexOf('height') + 8;
				heightend = embedcode.indexOf('"', heightstart);
				
				heightval = embedcode.substr(heightstart, (heightend - heightstart));
			}
			
			
			/**
			 * Build the error message if necessary
			 */
			if ((!srcval) || (!widthval) || (!heightval)) {
				msg+= '<?php _e('Please make sure that the embed code has a link, width and height attributes or that you enter width and height attributes manually.'); ?>' + "\n\n";
			}
			
			
			/**
			 * Get the text display
			 */
			linkstring = jQuery('#pb-link-name').val();
			
			if (!linkstring) {
				msg+= '<?php _e('Please insert a caption for the link.'); ?>';
			}
			
			
			/**
			 * Check to see if have an
			 * error message and display it
			 * if necessary
			 */
			if (msg) {
				alert(msg);
				return;
			}
			
			
			/**
			 * Create the Pirobox link
			 */
			newstring = '<a href="' + srcval + '" class="pirobox" rel="iframe-' + widthval + '-' + heightval + '">' + linkstring + '</a>';

			
			/**
			 * Send the string to the editor
			 * and close the box
			 */
			var win = window.dialogArguments || opener || parent || top;
			win.send_to_editor(newstring);
			tb_remove();
			return false;
		});
	/* ]]> */
</script>