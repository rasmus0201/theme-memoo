<?php if ( has_custom_logo() ) : ?>
    <?php the_custom_logo(); ?>
<?php else: ?>
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url">
        <h1><?php bloginfo( 'name' ); ?></h1>
    </a>
<?php endif; ?>
