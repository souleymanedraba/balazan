<?php
/*
 Template Name: Home
*/
?>

<?php get_header(); ?>
<?php    if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer 1') ) ?>
<?php    if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer 2') ) ?>
<?php    if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer 3') ) ?>

<?php get_footer(); ?>