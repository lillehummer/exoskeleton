<?php

require_once( 'library/bones.php' );
require_once( 'library/custom-post-type.php' );
require_once( 'library/admin.php' );

/************* AFTER THEME SETUP ******************/
function bones_after_setup_theme() {
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

add_action( 'after_setup_theme', 'bones_after_setup_theme' );

/************* THUMBNAIL SIZE OPTIONS *************/

// default thumb size
set_post_thumbnail_size(100, 100, true);

// Thumbnail sizes
//add_image_size( 'custom-size', 100, 100, true );

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
		wp_enqueue_script( 'plugins', get_stylesheet_directory_uri() . '/js/plugins.min.js', array(), '', false );
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
		'name' => __( 'Sidebar', 'lillehummer' ),
		'description' => __( 'The primary sidebar.', 'lillehummer' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
}

/************* SEARCH FORM LAYOUT *****************/

function bones_wpsearch($form) {
	$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	<label class="screen-reader-text" for="s">' . __( 'Search for:', 'lillehummer' ) . '</label>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . esc_attr__( 'Search the Site...', 'lillehummer' ) . '" />
	<input type="submit" id="searchsubmit" value="' . esc_attr__( 'Search' ) .'" />
	</form>';
	return $form;
}


?>
