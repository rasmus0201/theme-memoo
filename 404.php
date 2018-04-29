<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package memoo
 */

get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<section class="error-404 not-found">
				<header class="page-header">
					<?php memoo_custom_page_heading(esc_html( 'Ups, vi fandt desværre ikke noget...', 'memoo' ), '<h1 class="page-title">', '</h1>', true); ?>
				</header><!-- .page-header -->

				<div class="page-content">
					<?php get_search_form(); ?>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
