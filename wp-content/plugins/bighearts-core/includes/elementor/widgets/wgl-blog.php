<?php
/**
 * Current file can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/widgets/wgl-blog.php`.
 */
namespace WglAddons\Widgets;

defined( 'ABSPATH' ) || exit;

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Group_Control_Border,
    Group_Control_Typography,
    Group_Control_Background,
    Group_Control_Box_Shadow
};
use WglAddons\{
    BigHearts_Global_Variables as BigHearts_Globals,
    Includes\Wgl_Loop_Settings,
    Templates\WGL_Blog as Blog_Template
};

/**
 * Blog Widget
 *
 *
 * @package bighearts-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 * @version 1.1.5
 */
class Wgl_Blog extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-blog';
    }

    public function get_title()
    {
        return esc_html__('WGL Blog', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-blog';
    }

    /**
     * @since 1.1.5
     */
    public function get_keywords()
    {
        return [ 'blog' ];
    }

    public function get_script_depends()
    {
        return [
            'slick',
            'jarallax',
            'jarallax-video',
            'imagesloaded',
            'isotope',
            'wgl-elementor-extensions-widgets',
        ];
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
            ['label' => esc_html__('Layout', 'bighearts-core') ]
        );

        $this->add_control(
            'blog_title',
            [
                'label' => esc_html__('Title', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'blog_subtitle',
            [
                'label' => esc_html__('Subitle', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'separator' => 'after',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'blog_layout',
            [
                'label' => esc_html__('Layout', 'bighearts-core'),
                'type' => 'wgl-radio-image',
                'options' => [
                    'grid' => [
                        'title' => esc_html__('Grid', 'bighearts-core'),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/layout_grid.png',
                    ],
                    'masonry' => [
                        'title' => esc_html__('Masonry', 'bighearts-core'),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/layout_masonry.png',
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
            'blog_columns',
            [
                'label' => esc_html__('Grid Columns Amount', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => [
                    '12' => esc_html__('1 (one)', 'bighearts-core'),
                    '6' => esc_html__('2 (two)', 'bighearts-core'),
                    '4' => esc_html__('3 (three)', 'bighearts-core'),
                    '3' => esc_html__('4 (four)', 'bighearts-core')
                ],
                'default' => '12',
                'tablet_default' => 'inherit',
                'mobile_default' => '1',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'img_size_string',
            [
                'label' => esc_html__('Image Size', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'blog_layout' => ['grid', 'carousel']
                ],
                'separator' => 'before',
                'options' => [
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
                'default' => '1170x725',
            ]
        );

        $this->add_control(
            'img_size_array',
            [
                'label' => esc_html__('Image Dimension', 'bighearts-core'),
                'type' => Controls_Manager::IMAGE_DIMENSIONS,
                'condition' => [
                    'img_size_string' => 'custom',
                    'blog_layout' => ['grid', 'carousel'],
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
                'label' => esc_html__( 'Image Aspect Ratio', 'bighearts-core' ),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'blog_layout' => ['grid', 'carousel'],
                    'img_size_string!' => 'custom',
                ],
                'options' => [
                    '' => esc_html__( 'No Crop', 'bighearts-core' ),
                    '1:1' => esc_html__( '1:1', 'bighearts-core' ),
                    '3:2' => esc_html__( '3:2', 'bighearts-core' ),
                    '4:3' => esc_html__( '4:3', 'bighearts-core' ),
                    '6:5' => esc_html__('6:5', 'bighearts-core'),
                    '9:16' => esc_html__( '9:16', 'bighearts-core' ),
                    '16:9' => esc_html__( '16:9', 'bighearts-core' ),
                    '21:9' => esc_html__( '21:9', 'bighearts-core' ),
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
                    'blog_layout' => ['grid', 'masonry']
                ],
                'separator' => 'before',
                'options' => [
                    'none' => esc_html__('None', 'bighearts-core'),
                    'pagination' => esc_html__('Pagination', 'bighearts-core'),
                    'load_more' => esc_html__('Load More', 'bighearts-core'),
                ],
                'default' => 'none',
            ]
        );

        $this->add_responsive_control(
            'navigation_align',
            [
                'label' => esc_html__( 'Navigation\'s Alignment', 'bighearts-core' ),
                'type' => Controls_Manager::CHOOSE,
                'condition' => ['navigation_type' => 'pagination'],
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
                'default' => 'left',
                'prefix_class' => 'nav-%s',
            ]
        );

        $this->add_control(
            'navigation_offset',
            [
                'label' => esc_html__('Navigation Margin Top', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'condition' => [
                    'navigation_type' => 'pagination',
                    'blog_layout' => ['grid', 'masonry']
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

        $this->add_control(
            'items_load',
            [
                'label' => esc_html__('Items to be loaded', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => [
                    'navigation_type' => 'load_more',
                    'blog_layout' => ['grid', 'masonry']
                ],
                'min' => 1,
                'default' => 4,
            ]
        );

        $this->add_control(
            'load_more_text',
            [
                'label' => esc_html__('Button Text', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'condition' => [
                    'navigation_type' => 'load_more',
                    'blog_layout' => ['grid', 'masonry']
                ],
                'default' => esc_html__('LOAD MORE', 'bighearts-core'),
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> APPEARANCE
         */

        $this->start_controls_section(
            'section_content_appearance',
            ['label' => esc_html__('Appearance', 'bighearts-core') ]
        );

        $this->add_control(
            'hide_media',
            [
                'label' => esc_html__('Hide Media?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'media_link',
            [
                'label' => esc_html__('Clickable Image?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['hide_media' => ''],
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'hide_blog_title',
            [
                'label' => esc_html__('Hide Title?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'hide_content',
            [
                'label' => esc_html__('Hide Content?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'content_letter_count',
            [
                'label' => esc_html__('Characters Amount in Content', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['hide_content' => ''],
                'min' => 1,
                'default' => '95',
            ]
        );

        $this->add_control(
            'read_more_hide',
            [
                'label' => esc_html__('Hide \'Read More\' button?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => esc_html__('Read More Text', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'condition' => ['read_more_hide' => ''],
                'default' => esc_html__('Read More', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'hide_all_meta',
            [
                'label' => esc_html__('Hide all post meta?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'meta_author',
            [
                'label' => esc_html__('Hide author?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['hide_all_meta' => ''],
            ]
        );

        $this->add_control(
            'meta_comments',
            [
                'label' => esc_html__('Hide comments?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['hide_all_meta' => ''],
            ]
        );

        $this->add_control(
            'meta_categories',
            [
                'label' => esc_html__('Hide post-meta categories?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['hide_all_meta' => ''],
            ]
        );

        $this->add_control(
            'meta_date',
            [
                'label' => esc_html__('Hide post-meta date?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['hide_all_meta' => ''],
            ]
        );

        $this->add_control(
            'hide_views',
            [
                'label' => esc_html__('Hide Views?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'hide_likes',
            [
                'label' => esc_html__('Hide Likes?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'hide_share',
            [
                'label' => esc_html__('Hide Shares?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
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
                'condition' => ['blog_layout' => 'carousel']
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
            ]
        );

        $this->add_control(
            'slides_to_scroll',
            [
                'label' => esc_html__('Slide One Item per time', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
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
                'default' => -35,
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

        $this->add_control(
            'custom_contols_color',
            [
                'label' => esc_html__('Customize Colors', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['use_navigation!' => ''],
                'default' => 'yes',
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
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' => [
                        'top' => 2,
                        'right' => 2,
                        'bottom' => 2,
                        'left' => 2,
                    ]],
                    'color' => ['default' => BigHearts_Globals::get_secondary_color()],
                ],
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
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'color' => ['default' => BigHearts_Globals::get_primary_color()],
                ],
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
                'condition' => ['custom_resp' => 'yes'],
            ]
        );

        $this->add_control(
            'resp_medium',
            [
                'label' => esc_html__('Desktop Screen Breakpoint', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['custom_resp' => 'yes'],
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
                'condition' => ['custom_resp' => 'yes'],
                'min' => 1,
            ]
        );

        $this->add_control(
            'heading_tablet',
            [
                'label' => esc_html__('Tablet Settings', 'bighearts-core'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['custom_resp' => 'yes'],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'resp_tablets',
            [
                'label' => esc_html__('Tablet Screen Breakpoint', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['custom_resp' => 'yes'],
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
                'condition' => ['custom_resp' => 'yes'],
                'min' => 1,
            ]
        );

        $this->add_control(
            'heading_mobile',
            [
                'label' => esc_html__('Mobile Settings', 'bighearts-core'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['custom_resp' => 'yes'],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'resp_mobile',
            [
                'label' => esc_html__('Mobile Screen Breakpoint', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['custom_resp' => 'yes'],
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
                'condition' => ['custom_resp' => 'yes'],
                'min' => 1,
            ]
        );

        $this->end_controls_section();

        /**
         * SETTINGS -> QUERY
         */

        Wgl_Loop_Settings::init(
            $this,
            ['post_type' => 'post']
        );

        /**
         * STYLE -> POST ITEM
         */

        $this->start_controls_section(
            'section_style_post_item',
            [
                'label' => esc_html__('Post Item', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'content_wrapper_padding',
            [
                'label' => esc_html__('Content Section Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'after',
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .blog-post_wrapper .blog-post_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .blog-post_wrapper .blog-post_meta-wrap' => 'padding-left: {{LEFT}}{{UNIT}};'
                                                                           . 'padding-right: {{RIGHT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'post_item',
                'selector' => '{{WRAPPER}} .wgl_col-12:not(.slick-slide) .blog-post_wrapper,'
                    . '{{WRAPPER}} .wgl_col-6:not(.slick-slide) .blog-post_wrapper,'
                    . '{{WRAPPER}} .wgl_col-4:not(.slick-slide) .blog-post_wrapper,'
                    . '{{WRAPPER}} .wgl_col-3:not(.slick-slide) .blog-post_wrapper,'
                    . '{{WRAPPER}} .wgl_col-12.slick-slide[aria-hidden="false"] .blog-post_wrapper,'
                    . '{{WRAPPER}} .wgl_col-6.slick-slide[aria-hidden="false"] .blog-post_wrapper,'
                    . '{{WRAPPER}} .wgl_col-4.slick-slide[aria-hidden="false"] .blog-post_wrapper,'
                    . '{{WRAPPER}} .wgl_col-3.slick-slide[aria-hidden="false"] .blog-post_wrapper'
            ]
        );

        $this->add_control(
            'item_bg',
            [
                'label' => esc_html__('Add Item Background', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_bg',
                'label' => esc_html__('Background', 'bighearts-core'),
                'condition' => ['item_bg' => 'yes'],
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .blog-post_wrapper',
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> MODULE TITLE
         */

        $this->start_controls_section(
            'section_style_module_title',
            [
                'label' => esc_html__('Module Title', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['blog_title!' => ''],
            ]
        );

        $this->add_control(
            'heading_blog_title',
            [
                'label' => esc_html__('Title', 'bighearts-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'module_title',
                'selector' => '{{WRAPPER}} .blog_title',
            ]
        );

        $this->add_responsive_control(
            'blog_title_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .blog_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_blog_subtitle',
            [
                'label' => esc_html__('Subtitle', 'bighearts-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'module_subtitle',
                'selector' => '{{WRAPPER}} .blog_subtitle',
            ]
        );

        $this->add_responsive_control(
            'blog_subtitle_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .blog_subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> HEADING
         */

        $this->start_controls_section(
            'section_style_headings',
            [
                'label' => esc_html__( 'Heading', 'bighearts-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_blog_headings',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .blog-post_title,
                               {{WRAPPER}} .blog-post_title > a',
            ]
        );

        $this->add_control(
            'heading_tag',
            [
                'label' => esc_html__('HTML tag', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => esc_html__('‹h1›', 'bighearts-core'),
                    'h2' => esc_html__('‹h2›', 'bighearts-core'),
                    'h3' => esc_html__('‹h3›', 'bighearts-core'),
                    'h4' => esc_html__('‹h4›', 'bighearts-core'),
                    'h5' => esc_html__('‹h5›', 'bighearts-core'),
                    'h6' => esc_html__('‹h6›', 'bighearts-core'),
                ],
                'default' => 'h3',
            ]
        );

        $this->add_responsive_control(
            'heading_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .blog-post_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_headings');

        $this->start_controls_tab(
            'tab_headings_idle',
            ['label' => esc_html__('Idle', 'bighearts-core') ]
        );

        $this->add_control(
            'headings_color_idle',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .blog-post_title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_headings_hover',
            ['label' => esc_html__('Hover', 'bighearts-core') ]
        );

        $this->add_control(
            'headings_color_hover',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .blog-post_title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> EXCERPT|CONTENT
         */

        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__( 'Excerpt | Content', 'bighearts-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['hide_content' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content',
                'selector' => '{{WRAPPER}} .blog-post_text',
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .blog-post_text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_main_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .blog-post_text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> META DATA
         */

        $this->start_controls_section(
            'section_style_meta_data',
            [
                'label' => esc_html__('Meta Data', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'hide_all_meta',
                            'operator' => '==',
                            'value' => ''
                        ],
                        [
                            'relation' => 'or',
                            'terms' => [
                                [
                                    'name' => 'meta_author',
                                    'operator' => '==',
                                    'value' => ''
                                ],
                                [
                                    'name' => 'meta_comments',
                                    'operator' => '==',
                                    'value' => ''
                                ],
                                [
                                    'name' => 'meta_categories',
                                    'operator' => '==',
                                    'value' => ''
                                ],
                                [
                                    'name' => 'meta_date',
                                    'operator' => '==',
                                    'value' => ''
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'meta_data',
                'selector' => '{{WRAPPER}} .blog-post_meta-wrap',
            ]
        );

        $this->add_responsive_control(
            'meta_data_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .blog-post_meta-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'meta_data_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .blog-post .blog-post_wrapper .blog-post_meta-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'meta_data',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .blog-post_meta-wrap',
            ]
        );

        $this->start_controls_tabs(
            'tabs_meta_data',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'tab_meta_data_idle',
            ['label' => esc_html__('Idle', 'bighearts-core') ]
        );

        $this->add_control(
            'icon_meta_color_idle',
            [
                'label' => esc_html__('Icon Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .blog-post_meta-wrap .meta-data > span:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'meta_color_idle',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .blog-post_meta-wrap' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_meta_hover',
            ['label' => esc_html__('Hover', 'bighearts-core') ]
        );

        $this->add_control(
            'meta_color_hover',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .blog-post_meta-wrap a:hover,
                     {{WRAPPER}} .share_post-container:hover > a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> META DATE
         */

        $this->start_controls_section(
            'section_style_meta_date',
            [
                'label' => esc_html__('Date', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'hide_all_meta',
                            'operator' => '==',
                            'value' => ''
                        ],
                        [
                            'relation' => 'or',
                            'terms' => [
                                [
                                    'name' => 'meta_date',
                                    'operator' => '==',
                                    'value' => ''
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'meta_date',
                'selector' => '{{WRAPPER}} .meta-data .post_date',
            ]
        );

        $this->add_responsive_control(
            'meta_date_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .meta-data .post_date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'meta_date_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .meta-data .post_date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'meta_date',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .meta-data .post_date',
            ]
        );

        $this->add_control(
            'meta_date_color_idle',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .meta-data .post_date' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> MEDIA
         */

        $this->start_controls_section(
            'section_style_media',
            [
                'label' => esc_html__('Media', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['hide_media' => ''],
            ]
        );

        $this->add_control(
            'media_overlay_idle',
            [
                'label' => esc_html__('Image Overlay Idle', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'selectors' => [
                    '{{WRAPPER}} .format-standard-image .image-overlay:before' => 'content: \'\'',
                    '{{WRAPPER}} .format-image .image-overlay:before' => 'content: \'\'',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'media_overlay_idle',
                'condition' => ['media_overlay_idle!' => ''],
                'selector' => '{{WRAPPER}} .image-overlay:before',
            ]
        );

        $this->add_control(
            'media_overlay_hover',
            [
                'label' => esc_html__('Image Hover Overlay', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .format-standard-image .image-overlay:after' => 'content: \'\'',
                    '{{WRAPPER}} .format-image .image-overlay:after' => 'content: \'\'',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'media_overlay_hover',
                'condition' => ['media_overlay_hover!' => ''],
                'default' => 'rgba(14,21,30,.6)',
                'selector' => '{{WRAPPER}} .image-overlay:after',
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> READ MORE BUTTON
         */

        $this->start_controls_section(
            'section_style_read_more',
            [
                'label' => esc_html__( 'Read More Button', 'bighearts-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['read_more_hide' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'read_more',
                'selector' => '{{WRAPPER}} .button-read-more',
            ]
        );

        $this->add_responsive_control(
            'read_more_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .read-more-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'read_more_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .read-more-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_read_more',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'tab_read_more_idle',
            ['label' => esc_html__('Idle', 'bighearts-core') ]
        );

        $this->add_control(
            'read_more_color_idle',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .button-read-more' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_extra_idle',
            [
                'label' => esc_html__('Extra Element Background', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .button-read-more:before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_read_more_hover',
            ['label' => esc_html__('Hover', 'bighearts-core') ]
        );

        $this->add_control(
            'read_more_color_hover',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .button-read-more:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_extra_hover',
            [
                'label' => esc_html__('Extra Element Background', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .button-read-more:hover:before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .button-read-more:hover:after' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> LOAD MORE BUTTON
         */

        $this->start_controls_section(
            'section_style_load_more',
            [
                'label' => esc_html__( 'Load More Button', 'bighearts-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'navigation_type' => 'load_more',
                    'blog_layout' => ['grid', 'masonry'],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'load_more',
                'selector' => '{{WRAPPER}} .load_more_item > span',
            ]
        );

        $this->add_control(
            'align_load_more',
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
                'selectors' => [
                    '{{WRAPPER}} .load_more_wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'load_more_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 10,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .load_more_wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'load_more_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .load_more_item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_load_more',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'load_more_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'load_more_color_idle',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .load_more_item' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_bg_idle',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .load_more_item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'load_more_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'load_more_color_hover',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .load_more_item:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_bg_hover',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .load_more_item:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'load_more_border',
                'separator' => 'before',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' => [
                        'top' => 2,
                        'right' => 2,
                        'bottom' => 2,
                        'left' => 2,
                    ]],
                    'color' => [
                        'default' => BigHearts_Globals::get_secondary_color()
                    ],
                ],
                'selector' => '{{WRAPPER}} .load_more_item',
            ]
        );

        $this->add_control(
            'load_more_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 28,
                    'right' => 28,
                    'bottom' => 28,
                    'left' => 28,
                ],
                'selectors' => [
                    '{{WRAPPER}} .load_more_item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'load_more_shadow',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .load_more_item',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        echo ( new Blog_Template() )->render( $this->get_settings_for_display() );
    }

    /**
     * @since 1.1.5
     */
    public function wpml_support_module() {
        add_filter( 'wpml_elementor_widgets_to_translate',  [$this, 'wpml_widgets_to_translate_filter']);
    }

    /**
     * @since 1.1.5
     */
    public function wpml_widgets_to_translate_filter( $widgets ){
        return \WglAddons\Includes\WGL_WPML_Settings::get_translate(
            $this, $widgets
        );
    }
}
