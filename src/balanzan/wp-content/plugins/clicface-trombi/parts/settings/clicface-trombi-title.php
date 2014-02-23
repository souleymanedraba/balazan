<?php
/*
Title: Clicface Trombi
Setting: clicface_trombi_settings
Tab: Title
Order: 30
*/

piklist('field', array(
	'type' => 'text'
	,'field' => 'trombi_title_name_singular'
	,'label' => __('Title name (singular)', 'clicface-trombi')
	,'value' => __('Employee', 'clicface-trombi')
	,'attributes' => array(
		'class' => 'regular-text'
	)
	,'position' => 'wrap'
));

piklist('field', array(
	'type' => 'text'
	,'field' => 'trombi_title_name_plural'
	,'label' => __('Title name (plural)', 'clicface-trombi')
	,'value' => __('Employees', 'clicface-trombi')
	,'attributes' => array(
		'class' => 'regular-text'
	)
	,'position' => 'wrap'
));