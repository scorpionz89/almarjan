<?php
/**
 * This template can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/widgets/wgl-info-box.php`.
 */
namespace WglAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Group_Control_Typography,
    Group_Control_Box_Shadow,
    Group_Control_Background,
    Group_Control_Css_Filter
};
use WglAddons\{
    BigHearts_Global_Variables as BigHearts_Globals,
    Includes\Wgl_Icons,
    Templates\WGL_Info_Box as Info_Box_Template
};

class Wgl_Info_Box extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-info-box';
    }

    public function get_title()
    {
        return esc_html__('WGL Info Box', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-info-box';
    }

    public function get_categories()
    {
        return ['wgl-extensions'];
    }

    protected function register_controls()
    {
        /**
         * CONTENT -> LAYOUT
         */

        $this->start_controls_section(
            'section_content_layout',
            ['label' => esc_html__('Layout', 'bighearts-core')]
        );

        $this->add_control(
            'layout',
            [
                'type' => 'wgl-radio-image',
                'condition' => ['icon_type!' => ''],
                'options' => [
                    'top' => [
                        'title' => esc_html__( 'Top', 'bighearts-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/style_def.png',
                    ],
                    'left' => [
                        'title' => esc_html__( 'Left', 'bighearts-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/style_left.png',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'bighearts-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/style_right.png',
                    ],
                ],
                'default' => 'top',
            ]
        );

        $this->add_control(
            'alignment',
            [
                'label' => esc_html__( 'Alignment', 'bighearts-core' ),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => true,
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
                'default' => 'left',
                'prefix_class' => 'a',
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> ICON/IMAGE
         */

        $output = [];

        $output['view'] = [
            'label' => esc_html__('View', 'bighearts-core'),
            'type' => Controls_Manager::SELECT,
            'condition' => ['icon_type' => 'font'],
            'options' => [
                'default' => esc_html__('Default', 'bighearts-core'),
                'stacked' => esc_html__('Stacked', 'bighearts-core'),
                'framed' => esc_html__('Framed', 'bighearts-core'),
            ],
            'default' => 'default',
            'prefix_class' => 'elementor-view-',
        ];

        $output['shape'] = [
            'label' => esc_html__('Shape', 'bighearts-core'),
            'type' => Controls_Manager::SELECT,
            'condition' => [
                'icon_type' => 'font',
                'view!' => 'default',
            ],
            'options' => [
                'circle' => esc_html__('Circle', 'bighearts-core'),
                'square' => esc_html__('Square', 'bighearts-core'),
            ],
            'default' => 'circle',
            'prefix_class' => 'elementor-shape-',
        ];

        Wgl_Icons::init(
            $this,
            [
                'output' => $output,
                'section' => true,
                'default' => ['media_type' => 'font'],
            ]
        );

        /**
         * CONTENT -> CONTENT
         */

        $this->start_controls_section(
            'wgl_ib_content',
            ['label' => esc_html__('Content', 'bighearts-core')]
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
            'ib_title_add',
            [
                'label' => esc_html__('Additional Title', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'ib_subtitle',
            [
                'label' => esc_html__('Subtitle', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'ib_content',
            [
                'label' => esc_html__('Content', 'bighearts-core'),
                'type' => Controls_Manager::WYSIWYG,
			    'dynamic' => [  'active' => true],
                'placeholder' => esc_attr__('Description Text', 'bighearts-core'),
                'label_block' => true,
                'default' => esc_html__('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'bighearts-core'),
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> LINK
         */

        $this->start_controls_section(
            'section_style_link',
            ['label' => esc_html__('Link', 'bighearts-core')]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'bighearts-core'),
                'type' => Controls_Manager::URL,
			    'dynamic' => [  'active' => true],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'module_link',
                            'operator' => '!=',
                            'value' => '',
                        ],
                        [
                            'name' => 'add_read_more',
                            'operator' => '!=',
                            'value' => '',
                        ],
                    ],
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'module_link',
            [
                'label' => esc_html__('Whole Module Link', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'add_read_more',
            [
                'label' => esc_html__('\'Read More\' Button', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Use', 'bighearts-core'),
                'label_off' => esc_html__('Hide', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'read_more_inline',
            [
                'label' => esc_html__('Inline Button', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'layout' => ['left', 'right'],
                    'add_read_more!' => ''
                ],
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => esc_html__('Button Text', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'terms' => [
                                [
                                    'name' => 'layout',
                                    'operator' => '=',
                                    'value' => 'top',
                                ], [
                                    'name' => 'add_read_more',
                                    'operator' => '!=',
                                    'value' => '',
                                ]
                            ]
                        ],
                        [
                            'terms' => [
                                [
                                    'name' => 'layout',
                                    'operator' => 'in',
                                    'value' => ['left', 'right'],
                                ], [
                                    'name' => 'add_read_more',
                                    'operator' => '!=',
                                    'value' => '',
                                ], [
                                    'name' => 'read_more_inline',
                                    'operator' => '=',
                                    'value' => '',
                                ]
                            ]
                        ],
                    ],
                ],
                'label_block' => true,
                'default' => esc_html__('Read More', 'bighearts-core'),
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> HOVER ANIMATION
         */

        $this->start_controls_section(
            'section_content_animation',
            ['label' => esc_html__('Hover Animation', 'bighearts-core')]
        );

        $this->add_control(
            'hover_lifting',
            [
                'label' => esc_html__('Lift Up the Item', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['hover_toggling' => ''],
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
                'return_value' => 'lifting',
                'prefix_class' => 'animation_',
            ]
        );

        $this->add_control(
            'hover_toggling',
            [
                'label' => esc_html__('Toggle Icon/Content Visibility', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'hover_lifting' => '',
                    'layout!' => ['left', 'right'],
                    'icon_type!' => '',
                ],
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
                'return_value' => 'toggling',
                'prefix_class' => 'animation_',
            ]
        );

        $this->add_responsive_control(
            'hover_toggling_offset',
            [
                'label' => esc_html__('Animation Distance', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'condition' => [
                    'hover_toggling!' => '',
                    'layout!' => ['left', 'right'],
                    'icon_type!' => '',
                ],
                'range' => [
                    'px' => ['min' => 30, 'max' => 100],
                ],
                'default' => ['size' => 40],
                'selectors' => [
                    '{{WRAPPER}}.animation_toggling .wgl-infobox_wrapper' => 'transform: translateY({{SIZE}}{{UNIT}});',
                    '{{WRAPPER}}.animation_toggling .elementor-widget-container:hover .wgl-infobox_wrapper' => 'transform: translateY(-{{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_responsive_control(
            'hover_toggling_transition',
            [
                'label' => esc_html__('Transition Duration', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'condition' => [
                    'hover_toggling!' => '',
                    'layout!' => ['left', 'right'],
                    'icon_type!' => '',
                ],
                'range' => [
                    'px' => ['min' => 0.1, 'max' => 2, 'step' => 0.1],
                ],
                'default' => ['size' => 0.6],
                'selectors' => [
                    '{{WRAPPER}}.animation_toggling .wgl-infobox_wrapper,
                     {{WRAPPER}}.animation_toggling .media-wrapper,
                     {{WRAPPER}}.animation_toggling .wgl-infobox-button_wrapper' => 'transition-duration: {{SIZE}}s;',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> ICON
         */

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Icon', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['icon_type' => 'font'],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Font Size', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 6, 'max' => 300],
                ],
                'default' => ['size' => 40],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_rotate',
            [
                'label' => esc_html__('Rotate', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'size_units' => ['deg', 'turn'],
                'range' => [
                    'deg' => ['max' => 360],
                    'turn' => ['min' => 0, 'max' => 1, 'step' => 0.1],
                ],
                'default' => ['unit' => 'deg'],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .elementor-icon' => 'transform: rotate({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .elementor-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .elementor-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'border_width',
            [
                'label' => esc_html__('Border Width', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => ['view' => 'framed'],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .elementor-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => ['view!' => 'default'],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_icons',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'tab_icon_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'icon_primary_color_idle',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-framed .elementor-icon,
                     {{WRAPPER}}.elementor-view-default .elementor-icon' => 'color: {{VALUE}}; border-color: {{VALUE}}; fill: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-framed .elementor-icon svg,
                     {{WRAPPER}}.elementor-view-default .elementor-icon svg' => 'fill: {{VALUE}}; border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_secondary_color_idle',
            [
                'label' => esc_html__('Additional Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'condition' => ['view!' => 'default'],
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-framed .elementor-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-stacked .elementor-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_idle',
                'selector' => '{{WRAPPER}} .elementor-icon',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'icon_primary_color_hover',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-stacked .elementor-widget-container:hover .elementor-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-framed .elementor-widget-container:hover .elementor-icon,
                     {{WRAPPER}}.elementor-view-default .elementor-widget-container:hover .elementor-icon' => 'color: {{VALUE}}; border-color: {{VALUE}}; fill: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-framed .elementor-widget-container:hover .elementor-icon svg,
                     {{WRAPPER}}.elementor-view-default .elementor-widget-container:hover .elementor-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_secondary_color_hover',
            [
                'label' => esc_html__('Additional Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'condition' => ['view!' => 'default'],
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-framed .elementor-widget-container:hover .elementor-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-stacked .elementor-widget-container:hover .elementor-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-stacked .elementor-widget-container:hover .elementor-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_hover',
                'selector' => '{{WRAPPER}} .elementor-widget-container:hover .elementor-icon',
            ]
        );

        $this->add_control(
            'hover_animation_icon',
            [
                'label' => esc_html__('Hover Animation', 'bighearts-core'),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> IMAGE
         */

        $this->start_controls_section(
            'section_style_image',
            [
                'label' => esc_html__('Image', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['icon_type' => 'image'],
            ]
        );

        $this->add_responsive_control(
            'image_space',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
	                'top' => '0',
	                'right' => '0',
	                'bottom' => '22',
	                'left' => '0',
	                'unit' => 'px',
	                'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} figure.wgl-image-box_img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_size',
            [
                'label' => esc_html__('Width', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => 50, 'max' => 800],
                    '%' => ['min' => 5, 'max' => 100],
                ],
                'default' => ['size' => 95, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} figure.wgl-image-box_img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'hover_animation_image',
            [
                'label' => esc_html__('Hover Animation', 'bighearts-core'),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->start_controls_tabs('image_effects');

        $this->start_controls_tab(
            'Idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} figure.wgl-image-box_img img',
            ]
        );

        $this->add_control(
            'image_opacity',
            [
                'label' => esc_html__('Opacity', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'range' => [
                    'px' => ['min' => 0.10, 'max' => 1, 'step' => 0.01],
                ],
                'selectors' => [
                    '{{WRAPPER}} figure.wgl-image-box_img img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'background_hover_transition',
            [
                'label' => esc_html__('Transition Duration', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'default' => ['size' => 0.3],
                'range' => [
                    'px' => ['max' => 3, 'step' => 0.1],
                ],
                'selectors' => [
                    '{{WRAPPER}} figure.wgl-image-box_img img' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters_hover',
                'selector' => '{{WRAPPER}} .elementor-widget-container:hover figure.wgl-image-box_img img',
            ]
        );

        $this->add_control(
            'image_opacity_hover',
            [
                'label' => esc_html__('Opacity', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'range' => [
                    'px' => ['min' => 0.10, 'max' => 1, 'step' => 0.01],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover figure.wgl-image-box_img img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
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
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '10',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_title',
                'selector' => '{{WRAPPER}} .wgl-infobox_title',
            ]
        );

        $this->start_controls_tabs('tabs_title_styles');

        $this->start_controls_tab(
            'tab_title_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'title_color_idle',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#232323',
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> TITLE ADDITIONAL
         */

        $this->start_controls_section(
            'title_add_style_section',
            [
                'label' => esc_html__('Additional Title', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['ib_title_add!' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_title_add',
                'selector' => '{{WRAPPER}} .wgl-infobox_title-add',
            ]
        );

        $this->start_controls_tabs('tabs_title_add_styles');

        $this->start_controls_tab(
            'tab_title_add',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'title_color_add',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_title-add' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_add_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'title_add_color_hover',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_title-add' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> SUBTITLE
         */

        $this->start_controls_section(
            'subtitle_style_section',
            [
                'label' => esc_html__('Subtitle', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['ib_subtitle!' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typography',
                'selector' => '{{WRAPPER}} .wgl-infobox_subtitle',
            ]
        );

        $this->add_responsive_control(
            'subtitle_offset',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
	                'top' => '-6',
	                'right' => '0',
	                'bottom' => '10',
	                'left' => '0',
	                'unit'  => 'px',
	                'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_subtitle_styles');

        $this->start_controls_tab(
            'tab_subtitle_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'subtitle_color_idle',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#d6d6d6',
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_subtitle_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'subtitle_color_hover',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_subtitle' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> CONTENT
         */

        $this->start_controls_section(
            'content_style_section',
            [
                'label' => esc_html__('Content', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['ib_content!' => ''],
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
                'selector' => '{{WRAPPER}} .wgl-infobox_content',
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
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .wgl-infobox_content',
            ]
        );

        $this->start_controls_tabs('content_color_tab');

        $this->start_controls_tab(
            'custom_content_color_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_content_color_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'content_color_hover',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .wgl-infobox_content' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> BUTTON
         */

        $this->start_controls_section(
            'section_style_button',
            [
                'label' => esc_html__('Button', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['add_read_more!' => ''],
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
                'selector' => '{{WRAPPER}} .wgl-infobox_button span',
            ]
        );

        $this->add_responsive_control(
            'button_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox-button_wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox-button_wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_button',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'tab_button_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'button_color_idle',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_icon_bg_idle',
            [
                'label' => esc_html__('Additional Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_button:before,
                     {{WRAPPER}} .wgl-infobox_button:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'button_color_hover',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_button:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wgl-infobox__link:hover + .wgl-infobox .wgl-infobox_button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_icon_bg_hover',
            [
                'label' => esc_html__('Additional Hover Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_button:before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

	    /**
	     * STYLE -> BACKGROUND
	     */

	    $this->start_controls_section(
		    'section_style_bg',
		    [
			    'label' => esc_html__('Background', 'bighearts-core'),
			    'tab' => Controls_Manager::TAB_STYLE,
		    ]
	    );

	    $this->add_control(
		    'item_overflow',
		    [
			    'label' => esc_html__('Module Overflow', 'bighearts-core'),
			    'type' => Controls_Manager::SELECT,
			    'options' => [
				    '' => esc_html__('Theme Default', 'bighearts-core'),
				    'overflow: visible;' => esc_html__('Visible', 'bighearts-core'),
				    'overflow: hidden;' => esc_html__('Hidden', 'bighearts-core'),
			    ],
			    'selectors' => [
				    '{{WRAPPER}} .elementor-widget-container' => '{{VALUE}}',
			    ],
		    ]
	    );

	    $this->start_controls_tabs('tabs_background');

	    $this->start_controls_tab(
		    'tab_bg_idle',
		    ['label' => esc_html__('Idle', 'bighearts-core')]
	    );

	    $this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
			    'name' => 'item_idle',
			    'types' => ['classic', 'gradient'],
			    'selector' => '{{WRAPPER}} .elementor-widget-container',
		    ]
	    );

	    $this->end_controls_tab();

	    $this->start_controls_tab(
		    'tab_bg_hover',
		    ['label' => esc_html__('Hover', 'bighearts-core')]
	    );

	    $this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
			    'name' => 'item_hover',
			    'types' => ['classic', 'gradient'],
			    'selector' => '{{WRAPPER}} .elementor-widget-container:before',
		    ]
	    );

	    $this->add_control(
		    'item_bg_transition',
		    [
			    'label' => esc_html__('Transition Duration', 'bighearts-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
			    'range' => [
				    'px' => ['max' => 3, 'step' => 0.1],
			    ],
			    'default' => ['size' => 0.4],
			    'selectors' => [
				    '{{WRAPPER}} .elementor-widget-container' => 'transition: {{SIZE}}s',
			    ],
		    ]
	    );

	    $this->add_control(
		    'item_bg_transition_delay',
		    [
			    'label' => esc_html__('Transition Delay', 'bighearts-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
			    'range' => [
				    'px' => ['max' => 1, 'step' => 0.1],
			    ],
			    'default' => ['size' => 0.1],
			    'selectors' => [
				    '{{WRAPPER}} .elementor-widget-container,
				     {{WRAPPER}} div.elementor-widget-container:after' => 'transition-delay: {{SIZE}}s',
			    ],
		    ]
	    );

	    $this->end_controls_tab();
	    $this->end_controls_tabs();
	    $this->end_controls_section();

	    /**
	     * STYLE -> FURTHER BACKGROUND
	     */

	    $this->start_controls_section(
		    'section_style_further_bg',
		    [
			    'label' => esc_html__('Further Background', 'bighearts-core'),
			    'tab' => Controls_Manager::TAB_STYLE,
		    ]
	    );

	    $this->add_responsive_control(
		    'item_further_bg_margin',
		    [
			    'label' => esc_html__('Margin', 'bighearts-core'),
			    'type' => Controls_Manager::DIMENSIONS,
			    'separator' => 'before',
			    'size_units' => ['px', 'em', '%'],
			    'default' => [
				    'top' => '-30',
				    'right' => '-30',
				    'bottom' => '-30',
				    'left' => '-30',
				    'unit'  => 'px',
				    'isLinked' => false
			    ],
			    'selectors' => [
				    '{{WRAPPER}} .elementor-widget-container:after' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
		    ]
	    );

	    $this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
			    'name' => 'item_further_bg_hover',
			    'types' => ['classic', 'gradient'],
			    'selector' => '{{WRAPPER}} .elementor-widget-container:after',
		    ]
	    );

	    $this->add_control(
		    'item_further_bg_transition',
		    [
			    'label' => esc_html__('Transition Delay', 'bighearts-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
			    'separator' => 'before',
			    'range' => [
				    'px' => ['max' => 1, 'step' => 0.1],
			    ],
			    'default' => ['size' => 0],
			    'selectors' => [
				    '{{WRAPPER}} .elementor-widget-container:after' => 'transition-delay: {{SIZE}}s',
				    '{{WRAPPER}} .elementor-widget-container:hover:after' => 'transition-delay: {{SIZE}}s',
			    ],
		    ]
	    );

	    $this->end_controls_section();
    }

    protected function render()
    {
        ( new Info_Box_Template() )->render(
            $this,
            $this->get_settings_for_display()
        );
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
