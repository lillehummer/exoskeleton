<?php get_header(); ?>

	<div class="content">

		<main class="main clearfix" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

			<?php while (have_posts()) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

				<header class="article-header">
					<h1 class="page-title"><?php the_title(); ?></h1>

					<p class="byline vcard">
						<?php printf( __( 'Posted <time class="updated" datetime="%1$s" itemprop="datePublished">%2$s</time> by <span class="author">%3$s</span>', 'lillehummernl' ), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), get_the_author_link( get_the_author_meta( 'ID' ) )); ?>
					</p>
				</header>

				<section class="entry-content clearfix" itemprop="articleBody">
					<?php the_content(); ?>
				</section>

				<footer class="article-footer">
					<p class="clearfix"><?php the_tags( '<span class="tags">' . __( 'Tags:', 'lillehummernl' ) . '</span> ', ', ', '' ); ?></p>
				</footer>

			</article>

			<?php endwhile; ?>

		</main>

		<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>
