<?php
/**
 * This template can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/widgets/wgl-toggle-accordion.php`.
 */
namespace WglAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Frontend,
    Repeater,
    Group_Control_Border,
    Group_Control_Typography,
    Group_Control_Box_Shadow
};
use WglAddons\{
    BigHearts_Global_Variables as BigHearts_Globals,
    Includes\Wgl_Elementor_Helper
};

class Wgl_Toggle_Accordion extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-toggle-accordion';
    }

    public function get_title()
    {
        return esc_html__('WGL Toggle/Accordion', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-toggle-accordion';
    }

    public function get_categories()
    {
        return ['wgl-extensions'];
    }

    protected function register_controls()
    {
        /**
         * CONTENT -> GENERAL
         */
        $this->start_controls_section(
            'section_content_general',
            [ 'label' => esc_html__('General', 'bighearts-core') ]
        );

        $this->add_control(
            'acc_type',
            [
                'label' => esc_html__('Type', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'accordion' => esc_html__('Accordion', 'bighearts-core'),
                    'toggle' => esc_html__('Toggle', 'bighearts-core'),
                ],
                'default' => 'accordion',
            ]
        );

        $this->add_control(
            'heading_desktop',
            [
                'label' => esc_html__('Icon Settings', 'bighearts-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'enable_acc_icon',
            [
                'label' => esc_html__('Type', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__('None', 'bighearts-core'),
                    'plus' => esc_html__('Plus/Minus', 'bighearts-core'),
                    'custom' => esc_html__('Custom', 'bighearts-core'),
                ],
                'default' => 'plus',
            ]
        );

        $this->add_control(
            'acc_icon',
            [
                'label' => esc_html__('Icon', 'bighearts-core'),
                'type' => Controls_Manager::ICON,
                'condition' => [ 'enable_acc_icon' => 'custom' ],
                'include' => [
                    'fa fa-chevron-right',
                    'fa fa-plus',
                    'fa fa-long-arrow-alt-right',
                    'fa fa-chevron-circle-right',
                    'fa fa-arrow-right',
                    'fa fa-arrow-circle-right',
                    'fa fa-angle-right',
                    'fa fa-angle-double-right',
                ],
                'default' => 'fa fa-chevron-right',
            ]
        );

        $this->add_control(
            'icon_style',
            [
                'label' => esc_html__('Style', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => [ 'enable_acc_icon!' => 'none' ],
                'options' => [
                    'default' => esc_html__('Default', 'bighearts-core'),
                    'stacked' => esc_html__('Stacked', 'bighearts-core'),
                    'framed' => esc_html__('Framed', 'bighearts-core'),
                ],
                'default' => 'default',
                'prefix_class' => 'elementor-view-'
            ]
        );

        $this->add_control(
            'icon_alignment',
            [
                'label' => esc_html__('Position', 'bighearts-core'),
                'type' => Controls_Manager::CHOOSE,
                'condition' => [ 'enable_acc_icon!' => 'none' ],
                'options' => [
                    '1' => [
                        'title' => esc_html__( 'Left', 'bighearts-core' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    '0; flex-grow: 1' => [
                        'title' => esc_html__( 'Right', 'bighearts-core' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => '0; flex-grow: 1',
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_title' => 'order:{{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> CONTENT
         */

        $this->start_controls_section(
            'section_content_content',
            [ 'label' => esc_html__('Content', 'bighearts-core') ]
        );

        $repeater = new Repeater();
        $repeater->add_control(
			'acc_tab_title',
			[
                'label' => esc_html__('Tab Title', 'bighearts-core'),
                'type' => Controls_Manager::TEXTAREA,
			    'dynamic' => [  'active' => true],
                'default' => esc_html__('Tab Title', 'bighearts-core'),
			]
        );
        $repeater->add_control(
			'title_prefix',
			[
                'label' => esc_html__('Title Prefix', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
			]
        );
        $repeater->add_control(
			'acc_tab_def_active',
			[
                'label' => esc_html__('Active as Default', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
			]
        );
        $repeater->add_control(
			'acc_content_type',
			[
                'label' => esc_html__('Content Type', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'content' => esc_html__('Content', 'bighearts-core'),
                    'template' => esc_html__('Saved Templates', 'bighearts-core'),
                ],
                'default' => 'content',
			]
        );
        $repeater->add_control(
			'acc_content_templates',
			[
                'label' => esc_html__('Choose Template', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'options' => Wgl_Elementor_Helper::get_instance()->get_elementor_templates(),
                'condition' => [
                    'acc_content_type' => 'template',
                ],
			]
        );
        $repeater->add_control(
			'acc_content',
			[
                'label' => esc_html__('Tab Content', 'bighearts-core'),
                'type' => Controls_Manager::WYSIWYG,
			    'dynamic' => [  'active' => true],
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, neque qui velit. Magni dolorum quidem ipsam eligendi, totam, facilis laudantium cum accusamus ullam voluptatibus commodi numquam, error, est. Ea, consequatur.', 'bighearts-core'),
                'condition' => [
                    'acc_content_type' => 'content',
                ],
			]
        );

        $this->add_control(
            'acc_tab',
            [
                'type' => Controls_Manager::REPEATER,
                'seperator' => 'before',
                'fields' => $repeater->get_controls(),
                'title_field' => '{{acc_tab_title}}',
                'default' => [
                    [
                        'acc_tab_title' => esc_html__('Panel Title 1', 'bighearts-core'),
                        'acc_tab_def_active' => 'yes',
                    ],
                    [
                        'acc_tab_title' => esc_html__('Panel Title 2', 'bighearts-core'),
                    ],
                    [
                        'acc_tab_title' => esc_html__('Panel Title 3', 'bighearts-core'),
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> PANEL
         */

        $this->start_controls_section(
            'section_style_panel',
            [
                'label' => esc_html__('Panel', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'panel_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '17',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_panel' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'panel_border_radius_idle',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default' => [
                    'top' => '5',
                    'right' => '5',
                    'bottom' => '5',
                    'left' => '5',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_panel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_panel',
            [ 'separator' => 'before' ]
        );

        $this->start_controls_tab(
            'tab_panel_idle',
            [ 'label' => esc_html__('Idle', 'bighearts-core') ]
        );

        $this->add_responsive_control(
            'panel_padding_idle',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'panel_idle',
                'selector' => '{{WRAPPER}} .wgl-accordion_panel',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_panel_hover',
            [ 'label' => esc_html__('Hover', 'bighearts-core') ]
        );

        $this->add_responsive_control(
            'panel_padding_hover',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => 'vertical',
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_panel:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'panel_hover',
                'selector' => '{{WRAPPER}} .wgl-accordion_panel:hover',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_panel_active',
            [ 'label' => esc_html__('Active', 'bighearts-core') ]
        );

        $this->add_responsive_control(
            'panel_padding_active',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => 'vertical',
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '21',
                    'bottom' => '23',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_panel.active' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'panel_active',
                'selector' => '{{WRAPPER}} .wgl-accordion_panel.active',
                'exclude' => [
                    'box_shadow_position',
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
            'section_style_title',
            [
                'label' => esc_html__('Title', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'acc_title_typo',
                'selector' => '{{WRAPPER}} .wgl-accordion_title',
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
                'default' => 'h4',
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '8',
                    'right' => '19',
                    'bottom' => '8',
                    'left' => '23',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_title');

        $this->start_controls_tab(
            'tab_title_idle',
            [ 'label' => esc_html__('Idle', 'bighearts-core') ]
        );

        $this->add_control(
            'title_color_idle',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_header' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_bg_idle',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_header' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_border_radius_idle',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default' => [
                    'top' => '25',
                    'left' => '25',
                    'right' => '25',
                    'bottom' => '25',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'title_idle',
                'selector' => '{{WRAPPER}} .wgl-accordion_header',
                'fields_options' => [
                    'border' => [ 'default' => 'solid' ],
                    'width' => [ 'default' => [
                        'top' => 2,
                        'right' => 2,
                        'bottom' => 2,
                        'left' => 2,
                    ] ],
                    'color' => [
                        'default' => '#e8e8e8'
                    ],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_hover',
            [ 'label' => esc_html__('Hover', 'bighearts-core') ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_header:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_bg_hover',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_header:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_header:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'acc_title_border_hover',
                'selector' => '{{WRAPPER}} .wgl-accordion_header:hover',
	            'fields_options' => [
		            'border' => [ 'default' => 'solid' ],
		            'width' => [ 'default' => [
			            'top' => 2,
			            'right' => 2,
			            'bottom' => 2,
			            'left' => 2,
		            ] ],
		            'color' => [
			            'default' => BigHearts_Globals::get_primary_color()
		            ],
	            ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_active',
            [ 'label' => esc_html__('Active', 'bighearts-core') ]
        );

        $this->add_control(
            'title_color_active',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .active .wgl-accordion_header' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_bg_active',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .active .wgl-accordion_header' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'acc_title_border_radius_active',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .active .wgl-accordion_header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'acc_title_border_active',
                'selector' => '{{WRAPPER}} .active .wgl-accordion_header',
                'fields_options' => [
	                'border' => [ 'default' => 'solid' ],
	                'width' => [ 'default' => [
		                'top' => 2,
		                'right' => 2,
		                'bottom' => 2,
		                'left' => 2,
	                ] ],
	                'color' => [
		                'default' => BigHearts_Globals::get_primary_color()
	                ],
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> TITLE PREFIX
         */

        $this->start_controls_section(
            'section_style_title_pref',
            [
                'label' => esc_html__('Title Prefix', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'acc_title_pref_typo',
                'selector' => '{{WRAPPER}} .wgl-accordion_title-prefix',
            ]
        );

        $this->start_controls_tabs('tabs_prefix');

        $this->start_controls_tab(
            'tab_prefix_idle',
            [ 'label' => esc_html__('Idle', 'bighearts-core') ]
        );

        $this->add_control(
            'prefix_color_idle',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_title-prefix' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_prefix_hover',
            [ 'label' => esc_html__('Hover', 'bighearts-core') ]
        );

        $this->add_control(
            'prefix_color_hover',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_header:hover .wgl-accordion_title-prefix' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_prefix_active',
            [ 'label' => esc_html__('Active', 'bighearts-core') ]
        );

        $this->add_control(
            'prefix_color_active',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_panel.active .wgl-accordion_title-prefix' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> ICON
         */

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Icon', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Font Size', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'condition' => [ 'enable_acc_icon' => 'custom' ],
                'size_units' => [ 'px', 'em', 'rem' ],
                'range' => [
                    'px' => [ 'min' => 1, 'max' => 100 ],
                ],
                'default' => [ 'size' => 11, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '3',
                    'right' => '0',
                    'bottom'=> '3',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '12',
                    'right' => '12',
                    'bottom'=> '12',
                    'left' => '12',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_border_width',
            [
                'label' => esc_html__('Border Width', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => '1',
                    'right' => '1',
                    'bottom'=> '1',
                    'left' => '1',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_border_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default' => [
                    'top' => '50',
                    'right' => '50',
                    'bottom' => '50',
                    'left' => '50',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_icon');

        $this->start_controls_tab(
            'tab_icon_idle',
            [ 'label' => esc_html__('Idle', 'bighearts-core') ]
        );

        $this->add_control(
            'icon_color_idle',
            [
                'label' => esc_html__('Icon Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_bg_idle',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_border_idle',
            [
                'label' => esc_html__('Border Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_icon' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_idle',
                'selector' => '{{WRAPPER}} .wgl-accordion_icon',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            [ 'label' => esc_html__('Hover', 'bighearts-core') ]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_header:hover .wgl-accordion_icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_bg_hover',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_header:hover .wgl-accordion_icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_border_hover',
            [
                'label' => esc_html__('Border Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_header:hover .wgl-accordion_icon' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_hover',
                'selector' => '{{WRAPPER}} .wgl-accordion_header:hover .wgl-accordion_icon',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_active',
            [ 'label' => esc_html__('Active', 'bighearts-core') ]
        );

        $this->add_control(
            'icon_color_active',
            [
                'label' => esc_html__('Icon Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_panel.active .wgl-accordion_icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_bg_active',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .active .wgl-accordion_icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_border_active',
            [
                'label' => esc_html__('Border Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .active .wgl-accordion_icon' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_active',
                'selector' => '{{WRAPPER}} .active .wgl-accordion_icon',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> CONTENT
         */

        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__('Content', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'acc_content_typo',
                'selector' => '{{WRAPPER}} .wgl-accordion_content',
            ]
        );

        $this->add_responsive_control(
            'acc_content_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '21',
                    'right' => '25',
                    'bottom' => '2',
                    'left' => '25',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'acc_content_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'acc_content_color',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_main_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'acc_content_bg_color',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'acc_content_border_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'acc_content_border',
                'selector' => '{{WRAPPER}} .wgl-accordion_content',
            ]
        );

        $this->end_controls_section();

    }

    protected function render()
    {
        $_s = $this->get_settings_for_display();
        $id_int = substr($this->get_id_int(), 0, 3);

        $this->add_render_attribute(
            'accordion',
            [
                'class' => [
                    'wgl-accordion',
                    'icon-'.$_s['enable_acc_icon'],
                ],
                'id' => 'wgl-accordion-'.esc_attr($this->get_id()),
                'data-type' => $_s['acc_type'],
            ]
        );

        echo '<div ', $this->get_render_attribute_string('accordion'), '>';

        foreach ($_s['acc_tab'] as $index => $item) {
            $tab_count = $index + 1;

            $tab_title_key = $this->get_repeater_setting_key('acc_tab_title', 'acc_tab', $index);

            $this->add_render_attribute(
                $tab_title_key,
                [
                    'id' => 'wgl-accordion_header-' . $id_int . $tab_count,
                    'class' => 'wgl-accordion_header',
                    'data-default' => $item['acc_tab_def_active'],
                ]
            );

            // Render
            echo '<div class="wgl-accordion_panel">';
            echo '<', $_s['title_tag'], ' ', $this->get_render_attribute_string($tab_title_key), '>';

                echo '<span class="wgl-accordion_title">';
                    if (!empty($item['title_prefix'])) {
                        echo '<span class="wgl-accordion_title-prefix">',
                            $item['title_prefix'],
                        '</span>';
                    }
                    echo $item['acc_tab_title'];
                echo '</span>';

                if ($_s['enable_acc_icon'] != 'none') {
                    echo '<i class="wgl-accordion_icon elementor-icon ', $_s['acc_icon'], '"></i>';
                }

            echo '</', $_s['title_tag'], '>';

            echo '<div class="wgl-accordion_content">';

                if ('content' === $item['acc_content_type']) {
                    echo do_shortcode($item['acc_content']);
                } elseif ('template' === $item['acc_content_type']) {
                    $id = $item['acc_content_templates'];
                    echo (new Frontend)->get_builder_content_for_display($id, true);
                }

            echo '</div>'; // wgl-accordion_content

            echo '</div>'; // wgl-accordion_panel

        }

        echo '</div>';
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
