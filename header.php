<?php
/**
 * Header template.
 *
 * @link https://lillehummer.nl
 *
 * @package lillehummernl
 */

// header("Link: </wp-content/themes/lillehummernl/css/style.css>; rel=preload; as=style", false);
// header("Link: </wp-content/themes/lillehummernl/js/app.js>; rel=preload; as=script", false);
?><!doctype html>

<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="manifest" href="site.webmanifest">
    <link rel="apple-touch-icon" href="/wp-content/themes/lillehummernl/icon.png">

	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="375">

	<link rel="apple-touch-icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/apple-touch-icon.png">
	<link rel="icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/favicon.png" sizes="32x32" type="image/png">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

<div class="wrapper">

	<header class="header" role="banner" itemscope itemtype="http://schema.org/WPHeader">

		<div class="header__inner clearfix">

			<p class="logo" itemscope itemtype="http://schema.org/Organization">
				<a href="<?php echo esc_url( home_url() ); ?>" rel="home">
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/img/logo.png" width="" height="">
				</a>
			</p>

			<nav role="navigation" class="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
				<?php
				wp_nav_menu(array(
					'container' => false,
					'theme_location' => 'main-nav',
					'depth' => 0,
				));
				?>
			</nav>

		</div>

	</header>
