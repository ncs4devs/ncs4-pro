<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package NCS4_Pro
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'ncs4-pro' ); ?></a>
	<a class="skip-link screen-reader-text" href="#colophon"><?php esc_html_e( 'Skip to footer', 'ncs4-pro'); ?></a>

	<style><?php include 'header.css'; ?></style>
	<header id="masthead" class="site-header">
		<div class="site-header-inner">
			<div class="site-header-col col1">
				<div class="col-inner">
					<?php
					the_custom_logo(); // Replace with custom logo code later
					?>
				</div><!-- .col-inner -->
			</div><!-- .header-col.header-col1 -->
			<div class="site-header-col col2">
				<div class="col-inner">
					<!-- Search bar widget -->
					<div id="header-search-widget" class="header-widget-area"></div>
					<!-- Navbar -->
					<div id="header-navbar-area" class="header-widget-area">
						<nav id="header-navbar" class="main-navigation">
							<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'ncs4-pro' ); ?></button>
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'menu-1',
									'menu_id'		 =>	'primary-menu',
								)
							);
							?>
						</nav>
					</div><!-- .col-inner -->
				</div><!-- #header-navbar-area -->
			</div><!-- .header-col.header-col2 -->
		</div><!-- .site-header-inner -->
	</header><!-- #masthead -->