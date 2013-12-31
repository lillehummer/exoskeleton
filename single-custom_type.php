<?php get_header(); ?>

	<div id="content">

		<div id="inner-content" class="wrap clearfix">

			<div id="main" class="eightcol first clearfix" role="main">

				<?php while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

						<header class="article-header">
							<h1 class="single-title custom-post-type-title"><?php the_title(); ?></h1>
							<p class="byline vcard"><?php
								printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'lillehummer' ), get_the_time( 'Y-m-j' ), get_the_time( __( 'F jS, Y', 'lillehummer' ) ), bones_get_the_author_posts_link(), get_the_term_list( $post->ID, 'custom_cat', ' ', ', ', '' ) );
							?></p>
						</header>

						<section class="entry-content clearfix">
							<?php the_content(); ?>
						</section>

						<footer class="article-footer">
							<p class="tags"><?php echo get_the_term_list( get_the_ID(), 'custom_tag', '<span class="tags-title">' . __( 'Custom Tags:', 'lillehummer' ) . '</span> ', ', ' ) ?></p>
						</footer>

					</article>

				<?php endwhile; ?>

			</div>

			<?php get_sidebar(); ?>

		</div>

	</div>

<?php get_footer(); ?>
