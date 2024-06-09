<?php

namespace WglAddons\Includes;

defined('ABSPATH') || exit;

use Elementor\Plugin;

if (!class_exists('Wgl_Elementor_Helper')) {
    /**
     * Wgl Elementor Helper Settings
     *
     *
     * @package bighearts-core\includes\elementor
     * @author WebGeniusLab <webgeniuslab@gmail.com>
     * @since 1.0.0
     */
    class Wgl_Elementor_Helper
    {
        private static $instance;

        public static function get_instance()
        {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        public function get_wgl_icons()
        {
            return [
                'energy',
                'forest',
                'bin',
                'sea-waves',
                'food',
                'horse',
                'medical',
                'broken-link',
                'love-and-romance',
                'interface',
                'light',
                'business',
                'business-1',
                'shapes-and-symbols',
                'shapes-and-symbols-1',
                'null',
                'multimedia',
                'null-1',
                'null-2',
                'null-3',
                'null-4',
                'bell',
                'ruler',
                'gift',
                'vegetable',
                'checked',
                'youtube',
                'right-arrow',
                'left-arrow',
                'paper-plane',
                'plus',
                'plus-1',
                'check',
                'mortarboard',
                'healthy-food',
                'dumbbell',
                'heart',
                'edit',
                'email',
                'user',
                'wall-clock',
                'folder',
                'worldwide',
                'shopping-bag',
                'book',
                'fitness',
                'maternity',
                'water-bottle',
                'add',
                'right-quote',
                'link',
                'healthcare',
                'play',
                'basket',
                'loupe',
                'left-quote',
                'right-quote-1',
                'target',
                'package',
                'management',
                'startup',
                'bar-chart',
                'play-button',
                'call',
                'pin',
                'like',
                'like-1',
                'physics',
                'diamond',
                'idea',
                'user-1',
                'tick',
                'supermarket-gift',
                'right-arrow-1',
                'left-arrow-1',
                'menu',
                'right-arrow-2',
                'dollar-sign-symbol-bold-text',
                'quote-left',
                'copy',
                'quote',
                'shield',
                'bell-1',
                'tag',
                'document',
                'search',
                'star',
                'trash',
                'filter',
                'photograph',
                'supermarket',
                'lock',
                'chat',
                'key',
                'target-1',
                'portfolio',
                'document-1',
            ];
        }

        public static function enqueue_css($style)
        {
            if (!(bool) Plugin::$instance->editor->is_edit_mode()) {
                if (!empty($style)) {
                    ob_start();
                        echo $style;
                    $css = ob_get_clean();
                    $css = apply_filters('bighearts/extra_css', $css, $style);

                    return $css;
                }
            } else {
                echo '<style>', esc_attr($style), '</style>';
            }
        }

        public function get_elementor_templates()
        {
            $templates = get_posts([
                'post_type' => 'elementor_library',
                'posts_per_page' => -1,
            ]);

            if (!empty($templates) && !is_wp_error($templates)) {

                foreach ($templates as $template) {
                    $options[$template->ID] = $template->post_title;
                }

                update_option('temp_count', $options);

                return $options ?? [];
            }
        }

        /**
         * Retrieve image dimensions based on passed arguments.
         *
         * @param array|string $desired_dimensions  Required. Desired dimensions. Ex: `700x300`, `[700, 300]`, `['width' => 700, 'height' => 300]`
         * @param string       $aspect_ratio        Required. Desired ratio. Ex: `16:9`
         * @param array        $img_data            Optional. Result of `wp_get_attachment_image_src` function.
         */
        public static function get_image_dimensions(
            $desired_dimensions,
            String $aspect_ratio,
            Array $img_data = []
        ) {
            if (
                is_array( $desired_dimensions ) && ! $desired_dimensions[ 'width' ]
                || ! $desired_dimensions
            ) {
                // Bailout, if the required parameters are not provided.
                return;
            }

            if ($aspect_ratio) {
                $ratio_arr = explode(':', $aspect_ratio);
                $ratio = round($ratio_arr[0] / $ratio_arr[1], 4);
            }

            if ('full' === $desired_dimensions) {
                $attachemnt_data = $img_data ?: wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');

                if (!$attachemnt_data) {
                    // Bailout, if no featured image
                    return;
                }

                return [
                    'width' => $attachemnt_data[1],
                    'height' => isset($ratio) ? round((int) $attachemnt_data[1] / $ratio) : $attachemnt_data[2]
                ];
            }

            if (is_array($desired_dimensions)) {
                $desired_width = $desired_dimensions['width'];
                $desired_height = $desired_dimensions['height'];
            } else {
                $dims = explode('x', $desired_dimensions);
                $desired_width = $dims[0];
                $desired_height = !empty($dims[1]) ? $dims[1] : $dims[0];
            }

            return [
                'width' => (int) $desired_width,
                'height' => isset($ratio) ? round($desired_width / $ratio) : (int) $desired_height
            ];
        }

        /**
         * Retrieve the name of the highest priority template file that exists.
         *
         * @param string|array $template_names Template file(s) to search for, in order.
         * @param string       $origin_path    Template file(s) origin path. (../bighearts-core/includes/elementor)
         * @param string       $override_path  New template file(s) override path. (../bighearts)
         *
         * @return string The template filename if one is located.
         */
        public static function get_locate_template(
            $template_names,
            $origin_path,
            $override_path
        ) {
            $files = [];
            $file = '';
            foreach ((array)$template_names as $template_name) {
                if (file_exists(get_stylesheet_directory() . $override_path . $template_name)) {
                    $file = get_stylesheet_directory() . $override_path . $template_name;
                } elseif (file_exists(get_template_directory() . $override_path . $template_name)) {
                    $file = get_template_directory() . $override_path . $template_name;
                } elseif (file_exists(realpath(__DIR__ . '/..') . $origin_path . $template_name)) {
                    $file = realpath(__DIR__ . '/..') . $origin_path . $template_name;
                }
                array_push($files, $file);
            }
            return $files;
        }
    }

    new Wgl_Elementor_Helper;
}
