<?php
/*
Template Name: Custom Page
*/
?>

<?php get_header(); ?>

	<div id="content">

		<div id="inner-content" class="wrap clearfix">

			<div id="main" class="eightcol first clearfix" role="main">

				<?php while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

					<header class="article-header">
						<h1 class="page-title"><?php the_title(); ?></h1>
						<p class="byline vcard"><?php
							printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span>.', 'lillehummer' ), get_the_time( 'Y-m-j' ), get_the_time( __( 'F jS, Y', 'lillehummer' ) ), bones_get_the_author_posts_link() );
						?></p>
					</header>

					<section class="entry-content clearfix" itemprop="articleBody">
						<?php the_content(); ?>
					</section>

					<footer class="article-footer">
						<p class="clearfix"><?php the_tags( '<span class="tags">' . __( 'Tags:', 'lillehummer' ) . '</span> ', ', ', '' ); ?></p>
					</footer>

				</article>

				<?php endwhile; ?>

			</div>

			<?php get_sidebar(); ?>

		</div>

	</div>

<?php get_footer(); ?>
