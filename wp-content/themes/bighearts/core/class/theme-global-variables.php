<?php
namespace WglAddons;

defined('ABSPATH') || exit;

use BigHearts_Theme_Helper as BigHearts;

if (!class_exists('BigHearts_Global_Variables')) {
    /**
     * BigHearts Global Variables
     *
     *
     * @package bighearts\core\class
     * @author WebGeniusLab <webgeniuslab@gmail.com>
     * @since 1.0.0
     */
    class BigHearts_Global_Variables
    {
        protected static $theme_version;
        protected static $primary_color;
        protected static $secondary_color;
        protected static $h_font_color;
        protected static $main_font_color;
        protected static $btn_color_idle;
        protected static $btn_color_hover;

        function __construct()
        {
            if (class_exists('\BigHearts_Theme_Helper')) {
                $this->set_variables();
            }
        }

        protected function set_variables()
        {
            // Theme Version
            self::$theme_version = wp_get_theme()->get('Version') ?? false;

            // Colors
            self::$primary_color = esc_attr(BigHearts::get_option('theme-primary-color'));
            self::$secondary_color = esc_attr(BigHearts::get_option('theme-secondary-color'));
            self::$h_font_color = esc_attr(BigHearts::get_option('header-font')['color'] ?? null);
            self::$main_font_color = esc_attr(BigHearts::get_option('main-font')['color'] ?? null);
            self::$btn_color_idle = esc_attr(BigHearts::get_option('button-color-idle'));
            self::$btn_color_hover = esc_attr(BigHearts::get_option('button-color-hover'));
        }

        public static function get_theme_version()
        {
            return self::$theme_version;
        }

        public static function get_primary_color()
        {
            return self::$primary_color;
        }

        public static function get_secondary_color()
        {
            return self::$secondary_color;
        }

        public static function get_h_font_color()
        {
            return self::$h_font_color;
        }

        public static function get_main_font_color()
        {
            return self::$main_font_color;
        }

        public static function get_btn_color_idle()
        {
            return self::$btn_color_idle;
        }

        public static function get_btn_color_hover()
        {
            return self::$btn_color_hover;
        }
    }

    new BigHearts_Global_Variables();
}
