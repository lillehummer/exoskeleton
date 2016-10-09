<?php
/**
 * Custom post type archive template.
 *
 * @link https://lillehummer.nl
 *
 * @package lillehummernl
 */

get_header(); ?>

<div class="content">

	<main class="main clearfix" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

		<h1 class="archive-title"><?php post_type_archive_title(); ?></h1>

		<?php while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">

			<header class="article-header">
				<h3 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>

				<p class="byline entry-meta vcard">
				<?php printf( esc_html__( 'Posted %1$s by %2$s', 'lillehummernl' ),
					'<time class="updated entry-time" datetime="' . get_the_time( 'Y-m-d' ) . '" itemprop="datePublished">' . get_the_time( get_option( 'date_format' ) ) . '</time>',
					'<span class="by">by</span> <span class="entry-author author" itemprop="author" itemscope itemptype="http://schema.org/Person">' . get_the_author_link( get_the_author_meta( 'ID' ) ) . '</span>'
				); ?>
				</p>

			</header>

			<section class="entry-content clearfix">
				<?php the_excerpt(); ?>
			</section>

		</article>

		<?php endwhile; ?>

		<?php the_posts_pagination(); ?>

	</main>

	<?php get_sidebar(); ?>

</div>

<?php get_footer();
