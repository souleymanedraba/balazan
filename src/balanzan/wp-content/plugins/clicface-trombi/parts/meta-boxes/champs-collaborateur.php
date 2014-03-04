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
	'type' => 'file'
	,'field' => 'upload_photo'
	,'scope' => 'post_meta'
	,'label' => __('Picture', 'clicface-trombi')
	,'options' => array(
		'modal_title' => __('Add a picture', 'clicface-trombi')
		,'button' => __('Add a picture', 'clicface-trombi')
	)
));