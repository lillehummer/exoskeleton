<?php

require_once( 'library/bones.php' );
require_once( 'library/admin.php' );

/************* AFTER THEME SETUP ******************/
function bones_ahoy() {

  add_editor_style( get_stylesheet_directory_uri() . '/library/css/editor-style.css' );

	load_theme_textdomain( 'lillehummernl', get_template_directory() . '/languages' );

  require_once( 'library/custom-post-type.php' );

	// launching operation cleanup
	add_action( 'init', 'bones_head_cleanup' );
	add_filter( 'the_generator', 'bones_rss_version' );
	add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
	add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
	add_filter( 'gallery_style', 'bones_gallery_style' );

	// enqueue base scripts and styles
	add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );

	// launching this stuff after theme setup
	bones_theme_support();
	add_action( 'widgets_init', 'bones_register_sidebars' );

	add_filter( 'the_content', 'bones_filter_ptags_on_images' );
	add_filter( 'excerpt_more', 'bones_excerpt_more' );

}

add_action( 'after_setup_theme', 'bones_ahoy' );

/************* AFTER SWITCH THEME ******************/
add_action( 'after_switch_theme', 'bones_setup_theme' );

function bones_setup_theme() {
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
