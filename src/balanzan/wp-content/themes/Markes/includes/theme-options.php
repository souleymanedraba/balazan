<?php
$gettname = wp_get_theme( get_template(), get_theme_root( get_template_directory() ) );
$themename = $gettname->get( 'Name' );
$shortname = "swt";
$version = "1.0";

$option_group = $shortname.'_theme_option_group';
$option_name = $shortname.'_theme_options';

$readme = trailingslashit( get_template_directory_uri() ) ."readme.html";
$img_dir = trailingslashit( get_template_directory_uri() ) .'includes/images/';
$hts = $img_dir.'howtoslide.png';
$banners_default = $img_dir.'elegant.gif';
$mx_categories_obj = get_categories('hide_empty=0');
$mx_categories = array();
foreach ($mx_categories_obj as $mx_cat) {
	$mx_categories[$mx_cat->cat_ID] = $mx_cat->cat_name;
}
$categories_tmp = array_unshift($mx_categories, "Select a category:","Uncategorized" );


// Load stylesheet and jscript
add_action('admin_init', 'swt_add_init');

function swt_add_init() {
	$file_dir = get_template_directory_uri();
	wp_enqueue_style("swtCss", $file_dir."/includes/theme-options.css", false, "1.0", "all");
	wp_enqueue_script("swtScript", $file_dir."/includes/theme-options.js", false, "1.0");
}

// Create custom settings menu
add_action('admin_menu', 'swt_create_menu');

function swt_create_menu() {
	global $themename;
	//create new top-level menu
	add_theme_page( __( $themename.' Theme Options' ), __( 'Theme Options' ), 'edit_theme_options', basename(__FILE__), 'swt_settings_page' );
}

// Register settings
add_action( 'admin_init', 'register_settings' );

function register_settings() {
   global $themename, $shortname, $version, $swt_options, $option_group, $option_name;
  	//register our settings
	register_setting( $option_group, $option_name);
}


