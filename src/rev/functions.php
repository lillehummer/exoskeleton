<?php

require_once( 'library/bones.php' );
require_once( 'library/admin.php' );
require_once( 'library/activation.php' );

/************* AFTER THEME SETUP ******************/
function bones_ahoy() {

	//Allow editor style.
  add_editor_style( get_stylesheet_directory_uri() . '/library/css/editor-style.css' );

	// let's get language support going, if you need it
	load_theme_textdomain( 'lillehummernl', get_template_directory() . '/languages' );

	// USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
  	require_once( 'library/custom-post-type.php' );

	// launching operation cleanup
	add_action( 'init', 'bones_head_cleanup' );
	// A better title
	//add_filter( 'wp_title', 'rw_title', 10, 3 );
	// remove WP version from RSS
	add_filter( 'the_generator', 'bones_rss_version' );
	// remove pesky injected css for recent comments widget
	add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
	// clean up comment styles in the head
	add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
	// clean up gallery output in wp
	add_filter( 'gallery_style', 'bones_gallery_style' );

	// enqueue base scripts and styles
	add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );
	// ie conditional wrapper

	// launching this stuff after theme setup
	bones_theme_support();

	// adding sidebars to Wordpress (these are created in functions.php)
	add_action( 'widgets_init', 'bones_register_sidebars' );

	// cleaning up random code around images
	add_filter( 'the_content', 'bones_filter_ptags_on_images' );
	// cleaning up excerpt
	add_filter( 'excerpt_more', 'bones_excerpt_more' );

}

add_action( 'after_setup_theme', 'bones_ahoy' );

/************* AFTER SWITCH THEME ******************/
// Flush rewrite rules for custom post types
add_action( 'after_switch_theme', 'bones_setup_theme' );

// Flush your rewrite rules
function bones_set_image_dimensions() {
  update_option('image_default_link_type','none');

	$catalog = array(
		'width' 	=> '100',
		'height'	=> '100',
		'crop'		=> 1
	);

	$single = array(
		'width' 	=> '100',
		'height'	=> '100',
		'crop'		=> 1
	);

	$thumbnail = array(
		'width' 	=> '100',
		'height'	=> '100',
		'crop'		=> 1
	);

	update_option( 'shop_catalog_image_size', $catalog );
	update_option( 'shop_single_image_size', $single );
	update_option( 'shop_thumbnail_image_size', $thumbnail );

	update_option('thumbnail_size_w', 100);
	update_option('thumbnail_size_h', 100);
	update_option("thumbnail_crop", 1);
	update_option('medium_size_w', 100);
	update_option('medium_size_h', 100);
	update_option("medium_crop", 1);
	update_option('large_size_w', 100);
	update_option('large_size_h', 100);
	update_option("large_crop", 1);
}

/************* IMAGE/EMBED SIZE OPTIONS *************/

// Limit size of embeds.
if (!isset($content_width)) {
	$content_width = 640;
}

// default thumb size
set_post_thumbnail_size(100, 100, true);

// Thumbnail sizes
//add_image_size( 'custom-size', 100, 100, true );

add_filter( 'image_size_names_choose', 'bones_custom_image_sizes' );

function bones_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        //'bones-thumb-600' => __('600px by 150px', 'lillehummernl'),
        //'bones-thumb-300' => __('300px by 100px', 'lillehummernl')
    ));
}


/*********************
SCRIPTS & ENQUEUEING
*********************/

function bones_scripts_and_styles() {
	global $wp_styles;
	if (!is_admin()) {

		// remote libraries
		wp_deregister_script('jquery');
		wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js', array(), '', false );

		$environment = getenv("APPLICATION_ENV");
		if ($environment == "development") {
		    // local scripts
			wp_enqueue_script( 'app', get_stylesheet_directory_uri() . '/js' . '/app.js', array(), '', true );
			// register main stylesheet
			wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/css' . '/style.css', array(), '', 'all' );
		} else {
			// local scripts
			wp_enqueue_script( 'app', get_stylesheet_directory_uri() . '/js/app.js', array(), '', true );
			// register main stylesheet
			wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/css/style.css', array(), '', 'all' );
		}

    wp_deregister_script('wp-api');
    wp_enqueue_script( 'wp-api', plugins_url( 'rest-api/wp-api.min.js'), array(), '', true );

	}
}

/************* THEME CUSTOMIZE *********************/

/*
  A good tutorial for creating your own Sections, Controls and Settings:
  http://code.tutsplus.com/series/a-guide-to-the-wordpress-theme-customizer--wp-33722

  Good articles on modifying the default options:
  http://natko.com/changing-default-wordpress-theme-customization-api-sections/
  http://code.tutsplus.com/tutorials/digging-into-the-theme-customizer-components--wp-27162

  To do:
  - Create a js for the postmessage transport method
  - Create some sanitize functions to sanitize inputs
  - Create some boilerplate Sections, Controls and Settings
*/

function bones_theme_customizer($wp_customize) {
  // $wp_customize calls go here.
  //
  // Uncomment the below lines to remove the default customize sections

  // $wp_customize->remove_section('title_tagline');
  // $wp_customize->remove_section('colors');
  // $wp_customize->remove_section('background_image');
  // $wp_customize->remove_section('static_front_page');
  // $wp_customize->remove_section('nav');

  // Uncomment the below lines to remove the default controls
  // $wp_customize->remove_control('blogdescription');

  // Uncomment the following to change the default section titles
  // $wp_customize->get_section('colors')->title = __( 'Theme Colors' );
  // $wp_customize->get_section('background_image')->title = __( 'Images' );
}

add_action( 'customize_register', 'bones_theme_customizer' );

/************* ACTIVE SIDEBARS ********************/

function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar',
		'name' => __( 'Sidebar', 'lillehummernl' ),
		'description' => __( 'The primary sidebar.', 'lillehummernl' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
}

?>
