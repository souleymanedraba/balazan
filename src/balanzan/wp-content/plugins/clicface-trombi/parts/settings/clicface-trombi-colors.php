<?php
/*
Title: Clicface Trombi
Setting: clicface_trombi_settings
Tab: Colors
Order: 50
*/

piklist('field', array(
	'type' => 'colorpicker'
	,'field' => 'vignette_color_border'
	,'label' => __('Border Color', 'clicface-trombi') . '<br />' . __('(for Grid display)', 'clicface-trombi')
	,'value' => '#B5D9EA'
	,'description' => __('Click to pick a color.', 'clicface-trombi') . ' ' . __('Default color:', 'clicface-trombi') . ' #B5D9EA'
	,'attributes' => array(
		'class' => 'text'
	)
	,'position' => 'wrap'
));

piklist('field', array(
	'type' => 'colorpicker'
	,'field' => 'vignette_color_background_top'
	,'label' => __('Top Background Color', 'clicface-trombi') . '<br />' . __('(for Grid display)', 'clicface-trombi')
	,'value' => '#EDF7FF'
	,'description' => __('Click to pick a color.', 'clicface-trombi') . ' ' . __('Default color:', 'clicface-trombi') . ' #EDF7FF'
	,'attributes' => array(
		'class' => 'text'
	)
	,'position' => 'wrap'
));

piklist('field', array(
	'type' => 'colorpicker'
	,'field' => 'vignette_color_background_bottom'
	,'label' => __('Bottom Background Color', 'clicface-trombi') . '<br />' . __('(for Grid display)', 'clicface-trombi')
	,'value' => '#CDE7EE'
	,'description' => __('Click to pick a color.', 'clicface-trombi') . ' ' . __('Default color:', 'clicface-trombi') . ' #CDE7EE'
	,'attributes' => array(
		'class' => 'text'
	)
	,'position' => 'wrap'
));