<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
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
 * @version     2.2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wp_query;

if ( $wp_query->max_num_pages <= 1 ) {
	return;
}
?>
<nav class="woocommerce-pagination">
	<ul>
		<li>
			<?php if (in_array(get_query_var( 'paged' ), [0,1])): ?>
				<a class="disabled" href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" disabled><i class="far fa-long-arrow-left"></i></a>
			<?php else: ?>
				<?php echo previous_posts_link('<i class="far fa-long-arrow-left"></i>'); ?>
			<?php endif; ?>
		</li>
		<li><span class="text">Side <?php echo trim(max( 1, get_query_var( 'paged' ) )).' af '.trim($wp_query->max_num_pages); ?></span></li>
		<li>
			<?php if (get_query_var( 'paged' ) == $wp_query->max_num_pages): ?>
				<a class="disabled" href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ).'page/'.$wp_query->max_num_pages.'/'; ?>" disabled><i class="far fa-long-arrow-right"></i></a>
			<?php else: ?>
				<?php echo next_posts_link('<i class="far fa-long-arrow-right"></i>', $wp_query->max_num_pages); ?>
			<?php endif; ?>
		</li>
	</ul>
</nav>
