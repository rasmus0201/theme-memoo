<?php

function memoo_widgets_init() {
	register_sidebar( array(
        'name' => 'Header Right',
        'id' => 'header-right',
        'description' => 'Appears to the right of the main menuu',
        'before_widget' => '<div id="%1$s" class="site-info %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
    
    register_sidebar( array(
        'name' => 'Cart Totals Bottom',
        'id' => 'cart-right-bottom',
        'description' => 'Appears under the cart totals',
        'before_widget' => '<div id="%1$s" class="cart_totals_bottom_widget site-info %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

	register_sidebar( array(
		'name'          => esc_html__( 'Shop sidebar', 'memoo' ),
		'id'            => 'sidebar-shop',
		'description'   => esc_html__( 'Tilføj widget her', 'memoo' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Left sidebar', 'memoo' ),
		'id'            => 'sidebar-left',
		'description'   => esc_html__( 'Tilføj widget her', 'memoo' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Right sidebar', 'memoo' ),
		'id'            => 'sidebar-right',
		'description'   => esc_html__( 'Tilføj widget her', 'memoo' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

    register_sidebar( array(
        'name' => 'Footer Sidebar 1',
        'id' => 'footer-sidebar-1',
        'description' => 'Appears in the footer area',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

    register_sidebar( array(
        'name' => 'Footer Sidebar 2',
        'id' => 'footer-sidebar-2',
        'description' => 'Appears in the footer area',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

    register_sidebar( array(
        'name' => 'Footer Sidebar 3',
        'id' => 'footer-sidebar-3',
        'description' => 'Appears in the footer area',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

    register_sidebar( array(
        'name' => 'Footer Sidebar 4',
        'id' => 'footer-sidebar-4',
        'description' => 'Appears in the footer area',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

	register_sidebar( array(
        'name' => 'Footer Bottom',
        'id' => 'footer-bottom',
        'description' => 'Appears at the bottom of pages',
        'before_widget' => '<div id="%1$s" class="site-info %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
}
add_action( 'widgets_init', 'memoo_widgets_init' );

// Register and load the widget
function memoo_load_widgets() {
    register_widget('Memoo_Woocommerce_Minicart_Widget');
}
add_action('widgets_init', 'memoo_load_widgets');

// Creating the widget
class Memoo_Woocommerce_Minicart_Widget extends WP_Widget {

	function __construct() {
		$options = [
			'description' => esc_html__( 'Adds WooCommerce minicart widget', 'memoo' )
		];

		parent::__construct('Memoo_Woocommerce_Minicart', esc_html__('Mini kurv', 'memoo'), $options);
	}

	// Creating widget front-end
	public function widget( $args, $instance ) {
		$icon_position = ! empty( $instance['icon_position_after'] ) ? 'after' : 'before';
		$hide_count = ! empty( $instance['hide_count'] ) ? '0' : '1';

		echo do_shortcode('[memooo_wc_minicart is_widget="1" icon_classes="'.$instance['icon_classes'].'" text="'.$instance['text'].'" icon_position="'.$icon_position.'" hide_count="'.$hide_count.'"]');
		woocommerce_mini_cart();
		echo '</div>';
	}

	// Widget Backend
	public function form( $instance ) {
		$instance = wp_parse_args(
			(array)$instance,
			array(
				'text' => '',
				'icon_classes' => 'far fa-shopping-cart',
				'icon_position_after' => 0,
				'hide_count' => 0,
			)
		);
		$text = sanitize_text_field( $instance['text'] );
		$icon_classes = sanitize_text_field( $instance['icon_classes'] );

		?>
		<p>
			<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:', 'memoo'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo esc_attr($text); ?>" >
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('icon_classes'); ?>"><?php _e('Icon classes:', 'memoo'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('icon_classes'); ?>" name="<?php echo $this->get_field_name('icon_classes'); ?>" type="text" value="<?php echo esc_attr($icon_classes); ?>" >
		</p>
		<p>
			<input class="checkbox" type="checkbox"<?php checked( $instance['icon_position_after'] ); ?> id="<?php echo $this->get_field_id('icon_position_after'); ?>" name="<?php echo $this->get_field_name('icon_position_after'); ?>" >
			<label for="<?php echo $this->get_field_id('icon_position_after'); ?>"><?php _e('Display icon after text?'); ?></label>
			<br/>
			<input class="checkbox" type="checkbox"<?php checked( $instance['hide_count'] ); ?> id="<?php echo $this->get_field_id('hide_count'); ?>" name="<?php echo $this->get_field_name('hide_count'); ?>" >
			<label for="<?php echo $this->get_field_id('hide_count'); ?>"><?php _e('Hide cart product count'); ?></label>
		</p>
		<?php
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args(
			(array)$new_instance,
			array(
				'text' => '',
				'icon_classes' => 'far fa-shopping-cart',
				'icon_position_after' => 0,
				'hide_count' => 0
			)
		);

		$instance['text'] = sanitize_text_field( $new_instance['text'] );
		$instance['icon_classes'] = sanitize_text_field( $new_instance['icon_classes'] );
		$instance['hide_count'] = $new_instance['hide_count'] ? 1 : 0;
		$instance['icon_position_after'] = $new_instance['icon_position_after'] ? 1 : 0;

		return $instance;
	}
}
