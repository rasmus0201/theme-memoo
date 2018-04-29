<?php
function memoo_add_theme_options_page(){
	add_theme_page( 'Memoo Options', 'Memoo Options', 'manage_options', 'memoo-options', 'memoo_extra_theme_options_page' );

	//Comment the out to hide Theme Options
	add_theme_page( 'Theme Options', 'Theme Options', 'manage_options', 'theme-options', 'memoo_theme_options_page' );
}
add_action('admin_menu', 'memoo_add_theme_options_page');

function memoo_extra_theme_options_page(){
	?>
	<div class="wrap">
		<h1>Memoo Options</h1>
		<br><br>
		<form method="post" action="options.php">
			<?php
				//Create your own settings
				
				//settings_fields('memoo-settings');
				//do_settings_sections('memoo-options');
				//submit_button();
			?>
		</form>
	</div>
	<?php
}

function memoo_theme_settings(){
    $settings = [
        [
            'id'            => 'section-1',
            'display_title' => 'Side indstillinger',
            'fields'        => [
                'memoo_boxed_layout'                                	=> ['id' => 'memoo_boxed_layout', 'label' => 'Boxed layout?', 'type' => 'checkbox', 'desc' => 'Default: False'],
                'memoo_boxed_layout_breakpoint'                         => ['id' => 'memoo_boxed_layout_breakpoint', 'label' => 'Page width breakpoint', 'type' => 'text', 'desc' => 'Default: 1600px'],
                'memoo_display_boxed_layout_shadow'                 	=> ['id' => 'memoo_display_boxed_layout_shadow', 'label' => 'Page box-shadow', 'type' => 'text', 'desc' => 'Default: 0px 0px 10px rgba(0,0,0, 0.4)'],
                'memoo_fixed_header'                          			=> ['id' => 'memoo_fixed_header', 'label' => 'Use Fixed Header', 'type' => 'checkbox', 'desc' => 'Default: False'],
                'memoo_header_hide_menu_arrows'                         => ['id' => 'memoo_header_hide_menu_arrows', 'label' => 'Hide Menu Arrows', 'type' => 'checkbox', 'desc' => 'Default: False'],
                'memoo_hide_page_headings'                          	=> ['id' => 'memoo_hide_page_headings', 'label' => 'Hide Page Headings (Titles)', 'type' => 'checkbox', 'desc' => 'Default: False'],
                'memoo_hide_special_page_headings'                  	=> ['id' => 'memoo_hide_special_page_headings', 'label' => 'Hide Special Page Headings (404, Search, etc.)', 'type' => 'checkbox', 'desc' => 'Default: False'],
                'memoo_hide_woocommerce_page_headings'                 	=> ['id' => 'memoo_hide_woocommerce_page_headings', 'label' => 'Hide Woocommerce Page Headings', 'type' => 'checkbox', 'desc' => 'Default: False'],
                'memoo_header_facebook_url'                 			=> ['id' => 'memoo_header_facebook_url', 'label' => 'Facebook page url (with https)', 'type' => 'text', 'desc' => 'Default: https://fb.com'],
                'memoo_header_use_of_social_nav'                 		=> ['id' => 'memoo_header_use_of_social_nav', 'label' => 'What to display next to navigation', 'type' => 'radio',
					'options' => [
						0 => [
							'value' 	=> 'facebook',
							'desc' 		=> 'Facebook Icon',
							'default' 	=> true,
						],
						1 => [
							'value' 	=> 'wpml',
							'desc' 		=> 'WPML Language switcher',
						],
						2 => [
						    'value' 	=> 'nothing',
						    'desc' 		=> 'Nothing',
						],
					]
				],
            ],
        ],
		[
			'id'            => 'section-2',
            'display_title' => 'Woocommerce',
			'fields'		=> [
				'memoo_woocommerce_product_button_position' => [
					'id' => 'memoo_woocommerce_product_button_position',
					'label' => 'Køb knap placering',
					'type' => 'radio',
					'options' => [
						0 => [
							'value' 	=> 'below',
							'desc' 		=> 'Under produktbillede',
							'default' 	=> true,
						],
						1 => [
							'value' 	=> 'hover',
							'desc' 		=> 'Vis på hover af produktbillede',
						],
						2 => [
							'value' 	=> 'hide',
							'desc' 		=> 'Vis ikke',
						],
					],
				],
				'memoo_woocommerce_catalog_filter_visibility' => [
					'id'		=> 'memoo_woocommerce_catalog_filter_visibility',
					'label'		=> 'Disable Filtering Sidebar',
					'type'		=> 'checkbox',
					'desc'		=> 'Default: False'
				],
				'memoo_woocommerce_show_popup_after_add_to_cart' => [
					'id'		=> 'memoo_woocommerce_show_popup_after_add_to_cart',
					'label'		=> 'Show popup after add to cart',
					'type'		=> 'checkbox',
					'desc'		=> 'Default: False'
				],
                'memoo_woocommerce_product_pr_row_desktop' => [
					'id' => 'memoo_woocommerce_product_pr_row_desktop',
					'label' => 'Products pr. row (desktop)',
					'type' => 'radio',
					'options' => [
						0 => [
							'value' 	=> 'products-desktop-2',
							'desc' 		=> '2',
						],
						1 => [
							'value' 	=> 'products-desktop-3',
							'desc' 		=> '3',
						],
						2 => [
						    'value' 	=> 'products-desktop-4',
						    'desc' 		=> '4',
							'default' 	=> true,
						],
						3 => [
						    'value' 	=> 'products-desktop-5',
						    'desc' 		=> '5',
						],
					]
				],
                'memoo_woocommerce_product_pr_row_tablet' => [
					'id' => 'memoo_woocommerce_product_pr_row_tablet',
					'label' => 'Products pr. row (tablet)',
					'type' => 'radio',
					'options' => [
						0 => [
							'value' 	=> 'products-tablet-1',
							'desc' 		=> '1',
						],
						1 => [
							'value' 	=> 'products-tablet-2',
							'desc' 		=> '2',
						],
						2 => [
						    'value' 	=> 'products-tablet-3',
						    'desc' 		=> '3',
							'default' 	=> true,
						],
						3 => [
						    'value' 	=> 'products-tablet-4',
						    'desc' 		=> '4',
						],
					]
				],
                'memoo_woocommerce_product_pr_row_mobile' => [
					'id' => 'memoo_woocommerce_product_pr_row_mobile',
					'label' => 'Products pr. row (mobile)',
					'type' => 'radio',
					'options' => [
						0 => [
							'value' 	=> 'products-mobile-1',
							'desc' 		=> '1',
							'default' 	=> true,
						],
						1 => [
							'value' 	=> 'products-mobile-2',
							'desc' 		=> '2',
						],
						2 => [
						    'value' 	=> 'products-mobile-3',
						    'desc' 		=> '3',
						],
					]
				],
				'memoo_woocommerce_products_pr_page' => [
					'id'		=> 'memoo_woocommerce_products_pr_page',
					'label'		=> 'Number of products pr. page',
					'type'		=> 'number',
					'desc'		=> 'Default: 24'
				],
				'memoo_woocommerce_related_products_visibility' => [
					'id'		=> 'memoo_woocommerce_related_products_visibility',
					'label'		=> 'Disable related products',
					'type'		=> 'checkbox',
					'desc'		=> 'Default: False'
				],
				'memoo_woocommerce_breadcrumbs_seperator' => [
					'id'		=> 'memoo_woocommerce_breadcrumbs_seperator',
					'label'		=> 'Breadcrumbs seperator',
					'type'		=> 'text',
					'desc'		=> 'Default: /'
				],
				'memoo_woocommerce_breadcrumbs_visibility' => [
					'id'		=> 'memoo_woocommerce_breadcrumbs_visibility',
					'label'		=> 'Disable breadcrumbs',
					'type'		=> 'checkbox',
					'desc'		=> 'Default: False'
				],
			]
		],
        [
            'id'            => 'section-3',
            'display_title' => 'Vælg Farver (Main)',
            'fields'        => [
                'memoo_display_main_color_boxed_layout_body_background'    => ['id' => 'memoo_display_main_color_boxed_layout_body_background', 'label' => 'Body background (boxed layout)', 'type' => 'text', 'desc' => 'Default: #dfe3e8'],
                'memoo_display_main_color_boxed_layout_page_background'    => ['id' => 'memoo_display_main_color_boxed_layout_page_background', 'label' => 'Page background (boxed layout)', 'type' => 'text', 'desc' => 'Default: #fff'],

                'memoo_display_main_color_headings'         => ['id' => 'memoo_display_main_color_headings', 'label' => 'Headings Color', 'type' => 'text', 'desc' => 'Default: #151515 (H1, H2, H3, H4, H5, H6)'],

                'memoo_display_main_color_text'             => ['id' => 'memoo_display_main_color_text', 'label' => 'Text Color', 'type' => 'text', 'desc' => 'Default: #151515'],
                'memoo_display_main_color_text_inverse'     => ['id' => 'memoo_display_main_color_text_inverse', 'label' => 'Text Inverse Color', 'type' => 'text', 'desc' => 'Default: #fff'],
                'memoo_display_main_color_link'             => ['id' => 'memoo_display_main_color_link', 'label' => 'Links Color', 'type' => 'text', 'desc' => 'Default: #C62B2B'],
                'memoo_display_main_color_link_hover'       => ['id' => 'memoo_display_main_color_link_hover', 'label' => 'Links hover Color', 'type' => 'text', 'desc' => 'Default: rgba(194, 14, 13, 0.8)'],
            ],
        ],
        [
            'id'            => 'section-4',
            'display_title' => 'Vælg Farver (Header)',
            'fields'        => [
				'memoo_display_header_color_background'                     => ['id' => 'memoo_display_header_color_background', 'label' => 'Background Color', 'type' => 'text', 'desc' => 'Default: #fff'],
				'memoo_scroll_header_color_background'                     	=> ['id' => 'memoo_scroll_header_color_background', 'label' => 'Scrolled Background Color', 'type' => 'text', 'desc' => 'Default: #fff'],

				'memoo_display_header_color_background_submenu'             => ['id' => 'memoo_display_header_color_background_submenu', 'label' => 'Submenu Background Color', 'type' => 'text', 'desc' => 'Default: #fff'],
                'memoo_display_header_color_background_subsubmenu'          => ['id' => 'memoo_display_header_color_background_subsubmenu', 'label' => 'Sub-submenu Background Color', 'type' => 'text', 'desc' => 'Default: #fff'],

                'memoo_display_header_color_mobile_background'              => ['id' => 'memoo_display_header_color_mobile_background', 'label' => 'Mobile Background Color', 'type' => 'text', 'desc' => 'Default: #C62B2B'],
                'memoo_display_header_color_mobile_background_submenu'      => ['id' => 'memoo_display_header_color_mobile_background_submenu', 'label' => 'Mobile Submenu Background Color', 'type' => 'text', 'desc' => 'Default: rgba(194, 14, 13, 0.8)'],
                'memoo_display_header_color_mobile_background_subsubmenu'   => ['id' => 'memoo_display_header_color_mobile_background_subsubmenu', 'label' => 'Mobile Sub-submenu Background Color', 'type' => 'text', 'desc' => 'Default: #B50100'],

				'memoo_display_header_color_desktop_background_menuitem'   	=> ['id' => 'memoo_display_header_color_desktop_background_menuitem', 'label' => 'Desktop 1. Menu Item Background Color', 'type' => 'text', 'desc' => 'Default: #fff'],
                'memoo_display_header_color_desktop_menu_item_hover'   		=> ['id' => 'memoo_display_header_color_desktop_menu_item_hover', 'label' => 'Desktop 1. Menu Item Hover Link Color', 'type' => 'text', 'desc' => 'Default: rgba(194, 14, 13, 0.8)'],

                'memoo_display_header_color_text_mobile'             		=> ['id' => 'memoo_display_header_color_text_mobile', 'label' => 'Text Color Mobile', 'type' => 'text', 'desc' => 'Default: #fff'],

				'memoo_display_header_color_text'             => ['id' => 'memoo_display_header_color_text', 'label' => 'Text Color', 'type' => 'text', 'desc' => 'Default: #151515'],
                'memoo_display_header_color_text_inverse'     => ['id' => 'memoo_display_header_color_text_inverse', 'label' => 'Text Inverse Color', 'type' => 'text', 'desc' => 'Default: #fff'],
                'memoo_display_header_color_link'             => ['id' => 'memoo_display_header_color_link', 'label' => 'Links Color', 'type' => 'text', 'desc' => 'Default: #C62B2B'],
                'memoo_display_header_color_link_hover'       => ['id' => 'memoo_display_header_color_link_hover', 'label' => 'Links hover Color', 'type' => 'text', 'desc' => 'Default: #c20e0d'],
            ],
        ],
        [
            'id'            => 'section-5',
            'display_title' => 'Vælg Farver (Footer)',
            'fields'        => [
                'memoo_display_footer_widget_color_background'=> ['id' => 'memoo_display_footer_widget_color_background', 'label' => 'Footer Widgets Background Color', 'type' => 'text', 'desc' => 'Default: #efefef'],
                'memoo_display_footer_color_background'       => ['id' => 'memoo_display_footer_color_background', 'label' => 'Footer Background Color', 'type' => 'text', 'desc' => 'Default: #efefef'],

                'memoo_display_footer_widget_color_text'      => ['id' => 'memoo_display_footer_widget_color_text', 'label' => 'Footer Widgets Text Color', 'type' => 'text', 'desc' => 'Default: #151515'],

                'memoo_display_footer_color_text'             => ['id' => 'memoo_display_footer_color_text', 'label' => 'Text Color', 'type' => 'text', 'desc' => 'Default: #151515'],
                'memoo_display_footer_color_text_inverse'     => ['id' => 'memoo_display_footer_color_text_inverse', 'label' => 'Text Inverse Color', 'type' => 'text', 'desc' => 'Default: #fff'],
                'memoo_display_footer_color_link'             => ['id' => 'memoo_display_footer_color_link', 'label' => 'Links Color', 'type' => 'text', 'desc' => 'Default: #151515'],
                'memoo_display_footer_color_link_hover'       => ['id' => 'memoo_display_footer_color_link_hover', 'label' => 'Links hover Color', 'type' => 'text', 'desc' => 'Default: rgba(21, 21, 21, 0.5)'],

                'memoo_display_footer_color_memoo'            => ['id' => 'memoo_display_footer_color_memoo', 'label' => 'Memoo Link Color', 'type' => 'text', 'desc' => 'Default: #3A77D1'],
                'memoo_display_footer_color_memoo_hover'      => ['id' => 'memoo_display_footer_color_memoo_hover', 'label' => 'Memoo Link Hover Color', 'type' => 'text', 'desc' => 'Default: rgba(58, 119, 209, 0.5)'],
            ],
        ],
    ];

    return $settings;
}

