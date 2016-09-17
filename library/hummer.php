<?php
/**
 * Lille Hummer File Doc Comment
 *
 * @category function library
 * @package lillehummernl
 * @author Lille Hummer
 */

?>

<?php

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
}

/**
 * Custom page navigation.
 */
function hummer_page_navi() {
	global $wp_query;
	$bignum = 999999999;
	if ( $wp_query->max_num_pages <= 1 ) {
		return;
	}

	echo '<nav class="pagination">';

	echo paginate_links( array(
		'base' 			=> str_replace( $bignum, '%#%', esc_url( get_pagenum_link( $bignum ) ) ),
		'format' 		=> '',
		'current' 		=> max( 1, get_query_var( 'paged' ) ),
		'total' 		=> $wp_query->max_num_pages,
		'prev_text' 	=> '&larr;',
		'next_text' 	=> '&rarr;',
		'type'			=> 'list',
		'end_size'		=> 3,
		'mid_size'		=> 3,
	) );

	echo '</nav>';
}

/**
 * Remove paragraph around images.
 *
 * @param string $content post content.
 */
function hummer_filter_ptags_on_images( string $content ) {
	return preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );
}

/**
 * Change excerpt end.
 *
 * @param string $more excerpt text.
 */
function hummer_excerpt_more( string $more ) {
	global $post;
	return '...  <a href="'. get_permalink( $post->ID ) . '" title="' . get_the_title( $post->ID ).'">'. __( 'Read more', 'lillehummernl' ) .'</a>';
}

/**
 * Defer loading Gravity Forms scripts.
 *
 * @param string $content opening tag content.
 */
function hummer_wrap_gform_cdata_open( string $content = '' ) {
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
function hummer_wrap_gform_cdata_close( string $content = '' ) {
	if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || isset( $_POST['gform_ajax'] ) ) {
		return $content;
	}
	$content = ' }, false );';
	return $content;
}
