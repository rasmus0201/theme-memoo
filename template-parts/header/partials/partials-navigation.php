<div id="navigation-wrapper">
    <?php if (has_nav_menu('primary-menu')): ?>
        <?php
            wp_nav_menu( array(
                'theme_location'	=> 'primary-menu',
                'menu_id'        	=> 'primary-menu',
                'container'			=> false,
                'depth'				=> 3,
                'walker'			=> new Memoo_walker_nav_menu
            ) );
        ?>
    <?php else: ?>
        Du skal oprette en menu og angive den som "primær"
    <?php endif; ?>
</div>
