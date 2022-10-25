<?php
/**
 * NCS4 Pro functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package NCS4_Pro
 */

$ncs4_block_dependencies = array();

/*

ncs4_register_block_dependency(array(
  'name'          =>  'award-card',
  'editor-styles' =>  array(
    'ncs4-custom-blocks_award-card-editor' => WP_PLUGIN_DIR
  )
));

*/

/*

function ncs4_register_block_dependency($dependency) {
  if (isset($ncs4_block_dependencies[ $dependency->name] )) {
    return; // Dependency already exists
  }

  $ncs4_block_dependencies[$dependency->name] = $dependency;
}

function ncs4_enqueue_block_dependencies() {
  foreach ($ncs4_block_dependencies as $dependency) {
    foreach ($dependency->editor_style as $style) {
      wp_enqueue_style()
    }
  }
}
add_action('init', 'ncs4_enqueue_block_dependencies');

*/

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

// Remove "Tag: " from Newsletter archive
add_filter('get_the_archive_title', function($title) {
  if (is_tag()) {
    $tag_id = get_queried_object()->term_id;
    if ($tag_id == 20) { // Newsletter tag
      $title = single_tag_title('', false);
    }
  }
  return $title;
});

function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}

/*
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', function())
*/

// Modified get_the_content to properly handle more blocks inside innerblocks
// See: https://developer.wordpress.org/reference/functions/get_the_content/
function ncs4_get_the_content( $more_link_text = null, $strip_teaser = false, $post = null ) {
    global $page, $more, $preview, $pages, $multipage;

    $_post = get_post( $post );

    if ( ! ( $_post instanceof WP_Post ) ) {
        return '';
    }

    // Use the globals if the $post parameter was not specified,
    // but only after they have been set up in setup_postdata().
    if ( null === $post && did_action( 'the_post' ) ) {
        $elements = compact( 'page', 'more', 'preview', 'pages', 'multipage' );
    } else {
        $elements = generate_postdata( $_post );
    }

    if ( null === $more_link_text ) {
        $more_link_text = sprintf(
            '<span aria-label="%1$s">%2$s</span>',
            sprintf(
                /* translators: %s: Post title. */
                __( 'Continue reading %s' ),
                the_title_attribute(
                    array(
                        'echo' => false,
                        'post' => $_post,
                    )
                )
            ),
            __( '(more&hellip;)' )
        );
    }

    $output     = '';
    $has_teaser = false;

    // If post password required and it doesn't match the cookie.
    if ( post_password_required( $_post ) ) {
        return get_the_password_form( $_post );
    }

    // If the requested page doesn't exist.
    if ( $elements['page'] > count( $elements['pages'] ) ) {
        // Give them the highest numbered page that DOES exist.
        $elements['page'] = count( $elements['pages'] );
    }

    $page_no = $elements['page'];
    $content = $elements['pages'][ $page_no - 1 ];
    if ( preg_match( '/<!--more(.*?)?-->/', $content, $matches ) ) {
        if ( has_block( 'more', $content ) ) {
            // Remove the core/more block delimiters. They will be left over after $content is split up.
            $content = preg_replace( '/<!-- \/?wp:more(.*?) -->/', '', $content );
        }

        $content = explode( $matches[0], $content, 2 );

        if ( ! empty( $matches[1] ) && ! empty( $more_link_text ) ) {
            $more_link_text = strip_tags( wp_kses_no_null( trim( $matches[1] ) ) );
        }

        $has_teaser = true;
    } else {
        $content = array( $content );
    }

    if ( false !== strpos( $_post->post_content, '<!--noteaser-->' ) && ( ! $elements['multipage'] || 1 == $elements['page'] ) ) {
        $strip_teaser = true;
    }

    $teaser = $content[0];

    $more_link = '';
    if ( count( $content ) > 1 ) {
      if ( $elements['more'] ) {
        $more_link.= '<span id="more-' . $_post->ID . '"></span>' . $content[1];
      } else {
        if ( ! empty( $more_link_text ) ) {

          /**
          * Filters the Read More link text.
          *
          * @since 2.8.0
          *
          * @param string $more_link_element Read More link element.
          * @param string $more_link_text    Read More text.
          */
          $more_link .= apply_filters( 'the_content_more_link', ' <a href="' . get_permalink( $_post ) . "#more-{$_post->ID}\" class=\"more-link\">$more_link_text</a>", $more_link_text );
        }
        $more_link = force_balance_tags( $more_link );
      }
    }

    if ( $elements['more'] && $strip_teaser && $has_teaser ) {
      $teaser = '';
    }

    $teaser .= $more_link;
    $output .= $teaser;

    if (!is_archive()) {
      $output = apply_filters('the_content', $output);
    }
    $output = force_balance_tags($output);

    return $output;
}

