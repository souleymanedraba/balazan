<?php
if(session_id() == ""){
		session_start();
	}
/**
 * @package AVChat Video Chat Plugin for WordPress
 * @author  AVChat Software
 * @version 1.4.2
 */
/*
Plugin Name: AVChat Video Chat Plugin for WordPress
Plugin URI: http://wordpress.org/extend/plugins/avchat-3/
Description: This plugin integrates <a href="http://avchat.net/" target="_blank">AVChat 3</a> into any WordPress website. When updating keep in mind that the AVChat 3 files will be removed.
Author: AVChat Software
Version: 1.4.2
Author URI: http://avchat.net/



Copyright (C) 2009-2013 AVChat Software, avchat.net

This WordPress Plugin is distributed under the terms of the GNU General Public License.
You can redistribute it and/or modify it under the terms of the GNU General Public License 
as published by the Free Software Foundation, either version 3 of the License, or any later version.

You should have received a copy of the GNU General Public License
along with this plugin.  If not, see <http://www.gnu.org/licenses/>.
*/

//this function is called when you press Activate
function avchat3_install(){
   global $wpdb;
   global $wp_roles;

   $table_name = $wpdb->prefix . "avchat3_permissions";
   $table2_name = $wpdb->prefix . "avchat3_general_settings";
   
   //we remove the tables if they exist
   $sql = "DROP TABLE  $table_name";
   $results = $wpdb->query( $sql );
   $sql = "DROP TABLE  $table2_name";
   $results = $wpdb->query( $sql );
   
    //keep in mind if the tables were present\
	$tables_were_present=true;
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name && $wpdb->get_var("SHOW TABLES LIKE '$table2_name'") != $table2_name) {
		$tables_were_present=false;
	}
	
	$sql = "CREATE TABLE " . $table_name . " (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  user_role varchar(50) DEFAULT '0' NOT NULL,
		  can_access_chat tinyint(1) NOT NULL,
		  can_access_admin_chat tinyint(1) NOT NULL,
		  can_publish_audio_video tinyint(1) NOT NULL,
		  can_stream_private tinyint(1) NOT NULL,
		  can_send_files_to_rooms tinyint(1) NOT NULL,
		  can_send_files_to_users tinyint(1) NOT NULL,
		  can_pm tinyint(1) NOT NULL,
		  can_create_rooms tinyint(1) NOT NULL,
		  can_watch_other_people_streams tinyint(1) NOT NULL,
		  can_join_other_rooms tinyint(1) NOT NULL,
		  show_users_online_stay tinyint(1) NOT NULL,
		  view_who_is_watching_me tinyint(1) NOT NULL,
		  can_block_other_users tinyint(1) NOT NULL,
		  can_buzz tinyint(1) NOT NULL,
		  can_stop_viewer tinyint(1) NOT NULL,
		  can_ignore_pm tinyint(1) NOT NULL,
		  typing_enabled tinyint(1) NOT NULL,
		  free_video_time mediumint(5) NOT NULL,
		  drop_in_room varchar(5) NOT NULL,
		  max_streams mediumint(2) NOT NULL,
		  max_rooms mediumint(2) NOT NULL,
		  username_prefix varchar(10) NOT NULL,
		  UNIQUE KEY id (id)
		);
			CREATE TABLE " . $table2_name . " (
			connection_string TEXT NOT NULL,
			invite_link TEXT NOT NULL,
			disconnect_link TEXT NOT NULL,
			login_page_url TEXT NOT NULL,
			register_page_url TEXT NOT NULL,
			text_char_limit mediumint(2) NOT NULL,
			history_lenght mediumint(3) NOT NULL,
			hide_left_side ENUM ('yes', 'no') NOT NULL,
			p2t_default ENUM ('yes', 'no') NOT NULL,
			flip_tab_menu ENUM ('top', 'bottom') NOT NULL,
			display_mode ENUM ('embed', 'popup') NOT NULL,
			allow_facebook_login ENUM ('yes', 'no') NOT NULL,
			FB_appId TEXT NOT NULL
			);
		";		
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
      	
	if (!$tables_were_present){
		foreach($wp_roles->roles as $role => $details){
			$user_roles[$role] = $details["name"];
		}
		
		//unset($user_roles['administrator']);
		
		//we add these 2 roles to the array so that default values are also inserted for them
		$user_roles['visitors'] = "Visitors";
		
		//Network users are users that have signed up on the main site of a Multisite enabled WP instalation, they have no role on the main site but are admin in their own websites (part of the WP Multisite network)
		//$user_roles['networkuser'] = "Network user";
		
		foreach($user_roles as $key=>$value){
			$canAccessAdmin=0;
			if ($key=="administrator"){
				$canAccessAdmin=1;
			}
			$insert = "INSERT INTO " . $table_name .
					  " (user_role, can_access_chat, can_access_admin_chat, can_publish_audio_video, can_stream_private, can_send_files_to_rooms, can_send_files_to_users, can_pm, can_create_rooms, can_watch_other_people_streams, can_join_other_rooms, show_users_online_stay, view_who_is_watching_me, can_block_other_users, can_buzz, can_stop_viewer, can_ignore_pm, typing_enabled, free_video_time, drop_in_room, max_streams, max_rooms) " .
					  "VALUES ('" . $key . "','$canAccessAdmin','0', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '3600', '', '4', '4')";
			 $results = $wpdb->query( $insert );
		}
		
		$insert = "INSERT INTO " . $table2_name .
					  " (connection_string, invite_link, disconnect_link, login_page_url, register_page_url, text_char_limit, history_lenght, hide_left_side, p2t_default, flip_tab_menu, display_mode, allow_facebook_login, FB_appId) " .
					  "VALUES ('rtmp://','','/','/', '/', '200', '20', 'no', 'yes', 'top', 'embed', 'yes', '')";
		$results = $wpdb->query( $insert );
	}	
}


