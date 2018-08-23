<?php
/**
 * Attend functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Attend
 */

if ( ! function_exists( 'attend_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function attend_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on attend, use a find and replace
		 * to change 'attend' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'attend', get_template_directory() . '/languages' );

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
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'attend' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( '_s_custom_background_args', array(
			'default-color' => '1c214b',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		// Adding support for core block visual styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for custom color scheme.
		add_theme_support( 'editor-color-palette', array(
			array(
				'name'  => 'Dark Blue',
				'slug'  => 'dark-blue',
				'color' => '#1c214b',
			),
			array(
				'name'  => 'Light Blue',
				'slug'  => 'light-blue',
				'color' => '#a6d8ef',
			),
			array(
				'name'  => 'White',
				'slug'  => 'white',
				'color' => '#ffffff',
			),
			array(
				'name'  => 'Salmon',
				'slug'  => 'salmon',
				'color' => '#ff7a6b',
			)
		) );

	}
endif;
add_action( 'after_setup_theme', 'attend_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function attend_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'attend_content_width', 640 );
}
add_action( 'after_setup_theme', 'attend_content_width', 0 );

/**
 * Register Google Fonts
 */
function attend_fonts_url() {
	$fonts_url = '';

	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Playfair Display, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$playfair_display = esc_html_x( 'on', 'Playfair Display font: on or off', 'attend' );

	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Lato, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$lato = esc_html_x( 'on', 'Lato font: on or off', 'attend' );

	if ( 'off' !== $playfair_display || 'off' !== $lato ) {
		$font_families = array();

		if ( 'off' !== $playfair_display ) {
			$font_families[] = 'Playfair+Display:400,400i,700,700i';
		}

		if ( 'off' !== $lato ) {
			$font_families[] = 'Lato:300,300i,400,400i,700,700i';
		}

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}

/**
 * Enqueue scripts and styles.
 */
function attend_scripts() {
	wp_enqueue_style( 'attend-base-style', get_stylesheet_uri() );

	wp_enqueue_style( 'attend-blocks-style', get_template_directory_uri() . '/css/blocks.css' );

	wp_enqueue_style( 'attend-fonts', attend_fonts_url() );

	wp_enqueue_script( 'attend-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'attend-priority-navigation', get_template_directory_uri() . '/js/priority-navigation.js', array( 'jquery' ), '20151215', true );

	wp_enqueue_script( 'attend-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Screenreader text
	wp_localize_script( 'attend-navigation', 'attendScreenReaderText', array(
		'expand'   => esc_html__( 'expand child menu', 'attend' ),
		'collapse' => esc_html__( 'collapse child menu', 'attend' ),
	) );

	// Icons
	wp_localize_script( 'attend-navigation', 'attendIcons', array(
		'dropdown' => attend_get_svg( array( 'icon' => 'expand' ) )
	) );
}
add_action( 'wp_enqueue_scripts', 'attend_scripts' );

/**
 * Check whether the browser supports JavaScript
 */
function attend_html_js_class() {
	echo '<script>document.documentElement.className = document.documentElement.className.replace("no-js","js");</script>'. "\n";
}
add_action( 'wp_head', 'attend_html_js_class', 1 );

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
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// Add Custom Blocks
require get_template_directory() . '/inc/blocks.php';
