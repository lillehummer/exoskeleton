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
			'main-nav' => __( 'The Main Menu', 'lillehummernl' ),
			'footer-links' => __( 'Footer Links', 'lillehummernl' ),
		)
	);

	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
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
 * Change excerpt end.
 *
 * @param string $more excerpt text.
 */
function hummer_excerpt_more( $more ) {
	global $post;
	return '...  <a href="'. get_permalink( $post->ID ) . '" title="' . get_the_title( $post->ID ).'">'. __( 'Read more', 'lillehummernl' ) .'</a>';
}

/**
 * Defer loading Gravity Forms scripts.
 *
 * @param string $content opening tag content.
 */
function hummer_wrap_gform_cdata_open( $content = '' ) {
	if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || isset( $_POST['gform_ajax'] ) ) {
		return $content;
	}
	$content = 'document.addEventListener( "DOMContentLoaded", function() { ';
	return $content;
}

/**
 * Defer loading Gravity Forms scripts.
 *
 * @param string $content closing tag content.
 */
function hummer_wrap_gform_cdata_close( $content = '' ) {
	if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || isset( $_POST['gform_ajax'] ) ) {
		return $content;
	}
	$content = ' }, false );';
	return $content;
}
