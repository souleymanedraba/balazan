<?php
/*

Copyright (C) 2009-2013 AVChat Software, avchat.net

This WordPress Plugin is distributed under the terms of the GNU General Public License.
You can redistribute it and/or modify it under the terms of the GNU General Public License 
as published by the Free Software Foundation, either version 3 of the License, or any later version.

You should have received a copy of the GNU General Public License
along with this plugin.  If not, see <http://www.gnu.org/licenses/>.
*/

	global $wp_roles;
	global $wpdb;
	
	$table_permissions = $wpdb->prefix . "avchat3_permissions";
    $table_general_settings = $wpdb->prefix . "avchat3_general_settings";
	
	$permissions = array(
					'can_access_chat' => 'Can access chat',
					'can_access_admin_chat' => 'Can access admin chat',
					'can_publish_audio_video' =>  'Can publish audio & video stream',
					'can_stream_private' => 'Can stream private (<a href="http://avchat.net/integrations/wordpress" target="_blank">PRO</a>)',
					'can_send_files_to_rooms' => 'Can send files to rooms (<a href="http://avchat.net/integrations/wordpress" target="_blank">PRO</a>)',
					'can_send_files_to_users' => 'Can send files to users (<a href="http://avchat.net/integrations/wordpress" target="_blank">PRO</a>)',
					'can_pm' => 'Can send private messages',
					'can_create_rooms' => 'Can create rooms',
					'can_watch_other_people_streams' => 'Can watch other people streams (<a href="http://avchat.net/integrations/wordpress" target="_blank">PRO</a>)',
					'can_join_other_rooms' => 'Can join other rooms (<a href="http://avchat.net/integrations/wordpress" target="_blank">PRO</a>)',
					'show_users_online_stay' => 'Show users how much they stayed online (<a href="http://avchat.net/integrations/wordpress" target="_blank">PRO</a>)',
					'view_who_is_watching_me' => 'Ability for the users to see who is watching them (<a href="http://avchat.net/integrations/wordpress" target="_blank">PRO</a>)',
					'can_block_other_users' => 'Can block other users (<a href="http://avchat.net/integrations/wordpress" target="_blank">PRO</a>)',
					'can_buzz' => 'Can buzz (<a href="http://avchat.net/integrations/wordpress" target="_blank">PRO</a>)',
					'can_stop_viewer' => 'Can stop viewer (<a href="http://avchat.net/integrations/wordpress" target="_blank">PRO</a>)',
					'can_ignore_pm' => 'Can ignore private messages (<a href="http://avchat.net/integrations/wordpress" target="_blank">PRO</a>)',
					'typing_enabled' => 'Typing enabled (<a href="http://avchat.net/integrations/wordpress" target="_blank">PRO</a>)'
	);
	
	$settings = array(
					'free_video_time' => 'Free video time (<a href="http://avchat.net/integrations/wordpress" target="_blank">PRO</a>)',
					'drop_in_room' => 'Drop in room (<a href="http://avchat.net/integrations/wordpress" target="_blank">PRO</a>)',
					'max_streams' => 'Max streams a user can watch',
					'max_rooms' => 'Max rooms one can be in',
					'username_prefix' => 'Username prefix (<a href="http://avchat.net/integrations/wordpress" target="_blank">PRO</a>)',
	);
	
	$general_settings = array(
					'connection_string' => 'Connection string*',
					'invite_link' => 'Invite URL (<a href="http://avchat.net/integrations/wordpress" target="_blank">PRO</a>)',
					'disconnect_link' => 'Disconnect button URL (<a href="http://avchat.net/integrations/wordpress" target="_blank">PRO</a>)',
					'login_page_url' => 'Login page URL',
					'register_page_url' => 'Register page URL' ,
					'text_char_limit' => 'Text chat character limit (<a href="http://avchat.net/integrations/wordpress" target="_blank">PRO</a>)',
					'history_lenght' => 'History length (<a href="http://avchat.net/integrations/wordpress" target="_blank">PRO</a>)',
					'flip_tab_menu' => 'Position of rooms tabbed menu (<a href="http://avchat.net/integrations/wordpress" target="_blank">PRO</a>)',
					'hide_left_side' => 'Hide left side of chat (<a href="http://avchat.net/integrations/wordpress" target="_blank">PRO</a>)',
					'p2t_default' => 'Push 2 talk used by default (<a href="http://avchat.net/integrations/wordpress" target="_blank">PRO</a>)',
					'display_mode' => 'Where the chat is embedded (<a href="http://avchat.net/integrations/wordpress" target="_blank">PRO</a>)',
					'allow_facebook_login' => 'Allow Facebook login (<a href="http://avchat.net/integrations/wordpress" target="_blank">PRO</a>)',
					'FB_appId' => 'Facebook application ID*',
	);
    
	
	if(isset($_POST) && !empty($_POST)){
		foreach ($_POST as $key=>$avconfs){
			if (strpos($key, "-")){
				$avconf_arrtemp = explode("-", $key);
				if($avconfs == 'on')$avconfs = '1';
				$avconf_arr[$avconf_arrtemp[0]][substr($avconf_arrtemp[1],4)] = $avconfs;
			}else{
				$av_general_confs[substr($key,11)] = $avconfs;
			}
		}
		
		
		
		foreach ($avconf_arr as $key=>$vals){
			$updateString = "";
			foreach($permissions as $pkey => $pvalue){
				if($vals[$pkey] == ""){
					$vals[$pkey] = 0;
				}
				$updateString.= $pkey." = '".$vals[$pkey]."', ";
			}
			
			$i=1;
			foreach($settings as $skey=>$svalue){
				$updateString.= $skey." = '".stripslashes(trim($vals[$skey]))."'";
				if(count($settings) != $i) $updateString.= ', ';
				$i++;
			}
			
			
			$query = "UPDATE ".$table_permissions." SET ".$updateString." WHERE user_role = '".$key."'";
			$wpdb->query($query);
		}
		
		$updateString="";
		$p=1;
		foreach($av_general_confs as $gkey=>$gvalue){
			$updateString.= $gkey." = '".stripslashes(trim($gvalue))."'";
			if(count($av_general_confs) != $p) $updateString.= ', ';
			$p++;
		}
		
		$query = "UPDATE ".$table_general_settings." SET ".$updateString;
		//var_dump($query);
		$wpdb->query($query);
	}
	
	
	$location = get_option('siteurl') . '/wp-admin/admin.php?page=avchat-3/avchat3-settings.php'; 
	$user_roles = array();
	
	foreach($wp_roles->roles as $role => $details){
		$user_roles[$role] = $details["name"];
	}
	
	//unset($user_roles['administrator']);
	
	$user_roles['visitors'] = "Visitors";
	
	
	//var_dump($user_roles);
	
