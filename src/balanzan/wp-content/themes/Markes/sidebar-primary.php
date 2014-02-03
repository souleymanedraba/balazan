<?php
/**
 * Primary Sidebar Template
 *
 * Displays widgets for the Primary dynamic sidebar if any have been added to the sidebar through the 
 * widgets screen in the admin by the user.  Otherwise, nothing is displayed.
 *
 * @package swt
 * @subpackage Template
 */

if ( is_active_sidebar( 'primary' ) ) : ?>

	<div id="sidebar-primary" class="sidebar">

	
		<?php include( trailingslashit( get_template_directory() ) .'includes/social.php' ); ?>
		<?php dynamic_sidebar( 'primary' ); ?>

	</div><!-- #sidebar-primary .aside -->

<?php endif; ?>