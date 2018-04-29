<?php $fb_page = get_option('memoo_header_facebook_url', 'https://fb.com'); ?>
<nav id="social-nav">
    <ul id="social-menu" class="menu">
        <li class="facebook menu-item-even menu-item-depth-0 menu-item menu-item-type-custom menu-item-object-custom">
            <a target="_blank" href="<?php echo $fb_page; ?>" rel="nofollow">
                <i class="fab fa-facebook-square" aria-hidden="true"></i>
                <span class="menu-list-item-title">Facebook</span>
            </a>
        </li>
    </ul>
</nav>
<nav id="social-nav-mobile">
    <ul id="social-mobile-menu" class="menu">
        <li class="menu-item-even menu-item-depth-0 menu-item menu-item-type-custom menu-item-object-custom">
            <a target="_blank" href="<?php echo $fb_page; ?>" rel="nofollow">
                <i class="fab fa-facebook-f" aria-hidden="true"></i>
                <span class="menu-list-item-title">Facebook</span>
            </a>
        </li>
    </ul>
</nav>
