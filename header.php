<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 */

// search box - can be placed anywhere in the template
/*
		<div id="search-container" class="search-box-wrapper hide">
			<div class="search-box">
				<?php get_search_form(); ?>
			</div>
		</div>
*/

?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>" xmlns:og="http://opengraphprotocol.org/schema/"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>" xmlns:og="http://opengraphprotocol.org/schema/"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>" xmlns:og="http://opengraphprotocol.org/schema/"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?> xmlns:og="http://opengraphprotocol.org/schema/"> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, maximum-scale=1.0">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="wrapper" class="hfeed site container">

<div class="header-wrapper">
	<header id="header" class="site-header clearfix" role="banner">
		<div class="header-inner">

		<?php $post_image = actionsite_get_header_image();
		if ( $post_image ) : ?>
			<div id="header-image">
				<img src="<?php echo $post_image; ?>" alt="<?php echo actionsite_get_header_image_text(); ?>" />
			</div>
		<?php endif; ?>

		</div>
	</header><!-- #header -->
</div>

<div id="wrapper-main" class="clearfix row">
