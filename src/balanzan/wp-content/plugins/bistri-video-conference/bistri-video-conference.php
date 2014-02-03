<?php

/*
	Plugin Name: Bistri Video Conference
	Plugin URI: https://developers.bistri.com
	Description: Create a video conference in your posts
	Version: 1.0
	Author: Bistri
	Author URI: https://bistri.com
*/

// Defining


/**
 * Main BistriConference plugin class
 */

class BistriConference {

	public static $prefix = 'bvc_';

	function init() {

		// Add Bistri Conference API js into wp header
		add_action('wp_head', array( 'BistriConference', 'plugin_insert_js' ) );

		// Add custom menu handler
		add_action( 'admin_menu', array( 'BistriConference', 'plugin_menu' ) );

		// Add shortcode handler
		add_shortcode( 'bconference', array( 'BistriConference', 'plugin_shortcode_handler' ) );

	}

	function plugin_menu() {

		add_options_page(__('Bistri Video Conference', 'bistri-video-conference'), __('Bistri Video Conference', 'bistri-video-conference'), 'manage_options', 'bvc-options', array( 'BistriConference', 'plugin_options' ) );

	}

	function plugin_options() {

		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		$api_key = get_option( BistriConference::$prefix . 'api_key', "" );
		$app_key = get_option( BistriConference::$prefix . 'app_key', "" );

		?>
		<script>
			function generateShortcode(){
				var room = document.getElementById( 'bvc_room' ).value;
				var label = document.getElementById( 'bvc_label' ).value;
				document.getElementById( 'bvc_shortcode' ).value = "[bconference room=\""+ room +"\" label=\"" + label + "\"]";
			};
		</script>
		<div class="wrap">
			<h2>Bistri Video Conference Settings</h2>
			<p>In order to use Bistri Video Conference you need to create a <a href="https://api.developers.bistri.com/signup" target="_blank">developer account</a> on Bistri Developers.<br>Once you are logged in you just have to create a new application and it's done !</p>
			<form method="post" action="options.php">
				<?php wp_nonce_field( 'update-options' ); ?>
				<input type="hidden" name="action" value="update" />
				<input name="page_options" type="hidden" value="<?php echo BistriConference::$prefix . "api_key," . BistriConference::$prefix . "app_key"; ?>" />
				<h3>API key: </h3>
				<p><input type="text" name="<?php echo BistriConference::$prefix; ?>api_key" value="<?php echo $api_key; ?>" /></p>
				<h3>Application key: </h3>
				<p><input type="text" name="<?php echo BistriConference::$prefix; ?>app_key" value="<?php echo $app_key; ?>" /></p>
				<p class="submit"><input type="submit" name="Submit" value="save" class="button-primary"/></p>
			</form>
			<hr>
			<h3>How to insert a conference button into your posts</h3>
			<p>
				<ol>
					<li>set conference room name: <input type="text" id="bvc_room" value="" onkeyup="generateShortcode()"></li>
					<li>set conference button label: <input type="text" id="bvc_label" value="" onkeyup="generateShortcode()"></li>
					<li>copy the following code and paste it in a post or a page:<br>
						<textarea id="bvc_shortcode" style="width: 300px; height: 100px;">[bconference]</textarea>
					</li>
				</ol>
			</p>
		</div>
		<?php

	}

	function plugin_shortcode_handler( $attrs ) {

		$plugin_attrs = extract( shortcode_atts( array(
			'room' => 'default',
			'label' => 'Join Conference'
		), $attrs ) );

		ob_start();

		?>
		<a value="Join Conference" class="bistri-video-conference" data-room="<?php echo $room; ?>"><span><?php echo $label; ?></span></a>
		<?php

		$output_string = ob_get_contents();

		ob_end_clean();

		return $output_string;
	}

	function plugin_insert_js() {
		echo "<link rel=\"stylesheet\" href=\"" . plugins_url( 'bistri-video-conference.css', __FILE__ ) . "\"/>";
		echo "<script type=\"text/javascript\" src=\"" . plugins_url( 'bistri-video-conference.js', __FILE__ ) . "\"></script>";
		echo "<script type=\"text/javascript\">
			var bvc_page = \"" . plugins_url( 'conference/conference-popup.html', __FILE__ ) . "\";
			var bvc_apiKey = \"" . get_option( BistriConference::$prefix . 'api_key', "" ) . "\";
			var bvc_appKey = \"" . get_option( BistriConference::$prefix . 'app_key', "" ) . "\";
		</script>";
	}

} // end class


/// MAIN----------------------------------------------------------------------

add_action( 'plugins_loaded', array( 'BistriConference', 'init' ) );

?>