<?php
/**
 * Lille Hummer File Doc Comment
 *
 * @category admin
 * @package lillehummernl
 * @author Lille Hummer
 */

/**
 * Disable default dashboard widgets.
 */
function hummer_disable_default_dashboard_widgets() {
	global $wp_meta_boxes;

	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'] );

	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts'] );
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'] );

}
add_action( 'admin_menu', 'hummer_disable_default_dashboard_widgets' );

/**
 * Hide update notice from regular users.
 */
function hummer_hide_update_notice() {
	if ( ! current_user_can( 'update_core' ) ) {
		remove_action( 'admin_notices', 'update_nag', 3 );
	}
}
add_action( 'admin_head', 'hummer_hide_update_notice', 1 );

/**
 * Lille Hummer dashboard feed.
 */
function hummer_rss_dashboard_widget() {
	if ( function_exists( 'fetch_feed' ) ) {
		include_once( ABSPATH . WPINC . '/feed.php' );
		$feed = fetch_feed( 'http://lillehummer.nl/feed/rss/' );
		$limit = $feed->get_item_quantity( 7 );
		$items = $feed->get_items( 0, $limit );
	}

	if ( $limit === 0 ) {
		echo '<div>The RSS Feed is either empty or unavailable.</div>';
	} else {
		foreach ( $items as $item ) {
	?>
	<h4 style="margin-bottom: 0;">
		<a href="<?php echo $item->get_permalink(); ?>" title="<?php echo mysql2date( __( 'j F Y @ g:i a', 'lillehummernl' ), $item->get_date( 'Y-m-d H:i:s' ) ); ?>" target="_blank">
			<?php echo $item->get_title(); ?>
		</a>
	</h4>
	<p style="margin-top: 0.5em;">
		<?php echo substr($item->get_description(), 0, 200); ?>
	</p>
	<?php
		}
	}
}

/**
 * Add custom dashboard widgets.
 */
function hummer_custom_dashboard_widgets() {
	wp_add_dashboard_widget( 'hummer_rss_dashboard_widget', __( 'News from Lille Hummer', 'lillehummernl' ), 'hummer_rss_dashboard_widget' );
}
add_action( 'wp_dashboard_setup', 'hummer_custom_dashboard_widgets' );

/**
 * Enqueue login styles.
 */
function hummer_login_css() {
	wp_enqueue_style( 'hummer_login_css', get_template_directory_uri() . '/css/login.css', false );
}
add_action( 'login_enqueue_scripts', 'hummer_login_css', 10 );

/**
 * Change login logo URL.
 */
function hummer_login_url() {
	return home_url();
}
add_filter( 'login_headerurl', 'hummer_login_url' );

/**
 * Change login title.
 */
function hummer_login_title() {
	return get_option( 'blogname' );
}
add_filter( 'login_headertitle', 'hummer_login_title' );

/**
 * Change admin footer.
 */
function hummer_custom_admin_footer() {
	_e( '<span id="footer-thankyou">Developed by <a href="http://lillehummer.nl" target="_blank">Lille Hummer</a></span>.', 'lillehummernl' );
}
add_filter( 'admin_footer_text', 'hummer_custom_admin_footer' );
