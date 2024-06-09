<?php

defined('ABSPATH') || exit;

use BigHearts_Theme_Helper as BigHearts;
use WglAddons\BigHearts_Global_Variables as BigHearts_Globals;

/**
 * BigHearts Dynamic Styles
 *
 *
 * @package bighearts\core\class
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 * @version 1.1.2
 */
class BigHearts_Dynamic_Styles
{
    protected static $instance;

    private $theme_slug;
    private $template_directory_uri;
    private $use_minified;
    private $enqueued_stylesheets = [];
    private $header_page_id;
    private $header_type;

    /**
     * @since 1.0.0
     * @version 1.0.5
     */
    public function __construct()
    {
        // do nothing.
    }

    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @since 1.0.5
     * @version 1.1.2
     */
    public function construct()
    {
        $this->theme_slug = $this->get_theme_slug();
        $this->template_directory_uri = get_template_directory_uri();
        $this->use_minified = BigHearts::get_option('use_minified') ? '.min' : '';
        $this->header_type = BigHearts::get_option('header_type');

        $this->enqueue_styles_and_scripts();
        $this->add_body_classes();
    }

    public function get_theme_slug()
    {
        return str_replace('-child', '', wp_get_theme()->get('TextDomain'));
    }

    public function enqueue_styles_and_scripts()
    {
        //* Elementor Compatibility
        add_action('wp_enqueue_scripts', [$this, 'get_elementor_css_theme_builder']);
        add_action('wp_enqueue_scripts', [$this, 'elementor_column_fix']);

        add_action('wp_enqueue_scripts', [$this, 'givewp_single_frontend_style']);

        add_action('wp_enqueue_scripts', [$this, 'frontend_stylesheets']);
        add_action('wp_enqueue_scripts', [$this, 'frontend_scripts']);

        add_action('admin_enqueue_scripts', [$this, 'admin_stylesheets']);
        add_action('admin_enqueue_scripts', [$this, 'admin_scripts']);
    }

    public function get_elementor_css_theme_builder()
    {
        $current_post_id = get_the_ID();
        $css_files = [];

        $locations[] = $this->get_elementor_css_cache_header();
        $locations[] = $this->get_elementor_css_cache_header_sticky();
        $locations[] = $this->get_elementor_css_cache_footer();
        $locations[] = $this->get_elementor_css_cache_side_panel();

        foreach ($locations as $location) {
            //* Don't enqueue current post here (let the preview/frontend components to handle it)
            if ($location && $current_post_id !== $location) {
                $css_file = new \Elementor\Core\Files\CSS\Post($location);
                $css_files[] = $css_file;
            }
        }

        if (!empty($css_files)) {
            \Elementor\Plugin::$instance->frontend->enqueue_styles();
            foreach ($css_files as $css_file) {
                $css_file->enqueue();
            }
        }
    }

    public function get_elementor_css_cache_header()
    {
        if (
            !apply_filters('bighearts/header/enable', true)
            || !class_exists('\Elementor\Core\Files\CSS\Post')
        ) {
            // Bailtout.
            return;
        }

        if (
            $this->RWMB_is_active()
            && 'custom' === rwmb_meta('mb_customize_header_layout')
            && 'default' !== rwmb_meta('mb_header_content_type')
        ) {
            $this->header_type = 'custom';
            $this->header_page_id = rwmb_meta('mb_customize_header');
        } else {
            $this->header_page_id = BigHearts::get_option('header_page_select');
        }

        if ('custom' === $this->header_type) {
            return $this->multi_language_support($this->header_page_id, 'header');
        }
    }

    /**
     * @version 1.1.0
     */
    public function get_elementor_css_cache_header_sticky()
    {
        if (
            ! apply_filters( 'bighearts/header/enable', true )
            || 'custom' !== $this->header_type
            || ! class_exists( '\Elementor\Core\Files\CSS\Post' )
        ) {
            // Bailtout.
            return;
        }

        $header_sticky_page_id = '';

        if (
            $this->RWMB_is_active()
            && 'custom' === rwmb_meta( 'mb_customize_header_layout' )
            && 'default' !== rwmb_meta( 'mb_sticky_header_content_type' )
        ) {
            $header_sticky_page_id = rwmb_meta( 'mb_customize_sticky_header' );
        } elseif ( BigHearts::get_option( 'header_sticky' ) ) {
            $header_sticky_page_id = BigHearts::get_option( 'header_sticky_page_select' );
        }

        return $this->multi_language_support( $header_sticky_page_id, 'header' );
    }

