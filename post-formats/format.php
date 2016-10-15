<?php
/**
 * Post format template.
 *
 * @link https://lillehummer.nl
 *
 * @package hummer
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'article' ); ?> role="article" itemscope itemprop="blogPost" itemtype="http://schema.org/BlogPosting">

	<header class="article__header">

		<h1 class="article__title" itemprop="headline"><?php the_title(); ?></h1>

		<p class="entry-meta">

			<?php printf( __( 'Posted %1$s by %2$s', 'lillehummernl' ),
				'<time class="updated entry-time" datetime="' . get_the_time( 'Y-m-d' ) . '" itemprop="datePublished">' . get_the_time( get_option( 'date_format' ) ) . '</time>',
				'<span class="by">by</span> <span class="entry-author author" itemprop="author" itemscope itemptype="http://schema.org/Person">' . get_the_author_link( get_the_author_meta( 'ID' ) ) . '</span>'
			); ?>

		</p>

	</header>

	<section class="article__content clearfix" itemprop="articleBody">

		<?php the_content(); ?>

	</section>

</article>
