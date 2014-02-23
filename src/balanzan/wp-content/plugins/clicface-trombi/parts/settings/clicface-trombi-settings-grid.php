<?php
/*
Title: Grid Settings (for the Grid display only)
Setting: clicface_trombi_settings
Order: 30
*/

piklist('field', array(
	'type' => 'number'
	,'field' => 'trombi_collaborateurs_par_ligne'
	,'label' => __('Number of people per line', 'clicface-trombi')
	,'value' => 3
	,'attributes' => array(
		'class' => 'small-text'
	)
));

piklist('field', array(
	'type' => 'number'
	,'field' => 'vignette_width'
	,'label' => __('Width of boxes (in pixels)', 'clicface-trombi')
	,'value' => 250
	,'attributes' => array(
		'class' => 'small-text'
	)
));