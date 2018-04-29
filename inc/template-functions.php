<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package memoo
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function memoo_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( get_option('memoo_boxed_layout', '') !== '' ) {
		$classes[] = 'boxed-layout';
	}

	if ( get_option('memoo_hide_bottom_footer', '') !== '' ) {
		$classes[] = 'no-footer';
	} else if (!is_active_sidebar('footer-bottom')) {
		$classes[] = 'no-footer';
	}

	if ( get_option('memoo_fixed_header', '') !== '' ) {
		$classes[] = 'fixed-header';
	}

	if ( get_option('memoo_woocommerce_catalog_filter_visibility', '') !== '' ) {
		$classes[] = 'no-sidebar';
	} else if (!is_product() && !is_cart() && !is_checkout() && !is_account_page() && is_woocommerce()) {
		$classes[] = 'has-sidebar';
	}

	if (!is_product() && !is_cart() && !is_checkout() && !is_account_page() && is_woocommerce()) {
		$classes[] = 'full-width';
	}


	return $classes;
}
add_filter( 'body_class', 'memoo_body_classes' );

/**
 * Adds custom excerpt length to posts.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function memoo_excerpt_length( $length ){
  return 15;
}
add_filter('excerpt_length', 'memoo_excerpt_length');

function memoo_excerpt_more( $more ) {
	return __('&mldr;', 'memoo');
}
add_filter( 'excerpt_more', 'memoo_excerpt_more' );

function memoo_excerpt($long_string) {
	$text = strip_shortcodes( $long_string );
	$text = apply_filters( 'the_content', $text );
	$text = str_replace(']]>', ']]&gt;', $text);
	$excerpt_length = apply_filters( 'excerpt_length', 25 );
	$excerpt_more = apply_filters( 'excerpt_more', '' . '&hellip;' );
	$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );

	return $text;

}

function memoo_is_blog () {
    return ( is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag()) && 'post' == get_post_type();
}

function memoo_search_filter($query) {
	if ( !is_admin() && $query->is_main_query() ) {
		if ($query->is_search) {
			$query->set('post_type', 'post');
			$query->set('post_status', 'publish');
			$query->set('posts_per_page', '15');
		}
	}
}

add_action('pre_get_posts','memoo_search_filter');

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function memoo_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'memoo_pingback_header' );


function memoo_custom_page_heading($title, $before = '', $after = '', $special_page = false, $echo = true){
	if ($special_page) {
		if (get_option('memoo_hide_special_page_headings') == true){
			return;
		}
	} else if (is_really_woocommerce_page()) {
		if (get_option('memoo_hide_woocommerce_page_headings') == true){
			return;
		}
	} else {
		if (get_option('memoo_hide_page_headings') == true){
			return;
		}
	}

	$custom_heading = get_option('memoo_custom_page_headings', '');

	if ($custom_heading !== '') {
		$searchReplaceArray = [
			'%page-title%' 	=> $title,
		];

		if ($special_page) {
			if (get_option('memoo_use_custom_page_headings_on_special_pages') == true) {
				$title = str_replace(
					array_keys($searchReplaceArray),
					array_values($searchReplaceArray),
					$custom_heading
				);
			}
		} elseif (is_really_woocommerce_page()) {
			if (get_option('memoo_use_custom_page_headings_on_woocommerce_pages') == true) {
				$title = str_replace(
					array_keys($searchReplaceArray),
					array_values($searchReplaceArray),
					$custom_heading
				);
			}
		} else {
			$title = str_replace(
				array_keys($searchReplaceArray),
				array_values($searchReplaceArray),
				$custom_heading
			);
		}
	}

	if ($echo) {
		echo $before.$title.$after;
	} else {
		return $before.$title.$after;
	}
}

/**
* is_really_woocommerce_page - Returns true if on a page which uses WooCommerce templates (cart and checkout are standard pages with shortcodes and which are also included)
*
* @access public
* @return bool
*/
function is_really_woocommerce_page() {
        if(  function_exists ( "is_woocommerce" )){
			if (is_woocommerce()) {
				return true;
			}
        }

        $woocommerce_keys = array(
			"woocommerce_shop_page_id",
	        "woocommerce_terms_page_id",
	        "woocommerce_cart_page_id",
	        "woocommerce_checkout_page_id",
	        "woocommerce_pay_page_id",
	        "woocommerce_thanks_page_id",
	        "woocommerce_myaccount_page_id",
	        "woocommerce_edit_address_page_id",
	        "woocommerce_view_order_page_id",
	        "woocommerce_change_password_page_id",
	        "woocommerce_logout_page_id",
	        "woocommerce_lost_password_page_id"
		);

        foreach ( $woocommerce_keys as $wc_page_id ) {
            if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
                return true ;
            }
        }
        return false;
}
