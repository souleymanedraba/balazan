<!doctype html>
<html>
 <head>
 	<meta charset="utf-8"/>
 	 <title><?php bloginfo('title') ?></title>
 	 <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
 	 <link rel="stylesheet" href="<?php bloginfo('stylesheet_url') ?>"/>
 	<?php wp_head() ?>
 </head>
<header>
	<h1><a href="<?php echo home_url('/')?>"><?php bloginfo('balazan') ?></a></h1>
</header>

<nav>
	<?php wp_nav_menu(array(
		'menu_id'=> 'primary'
	));?>
</nav>
 
<div id="container">
