<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package memoo
 */

?>

<section class="no-results not-found">
	<header class="page-header">
		<?php memoo_custom_page_heading(esc_html( 'Ups, vi fandt desværre ikke noget.', 'memoo' ), '<h1 class="page-title">', '</h1>', true); ?>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php get_search_form(); ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
