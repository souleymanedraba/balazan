<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

        <?php echo apply_atomic_shortcode( 'entry_title', '[entry-title]' ); ?>

	<?php echo apply_atomic_shortcode( 'byline', '<div class="byline">' . __( 'By [entry-author] / Posted on [entry-published format="m.d.Y"] [entry-edit-link before=" / "]', hybrid_get_parent_textdomain() ) . '</div>' ); ?>        
        
        <div class="entry-content">
                <?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'meta_key' => 'Thumbnail', 'size' => 'thumbnail', 'image_class' => 'alignleft' ) ); ?>
                <?php the_excerpt(); ?>
                <?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', hybrid_get_parent_textdomain() ), 'after' => '</p>' ) ); ?>
        </div><!-- .entry-content -->
        
	<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">' . __( '[read_more text="Read More"]', hybrid_get_parent_textdomain() ) . '</div>' ); ?>
        

</div><!-- .hentry -->