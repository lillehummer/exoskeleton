<?php
/**
 * Single custom post template.
 *
 * @link https://lillehummer.nl
 *
 * @package lillehummernl
 */

get_header(); ?>

<div class="content">

	<main class="main clearfix" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

		<?php while ( have_posts() ) : the_post(); ?>

		<article <?php post_class( 'article clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

			<header class="article__header">
				<h1><?php the_title(); ?></h1>
			</header>

			<section class="article__content clearfix">
				<?php the_content(); ?>
			</section>

		</article>

		<?php endwhile; ?>

	</main>

	<?php get_sidebar(); ?>

</div>

<?php get_footer();
