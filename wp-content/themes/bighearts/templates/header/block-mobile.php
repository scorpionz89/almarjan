<?php

defined('ABSPATH') || exit;

if (!class_exists('BigHearts_Header_Mobile')) {
    class BigHearts_Header_Mobile extends BigHearts_Get_Header
    {
        public function __construct()
        {
            $this->header_vars();
            $this->html_render = 'mobile';

            $header_mobile_background = BigHearts_Theme_Helper::get_option('mobile_background');
            $header_mobile_color = BigHearts_Theme_Helper::get_option('mobile_color');
            $mobile_header_custom =  BigHearts_Theme_Helper::get_option('mobile_header');
            $mobile_sticky = BigHearts_Theme_Helper::get_option('mobile_sticky');

            $mobile_styles = !empty($header_mobile_background['rgba']) ? 'background-color: ' . (esc_attr($header_mobile_background['rgba'])) . ';' : '';
            $mobile_styles .= !empty($header_mobile_color) ? 'color: ' . (esc_attr($header_mobile_color)) . ';' : '';
            $mobile_styles = !empty($mobile_styles) ? ' style="' . $mobile_styles . '"' : '';

            echo '<div',
                ' class="wgl-mobile-header' . ($mobile_sticky === '1' ? ' wgl-sticky-element' : '') . '"',
                $mobile_styles,
                ($mobile_sticky === '1' ? ' data-style="standard"' : ''),
                ">";
            echo "<div class='container-wrapper'>";
            if (!empty($mobile_header_custom)) {
                $this->build_header_layout('mobile');
            } else {
                $this->default_header_mobile();
            }
            $this->build_header_mobile_menu();
            echo '</div>';
            echo '</div>';
        }

        public function default_header_mobile()
        {
            echo '<div class="wgl-header-row">';
            echo '<div class="wgl-container">';
            echo '<div class="wgl-header-row_wrapper" style="height: 100px;">';

                echo '<div class="header_side display_grow h_align_left">';
                echo '<div class="header_area_container">';

                echo '<nav class="primary-nav">';
                if (has_nav_menu('main_menu')) {
                    bighearts_main_menu();
                }
                echo '</nav>';

                echo '<div class="hamburger-box">',
                    '<div class="hamburger-inner">',
                        '<span></span>',
                        '<span></span>',
                        '<span></span>',
                    '</div>',
                '</div>';

                echo '</div>';
                echo '</div>';

                echo '<div class="header_side display_grow h_align_center">';
                echo '<div class="header_area_container">';
                    $this->get_logo();
                echo '</div>';
                echo '</div>';

                echo '<div class="header_side display_grow h_align_right">',
                    '<div class="header_area_container">',
                        BigHearts_Theme_Helper::render_html($this->search('mobile', '')),
                    '</div>',
                '</div>';

            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }

    new BigHearts_Header_Mobile();
}