    public function get_elementor_css_cache_footer()
    {
        $footer = apply_filters('bighearts/footer/enable', true);
        $footer_switch = $footer['footer_switch'] ?? '';

        if (
            !$footer_switch
            || 'pages' !== BigHearts::get_mb_option('footer_content_type', 'mb_footer_switch', 'on')
            || !class_exists('\Elementor\Core\Files\CSS\Post')
        ) {
            // Bailout.
            return;
        }

        $footer_page_id = BigHearts::get_mb_option('footer_page_select', 'mb_footer_switch', 'on');

        return $this->multi_language_support($footer_page_id, 'footer');
    }

    /**
     * @since 1.0.0
     * @version 1.0.3
     */
    public function get_elementor_css_cache_side_panel()
    {
        if (
            !BigHearts::get_option('side_panel_enable')
            || 'pages' !== BigHearts::get_mb_option('side_panel_content_type', 'mb_customize_side_panel', 'custom')
            || !class_exists('\Elementor\Core\Files\CSS\Post')
        ) {
            // Bailout.
            return;
        }

        $sp_page_id = BigHearts::get_mb_option('side_panel_page_select', 'mb_customize_side_panel', 'custom');

        return $this->multi_language_support($sp_page_id, 'side_panel');
    }

    /**
     * @since 1.0.0
     * @version 1.0.5
     */
    public function multi_language_support($page_id, $page_type)
    {
        if (!$page_id) {
            // Bailout.
            return;
        }

        $page_id = intval($page_id);

        if (class_exists('Polylang') && function_exists('pll_current_language')) {
            $currentLanguage = pll_current_language();
            $translations = PLL()->model->post->get_translations($page_id);

            $polylang_id = $translations[$currentLanguage] ?? '';
            $page_id = $polylang_id ?: $page_id;
        }

        if (class_exists('SitePress')) {
            $wpml_id = wpml_object_id_filter($page_id, $page_type, false, ICL_LANGUAGE_CODE);
            if (
                $wpml_id
                && 'publish' === get_post_status($wpml_id)
            ) {
                $page_id = $wpml_id;
            }
        }

        return $page_id;
    }

    public function elementor_column_fix()
    {
        $css = '.elementor-container > .elementor-row > .elementor-column > .elementor-element-populated,'
            . '.elementor-container > .elementor-column > .elementor-element-populated {'
                . 'padding-top: 0;'
                . 'padding-bottom: 0;'
            . '}';

        $css .= '.elementor-column-gap-default > .elementor-row > .elementor-column > .elementor-element-populated,'
            . '.elementor-column-gap-default > .elementor-column > .elementor-element-populated {'
                . 'padding-left: 15px;'
                . 'padding-right: 15px;'
            . '}';

        wp_add_inline_style('elementor-frontend', $css);
    }

    /**
     * @since 1.0.0
     */
    public function givewp_single_frontend_style()
    {
        if (
            is_single()
            && 'give_forms' === get_post_type()
        ) {
            wp_dequeue_style('elementor-post-' . get_the_ID());

            $css_file = new \Elementor\Core\Files\CSS\Post(get_the_ID());
            $css_file->print_css();
        }
    }

    /**
     * @version 1.1.2
     */
    public function frontend_stylesheets()
    {
        wp_enqueue_style(
            $this->theme_slug . '-theme-info',
            get_bloginfo( 'stylesheet_url' ),
            [],
            BigHearts_Globals::get_theme_version()
        );

        $this->enqueue_css_variables();
        $this->enqueue_additional_styles();
        $this->enqueue_style( 'main', '/css/' );
        $this->enqueue_pluggable_styles();
        $this->enqueue_style( 'responsive', '/css/', $this->enqueued_stylesheets );
        $this->enqueue_style( 'dynamic', '/css/', $this->enqueued_stylesheets );

	    if ( is_rtl() ) {
		    wp_enqueue_style( $this->theme_slug . '-rtl', $this->template_directory_uri . '/css/rtl' . $this->use_minified . '.css' );
	    }
    }

    public function enqueue_css_variables()
    {
        return wp_add_inline_style(
            $this->theme_slug . '-theme-info',
            $this->retrieve_css_variables_and_extra_styles()
        );
    }