function avchat3_get_user_details(){
	global $current_user;
	global $wpdb;
	global $blog_id;
	get_currentuserinfo();
	
	$user_roles = array();
	$user_info = array();
	
	if(function_exists(is_site_admin)){
		$avchat3_is_on_wpmu = true;
	}else{
		$avchat3_is_on_wpmu = false;
	}

	
	if($current_user->ID == null || $current_user->ID == ""){
		$user_info['user_id'] = '0';
	}else{
		
		/*
		if($avchat3_is_on_wpmu){
			$av3_current_blog_capabilities = 'wp_'.$blog_id.'_capabilities';
		}else{
			$av3_current_blog_capabilities = 'wp_capabilities';
		}
		*/
		
		$av3_current_blog_capabilities = $wpdb->prefix.'capabilities';
		
		$user_roles = array_keys($current_user->$av3_current_blog_capabilities);
		
		$user_info['user_id'] = $current_user->ID;
		$user_info['user_login'] = $current_user->user_login;
		$user_info['user_display_name'] = $current_user->display_name;
		$user_info['user_level_id'] = $current_user->user_level;
		$user_info['email'] = $current_user->user_email;
		$user_info['user_role'] = $user_roles[0];
		
		//if($user_info['user_role'] != "administrator"){
			$query = "SELECT * FROM ".$wpdb->prefix . "avchat3_permissions"." WHERE user_role = '".$user_info['user_role']."'";
			$user_permissions = $wpdb->get_results($query);
			
			unset($user_permissions[0]->id);
			unset($user_permissions[0]->user_role);
			
			foreach($user_permissions[0] as $key=>$value){
				$user_info[$key] = $value;
			}
		//}
	}
	
	return $user_info;
	
}

