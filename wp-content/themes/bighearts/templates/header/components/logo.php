<?php

use BigHearts_Theme_Helper as BigHearts;

if (!class_exists('BigHearts_Get_Logo')) {
    /**
     * Header Logotype
     *
     *
     * @package bighearts\templates
     * @author WebGeniusLab <webgeniuslab@gmail.com>
     * @since 1.0.0
     * @version 1.0.13
     */
    class BigHearts_Get_Logo
    {
        public function __construct(
            $header = 'bottom',
            $menu = false,
            $custom_img = false,
            $custom_height = false
        ) {
            if ('mobile' == $header) {
                $this->mobileLogo($menu);
                return;
            }

            $this->defaultLogo($header, $custom_img, $custom_height);
        }

        /**
         * @since 1.0.0
         * @version 1.0.13
         */
        private static function defaultLogo(
            $header,
            $custom_img,
            $custom_height
        ) {
            $logo = $custom_img ?: BigHearts::get_option('header_logo');
            $height_limit = BigHearts::get_option('logo_height_custom');
            $logo_height = BigHearts::get_option('logo_height')['height'] ?? '';

            if (
                ! $custom_img
                && 'sticky' == $header
                && $sticky_logo = BigHearts::get_option('sticky_header_logo')
            ) {
                $logo = $sticky_logo;
                $height_limit = BigHearts::get_option('sticky_logo_height_custom');
                $logo_height = BigHearts::get_option('sticky_logo_height')['height'] ?? '';
            }

            if ($custom_height) {
                $logo_height = $custom_height;
            }

            if ($height_limit || $custom_height) {
                $style = $logo_height ? 'height: ' . esc_attr((int) $logo_height) . 'px;' : '';
                $style = $style ? ' style="' . $style . '"' : '';
            }

            if ( $custom_img && empty( $logo[ 'alt' ] ) ) {
                $logo[ 'alt' ] = get_post_meta( $logo[ 'id' ], '_wp_attachment_image_alt', true );
            }

            self::render(
                'default_logo', // class
                $logo['url'] ?? '',
                $logo['alt'] ?? '',
                $style ?? ''
            );
        }

        private function mobileLogo($menu)
        {
            $menu = !empty($menu) ? '_menu' : '';
            $logo = BigHearts::get_option('logo_mobile' . $menu);
            $src = $logo['url'] ?? '';

            if (BigHearts::get_option('mobile_logo' . $menu . '_height_custom')) {
                $height = BigHearts::get_option('mobile_logo' . $menu . '_height')['height'] ?? '';
            }

            // If no `menu logo`, use `mobile logo` options instead
            if ($menu && !$src) {
                $logo = BigHearts::get_option('logo_mobile');
                $height = BigHearts::get_option('mobile_logo_height')['height'] ?? '';
            }

            if (class_exists('SitePress')) {
                $logo_mobile_id = !empty($logo) ? $logo['id'] : '';
                if(!empty($logo_mobile_id)){
                    $wpml_logo_id = wpml_object_id_filter( $logo_mobile_id, 'post', false, ICL_LANGUAGE_CODE);
                    $logo_mobile_id = !empty($wpml_logo_id) ? $wpml_logo_id : $logo_mobile_id; 
                    $logo[ 'alt' ] = get_post_meta( $logo_mobile_id, '_wp_attachment_image_alt', true ) ?? '';       
                }
			}

            if (isset($height)) {
                $style = $height ? 'height: ' . esc_attr((int) $height) . 'px;' : '';
                $style = $style ? ' style="' . $style . '"' : '';
            }

            self::render(
                $menu ? 'logo-menu' : 'logo-mobile', // class
                $src,
                $logo['alt'] ?? '',
                $style ?? ''
            );
        }

        private static function render(
            $class,
            $src,
            $alt,
            $style
        ) {
            echo '<div class="wgl-logotype-container ', esc_attr($class), '">';
            echo '<a href="', esc_url(home_url('/')), '">';
            if ($src) {
                echo '<img',
                    ' class="', $class, '"',
                    ' src="', esc_url($src), '"',
                    ' alt="', esc_attr($alt) ?: 'logotype', '"',
                    $style,
                    '>';
            } else {
                echo '<h1 class="logo-name">',
                    get_bloginfo('name'),
                '</h1>';
            }
            echo '</a>';
            echo '</div>';
        }
    }
}