    public function enqueue_additional_styles()
    {
        wp_enqueue_style('font-awesome-5-all', $this->template_directory_uri . '/css/font-awesome-5.min.css');
        wp_enqueue_style('bighearts-flaticon', $this->template_directory_uri . '/fonts/flaticon/flaticon.css', [], BigHearts_Globals::get_theme_version());
    }

    public function retrieve_css_variables_and_extra_styles()
    {
        $root_vars = $extra_css = '';

        /**
         * Color Variables
         */
        if (
            class_exists('RWMB_Loader')
            && 'custom' === BigHearts::get_mb_option('page_colors_switch')
        ) {
            $theme_primary_color = BigHearts::get_mb_option('theme-primary-color');
            $theme_secondary_color = BigHearts::get_mb_option('theme-secondary-color');

            $button_color_idle = BigHearts::get_mb_option('button-color-idle');
            $button_color_hover = BigHearts::get_mb_option('button-color-hover');

            $bg_body = BigHearts::get_mb_option('body_background_color');

            $scroll_up_arrow_color = BigHearts::get_mb_option('scroll_up_arrow_color');
            $scroll_up_bg_color = BigHearts::get_mb_option('scroll_up_bg_color');
        } else {
            $theme_primary_color = BigHearts_Globals::get_primary_color();
            $theme_secondary_color = BigHearts_Globals::get_secondary_color();

            $button_color_idle = BigHearts_Globals::get_btn_color_idle();
            $button_color_hover = BigHearts_Globals::get_btn_color_hover();

            $bg_body = BigHearts::get_option('body-background-color');

            $scroll_up_arrow_color = BigHearts::get_option('scroll_up_arrow_color');
            $scroll_up_bg_color = BigHearts::get_option('scroll_up_bg_color');
        }
        $root_vars .= '--bighearts-primary-color: ' . esc_attr($theme_primary_color) . ';';
        $root_vars .= '--bighearts-secondary-color: ' . esc_attr($theme_secondary_color) . ';';

        $root_vars .= '--bighearts-button-color-idle: ' . esc_attr($button_color_idle) . ';';
        $root_vars .= '--bighearts-button-color-hover: ' . esc_attr($button_color_hover) . ';';

        $root_vars .= '--bighearts-back-to-top-color: ' . esc_attr($scroll_up_arrow_color) . ';';
        $root_vars .= '--bighearts-back-to-top-background: ' . esc_attr($scroll_up_bg_color) . ';';

        $theme_average_two_color = BigHearts::average_between_two_colors( $theme_primary_color, $theme_secondary_color );
        $root_vars .= '--bighearts-average-of-primary-and-secondary: ' . esc_attr( $theme_average_two_color ) . ';';

        $root_vars .= '--bighearts-body-background: ' . esc_attr($bg_body) . ';';
        //* ↑ color variables

        /**
         * Headings Variables
         */
        $header_font = BigHearts::get_option('header-font');
        $root_vars .= '--bighearts-header-font-family: ' . (esc_attr($header_font['font-family'] ?? '')) . ';';
        $root_vars .= '--bighearts-header-font-weight: ' . (esc_attr($header_font['font-weight'] ?? '')) . ';';
        $root_vars .= '--bighearts-header-font-color: ' . (esc_attr($header_font['color'] ?? '')) . ';';

        for ($i = 1; $i <= 6; $i++) {
            ${'header-h' . $i} = BigHearts::get_option('header-h' . $i);

            $root_vars .= '--bighearts-h' . $i . '-font-family: ' . (esc_attr(${'header-h' . $i}['font-family'] ?? '')) . ';';
            $root_vars .= '--bighearts-h' . $i . '-font-size: ' . (esc_attr(${'header-h' . $i}['font-size'] ?? '')) . ';';
            $root_vars .= '--bighearts-h' . $i . '-line-height: ' . (esc_attr(${'header-h' . $i}['line-height'] ?? '')) . ';';
            $root_vars .= '--bighearts-h' . $i . '-font-weight: ' . (esc_attr(${'header-h' . $i}['font-weight'] ?? '')) . ';';
            $root_vars .= '--bighearts-h' . $i . '-text-transform: ' . (esc_attr(${'header-h' . $i}['text-transform'] ?? '')) . ';';
        }
        //* ↑ headings variables

        /**
         * Content Variables
         */
        $main_font = BigHearts::get_option('main-font');
        $content_font_size = $main_font['font-size'] ?? '';
        $content_line_height = $main_font['line-height'] ?? '';
        $content_line_height = $content_line_height ? round(((int) $content_line_height / (int) $content_font_size), 3) : '';

        $root_vars .= '--bighearts-content-font-family: ' . (esc_attr($main_font['font-family'] ?? '')) . ';';
        $root_vars .= '--bighearts-content-font-size: ' . esc_attr($content_font_size) . ';';
        $root_vars .= '--bighearts-content-line-height: ' . esc_attr($content_line_height) . ';';
        $root_vars .= '--bighearts-content-font-weight: ' . (esc_attr($main_font['font-weight'] ?? '')) . ';';
        $root_vars .= '--bighearts-content-color: ' . (esc_attr($main_font['color'] ?? '')) . ';';
        //* ↑ content variables

        /**
         * Menu Variables
         */
        $menu_font = BigHearts::get_option('menu-font');
        $root_vars .= '--bighearts-menu-font-family: ' . (esc_attr($menu_font['font-family'] ?? '')) . ';';
        $root_vars .= '--bighearts-menu-font-size: ' . (esc_attr($menu_font['font-size'] ?? '')) . ';';
        $root_vars .= '--bighearts-menu-line-height: ' . (esc_attr($menu_font['line-height'] ?? '')) . ';';
        $root_vars .= '--bighearts-menu-font-weight: ' . (esc_attr($menu_font['font-weight'] ?? '')) . ';';
        //* ↑ menu variables

        /**
         * Submenu Variables
         */
        $sub_menu_font = BigHearts::get_option('sub-menu-font');
        $root_vars .= '--bighearts-submenu-font-family: ' . (esc_attr($sub_menu_font['font-family'] ?? '')) . ';';
        $root_vars .= '--bighearts-submenu-font-size: ' . (esc_attr($sub_menu_font['font-size'] ?? '')) . ';';
        $root_vars .= '--bighearts-submenu-line-height: ' . (esc_attr($sub_menu_font['line-height'] ?? '')) . ';';
        $root_vars .= '--bighearts-submenu-font-weight: ' . (esc_attr($sub_menu_font['font-weight'] ?? '')) . ';';
        $root_vars .= '--bighearts-submenu-color: ' . (esc_attr(BigHearts::get_option('sub_menu_color') ?? '')) . ';';
        $root_vars .= '--bighearts-submenu-background: ' . (esc_attr(BigHearts::get_option('sub_menu_background')['rgba'] ?? '')) . ';';

        $root_vars .= '--bighearts-submenu-mobile-color: ' . (esc_attr(BigHearts::get_option('mobile_sub_menu_color') ?? '')) . ';';
        $root_vars .= '--bighearts-submenu-mobile-background: ' . (esc_attr(BigHearts::get_option('mobile_sub_menu_background')['rgba'] ?? '')) . ';';
        $root_vars .= '--bighearts-submenu-mobile-overlay: ' . (esc_attr(BigHearts::get_option('mobile_sub_menu_overlay')['rgba'] ?? '')) . ';';

        $sub_menu_border = BigHearts::get_option('header_sub_menu_bottom_border');
        if ($sub_menu_border) {
            $sub_menu_border_height = BigHearts::get_option('header_sub_menu_border_height')['height'] ?? '';
            $sub_menu_border_color = BigHearts::get_option('header_sub_menu_bottom_border_color')['rgba'] ?? '';

            $extra_css .= '.primary-nav ul li ul li:not(:last-child),'
                . '.sitepress_container > .wpml-ls ul ul li:not(:last-child) {'
                    . ($sub_menu_border_height ? 'border-bottom-width: ' . (int) esc_attr($sub_menu_border_height) . 'px;' : '')
                    . ($sub_menu_border_color ? 'border-bottom-color: ' . esc_attr($sub_menu_border_color) . ';' : '')
                    . 'border-bottom-style: solid;'
                . '}';
        }
        //* ↑ submenu variables

        /**
         * Additional Font Variables
         */
        $extra_font = BigHearts::get_option('additional-font');
        empty($extra_font['font-family']) || $root_vars .= '--bighearts-additional-font-family: ' . esc_attr($extra_font['font-family']) . ';';
        empty($extra_font['font-weight']) || $root_vars .= '--bighearts-additional-font-weight: ' . esc_attr($extra_font['font-weight']) . ';';
        empty($extra_font['color']) || $root_vars .= '--bighearts-additional-font-color: ' . esc_attr($extra_font['color']) . ';';
        //* ↑ additional font variables

        /**
         * Button Font Variables
         */
        $button_font = BigHearts::get_option('button-font');
        $root_vars .= '--bighearts-button-font-family: ' . esc_attr($button_font['font-family'] ?? '') . ';';
        $root_vars .= '--bighearts-button-font-size: ' . esc_attr($button_font['font-size'] ?? '') . ';';
        $root_vars .= '--bighearts-button-line-height: ' . esc_attr($button_font['line-height'] ?? '') . ';';
        $root_vars .= '--bighearts-button-font-weight: ' . esc_attr($button_font['font-weight'] ?? '') . ';';
        $root_vars .= '--bighearts-button-text-transform: ' . esc_attr($button_font['text-transform'] ?? '') . ';';

        $button_letter_spacing = !empty($button_font['letter-spacing']) ?: '0';
        $root_vars .= '--bighearts-button-letter-spacing: ' . esc_attr($button_letter_spacing) . ';';
        //* ↑ button font variables

        /**
         * Footer Variables
         */
        if (
            BigHearts::get_option('footer_switch')
            && 'widgets' === BigHearts::get_option('footer_content_type')
        ) {
            $root_vars .= '--bighearts-footer-content-color: ' . (esc_attr(BigHearts::get_option('footer_text_color') ?? '')) . ';';
            $root_vars .= '--bighearts-footer-heading-color: ' . (esc_attr(BigHearts::get_option('footer_heading_color') ?? '')) . ';';
            $root_vars .= '--bighearts-copyright-content-color: ' . (esc_attr(BigHearts::get_mb_option('copyright_text_color', 'mb_copyright_switch', 'on') ?? '')) . ';';
        }
        //* ↑ footer variables

        /**
         * Side Panel Variables
         */
        $sidepanel_title_color = BigHearts::get_mb_option('side_panel_title_color', 'mb_customize_side_panel', 'custom');
	    $sidepanel_title_color && $root_vars .= '--bighearts-sidepanel-title-color: ' . esc_attr($sidepanel_title_color) . ';';
        //* ↑ side panel variables

        /**
         * Elementor Container
         */
	    $root_vars .= '--bighearts-elementor-container-width: ' . $this->get_elementor_container_width() . 'px;';
        //* ↑ elementor container

        $css_variables = ':root {' . $root_vars . '}';

        $extra_css .= $this->get_mobile_header_extra_css();
        $extra_css .= $this->get_page_title_responsive_extra_css();

        return $css_variables . $extra_css;
    }

