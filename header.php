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
	<header id="masthead" class="site-header">
		<div class="site-header-inner">
			<div class="site-header-col col1">
				<div class="col-inner">
					<a class="title-link" href="/">
						<?php
						$custom_logo_id = get_theme_mod( 'custom_logo' );
						$logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
	 
						if ( has_custom_logo() ) {
						    echo '<img src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . '">';
						} else {
						    echo '<h1>' . get_bloginfo('name') . '</h1>';
						}
						?>
					</a><!-- .title-link -->
				</div><!-- .col-inner -->
			</div><!-- .header-col.header-col1 -->
			<div class="site-header-col col2">
				<div class="col-inner">
					<!-- Search bar widget -->
					<div id="header-search-widget" class="header-widget-area widget-area">
						<div id="header-search-widget-inner" class="header-widget-area-inner widget-area-inner">
							<form class="search-form" method="get" action="/" role="search" itemprop="potentialAction" itemtype="https://schema.org/SearchAction">
								<label class="search-form-lbl screen-reader-text" for="searchform">Search</label>
								<input id="searchform" class="search-form-input" type="search" name="s" placeholder="Search" itemprop="query-input"><button class="search-form-submit" type="submit" value="Search" title="Search">
									<span class="screen-reader-text">Submit</span>
								</button>
								<meta content="/?s={s}" itemprop="target">
							</form>
						</div>
					</div>
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