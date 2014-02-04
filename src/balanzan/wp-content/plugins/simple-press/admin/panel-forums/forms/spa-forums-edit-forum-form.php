<?php
/*
Simple:Press
Admin Forums Edit Forum Form
$LastChangedDate: 2014-01-28 01:20:52 -0800 (Tue, 28 Jan 2014) $
$Rev: 11012 $
*/

if (preg_match('#'.basename(__FILE__).'#', $_SERVER['PHP_SELF'])) die('Access denied - you cannot directly call this file');

# function to display the edit form information form.  It is hidden until the edit forum link is clicked
function spa_forums_edit_forum_form($forum_id) {
?>
<script type="text/javascript">
jQuery(document).ready(function() {
	spjAjaxForm('sfforumedit<?php echo $forum_id; ?>', 'sfreloadfb');
});
</script>
<?php

	global $spPaths, $tab;

	$forum = spdb_table(SFFORUMS, "forum_id=$forum_id", 'row');

	spa_paint_options_init();

    $ahahURL = SFHOMEURL.'index.php?sp_ahah=forums-loader&amp;sfnonce='.wp_create_nonce('forum-ahah').'&amp;saveform=editforum';
?>
	<form action="<?php echo $ahahURL; ?>" method="post" id="sfforumedit<?php echo $forum->forum_id; ?>" name="sfforumedit<?php echo $forum->forum_id; ?>">
<?php
		echo sp_create_nonce('forum-adminform_forumedit');
		spa_paint_open_tab(spa_text('Forums').' - '.spa_text('Manage Groups and Forums'), true);
			spa_paint_open_panel();
				spa_paint_open_fieldset(spa_text('Forum Details'), false);

					$target='cforum_slug';
					$ahahURL = SFHOMEURL.'index.php?sp_ahah=forums&amp;sfnonce='.wp_create_nonce('forum-ahah');

					spa_paint_input(spa_text('Forum name'), 'forum_name', sp_filter_title_display($forum->forum_name), false, true);
					echo '<input type="hidden" name="forum_id" value="'.$forum->forum_id.'" />';

					echo "<div class='sp-form-row'>\n";
					echo "<div class='wp-core-ui sflabel sp-label-40'>".spa_text('Forum slug').":</div>";
					echo '<input type="text" class="wp-core-ui sp-input-60" tabindex="'.$tab.'" name="cforum_slug" id="cforum_slug" value="'.esc_attr($forum->forum_slug).'" onchange="spjSetForumSlug(this, \''.$ahahURL.'\', \''.$target.'\', \'edit\');" />';
					echo '<div class="clearboth"></div>';
					echo '</div>';
					$tab++;

					spa_paint_input(spa_text('Description'), 'forum_desc', sp_filter_text_edit($forum->forum_desc), false, true);

					spa_paint_checkbox(spa_text('Locked'), 'forum_status', $forum->forum_status);
					spa_paint_checkbox(spa_text('Disable forum RSS feed so feed will not be generated'), 'forum_private', $forum->forum_rss_private);

					spa_paint_select_start(spa_text('Custom forum icon'), 'forum_icon', '');
					spa_select_icon_dropdown('forum_icon', spa_text('Select Custom Icon'), SF_STORE_DIR.'/'.$spPaths['custom-icons'].'/', $forum->forum_icon, false);
					spa_paint_select_end();

					spa_paint_select_start(spa_text('Custom forum icon when new posts'), 'forum_icon_new', '');
					spa_select_icon_dropdown('forum_icon_new', spa_text('Select Custom Icon'), SF_STORE_DIR.'/'.$spPaths['custom-icons'].'/', $forum->forum_icon_new, false);
					spa_paint_select_end();

					spa_paint_select_start(spa_text('Custom topic icon'), 'topic_icon', '');
					spa_select_icon_dropdown('topic_icon', spa_text('Select Custom Icon'), SF_STORE_DIR.'/'.$spPaths['custom-icons'].'/', $forum->topic_icon, false);
					spa_paint_select_end();

					spa_paint_select_start(spa_text('Custom topic icon when new posts'), 'topic_icon_new', '');
					spa_select_icon_dropdown('topic_icon_new', spa_text('Select Custom Icon'), SF_STORE_DIR.'/'.$spPaths['custom-icons'].'/', $forum->topic_icon_new, false);
					spa_paint_select_end();

					spa_paint_input(spa_text('Replacement external RSS URL').'<br />'.spa_text('Default').': <strong>'.sp_build_url($forum->forum_slug, '', 0, 0, 0, 1).'</strong>', 'forum_rss', sp_filter_url_display($forum->forum_rss), false, true);

					spa_paint_input(spa_text('Custom meta keywords (SEO option must be enabled)'), 'forum_keywords', '', false, true);
					spa_paint_wide_textarea('Special forum message to be displayed above forums', 'forum_message', sp_filter_text_edit($forum->forum_message));

				spa_paint_close_fieldset();
			spa_paint_close_panel();

			spa_paint_open_panel();
				spa_paint_open_fieldset(spa_text('Extended Forum Options'), false);

					# As added by plugins
					do_action('sph_forum_edit_forum_options', $forum);

				spa_paint_close_fieldset();

			echo '<div class="sfoptionerror spaceabove">';
			echo sprintf(sp_text('To re-order your Groups, Forums and SubForums use the %s Order Groups and Forums %s option from the Forums Menu'), '<b>', '</b>');
			echo '</div>';

			spa_paint_close_panel();
		spa_paint_close_tab();
?>
		<div class="sfform-submit-bar">
		<input type="submit" class="button-primary" id="sfforumedit<?php echo $forum->forum_id; ?>" name="sfforumedit<?php echo $forum->forum_id; ?>" value="<?php spa_etext('Update Forum'); ?>" />
		<input type="button" class="button-primary" onclick="javascript:jQuery('#forum-<?php echo $forum->forum_id; ?>').html('');" id="sfforumedit<?php echo $forum->forum_id; ?>" name="editforumcancel<?php echo $forum->forum_id; ?>" value="<?php spa_etext('Cancel'); ?>" />
		</div>
	</form>

	<div class="sfform-panel-spacer"></div>
<?php
}
?>