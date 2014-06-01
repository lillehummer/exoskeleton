<?php get_header(); ?>

	<div class="content">

		<div class="main clearfix" role="main">

			<?php while (have_posts()) : the_post(); ?>

				<?php get_template_part( 'post-formats/format', get_post_format() ); ?>

			<?php endwhile; ?>

		</div>

		<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>
