<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

	<?php
		$image_url = false;

		if (is_product_category()) {
			global $wp_query;
			$cat = $wp_query->get_queried_object();
			$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
			$image_url = wp_get_attachment_url( $thumbnail_id );
		}

		if ($image_url) {
			wc_get_template_part( 'archive', 'image' );
		} else {
			wc_get_template_part( 'archive', 'no-image' );
		}
	?>

<?php get_footer( 'shop' );

if (get_option('memoo_woocommerce_show_popup_after_add_to_cart', false) == true) {
	wc_get_template( 'single-product/popup.php' );
}

?>
