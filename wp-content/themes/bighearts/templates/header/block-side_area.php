<?php

defined('ABSPATH') || exit;

use BigHearts_Theme_Helper as BigHearts;

if (!class_exists('BigHearts_Header_Side_Area')) {
    /**
     * @since 1.0.0
     * @version 1.0.3
     */
    class BigHearts_Header_Side_Area extends BigHearts_Get_Header
    {
        public function __construct()
        {
            $side_panel_disabled = !BigHearts::get_option('side_panel_enable');
            if ($side_panel_disabled) {
                // Bailout.
                return;
            }

            $this->render();
        }

        public function render()
        {
            echo '<div class="side-panel_overlay"></div>';
            echo '<section id="side-panel"', $this->get_section_classes(), $this->get_section_styles(), '>';

                echo '<button class="side-panel_close">',
                    '<span class="side-panel_close_icon">',
                        '<span></span>',
                        '<span></span>',
                    '</span>',
                '</button>';

                echo '<div class="side-panel_sidebar"', $this->get_side_panel_styles(), '>';

                $content_type = BigHearts::get_mb_option('side_panel_content_type', 'mb_customize_side_panel', 'custom');
                switch ($content_type) {
                    case 'pages':
                        $this->render_page();
                        break;
                    case 'widgets':
                    default:
                        dynamic_sidebar('side_panel');
                        break;
                }

                echo '</div>';

            echo '</section>';
        }

        public function get_section_classes()
        {
            $position = BigHearts::get_mb_option('side_panel_position', 'mb_customize_side_panel', 'custom') ?: 'right';
            $class = ' side-panel_position_' . $position;

            return ' class="side-panel_widgets' . $class .  '"';
        }

        public function get_section_styles()
        {
            if (
                class_exists('RWMB_Loader')
                && 0 !== $this->id
                && 'custom' === rwmb_meta('mb_customize_side_panel')
            ) {
                $bg = rwmb_meta('mb_side_panel_bg');
                $color = rwmb_meta('mb_side_panel_text_color');
                $width = rwmb_meta('mb_side_panel_width');
            }
            $bg = $bg ?? (BigHearts::get_option('side_panel_bg')['rgba'] ?? '');
            $color = $color ?? (BigHearts::get_option('side_panel_text_color')['rgba'] ?? '');
            $width = $width ?? (BigHearts::get_option('side_panel_width')['width'] ?? '');

            $style = '';
            if ($bg) $style .= 'background-color: ' . esc_attr($bg) . ';';
            if ($color) $style .= 'color: ' . esc_attr($color) . ';';
            if ($width) $style .= 'width: ' . esc_attr((int) $width) . 'px;';

            $align = BigHearts::get_mb_option('side_panel_text_alignment', 'mb_customize_side_panel', 'custom');
            $style .= $align ? 'text-align: ' . esc_attr($align) . ';' : 'text-align: center;';

            return $style ? ' style="' . $style . '"' : '';
        }

        public function get_side_panel_styles()
        {
            $spacings = BigHearts::get_mb_option('side_panel_spacing', 'mb_customize_side_panel', 'custom') ?: [];

            $p_top = !empty($spacings['padding-top']) ? 'padding-top:' . (int) $spacings['padding-top'] . 'px;' : '';
            $p_bottom = !empty($spacings['padding-bottom']) ? ' padding-bottom:' . (int) $spacings['padding-bottom'] . 'px;' : '';
            $p_left = !empty($spacings['padding-left']) ? ' padding-left:' . (int) $spacings['padding-left'] . 'px;' : '';
            $p_right = !empty($spacings['padding-right']) ? ' padding-right:' . (int) $spacings['padding-right'] . 'px;' : '';

            $style = $p_top . $p_bottom . $p_left . $p_right;

            return $style ? ' style="' . $style . '"' : '';
        }

        /**
         * @since 1.0.0
         * @version 1.0.3
         */
        public function render_page()
        {
            $page_select = BigHearts::get_mb_option('side_panel_page_select', 'mb_customize_side_panel', 'custom');

            if (
                !$page_select
                || !did_action('elementor/loaded')
            ) {
                // Bailout, if nothing to render
                return;
            }

            $page_select = intval($page_select);

            if (class_exists('Polylang') && function_exists('pll_current_language')) {
                $currentLanguage = pll_current_language();
                $translations = PLL()->model->post->get_translations($page_select);

                $polylang_id = $translations[$currentLanguage] ?? '';
                $page_select = $polylang_id ?: $page_select;
            }

            if (class_exists('SitePress')) {
                $wpml_id = wpml_object_id_filter($page_select, 'side_panel', false, ICL_LANGUAGE_CODE);
                if (
                    $wpml_id
                    && 'publish' === get_post_status($wpml_id)
                ) {
                    $page_select = $wpml_id;
                }
            }

            echo \Elementor\Plugin::$instance->frontend->get_builder_content($page_select);
        }
    }

    new BigHearts_Header_Side_Area();
}
