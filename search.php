<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Memoo
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">
			<?php
				if ( have_posts() ) : ?>
					<section class="search-results">
						<header class="page-header">
							<?php memoo_custom_page_heading(esc_html( 'Hvad leder du efter?', 'memoo' ), '<h1 class="page-title">', '</h1>', true); ?>
						</header><!-- .page-header -->

						<div class="page-content">
							<?php get_search_form(); ?>

							<div class="row we-found-results">
								<div class="col-xs">
									<?php
										global $wp_query;
									?>
									<p>
										<?php echo sprintf(__('Vi fandt <strong>%s</strong> resultater for "%s"', 'memoo'), $wp_query->found_posts, get_search_query());?>
									</p>
								</div>
							</div>
						</div><!-- .page-content -->
					</section><!-- .search-results -->

					<div class="row flex-start">

						<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();
							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'template-parts/content', 'search' );

						endwhile;

						?>
						<div class="col-xs-12">
							<?php the_posts_pagination( array(
								'prev_text' => '<i class="far fa-chevron-left"></i><span class="screen-reader-text">' . __( 'Forrige blogindlæg', 'memoo' ) . '</span>',
								'next_text' => '<span class="screen-reader-text">' . __( 'Næste blogindlæg', 'memoo' ) . '</span><i class="far fa-chevron-right"></i>',
								'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Side', 'memoo' ) . ' </span>',
							) );
							?>
						</div>
					</div>
					<?php
				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
			?>
		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