    public function get_elementor_container_width()
    {
        if (
            did_action('elementor/loaded')
            && defined('ELEMENTOR_VERSION')
        ) {
            if (version_compare(ELEMENTOR_VERSION, '3.0', '<')) {
                $container_width = get_option('elementor_container_width') ?: 1140;
            } else {
                $kit_id = (new \Elementor\Core\Kits\Manager())->get_active_id();
                $meta_key = \Elementor\Core\Settings\Page\Manager::META_KEY;
                $kit_settings = get_post_meta($kit_id, $meta_key, true);
                $container_width = $kit_settings['container_width']['size'] ?? 1140;
            }
        }

        return $container_width ?? 1170;
    }

    protected function get_mobile_header_extra_css()
    {
        $extra_css = '';

        if (BigHearts::get_option('mobile_header')) {
            $mobile_background = BigHearts::get_option('mobile_background')['rgba'] ?? '';
            $mobile_color = BigHearts::get_option('mobile_color');

            $extra_css .= '.wgl-theme-header {'
                    . 'background-color: ' . esc_attr($mobile_background) . ' !important;'
                    . 'color: ' . esc_attr($mobile_color) . ' !important;'
                . '}';
        }

        $extra_css .= 'header.wgl-theme-header .wgl-mobile-header {'
                . 'display: block;'
            . '}'
            . '.wgl-site-header,'
            . '.wgl-theme-header .primary-nav {'
                . 'display: none;'
            . '}'
            . '.wgl-theme-header .hamburger-box {'
                . 'display: inline-flex;'
            . '}'
            . 'header.wgl-theme-header .mobile_nav_wrapper .primary-nav {'
                . 'display: block;'
            . '}'
            . '.wgl-theme-header .wgl-sticky-header {'
                . 'display: none;'
            . '}'
            . '.wgl-page-socials {'
                . 'display: none;'
            . '}';

        $mobile_sticky = BigHearts::get_option('mobile_sticky');

        if (BigHearts::get_option('mobile_over_content')) {
            $extra_css .= 'body .wgl-theme-header {'
                    . 'position: absolute;'
                    . 'z-index: 99;'
                    . 'width: 100%;'
                    . 'left: 0;'
                    . 'top: 0;'
                . '}';

            if ($mobile_sticky) {
                $extra_css .= 'body .wgl-theme-header .wgl-mobile-header {'
                        . 'position: absolute;'
                        . 'left: 0;'
                        . 'width: 100%;'
                    . '}';
            }

        } else {
            $extra_css .= 'body .wgl-theme-header.header_overlap {'
                    . 'position: relative;'
                    . 'z-index: 2;'
                . '}';
        }

        if ($mobile_sticky) {
            $extra_css .= 'body .wgl-theme-header,'
                . 'body .wgl-theme-header.header_overlap {'
                    . 'position: sticky;'
                    . 'top: 0;'
                . '}';
        }

        return '@media only screen and (max-width: ' . $this->get_header_mobile_breakpoint() . 'px) {' . $extra_css . '}';
    }

