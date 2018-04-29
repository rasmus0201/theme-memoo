<?php

if ( ! function_exists( 'memoo_woocommerce_setup' ) ) {
	function memoo_woocommerce_setup() {
		//add_theme_support( 'wc-product-gallery-zoom' );
		//add_theme_support( 'wc-product-gallery-lightbox' );
		//add_theme_support( 'wc-product-gallery-slider' );
    }
}
add_action( 'after_setup_theme', 'memoo_woocommerce_setup' );

function memoo_woocommerce_scripts() {
	/*SCRIPTS*/
	$translations = array(
		'selected_custom_dropdown' 	=> __( 'Du har valgt: ', 'memoo' ),
		'choose_an_option'			=> __( 'Choose an option', 'woocommerce' ),
		'popup_enabled'				=> get_option('memoo_woocommerce_show_popup_after_add_to_cart', false)
	);

	wp_register_script('memoo-woocommerce', get_template_directory_uri() . '/assets/js/woocommerce.js', array('jquery'), null, true);
	
	wp_localize_script( 'memoo-woocommerce', 'memoo', $translations );

	wp_enqueue_script('memoo-woocommerce');


	/*STYLES*/
	wp_enqueue_style('memoo-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css');

}
add_action( 'wp_enqueue_scripts', 'memoo_woocommerce_scripts' );


add_filter( 'woocommerce_breadcrumb_defaults', 'memoo_change_woocommerce_breadcrumb_seperator' );
function memoo_change_woocommerce_breadcrumb_seperator( $defaults ) {
	$custom_delimiter = trim(get_option('memoo_woocommerce_breadcrumbs_seperator', false));
	$defaults['delimiter'] = ($custom_delimiter != false && $custom_delimiter != '') ? '&nbsp;'.$custom_delimiter.'&nbsp;' : '&nbsp;/&nbsp;' ;

	return $defaults;
}

function memoo_get_product_columns_class(){
	$desktop_layout = get_option('memoo_woocommerce_product_pr_row_desktop', 'products-mobile-4');
	$tablet_layout = get_option('memoo_woocommerce_product_pr_row_tablet', 'products-tablet-3');
	$mobile_layout = get_option('memoo_woocommerce_product_pr_row_mobile', 'products-mobile-1');

	return [$desktop_layout, $tablet_layout, $mobile_layout];
}

function memoo_alter_product_class( $classes ) {
    //global $post;
	$added_classes = memoo_get_product_columns_class();

	foreach($added_classes as $class) {
		$classes[] = $class;
	}

    return $classes;
}
add_filter( 'post_class', 'memoo_alter_product_class' );

function memoo_number_of_prodcts_per_page( $cols ) {
	$option = get_option('memoo_woocommerce_products_pr_page', false);
	return ($option == false) ? 24 : abs($option);
}
add_filter( 'loop_shop_per_page', 'memoo_number_of_prodcts_per_page', 20 );

function memoo_variable_product_price_format( $price, $product ) {

    $prefix = sprintf('%s ', __('Fra:', 'memoo'));

    $min_price_regular = $product->get_variation_regular_price( 'min', true );
    $min_price_sale    = $product->get_variation_sale_price( 'min', true );
    $max_price = $product->get_variation_price( 'max', true );
    $min_price = $product->get_variation_price( 'min', true );

    $price = ( $min_price_sale == $min_price_regular ) ?
        wc_price( $min_price_regular ) :
        '<del>' . wc_price( $min_price_regular ) . '</del>' . '<ins>' . wc_price( $min_price_sale ) . '</ins>';

    return ( $min_price == $max_price ) ?
        $price :
        sprintf('%s%s', $prefix, $price);

}
add_filter('woocommerce_variable_sale_price_html', 'memoo_variable_product_price_format', 10, 2);
add_filter('woocommerce_variable_price_html', 'memoo_variable_product_price_format', 10, 2);

remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
add_action('memoo_woocommerce_catalog_bar_right', 'woocommerce_result_count', 20);

remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
add_action('memoo_woocommerce_catalog_bar_left', 'woocommerce_catalog_ordering', 20);


function memoo_maybe_remove_woocommerce_breadcrumbs() {
	if (get_option('memoo_woocommerce_breadcrumbs_visibility', false) == true) {
		remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
		
		return;
	}

	if (!is_product() && !is_cart() && !is_checkout() && !is_account_page() && is_really_woocommerce_page()) {
		remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
		add_action('memoo_woocommerce_breadcrumb', 'woocommerce_breadcrumb', 20);
	}
}
add_action('init', 'memoo_maybe_remove_woocommerce_breadcrumbs', 20);


function memoo_woocommerce_category_image() {
    if ( is_product_category() ){
	    global $wp_query;
	    $cat = $wp_query->get_queried_object();
	    $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
	    $image = wp_get_attachment_url( $thumbnail_id );
	    if ( $image ) {
		    echo '<img src="' . $image . '" alt="' . $cat->name . '" />';
		}
	}
}
//add_action( 'woocommerce_archive_description', 'memoo_woocommerce_category_image', 2 );


