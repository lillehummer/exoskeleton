<!doctype html>

<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?php wp_title( '' ); ?></title>

	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="375">

	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/img/apple-touch-icon.png">
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.png" sizes="32x32" type="image/png">

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

<div class="wrapper">

	<header class="header" role="banner" itemscope itemtype="http://schema.org/WPHeader">

		<div class="header-inner clearfix">

			<p class="logo" itemscope itemtype="http://schema.org/Organization">
				<a href="<?php echo home_url(); ?>" rel="nofollow">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo.png" width="" height="">
				</a>
			</p>

			<nav role="navigation" class="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
				<?php
				wp_nav_menu(array(
					'container' => false,
					'container_class' => '',
					'menu_class' => '',
					'theme_location' => 'main-nav',
					'before' => '',
					'after' => '',
					'link_before' => '',
					'link_after' => '',
					'depth' => 0,
				));
				?>
			</nav>

		</div>

	</header>
