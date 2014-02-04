<?php
/*
Simple:Press
Admin User Groups Add Member Form
$LastChangedDate: 2013-12-04 05:25:27 -0800 (Wed, 04 Dec 2013) $
$Rev: 10906 $
*/

if (preg_match('#'.basename(__FILE__).'#', $_SERVER['PHP_SELF'])) die('Access denied - you cannot directly call this file');

function spa_usergroups_add_members_form($usergroup_id)
{
?>
<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('#sfmembernew<?php echo $usergroup_id; ?>').ajaxForm({
		target: '#sfmsgspot',
	});
});
</script>
<?php
	spa_paint_options_init();

    $ahahURL = SFHOMEURL."index.php?sp_ahah=usergroups-loader&amp;sfnonce=".wp_create_nonce('forum-ahah')."&amp;saveform=addmembers";

	$url = SFHOMEURL.'index.php?sp_ahah=memberships&amp;action=add&amp;sfnonce='.wp_create_nonce('forum-ahah');
	$target = 'sfmsgspot';
	$smessage = esc_js(spa_text('Please Wait - Processing'));
	$emessage = esc_js(spa_text('Users added'));

?>
	<form action="<?php echo $ahahURL; ?>" method="post" id="sfmembernew<?php echo $usergroup_id; ?>" name="sfmembernew<?php echo $usergroup_id ?>" onsubmit="spjAddDelMembers('sfmembernew<?php echo $usergroup_id ?>', '<?php echo($url); ?>', '<?php echo($target); ?>', '<?php echo($smessage); ?>', '<?php echo($emessage); ?>', 0, 50, '#amid<?php echo $usergroup_id; ?>');">
<?php
		echo sp_create_nonce('forum-adminform_membernew');

		$sfmemberopts = array();
		$sfmemberopts = sp_get_option('sfmemberopts');

		if(!isset($sfmemberopts['sfsinglemembership'])) {
			$singleGrp = false;
		} else {
			$singleGrp = $sfmemberopts['sfsinglemembership'];
		}
		$singleOpt = ($singleGrp) ? spa_text('On') : spa_text('Off');
		$singleMsg = ($singleGrp) ? spa_text('Any members moved will be deleted from current user group memberships') : spa_text('Any members moved will be retained in current user group memberships');

//		spa_paint_open_tab(spa_text('User Groups')." - ".spa_text('Manage User Groups'), true);
//			spa_paint_open_panel();
//				spa_paint_open_fieldset(spa_text('Add Members'), 'true', 'add-members');
?>
					<input type="hidden" name="usergroup_id" value="<?php echo $usergroup_id; ?>" />
					<p><?php spa_etext("Select members to add (use CONTROL for multiple members)") ?></p>
					<p><br /><?php spa_etext("The Option");?> <b><?php spa_etext("Users are limited to single usergroup membership");?></b> <?php echo sprintf(spa_text("is turned %s"), $singleOpt); ?></b><br /><?php echo($singleMsg); ?></p>
<?php
                	$from = esc_js(spa_text('Eligible Members'));
                	$to = esc_js(spa_text('Selected Members'));
                    $action = 'addug';
                	include_once(SF_PLUGIN_DIR.'/admin/library/ahah/spa-ahah-multiselect.php');
?>
					<div class="clearboth"></div>
<?php
//				spa_paint_close_fieldset();
//			spa_paint_close_panel();
			do_action('sph_usergroup_add_member_panel');
//		spa_paint_close_tab();
?>
		<span><input type="submit" class="button-primary" id="sfmembernew<?php echo $usergroup_id; ?>" name="sfmembernew<?php echo $usergroup_id; ?>" value="<?php spa_etext('Add Members'); ?>" /> <span class="button sfhidden" id='onFinish'></span>
		<input type="button" class="button-primary" onclick="javascript:jQuery('#members-<?php echo $usergroup_id; ?>').html('');" id="sfmembernew<?php echo $usergroup_id; ?>" name="addmemberscancel<?php echo $usergroup_id; ?>" value="<?php spa_etext('Cancel'); ?>" /></span>
		<br />
		<div class="pbar" id="progressbar"></div>
	</form>

	<div class="sfform-panel-spacer"></div>
<?php
}
?>