<?php get_header(); ?>

	<div class="content">

		<main class="main clearfix" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'post-formats/format', get_post_format() ); ?>

			<?php endwhile; ?>

		</main>

		<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>
