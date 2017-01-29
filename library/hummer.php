<?php
/**
 * Exoskeleton utility functions.
 *
 * @category function library
 * @package lillehummernl
 * @author Lille Hummer
 */

/**
 * Remove inline gallery styles.
 *
 * @param string $css gallery content.
 */
function hummer_gallery_style( string $css ) {
	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}

/**
 * Theme support.
 */
function hummer_theme_support() {
	add_theme_support( 'soil-clean-up' );
	add_theme_support( 'soil-disable-asset-versioning' );
	add_theme_support( 'soil-disable-trackbacks' );
	add_theme_support( 'soil-js-to-footer' );
	add_theme_support( 'soil-nice-search' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );

	add_theme_support( 'title-tag' );

	add_theme_support( 'post-formats',
		array(
			'aside',
			'gallery',
			'link',
			'image',
			'quote',
			'status',
			'video',
			'audio',
			'chat',
		)
	);

	add_theme_support( 'menus' );
	register_nav_menus(
		array(
			'main-nav' => 'The Main Menu',
			'footer-links' => 'Footer Links',
		)
	);

	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	add_filter( 'xmlrpc_enabled', '__return_false' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
}

/**
 * Remove paragraph around images.
 *
 * @param string $content post content.
 */
function hummer_filter_ptags_on_images( $content ) {
	return preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );
}

/**
 * Modify excerpt length.
 *
 * @param  [type] $length Length.
 * @return [type]         [description]
 */
function hummer_excerpt_length( $length ) {
	return 25;
}
add_filter( 'excerpt_length', 'hummer_excerpt_length', 999 );

/**
 * Change excerpt end.
 *
 * @param string $more excerpt text.
 */
function hummer_excerpt_more( $more ) {
	global $post;
	return '...  <a href="'. get_permalink( $post->ID ) . '" title="' . get_the_title( $post->ID ).'">Read more</a>';
}

/**
 * Disable emojicons in TinyMCE.
 * @param  [type] $plugins [description]
 * @return [type]          [description]
 */
function hummer_disable_emojicons_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/**
 * Disable emojicons.
 *
 * @return [type] [description]
 */
function hummer_disable_wp_emojicons() {
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	add_filter( 'tiny_mce_plugins', 'hummer_disable_emojicons_tinymce' );
}
add_action( 'init', 'hummer_disable_wp_emojicons' );

/**
 * Remove comments from dashboard.
 */
function hummer_remove_menu_pages() {
	remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'hummer_remove_menu_pages' );

/**
 * Remove comments from posts and pages.
 *
 * @return [type] [description]
 */
function hummer_remove_comment_support() {
	remove_post_type_support( 'post', 'comments' );
	remove_post_type_support( 'page', 'comments' );
}
add_action( 'init', 'hummer_remove_comment_support', 100 );

/**
 * Remove comments from admin bar.
 *
 * @return [type] [description]
 */
function hummer_admin_bar_render() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'comments' );
}
add_action( 'wp_before_admin_bar_render', 'hummer_admin_bar_render' );

/**
 * Add excerpts to pages.
 *
 *
 * @return [type] [description]
 */
function hummer_add_page_excerpt() {
	add_post_type_support( 'page', array( 'excerpt' ) );
}
add_action( 'init', 'hummer_add_page_excerpt' );

/**
 * [hummer_remove_ver_css_js description]
 * @param  [type] $src [description]
 * @return [type]      [description]
 */
function hummer_remove_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}
add_filter( 'style_loader_src', 'hummer_remove_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'hummer_remove_ver_css_js', 9999 );
