<?php

/* Load the core theme framework. */
require_once( trailingslashit( get_template_directory() ) . 'library/hybrid.php' );
new Hybrid();

// Get theme options
global $options;
$options = get_option('swt_theme_options'); 

/* Load theme options */
require_once( trailingslashit( get_template_directory() ) . 'includes/theme-options.php' );

/* Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'swt_theme_setup' );

/**
 * Theme setup function.  This function adds support for theme features and defines the default theme
 * actions and filters.
 *
 * @since 0.1.0
 */
function swt_theme_setup() {
    
	/* Get action/filter hook prefix. */
	$prefix = hybrid_get_prefix();

	/* Add theme support for core framework features. */
	add_theme_support( 'hybrid-core-menus', array( 'primary' ) );
	add_theme_support( 'hybrid-core-sidebars', array( 'primary', 'subsidiary' ) );
	add_theme_support( 'hybrid-core-widgets' );
	add_theme_support( 'hybrid-core-shortcodes' );
	add_theme_support( 'hybrid-core-drop-downs' );
	add_theme_support( 'hybrid-core-seo' );
	//add_theme_support( 'hybrid-core-template-hierarchy' );

	/* Add theme support for framework extensions. */
	add_theme_support( 'loop-pagination' );
	add_theme_support( 'get-the-image' );
	add_theme_support( 'cleaner-gallery' );

	/* Add theme support for WordPress features. */
	add_theme_support( 'automatic-feed-links' );

	/* Read more shortcode */
	add_shortcode('read_more', 'read_more_func');
	
	/* Set the content width. */
	hybrid_set_content_width( 560 );


	add_filter('dynamic_sidebar_params','widget_first_last_classes');
	
        /* Add fonts to wp_head */
        add_action( 'wp_enqueue_scripts', 'swt_scripts' );	
	
	/* Analytics code */
	global $options;
	if ( $options['swt_analytics_code']!=="" ) {
		add_action('wp_footer', 'swt_analytics2'); 
	}
        
	
}


/* inserts anayltics */
function swt_analytics2() {
	global $options;
	echo stripslashes( $options['swt_analytics_code'] );
}

/* Adding widget-first and widget-last classes to widgets */
function widget_first_last_classes($params) {

	global $my_widget_num; // Global a counter array
	$this_id = $params[0]['id']; // Get the id for the current sidebar we're processing
	$arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets

	if(!$my_widget_num) {// If the counter array doesn't exist, create it
		$my_widget_num = array();
	}

	if(!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) { // Check if the current sidebar has no widgets
		return $params; // No widgets in this sidebar... bail early.
	}

	if(isset($my_widget_num[$this_id])) { // See if the counter array has an entry for this sidebar
		$my_widget_num[$this_id] ++;
	} else { // If not, create it starting with 1
		$my_widget_num[$this_id] = 1;
	}

	$class = 'class="widget-' . $my_widget_num[$this_id] . ' '; // Add a widget number class for additional styling options

	if($my_widget_num[$this_id] == 1) { // If this is the first widget
		$class .= 'widget-first ';
	} elseif($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) { // If this is the last widget
		$class .= 'widget-last ';
	}

	$params[0]['before_widget'] = str_replace('class="', $class, $params[0]['before_widget']); // Insert our new classes into "before widget"

	return $params;

}


/*this function allows for the auto-creation of post excerpts*/
function truncate_post($amount,$quote_after=false) {
	$truncate = get_the_content();
	$truncate = apply_filters('the_content', $truncate);
	$truncate = preg_replace('@<script[^>]*?>.*?</script>@si', '', $truncate);
	$truncate = preg_replace('@<style[^>]*?>.*?</style>@si', '', $truncate);
	$truncate = strip_tags($truncate);
	$truncate = substr($truncate, 0, strrpos(substr($truncate, 0, $amount), ' '));
	echo $truncate;
	echo "...";
	if ($quote_after) echo('');
} 

/* Creates read more link */
function read_more_func( $attr ) {

	$attr = shortcode_atts( array( 'text' => __( 'Read More', hybrid_get_parent_textdomain() ) ), $attr );

	return "<a class='more-link' href=" . get_permalink() . ">{$attr['text']}</a>";
}

/* Scripts */
function swt_scripts() {

	global $options;
	
	if ( !is_singular() && $options['swt_slider'] == 'Display' ) {
		wp_enqueue_script( 'swt-flex', trailingslashit( get_template_directory_uri() ) . 'js/slider.js', array( 'jquery' ), '20121010', true );
		add_filter( 'body_class', 'slider_class' );
	}

}

function slider_class( $classes ) {
	
	$classes[] = 'has-slider';
	
	return $classes;
}

?>