<?php
/*
Title: How to use Clicface Trombi?
Setting: clicface_trombi_settings
Order: 10
*/
?>
<ol>
<li>To see how to use Clicface Trombi, <a href="http://www.clicface.com/documentation/how-to-use-clicface-trombi/" target="_blank">a tutorial is available online</a></li>
<li>Stay in touch with Clicface updates by <a href="http://eepurl.com/Oz7YH" target="_blank">subscribing to our newsletter</a>. New subscribers automatically receive discount vouchers.</li>
<li>Need help? Check our <a href="http://www.clicface.com/documentation/faq/" target="_blank">FAQ</a> or <a href="http://support.clicface.com/" target="_blank">create a new support ticket</a></li>
<li>Consider <a href="https://twitter.com/clicface" target="_blank">following us on Twitter</a></li>
</ol>
<h3>General Settings</h3>
<?php
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