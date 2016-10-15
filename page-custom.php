<?php
/**
 * Custom page template.
 *
 * @link https://lillehummer.nl
 *
 * @package lillehummernl
 */

/*
Template Name: Custom Page
*/

get_header(); ?>

<div class="content">

	<main class="main clearfix" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/WebPage">

		<?php while ( have_posts() ) : the_post(); ?>

		<article <?php post_class( 'article clearfix' ); ?>>

			<header class="article__header">
				<h1 itemprop="headline"><?php the_title(); ?></h1>
			</header>

			<section class="article__content clearfix" itemprop="articleBody">
				<?php the_content(); ?>
			</section>

			<footer class="article__footer">
			</footer>

		</article>

		<?php endwhile; ?>

	</main>

	<?php get_sidebar(); ?>

</div>

<?php get_footer();
