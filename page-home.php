<?php
/*
Template Name: Home
*/
?>

<?php get_header(); ?>

	<div class="content">

		<div class="main clearfix" role="main">

			<?php while (have_posts()) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

				<header class="article-header">
					<h1 class="page-title"><?php the_title(); ?></h1>
				</header>

				<section class="entry-content clearfix" itemprop="articleBody">
					<?php the_content(); ?>
				</section>

				<footer class="article-footer">
					<p class="clearfix"><?php the_tags( '<span class="tags">' . __( 'Tags:', 'lillehummernl' ) . '</span> ', ', ', '' ); ?></p>
				</footer>

			</article>

			<?php endwhile; ?>

		</div>

		<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>