function memoo_maybe_remove_woocommerce_related_products(){
	if (is_product()) {
		if (get_option('memoo_woocommerce_related_products_visibility', false) == true) {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		}
	}

	return;
}
add_action('init', 'memoo_maybe_remove_woocommerce_related_products', 20);

function memoo_disable_shipping_on_cart( $show_shipping ) {
	return is_cart() ? false : $show_shipping;
}
add_filter( 'woocommerce_cart_ready_to_calc_shipping', 'memoo_disable_shipping_on_cart', 99 );

function memoo_shortcode_wc_search( $atts ) {
	return get_product_search_form(false);
}
add_shortcode( 'memooo_wc_search', 'memoo_shortcode_wc_search' );

function memoo_wc_add_cart_ajax_single_product() {
	$product_id = $_POST['product_id'];
	$variation_id = $_POST['variation_id'];
	$quantity = $_POST['quantity'];

	if ($variation_id) {
		$res = WC()->cart->add_to_cart($product_id, $quantity, $variation_id, wc_get_product_variation_attributes( $variation_id ));
	} else {
		$res = WC()->cart->add_to_cart($product_id, $quantity);
	}

	echo woocommerce_mini_cart();

	wp_die();
}
add_action('wp_ajax_memoo_wc_add_cart_ajax_single_product', 'memoo_wc_add_cart_ajax_single_product');
add_action('wp_ajax_nopriv_memoo_wc_add_cart_ajax_single_product', 'memoo_wc_add_cart_ajax_single_product');

function memoo_get_mini_cart() {
	echo woocommerce_mini_cart();

	wp_die();
}
add_action('wp_ajax_memoo_get_mini_cart', 'memoo_get_mini_cart');
add_action('wp_ajax_nopriv_memoo_get_mini_cart', 'memoo_get_mini_cart');

function memoo_get_cart_count() {
	echo WC()->cart->get_cart_contents_count();

	wp_die();
}
add_action('wp_ajax_memoo_get_cart_count', 'memoo_get_cart_count');
add_action('wp_ajax_nopriv_memoo_get_cart_count', 'memoo_get_cart_count');


function memoo_shortcode_wc_minicart( $atts ) {
	$atts = shortcode_atts( array(
		'text' 			=> '',
		'icon_classes' 	=> '',
		'icon_position' => 'after',
		'hide_count'	=> '0',
		'is_widget'		=> '0'
	), $atts, 'memooo_wc_minicart' );

	$text = '';
	$icon = '';

	if ($atts['text'] != '') {
		$text = '<span class="item-text">'.$atts['text'].'</span>';
	}

	if ($atts['icon_classes'] != '') {
		$icon = '<i class="'.$atts['icon_classes'].'"></i>';
	}

	$cart = '<div class="wc-mini-cart-wrapper">';
	$cart .= '<a class="cart-contents" href="'.wc_get_cart_url().'" title="'. __( 'Vis kurven', 'memoo').'">';

	if ($atts['icon_position'] == 'before') {
		$cart .= $icon;
		$cart .= $text;
	}

	if ($atts['icon_position'] != 'before') {
		$cart .= $text;
		$cart .= $icon;
	}

	if ($atts['hide_count'] === "1") {
		$cart .= '<span class="cart-count-total">(<span class="number">'.WC()->cart->get_cart_contents_count().'</span>)</span>';
	}

	$cart .= '</a>';

	if ($atts['is_widget'] === "0") {
		$cart .= woocommerce_mini_cart();
	}

	return $cart;
}
add_shortcode( 'memooo_wc_minicart', 'memoo_shortcode_wc_minicart' );

function memoo_add_before_minicart(){
	echo '<div class="wc-mini-cart">';
}
add_action('woocommerce_before_mini_cart', 'memoo_add_before_minicart', 20);

function memoo_add_after_minicart(){
	echo '</div>';
}
add_action('woocommerce_after_mini_cart', 'memoo_add_after_minicart', 20);

function memoo_woocommerce_catalog_orderby( $orderby ) {
	$orderby['menu_order'] 	= __('Sorter efter', 'memoo');
	$orderby['price'] 		= __('Pris: lav til høj', 'memoo');
	$orderby['price-desc'] 	= __('Pris: høj til lav', 'memoo');
	$orderby['date'] 		= __('Nyeste', 'memoo');
	$orderby['popularity'] 	= __('Popularitet', 'memoo');
	$orderby['rating'] 		= __('Bedømmelse', 'memoo');
	return $orderby;
}
add_filter( 'woocommerce_catalog_orderby', 'memoo_woocommerce_catalog_orderby', 20 );

function memoo_excerpt_max_charlength($charlength) {
	$excerpt = get_the_excerpt();
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		} else {
			echo $subex;
		}
	} else {
		echo $excerpt;
	}
}

