	<footer class="footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">

		<div class="footer-inner clearfix">

			<nav role="navigation" class="footer-links">
				<?php
				wp_nav_menu(array(
					'container' => '',
					'container_class' => '',
					'menu' => __( 'Footer Links', 'lillehummernl' ),
					'menu_class' => '',
					'theme_location' => 'footer-links',
					'before' => '',
					'after' => '',
					'link_before' => '',
					'link_after' => '',
					'depth' => 0
				));
				?>
			</nav>

			<p class="source-org copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>.</p>

		</div>

	</footer>

</div>

<?php wp_footer(); ?>

</body>

</html>
