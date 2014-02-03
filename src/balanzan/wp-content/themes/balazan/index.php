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
		 	<h2><a href="<?php the_permalink()?>"><?php the_title()?></a></h2>
		 	<p>
		 		<a href="<?php echo get_author_link(false, $authordata->ID, $authordata->user_nicename);?>"></a>
		 	<p>
		 	<?php the_content(__('Continue Reading'));?>
		 <?php endwhile;?>
	</div>
<?php get_footer()?>

