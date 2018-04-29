<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Memoo
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<!-- header -->
	<header id="main-header" class="<?php echo (get_option('memoo_fixed_header', '') != '') ? 'fixed' : ''; ?>">
		<div id="header-inner-wrapper">
			<div id="menu-1" class="site-title">
				<?php get_template_part('template-parts/header/partials/partials', 'logo'); ?>
			</div>
			<nav id="menu-2">
				<!-- Denne er mobil burgermenu -->
				<?php get_template_part('template-parts/header/partials/partials', 'burger_menu'); ?>

				<!-- Denne er tablet/computer menu -->
				<?php get_template_part('template-parts/header/partials/partials', 'navigation'); ?>
			</nav>
			<div id="menu-3">
				<?php
				$option = get_option('memoo_header_use_of_social_nav', '');
				if ($option != '') : ?>
					<?php switch ($option) :
						case 'facebook': ?>
							<?php get_template_part('template-parts/header/partials/partials', 'social_menu'); ?>
						<?php break; ?>
						<?php case 'wpml': ?>
							<?php get_template_part('template-parts/header/partials/partials', 'wpml'); ?>
						<?php break; ?>
						<?php case 'nothing': ?>

						<?php break; ?>
					<?php endswitch; ?>
				<?php else: ?>
					<?php get_template_part('template-parts/header/partials/partials', 'social_menu'); ?>
				<?php endif; ?>
			</div>
			<div id="menu-4">
				<?php dynamic_sidebar('header-right'); ?>
			</div>
		</div>
	</header>
	<!-- /header -->

	<div id="content" class="site-content">