function get_avchat3_visitor_permissions(){
	global $wpdb;
	
	$query = "SELECT * FROM ".$wpdb->prefix . "avchat3_permissions"." WHERE user_role = 'visitors'";
	$user_permissions = $wpdb->get_results($query);
	
	unset($user_permissions[0]->id);
	unset($user_permissions[0]->user_role);
	
	foreach($user_permissions[0] as $key=>$value){
		$user_info[$key] = $value;
	}
	$user_info['user_role'] = 'visitor';
	
	return $user_info;
}

function get_avchat3_general_settings(){
	global $wpdb;
	
	$query = "SELECT * FROM ".$wpdb->prefix . "avchat3_general_settings";
	$general_settings = $wpdb->get_results($query);
	
	return $general_settings;
}

function get_avchat3_general_setting($general_av_setting){
	global $wpdb;
	
	$query = "SELECT ".$general_av_setting." FROM ".$wpdb->prefix . "avchat3_general_settings";
	$result = $wpdb->get_results($query);
	
	
	return $result[0];
}

function avchat3_set_avchat3_general_settings_on_session(){
	if(session_id() == ""){
		session_start();
	}
	
	$general_settings = get_avchat3_general_settings();
	
	foreach($general_settings[0] as $key=>$value){
		$_SESSION[$key] = $value;
	}
	
}

function avchat3_set_avchat3_buddy_details_on_session($buddy_details){
	if(session_id() == ""){
		session_start();
	}
	
	
	foreach($buddy_details as $key=>$value){
		$_SESSION[$key] = $value;
	}
}

function avchat3_set_user_details_on_session($user_info){
	if(session_id() == ""){
		session_start();
	}
	
	
	if($user_info['user_id'] == "0"){
		$user_info = get_avchat3_visitor_permissions();
	}else{
		$_SESSION['user_logged_in'] = true;
	}
	
	foreach($user_info as $key=>$val){
			$_SESSION[$key] = $val;
		}
}

function avchat3_clear_session(){
	session_destroy();
}


