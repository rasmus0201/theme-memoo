<?php
    /**
     * woocommerce_before_main_content hook.
     *
     * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
     * @hooked woocommerce_breadcrumb - 20
     * @hooked WC_Structured_Data::generate_website_data() - 30
     */
    do_action( 'woocommerce_before_main_content' );
?>
<div class="row no-gutters container-fullwidth">
    <div class="col col-xs-12">
        <?php
            global $wp_query;
            $cat = $wp_query->get_queried_object();
            $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
            $image_url = wp_get_attachment_url( $thumbnail_id );
        ?>

        <div class="woocommerce-archive-header-image" style="background-image: url(<?php echo $image_url; ?>)">
            <?php do_action( 'memoo_woocommerce_breadcrumb' ); ?>
            <div class="woocommerce-page-top-text content-width">
                <h1 class="woocommerce-page-title"><?php woocommerce_page_title(); ?></h1>
                <p class="woocommerce-page-description">
                    <?php memoo_excerpt_max_charlength(200); ?>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="row no-gutters">
    <?php if (get_option('memoo_woocommerce_catalog_filter_visibility', false) != true && is_active_sidebar('sidebar-shop') && !is_product()): ?>
        <aside class="col col-xs-12 col-md-3 col-sidebar">
            <?php dynamic_sidebar( 'sidebar-shop' ); ?>
        </aside>
        <section class="col col-xs-12 col-md-9 col-content">
    <?php else: ?>
        <section class="col col-xs-12">
    <?php endif; ?>

        <header class="woocommerce-products-header content-width">

            <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

                <p class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></p>

            <?php endif; ?>

            <?php
                /**
                 * woocommerce_archive_description hook.
                 *
                 * @hooked woocommerce_taxonomy_archive_description - 10
                 * @hooked woocommerce_product_archive_description - 10
                 */
                do_action( 'woocommerce_archive_description' );
            ?>
        </header>
        <div class="woocommerce-catalog-bar">
            <div class="row no-gutters content-width">
                <div class="col col-xs-6">
                    <?php do_action('memoo_woocommerce_catalog_bar_right'); ?>
                </div>
                <div class="col col-xs-6">
                    <?php do_action('memoo_woocommerce_catalog_bar_left'); ?>
                </div>
            </div>
        </div>
        <div class="woocommerce-products-result content-width">
            <?php if ( have_posts() ) : ?>
                <?php
                    /**
                     * woocommerce_before_shop_loop hook.
                     *
                     * @hooked wc_print_notices - 10
                     */
                    do_action( 'woocommerce_before_shop_loop' );
                ?>

                <?php woocommerce_product_loop_start(); ?>

                    <?php woocommerce_product_subcategories(); ?>

                    <?php while ( have_posts() ) : the_post(); ?>

                        <?php
                            /**
                             * woocommerce_shop_loop hook.
                             *
                             * @hooked WC_Structured_Data::generate_product_data() - 10
                             */
                            do_action( 'woocommerce_shop_loop' );
                        ?>

                        <?php wc_get_template_part( 'content', 'product' ); ?>

                    <?php endwhile; // end of the loop. ?>

                <?php woocommerce_product_loop_end(); ?>

                <?php
                    /**
                     * woocommerce_after_shop_loop hook.
                     *
                     * @hooked woocommerce_pagination - 10
                     */
                    do_action( 'woocommerce_after_shop_loop' );
                ?>

            <?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

                <?php
                    /**
                     * woocommerce_no_products_found hook.
                     *
                     * @hooked wc_no_products_found - 10
                     */
                    do_action( 'woocommerce_no_products_found' );
                ?>

            <?php endif; ?>
        </div>

        <?php
            /**
             * woocommerce_after_main_content hook.
             *
             * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
             */
            do_action( 'woocommerce_after_main_content' );
        ?>

        <?php
            /**
             * woocommerce_sidebar hook.
             *
             * @hooked woocommerce_get_sidebar - 10
             */
            do_action( 'woocommerce_sidebar' );
        ?>
    </section>
</div>
