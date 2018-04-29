<div class="modal">
	<div class="modal-overlay"></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="row no-gutters">
				<div class="col col-xs-12">
					<h3 class="modal-title">
						<i class="fas fa-check"></i>
						<span class="added-product"></span>
						<?php _e('Produktet blev tilføjet til kurven.', 'memoo'); ?>
					</h3>
				</div>
				<div class="col center-xs col-xs-12 col-md-6">
					<a class="button button-underline" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
						<?php _e( 'Shop videre', 'memoo' ) ?>
					</a>
				</div>
				<div class="col center-xs col-xs-12 col-md-6">
					<a class="button button-dark" href="<?php echo esc_url( wc_get_page_permalink( 'cart' ) ); ?>">
						<i class="fal fa-shopping-bag"></i>
						<?php _e( 'Gå til kurven', 'memoo' ) ?>	
					</a>
				</div>
			</div>
		</div>
	</div>
</div>