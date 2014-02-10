<?php
/**
 * @package   Options_Framework
 * @author    Devin Price <devin@wptheming.com>
 * @license   GPL-2.0+
 * @link      http://wptheming.com
 * @copyright 2013 WP Theming
 */

class Options_Framework_Admin {

	/**
	 * Page hook for the options screen
	 *
	 * @since 1.7.0
	 * @type string
	 */
    protected $options_screen = null;

	/**
	 * Hook in the scripts and styles
	 *
	 * @since 1.7.0
	 */
    public function init() {

		// Gets options to load
    	$options = & Options_Framework::_optionsframework_options();

		// Checks if options are available
    	if ( $options ) {

			// Add the options page and menu item.
			add_action( 'admin_menu', array( $this, 'add_options_page_menu' ) );

			// Add the required scripts and styles
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

			// Settings need to be registered after admin_init
			add_action( 'admin_init', array( $this, 'settings_init' ) );

		}

    }

	/**
	 * Registers the settings
	 *
	 * @since 1.7.0
	 */
    function settings_init() {

		// Load Options Framework Settings
        $optionsframework_settings = get_option( 'optionsframework' );

		// Registers the settings fields and callback
		register_setting( 'optionsframework', $optionsframework_settings['id'],  array ( $this, 'validate_options' ) );

		// Displays notice after options save
		add_action( 'optionsframework_after_validate', array( $this, 'save_options_notice' ) );

    }

	static function menu_settings() {

		$menu = array(
			'page_title' => __( 'Frontier Options', 'frontier' ),
			'menu_title' => __( 'Frontier Options', 'frontier' ),
			'capability' => 'edit_theme_options',
			'menu_slug' => 'frontier-options'
		);

		return apply_filters( 'optionsframework_menu', $menu );
	}

	/**
     * Add a subpage called "Theme Options" to the appearance menu.
     *
     * @since 1.7.0
     */
	function add_options_page_menu() {

		$menu = $this->menu_settings();
		$this->options_screen = add_theme_page( $menu['page_title'], $menu['menu_title'], $menu['capability'], $menu['menu_slug'], array( $this, 'options_page' ) );

	}

	function enqueue_admin_styles() {
		wp_enqueue_style( 'optionsframework', OPTIONS_FRAMEWORK_DIRECTORY . 'css/optionsframework.css', array(), Options_Framework::VERSION );
		wp_enqueue_style( 'wp-color-picker' );
	}

	function enqueue_admin_scripts( $hook ) {

		$menu = $this->menu_settings();

		if ( 'appearance_page_' . $menu['menu_slug'] != $hook )
	        return;

		// Enqueue custom option panel JS
		wp_enqueue_script( 'options-custom', OPTIONS_FRAMEWORK_DIRECTORY . 'js/options-custom.js', array( 'jquery','wp-color-picker' ), Options_Framework::VERSION );

		// Inline scripts from options-interface.php
		add_action( 'admin_head', array( $this, 'of_admin_head' ) );
	}

	function of_admin_head() {
		// Hook to add custom scripts
		do_action( 'optionsframework_custom_scripts' );
	}

