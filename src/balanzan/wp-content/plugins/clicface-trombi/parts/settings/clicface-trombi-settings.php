<?php
/*
Title: General Settings
Setting: clicface_trombi_settings
Order: 10
*/

piklist('field', array(
	'type' => 'radio'
	,'field' => 'trombi_affichage_type'
	,'label' => __('List display', 'clicface-trombi')
	,'value' => 'grid'
	,'choices' => array(
		'grid' => __('Grid', 'clicface-trombi')
		,'list' => __('List', 'clicface-trombi')
	)
));