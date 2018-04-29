<?php
/**
 * Template part for displaying posts in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package memoo
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if (has_post_thumbnail()) : ?>
			<div class="post-image-container" style="background-image: url('<?php the_post_thumbnail_url(); ?>');"></div>
		<?php endif; ?>
	</header><!-- .entry-header -->
	<div class="entry-content">
		<?php memoo_custom_page_heading(get_the_title(), '<h1 class="entry-title">', '</h1>', true); ?>
		<?php the_content(); ?>
	</div><!-- .entry-content -->
	<footer class="entry-footer">
		<div class="post-date"><?php the_time(get_option('date_format')); ?></div>
		<strong class="share-title"><?php _e('Del', 'memoo');?></strong>
		<span class="share-item">
			<a class="share-facebook" title="<?php echo esc_html_x( 'Del på Facebook', 'post title', 'memoo' ); ?>" rel="external" href="http://www.facebook.com/sharer.php?m2w&s=100&p[title]=<?php the_title(); ?>&p[url]=<?php echo esc_url( get_permalink() ); ?>
				&p[images][0]=
				<?php
				if ( has_post_thumbnail() == true) {
					the_post_thumbnail_url('full');
				}else {
					echo wp_get_attachment_url( get_theme_mod( 'custom_logo' ), 'full', false);
				}?>">
				<i class="fab fa-facebook-f"></i>
			</a>
		</span>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Sider:', 'memoo' ),
				'after'  => '</div>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			) );
		?>

		<?php if ( get_edit_post_link() ) : ?>
			<?php
				edit_post_link(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Rediger <span class="screen-reader-text">%s</span>', 'memoo' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					),
					'<span class="edit-link">',
					'</span>'
				);
			?>
		<?php endif; ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
