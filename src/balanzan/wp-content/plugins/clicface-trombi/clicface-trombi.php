<?php
/*
Plugin Name: Clicface Trombi
Plugin URI: http://www.clicface.com/
Description: A great plugin for WordPress that creates a directory of all your employees.
Version: 1.13
Author: Clicface
Author URI: http://www.clicface.com/
Plugin Type: Piklist
License: GPL2
*/

require_once( plugin_dir_path(__FILE__) . 'includes/class-collaborateur.php' );

add_action('init', 'clicface_trombi_init');
function clicface_trombi_init(){
	load_plugin_textdomain('clicface-trombi', false, dirname( plugin_basename( __FILE__ ) ) . '/i18n/');
	wp_register_style( 'clicface-trombi-style', plugins_url('clicface-trombi/css/clicface-trombi.css') );
}

add_action('admin_init', 'clicface_trombi_init_function', -1);
function clicface_trombi_init_function() {
	include_once('includes/class-piklist-checker.php');
	if (!piklist_checker::check(__FILE__)) {
		return;
	}
}

add_filter('piklist_admin_pages', 'piklist_collaborateur_admin_pages');
function piklist_collaborateur_admin_pages($pages) {
	$pages[] = array(
		'page_title' => __('Clicface Trombi Settings', 'clicface-trombi')
		,'menu_title' => 'Clicface Trombi'
		,'capability' => 'manage_options'
		,'menu_slug' => 'clicface_trombi_settings_menu'
		,'setting' => 'clicface_trombi_settings'
		,'icon' => 'options-general'
		,'single_line' => false
		,'default_tab' => __('General', 'clicface-trombi')
	);

	return $pages;
}

add_filter('piklist_post_types', 'piklist_collaborateur_post_types');
function piklist_collaborateur_post_types($post_types) {
	$clicface_trombi_settings = get_option('clicface_trombi_settings');
	if ( !isset( $clicface_trombi_settings['trombi_title_name_singular'] ) ) $clicface_trombi_settings['trombi_title_name_singular'] = __('Employee', 'clicface-trombi');
	if ( !isset( $clicface_trombi_settings['trombi_title_name_plural'] ) ) $clicface_trombi_settings['trombi_title_name_plural'] = __('Employees', 'clicface-trombi');
	$label_name_plural = ($clicface_trombi_settings['trombi_title_name_plural']) ? $clicface_trombi_settings['trombi_title_name_plural'] : __('Employees', 'clicface-trombi');
	$label_name_singular = ($clicface_trombi_settings['trombi_title_name_singular']) ? $clicface_trombi_settings['trombi_title_name_singular'] : __('Employee', 'clicface-trombi');
	$post_types['collaborateur'] = array(
			'labels' => array(
				'name' => ucwords($label_name_plural)
				,'singular_name' => ucwords($label_name_singular)
				,'add_new' => sprintf(__('Add New %s', 'clicface-trombi'), ucwords($label_name_singular))
			)
			,'public' => true
			,'rewrite' => array(
				'slug' => 'collaborateur'
			)
			,'capability_type' => 'post'
			,'edit_columns' => array(
				'title' => ucwords($label_name_singular)
				,'author' => __('Author', 'clicface-trombi')
			)
			,'hide_meta_box' => array(
				'slug'
				,'author'
				,'piklist_collaborateur_type'
			)
	);
	return $post_types;
}

add_filter('piklist_taxonomies', 'piklist_collaborateur_services');
function piklist_collaborateur_services($taxonomies) {
	$taxonomies[] = array(
		'post_type' => 'collaborateur'
		,'name' => 'collaborateur_service'
		,'show_admin_column' => false
		,'hide_meta_box' => true
		,'configuration' => array(
			'hierarchical' => false
			,'labels' => array(
				'name' => __('Divisions', 'clicface-trombi')
				,'singular_name' => __('Division', 'clicface-trombi')
				,'add_new' => __('Add New Division', 'clicface-trombi')
			)
			,'show_ui' => true
			,'query_var' => true
			,'rewrite' => array(
				'slug' => 'collaborateur-service'
			)
		)
	);
	return $taxonomies;
}

