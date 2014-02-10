<?php if ( post_password_required() ) return; ?>

<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>

		<div id="comment-header" class="cf">
			<h3 class="title"><?php comments_number( __('Comments', 'frontier'), __('1 Comment', 'frontier'), __('% Comments', 'frontier') ); ?></h3>
			<?php if ( comments_open() ) : ?>
				<span class="respond-link"><a href="#respond"><?php _e('Add a Comment', 'frontier'); ?></a></span>
			<?php endif; ?>
		</div>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav class="navigation comment-navigation" role="navigation">
				<div class="comment-nav"><?php paginate_comments_links(); ?></div>
			</nav>
		<?php endif; ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 50,
				) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav class="navigation comment-navigation" role="navigation">
				<div class="comment-nav"><?php paginate_comments_links(); ?></div>
			</nav>
		<?php endif; ?>

		<?php if ( ! comments_open() && get_comments_number() ) : ?>
			<div class="no-comments"><i class="genericon genericon-warning"></i><h4><?php _e( 'Comments are closed.' , 'frontier' ); ?></h4></div>
		<?php endif; ?>

	<?php endif; ?>

	<?php comment_form(); ?>
</div>