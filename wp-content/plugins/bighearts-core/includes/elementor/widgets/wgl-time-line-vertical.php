<?php
/**
 * This template can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/widgets/wgl-time-line-vertical.php`.
 */
namespace WglAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Control_Media,
    Repeater,
    Group_Control_Border,
    Group_Control_Box_Shadow,
    Group_Control_Typography
};
use WglAddons\BigHearts_Global_Variables as BigHearts_Globals;

class Wgl_Time_Line_Vertical extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-time-line-vertical';
    }

    public function get_title()
    {
        return esc_html__('WGL Time Line Vertical', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-time-line-vertical';
    }

    public function get_categories()
    {
        return [ 'wgl-extensions' ];
    }

    public function get_script_depends()
    {
        return [ 'jquery-appear' ];
    }

    protected function register_controls()
    {
        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> CONTENT
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_content',
            [ 'label' => esc_html__('Content', 'bighearts-core') ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'thumbnail_idle',
            [
                'label' => esc_html__('Thumbnail', 'bighearts-core'),
                'type' => Controls_Manager::MEDIA,
			    'dynamic' => [  'active' => true],
            ]
        );

        $repeater->add_control(
            'thumbnail_switch',
            [
                'label' => esc_html__('Change on hover?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $repeater->add_control(
            'thumbnail_hover',
            [
                'label' => esc_html__('Hover Thumbnail', 'bighearts-core'),
                'type' => Controls_Manager::MEDIA,
			    'dynamic' => [  'active' => true],
                'condition' => [ 'thumbnail_switch!' => '' ],
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'bighearts-core'),
                'type' => Controls_Manager::TEXTAREA,
			    'dynamic' => [  'active' => true],
                'rows' => 1,
                'separator' => 'before',
                'placeholder' => esc_attr__('Your title', 'bighearts-core'),
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => esc_html__('Content', 'bighearts-core'),
                'type' => Controls_Manager::WYSIWYG,
			    'dynamic' => [  'active' => true],
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, neque qui velit.', 'bighearts-core'),
            ]
        );

        $repeater->add_control(
            'date',
            [
                'label' => esc_html__('Date', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => esc_html__('Layers', 'bighearts-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => esc_html__('First heading​', 'bighearts-core'),
                        'date' => esc_html__('2020', 'bighearts-core'),
                    ],
                    [
                        'title' => esc_html__('Second heading​', 'bighearts-core'),
                        'date' => esc_html__('2019', 'bighearts-core'),
                    ],
                ],
                'title_field' => '{{title}}',
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> APPEARANCE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_animation',
            [ 'label' => esc_html__('Appearance', 'bighearts-core') ]
        );

        $this->add_control(
            'add_appear',
            [
                'label' => esc_html__('Use Appear Animation?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> CURVE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_curve',
            [
                'label' => esc_html__('Main Curve', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'curve_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'after',
                'default' => [
                    'top' => 0,
                    'right' => 50,
                    'bottom' => 0,
                    'left' => 50,
                ],
                'mobile_default' => [
                    'top' => 0,
                    'right' => 25,
                    'bottom' => 0,
                    'left' => 35,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__curve-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tlv__date-wrapper, {{WRAPPER}} .tlv__volume-wrapper' => 'flex-basis: calc( 50% - 2.5px - ({{RIGHT}}px + {{LEFT}}px) / 2 );',
                ],
            ]
        );

        $this->add_control(
            'curve_bg',
            [
                'label' => esc_html__('Curve Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#f7f7f7',
                'selectors' => [
                    '{{WRAPPER}} .tlv__curve-wrapper' => 'background-color: {{VALUE}};',


                    // The following lines are not related to Curve Background Color and are necessary only for module responsive.
                    // They can be placed in 'Selectors' setion of any other Control

                    // ↓ Responsive styles depending on Elementor Breakpoint setting ↓
                    'body[data-elementor-device-mode="tablet"] {{WRAPPER}} .tlv__item:nth-child(even), body[data-elementor-device-mode="mobile"] {{WRAPPER}} .tlv__item:nth-child(even)' => 'text-align: left; flex-direction: row;',
                    'body.elementor-device-tablet {{WRAPPER}} .tlv__item:nth-child(even), body.elementor-device-mobile {{WRAPPER}} .tlv__item:nth-child(even)' => 'text-align: left; flex-direction: row;',

                    'body[data-elementor-device-mode="tablet"] {{WRAPPER}} .tlv__date-wrapper, body[data-elementor-device-mode="mobile"] {{WRAPPER}} .tlv__date-wrapper' => 'flex-basis: 0px !important;',
                    'body.elementor-device-tablet {{WRAPPER}} .tlv__date-wrapper, body.elementor-device-mobile {{WRAPPER}} .tlv__date-wrapper' => 'flex-basis: 0px !important;',

                    'body[data-elementor-device-mode="tablet"] {{WRAPPER}} .tlv__date-wrapper .tlv__date, body[data-elementor-device-mode="mobile"] {{WRAPPER}} .tlv__date-wrapper .tlv__date' => 'position: absolute; left: -25px; transform: rotate(-90deg);',

                    'body.elementor-device-tablet {{WRAPPER}} .tlv__date-wrapper .tlv__date, body.elementor-device-mobile {{WRAPPER}} .tlv__date-wrapper .tlv__date' => 'position: absolute; left: -25px; transform: rotate(-90deg);',

                    'body[data-elementor-device-mode="tablet"] {{WRAPPER}} .tlv__volume-wrapper, body[data-elementor-device-mode="mobile"] {{WRAPPER}} .tlv__volume-wrapper' => 'flex-basis: auto !important;',
                    'body.elementor-device-tablet {{WRAPPER}} .tlv__volume-wrapper, body.elementor-device-mobile {{WRAPPER}} .tlv__volume-wrapper' => 'flex-basis: auto !important;',

                    'body[data-elementor-device-mode="tablet"] {{WRAPPER}} .tlv__item:nth-child(even) .tlv__content-wrapper' => 'flex-direction: row;',
                    'body.elementor-device-tablet {{WRAPPER}} .tlv__item:nth-child(even) .tlv__content-wrapper' => 'flex-direction: row;',

                    'body[data-elementor-device-mode="mobile"] {{WRAPPER}} .tlv__item .tlv__content-wrapper' => 'flex-direction: column;',
                    'body.elementor-device-mobile {{WRAPPER}} .tlv__item .tlv__content-wrapper' => 'flex-direction: column;',
                    // ↑ responsive styles ↑
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_pointer' );

        $this->start_controls_tab(
            'tab_pointer_idle',
            [ 'label' => esc_html__('Idle', 'bighearts-core') ]
        );

        $this->add_control(
            'in_pointer_bg_idle',
            [
                'label' => esc_html__('Inner Pointer Background', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .tlv__curve-wrapper' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'out_pointer_bg_idle',
            [
                'label' => esc_html__('Outter Pointer Background', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .tlv__curve-wrapper:before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_pointer_hover',
            [ 'label' => esc_html__('Hover', 'bighearts-core') ]
        );

        $this->add_control(
            'in_pointer_bg_hover',
            [
                'label' => esc_html__('Inner Pointer Background', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .tlv__item:hover .tlv__curve-wrapper:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'out_pointer_bg_hover',
            [
                'label' => esc_html__('Outter Pointer Background', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__item:hover .tlv__curve-wrapper:before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> CONTENT & MEDIA WRAPPER
         */

        $this->start_controls_section(
            'section_style_wrapper',
            [
                'label' => esc_html__('Content & Media Wrapper', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'wrapper_notice',
            [
                'type' => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
                'raw' => esc_html__('Note: Left/right values are inversed for even items.', 'bighearts-core' ),
            ]
        );

        $this->add_responsive_control(
            'wrapper_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 37,
                    'right' => 0,
                    'bottom' => 37,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__item .tlv__volume-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    'body[data-elementor-device-mode="desktop"] {{WRAPPER}} .tlv__item:nth-child(even) .tlv__volume-wrapper' => 'padding-left: {{RIGHT}}{{UNIT}}; padding-right: {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 8,
                    'right' => 10,
                    'bottom' => 8,
                    'left' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    'body[data-elementor-device-mode="desktop"] {{WRAPPER}} .tlv__item:nth-child(even) .tlv__content-wrapper' => 'padding-left: {{RIGHT}}{{UNIT}}; padding-right: {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wrapper_border_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default' => [
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__content-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    'body[data-elementor-device-mode="desktop"] {{WRAPPER}} .tlv__item:nth-child(even) .tlv__content-wrapper' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_wrapper',
            [ 'separator' => 'before' ]
        );

        $this->start_controls_tab(
            'tab_wrapper_idle',
            [ 'label' => esc_html__('Idle', 'bighearts-core') ]
        );

        $this->add_control(
            'wrapper_bg_idle',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .tlv__content-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'wrapper_idle',
                'selector' => '{{WRAPPER}} .tlv__content-wrapper',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrapper_idle',
                'selector' => '{{WRAPPER}} .tlv__content-wrapper',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_wrapper_hover',
            [ 'label' => esc_html__('Hover', 'bighearts-core') ]
        );

        $this->add_control(
            'wrapper_bg_hover',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__item:hover .tlv__content-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'wrapper_hover',
                'selector' => '{{WRAPPER}} .tlv__item:hover .tlv__content-wrapper',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrapper_hover',
                'selector' => '{{WRAPPER}} .tlv__item:hover .tlv__content-wrapper',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> MEDIA
         */

        $this->start_controls_section(
            'section_style_media',
            [
                'label' => esc_html__('Media', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'media_position',
            [
                'label' => esc_html__('Position Image', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'flex-start' => esc_html__('Start', 'bighearts-core'),
                    'center' => esc_html__('Center', 'bighearts-core'),
                    'flex-end' => esc_html__('End', 'bighearts-core'),
                ],
                'default' => 'center',
                'mobile_default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .tlv__media' => 'align-self: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'media_notice',
            [
                'type' => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
                'raw' => esc_html__('Note: Left/right values are inversed for even items.', 'bighearts-core' ),
            ]
        );

        $this->add_responsive_control(
            'media_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 0,
                    'right' => 20,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'mobile_default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 15,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__media' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    'body[data-elementor-device-mode="desktop"] {{WRAPPER}} .tlv__item:nth-child(even) .tlv__media' => 'margin-left: {{RIGHT}}{{UNIT}}; margin-right: {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'media_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .tlv__media' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    'body[data-elementor-device-mode="desktop"] {{WRAPPER}} .tlv__item:nth-child(even) .tlv__media' => 'padding-left: {{RIGHT}}{{UNIT}}; padding-right: {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'media_border_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'after',
                'size_units' => [ 'px', '%' ],
                'default' => [
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    'body[data-elementor-device-mode="desktop"] {{WRAPPER}} .tlv__item:nth-child(even) .tlv__media' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'media',
                'selector' => '{{WRAPPER}} .tlv__media',
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> CONTENT
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__('Content', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Content Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'description' => esc_html__('Note. Left/right values are inversed for even items.', 'bighearts-core'),
                'mobile_default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    'body[data-elementor-device-mode="desktop"] {{WRAPPER}} .tlv__item:nth-child(even) .tlv__content' => 'padding-left: {{RIGHT}}{{UNIT}}; padding-right: {{LEFT}}{{UNIT}};',

                ],
            ]
        );

        $this->add_control(
            'heading_title',
            [
                'label' => esc_html__('Title Styles', 'bighearts-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_title',
                'selector' => '{{WRAPPER}} .tlv__title',
            ]
        );

        $this->start_controls_tabs( 'tabs_title' );

        $this->start_controls_tab(
            'tab_title_idle',
            [ 'label' => esc_html__('Idle', 'bighearts-core') ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_hover',
            [ 'label' => esc_html__('Hover', 'bighearts-core') ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__item:hover .tlv__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'heading_text',
            [
                'label' => esc_html__('Text Styles', 'bighearts-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_text',
                'selector' => '{{WRAPPER}} .tlv__text',
            ]
        );

        $this->start_controls_tabs( 'tabs_content' );

        $this->start_controls_tab(
            'tab_content_idle',
            [ 'label' => esc_html__('Idle', 'bighearts-core') ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_main_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .tlv__text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_content_hover',
            [ 'label' => esc_html__('Hover', 'bighearts-core') ]
        );

        $this->add_control(
            'content_color_hover',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__item:hover .tlv__text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> DATE
         */

        $this->start_controls_section(
            'section_style_date',
            [
                'label' => esc_html__('Date', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'date',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_family' => ['default' => \Wgl_Addons_Elementor::$typography_1['font_family']],
                    'font_weight' => ['default' => \Wgl_Addons_Elementor::$typography_1['font_weight']],
                ],
                'selector' => '{{WRAPPER}} .tlv__date',
            ]
        );

        $this->add_responsive_control(
            'date_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'tablet_default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tlv__date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_date' );

        $this->start_controls_tab(
            'date_colors_idle',
            [ 'label' => esc_html__('Idle', 'bighearts-core') ]
        );

        $this->add_control(
            'date_color_idle',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .tlv__date' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'date_bg_idle',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__date' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_date_hover',
            [ 'label' => esc_html__('Hover', 'bighearts-core') ]
        );

        $this->add_control(
            'date_color_hover',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__item:hover .tlv__date' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'date_bg_hover',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .tlv__item:hover .tlv__date' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render()
    {
        $_s = $this->get_settings_for_display();

        $kses_allowed_html = [
            'a' => [
                'id' => true, 'class' => true, 'style' => true,
                'href' => true, 'title' => true,
                'rel' => true, 'target' => true
            ],
            'br' => ['id' => true, 'class' => true, 'style' => true],
            'em' => ['id' => true, 'class' => true, 'style' => true],
            'strong' => ['id' => true, 'class' => true, 'style' => true],
            'span' => ['id' => true, 'class' => true, 'style' => true],
            'p' => ['id' => true, 'class' => true, 'style' => true],
            'ul' => ['id' => true, 'class' => true, 'style' => true],
            'ol' => ['id' => true, 'class' => true, 'style' => true],
            'li' => ['id' => true, 'class' => true, 'style' => true],
        ];

        $this->add_render_attribute(
            'timeline-vertical',
            [
                'class' => [
                    'wgl-timeline-vertical',
                    $_s[ 'add_appear' ] ? 'appear_animation' : '',
                ],
            ]
        );

        // Render
        echo '<div ', $this->get_render_attribute_string('timeline-vertical'), '>';
        echo '<div class="tlv__items-wrapper">';

        foreach ($_s['items'] as $index => $item) {
            $thumbnail_idle = $this->get_repeater_setting_key('thumbnail', 'list', $index);
            $url_idle = $item['thumbnail_idle']['url'] ?? false;
            $this->add_render_attribute($thumbnail_idle, [
                'class' => 'tlv__thumbnail--idle',
                'src' => $url_idle ? esc_url($url_idle) : '',
                'alt' => Control_Media::get_image_alt($item['thumbnail_idle']),
            ]);

            $thumbnail_hover = $this->get_repeater_setting_key('thumbnail_hover', 'list', $index);
            $url_hover = $item['thumbnail_hover']['url'] ?? false;
            $this->add_render_attribute($thumbnail_hover, [
                'class' => 'tlv__thumbnail--hover',
                'src' => $url_hover ? esc_url($url_hover) : '',
                'alt' => Control_Media::get_image_alt($item['thumbnail_hover']),
            ]);

            echo '<div class="tlv__item">';

                echo '<div class="tlv__date-wrapper">',
                    '<span class="tlv__date">',
                        $item['date'],
                    '</span>',
                '</div>';

                echo '<div class="tlv__curve-wrapper"></div>';

                echo '<div class="tlv__volume-wrapper">';
                    echo '<div class="tlv__content-wrapper">';

                    echo '<div class="tlv__media">';
                    if ($url_hover) {
                        echo '<img ', $this->get_render_attribute_string($thumbnail_hover), '/>';
                    }
                    if ($url_idle) {
                        echo '<img ', $this->get_render_attribute_string($thumbnail_idle), '/>';
                    }
                    echo '</div>'; // tlv__media

                    echo '<div class="tlv__content">';
                    if (!empty($item['title'])) {
                        echo '<h3 class="tlv__title">',
                            $item['title'],
                        '</h3>';
                    }
                    if (!empty($item['content'])) {
                        echo '<div class="tlv__text">',
                            wp_kses( $item['content'], $kses_allowed_html ),
                        '</div>';
                    }
                    echo '</div>'; // tlv__content

                    echo '</div>'; // tlv__content-wrapper
                echo '</div>'; // tlv__volume-wrapper

            echo '</div>';
        }

        echo '</div>'; // tlv__items-wrapper
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