add_filter('piklist_taxonomies', 'piklist_collaborateur_worksites');
function piklist_collaborateur_worksites($taxonomies) {
	$taxonomies[] = array(
		'post_type' => 'collaborateur'
		,'name' => 'collaborateur_worksite'
		,'show_admin_column' => false
		,'hide_meta_box' => true
		,'configuration' => array(
			'hierarchical' => false
			,'labels' => array(
				'name' => __('Worksites', 'clicface-trombi')
				,'singular_name' => __('Worksite', 'clicface-trombi')
				,'add_new' => __('Add New Worksite', 'clicface-trombi')
			)
			,'show_ui' => true
			,'query_var' => true
			,'rewrite' => array(
				'slug' => 'collaborateur-worksite'
			)
		)
	);
	return $taxonomies;
}

add_action('new_to_publish', 'trombi_check_num_collab');
add_action('auto-draft_to_publish', 'trombi_check_num_collab');
add_action('draft_to_publish', 'trombi_check_num_collab');
add_action('pending_to_publish', 'trombi_check_num_collab');
function trombi_check_num_collab( $post ) {
	if ($post->post_type == 'collaborateur') {
		if ( wp_count_posts('collaborateur')->publish > strlen('-clicface-') ) {
			wp_delete_post( $post->ID, true );
			wp_die( __('You can\'t create any more record, you have already reached the limit. You have to update your Clicface Trombi plugin version to add more records.', 'clicface-trombi') . '<br /><center><a href="http://www.clicface.com/" target="_blank">http://www.clicface.com/</a></center>' );
		}
	}
}

add_action ('save_post', 'titlize_collaborateur');
function titlize_collaborateur( $post_id ) {
	$type = get_post_type( $post_id );
	if ($type == 'collaborateur') {
		$update_post['ID'] = $post_id;
		
		// On sauvegarde une première fois
		remove_action('save_post', 'titlize_collaborateur'); // unhook this function so it doesn't loop infinitely
		wp_update_post( $update_post );
		
		// On met à jour le titre, et on sauvegarde à nouveau
		$update_post['post_title'] = get_post_meta($post_id, 'prenom', true) . ' ' . get_post_meta($post_id, 'nom', true);
		wp_update_post( $update_post );
		
		add_action ('save_post', 'titlize_collaborateur'); // re-hook this function
	} else {
		return true;
	}
}

add_filter( 'template_include', 'wpse_57232_render_cpt', 100 );
function wpse_57232_render_cpt( $template ) {
	// Our custom post type.
	$post_type = 'collaborateur';

	// WordPress has already found the correct template in the theme.
	if ( FALSE !== strpos( $template, "/single-$post_type.php" ) ) {
		return $template;
	}

	// Send our plugin file.
	if ( is_singular() && $post_type === get_post_type( $GLOBALS['post'] ) ) {
		return dirname( __FILE__ ) . "/templates/single-$post_type.php";
	}

	// Not our post type single view.
	return $template;
}

