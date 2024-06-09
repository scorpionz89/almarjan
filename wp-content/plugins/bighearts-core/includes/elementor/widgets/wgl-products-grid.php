<?php
/*
 * This template can be overridden by copying it to yourtheme/bighearts-core/elementor/widgets/wgl-products-grid.php.
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
    Includes\WGL_Loop_Settings,
    Templates\WGLProductsGrid
};

class Wgl_Products_Grid extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-products-grid';
    }

    public function get_keywords() {
        return ['products', 'shop', 'woocommerce'];
    }

    public function get_title()
    {
        return esc_html__('WGL Products Grid', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-products-grid';
    }

    public function get_categories()
    {
        return ['wgl-extensions'];
    }

    public function get_script_depends()
    {
        return ['jquery-appear'];
    }

    protected function register_controls()
    {
        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_general',
            ['label' => esc_html__('General', 'bighearts-core')]
        );

        $this->add_control(
            'products_layout',
            [
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

        $this->add_responsive_control(
            'grid_columns',
            [
                'label' => esc_html__('Grid Columns Amount', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'label_block' => true,
                'render_type' => 'template',
                'options' => [
                    '1' => esc_html__('1 / One', 'bighearts-core'),
                    '2' => esc_html__('2 / Two', 'bighearts-core'),
                    '3' => esc_html__('3 / Three', 'bighearts-core'),
                    '4' => esc_html__('4 / Four', 'bighearts-core'),
                    '5' => esc_html__('5 / Five', 'bighearts-core'),
                    '6' => esc_html__('6 / Six', 'bighearts-core'),
                ],
                'default' => '4',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'prefix_class' => 'columns%s-'
            ]
        );

        $this->add_control(
            'img_size_string',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Image Size', 'bighearts-core'),
                'options' => [
                    '150' => 'Thumbnail - 150x150',
                    '300' => 'Medium - 300x300',
                    '768' => 'Medium Large - 768x768',
                    '1024' => 'Large - 1024x1024',
                    '536x536' => '536x536', // 3col
                    'full' => 'Full',
                    'custom' => 'Custom',
                ],
                'default' => '536x536', // 3col
            ]
        );

        $this->add_control(
            'img_size_array',
            [
                'label' => esc_html__('Image Dimension', 'bighearts-core'),
                'type' => Controls_Manager::IMAGE_DIMENSIONS,
                'description' => esc_html__('You can crop the original image size to any custom size. You can also set a single value for height or width in order to keep the original size ratio.', 'bighearts-core'),
                'condition' => [
                    'img_size_string' => 'custom',
                ],
                'default' => [
                    'width' => '536',
                    'height' => '536',
                ]
            ]
        );

        $this->add_control(
            'img_aspect_ratio',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Image Aspect Ratio', 'bighearts-core'),
                'options' => [
                    '1:1' => '1:1',
                    '3:2' => '3:2',
                    '4:3' => '4:3',
                    '6:5' => '6:5',
                    '9:16' => '9:16',
                    '16:9' => '16:9',
                    '21:9' => '21:9',
                    '' => 'Not Crop',
                ],
                'default' => '',
            ]
        );

        $this->add_control(
            'show_header_products',
            array(
                'label' => esc_html__('Show Header Shop', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
                'return_value' => 'yes',
            )
        );

        $this->add_control(
            'show_res_count',
            array(
                'label' => esc_html__('Show Result Count', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
                'return_value' => 'yes',
                'condition' => [
                    'show_header_products' => 'yes'
                ]
            )
        );

        $this->add_control(
            'show_sorting',
            array(
                'label' => esc_html__('Show Default Sorting', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
                'return_value' => 'yes',
                'condition' => [
                    'show_header_products' => 'yes'
                ]
            )
        );

        $this->add_control(
            'isotope_filter',
            [
                'label' => esc_html__('Use Filter?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => ['products_layout!' => 'carousel'],
            ]
        );

        $this->add_control(
            'products_navigation',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Navigation', 'bighearts-core'),
                'options' => [
                    '' => 'None',
                    'pagination' => 'Pagination',
                    'load_more' => 'Load More',
                ],
                'default' => '',
                'condition' => ['products_layout!' => 'carousel'],
            ]
        );

        $this->add_control(
            'items_load',
            array(
                'label' => esc_html__('Items to be loaded', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'default' => esc_html__('4', 'bighearts-core'),
                'condition' => [
                    'products_navigation' => 'load_more',
                    'products_layout!' => 'carousel'
                ]
            )
        );

        $this->add_control(
            'name_load_more',
            array(
                'label' => esc_html__('Button Text', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'default' => esc_html__('Load More', 'bighearts-core'),
                'condition' => [
                    'products_navigation' => 'load_more',
                    'products_layout!' => 'carousel'
                ]
            )
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> CAROUSEL OPTIONS
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_carousel',
            [
                'label' => esc_html__('Carousel Options', 'bighearts-core'),
                'condition' => ['products_layout' => 'carousel']
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
            'infinity_on_the_right',
            [
                'label' => esc_html__('Infinity on the Right', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
                'prefix_class' => 'infinity_',
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
            'slide_single',
            [
                'label' => esc_html__('Slide One Item per time', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'pag_divider_before',
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
                'default' => 'yes'
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
                'default' => '',
            ]
        );

        $this->add_control(
            'pag_divider_after',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => ['use_pagination!' => ''],
            ]
        );

        $this->add_control(
            'use_navigation',
            [
                'label' => esc_html__('Add Navigation controls', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  SETTINGS -> QUERY
        /*-----------------------------------------------------------------------------------*/

        Wgl_Loop_Settings::init(
            $this,
            [
                'post_type' => 'product',
                'hide_tags' => true,
                'hide_cats' => true,
            ]
        );

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_item',
            [
                'label' => esc_html__('General', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'products_gap',
            [
                'label' => esc_html__('Products Gap', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 60, 'step' => 2],
                ],
                'desktop_default' => ['size' => 30, 'unit' => 'px'],
                'tablet_default' => ['size' => 30, 'unit' => 'px'],
                'mobile_default' => ['size' => 0, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} ul.wgl-products' => '--products-gap: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__('Product Inner Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} li.product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'item_radius',
            [
                'label' => esc_html__('Product Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} li.product' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs('tabs_item');

        $this->start_controls_tab(
            'tab_item_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'item_bg_color_idle',
            [
                'label' => esc_html__('Item Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} li.product' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_shadow_idle',
                'selector' => '{{WRAPPER}} li.product:before',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_item_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'item_bg_color_hover',
            [
                'label' => esc_html__('Item Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} li.product:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_shadow_hover',
                'selector' => '{{WRAPPER}} li.product:after',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Content Padding', 'bighearts-core'),
                'separator' => 'before',
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .woo_product_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'content_radius',
            [
                'label' => esc_html__('Content Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .woo_product_content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> IMAGE
		/*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_image',
            [
                'label' => esc_html__('Image', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} li.product .picture,
                     {{WRAPPER}} li.product .picture img,
				     {{WRAPPER}} li.product .picture .woo_post-link,
				     {{WRAPPER}} li.product .picture:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'secondary_image',
            [
                'label' => esc_html__('Show Secondary Image on Hover', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'render_type' => 'template',
                'selectors' => [
                    '{{WRAPPER}} li.product .picture img.attachment-shop_catalog' => 'display: block;',
                ],
            ]
        );

        $this->add_control(
            'image_bg_color',
            [
                'label' => esc_html__('image Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} li.product .picture' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'image_opacity_hover',
            [
                'label' => esc_html__('Image Transparency on Hover', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1, 'step' => .02],
                ],
                'selectors' => [
                    '{{WRAPPER}} li.product:hover .picture .woo_post-link' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_image');

        $this->start_controls_tab(
            'tab_image_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_shadow_idle',
                'selector' => '{{WRAPPER}} li.product .picture:before',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_image_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_shadow_hover',
                'selector' => '{{WRAPPER}} li.product .picture:after',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> TITLE
		/*-----------------------------------------------------------------------------------*/

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
                'name' => 'title',
                'selector' => '{{WRAPPER}} .woocommerce-loop-product__title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-loop-product__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_title');

        $this->start_controls_tab(
            'tab_title_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'title_color_idle',
            [
                'label' => esc_html__('Title Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-loop-product__title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'htitle_color_hover',
            [
                'label' => esc_html__('Title Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-loop-product__title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> PRICE
		/*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_price',
            [
                'label' => esc_html__('Price', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price',
                'selector' => '{{WRAPPER}} ul.wgl-products .woocommerce-Price-amount, {{WRAPPER}} ul.wgl-products .price',
            ]
        );

        $this->add_responsive_control(
            'price_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} ul.wgl-products .price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_price');

        $this->start_controls_tab(
            'tab_price_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'price_color_idle',
            [
                'label' => esc_html__('Price Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} ul.wgl-products .price' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'old_price_color_idle',
            [
                'label' => esc_html__('Old Price Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} ul.wgl-products .price del' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_price_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'price_color_hover',
            [
                'label' => esc_html__('Price Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} ul.wgl-products li.product:hover .price' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'old_price_color_hover',
            [
                'label' => esc_html__('Old Price Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} ul.wgl-products li.product:hover .price del' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> BUTTON
		/*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_button',
            [
                'label' => esc_html__('Button', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button',
                'selector' => '{{WRAPPER}} li.product a.button',
            ]
        );

        $this->add_control(
            'button_width',
            [
                'label' => esc_html__('Min Width', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => 50, 'max' => 400],
                    '%' => ['min' => 10, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} li.product a.button,
				     {{WRAPPER}} li.product a.wc-forward' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} li.product a.button,
				     {{WRAPPER}} li.product a.wc-forward' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} li.product a.button,
				     {{WRAPPER}} li.product a.wc-forward' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_button');

        $this->start_controls_tab(
            'tab_button_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'button_color_idle',
            [
                'label' => esc_html__('Button Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} li.product a.button,
				     {{WRAPPER}} li.product a.wc-forward' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_color_idle',
            [
                'label' => esc_html__('Button Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} li.product a.button,
				     {{WRAPPER}} li.product a.wc-forward' => 'background-color: {{VALUE}};',
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
                'label' => esc_html__('Button Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} li.product a.button:hover,
				     {{WRAPPER}} li.product a.wc-forward:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_color_hover',
            [
                'label' => esc_html__('Button Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} li.product a.button:hover,
				     {{WRAPPER}} li.product a.wc-forward:hover' => 'background-color: {{VALUE}};',
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
            'style_load_more',
            [
                'label' => esc_html__('Load More Button', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['products_navigation' => 'load_more'],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'load_more',
                'selector' => '{{WRAPPER}} .load_more_item',
            ]
        );

        $this->add_control(
            'load_more_alignment',
            [
                'label' => esc_html__('Alignment', 'bighearts-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'bighearts-core'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'bighearts-core'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'bighearts-core'),
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

        $this->add_control(
            'load_more_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .load_more_item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'load_more_btn',
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

        $this->add_control(
            'load_more_animated_element_color_idle',
            [
                'label' => esc_html__('Animated Element Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .load_more_item:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'load_more_border',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .load_more_item',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'load_more_shadow',
                'selector' => '{{WRAPPER}} .load_more_item',
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
                    '{{WRAPPER}} .load_more_wrapper .load_more_item:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_animated_element_color_hover',
            [
                'label' => esc_html__('Animated Element Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .load_more_item:hover:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'load_more_border:hover',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .load_more_item:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'load_more_shadow:hover',
                'selector' => '{{WRAPPER}} .load_more_item:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> LABEL SALE
		/*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_label_sale',
            [
                'label' => esc_html__('Label Sale', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_sale',
                'selector' => '{{WRAPPER}} span.onsale',
            ]
        );

        $this->add_control(
            'label_sale_color',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} span.onsale' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'label_sale_bg_color',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} span.onsale' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'label_sale_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} span.onsale' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'label_sale_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} span.onsale' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $atts = $this->get_settings_for_display();

        $products = new WglProductsGrid();
        $products->render($atts, $this);
    }
}
