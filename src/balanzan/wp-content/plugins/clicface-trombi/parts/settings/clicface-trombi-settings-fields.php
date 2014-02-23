<?php
/*
Title: Field Settings on the main page
Setting: clicface_trombi_settings
Order: 20
*/

piklist('field', array(
	'type' => 'radio'
	,'field' => 'trombi_display_service'
	,'label' => __('Display Division', 'clicface-trombi')
	,'value' => 'oui'
	,'choices' => array(
		'oui' => __('Yes', 'clicface-trombi')
		,'non' => __('No', 'clicface-trombi')
	)
));

piklist('field', array(
	'type' => 'radio'
	,'field' => 'trombi_display_phone'
	,'label' => __('Display Landline Number', 'clicface-trombi')
	,'value' => 'non'
	,'choices' => array(
		'oui' => __('Yes', 'clicface-trombi')
		,'non' => __('No', 'clicface-trombi')
	)
));

piklist('field', array(
	'type' => 'radio'
	,'field' => 'trombi_display_cellular'
	,'label' => __('Display Mobile Number', 'clicface-trombi')
	,'value' => 'non'
	,'choices' => array(
		'oui' => __('Yes', 'clicface-trombi')
		,'non' => __('No', 'clicface-trombi')
	)
));

piklist('field', array(
	'type' => 'radio'
	,'field' => 'trombi_display_email'
	,'label' => __('Display E-mail', 'clicface-trombi')
	,'value' => 'non'
	,'choices' => array(
		'oui' => __('Yes', 'clicface-trombi')
		,'non' => __('No', 'clicface-trombi')
	)
));