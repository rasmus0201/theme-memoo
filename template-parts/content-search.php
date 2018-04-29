<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package memoo
 */

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
