<?php
/**
 * Lille Hummer File Doc Comment
 *
 * @category functions
 * @package lillehummernl
 * @author Lille Hummer
 */

?>

<?php
require_once( 'library/hummer.php' );
require_once( 'library/admin.php' );

/**
 * Setup theme.
 */
function hummer_ahoy() {

	add_editor_style( get_stylesheet_directory_uri() . '/library/css/editor-style.css' );

	load_theme_textdomain( 'lillehummernl', get_template_directory() . '/languages' );

	require_once( 'library/custom-post-type.php' );

	// Launching operation cleanup.
	add_filter( 'gallery_style', 'hummer_gallery_style' );
	add_filter( 'the_content', 'hummer_filter_ptags_on_images' );
	add_filter( 'excerpt_more', 'hummer_excerpt_more' );

	// Cleanup Gravity Forms.
	add_filter( 'gform_init_scripts_footer', '__return_true' );
	add_filter( 'gform_cdata_open', 'hummer_wrap_gform_cdata_open', 1 );
	add_filter( 'gform_cdata_close', 'hummer_wrap_gform_cdata_close', 99 );

	// Enqueue base scripts and styles.
	add_action( 'wp_enqueue_scripts', 'hummer_scripts_and_styles', 999 );

	// Launching this stuff after theme setup.
	hummer_theme_support();

	add_action( 'widgets_init', 'hummer_register_sidebars' );

}

add_action( 'after_setup_theme', 'hummer_ahoy' );

/**
 * Theme setup.
 */
function hummer_setup_theme() {
	update_option( 'image_default_link_type','none' );

	$catalog = array(
		'width' 	=> '100',
		'height'	=> '100',
		'crop'		=> 1,
	);

	$single = array(
		'width' 	=> '100',
		'height'	=> '100',
		'crop'		=> 1,
	);

	$thumbnail = array(
		'width' 	=> '100',
		'height'	=> '100',
		'crop'		=> 1,
	);

	update_option( 'shop_catalog_image_size', $catalog );
	update_option( 'shop_single_image_size', $single );
	update_option( 'shop_thumbnail_image_size', $thumbnail );

	update_option( 'thumbnail_size_w', 100 );
	update_option( 'thumbnail_size_h', 100 );
	update_option( 'thumbnail_crop', 1 );
	update_option( 'medium_size_w', 100 );
	update_option( 'medium_size_h', 100 );
	update_option( 'medium_crop', 1 );
	update_option( 'large_size_w', 100 );
	update_option( 'large_size_h', 100 );
	update_option( 'large_crop', 1 );
}
add_action( 'after_switch_theme', 'hummer_setup_theme' );

/**
 * Add image sizes.
 */
// add_image_size( 'custom-size', 100, 100, true );

/**
 * Register custom image sizes.
 *
 * @param array $sizes standard image sizes.
 */
function hummer_custom_image_sizes( array $sizes ) {
	return array_merge( $sizes, array(
		// 'custom-size' => __('Custom Size', 'lillehummernl')
	));
}
add_filter( 'image_size_names_choose', 'hummer_custom_image_sizes' );


/**
 * Register scripts.
 */
function hummer_scripts_and_styles() {
	global $wp_styles;
	if ( ! is_admin() ) {

		wp_dequeue_script( 'jquery' );
		wp_deregister_script( 'jquery' );

		if ( wp_script_is( 'wp-api', 'registered' ) ) {
			wp_deregister_script( 'wp-api' );
			wp_enqueue_script( 'wp-api', plugins_url( 'rest-api/wp-api.min.js' ), array(), '', true );
		}

		if ( ENVIRONMENT === 'development' ) {
			wp_enqueue_script( 'app', get_stylesheet_directory_uri() . '/js' . '/app.js', array(), '', true );
			wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/css' . '/style.css', array(), '', 'all' );
		} else {
			wp_enqueue_script( 'app', get_stylesheet_directory_uri() . '/js/app.js', array(), '', true );
			wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/css/style.css', array(), '', 'all' );
		}
	}
}

/**
 * Register sidebars.
 */
function hummer_register_sidebars() {
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