/*
add_filter('the_post', function($post) {
  if (is_single($post)) {
    $post->post_name = (string) $post->ID;
  };
  return $post;
});

// Add Event date meta boxes
add_action( 'add_meta_boxes', function() {
  $screens = [ 'post', 'wporg_cpt' ];
  foreach ($screens as $screen) {
    add_meta_box(
      'ncs4_event-start',
      'Event start date',
      'ncs4_event_start_meta_box',
      $screen,
    );
    add_meta_box(
      'ncs4_event-end',
      'Event end date',
      'ncs4_event_end_meta_box',
      $screen,
    );
  }
});

function ncs4_event_start_meta_box($post) {
  ?>
  <label for="event-start-field">Event start</label>
  <select name="event-start-field" id="event-start-field" class="postbox">

  <
  <?php
}

function ncs4_event_end_meta_box($post) {

}
*/

// Add SVG support
// Warning: SVG is an insecure image format and should only be accepted from trusted sources
function cc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('mime_types', 'cc_mime_types');

function remove_admin_bar_default_style() {
  remove_action('wp_head', '_admin_bar_bump_cb');
  if (!current_user_can('edit_others_posts')) {
    show_admin_bar(false);
  }
}
add_action('admin_bar_init', 'remove_admin_bar_default_style');

function ncs4_custom_admin_bar_items($admin_bar) {
  if (!is_admin()) {
    $admin_bar->add_menu( array(
      'id'    =>  'drag',
      'title' =>  '<svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18" role="img" aria-hidden="true" focusable="false"><path d="M5 4h2V2H5v2zm6-2v2h2V2h-2zm-6 8h2V8H5v2zm6 0h2V8h-2v2zm-6 6h2v-2H5v2zm6 0h2v-2h-2v2z"></path></svg>',
    ));

    wp_enqueue_script(
      'ncs4-pro-adminbar-drag',
      get_template_directory_uri() . '/js/adminbar_drag.js',
      array(),
      filemtime( get_stylesheet_directory() . '/js/adminbar_drag.js'),
    );
  }
}
add_action('admin_bar_menu', 'ncs4_custom_admin_bar_items');

// BuddyPress
add_filter('bp_after_activate_content', function() {
  if (bp_account_was_activated()) {
    return '<p><a href="/login">Log In</a></p>';
  }
  return "";
});

// Forum settings
function bbp_enable_tinymce( $args = array() ) {
  $args['tinymce'] = true;
  $args['teeny'] = false;
  return $args;
}
add_filter( 'bbp_after_get_the_content_parse_args', 'bbp_enable_tinymce');
add_filter('mce_buttons', function($buttons) {
  $buttons[] = 'superscript';
  $buttons[] = 'subscript';
  $buttons[] = 'image';
  $buttons[] = 'media';
  return $buttons;
});

add_filter( 'bbp_get_title_max_length', function($length) {
  $length = 120;
  return $length;
});