// Create theme options
global $swt_options;
$swt_options = array (

array("name" => "Slider Settings",
      "type" => "section"),
array("type" => "section-desc"),
array("type" => "open"),

	array(  "name" => "Enable/Disable Content Slider",
			  "desc" => "To have content slider working, you'll have to enable it first, then select sliding category and number of slides. Under post, thats under 	selected sliding category, enter new custom field 'slide' (without '' quotes), and then on the right side in the 'Value' leave the link to the image. Check <a href='$hts' target='_blank'>this image</a> to make sure you're doing good! For some sliders, you dont need to do this, you just need to set image as featured for each post that is in the slider. Images are automatically resized, but try to upload similiar size's like on demo version of this theme, pic's wont loose their quality! <b><u><a target='_blank' href='$readme'>PLEASE FOLLOW README IN THEME'S FOLDER!</a></u></b> Its all explained, how to set featured images, change the logo, and everything needed!",
			  "id" => $shortname."_slider",
			  "type" => "select",
			  "std" => "Hide",
			  "options" => array("Hide", "Display")),

	array( 	"name" => "Sliding category",
			  "desc" => "Select the category that will be displayed in the slider.",
			  "id" => $shortname."_slide_category",
			  "std" => "Uncategorized",
			  "type" => "select",
			  "options" => $mx_categories),
 
 	array(	"name" => "Number of slides",
			  "desc" => "Enter number of slides",
			  "id" => $shortname."_slide_count",
			  "std" => "3",
			  "type" => "text",
),

array("type" => "close"),

array("name" => "Featured Posts",
      "type" => "section"),
array("type" => "section-desc"),
array("type" => "open"),

	array(  "name" => "Enable / Disable Featured Posts",
			  "desc" => "Show / Hide Featured Posts",
			  "id" => $shortname."_fp",
			  "type" => "select",
			  "std" => "Hide",
			  "options" => array("Hide", "Display")),

	array( 	"name" => "Featured Posts Category",
			  "desc" => "Select the category from which posts will be shown",
			  "id" => $shortname."_fp_category",
			  "std" => "Uncategorized",
			  "type" => "select",
			  "options" => $mx_categories),

	array(	"name" => "Number Of Featured Posts",
			  "desc" => "Enter the number of featured posts to show",
			  "id" => $shortname."_fp_count",
			  "std" => "3",
			  "type" => "text",
),

array("type" => "close"),

array("name" => "Social Profiles",
      "type" => "section"),
array("type" => "section-desc"),
array("type" => "open"),

	array(  "name" => "Enable / Disable Social Profiles",
			  "desc" => 'Show / Hide social profiles',
			  "id" => $shortname."_social",
			  "type" => "select",
			  "std" => "Display",
			  "options" => array("Display", "Hide")),

	array("name" =>   "Facebook",
			  "desc" => "Enter your Facebook url here.",
		          "id" => $shortname."_facebook",
			  "std" => "#",
			  "type" => "text"),
	
	array("name" =>   "Twitter",
			  "desc" => "Enter your Twitter url here.",
		          "id" => $shortname."_twitter",
			  "std" => "#",
			  "type" => "text"),	
	
	array("name" =>   "RSS",
			  "desc" => "Enter your RSS url here.",
		          "id" => $shortname."_rss",
			  "std" => "#",
			  "type" => "text"),

	array("name" =>   "Youtube",
			  "desc" => "Enter your Youtube channel here.",
		          "id" => $shortname."_youtube",
			  "std" => "#",
			  "type" => "text"),
 
	array("name" =>   "Linkedin",
			  "desc" => "Enter your Linkedin url here.",
		          "id" => $shortname."_linkedin",
			  "std" => "#",
			  "type" => "text"),
	
	array("name" =>   "Pinterest",
			  "desc" => "Enter your Pinterest url here.",
		          "id" => $shortname."_pinterest",
			  "std" => "#",
			  "type" => "text"),	
	
array( "type" => "close"),
 
    

array("name" => "Footer",
      "type" => "section"),
array("type" => "section-desc"),
array("type" => "open"),    
 
       array("name" => 	  "Google Analytics Tracking Code",
			  "desc" => "Enter your tracking code here for Google Analytics",
			  "id" => $shortname."_analytics_code",
  			  "type" => "textarea",
			  "std" => ""),

array("type" => "close"), 
 
);


