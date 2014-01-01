<?php get_header(); ?>

	<div id="content">

		<div id="inner-content" class="wrap clearfix">

			<div id="main" class="eightcol first clearfix" role="main">

				<h1 class="archive-title"><span><?php _e( 'Posts Categorized:', 'lillehummer' ); ?></span> <?php single_cat_title(); ?></h1>

				<?php while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">

						<header class="article-header">
							<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
						</header>

						<section class="entry-content">
							<?php the_excerpt( '<span class="read-more">' . __( 'Read More &raquo;', 'lillehummer' ) . '</span>' ); ?>
						</section>

					</article>

				<?php endwhile; ?>

				<?php if ( function_exists( 'bones_page_navi' ) ) : bones_page_navi(); ?>

			</div>

			<?php get_sidebar(); ?>

		</div>

	</div>

<?php get_footer(); ?>
