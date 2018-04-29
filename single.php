<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Memoo
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main blog-page">
			<?php
				if ( have_posts() ) :
					while ( have_posts() ) : the_post();

						get_template_part( 'template-parts/content', get_post_type() );

						get_template_part( 'template-parts/content', 'excerpt' );

						//the_post_navigation();

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
				else :
					get_template_part( 'template-parts/content', 'none' );
				endif;
			?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
