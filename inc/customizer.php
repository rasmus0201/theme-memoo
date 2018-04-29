<?php
/**
 * memoo Theme Customizer
 *
 * @package memoo
 */

class Memoo_Customize {
	public static function register ( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'blogname', array(
				'selector'        => '.site-title a',
				'render_callback' => 'memoo_customize_partial_blogname',
			) );
			$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
				'selector'        => '.site-description',
				'render_callback' => 'memoo_customize_partial_blogdescription',
			) );
		}
	}

    public static function live_preview() {
		wp_enqueue_script(
			'memoo-customizer', // Give the script a unique ID
			get_template_directory_uri() . '/assets/js/customizer.js',
			array(  'jquery', 'customize-preview' ),
			null,
			true
		);
    }
}

// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'Memoo_Customize' , 'register' ) );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init' , array( 'Memoo_Customize' , 'live_preview' ) );


/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function memoo_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function memoo_customize_partial_blogdescription() {
	bloginfo( 'description' );
}