    protected function get_header_mobile_breakpoint()
    {
        $elementor_breakpoint = '';

        if (
            'custom' === $this->header_type
            && $this->header_page_id
            && did_action('elementor/loaded')
        ) {
            $settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers('page');
            $settings_model = $settings_manager->get_model($this->header_page_id);

            $elementor_breakpoint = $settings_model->get_settings('mobile_breakpoint');
        }

        return $elementor_breakpoint ?: (int) BigHearts::get_option('header_mobile_queris');
    }

    protected function get_page_title_responsive_extra_css()
    {
        $page_title_resp = BigHearts::get_option('page_title_resp_switch');

        if (
            $this->RWMB_is_active()
            && 'on' === rwmb_meta('mb_page_title_switch')
            && rwmb_meta('mb_page_title_resp_switch')
        ) {
            $page_title_resp = true;
        }

        if (!$page_title_resp) {
            // Bailout, if no any responsive logic
            return;
        }

        $pt_padding = BigHearts::get_mb_option('page_title_resp_padding', 'mb_page_title_resp_switch', true);

        $extra_css = '.page-header {'
                . (!empty($pt_padding['padding-top']) ? 'padding-top: ' . esc_attr((int) $pt_padding['padding-top']) . 'px !important;' : '')
                . (!empty($pt_padding['padding-bottom']) ? 'padding-bottom: ' . esc_attr((int) $pt_padding['padding-bottom']) . 'px !important;' : '')
                . 'min-height: auto !important;'
            . '}';

        $breadcrumbs_switch = BigHearts::get_mb_option('page_title_resp_breadcrumbs_switch', 'mb_page_title_resp_switch', true);

        //* Title
        $pt_font = BigHearts::get_mb_option('page_title_resp_font', 'mb_page_title_resp_switch', true);
        $pt_color = !empty($pt_font['color']) ? 'color: ' . esc_attr($pt_font['color']) . ' !important;' : '';
        $pt_f_size = !empty($pt_font['font-size']) ? ' font-size: ' . esc_attr((int) $pt_font['font-size']) . 'px !important;' : '';
        $pt_line_height = !empty($pt_font['line-height']) ? ' line-height: ' . esc_attr((int) $pt_font['line-height']) . 'px !important;' : '';
        $pt_additional_style = !(bool) $breadcrumbs_switch ? ' margin-bottom: 0 !important;' : '';
        $title_style = $pt_color . $pt_f_size . $pt_line_height . $pt_additional_style;

        $extra_css .= '.page-header_content .page-header_title {' . $title_style . '}';

        //* Breadcrumbs
        $breadcrumbs_font = BigHearts::get_mb_option('page_title_resp_breadcrumbs_font', 'mb_page_title_resp_switch', true);
        $breadcrumbs_color = !empty($breadcrumbs_font['color']) ? 'color: ' . esc_attr($breadcrumbs_font['color']) . ' !important;' : '';
        $breadcrumbs_f_size = !empty($breadcrumbs_font['font-size']) ? 'font-size: ' . esc_attr((int) $breadcrumbs_font['font-size']) . 'px !important;' : '';
        $breadcrumbs_line_height = !empty($breadcrumbs_font['line-height']) ? 'line-height: ' . esc_attr((int) $breadcrumbs_font['line-height']) . 'px !important;' : '';
        $breadcrumbs_display = !(bool) $breadcrumbs_switch ? 'display: none !important;' : '';
        $breadcrumbs_style = $breadcrumbs_color . $breadcrumbs_f_size . $breadcrumbs_line_height . $breadcrumbs_display;

        $extra_css .= '.page-header_content .page-header_breadcrumbs {' . $breadcrumbs_style . '}'
            . '.page-header_breadcrumbs .divider:not(:last-child):before {width: 10px;}';

        //* Blog Single Type 3
        if (
            is_single()
            && 'post' === get_post_type()
            && '3' === BigHearts::get_mb_option('single_type_layout', 'mb_post_layout_conditional', 'custom')
        ) {
            $blog_t3_padding = BigHearts::get_option('single_padding_layout_3');
            $blog_t3_p_top = $blog_t3_padding['padding-top'] ?? '';
            $blog_t3_p_bottom = $blog_t3_padding['padding-bottom'] ?? '';
            $blog_t3_p_top_responsive = $blog_t3_p_top > $blog_t3_p_bottom ? 10 + (int) $blog_t3_p_bottom : (int) $blog_t3_p_top;
            $blog_t3_p_top_responsive = $blog_t3_p_top_responsive > 100 ? 100 : $blog_t3_p_top_responsive;

            $extra_css .= '.single-post .post_featured_bg > .blog-post {'
                    . 'padding-top: ' . $blog_t3_p_top_responsive . 'px !important;'
                . '}';
        }

        $pt_breakpoint = (int) BigHearts::get_mb_option('page_title_resp_resolution', 'mb_page_title_resp_switch', true);

        return '@media (max-width: ' . $pt_breakpoint . 'px) {' . $extra_css . '}';
    }

