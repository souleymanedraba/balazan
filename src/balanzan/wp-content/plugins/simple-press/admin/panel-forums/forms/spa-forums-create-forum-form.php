<?php
/*
Simple:Press
Admin Forums Create Forum Form
$LastChangedDate: 2014-01-27 05:52:07 -0800 (Mon, 27 Jan 2014) $
$Rev: 11008 $
*/

if (preg_match('#'.basename(__FILE__).'#', $_SERVER['PHP_SELF'])) die('Access denied - you cannot directly call this file');

# function to display the create new forum forum.  It is hidden until the create new forum link is clicked
function spa_forums_create_forum_form() {
?>
<script type="text/javascript">
jQuery(document).ready(function() {
	spjAjaxForm('sfforumnew', 'sfreloadfb');
});
</script>
<?php
	global $spPaths, $tab;

	spa_paint_options_init();

    $ahahURL = SFHOMEURL.'index.php?sp_ahah=forums-loader&amp;sfnonce='.wp_create_nonce('forum-ahah').'&amp;saveform=createforum';
?>
	<form action="<?php echo $ahahURL; ?>" method="post" id="sfforumnew" name="sfforumnew">
<?php
		echo sp_create_nonce('forum-adminform_forumnew');
		spa_paint_open_tab(spa_text('Forums').' - '.spa_text('Create New Forum'), true);
			spa_paint_open_panel();
				spa_paint_open_fieldset(spa_text('Create New Forum'), 'true', 'create-new-forum');

					# check there are groups before proceeding
					if (spdb_count(SFGROUPS) == 0) {
						echo '<br /><div class="sfoptionerror">';
						spa_etext('There are no groups defined');
						echo '<br />'.spa_text('Create new group');
						echo '</div><br />';
						spa_paint_close_fieldset();
						spa_paint_close_panel();
						spa_paint_close_tab();
						return;
					}

					# Select the forum type first
					echo "<div class='sp-form-row'>\n";
					echo "<div class='wp-core-ui sflabel sp-label-40'>".spa_text('What type of forum are you creating').":</div>\n";
					echo "<div class='wp-core-ui sp-radio'>";
					echo '<label for="sfradio1" class="wp-core-ui sp-label">'.spa_text('Standard Forum').'</label>'."\n";
					echo '<input type="radio" name="forumtype" id="sfradio1" tabindex="'.$tab.'" value="1" checked="checked" onchange="spjSetForumOptions(\'forum\');" />'."\n";
					$tab++;
					# check there are forums before offering subforum creation!
					if(spdb_count(SFFORUMS) != 0) {
						echo '<label for="sfradio2" class="wp-core-ui sp-label">'.spa_text('Sub or child forum').'</label>'."\n";
						echo '<input type="radio" name="forumtype" id="sfradio2" tabindex="'.$tab.'" value="2" onchange="spjSetForumOptions(\'subforum\');" />'."\n";
						$tab++;
					}
					echo '</div><div class="clearboth"></div></div>';

					# Now display the two select box options
					$ahahURL = SFHOMEURL.'index.php?sp_ahah=forums&amp;sfnonce='.wp_create_nonce('forum-ahah');
					$target = 'fseq';

					echo '<div id="groupselect" style="display:block;">';
					echo "<div class='sp-form-row'>\n";
					echo "<div class='wp-core-ui sflabel sp-label-40'>".spa_text('Select group new forum will belong to').":</div>\n";
					echo '<select class="wp-core-ui  sp-input-60" tabindex="'.$tab.'" name="group_id"  onchange="spjSetForumSequence();">';
					echo spa_create_group_select();
					echo "</select>\n";
					echo '<div class="clearboth"></div>';
					echo '</div>';
					$tab++;
					echo '</div>';

					echo '<div id="forumselect" style="display:none;">';
					echo "<div class='sp-form-row'>\n";
					echo "<div class='wp-core-ui sflabel sp-label-40'>".spa_text('Select forum new subforum will belong to').":</div>\n";
					echo '<select class="wp-core-ui  sp-input-60" tabindex="'.$tab.'" name="forum_id"  onchange="spjSetForumSequence();">';
					echo sp_render_group_forum_select(false, false, false, true);
					echo "</select>\n";
					echo '<div class="clearboth"></div>';
					echo '</div>';
					$tab++;
					echo '</div>';

				spa_paint_close_fieldset();
			spa_paint_close_panel();
		spa_paint_close_tab();

		echo '<div class="sfhidden" id="block1">';

		spa_paint_open_nohead_tab(false);
			spa_paint_open_panel();
				spa_paint_open_fieldset(spa_text('Forum Details'), false);

					$target='thisforumslug';
					$ahahURL = SFHOMEURL.'index.php?sp_ahah=forums&amp;sfnonce='.wp_create_nonce('forum-ahah');

					# forum name and slug
					echo "<div class='sp-form-row'>";
					echo "<div class='wp-core-ui sflabel sp-label-40'>".spa_text('Forum Name').":</div>";
					echo '<input type="text" class="wp-core-ui sp-input-60" tabindex="'.$tab.'" name="forum_name" value="" onchange="spjSetForumSlug(this, \''.$ahahURL.'\', \''.$target.'\', \'new\');" />';
					echo '<div class="clearboth"></div>';
					echo '</div>';
					$tab++;

					echo "<div class='sp-form-row'>\n";
					echo "<div class='wp-core-ui sflabel sp-label-40'>".spa_text('Forum slug').":</div>";
					echo '<input type="text" class="wp-core-ui sp-input-60" tabindex="'.$tab.'" name="thisforumslug" id="thisforumslug" value="" disabled="disabled" onchange="spjSetForumSlug(this, \''.$ahahURL.'\', \''.$target.'\', \'new\');" />';
					echo '<div class="clearboth"></div>';
					echo '</div>';
					$tab++;

					spa_paint_input(spa_text('Description'), 'forum_desc', '', false, true);

					spa_paint_checkbox(spa_text('Locked'), 'forum_status', 0);
					spa_paint_checkbox(spa_text('Disable forum RSS feed so feed will not be generated'), 'forum_private', 0);

					spa_paint_select_start(spa_text('Custom forum icon'), 'forum_icon', '');
					spa_select_icon_dropdown('forum_icon', spa_text('Select Custom Icon'), SF_STORE_DIR.'/'.$spPaths['custom-icons'].'/', '', false);
					spa_paint_select_end();

					spa_paint_select_start(spa_text('Custom forum icon when new posts'), 'forum_icon_new', '');
					spa_select_icon_dropdown('forum_icon_new', spa_text('Select Custom Icon'), SF_STORE_DIR.'/'.$spPaths['custom-icons'].'/', '', false);
					spa_paint_select_end();

					spa_paint_select_start(spa_text('Custom topic icon'), 'topic_icon', '');
					spa_select_icon_dropdown('topic_icon', spa_text('Select Custom Icon'), SF_STORE_DIR.'/'.$spPaths['custom-icons'].'/', '', false);
					spa_paint_select_end();

					spa_paint_select_start(spa_text('Custom topic icon when new posts'), 'topic_icon_new', '');
					spa_select_icon_dropdown('topic_icon_new', spa_text('Select Custom Icon'), SF_STORE_DIR.'/'.$spPaths['custom-icons'].'/', '', false);
					spa_paint_select_end();

					spa_paint_input(spa_text('Custom meta keywords (SEO option must be enabled)'), 'forum_keywords', '', false, true);
					spa_paint_wide_textarea('Special forum message to be displayed above forums', 'forum_message', '');

				spa_paint_close_fieldset();

			echo '<div class="sfoptionerror spaceabove">';
			echo sprintf(sp_text('To re-order your Groups, Forums and SubForums use the %s Order Groups and Forums %s option from the Forums Menu'), '<b>', '</b>');
			echo '</div>';

			spa_paint_close_panel();

		spa_paint_tab_right_cell();

			spa_paint_open_panel();
				spa_paint_open_fieldset(spa_text('Extended Forum Options'), false);

					# As added by plugins
					do_action('sph_forum_create_forum_options');

				spa_paint_close_fieldset();
			spa_paint_close_panel();

			spa_paint_open_panel();
				spa_paint_open_fieldset(spa_text('Add User Group Permissions'), false);

					echo '<div id="block2" class="sfhidden">';

					echo '<strong>'.spa_text('You can selectively set the permission sets for the forum below. If you want to use the default permissions for the selected group, then do not select anything').'</strong>';

					# Permissions
					$usergroups = spa_get_usergroups_all();
					$roles = sp_get_all_roles();

					foreach ($usergroups as $usergroup) {
						echo '<input type="hidden" name="usergroup_id[]" value="'.$usergroup->usergroup_id.'" />';
						spa_paint_select_start(sp_filter_title_display($usergroup->usergroup_name), 'role[]', '');
						echo '<option value="-1">'.spa_text('Select permission set').'</option>';
						foreach($roles as $role) {
							echo '<option value="'.$role->role_id.'">'.sp_filter_title_display($role->role_name).'</option>'."\n";
						}
						spa_paint_select_end();
					}

				spa_paint_close_fieldset();
			spa_paint_close_panel();
		spa_paint_close_tab();
?>
		<div class="sfform-submit-bar">
		<input type="submit" class="button-primary" id="saveit" name="saveit" value="<?php spa_etext('Create New Forum'); ?>" />
		</div>
	</form>

	<div class="sfform-panel-spacer"></div>
<?php
}
?>