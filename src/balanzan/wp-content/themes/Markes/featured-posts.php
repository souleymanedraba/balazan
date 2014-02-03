<?php

global $options;
$options = get_option('swt_theme_options');

if ( !is_singular() && $options['swt_fp']=='Display' ) {

	$fp_cat = $options['swt_fp_category'];
	$fp_cat_id = get_cat_ID($fp_cat);
	$fp_num = $options['swt_fp_count'];

?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('#featured li').hover(function(){
			
			var height = jQuery('.details', this).height();
			
			jQuery('.details', this).stop().animate({
				top : 150-height
			}, 120 );				
		}, function(){
			jQuery('.details', this).stop().animate({
				top : 0
			}, 120 );								
		});
	});
</script>
<div id="featured">
	<ul class="featured-posts">
		<?php $x = 0; $swt_query = new WP_Query( 'cat= '. $fp_cat_id . '&showposts='. $fp_num .'' ); while ( $swt_query->have_posts() ) : $swt_query->the_post(); $x++; ?>
			<li class="item<?php echo $x; ?>">
				<?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'meta_key' => 'Medium', 'size' => 'medium', 'width' => 300, 'height' => 175 ) ); ?>
				<div class="details">
					<h4 class="featured-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
					<a href="<?php the_permalink(); ?>" class="featured-more"><?php _e( 'Read More', hybrid_get_parent_textdomain() ); ?></a>
				</div><!-- .details -->					
			</li>
		<?php endwhile; ?>
	</ul><!-- .featured-posts -->
</div><!-- #featured -->
<div class="clear"></div>
<?php } ?>