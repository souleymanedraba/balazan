<?php
/**
 * Archive Template
 *
 * The archive template is the default template used for archives pages without a more specific template. 
 *
 * @package swt
 * @subpackage Template
 */

get_header(); // Loads the header.php template. ?>

	<div id="content">

		<div class="hfeed">

			<?php get_template_part( 'loop-meta' ); // Loads the loop-meta.php template. ?>

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content' ); ?>
					
				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

			<?php endif; ?>

		</div><!-- .hfeed -->

		<?php get_template_part( 'loop-nav' ); // Loads the loop-nav.php template. ?>

	</div><!-- #content -->

<?php get_footer(); // Loads the footer.php template. ?>