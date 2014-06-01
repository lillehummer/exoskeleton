<?php get_header(); ?>

	<div class="content">

		<div class="main clearfix" role="main">

			<h1 class="archive-title"><?php post_type_archive_title(); ?></h1>

				<?php while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">

					<header class="article-header">
						<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
					</header>

					<section class="entry-content clearfix">
						<?php the_excerpt(); ?>
					</section>

				</article>

				<?php endwhile; ?>

				<?php if ( function_exists( 'bones_page_navi' ) ) bones_page_navi(); ?>

		</div>

		<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>
