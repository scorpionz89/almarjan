<?php

define( 'WGL_ELEMENTOR_ADDONS_URL', plugins_url( '/', __FILE__ ) );
define( 'WGL_ELEMENTOR_ADDONS_PATH', plugin_dir_path( __FILE__ ) );
define( 'WGL_ELEMENTOR_ADDONS_FILE', __FILE__ );

use Elementor\{
    Plugin,
    Core\Base\Document,
    Core\Schemes\Manager as Schemes_Manager
};
use WglAddons\{
    BigHearts_Global_Variables as BigHearts_Globals,
    Includes\Wgl_Elementor_Helper
};
use BigHearts_Theme_Helper as BigHearts;

if ( ! class_exists( 'Wgl_Addons_Elementor' ) ) {
    /**
     * WGL Elementor Extenstion
     *
     *
     * @package bighearts-core\includes\elementor
     * @author WebGeniusLab <webgeniuslab@gmail.com>
     * @since 1.0.0
     * @version 1.1.5
     */
    class Wgl_Addons_Elementor
    {
        /**
         * @var string The defualt path to elementor dir on this plugin.
         */
        private $dir_path;

        private $admin_bar_edit_documents;
        private $documents;

        public static $typography_1 = '1';
        public static $typography_2 = '2';
        public static $typography_3 = '3';
        public static $typography_4 = '4';

        private static $instance;

        public function __construct()
        {
            $this->dir_path = plugin_dir_path(__FILE__);

            add_action( 'plugins_loaded', [ $this, 'elementor_setup' ] );
            add_action('elementor/init', [$this, 'elementor_widgets_translatable']);

            add_action( 'elementor/init', [ $this, 'optimize_elementor' ], 5 );
            add_action( 'elementor/init', [ $this, 'inject_wgl_categories' ] );
            add_action( 'elementor/init', [ $this, 'save_custom_schemes' ] );
            add_action( 'elementor/init', [ $this, '_v_3_0_0_compatible' ] );

            add_filter( 'elementor/widgets/wordpress/widget_args', [ $this, 'wgl_widget_args' ], 10, 1 ); // WPCS: spelling ok.

            add_filter( 'admin_bar_menu', [ $this, 'replace_elementor_admin_bar_title' ], 400 );
            add_action( 'elementor/css-file/post/enqueue', [ $this, 'add_document_to_admin_bar' ] );
            add_action( 'wp_before_admin_bar_render', [ $this, 'remove_admin_bar_node' ] );
            add_action( 'wp_enqueue_scripts', [ $this, 'admin_bar_style' ] );

            add_action( 'elementor/frontend/get_builder_content', [ $this, 'add_builder_to_admin_bar' ], 10, 2 );
            add_filter( 'elementor/frontend/admin_bar/settings', [ $this, 'add_menu_in_admin_bar' ] );

            add_filter('template_include', [$this, 'modify_page_structure_for_saved_templates'], 12); // after Elementors hook
        }

        /**
         * Eliminate redundant functionality
         * and speed up website load
         */
        public function optimize_elementor()
        {
            if ( ! class_exists( '\BigHearts_Theme_Helper' ) ) {
                return;
            }

            if ( BigHearts::get_option( 'disable_elementor_googlefonts' ) ) {
                /**
                 * Disable Google Fonts
                 * Note: breaks all fonts selected within `Group_Control_Typography` (if any).
                 */
                add_filter('elementor/frontend/print_google_fonts', '__return_false');
            }

            if ( BigHearts::get_option( 'disable_elementor_fontawesome' ) ) {
                /** Disable Font Awesome pack */
                add_action('elementor/frontend/after_register_styles', function () {
                    foreach (['solid', 'regular', 'brands'] as $style) {
                        wp_deregister_style('elementor-icons-fa-' . $style);
                    }
                }, 20);
            }
        }

        public function elementor_setup()
        {
            $this->includes();

            /**
             * Check if Elementor installed and activated
             * @see https://developers.elementor.com/creating-an-extension-for-elementor/
             */
            if ( ! did_action( 'elementor/loaded' ) ) {
                return;
            }

            $this->init_addons();
        }

        /**
         * Require core files
         */
        public function includes()
        {
            $this->init_helper_files();
        }

        /**
         * @version 1.1.5
         */
        public function init_helper_files()
        {
            require_once $this->dir_path . 'includes/loop_settings.php';
            require_once $this->dir_path . 'includes/icons_settings.php';
            require_once $this->dir_path . 'includes/carousel_settings.php';
            require_once $this->dir_path . 'includes/plugin_helper.php';

            $this->templates_register();
        }

        public function elementor_widgets_translatable()
        {
            if (
                class_exists('\SitePress')
            ) {
                require_once $this->dir_path . 'includes/wpml_translate.php';
            }
        }

        /**
         * Requires templates files
         */
        private function templates_register()
        {
            $template_names = [];
            $template_path = '/bighearts-core/elementor/templates/';
            $plugin_template_path = $this->dir_path . 'templates/';

            foreach (glob($plugin_template_path . '*.php') as $file) {
                $template_name = basename($file);
                array_push($template_names, $template_name);
            }

            $files = Wgl_Elementor_Helper::get_locate_template($template_names, '/templates/', $template_path);

            foreach ((array) $files as $file) {
                require_once $file;
            }
        }

        /**
         * Require initial necessary files
         */
        public function init_modules_files()
        {
            foreach ( glob( $this->dir_path . 'modules/' . '*.php' ) as $file ) {
                $this->register_modules_addon( $file );
            }
        }

        /**
         * Register addon by file name
         */
        public function register_modules_addon( $file_name )
        {
            $base = basename( str_replace( '.php', '', $file_name ) );
            $class = ucwords( str_replace( '-', ' ', $base ) );
            $class = str_replace( ' ', '_', $class );
            $class = sprintf( 'WglAddons\Modules\%s', $class );

            if ($class === 'WglAddons\Widgets\Wgl_Products_Grid' && !class_exists('WooCommerce')) {
                return;
            }

            // Class File
            require_once $file_name;

            if ( class_exists( $class ) ) {
                new $class();
            }
        }

        /**
         * Load required file for addons integration
         *
         * @version 1.1.5
         */
        public function init_addons()
        {
            add_action('elementor/widgets/register', [$this, 'widgets_area']);
            add_action( 'elementor/controls/register', [ $this, 'controls_area' ] );

            // Register Frontend Widget Scripts
            add_action( 'elementor/frontend/after_register_scripts', [ $this, 'register_widget_scripts' ] );

            // Register Backend Widget Scripts
            add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'extensions_scripts' ] );

            add_action( 'init', [ $this, 'add_wpml_support' ] );

            $this->init_modules_files();
        }

        /**
         * Load controls require function
         */
        public function controls_area()
        {
            $this->controls_register();
        }

        /**
         * Requires controls files
         */
        private function controls_register()
        {
            foreach ( glob( $this->dir_path . 'controls/' . '*.php' ) as $file ) {
                $this->register_controls_addon( $file );
            }
        }

        /**
         * Register addon by file name.
         */
        public function register_controls_addon( $file_name )
        {
            $controls_manager = Plugin::$instance->controls_manager;

            $base = basename( str_replace( '.php', '', $file_name ) );
            $class = ucwords( str_replace( '-', ' ', $base ) );
            $class = str_replace( ' ', '_', $class );
            $class = sprintf( 'WglAddons\Controls\%s', $class );

            // Class Constructor File
            require_once $file_name;

            if ( class_exists( $class ) ) {
                $controls_manager->register(new $class);
            }
        }

        /**
         * @since 1.0.0
         * @version 1.1.5
         */
        public function widgets_area()
        {
            $this->widgets_register( $folder = 'widgets' );
            $this->widgets_register( $folder = 'header' );
        }

        /**
         * Requires widgets files
         *
         * @since 1.0.0
         * @version 1.1.5
         */
        private function widgets_register( $require_folder, $wpml_translate = false )
        {
            $template_names = [];
            $template_path = '/bighearts-core/elementor/' . $require_folder . '/';
            $plugin_template_path = $this->dir_path . $require_folder . '/';

            foreach ( glob( $plugin_template_path . '*.php' ) as $file ) {
                $template_name = basename( $file );
                array_push( $template_names, $template_name );
            }

            $files = Wgl_Elementor_Helper::get_locate_template(
                $template_names,
                '/' . $require_folder . '/',
                $template_path
            );

            foreach ( (array) $files as $file ) {
                $this->register_widgets_addon( $file, $wpml_translate );
            }
        }

        /**
         * Register widgets by file name
         *
         * @version 1.1.5
         */
        public function register_widgets_addon( $file_name, $wpml_translate = false )
        {
            $widget_manager = Plugin::instance()->widgets_manager;

            $base  = basename( str_replace( '.php', '', $file_name ) );
            $class = ucwords( str_replace( '-', ' ', $base ) );
            $class = str_replace( ' ', '_', $class );
            $class = sprintf( 'WglAddons\Widgets\%s', $class );

            $module_header = $this->header_module_check( $class );

            if ( ! (bool) $module_header ) {
                return;
            }

            if (
                'WglAddons\Widgets\Wgl_Give_Forms' === $class
                && ! class_exists( 'Give' )
            ) {
                return;
            }

            // Class File
            require_once $file_name;

            if ( class_exists( $class ) ) {
                if ( ! $wpml_translate ) {
                    $widget_manager->register( new $class );
                } else {
                    $widget = new $class();
                    if ( method_exists( new $class(), 'wpml_support_module' ) ) {
                        $widget->wpml_support_module();
                    }
                }
            }
        }

        private function header_module_check( $class )
        {
            if (
                'WglAddons\Widgets\Wgl_Header_Cart' === $class
                && ! class_exists('\WooCommerce')
            ) {
                return false;
            }

            if (
                'WglAddons\Widgets\Wgl_Header_Wpml' === $class
                && ! class_exists('\SitePress')
            ) {
                return false;
            }

            return true;
        }



        public function register_widget_scripts()
        {
            wp_register_script(
                'wgl-elementor-extensions-widgets',
                WGL_ELEMENTOR_ADDONS_URL . '/assets/js/wgl_elementor_widgets.js',
                [ 'jquery' ],
                '1.0.0',
                true
            );

            wp_register_script(
                'isotope',
                WGL_ELEMENTOR_ADDONS_URL . 'assets/js/isotope.pkgd.min.js',
                [ 'jquery' ],
                '1.0.0',
                true
            );

            wp_register_script(
                'jquery-appear',
                get_template_directory_uri() . '/js/jquery.appear.js',
                [ 'jquery' ],
                '1.0.0',
                true
            );

	        wp_register_script(
		        'jquery-easypiechart',
		        get_template_directory_uri() . '/js/jquery.easypiechart.min.js',
		        [ 'jquery' ],
		        '1.0.0',
		        true
	        );

            wp_register_script(
                'slick',
                get_template_directory_uri() . '/js/slick.min.js',
                [ 'jquery' ],
                '1.0.0',
                true
            );

            wp_register_script(
                'jarallax',
                get_template_directory_uri() . '/js/jarallax.min.js',
                [ 'jquery' ],
                '1.0.0',
                true
            );

            wp_register_script(
                'jarallax-video',
                get_template_directory_uri() . '/js/jarallax-video.min.js',
                [ 'jquery' ],
                '1.0.0',
                true
            );

            wp_register_script(
                'jquery-countdown',
                get_template_directory_uri() . '/js/jquery.countdown.min.js',
                [ 'jquery' ],
                '1.0.0',
                true
            );

            wp_register_script(
                'cocoen',
                get_template_directory_uri() . '/js/cocoen.min.js',
                [ 'jquery' ],
                '1.0.0',
                true
            );

            wp_register_script(
                'perfect-scrollbar',
                get_template_directory_uri() . '/js/perfect-scrollbar.min.js',
                [ 'jquery' ],
                '1.0.0',
                true
            );

            wp_register_script(
                'jquery-justifiedGallery',
                get_template_directory_uri() . '/js/jquery.justifiedGallery.min.js',
                [ 'jquery' ],
                '1.0.0',
                true
            );
        }

        public function inject_wgl_categories()
        {
            $elements_manager = Plugin::instance()->elements_manager;

            $elements_manager->add_category(
                'wgl-extensions',
                [ 'title' => esc_html__( 'WGL Widgets', 'bighearts-core' ) ]
            );

            $elements_manager->add_category(
                'wgl-header-modules',
                [ 'title' => esc_html__( 'WGL Header Widgets', 'bighearts-core' ) ]
            );
        }

        public function extensions_scripts()
        {
            wp_enqueue_style(
                'bighearts-flaticon',
                get_template_directory_uri() . '/fonts/flaticon/flaticon.css',
                [],
                BigHearts_Globals::get_theme_version()
            );
        }

        public function save_custom_schemes()
        {
            if ( ! class_exists( '\BigHearts_Theme_Helper' ) ) {
                return;
            }

            $schemes_manager = new Schemes_Manager();

            $header_font = BigHearts::get_option('header-font');
            $main_font = BigHearts::get_option('main-font');

            $theme_color = BigHearts::get_mb_option('theme-primary-color', 'mb_page_colors_switch', 'custom');

            $theme_fonts = [
                '1' => [
                    'font_family' => esc_attr($header_font['font-family']),
                    'font_weight' => esc_attr($header_font['font-weight']),
                ],
                '2' => [
                    'font_family' => esc_attr($header_font['font-family']),
                    'font_weight' => '400',
                ],
                '3' => [
                    'font_family' => esc_attr($main_font['font-family']),
                    'font_weight' => esc_attr($main_font['font-weight']),
                ],
                '4' => [
                    'font_family' => esc_attr($main_font['font-family']),
                    'font_weight' => '700',
                ],
            ];

            self::$typography_1 = $theme_fonts[1];
            self::$typography_2 = $theme_fonts[2];
            self::$typography_3 = $theme_fonts[3];
            self::$typography_4 = $theme_fonts[4];

            $scheme_obj_typo = $schemes_manager->get_scheme('typography');

            $theme_color = [
                '1' => esc_attr($theme_color),
                '2' => esc_attr($header_font['color']),
                '3' => esc_attr($main_font['color']),
                '4' => esc_attr($theme_color),
            ];

            $scheme_obj_color = $schemes_manager->get_scheme('color');

            // Save Options
            if($scheme_obj_typo){
                $scheme_obj_typo->save_scheme($theme_fonts);
            }
            if($scheme_obj_color){
                $scheme_obj_color->save_scheme($theme_color);
            }
        }

        public function wgl_widget_args($params)
        {
            // Default wrapper for widget and title
            $id = str_replace( 'wp-', '', $params[ 'widget_id' ] );
            $id = str_replace( '-', '_', $id );

            $wrapper_before = '<div class="wgl-elementor-widget widget bighearts_widget ' . esc_attr($id) . '">';
            $wrapper_after = '</div>';
            $title_before = '<div class="title-wrapper"><span class="title">';
            $title_after = '</span><span class="title__line"></span></div>';

            $default_widget_args = [
                'id' => 'sidebar_' . esc_attr(strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $params['widget_id'])))),
                'before_widget' => $wrapper_before,
                'after_widget' => $wrapper_after,
                'before_title' => $title_before,
                'after_title' => $title_after,
            ];

            return $default_widget_args;
        }

        /**
         * Move WGL Theme Option settings to the Elementor global settings
         */
        public function _v_3_0_0_compatible()
        {
            if (
                defined( 'ELEMENTOR_VERSION' )
                && version_compare( ELEMENTOR_VERSION, '3.0', '>=' )
            ) {
                if ( ! $wgl_option = get_option( 'wgl_system_status' ) ) {
                    $page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers('page');
                    $kit_id = (new \Elementor\Core\Kits\Manager())->get_active_id();

                    $meta_key = \Elementor\Core\Settings\Page\Manager::META_KEY;
                    $kit_settings = get_post_meta( $kit_id, $meta_key, true );

                    $wgl_settings = [];
                    $wgl_settings[ 'container_width' ] = [ 'unit' => 'px', 'size' => '1200' ];

                    $items_color = $this->_get_elementor_settings( 'system_colors' );
                    $items_fonts = $this->_get_elementor_settings( 'system_typography' );

                    $reduxArgs = new Redux;
                    $reduxArgs = $reduxArgs::$args;
                    $keys = array_keys($reduxArgs);
                    $opt_name = $keys[0];
                    $wgl_theme_option = get_option( $opt_name );

                    if (empty($wgl_theme_option)) {
                        return;
                    }

                    $header_font = $wgl_theme_option['header-font'] ?? '';
                    $main_font   = $wgl_theme_option['main-font'] ?? '';
                    $theme_color = BigHearts_Globals::get_primary_color();

                    $items_color[0]['color'] = esc_attr($theme_color);
                    $items_color[1]['color'] = esc_attr($header_font['color']);
                    $items_color[2]['color'] = esc_attr($main_font['color']);
                    $items_color[3]['color'] = esc_attr($theme_color);
                    $wgl_settings['system_colors'] = $items_color;

                    $items_fonts[0]['typography_font_family'] = esc_attr($header_font['font-family']);
                    $items_fonts[0]['typography_font_weight'] = esc_attr($header_font['font-weight']);
                    $items_fonts[1]['typography_font_family'] = esc_attr($header_font['font-family']);
                    $items_fonts[1]['typography_font_weight'] = esc_attr($header_font['font-weight']);
                    $items_fonts[2]['typography_font_family'] = esc_attr($main_font['font-family']);
                    $items_fonts[2]['typography_font_weight'] = esc_attr($main_font['font-weight']);
                    $items_fonts[3]['typography_font_family'] = esc_attr($main_font['font-family']);
                    $items_fonts[3]['typography_font_weight'] = esc_attr($main_font['font-weight']);

                    $wgl_settings['system_typography'] = $items_fonts;
                    update_option( 'elementor_disable_typography_schemes', 'yes' );
                    update_option('wgl_system_status', 'yes');

                    if ( ! $kit_settings ) {
                        update_metadata( 'post', $kit_id, $meta_key, $wgl_settings );
                    } else {
                        $kit_settings = array_merge( $kit_settings, $wgl_settings );
                        $page_settings_manager->save_settings( $kit_settings, $kit_id );
                    }

                    Plugin::$instance->files_manager->clear_cache();
                }
            } elseif (!$wgl_option = get_option('wgl_system_status_old_e')) {
                update_option( 'elementor_disable_typography_schemes', 'yes' );
                update_option('wgl_system_status_old_e', 'yes');
                Plugin::$instance->files_manager->clear_cache();
            }
        }

        public function _get_elementor_settings( $value = 'system_colors' )
        {
            $kit = Plugin::$instance->kits_manager->get_active_kit_for_frontend();

            $system_items = $kit->get_settings_for_display( $value );

            if ( ! $system_items ) {
                $system_items = [];
            }

            return $system_items;
        }

        /**
         * Remove elementor node in the admin bar
         */
        public function remove_admin_bar_node()
        {
            global $wp_admin_bar;

            $wp_admin_bar->remove_node( 'elementor_app_site_editor' );

            if (empty($this->admin_bar_edit_documents)) {
                return;
            }

            foreach ( $this->admin_bar_edit_documents as $document ) {
                $wp_admin_bar->remove_node( 'elementor_edit_doc_' . $document->get_main_id() );
            }
        }

        /**
         * @param Post_CSS $css_file
        */
        public function add_document_to_admin_bar( $css_file )
        {
            $document = Plugin::$instance->documents->get( $css_file->get_post_id() );

            if (
                $document::get_property( 'show_on_admin_bar' )
                && $document->is_editable_by_current_user()
            ) {
                $this->admin_bar_edit_documents[ $document->get_main_id() ] = $document;
            }
        }

        /**
         * Replace elementor node in the admin bar
         */
        public function replace_elementor_admin_bar_title( \WP_Admin_Bar $wp_admin_bar )
        {
            if ( empty( $this->admin_bar_edit_documents ) ) {
                return;
            }

            $queried_object_id = get_queried_object_id();

            if (
                is_singular()
                && isset( $this->admin_bar_edit_documents[ $queried_object_id ] )
            ) {
                $menu_args[ 'href' ] = $this->admin_bar_edit_documents[ $queried_object_id ]->get_edit_url();
                unset( $this->admin_bar_edit_documents[ $queried_object_id ] );
            }

            foreach ( $this->admin_bar_edit_documents as $document ) {
                $title_bar = $document->get_post()->post_type && $document->get_post()->post_type !== 'elementor_library'
                    ? $document->get_post()->post_type
                    : $document::get_title();

                $wp_admin_bar->add_menu( [
                    'id' => 'wgl_elementor_edit_doc_' . $document->get_main_id(),
                    'parent' => 'elementor_edit_page',
                    'title' => sprintf( '<span class="elementor-edit-link-title">%s</span><span class="elementor-edit-link-type">%s</span>', $document->get_post()->post_title, $title_bar ),
                    'href' => $document->get_edit_url(),
                ] );
            }

            if (
                defined( 'ELEMENTOR_VERSION' )
                && version_compare( ELEMENTOR_VERSION, '3.0', '>=' )
            ) {
                $wp_admin_bar->add_menu( [
                    'id' => 'wgl_elementor_app_site_editor',
                    'parent' => 'elementor_edit_page',
                    'title' => esc_html__( 'Open Theme Builder', 'bighearts-core' ),
                    'href' => Plugin::$instance->app->get_settings( 'menu_url' ),
                    'meta' => [ 'class' => 'elementor-app-link' ],
                ] );
            }
        }

        /**
         * Add custom css to the admin bar
         */
        public function admin_bar_style()
        {
            if (
                is_admin_bar_showing()
                && defined( 'ELEMENTOR_VERSION' )
                && version_compare( ELEMENTOR_VERSION, '3.0', '>=' )
            ) {
                $css = '#wpadminbar #wp-admin-bar-wgl_elementor_app_site_editor a.ab-item:before {'
                        . 'content: "\e91d";'
                        . 'font-family: eicons;'
                        . 'top: 4px;'
                        . 'font-size: 13px;'
                        . 'color: inherit;'
                    . '}';

                $css .= '#wpadminbar #wp-admin-bar-wgl_elementor_app_site_editor a.ab-item:hover {'
                        . 'background: #4ab7f4;'
                        . 'color: #fff'
                    . '}';

                $css .= '#wpadminbar #wp-admin-bar-wgl_elementor_app_site_editor a.ab-item:hover:before {'
                        . 'color: #fff'
                    . '}';

                wp_add_inline_style( 'elementor-frontend', $css );
            }
        }

        public function add_builder_to_admin_bar( Document $document, $is_excerpt )
        {
            if (
                $is_excerpt
                || ! $document::get_property( 'show_on_admin_bar' )
                || ! $document->is_editable_by_current_user()
            ) {
                return;
            }

            $this->documents[ $document->get_main_id() ] = $document;
        }

        public function add_menu_in_admin_bar( $admin_bar_config )
        {
            if (empty($this->documents)) {
                return;
            }

            $_key = array_keys($this->documents);
            foreach ( $_key as $condition ) {
                unset($admin_bar_config['elementor_edit_page']['children'][$condition]);
            }

            $queried_object_id = get_queried_object_id();
            if ( is_singular() && isset( $this->documents[ $queried_object_id ] ) ) {
                unset( $this->documents[ $queried_object_id ] );
            }

            $admin_bar_config['elementor_edit_page']['children'] = array_map( function ( $document ) {
                return [
                    'id' => "wgl_elementor_edit_doc_{$document->get_main_id()}",
                    'title' => $document->get_post()->post_title,
                    'sub_title' => $document->get_post()->post_type && $document->get_post()->post_type !== 'elementor_library'
                        ? $document->get_post()->post_type
                        : $document::get_title(),
                    'href' => $document->get_edit_url(),
                ];
            }, $this->documents );

            return $admin_bar_config;
        }

        public function modify_page_structure_for_saved_templates($template)
        {
            if (
                'elementor_library' === get_post_type()
                && ($documents = Plugin::$instance->documents)
            ) {
                $current_doc = $documents->get(get_the_ID());

                if (
                    is_a($current_doc, 'Elementor\Modules\Library\Documents\Page')
                    || is_a($current_doc, 'Elementor\Modules\Library\Documents\Section')
                    || is_a($current_doc, 'ElementorPro\Modules\ThemeBuilder\Documents\Section')
                ) {
                    $elementor_templates = Plugin::$instance->modules_manager->get_modules('page-templates');
                    $elementor_template_path = $elementor_templates->get_template_path($elementor_templates::TEMPLATE_HEADER_FOOTER);

                    $template = $elementor_template_path ?: get_page_template(); // prevent rendering through `single.php`
                }
            }

            return $template;
        }

        /**
         * @since 1.1.5
         */
        public function add_wpml_support()
        {
            if ( class_exists( '\SitePress' ) ) {
                $this->widgets_register( 'widgets', true );
                $this->widgets_register( 'header', true );
            }
        }

        /**
         * Creates and returns an instance of the class
         *
         * @return object
         */
        public static function get_instance()
        {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self;
            }

            return self::$instance;
        }
    }
}

if ( ! function_exists( 'wgl_addons_elementor' ) ) {
    function wgl_addons_elementor()
    {
        return Wgl_Addons_Elementor::get_instance();
    }
}

wgl_addons_elementor();
