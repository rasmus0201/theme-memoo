<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
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
 * @version     2.3.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<div class="cart-totals-title-wrapper">
		<h2><?php _e( 'Cart totals', 'woocommerce' ); ?></h2>
	</div>

	<?php if ( wc_coupons_enabled() ) { ?>
		<form class="woocommerce-cart-coupon-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
			<div class="woocommerce-cart-coupon">
				<div class="coupon">
					<label for="coupon_code"><?php _e( 'Har du en rabatkode?', 'memoo' ); ?></label>
					<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" />
					<input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Tilføj', 'memoo' ); ?>" />
					<span class="error-message"></span>
					<?php do_action( 'woocommerce_cart_coupon' ); ?>
				</div>
			</div>
		</form>
	<?php } ?>

	<div class="cart-totals-pricing-wrapper">
		<div class="cart-subtotal">
			<span class="title left"><?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?></span>
			<span class="price right" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
				<?php wc_cart_totals_subtotal_html(); ?>
			</span>
		</div>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<div class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<span class="title left"><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
				<span class="name right" data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
			</div>
		<?php endforeach; ?>
		
		<?php /*
		
		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

				<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

				<?php wc_cart_totals_shipping_html(); ?>

				<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

		<?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

			<div class="cart-shipping shipping">
				<span class="title left"><?php _e( 'Shipping', 'woocommerce' ); ?></span>
				<span class="name right" data-title="<?php esc_attr_e( 'Shipping', 'woocommerce' ); ?>"><?php woocommerce_shipping_calculator(); ?></span>
			</div>

		<?php endif; ?>

		*/ ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<div class="cart-fee fee">
				<span class="title left"><?php echo esc_html( $fee->name ); ?></span>
				<span class="name right" data-title="<?php echo esc_attr( $fee->name ); ?>">
					<?php wc_cart_totals_fee_html( $fee ); ?>
				</span>
			</div>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && 'excl' === WC()->cart->tax_display_cart ) :
			$taxable_address = WC()->customer->get_taxable_address();
			$estimated_text  = WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping()
					? sprintf( ' <small>' . __( '(estimated for %s)', 'woocommerce' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] )
					: '';

			if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
					<div class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
						<span class="title left">
							<?php echo esc_html( $tax->label ) . $estimated_text; ?>
						</span>
						<span class="name right" data-title="<?php echo esc_attr( $tax->label ); ?>">
							<?php echo wp_kses_post( $tax->formatted_amount ); ?>
						</span>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="tax-total">
					<span class="title left">
						<?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; ?>
					</span>
					<span class="name right" data-title="<?php echo esc_attr( WC()->countries->tax_or_vat() ); ?>">
						<?php wc_cart_totals_taxes_total_html(); ?>
					</span>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

		<div class="order-total">
			<span class="left title"><?php _e( 'Total', 'woocommerce' ); ?></span>
			<span class="right name" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>">
				<?php wc_cart_totals_order_total_html(); ?>
			</span>
		</div>

		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

		<div class="wc-proceed-to-checkout">
			<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
		</div>
	</div>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
