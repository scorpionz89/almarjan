<?php
/**
 * This template can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/widgets/wgl-portfolio.php`.
 */
namespace WglAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

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
    Templates\WglPortfolio
};

class Wgl_Portfolio extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-portfolio';
    }

    public function get_title()
    {
        return esc_html__('WGL Portfolio', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-portfolio';
    }

    public function get_categories()
    {
        return ['wgl-extensions'];
    }

    public function get_script_depends()
    {
        return [
            'slick',
            'imagesloaded',
            'isotope',
            'wgl-elementor-extensions-widgets',
        ];
    }

    protected function register_controls()
    {
        /**
         * CONTENT -> GENERAL
         */

        $this->start_controls_section(
            'wgl_portfolio_section',
            ['label' => esc_html__('General', 'bighearts-core')]
        );

        $this->add_control(
            'portfolio_layout',
            [
                'label' => esc_html__('Layout', 'bighearts-core'),
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
                    'masonry' => [
                        'title' => esc_html__('Masonry', 'bighearts-core'),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/layout_masonry.png',
                    ],
                    'masonry2' => [
                        'title' => esc_html__('Masonry 2', 'bighearts-core'),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/layout_masonry_2.png',
                    ],
                    'masonry3' => [
                        'title' => esc_html__('Masonry 3', 'bighearts-core'),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/layout_masonry_3.png',
                    ],
                    'masonry4' => [
                        'title' => esc_html__('Masonry 4', 'bighearts-core'),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/layout_masonry_4.png',
                    ],
                ],
                'default' => 'grid',
            ]
        );

        $this->add_control(
            'posts_per_row',
            [
                'label' => esc_html__('Columns Amount', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '1' => esc_html__('1', 'bighearts-core'),
                    '2' => esc_html__('2', 'bighearts-core'),
                    '3' => esc_html__('3', 'bighearts-core'),
                    '4' => esc_html__('4', 'bighearts-core'),
                    '5' => esc_html__('5', 'bighearts-core'),
                ],
                'default' => '3',
                'condition' => [
                    'portfolio_layout' => ['grid', 'masonry', 'carousel']
                ],
            ]
        );

        $this->add_control(
            'grid_gap',
            [
                'label' => esc_html__('Grid Gap', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '0px' => esc_html__('0', 'bighearts-core'),
                    '1px' => esc_html__('1', 'bighearts-core'),
                    '2px' => esc_html__('2', 'bighearts-core'),
                    '3px' => esc_html__('3', 'bighearts-core'),
                    '4px' => esc_html__('4', 'bighearts-core'),
                    '5px' => esc_html__('5', 'bighearts-core'),
                    '10px' => esc_html__('10', 'bighearts-core'),
                    '15px' => esc_html__('15', 'bighearts-core'),
                    '20px' => esc_html__('20', 'bighearts-core'),
                    '25px' => esc_html__('25', 'bighearts-core'),
                    '30px' => esc_html__('30', 'bighearts-core'),
                    '35px' => esc_html__('35', 'bighearts-core'),
                ],
                'default' => '30px',
            ]
        );

        $this->add_control(
            'show_filter',
            [
                'label' => esc_html__('Show Filter', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['portfolio_layout!' => 'carousel'],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'add_max_width_filter',
            [
                'label' => esc_html__('Limit the Filter Container Width', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['show_filter' => 'yes'],
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'max_width_filter',
            [
                'label' => esc_html__('Filter Container Max Width (px)', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => [
                    'show_filter' => 'yes',
                    'add_max_width_filter' => 'yes',
                ],
                'default' => '1170',
                'selectors' => [
                    '{{WRAPPER}} .portfolio__filter' => 'max-width: {{VALUE}}px; margin-left: auto; margin-right: auto;',
                ],
            ]
        );

        $this->add_control(
            'filter_align',
            [
                'label' => esc_html__('Filter Align', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'portfolio_layout!' => 'carousel',
                    'show_filter' => 'yes',
                ],
                'options' => [
                    'left' => esc_html__('Left', 'bighearts-core'),
                    'center' => esc_html__('Сenter', 'bighearts-core'),
                    'right' => esc_html__('Right', 'bighearts-core'),
                ],
                'default' => 'center',
            ]
        );

        $this->add_control(
            'img_size_string',
            [
                'label' => esc_html__('Image Size', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'portfolio_layout' => ['grid', 'carousel']
                ],
                'separator' => 'before',
                'options' => [
                    '150' => esc_html__('Thumbnail - 150x150', 'bighearts-core'),
                    '300' => esc_html__('Medium - 300x300', 'bighearts-core'),
                    '768' => esc_html__('Medium Large - 768x768', 'bighearts-core'),
                    '1024' => esc_html__('Large - 1024x1024', 'bighearts-core'),
                    '740x740' => esc_html__('740x740 - 3 Columns', 'bighearts-core'),
                    '770x460' => esc_html__('770x460', 'bighearts-core'), // slider variable width
                    '886x886' => esc_html__('886x886 - 4 Columns Wide', 'bighearts-core'),
                    '1140x840' => esc_html__('1140x840 - 2 Columns', 'bighearts-core'),
                    'full' => esc_html__('Full', 'bighearts-core'),
                    'custom' => esc_html__('Custom', 'bighearts-core'),
                ],
                'default' => '740x740',
            ]
        );

        $this->add_control(
            'img_size_array',
            [
                'label' => esc_html__('Image Dimension', 'bighearts-core'),
                'type' => Controls_Manager::IMAGE_DIMENSIONS,
                'condition' => [
                    'img_size_string' => 'custom',
                    'portfolio_layout' => ['grid', 'carousel']
                ],
                'description' => esc_html__('Crop the original image to any custom size. You can also set a single value for width to keep the initial ratio.', 'bighearts-core'),
                'default' => [
                    'width' => '740',
                    'height' => '940',
                ]
            ]
        );

        $this->add_control(
            'img_aspect_ratio',
            [
                'label' => esc_html__('Image Aspect Ratio', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'portfolio_layout' => ['grid', 'carousel'],
                    'img_size_string!' => 'custom'
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
            'navigation',
            [
                'label' => esc_html__('Navigation Type', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['portfolio_layout!' => 'carousel'],
                'separator' => 'before',
                'options' => [
                    'none' => esc_html__('None', 'bighearts-core'),
                    'pagination' => esc_html__('Pagination', 'bighearts-core'),
                    'infinite' => esc_html__('Infinite Scroll', 'bighearts-core'),
                    'load_more' => esc_html__('Load More', 'bighearts-core'),
                    'custom_link' => esc_html__('Custom Link', 'bighearts-core'),
                ],
                'default' => 'none',
            ]
        );

        $this->add_control(
            'item_link',
            [
                'label' => esc_html__('Link', 'bighearts-core'),
                'type' => Controls_Manager::URL,
			    'dynamic' => [  'active' => true],
                'condition' => ['navigation' => 'custom_link'],
                'placeholder' => esc_attr__('https://your-link.com', 'bighearts-core'),
                'default' => ['url' => '#'],
            ]
        );

        $this->add_control(
            'link_position',
            [
                'label' => esc_html__('Link Position', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['navigation' => 'custom_link'],
                'options' => [
                    'below_items' => esc_html__('Below Items', 'bighearts-core'),
                    'after_items' => esc_html__('After Items', 'bighearts-core'),
                ],
                'default' => 'below_items',
            ]
        );

        $this->add_control(
            'link_align',
            [
                'label' => esc_html__('Link Alignment', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['navigation' => 'custom_link'],
                'options' => [
                    'left' => esc_html__('Left', 'bighearts-core'),
                    'center' => esc_html__('Сenter', 'bighearts-core'),
                    'right' => esc_html__('Right', 'bighearts-core'),
                ],
                'default' => 'left',
            ]
        );

        $this->add_responsive_control(
            'link_margin',
            [
                'label' => esc_html__('Spacing', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => ['navigation' => 'custom_link'],
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 0,
                    'left' => 0,
                    'right' => 0,
                    'bottom' => 60,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-portfolio_item_link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'nav_align',
            [
                'label' => esc_html__( 'Alignment', 'bighearts-core' ),
                'type' => Controls_Manager::SELECT,
                'condition' => ['navigation' => 'pagination'],
                'options' => [
                    'left' => esc_html__('Left', 'bighearts-core'),
                    'center' => esc_html__('Сenter', 'bighearts-core'),
                    'right' => esc_html__('Right', 'bighearts-core'),
                ],
                'default' => 'center',
            ]
        );

        $this->add_control(
            'items_load',
            [
                'label' => esc_html__('Items to be loaded', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'condition' => [
                    'portfolio_layout!' => 'carousel',
                    'navigation' => ['load_more', 'infinite'],
                ],
                'default' => esc_html__('4', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'load_more_text',
            [
                'label' => esc_html__('Button Text', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'condition' => [
                    'portfolio_layout!' => 'carousel',
                    'navigation' => ['load_more', 'custom_link'],
                ],
                'default' => esc_html__('Load More', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'add_animation',
            [
                'label' => esc_html__('Add Appear Animation', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'appear_animation',
            [
                'label' => esc_html__('Animation Style', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['add_animation' => 'yes'],
                'options' => [
                    'fade-in' => esc_html__('Fade In', 'bighearts-core'),
                    'slide-top' => esc_html__('Slide Top', 'bighearts-core'),
                    'slide-bottom' => esc_html__('Slide Bottom', 'bighearts-core'),
                    'slide-left' => esc_html__('Slide Left', 'bighearts-core'),
                    'slide-right' => esc_html__('Slide Right', 'bighearts-core'),
                    'zoom' => esc_html__('Zoom', 'bighearts-core'),
                ],
                'default' => 'fade-in',
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> APPEARANCE
         */

        $this->start_controls_section(
            'display_section',
            ['label' => esc_html__('Appearance', 'bighearts-core')]
        );

        $this->add_control(
            'gallery_mode',
            [
                'label' => esc_html__('Gallery Mode', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'after',
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'show_portfolio_title',
            [
                'label' => esc_html__('Show Heading?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['gallery_mode' => ''],
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_meta_categories',
            [
                'label' => esc_html__('Show Categories?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['gallery_mode' => ''],
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_content',
            [
                'label' => esc_html__('Show Excerpt/Content?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['gallery_mode' => ''],
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'content_letter_count',
            [
                'label' => esc_html__('Content Limit (symbols)', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => [
                    'show_content' => 'yes',
                    'gallery_mode' => '',
                ],
                'min' => 1,
                'default' => '85',
            ]
        );

        $this->add_control(
            'info_position',
            [
                'label' => esc_html__('Meta Position', 'bighearts-core'),
                'condition' => ['gallery_mode' => ''],
                'type' => Controls_Manager::SELECT,
                'separator' => 'before',
                'options' => [
                    'inside_image' => esc_html__('within image', 'bighearts-core'),
                    'under_image' => esc_html__('beneath image', 'bighearts-core'),
                ],
                'default' => 'inside_image',
            ]
        );

        $this->add_control(
            'image_anim',
            [
                'label' => esc_html__('Meta Animation', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'info_position' => 'inside_image',
                    'gallery_mode' => ''
                ],
                'options' => [
                    'simple' => esc_html__('Simple', 'bighearts-core'),
                    'sub_layer' => esc_html__('On Sub-Layer', 'bighearts-core'),
                    'offset' => esc_html__('Side Offset', 'bighearts-core'),
                    'zoom_in' => esc_html__('Zoom In', 'bighearts-core'),
                    'outline' => esc_html__('Outline', 'bighearts-core'),
                    'always_info' => esc_html__('Visible Until Hover', 'bighearts-core'),
                ],
                'default' => 'sub_layer',
            ]
        );

        $this->add_control(
            'meta_alignment',
            [
                'label' => esc_html__('Meta Alignment', 'bighearts-core'),
                'type' => Controls_Manager::CHOOSE,
                'condition' => ['gallery_mode' => ''],
                'label_block' => true,
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
                    'justify' => [
                        'title' => esc_html__('Justified', 'bighearts-core'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .portfolio__description' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'portfolio_icon_type',
            [
                'label' => esc_html__( 'Add Meta Icon', 'bighearts-core' ),
                'type' => Controls_Manager::CHOOSE,
                'condition' => [
                    'info_position' => 'inside_image',
                    'gallery_mode' => ''
                ],
                'label_block' => false,
                'options' => [
                    '' => [
                        'title' => esc_html__( 'None', 'bighearts-core' ),
                        'icon' => 'fa fa-ban',
                    ],
                    'font' => [
                        'title' => esc_html__( 'Icon', 'bighearts-core' ),
                        'icon' => 'far fa-smile',
                    ],
                ],
                'default' => '',
            ]
        );

        $this->add_control(
            'portfolio_icon',
            [
                'label' => esc_html__('Icon', 'bighearts-core'),
                'type' => Controls_Manager::ICONS,
                'condition' => [
                    'portfolio_icon_type' => 'font',
                    'info_position' => 'inside_image',
                    'gallery_mode' => ''
                ],
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> LINKS
         */

        $this->start_controls_section(
            'section_content_links',
            [
                'label' => esc_html__('Links', 'bighearts-core'),
                'condition' => ['gallery_mode' => ''],
            ]
        );

        $this->add_control(
            'linked_image',
            [
                'label' => esc_html__('Add link on Image', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'linked_title',
            [
                'label' => esc_html__('Add link on Heading', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['show_portfolio_title!' => ''],
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'linked_icon',
            [
                'label' => esc_html__('Add link on Icon', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'portfolio_icon_type' => 'font',
                    'info_position' => 'inside_image',
                    'gallery_mode' => '',
                    'portfolio_icon!' => '',
                ],
            ]
        );

        $this->add_control(
            'link_destination',
            [
                'label' => esc_html__('Link Action', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'linked_title',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'linked_image',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'options' => [
                    'single' => esc_html__('Open Single Page', 'bighearts-core'),
                    'custom' => esc_html__('Open Custom Link', 'bighearts-core'),
                    'popup' => esc_html__('Popup the Image', 'bighearts-core'),
                ],
                'default' => 'single',
            ]
        );

        $this->add_control(
            'link_custom_notice',
            [
                'type' => Controls_Manager::RAW_HTML,
                'condition' => ['link_destination' => 'custom'],
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
                'raw' => esc_html__('Note: Specify the link in metabox section of each corresponding post.', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'link_target',
            [
                'label' => esc_html__('Open link in a new tab', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'conditions' => [
                    'terms' => [
                        [
                            'relation' => 'or',
                            'terms' => [
                                [
                                    'name' => 'linked_title',
                                    'operator' => '!==',
                                    'value' => '',
                                ],
                                [
                                    'name' => 'linked_image',
                                    'operator' => '!==',
                                    'value' => '',
                                ],
                            ],
                        ],
                        [
                            'name' => 'link_destination',
                            'operator' => '!==',
                            'value' => 'popup',
                        ],
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> CAROUSEL OPTIONS
         */

        $this->start_controls_section(
            'wgl_carousel_section',
            [
                'label' => esc_html__('Carousel Options', 'bighearts-core'),
                'condition' => ['portfolio_layout' => 'carousel'],
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
                'condition' => ['autoplay' => 'yes'],
                'min' => 1,
                'default' => '3000',
            ]
        );

        $this->add_control(
            'c_infinite_loop',
            [
                'label' => esc_html__('Infinite Loop', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'c_slide_per_single',
            [
                'label' => esc_html__('Slide per single item', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'center_mode',
            [
                'label' => esc_html__('Center Mode', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'center_info',
            [
                'label' => esc_html__('Show Center Item Info', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['center_mode' => 'yes'],
            ]
        );

        $this->add_control(
            'variable_width',
            [
                'label' => esc_html__('Variable Width', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'chess_divider_before',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => ['chess_layout!' => ''],
            ]
        );

        $this->add_control(
            'chess_layout',
            [
                'label' => esc_html__('Chess Layout', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'chess',
                'prefix_class' => 'layout-',
            ]
        );

        $this->add_control(
            'chess_offset',
            [
                'label' => esc_html__('Items Offset', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'condition' => ['chess_layout!' => ''],
                'size_units' => ['px', 'rem'],
                'range' => [
                    'px' => ['min' => 1, 'max' => 300],
                    'rem' => ['min' => 0.1, 'max' => 20, 'step' => 0.1],
                ],
                'default' => ['size' => '30'],
                'selectors' => [
                    '{{WRAPPER}} .slick-list' => 'padding-top: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}} .wgl-portfolio-list_item:nth-child(even)' => 'margin-top: -{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'chess_notice',
            [
                'type' => Controls_Manager::RAW_HTML,
                'condition' => [
                    'autoplay!' => '',
                    'chess_layout!' => '',
                ],
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
                'raw' => esc_html__('Note: even number of portfolio items is preffered.', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'chess_divider_after',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => ['chess_layout!' => ''],
            ]
        );

        $this->add_control(
            'use_pagination',
            [
                'label' => esc_html__('Add Pagination control', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'pag_type',
            [
                'label' => esc_html__('Pagination Type', 'bighearts-core'),
                'type' => 'wgl-radio-image',
                'condition' => ['use_pagination' => 'yes'],
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
                'label' => esc_html__('Pagination Top Offset', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['use_pagination' => 'yes'],
                'min' => -55,
                'max' => 55,
                'default' => 14,
                'selectors' => [
                    '{{WRAPPER}} .wgl-carousel .slick-dots' => 'margin-top: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'custom_pag_color',
            [
                'label' => esc_html__('Customize Pagination Color', 'bighearts-core'),
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
                'condition' => ['custom_pag_color' => 'yes'],
                'default' => BigHearts_Globals::get_primary_color(),
                'global' => [],
                'selectors' => [
                    '{{WRAPPER}} .pagination_circle .slick-dots li button,
                    {{WRAPPER}} .pagination_line .slick-dots li button:before,
                    {{WRAPPER}} .pagination_line_circle .slick-dots li button,
                    {{WRAPPER}} .pagination_square .slick-dots li button,
                    {{WRAPPER}} .pagination_square_border .slick-dots li button:before,
                    {{WRAPPER}} .pagination_circle_border .slick-dots li button:before' => 'background: {{VALUE}}',

                    '{{WRAPPER}} .pagination_circle_border .slick-dots li.slick-active button,
                    {{WRAPPER}} .pagination_square_border .slick-dots li.slick-active button' => 'border-color: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'use_prev_next',
            [
                'label' => esc_html__('Add Prev/Next buttons', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'arrows_center_mode',
            [
                'label' => esc_html__('Center Mode', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['use_prev_next' => 'yes'],
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'custom_resp',
            [
                'label' => esc_html__('Customize Responsive', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'heading_desktop',
            [
                'label' => esc_html__('Desktop Settings', 'bighearts-core'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['custom_resp' => 'yes'],
                'separator' => 'after',
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
                'label' => esc_html__('Columns amount', 'bighearts-core'),
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
                'separator' => 'after',
                'condition' => ['custom_resp' => 'yes'],
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
                'label' => esc_html__('Columns amount', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['custom_resp' => 'yes'],
                'min' => 1,
                'step' => 1,
            ]
        );

        $this->add_control(
            'heading_mobile',
            [
                'label' => esc_html__('Mobile Settings', 'bighearts-core'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['custom_resp' => 'yes'],
                'separator' => 'after',
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
                'default' => '600',
            ]
        );

        $this->add_control(
            'resp_mobile_slides',
            [
                'label' => esc_html__('Columns amount', 'bighearts-core'),
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
            [
                'post_type' => 'portfolio',
                'hide_cats' => true,
                'hide_tags' => true
            ]
        );

        /**
         * STYLE -> GENERAL
         */

        $this->start_controls_section(
            'media_style_section',
            [
                'label' => esc_html__( 'General', 'bighearts-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'items_padding',
            [
                'label' => esc_html__('Description Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => ['gallery_mode' => ''],
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 20,
                    'right' => 29,
                    'bottom' => 21,
                    'left' => 29,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-portfolio-item_description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'items_margin',
            [
                'label' => esc_html__('Description Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => [
                    'info_position' => 'inside_image',
                    'image_anim' => 'sub_layer',
                    'gallery_mode' => ''
                ],
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 20,
                    'right' => 20,
                    'bottom' => 20,
                    'left' => 20,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-portfolio-item_description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};width: calc(100% - {{RIGHT}}{{UNIT}} - {{LEFT}}{{UNIT}});',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'description',
                'types' => ['classic', 'gradient'],
                'condition' => [
                    'info_position' => 'under_image',
                    'gallery_mode' => ''
                ],
                'selector' => '{{WRAPPER}} .wgl-portfolio-item_description',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => 'rgba(' . \BigHearts_Theme_Helper::HexToRGB(BigHearts_Globals::get_h_font_color()) . ', 0.7)'],
                ],
            ]
        );

        $this->add_control(
            'overlay_heading',
            [
                'label' => esc_html__('Item Overlay', 'bighearts-core'),
                'type' => Controls_Manager::HEADING,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'info_position',
                            'operator' => '===',
                            'value' => 'inside_image',
                        ],
                        [
                            'name' => 'gallery_mode',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'custom_image_mask_color',
                'types' => ['classic', 'gradient'],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'terms' => [
                                [
                                    'name' => 'info_position',
                                    'operator' => '===',
                                    'value' => 'inside_image',
                                ],
                                [
                                    'name' => 'image_anim',
                                    'operator' => '!==',
                                    'value' => 'sub_layer',
                                ],
                            ],
                        ],
                        [
                            'name' => 'gallery_mode',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                'selector' => '{{WRAPPER}} .overlay',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => 'rgba(34,35,40, 0.45)'],
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'custom_desc_mask_color',
                'types' => ['classic', 'gradient'],
                'condition' => [
                    'info_position' => 'inside_image',
                    'image_anim' => 'sub_layer',
                    'gallery_mode' => ''
                ],
                'selector' => '{{WRAPPER}} .wgl-portfolio-item_description',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => 'rgba(255,255,255,1)'],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'custom_desc_mask_shadow',
                'condition' => [
                    'info_position' => 'inside_image',
                    'image_anim' => 'sub_layer',
                    'gallery_mode' => ''
                ],
                'selector' => '{{WRAPPER}} .wgl-portfolio-item_description',
                'fields_options' => [
                    'box_shadow_type' => [
                        'default' => 'yes'
                    ],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 11,
                            'vertical' => 10,
                            'blur' => 38,
                            'spread' => 0,
                            'color' => 'rgba(0,0,0,0.1)',
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'custom_desc_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'after',
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-portfolio-item_description' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'sec_overlay_color',
            [
                'label' => esc_html__('Additional Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'condition' => [
                    'info_position' => 'inside_image',
                    'image_anim' => ['outline'],
                ],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .inside_image .overlay:before' => 'box-shadow: inset 0px 0px 0px 0px {{VALUE}}',
                    '{{WRAPPER}} .inside_image:hover .overlay:before' => 'box-shadow: inset 0px 0px 0px 10px {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> FILTER
         */

        $this->start_controls_section(
            'section_style_filter',
            [
                'label' => esc_html__('Filter', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['show_filter' => 'yes'],
            ]
        );

        $this->add_responsive_control(
            'filter_cats_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 6,
                    'right' => 20,
                    'bottom' => 6,
                    'left' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .isotope-filter a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'filter_cats_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 0,
                    'right' => 10,
                    'bottom' => 0,
                    'left' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .isotope-filter a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .isotope-filter' => 'margin-bottom: calc(34px + {{BOTTOM}}{{UNIT}});',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_filter_cats',
                'selector' => '{{WRAPPER}} .isotope-filter a',
            ]
        );

        $this->start_controls_tabs('filter_cats_color_tabs');

        $this->start_controls_tab(
            'filter_cats_color_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'filter_color_idle',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .isotope-filter a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_bg_idle',
            [
                'label' => esc_html__('Background', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .isotope-filter a' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'filter_border',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' => [
                        'top' => 1,
                        'right' => 1,
                        'bottom' => 1,
                        'left' => 1,
                    ]],
                    'color' => ['default' => '#eeeeee'],
                ],
                'selector' => '{{WRAPPER}} .isotope-filter a',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'filter_cats_color_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'filter_color_hover',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_btn_color_hover(),
                'selectors' => [
                    '{{WRAPPER}} .isotope-filter a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .isotope-filter a:before' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_bg_hover',
            [
                'label' => esc_html__('Background', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .isotope-filter a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'filter_border_hover',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' => [
                        'top' => 1,
                        'right' => 1,
                        'bottom' => 1,
                        'left' => 1,
                    ]],
                    'color' => ['default' => BigHearts_Globals::get_btn_color_hover()],
                ],
                'selector' => '{{WRAPPER}} .isotope-filter a:hover',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'filter_cats_color_active',
            ['label' => esc_html__('Active', 'bighearts-core')]
        );

        $this->add_control(
            'filter_color_active',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .isotope-filter a.active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_bg_active',
            [
                'label' => esc_html__('Background', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_btn_color_idle(),
                'selectors' => [
                    '{{WRAPPER}} .isotope-filter a.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'filter_border_active',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' => [
                        'top' => 1,
                        'right' => 1,
                        'bottom' => 1,
                        'left' => 1,
                    ]],
                    'color' => ['default' => BigHearts_Globals::get_btn_color_idle()],
                ],
                'selector' => '{{WRAPPER}} .isotope-filter a.active',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'filter_cats_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 18,
                    'left' => 18,
                    'right' => 18,
                    'bottom' => 18,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .isotope-filter a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'filter_cats_shadow',
                'selector' => '{{WRAPPER}} .isotope-filter a',
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> IMAGES
         */

        $this->start_controls_section(
            'section_style_images',
            [
                'label' => esc_html__('Images', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'images_filter_enabled',
            [
                'label' => esc_html__('Use Image Filters', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->start_controls_tabs(
            'images',
            ['condition' => ['images_filter_enabled!' => '']]
        );

        $this->start_controls_tab(
            'tab_images_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'images_filter_grayscale_idle',
            [
                'label' => esc_html__('Grayscale Filter', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.1],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-portfolio-item_image img' => 'filter: grayscale({{SIZE}});',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_images_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'images_filter_grayscale_hover',
            [
                'label' => esc_html__('Grayscale Filter', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => 0.1],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-portfolio-item_wrapper:hover .wgl-portfolio-item_image img' => 'filter: grayscale({{SIZE}});',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> HEADINGS
         */

        $this->start_controls_section(
            'section_style_headings',
            [
                'label' => esc_html__('Headings', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_portfolio_title!' => '',
                    'gallery_mode' => ''
                ],
            ]
        );

        $this->add_responsive_control(
            'headings_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-item__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'headings',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_family' => ['default' => \Wgl_Addons_Elementor::$typography_1['font_family']],
                    'font_weight' => ['default' => \Wgl_Addons_Elementor::$typography_1['font_weight']],
                ],
                'selector' => '{{WRAPPER}} .title',
            ]
        );

        $this->start_controls_tabs('headings');

        $this->start_controls_tab(
            'tab_headings_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'headings_color_idle',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .title,
                     {{WRAPPER}} .inside_image .portfolio-item__title .title a:not(:hover)' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .title:before' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_headings_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'headings_color_hover',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .title:hover,
                     {{WRAPPER}} .title:hover a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> CATEGORIES
         */

        $this->start_controls_section(
            'cats_style_section',
            [
                'label' => esc_html__('Categories', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['show_meta_categories!' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'categories',
                'selector' => '{{WRAPPER}} .portfolio-category',
            ]
        );

        $this->start_controls_tabs('categories');

        $this->start_controls_tab(
            'tab_categories_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'cat_color_idle',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .portfolio-category' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .portfolio-category' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_categories_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'cat_color_hover',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .portfolio-category:hover' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .portfolio-category:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'cat_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 0,
                    'right' => 10,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cat_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> EXCERPT/CONTENT
         */

        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__('Excerpt/Content', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['show_content!' => ''],
            ]
        );

        $this->add_control(
            'custom_content_color',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .wgl-portfolio-item_content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> LOAD MORE
         */

        $this->start_controls_section(
            'load_more_style_section',
            [
                'label' => esc_html__('Load More', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['navigation' => 'load_more'],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_load_more',
                'selector' => '{{WRAPPER}} .load_more_wrapper .load_more_item',
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
                'separator' => 'before',
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 30,
                    'left' => 0,
                    'right' => 0,
                    'bottom' => 0,
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
                    '{{WRAPPER}} .load_more_wrapper .load_more_item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .load_more_wrapper .load_more_item' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_bg_idle',
            [
                'label' => esc_html__('Background', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .load_more_wrapper .load_more_item' => 'background: {{VALUE}};',
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
                    '{{WRAPPER}} .load_more_wrapper .load_more_item:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_bg_hover',
            [
                'label' => esc_html__('Background', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .load_more_wrapper .load_more_item:hover' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'load_more_border',
                'label' => esc_html__('Border Type', 'bighearts-core'),
                'separator' => 'before',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' => [
                        'top' => 2,
                        'right' => 2,
                        'bottom' => 2,
                        'left' => 2,
                    ]],
                    'color' => ['default' => BigHearts_Globals::get_primary_color()],
                ],
                'selector' => '{{WRAPPER}} .load_more_wrapper .load_more_item',
            ]
        );

        $this->add_control(
            'load_more_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'after',
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 28,
                    'right' => 28,
                    'bottom' => 28,
                    'left' => 28,
                ],
                'selectors' => [
                    '{{WRAPPER}} .load_more_wrapper .load_more_item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'load_more_shadow',
                'selector' => '{{WRAPPER}} .load_more_wrapper .load_more_item',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_meta_icon',
            [
                'label' => esc_html__('Meta Icon', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'portfolio_icon_type' => 'font',
                    'info_position' => 'inside_image',
                    'gallery_mode' => '',
                    'portfolio_icon!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'meta_icon_size',
            [
                'label' => esc_html__('Icon Size', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'range' => [
                    'px' => ['min' => 10, 'max' => 100],
                ],
                'default' => ['size' => 18, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-item__icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'meta_icon_animation',
            [
                'label' => esc_html__('Rotate Animation', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
                'return_value' => 'rotate-icon',
                'default' => 'rotate-icon',
                'prefix_class' => 'animation_',
            ]
        );

        $this->add_responsive_control(
            'meta_icon_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-item__icon > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .portfolio-item__icon > i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .portfolio-item__icon svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'meta_icon_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-item__icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('meta_icon');

        $this->start_controls_tab(
            'tab_icon_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'meta_icon_color_idle',
            [
                'label' => esc_html__('Icon Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .portfolio-item__icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .portfolio-item__icon a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .portfolio-item__icon svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'meta_icon_bg_idle',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .portfolio-item__icon' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'meta_icon_border_color_idle',
            [
                'label' => esc_html__('Border Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'condition' => ['meta_icon_border!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-item__icon' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_meta_icon_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'meta_icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-item__icon:hover,
                     {{WRAPPER}} .portfolio-item__icon:hover a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .portfolio-item__icon:hover svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'meta_icon_bg_hover',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => esc_attr(BigHearts_Globals::get_primary_color()),
                'selectors' => [
                    '{{WRAPPER}} .portfolio-item__icon:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'meta_icon_border_color_hover',
            [
                'label' => esc_html__('Border Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'condition' => ['meta_icon_border!' => ''],
                'default' => esc_attr(BigHearts_Globals::get_primary_color()),
                'selectors' => [
                    '{{WRAPPER}} .portfolio-item__icon:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'meta_icon_border_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 30,
                    'right' => 30,
                    'bottom' => 30,
                    'left' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-item__icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'meta_icon',
                'selector' => '{{WRAPPER}} .portfolio-item__icon',
                'fields_options' => [
                    'border' => ['default' => ''],
                    'width' => [
                        'default' => [
                            'top' => 1,
                            'right' => 1,
                            'bottom' => 1,
                            'left' => 1,
                        ],
                    ],
                    'color' => ['default' => '#ffffff'],
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $atts = $this->get_settings_for_display();

        echo (new WglPortfolio())->render($atts, $this);
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
