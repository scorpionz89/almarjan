<?php
/**
 * This template can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/widgets/wgl-service-1.php`.
 */
namespace WglAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{
	Widget_Base,
	Controls_Manager,
	Icons_Manager,
	Group_Control_Background,
	Group_Control_Css_Filter,
	Group_Control_Typography,
	Group_Control_Box_Shadow
};
use WglAddons\{
	BigHearts_Global_Variables as BigHearts_Globals,
	Includes\Wgl_Icons
};

class Wgl_Service_1 extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-service-1';
    }

    public function get_title()
    {
        return esc_html__('WGL Service', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-services';
    }

    public function get_categories()
    {
        return ['wgl-extensions'];
    }

    protected function register_controls()
    {
		/**
         * CONTENT -> SERVICE CONTENT
         */

        $this->start_controls_section(
            'wgl_service_content',
            ['label' => esc_html__('Service Content', 'bighearts-core')]
        );

        $this->add_control(
            's_title',
            [
                'label' => esc_html__('Title', 'bighearts-core'),
                'type' => Controls_Manager::TEXTAREA,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
                'default' => esc_html__('The Heading​', 'bighearts-core'),
                'rows' => 2
            ]
        );

        $this->add_control(
            's_subtitle',
            [
                'label' => esc_html__('Subtitle', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
            ]
        );
        $this->add_control(
            's_description',
            [
                'label' => esc_html__('Description', 'bighearts-core'),
                'type' => Controls_Manager::TEXTAREA,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
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
                'default' => 'left',
                'prefix_class' => 'a',
                'toggle' => true,
            ]
        );

        $this->add_control(
            'hover_toggling',
            [
                'label' => esc_html__('Toggle Content Visibility', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
                'return_value' => 'toggling',
                'prefix_class' => 'animation_',
                'default' => 'yes',
            ]
        );

        $this->add_responsive_control(
            'hover_toggling_offset',
            [
                'label' => esc_html__('Animation Distance in %', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'condition' => ['hover_toggling!' => ''],
                'range' => [
                    '%' => ['min' => 30, 'max' => 100],
                ],
                'default' => ['size' => 57, 'unit' => '%'],
                'selectors' => [
                    '{{WRAPPER}}.animation_toggling .wgl-service_content' => 'transform: translateY({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_responsive_control(
            'hover_toggling_transition',
            [
                'label' => esc_html__('Transition Duration', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'condition' => ['hover_toggling!' => ''],
                'range' => [
                    'px' => ['min' => 0.1, 'max' => 2, 'step' => 0.1],
                ],
                'default' => ['size' => 0.6 ],
                'selectors' => [
                    '{{WRAPPER}}.animation_toggling .wgl-service_content,
                    {{WRAPPER}}.animation_toggling .wgl-service_subtitle' => 'transition-duration: {{SIZE}}s;',
                ],
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
			    'default' => [
				    'media_type' => 'font',
			    ]
		    ]
	    );

        /**
         * CONTENT -> BUTTON
         */

        $this->start_controls_section(
            'section_style_link',
            ['label' => esc_html__('Link', 'bighearts-core') ]
        );

	    $this->add_control(
		    'item_link',
		    [
			    'label' => esc_html__('Link', 'bighearts-core'),
			    'type' => Controls_Manager::URL,
			    'dynamic' => [  'active' => true],
		    ]
	    );

        $this->add_control(
            'add_item_link',
            [
                'label' => esc_html__('Whole Item Link', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),

            ]
        );

        $this->add_control(
            'add_read_more',
            [
                'label' => esc_html__('Button', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
                'default' => 'yes',
            ]
        );

	    $this->add_control(
		    'read_more_alignment',
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
			    'default' => 'left',
			    'condition' => ['add_read_more' => 'yes'],
			    'toggle' => true,
			    'prefix_class' => 'read_more_alignment-',
			    'selectors' => [
				    '{{WRAPPER}} .wgl-service_button-wrapper' => 'text-align: {{VALUE}};',
			    ],
		    ]
	    );

	    $this->add_control(
		    'hover_animation_icon_button',
		    [
			    'label' => esc_html__('Toggle Button Animation', 'bighearts-core'),
			    'type' => Controls_Manager::SWITCHER,
			    'condition' => [
                    'add_read_more' => 'yes',
                    'read_more_alignment' => 'center',
                ],
			    'label_on' => esc_html__('On', 'bighearts-core'),
			    'label_off' => esc_html__('Off', 'bighearts-core'),
			    'return_value' => 'toggling',
			    'prefix_class' => 'button_animation_',
			    'default' => 'yes',
		    ]
	    );

	    $this->add_control(
            'read_more_icon_fontawesome',
            [
                'label' => esc_html__('Icon', 'bighearts-core'),
                'type' => Controls_Manager::ICONS,
                'condition' => ['add_read_more' => 'yes'],
                'label_block' => true,
                'description' => esc_html__('Select icon from available libraries.', 'bighearts-core'),
            ]
        );

	    $this->add_responsive_control(
		    'read_more_icon_size',
		    [
			    'label' => esc_html__('Icon Size', 'bighearts-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
			    'condition' => [
				    'add_read_more' => 'yes',
				    'read_more_icon_fontawesome!' => [
				    	'value' => '',
				    	'library' => '',
				    ]
			    ],
			    'range' => [
				    'px' => ['min' => 10, 'max' => 100 ],
			    ],
			    'default' => ['size' => 19 ],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-service_button i' => 'font-size: {{SIZE}}{{UNIT}};',
			    ],
		    ]
	    );

	    $this->add_responsive_control(
		    'read_more_icon_spacing',
		    [
			    'label' => esc_html__('Icon Wrapper Size', 'bighearts-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
			    'condition' => [
				    'add_read_more' => 'yes',
				    'read_more_icon_fontawesome!' => [
				    	'value' => '',
				    	'library' => '',
				    ]
			    ],
			    'range' => [
				    'px' => ['min' => 10, 'max' => 100 ],
			    ],
			    'default' => ['size' => 46 ],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-service_button i,{{WRAPPER}} .wgl-service_button span' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
			    ],
		    ]
	    );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'general_style_section',
            [
                'label' => esc_html__( 'General', 'bighearts-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

	    $this->add_responsive_control(
		    'general_padding',
		    [
			    'label' => esc_html__('Padding', 'bighearts-core'),
			    'type' => Controls_Manager::DIMENSIONS,
			    'size_units' => ['px', 'em', '%'],
			    'default' => [
				    'top' => '70',
				    'right' => '60',
				    'bottom' => '138',
				    'left' => '60',
				    'unit' => 'px',
				    'isLinked' => false,
			    ],
			    'selectors' => [
				    '{{WRAPPER}} .elementor-widget-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
		    ]
	    );

	    $this->start_controls_tabs('tabs_background');

	    $this->start_controls_tab(
		    'tab_bg_idle',
		    ['label' => esc_html__('Idle', 'bighearts-core')]
	    );

	    $this->add_control(
		    'general_border_radius_idle',
		    [
			    'label' => esc_html__('Border Radius', 'bighearts-core'),
			    'type' => Controls_Manager::DIMENSIONS,
			    'size_units' => [ 'px', '%' ],
			    'selectors' => [
				    '{{WRAPPER}} .elementor-widget-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
		    ]
	    );

	    $this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
			    'name' => 'item_idle',
			    'types' => ['classic', 'gradient'],
			    'fields_options' => [
				    'background' => [ 'default' => 'classic' ],
				    'color' => [ 'default' => BigHearts_Globals::get_h_font_color() ],
			    ],
			    'selector' => '{{WRAPPER}} .elementor-widget-container',
		    ]
	    );

	    $this->end_controls_tab();

	    $this->start_controls_tab(
		    'tab_bg_hover',
		    ['label' => esc_html__('Hover', 'bighearts-core')]
	    );

	    $this->add_control(
		    'general_border_radius_hover',
		    [
			    'label' => esc_html__('Border Radius', 'bighearts-core'),
			    'type' => Controls_Manager::DIMENSIONS,
			    'size_units' => [ 'px', '%' ],
			    'selectors' => [
				    '{{WRAPPER}}:hover .elementor-widget-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
		    ]
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
			    'label' => esc_html__('Transition Delay', 'bighearts-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
			    'separator' => 'before',
			    'range' => [
				    'px' => ['max' => 3, 'step' => 0.1],
			    ],
			    'default' => ['size' => 0.4],
			    'selectors' => [
				    '{{WRAPPER}} .elementor-widget-container' => 'transition: {{SIZE}}s',
			    ],
		    ]
	    );

	    $this->end_controls_tab();
	    $this->end_controls_tabs();
	    $this->end_controls_section();

	    /*-----------------------------------------------------------------------------------*/
	    /*  STYLE -> ICON
		/*-----------------------------------------------------------------------------------*/

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
			    'default' => ['size' => 60],
			    'selectors' => [
				    '{{WRAPPER}} .media-wrapper .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
			    ],
		    ]
	    );

	    $this->add_control(
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
			    'default' => [
				    'top' => '0',
				    'right' => '0',
				    'bottom' => '10',
				    'left' => '0',
				    'unit' => 'px',
				    'isLinked' => false,
			    ],
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
			    'default' => '#ffffff',
			    'selectors' => [
				    '{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
				    '{{WRAPPER}}.elementor-view-stacked .elementor-icon svg' => 'fill: {{VALUE}};',
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
			    'default' => 'rgba(255,255,255,.3)',
			    'selectors' => [
				    '{{WRAPPER}}.elementor-view-framed .elementor-icon,
				    {{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'background-color: {{VALUE}};',
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
				    '{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon' => 'background-color: {{VALUE}};',
				    '{{WRAPPER}}.elementor-view-framed:hover .elementor-icon,
                     {{WRAPPER}}.elementor-view-default:hover .elementor-icon' => 'color: {{VALUE}}; border-color: {{VALUE}}; fill: {{VALUE}};',
				    '{{WRAPPER}}.elementor-view-framed:hover .elementor-icon svg,
                     {{WRAPPER}}.elementor-view-default:hover .elementor-icon svg' => 'fill: {{VALUE}}; border-color: {{VALUE}};',
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
				    '{{WRAPPER}}.elementor-view-framed:hover .elementor-icon' => 'background-color: {{VALUE}};',
				    '{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
				    '{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon svg' => 'fill: {{VALUE}};',
			    ],
		    ]
	    );

	    $this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
			    'name' => 'icon_hover',
			    'selector' => '{{WRAPPER}}:hover .elementor-icon',
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

	    /*-----------------------------------------------------------------------------------*/
	    /*  STYLE -> IMAGE
		/*-----------------------------------------------------------------------------------*/

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
				    '{{WRAPPER}} .wgl-image-box_img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				    '{{WRAPPER}} .wgl-image-box_img' => 'width: {{SIZE}}{{UNIT}};',
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
			    'selector' => '{{WRAPPER}} .wgl-image-box_img img',
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
				    '{{WRAPPER}} .wgl-image-box_img img' => 'opacity: {{SIZE}};',
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
				    '{{WRAPPER}} .wgl-image-box_img img' => 'transition-duration: {{SIZE}}s',
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
			    'selector' => '{{WRAPPER}} .elementor-widget-container:hover .wgl-image-box_img img',
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
				    '{{WRAPPER}} .elementor-widget-container:hover .wgl-image-box_img img' => 'opacity: {{SIZE}};',
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

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_title',
                'selector' => '{{WRAPPER}} .wgl-service_title',
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
            'title_margin',
            [
                'label' => esc_html__('Title Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '20',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__('Title Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'service_color_tab_title' );

        $this->start_controls_tab(
            'custom_service_color_idle',
            ['label' => esc_html__('Idle' , 'bighearts-core')]
        );

        $this->add_control(
            'service_color',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
				'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_title' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_service_color_hover',
            ['label' => esc_html__('Hover' , 'bighearts-core')]
        );

        $this->add_control(
            'service_color_hover',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
				'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}}:hover .wgl-service_title' => 'color: {{VALUE}};'
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
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_custom_fonts',
				'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_family' => ['default' => \Wgl_Addons_Elementor::$typography_1['font_family']],
                    'font_weight' => ['default' => \Wgl_Addons_Elementor::$typography_1['font_weight']],
                ],
                'selector' => '{{WRAPPER}} .wgl-service_subtitle',
            ]
        );

        $this->add_responsive_control(
            'subtitle_margin',
            [
                'label' => esc_html__('Subtitle Margin', 'bighearts-core'),
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
                    '{{WRAPPER}} .wgl-service_subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'service_color_tab_subtitle' );

        $this->start_controls_tab(
            'custom_service_color_normal_subtitle',
            [
                'label' => esc_html__('Idle' , 'bighearts-core'),
            ]
        );

        $this->add_control(
            'service_color_subtitle',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
				'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_subtitle' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_service_color_hover_subtitle',
            [
                'label' => esc_html__('Hover' , 'bighearts-core'),
            ]
        );

        $this->add_control(
            'service_color_hover_subtitle',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
				'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}}:hover .wgl-service_subtitle' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

		/**
		 * STYLE -> DESCRIPTION
		 */

        $this->start_controls_section(
            'descr_style_section',
            [
                'label' => esc_html__('Description', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'descr_custom_fonts',
                'selector' => '{{WRAPPER}} .wgl-service_description',
            ]
        );

        $this->add_responsive_control(
            'descr_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('service_color_tab_descr');

        $this->start_controls_tab(
            'custom_service_color_normal_descr',
            ['label' => esc_html__('Idle' , 'bighearts-core')]
        );

        $this->add_control(
            'service_color_descr',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
				'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_description' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_service_color_hover_descr',
            [
                'label' => esc_html__('Hover' , 'bighearts-core'),
            ]
        );

        $this->add_control(
            'service_color_hover_descr',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
				'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}}:hover .wgl-service_description' => 'color: {{VALUE}};'
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
            'button_style_section',
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
                'selector' => '{{WRAPPER}} .wgl-service_button span',
            ]
        );

        $this->add_responsive_control(
            'button_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_button-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .wgl-service_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

	    $this->add_responsive_control(
		    'button_border_radius',
		    [
			    'label' => esc_html__('Border Radius', 'bighearts-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
			    'range' => [
				    'px' => ['min' => 0, 'max' => 50, 'step' => 1 ],
			    ],
			    'default' => ['size' => 28, 'unit' => 'px'],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-service_button, {{WRAPPER}} .wgl-service_button i' => 'border-radius: {{SIZE}}px;',
			    ],
		    ]
	    );

	    $this->start_controls_tabs(
            'button_color_tab',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'tab_button_idle',
            ['label' => esc_html__('Idle' , 'bighearts-core') ]
        );

        $this->add_control(
            'button_color_idle',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_btn_color_idle(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_button i, {{WRAPPER}} .wgl-service_button span' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wgl-service_button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_idle',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
				'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_button i, {{WRAPPER}} .wgl-service_button span' => 'background-color: {{VALUE}};',
                ],
            ]
        );

	    $this->add_control(
		    'button_icon_rotate_idle',
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
				    '{{WRAPPER}} .wgl-service_button i:before,
				     {{WRAPPER}} .wgl-service_button span:before' => 'transform: rotate({{SIZE}}{{UNIT}});',
			    ],
		    ]
	    );

        $this->end_controls_tab();

	    $this->start_controls_tab(
		    'tab_button_hover_item',
		    [
                'label' => esc_html__('Hover Item' , 'bighearts-core'),
                'condition' => ['add_item_link!' => ''],
            ]
	    );

	    $this->add_control(
		    'button_color_hover_item',
		    [
			    'label' => esc_html__('Color', 'bighearts-core'),
				'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-service_link:hover ~ .wgl-service_button-wrapper .wgl-service_button i,
				    {{WRAPPER}} .wgl-service_link:hover ~ .wgl-service_button-wrapper .wgl-service_button span' => 'color: {{VALUE}};',
				    '{{WRAPPER}} .wgl-service_link:hover ~ .wgl-service_button-wrapper .wgl-service_button' => 'background-color: {{VALUE}};',
			    ],
		    ]
	    );

	    $this->add_control(
		    'button_bg_hover_item',
		    [
			    'label' => esc_html__('Background Color', 'bighearts-core'),
				'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-service_link:hover ~ .wgl-service_button-wrapper .wgl-service_button i,
				    {{WRAPPER}} .wgl-service_link:hover ~ .wgl-service_button-wrapper .wgl-service_button span' => 'background-color: {{VALUE}};'
			    ],
		    ]
	    );

	    $this->add_control(
		    'button_icon_rotate_hover_item',
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
				    '{{WRAPPER}} .wgl-service_link:hover ~ .wgl-service_button-wrapper .wgl-service_button i:before,
				    {{WRAPPER}} .wgl-service_link:hover ~ .wgl-service_button-wrapper .wgl-service_button span:before' => 'transform: rotate({{SIZE}}{{UNIT}});',
			    ],
		    ]
	    );

	    $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => esc_html__('Hover Button' , 'bighearts-core'),
                'condition' => ['add_item_link' => ''],
            ]
        );

        $this->add_control(
            'button_color_hover',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
				'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_button:hover i,
                    {{WRAPPER}} .wgl-service_button:hover span' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wgl-service_button:hover,
                    {{WRAPPER}} .wgl-service_link ~ .wgl-service_button-wrapper .wgl-service_button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_hover',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
				'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-service_button:hover i,
                    {{WRAPPER}} .wgl-service_button:hover span' => 'background-color: {{VALUE}};'
                ],
            ]
        );

	    $this->add_control(
		    'button_icon_rotate_hover',
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
				    '{{WRAPPER}} .wgl-service_button:hover i:before,
                    {{WRAPPER}} .wgl-service_button:hover span:before,
                    {{WRAPPER}} .wgl-service_link ~ .wgl-service_button-wrapper .wgl-service_button:hover i:before,
                    {{WRAPPER}} .wgl-service_link ~ .wgl-service_button-wrapper .wgl-service_button:hover span:before' => 'transform: rotate({{SIZE}}{{UNIT}});',
			    ],
		    ]
	    );

	    $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

    }

    public function render()
    {
        $_s = $this->get_settings_for_display();

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
            'small' => ['id' => true, 'class' => true, 'style' => true],
        ];

        $this->add_render_attribute('service', 'class', 'wgl-service-1');

        // Link
        if (!empty($_s['item_link']['url'])) {
            $this->add_link_attributes('link', $_s['item_link']);
        }

	    // Media
	    if (!empty($_s['icon_type'])) {
		    $media = new Wgl_Icons;
		    $ib_media = $media->build($this, $_s, []);
	    }

        // Read more button
        if ($_s['add_read_more']) {
            $this->add_render_attribute('btn', 'class', 'wgl-service_button');

            $icon_font = $_s['read_more_icon_fontawesome'];

            $migrated = isset($_s['__fa4_migrated']['read_more_icon_fontawesome']);
            $is_new = Icons_Manager::is_migration_allowed();
		    $icon_output = '';

		    if ( $is_new || $migrated ) {
			    ob_start();
			    Icons_Manager::render_icon( $_s['read_more_icon_fontawesome'], ['aria-hidden' => 'true'] );
			    $icon_output .= ob_get_clean();
		    } else {
			    $icon_output .= '<i class="icon '.esc_attr($icon_font).'"></i>';
		    }

		    if (!empty($icon_output)){
                $s_button = '<div class="wgl-service_button-wrapper">';
                    $s_button .= sprintf('<%s %s %s>',
                        $_s['add_item_link'] ? 'div' : 'a',
                        $_s['add_item_link'] ? '' : $this->get_render_attribute_string('link'),
                        $this->get_render_attribute_string('btn')
                    );
                        $s_button .= $icon_output;
                    $s_button .= $_s['add_item_link'] ? '</div>' : '</a>';
                $s_button .= '</div>';
		    }
        }

        // Render
        if ($_s['add_item_link'] && !empty($_s['item_link']['url'])) { ?>
            <a class="wgl-service_link" <?php echo $this->get_render_attribute_string('link'); ?>></a><?php
        }?>
        <div <?php echo $this->get_render_attribute_string('service'); ?>>
            <div class="wgl-service_content-wrap">
                <div class="wgl-service_content">
                    <?php
                    if (!empty($ib_media)) {
	                    echo $ib_media;
                    }
                    if (!empty($_s['s_subtitle'])) { ?>
                        <div class="wgl-service_subtitle"><?php echo wp_kses($_s['s_subtitle'], $kses_allowed_html); ?></div><?php
                    }
                    if (!empty($_s['s_title'])) {
                        echo '<', $_s['title_tag'], ' class="wgl-service_title">',wp_kses($_s['s_title'], $kses_allowed_html),'</', $_s['title_tag'], '>';
                    }
                    if (!empty($_s['s_description'])) { ?>
                        <div class="wgl-service_description"><?php echo wp_kses($_s['s_description'], $kses_allowed_html); ?></div><?php
                    }?>
                </div>
            </div>
        </div><?php
	    if ( ! empty( $s_button ) ) {
		    echo $s_button;
	    }
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
