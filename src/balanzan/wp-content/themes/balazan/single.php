<?php
/**
* The template for displaying all pages
*
* @package WordPress
* @subpackage balazan
* @since Balazan 1.0
*/

get_header(); ?>
<?php get_sidebar()?>	
	<div id="left">
		 <?php while (have_posts()): the_post()?>
		 	<h2><?php the_title()?></h2>
		 	<?php the_content();?>
		 <?php endwhile;?>
		 
		 <?php comments_template('', true);?>
	</div>
<?php get_footer()?>