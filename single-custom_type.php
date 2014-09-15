<?php get_header(); ?>

	<div class="content">

		<div class="main clearfix" role="main">

			<?php while (have_posts()) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

				<header class="article-header">
					<h1 class="single-title custom-post-type-title"><?php the_title(); ?></h1>
				</header>

				<section class="entry-content clearfix">
					<?php the_content(); ?>
				</section>

				<footer class="article-footer">
					<p class="tags"><?php echo get_the_term_list( get_the_ID(), 'custom_tag', '<span class="tags-title">' . __( 'Custom Tags:', 'lillehummernl' ) . '</span> ', ', ' ) ?></p>
				</footer>

			</article>

			<?php endwhile; ?>

		</div>

		<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>
