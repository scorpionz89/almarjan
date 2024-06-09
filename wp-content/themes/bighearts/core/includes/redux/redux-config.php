<?php

if (!class_exists('BigHearts_Core')) {
    return;
}

if (!function_exists('wgl_get_redux_icons')) {
    function wgl_get_redux_icons()
    {
        return WglAdminIcon()->get_icons_name(true);
    }

    add_filter('redux/font-icons', 'wgl_get_redux_icons');
}

//* This is theme option name where all the Redux data is stored.
$theme_slug = 'bighearts_set';

/**
 * Set all the possible arguments for Redux
 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
 * */
$theme = wp_get_theme();

Redux::setArgs($theme_slug, [
    'opt_name' => $theme_slug, //* This is where your data is stored in the database and also becomes your global variable name.
    'display_name' => $theme->get('Name'), //* Name that appears at the top of your panel
    'display_version' => $theme->get('Version'), //* Version that appears at the top of your panel
    'menu_type' => 'menu', //* Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu' => true, //* Show the sections below the admin menu item or not
    'menu_title' => esc_html__('Theme Options', 'bighearts'),
    'page_title' => esc_html__('Theme Options', 'bighearts'),
    'google_api_key' => '', //* You will need to generate a Google API key to use this feature. Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_update_weekly' => false, //* Set it you want google fonts to update weekly. A google_api_key value is required.
    'async_typography' => true, //* Must be defined to add google fonts to the typography module
    'admin_bar' => true, //* Show the panel pages on the admin bar
    'admin_bar_icon' => 'dashicons-admin-generic', //* Choose an icon for the admin bar menu
    'admin_bar_priority' => 50, //* Choose an priority for the admin bar menu
    'global_variable' => '', //* Set a different name for your global variable other than the opt_name
    'dev_mode' => false,
    'update_notice' => true, //* If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer' => true,
    'page_priority' => 3, //* Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent' => 'wgl-dashboard-panel', //* For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions' => 'manage_options', //* Permissions needed to access the options panel.
    'menu_icon' => 'dashicons-admin-generic', //* Specify a custom URL to an icon
    'last_tab' => '', //* Force your panel to always open to a specific tab (by id)
    'page_icon' => 'icon-themes', //* Icon displayed in the admin panel next to your menu_title
    'page_slug' => 'wgl-theme-options-panel', //* Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
    'save_defaults' => true, //* On load save the defaults to DB before user clicks save or not
    'default_show' => false, //* If true, shows the default value next to each field that is not the default value.
    'default_mark' => '', //* What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export' => true, //* Shows the Import/Export panel when not used as a field.
    'transient_time' => 60 * MINUTE_IN_SECONDS, //* Show the time the page took to load, etc
    'output' => true, //* Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag' => true, //* FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database' => '', //* possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'use_cdn' => true,
]);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'general',
        'title' => esc_html__('General', 'bighearts'),
        'icon' => 'el el-screen',
        'fields' => [
            [
                'id' => 'use_minified',
                'title' => esc_html__('Use minified css/js files', 'bighearts'),
                'type' => 'switch',
                'desc' => esc_html__('Speed up your site load.', 'bighearts'),
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
            ],
            [
                'id' => 'preloader-start',
                'title' => esc_html__('Preloader', 'bighearts'),
                'type' => 'section',
                'indent' => true,
            ],
            [
                'id' => 'preloader',
                'title' => esc_html__('Preloader', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'preloader_background',
                'title' => esc_html__('Preloader Background', 'bighearts'),
                'type' => 'color',
                'required' => ['preloader', '=', '1'],
                'transparent' => false,
                'default' => '#ffffff',
            ],
            [
                'id' => 'preloader_color',
                'title' => esc_html__('Preloader Color', 'bighearts'),
                'type' => 'color',
                'required' => ['preloader', '=', '1'],
                'transparent' => false,
                'default' => '#ff7029',
            ],
            [
                'id' => 'preloader-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'search_settings',
                'type' => 'section',
                'title' => esc_html__('Search', 'bighearts'),
                'indent' => true,
            ],
            [
                'id' => 'search_style',
                'title' => esc_html__('Choose search style', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'standard' => esc_html__('Standard', 'bighearts'),
                    'alt' => esc_html__('Full Page Width', 'bighearts'),
                ],
                'default' => 'standard',
            ],
            [
                'id' => 'search_settings-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'scroll_up_settings',
                'title' => esc_html__('Back to Top', 'bighearts'),
                'type' => 'section',
                'indent' => true,
            ],
            [
                'id' => 'scroll_up',
                'title' => esc_html__('Button', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Disable', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'scroll_up_appearance',
                'title' => esc_html__('Appearance', 'bighearts'),
                'type' => 'switch',
                'required' => ['scroll_up', '=', true],
                'on' => esc_html__('Text', 'bighearts'),
                'off' => esc_html__('Icon', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'scroll_up_text',
                'title' => esc_html__('Button Text', 'bighearts'),
                'type' => 'text',
                'required' => ['scroll_up_appearance', '=', true],
                'default' => esc_html__('Top', 'bighearts'),
            ],
            [
                'id' => 'scroll_up_arrow_color',
                'title' => esc_html__('Text Color', 'bighearts'),
                'type' => 'color',
                'required' => ['scroll_up', '=', true],
                'transparent' => false,
                'default' => '#f74f22',
            ],
            [
                'id' => 'scroll_up_bg_color',
                'title' => esc_html__('Background Color', 'bighearts'),
                'type' => 'color',
                'required' => ['scroll_up', '=', true],
                'transparent' => false,
                'default' => '#ffffff',
            ],
            [
                'id' => 'scroll_up_settings-end',
                'type' => 'section',
                'indent' => false,
            ],
        ],
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'editors-option',
        'title' => esc_html__('Custom JS', 'bighearts'),
        'subsection' => true,
        'fields' => [
            [
                'id' => 'custom_js',
                'title' => esc_html__('Custom JS', 'bighearts'),
                'type' => 'ace_editor',
                'subtitle' => esc_html__('Paste your JS code here.', 'bighearts'),
                'mode' => 'javascript',
                'theme' => 'chrome',
                'default' => ''
            ],
            [
                'id' => 'header_custom_js',
                'title' => esc_html__('Custom JS', 'bighearts'),
                'type' => 'ace_editor',
                'subtitle' => esc_html__('Code to be added inside HEAD tag', 'bighearts'),
                'mode' => 'html',
                'theme' => 'chrome',
                'default' => ''
            ],
        ],
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'header_section',
        'title' => esc_html__('Header', 'bighearts'),
        'icon' => 'fas fa-window-maximize',
    ]
);

$header_builder_items = [
    'default' => [
        'html1' => ['title' => esc_html__('HTML 1', 'bighearts'), 'settings' => true],
        'html2' => ['title' => esc_html__('HTML 2', 'bighearts'), 'settings' => true],
        'html3' => ['title' => esc_html__('HTML 3', 'bighearts'), 'settings' => true],
        'html4' => ['title' => esc_html__('HTML 4', 'bighearts'), 'settings' => true],
        'html5' => ['title' => esc_html__('HTML 5', 'bighearts'), 'settings' => true],
        'html6' => ['title' => esc_html__('HTML 6', 'bighearts'), 'settings' => true],
        'html7' => ['title' => esc_html__('HTML 7', 'bighearts'), 'settings' => true],
        'html8' => ['title' => esc_html__('HTML 8', 'bighearts'), 'settings' => true],
        'delimiter1' => ['title' => esc_html__('|', 'bighearts'), 'settings' => true],
        'delimiter2' => ['title' => esc_html__('|', 'bighearts'), 'settings' => true],
        'delimiter3' => ['title' => esc_html__('|', 'bighearts'), 'settings' => true],
        'delimiter4' => ['title' => esc_html__('|', 'bighearts'), 'settings' => true],
        'delimiter5' => ['title' => esc_html__('|', 'bighearts'), 'settings' => true],
        'delimiter6' => ['title' => esc_html__('|', 'bighearts'), 'settings' => true],
        'spacer1' => ['title' => esc_html__('Spacer 1', 'bighearts'), 'settings' => true],
        'spacer2' => ['title' => esc_html__('Spacer 2', 'bighearts'), 'settings' => true],
        'spacer3' => ['title' => esc_html__('Spacer 3', 'bighearts'), 'settings' => true],
        'spacer4' => ['title' => esc_html__('Spacer 4', 'bighearts'), 'settings' => true],
        'spacer5' => ['title' => esc_html__('Spacer 5', 'bighearts'), 'settings' => true],
        'spacer6' => ['title' => esc_html__('Spacer 6', 'bighearts'), 'settings' => true],
        'spacer7' => ['title' => esc_html__('Spacer 7', 'bighearts'), 'settings' => true],
        'spacer8' => ['title' => esc_html__('Spacer 8', 'bighearts'), 'settings' => true],
        'button1' => ['title' => esc_html__('Button', 'bighearts'), 'settings' => true],
        'button2' => ['title' => esc_html__('Button', 'bighearts'), 'settings' => true],
        'wpml' => ['title' => esc_html__('WPML/Polylang', 'bighearts'), 'settings' => false],
        'cart' => ['title' => esc_html__('Cart', 'bighearts'), 'settings' => true],
        'login' => ['title' => esc_html__('Login', 'bighearts'), 'settings' => false],
        'side_panel' => ['title' => esc_html__('Side Panel', 'bighearts'), 'settings' => true],
    ],
    'mobile' => [
        'html1' => esc_html__('HTML 1', 'bighearts'),
        'html2' => esc_html__('HTML 2', 'bighearts'),
        'html3' => esc_html__('HTML 3', 'bighearts'),
        'html4' => esc_html__('HTML 4', 'bighearts'),
        'html5' => esc_html__('HTML 5', 'bighearts'),
        'html6' => esc_html__('HTML 6', 'bighearts'),
        'spacer1' => esc_html__('Spacer 1', 'bighearts'),
        'spacer2' => esc_html__('Spacer 2', 'bighearts'),
        'spacer3' => esc_html__('Spacer 3', 'bighearts'),
        'spacer4' => esc_html__('Spacer 4', 'bighearts'),
        'spacer5' => esc_html__('Spacer 5', 'bighearts'),
        'spacer6' => esc_html__('Spacer 6', 'bighearts'),
        'side_panel' => esc_html__('Side Panel', 'bighearts'),
        'wpml' => esc_html__('WPML/Polylang', 'bighearts'),
        'cart' => esc_html__('Cart', 'bighearts'),
        'login' => esc_html__('Login', 'bighearts'),
    ],
    'mobile_drawer' => [
        'html1' => esc_html__('HTML 1', 'bighearts'),
        'html2' => esc_html__('HTML 2', 'bighearts'),
        'html3' => esc_html__('HTML 3', 'bighearts'),
        'html4' => esc_html__('HTML 4', 'bighearts'),
        'html5' => esc_html__('HTML 5', 'bighearts'),
        'html6' => esc_html__('HTML 6', 'bighearts'),
        'wpml' => esc_html__('WPML/Polylang', 'bighearts'),
        'spacer1' => esc_html__('Spacer 1', 'bighearts'),
        'spacer2' => esc_html__('Spacer 2', 'bighearts'),
        'spacer3' => esc_html__('Spacer 3', 'bighearts'),
        'spacer4' => esc_html__('Spacer 4', 'bighearts'),
        'spacer5' => esc_html__('Spacer 5', 'bighearts'),
        'spacer6' => esc_html__('Spacer 6', 'bighearts'),
    ],
];

Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Header Builder', 'bighearts'),
        'id' => 'header-customize',
        'subsection' => true,
        'fields' => [
            [
                'id' => 'header_switch',
                'title' => esc_html__('Header', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Disable', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'header_type',
                'type' => 'select',
                'title' => esc_html__('Layout Building Tool', 'bighearts'),
                'desc' => esc_html__('Custom Builder allows create templates within Elementor environment.', 'bighearts'),
                'options' => [
                    'default' => esc_html__('Default Builder', 'bighearts'),
                    'custom' => esc_html__('Custom Builder ( Recommended )', 'bighearts')
                ],
                'default' => 'default',
                'required' => ['header_switch', '=', '1'],
            ],
            [
                'id' => 'header_page_select',
                'type' => 'select',
                'title' => esc_html__('Header Template', 'bighearts'),
                'required' => ['header_type', '=', 'custom'],
                'desc' => sprintf(
                    '%s <a href="%s" target="_blank">%s</a> %s',
                    esc_html__('Selected Template will be used for all pages by default. You can edit/create Header Template in the', 'bighearts'),
                    admin_url('edit.php?post_type=header'),
                    esc_html__('Header Templates', 'bighearts'),
                    esc_html__('dashboard tab.', 'bighearts')
                ),
                'data' => 'posts',
                'args' => [
                    'post_type' => 'header',
                    'posts_per_page' => -1,
                    'orderby' => 'title',
                    'order' => 'ASC',
                ],
            ],
            [
                'id' => 'bottom_header_layout',
                'type' => 'custom_header_builder',
                'title' => esc_html__('Header Builder', 'bighearts'),
                'required' => ['header_type', '=', 'default'],
                'compiler' => 'true',
                'full_width' => true,
                'default' => [
                    'items' => $header_builder_items['default'],
                    'Top Left area' => [],
                    'Top Center area' => [],
                    'Top Right area' => [],
                    'Middle Left area' => [
                        'spacer2' => ['title' => esc_html__('Spacer 2', 'bighearts'), 'settings' => true],
                        'logo' => ['title' => esc_html__('Logo', 'bighearts'), 'settings' => false],
                    ],
                    'Middle Center area' => [
                        'menu' => ['title' => esc_html__('Menu', 'bighearts'), 'settings' => false],
                    ],
                    'Middle Right area' => [
                        'item_search' => ['title' => esc_html__('Search', 'bighearts'), 'settings' => true],
                        'spacer3' => ['title' => esc_html__('Spacer 3', 'bighearts'), 'settings' => true],
                    ],
                    'Bottom Left area' => [],
                    'Bottom Center area' => [],
                    'Bottom Right area' => [],
                ],
            ],
            [
                'id' => 'bottom_header_spacer1',
                'title' => esc_html__('Header Spacer 1 Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_type', '=', 'default'],
                'width' => true,
                'height' => false,
                'default' => ['width' => 43],
            ],
            [
                'id' => 'bottom_header_spacer2',
                'title' => esc_html__('Header Spacer 2 Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_type', '=', 'default'],
                'width' => true,
                'height' => false,
                'default' => ['width' => 40],
            ],
            [
                'id' => 'bottom_header_spacer3',
                'title' => esc_html__('Header Spacer 3 Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_type', '=', 'default'],
                'width' => true,
                'height' => false,
                'default' => ['width' => 40],
            ],
            [
                'id' => 'bottom_header_spacer4',
                'title' => esc_html__('Header Spacer 4 Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_type', '=', 'default'],
                'width' => true,
                'height' => false,
                'default' => ['width' => 25],
            ],
            [
                'id' => 'bottom_header_spacer5',
                'title' => esc_html__('Header Spacer 5 Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_type', '=', 'default'],
                'height' => false,
                'width' => true,
                'default' => ['width' => 25],
            ],
            [
                'id' => 'bottom_header_spacer6',
                'title' => esc_html__('Header Spacer 6 Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_type', '=', 'default'],
                'height' => false,
                'width' => true,
                'default' => ['width' => 25],
            ],
            [
                'id' => 'bottom_header_spacer7',
                'title' => esc_html__('Header Spacer 7 Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_type', '=', 'default'],
                'width' => true,
                'height' => false,
                'default' => ['width' => 25],
            ],
            [
                'id' => 'bottom_header_spacer8',
                'title' => esc_html__('Header Spacer 8 Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_type', '=', 'default'],
                'width' => true,
                'height' => false,
                'default' => ['width' => 25],
            ],
            [
                'id' => 'bottom_header_item_search_custom',
                'title' => esc_html__('Customize Search', 'bighearts'),
                'type' => 'switch',
                'required' => ['header_type', '=', 'default'],
                'default' => false,
            ],
            [
                'id' => 'bottom_header_item_search_color_txt',
                'title' => esc_html__('Icon Color', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['bottom_header_item_search_custom', '=', '1'],
                'mode' => 'background',
                'default' => [
                    'alpha' => '1',
                    'rgba' => 'rgba(33,33,33,1)',
                    'color' => '#313131',
                ],
            ],
            [
                'id' => 'bottom_header_item_search_hover_color_txt',
                'title' => esc_html__('Hover Icon Color', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['bottom_header_item_search_custom', '=', '1'],
                'mode' => 'background',
                'default' => [
                    'alpha' => '1',
                    'rgba' => 'rgba(33,33,33,1)',
                    'color' => '#212121',
                ],
            ],
            [
                'id' => 'bottom_header_cart_custom',
                'title' => esc_html__('Customize cart', 'bighearts'),
                'type' => 'switch',
                'required' => ['header_type', '=', 'default'],
                'default' => false,
            ],
            [
                'id' => 'bottom_header_cart_color_txt',
                'title' => esc_html__('Icon Color', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['bottom_header_cart_custom', '=', '1'],
                'mode' => 'background',
                'default' => [
                    'alpha' => '1',
                    'rgba' => 'rgba(33,33,33,1)',
                    'color' => '#212121',
                ],
            ],
            [
                'id' => 'bottom_header_cart_hover_color_txt',
                'title' => esc_html__('Hover Icon Color', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['bottom_header_cart_custom', '=', '1'],
                'mode' => 'background',
                'default' => [
                    'color' => '#212121',
                    'alpha' => '1',
                    'rgba' => 'rgba(33,33,33,1)'
                ],
            ],
            [
                'id' => 'bottom_header_delimiter1_height',
                'title' => esc_html__('Delimiter Height', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_type', '=', 'default'],
                'width' => false,
                'height' => true,
                'default' => ['height' => 50],
            ],
            [
                'id' => 'bottom_header_delimiter1_width',
                'title' => esc_html__('Delimiter Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_type', '=', 'default'],
                'width' => true,
                'height' => false,
                'default' => ['width' => 1],
            ],
            [
                'id' => 'bottom_header_delimiter1_bg',
                'title' => esc_html__('Delimiter Background', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['header_type', '=', 'default'],
                'mode' => 'background',
                'default' => [
                    'color' => '#000000',
                    'alpha' => '0.1',
                    'rgba' => 'rgba(0, 0, 0, 0.1)'
                ],
            ],
            [
                'id' => 'bottom_header_delimiter1_margin',
                'title' => esc_html__('Delimiter Spacing', 'bighearts'),
                'type' => 'spacing',
                'required' => ['header_type', '=', 'default'],
                'mode' => 'margin',
                'all' => false,
                'bottom' => false,
                'top' => false,
                'left' => true,
                'right' => true,
                'default' => [
                    'margin-left' => '20',
                    'margin-right' => '30',
                ],
            ],
            [
                'id' => 'bottom_header_delimiter2_height',
                'title' => esc_html__('Delimiter Height', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_type', '=', 'default'],
                'height' => true,
                'width' => false,
                'default' => ['height' => 100],
            ],
            [
                'id' => 'bottom_header_delimiter2_width',
                'title' => esc_html__('Delimiter Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_type', '=', 'default'],
                'height' => false,
                'width' => true,
                'default' => ['width' => 1],
            ],
            [
                'id' => 'bottom_header_delimiter2_bg',
                'title' => esc_html__('Delimiter Background', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['header_type', '=', 'default'],
                'mode' => 'background',
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '.9',
                    'rgba' => 'rgba(255,255,255,0.9)'
                ],
            ],
            [
                'id' => 'bottom_header_delimiter2_margin',
                'title' => esc_html__('Delimiter Spacing', 'bighearts'),
                'type' => 'spacing',
                'required' => ['header_type', '=', 'default'],
                'mode' => 'margin',
                'all' => false,
                'bottom' => false,
                'top' => false,
                'left' => true,
                'right' => true,
                'default' => [
                    'margin-left' => '30',
                    'margin-right' => '30',
                ],
            ],
            [
                'id' => 'bottom_header_delimiter3_height',
                'title' => esc_html__('Delimiter Height', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_type', '=', 'default'],
                'width' => false,
                'height' => true,
                'default' => ['height' => 100],
            ],
            [
                'id' => 'bottom_header_delimiter3_width',
                'title' => esc_html__('Delimiter Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_type', '=', 'default'],
                'width' => true,
                'height' => false,
                'default' => ['width' => 1],
            ],
            [
                'id' => 'bottom_header_delimiter3_bg',
                'title' => esc_html__('Delimiter Background', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['header_type', '=', 'default'],
                'mode' => 'background',
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '.9',
                    'rgba' => 'rgba(255,255,255,0.9)'
                ],
            ],
            [
                'id' => 'bottom_header_delimiter3_margin',
                'title' => esc_html__('Delimiter Spacing', 'bighearts'),
                'type' => 'spacing',
                'required' => ['header_type', '=', 'default'],
                'mode' => 'margin',
                'all' => false,
                'bottom' => false,
                'top' => false,
                'left' => true,
                'right' => true,
                'default' => [
                    'margin-left' => '30',
                    'margin-right' => '30',
                ],
            ],
            [
                'id' => 'bottom_header_delimiter4_height',
                'title' => esc_html__('Delimiter Height', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_type', '=', 'default'],
                'width' => false,
                'height' => true,
                'default' => ['height' => 100],
            ],
            [
                'id' => 'bottom_header_delimiter4_width',
                'title' => esc_html__('Delimiter Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_type', '=', 'default'],
                'height' => false,
                'width' => true,
                'default' => ['width' => 1],
            ],
            [
                'id' => 'bottom_header_delimiter4_bg',
                'title' => esc_html__('Delimiter Background', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['header_type', '=', 'default'],
                'mode' => 'background',
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '.9',
                    'rgba' => 'rgba(255,255,255,0.9)'
                ],
            ],
            [
                'id' => 'bottom_header_delimiter4_margin',
                'title' => esc_html__('Delimiter Spacing', 'bighearts'),
                'type' => 'spacing',
                'required' => ['header_type', '=', 'default'],
                'mode' => 'margin',
                'all' => false,
                'bottom' => false,
                'top' => false,
                'left' => true,
                'right' => true,
                'default' => [
                    'margin-left' => '30',
                    'margin-right' => '30',
                ],
            ],
            [
                'id' => 'bottom_header_delimiter5_height',
                'title' => esc_html__('Delimiter Height', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_type', '=', 'default'],
                'width' => false,
                'height' => true,
                'default' => ['height' => 100],
            ],
            [
                'id' => 'bottom_header_delimiter5_width',
                'title' => esc_html__('Delimiter Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_type', '=', 'default'],
                'height' => false,
                'width' => true,
                'default' => ['width' => 1],
            ],
            [
                'id' => 'bottom_header_delimiter5_bg',
                'title' => esc_html__('Delimiter Background', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['header_type', '=', 'default'],
                'mode' => 'background',
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '.9',
                    'rgba' => 'rgba(255,255,255,0.9)'
                ],
            ],
            [
                'id' => 'bottom_header_delimiter5_margin',
                'title' => esc_html__('Delimiter Spacing', 'bighearts'),
                'type' => 'spacing',
                'required' => ['header_type', '=', 'default'],
                'mode' => 'margin',
                'all' => false,
                'bottom' => false,
                'top' => false,
                'left' => true,
                'right' => true,
                'default' => [
                    'margin-left' => '30',
                    'margin-right' => '30',
                ],
            ],
            [
                'id' => 'bottom_header_delimiter6_height',
                'title' => esc_html__('Delimiter Height', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_type', '=', 'default'],
                'height' => true,
                'width' => false,
                'default' => ['height' => 100],
            ],
            [
                'id' => 'bottom_header_delimiter6_width',
                'title' => esc_html__('Delimiter Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_type', '=', 'default'],
                'width' => true,
                'height' => false,
                'default' => ['width' => 1],
            ],
            [
                'id' => 'bottom_header_delimiter6_bg',
                'title' => esc_html__('Delimiter Background', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['header_type', '=', 'default'],
                'mode' => 'background',
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '.9',
                    'rgba' => 'rgba(255,255,255,0.9)'
                ],
            ],
            [
                'id' => 'bottom_header_delimiter6_margin',
                'title' => esc_html__('Delimiter Spacing', 'bighearts'),
                'type' => 'spacing',
                'required' => ['header_type', '=', 'default'],
                'mode' => 'margin',
                'all' => false,
                'bottom' => false,
                'top' => false,
                'left' => true,
                'right' => true,
                'default' => [
                    'margin-left' => '30',
                    'margin-right' => '30',
                ],
            ],
            [
                'id' => 'bottom_header_button1_title',
                'title' => esc_html__('Button Text', 'bighearts'),
                'type' => 'text',
                'required' => ['header_type', '=', 'default'],
                'default' => esc_html__('Contact Us', 'bighearts'),
            ],
            [
                'id' => 'bottom_header_button1_link',
                'title' => esc_html__('Link', 'bighearts'),
                'type' => 'text',
                'required' => ['header_type', '=', 'default'],
                'default' => '#',
            ],
            [
                'id' => 'bottom_header_button1_target',
                'title' => esc_html__('Open link in a new tab', 'bighearts'),
                'type' => 'switch',
                'required' => ['header_type', '=', 'default'],
                'default' => true,
            ],
            [
                'id' => 'bottom_header_button1_size',
                'title' => esc_html__('Button Size', 'bighearts'),
                'type' => 'select',
                'required' => ['header_type', '=', 'default'],
                'options' => [
                    'sm' => esc_html__('Small', 'bighearts'),
                    'md' => esc_html__('Medium', 'bighearts'),
                    'lg' => esc_html__('Large', 'bighearts'),
                    'xl' => esc_html__('Extra Large', 'bighearts'),
                ],
                'default' => 'md',
            ],
            [
                'id' => 'bottom_header_button1_radius',
                'title' => esc_html__('Button Border Radius', 'bighearts'),
                'type' => 'text',
                'required' => ['header_type', '=', 'default'],
                'desc' => esc_html__('Value in pixels.', 'bighearts'),
            ],
            [
                'id' => 'bottom_header_button1_custom',
                'title' => esc_html__('Customize Button', 'bighearts'),
                'type' => 'switch',
                'required' => ['header_type', '=', 'default'],
                'default' => false,
            ],
            [
                'id' => 'bottom_header_button1_color_txt',
                'title' => esc_html__('Text Color Idle', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['bottom_header_button1_custom', '=', '1'],
                'mode' => 'background',
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)'
                ],
            ],
            [
                'id' => 'bottom_header_button1_hover_color_txt',
                'title' => esc_html__('Text Color Hover', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['bottom_header_button1_custom', '=', '1'],
                'mode' => 'background',
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
            ],
            [
                'id' => 'bottom_header_button1_bg',
                'title' => esc_html__('Background Color', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['bottom_header_button1_custom', '=', '1'],
                'mode' => 'background',
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
            ],
            [
                'id' => 'bottom_header_button1_hover_bg',
                'title' => esc_html__('Hover Background Color', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['bottom_header_button1_custom', '=', '1'],
                'mode' => 'background',
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)'
                ],
            ],
            [
                'id' => 'bottom_header_button1_border',
                'title' => esc_html__('Border Color', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['bottom_header_button1_custom', '=', '1'],
                'mode' => 'background',
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
            ],
            [
                'id' => 'bottom_header_button1_hover_border',
                'title' => esc_html__('Hover Border Color', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['bottom_header_button1_custom', '=', '1'],
                'mode' => 'background',
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
            ],
            [
                'id' => 'bottom_header_button2_title',
                'title' => esc_html__('Button Text', 'bighearts'),
                'type' => 'text',
                'required' => ['header_type', '=', 'default'],
                'default' => esc_html__('Contact Us', 'bighearts'),
            ],
            [
                'id' => 'bottom_header_button2_link',
                'title' => esc_html__('Link', 'bighearts'),
                'type' => 'text',
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_button2_target',
                'title' => esc_html__('Open link in a new tab', 'bighearts'),
                'type' => 'switch',
                'required' => ['header_type', '=', 'default'],
                'default' => true,
            ],
            [
                'id' => 'bottom_header_button2_size',
                'title' => esc_html__('Button Size', 'bighearts'),
                'type' => 'select',
                'required' => ['header_type', '=', 'default'],
                'options' => [
                    'sm' => esc_html__('Small', 'bighearts'),
                    'md' => esc_html__('Medium', 'bighearts'),
                    'lg' => esc_html__('Large', 'bighearts'),
                    'xl' => esc_html__('Extra Large', 'bighearts'),
                ],
                'default' => 'md',
            ],
            [
                'id' => 'bottom_header_button2_radius',
                'title' => esc_html__('Button Border Radius', 'bighearts'),
                'type' => 'text',
                'required' => ['header_type', '=', 'default'],
                'desc' => esc_html__('Value in pixels.', 'bighearts'),
            ],
            [
                'id' => 'bottom_header_button2_custom',
                'title' => esc_html__('Customize Button', 'bighearts'),
                'type' => 'switch',
                'required' => ['header_type', '=', 'default'],
                'default' => false,
            ],
            [
                'id' => 'bottom_header_button2_color_txt',
                'title' => esc_html__('Text Color Idle', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['bottom_header_button2_custom', '=', '1'],
                'mode' => 'background',
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)'
                ],
            ],
            [
                'id' => 'bottom_header_button2_hover_color_txt',
                'title' => esc_html__('Text Color Hover', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['bottom_header_button2_custom', '=', '1'],
                'mode' => 'background',
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
            ],
            [
                'id' => 'bottom_header_button2_bg',
                'title' => esc_html__('Background Color', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['bottom_header_button2_custom', '=', '1'],
                'mode' => 'background',
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
            ],
            [
                'id' => 'bottom_header_button2_hover_bg',
                'title' => esc_html__('Hover Background Color', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['bottom_header_button2_custom', '=', '1'],
                'mode' => 'background',
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)'
                ],
            ],
            [
                'id' => 'bottom_header_button2_border',
                'title' => esc_html__('Border Color', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['bottom_header_button2_custom', '=', '1'],
                'mode' => 'background',
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
            ],
            [
                'id' => 'bottom_header_button2_hover_border',
                'title' => esc_html__('Hover Border Color', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['bottom_header_button2_custom', '=', '1'],
                'mode' => 'background',
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
            ],
            [
                'id' => 'bottom_header_bar_html1_editor',
                'title' => esc_html__('HTML Element 1 Editor', 'bighearts'),
                'type' => 'ace_editor',
                'required' => ['header_type', '=', 'default'],
                'mode' => 'html',
                'default' => '<span style="font-size: 14px;"><a href="tel:+5074521254">'
                    . '<i class="wgl-icon fa fa-phone" style="margin-right: 5px;"></i>'
                    . '+8 (123) 985 789'
                    . '</a></span>',
            ],
            [
                'id' => 'bottom_header_bar_html2_editor',
                'title' => esc_html__('HTML Element 2 Editor', 'bighearts'),
                'type' => 'ace_editor',
                'required' => ['header_type', '=', 'default'],
                'mode' => 'html',
                'default' => '<span style="font-size: 14px;"><a href="https://google.com.ua/maps/@40.7798704,-73.975151,15z" target="_blank">'
                    . '<i class="wgl-icon fa fa-map-marker-alt" style="margin-right: 5px;"></i>'
                    . '27 Division St, New York, NY 10002'
                    . '</a></span>',
            ],
            [
                'id' => 'bottom_header_bar_html3_editor',
                'title' => esc_html__('HTML Element 3 Editor', 'bighearts'),
                'type' => 'ace_editor',
                'required' => ['header_type', '=', 'default'],
                'mode' => 'html',
                'default' => '<span style="font-size: 12px;">'
                    . '<a href="https://twitter.com/"><i class="wgl-icon fab fa-twitter" style="padding: 12.5px"></i></a>'
                    . '<a href="https://facebook.com/"><i class="wgl-icon fab fa-facebook-f" style="padding: 12.5px"></i></a>'
                    . '<a href="https://linkedin.com/"><i class="wgl-icon fab fa-linkedin-in" style="padding: 12.5px"></i></a>'
                    . '<a href="https://instagram.com/"><i class="wgl-icon fab fa-instagram" style="padding: 12.5px; margin-right: -10px;"></i></a>'
                    . '</span>',
            ],
            [
                'id' => 'bottom_header_bar_html4_editor',
                'title' => esc_html__('HTML Element 4 Editor', 'bighearts'),
                'type' => 'ace_editor',
                'required' => ['header_type', '=', 'default'],
                'mode' => 'html',
            ],
            [
                'id' => 'bottom_header_bar_html5_editor',
                'title' => esc_html__('HTML Element 5 Editor', 'bighearts'),
                'type' => 'ace_editor',
                'required' => ['header_type', '=', 'default'],
                'mode' => 'html',
            ],
            [
                'id' => 'bottom_header_bar_html6_editor',
                'title' => esc_html__('HTML Element 6 Editor', 'bighearts'),
                'type' => 'ace_editor',
                'required' => ['header_type', '=', 'default'],
                'mode' => 'html',
            ],
            [
                'id' => 'bottom_header_bar_html7_editor',
                'title' => esc_html__('HTML Element 7 Editor', 'bighearts'),
                'type' => 'ace_editor',
                'required' => ['header_type', '=', 'default'],
                'mode' => 'html',
            ],
            [
                'id' => 'bottom_header_bar_html8_editor',
                'title' => esc_html__('HTML Element 8 Editor', 'bighearts'),
                'type' => 'ace_editor',
                'required' => ['header_type', '=', 'default'],
                'mode' => 'html',
            ],
            [
                'id' => 'bottom_header_side_panel_color',
                'title' => esc_html__('Icon Color', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['header_type', '=', 'default'],
                'mode' => 'background',
                'default' => [
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)',
                    'color' => '#ffffff',
                ],
            ],
            [
                'id' => 'bottom_header_side_panel_background',
                'title' => esc_html__('Background Icon', 'bighearts'),
                'type' => 'color',
                'required' => ['header_type', '=', 'default'],
                'default' => '#313131',
            ],
            [
                'id' => 'header_top-start',
                'title' => esc_html__('Header Top Options', 'bighearts'),
                'type' => 'section',
                'required' => ['header_type', '=', 'default'],
                'indent' => true,
            ],
            [
                'id' => 'header_top_full_width',
                'title' => esc_html__('Full Width Header', 'bighearts'),
                'type' => 'switch',
                'subtitle' => esc_html__('Set header content in full width', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'header_top_max_width_custom',
                'title' => esc_html__('Limit the Max Width of Container', 'bighearts'),
                'type' => 'switch',
                'default' => false,
            ],
            [
                'id' => 'header_top_max_width',
                'title' => esc_html__('Max Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_top_max_width_custom', '=', '1'],
                'width' => true,
                'height' => false,
                'default' => ['width' => 1290],
            ],
            [
                'id' => 'header_top_height',
                'title' => esc_html__('Header Top Height', 'bighearts'),
                'type' => 'dimensions',
                'width' => false,
                'height' => true,
                'default' => ['height' => 49],
            ],
            [
                'id' => 'header_top_background_image',
                'title' => esc_html__('Header Top Background Image', 'bighearts'),
                'type' => 'media',
            ],
            [
                'id' => 'header_top_background',
                'title' => esc_html__('Header Top Background', 'bighearts'),
                'type' => 'color_rgba',
                'mode' => 'background',
                'default' => [
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)',
                    'color' => '#ffffff',
                ],
            ],
            [
                'id' => 'header_top_color',
                'title' => esc_html__('Header Top Text Color', 'bighearts'),
                'type' => 'color',
                'transparent' => false,
                'default' => '#a2a2a2',
            ],
            [
                'id' => 'header_top_bottom_border',
                'type' => 'switch',
                'title' => esc_html__('Set Header Top Bottom Border', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'header_top_border_height',
                'title' => esc_html__('Header Top Border Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_top_bottom_border', '=', '1'],
                'width' => false,
                'height' => true,
                'default' => ['height' => '1'],
            ],
            [
                'id' => 'header_top_bottom_border_color',
                'title' => esc_html__('Header Top Border Color', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['header_top_bottom_border', '=', '1'],
                'mode' => 'background',
                'default' => [
                    'alpha' => '.2',
                    'rgba' => 'rgba(162,162,162,0.2)',
                    'color' => '#a2a2a2',
                ],
            ],
            [
                'id' => 'header_top-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_middle-start',
                'title' => esc_html__('Header Middle Options', 'bighearts'),
                'type' => 'section',
                'required' => ['header_type', '=', 'default'],
                'indent' => true,
            ],
            [
                'id' => 'header_middle_full_width',
                'type' => 'switch',
                'title' => esc_html__('Full Width Middle Header', 'bighearts'),
                'subtitle' => esc_html__('Set header content in full width', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'header_middle_max_width_custom',
                'title' => esc_html__('Limit the Max Width of Container', 'bighearts'),
                'type' => 'switch',
                'default' => false,
            ],
            [
                'id' => 'header_middle_max_width',
                'title' => esc_html__('Max Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_middle_max_width_custom', '=', '1'],
                'width' => true,
                'height' => false,
                'default' => ['width' => 1290],
            ],
            [
                'id' => 'header_middle_height',
                'title' => esc_html__('Header Middle Height', 'bighearts'),
                'type' => 'dimensions',
                'width' => false,
                'height' => true,
                'default' => ['height' => 98],
            ],
            [
                'id' => 'header_middle_background_image',
                'title' => esc_html__('Header Middle Background Image', 'bighearts'),
                'type' => 'media',
            ],
            [
                'id' => 'header_middle_background',
                'title' => esc_html__('Header Middle Background', 'bighearts'),
                'type' => 'color_rgba',
                'mode' => 'background',
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)'
                ],
            ],
            [
                'id' => 'header_middle_color',
                'title' => esc_html__('Header Middle Text Color', 'bighearts'),
                'type' => 'color',
                'transparent' => false,
                'default' => '#333332',
            ],
            [
                'id' => 'header_middle_bottom_border',
                'title' => esc_html__('Set Header Middle Bottom Border', 'bighearts'),
                'type' => 'switch',
                'default' => false,
            ],
            [
                'id' => 'header_middle_border_height',
                'title' => esc_html__('Header Middle Border Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_middle_bottom_border', '=', '1'],
                'height' => true,
                'width' => false,
                'default' => ['height' => '1'],
            ],
            [
                'id' => 'header_middle_bottom_border_color',
                'title' => esc_html__('Header Middle Border Color', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['header_middle_bottom_border', '=', '1'],
                'mode' => 'background',
                'default' => [
                    'alpha' => '1',
                    'rgba' => 'rgba(245,245,245,1)',
                    'color' => '#f5f5f5',
                ],
            ],
            [
                'id' => 'header_middle-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_bottom-start',
                'title' => esc_html__('Header Bottom Options', 'bighearts'),
                'type' => 'section',
                'required' => ['header_type', '=', 'default'],
                'indent' => true,
            ],
            [
                'id' => 'header_bottom_full_width',
                'title' => esc_html__('Full Width Bottom Header', 'bighearts'),
                'type' => 'switch',
                'subtitle' => esc_html__('Set header content in full width', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'header_bottom_max_width_custom',
                'title' => esc_html__('Limit the Max Width of Container', 'bighearts'),
                'type' => 'switch',
                'default' => false,
            ],
            [
                'id' => 'header_bottom_max_width',
                'title' => esc_html__('Max Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_bottom_max_width_custom', '=', '1'],
                'width' => true,
                'height' => false,
                'default' => ['width' => 1290],
            ],
            [
                'id' => 'header_bottom_height',
                'title' => esc_html__('Header Bottom Height', 'bighearts'),
                'type' => 'dimensions',
                'width' => false,
                'height' => true,
                'default' => ['height' => 100],
            ],
            [
                'id' => 'header_bottom_background_image',
                'title' => esc_html__('Header Bottom Background Image', 'bighearts'),
                'type' => 'media',
            ],
            [
                'id' => 'header_bottom_background',
                'title' => esc_html__('Header Bottom Background', 'bighearts'),
                'type' => 'color_rgba',
                'mode' => 'background',
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '.9',
                    'rgba' => 'rgba(255,255,255,0.9)'
                ],
            ],
            [
                'id' => 'header_bottom_color',
                'title' => esc_html__('Header Bottom Text Color', 'bighearts'),
                'type' => 'color',
                'transparent' => false,
                'default' => '#fefefe',
            ],
            [
                'id' => 'header_bottom_bottom_border',
                'title' => esc_html__('Set Header Bottom Border', 'bighearts'),
                'type' => 'switch',
                'default' => true,
            ],
            [
                'id' => 'header_bottom_border_height',
                'title' => esc_html__('Header Bottom Border Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_bottom_bottom_border', '=', '1'],
                'width' => false,
                'height' => true,
                'default' => ['height' => '1'],
            ],
            [
                'id' => 'header_bottom_bottom_border_color',
                'title' => esc_html__('Header Bottom Border Color', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['header_bottom_bottom_border', '=', '1'],
                'mode' => 'background',
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,0.2)'
                ],
            ],
            [
                'id' => 'header_bottom-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_column-top-left-start',
                'title' => esc_html__('Top Left Column Options', 'bighearts'),
                'type' => 'section',
                'required' => ['header_type', '=', 'default'],
                'indent' => true,
            ],
            [
                'id' => 'header_column_top_left_horz',
                'type' => 'button_set',
                'title' => esc_html__('Horizontal Align', 'bighearts'),
                'options' => [
                    'left' => esc_html__('Left', 'bighearts'),
                    'center' => esc_html__('Center', 'bighearts'),
                    'right' => esc_html__('Right', 'bighearts'),
                ],
                'default' => 'left'
            ],
            [
                'id' => 'header_column_top_left_vert',
                'type' => 'button_set',
                'title' => esc_html__('Vertical Align', 'bighearts'),
                'options' => [
                    'top' => esc_html__('Top', 'bighearts'),
                    'middle' => esc_html__('Middle', 'bighearts'),
                    'bottom' => esc_html__('Bottom', 'bighearts'),
                ],
                'default' => 'middle'
            ],
            [
                'id' => 'header_column_top_left_display',
                'type' => 'button_set',
                'title' => esc_html__('Display', 'bighearts'),
                'options' => [
                    'normal' => esc_html__('Normal', 'bighearts'),
                    'grow' => esc_html__('Grow', 'bighearts'),
                ],
                'default' => 'normal'
            ],
            [
                'id' => 'header_column-top-left-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_column-top-center-start',
                'title' => esc_html__('Top Center Column Options', 'bighearts'),
                'type' => 'section',
                'required' => ['header_type', '=', 'default'],
                'indent' => true,
            ],
            [
                'id' => 'header_column_top_center_horz',
                'title' => esc_html__('Horizontal Align', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'left' => esc_html__('Left', 'bighearts'),
                    'center' => esc_html__('Center', 'bighearts'),
                    'right' => esc_html__('Right', 'bighearts'),
                ],
                'default' => 'left'
            ],
            [
                'id' => 'header_column_top_center_vert',
                'title' => esc_html__('Vertical Align', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'top' => esc_html__('Top', 'bighearts'),
                    'middle' => esc_html__('Middle', 'bighearts'),
                    'bottom' => esc_html__('Bottom', 'bighearts'),
                ],
                'default' => 'middle'
            ],
            [
                'id' => 'header_column_top_center_display',
                'title' => esc_html__('Display', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'normal' => esc_html__('Normal', 'bighearts'),
                    'grow' => esc_html__('Grow', 'bighearts'),
                ],
                'default' => 'normal'
            ],
            [
                'id' => 'header_column-top-center-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_column-top-center-start',
                'title' => esc_html__('Top Center Column Options', 'bighearts'),
                'type' => 'section',
                'required' => ['header_type', '=', 'default'],
                'indent' => true,
            ],
            [
                'id' => 'header_column_top_center_horz',
                'title' => esc_html__('Horizontal Align', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'left' => esc_html__('Left', 'bighearts'),
                    'center' => esc_html__('Center', 'bighearts'),
                    'right' => esc_html__('Right', 'bighearts'),
                ],
                'default' => 'left'
            ],
            [
                'id' => 'header_column_top_center_vert',
                'title' => esc_html__('Vertical Align', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'top' => esc_html__('Top', 'bighearts'),
                    'middle' => esc_html__('Middle', 'bighearts'),
                    'bottom' => esc_html__('Bottom', 'bighearts'),
                ],
                'default' => 'middle'
            ],
            [
                'id' => 'header_column_top_center_display',
                'title' => esc_html__('Display', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'normal' => esc_html__('Normal', 'bighearts'),
                    'grow' => esc_html__('Grow', 'bighearts'),
                ],
                'default' => 'normal'
            ],
            [
                'id' => 'header_column-top-center-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_column-top-right-start',
                'title' => esc_html__('Top Right Column Options', 'bighearts'),
                'type' => 'section',
                'required' => ['header_type', '=', 'default'],
                'indent' => true,
            ],
            [
                'id' => 'header_column_top_right_horz',
                'title' => esc_html__('Horizontal Align', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'left' => esc_html__('Left', 'bighearts'),
                    'center' => esc_html__('Center', 'bighearts'),
                    'right' => esc_html__('Right', 'bighearts'),
                ],
                'default' => 'right'
            ],
            [
                'id' => 'header_column_top_right_vert',
                'title' => esc_html__('Vertical Align', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'top' => esc_html__('Top', 'bighearts'),
                    'middle' => esc_html__('Middle', 'bighearts'),
                    'bottom' => esc_html__('Bottom', 'bighearts'),
                ],
                'default' => 'middle'
            ],
            [
                'id' => 'header_column_top_right_display',
                'title' => esc_html__('Display', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'normal' => esc_html__('Normal', 'bighearts'),
                    'grow' => esc_html__('Grow', 'bighearts'),
                ],
                'default' => 'normal'
            ],
            [
                'id' => 'header_column-top-right-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_column-middle-left-start',
                'title' => esc_html__('Middle Left Column Options', 'bighearts'),
                'type' => 'section',
                'required' => ['header_type', '=', 'default'],
                'indent' => true,
            ],
            [
                'id' => 'header_column_middle_left_horz',
                'title' => esc_html__('Horizontal Align', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'left' => esc_html__('Left', 'bighearts'),
                    'center' => esc_html__('Center', 'bighearts'),
                    'right' => esc_html__('Right', 'bighearts'),
                ],
                'default' => 'left'
            ],
            [
                'id' => 'header_column_middle_left_vert',
                'title' => esc_html__('Vertical Align', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'top' => esc_html__('Top', 'bighearts'),
                    'middle' => esc_html__('Middle', 'bighearts'),
                    'bottom' => esc_html__('Bottom', 'bighearts'),
                ],
                'default' => 'middle'
            ],
            [
                'id' => 'header_column_middle_left_display',
                'title' => esc_html__('Display', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'normal' => esc_html__('Normal', 'bighearts'),
                    'grow' => esc_html__('Grow', 'bighearts'),
                ],
                'default' => 'normal'
            ],
            [
                'id' => 'header_column-middle-left-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_column-middle-center-start',
                'title' => esc_html__('Middle Center Column Options', 'bighearts'),
                'type' => 'section',
                'required' => ['header_type', '=', 'default'],
                'indent' => true,
            ],
            [
                'id' => 'header_column_middle_center_horz',
                'type' => 'button_set',
                'title' => esc_html__('Horizontal Align', 'bighearts'),
                'options' => [
                    'left' => esc_html__('Left', 'bighearts'),
                    'center' => esc_html__('Center', 'bighearts'),
                    'right' => esc_html__('Right', 'bighearts'),
                ],
                'default' => 'center',
            ],
            [
                'id' => 'header_column_middle_center_vert',
                'type' => 'button_set',
                'title' => esc_html__('Vertical Align', 'bighearts'),
                'options' => [
                    'top' => esc_html__('Top', 'bighearts'),
                    'middle' => esc_html__('Middle', 'bighearts'),
                    'bottom' => esc_html__('Bottom', 'bighearts'),
                ],
                'default' => 'middle'
            ],
            [
                'id' => 'header_column_middle_center_display',
                'title' => esc_html__('Display', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'normal' => esc_html__('Normal', 'bighearts'),
                    'grow' => esc_html__('Grow', 'bighearts'),
                ],
                'default' => 'normal'
            ],
            [
                'id' => 'header_column-middle-center-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_column-middle-right-start',
                'title' => esc_html__('Middle Right Column Options', 'bighearts'),
                'type' => 'section',
                'required' => ['header_type', '=', 'default'],
                'indent' => true,
            ],
            [
                'id' => 'header_column_middle_right_horz',
                'title' => esc_html__('Horizontal Align', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'left' => esc_html__('Left', 'bighearts'),
                    'center' => esc_html__('Center', 'bighearts'),
                    'right' => esc_html__('Right', 'bighearts'),
                ],
                'default' => 'right',
            ],
            [
                'id' => 'header_column_middle_right_vert',
                'title' => esc_html__('Vertical Align', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'top' => esc_html__('Top', 'bighearts'),
                    'middle' => esc_html__('Middle', 'bighearts'),
                    'bottom' => esc_html__('Bottom', 'bighearts'),
                ],
                'default' => 'middle',
            ],
            [
                'id' => 'header_column_middle_right_display',
                'type' => 'button_set',
                'title' => esc_html__('Display', 'bighearts'),
                'options' => [
                    'normal' => esc_html__('Normal', 'bighearts'),
                    'grow' => esc_html__('Grow', 'bighearts'),
                ],
                'default' => 'normal',
            ],
            [
                'id' => 'header_column-middle-right-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_column-bottom-left-start',
                'title' => esc_html__('Bottom Left Column Options', 'bighearts'),
                'type' => 'section',
                'required' => ['header_type', '=', 'default'],
                'indent' => true,
            ],
            [
                'id' => 'header_column_bottom_left_horz',
                'title' => esc_html__('Horizontal Align', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'left' => esc_html__('Left', 'bighearts'),
                    'center' => esc_html__('Center', 'bighearts'),
                    'right' => esc_html__('Right', 'bighearts'),
                ],
                'default' => 'left'
            ],
            [
                'id' => 'header_column_bottom_left_vert',
                'title' => esc_html__('Vertical Align', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'top' => esc_html__('Top', 'bighearts'),
                    'middle' => esc_html__('Middle', 'bighearts'),
                    'bottom' => esc_html__('Bottom', 'bighearts'),
                ],
                'default' => 'middle'
            ],
            [
                'id' => 'header_column_bottom_left_display',
                'title' => esc_html__('Display', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'normal' => esc_html__('Normal', 'bighearts'),
                    'grow' => esc_html__('Grow', 'bighearts'),
                ],
                'default' => 'normal'
            ],
            [
                'id' => 'header_column-bottom-left-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_column-bottom-center-start',
                'type' => 'section',
                'title' => esc_html__('Bottom Center Column Options', 'bighearts'),
                'indent' => true,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'header_column_bottom_center_horz',
                'title' => esc_html__('Horizontal Align', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'left' => esc_html__('Left', 'bighearts'),
                    'center' => esc_html__('Center', 'bighearts'),
                    'right' => esc_html__('Right', 'bighearts'),
                ],
                'default' => 'left'
            ],
            [
                'id' => 'header_column_bottom_center_vert',
                'title' => esc_html__('Vertical Align', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'top' => esc_html__('Top', 'bighearts'),
                    'middle' => esc_html__('Middle', 'bighearts'),
                    'bottom' => esc_html__('Bottom', 'bighearts'),
                ],
                'default' => 'middle'
            ],
            [
                'id' => 'header_column_bottom_center_display',
                'type' => 'button_set',
                'title' => esc_html__('Display', 'bighearts'),
                'options' => [
                    'normal' => esc_html__('Normal', 'bighearts'),
                    'grow' => esc_html__('Grow', 'bighearts'),
                ],
                'default' => 'normal'
            ],
            [
                'id' => 'header_column-bottom-center-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_column-bottom-right-start',
                'title' => esc_html__('Bottom Right Column Options', 'bighearts'),
                'type' => 'section',
                'required' => ['header_type', '=', 'default'],
                'indent' => true,
            ],
            [
                'id' => 'header_column_bottom_right_horz',
                'title' => esc_html__('Horizontal Align', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'left' => esc_html__('Left', 'bighearts'),
                    'center' => esc_html__('Center', 'bighearts'),
                    'right' => esc_html__('Right', 'bighearts'),
                ],
                'default' => 'right'
            ],
            [
                'id' => 'header_column_bottom_right_vert',
                'title' => esc_html__('Vertical Align', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'top' => esc_html__('Top', 'bighearts'),
                    'middle' => esc_html__('Middle', 'bighearts'),
                    'bottom' => esc_html__('Bottom', 'bighearts'),
                ],
                'default' => 'middle'
            ],
            [
                'id' => 'header_column_bottom_right_display',
                'title' => esc_html__('Display', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'normal' => esc_html__('Normal', 'bighearts'),
                    'grow' => esc_html__('Grow', 'bighearts'),
                ],
                'default' => 'normal'
            ],
            [
                'id' => 'header_column-bottom-right-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_row_settings-start',
                'title' => esc_html__('Header Settings', 'bighearts'),
                'type' => 'section',
                'required' => ['header_type', '=', 'default'],
                'indent' => true,
            ],
            [
                'id' => 'header_shadow',
                'title' => esc_html__('Header Bottom Shadow', 'bighearts'),
                'type' => 'switch',
                'default' => false,
            ],
            [
                'id' => 'header_on_bg',
                'title' => esc_html__('Over content', 'bighearts'),
                'type' => 'switch',
                'subtitle' => esc_html__('Display header template over the content.', 'bighearts'),
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'lavalamp_active',
                'type' => 'switch',
                'title' => esc_html__('Lavalamp Marker', 'bighearts'),
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'sub_menu_background',
                'type' => 'color_rgba',
                'title' => esc_html__('Sub Menu Background', 'bighearts'),
                'mode' => 'background',
                'default' => [
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)',
                    'color' => '#ffffff',
                ],
            ],
            [
                'id' => 'sub_menu_color',
                'title' => esc_html__('Sub Menu Text Color', 'bighearts'),
                'type' => 'color',
                'transparent' => false,
                'default' => '#313131',
            ],
            [
                'id' => 'header_sub_menu_bottom_border',
                'title' => esc_html__('Sub Menu Bottom Border', 'bighearts'),
                'type' => 'switch',
                'default' => false,
            ],
            [
                'id' => 'header_sub_menu_border_height',
                'title' => esc_html__('Sub Menu Border Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['header_sub_menu_bottom_border', '=', '1'],
                'width' => false,
                'height' => true,
                'default' => ['height' => '1'],
            ],
            [
                'id' => 'header_sub_menu_bottom_border_color',
                'title' => esc_html__('Sub Menu Border Color', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['header_sub_menu_bottom_border', '=', '1'],
                'mode' => 'background',
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(0, 0, 0, 0.08)'
                ],
            ],
            [
                'id' => 'header_mobile_queris',
                'title' => esc_html__('Mobile Header Switch Breakpoint', 'bighearts'),
                'type' => 'slider',
                'display_value' => 'text',
                'min' => 400,
                'max' => 1920,
                'default' => 1200,
            ],
            [
                'id' => 'header_row_settings-end',
                'type' => 'section',
                'indent' => false,
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Header Sticky', 'bighearts'),
        'id' => 'header_builder_sticky',
        'subsection' => true,
        'fields' => [
            [
                'id' => 'header_sticky',
                'title' => esc_html__('Header Sticky', 'bighearts'),
                'type' => 'switch',
                'default' => true,
            ],
            [
                'id' => 'header_sticky-start',
                'title' => esc_html__('Sticky Settings', 'bighearts'),
                'type' => 'section',
                'required' => ['header_sticky', '=', '1'],
                'indent' => true,
            ],
            [
                'id' => 'header_sticky_page_select',
                'title' => esc_html__('Header Sticky Template', 'bighearts'),
                'type' => 'select',
                'required' => ['header_sticky', '=', '1'],
                'desc' => sprintf(
                    '%s <a href="%s" target="_blank">%s</a> %s',
                    esc_html__('Selected Template will be used for all pages by default. You can edit/create Header Template in the', 'bighearts'),
                    admin_url('edit.php?post_type=header'),
                    esc_html__('Header Templates', 'bighearts'),
                    esc_html__('dashboard tab.', 'bighearts')
                ),
                'data' => 'posts',
                'args' => [
                    'post_type' => 'header',
                    'posts_per_page' => -1,
                    'orderby' => 'title',
                    'order' => 'ASC',
                ],
            ],
            [
                'id' => 'header_sticky_style',
                'type' => 'select',
                'title' => esc_html__('Appearance', 'bighearts'),
                'options' => [
                    'standard' => esc_html__('Always Visible', 'bighearts'),
                    'scroll_up' => esc_html__('Visible while scrolling upwards', 'bighearts'),
                ],
                'default' => 'scroll_up'
            ],
            [
                'id' => 'header_sticky-end',
                'type' => 'section',
                'indent' => false,
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Header Mobile', 'bighearts'),
        'id' => 'header_builder_mobile',
        'subsection' => true,
        'fields' => [
            [
                'id' => 'mobile_header',
                'title' => esc_html__('Mobile Header', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Custom', 'bighearts'),
                'off' => esc_html__('Default', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'header_mobile_appearance-start',
                'title' => esc_html__('Appearance', 'bighearts'),
                'type' => 'section',
                'required' => ['mobile_header', '=', '1'],
                'indent' => true,
            ],
            [
                'id' => 'header_mobile_height',
                'title' => esc_html__('Header Height', 'bighearts'),
                'type' => 'dimensions',
                'width' => false,
                'height' => true,
                'default' => ['height' => '100'],
            ],
            [
                'id' => 'header_mobile_full_width',
                'title' => esc_html__('Full Width Header', 'bighearts'),
                'type' => 'switch',
                'default' => false,
            ],
            [
                'id' => 'mobile_sticky',
                'title' => esc_html__('Mobile Sticky Header', 'bighearts'),
                'type' => 'switch',
                'default' => false,
            ],
            [
                'id' => 'mobile_over_content',
                'title' => esc_html__('Header Over Content', 'bighearts'),
                'type' => 'switch',
                'default' => false,
            ],
            [
                'id' => 'mobile_background',
                'title' => esc_html__('Header Background', 'bighearts'),
                'type' => 'color_rgba',
                'mode' => 'background',
                'default' => [
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)',
                    'color' => '#313131',
                ],
            ],
            [
                'id' => 'mobile_color',
                'title' => esc_html__('Header Text Color', 'bighearts'),
                'type' => 'color',
                'transparent' => false,
                'default' => '#ffffff',
            ],
            [
                'id' => 'header_mobile_appearance-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_mobile_menu-start',
                'title' => esc_html__('Menu', 'bighearts'),
                'type' => 'section',
                'required' => ['mobile_header', '=', '1'],
                'indent' => true,
            ],
            [
                'id' => 'mobile_position',
                'title' => esc_html__('Menu Occurrence', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'left' => esc_html__('Left', 'bighearts'),
                    'right' => esc_html__('Right', 'bighearts'),
                ],
                'default' => 'left',
            ],
            [
                'id' => 'custom_mobile_menu',
                'title' => esc_html__('Custom Mobile Menu', 'bighearts'),
                'type' => 'switch',
                'default' => false,
            ],
            [
                'id' => 'mobile_menu',
                'type' => 'select',
                'title' => esc_html__('Mobile Menu', 'bighearts'),
                'required' => ['custom_mobile_menu', '=', '1'],
                'select2' => ['allowClear' => false],
                'options' => $menus = bighearts_get_custom_menu(),
                'default' => reset($menus),
            ],
            [
                'id' => 'mobile_sub_menu_color',
                'title' => esc_html__('Menu Text Color', 'bighearts'),
                'type' => 'color',
                'transparent' => false,
                'default' => '#ffffff',
            ],
            [
                'id' => 'mobile_sub_menu_background',
                'title' => esc_html__('Menu Background', 'bighearts'),
                'type' => 'color_rgba',
                'mode' => 'background',
                'default' => [
                    'alpha' => '1',
                    'rgba' => 'rgba(45,45,45,1)',
                    'color' => '#2d2d2d',
                ],
            ],
            [
                'id' => 'mobile_sub_menu_overlay',
                'title' => esc_html__('Menu Overlay', 'bighearts'),
                'type' => 'color_rgba',
                'mode' => 'background',
                'default' => [
                    'alpha' => '1',
                    'rgba' => 'rgba(49, 49, 49, 0.8)',
                    'color' => '#313131',
                ],
            ],
            [
                'id' => 'header_mobile_menu-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'mobile_header_layout',
                'title' => esc_html__('Mobile Header Order', 'bighearts'),
                'type' => 'sorter',
                'required' => ['mobile_header', '=', '1'],
                'desc' => esc_html__('Organize the layout of the mobile header', 'bighearts'),
                'compiler' => 'true',
                'full_width' => true,
                'options' => [
                    'items' => $header_builder_items['mobile'],
                    'Left align side' => [
                        'menu' => esc_html__('Hamburger Menu', 'bighearts'),
                    ],
                    'Center align side' => [
                        'logo' => esc_html__('Logo', 'bighearts'),
                    ],
                    'Right align side' => [
                        'item_search' => esc_html__('Search', 'bighearts'),
                    ],
                ],
            ],
            [
                'id' => 'mobile_content_header_layout',
                'title' => esc_html__('Mobile Drawer Content', 'bighearts'),
                'type' => 'sorter',
                'required' => ['mobile_header', '=', '1'],
                'desc' => esc_html__('Organize the layout of the mobile header', 'bighearts'),
                'compiler' => 'true',
                'full_width' => true,
                'options' => [
                    'items' => $header_builder_items['mobile_drawer'],
                    'Left align side' => [
                        'logo' => esc_html__('Logo', 'bighearts'),
                        'menu' => esc_html__('Menu', 'bighearts'),
                        'item_search' => esc_html__('Search', 'bighearts'),
                    ],
                ],
                'default' => [
                    'items' => $header_builder_items['mobile_drawer'],
                    'Left align side' => [
                        'logo' => esc_html__('Logo', 'bighearts'),
                        'menu' => esc_html__('Menu', 'bighearts'),
                        'item_search' => esc_html__('Search', 'bighearts'),
                    ],
                ],
            ],
            [
                'id' => 'mobile_header_bar_html1_editor',
                'title' => esc_html__('HTML Element 1 Editor', 'bighearts'),
                'type' => 'ace_editor',
                'required' => ['mobile_header', '=', '1'],
                'mode' => 'html',
                'default' => '',
            ],
            [
                'id' => 'mobile_header_bar_html2_editor',
                'title' => esc_html__('HTML Element 2 Editor', 'bighearts'),
                'type' => 'ace_editor',
                'required' => ['mobile_header', '=', '1'],
                'mode' => 'html',
                'default' => '',
            ],
            [
                'id' => 'mobile_header_bar_html3_editor',
                'title' => esc_html__('HTML Element 3 Editor', 'bighearts'),
                'type' => 'ace_editor',
                'required' => ['mobile_header', '=', '1'],
                'mode' => 'html',
                'default' => '',
            ],
            [
                'id' => 'mobile_header_bar_html4_editor',
                'title' => esc_html__('HTML Element 4 Editor', 'bighearts'),
                'type' => 'ace_editor',
                'required' => ['mobile_header', '=', '1'],
                'mode' => 'html',
                'default' => '',
            ],
            [
                'id' => 'mobile_header_bar_html5_editor',
                'title' => esc_html__('HTML Element 5 Editor', 'bighearts'),
                'type' => 'ace_editor',
                'required' => ['mobile_header', '=', '1'],
                'mode' => 'html',
                'default' => '',
            ],
            [
                'id' => 'mobile_header_bar_html6_editor',
                'title' => esc_html__('HTML Element 6 Editor', 'bighearts'),
                'type' => 'ace_editor',
                'required' => ['mobile_header', '=', '1'],
                'mode' => 'html',
                'default' => '',
            ],
            [
                'id' => 'mobile_header_spacer1',
                'title' => esc_html__('Spacer 1 Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['mobile_header', '=', '1'],
                'width' => true,
                'height' => false,
                'default' => ['width' => 25],
            ],
            [
                'id' => 'mobile_header_spacer2',
                'title' => esc_html__('Spacer 2 Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['mobile_header', '=', '1'],
                'width' => true,
                'height' => false,
                'default' => ['width' => 25],
            ],
            [
                'id' => 'mobile_header_spacer3',
                'title' => esc_html__('Spacer 3 Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['mobile_header', '=', '1'],
                'width' => true,
                'height' => false,
                'default' => ['width' => 25],
            ],
            [
                'id' => 'mobile_header_spacer4',
                'title' => esc_html__('Spacer 4 Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['mobile_header', '=', '1'],
                'width' => true,
                'height' => false,
                'default' => ['width' => 25],
            ],
            [
                'id' => 'mobile_header_spacer5',
                'title' => esc_html__('Spacer 5 Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['mobile_header', '=', '1'],
                'width' => true,
                'height' => false,
                'default' => ['width' => 25],
            ],
            [
                'id' => 'mobile_header_spacer6',
                'title' => esc_html__('Spacer 6 Width', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['mobile_header', '=', '1'],
                'width' => true,
                'height' => false,
                'default' => ['width' => 25],
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'logo',
        'title' => esc_html__('Logo', 'bighearts'),
        'subsection' => true,
        'required' => ['header_type', '=', 'custom'],
        'fields' => [
            [
                'id' => 'header_logo',
                'title' => esc_html__('Default Header Logo', 'bighearts'),
                'type' => 'media',
            ],
            [
                'id' => 'logo_height_custom',
                'title' => esc_html__('Limit Default Logo Height', 'bighearts'),
                'type' => 'switch',
                'required' => ['header_logo', '!=', ''],
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'logo_height',
                'title' => esc_html__('Default Logo Height', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['logo_height_custom', '=', '1'],
                'height' => true,
                'width' => false,
                'default' => ['height' => 90],
            ],
            [
                'id' => 'sticky_header_logo',
                'title' => esc_html__('Sticky Header Logo', 'bighearts'),
                'type' => 'media',
            ],
            [
                'id' => 'sticky_logo_height_custom',
                'title' => esc_html__('Limit Sticky Logo Height', 'bighearts'),
                'type' => 'switch',
                'required' => ['sticky_header_logo', '!=', ''],
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'sticky_logo_height',
                'title' => esc_html__('Sticky Header Logo Height', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['sticky_logo_height_custom', '=', '1'],
                'height' => true,
                'width' => false,
                'default' => ['height' => 90],
            ],
            [
                'id' => 'logo_mobile',
                'title' => esc_html__('Mobile Header Logo', 'bighearts'),
                'type' => 'media',
            ],
            [
                'id' => 'mobile_logo_height_custom',
                'title' => esc_html__('Limit Mobile Logo Height', 'bighearts'),
                'type' => 'switch',
                'required' => ['logo_mobile', '!=', ''],
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'mobile_logo_height',
                'title' => esc_html__('Mobile Logo Height', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['mobile_logo_height_custom', '=', '1'],
                'height' => true,
                'width' => false,
                'default' => ['height' => 60],
            ],
            [
                'id' => 'logo_mobile_menu',
                'title' => esc_html__('Mobile Menu Logo', 'bighearts'),
                'type' => 'media',
            ],
            [
                'id' => 'mobile_logo_menu_height_custom',
                'title' => esc_html__('Limit Mobile Menu Logo Height', 'bighearts'),
                'type' => 'switch',
                'required' => ['logo_mobile_menu', '!=', ''],
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'mobile_logo_menu_height',
                'title' => esc_html__('Mobile Menu Logo Height', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['mobile_logo_menu_height_custom', '=', '1'],
                'height' => true,
                'width' => false,
                'default' => ['height' => 60],
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'page_title',
        'title' => esc_html__('Page Title', 'bighearts'),
        'icon' => 'el el-home-alt',
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'page_title_settings',
        'title' => esc_html__('General', 'bighearts'),
        'subsection' => true,
        'fields' => [
            [
                'id' => 'page_title_switch',
                'title' => esc_html__('Use Page Titles?', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'page_title-start',
                'title' => esc_html__('Appearance', 'bighearts'),
                'type' => 'section',
                'required' => ['page_title_switch', '=', '1'],
                'indent' => true,
            ],
            [
                'id' => 'page_title_bg_switch',
                'title' => esc_html__('Use Background Image/Color?', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'page_title_bg_image',
                'title' => esc_html__('Background Image/Color', 'bighearts'),
                'type' => 'background',
                'required' => ['page_title_bg_switch', '=', true],
                'preview' => false,
                'preview_media' => true,
                'background-color' => true,
                'transparent' => false,
                'default' => [
                    'background-image' => '',
                    'background-repeat' => 'no-repeat',
                    'background-size' => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position' => 'center bottom',
                    'background-color' => '#001322',
                ],
            ],
            [
                'id' => 'page_title_height',
                'title' => esc_html__('Min Height', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['page_title_bg_switch', '=', true],
                'desc' => esc_html__('Choose `0px` in order to use `min-height: auto;`', 'bighearts'),
                'width' => false,
                'height' => true,
                'default' => ['height' => 396],
            ],
            [
                'id' => 'page_title_padding',
                'title' => esc_html__('Paddings Top/Bottom', 'bighearts'),
                'type' => 'spacing',
                'mode' => 'padding',
                'all' => false,
                'bottom' => true,
                'top' => true,
                'left' => false,
                'right' => false,
                'default' => [
                    'padding-top' => '60',
                    'padding-bottom' => '80',
                ],
            ],
            [
                'id' => 'page_title_margin',
                'title' => esc_html__('Margin Bottom', 'bighearts'),
                'type' => 'spacing',
                'mode' => 'margin',
                'all' => false,
                'bottom' => true,
                'top' => false,
                'left' => false,
                'right' => false,
                'default' => ['margin-bottom' => '50'],
            ],
            [
                'id' => 'page_title_align',
                'title' => esc_html__('Title Alignment', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'left' => esc_html__('Left', 'bighearts'),
                    'center' => esc_html__('Center', 'bighearts'),
                    'right' => esc_html__('Right', 'bighearts'),
                ],
                'default' => 'center',
            ],
            [
                'id' => 'page_title_breadcrumbs_switch',
                'title' => esc_html__('Breadcrumbs', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'page_title_breadcrumbs_block_switch',
                'title' => esc_html__('Breadcrumbs Full Width', 'bighearts'),
                'type' => 'switch',
                'required' => ['page_title_breadcrumbs_switch', '=', true],
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'page_title_breadcrumbs_align',
                'title' => esc_html__('Breadcrumbs Alignment', 'bighearts'),
                'type' => 'button_set',
                'required' => ['page_title_breadcrumbs_block_switch', '=', true],
                'options' => [
                    'left' => esc_html__('Left', 'bighearts'),
                    'center' => esc_html__('Center', 'bighearts'),
                    'right' => esc_html__('Right', 'bighearts'),
                ],
                'default' => 'center',
            ],
            [
                'id' => 'page_title_parallax',
                'title' => esc_html__('Parallax Effect', 'bighearts'),
                'type' => 'switch',
                'default' => false,
            ],
            [
                'id' => 'page_title_parallax_speed',
                'title' => esc_html__('Parallax Speed', 'bighearts'),
                'type' => 'spinner',
                'required' => ['page_title_parallax', '=', '1'],
                'min' => '-5',
                'max' => '5',
                'step' => '0.1',
                'default' => '0.3',
            ],
            [
                'id' => 'page_title-end',
                'type' => 'section',
                'indent' => false,
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'page_title_typography',
        'title' => esc_html__('Typography', 'bighearts'),
        'subsection' => true,
        'fields' => [
            [
                'id' => 'page_title_font',
                'title' => esc_html__('Page Title Font', 'bighearts'),
                'type' => 'custom_typography',
                'font-size' => true,
                'google' => false,
                'font-weight' => false,
                'font-family' => false,
                'font-style' => false,
                'color' => true,
                'line-height' => true,
                'font-backup' => false,
                'text-align' => false,
                'all_styles' => false,
                'default' => [
                    'font-size' => '48px',
                    'line-height' => '76px',
                    'color' => '#ffffff',
                ],
            ],
            [
                'id' => 'page_title_breadcrumbs_font',
                'title' => esc_html__('Breadcrumbs Font', 'bighearts'),
                'type' => 'custom_typography',
                'font-size' => true,
                'google' => false,
                'font-weight' => false,
                'font-family' => false,
                'font-style' => false,
                'color' => true,
                'line-height' => true,
                'font-backup' => false,
                'text-align' => false,
                'all_styles' => false,
                'default' => [
                    'font-size' => '14px',
                    'color' => '#ffffff',
                    'line-height' => '24px',
                ],
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Responsive', 'bighearts'),
        'id' => 'page_title_responsive',
        'subsection' => true,
        'fields' => [
            [
                'id' => 'page_title_resp_switch',
                'title' => esc_html__('Responsive Settings', 'bighearts'),
                'type' => 'switch',
                'default' => true,
            ],
            [
                'id' => 'page_title_resp_resolution',
                'title' => esc_html__('Screen breakpoint', 'bighearts'),
                'type' => 'slider',
                'required' => ['page_title_resp_switch', '=', '1'],
                'desc' => esc_html__('Use responsive settings on screens smaller then choosed breakpoint.', 'bighearts'),
                'display_value' => 'text',
                'min' => 1,
                'max' => 1700,
                'step' => 1,
                'default' => 768,
            ],
            [
                'id' => 'page_title_resp_padding',
                'title' => esc_html__('Page Title Paddings', 'bighearts'),
                'type' => 'spacing',
                'required' => ['page_title_resp_switch', '=', '1'],
                'mode' => 'padding',
                'all' => false,
                'bottom' => true,
                'top' => true,
                'left' => false,
                'right' => false,
                'default' => [
                    'padding-top' => '70',
                    'padding-bottom' => '70',
                ],
            ],
            [
                'id' => 'page_title_resp_font',
                'title' => esc_html__('Page Title Font', 'bighearts'),
                'type' => 'custom_typography',
                'required' => ['page_title_resp_switch', '=', '1'],
                'google' => false,
                'all_styles' => false,
                'font-family' => false,
                'font-style' => false,
                'font-size' => true,
                'font-weight' => false,
                'font-backup' => false,
                'line-height' => true,
                'text-align' => false,
                'color' => true,
                'default' => [
                    'font-size' => '38px',
                    'line-height' => '48px',
                    'color' => '#ffffff',
                ],
            ],
            [
                'id' => 'page_title_resp_breadcrumbs_switch',
                'title' => esc_html__('Breadcrumbs', 'bighearts'),
                'type' => 'switch',
                'required' => ['page_title_resp_switch', '=', '1'],
                'default' => true,
            ],
            [
                'id' => 'page_title_resp_breadcrumbs_font',
                'title' => esc_html__('Breadcrumbs Font', 'bighearts'),
                'type' => 'custom_typography',
                'required' => ['page_title_resp_breadcrumbs_switch', '=', '1'],
                'google' => false,
                'all_styles' => false,
                'font-family' => false,
                'font-style' => false,
                'font-size' => true,
                'font-weight' => false,
                'font-backup' => false,
                'line-height' => true,
                'text-align' => false,
                'color' => true,
                'default' => [
                    'font-size' => '14px',
                    'color' => '#ffffff',
                    'line-height' => '24px',
                ],
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'footer',
        'title' => esc_html__('Footer', 'bighearts'),
        'icon' => 'fas fa-window-maximize el-rotate-180',
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'footer-general',
        'title' => esc_html__('General', 'bighearts'),
        'subsection' => true,
        'fields' => [
            [
                'id' => 'footer_switch',
                'title' => esc_html__('Footer', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Disable', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'footer-start',
                'title' => esc_html__('Footer Settings', 'bighearts'),
                'type' => 'section',
                'required' => ['footer_switch', '=', '1'],
                'indent' => true,
            ],
            [
                'id' => 'footer_content_type',
                'title' => esc_html__('Content Type', 'bighearts'),
                'type' => 'select',
                'options' => [
                    'widgets' => esc_html__('Get Widgets', 'bighearts'),
                    'pages' => esc_html__('Get Pages', 'bighearts'),
                ],
                'default' => 'widgets',
            ],
            [
                'id' => 'footer_page_select',
                'title' => esc_html__('Page Select', 'bighearts'),
                'type' => 'select',
                'required' => ['footer_content_type', '=', 'pages'],
                'data' => 'posts',
                'args' => [
                    'post_type' => 'footer',
                    'posts_per_page' => -1,
                    'orderby' => 'title',
                    'order' => 'ASC',
                ],
            ],
            [
                'id' => 'widget_columns',
                'title' => esc_html__('Columns', 'bighearts'),
                'type' => 'button_set',
                'required' => ['footer_content_type', '=', 'widgets'],
                'options' => [
                    '1' => esc_html__('1', 'bighearts'),
                    '2' => esc_html__('2', 'bighearts'),
                    '3' => esc_html__('3', 'bighearts'),
                    '4' => esc_html__('4', 'bighearts'),
                ],
                'default' => '4',
            ],
            [
                'id' => 'widget_columns_2',
                'title' => esc_html__('Columns Layout', 'bighearts'),
                'type' => 'image_select',
                'required' => ['widget_columns', '=', '2'],
                'options' => [
                    '6-6' => [
                        'alt' => '50-50',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/50-50.png'
                    ],
                    '3-9' => [
                        'alt' => '25-75',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/25-75.png'
                    ],
                    '9-3' => [
                        'alt' => '75-25',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/75-25.png'
                    ],
                    '4-8' => [
                        'alt' => '33-66',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/33-66.png'
                    ],
                    '8-4' => [
                        'alt' => '66-33',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/66-33.png'
                    ]
                ],
                'default' => '6-6',
            ],
            [
                'id' => 'widget_columns_3',
                'title' => esc_html__('Columns Layout', 'bighearts'),
                'type' => 'image_select',
                'required' => ['widget_columns', '=', '3'],
                'options' => [
                    '4-4-4' => [
                        'alt' => '33-33-33',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/33-33-33.png'
                    ],
                    '3-3-6' => [
                        'alt' => '25-25-50',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/25-25-50.png'
                    ],
                    '3-6-3' => [
                        'alt' => '25-50-25',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/25-50-25.png'
                    ],
                    '6-3-3' => [
                        'alt' => '50-25-25',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/50-25-25.png'
                    ],
                ],
                'default' => '4-4-4',
            ],
            [
                'id' => 'footer_spacing',
                'title' => esc_html__('Paddings', 'bighearts'),
                'type' => 'spacing',
                'required' => ['footer_content_type', '=', 'widgets'],
                'output' => ['.wgl-footer'],
                'all' => false,
                'mode' => 'padding',
                'units' => 'px',
                'default' => [
                    'padding-top' => '50px',
                    'padding-right' => '0px',
                    'padding-bottom' => '0px',
                    'padding-left' => '0px'
                ],
            ],
            [
                'id' => 'footer_full_width',
                'title' => esc_html__('Full Width On/Off', 'bighearts'),
                'type' => 'switch',
                'required' => ['footer_content_type', '=', 'widgets'],
                'default' => false,
            ],
            [
                'id' => 'footer-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'footer-start-styles',
                'title' => esc_html__('Footer Styling', 'bighearts'),
                'type' => 'section',
                'required' => [
                    ['footer_switch', '=', '1'],
                    ['footer_content_type', '=', 'widgets'],
                ],
                'indent' => true,
            ],
            [
                'id' => 'footer_bg_image',
                'title' => esc_html__('Background Image', 'bighearts'),
                'type' => 'background',
                'required' => [
                    ['footer_switch', '=', '1'],
                    ['footer_content_type', '=', 'widgets'],
                ],
                'preview' => false,
                'preview_media' => true,
                'background-color' => false,
                'default' => [
                    'background-repeat' => 'repeat',
                    'background-size' => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position' => 'center center',
                ],
            ],
            [
                'id' => 'footer_align',
                'title' => esc_html__('Content Align', 'bighearts'),
                'type' => 'button_set',
                'required' => [
                    ['footer_switch', '=', '1'],
                    ['footer_content_type', '=', 'widgets'],
                ],
                'options' => [
                    'left' => esc_html__('Left', 'bighearts'),
                    'center' => esc_html__('Center', 'bighearts'),
                    'right' => esc_html__('Right', 'bighearts'),
                ],
                'default' => 'center',
            ],
            [
                'id' => 'footer_bg_color',
                'title' => esc_html__('Background Color', 'bighearts'),
                'type' => 'color',
                'required' => [
                    ['footer_switch', '=', '1'],
                    ['footer_content_type', '=', 'widgets'],
                ],
                'transparent' => false,
                'default' => '#1f242c',
            ],
            [
                'id' => 'footer_heading_color',
                'title' => esc_html__('Headings color', 'bighearts'),
                'type' => 'color',
                'required' => [
                    ['footer_switch', '=', '1'],
                    ['footer_content_type', '=', 'widgets'],
                ],
                'transparent' => false,
                'default' => '#ffffff',
            ],
            [
                'id' => 'footer_text_color',
                'title' => esc_html__('Content color', 'bighearts'),
                'type' => 'color',
                'required' => [
                    ['footer_switch', '=', '1'],
                    ['footer_content_type', '=', 'widgets'],
                ],
                'transparent' => false,
                'default' => '#ffffff',
            ],
            [
                'id' => 'footer_add_border',
                'title' => esc_html__('Add Border Top', 'bighearts'),
                'type' => 'switch',
                'required' => [
                    ['footer_switch', '=', '1'],
                    ['footer_content_type', '=', 'widgets'],
                ],
                'default' => false,
            ],
            [
                'id' => 'footer_border_color',
                'title' => esc_html__('Border color', 'bighearts'),
                'type' => 'color',
                'required' => ['footer_add_border', '=', '1'],
                'transparent' => false,
                'default' => '#e5e5e5',
            ],
            [
                'id' => 'footer-end-styles',
                'type' => 'section',
                'indent' => false,
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'footer-copyright',
        'title' => esc_html__('Copyright', 'bighearts'),
        'subsection' => true,
        'fields' => [
            [
                'id' => 'copyright_switch',
                'type' => 'switch',
                'title' => esc_html__('Copyright', 'bighearts'),
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Disable', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'copyright-start',
                'type' => 'section',
                'title' => esc_html__('Copyright Settings', 'bighearts'),
                'indent' => true,
                'required' => ['copyright_switch', '=', '1'],
            ],
            [
                'id' => 'copyright_editor',
                'title' => esc_html__('Editor', 'bighearts'),
                'type' => 'editor',
                'required' => ['copyright_switch', '=', '1'],
                'args' => [
                    'wpautop' => false,
                    'media_buttons' => false,
                    'textarea_rows' => 2,
                    'teeny' => false,
                    'quicktags' => true,
                ],
                'default' => '<p>Copyright © 2020 BigHearts by <a href="https://themeforest.net/user/webgeniuslab" rel="noopener noreferrer" target="_blank">WebGeniusLab</a>. All Rights Reserved</p>',
            ],
            [
                'id' => 'copyright_text_color',
                'title' => esc_html__('Text Color', 'bighearts'),
                'type' => 'color',
                'required' => ['copyright_switch', '=', '1'],
                'transparent' => false,
                'default' => '#9f9f9f',
            ],
            [
                'id' => 'copyright_bg_color',
                'title' => esc_html__('Background Color', 'bighearts'),
                'type' => 'color',
                'required' => ['copyright_switch', '=', '1'],
                'transparent' => false,
                'default' => '#1f242c',
            ],
            [
                'id' => 'copyright_spacing',
                'type' => 'spacing',
                'title' => esc_html__('Paddings', 'bighearts'),
                'required' => ['copyright_switch', '=', '1'],
                'mode' => 'padding',
                'left' => false,
                'right' => false,
                'all' => false,
                'default' => [
                    'padding-top' => '20',
                    'padding-bottom' => '20',
                ],
            ],
            [
                'id' => 'copyright-end',
                'type' => 'section',
                'indent' => false,
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'blog-option',
        'title' => esc_html__('Blog', 'bighearts'),
        'icon' => 'el el-bullhorn',
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'blog-list-option',
        'title' => esc_html__('Archive', 'bighearts'),
        'subsection' => true,
        'fields' => [
            [
                'id' => 'blog_list_page_title-start',
                'title' => esc_html__('Page Title', 'bighearts'),
                'type' => 'section',
                'required' => ['page_title_switch', '=', '1'],
                'indent' => true,
            ],
            [
                'id' => 'post_archive__page_title_bg_image',
                'title' => esc_html__('Background Image', 'bighearts'),
                'type' => 'background',
                'background-color' => false,
                'preview_media' => true,
                'preview' => false,
                'default' => [
                    'background-repeat' => 'repeat',
                    'background-size' => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position' => 'center center',
                ],
            ],
            [
                'id' => 'blog_list_page_title-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'blog_list_sidebar-start',
                'title' => esc_html__('Sidebar', 'bighearts'),
                'type' => 'section',
                'indent' => true,
            ],
            [
                'id' => 'blog_list_sidebar_layout',
                'title' => esc_html__('Sidebar Layout', 'bighearts'),
                'type' => 'image_select',
                'options' => [
                    'none' => [
                        'alt' => esc_html__('None', 'bighearts'),
                        'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                    ],
                    'left' => [
                        'alt' => esc_html__('Left', 'bighearts'),
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                    ],
                    'right' => [
                        'alt' => esc_html__('Right', 'bighearts'),
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                    ]
                ],
                'default' => 'none'
            ],
            [
                'id' => 'blog_list_sidebar_def',
                'title' => esc_html__('Sidebar Template', 'bighearts'),
                'type' => 'select',
                'required' => ['blog_list_sidebar_layout', '!=', 'none'],
                'data' => 'sidebars',
            ],
            [
                'id' => 'blog_list_sidebar_def_width',
                'title' => esc_html__('Sidebar Width', 'bighearts'),
                'type' => 'button_set',
                'required' => ['blog_list_sidebar_layout', '!=', 'none'],
                'options' => [
                    '9' => esc_html__('25%', 'bighearts'),
                    '8' => esc_html__('33%', 'bighearts'),
                ],
                'default' => '9',
            ],
            [
                'id' => 'blog_list_sidebar_sticky',
                'title' => esc_html__('Sticky Sidebar', 'bighearts'),
                'type' => 'switch',
                'required' => ['blog_list_sidebar_layout', '!=', 'none'],
                'default' => false,
            ],
            [
                'id' => 'blog_list_sidebar_gap',
                'title' => esc_html__('Sidebar Side Gap', 'bighearts'),
                'type' => 'select',
                'required' => ['blog_list_sidebar_layout', '!=', 'none'],
                'options' => [
                    'def' => esc_html__('Default', 'bighearts'),
                    '0' => esc_html__('0', 'bighearts'),
                    '15' => esc_html__('15', 'bighearts'),
                    '20' => esc_html__('20', 'bighearts'),
                    '25' => esc_html__('25', 'bighearts'),
                    '30' => esc_html__('30', 'bighearts'),
                    '35' => esc_html__('35', 'bighearts'),
                    '40' => esc_html__('40', 'bighearts'),
                    '45' => esc_html__('45', 'bighearts'),
                    '50' => esc_html__('50', 'bighearts'),
                ],
                'default' => 'def',
            ],
            [
                'id' => 'blog_list_sidebar-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'blog_list_appearance-start',
                'title' => esc_html__('Appearance', 'bighearts'),
                'type' => 'section',
                'indent' => true,
            ],
            [
                'id' => 'blog_list_columns',
                'title' => esc_html__('Columns in Archive', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    '12' => esc_html__('One', 'bighearts'),
                    '6' => esc_html__('Two', 'bighearts'),
                    '4' => esc_html__('Three', 'bighearts'),
                    '3' => esc_html__('Four', 'bighearts'),
                ],
                'default' => '12',
            ],
            [
                'id' => 'blog_list_likes',
                'title' => esc_html__('Likes', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'blog_list_views',
                'title' => esc_html__('Views', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'blog_list_share',
                'title' => esc_html__('Shares', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'blog_list_hide_media',
                'title' => esc_html__('Hide Media?', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'blog_list_hide_title',
                'title' => esc_html__('Hide Title?', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'blog_list_hide_content',
                'title' => esc_html__('Hide Content?', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'blog_post_listing_content',
                'title' => esc_html__('Limit the characters amount in Content?', 'bighearts'),
                'type' => 'switch',
                'required' => ['blog_list_hide_content', '=', false],
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'blog_list_letter_count',
                'title' => esc_html__('Characters amount to be displayed in Content', 'bighearts'),
                'type' => 'text',
                'required' => ['blog_post_listing_content', '=', true],
                'default' => '85',
            ],
            [
                'id' => 'blog_list_read_more',
                'title' => esc_html__('Hide Read More Button?', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'blog_list_meta',
                'title' => esc_html__('Hide all post-meta?', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'blog_list_meta_author',
                'title' => esc_html__('Hide post-meta author?', 'bighearts'),
                'type' => 'switch',
                'required' => ['blog_list_meta', '=', false],
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'blog_list_meta_comments',
                'title' => esc_html__('Hide post-meta comments?', 'bighearts'),
                'type' => 'switch',
                'required' => ['blog_list_meta', '=', false],
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'blog_list_meta_categories',
                'title' => esc_html__('Hide post-meta categories?', 'bighearts'),
                'type' => 'switch',
                'required' => ['blog_list_meta', '=', false],
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'blog_list_meta_date',
                'title' => esc_html__('Hide post-meta date?', 'bighearts'),
                'type' => 'switch',
                'required' => ['blog_list_meta', '=', false],
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'blog_list_appearance-end',
                'type' => 'section',
                'indent' => false,
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'blog-single-option',
        'title' => esc_html__('Single', 'bighearts'),
        'subsection' => true,
        'fields' => [
            [
                'id' => 'single_type_layout',
                'title' => esc_html__('Default Post Layout', 'bighearts'),
                'type' => 'button_set',
                'desc' => esc_html__('Note: each Post can be separately customized within its Metaboxes section.', 'bighearts'),
                'options' => [
                    '1' => esc_html__('Title First', 'bighearts'),
                    '2' => esc_html__('Image First', 'bighearts'),
                    '3' => esc_html__('Overlay Image', 'bighearts')
                ],
                'default' => '3',
            ],
            [
                'id' => 'blog_single_page_title-start',
                'title' => esc_html__('Page Title', 'bighearts'),
                'type' => 'section',
                'required' => ['page_title_switch', '=', '1'],
                'indent' => true,
            ],
            [
                'id' => 'blog_title_conditional',
                'title' => esc_html__('Page Title Text', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Post Type Name', 'bighearts'),
                'off' => esc_html__('Post Title', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'blog_single_page_title_breadcrumbs_switch',
                'title' => esc_html__('Breadcrumbs', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'post_single__page_title_bg_switch',
                'title' => esc_html__('Use Background Image/Color?', 'bighearts'),
                'type' => 'switch',
                'desc' => bighearts_quick_tip(
                    esc_html__('\'Overlay Image\' posts have to be customized individually via metaboxes.', 'bighearts')
                ),
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'post_single__page_title_bg_image',
                'title' => esc_html__('Background Image/Color', 'bighearts'),
                'type' => 'background',
                'required' => ['post_single__page_title_bg_switch', '=', true],
                'desc' => bighearts_quick_tip(
                    esc_html__('\'Overlay Image\' posts have to be customized individually via metaboxes.', 'bighearts')
                ),
                'preview' => false,
                'preview_media' => true,
                'background-color' => true,
                'transparent' => false,
                'default' => [
                    'background-repeat' => 'repeat',
                    'background-size' => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position' => 'center center',
                    'background-color' => '#001322',
                ],
            ],
            [
                'id' => 'single_padding_layout_3',
                'type' => 'spacing',
                'title' => esc_html__('Padding Top/Bottom', 'bighearts'),
                'required' => ['single_type_layout', '=', '3'],
                'mode' => 'padding',
                'all' => false,
                'top' => true,
                'right' => false,
                'bottom' => true,
                'left' => false,
                'default' => [
                    'padding-top' => '298',
                    'padding-bottom' => '67',
                ],
            ],
            [
                'id' => 'blog_single_page_title-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'blog_single_sidebar-start',
                'type' => 'section',
                'title' => esc_html__('Sidebar', 'bighearts'),
                'indent' => true,
            ],
            [
                'id' => 'single_sidebar_layout',
                'title' => esc_html__('Sidebar Layout', 'bighearts'),
                'type' => 'image_select',
                'options' => [
                    'none' => [
                        'alt' => esc_html__('None', 'bighearts'),
                        'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                    ],
                    'left' => [
                        'alt' => esc_html__('Left', 'bighearts'),
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                    ],
                    'right' => [
                        'alt' => esc_html__('Right', 'bighearts'),
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                    ]
                ],
                'default' => 'right'
            ],
            [
                'id' => 'single_sidebar_def',
                'title' => esc_html__('Sidebar Template', 'bighearts'),
                'type' => 'select',
                'required' => ['single_sidebar_layout', '!=', 'none'],
                'data' => 'sidebars',
                'default' => 'sidebar_main-sidebar',
            ],
            [
                'id' => 'single_sidebar_def_width',
                'title' => esc_html__('Sidebar Width', 'bighearts'),
                'type' => 'button_set',
                'required' => ['single_sidebar_layout', '!=', 'none'],
                'options' => [
                    '9' => esc_html__('25%', 'bighearts'),
                    '8' => esc_html__('33%', 'bighearts'),
                ],
                'default' => '9',
            ],
            [
                'id' => 'single_sidebar_sticky',
                'title' => esc_html__('Sticky Sidebar', 'bighearts'),
                'type' => 'switch',
                'required' => ['single_sidebar_layout', '!=', 'none'],
                'default' => true,
            ],
            [
                'id' => 'single_sidebar_gap',
                'title' => esc_html__('Sidebar Side Gap', 'bighearts'),
                'type' => 'select',
                'required' => ['single_sidebar_layout', '!=', 'none'],
                'options' => [
                    'def' => esc_html__('Default', 'bighearts'),
                    '0' => esc_html__('0', 'bighearts'),
                    '15' => esc_html__('15', 'bighearts'),
                    '20' => esc_html__('20', 'bighearts'),
                    '25' => esc_html__('25', 'bighearts'),
                    '30' => esc_html__('30', 'bighearts'),
                    '35' => esc_html__('35', 'bighearts'),
                    '40' => esc_html__('40', 'bighearts'),
                    '45' => esc_html__('45', 'bighearts'),
                    '50' => esc_html__('50', 'bighearts'),
                ],
                'default' => 'def',
            ],
            [
                'id' => 'blog_single_sidebar-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'blog_single_appearance-start',
                'title' => esc_html__('Appearance', 'bighearts'),
                'type' => 'section',
                'indent' => true,
            ],
            [
                'id' => 'featured_image_type',
                'title' => esc_html__('Featured Image', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'default' => esc_html__('Default', 'bighearts'),
                    'off' => esc_html__('Off', 'bighearts'),
                ],
                'default' => 'default',
            ],
            [
                'id' => 'single_apply_animation',
                'title' => esc_html__('Apply Animation?', 'bighearts'),
                'type' => 'switch',
                'required' => ['single_type_layout', '=', '3'],
                'desc' => bighearts_quick_tip(
                    wp_kses(
                        __('Fade out the Post Title during page scrolling. <br>Note: affects only <code>Overlay Image</code> post layouts', 'bighearts'),
                        ['br' => [], 'code' => []]
                    )
                ),
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'single_likes',
                'title' => esc_html__('Likes', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'single_views',
                'title' => esc_html__('Views', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'single_share',
                'title' => esc_html__('Shares', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'single_meta_tags',
                'title' => esc_html__('Tags', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'single_author_info',
                'title' => esc_html__('Author Info', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'single_meta',
                'title' => esc_html__('Hide all post-meta?', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'single_meta_author',
                'title' => esc_html__('Hide post-meta author?', 'bighearts'),
                'type' => 'switch',
                'required' => ['single_meta', '=', false],
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'single_meta_comments',
                'title' => esc_html__('Hide post-meta comments?', 'bighearts'),
                'type' => 'switch',
                'required' => ['single_meta', '=', false],
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'single_meta_categories',
                'title' => esc_html__('Hide post-meta categories?', 'bighearts'),
                'type' => 'switch',
                'required' => ['single_meta', '=', false],
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'single_meta_date',
                'title' => esc_html__('Hide post-meta date?', 'bighearts'),
                'type' => 'switch',
                'required' => ['single_meta', '=', false],
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'blog_single_appearance-end',
                'type' => 'section',
                'indent' => false,
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'blog-single-related-option',
        'title' => esc_html__('Related', 'bighearts'),
        'subsection' => true,
        'fields' => [
            [
                'id' => 'single_related_posts',
                'title' => esc_html__('Related Posts', 'bighearts'),
                'type' => 'switch',
                'default' => true,
            ],
            [
                'id' => 'blog_title_r',
                'title' => esc_html__('Related Section Title', 'bighearts'),
                'type' => 'text',
                'required' => ['single_related_posts', '=', '1'],
                'default' => esc_html__('Related Posts', 'bighearts'),
            ],
            [
                'id' => 'blog_cat_r',
                'title' => esc_html__('Select Categories', 'bighearts'),
                'type' => 'select',
                'required' => ['single_related_posts', '=', '1'],
                'multi' => true,
                'data' => 'categories',
                'width' => '20%',
            ],
            [
                'id' => 'blog_column_r',
                'title' => esc_html__('Columns', 'bighearts'),
                'type' => 'button_set',
                'required' => ['single_related_posts', '=', '1'],
                'options' => [
                    '12' => '1',
                    '6' => '2',
                    '4' => '3',
                    '3' => '4'
                ],
                'default' => '6',
            ],
            [
                'id' => 'blog_number_r',
                'title' => esc_html__('Number of Related Items', 'bighearts'),
                'type' => 'text',
                'required' => ['single_related_posts', '=', '1'],
                'default' => '2',
            ],
            [
                'id' => 'blog_carousel_r',
                'title' => esc_html__('Display items in the carousel', 'bighearts'),
                'type' => 'switch',
                'required' => ['single_related_posts', '=', '1'],
                'default' => true,
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'portfolio-option',
        'title' => esc_html__('Portfolio', 'bighearts'),
        'icon' => 'el el-picture',
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'portfolio-list-option',
        'title' => esc_html__('Archive', 'bighearts'),
        'subsection' => true,
        'fields' => [
            [
                'id' => 'portfolio_slug',
                'title' => esc_html__('Portfolio Slug', 'bighearts'),
                'type' => 'text',
                'default' => 'portfolio',
            ],
            [
                'id' => 'portfolio_archive_page_title-start',
                'title' => esc_html__('Page Title', 'bighearts'),
                'type' => 'section',
                'required' => ['page_title_switch', '=', '1'],
                'indent' => true,
            ],
            [
                'id' => 'portfolio_archive__page_title_bg_image',
                'title' => esc_html__('Page Title Background Image', 'bighearts'),
                'type' => 'background',
                'preview' => false,
                'preview_media' => true,
                'background-color' => false,
                'default' => [
                    'background-repeat' => 'repeat',
                    'background-size' => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position' => 'center center',
                    'background-color' => '',
                ],
            ],
            [
                'id' => 'portfolio_archive_page_title-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'portfolio_archive_sidebar-start',
                'title' => esc_html__('Sidebar', 'bighearts'),
                'type' => 'section',
                'indent' => true,
            ],
            [
                'id' => 'portfolio_list_sidebar_layout',
                'title' => esc_html__('Sidebar Layout', 'bighearts'),
                'type' => 'image_select',
                'options' => [
                    'none' => [
                        'alt' => esc_html__('None', 'bighearts'),
                        'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                    ],
                    'left' => [
                        'alt' => esc_html__('Left', 'bighearts'),
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                    ],
                    'right' => [
                        'alt' => esc_html__('Right', 'bighearts'),
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                    ]
                ],
                'default' => 'none'
            ],
            [
                'id' => 'portfolio_list_sidebar_def',
                'title' => esc_html__('Sidebar Template', 'bighearts'),
                'type' => 'select',
                'required' => ['portfolio_list_sidebar_layout', '!=', 'none'],
                'data' => 'sidebars',
            ],
            [
                'id' => 'portfolio_list_sidebar_def_width',
                'title' => esc_html__('Sidebar Width', 'bighearts'),
                'type' => 'button_set',
                'required' => ['portfolio_list_sidebar_layout', '!=', 'none'],
                'options' => [
                    '9' => esc_html__('25%', 'bighearts'),
                    '8' => esc_html__('33%', 'bighearts'),
                ],
                'default' => '9',
            ],
            [
                'id' => 'portfolio_archive_sidebar-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'portfolio_list_appearance-start',
                'title' => esc_html__('Appearance', 'bighearts'),
                'type' => 'section',
                'indent' => true,
            ],
            [
                'id' => 'portfolio_list_columns',
                'title' => esc_html__('Columns in Archive', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    '1' => esc_html__('One', 'bighearts'),
                    '2' => esc_html__('Two', 'bighearts'),
                    '3' => esc_html__('Three', 'bighearts'),
                    '4' => esc_html__('Four', 'bighearts'),
                ],
                'default' => '3',
            ],
            [
                'id' => 'portfolio_list_show_filter',
                'title' => esc_html__('Filter', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'portfolio_list_filter_cats',
                'title' => esc_html__('Select Categories', 'bighearts'),
                'type' => 'select',
                'multi' => true,
                'data' => 'terms',
                'args' => ['taxonomies' => 'portfolio-category'],
                'required' => ['portfolio_list_show_filter', '=', '1'],
            ],
            [
                'id' => 'portfolio_list_show_title',
                'title' => esc_html__('Title', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'portfolio_list_show_content',
                'title' => esc_html__('Content', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'portfolio_list_show_cat',
                'title' => esc_html__('Categories', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'portfolio_list_appearance-end',
                'type' => 'section',
                'indent' => false,
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'portfolio-single-option',
        'title' => esc_html__('Single', 'bighearts'),
        'subsection' => true,
        'fields' => [
            [
                'id' => 'portfolio_single_layout-start',
                'title' => esc_html__('Layout', 'bighearts'),
                'type' => 'section',
                'indent' => true,
            ],
            [
                'id' => 'portfolio_single_type_layout',
                'title' => esc_html__('Portfolio Single Layout', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    '1' => esc_html__('Title First', 'bighearts'),
                    '2' => esc_html__('Image First', 'bighearts'),
                ],
                'default' => '2',
            ],
            [
                'id' => 'portfolio_single_layout-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'portfolio_single_page_title-start',
                'title' => esc_html__('Page Title', 'bighearts'),
                'type' => 'section',
                'required' => ['page_title_switch', '=', true],
                'indent' => true,
            ],
            [
                'id' => 'portfolio_title_conditional',
                'title' => esc_html__('Page Title Text', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Post Type Name', 'bighearts'),
                'off' => esc_html__('Post Title', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'portfolio_single_title_align',
                'title' => esc_html__('Title Alignment', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'left' => esc_html__('Left', 'bighearts'),
                    'center' => esc_html__('Center', 'bighearts'),
                    'right' => esc_html__('Right', 'bighearts'),
                ],
                'default' => 'center',
            ],
            [
                'id' => 'portfolio_single_breadcrumbs_align',
                'title' => esc_html__('Breadcrumbs Alignment', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'left' => esc_html__('Left', 'bighearts'),
                    'center' => esc_html__('Center', 'bighearts'),
                    'right' => esc_html__('Right', 'bighearts'),
                ],
                'default' => 'center',
            ],
            [
                'id' => 'portfolio_single_breadcrumbs_block_switch',
                'title' => esc_html__('Breadcrumbs Full Width', 'bighearts'),
                'type' => 'switch',
                'default' => true,
            ],
            [
                'id' => 'portfolio_single__page_title_bg_switch',
                'title' => esc_html__('Use Background Image/Color?', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'portfolio_single__page_title_bg_image',
                'title' => esc_html__('Background Image/Color', 'bighearts'),
                'type' => 'background',
                'required' => ['portfolio_single__page_title_bg_switch', '=', true],
                'preview' => false,
                'preview_media' => true,
                'background-color' => true,
                'transparent' => false,
                'default' => [
                    'background-repeat' => 'repeat',
                    'background-size' => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position' => 'center center',
                    'background-color' => '',
                ],
            ],
            [
                'id' => 'portfolio_single__page_title_height',
                'title' => esc_html__('Min Height', 'bighearts'),
                'type' => 'dimensions',
                'desc' => esc_html__('Choose `0px` in order to use `min-height: auto;`', 'bighearts'),
                'height' => true,
                'width' => false,
            ],
            [
                'id' => 'portfolio_single__page_title_padding',
                'title' => esc_html__('Paddings Top/Bottom', 'bighearts'),
                'type' => 'spacing',
                'mode' => 'padding',
                'all' => false,
                'bottom' => true,
                'top' => true,
                'left' => false,
                'right' => false,
                'default' => [
                    'padding-top' => '0',
                    'padding-bottom' => '0',
                ],
            ],
            [
                'id' => 'portfolio_single__page_title_margin',
                'title' => esc_html__('Margin Bottom', 'bighearts'),
                'type' => 'spacing',
                'mode' => 'margin',
                'all' => false,
                'bottom' => true,
                'top' => false,
                'left' => false,
                'right' => false,
                'default' => ['margin-bottom' => '40'],
            ],
            [
                'id' => 'portfolio_single_page_title-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'portfolio_single_sidebar-start',
                'title' => esc_html__('Sidebar', 'bighearts'),
                'type' => 'section',
                'indent' => true,
            ],
            [
                'id' => 'portfolio_single_sidebar_layout',
                'title' => esc_html__('Sidebar Layout', 'bighearts'),
                'type' => 'image_select',
                'options' => [
                    'none' => [
                        'alt' => esc_html__('None', 'bighearts'),
                        'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                    ],
                    'left' => [
                        'alt' => esc_html__('Left', 'bighearts'),
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                    ],
                    'right' => [
                        'alt' => esc_html__('Right', 'bighearts'),
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                    ]
                ],
                'default' => 'none'
            ],
            [
                'id' => 'portfolio_single_sidebar_def',
                'title' => esc_html__('Sidebar Template', 'bighearts'),
                'type' => 'select',
                'required' => ['portfolio_single_sidebar_layout', '!=', 'none'],
                'data' => 'sidebars',
            ],
            [
                'id' => 'portfolio_single_sidebar_def_width',
                'title' => esc_html__('Sidebar Width', 'bighearts'),
                'type' => 'button_set',
                'required' => ['portfolio_single_sidebar_layout', '!=', 'none'],
                'options' => [
                    '9' => esc_html__('25%', 'bighearts'),
                    '8' => esc_html__('33%', 'bighearts'),
                ],
                'default' => '8',
            ],
            [
                'id' => 'portfolio_single_sidebar_sticky',
                'title' => esc_html__('Sticky Sidebar', 'bighearts'),
                'type' => 'switch',
                'required' => ['portfolio_single_sidebar_layout', '!=', 'none'],
                'default' => false,
            ],
            [
                'id' => 'portfolio_single_sidebar_gap',
                'title' => esc_html__('Sidebar Side Gap', 'bighearts'),
                'type' => 'select',
                'required' => ['portfolio_single_sidebar_layout', '!=', 'none'],
                'options' => [
                    'def' => esc_html__('Default', 'bighearts'),
                    '0' => esc_html__('0', 'bighearts'),
                    '15' => esc_html__('15', 'bighearts'),
                    '20' => esc_html__('20', 'bighearts'),
                    '25' => esc_html__('25', 'bighearts'),
                    '30' => esc_html__('30', 'bighearts'),
                    '35' => esc_html__('35', 'bighearts'),
                    '40' => esc_html__('40', 'bighearts'),
                    '45' => esc_html__('45', 'bighearts'),
                    '50' => esc_html__('50', 'bighearts'),
                ],
                'default' => 'def',
            ],
            [
                'id' => 'portfolio_single_sidebar-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'portfolio_single_appearance-start',
                'title' => esc_html__('Appearance', 'bighearts'),
                'type' => 'section',
                'indent' => true,
            ],
            [
                'id' => 'portfolio_above_content_cats',
                'title' => esc_html__('Tags', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'portfolio_above_content_share',
                'title' => esc_html__('Shares', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'portfolio_single_meta_likes',
                'title' => esc_html__('Likes', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'portfolio_single_meta',
                'title' => esc_html__('Hide all post-meta?', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'portfolio_single_meta_author',
                'title' => esc_html__('Post-meta author', 'bighearts'),
                'type' => 'switch',
                'required' => ['portfolio_single_meta', '=', false],
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'portfolio_single_meta_comments',
                'title' => esc_html__('Post-meta comments', 'bighearts'),
                'type' => 'switch',
                'required' => ['portfolio_single_meta', '=', false],
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'portfolio_single_meta_categories',
                'title' => esc_html__('Post-meta categories', 'bighearts'),
                'type' => 'switch',
                'required' => ['portfolio_single_meta', '=', false],
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'portfolio_single_meta_date',
                'title' => esc_html__('Post-meta date', 'bighearts'),
                'type' => 'switch',
                'required' => ['portfolio_single_meta', '=', false],
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'portfolio_single_appearance-end',
                'type' => 'section',
                'indent' => false,
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'portfolio-related-option',
        'title' => esc_html__('Related Posts', 'bighearts'),
        'subsection' => true,
        'fields' => [
            [
                'id' => 'portfolio_related_switch',
                'title' => esc_html__('Related Posts', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'pf_title_r',
                'title' => esc_html__('Title', 'bighearts'),
                'type' => 'text',
                'required' => ['portfolio_related_switch', '=', '1'],
                'default' => esc_html__('Related Projects', 'bighearts'),
            ],
            [
                'id' => 'pf_carousel_r',
                'title' => esc_html__('Display items carousel for this portfolio post', 'bighearts'),
                'type' => 'switch',
                'required' => ['portfolio_related_switch', '=', '1'],
                'default' => true,
            ],
            [
                'id' => 'pf_column_r',
                'title' => esc_html__('Related Columns', 'bighearts'),
                'type' => 'button_set',
                'required' => ['portfolio_related_switch', '=', '1'],
                'options' => [
                    '2' => esc_html__('Two', 'bighearts'),
                    '3' => esc_html__('Three', 'bighearts'),
                    '4' => esc_html__('Four', 'bighearts'),
                ],
                'default' => '3',
            ],
            [
                'id' => 'pf_number_r',
                'title' => esc_html__('Number of Related Items', 'bighearts'),
                'type' => 'text',
                'required' => ['portfolio_related_switch', '=', '1'],
                'default' => '3',
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'portfolio-advanced',
        'title' => esc_html__('Advanced', 'bighearts'),
        'subsection' => true,
        'fields' => [
            [
                'id' => 'portfolio_archives',
                'title' => esc_html__('Portfolio Archives', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Enabled', 'bighearts'),
                'off' => esc_html__('Disabled', 'bighearts'),
                'default' => true,
                'desc' => sprintf(
                    wp_kses(
                        __('Archive pages list all the portfolio posts you have created. This option will disable only the post\'s archive page(s). The post\'s single view will still be displayed. Note: you will need to <a href="%s">refresh your permalinks</a> after this option has been enabled.', 'bighearts'),
                        [
                            'a' => ['href' => true, 'target' => true],
                        ]
                    ),
                    esc_url(admin_url('options-permalink.php'))
                ),
            ],
            [
                'id' => 'portfolio_singular',
                'title' => esc_html__('Portfolio Single', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Enabled', 'bighearts'),
                'off' => esc_html__('Disabled', 'bighearts'),
                'default' => true,
                'desc' => esc_html__('By default, all portfolio posts have single views enabled. This creates a specific URL on your website for that post. Selecting "Disabled" will prevent the single view post being publicly displayed.', 'bighearts'),
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'team-option',
        'title' => esc_html__('Team', 'bighearts'),
        'icon' => 'el el-user',
        'fields' => [
            [
                'id' => 'team_slug',
                'title' => esc_html__('Team Slug', 'bighearts'),
                'type' => 'text',
                'default' => 'team',
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'team-single-option',
        'title' => esc_html__('Single', 'bighearts'),
        'subsection' => true,
        'fields' => [
            [
                'id' => 'team_single_page_title-start',
                'title' => esc_html__('Page Title', 'bighearts'),
                'type' => 'section',
                'required' => ['page_title_switch', '=', true],
                'indent' => true,
            ],
            [
                'id' => 'team_title_conditional',
                'title' => esc_html__('Page Title Text', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Post Type Name', 'bighearts'),
                'off' => esc_html__('Post Title', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'team_single__page_title_bg_switch',
                'title' => esc_html__('Use Background Image/Color?', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'team_single__page_title_bg_image',
                'title' => esc_html__('Background Image/Color', 'bighearts'),
                'type' => 'background',
                'required' => ['team_single__page_title_bg_switch', '=', true],
                'preview' => false,
                'preview_media' => true,
                'background-color' => true,
                'transparent' => false,
                'default' => [
                    'background-repeat' => 'repeat',
                    'background-size' => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position' => 'center center',
                    'background-color' => '',
                ],
            ],
            [
                'id' => 'team_single__page_title_height',
                'title' => esc_html__('Min Height', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['page_title_bg_switch', '=', true],
                'desc' => esc_html__('Choose `0px` in order to use `min-height: auto;`', 'bighearts'),
                'height' => true,
                'width' => false,
            ],
            [
                'id' => 'team_single__page_title_padding',
                'title' => esc_html__('Paddings Top/Bottom', 'bighearts'),
                'type' => 'spacing',
                'mode' => 'padding',
                'all' => false,
                'bottom' => true,
                'top' => true,
                'left' => false,
                'right' => false,
            ],
            [
                'id' => 'team_single__page_title_margin',
                'title' => esc_html__('Margin Bottom', 'bighearts'),
                'type' => 'spacing',
                'mode' => 'margin',
                'all' => false,
                'bottom' => true,
                'top' => false,
                'left' => false,
                'right' => false,
            ],
            [
                'id' => 'team_single_page_title-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'team_single_hide_content',
                'type' => 'switch',
                'title' => esc_html__('Hide Excerpt?', 'bighearts'),
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'team_single_content',
                'type' => 'switch',
                'title' => esc_html__('Limit the characters amount in Excerpt?', 'bighearts'),
                'required' => ['team_single_hide_content', '=', false],
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'team_single_letter_count',
                'type' => 'text',
                'title' => esc_html__('Excerpt characters amount', 'bighearts'),
                'required' => ['team_single_content', '=', true],
                'default' => '85',
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'team-advanced',
        'title' => esc_html__('Advanced', 'bighearts'),
        'subsection' => true,
        'fields' => [
            [
                'id' => 'team_archives',
                'title' => esc_html__('Team Archives', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Enabled', 'bighearts'),
                'off' => esc_html__('Disabled', 'bighearts'),
                'default' => true,
                'desc' => sprintf(
                    wp_kses(
                        __('Archive pages list all the team posts you have created. This option will disable only the post\'s archive page(s). The post\'s single view will still be displayed. Note: you will need to <a href="%s">refresh your permalinks</a> after this option has been enabled.', 'bighearts'),
                        [
                            'a' => ['href' => true, 'target' => true],
                        ]
                    ),
                    esc_url(admin_url('options-permalink.php'))
                ),
            ],
            [
                'id' => 'team_singular',
                'title' => esc_html__('Team Single', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Enabled', 'bighearts'),
                'off' => esc_html__('Disabled', 'bighearts'),
                'default' => true,
                'desc' => esc_html__('By default, all team posts have single views enabled. This creates a specific URL on your website for that post. Selecting "Disabled" will prevent the single view post being publicly displayed.', 'bighearts'),
            ],
        ]
    ]
);

if (class_exists('Give')) {
    Redux::setSection(
        $theme_slug,
        [
            'id' => 'give-wp-section',
            'title' => esc_html__('Give-WP', 'bighearts'),
            'icon' => 'el el-leaf',
            'fields' => []
        ]
    );

    Redux::setSection(
        $theme_slug,
        [
            'id' => 'give-wp-single',
            'title' => esc_html__('Single', 'bighearts'),
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'give-page_title-start',
                    'title' => esc_html__('Page Title', 'bighearts'),
                    'type' => 'section',
                    'required' => ['page_title_switch', '=', true],
                    'indent' => true,
                ],
                [
                    'id' => 'give_single__page_title_bg_switch',
                    'title' => esc_html__('Use Background Image/Color?', 'bighearts'),
                    'type' => 'switch',
                    'required' => ['page_title_switch', '=', true],
                    'on' => esc_html__('Use', 'bighearts'),
                    'off' => esc_html__('Hide', 'bighearts'),
                    'default' => true,
                ],
                [
                    'id' => 'give_single__page_title_bg_image',
                    'title' => esc_html__('Background Image/Color', 'bighearts'),
                    'type' => 'background',
                    'required' => [
                        ['page_title_switch', '=', true],
                        ['give_single__page_title_bg_switch', '=', true]
                    ],
                    'preview' => false,
                    'preview_media' => true,
                    'background-color' => true,
                    'transparent' => false,
                    'default' => [
                        'background-repeat' => 'repeat',
                        'background-size' => 'cover',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center center',
                        'background-color' => '',
                    ],
                ],
                [
                    'id' => 'give_single__page_title_padding',
                    'title' => esc_html__('Paddings Top/Bottom', 'bighearts'),
                    'type' => 'spacing',
                    'required' => ['page_title_switch', '=', true],
                    'mode' => 'padding',
                    'all' => false,
                    'top' => true,
                    'bottom' => true,
                    'left' => false,
                    'right' => false,
                ],
                [
                    'id' => 'give_single__page_title_margin',
                    'title' => esc_html__('Margin Bottom', 'bighearts'),
                    'type' => 'spacing',
                    'required' => ['page_title_switch', '=', '1'],
                    'mode' => 'margin',
                    'all' => false,
                    'top' => false,
                    'bottom' => true,
                    'left' => false,
                    'right' => false,
                ],
                [
                    'id' => 'give-page_title-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'give-single-sidebar-start',
                    'title' => esc_html__('Sidebar', 'bighearts'),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'give-single_sidebar_layout',
                    'title' => esc_html__('Sidebar Layout', 'bighearts'),
                    'type' => 'image_select',
                    'options' => [
                        'none' => [
                            'alt' => esc_html__('None', 'bighearts'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                        ],
                        'left' => [
                            'alt' => esc_html__('Left', 'bighearts'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                        ],
                        'right' => [
                            'alt' => esc_html__('Right', 'bighearts'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                        ]
                    ],
                    'default' => 'none'
                ],
                [
                    'id' => 'give-single_sidebar_def',
                    'title' => esc_html__('Sidebar Template', 'bighearts'),
                    'type' => 'select',
                    'required' => ['give-single_sidebar_layout', '!=', 'none'],
                    'data' => 'sidebars',
                ],
                [
                    'id' => 'give-single_sidebar_def_width',
                    'title' => esc_html__('Sidebar Width', 'bighearts'),
                    'type' => 'button_set',
                    'required' => ['give-single_sidebar_layout', '!=', 'none'],
                    'options' => [
                        '9' => esc_html__('25%', 'bighearts'),
                        '8' => esc_html__('33%', 'bighearts'),
                    ],
                    'default' => '9',
                ],
                [
                    'id' => 'give-single_sidebar_sticky',
                    'title' => esc_html__('Sticky Sidebar', 'bighearts'),
                    'type' => 'switch',
                    'required' => ['give-single_sidebar_layout', '!=', 'none'],
                    'default' => false,
                ],
                [
                    'id' => 'give-single_sidebar_gap',
                    'title' => esc_html__('Sidebar Side Gap', 'bighearts'),
                    'type' => 'select',
                    'required' => ['give-single_sidebar_layout', '!=', 'none'],
                    'options' => [
                        'def' => esc_html__('Default', 'bighearts'),
                        '0' => esc_html__('0', 'bighearts'),
                        '15' => esc_html__('15', 'bighearts'),
                        '20' => esc_html__('20', 'bighearts'),
                        '25' => esc_html__('25', 'bighearts'),
                        '30' => esc_html__('30', 'bighearts'),
                        '35' => esc_html__('35', 'bighearts'),
                        '40' => esc_html__('40', 'bighearts'),
                        '45' => esc_html__('45', 'bighearts'),
                        '50' => esc_html__('50', 'bighearts'),
                    ],
                    'default' => 'def',
                ],
                [
                    'id' => 'give-single-sidebar-end',
                    'type' => 'section',
                    'indent' => false,
                ],
            ]
        ]
    );

    $give_archive_hide_categories = '';
    $enabled_categories = give_is_setting_enabled(give_get_option('categories', 'disabled'));
    if ($enabled_categories) {
        $give_archive_hide_categories = [
            'id' => 'give-archive_hide-categories',
            'type' => 'switch',
            'title' => esc_html__('Hide Categories', 'bighearts'),
            'on' => esc_html__('Yes', 'bighearts'),
            'off' => esc_html__('No', 'bighearts'),
            'default' => false,
        ];
    }

    Redux::setSection(
        $theme_slug,
        [
            'id' => 'give-wp-archive',
            'title' => esc_html__('Archive', 'bighearts'),
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'give-archive-page_title-start',
                    'title' => esc_html__('Page Title', 'bighearts'),
                    'type' => 'section',
                    'required' => ['page_title_switch', '=', '1'],
                    'indent' => true,
                ],
                [
                    'id' => 'give_archive__page_title_bg_switch',
                    'type' => 'switch',
                    'title' => esc_html__('Use Background Image/Color?', 'bighearts'),
                    'on' => esc_html__('Use', 'bighearts'),
                    'off' => esc_html__('Hide', 'bighearts'),
                    'default' => true,
                ],
                [
                    'id' => 'give_archive__page_title_bg_image',
                    'title' => esc_html__('Background Image', 'bighearts'),
                    'type' => 'background',
                    'preview' => false,
                    'preview_media' => true,
                    'background-color' => false,
                    'default' => [
                        'background-repeat' => 'repeat',
                        'background-size' => 'cover',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center center',
                        'background-color' => '',
                    ],
                ],
                [
                    'id' => 'give-archive-page_title-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'give-archive-sidebar-start',
                    'title' => esc_html__('Sidebar', 'bighearts'),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'give-archive_sidebar_layout',
                    'title' => esc_html__('Sidebar Layout', 'bighearts'),
                    'type' => 'image_select',
                    'options' => [
                        'none' => [
                            'alt' => esc_html__('None', 'bighearts'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                        ],
                        'left' => [
                            'alt' => esc_html__('Left', 'bighearts'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                        ],
                        'right' => [
                            'alt' => esc_html__('Right', 'bighearts'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                        ]
                    ],
                    'default' => 'none'
                ],
                [
                    'id' => 'give-archive_sidebar_def',
                    'title' => esc_html__('Sidebar Template', 'bighearts'),
                    'type' => 'select',
                    'required' => ['give-archive_sidebar_layout', '!=', 'none'],
                    'data' => 'sidebars',
                ],
                [
                    'id' => 'give-archive_sidebar_def_width',
                    'title' => esc_html__('Sidebar Width', 'bighearts'),
                    'type' => 'button_set',
                    'required' => ['give-archive_sidebar_layout', '!=', 'none'],
                    'options' => [
                        '9' => esc_html__('25%', 'bighearts'),
                        '8' => esc_html__('33%', 'bighearts'),
                    ],
                    'default' => '9',
                ],
                [
                    'id' => 'give-archive_sidebar_sticky',
                    'title' => esc_html__('Sticky Sidebar', 'bighearts'),
                    'type' => 'switch',
                    'required' => ['give-archive_sidebar_layout', '!=', 'none'],
                    'default' => false,
                ],
                [
                    'id' => 'give-archive_sidebar_gap',
                    'title' => esc_html__('Sidebar Side Gap', 'bighearts'),
                    'type' => 'select',
                    'required' => ['give-archive_sidebar_layout', '!=', 'none'],
                    'options' => [
                        'def' => esc_html__('Default', 'bighearts'),
                        '0' => esc_html__('0', 'bighearts'),
                        '15' => esc_html__('15', 'bighearts'),
                        '20' => esc_html__('20', 'bighearts'),
                        '25' => esc_html__('25', 'bighearts'),
                        '30' => esc_html__('30', 'bighearts'),
                        '35' => esc_html__('35', 'bighearts'),
                        '40' => esc_html__('40', 'bighearts'),
                        '45' => esc_html__('45', 'bighearts'),
                        '50' => esc_html__('50', 'bighearts'),
                    ],
                    'default' => 'def',
                ],
                [
                    'id' => 'give-archive-sidebar-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'give-archive_appearance-start',
                    'type' => 'section',
                    'title' => esc_html__('Appearance', 'bighearts'),
                    'indent' => true,
                ],
                [
                    'id' => 'give-archive_columns',
                    'type' => 'button_set',
                    'title' => esc_html__('Grid Columns', 'bighearts'),
                    'options' => [
                        '1' => esc_html__('One', 'bighearts'),
                        '2' => esc_html__('Two', 'bighearts'),
                        '3' => esc_html__('Three', 'bighearts'),
                        '4' => esc_html__('Four', 'bighearts'),
                    ],
                    'default' => '3'
                ],
                [
                    'id' => 'give-archive_hide-media',
                    'type' => 'switch',
                    'title' => esc_html__('Hide Media', 'bighearts'),
                    'on' => esc_html__('Yes', 'bighearts'),
                    'off' => esc_html__('No', 'bighearts'),
                    'default' => false,
                ],
                $give_archive_hide_categories,
                [
                    'id' => 'give-archive_hide-title',
                    'type' => 'switch',
                    'title' => esc_html__('Hide Title', 'bighearts'),
                    'on' => esc_html__('Yes', 'bighearts'),
                    'off' => esc_html__('No', 'bighearts'),
                    'default' => false,
                ],
                [
                    'id' => 'give-archive_hide-content',
                    'type' => 'switch',
                    'title' => esc_html__('Hide Excerpt | Content', 'bighearts'),
                    'on' => esc_html__('Yes', 'bighearts'),
                    'off' => esc_html__('No', 'bighearts'),
                    'default' => false,
                ],
                [
                    'id' => 'give-archive_content-limit',
                    'type' => 'switch',
                    'title' => esc_html__('Limit the characters amount in Excerpt?', 'bighearts'),
                    'required' => ['give-archive_hide-content', '=', false],
                    'on' => esc_html__('Yes', 'bighearts'),
                    'off' => esc_html__('No', 'bighearts'),
                    'default' => true,
                ],
                [
                    'id' => 'give-archive_content_count',
                    'type' => 'text',
                    'title' => esc_html__('Excerpt characters amount', 'bighearts'),
                    'required' => [
                        ['give-archive_hide-content', '=', false],
                        ['give-archive_content-limit', '=', true],
                    ],
                    'default' => '85',
                ],
                [
                    'id' => 'give-archive_hide-goal-bar',
                    'type' => 'switch',
                    'title' => esc_html__('Hide Goal Bar', 'bighearts'),
                    'on' => esc_html__('Yes', 'bighearts'),
                    'off' => esc_html__('No', 'bighearts'),
                    'default' => false,
                ],
                [
                    'id' => 'give-archive_hide-goal-stats',
                    'type' => 'switch',
                    'title' => esc_html__('Hide Goal Stats', 'bighearts'),
                    'on' => esc_html__('Yes', 'bighearts'),
                    'off' => esc_html__('No', 'bighearts'),
                    'default' => false,
                ],
                [
                    'id' => 'give-archive_appearance-end',
                    'type' => 'section',
                    'indent' => false,
                ],
            ]
        ]
    );
}

Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Page 404', 'bighearts'),
        'id' => '404-option',
        'icon' => 'el el-error',
        'fields' => [
            [
                'id' => '404_page_type',
                'title' => esc_html__('Layout Building Tool', 'bighearts'),
                'type' => 'select',
                'desc' => esc_html__('Custom Template allows create templates within Elementor environment.', 'bighearts'),
                'options' => [
                    'default' => esc_html__('Default', 'bighearts'),
                    'custom' => esc_html__('Custom Template', 'bighearts'),
                ],
                'default' => 'default',
            ],
            [
                'id' => '404_template_select',
                'type' => 'select',
                'title' => esc_html__('404 Template', 'bighearts'),
                'required' => ['404_page_type', '=', 'custom'],
                'data' => 'posts',
                'desc' => sprintf(
                    '%s <a href="%s" target="_blank">%s</a> %s',
                    esc_html__('Selected Template will be used for 404 page by default. You can edit/create Template in the', 'bighearts'),
                    admin_url('edit.php?post_type=elementor_library&tabs_group=library'),
                    esc_html__('Saved Templates', 'bighearts'),
                    esc_html__('dashboard tab.', 'bighearts')
                ),
                'args' => [
                    'post_type' => 'elementor_library',
                    'posts_per_page' => -1,
                    'orderby' => 'title',
                    'order' => 'ASC',
                ],
            ],
            [
                'id' => '404_show_header',
                'type' => 'switch',
                'title' => esc_html__('Header Section', 'bighearts'),
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => '404_page_title_switcher',
                'title' => esc_html__('Page Title Section', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => '404_page_title-start',
                'type' => 'section',
                'required' => ['404_page_title_switcher', '=', true],
                'indent' => true,
            ],
            [
                'id' => '404_custom_title_switch',
                'title' => esc_html__('Page Title Text', 'bighearts'),
                'type' => 'switch',
                'required' => ['404_page_title_switcher', '=', true],
                'on' => esc_html__('Custom', 'bighearts'),
                'off' => esc_html__('Default', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => '404_page_title_text',
                'title' => esc_html__('Custom Page Title Text', 'bighearts'),
                'type' => 'text',
                'required' => ['404_custom_title_switch', '=', true],
            ],
            [
                'id' => '404_page__page_title_bg_switch',
                'title' => esc_html__('Use Background Image/Color?', 'bighearts'),
                'type' => 'switch',
                'required' => ['404_page_title_switcher', '=', true],
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => '404_page__page_title_bg_image',
                'title' => esc_html__('Background Image/Color', 'bighearts'),
                'type' => 'background',
                'required' => ['404_page__page_title_bg_switch', '=', true],
                'preview' => false,
                'preview_media' => true,
                'background-color' => true,
                'transparent' => false,
                'default' => [
                    'background-repeat' => 'repeat',
                    'background-size' => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position' => 'center center',
                ],
            ],
            [
                'id' => '404_page__page_title_height',
                'title' => esc_html__('Min Height', 'bighearts'),
                'type' => 'dimensions',
                'required' => ['page_title_bg_switch', '=', true],
                'desc' => esc_html__('Choose `0px` in order to use `min-height: auto;`', 'bighearts'),
                'height' => true,
                'width' => false,
            ],
            [
                'id' => '404_page__page_title_padding',
                'title' => esc_html__('Paddings Top/Bottom', 'bighearts'),
                'type' => 'spacing',
                'mode' => 'padding',
                'all' => false,
                'top' => true,
                'bottom' => true,
                'left' => false,
                'right' => false,
            ],
            [
                'id' => '404_page__page_title_margin',
                'title' => esc_html__('Margin Bottom', 'bighearts'),
                'type' => 'spacing',
                'mode' => 'margin',
                'all' => false,
                'top' => false,
                'bottom' => true,
                'left' => false,
                'right' => false,
            ],
            [
                'id' => '404_page_title-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => '404_content-start',
                'title' => esc_html__('Content Section', 'bighearts'),
                'type' => 'section',
                'required' => ['404_page_type', '=', 'default'],
                'indent' => true,
            ],
            [
                'id' => '404_page_main_bg_image',
                'title' => esc_html__('Section Background Image/Color', 'bighearts'),
                'type' => 'background',
                'preview' => false,
                'preview_media' => true,
                'background-color' => true,
                'transparent' => false,
                'default' => [
                    'background-repeat' => 'no-repeat',
                    'background-size' => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position' => 'right top',
                    'background-color' => '#ffffff',
                ],
            ],
            [
                'id' => '404_content-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => '404_show_footer',
                'title' => esc_html__('Footer Section', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => true,
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'side_panel',
        'title' => esc_html__('Side Panel', 'bighearts'),
        'icon' => 'el el-indent-left',
        'fields' => [
            [
                'id' => 'side_panel_enable',
                'title' => esc_html__('Side Panel', 'bighearts'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Disable', 'bighearts'),
                'default' => true,
            ],
            [
                'id' => 'side_panel-start',
                'title' => esc_html__('Settings', 'bighearts'),
                'type' => 'section',
                'required' => ['side_panel_enable', '=', true],
                'indent' => true,
            ],
            [
                'id' => 'side_panel_content_type',
                'title' => esc_html__('Content Type', 'bighearts'),
                'type' => 'select',
                'options' => [
                    'widgets' => esc_html__('Get Widgets', 'bighearts'),
                    'pages' => esc_html__('Get Pages', 'bighearts'),
                ],
                'default' => 'pages',
            ],
            [
                'id' => 'side_panel_page_select',
                'title' => esc_html__('Page Select', 'bighearts'),
                'type' => 'select',
                'required' => ['side_panel_content_type', '=', 'pages'],
                'data' => 'posts',
                'args' => [
                    'post_type' => 'side_panel',
                    'posts_per_page' => -1,
                    'orderby' => 'title',
                    'order' => 'ASC',
                ],
            ],
            [
                'id' => 'side_panel_spacing',
                'title' => esc_html__('Paddings', 'bighearts'),
                'type' => 'spacing',
                'output' => ['#side-panel .side-panel_sidebar'],
                'mode' => 'padding',
                'units' => 'px',
                'all' => false,
                'default' => [
                    'padding-top' => '40px',
                    'padding-right' => '25px',
                    'padding-bottom' => '40px',
                    'padding-left' => '25px',
                ],
            ],
            [
                'id' => 'side_panel_title_color',
                'title' => esc_html__('Title Color', 'bighearts'),
                'type' => 'color',
                'required' => ['side_panel_content_type', '=', 'widgets'],
                'transparent' => false,
                'default' => '#232323',
            ],
            [
                'id' => 'side_panel_text_color',
                'title' => esc_html__('Text Color', 'bighearts'),
                'type' => 'color_rgba',
                'required' => ['side_panel_content_type', '=', 'widgets'],
                'mode' => 'background',
                'default' => [
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)',
                    'color' => '#ffffff',
                ],
            ],
            [
                'id' => 'side_panel_bg',
                'title' => esc_html__('Background', 'bighearts'),
                'type' => 'color_rgba',
                'mode' => 'background',
                'default' => [
                    'alpha' => '1',
                    'rgba' => 'rgba(34,35,37,1)',
                    'color' => '#222325',
                ],
            ],
            [
                'id' => 'side_panel_text_alignment',
                'title' => esc_html__('Text Align', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'left' => esc_html__('Left', 'bighearts'),
                    'center' => esc_html__('Center', 'bighearts'),
                    'right' => esc_html__('Right', 'bighearts'),
                ],
                'default' => 'left',
            ],
            [
                'id' => 'side_panel_width',
                'title' => esc_html__('Width', 'bighearts'),
                'type' => 'dimensions',
                'width' => true,
                'height' => false,
                'default' => ['width' => 350],
            ],
            [
                'id' => 'side_panel_position',
                'title' => esc_html__('Position', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'left' => esc_html__('Left', 'bighearts'),
                    'right' => esc_html__('Right', 'bighearts'),
                ],
                'default' => 'right'
            ],
            [
                'id' => 'side_panel-end',
                'type' => 'section',
                'indent' => false,
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'layout_options',
        'title' => esc_html__('Sidebars', 'bighearts'),
        'icon' => 'el el-braille',
        'fields' => [
            [
                'id' => 'sidebars',
                'title' => esc_html__('Register Sidebars', 'bighearts'),
                'type' => 'multi_text',
                'validate' => 'no_html',
                'add_text' => esc_html__('Add Sidebar', 'bighearts'),
                'default' => ['Main Sidebar'],
            ],
            [
                'id' => 'sidebars-start',
                'title' => esc_html__('Sidebar Settings', 'bighearts'),
                'type' => 'section',
                'indent' => true,
            ],
            [
                'id' => 'page_sidebar_layout',
                'title' => esc_html__('Page Sidebar Layout', 'bighearts'),
                'type' => 'image_select',
                'options' => [
                    'none' => [
                        'alt' => esc_html__('None', 'bighearts'),
                        'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                    ],
                    'left' => [
                        'alt' => esc_html__('Left', 'bighearts'),
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                    ],
                    'right' => [
                        'alt' => esc_html__('Right', 'bighearts'),
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                    ]
                ],
                'default' => 'none'
            ],
            [
                'id' => 'page_sidebar_def',
                'title' => esc_html__('Page Sidebar', 'bighearts'),
                'type' => 'select',
                'required' => ['page_sidebar_layout', '!=', 'none'],
                'data' => 'sidebars',
            ],
            [
                'id' => 'page_sidebar_def_width',
                'title' => esc_html__('Page Sidebar Width', 'bighearts'),
                'type' => 'button_set',
                'required' => ['page_sidebar_layout', '!=', 'none'],
                'options' => [
                    '9' => esc_html__('25%', 'bighearts'),
                    '8' => esc_html__('33%', 'bighearts'),
                ],
                'default' => '9',
            ],
            [
                'id' => 'page_sidebar_sticky',
                'title' => esc_html__('Sticky Sidebar', 'bighearts'),
                'type' => 'switch',
                'required' => ['page_sidebar_layout', '!=', 'none'],
                'default' => false,
            ],
            [
                'id' => 'page_sidebar_gap',
                'title' => esc_html__('Sidebar Side Gap', 'bighearts'),
                'type' => 'select',
                'required' => ['page_sidebar_layout', '!=', 'none'],
                'options' => [
                    'def' => esc_html__('Default', 'bighearts'),
                    '0' => esc_html__('0', 'bighearts'),
                    '15' => esc_html__('15', 'bighearts'),
                    '20' => esc_html__('20', 'bighearts'),
                    '25' => esc_html__('25', 'bighearts'),
                    '30' => esc_html__('30', 'bighearts'),
                    '35' => esc_html__('35', 'bighearts'),
                    '40' => esc_html__('40', 'bighearts'),
                    '45' => esc_html__('45', 'bighearts'),
                    '50' => esc_html__('50', 'bighearts'),
                ],
                'default' => 'def',
            ],
            [
                'id' => 'sidebars-end',
                'type' => 'section',
                'indent' => false,
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'soc_shares',
        'title' => esc_html__('Social Shares', 'bighearts'),
        'icon' => 'el el-share-alt',
        'fields' => [
            [
                'id' => 'post_shares',
                'title' => esc_html__('Share List', 'bighearts'),
                'type' => 'checkbox',
                'desc' => esc_html__('Note: used only on Blog Single, Blog List and Portfolio Single pages', 'bighearts'),
                'options' => [
                    'telegram' => esc_html__('Telegram', 'bighearts'),
                    'reddit' => esc_html__('Reddit', 'bighearts'),
                    'twitter' => esc_html__('Twitter', 'bighearts'),
                    'whatsapp' => esc_html__('WhatsApp', 'bighearts'),
                    'facebook' => esc_html__('Facebook', 'bighearts'),
                    'pinterest' => esc_html__('Pinterest', 'bighearts'),
                    'linkedin' => esc_html__('Linkedin', 'bighearts'),
                ],
                'default' => [
                    'telegram' => '0',
                    'reddit' => '0',
                    'twitter' => '1',
                    'whatsapp' => '0',
                    'facebook' => '1',
                    'pinterest' => '1',
                    'linkedin' => '1',
                ]
            ],
            [
                'id' => 'page_socials-start',
                'title' => esc_html__('Page Socials', 'bighearts'),
                'type' => 'section',
                'indent' => true,
            ],
            [
                'id' => 'show_soc_icon_page',
                'title' => esc_html__('Page Social Shares', 'bighearts'),
                'type' => 'switch',
                'desc' => esc_html__('Social buttons are to be rendered on a left side of each page.', 'bighearts'),
                'on' => esc_html__('Use', 'bighearts'),
                'off' => esc_html__('Hide', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'soc_icon_style',
                'title' => esc_html__('Socials visibility', 'bighearts'),
                'type' => 'button_set',
                'options' => [
                    'standard' => esc_html__('Always', 'bighearts'),
                    'hovered' => esc_html__('On Hover', 'bighearts'),
                ],
                'default' => 'standard',
                'required' => ['show_soc_icon_page', '=', '1'],
            ],
            [
                'id' => 'soc_icon_offset',
                'title' => esc_html__('Offset Top', 'bighearts'),
                'type' => 'spacing',
                'required' => ['show_soc_icon_page', '=', '1'],
                'desc' => esc_html__('If units defined as "%" then socials will be fixed to viewport.', 'bighearts'),
                'mode' => 'margin',
                'units' => ['px', '%'],
                'all' => false,
                'top' => true,
                'bottom' => false,
                'left' => false,
                'right' => false,
                'default' => [
                    'margin-top' => '250',
                    'units' => 'px'
                ],
            ],
            [
                'id' => 'soc_icon_facebook',
                'title' => esc_html__('Facebook Button', 'bighearts'),
                'type' => 'switch',
                'required' => ['show_soc_icon_page', '=', '1'],
                'default' => false,
            ],
            [
                'id' => 'soc_icon_twitter',
                'title' => esc_html__('Twitter Button', 'bighearts'),
                'type' => 'switch',
                'required' => ['show_soc_icon_page', '=', '1'],
                'default' => false,
            ],
            [
                'id' => 'soc_icon_linkedin',
                'title' => esc_html__('Linkedin Button', 'bighearts'),
                'type' => 'switch',
                'required' => ['show_soc_icon_page', '=', '1'],
                'default' => false,
            ],
            [
                'id' => 'soc_icon_pinterest',
                'title' => esc_html__('Pinterest Button', 'bighearts'),
                'type' => 'switch',
                'required' => ['show_soc_icon_page', '=', '1'],
                'default' => false,
            ],
            [
                'id' => 'soc_icon_tumblr',
                'title' => esc_html__('Tumblr Button', 'bighearts'),
                'type' => 'switch',
                'required' => ['show_soc_icon_page', '=', '1'],
                'default' => false,
            ],
            [
                'id' => 'add_custom_share',
                'title' => esc_html__('Need Additional Socials?', 'bighearts'),
                'type' => 'switch',
                'required' => ['show_soc_icon_page', '=', '1'],
                'on' => esc_html__('Yes', 'bighearts'),
                'off' => esc_html__('No', 'bighearts'),
                'default' => false,
            ],
            [
                'id' => 'share_name-1',
                'title' => esc_html__('Social 1 - Name', 'bighearts'),
                'type' => 'text',
                'required' => ['add_custom_share', '=', '1'],
            ],
            [
                'id' => 'share_link-1',
                'title' => esc_html__('Social 1 - Link', 'bighearts'),
                'type' => 'text',
                'required' => ['add_custom_share', '=', '1'],
            ],
            [
                'id' => 'share_icons-1',
                'title' => esc_html__('Social 1 - Icon', 'bighearts'),
                'type' => 'select',
                'required' => ['add_custom_share', '=', '1'],
                'data' => 'elusive-icons',
            ],
            [
                'id' => 'share_name-2',
                'title' => esc_html__('Social 2 - Name', 'bighearts'),
                'type' => 'text',
                'required' => ['add_custom_share', '=', '1'],
            ],
            [
                'id' => 'share_link-2',
                'title' => esc_html__('Social 2 - Link', 'bighearts'),
                'type' => 'text',
                'required' => ['add_custom_share', '=', '1'],
            ],
            [
                'id' => 'share_icons-2',
                'title' => esc_html__('Social 2 - Icon', 'bighearts'),
                'type' => 'select',
                'required' => ['add_custom_share', '=', '1'],
                'data' => 'elusive-icons',
            ],
            [
                'id' => 'share_name-3',
                'title' => esc_html__('Social 3 - Name', 'bighearts'),
                'type' => 'text',
                'required' => ['add_custom_share', '=', '1'],
            ],
            [
                'id' => 'share_link-3',
                'title' => esc_html__('Social 3 - Link', 'bighearts'),
                'type' => 'text',
                'required' => ['add_custom_share', '=', '1'],
            ],
            [
                'id' => 'share_icons-3',
                'title' => esc_html__('Social 3 - Icon', 'bighearts'),
                'type' => 'select',
                'required' => ['add_custom_share', '=', '1'],
                'data' => 'elusive-icons',
            ],
            [
                'id' => 'share_name-4',
                'type' => 'text',
                'title' => esc_html__('Social 4 - Name', 'bighearts'),
                'required' => ['add_custom_share', '=', '1'],
            ],
            [
                'id' => 'share_link-4',
                'title' => esc_html__('Social 4 - Link', 'bighearts'),
                'type' => 'text',
                'required' => ['add_custom_share', '=', '1'],
            ],
            [
                'id' => 'share_icons-4',
                'type' => 'select',
                'title' => esc_html__('Social 4 - Icon', 'bighearts'),
                'required' => ['add_custom_share', '=', '1'],
                'data' => 'elusive-icons',
            ],
            [
                'id' => 'share_name-5',
                'title' => esc_html__('Social 5 - Name', 'bighearts'),
                'type' => 'text',
                'required' => ['add_custom_share', '=', '1'],
            ],
            [
                'id' => 'share_link-5',
                'title' => esc_html__('Social 5 - Link', 'bighearts'),
                'type' => 'text',
                'required' => ['add_custom_share', '=', '1'],
            ],
            [
                'id' => 'share_icons-5',
                'title' => esc_html__('Social 5 - Icon', 'bighearts'),
                'type' => 'select',
                'required' => ['add_custom_share', '=', '1'],
                'data' => 'elusive-icons',
            ],
            [
                'id' => 'share_name-6',
                'title' => esc_html__('Social 6 - Name', 'bighearts'),
                'type' => 'text',
                'required' => ['add_custom_share', '=', '1'],
            ],
            [
                'id' => 'share_link-6',
                'title' => esc_html__('Social 6 - Link', 'bighearts'),
                'type' => 'text',
                'required' => ['add_custom_share', '=', '1'],
            ],
            [
                'id' => 'share_icons-6',
                'title' => esc_html__('Social 6 - Icon', 'bighearts'),
                'type' => 'select',
                'required' => ['add_custom_share', '=', '1'],
                'data' => 'elusive-icons',
            ],
            [
                'id' => 'page_socials-end',
                'type' => 'section',
                'indent' => false,
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'color_options_color',
        'title' => esc_html__('Color Settings', 'bighearts'),
        'icon' => 'el-icon-tint',
        'fields' => [
            [
                'id' => 'theme_colors-start',
                'title' => esc_html__('Main Colors', 'bighearts'),
                'type' => 'section',
                'indent' => true,
            ],
            [
                'id' => 'theme-primary-color',
                'title' => esc_html__('Primary Theme Color', 'bighearts'),
                'type' => 'color',
                'validate' => 'color',
                'transparent' => false,
                'default' => '#f74f22',
            ],
            [
                'id' => 'theme-secondary-color',
                'title' => esc_html__('Secondary Theme Color', 'bighearts'),
                'type' => 'color',
                'validate' => 'color',
                'transparent' => false,
                'default' => '#ffac00',
            ],
            [
                'id' => 'body-background-color',
                'title' => esc_html__('Body Background Color', 'bighearts'),
                'type' => 'color',
                'validate' => 'color',
                'transparent' => false,
                'default' => '#ffffff',
            ],
            [
                'id' => 'theme_colors-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'button_colors-start',
                'title' => esc_html__('Button Colors', 'bighearts'),
                'type' => 'section',
                'indent' => true,
            ],
            [
                'id' => 'button-color-idle',
                'title' => esc_html__('Button Color Idle', 'bighearts'),
                'type' => 'color',
                'validate' => 'color',
                'transparent' => false,
                'default' => '#f74f22',
            ],
            [
                'id' => 'button-color-hover',
                'title' => esc_html__('Button Color Hover', 'bighearts'),
                'type' => 'color',
                'validate' => 'color',
                'transparent' => false,
                'default' => '#ffac00',
            ],
            [
                'id' => 'button_colors-end',
                'type' => 'section',
                'indent' => false,
            ],
        ]
    ]
);

//* ↓ Typography Config
Redux::setSection(
    $theme_slug,
    [
        'id' => 'Typography',
        'title' => esc_html__('Typography', 'bighearts'),
        'icon' => 'el-icon-font',
    ]
);

$typography = [];
$main_typography = [
    [
        'id' => 'main-font',
        'title' => esc_html__('Content Font', 'bighearts'),
        'color' => true,
        'line-height' => true,
        'font-size' => true,
        'subsets' => false,
        'all_styles' => true,
        'font-weight-multi' => true,
        'defs' => [
            'font-size' => '16px',
            'line-height' => '30px',
            'color' => '#616161',
            'font-family' => 'Nunito Sans',
            'font-weight' => '400',
            'font-weight-multi' => '600,700',
        ],
    ],
    [
        'id' => 'header-font',
        'title' => esc_html__('Headings Font', 'bighearts'),
        'font-size' => false,
        'line-height' => false,
        'color' => true,
        'subsets' => false,
        'all_styles' => true,
        'font-weight-multi' => true,
        'defs' => [
            'google' => true,
            'color' => '#232323',
            'font-family' => 'Quicksand',
            'font-weight' => '700',
            'font-weight-multi' => '400,500,600',
        ],
    ],
    [
        'id' => 'additional-font',
        'title' => esc_html__('Additional Font', 'bighearts'),
        'font-size' => false,
        'line-height' => false,
        'color' => false,
        'subsets' => false,
        'all_styles' => true,
        'font-weight-multi' => true,
        'defs' => [
            'google' => true,
            'font-family' => 'Amatic SC',
            'font-weight' => '700',
            'font-weight-multi' => '400, 700',
        ],
    ],
];
foreach ($main_typography as $key => $value) {
    array_push($typography, [
        'id' => $value['id'],
        'type' => 'custom_typography',
        'title' => $value['title'],
        'color' => $value['color'] ?? '',
        'line-height' => $value['line-height'],
        'font-size' => $value['font-size'],
        'subsets' => $value['subsets'],
        'all_styles' => $value['all_styles'],
        'font-weight-multi' => $value['font-weight-multi'] ?? '',
        'subtitle' => $value['subtitle'] ?? '',
        'letter-spacing' => $value['letter-spacing'] ?? '',
        'google' => true,
        'font-style' => true,
        'font-backup' => false,
        'text-align' => false,
        'default' => $value['defs'],
    ]);
}

Redux::setSection(
    $theme_slug,
    [
        'id' => 'main_typography',
        'title' => esc_html__('Main Content', 'bighearts'),
        'subsection' => true,
        'fields' => $typography,
    ]
);

//* ↓ Menu Typography
$menu_typography = [
    [
        'id' => 'menu-font',
        'title' => esc_html__('Menu Font', 'bighearts'),
        'color' => false,
        'line-height' => true,
        'font-size' => true,
        'subsets' => true,
        'defs' => [
            'google' => true,
            'font-family' => 'Quicksand',
            'font-size' => '16px',
            'font-weight' => '700',
            'line-height' => '30px'
        ],
    ],
    [
        'id' => 'sub-menu-font',
        'title' => esc_html__('Submenu Font', 'bighearts'),
        'color' => false,
        'line-height' => true,
        'font-size' => true,
        'subsets' => true,
        'defs' => [
            'google' => true,
            'font-family' => 'Quicksand',
            'font-size' => '15px',
            'font-weight' => '700',
            'line-height' => '30px'
        ],
    ],
];
$menu_typography_array = [];
foreach ($menu_typography as $key => $value) {
    array_push($menu_typography_array, [
        'id' => $value['id'],
        'type' => 'custom_typography',
        'title' => $value['title'],
        'color' => $value['color'],
        'line-height' => $value['line-height'],
        'font-size' => $value['font-size'],
        'subsets' => $value['subsets'],
        'google' => true,
        'font-style' => true,
        'font-backup' => false,
        'text-align' => false,
        'all_styles' => false,
        'default' => $value['defs'],
    ]);
}

Redux::setSection(
    $theme_slug,
    [
        'id' => 'main_menu_typography',
        'title' => esc_html__('Menu', 'bighearts'),
        'subsection' => true,
        'fields' => $menu_typography_array
    ]
);
//* ↑ menu typography

//* ↓ Headings Typography
$headings = [
    [
        'id' => 'header-h1',
        'title' => esc_html__('‹h1›', 'bighearts'),
        'defs' => [
            'font-family' => 'Quicksand',
            'font-size' => '48px',
            'line-height' => '72px',
            'font-weight' => '700',
            'text-transform' => 'none',
        ],
    ],
    [
        'id' => 'header-h2',
        'title' => esc_html__('‹h2›', 'bighearts'),
        'defs' => [
            'font-family' => 'Quicksand',
            'font-size' => '42px',
            'line-height' => '60px',
            'font-weight' => '700',
            'text-transform' => 'none',
        ],
    ],
    [
        'id' => 'header-h3',
        'title' => esc_html__('‹h3›', 'bighearts'),
        'defs' => [
            'font-family' => 'Quicksand',
            'font-size' => '36px',
            'line-height' => '50px',
            'font-weight' => '700',
            'text-transform' => 'none',
        ],
    ],
    [
        'id' => 'header-h4',
        'title' => esc_html__('‹h4›', 'bighearts'),
        'defs' => [
            'font-family' => 'Quicksand',
            'font-size' => '30px',
            'line-height' => '40px',
            'font-weight' => '700',
            'text-transform' => 'none',
        ],
    ],
    [
        'id' => 'header-h5',
        'title' => esc_html__('‹h5›', 'bighearts'),
        'defs' => [
            'font-family' => 'Quicksand',
            'font-size' => '24px',
            'line-height' => '38px',
            'font-weight' => '700',
            'text-transform' => 'none',
        ],
    ],
    [
        'id' => 'header-h6',
        'title' => esc_html__('‹h6›', 'bighearts'),
        'defs' => [
            'font-family' => 'Quicksand',
            'font-size' => '18px',
            'line-height' => '30px',
            'font-weight' => '700',
            'text-transform' => 'none',
        ],
    ],
];
$headings_array = [];
foreach ($headings as $key => $heading) {
    array_push($headings_array, [
        'id' => $heading['id'],
        'type' => 'custom_typography',
        'title' => $heading['title'],
        'google' => true,
        'font-backup' => false,
        'font-size' => true,
        'line-height' => true,
        'color' => false,
        'word-spacing' => false,
        'letter-spacing' => true,
        'text-align' => false,
        'text-transform' => true,
        'default' => $heading['defs'],
    ]);
}

Redux::setSection(
    $theme_slug,
    [
        'id' => 'main_headings_typography',
        'title' => esc_html__('Headings', 'bighearts'),
        'subsection' => true,
        'fields' => $headings_array
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'id' => 'main_button_typography',
        'title' => esc_html__('Buttons', 'bighearts'),
        'subsection' => true,
        'fields' => [
            [
                'id' => 'button-font',
                'type' => 'custom_typography',
                'title' => esc_html__('Button Fonts', 'bighearts'),
                'desc' => bighearts_quick_tip(
                    wp_kses(
                        __('Affects all <code>button</code> and <code>input[type="submit"]</code> tags.', 'bighearts'),
                        ['code' => []]
                    )
                ),
                'google' => true,
                'font-backup' => false,
                'font-size' => true,
                'line-height' => true,
                'color' => false,
                'word-spacing' => false,
                'letter-spacing' => true,
                'text-align' => false,
                'text-transform' => true,
                'default' => [
                    'font-family' => 'Quicksand',
                    'font-size' => '14px',
                    'line-height' => '28px',
                    'font-weight' => '700',
                    'text-transform' => 'uppercase',
                ],
            ],
        ]
    ]
);

if (class_exists('WooCommerce')) {
    Redux::setSection(
        $theme_slug,
        [
            'id' => 'shop-option',
            'title' => esc_html__('Shop', 'bighearts'),
            'icon' => 'el-icon-shopping-cart',
            'fields' => []
        ]
    );

    Redux::setSection(
        $theme_slug,
        [
            'id' => 'shop-catalog-option',
            'title' => esc_html__('Catalog', 'bighearts'),
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'shop_catalog__page_title_bg_image',
                    'title' => esc_html__('Page Title Background Image', 'bighearts'),
                    'type' => 'background',
                    'required' => ['page_title_switch', '=', true],
                    'preview' => false,
                    'preview_media' => true,
                    'background-color' => false,
                    'default' => [
                        'background-repeat' => 'repeat',
                        'background-size' => 'cover',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center center',
                        'background-color' => '',
                    ]
                ],
                [
                    'id' => 'shop_catalog_sidebar-start',
                    'title' => esc_html__('Sidebar Settings', 'bighearts'),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'shop_catalog_sidebar_layout',
                    'title' => esc_html__('Sidebar Layout', 'bighearts'),
                    'type' => 'image_select',
                    'options' => [
                        'none' => [
                            'alt' => esc_html__('None', 'bighearts'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                        ],
                        'left' => [
                            'alt' => esc_html__('Left', 'bighearts'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                        ],
                        'right' => [
                            'alt' => esc_html__('Right', 'bighearts'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                        ],
                    ],
                    'default' => 'left',
                ],
                [
                    'id' => 'shop_catalog_sidebar_def',
                    'title' => esc_html__('Shop Catalog Sidebar', 'bighearts'),
                    'type' => 'select',
                    'required' => ['shop_catalog_sidebar_layout', '!=', 'none'],
                    'data' => 'sidebars',
                ],
                [
                    'id' => 'shop_catalog_sidebar_def_width',
                    'title' => esc_html__('Shop Sidebar Width', 'bighearts'),
                    'type' => 'button_set',
                    'required' => ['shop_catalog_sidebar_layout', '!=', 'none'],
                    'options' => [
                        '9' => esc_html__('25%', 'bighearts'),
                        '8' => esc_html__('33%', 'bighearts'),
                    ],
                    'default' => '9',
                ],
                [
                    'id' => 'shop_catalog_sidebar_sticky',
                    'title' => esc_html__('Sticky Sidebar', 'bighearts'),
                    'type' => 'switch',
                    'required' => ['shop_catalog_sidebar_layout', '!=', 'none'],
                    'default' => false,
                ],
                [
                    'id' => 'shop_catalog_sidebar_gap',
                    'title' => esc_html__('Sidebar Side Gap', 'bighearts'),
                    'type' => 'select',
                    'required' => ['shop_catalog_sidebar_layout', '!=', 'none'],
                    'options' => [
                        'def' => esc_html__('Default', 'bighearts'),
                        '0' => esc_html__('0', 'bighearts'),
                        '15' => esc_html__('15', 'bighearts'),
                        '20' => esc_html__('20', 'bighearts'),
                        '25' => esc_html__('25', 'bighearts'),
                        '30' => esc_html__('30', 'bighearts'),
                        '35' => esc_html__('35', 'bighearts'),
                        '40' => esc_html__('40', 'bighearts'),
                        '45' => esc_html__('45', 'bighearts'),
                        '50' => esc_html__('50', 'bighearts'),
                    ],
                    'default' => 'def',
                ],
                [
                    'id' => 'shop_catalog_sidebar-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'shop_column',
                    'title' => esc_html__('Shop Column', 'bighearts'),
                    'type' => 'button_set',
                    'options' => [
                        '1' => esc_html__('1', 'bighearts'),
                        '2' => esc_html__('2', 'bighearts'),
                        '3' => esc_html__('3', 'bighearts'),
                        '4' => esc_html__('4', 'bighearts'),
                    ],
                    'default' => '3',
                ],
                [
                    'id' => 'shop_products_per_page',
                    'title' => esc_html__('Products per page', 'bighearts'),
                    'type' => 'spinner',
                    'min' => '1',
                    'max' => '100',
                    'default' => '12',
                ],
                [
                    'id' => 'use_animation_shop',
                    'title' => esc_html__('Use Animation Shop?', 'bighearts'),
                    'type' => 'switch',
                    'default' => true,
                ],
                [
                    'id' => 'shop_catalog_animation_style',
                    'title' => esc_html__('Animation Style', 'bighearts'),
                    'type' => 'select',
                    'required' => ['use_animation_shop', '=', true],
                    'select2' => ['allowClear' => false],
                    'options' => [
                        'fade-in' => esc_html__('Fade In', 'bighearts'),
                        'slide-top' => esc_html__('Slide Top', 'bighearts'),
                        'slide-bottom' => esc_html__('Slide Bottom', 'bighearts'),
                        'slide-left' => esc_html__('Slide Left', 'bighearts'),
                        'slide-right' => esc_html__('Slide Right', 'bighearts'),
                        'zoom' => esc_html__('Zoom', 'bighearts'),
                    ],
                    'default' => 'slide-left',
                ],
            ]
        ]
    );

    Redux::setSection(
        $theme_slug,
        [
            'id' => 'shop-single-option',
            'title' => esc_html__('Single', 'bighearts'),
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'shop_single_page_title-start',
                    'title' => esc_html__('Page Title Settings', 'bighearts'),
                    'type' => 'section',
                    'required' => ['page_title_switch', '=', true],
                    'indent' => true,
                ],
                [
                    'id' => 'shop_title_conditional',
                    'title' => esc_html__('Page Title Text', 'bighearts'),
                    'type' => 'switch',
                    'on' => esc_html__('Post Type Name', 'bighearts'),
                    'off' => esc_html__('Post Title', 'bighearts'),
                    'default' => true,
                ],
                [
                    'id' => 'shop_single_title_align',
                    'title' => esc_html__('Title Alignment', 'bighearts'),
                    'type' => 'button_set',
                    'options' => [
                        'left' => esc_html__('Left', 'bighearts'),
                        'center' => esc_html__('Center', 'bighearts'),
                        'right' => esc_html__('Right', 'bighearts'),
                    ],
                    'default' => 'center',
                ],
                [
                    'id' => 'shop_single_breadcrumbs_block_switch',
                    'title' => esc_html__('Breadcrumbs Display', 'bighearts'),
                    'type' => 'switch',
                    'required' => ['page_title_breadcrumbs_switch', '=', true],
                    'on' => esc_html__('Block', 'bighearts'),
                    'off' => esc_html__('Inline', 'bighearts'),
                    'default' => true,
                ],
                [
                    'id' => 'shop_single_breadcrumbs_align',
                    'title' => esc_html__('Title Breadcrumbs Alignment', 'bighearts'),
                    'type' => 'button_set',
                    'required' => [
                        ['page_title_breadcrumbs_switch', '=', true],
                        ['shop_single_breadcrumbs_block_switch', '=', true]
                    ],
                    'options' => [
                        'left' => esc_html__('Left', 'bighearts'),
                        'center' => esc_html__('Center', 'bighearts'),
                        'right' => esc_html__('Right', 'bighearts'),
                    ],
                    'default' => 'center',
                ],
                [
                    'id' => 'shop_single__page_title_bg_switch',
                    'title' => esc_html__('Use Background Image/Color?', 'bighearts'),
                    'type' => 'switch',
                    'on' => esc_html__('Use', 'bighearts'),
                    'off' => esc_html__('Hide', 'bighearts'),
                    'default' => true,
                ],
                [
                    'id' => 'shop_single__page_title_bg_image',
                    'title' => esc_html__('Background Image/Color', 'bighearts'),
                    'type' => 'background',
                    'required' => ['shop_single__page_title_bg_switch', '=', true],
                    'preview' => false,
                    'preview_media' => true,
                    'background-color' => true,
                    'transparent' => false,
                    'default' => [
                        'background-repeat' => 'repeat',
                        'background-size' => 'cover',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center center',
                        'background-color' => '',
                    ],
                ],
                [
                    'id' => 'shop_single__page_title_padding',
                    'title' => esc_html__('Paddings Top/Bottom', 'bighearts'),
                    'type' => 'spacing',
                    'mode' => 'padding',
                    'all' => false,
                    'bottom' => true,
                    'top' => true,
                    'left' => false,
                    'right' => false,
                ],
                [
                    'id' => 'shop_single__page_title_margin',
                    'title' => esc_html__('Margin Bottom', 'bighearts'),
                    'type' => 'spacing',
                    'mode' => 'margin',
                    'all' => false,
                    'bottom' => true,
                    'top' => false,
                    'left' => false,
                    'right' => false,
                    'default' => ['margin-bottom' => '47'],
                ],
                [
                    'id' => 'shop_single_page_title_border_switch',
                    'title' => esc_html__('Enable Border Top?', 'bighearts'),
                    'type' => 'switch',
                    'default' => false,
                ],
                [
                    'id' => 'shop_single_page_title_border_color',
                    'title' => esc_html__('Border Top Color', 'bighearts'),
                    'type' => 'color_rgba',
                    'required' => ['shop_single_page_title_border_switch', '=', true],
                    'default' => [
                        'alpha' => '1',
                        'rgba' => 'rgba(229,229,229,1)',
                        'color' => '#e5e5e5',
                    ],
                ],
                [
                    'id' => 'shop_single_page_title-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'shop_single_sidebar-start',
                    'title' => esc_html__('Sidebar Settings', 'bighearts'),
                    'type' => 'section',
                    'indent' => true,
                ],
                [
                    'id' => 'shop_single_sidebar_layout',
                    'title' => esc_html__('Sidebar Layout', 'bighearts'),
                    'type' => 'image_select',
                    'options' => [
                        'none' => [
                            'alt' => esc_html__('None', 'bighearts'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                        ],
                        'left' => [
                            'alt' => esc_html__('Left', 'bighearts'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                        ],
                        'right' => [
                            'alt' => esc_html__('Right', 'bighearts'),
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                        ],
                    ],
                    'default' => 'none',
                ],
                [
                    'id' => 'shop_single_sidebar_def',
                    'title' => esc_html__('Sidebar Template', 'bighearts'),
                    'type' => 'select',
                    'required' => ['shop_single_sidebar_layout', '!=', 'none'],
                    'data' => 'sidebars',
                ],
                [
                    'id' => 'shop_single_sidebar_def_width',
                    'title' => esc_html__('Sidebar Width', 'bighearts'),
                    'type' => 'button_set',
                    'required' => ['shop_single_sidebar_layout', '!=', 'none'],
                    'options' => [
                        '9' => esc_html__('25%', 'bighearts'),
                        '8' => esc_html__('33%', 'bighearts'),
                    ],
                    'default' => '9',
                ],
                [
                    'id' => 'shop_single_sidebar_sticky',
                    'title' => esc_html__('Sticky Sidebar', 'bighearts'),
                    'type' => 'switch',
                    'required' => ['shop_single_sidebar_layout', '!=', 'none'],
                    'default' => false,
                ],
                [
                    'id' => 'shop_single_sidebar_gap',
                    'title' => esc_html__('Sidebar Side Gap', 'bighearts'),
                    'type' => 'select',
                    'required' => ['shop_single_sidebar_layout', '!=', 'none'],
                    'options' => [
                        'def' => esc_html__('Default', 'bighearts'),
                        '0' => esc_html__('0', 'bighearts'),
                        '15' => esc_html__('15', 'bighearts'),
                        '20' => esc_html__('20', 'bighearts'),
                        '25' => esc_html__('25', 'bighearts'),
                        '30' => esc_html__('30', 'bighearts'),
                        '35' => esc_html__('35', 'bighearts'),
                        '40' => esc_html__('40', 'bighearts'),
                        '45' => esc_html__('45', 'bighearts'),
                        '50' => esc_html__('50', 'bighearts'),
                    ],
                    'default' => 'def',
                ],
                [
                    'id' => 'shop_single_sidebar-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'shop_single_share',
                    'title' => esc_html__('Share On/Off', 'bighearts'),
                    'type' => 'switch',
                    'default' => false,
                ],
            ]
        ]
    );

    Redux::setSection(
        $theme_slug,
        [
            'title' => esc_html__('Related', 'bighearts'),
            'id' => 'shop-related-option',
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'shop_related_columns',
                    'title' => esc_html__('Related products column', 'bighearts'),
                    'type' => 'button_set',
                    'options' => [
                        '1' => esc_html__('1', 'bighearts'),
                        '2' => esc_html__('2', 'bighearts'),
                        '3' => esc_html__('3', 'bighearts'),
                        '4' => esc_html__('4', 'bighearts'),
                    ],
                    'default' => '4',
                ],
                [
                    'id' => 'shop_r_products_per_page',
                    'title' => esc_html__('Related products per page', 'bighearts'),
                    'type' => 'spinner',
                    'min' => '1',
                    'max' => '100',
                    'default' => '4',
                ],
            ]
        ]
    );

    Redux::setSection(
        $theme_slug,
        [
            'title' => esc_html__('Cart', 'bighearts'),
            'id' => 'shop-cart-option',
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'shop_cart__page_title_bg_image',
                    'title' => esc_html__('Page Title Background Image', 'bighearts'),
                    'type' => 'background',
                    'required' => ['page_title_switch', '=', true],
                    'background-color' => false,
                    'preview_media' => true,
                    'preview' => false,
                    'default' => [
                        'background-repeat' => 'repeat',
                        'background-size' => 'cover',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center center',
                        'background-color' => '',
                    ],
                ],
            ]
        ]
    );

    Redux::setSection(
        $theme_slug,
        [
            'id' => 'shop-checkout-option',
            'title' => esc_html__('Checkout', 'bighearts'),
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'shop_checkout__page_title_bg_image',
                    'title' => esc_html__('Page Title Background Image', 'bighearts'),
                    'type' => 'background',
                    'background-color' => false,
                    'preview_media' => true,
                    'preview' => false,
                    'default' => [
                        'background-repeat' => 'repeat',
                        'background-size' => 'cover',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center center',
                        'background-color' => '',
                    ],
                ],
            ]
        ]
    );
}

$advanced_fields = [
    [
        'id' => 'advanced_warning',
        'title' => esc_html__('Attention! This tab stores functionality that can harm site reliability.', 'bighearts'),
        'type' => 'info',
        'desc' => esc_html__('Site troublefree operation is not ensured, if any of the following options is changed.', 'bighearts'),
        'style' => 'critical',
        'icon' => 'el el-warning-sign',
    ],
    [
        'id' => 'advanced_divider',
        'type' => 'divide'
    ],
    [
        'id' => 'advanced-wp-start',
        'title' => esc_html__('WordPress', 'bighearts'),
        'type' => 'section',
        'indent' => true,
    ],
    [
        'id' => 'disable_wp_gutenberg',
        'title' => esc_html__('Gutenberg Stylesheet', 'bighearts'),
        'type' => 'switch',
        'desc' => esc_html__('Dequeue CSS files.', 'bighearts') . bighearts_quick_tip(
            wp_kses(
                __('Eliminates <code>wp-block-library-css</code> stylesheet. <br>Before disabling ensure that Gutenberg editor is not used anywhere throughout the site.', 'bighearts'),
                ['code' => [], 'br' => []]
            )
        ),
        'on' => esc_html__('Dequeue', 'bighearts'),
        'off' => esc_html__('Default', 'bighearts'),
    ],
    [
        'id' => 'wordpress_widgets',
        'title' => esc_html__('WordPress Widgets', 'bighearts'),
        'type' => 'switch',
        'on' => esc_html__('Classic', 'bighearts'),
        'off' => esc_html__('Gutenberg', 'bighearts'),
        'default' => true,
    ],
    [
        'id' => 'advanced-wp-end',
        'type' => 'section',
        'indent' => false,
    ],
];

if (class_exists('Elementor\Plugin')) {
    $advanced_elementor = [
        [
            'id' => 'advanced-elementor-start',
            'title' => esc_html__('Elementor', 'bighearts'),
            'type' => 'section',
            'indent' => true,
        ],
        [
            'id' => 'disable_elementor_googlefonts',
            'title' => esc_html__('Google Fonts', 'bighearts'),
            'type' => 'switch',
            'desc' => esc_html__('Dequeue font pack.', 'bighearts') . bighearts_quick_tip(sprintf(
                '%s <a href="%s" target="_blank">%s</a>%s',
                esc_html__('See: ', 'bighearts'),
                esc_url('https://docs.elementor.com/article/286-speed-up-a-slow-site'),
                esc_html__('Optimizing a Slow Site w/ Elementor', 'bighearts'),
                wp_kses(
                    __('<br>Note: breaks all fonts selected within <code>Group_Control_Typography</code> (if any). Has no affect on <code>Theme Options->Typography</code> fonts.', 'bighearts'),
                    ['code' => [], 'br' => []]
                )
            )),
            'on' => esc_html__('Disable', 'bighearts'),
            'off' => esc_html__('Default', 'bighearts'),
        ],
        [
            'id' => 'disable_elementor_fontawesome',
            'title' => esc_html__('Font Awesome Pack', 'bighearts'),
            'type' => 'switch',
            'desc' => esc_html__('Dequeue icon pack.', 'bighearts')
                . bighearts_quick_tip(esc_html__('Note: Font Awesome is essential for Bighearts theme. Disable only if it already enqueued by some other plugin.', 'bighearts')),
            'on' => esc_html__('Disable', 'bighearts'),
            'off' => esc_html__('Default', 'bighearts'),
        ],
        [
            'id' => 'advanced-elelemntor-end',
            'type' => 'section',
            'indent' => false,
        ],
    ];
    array_push($advanced_fields, ...$advanced_elementor);
}

Redux::setSection(
    $theme_slug,
    [
        'id' => 'advanced',
        'title' => esc_html__('Advanced', 'bighearts'),
        'icon' => 'el el-warning-sign',
        'fields' => $advanced_fields
    ]
);
