<?php
/**
 * Sabi utility functions.
 *
 * @category function library
 * @package lillehummernl
 * @author Lille Hummer
 */

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
 * Add excerpts to pages.
 *
 *
 * @return [type] [description]
 */
function hummer_add_page_excerpt() {
	add_post_type_support( 'page', array( 'excerpt' ) );
}
add_action( 'init', 'hummer_add_page_excerpt' );
