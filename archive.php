<?php get_header(); ?>

	<div id="content">

		<div id="inner-content" class="wrap clearfix">

			<div id="main" class="eightcol first clearfix" role="main">

				<?php if (is_category()) { ?>
					<h1 class="archive-title h2">
						<span><?php _e( 'Posts Categorized:', 'lillehummer' ); ?></span> <?php single_cat_title(); ?>
					</h1>

				<?php } elseif (is_tag()) { ?>
					<h1 class="archive-title h2">
						<span><?php _e( 'Posts Tagged:', 'lillehummer' ); ?></span> <?php single_tag_title(); ?>
					</h1>

				<?php } elseif (is_author()) {
					global $post;
					$author_id = $post->post_author;
				?>
					<h1 class="archive-title h2">

						<span><?php _e( 'Posts By:', 'lillehummer' ); ?></span> <?php the_author_meta('display_name', $author_id); ?>

					</h1>
				<?php } elseif (is_day()) { ?>
					<h1 class="archive-title h2">
						<span><?php _e( 'Daily Archives:', 'lillehummer' ); ?></span> <?php the_time('l, F j, Y'); ?>
					</h1>

				<?php } elseif (is_month()) { ?>
						<h1 class="archive-title h2">
							<span><?php _e( 'Monthly Archives:', 'lillehummer' ); ?></span> <?php the_time('F Y'); ?>
						</h1>

				<?php } elseif (is_year()) { ?>
						<h1 class="archive-title h2">
							<span><?php _e( 'Yearly Archives:', 'lillehummer' ); ?></span> <?php the_time('Y'); ?>
						</h1>
				<?php } ?>

				<?php while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">

					<header class="article-header">
						<h3 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
						<p class="byline vcard"><?php
							printf(__( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'lillehummer' ), get_the_time('Y-m-j'), get_the_time(__( 'F jS, Y', 'lillehummer' )), bones_get_the_author_posts_link(), get_the_category_list(', '));
						?></p>
					</header>

					<section class="entry-content clearfix">
						<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
						<?php the_excerpt(); ?>
					</section>

				</article>

				<?php endwhile; ?>

				<?php if ( function_exists( 'bones_page_navi' ) ) : bones_page_navi(); ?>

			</div>

			<?php get_sidebar(); ?>

		</div>

	</div>

<?php get_footer(); ?>
