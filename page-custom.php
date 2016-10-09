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

	<main class="main clearfix" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

		<?php while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

			<header class="article-header">
				<h1 class="page-title"><?php the_title(); ?></h1>
			</header>

			<section class="entry-content clearfix" itemprop="articleBody">
				<?php the_content(); ?>
			</section>

			<footer class="article-footer">
			</footer>

		</article>

		<?php endwhile; ?>

	</main>

	<?php get_sidebar(); ?>

</div>

<?php get_footer();