	/**
	 * Builds out the options panel.
	 *
	 * @since 1.7.0
	 */
	 function options_page() { ?>

		<div id="optionsframework-wrap" class="wrap">

		<?php $menu = $this->menu_settings(); ?>

	    <h2 class="nav-tab-wrapper">
	        <?php echo Options_Framework_Interface::optionsframework_tabs(); ?>
	    </h2>

	    <?php settings_errors( 'options-framework' ); ?>

	    <div id="optionsframework-metabox" class="metabox-holder">
		    <div id="optionsframework" class="postbox">
				<form action="options.php" method="post">
				<?php settings_fields( 'optionsframework' ); ?>
				<?php Options_Framework_Interface::optionsframework_fields(); /* Settings */ ?>
				<div id="optionsframework-submit">
					<input type="submit" class="button-primary" name="update" value="<?php esc_attr_e( 'Save Options', 'frontier' ); ?>" />
					<input type="submit" class="reset-button button-secondary" name="reset" value="<?php esc_attr_e( 'Restore Defaults', 'frontier' ); ?>" onclick="return confirm( '<?php print esc_js( __( 'Click OK to reset. Any theme settings will be lost!', 'frontier' ) ); ?>' );" />
					<div class="clear"></div>
				</div>
				</form>
			</div> <!-- / #container -->

			<div id="option-sidebar">
				<div id="donate" class="frontier-info">
					<div class="info-title"><h4>Support the Developer</h4></div>
					<div class="info-content">
						<p>If you liked this theme, please consider donating a small amount.</p>
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
						<input type="hidden" name="cmd" value="_donations">
						<input type="hidden" name="business" value="U92LEYCWW973S">
						<input type="hidden" name="lc" value="PH">
						<input type="hidden" name="item_name" value="Frontier Theme">
						<input type="hidden" name="currency_code" value="USD">
						<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHosted">
						<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form>
					</div>
				</div>

				<div id="theme-info" class="frontier-info">
					<div class="info-title"><h4>About Frontier Theme</h4></div>
					<div class="info-content">
						<div>&#9679;&nbsp;&nbsp;<a href="<?php echo esc_url( 'http://ronangelo.com/frontier/' ); ?>" target="_blank">Frontier Theme Page</a></div>
						<div>&#9679;&nbsp;&nbsp;<a href="<?php echo esc_url( 'http://ronangelo.com/frontier-documentation/' ); ?>" target="_blank">Frontier Documentation</a></div>
						<div>&#9679;&nbsp;&nbsp;<a href="<?php echo esc_url( 'http://ronangelo.com/frontier-changelog/' ); ?>" target="_blank">Frontier Changelog</a></div>
						<p>Have suggestions or need help? Post questions and comments on the theme's <a href="<?php echo esc_url( 'http://ronangelo.com/theme-forum/' ); ?>" target="_blank">support forum</a> or on <a href="<?php echo esc_url( 'http://wordpress.org/support/theme/frontier/' ); ?>" target="_blank">wordpress.org</a></p>
					</div>
				</div>
			</div>			
		</div>
		<?php do_action( 'optionsframework_after' ); ?>
		</div> <!-- / .wrap -->

	<?php
	}

	/**
	 * Validate Options.
	 *
	 * This runs after the submit/reset button has been clicked and
	 * validates the inputs.
	 *
	 * @uses $_POST['reset'] to restore default options
	 */
	function validate_options( $input ) {

		// Restore Defaults.

		if ( isset( $_POST['reset'] ) ) {
			add_settings_error( 'options-framework', 'restore_defaults', __( 'Default options restored.', 'frontier' ), 'updated fade' );
			return $this->get_default_values();
		}

		// Update Settings

		$clean = array();
		$options = & Options_Framework::_optionsframework_options();
		foreach ( $options as $option ) {

			if ( ! isset( $option['id'] ) ) {
				continue;
			}

			if ( ! isset( $option['type'] ) ) {
				continue;
			}

			$id = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $option['id'] ) );

			// Set checkbox to false if it wasn't sent in the $_POST
			if ( 'checkbox' == $option['type'] && ! isset( $input[$id] ) ) {
				$input[$id] = false;
			}

			// Set each item in the multicheck to false if it wasn't sent in the $_POST
			if ( 'multicheck' == $option['type'] && ! isset( $input[$id] ) ) {
				foreach ( $option['options'] as $key => $value ) {
					$input[$id][$key] = false;
				}
			}

			// For a value to be submitted to database it must pass through a sanitization filter
			if ( has_filter( 'of_sanitize_' . $option['type'] ) ) {
				$clean[$id] = apply_filters( 'of_sanitize_' . $option['type'], $input[$id], $option );
			}
		}

		// Hook to run after validation
		do_action( 'optionsframework_after_validate', $clean );

		return $clean;
	}


	function save_options_notice() {
		add_settings_error( 'options-framework', 'save_options', __( 'Options saved.', 'frontier' ), 'updated fade' );
	}


	function get_default_values() {
		$output = array();
		$config = & Options_Framework::_optionsframework_options();

		foreach ( (array) $config as $option ) {
			if ( ! isset( $option['id'] ) ) {
				continue;
			}
			if ( ! isset( $option['std'] ) ) {
				continue;
			}
			if ( ! isset( $option['type'] ) ) {
				continue;
			}
			if ( has_filter( 'of_sanitize_' . $option['type'] ) ) {
				$output[$option['id']] = apply_filters( 'of_sanitize_' . $option['type'], $option['std'], $option );
			}
		}
		return $output;
	}

}