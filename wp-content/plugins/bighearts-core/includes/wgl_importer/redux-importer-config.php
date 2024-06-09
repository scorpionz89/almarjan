<?php

if (!function_exists('wgl_extended_example')) {
    /**
     * Add menu and rev slider to demo content.
     * Set defaults settings.
     *
     * @package     wgl_Importer - Extension for Importing demo content
     * @author      Webcreations907
     * @version     1.0
     */
    function wgl_extended_example($demo_active_import, $demo_directory_path)
    {
        
        reset($demo_active_import);
        $current_key = key($demo_active_import);

        /**
         * Slider(s) Import
         */
        if (class_exists('RevSlider')) {
            $slider_array = [
                // Set sliders zip name
                'full' => [
                    '1' => 'home-1.zip',
                    '2' => 'home-2.zip',
                    '3' => 'home-3.zip',
                    '4' => 'home-4.zip',
                    '5' => 'home-5.zip',
                    '6' => 'home-6.zip',
                    '7' => 'home-7.zip',
                    '8' => 'home-9.zip',
                    '9' => 'home-10.zip',
                    '10' =>'landing.zip',
                ]
            ];
            if (
                !empty($demo_active_import[$current_key]['directory'])
                && array_key_exists($demo_active_import[$current_key]['directory'], $slider_array)
            ) {
                $slider_import = $slider_array[$demo_active_import[$current_key]['directory']];
                if (is_array($slider_import)) {
                    foreach ($slider_import as $value) {
                        if (file_exists($demo_directory_path . $value)) {
                            (new RevSlider())->importSliderFromPost(true, true, $demo_directory_path . $value);
                        }
                    }
                } elseif (file_exists($demo_directory_path . $slider_import)) {
                    (new RevSlider())->importSliderFromPost(true, true, $demo_directory_path . $slider_import);
                }
            }
        }

        /**
         * Menu(s)
         */

        // Set menu name
        $menu_array = [
            'full' => 'main'
        ];

        if (
            !empty($demo_active_import[$current_key]['directory'])
            && array_key_exists($demo_active_import[$current_key]['directory'], $menu_array)
        ) {
            $top_menu = get_term_by('name', $menu_array[$demo_active_import[$current_key]['directory']], 'nav_menu');
            if (isset($top_menu->term_id)) {
                set_theme_mod('nav_menu_locations', ['main_menu' => $top_menu->term_id]);
            }
        }


        /**
         * Home Page(s)
         */

        // Array of `demos => homepages` to select from
        $home_pages = [
            'full' => 'Home',
        ];

        if (
            !empty($demo_active_import[$current_key]['directory'])
            && array_key_exists($demo_active_import[$current_key]['directory'], $home_pages)
        ) {
            $query =  new WP_Query(
                array(
                   'post_type'              => 'page',
                   'title'                  => $home_pages[$demo_active_import[$current_key]['directory']],
                   'posts_per_page'         => 1,
                   'no_found_rows'          => true,
                   'ignore_sticky_posts'    => true,
                   'update_post_term_cache' => false,
                   'update_post_meta_cache' => false,
                )
             );
            $page = $query->posts[0];
            if (isset($page->ID)) {
                update_option('page_on_front', $page->ID);
                update_option('show_on_front', 'page');
            }
        }


        /**
         * Elementor defaults
         */

        // Support all Custom Post Types
        $cpt_support = get_option('elementor_cpt_support');
        if (!$cpt_support) {
            $cpt_support = ['page', 'post', 'portfolio', 'team', 'footer', 'side_panel', 'header', 'give_forms'];
            update_option('elementor_cpt_support', $cpt_support);
        } else {
            $include_cpt = ['portfolio', 'team', 'footer', 'side_panel', 'header', 'give_forms'];
            foreach ($include_cpt as $cpt) {
                if (!in_array($cpt, $cpt_support)) {
                    $cpt_support[] = $cpt;
                }
            }
            update_option('elementor_cpt_support', $cpt_support);
        }
        update_option('elementor_container_width', 1170);

        update_option('elementor_experiment-e_optimized_css_loading', 'inactive');
        // Font Awesome Styles
        update_option('elementor_load_fa4_shim', 'yes');

        global $wgl_elementor_page_settings;
        global $wpdb;
        if(!empty($GLOBALS['wgl_elementor_page_settings'])){
            $like = '%'.$GLOBALS['wgl_elementor_page_settings'].'%';
            $result = $wpdb->get_row($wpdb->prepare("SELECT post_id FROM {$wpdb->prefix}postmeta WHERE meta_key='_elementor_page_settings' AND meta_value LIKE %s", $like), ARRAY_N);
            if (!empty($result)) {
                if (
                    defined('ELEMENTOR_VERSION')
                    && version_compare(ELEMENTOR_VERSION, '3.0', '>=')
                ) {
                    if(isset($result[0])){
                        update_option( 'elementor_active_kit', $result[0] );
                        update_option( 'elementor_active_full_import', 'yes' );
                        update_option('wbc_imported_demos', 'yes');
                        \Elementor\Plugin::$instance->files_manager->clear_cache();
                    }
                }
            }
            unset($GLOBALS['wgl_elementor_page_settings']);
        }

        /**
         * Give-WP plugin
         */

        if (class_exists('Give')) {
            // The number of decimal points displayed in amounts.
            give_update_option('number_decimals', 0);
            // Enable Categories for all GiveWP forms.
            give_update_option('categories', 'enabled');
            // Enable Tags for all GiveWP forms.
            give_update_option('tags', 'enabled');
        }
        // Permalink Structure
        update_option('permalink_structure', "/%postname%/");
    }

    add_action('wgl_importer_after_content_import', 'wgl_extended_example', 10, 2);

    function wgl_default_kits_init($atts)
    {
        if (!get_option('elementor_active_full_import') || !get_option( 'wbc_imported_demos')) {
            $kit_id = (new \Elementor\Core\Kits\Manager())->get_active_id();

            if(!$kit_id){
                return;
            }            
            
            $page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers('page');
    
            $meta_key = \Elementor\Core\Settings\Page\Manager::META_KEY;
            $kit_settings = get_post_meta($kit_id, $meta_key, true);
    
            $wgl_settings = [];

            $settings = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend();

            $system_items = $settings->get_settings_for_display('system_colors');            
            
            if (!$system_items) {
                $system_items = [];
            }

            $system_items[0]['color'] = '#F74F22';
            $system_items[1]['color'] = '#FFAC00';
            $system_items[2]['color'] = '#616161';
            $system_items[3]['color'] = '';
            $system_items[4]['color'] = '#6EC1E4';
            $system_items[5]['color'] = '#54595F';
            $system_items[6]['color'] = '#54595F';
            $system_items[7]['color'] = '#7A7A7A';
            $system_items[8]['color'] = '#61CE70';
            $system_items[9]['color'] = '#4054B2';
            $system_items[10]['color'] = '#23A455';
            $system_items[11]['color'] = '#232323';
            $system_items[12]['color'] = '#FFFFFF';
            $system_items[13]['color'] = '#FD853E';
            $system_items[14]['color'] = '#1DACF4';
            $system_items[15]['color'] = '#40D792';
            $system_items[16]['color'] = '#51C147';
            $system_items[17]['color'] = '#049013';
            $system_items[18]['color'] = '#049013';
            $system_items[19]['color'] = '#FFAC00';
            $system_items[20]['color'] = '#F43442';
            $system_items[21]['color'] = '#EE545F';
            $system_items[22]['color'] = '#C88D5A';
            $system_items[23]['color'] = '#AE7B50';
            $system_items[24]['color'] = '#543FD7';
            $system_items[25]['color'] = '#7D89F8';
            $system_items[26]['color'] = '#C3C3C3';
    
            $wgl_settings['system_colors'] = $system_items;
            
            if (!$kit_settings) {
                update_metadata('post', $kit_id, $meta_key, $wgl_settings);
            } else {
                $kit_settings = array_merge($kit_settings, $wgl_settings);
                $page_settings_manager->save_settings($kit_settings, $kit_id);
            }
            update_option( 'elementor_active_full_import', 'yes' );
    
            \Elementor\Plugin::$instance->files_manager->clear_cache();
        }
    }
    
    add_action('wgl_importer_elementor_default_kit', 'wgl_default_kits_init' ,10);
}

