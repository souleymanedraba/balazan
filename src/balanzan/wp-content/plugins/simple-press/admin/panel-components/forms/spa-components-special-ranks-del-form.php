<?php
/*
Simple:Press
Admin Components Special Rank Delete Member Form
$LastChangedDate: 2013-12-04 05:25:27 -0800 (Wed, 04 Dec 2013) $
$Rev: 10906 $
*/

if (preg_match('#'.basename(__FILE__).'#', $_SERVER['PHP_SELF'])) die('Access denied - you cannot directly call this file');

function spa_components_sr_del_members_form($rank_id) {
?>
<script type="text/javascript">
jQuery(document).ready(function() {
	spjAjaxForm('sfmemberdel<?php echo $rank_id; ?>', 'sfreloadfr');
});
</script>
<?php
	spa_paint_options_init();

    $ahahURL = SFHOMEURL.'index.php?sp_ahah=components-loader&amp;sfnonce='.wp_create_nonce('forum-ahah')."&amp;saveform=specialranks&amp;action=delmember&amp;id=$rank_id";
?>
	<form action="<?php echo $ahahURL; ?>" method="post" id="sfmemberdel<?php echo $rank_id; ?>" name="sfmemberdel<?php echo $rank_id ?>">
<?php
		echo sp_create_nonce('special-rank-del');
?>
					<p><?php spa_etext('Select member to add (use CONTROL for multiple members)') ?></p>
<?php
                	$from = esc_js(spa_text('Current members'));
                	$to = esc_js(spa_text('Selected Members'));
                    $action = 'delru';
                	include_once(SF_PLUGIN_DIR.'/admin/library/ahah/spa-ahah-multiselect.php');
?>
					<div class="clearboth"></div>
<?php
        $loc = 'sfrankshow-'.$rank_id;
?>
		<input type="submit" class="button-primary" id="sfmemberdel<?php echo $rank_id; ?>" name="sfmemberdel<?php echo $rank_id; ?>" onclick="javascript:jQuery('#dmember_id<?php echo $rank_id; ?> option').each(function(i) {jQuery(this).attr('selected', 'selected');});" value="<?php spa_etext('Remove Members'); ?>" />
		<input type="button" class="button-primary" onclick="spjToggleLayer('<?php echo $loc; ?>');javascript:jQuery('#members-<?php echo $rank_id; ?>').html('');" id="sfmemberdel<?php echo $rank_id; ?>" name="addmemberscancel<?php echo $rank_id; ?>" value="<?php spa_etext('Cancel'); ?>" />
	</form>

	<div class="sfform-panel-spacer"></div>
<?php
}
?>