<?php
namespace WglAddons\Widgets;

defined('ABSPATH') || exit; // Abort, If called directly.

use Elementor\{
    Widget_Base,
    Controls_Manager
};

/**
 * WPML widget for Header CPT
 *
 *
 * @package bighearts-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 */
class Wgl_Header_Wpml extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-header-wpml';
    }

    public function get_title()
    {
        return esc_html__('WPML Selector', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-header-wpml';
    }

    public function get_categories()
    {
        return ['wgl-header-modules'];
    }

    public function get_script_depends()
    {
        return [
            'perfect-scrollbar',
            'wgl-elementor-extensions-widgets',
        ];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_navigation_settings',
            [
                'label' => esc_html__( 'WPML Settings', 'bighearts-core' ),
            ]
        );

        $this->add_control(
            'wpml_height',
            array(
                'label' => esc_html__( 'WPML Height', 'bighearts-core' ),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'min' => 0,
                'step' => 1,
                'default' => 100,
                'description' => esc_html__( 'Enter value in pixels', 'bighearts-core' ),
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .sitepress_container' => 'height: {{VALUE}}px;',
                ],
            )
        );

        $this->add_control(
            'wpml_align',
            array(
                'label' => esc_html__( 'Alignment', 'bighearts-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'bighearts-core' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'bighearts-core' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'bighearts-core' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'label_block' => false,
                'default' => 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .sitepress_container' => 'text-align: {{VALUE}};',
                ],
            )
        );

        $this->end_controls_section();
    }

    public function render(){
        if (class_exists('\SitePress')) {
            echo "<div class='sitepress_container'>";
                do_action('wpml_add_language_selector');
            echo "</div>";
        }
    }
}