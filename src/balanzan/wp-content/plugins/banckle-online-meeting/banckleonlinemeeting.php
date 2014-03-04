<?php
/*
  Plugin Name: Banckle Online Meeting for Wordpress
  Plugin URI: http://banckle.com
  Description: A light, platform-independent and feature-rich web conferencing solution that allows you to host and participate in online meetings, eLearning sessions and webinars easily and effectively! Banckle Online Meeting is based on an extremely stable, robust yet flexible architecture; allowing it to be a secure, reliable, platform-independent and user-friendly web conferencing application.
  Version: 1.2
  Author: Imran Anwar
  Author URI: http://banckle.com

  Copyright (c) 2001-2013 Aspose Pty Ltd. All rights Reserved (email : imran.anwar@banckle.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details at <http://www.gnu.org/licenses/>.
 */


				/**
				 * Banckle Online Meeting Widget
				 */
				class BanckleOnlineMeetingWidget extends WP_Widget {

					 /** constructor */
					 function BanckleOnlineMeetingWidget() {
						  parent::WP_Widget(false, $name = 'Banckle Onlne Meeting Widget');
					 }

					 /** @see WP_Widget::widget */
					 function widget($args, $instance) {
						  extract($args);
						  $title = apply_filters('widget_title', $instance['title']);
						  $BOMWidgetCode = apply_filters('BOMWidgetCode', $instance['widgetCode']);
	 ?>
<style>
	 .om-widget-container {
width:100%;
}
.om-widget-content {
padding:0px;
}
.om-widget-agenda {
padding:5px;
width:95%;
}
</style>
	 <?php echo $before_widget; ?>
	 <?php if ($title)
								echo $before_title . $title . $after_title; ?>
	 <?php echo $BOMWidgetCode; ?>
	 <?php echo $after_widget; ?>
	 <?php
					 }

					 /** @see WP_Widget::update */
					 function update($new_instance, $old_instance) {
						  $instance = $old_instance;
						  $instance['title'] = strip_tags($new_instance['title']);
						  $instance['widgetCode'] = $new_instance['widgetCode'];
						  return $instance;
					 }

					 /** @see WP_Widget::form */
					 function form($instance) {
						  $title = esc_attr($instance['title']);
						  $widgetCode = esc_attr($instance['widgetCode']);
	 ?>

<p>
	 Don't have Banckle account yet? <a target="_blank" href="http://banckle.com/action/signup?ref=https%3A%2F%2Fapps.banckle.com%2F" ;="">Sign Up for Free!</a>
</p>
						  <p>
					 		  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
					 		  <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
								<label for="<?php echo $this->get_field_id('widgetCode'); ?>"><?php _e('Widget Code:'); ?></label>
							  <textarea rows="10" class="widefat" id="<?php echo $this->get_field_id('widgetCode'); ?>" name="<?php echo $this->get_field_name('widgetCode'); ?>"><?php echo $widgetCode; ?></textarea>
					 	 </p>
						 <p>
							  About getting BOM widget Code please read <a href="http://banckle.com/wiki/display/onlinemeeting/integration-with-wordpress.html" target="_blank">Banckle Online Meeting for WordPress integration</a>.
						 </p>
	 <?php
					 }

				}

// class Banckle Online Meeting Widget
// register widget
				add_action('widgets_init', create_function('', 'return register_widget("BanckleOnlineMeetingWidget");'));
	 ?>