function swt_settings_page() {
   global $themename, $shortname, $version, $swt_options, $option_group, $option_name;
?>

<div class="wrap">
<div class="options_wrap">
<?php screen_icon(); ?><h2><?php echo $themename; ?> <?php _e('Theme Options',hybrid_get_parent_textdomain()); ?></h2>
<p class="top-notice"><?php _e('Customize your WordPress blog with these settings. ',hybrid_get_parent_textdomain()); ?></p>
<?php if ( isset ( $_POST['reset'] ) ): ?>
<?php // Delete Settings
global $wpdb, $themename, $shortname, $version, $swt_options, $option_group, $option_name;
delete_option('swt_theme_options');
wp_cache_flush(); ?>
<div class="updated fade"><p><strong><?php _e( $themename. ' options reset.' ); ?></strong></p></div>

<?php elseif ( isset ( $_REQUEST['save'] ) ): ?>
<div class="updated fade"><p><strong><?php _e( $themename. ' options saved.' ); ?></strong></p></div>
<?php endif; ?>

<form method="post" action="options.php">

<?php settings_fields( $option_group ); ?>

<?php $options = get_option( $option_name ); ?>        

<?php foreach ($swt_options as $value) {
if ( isset($value['id']) ) { $valueid = $value['id'];}
switch ( $value['type'] ) {
case "section":
?>
	<div class="section_wrap">
	<h3 class="section_title"><?php echo $value['name']; ?> 

<?php break; 
case "section-desc":
?>
	<span><?php if ( isset( $value['name'] ) ) echo $value['name']; ?></span></h3>
	<div class="section_body">

<?php 
break;
case 'text':
?>

	<div class="options_input options_text">
		<div class="options_desc"><?php echo $value['desc']; ?></div>
		<span class="labels"><label for="<?php echo $option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></span>
		<input name="<?php echo $option_name.'['.$valueid.']'; ?>" id="<?php echo $option_name.'['.$valueid.']'; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( isset( $options[$valueid]) ){ esc_attr_e($options[$valueid]); } else { esc_attr_e($value['std']); } ?>" />
	</div>

<?php
break;
case 'textarea':
?>
	<div class="options_input options_textarea">
		<div class="options_desc"><?php echo $value['desc']; ?></div>
		<span class="labels"><label for="<?php echo $option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></span>
		<textarea name="<?php echo $option_name.'['.$valueid.']'; ?>" type="<?php echo $option_name.'['.$valueid.']'; ?>" cols="" rows=""><?php if ( isset( $options[$valueid]) ){ esc_attr_e($options[$valueid]); } else { esc_attr_e($value['std']); } ?></textarea>
	</div>

<?php 
break;
case 'select':
?>
	<div class="options_input options_select">
		<div class="options_desc"><?php echo $value['desc']; ?></div>
		<span class="labels"><label for="<?php echo $option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></span>
		<select name="<?php echo $option_name.'['.$valueid.']'; ?>" id="<?php echo $option_name.'['.$valueid.']'; ?>">
		<?php foreach ($value['options'] as $option) { ?>
				<option <?php if ($options[$valueid] == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?>
		</select>
	</div>

<?php
break;
case "radio":
?>
	<div class="options_input options_select">
		<div class="options_desc"><?php echo $value['desc']; ?></div>
		<span class="labels"><label for="<?php echo $option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></span>
		  <?php foreach ($value['options'] as $key=>$option) { 
			$radio_setting = $options[$valueid];
			if($radio_setting != ''){
				if ($key == $options[$valueid] ) {
					$checked = "checked=\"checked\"";
					} else {
						$checked = "";
					}
			}else{
				if($key == $value['std']){
					$checked = "checked=\"checked\"";
				}else{
					$checked = "";
				}
			}?>
			<input type="radio" id="<?php echo $option_name.'['.$valueid.']'; ?>" name="<?php echo $option_name.'['.$valueid.']'; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> /><?php echo $option; ?><br />
			<?php } ?>
	</div>

<?php
break;
case "checkbox":
?>
	<div class="options_input options_checkbox">
		<div class="options_desc"><?php echo $value['desc']; ?></div>
		<?php if( isset( $options[$valueid] ) ){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
		<input type="checkbox" name="<?php echo $option_name.'['.$valueid.']'; ?>" id="<?php echo $option_name.'['.$valueid.']'; ?>" value="true" <?php echo $checked; ?> />
		<label for="<?php echo $option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label>
	 </div>

<?php
break;
case "close":
?>
</div><!--#section_body-->
</div><!--#section_wrap-->

<?php 
break;
}
}
?>

<span class="submit">
<input class="button button-primary" type="submit" name="save" value="<?php _e('Save All Changes', hybrid_get_parent_textdomain()) ?>" />
</span>
</form>

<form method="post" action="">
<span class="button-right" class="submit">
<input class="button button-secondary" type="submit" name="reset" value="<?php _e('Reset/Delete Settings', hybrid_get_parent_textdomain()) ?>" />
<input type="hidden" name="action" value="reset" />
<span><?php _e('Caution: All entries will be deleted from database. Press when starting afresh or completely removing the theme.',hybrid_get_parent_textdomain()) ?></span>
</span>
</form>
</div><!--#options-wrap-->

<div class="sidebox">
	<h2>Support for <?php echo $themename; ?>!</h2>
	<p>Theme is made by <a href="http://www.simplewpthemes.com">Simplewpthemes.com</a>.</p>
	<p>Make sure you learn how to use theme first. Please check readme.txt from theme folder, then <a href="http://www.simplewpthemes.com/faq/">FAQ</a> on our site and, and comments on our site for this theme. If you're not sure how to set custom fields, it's all explained with images in our <a href="http://www.simplewpthemes.com/faq/">FAQ</a>.</p>
	</div>
</div>
<?php } ?>