<?php
/**
 * Index Template
 *
 * This is the default template.  It is used when a more specific template can't be found to display
 * posts.  It is unlikely that this template will ever be used, but there may be rare cases.
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