// Register styles
function ncs4_enqueue_custom_styles() {
	if (!is_admin()) {
		wp_enqueue_style( // Default WP style which enables dashicons
			'dashicons',
		);
		wp_enqueue_style(
			'ncs4-pro-style',
			get_stylesheet_uri(),
			array(),
			filemtime( get_stylesheet_directory() . '/style.css' ),
		);
		wp_enqueue_style(
			'ncs4-pro-color-palette',
			get_template_directory_uri() . '/generic/color-palette.css',
			array(),
			filemtime( get_stylesheet_directory() . '/generic/color-palette.css' ),
		);
		wp_enqueue_style(
			'ncs4-pro-index',
			get_template_directory_uri() . '/index.css',
			array(),
			filemtime( get_stylesheet_directory() . '/index.css' ),
		);
		wp_enqueue_style(
			'ncs4-pro-header',
			get_template_directory_uri() . '/header.css',
			array(),
			filemtime( get_stylesheet_directory() . '/header.css' ),
		);
		wp_enqueue_style(
			'ncs4-pro-footer',
			get_template_directory_uri() . '/footer.css',
			array(),
			filemtime( get_stylesheet_directory() . '/footer.css' ),
		);
		wp_enqueue_style(
			'ncs4-pro-margin',
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
		'ncs4-pro-color-palette',
		get_template_directory_uri() . '/generic/color-palette.css',
		array(),
		filemtime( get_stylesheet_directory() . '/generic/color-palette.css' ),
	);
  wp_enqueue_style(
    'ncs4-pro-editor-style',
    get_stylesheet_directory_uri() . '/editor-style.css',
    array(),
    filemtime( get_stylesheet_directory() . '/editor-style.css'),
  );
}
add_action( 'enqueue_block_editor_assets', 'ncs4_enqueue_custom_editor_styles');

function ncs4_custom_admin_bar_frontend() {
	wp_enqueue_style(
		'ncs4-pro-admin-bar',
		get_template_directory_uri() . '/admin-bar.css',
		array(),
		filemtime( get_stylesheet_directory() . '/admin-bar.css' ),
	);
}
add_action( 'wp_head', 'ncs4_custom_admin_bar_frontend' );


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
      /*
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
      */
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
      array(
        'name'  =>  'Pure White',
        'slug'  =>  'white-bright',
        'color' =>  '#fff',
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

/* Custom search functions */

/* Original src: https://blog.project-insanity.org/2020/07/27/custom-excerpts-in-wordpress-search-highlighting-query-keywords/ */

function generate_excerpt($text, $query, $length) {

	$words = explode(' ', $text);
	$total_words = count($words);

	if ($total_words > $length) {

		$queryLow = array_map('strtolower', $query);
		$wordsLow = array_map('strtolower', $words);

		for ($i=0; $i <= $total_words; $i++) {

			foreach ($queryLow as $queryItem) {

				if (preg_match("/\b$queryItem\b/", $wordsLow[$i])) {
					$posFound = $i;
					break;
				}
			}

			if ($posFound) {
				break;
			}
		}

		if ($i > ($length+($length/2))) {
			$i = $i - ($length/2);
		} else {
      $i = 0;
    }

	}

	$cutword = array_splice($words,$i,$length);
	$excerpt = implode(' ', $cutword);

	$keys = implode('|', $query);
	$excerpt = preg_replace('/(' . $keys .')/iu', '<strong class="search-highlight">\0</strong>', $excerpt);
	$excerptRet = '<p>';
  if ($i !== 0) {
    $excerptRet .= '... ';
  }
  $excerptRet .= $excerpt . ' ...</p>';

	return $excerptRet;

}

function search_excerpt_highlight() {

    # Length in word count
    $excerptLength = 32;

    $text = wp_strip_all_tags( get_the_content() );

    # Filter double quotes from query. They will
    # work on the results side but won't help with
    # text highlighting and displaying.
    $query=get_search_query(false);
    $query=str_replace('"','',$query);
    $query=esc_html($query);

    $query = explode(' ', $query);

    echo generate_excerpt($text, $query, $excerptLength);

}

/* End Custom Search Function */

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

require __DIR__ . "/buddypress/members/bpFunctions.php";

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
