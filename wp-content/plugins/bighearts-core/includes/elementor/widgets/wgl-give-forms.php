<?php
/**
 * Current file can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/widgets/wgl-give-forms.php`.
 */
namespace WglAddons\Widgets;

defined( 'ABSPATH' ) || exit;

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Group_Control_Typography,
    Group_Control_Background,
    Group_Control_Box_Shadow,
    Group_Control_Border
};
use WglAddons\{
    BigHearts_Global_Variables as BigHearts_Globals,
    Includes\Wgl_Loop_Settings,
    Templates\WGL_Give_Donations
};

/**
 * Give Forms Widget
 *
 *
 * @since 1.0.0
 * @version 1.1.5
 */
class Wgl_Give_Forms extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-give-forms';
    }

    public function get_title()
    {
        return esc_html__('WGL Give Forms', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-give-forms';
    }

    public function get_categories()
    {
        return ['wgl-extensions'];
    }

    public function get_script_depends()
    {
        return [];
    }

    /**
     * @since 1.0.0
     * @version 1.0.6
     */
    protected function register_controls()
    {
        /** CONTENT -> LAYOUT */

        $this->start_controls_section(
            'section_content_layout',
            ['label' => esc_html__('Layout', 'bighearts-core')]
        );

        $this->add_control(
            'widget_title',
            [
                'label' => esc_html__('Widget Title', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
            ]
        );

        $this->add_control(
            'widget_subtitle',
            [
                'label' => esc_html__('Widget Subitle', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'widget_layout',
            [
                'type' => 'wgl-radio-image',
                'options' => [
                    'grid' => [
                        'title' => esc_html__('Grid', 'bighearts-core'),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/layout_grid.png',
                    ],
                    'carousel' => [
                        'title' => esc_html__('Carousel', 'bighearts-core'),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/layout_carousel.png',
                    ],
                ],
                'default' => 'grid',
            ]
        );

        $this->add_control(
            'grid_columns',
            [
                'label' => esc_html__('Grid Columns Amount', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => [
                    '1' => esc_html__('1 (one)', 'bighearts-core'),
                    '2' => esc_html__('2 (two)', 'bighearts-core'),
                    '3' => esc_html__('3 (three)', 'bighearts-core'),
                    '4' => esc_html__('4 (four)', 'bighearts-core'),
                    '5' => esc_html__('5 (five)', 'bighearts-core')
                ],
                'default' => '1',
            ]
        );

        $this->add_control(
            'horizontal_layout',
            [
                'label' => esc_html__('Horizontal Layout', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'horizontal_layout_notice',
            [
                'type' => Controls_Manager::RAW_HTML,
                'condition' => [
                    'horizontal_layout!' => '',
                    'grid_columns!' => '1',
                ],
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
                'raw' => esc_html__('Horizontal Layout intended for single column grid only.', 'bighearts-core'),
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

        $this->add_control(
            'img_size_string',
            [
                'label' => esc_html__('Image Size', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'widget_layout' => ['grid', 'carousel']
                ],
                'separator' => 'before',
                'options' => [
                    'default' => esc_html__('Theme Default', 'bighearts-core'),
                    '150' => esc_html__('Thumbnail - 150x150', 'bighearts-core'),
                    '300' => esc_html__('Medium - 300x300', 'bighearts-core'),
                    '768' => esc_html__('Medium Large - 768x768', 'bighearts-core'),
                    '1024' => esc_html__('Large - 1024x1024', 'bighearts-core'),
                    '740x620' => esc_html__('740x620 - 3 Columns', 'bighearts-core'),
                    '1140x950' => esc_html__('1140x950 - 2 Columns', 'bighearts-core'),
                    '1170x725' => esc_html__('1170x725 - 1 Column', 'bighearts-core'),
                    'full' => esc_html__('Full', 'bighearts-core'),
                    'custom' => esc_html__('Custom', 'bighearts-core'),
                ],
                'default' => 'default',
            ]
        );

        $this->add_control(
            'img_size_array',
            [
                'label' => esc_html__('Image Dimension', 'bighearts-core'),
                'type' => Controls_Manager::IMAGE_DIMENSIONS,
                'condition' => [
                    'img_size_string' => 'custom',
                    'widget_layout' => ['grid', 'carousel'],
                ],
                'description' => esc_html__('Crop the original image to any custom size. You can also set a single value for width to keep the initial ratio.', 'bighearts-core'),
                'default' => [
                    'width' => '1170',
                    'height' => '750',
                ]
            ]
        );

        $this->add_control(
            'img_aspect_ratio',
            [
                'label' => esc_html__('Image Aspect Ratio', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'img_size_string!' => ['custom', 'default'],
                    'widget_layout' => ['grid', 'carousel'],
                ],
                'options' => [
                    '1:1' => esc_html__('1:1', 'bighearts-core'),
                    '3:2' => esc_html__('3:2', 'bighearts-core'),
                    '4:3' => esc_html__('4:3', 'bighearts-core'),
                    '9:16' => esc_html__('9:16', 'bighearts-core'),
                    '16:9' => esc_html__('16:9', 'bighearts-core'),
                    '21:9' => esc_html__('21:9', 'bighearts-core'),
                    '' => esc_html__('Not Crop', 'bighearts-core'),
                ],
                'default' => '',
            ]
        );

        $this->add_control(
            'navigation_type',
            [
                'label' => esc_html__('Navigation Type', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'widget_layout!' => 'carousel',
                ],
                'separator' => 'before',
                'options' => [
                    'none' => esc_html__('None', 'bighearts-core'),
                    'pagination' => esc_html__('Pagination', 'bighearts-core'),
                ],
                'default' => 'none',
            ]
        );

        $this->add_responsive_control(
            'navigation_align',
            [
                'label' => esc_html__('Navigation\'s Alignment', 'bighearts-core'),
                'type' => Controls_Manager::CHOOSE,
                'condition' => [
                    'widget_layout!' => 'carousel',
                    'navigation_type' => 'pagination'
                ],
                'toggle' => false,
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
                'selectors' => [
                    '{{WRAPPER}} .wgl-pagination' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'navigation_spacer',
            [
                'label' => esc_html__('Navigation Margin Top', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'condition' => [
                    'navigation_type' => 'pagination',
                    'widget_layout!' => 'carousel',
                ],
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 240],
                ],
                'default' => ['size' => 60],
                'selectors' => [
                    '{{WRAPPER}} .wgl-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> APPEARANCE
         */

        $this->start_controls_section(
            'section_content_appearance',
            ['label' => esc_html__('Appearance', 'bighearts-core')]
        );

        $this->add_control(
            'hide_media',
            [
                'label' => esc_html__('Hide Media', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'media_link',
            [
                'label' => esc_html__('Clickable Thumbnail', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['hide_media' => ''],
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'media_crop',
            [
                'label' => esc_html__('Crop Thumbnail', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['hide_media' => ''],
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'media_divider',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => ['hide_media' => ''],
            ]
        );

        $enabled_cats = give_is_setting_enabled(give_get_option('categories', 'disabled'));
        if ($enabled_cats) {
            $this->add_control(
                'hide_cats',
                [
                    'label' => esc_html__('Hide Categories', 'bighearts-core'),
                    'type' => Controls_Manager::SWITCHER,
                ]
            );
        }

        $this->add_control(
            'hide_title',
            [
                'label' => esc_html__('Hide Title', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'hide_excerpt',
            [
                'label' => esc_html__('Hide Excerpt | Content', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'excerpt_chars',
            [
                'label' => esc_html__('Characters Limit for Excerpt', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['hide_excerpt' => ''],
                'min' => 1,
                'default' => '85',
            ]
        );

        $this->add_control(
            'hide_goal_bar',
            [
                'label' => esc_html__('Hide Goal Bar', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'hide_goal_stats',
            [
                'label' => esc_html__('Hide Goal Statistics', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> CAROUSEL OPTIONS
         */

        $this->start_controls_section(
            'section_content_carousel',
            [
                'label' => esc_html__('Carousel Options', 'bighearts-core'),
                'condition' => ['widget_layout' => 'carousel']
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => esc_html__('Autoplay Speed', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['autoplay!' => ''],
                'min' => 1,
                'default' => '3000',
            ]
        );

        $this->add_control(
            'infinite_loop',
            [
                'label' => esc_html__('Infinite Loop', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'slide_single',
            [
                'label' => esc_html__('Slide One Item per time', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'slides_visibility',
            [
                'label' => esc_html__('Reveal right edge items', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'prefix_class' => 'slides-visible-',
                'selectors' => [
                    '{{WRAPPER}} .wgl-carousel_wrapper,
                     {{WRAPPER}} .slick-slider' => 'overflow: visible;',
					'{{WRAPPER}} .slick-list' => 'margin-right: -60%; padding-right: 60%; overflow: hidden;',
				],
            ]
        );

        $this->add_control(
            'pagination_divider',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => ['use_pagination!' => ''],
            ]
        );

        $this->add_control(
            'use_pagination',
            [
                'label' => esc_html__('Add Pagination controls', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'pag_type',
            [
                'label' => esc_html__('Pagination Type', 'bighearts-core'),
                'type' => 'wgl-radio-image',
                'condition' => ['use_pagination!' => ''],
                'options' => [
                    'circle' => [
                        'title' => esc_html__('Circle', 'bighearts-core'),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/pag_circle.png',
                    ],
                    'circle_border' => [
                        'title' => esc_html__('Empty Circle', 'bighearts-core'),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/pag_circle_border.png',
                    ],
                    'square' => [
                        'title' => esc_html__('Square', 'bighearts-core'),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/pag_square.png',
                    ],
                    'square_border' => [
                        'title' => esc_html__('Empty Square', 'bighearts-core'),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/pag_square_border.png',
                    ],
                    'line' => [
                        'title' => esc_html__('Line', 'bighearts-core'),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/pag_line.png',
                    ],
                    'line_circle' => [
                        'title' => esc_html__('Line - Circle', 'bighearts-core'),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/pag_line_circle.png',
                    ],
                ],
                'default' => 'line_circle',
            ]
        );

        $this->add_control(
            'pag_offset',
            [
                'label' => esc_html__('Top Offset', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['use_pagination!' => ''],
                'min' => -50,
                'max' => 150,
                'selectors' => [
                    '{{WRAPPER}} .wgl-carousel .slick-dots' => 'margin-top: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'custom_pag_color',
            [
                'label' => esc_html__('Customize Color', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['use_pagination!' => ''],
            ]
        );

        $this->add_control(
            'pag_color',
            [
                'label' => esc_html__('Pagination Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'condition' => [
                    'use_pagination!' => '',
                    'custom_pag_color!' => '',
                ],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .pagination_circle .slick-dots li button,
                    {{WRAPPER}} .pagination_line .slick-dots li button:before,
                    {{WRAPPER}} .pagination_line_circle .slick-dots li button,
                    {{WRAPPER}} .pagination_square .slick-dots li button,
                    {{WRAPPER}} .pagination_square_border .slick-dots li button:before,
                    {{WRAPPER}} .pagination_circle_border .slick-dots li button:before ' => 'background: {{VALUE}}',

                    '{{WRAPPER}} .pagination_circle_border .slick-dots li.slick-active button,
                    {{WRAPPER}} .pagination_square_border .slick-dots li.slick-active button' => 'border-color: {{VALUE}}'
                ],
                'global' => [],
            ]
        );

        $this->add_control(
            'navigation_divider',
            [
                'type' => Controls_Manager::DIVIDER,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [[
                        'terms' => [[
                            'name' => 'use_pagination',
                            'operator' => '!=',
                            'value' => '',
                        ]]
                    ], [
                        'terms' => [[
                            'name' => 'use_navigation',
                            'operator' => '!=',
                            'value' => '',
                        ]]
                    ],],
                ],
            ]
        );

        $this->add_control(
            'use_navigation',
            [
                'label' => esc_html__('Add Navigation controls', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_responsive_control(
            'controls_spacer',
            [
                'label' => esc_html__('Controls Margin Top', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'condition' => ['use_navigation!' => ''],
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => -300, 'max' => 700],
                    '%' => ['min' => -50, 'max' => 150],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-carousel_wrapper,
                     {{WRAPPER}} .slick-slider' => 'overflow: visible;',
                    '{{WRAPPER}} .slick-arrow' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'controls_alignment',
            [
                'label' => esc_html__('Controls Alignment', 'bighearts-core'),
                'type' => Controls_Manager::CHOOSE,
                'condition' => ['use_navigation!' => ''],
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'bighearts-core' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'bighearts-core' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__('Justify', 'bighearts-core'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'prefix_class' => 'controls%s-',
            ]
        );

        $this->add_control(
            'custom_contols_color',
            [
                'label' => esc_html__('Customize Colors', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['use_navigation!' => ''],
            ]
        );

        $this->start_controls_tabs(
            'contols',
            [
                'condition' => [
                    'use_navigation!' => '',
                    'custom_contols_color!' => '',
                ]
            ]
        );

        $this->start_controls_tab(
            'controls_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'controls_color_idle',
            [
                'label' => esc_html__('Icon Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow' => 'color: {{VALUE}};',
                ],
                'global' => [],
            ]
        );

        $this->add_control(
            'controls_bg_idle',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow' => 'background-color: {{VALUE}};',
                ],
                'global' => [],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'controls_idle',
                'selector' => '{{WRAPPER}} .slick-arrow',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'controls_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'controls_color_hover',
            [
                'label' => esc_html__('Icon Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow:hover' => 'color: {{VALUE}};',
                ],
                'global' => [],
            ]
        );

        $this->add_control(
            'controls_bg_hover',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow:hover' => 'background-color: {{VALUE}};',
                ],
                'global' => [],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'controls_hover',
                'selector' => '{{WRAPPER}} .slick-arrow:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'responsive_divider',
            [
                'type' => Controls_Manager::DIVIDER,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [[
                        'terms' => [[
                            'name' => 'use_navigation',
                            'operator' => '!=',
                            'value' => '',
                        ]]
                    ], [
                        'terms' => [[
                            'name' => 'custom_resp',
                            'operator' => '!=',
                            'value' => '',
                        ]]
                    ],],
                ],
            ]
        );

        $this->add_control(
            'custom_resp',
            [
                'label' => esc_html__('Customize Responsive', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'heading_desktop',
            [
                'label' => esc_html__('Desktop Settings', 'bighearts-core'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['custom_resp!' => ''],
            ]
        );

        $this->add_control(
            'resp_medium',
            [
                'label' => esc_html__('Desktop Screen Breakpoint', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['custom_resp!' => ''],
                'min' => 500,
                'default' => '1025',
            ]
        );

        $this->add_control(
            'resp_medium_slides',
            [
                'label' => esc_html__('Slides to show', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['custom_resp!' => ''],
                'min' => 1,
            ]
        );

        $this->add_control(
            'heading_tablet',
            [
                'label' => esc_html__('Tablet Settings', 'bighearts-core'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['custom_resp!' => ''],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'resp_tablets',
            [
                'label' => esc_html__('Tablet Screen Breakpoint', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['custom_resp!' => ''],
                'min' => 400,
                'default' => '993',
            ]
        );

        $this->add_control(
            'resp_tablets_slides',
            [
                'label' => esc_html__('Slides to show', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['custom_resp!' => ''],
                'min' => 1,
            ]
        );

        $this->add_control(
            'heading_mobile',
            [
                'label' => esc_html__('Mobile Settings', 'bighearts-core'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['custom_resp!' => ''],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'resp_mobile',
            [
                'label' => esc_html__('Mobile Screen Breakpoint', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['custom_resp!' => ''],
                'min' => 1,
                'default' => '601',
            ]
        );

        $this->add_control(
            'resp_mobile_slides',
            [
                'label' => esc_html__('Slides to show', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['custom_resp!' => ''],
                'min' => 1,
            ]
        );

        $this->end_controls_section();

        /** SETTINGS -> QUERY */

        $enabled_tags = give_is_setting_enabled(give_get_option('tags', 'disabled'));

        Wgl_Loop_Settings::init(
            $this,
            [
                'post_type' => 'give_forms',
                'ignore_sticky_posts' => 1,
                'hide_cats' => true,
                'hide_tags' => true,
                'hide_tax' => $enabled_cats ? !$enabled_cats : !$enabled_tags, // evaluates to `true` if either cats or tags is enabled
            ]
        );

        /** STYLE -> WIDGET TITLE */

        $this->start_controls_section(
            'section_style_widget_title',
            [
                'label' => esc_html__('Widget Title', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [[
                        'terms' => [[
                            'name' => 'widget_title',
                            'operator' => '!=',
                            'value' => '',
                        ]]
                    ], [
                        'terms' => [[
                            'name' => 'widget_subtitle',
                            'operator' => '!=',
                            'value' => '',
                        ]]
                    ],],
                ],
            ]
        );

        $this->add_control(
            'widget_title_heading',
            [
                'label' => esc_html__('Title', 'bighearts-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'widget_title',
                'selector' => '{{WRAPPER}} .wgl-donation__title',
            ]
        );

        $this->add_control(
            'widget_title_color',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-donation__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'widget_title_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 20,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-donation__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'widget_subtitle_heading',
            [
                'label' => esc_html__('Subtitle', 'bighearts-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'widget_subtitle',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => ['default' => [
                        'size' => 30
                    ]],
                    'line_height' => ['default' => [
                        'size' => 1.2,
                        'unit' => 'em'
                    ]],
                    'letter_spacing' => ['default' => [
                        'size' => 0.05,
                        'unit' => 'em'
                    ]],
                ],
                'selector' => '{{WRAPPER}} .wgl-donation__subtitle',
            ]
        );

        $this->add_control(
            'widget_subtitle_color',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffac00',
                'selectors' => [
                    '{{WRAPPER}} .wgl-donation__subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'widget_subtitle_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 10,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-donation__subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /** STYLE -> ITEMS */

        $this->start_controls_section(
            'section_style_item',
            [
                'label' => esc_html__('Items', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'item_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem'],
                'default' => [
                    'top' => 20,
                    'right' => 0,
                    'bottom' => 30,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .card__container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem'],
                'default' => [
                    'top' => 20,
                    'right' => 20,
                    'bottom' => 30,
                    'left' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .card__container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'item_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-donation__card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        /** @since 1.0.6 */
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item',
                'selector' => '{{WRAPPER}} .wgl-donation__card .card__container',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item',
                'selector' => '{{WRAPPER}} .wgl-donation__card:not([aria-hidden="true"]) .card__container',
            ]
        );

        $this->end_controls_section();

        /** STYLE -> MEDIA */

        $this->start_controls_section(
            'section_style_media',
            [
                'label' => esc_html__('Media', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['hide_media' => ''],
            ]
        );

        $this->add_responsive_control(
            'media_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'tablet_default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 20,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .card__media' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'media_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .card__media' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'media_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .card__media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /** STYLE -> CATEGORIES */

        $this->start_controls_section(
            'section_style_categories',
            [
                'label' => esc_html__('Categories', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['hide_cats!' => 'yes'],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'cat',
                'selector' => '{{WRAPPER}} .post_categories a',
            ]
        );

        $this->add_responsive_control(
            'cat_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post_categories' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cat_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post_categories a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'cat_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post_categories a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'category',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'cat_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'cat_color_idle',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .post_categories a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'cat_bg_idle',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .post_categories a' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'category_idle',
                'selector' => '{{WRAPPER}} .post_categories a',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'cat_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'cat_color_hover',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .post_categories a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'cat_bg_hover',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .post_categories a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'category_hover',
                'selector' => '{{WRAPPER}} .post_categories a:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /** STYLE -> TITLE */

        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Title', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['hide_title' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_family' => ['default' => \Wgl_Addons_Elementor::$typography_1['font_family']],
                    'font_weight' => ['default' => \Wgl_Addons_Elementor::$typography_1['font_weight']],
                ],
                'selector' => '{{WRAPPER}} .card__title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 11,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .card__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .card__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'title',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'title_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        /**
         * @since 1.0.0
         * @version 1.0.6
         */
        $this->add_control(
            'title_color_idle',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .card__title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'title_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        /**
         * @since 1.0.0
         * @version 1.0.6
         */
        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .card__title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /** STYLE -> EXCERPT | CONTENT */

        $this->start_controls_section(
            'section_style_excerpt',
            [
                'label' => esc_html__('Excerpt | Content', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'hide_excerpt' => '' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt',
                'selector' => '{{WRAPPER}} .card__excerpt',
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .card__excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'excerpt_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .card__excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'excerpt_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .card__excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /** STYLE -> GOAL BAR */

        $this->start_controls_section(
            'section_style_goal_bar',
            [
                'label' => esc_html__('Goal Bar', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'hide_goal_bar' => '' ],
            ]
        );

        $this->add_responsive_control(
            'bar_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 42,
                    'right' => 0,
                    'bottom' => 20,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .progress__bar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'bar_filled_bg',
            [
                'label' => esc_html__('Filled Bar Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .bar__container' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'bar_empty_bg',
            [
                'label' => esc_html__('Empty Bar Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#eaeaea',
                'selectors' => [
                    '{{WRAPPER}} .progress__bar' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'bar_label_color',
            [
                'label' => esc_html__('Label Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .bar__label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /** STYLE -> GOAL STATS */

        $this->start_controls_section(
            'section_style_goal_stats',
            [
                'label' => esc_html__('Goal Stats', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['hide_goal_stats' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'stats',
                'selector' => '{{WRAPPER}} .progress__stats',
            ]
        );

        $this->add_responsive_control(
            'stats_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'mobile_default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .progress__stats' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'stats_goal_color',
            [
                'label' => esc_html__('Goal Value Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .stats__info .stats__value' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'stats_raised_color',
            [
                'label' => esc_html__('Raised Value Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => \BigHearts_Theme_Helper::average_between_two_colors(
                    BigHearts_Globals::get_primary_color(),
                    BigHearts_Globals::get_secondary_color()
                ),
                'selectors' => [
                    '{{WRAPPER}} .stats__raised .stats__value' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'stats_lack_color',
            [
                'label' => esc_html__('Remained value Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .stats__lack .stats__value' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'stats_labels_color',
            [
                'label' => esc_html__('Labels Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .stats__label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        ( new WGL_Give_Donations() )->render( $this->get_settings_for_display() );
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
