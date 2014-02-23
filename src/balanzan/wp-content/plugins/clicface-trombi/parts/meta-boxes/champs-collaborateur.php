<?php
/*
Title: Clicface Trombi
Post Type: collaborateur
Order: 5
Collapse: false
*/


piklist('field', array(
	'type' => 'text'
	,'field' => 'nom'
	,'label' => __('Last Name', 'clicface-trombi')
));

piklist('field', array(
	'type' => 'text'
	,'field' => 'prenom'
	,'label' => __('First Name', 'clicface-trombi')
));

piklist('field', array(
	'type' => 'text'
	,'field' => 'mail'
	,'label' => __('E-mail', 'clicface-trombi')
	,'attributes' => array(
		'columns' => 6
	)
));

piklist('field', array(
	'type' => 'text'
	,'field' => 'fonction'
	,'label' => __('Function', 'clicface-trombi')
	,'attributes' => array(
		'columns' => 6
	)
));

piklist('field', array(
	'type' => 'radio'
	,'scope' => 'taxonomy'
	,'field' => 'collaborateur_service'
	,'label' => __('Division', 'clicface-trombi')
	,'choices' => piklist(
		get_terms('collaborateur_service', array(
			'hide_empty' => false
		))
		,array(
			'term_id'
			,'name'
		)
	)
));

piklist('field', array(
	'type' => 'radio'
	,'scope' => 'taxonomy'
	,'field' => 'collaborateur_worksite'
	,'label' => __('Worksite', 'clicface-trombi')
	,'choices' => piklist(
		get_terms('collaborateur_worksite', array(
			'hide_empty' => false
		))
		,array(
			'term_id'
			,'name'
		)
	)
));

piklist('field', array(
	'type' => 'text'
	,'field' => 'telephone_fixe'
	,'label' => __('Landline Number', 'clicface-trombi')
));

piklist('field', array(
	'type' => 'text'
	,'field' => 'telephone_portable'
	,'label' => __('Mobile Number', 'clicface-trombi')
));

piklist('field', array(
	'type' => 'textarea'
	,'field' => 'commentaires'
	,'label' => __('Comments', 'clicface-trombi')
	,'attributes' => array(
		'rows' => 3
		,'cols' => 50
	)
));

piklist('field', array(
	'type' => 'hidden'
	,'field' => 'post_status'
	,'scope' => 'upload_photo'
	,'description' => 'This is set to pull in post status automatically'
	,'label' => 'Attachment Status'
	,'value' => $post->post_status
));

$args = array(
	'post_type' => 'attachment'
	,'numberposts' => -1
	,'post_parent' => $post->ID
	,'post_status' => 'all'
);

$attachments = get_posts( $args );

if ($attachments) {
	global $wp_post_statuses;
	remove_all_filters('get_the_excerpt'); // Since we're using the_excerpt for notes, we need to keep it clean.
	foreach ( $attachments as $post ) {
		setup_postdata($post); ?>
			<div id="pik_post_attachment_<?php echo $post->ID; ?>" class="piklist-field-container">
				<div class="piklist-label-container">
					<?php echo wp_get_attachment_link( $post->ID, 'thumbnail', false, true ); ?>
				</div>
				<div class="piklist-field">
					<a href="<?php echo wp_nonce_url( "/wp-admin/post.php?action=delete&amp;post=$post->ID", 'delete-post_' . $post->ID ) ?>"><?php _e('Permanently delete the picture', 'clicface-trombi'); ?></a>
					<?php the_excerpt(); ?>
				</div>
			</div>
		<?php
	}
} else {
	piklist('field', array(
		'type' => 'file'
		,'field' => 'upload_photo'
		,'scope' => 'post'
		,'label' => __('Picture', 'clicface-trombi')
		,'value' => 'Upload'
	));
}