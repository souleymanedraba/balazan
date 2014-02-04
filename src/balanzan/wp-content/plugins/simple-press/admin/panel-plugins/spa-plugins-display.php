<?php
/*
Simple:Press
Admin plugins Display Rendering
$LastChangedDate: 2014-01-11 08:31:57 -0800 (Sat, 11 Jan 2014) $
$Rev: 10960 $
*/

if (preg_match('#'.basename(__FILE__).'#', $_SERVER['PHP_SELF'])) die('Access denied - you cannot directly call this file');

function spa_render_plugins_panel($formid) {
?>
	<div class="clearboth"></div>

	<div class="wrap sfatag">
		<?php
			spa_render_sidemenu();
		?>
		<div id='sfmsgspot'></div>
		<div id="sfmaincontainer">
			<?php spa_render_plugins_container($formid); ?>
		</div>
			<div class="clearboth"></div>
	</div>
<?php
}

function spa_render_plugins_container($formid) {
	switch($formid) {
		case 'plugin-list':
			include_once(SF_PLUGIN_DIR.'/admin/panel-plugins/forms/spa-plugins-list-form.php');
			spa_plugins_list_form();
			break;

		case 'plugin-upload':
			include_once(SF_PLUGIN_DIR.'/admin/panel-plugins/forms/spa-plugins-upload-form.php');
			spa_plugins_upload_form();
			break;

        # leave this for plugins to add to this panel
		case 'plugin':
			include_once(SF_PLUGIN_DIR.'/admin/panel-plugins/forms/spa-plugins-user-form.php');
            $admin = (isset($_GET['admin'])) ? sp_esc_str($_GET['admin']) : '';
            $save = (isset($_GET['save'])) ? sp_esc_str($_GET['save']) : '';
            $form = (isset($_GET['form'])) ? sp_esc_int($_GET['form']) : '';
            $reload = (isset($_GET['reload'])) ? sp_esc_str($_GET['reload']) : '';
			spa_plugins_user_form($admin, $save, $form, $reload);
			break;
	}
}
?>