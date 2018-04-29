<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Memoo
 */
get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main <?php echo (memoo_is_blog()) ? 'blog-page' : '';?>">
			<?php
			$args = array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'posts_per_page' => 1,
			);

			$query = new WP_Query($args);

			if ($query->have_posts()) {
				$featured_post_args = array(
					'numberposts' => 1,
					'offset' => 0,
					'orderby' => 'post_date',
					'order' => 'DESC',
					'post_type' => 'post',
					'post_status' => 'publish',
				);

				$featured_post_id = get_option('memoo_featured_post', '');

				if ($featured_post_id !== '') {
				    $featured_post_args['post__in'] = array($featured_post_id);
				}

				$recent_post = wp_get_recent_posts( $featured_post_args )[0];
				$recent_post_id = $recent_post['ID'];
				$image_src = get_the_post_thumbnail_url($recent_post_id, 'full');

				if (!$image_src) {
					//No image get default
					$image_src = get_template_directory_uri() . '/assets/img/blank.png';
				}

				?>
				<article class="featured-post">
					<h1 class="large-header bigger-space"><?php esc_html_e('Seneste blogindlæg', 'memoo'); ?></h1>
					<a href="<?php the_permalink($recent_post_id); ?>" class="inherit">
						<div class="featured-post-wrapper">
							<div class="featured-post-image-container" style="background-image: url('<?php echo $image_src; ?>');"></div>
							<div class="featured-post-text">
								<strong><?php echo $recent_post['post_title']; ?></strong>
								<?php echo memoo_excerpt($recent_post['post_content']); ?>
								<time><?php the_time(get_option('date_format'), $recent_post_id); ?></time>
							</div>
						</div>
					</a>
				</article>
				<?php get_template_part('template-parts/content', 'excerpt'); ?>
			<?php
			} else {
				get_template_part('template-parts/content', 'none');
			}
			?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
