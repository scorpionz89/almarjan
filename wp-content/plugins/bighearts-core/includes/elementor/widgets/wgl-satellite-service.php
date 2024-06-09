<?php
/**
 * This template can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/widgets/wgl-satellite-service.php`.
 */
namespace WglAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Group_Control_Border,
    Group_Control_Typography,
    Group_Control_Box_Shadow,
    Group_Control_Background
};
use WglAddons\{
    BigHearts_Global_Variables as BigHearts_Globals,
    Includes\Wgl_Icons
};

class Wgl_Satellite_Service extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-satellite-service';
    }

    public function get_title()
    {
        return esc_html__('WGL Satellite Service', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-services-sat';
    }

    public function get_categories()
    {
        return ['wgl-extensions'];
    }

    protected function register_controls()
    {
        /*-----------------------------------------------------------------------------------*/
        /*  Build Icon/Image Box
        /*-----------------------------------------------------------------------------------*/

        $output['media_width'] = [
            'label' => esc_html__('Media Width (Height)', 'bighearts-core'),
            'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
            'condition' => ['icon_type!' => ''],
            'separator' => 'before',
            'min' => 50,
            'step' => 1,
            'default' => 110,
            'selectors' => [
                '{{WRAPPER}} .wgl-services_media-wrap' => 'width: {{VALUE}}px; height: {{VALUE}}px; line-height: {{VALUE}}px;',
            ],
        ];

        Wgl_Icons::init(
            $this,
            [
                'output' => $output,
                'section' => true,
            ]
        );

        /*-----------------------------------------------------------------------------------*/
        /*  Content
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'wgl_ib_content',
            ['label' => esc_html__('Service Content', 'bighearts-core')]
        );

        $this->add_control(
            'ib_title',
            [
                'label' => esc_html__('Title', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
                'default' => esc_html__('This is the heading​', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'ib_content',
            [
                'label' => esc_html__('Service Text', 'bighearts-core'),
                'type' => Controls_Manager::WYSIWYG,
			    'dynamic' => [  'active' => true],
				'placeholder' => esc_attr__('Description Text', 'bighearts-core'),
				'label_block' => true,
                'default' => esc_html__('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'alignment',
            [
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
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_wrap' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_link',
            ['label' => esc_html__('Service Link', 'bighearts-core') ]
        );

        $this->add_control(
            'add_item_link',
            [
                'label' => esc_html__('Add Link To Whole Item', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
                'condition' => ['add_read_more!' => 'yes'],
            ]
        );

        $this->add_control(
            'item_link',
            [
                'label' => esc_html__('Link', 'bighearts-core'),
                'type' => Controls_Manager::URL,
			    'dynamic' => [  'active' => true],
                'condition' => ['add_item_link' => 'yes'],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'add_read_more',
            [
                'label' => esc_html__('Add \'Read More\' Button', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['add_item_link!' => 'yes'],
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => esc_html__('Button Text', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'condition' => ['add_read_more' => 'yes'],
                'default' =>  esc_html__('Read More', 'bighearts-core'),
				'label_block' => true,
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Button Link', 'bighearts-core'),
                'type' => Controls_Manager::URL,
			    'dynamic' => [  'active' => true],
                'condition' => ['add_read_more' => 'yes'],
                'label_block' => true,
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  Style Section
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Media', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs(
            'icon_colors',
            [
                'condition' => ['icon_type' => 'font'],
            ]
        );

        $this->start_controls_tab(
            'icon_colors_idle',
            [
                'label' => esc_html__('Idle', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'primary_color',
            [
                'label' => esc_html__('Primary Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'icon_colors_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'hover_primary_color',
            [
                'label' => esc_html__('Primary Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}}:hover .wgl-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'icon_space',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_media-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Size', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'condition' => ['icon_type' => 'font'],
                'range' => [
                    'px' => ['min' => 16, 'max' => 100 ],
                ],
                'default' => ['size' => 45, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_size',
            [
                'label' => esc_html__('Width', 'bighearts-core') . ' (%)',
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'condition' => ['icon_type' => 'image'],
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => 50, 'max' => 800 ],
                    '%' => ['min' => 5, 'max' => 100 ],
                ],
                'default' => ['size' => 100, 'unit' => '%'],
                'tablet_default' => ['unit' => '%'],
                'mobile_default' => ['unit' => '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-image-box_img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'border_width',
            [
                'label' => esc_html__('Border Width', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'default' => [
                    'top' => 1,
                    'right' => 1,
                    'bottom'=> 1,
                    'left' => 1,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_media-wrap' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'border_type',
            [
                'label' => esc_html__('Border Type', 'Border Control', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'solid' => esc_html__('Solid', 'Border Control', 'bighearts-core'),
                    'double' => esc_html__('Double', 'Border Control', 'bighearts-core'),
                    'dotted' => esc_html__('Dotted', 'Border Control', 'bighearts-core'),
                    'dashed' => esc_html__('Dashed', 'Border Control', 'bighearts-core'),
                    'groove' => esc_html__('Groove', 'Border Control', 'bighearts-core'),
                ],
                'default' => 'dashed',
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_media-wrap' => 'border-style: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs('border_colors');

        $this->start_controls_tab(
            'border_colors_idle',
            [
                'label' => esc_html__('Idle', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'border_primary_color',
            [
                'label' => esc_html__('Border Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_media-wrap' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'border_colors_hover',
            [
                'label' => esc_html__('Hover', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'border_hover_primary_color',
            [
                'label' => esc_html__('Border Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}}:hover .wgl-services_media-wrap' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'circle_width',
            [
                'label' => esc_html__('Circles Width(Height)', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'min' => 2,
                'step' => 1,
                'default' => 8,
                'description' => esc_html__('Enter value in pixels', 'bighearts-core'),
                'condition' => ['icon_type!' => ''],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_circle' => 'width: {{VALUE}}px; height: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'circle_color_1',
            [
                'label' => esc_html__('First Circle Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_circle-wrapper:nth-child(1) .wgl-services_circle' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'circle_color_2',
            [
                'label' => esc_html__('Second Circle Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_circle-wrapper:nth-child(2) .wgl-services_circle' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> TITLE
         */

        $this->start_controls_section(
            'title_style_section',
            [
                'label' => esc_html__('Title', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__('HTML Tag', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => esc_html__('‹h1›', 'bighearts-core'),
                    'h2' => esc_html__('‹h2›', 'bighearts-core'),
                    'h3' => esc_html__('‹h3›', 'bighearts-core'),
                    'h4' => esc_html__('‹h4›', 'bighearts-core'),
                    'h5' => esc_html__('‹h5›', 'bighearts-core'),
                    'h6' => esc_html__('‹h6›', 'bighearts-core'),
                    'div' => esc_html__('‹div›', 'bighearts-core'),
                    'span' => esc_html__('‹span›', 'bighearts-core'),
                ],
                'default' => 'h3',
            ]
        );

        $this->add_responsive_control(
            'title_offset',
            [
                'label' => esc_html__('Title Offset', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 15,
                    'right' => 0,
                    'bottom' => 10,
                    'left' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_title',
                'selector' => '{{WRAPPER}} .wgl-services_title',
            ]
        );

        $this->start_controls_tabs('title_color_tab');

        $this->start_controls_tab(
            'custom_title_color_idle',
            ['label' => esc_html__('Idle' , 'bighearts-core')]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_title_color_hover',
            ['label' => esc_html__('Hover' , 'bighearts-core')]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => esc_attr(BigHearts_Globals::get_h_font_color()),
                'selectors' => [
                    '{{WRAPPER}}:hover .wgl-services_title,
                     {{WRAPPER}}:hover .wgl-services_title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'content_style_section',
            [
                'label' => esc_html__('Content', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_tag',
            [
                'label' => esc_html__('HTML Tag', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => esc_html__('‹h1›', 'bighearts-core'),
                    'h2' => esc_html__('‹h2›', 'bighearts-core'),
                    'h3' => esc_html__('‹h3›', 'bighearts-core'),
                    'h4' => esc_html__('‹h4›', 'bighearts-core'),
                    'h5' => esc_html__('‹h5›', 'bighearts-core'),
                    'h6' => esc_html__('‹h6›', 'bighearts-core'),
                    'div' => esc_html__('‹div›', 'bighearts-core'),
                    'span' => esc_html__('‹span›', 'bighearts-core'),
                ],
                'default' => 'div',
            ]
        );

        $this->add_responsive_control(
            'content_offset',
            [
                'label' => esc_html__('Content Offset', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom'=> 20,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Content Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'custom_content_mask_color',
                'label' => esc_html__('Background', 'bighearts-core'),
                'types' => ['classic', 'gradient'],
                'condition' => ['custom_bg' => 'custom'],
                'selector' => '{{WRAPPER}} .wgl-services_text',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_content',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_family' => ['default' => \Wgl_Addons_Elementor::$typography_3['font_family']],
                    'font_weight' => ['default' => \Wgl_Addons_Elementor::$typography_3['font_weight']],
                ],
                'selector' => '{{WRAPPER}} .wgl-services_text',
            ]
        );

        $this->start_controls_tabs('content_color_tab');

        $this->start_controls_tab(
            'custom_content_color_idle',
            ['label' => esc_html__('Idle' , 'bighearts-core')]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_main_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_content_color_hover',
            [
                'label' => esc_html__('Hover' , 'bighearts-core'),
            ]
        );

        $this->add_control(
            'content_color_hover',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_main_font_color(),
                'selectors' => [
                    '{{WRAPPER}}:hover .wgl-services_text' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        $this->start_controls_section(
            'button_style_section',
            [
                'label' => esc_html__('Button', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'add_read_more!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_button',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_family' => ['default' => \Wgl_Addons_Elementor::$typography_1['font_family']],
                    'font_weight' => ['default' => \Wgl_Addons_Elementor::$typography_1['font_weight']],
                ],
                'selector' => '{{WRAPPER}} .wgl-services_readmore',
            ]
        );

        $this->add_responsive_control(
            'custom_button_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_readmore' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'custom_button_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_readmore' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'custom_button_border',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_readmore' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->start_controls_tabs('button_color_tab');

        $this->start_controls_tab(
            'custom_button_color_idle',
            ['label' => esc_html__('Idle' , 'bighearts-core')]
        );

        $this->add_control(
            'button_background',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_readmore' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_readmore' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'label' => esc_html__('Border Type', 'bighearts-core'),
                'selector' => '{{WRAPPER}} .wgl-services_readmore',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow',
                'selectors' => '{{WRAPPER}} .wgl-services_readmore',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_button_color_hover',
            ['label' => esc_html__('Hover' , 'bighearts-core')]
        );

        $this->add_control(
            'button_background_hover',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_readmore:hover' => 'background: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'button_color_hover',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => esc_attr(BigHearts_Globals::get_secondary_color()),
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_readmore:hover' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border_hover',
                'label' => esc_html__('Border Type', 'bighearts-core'),
                'selector' => '{{WRAPPER}} .wgl-services_readmore:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow_hover',
                'selector' => '{{WRAPPER}} .wgl-services_readmore:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'service_2_style_section',
            [
                'label' => esc_html__('Item', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'service_2_offset',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'service_2_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'service_2_border_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('service_2_color_tab');

        $this->start_controls_tab(
            'custom_service_2_color_idle',
            ['label' => esc_html__('Idle' , 'bighearts-core')]
        );

        $this->add_control(
            'bg_service_2_color',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_wrap' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'service_2_border',
                'label' => esc_html__('Border Type', 'bighearts-core'),
                'selector' => '{{WRAPPER}} .wgl-services_wrap',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'service_2_shadow',
                'selector' => '{{WRAPPER}} .wgl-services_wrap',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_service_2_color_hover',
            ['label' => esc_html__('Hover' , 'bighearts-core')]
        );

        $this->add_control(
            'bg_service_2_color_hover',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}}:hover .wgl-services_wrap' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'service_2_border_hover',
                'label' => esc_html__('Border Type', 'bighearts-core'),
                'selector' => '{{WRAPPER}}:hover .wgl-services_wrap',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'service_2_shadow_hover',
                'selector' => '{{WRAPPER}}:hover .wgl-services_wrap',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

    }

    public function render()
    {
        $_s = $this->get_settings_for_display();
        $circle_w = $_s['media_width'];

        $this->add_render_attribute('services', 'class', 'wgl-service-sat');

        $this->add_render_attribute('circle_wrap', [
			'class' => [
                'wgl-services_circle-wrapper',
            ],
            'style' => [
                'width: '.(round($circle_w/sqrt(2))).'px;',
                'height: '.(round($circle_w/sqrt(2))).'px;',
                'left: '.(($circle_w - round($circle_w/sqrt(2)))/2).'px;',
                'top: '.(($circle_w - round($circle_w/sqrt(2)))/2).'px;',
            ]
        ]);

        $this->add_render_attribute('serv_link', 'class', 'wgl-services_readmore');
        if (!empty($_s['link']['url'])) $this->add_link_attributes('serv_link', $_s['link']);

        $this->add_render_attribute('item_link', 'class', 'wgl-services_item-link');
        if (!empty($_s['item_link']['url'])) $this->add_link_attributes('item_link', $_s['item_link']);

        $kses_allowed_html = [
            'a' => [
                'id' => true, 'class' => true, 'style' => true,
                'href' => true, 'title' => true,
                'rel' => true, 'target' => true,
            ],
            'br' => ['id' => true, 'class' => true, 'style' => true],
            'em' => ['id' => true, 'class' => true, 'style' => true],
            'strong' => ['id' => true, 'class' => true, 'style' => true],
            'span' => ['id' => true, 'class' => true, 'style' => true],
            'p' => ['id' => true, 'class' => true, 'style' => true],
        ];

        // Icon/Image output
        ob_start();
        if (!empty($_s['icon_type'])) {
            $icons = new Wgl_Icons;
            echo $icons->build($this, $_s, []);
        }
        $services_media = ob_get_clean();

        ?>
        <div <?php echo $this->get_render_attribute_string('services'); ?>>
            <div class="wgl-services_wrap"><?php
                if ($_s['icon_type'] != '') {?>
                <div class="wgl-services_media-wrap">
                    <div <?php echo $this->get_render_attribute_string('circle_wrap'); ?>><div class="wgl-services_circle"></div></div>
                    <div <?php echo $this->get_render_attribute_string('circle_wrap'); ?>><div class="wgl-services_circle"></div></div><?php
                    if (!empty($services_media)) {
                        echo $services_media;
                    }?>
                </div><?php
                }?>
                <div class="wgl-services_content-wrap">
                    <<?php echo $_s['title_tag']; ?> class="wgl-services_title"><?php echo wp_kses($_s['ib_title'], $kses_allowed_html);?></<?php echo $_s['title_tag']; ?>><?php
                    if (!empty($_s['ib_content'])) {?>
                        <<?php echo $_s['content_tag']; ?> class="wgl-services_text"><?php echo wp_kses($_s['ib_content'], $kses_allowed_html);?></<?php echo $_s['content_tag']; ?>><?php
                    }
                    if ($_s['add_read_more']) {?>
                        <a <?php echo $this->get_render_attribute_string('serv_link'); ?>><?php echo esc_html($_s['read_more_text']);?></a><?php
                    }?>
                </div><?php
                if ($_s['add_item_link']) {?>
                    <a <?php echo $this->get_render_attribute_string('item_link'); ?>></a><?php
                }?>
            </div>
        </div>

        <?php
    }

    /**
     * @since 1.1.5
     */
    public function wpml_support_module()
    {
        add_filter( 'wpml_elementor_widgets_to_translate',  [ $this, 'wpml_widgets_to_translate_filter' ] );
    }

    /**
     * @since 1.1.5
     */
    public function wpml_widgets_to_translate_filter( $widgets )
    {
        return \WglAddons\Includes\WGL_WPML_Settings::get_translate(
            $this, $widgets
        );
    }
}