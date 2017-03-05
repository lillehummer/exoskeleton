<?php
/**
 * Exoskeleton cleanup functions.
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
 * Remove paragraph around images.
 *
 * @param string $content post content.
 */
function hummer_filter_ptags_on_images( $content ) {
  return preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );
}

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
 * [hummer_remove_ver_css_js description]
 * @param  [type] $src [description]
 * @return [type]      [description]
 */
function hummer_remove_ver_css_js( $src ) {
	return $src ? esc_url(remove_query_arg('ver', $src)) : false;
}
add_filter( 'style_loader_src', 'hummer_remove_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'hummer_remove_ver_css_js', 9999 );

/**
 * Disable pingback XMLRPC method
 */
function hummer_filter_xmlrpc_method($methods) {
  unset($methods['pingback.ping']);
  return $methods;
}
add_filter('xmlrpc_methods', 'hummer_filter_xmlrpc_method', 10, 1);

/**
 * Remove pingback header
 */
function hummer_filter_headers($headers) {
  if (isset($headers['X-Pingback'])) {
    unset($headers['X-Pingback']);
  }
  return $headers;
}
add_filter('wp_headers', 'hummer_filter_headers', 10, 1);

/**
 * Kill trackback rewrite rule
 */
function hummer_filter_rewrites($rules) {
  foreach ($rules as $rule => $rewrite) {
    if (preg_match('/trackback\/\?\$$/i', $rule)) {
      unset($rules[$rule]);
    }
  }
  return $rules;
}
add_filter('rewrite_rules_array', 'hummer_filter_rewrites');

/**
 * Kill bloginfo('pingback_url')
 */
function hummer_kill_pingback_url($output, $show) {
  if ($show === 'pingback_url') {
    $output = '';
  }
  return $output;
}
add_filter('bloginfo_url', 'hummer_kill_pingback_url', 10, 2);

/**
 * Disable XMLRPC call
 */
function hummer_kill_xmlrpc($action) {
  if ($action === 'pingback.ping') {
    wp_die('Pingbacks are not supported', 'Not Allowed!', ['response' => 403]);
  }
}
add_action('xmlrpc_call', 'hummer_kill_xmlrpc');

/**
 * Clean up wp_head()
 *
 * Remove unnecessary <link>'s
 * Remove inline CSS and JS from WP emoji support
 * Remove inline CSS used by Recent Comments widget
 * Remove inline CSS used by posts with galleries
 * Remove self-closing tag
 *
 * You can enable/disable this feature in functions.php (or lib/setup.php if you're using Sage):
 * add_theme_support('soil-clean-up');
 */
function hummer_head_cleanup() {
  // Originally from http://wpengineer.com/1438/wordpress-header/
  remove_action('wp_head', 'feed_links_extra', 3);
  add_action('wp_head', 'ob_start', 1, 0);
  add_action('wp_head', function () {
    $pattern = '/.*' . preg_quote(esc_url(get_feed_link('comments_' . get_default_feed())), '/') . '.*[\r\n]+/';
    echo preg_replace($pattern, '', ob_get_clean());
  }, 3, 0);
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
  remove_action('wp_head', 'wp_generator');
  remove_action('wp_head', 'wp_shortlink_wp_head', 10);
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_action('admin_print_styles', 'print_emoji_styles');
  remove_action('wp_head', 'wp_oembed_add_discovery_links');
  remove_action('wp_head', 'wp_oembed_add_host_js');
  remove_action('wp_head', 'rest_output_link_wp_head', 10);
  remove_filter('the_content_feed', 'wp_staticize_emoji');
  remove_filter('comment_text_rss', 'wp_staticize_emoji');
  remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
  add_filter('use_default_gallery_style', '__return_false');
  add_filter('emoji_svg_url', '__return_false');
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', [$wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style']);
  }
}
add_action('init', 'hummer_head_cleanup');

/**
 * Remove the WordPress version from RSS feeds
 */
add_filter('the_generator', '__return_false');

/**
 * Clean up language_attributes() used in <html> tag
 *
 * Remove dir="ltr"
 */
function hummer_language_attributes() {
  $attributes = [];
  if (is_rtl()) {
    $attributes[] = 'dir="rtl"';
  }
  $lang = get_bloginfo('language');
  if ($lang) {
    $attributes[] = "lang=\"$lang\"";
  }
  $output = implode(' ', $attributes);
  $output = apply_filters('soil/language_attributes', $output);
  return $output;
}
add_filter('language_attributes', 'hummer_language_attributes');

/**
 * Clean up output of stylesheet <link> tags
 */
function hummer_clean_style_tag($input) {
  preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches);
  if (empty($matches[2])) {
    return $input;
  }
  // Only display media if it is meaningful
  $media = $matches[3][0] !== '' && $matches[3][0] !== 'all' ? ' media="' . $matches[3][0] . '"' : '';
  return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
}
add_filter('style_loader_tag', 'hummer_clean_style_tag');

/**
 * Clean up output of <script> tags
 */
function hummer_clean_script_tag($input) {
  $input = str_replace("type='text/javascript' ", '', $input);
  return str_replace("'", '"', $input);
}
add_filter('script_loader_tag', 'hummer_clean_script_tag');

/**
 * Add and remove body_class() classes
 */
function hummer_body_class($classes) {
  // Add post/page slug if not present
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }
  // Remove unnecessary classes
  $home_id_class = 'page-id-' . get_option('page_on_front');
  $remove_classes = [
    'page-template-default',
    $home_id_class
  ];
  $classes = array_diff($classes, $remove_classes);
  return $classes;
}
add_filter('body_class', 'hummer_body_class');

/**
 * Wrap embedded media as suggested by Readability
 *
 * @link https://gist.github.com/965956
 * @link http://www.readability.com/publishers/guidelines#publisher
 */
function hummer_embed_wrap($cache) {
  return '<div class="entry-content-asset">' . $cache . '</div>';
}
add_filter('embed_oembed_html', 'hummer_embed_wrap');

/**
 * Remove unnecessary dashboard widgets
 *
 * @link http://www.deluxeblogtips.com/2011/01/remove-dashboard-widgets-in-wordpress.html
 */
function hummer_remove_dashboard_widgets() {
  remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
  remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
  remove_meta_box('dashboard_primary', 'dashboard', 'normal');
  remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
}
add_action('admin_init', 'hummer_remove_dashboard_widgets');

/**
 * Remove unnecessary self-closing tags
 */
function hummer_remove_self_closing_tags($input) {
  return str_replace(' />', '>', $input);
}
add_filter('get_avatar', 'hummer_remove_self_closing_tags'); // <img />
add_filter('comment_id_fields', 'hummer_remove_self_closing_tags'); // <input />
add_filter('post_thumbnail_html', 'hummer_remove_self_closing_tags'); // <img />

/**
 * Don't return the default description in the RSS feed if it hasn't been changed
 */
function hummer_remove_default_description($bloginfo) {
  $default_tagline = 'Just another WordPress site';
  return ($bloginfo === $default_tagline) ? '' : $bloginfo;
}
add_filter('get_bloginfo_rss', 'hummer_remove_default_description');