function avchat3_get_user_chat($content){
		$user_info = avchat3_get_user_details();
		avchat3_set_user_details_on_session($user_info);
		avchat3_set_avchat3_general_settings_on_session();
		
		
		
		if($user_info['can_access_admin_chat']){
			$movie_param = 'admin.swf';
			
		}else{
			$movie_param = 'index.swf';
		}
		
		//$_SESSION['raluca'] = 'administrator';
		
		$display_mode = get_avchat3_general_setting('display_mode')->display_mode;
		
		
		//Check if buddypress is installed
		if(in_array( 'buddypress/bp-loader.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )){
			
			
			//Get buddypress member avatar
			$buddy_details['avatar'] = bp_core_fetch_avatar( array( 'item_id' => $user_info['user_id'], 'type' => 'thumb', 'alt' => '', 'css_id' => '', 'class' => 'avatar', 'width' => '40', 'height' => '40', 'email' => $user_info['user_email'], 'html' => 'false') ) ;
			$buddy_details['is_buddy'] = 1;
			
			
			avchat3_set_avchat3_buddy_details_on_session($buddy_details);	
		}	
		
		if($_SESSION['FB_appId'] != "") {
			$FB_appId = $_SESSION['FB_appId'];
		}
		else {
			$FB_appId = "";
		}
		
		$role = $_SESSION['user_role'];
		if($_SESSION['can_access_chat'] != '1'){
				$embed = '<div id="av_message" style="color:#ff0000"> You do not have sufficient privileges to access this page. <a style="display:block;padding:5px 3px;width:200px;margin:5px 0;text-align:center;background:#f3f3f3;border:1px solid #ccc" href="wp-login.php" >Click to upgrade!</a></div>';	
		}else{
			if(!file_exists('./wp-content/plugins/avchat-3/swfobject.js')){
				//the AVChat 3 files have not been copied to the installation folder
				$embed = '<p>Before the chat can work, you need to copy the <b>AVChat 3</b> files to the <b>/wp-content/plugins/avchat-3/</b> folder.</p><p>To get <b>AVChat 3</b> you can request a 15 day trial from <a href="http://avchat.net">http://avchat.net</a> or you can purchase it from <a href="http://avchat.net/buy-now">http://avchat.net/buy-now</a>.</p>';
			}else{
				require_once(ABSPATH . 'wp-content/plugins/avchat-3/Mobile_Detect.php');
				$mobilecheck= new Mobile_Detect();
				if ($mobilecheck->isMobile() || $mobilecheck->isTablet()){
					$embed = '<a href="'.get_bloginfo('url').'/wp-content/plugins/avchat-3/m/m.php" style="background:#f0f0f0;display:block;padding:10px 20px;width:200px;text-align:center;border:1px solid #ccc">Enter mobile version</a>';
				}else{
					if($display_mode == 'embed'){
						$embed = '
						<div id="myContent"><div id="av_message" style="color:#ff0000">You need to have JavaScript enabled and <a target="_blank" href="http://get2.adobe.com/flashplayer/">the latest version of Flash Player</a> for the chat to work.</div></div>
						<input type="hidden" name="FB_appId" id="FB_appId" value="'.$FB_appId.'" />
						<script type="text/javascript" src="'.get_bloginfo('url').'/wp-content/plugins/avchat-3/tinycon.min.js"></script>
						<script type="text/javascript" src="'.get_bloginfo('url').'/wp-content/plugins/avchat-3/facebook_integration.js"></script>
						<script type="text/javascript" src="'.get_bloginfo('url').'/wp-content/plugins/avchat-3/swfobject.js"></script>
						<script type="text/javascript" src="'.get_bloginfo('url').'/wp-content/plugins/avchat-3/new_message.js"></script>
						<script type="text/javascript">
						var plugin_path = "'.get_bloginfo('url').'/wp-content/plugins/avchat-3/"; var embed = "'.$display_mode.'";
						</script>
						<script type="text/javascript">
							var flashvars = {
								lstext : "Loading Settings...",
								sscode : "php",
								userId : ""
							};
							var params = {
								quality : "high",
								bgcolor : "#272727",
								play : "true",
								loop : "false",
								allowFullScreen : "true",
								base : "'.get_bloginfo("url").'/wp-content/plugins/avchat-3/"
							};
							var attributes = {
								name : "index_embed",
								id :   "index_embed",
								align : "middle"
							};
						</script>
						<script type="text/javascript">
						swfobject.embedSWF("'.get_bloginfo('url').'/wp-content/plugins/avchat-3/'.$movie_param.'", "myContent", "100%", "600", "11.1.0", "", flashvars, params, attributes);
						</script>';
						$embed = $embed.'<script type="text/javascript" src="'.get_bloginfo('url').'/wp-content/plugins/avchat-3/find_player.js"></script>';
					}else{
						$chat_window_url = get_bloginfo('url').'/wp-content/plugins/avchat-3/index_popup.php?movie_param='.$movie_param."&FB_appId=".FB_appId;
						$chat_window_height = 600; 
						$chat_window_width = 800;
						$embed ='<a style="display:block;padding:5px 3px;width:200px;margin:5px 0;text-align:center;background:#f3f3f3;border:1px solid #ccc" href="#" onclick="javascript:window.open('.'&#39;'.$chat_window_url.'&#39;'.',\'_blank\',\'width='.$chat_window_width.',height='.$chat_window_height.'\')">Open chat in popup</a>';
					}
				}
			}
		}
		return str_replace('[chat]', $embed, $content);
}

function avchat3_admin_config(){
	add_options_page('AVChat 3 Permissions & Config', 'AVChat 3 Video Chat',  'manage_options', 'avchat-3/avchat3-settings.php');
}

register_activation_hook(__FILE__,'avchat3_install');
add_action('wp_logout', 'avchat3_clear_session');
add_action('admin_menu', 'avchat3_admin_config');
add_filter('the_content', 'avchat3_get_user_chat', 7);
?>