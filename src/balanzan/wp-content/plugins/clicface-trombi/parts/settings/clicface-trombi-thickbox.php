<?php
/*
Title: Clicface Trombi
Setting: clicface_trombi_settings
Tab: ThickBox
Order: 40
*/

piklist('field', array(
	'type' => 'number'
	,'field' => 'trombi_thickbox_width'
	,'label' => __('Width (in pixels)', 'clicface-trombi')
	,'value' => 800
	,'attributes' => array(
		'class' => 'small-text'
	)
));

piklist('field', array(
	'type' => 'number'
	,'field' => 'trombi_thickbox_height'
	,'label' => __('Height (in pixels)', 'clicface-trombi')
	,'value' => 670
	,'attributes' => array(
		'class' => 'small-text'
	)
));