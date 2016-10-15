<?php
/**
 * Footer template.
 *
 * @link https://lillehummer.nl
 *
 * @package lillehummernl
 */

?>

	<footer class="footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">

		<div class="footer__inner clearfix">

			<nav role="navigation navigation--footer" class="footer-links">
				<?php
				wp_nav_menu(array(
					'container' => false,
					'theme_location' => 'footer-links',
					'depth' => 0,
				));
				?>
			</nav>

			<p class="footer__copyright">&copy; <?php echo esc_url( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.</p>

		</div>

	</footer>

</div>

<?php wp_footer(); ?>

</body>

</html>