    /**
     * Enqueue theme stylesheets
     *
     * Function keeps track of already enqueued stylesheets and stores them in `enqueued_stylesheets[]`
     *
     * @param string   $tag      Unprefixed handle.
     * @param string   $file_dir Path to stylesheet folder, relative to BigHearts root folder.
     * @param string[] $deps     Optional. An array of registered stylesheet handles this stylesheet depends on.
     */
    public function enqueue_style($tag, $file_dir, $deps = [])
    {
        $prefixed_tag = $this->theme_slug . '-' . $tag;
        $this->enqueued_stylesheets[] = $prefixed_tag;

        wp_enqueue_style(
            $prefixed_tag,
            $this->template_directory_uri . $file_dir . $tag . $this->use_minified . '.css',
            $deps,
            BigHearts_Globals::get_theme_version()
        );
    }

    public function enqueue_pluggable_styles()
    {
        //* Preloader
        if (BigHearts::get_option('preloader')) {
            $this->enqueue_style('preloader', '/css/pluggable/');
        }

        //* Page 404|Search
        if (is_404() || is_search()) {
            $this->enqueue_style('page-404', '/css/pluggable/');
        }

        //* Gutenberg
        if (BigHearts::get_option('disable_wp_gutenberg')) {
            wp_dequeue_style('wp-block-library');
        } else {
            $this->enqueue_style('gutenberg', '/css/pluggable/');
        }

        //* Post Single (blog, portfolio)
        if (is_single()) {
            $post_type = get_post()->post_type;
            if (
                'post' === $post_type
                || 'portfolio' === $post_type
            ) {
                $this->enqueue_style('blog-post-single', '/css/pluggable/');
            }
        }

        //* Give-WP Plugin
        if (class_exists('Give')) {
            $this->enqueue_style('give-wp', '/css/pluggable/');
        }

        //* WooCommerce Plugin
        if (class_exists('WooCommerce')) {
            $this->enqueue_style('woocommerce', '/css/pluggable/');
        }

        //* Side Panel
        if (BigHearts::get_option('side_panel_enable')) {
            $this->enqueue_style('side-panel', '/css/pluggable/');
        }

        //* WPML plugin
        if (class_exists('SitePress')) {
            $this->enqueue_style('wpml', '/css/pluggable/');
        }

        //* Polylang plugin
        if (function_exists('pll_the_languages')) {
            $this->enqueue_style('polylang', '/css/pluggable/');
        }
    }

