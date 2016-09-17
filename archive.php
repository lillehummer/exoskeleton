<?php get_header(); ?>

	<div id="content">

		<div id="inner-content" class="wrap clearfix">

			<main class="main clearfix" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

				<?php if ( is_category() ) { ?>
					<h1 class="archive-title h2">
						<span><?php _e( 'Posts Categorized:', 'lillehummernl' ); ?></span> <?php single_cat_title(); ?>
					</h1>

				<?php } elseif ( is_tag() ) { ?>
					<h1 class="archive-title h2">
						<span><?php _e( 'Posts Tagged:', 'lillehummernl' ); ?></span> <?php single_tag_title(); ?>
					</h1>

				<?php } elseif ( is_author() ) {
					global $post;
					$author_id = $post->post_author;
				?>
					<h1 class="archive-title h2">

						<span><?php _e( 'Posts By:', 'lillehummernl' ); ?></span> <?php the_author_meta( 'display_name', $author_id ); ?>

					</h1>
				<?php } elseif ( is_day() ) { ?>
					<h1 class="archive-title h2">
						<span><?php _e( 'Daily Archives:', 'lillehummernl' ); ?></span> <?php the_time( 'l, F j, Y' ); ?>
					</h1>

				<?php } elseif ( is_month() ) { ?>
						<h1 class="archive-title h2">
							<span><?php _e( 'Monthly Archives:', 'lillehummernl' ); ?></span> <?php the_time( 'F Y' ); ?>
						</h1>

				<?php } elseif ( is_year() ) { ?>
						<h1 class="archive-title h2">
							<span><?php _e( 'Yearly Archives:', 'lillehummernl' ); ?></span> <?php the_time( 'Y' ); ?>
						</h1>
				<?php } ?>

				<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">

					<header class="article-header">
						<h3 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>

						<p class="byline entry-meta vcard">
							<?php printf( __( 'Posted %1$s by %2$s', 'lillehummernl' ),
								/* the time the post was published */
								'<time class="updated entry-time" datetime="' . get_the_time( 'Y-m-d' ) . '" itemprop="datePublished">' . get_the_time( get_option( 'date_format' ) ) . '</time>',
								/* the author of the post */
								'<span class="by">by</span> <span class="entry-author author" itemprop="author" itemscope itemptype="http://schema.org/Person">' . get_the_author_link( get_the_author_meta( 'ID' ) ) . '</span>'
							); ?>
						</p>
					</header>

					<section class="entry-content clearfix">
						<?php the_post_thumbnail(); ?>
						<?php the_excerpt(); ?>
					</section>

				</article>

				<?php endwhile; ?>

				<?php if ( function_exists( 'hummer_page_navi' ) ) {
					hummer_page_navi();
				} ?>

			</main>

			<?php get_sidebar(); ?>

		</div>

	</div>

<?php get_footer(); ?>
