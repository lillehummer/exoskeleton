<?php get_header(); ?>

	<div id="content">

		<div id="inner-content" class="wrap clearfix">

			<div id="main" class="eightcol first clearfix" role="main">

				<h1 class="archive-title"><span><?php _e( 'Posts Categorized:', 'lillehummer' ); ?></span> <?php single_cat_title(); ?></h1>

				<?php while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">

					<header class="article-header">

						<h3 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
						<p class="byline vcard"><?php
							printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'lillehummer' ), get_the_time( 'Y-m-j' ), get_the_time( __( 'F jS, Y', 'lillehummer' )), bones_get_the_author_posts_link(), get_the_term_list( get_the_ID(), 'custom_cat', "" ) );
						?></p>

					</header>

					<section class="entry-content">
						<?php the_excerpt( '<span class="read-more">' . __( 'Read More &raquo;', 'lillehummer' ) . '</span>' ); ?>

					</section>

					<footer class="article-footer">

					</footer>

				</article>

				<?php endwhile; ?>

				<?php if ( function_exists( 'bones_page_navi' ) ) : bones_page_navi(); ?>

			</div>

			<?php get_sidebar(); ?>

		</div>

	</div>

<?php get_footer(); ?>
