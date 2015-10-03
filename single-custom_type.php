<?php get_header(); ?>

	<div class="content">

		<main class="main clearfix" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

			<?php while (have_posts()) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

				<header class="article-header">
					<h1 class="single-title custom-post-type-title"><?php the_title(); ?></h1>

					<p class="byline vcard"><?php
						printf( __( 'Posted <time class="updated" datetime="%1$s" itemprop="datePublished">%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'bonestheme' ), get_the_time( 'Y-m-j' ), get_the_time(get_option('date_format')), get_the_author_link( get_the_author_meta( 'ID' ) ), get_the_term_list( $post->ID, 'custom_cat', ' ', ', ', '' ) );
					?></p>
				</header>

				<section class="entry-content clearfix">
					<?php the_content(); ?>
				</section>

				<footer class="article-footer">
					<p class="tags"><?php echo get_the_term_list( get_the_ID(), 'custom_tag', '<span class="tags-title">' . __( 'Custom Tags:', 'lillehummernl' ) . '</span> ', ', ' ) ?></p>
				</footer>

			</article>

			<?php endwhile; ?>

		</main>

		<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>