function memoo_theme_options_page() {
    memoo_save_stylesheet();
    ?>
    <div class="wrap">
        <h1>Theme Options</h1>
        <br><br>
        <form method="post" action="options.php">
            <?php
                settings_fields('all-settings');
                do_settings_sections('theme-options');
                submit_button();
            ?>
        </form>
    </div>
    <?php
}

function memoo_display_setting_fields() {
    memoo_generate_settings_fields();
}
add_action('admin_init', 'memoo_display_setting_fields');

function memoo_generate_settings_fields(){
    $settings = memoo_theme_settings();

    foreach ($settings as $setting) {
        add_settings_section($setting['id'], $setting['display_title'], null, 'theme-options');

        foreach ($setting['fields'] as $field) {
            add_settings_field($field['id'], $field['label'], 'memoo_display_fields', 'theme-options', $setting['id'], $field);
            register_setting('all-settings', $field['id']);
        }
    }
}

function memoo_display_fields(array $args){
    switch ($args['type']) {
        case 'text':
            ?>
            <input type="text" name="<?php echo $args['id']; ?>" id="<?php echo $args['id']; ?>" value="<?php echo get_option($args['id']); ?>" />
            <small><?php echo $args['desc']; ?></small>
            <?php
            break;
		case 'number':
            ?>
            <input type="number" name="<?php echo $args['id']; ?>" id="<?php echo $args['id']; ?>" value="<?php echo get_option($args['id']); ?>" />
            <small><?php echo $args['desc']; ?></small>
            <?php
            break;
        case 'checkbox':
            ?>
            <input type="checkbox" name="<?php echo $args['id']; ?>" value="1" <?php checked(1, get_option($args['id']), true); ?> />
            <small><?php echo $args['desc']; ?></small>
            <?php
            break;
        case 'radio':
            ?>
			<?php foreach ($args['options'] as $option): ?>
				<?php $input_id = sanitize_title($args['id'].'_'.$option['value']); ?>
				<input type="radio" name="<?php echo $args['id']; ?>" id="<?php echo $input_id; ?>" value="<?php echo $option['value']; ?>"
				<?php if ( (get_option($args['id'], '') == '') && isset($option['default']) ) : ?>
					checked
				<?php elseif( get_option($args['id']) == $option['value'] ) : ?>
					checked
				<?php endif; ?>
				/>
				<label for="<?php echo $input_id; ?>"><small><?php echo $option['desc']; ?></small></label>
			<?php endforeach; ?>
            <?php
            break;
    }
}

