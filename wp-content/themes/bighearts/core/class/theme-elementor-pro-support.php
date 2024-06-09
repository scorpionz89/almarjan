<?php

defined('ABSPATH') || exit;

use ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager;
use ElementorPro\Modules\ThemeBuilder\Module;

/**
 * BigHearts Theme Elementor Pro Support
 *
 *
 * @class        BigHearts_Theme_ElementorPro_Support
 * @version      1.0
 * @category     Class
 * @author       WebGeniusLab
 */

if (!class_exists('BigHearts_Theme_ElementorPro_Support')) {
    class BigHearts_Theme_ElementorPro_Support
    {

        private static $instance = null;

        public static function get_instance()
        {
            if (null == self::$instance) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        public function __construct()
        {
            add_action('init', [$this, 'bighearts_init_template']);
        }

        /**
         * @param Locations_Manager $manager
         */
        public function register_locations($manager)
        {
            $manager->register_core_location('header');
            $manager->register_core_location('footer');
        }

        public function do_header()
        {
            $did_location = Module::instance()->get_locations_manager()->do_location('header');
            if ($did_location) {
                add_filter('bighearts/header/enable', '__return_false');
            }
        }

        public function do_footer()
        {
            $did_location = Module::instance()->get_locations_manager()->do_location('footer');
            if ($did_location) {
                add_filter('bighearts/footer/enable', '__return_false');
            }
        }

        public function bighearts_init_template()
        {
            add_action('elementor/theme/register_locations', [$this, 'register_locations']);

            add_action('bighearts/elementor_pro/header', [$this, 'do_header'], 0);
            add_action('bighearts/elementor_pro/footer', [$this, 'do_footer'], 0);
        }
    }
    new BigHearts_Theme_ElementorPro_Support();
}
