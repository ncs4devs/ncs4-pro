<?php
/**
 * NCS4 Pro functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package NCS4_Pro
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

// Add SVG support
// Warning: SVG is an insecure image format and should only be accepted from trusted sources
function cc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

// Register styles
function ncs4_enqueue_custom_styles() {
	if (!is_admin()) {
		wp_enqueue_style( // Default WP style which enables dashicons
			'dashicons',
		);
		wp_enqueue_style(
			'style',
			get_stylesheet_uri(),
			array(),
			filemtime( get_stylesheet_directory() . '/style.css' ),
		);
		wp_enqueue_style(
			'color-palette',
			get_template_directory_uri() . '/generic/color-palette.css',
			array(),
			filemtime( get_stylesheet_directory() . '/generic/color-palette.css' ),
		);
		wp_enqueue_style(
			'index',
			get_template_directory_uri() . '/index.css',
			array(),
			filemtime( get_stylesheet_directory() . '/index.css' ),
		);
		wp_enqueue_style(
			'header',
			get_template_directory_uri() . '/header.css',
			array(),
			filemtime( get_stylesheet_directory() . '/header.css' ),
		);
		wp_enqueue_style(
			'footer',
			get_template_directory_uri() . '/footer.css',
			array(),
			filemtime( get_stylesheet_directory() . '/footer.css' ),
		);
		wp_enqueue_style(
			'margin',
			get_template_directory_uri() . '/margin.css',
			array(),
			filemtime( get_stylesheet_directory() . '/margin.css' ),
		);

	}
}
add_action( 'wp_enqueue_scripts', 'ncs4_enqueue_custom_styles', 11);

// Register editor styles
function ncs4_enqueue_custom_editor_styles() {
	wp_enqueue_style(
		'color-palette',
		get_template_directory_uri() . '/generic/color-palette.css',
		array(),
		filemtime( get_stylesheet_directory() . '/generic/color-palette.css' ),
	);
}
add_action( 'enqueue_block_editor_assets', 'ncs4_enqueue_custom_editor_styles');


if ( ! function_exists( 'ncs4_pro_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ncs4_pro_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on NCS4 Pro, use a find and replace
		 * to change 'ncs4-pro' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ncs4-pro', get_template_directory() . '/languages' );

		// Add custom color palette
		add_theme_support( 'editor-color-palette', array(
			// Navy
			array(
				'name'	=>  'Navy 0',
				'slug'	=>  'primary-0',
				'color'	=>  '#0b152b',
			),
			array(
				'name'	=>	'Navy 1',
				'slug'	=>	'primary-1',
				'color'	=>	'#18243e',
			),
			array(
				'name'	=>	'Navy 2 (Base Tone)',
				'slug'	=>	'primary-2',
				'color'	=>	'#273249',
			),
			array(
				'name'	=>	'Navy 3',
				'slug'	=>	'primary-3',
				'color'	=>	'#3e4a64',
			),
			array(
				'name'	=>	'Navy 4',
				'slug'	=>	'primary-4',
				'color'	=>	'#59657e',
			),
			// Dark Blue
			array(
				'name'	=>	'Dark Blue 0',
				'slug'	=>	'secondary-0',
				'color'	=>	'#002c5d',
			),
			array(
				'name'	=>	'Dark Blue 1',
				'slug'	=>	'secondary-1',
				'color'	=>	'#003b7c',
			),
			array(
				'name'	=>	'Dark Blue 2 (Base Tone)',
				'slug'	=>	'secondary-2',
				'color'	=>	'#00499A',
			),
			array(
				'name'	=>	'Dark Blue 3',
				'slug'	=>	'secondary-3',
				'color'	=>	'#0061cd',
			),
			array(
				'name'	=>	'Dark Blue 4',
				'slug'	=>	'secondary-4',
				'color'	=>	'#097bfb',
			),
			// Yellow
			array(
				'name'	=>	'Yellow 0',
				'slug'	=>	'primary-0c',
				'color'	=>	'#b18800',
			),
			array(
				'name'	=>	'Yellow 1',
				'slug'	=>	'primary-1c',
				'color'	=>	'#e4b005',
			),
			array(
				'name'	=>	'Yellow 2 (Base Tone)',
				'slug'	=>	'primary-2c',
				'color'	=>	'#ffce2f',
			),
			array(
				'name'	=>	'Yellow 3',
				'slug'	=>	'primary-3c',
				'color'	=>	'#ffd755',
			),
			array(
				'name'	=>	'Yellow 4',
				'slug'	=>	'primary-4c',
				'color'	=>	'#ffe17f',
			),
			// Grey
			array(
				'name'	=>	'Grey 0',
				'slug'	=>	'secondary-0c',
				'color'	=>	'#040303',
			),
			array(
				'name'	=>	'Grey 1',
				'slug'	=>	'secondary-1c',
				'color'	=>	'#171717',
			),
			array(
				'name'	=>	'Grey 2 (Base Tone)',
				'slug'	=>	'secondary-2c',
				'color'	=>	'#555',
			),
			array(
				'name'	=>	'Grey 3',
				'slug'	=>	'secondary-3c',
				'color'	=>	'#868686',
			),
			array(
				'name'	=>	'Grey 4',
				'slug'	=>	'secondary-4c',
				'color'	=>	'#b6b5b5',
			),
			// Links
			array(
				'name'	=>	'Light Blue 0',
				'slug'	=>	'link-0',
				'color'	=>	'#0051a5',
			),
			array(
				'name'	=>	'Light Blue 1',
				'slug'	=>	'link-1',
				'color'	=>	'#037fff',
			),
			array(
				'name'	=>	'Light Blue 2 (Base Tone)',
				'slug'	=>	'link-2',
				'color'	=>	'#1b8bff',
			),
			array(
				'name'	=>	'Light Blue 3',
				'slug'	=>	'link-3',
				'color'	=>	'#53a6fd',
			),
			array(
				'name'	=>	'Light Blue 4',
				'slug'	=>	'link-4',
				'color'	=>	'#95c5f6',
			),
			// Whites
			array(
				'name'	=>	'Dark White (Text)',
				'slug'	=>	'white-dark',
				'color'	=>	'#e6e6e6',
			),
			array(
				'name'	=>	'White (Backgrounds)',
				'slug'	=>	'white',
				'color'	=>	'#f4f4f4',
			),
		));

		// No custom colors. Bad editor >:(
		// ( More seriously, custom colors are disabled so that we don't end up
		// with 100 versions of "blue" )
		add_theme_support( 'disable-custom-colors' );

		add_theme_support( 'editor-gradient-presets', array(
			array(
				'name'			=>	'Dark Blue to Black',
				'slug'			=>	'secondary-1_secondary-0_secondary-0c',
				'gradient'	=>	'linear-gradient(0deg, #003b7c 0%, #002c5d 22%, #040303 100%)',
			),
			array(
				'name'			=>	'Dark Blue to Mid Blue',
				'slug'			=>	'secondary-1_secondary-4',
				'gradient'	=>	'linear-gradient(0deg, #003b7c 0%, #097bfb 100%)',
			),
		));

		// Same reason for disabling custom colors.
		// However, it might be worth it to re-enable this and just tell people
		// not to change the stops, so that they can freely modify the angle
		// Alternatively, a free preset angles and some InspectorControls could do it
		add_theme_support( 'disable-custom-gradients' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'ncs4-pro' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'ncs4_pro_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      		   => 250,
				'width'       		   => 250,
				'flex-width'  		   => true,
				'flex-height' 		   => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'ncs4_pro_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ncs4_pro_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ncs4_pro_content_width', 640 );
}
add_action( 'after_setup_theme', 'ncs4_pro_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ncs4_pro_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'ncs4-pro' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'ncs4-pro' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'ncs4_pro_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ncs4_pro_scripts() {
	wp_enqueue_style( 'ncs4-pro-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'ncs4-pro-style', 'rtl', 'replace' );

	wp_enqueue_script( 'ncs4-pro-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'ncs4-pro-search', get_template_directory_uri() . '/js/searchbar.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ncs4_pro_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