    public function frontend_scripts()
    {
        wp_enqueue_script('bighearts-theme-addons', $this->template_directory_uri . '/js/theme-addons' . $this->use_minified . '.js', ['jquery'], BigHearts_Globals::get_theme_version(), true);
        wp_enqueue_script('bighearts-theme', $this->template_directory_uri . '/js/theme.js', ['jquery'], BigHearts_Globals::get_theme_version(), true);

        wp_localize_script('bighearts-theme', 'wgl_core', [
            'ajaxurl' => esc_url(admin_url('admin-ajax.php')),
        ]);

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }

        wp_enqueue_script('perfect-scrollbar', $this->template_directory_uri . '/js/perfect-scrollbar.min.js');
    }

    public function admin_stylesheets()
    {
        wp_enqueue_style('bighearts-admin', $this->template_directory_uri . '/core/admin/css/admin.css', [], BigHearts_Globals::get_theme_version());
        wp_enqueue_style('font-awesome-5-all', $this->template_directory_uri . '/css/font-awesome-5.min.css');
        wp_enqueue_style('wp-color-picker');
    }

    public function admin_scripts()
    {
        wp_enqueue_media();

        wp_enqueue_script('wp-color-picker');
	    wp_localize_script('wp-color-picker', 'wpColorPickerL10n', [
		    'clear' => esc_html__('Clear', 'bighearts'),
		    'clearAriaLabel' => esc_html__('Clear color', 'bighearts'),
		    'defaultString' => esc_html__('Default', 'bighearts'),
		    'defaultAriaLabel' => esc_html__('Select default color', 'bighearts'),
		    'pick' => esc_html__('Select', 'bighearts'),
		    'defaultLabel' => esc_html__('Color value', 'bighearts'),
        ]);

        wp_enqueue_script('bighearts-admin', $this->template_directory_uri . '/core/admin/js/admin.js', [], BigHearts_Globals::get_theme_version());

        if (class_exists('RWMB_Loader')) {
            wp_enqueue_script('bighearts-metaboxes', $this->template_directory_uri . '/core/admin/js/metaboxes.js', [], BigHearts_Globals::get_theme_version());
        }

        $currentTheme = wp_get_theme();
        $theme_name = false == $currentTheme->parent()
            ? wp_get_theme()->get('Name')
            : wp_get_theme()->parent()->get('Name');
        $theme_name = trim($theme_name);

        $purchase_code = $email = '';
        if (BigHearts::wgl_theme_activated()) {
            $theme_details = get_option('wgl_licence_validated');
            $purchase_code = $theme_details['purchase'] ?? '';
            $email = $theme_details['email'] ?? '';
        }

        wp_localize_script('bighearts-admin', 'wgl_verify', [
            'ajaxurl' => esc_js(admin_url('admin-ajax.php')),
            'wglUrlActivate' => esc_js(WGL_Theme_Verify::get_instance()->api . 'verification'),
            'wglUrlReset' => esc_js(WGL_Theme_Verify::get_instance()->api . 'reset_activation'),
            'wglUrlDeactivate' => esc_js(WGL_Theme_Verify::get_instance()->api . 'deactivate'),
            'domainUrl' => esc_js(site_url('/')),
            'themeName' => esc_js($theme_name),
            'purchaseCode' => esc_js($purchase_code),
            'email' => esc_js($email),
            'message' => esc_js(esc_html__('Thank you, your license has been validated', 'bighearts')),
            'titleCodeRigistered' => esc_js(esc_html__('This purchase code has been registered', 'bighearts')),
            'messageCodeRigistered' => esc_js(esc_html__('Please go to your previous working environment and deactivate the purchase code to use it again (WP dashboard -> WebGeniusLab -> Activate Theme -> click on the button "Deactivate" )', 'bighearts')),
            'messageLostCode' => esc_js(esc_html__('Lost access to your previous site?', 'bighearts')),
            'ajax_nonce' => esc_js(wp_create_nonce('_notice_nonce'))
        ]);
    }

    /**
     * @version 1.1.2
     */
    protected function add_body_classes()
    {
        add_filter( 'body_class', function ( Array $classes ) {
            if (
                is_single()
                && 'post' === get_post_type( get_queried_object_id() )
                && '3' === BigHearts::get_mb_option( 'single_type_layout', 'mb_post_layout_conditional', 'custom' )
            ) {
                $classes[] = 'bighearts-blog-type-overlay';
            }

            return $classes;
        } );
    }

    public function RWMB_is_active()
    {
        $id = ! is_archive() ? get_queried_object_id() : 0;

        return class_exists( 'RWMB_Loader' ) && 0 !== $id;
    }
}

function bighearts_dynamic_styles()
{
    return BigHearts_Dynamic_Styles::instance();
}

bighearts_dynamic_styles()->construct();