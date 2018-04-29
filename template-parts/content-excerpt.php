<?php
/**
 * Template part for displaying posts with excerpts
 *
 * Used in Search Results and for Recent Posts in Front Page panels.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package memoo
*/
?>
<div class="inner-container">
	<hr>
</div>
<div class="inner-container">
	<div class="row flex-start">
		<div class="col-xs">
			<h2 class="bigger-space"><?php esc_html_e('Flere blogindlæg', 'memoo'); ?></h2>
		</div>
	</div>
	<div class="row flex-start">
	<?php
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 0;

		if (!is_single()) {
			$args = array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'posts_per_page' => 6,
				'offset' => $paged * 6,
				'orderby' => 'post_date',
				'order' => 'DESC',
				'post__not_in' => array( get_the_ID() ),
			);
		} else {
			$args = array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'posts_per_page' => 3,
				'orderby' => 'post_date',
				'order' => 'DESC',
				'post__not_in' => array( get_the_ID() ),
			);
		}

		$featured_post_id = get_option('memoo_featured_post', '');

		if ($featured_post_id !== '') {
		    $args['post__not_in'] = array( get_the_ID(), $featured_post_id );
		}


		$query = new WP_Query($args);

		if ($query->have_posts()) :
			while( $query->have_posts() ) :
				$query->the_post();

				if (has_post_thumbnail()) {
					$image_src = get_the_post_thumbnail_url();
				} else {
					$image_src = get_template_directory_uri() . '/assets/img/blank.png';
				}

				?>
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 blog-item-more">
					<a href="<?php the_permalink(); ?>" class="inherit">
						<div class="post-image-container" style="background-image:url('<?php echo $image_src; ?>')"></div>
						<div class="post-text">
							<strong><?php the_title(); ?>&nbsp;</strong>
							<?php echo memoo_excerpt( get_the_excerpt() ); ?>
						</div>
						<div class="post-date"><?php the_time(get_option('date_format')); ?></div>
					</a>
				</div>
			<?php
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
		<?php
		endif;
		?>
	</div>
</div>