function memoo_get_stored_theme_options(){
    return [
        'memoo_boxed_layout_breakpoint'                             => str_replace(';', '', get_option('memoo_boxed_layout_breakpoint')),
        'memoo_display_boxed_layout_shadow'                         => str_replace(';', '', get_option('memoo_display_boxed_layout_shadow')),

        'memoo_display_main_color_boxed_layout_body_background'     => str_replace(';', '', get_option('memoo_display_main_color_boxed_layout_body_background')),
        'memoo_display_main_color_boxed_layout_page_background'     => str_replace(';', '', get_option('memoo_display_main_color_boxed_layout_page_background')),

        'memoo_display_main_color_headings'                         => str_replace(';', '', get_option('memoo_display_main_color_headings')),

        'memoo_display_main_color_text'                             => str_replace(';', '', get_option('memoo_display_main_color_text')),
        'memoo_display_main_color_text_inverse'                     => str_replace(';', '', get_option('memoo_display_main_color_text_inverse')),
        'memoo_display_main_color_link'                             => str_replace(';', '', get_option('memoo_display_main_color_link')),
        'memoo_display_main_color_link_hover'                       => str_replace(';', '', get_option('memoo_display_main_color_link_hover')),

        'memoo_scroll_header_color_background'                     	=> str_replace(';', '', get_option('memoo_scroll_header_color_background')),

		'memoo_display_header_color_background'                     => str_replace(';', '', get_option('memoo_display_header_color_background')),
        'memoo_display_header_color_background_submenu'             => str_replace(';', '', get_option('memoo_display_header_color_background_submenu')),
        'memoo_display_header_color_background_subsubmenu'          => str_replace(';', '', get_option('memoo_display_header_color_background_subsubmenu')),

        'memoo_display_header_color_mobile_background'              => str_replace(';', '', get_option('memoo_display_header_color_mobile_background')),
        'memoo_display_header_color_mobile_background_submenu'      => str_replace(';', '', get_option('memoo_display_header_color_mobile_background_submenu')),
        'memoo_display_header_color_mobile_background_subsubmenu'   => str_replace(';', '', get_option('memoo_display_header_color_mobile_background_subsubmenu')),

		'memoo_display_header_color_desktop_background_menuitem'   	=> str_replace(';', '', get_option('memoo_display_header_color_desktop_background_menuitem')),
        'memoo_display_header_color_desktop_menu_item_hover'   		=> str_replace(';', '', get_option('memoo_display_header_color_desktop_menu_item_hover')),

        'memoo_display_header_color_text_mobile'                    => str_replace(';', '', get_option('memoo_display_header_color_text_mobile')),
        'memoo_display_header_color_text'                           => str_replace(';', '', get_option('memoo_display_header_color_text')),
        'memoo_display_header_color_text_inverse'                   => str_replace(';', '', get_option('memoo_display_header_color_text_inverse')),
        'memoo_display_header_color_link'                           => str_replace(';', '', get_option('memoo_display_header_color_link')),
        'memoo_display_header_color_link_hover'                     => str_replace(';', '', get_option('memoo_display_header_color_link_hover')),

        'memoo_display_footer_widget_color_background'              => str_replace(';', '', get_option('memoo_display_footer_widget_color_background')),
        'memoo_display_footer_color_background'                     => str_replace(';', '', get_option('memoo_display_footer_color_background')),

        'memoo_display_footer_widget_color_text'                    => str_replace(';', '', get_option('memoo_display_footer_widget_color_text')),

        'memoo_display_footer_color_text'                           => str_replace(';', '', get_option('memoo_display_footer_color_text')),
        'memoo_display_footer_color_text_inverse'                   => str_replace(';', '', get_option('memoo_display_footer_color_text_inverse')),
        'memoo_display_footer_color_link'                           => str_replace(';', '', get_option('memoo_display_footer_color_link')),
        'memoo_display_footer_color_link_hover'                     => str_replace(';', '', get_option('memoo_display_footer_color_link_hover')),

        'memoo_display_footer_color_memoo'                          => str_replace(';', '', get_option('memoo_display_footer_color_memoo')),
        'memoo_display_footer_color_memoo_hover'                    => str_replace(';', '', get_option('memoo_display_footer_color_memoo_hover')),
    ];
}

