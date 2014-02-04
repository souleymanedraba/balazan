<?php
/*
Simple:Press
Admin Forums Ordering Form
$LastChangedDate: 2014-02-01 11:06:50 -0800 (Sat, 01 Feb 2014) $
$Rev: 11022 $
*/

if (preg_match('#'.basename(__FILE__).'#', $_SERVER['PHP_SELF'])) die('Access denied - you cannot directly call this file');

function spa_forums_ordering_form() {
	$groups = spdb_table(SFGROUPS, '', '', 'group_seq');
?>
<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('#groupList').nestedSortable({
		handle: 'div',
        items: 'li',
        tolerance: 'pointer',
        toleranceElement: '> div',
        listType: 'ul',
        protectRoot: true,
        placeholder: 'placeholder',
       	forcePlaceholderSize: true,
        helper: 'clone',
        tabSize: 30,
        maxLevels: 10
	});

	jQuery('#sfforumorder').ajaxForm({
		target: '#sfmsgspot',
		beforeSubmit: function() {
			jQuery('#sfmsgspot').show();
			jQuery('#sfmsgspot').html(pWait);
		},
		success: function() {
			jQuery('#sfmsgspot').hide();
			jQuery('#sfreloadfo').click();
			jQuery('#sfmsgspot').fadeIn();
			jQuery('#sfmsgspot').fadeOut(6000);
		},
        beforeSerialize: function() {
            jQuery("input#spForumsOrder").val(jQuery("#groupList").nestedSortable('serialize'));
        }
	});
});
</script>
<?php
	spa_paint_options_init();

    $ahahURL = SFHOMEURL.'index.php?sp_ahah=forums-loader&amp;sfnonce='.wp_create_nonce('forum-ahah').'&amp;saveform=orderforum';
?>
	<form action="<?php echo $ahahURL; ?>" method="post" id="sfforumorder" name="sfforumorder">
<?php
    	echo sp_create_nonce('forum-adminform_forumorder');
		spa_paint_open_tab(spa_text('Forums').' - '.spa_text('Group and Forum Ordering'), true);
			spa_paint_open_panel();
				spa_paint_open_fieldset(spa_text('Order Groups and Forums'), 'true', 'order-forums');
				echo '<p>'.spa_text('Here you can set the order of Groups, Forums and SubForums by dragging and dropping below. After ordering, push the save button.').'</p>';

				if (!empty($groups)) {
					echo '<ul id="groupList" class="groupList menu">';
					foreach ($groups as $group) {
						echo "<li id='group-$group->group_id' class='menu-item-depth-0'>";
						echo "<div class='alt group-list menu-item'>";
						echo "<span class='item-name'>$group->group_name</span>";
						echo '</div>';

						# now output any forums in the group
                        $forums = spa_get_forums_in_group($group->group_id);
                        $parent = array(0);
                        $depth = 1;
						if (!empty($forums)) {
    						echo "<ul id='forumList-$group->group_id' class='forumList menu'>";
							foreach ($forums as $forum) {
                                # done with the subforums?  If so, unwind the depth back to next parent
                                if ($forum->parent != end($parent)) {
                                    do {
                                        $depth--;
                                        array_pop($parent);
                						echo '</ul>';
           								echo '</li>';
                                    } while ($forum->parent != end($parent));
                                }

                                # display this forum
								echo "<li id='forum-$forum->forum_id' class='menu-item-depth-$depth'>";
								echo "<div class='forum-list menu-item'>";
								echo "<span class='item-name'>$forum->forum_name</span>";
        						echo '</div>';

                                # if parent has subforums, output new block and increase depth
                                if (!empty($forum->children)) {
            						echo "<ul id='subForumList-$forum->forum_id' class='subforumList menu'>";
                                    $parent[] = $forum->forum_id;
                                    $depth++;
                                } else {
       								echo '</li>';
                                }
							}

                            # last forum in group done, so make sure to unwind back to group level
                            if (0 != end($parent)) {
                                do {
                                    $depth--;
                                    array_pop($parent);
            						echo '</ul>';
       								echo '</li>';
                                } while (0 != end($parent));
                            }
       	    				echo '</ul>';
               				echo '</li>';
						}
					}
					echo '</ul>';
				}
				echo '<input type="text" class="inline_edit" size="70" id="spForumsOrder" name="spForumsOrder" />';
				spa_paint_close_fieldset();
			spa_paint_close_panel();
		spa_paint_close_tab();
?>
		<div class="sfform-submit-bar">
		<input type="submit" class="button-primary" id="saveit" name="saveit" value="<?php spa_etext('Save Ordering'); ?>" />
		</div>
	</form>
<?php
}
?>