//add_filter( 'woocommerce_enqueue_styles', 'memoo_dequeue_woocommerce_general_styles' );
function memoo_dequeue_woocommerce_general_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] );

	return $enqueue_styles;
}

/*add_filter( 'woocommerce_output_related_products_args', 'hff_commerce_child_related_products_args', 99, 3 );
function hff_commerce_child_related_products_args( $args ) {
	$args = array( 
		'posts_per_page' => 5,  
		'columns' => 5,  
		'orderby' => 'DESC',  
	); 
return $args;
}*/

function memoo_wc_dropdown_variation_html($args = array()){
	$args = wp_parse_args( apply_filters( 'woocommerce_dropdown_variation_attribute_options_args', $args ), array(
            'options'          => false,
            'attribute'        => false,
            'product'          => false,
            'selected'         => false,
            'name'             => '',
            'id'               => '',
            'class'            => '',
            'show_option_none' => __( 'Choose an option', 'woocommerce' ),
    ));

    $options            	= $args['options'];
    $product            	= $args['product'];
    $attribute          	= $args['attribute'];
    $selected				= $args['selected'];
    $name               	= $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $attribute );
    $id                    	= $args['id'] ? $args['id'] : sanitize_title( $attribute );
    $class                	= $args['class'];
    $show_option_none      	= $args['show_option_none'] ? true : false;
    $show_option_none_text 	= $args['show_option_none'] ? $args['show_option_none'] : __( 'Choose an option', 'woocommerce' ); // We'll do our best to hide the placeholder, but we'll need to show something when resetting options.
    $attribute_nice_name 	= wc_attribute_label( $attribute );


    if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
        $attributes = $product->get_variation_attributes();
        $options    = $attributes[ $attribute ];
    }

    if ($selected) {
    	if ($product && taxonomy_exists( $attribute ) ) {
   			$terms = wc_get_product_terms( $product->get_id(), $attribute, array(
   				'fields' => 'all',
   			));

   			$chosen = '';

   			foreach ($terms as $key => $term) {
   				if ($selected == $term->slug ) {
   					$chosen = $term->name;
   				}
   			}

    		$html = '<span class="selected">'.__('Du har valgt: ', 'memoo').$chosen.'</span>';
    	} else {
    		$html = '<span class="selected">'.__('Du har valgt: ', 'memoo').$selected.'</span>';
    	}
    } else {
    	$html = '<span class="selected">'.$attribute_nice_name.'</span>';
    }
    
    $html .= '<ul class="dropdown '.$class.'" id="memoo_'.$id.'" data-attribute_slug="'.$name.'" data-show_option_none="'.$show_option_none.'" data-attribute_name="'.$attribute_nice_name.'">';
    $html .= '<li class="default"><a data-value="">'.$show_option_none_text.'</a></li>';

    if ( ! empty( $options ) ) {
        if ( $product && taxonomy_exists( $attribute ) ) {
            // Get terms if this is a taxonomy - ordered. We need the names too.
            $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

            foreach ( $terms as $term ) {
                if ( in_array( $term->slug, $options ) ) {
                	$html .= '<li><a data-value="'.esc_attr( $term->slug ).'">'.esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ).'</a></li>';
                }
            }
        } else {
            foreach ( $options as $option ) {
            	$html .= '<li><a data-attribute_name="'.$attribute.'" data-value="'.esc_attr( $option ).'">'.esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ).'</a></li>';
            }
        }
    }

    $html .= '</ul>';

    echo apply_filters( 'woocommerce_dropdown_variation_attribute_options_html', $html, $args );
}

function memoo_wc_qty_title() {
	return __('Antal','memoo');
}

function memoo_add_terms_after_cart_checkout_btn() {
	?>
	<div class="cart-totals-terms-wrapper">
		<span class="cart-term">
			<?php _e('Priser og leveringsomkostninger er ikke bekræftet, før du når frem til kassen.'); ?>
		</span>
		<span class="cart-term">
			<?php _e('Du har 14 dages fortrydelsesret. Læs mere her om '.sprintf(__('<a href="%s" target="_blank">returnering og tilbagebetaling.</a>', 'memoo'), esc_url( wc_get_page_permalink( 'terms' ) )), 'memoo'); ?>
		</span>
	</div>
	<?php
}
add_action('woocommerce_after_cart_totals', 'memoo_add_terms_after_cart_checkout_btn', 20);

add_filter( 'woocommerce_coupon_error', 'memoo_remove_coupon_removed_notice', 10, 2 );
function memoo_remove_coupon_removed_notice( $err, $err_code ) {
	return ( '201' == $err_code ) ? '' : $err;
}

add_filter( 'woocommerce_cart_item_price', 'memoo_change_cart_price_display', 30, 3 );
function memoo_change_cart_price_display( $price, $cart_item, $cart_item_key ) {
	return ($cart_item['data']->is_on_sale()) ? $cart_item['data']->get_price_html() : $price;
}