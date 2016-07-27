<?php

function bones_head_cleanup() {
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	remove_action( 'wp_head', 'wp_generator' );
	add_filter( 'style_loader_src', 'bones_remove_wp_ver_css_js', 9999 );
	add_filter( 'script_loader_src', 'bones_remove_wp_ver_css_js', 9999 );

}

// remove WP version from RSS
function bones_rss_version() { return ''; }

// remove WP version from scripts
function bones_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}

// remove injected CSS for recent comments widget
function bones_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}

// remove injected CSS from recent comments widget
function bones_remove_recent_comments_style() {
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
	}
}

// remove injected CSS from gallery
function bones_gallery_style($css) {
	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}

/*********************
THEME SUPPORT
*********************/
function bones_theme_support() {

	// roots/soil
	add_theme_support('soil-clean-up');
	add_theme_support('soil-disable-asset-versioning');
	add_theme_support('soil-disable-trackbacks');
	add_theme_support('soil-jquery-cdn');
	add_theme_support('soil-js-to-footer');
	add_theme_support('soil-nav-walker');
	add_theme_support('soil-nice-search');
	add_theme_support('soil-relative-urls');

	add_theme_support('automatic-feed-links');

	add_theme_support('post-thumbnails');

	// adding post format support
	add_theme_support( 'post-formats',
		array(
			'aside',             // title less blurb
			'gallery',           // gallery of images
			'link',              // quick link to other site
			'image',             // an image
			'quote',             // a quick quote
			'status',            // a Facebook like status update
			'video',             // video
			'audio',             // audio
			'chat'               // chat transcript
		)
	);

	// wp menus
	add_theme_support( 'menus' );
	register_nav_menus(
		array(
			'main-nav' => __( 'The Main Menu', 'lillehummernl' ),   // main nav in header
			'footer-links' => __( 'Footer Links', 'lillehummernl' ) // secondary nav in footer
		)
	);
}

/*********************
PAGE NAVI
*********************/

function bones_page_navi() {
	global $wp_query;
	$bignum = 999999999;
	if ( $wp_query->max_num_pages <= 1 )
		return;

	echo '<nav class="pagination">';

		echo paginate_links( array(
			'base' 			=> str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
			'format' 		=> '',
			'current' 		=> max( 1, get_query_var('paged') ),
			'total' 		=> $wp_query->max_num_pages,
			'prev_text' 	=> '&larr;',
			'next_text' 	=> '&rarr;',
			'type'			=> 'list',
			'end_size'		=> 3,
			'mid_size'		=> 3
		) );

	echo '</nav>';
}

/*********************
RANDOM CLEANUP ITEMS
*********************/

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function bones_filter_ptags_on_images($content){
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// This removes the annoying […] to a Read More link
function bones_excerpt_more($more) {
	global $post;
	// edit here if you like
	return '...  <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '" title="'. __( 'Read', 'lillehummernl' ) . get_the_title($post->ID).'">'. __( 'Read more &raquo;', 'lillehummernl' ) .'</a>';
}

// Gravity Forms to footer
add_filter( ‘gform_init_scripts_footer’, ‘__return_true’ );

add_filter( ‘gform_cdata_open’, ‘bones_wrap_gform_cdata_open’, 1 );
function bones_wrap_gform_cdata_open( $content = ” ) {
	if ( ( defined(‘DOING_AJAX’) && DOING_AJAX ) || isset( $_POST[‘gform_ajax’] ) ) {
		return $content;
	}
	$content = ‘document.addEventListener( “DOMContentLoaded”, function() { ‘;
	return $content;
}

add_filter( ‘gform_cdata_close’, ‘bones_wrap_gform_cdata_close’, 99 );
function bones_wrap_gform_cdata_close( $content = ” ) {
	if ( ( defined(‘DOING_AJAX’) && DOING_AJAX ) || isset( $_POST[‘gform_ajax’] ) ) {
		return $content;
	}
	$content = ‘ }, false );’;
	return $content;
}

?>
