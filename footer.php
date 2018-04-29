<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Memoo
 */

$active = [];

if ( is_active_sidebar('footer-sidebar-1') ) {
	$active['footer-1'] = true;
}
if ( is_active_sidebar('footer-sidebar-2') ) {
	$active['footer-2'] = true;
}
if ( is_active_sidebar('footer-sidebar-3') ) {
	$active['footer-3'] = true;
}
if ( is_active_sidebar('footer-sidebar-4') ) {
	$active['footer-4'] = true;
}

$col_class = 'col col-xs';
$col_class .= ' b-col-xs-12';

if (count($active) == 4) {
	$col_class .= ' b-col-sm-6';
	$col_class .= ' b-col-md-6';
	$col_class .= ' b-col-lg-3';
	$col_class .= ' b-col-xl-3';
} elseif (count($active) == 3) {
	$col_class .= ' b-col-sm-12';
	$col_class .= ' b-col-md-4';
	$col_class .= ' b-col-lg-4';
	$col_class .= ' b-col-xl-4';
} elseif (count($active) == 2) {
	$col_class .= ' b-col-sm-6';
	$col_class .= ' b-col-md-6';
	$col_class .= ' b-col-lg-6';
	$col_class .= ' b-col-xl-6';
} else {
	$col_class .= ' b-col-sm-12';
	$col_class .= ' b-col-md-12';
	$col_class .= ' b-col-lg-12';
	$col_class .= ' b-col-xl-12';
}
?>

	</div><!-- #content -->
	<?php if ( count($active) > 0 ) : ?>
		<div id="footer-widgets">
			<div id="footer-widgets-inner-wrapper">
				<div class="row between-xs">
					<?php if( is_active_sidebar('footer-sidebar-1') ) : ?>
						<div class="<?php echo $col_class?>">
							<?php dynamic_sidebar('footer-sidebar-1'); ?>
						</div>
					<?php endif; ?>

					<?php if( is_active_sidebar('footer-sidebar-2') ) : ?>
						<div class="<?php echo $col_class?>">
							<?php dynamic_sidebar('footer-sidebar-2'); ?>
						</div>
					<?php endif; ?>

					<?php if( is_active_sidebar('footer-sidebar-3') ) : ?>
						<div class="<?php echo $col_class?>">
							<?php dynamic_sidebar('footer-sidebar-3'); ?>
						</div>
					<?php endif; ?>

					<?php if( is_active_sidebar('footer-sidebar-4') ) : ?>
						<div class="<?php echo $col_class?>">
							<?php dynamic_sidebar('footer-sidebar-4'); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?php if ( is_active_sidebar('footer-bottom') ) : ?>
		<footer id="footer" class="site-footer">
			<div id="footer-innner-wrapper">
				<?php dynamic_sidebar('footer-bottom'); ?>
			</div><!-- #footer-inner-wrapper -->
		</footer><!-- #footer -->
	<?php endif; ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
