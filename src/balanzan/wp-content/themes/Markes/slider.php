<?php

global $options;
$options = get_option( 'swt_theme_options' );

if ( !is_singular() && $options['swt_slider'] == 'Display' ) {

	$slider_cat = $options['swt_slide_category'];
	$slider_cat_id = get_cat_ID( $slider_cat );
	$slide_count = $options['swt_slide_count'];

?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery(window).load(function() {
			jQuery('.flexslider').flexslider({
				slideshowSpeed: 		4000,
				animationDuration:		1000,
				directionNav:			false,
				controlNav:			true,
				manualControls: 		".flex-control-paging li",				
 				keyboardNav:			true			
			});
		});	
	});
</script>
<div id="slider-wrap">
        <div class="flexslider">
		<ul class="slides">
		
			<?php $my_query = new WP_Query( 'cat= '. $slider_cat_id .'&showposts='.$slide_count.'' );
		
				while ( $my_query->have_posts() ) : $my_query->the_post(); $do_not_duplicate = $post->ID; ?>	
				
				<li>
					<img src="<?php echo get_post_meta( $post->ID, 'slide', $single = true ); ?>" />
					
					<div class="flex-caption">
						<h2 class="flex-title"><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p><?php truncate_post( 80, true ); ?></p>
					</div>
				</li>
				
			<?php endwhile; ?>
			
		</ul><!--.slides-->
		
         </div><!--.flexslider-->
</div><!--#sliderwrap-->
<?php } ?>