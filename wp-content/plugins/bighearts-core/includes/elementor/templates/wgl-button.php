<?php
/**
 * This template can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/templates/wgl-button.php`.
 */
namespace WglAddons\Templates;

defined('ABSPATH') || exit; // Abort, if called directly.

use WglAddons\Includes\Wgl_Icons;

if (!class_exists('WGL_Button')) {
    /**
     * WGL Elementor Button Template
     *
     *
     * @package bighearts-core\includes\elementor
     * @author WebGeniusLab <webgeniuslab@gmail.com>
     * @since 1.0.0
     */
    class WGL_Button
    {
        private static $instance;

        public static function get_instance()
        {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        public function render($self, $settings)
        {
            $self->add_render_attribute([
                'wrapper' => [
                    'class' => 'button-wrapper',
                ],
                'button' => [
                    'class' => [
                        'wgl-button',
                        !empty($settings['size']) ? 'btn-size-' . $settings['size'] : '',
                        !empty($settings['hover_animation']) ? 'elementor-animation-' . $settings['hover_animation'] : '',
                    ],
                    'role' => 'button',
                ],
                'content-wrapper' => [
                    'class' => [
                        'button-content-wrapper',
                        !empty($settings['icon_align']) ? 'align-icon-' . $settings['icon_align'] : '',
                    ],
                ],
                'text' => [
                    'class' => 'wgl-button-text',
                ],
            ] );

            if (!empty($settings['link']['url'])) {
                $self->add_link_attributes('button', $settings['link']);
            }

            // Render
            echo '<div ', $self->get_render_attribute_string('wrapper'), '>';
            echo '<a  ', $self->get_render_attribute_string('button'), '>';
            if (!empty($settings['text']) || !empty($settings['icon_type'])) {
                echo '<div ', $self->get_render_attribute_string('content-wrapper'), '>';

                if (!empty($settings['icon_type'])) {
                    $icons = new Wgl_Icons;
                    $button_icon_out = $icons->build($self, $settings, []);
                    echo $button_icon_out;
                }
                echo '<span ', $self->get_render_attribute_string('text'), '>',
                    $settings['text'],
                '</span>';

                echo '</div>';
            }
            echo '</a>';
            echo '</div>';
        }
    }
}
