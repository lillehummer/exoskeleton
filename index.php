<?php
/**
 * Posts page template.
 *
 * @link https://lillehummer.nl
 *
 * @package lillehummernl
 */

get_header(); ?>

<div class="content">

	<main class="main clearfix" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

		<?php while ( have_posts() ) : the_post(); ?>

		<article <?php post_class( 'article-entry clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

			<header class="article-entry__header">
				<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>

				<p class="entry-meta">
					<?php printf( esc_html__( 'Posted %1$s by %2$s', 'lillehummernl' ),
						'<time class="updated entry-time" datetime="' . get_the_time( 'Y-m-d' ) . '" itemprop="datePublished">' . get_the_time( get_option( 'date_format' ) ) . '</time>',
						'<span class="by">by</span> <span class="entry-author author" itemprop="author" itemscope itemptype="http://schema.org/Person">' . get_the_author_link( get_the_author_meta( 'ID' ) ) . '</span>'
					); ?>
				</p>
			</header>

			<section class="article-entry__content clearfix">
				<?php the_content(); ?>
			</section>

		</article>

		<?php endwhile; ?>

		<?php the_posts_pagination(); ?>

	</main>

	<?php get_sidebar(); ?>

</div>

<?php get_footer();