function memoo_save_stylesheet(){
	global $wp_filesystem;
	WP_Filesystem();

	$wp_filesystem->put_contents(
		get_template_directory() . '/assets/css/variables.css',
		memoo_generate_styleheet(),
		FS_CHMOD_FILE // predefined mode settings for WP files
	);
}

function memoo_generate_styleheet(){
    $stored_options = memoo_get_stored_theme_options();

    return ":root {
--main-boxed-layout-page-shadow: ".(($stored_options['memoo_display_boxed_layout_shadow']) ? $stored_options['memoo_display_boxed_layout_shadow']  : '0px 0px 10px rgba(0,0,0, 0.4)').";
--main-boxed-layout-page-breakpoint: ".(($stored_options['memoo_boxed_layout_breakpoint']) ? $stored_options['memoo_boxed_layout_breakpoint']  : '1600px').";
--main-color-headings: ".(($stored_options['memoo_display_main_color_headings']) ? $stored_options['memoo_display_main_color_headings']  : '#151515' ).";
--main-color-text: ".(($stored_options['memoo_display_main_color_text']) ? $stored_options['memoo_display_main_color_text']  : '#151515' ).";
--main-color-text-inverse: ".(($stored_options['memoo_display_main_color_text_inverse']) ? $stored_options['memoo_display_main_color_text_inverse']  : '#fff' ).";
--main-color-link: ".(($stored_options['memoo_display_main_color_link']) ? $stored_options['memoo_display_main_color_link']  : '#C62B2B' ).";
--main-color-link-hover: ".(($stored_options['memoo_display_main_color_link_hover']) ? $stored_options['memoo_display_main_color_link_hover']  : 'rgba(194, 14, 13, 0.8)' ).";
--main-boxed-layout-body-background-color: ".(($stored_options['memoo_display_main_color_boxed_layout_body_background']) ? $stored_options['memoo_display_main_color_boxed_layout_body_background']  : '#dfe3e8' ).";
--main-boxed-layout-page-background-color: ".(($stored_options['memoo_display_main_color_boxed_layout_page_background']) ? $stored_options['memoo_display_main_color_boxed_layout_page_background']  : '#fff' ).";
--header-color-background-scrolled: ".(($stored_options['memoo_scroll_header_color_background']) ? $stored_options['memoo_scroll_header_color_background']  : '#fff' ).";
--header-color-background: ".(($stored_options['memoo_display_header_color_background']) ? $stored_options['memoo_display_header_color_background']  : '#fff' ).";
--header-color-background-submenu: ".(($stored_options['memoo_display_header_color_background_submenu']) ? $stored_options['memoo_display_header_color_background_submenu']  : '#fff' ).";
--header-color-background-subsubmenu: ".(($stored_options['memoo_display_header_color_background_subsubmenu']) ? $stored_options['memoo_display_header_color_background_subsubmenu']  : '#fff' ).";
--header-color-mobile-background: ".(($stored_options['memoo_display_header_color_mobile_background']) ? $stored_options['memoo_display_header_color_mobile_background']  : '#C62B2B' ).";
--header-color-mobile-background-submenu: ".(($stored_options['memoo_display_header_color_mobile_background_submenu']) ? $stored_options['memoo_display_header_color_mobile_background_submenu']  : 'rgba(194, 14, 13, 0.8)' ).";
--header-color-mobile-background-subsubmenu: ".(($stored_options['memoo_display_header_color_mobile_background_subsubmenu']) ? $stored_options['memoo_display_header_color_mobile_background_subsubmenu']  : '#B50100' ).";
--header-color-desktop-menuitem-background: ".(($stored_options['memoo_display_header_color_desktop_background_menuitem']) ? $stored_options['memoo_display_header_color_desktop_background_menuitem']  : '#fff' ).";
--header-color-desktop-menuitem-link-hover: ".(($stored_options['memoo_display_header_color_desktop_menu_item_hover']) ? $stored_options['memoo_display_header_color_desktop_menu_item_hover']  : 'rgba(194, 14, 13, 0.8)' ).";
--header-color-text-mobile: ".(($stored_options['memoo_display_header_color_text_mobile']) ? $stored_options['memoo_display_header_color_text_mobile']  : '#fff' ).";
--header-color-text: ".(($stored_options['memoo_display_header_color_text']) ? $stored_options['memoo_display_header_color_text']  : '#151515' ).";
--header-color-text-inverse: ".(($stored_options['memoo_display_header_color_text_inverse']) ? $stored_options['memoo_display_header_color_text_inverse']  : '#fff' ).";
--header-color-link: ".(($stored_options['memoo_display_header_color_link']) ? $stored_options['memoo_display_header_color_link']  : '#C62B2B' ).";
--header-color-link-hover: ".(($stored_options['memoo_display_header_color_link_hover']) ? $stored_options['memoo_display_header_color_link_hover']  : 'rgba(194, 14, 13, 0.8)' ).";
--footer-widgets-background-color: ".(($stored_options['memoo_display_footer_widget_color_background']) ? $stored_options['memoo_display_footer_widget_color_background']  : '#efefef' ).";
--footer-background-color: ".(($stored_options['memoo_display_footer_color_background']) ? $stored_options['memoo_display_footer_color_background']  : '#efefef' ).";
--footer-widgets-color-text: ".(($stored_options['memoo_display_footer_widget_color_text']) ? $stored_options['memoo_display_footer_widget_color_text']  : '#151515' ).";
--footer-color-text: ".(($stored_options['memoo_display_footer_color_text']) ? $stored_options['memoo_display_footer_color_text']  : '#151515' ).";
--footer-color-text-inverse: ".(($stored_options['memoo_display_footer_color_text_inverse']) ? $stored_options['memoo_display_footer_color_text_inverse']  : '#fff' ).";
--footer-color-link: ".(($stored_options['memoo_display_footer_color_link']) ? $stored_options['memoo_display_footer_color_link']  : '#151515' ).";
--footer-color-link-hover: ".(($stored_options['memoo_display_footer_color_link_hover']) ? $stored_options['memoo_display_footer_color_link_hover']  : 'rgba(21, 21, 21, 0.5)' ).";
--footer-color-memoo: ".(($stored_options['memoo_display_footer_color_memoo']) ? $stored_options['memoo_display_footer_color_memoo']  : '#3A77D1' ).";
--footer-color-memoo-hover: ".(($stored_options['memoo_display_footer_color_memoo_hover']) ? $stored_options['memoo_display_footer_color_memoo_hover']  : 'rgba(58, 119, 209, 0.5)' ).";
}
";
}