add_shortcode( 'clicface-trombi', 'trombi_display_views' );
function trombi_display_views() {
	$clicface_trombi_settings = get_option('clicface_trombi_settings');
	wp_enqueue_style('clicface-trombi-style');
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-dialog');
	$output = '';
	
	if ( !isset( $clicface_trombi_settings['vignette_color_border'] ) ) $clicface_trombi_settings['vignette_color_border'] = '#B5D9EA';
	if ( !isset( $clicface_trombi_settings['vignette_color_background_top'] ) ) $clicface_trombi_settings['vignette_color_background_top'] = '#EDF7FF';
	if ( !isset( $clicface_trombi_settings['vignette_color_background_bottom'] ) ) $clicface_trombi_settings['vignette_color_background_bottom'] = '#CDE7EE';
	if ( !isset( $clicface_trombi_settings['trombi_affichage_type'] ) ) $clicface_trombi_settings['trombi_affichage_type'] = 'grid';
	if ( !isset( $clicface_trombi_settings['trombi_display_service'] ) ) $clicface_trombi_settings['trombi_display_service'] = 'oui';
	if ( !isset( $clicface_trombi_settings['trombi_display_phone'] ) ) $clicface_trombi_settings['trombi_display_phone'] = 'non';
	if ( !isset( $clicface_trombi_settings['trombi_display_cellular'] ) ) $clicface_trombi_settings['trombi_display_cellular'] = 'non';
	if ( !isset( $clicface_trombi_settings['trombi_display_email'] ) ) $clicface_trombi_settings['trombi_display_email'] = 'non';
	if ( !isset( $clicface_trombi_settings['trombi_collaborateurs_par_ligne'] ) ) $clicface_trombi_settings['trombi_collaborateurs_par_ligne'] = 3;
	if ( !isset( $clicface_trombi_settings['vignette_width'] ) ) $clicface_trombi_settings['vignette_width'] = 250;
	if ( !isset( $clicface_trombi_settings['trombi_target_window'] ) ) $clicface_trombi_settings['trombi_target_window'] = '_blank';
	if ( !isset( $clicface_trombi_settings['trombi_profile_width'] ) ) $clicface_trombi_settings['trombi_profile_width'] = 720;
	if ( !isset( $clicface_trombi_settings['trombi_profile_height'] ) ) $clicface_trombi_settings['trombi_profile_height'] = 440;
	if ( !isset( $clicface_trombi_settings['trombi_display_worksite'] ) ) $clicface_trombi_settings['trombi_display_worksite'] = 'non';
	if ( !isset( $clicface_trombi_settings['trombi_display_return_link'] ) ) $clicface_trombi_settings['trombi_display_return_link'] = 'non';
	if ( !isset( $clicface_trombi_settings['trombi_move_to_anchor'] ) ) $clicface_trombi_settings['trombi_move_to_anchor'] = 'non';
	if ( !isset( $clicface_trombi_settings['trombi_thickbox_width'] ) ) $clicface_trombi_settings['trombi_thickbox_width'] = 800;
	if ( !isset( $clicface_trombi_settings['trombi_thickbox_height'] ) ) $clicface_trombi_settings['trombi_thickbox_height'] = 670;
	if ( !isset( $clicface_trombi_settings['trombi_title_name_singular'] ) ) $clicface_trombi_settings['trombi_title_name_singular'] = __('Employee', 'clicface-trombi');
	if ( !isset( $clicface_trombi_settings['trombi_title_name_plural'] ) ) $clicface_trombi_settings['trombi_title_name_plural'] = __('Employees', 'clicface-trombi');
	
	// query
	$args = array(
			'post_type' => 'collaborateur',
			'posts_per_page' => -1,
			'meta_key' => 'nom',
			'orderby' => 'meta_value',
			'order' => 'ASC',
		);
	$the_query = new WP_Query($args);
	
	switch($clicface_trombi_settings['trombi_target_window']) {
		case 'thickbox':
			$ExtraLink = '?TB_iframe=true&width=' . $clicface_trombi_settings['trombi_thickbox_width'] . '&height=' . $clicface_trombi_settings['trombi_thickbox_height'];
			$WindowTarget = '_self';
			$ExtraClassImg = 'class="thickbox"';
			$ExtraClassTxt = 'thickbox';
			add_thickbox();
		break;
		
		case '_self':
			$ExtraLink = ($clicface_trombi_settings['trombi_move_to_anchor'] == 'oui') ? '#ClicfaceTrombi' : '';
			$WindowTarget = '_self';
			$ExtraClassImg = '';
			$ExtraClassTxt = '';
		break;
		
		default: // _blank
			$ExtraLink = ($clicface_trombi_settings['trombi_move_to_anchor'] == 'oui') ? '#ClicfaceTrombi' : '';
			$WindowTarget = '_blank';
			$ExtraClassImg = '';
			$ExtraClassTxt = '';
		break;
	}
	
	switch($clicface_trombi_settings['trombi_affichage_type']) {
		case 'list':
			$output .= '<table class="clicface-trombi-table">';
			$output .= '<tr><td colspan="2" style="border: none;"><hr></td></tr>';
			while ( $the_query->have_posts() ) : $the_query->the_post();
				$collaborateur = new clicface_Collaborateur( get_the_ID() );
				$output .= '<tr><td style="border: none;">';
				$output .= '<a class="clicface-trombi-collaborateur ' . $ExtraClassTxt .'" href="'. $collaborateur->Link . $ExtraLink .'" target="'. $WindowTarget .'" ' . $ExtraClassImg . '><div>';
				$output .= '<div class="clicface-trombi-person-name">' . $collaborateur->Nom . '</div>';
				$output .= '<div class="clicface-trombi-person-function">' . $collaborateur->Fonction . '</div>';
				if ( $clicface_trombi_settings['trombi_display_service'] == 'oui' ) {
					$output .= '<br /><u>' . __('Division:', 'clicface-trombi') . '</u><br /><div class="clicface-trombi-person-service">' . $collaborateur->Service . '</div>';
				}
				if ( $clicface_trombi_settings['trombi_display_phone'] == 'oui' && $collaborateur->TelephoneFixe != NULL ) {
					$output .= '<br />' . __('Phone:', 'clicface-trombi') . ' ' . $collaborateur->TelephoneFixe;
				}
				if ( $clicface_trombi_settings['trombi_display_cellular'] == 'oui' && $collaborateur->TelephonePortable != NULL ) {
					$output .= '<br />' . __('Cell:', 'clicface-trombi') . ' ' . $collaborateur->TelephonePortable;
				}
				if ( $clicface_trombi_settings['trombi_display_email'] == 'oui' && $collaborateur->Mail != NULL ) {
					$output .= '<br />' . $collaborateur->Mailto;
				}
				$output .= '</div></a>';
				$output .= '</td><td style="border: none;">';
				$output .= '<div class="piklist-label-container"><a href="' . $collaborateur->Link . $ExtraLink .'" target="'. $WindowTarget .'" ' . $ExtraClassImg . '>' . $collaborateur->PhotoThumbnail . '</a></div>';
				$output .= '</td></tr>';
				$output .= '<tr><td colspan="2" style="border: none;"><hr></td></tr>';
			endwhile;
			$output .= '</table>';
		break;
		
		default: //grid
			$i = 1;
			$output .= '<style type="text/css">.clicface-trombi-cellule {width: ' . $clicface_trombi_settings['vignette_width'] . 'px; background-color: ' . $clicface_trombi_settings['vignette_color_background_top'] . '; background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(' . $clicface_trombi_settings['vignette_color_background_top'] . '), to(' . $clicface_trombi_settings['vignette_color_background_bottom'] . ')); border: 2px solid ' . $clicface_trombi_settings['vignette_color_border'] . ';}</style>';
			$output .= '<table class="clicface-trombi-table">';
			$output .= '<tr>';
			while ( $the_query->have_posts() ) : $the_query->the_post();
				$collaborateur = new clicface_Collaborateur( get_the_ID() );
				$output .= '<td class="clicface-trombi-cellule"><div class="clicface-trombi-vignette">';
				$output .= '<div class="piklist-label-container"><a href="' . $collaborateur->Link . $ExtraLink . '" target="'. $WindowTarget .'" ' . $ExtraClassImg . '>' . $collaborateur->PhotoThumbnail . '</a></div>';
				$output .= '<a class="clicface-trombi-collaborateur ' . $ExtraClassTxt . '" href="' . $collaborateur->Link . $ExtraLink . '" target="'. $WindowTarget .'" ' . $ExtraClassImg . '><div>';
				$output .= '<div class="clicface-trombi-person-name">' . $collaborateur->Nom . '</div>';
				$output .= '<div class="clicface-trombi-person-function">' . $collaborateur->Fonction . '</div>';
				if ( $clicface_trombi_settings['trombi_display_service'] == 'oui' ) {
					$output .= '<div class="clicface-trombi-person-service">' . $collaborateur->Service . '</div>';
				}
				if ( $clicface_trombi_settings['trombi_display_phone'] == 'oui' && $collaborateur->TelephoneFixe != NULL ) {
					$output .= '<br />' . __('Phone:', 'clicface-trombi') . ' ' . $collaborateur->TelephoneFixe;
				}
				if ( $clicface_trombi_settings['trombi_display_cellular'] == 'oui' && $collaborateur->TelephonePortable != NULL ) {
					$output .= '<br />' . __('Cell:', 'clicface-trombi') . ' ' . $collaborateur->TelephonePortable;
				}
				if ( $clicface_trombi_settings['trombi_display_email'] == 'oui' && $collaborateur->Mail != NULL ) {
					$output .= '<br />' . $collaborateur->Mailto;
				}
				$output .= '</div></a>';
				$output .= '</div></td>';
				if ( $i % $clicface_trombi_settings['trombi_collaborateurs_par_ligne'] == 0) {
					$output .= '</tr><tr>';
				}
				$i++;
			endwhile;
			$output .= '</table>';
		break;
	}
	wp_reset_postdata();
	return $output;
}

add_action( 'admin_menu' , 'remove_fonction_meta' );
function remove_fonction_meta() {
	remove_meta_box( 'tagsdiv-collaborateur_fonction', 'collaborateur', 'side' );
}

add_action( 'admin_menu' , 'remove_service_meta' );
function remove_service_meta() {
	remove_meta_box( 'tagsdiv-collaborateur_service', 'collaborateur', 'side' );
}

add_action( 'admin_menu' , 'remove_worksite_meta' );
function remove_worksite_meta() {
	remove_meta_box( 'tagsdiv-collaborateur_worksite', 'collaborateur', 'side' );
}