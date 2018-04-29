<?php
/**
 * memoo functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Memoo
 */

if ( ! function_exists( 'memoo_setup' ) ) {
	function memoo_setup() {
		load_theme_textdomain( 'memoo', get_template_directory() . '/languages' );

		add_editor_style();

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );


		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary-menu' => esc_html__( 'Primær navigation', 'memoo' ),
		) );

		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		//Woocommerce theme support
        add_theme_support( 'woocommerce' );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		// Remove the REST API lines from the HTML Header
	    remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
	    remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

	    // Remove the REST API endpoint.
	    remove_action( 'rest_api_init', 'wp_oembed_register_route' );

	    // Don't filter oEmbed results.
	    remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

	    // Remove oEmbed discovery links.
	    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

	    // Remove oEmbed-specific JavaScript from the front-end and back-end.
	    remove_action( 'wp_head', 'wp_oembed_add_host_js' );

		// Turn off oEmbed auto discovery.
	    add_filter( 'embed_oembed_discover', '__return_false' );
	}
}
add_action( 'after_setup_theme', 'memoo_setup' );

function memoo_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'memoo_content_width', 1170 );
}
add_action( 'after_setup_theme', 'memoo_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function memoo_scripts() {

	/*SCRIPTS*/
	wp_enqueue_script( 'memoo-header', get_template_directory_uri() . '/assets/js/header.js', array('jquery'), null, true );
	//wp_enqueue_script( 'memoo-header-min', get_template_directory_uri() . '/assets/js/min/header.min.js', array('jquery'), null, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}


	/*STYLES*/
	wp_enqueue_style( 'memoo-variables', get_template_directory_uri() . '/assets/css/variables.css');
	wp_enqueue_style( 'memoo-custom-variables', get_template_directory_uri() . '/assets/css/custom-variables.css');
	//wp_enqueue_style( 'memoo-custom-variables-min', get_template_directory_uri() . '/assets/css/min/custom-variables.min.css');

	wp_enqueue_style( 'memoo-reset-min', get_template_directory_uri() . '/assets/css/min/reset.min.css');
	wp_enqueue_style( 'memoo-fac-min', get_template_directory_uri() . '/assets/css/min/fa-core.min.css');
	wp_enqueue_style( 'memoo-grid-min', get_template_directory_uri() . '/assets/css/min/flexboxgrid.min.css');

	wp_enqueue_style( 'memoo-header', get_template_directory_uri() . '/assets/css/header.css');
	//wp_enqueue_style( 'memoo-header-min', get_template_directory_uri() . '/assets/css/min/header.min.css');

	wp_enqueue_style( 'memoo-footer', get_template_directory_uri() . '/assets/css/footer.css');
	//wp_enqueue_style( 'memoo-footer-min', get_template_directory_uri() . '/assets/css/min/footer.min.css');

	wp_enqueue_style( 'memoo-main', get_template_directory_uri() . '/assets/css/main.css');
	//wp_enqueue_style( 'memoo-main-min', get_template_directory_uri() . '/assets/css/min/main.min.css');

	wp_enqueue_style( 'memoo-fallback', get_template_directory_uri() . '/assets/css/fallback.css');
	//wp_enqueue_style( 'memoo-fallback-min', get_template_directory_uri() . '/assets/css/min/fallback.min.css');

	wp_enqueue_style( 'memoo-ie', get_template_directory_uri() . '/assets/css/ie.css');
	wp_style_add_data( 'memoo-ie', 'conditional', 'gt IE 8' );
	//wp_enqueue_style( 'memoo-ie-min', get_template_directory_uri() . '/assets/css/min/ie.min.css');
	//wp_style_add_data( 'memoo-ie-min', 'conditional', 'gt IE 8' );

	wp_enqueue_style( 'memoo-style', get_stylesheet_uri() );

}
add_action( 'wp_enqueue_scripts', 'memoo_scripts' );


require get_template_directory() . '/inc/theme-options.php';

require get_template_directory() . '/inc/custom-functions.php';

require get_template_directory() . '/inc/widgets.php';

require get_template_directory() . '/inc/walker-nav.php';

require get_template_directory() . '/inc/template-tags.php';

require get_template_directory() . '/inc/template-functions.php';

require get_template_directory() . '/inc/customizer.php';

if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

if ( function_exists('is_woocommerce') ) {
	require get_template_directory() . '/inc/woocommerce-customization.php';
}
