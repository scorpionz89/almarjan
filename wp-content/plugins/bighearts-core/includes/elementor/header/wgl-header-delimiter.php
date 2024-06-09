<?php
namespace WglAddons\Widgets;

defined('ABSPATH') || exit; // Abort, If called directly.

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Group_Control_Background
};

/**
 * Delimiter widget for Header CPT
 *
 *
 * @package bighearts-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 */
class Wgl_Header_Delimiter extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-header-delimiter';
    }

    public function get_title()
    {
        return esc_html__('WGL Delimiter', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-header-delimiter';
    }

    public function get_categories()
    {
        return ['wgl-header-modules'];
    }

    public function get_script_depends()
    {
        return ['wgl-elementor-extensions-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_content_general',
            ['label' => esc_html__('General', 'bighearts-core')]
        );

        $this->add_control(
            'delimiter_height',
            [
                'label' => esc_html__('Delimiter Height', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'separator' => 'before',
                'min' => 0,
                'default' => 50,
                'selectors' => [
                    '{{WRAPPER}} .delimiter' => 'height: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'delimiter_width',
            [
                'label' => esc_html__('Delimiter Width', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'description' => esc_html__('Values in pixels', 'bighearts-core'),
                'min' => 0,
                'default' => 1,
                'selectors' => [
                    '{{WRAPPER}} .delimiter' => 'width: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'delimiter_align',
            [
                'label' => esc_html__( 'Alignment', 'bighearts-core' ),
                'type' => Controls_Manager::CHOOSE,
                'separator' => 'after',
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .delimiter-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'delimiter_background',
                'label' => esc_html__('Background', 'bighearts-core'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .delimiter-wrapper .delimiter',
            ]
        );

        $this->add_control(
            'delimiter_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .delimiter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function render()
    {
        echo '<div class="delimiter-wrapper">',
            '<div class="delimiter">',
            '</div>',
            '</div>';
    }
}
