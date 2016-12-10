<?php
/**
 * Custom taxonomy template.
 *
 * @link https://lillehummer.nl
 *
 * @package lillehummernl
 */

get_header(); ?>

<div class="content">

	<main class="main archive clearfix" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

		<h1 class="archive__title"><?php single_cat_title(); ?></h1>

		<?php while ( have_posts() ) : the_post(); ?>

			<article <?php post_class( 'article-entry clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

				<header class="article-entry__header">
					<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
					<p class="entry-meta"><?php
						printf( __( 'Posted <time class="updated" datetime="%1$s" itemprop="datePublished">%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'lillehummernl' ), get_the_time( 'Y-m-j' ), get_the_time( __( 'F jS, Y', 'lillehummernl' ) ), hummer_get_the_author_posts_link(), get_the_term_list( get_the_ID(), 'custom_cat', "", ", ", "" ) );
					?></p>
				</header>

				<section class="article-entry__content">
					<?php the_excerpt(); ?>
				</section>

			</article>

		<?php endwhile; ?>

		<?php the_posts_pagination(); ?>

	</main>

	<?php get_sidebar(); ?>

</div>

<?php get_footer();
