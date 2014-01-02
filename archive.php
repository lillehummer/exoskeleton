<?php get_header(); ?>

	<div id="content">

		<div id="inner-content" class="wrap clearfix">

			<div id="main" class="eightcol first clearfix" role="main">

				<h1 class="archive-title">
					<?php
						if ( is_category() ) :
							single_cat_title();

						elseif ( is_tag() ) :
							single_tag_title();

						elseif ( is_author() ) :
							printf( __( 'Author: %s', 'lillehummer' ), '<span class="vcard">' . get_the_author() . '</span>' );

						elseif ( is_day() ) :
							printf( __( 'Day: %s', 'lillehummer' ), '<span>' . get_the_date() . '</span>' );

						elseif ( is_month() ) :
							printf( __( 'Month: %s', 'lillehummer' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'lillehummer' ) ) . '</span>' );

						elseif ( is_year() ) :
							printf( __( 'Year: %s', 'lillehummer' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'lillehummer' ) ) . '</span>' );

						elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
							_e( 'Asides', 'lillehummer' );

						elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
							_e( 'Galleries', 'lillehummer');

						elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
							_e( 'Images', 'lillehummer');

						elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
							_e( 'Videos', 'lillehummer' );

						elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
							_e( 'Quotes', 'lillehummer' );

						elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
							_e( 'Links', 'lillehummer' );

						elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
							_e( 'Statuses', 'lillehummer' );

						elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
							_e( 'Audios', 'lillehummer' );

						elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
							_e( 'Chats', 'lillehummer' );

						else :
							_e( 'Archives', 'lillehummer' );

						endif;
					?>
				</h1>
				<?php
					// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						printf( '<div class="taxonomy-description">%s</div>', $term_description );
					endif;
				?>

				<?php while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">

					<header class="article-header">
						<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
					</header>

					<section class="entry-content clearfix">
						<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
						<?php the_excerpt(); ?>
					</section>

				</article>

				<?php endwhile; ?>

				<?php if ( function_exists( 'bones_page_navi' ) ) bones_page_navi(); ?>

			</div>

			<?php get_sidebar(); ?>

		</div>

	</div>

<?php get_footer(); ?>
