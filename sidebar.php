<?php
/**
 * Sidebar template.
 *
 * @link https://lillehummer.nl
 *
 * @package lillehummernl
 */

if ( ! is_active_sidebar( 'sidebar' ) ) {
	return;
}
?>

<div class="sidebar clearfix" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">

	<?php if ( is_active_sidebar( 'sidebar' ) ) :
		dynamic_sidebar( 'sidebar' );
	endif; ?>

</div>