?>

<div class="wrap">
	<h2>AVChat 3 Settings & Permissions</h2>
</div>
<form name="form1" method="post" action="<?php echo $location; ?>">
	<table style="text-align:center">
		
		<tr>
			<th></th>
			<?php foreach($user_roles as $role => $name){?>
				<th style="padding:0 10px !important"><?php echo $name;?></th>
			<?php } ?>
		</tr>
		
		<tr><td colspan="5" style="text-align:left"><h3>Permissions</h3></td>
		<?php foreach($permissions as $key=>$value){ ?>
			
		<tr>
			<td style="text-align:left"><?php echo $value;?></td>
			<?php 
				foreach ($user_roles as $user_role => $name){
					$user_permissions = $wpdb->get_results( "SELECT can_access_chat, can_access_admin_chat, can_publish_audio_video, can_stream_private, can_send_files_to_rooms, can_send_files_to_users, can_pm, can_create_rooms, can_watch_other_people_streams, can_join_other_rooms, show_users_online_stay, view_who_is_watching_me, can_block_other_users, can_buzz, can_stop_viewer, can_ignore_pm, typing_enabled FROM ".$wpdb->prefix . "avchat3_permissions WHERE user_role = '".$user_role."'" );
			?>
				<td style="padding:0 10px !important">
					<input type="checkbox" 
					<?php 
						if($user_permissions[0]->$key){ echo 'checked="checked"';}
						if(
							$key == "can_stream_private" ||
							$key == "can_send_files_to_rooms" ||
							$key == "can_send_files_to_users" ||
							$key == "can_watch_other_people_streams" ||
							$key == "can_join_other_rooms" ||
							$key == "show_users_online_stay" ||
							$key == "view_who_is_watching_me" ||
							$key == "can_block_other_users" ||
							$key == "can_buzz" ||
							$key == "can_stop_viewer" ||
							$key == "can_ignore_pm" ||
							$key == "typing_enabled"
							
							) { echo 'disabled="disabled"';}
					?> 
					name="<?php echo strtolower($user_role);?>-avp_<?php echo $key;?>" />
					<?php 
						if( $key == "can_stream_private" ||
							$key == "can_send_files_to_rooms" ||
							$key == "can_send_files_to_users" ||
							$key == "can_watch_other_people_streams" ||
							$key == "can_join_other_rooms" ||
							$key == "show_users_online_stay" ||
							$key == "view_who_is_watching_me" ||
							$key == "can_block_other_users" ||
							$key == "can_buzz" ||
							$key == "can_stop_viewer" ||
							$key == "can_ignore_pm" ||
							$key == "typing_enabled"
							){?>
							<input type="hidden" name="<?php echo strtolower($user_role);?>-avp_<?php echo $key;?>" value="<?php
									if($user_permissions[0]->$key){ 
										  echo '1';}
									else{ echo '0';}?>" /><?php
							}
					?>		
					
					</td>
			<?php }?>
		</tr>
		<?php }?>
		
		<tr><td colspan="5" style="text-align:left"><h3>Settings</h3></td>
		<?php foreach($settings as $key=>$value){?>
		<tr>
			<td style="text-align:left"><?php echo $value;?></td>
			<?php 
				foreach ($user_roles as $user_role => $name){
					$user_settings = $wpdb->get_results( "SELECT free_video_time, drop_in_room, max_streams, max_rooms, username_prefix FROM ".$wpdb->prefix . "avchat3_permissions WHERE user_role = '".$user_role."'" );
			?>
				<td style="padding:0 10px !important"><input type="text" 
					<?php 
						if($key == "free_video_time" || 
							$key == "drop_in_room" || 
							$key == "username_prefix" ) { echo 'readonly="true"';}
					?> 
				name="<?php echo strtolower($user_role);?>-avs_<?php echo $key;?>" value="<?php echo $user_settings[0]->$key;?>" /></td>
			<?php }?>
		</tr>
		<?php }?>
		
		<tr><td colspan="5" style="text-align:left"><h3>General settings</h3></td>
		<?php 
			foreach($general_settings as $key=>$value){
				$av_general_settings = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix . "avchat3_general_settings" );	
		?>
		<tr>
			<td style="text-align:left"><?php echo $value;?></td>
			<td style="padding:0 10px !important;text-align:left;" colspan="4">
				<?php 
				switch ($key) {
					case 'display_mode':
					?>
						<select name="avgsetting_<?php echo $key?>"  disabled="disabled">
							<option <?php if ($av_general_settings[0]->$key == 'popup') {echo 'selected="selected"';}?> value="popup">Popup</option>
							<option <?php if ($av_general_settings[0]->$key == 'embed') {echo 'selected="selected"';}?> value="embed">Embed</option>
						</select>
					<?php
						break;
					case ($key == 'allow_facebook_login' || $key == 'hide_left_side' || $key == 'p2t_default'):
					?>
						<select name="avgsetting_<?php echo $key?>"  disabled="disabled">
							<option <?php if ($av_general_settings[0]->$key == 'yes') {echo 'selected="selected"';}?> value="yes">Yes</option>
							<option <?php if ($av_general_settings[0]->$key == 'no') {echo 'selected="selected"';}?> value="no">No</option>
						</select> 
					<?php
						break;
					case 'flip_tab_menu':
					?>
						<select name="avgsetting_<?php echo $key?>"  disabled="disabled">
							<option <?php if ($av_general_settings[0]->$key == 'top') {echo 'selected="selected"';}?> value="top">Top</option>
							<option <?php if ($av_general_settings[0]->$key == 'bottom') {echo 'selected="selected"';}?> value="bottom">Bottom</option>
						</select> 
					<?php
						break;
						case ($key == 'history_lenght' || $key == 'text_char_limit' || $key == 'invite_link' || $key == 'disconnect_link'):
					?>
						<input size="50" type="text" name="avgsetting_<?php echo $key;?>" readonly="true" value="<?php echo $av_general_settings[0]->$key; ?>" />
					<?php
						break;
					default :
					?>
						<input size="50" type="text" name="avgsetting_<?php echo $key;?>" value="<?php echo $av_general_settings[0]->$key; ?>" />
				<?php }?>
			</td>
		</tr>
		<?php } ?>
	</table>
	<p class="submit"><input type="submit" value="Update Options" class="button-primary" /></p>
</form>