<?php
/**
 * @package   Options_Framework
 * @author    Devin Price <devin@wptheming.com>
 * @license   GPL-2.0+
 * @link      http://wptheming.com
 * @copyright 2013 WP Theming
 */

class Options_Framework {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since 1.7.0
	 * @type string
	 */
	const VERSION = '1.7.1';

	/**
	 * Initialize the plugin.
	 *
	 * @since 1.7.0
	 */
	public function init() {

		// Needs to run every time in case theme has been changed
		add_action( 'admin_init', array( $this, 'set_theme_option' ) );

	}

	/**
	 * Sets option defaults
	 *
	 * @since 1.7.0
	 */
	function set_theme_option() {

		// Load settings
        $optionsframework_settings = get_option( 'optionsframework' );

        // Updates the unique option id in the database if it has changed
        if ( function_exists( 'optionsframework_option_name' ) ) {
			optionsframework_option_name();
        }
        elseif ( has_action( 'optionsframework_option_name' ) ) {
			do_action( 'optionsframework_option_name' );
        }
        // If the developer hasn't explicitly set an option id, we'll use a default
        else {
            $default_themename = get_option( 'stylesheet' );
            $default_themename = preg_replace( "/\W/", "_", strtolower($default_themename ) );
            $default_themename = 'optionsframework_' . $default_themename;
            if ( isset( $optionsframework_settings['id'] ) ) {
				if ( $optionsframework_settings['id'] == $default_themename ) {
					// All good, using default theme id
				} else {
					$optionsframework_settings['id'] = $default_themename;
					update_option( 'optionsframework', $optionsframework_settings );
				}
            }
            else {
				$optionsframework_settings['id'] = $default_themename;
				update_option( 'optionsframework', $optionsframework_settings );
            }
        }

	}

	static function &_optionsframework_options() {
		static $options = null;

		if ( !$options ) {
	        // Load options from options.php file (if it exists)
	        $location = apply_filters( 'options_framework_location', array('options.php') );
	        if ( $optionsfile = locate_template( $location ) ) {
	            $maybe_options = require_once $optionsfile;
	            if ( is_array( $maybe_options ) ) {
					$options = $maybe_options;
	            } else if ( function_exists( 'optionsframework_options' ) ) {
					$options = optionsframework_options();
				}
	        }

	        // Allow setting/manipulating options via filters
	        $options = apply_filters( 'of_options', $options );
		}

		return $options;
	}

}