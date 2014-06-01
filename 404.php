<?php get_header(); ?>

	<div class="content">

		<div class="main clearfix" role="main">

			<article id="post-not-found" class="hentry clearfix">

				<header class="article-header">
					<h1><?php _e( 'Epic 404 - Article Not Found', 'lillehummer' ); ?></h1>
				</header>

				<section class="entry-content">
					<p><?php _e( 'The article you were looking for was not found, but maybe try looking again!', 'lillehummer' ); ?></p>
				</section>

				<section class="search">
					<p><?php get_search_form(); ?></p>
				</section>

			</article>

		</div>

	</div>

<?php get_footer(); ?>
