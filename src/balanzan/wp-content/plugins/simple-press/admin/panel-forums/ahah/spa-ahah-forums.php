<?php
/*
Simple:Press
Forum Specials
$LastChangedDate: 2014-01-26 16:21:09 -0800 (Sun, 26 Jan 2014) $
$Rev: 11005 $
*/

if (preg_match('#'.basename(__FILE__).'#', $_SERVER['PHP_SELF'])) die('Access denied - you cannot directly call this file');

spa_admin_ahah_support();

include_once(SF_PLUGIN_DIR.'/admin/panel-forums/support/spa-forums-prepare.php');

# Check Whether User Can Manage Components
if (!sp_current_user_can('SPF Manage Forums')) {
	spa_etext('Access denied - you do not have permission');
	die();
}

if (isset($_GET['action'])) $action = $_GET['action'];
if (isset($_GET['type'])) $type = sp_esc_str($_GET['type']);
if (isset($_GET['id'])) $id = sp_esc_int($_GET['id']);
if (isset($_GET['title'])) $title = sp_esc_str($_GET['title']);
if (isset($_GET['slugaction'])) $slugaction = sp_esc_str($_GET['slugaction']);

if ($action == 'slug') {
	$checkdupes = true;
	if ($slugaction == 'edit') $checkdupes=false;
	$newslug = sp_create_slug($title, $checkdupes, SFFORUMS, 'forum_slug');
	$newslug = sp_create_slug($newslug, $checkdupes, SFWPPOSTS, 'post_name'); # must also check WP posts table as WP can mistake forum slug for WP post
	echo $newslug;
}

if ($action == 'delicon') {
	global $spPaths;
	$file = sp_esc_str($_GET['file']);
	$path = SF_STORE_DIR.'/'.$spPaths['custom-icons'].'/'.$file;
	@unlink($path);
}

die();
?>