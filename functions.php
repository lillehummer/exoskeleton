<?php

require_once( 'library/bones.php' );
require_once( 'library/custom-post-type.php' );
require_once( 'library/admin.php' );
require_once( 'library/activation.php' );

/************* AFTER THEME SETUP ******************/
function bones_ahoy() {

  // let's get language support going, if you need it
  load_theme_textdomain( 'lillehummernl', get_template_directory() . '/library/translation' );

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
add_action( 'after_switch_theme', 'bones_set_image_dimensions' );

// Flush your rewrite rules
function bones_set_image_dimensions() {
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

/************* AFTER THEME SETUP ******************/
function bones_after_setup_theme() {
	// Tell the TinyMCE editor to use a custom stylesheet
	add_editor_style('/assets/css/editor-style.css');
}

add_action( 'after_setup_theme', 'bones_after_setup_theme' );

/************* IMAGE/EMBED SIZE OPTIONS *************/

// Limit size of embeds.
if (!isset($content_width)) { $content_width = 640; }

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
		wp_enqueue_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', array(), '', false );
		wp_enqueue_script( 'html5shiv', '//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js', array(), '', false );

		// local scripts
		wp_enqueue_script( 'scripts', get_stylesheet_directory_uri() . '/js/scripts.min.js', array(), '', false );

		// register main stylesheet
		wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/css/style.css', array(), '', 'all' );

		// ie-only style sheet
		wp_enqueue_style( 'style-ie', get_stylesheet_directory_uri() . '/css/ie.css', array(), '' );
		$wp_styles->add_data( 'style-ie', 'conditional', 'lt IE 9' ); // add conditional wrapper around ie stylesheet

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

/************* SEARCH FORM LAYOUT *****************/

function bones_wpsearch($form) {
	$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	<label class="screen-reader-text" for="s">' . __( 'Search for:', 'lillehummernl' ) . '</label>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . esc_attr__( 'Search the Site...', 'lillehummernl' ) . '" />
	<input type="submit" id="searchsubmit" value="' . esc_attr__( 'Search' ) .'" />
	</form>';
	return $form;
}

/************* DISABLE PINGBACK *****************/
add_filter( 'xmlrpc_methods', 'remove_xmlrpc_pingback_ping' );
function remove_xmlrpc_pingback_ping( $methods ) {
   unset( $methods['pingback.ping'] );
   return $methods;
} ;

/************* CUSTOM GALLERY SIZE *****************/
remove_shortcode('gallery');
add_shortcode('gallery', 'custom_size_gallery');
 
function custom_size_gallery($attr) {
     $attr['size'] = 'medium';
     return gallery_shortcode($attr);
}

/************* OUTPUT HTML5 TAGS *****************/
function prefix_gallery_atts( $atts ) {
    $atts['itemtag']    = 'figure';
    $atts['icontag']    = 'div';
    $atts['captiontag'] = 'figcaption';
 
    return $atts;
}
add_filter( 'shortcode_atts_gallery', 'prefix_gallery_atts' );


?>
