<?php
 register_sidebar(array(
 	'name' => __('1st Right Sidebar'),
 	'id'=>'first-right-sidebar',
 	'description'=>'The top bar',
    'before_widget'=> '<div>',
    'after_widget'=>'</div>'
 ));
 
 register_sidebar(array(
 'name' => __('2st Right Sidebar'),
 'id'=>'second-right-sidebar',
 'description'=>'The second top bar',
 'before_widget'=> '<div>',
 'after_widget'=>'</div>'
 		
 ));
 ?>
 