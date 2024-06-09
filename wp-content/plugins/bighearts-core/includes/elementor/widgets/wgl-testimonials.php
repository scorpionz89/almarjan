<?php
/**
 * This template can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/widgets/wgl-testimonials.php`.
 */
namespace WglAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Utils,
    Repeater,
    Group_Control_Border,
    Group_Control_Box_Shadow,
    Group_Control_Typography,
    Group_Control_Background
};
use WglAddons\{
    BigHearts_Global_Variables as BigHearts_Globals,
    Includes\Wgl_Carousel_Settings,
    Templates\WglTestimonials
};

class Wgl_Testimonials extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-testimonials';
    }

    public function get_title()
    {
        return esc_html__('WGL Testimonials', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-testimonials';
    }

    public function get_script_depends()
    {
        return ['slick'];
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
            'wgl_testimonials_section',
            ['label' => esc_html__('General', 'bighearts-core')]
        );
        $this->add_control(
            'posts_per_line',
            [
                'label' => esc_html__('Grid Columns Amount', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '1' => esc_html__('One ', 'bighearts-core'),
                    '2' => esc_html__('Two', 'bighearts-core'),
                    '3' => esc_html__('Three', 'bighearts-core'),
                    '4' => esc_html__('Four', 'bighearts-core'),
                    '5' => esc_html__('Five', 'bighearts-core'),
                ],
                'default' => '1',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'thumbnail',
            [
                'label' => esc_html__('Image', 'bighearts-core'),
                'type' => Controls_Manager::MEDIA,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
                'default' => ['url' => Utils::get_placeholder_image_src()],
            ]
        );

        $repeater->add_control(
            'author_name',
            [
                'label' => esc_html__('Author Name', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'label_block' => true
            ]
        );

        $repeater->add_control(
            'link_author',
            [
                'label' => esc_html__('Link Author', 'bighearts-core'),
                'type' => Controls_Manager::URL,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'author_position',
            [
                'label' => esc_html__('Author Position', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'label_block' => true
            ]
        );

        $repeater->add_control(
            'author_date',
            [
                'label' => esc_html__('Date', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'quote',
            [
                'label' => esc_html__('Quote', 'bighearts-core'),
                'type' => Controls_Manager::WYSIWYG,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => esc_html__('Items', 'bighearts-core'),
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'author_name' => esc_html__('Ann Peterson', 'bighearts-core'),
                        'author_position' => esc_html__('VOLUNTEER', 'bighearts-core'),
                        'quote' => esc_html__('“Dictum fusce ut placerat orci nulla. At auctor urna nun id cursus metus convallis aliquam posuere eleifend.Dictum fusce ut placerat orci nulla. At auctor urna nun id cursus metus convallis aliquam posuere eleifend.Dictum fusce ut placerat orci nulla. At auctor urna nun id cursus.”', 'bighearts-core'),
                        'thumbnail' => Utils::get_placeholder_image_src(),
                    ],
                ],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ author_name }}}',
            ]
        );

        $this->add_control(
            'item_type',
            [
                'label' => esc_html__('Layout', 'bighearts-core'),
                'type' => 'wgl-radio-image',
                'options' => [
                    'author_top' => [
                        'title' => esc_html__( 'Top', 'bighearts-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/testimonials_1.png',
                    ],
                    'author_bottom' => [
                        'title' => esc_html__( 'Bottom', 'bighearts-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/testimonials_4.png',
                    ],
                    'inline_top' => [
                        'title' => esc_html__('Top Inline', 'bighearts-core'),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/testimonials_2.png',
                    ],
                    'inline_bottom' => [
                        'title' => esc_html__('Bottom Inline', 'bighearts-core'),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/testimonials_3.png',
                    ],

                ],
                'default' => 'inline_top',
            ]
        );

        $this->add_control(
            'item_align',
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
                'toggle' => true,
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => esc_html__('Enable Hover Animation', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__('Lift up the item on hover.', 'bighearts-core'),
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> CAROUSEL OPTIONS
         */

        Wgl_Carousel_Settings::options($this);

        /**
         * STYLE -> IMAGE
         */

        $this->start_controls_section(
            'section_style_image',
            [
                'label' => esc_html__('Image', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'additional_style',
            [
                'label' => esc_html__('Additional Image Style', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['item_type' => 'author_top'],
                'prefix_class' => 'additional_style_',
                'render_type' => 'template',
            ]
        );

        $this->add_control(
            'image_size',
            [
                'label' => esc_html__('Image Width', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'range' => [
                    'px' => ['min' => 20, 'max' => 1000],
                ],
                'default' => ['size' => 60],
            ]
        );
        $this->add_control(
            'image_height',
            [
                'label' => esc_html__('Image Height', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'range' => [
                    'px' => ['min' => 20, 'max' => 1000],
                ],
                'default' => ['size' => 60],
                'condition' => ['additional_style!' => ''],
            ]
        );

        $this->add_responsive_control(
            'image_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials_image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials_image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'testimonials_image_shadow',
                'selector' => '{{WRAPPER}} .wgl-testimonials_image img',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'selector' => '{{WRAPPER}} .wgl-testimonials_image img',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '50',
                    'left' => '50',
                    'right' => '50',
                    'bottom' => '50',
                    'unit' => '%',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials_image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> QUOTE
         */

        $this->start_controls_section(
            'section_style_quote',
            [
                'label' => esc_html__('Quote', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'quote_tag',
            [
                'label' => esc_html__('Quote tag', 'bighearts-core'),
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

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_quote',
                'selector' => '{{WRAPPER}} .wgl-testimonials_quote',
            ]
        );

        $this->add_control(
            'quote_color',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials_quote' => 'color: {{VALUE}};',
                ],
            ]
        );

	    $this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
			    'name' => 'quote_background',
			    'label' => esc_html__('Background', 'bighearts-core'),
			    'types' => ['classic', 'gradient'],
			    'selector' => '{{WRAPPER}} .wgl-testimonials_quote',
		    ]
	    );

        $this->add_responsive_control(
            'quote_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials_quote' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'quote_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials_quote' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

	    $this->add_control(
		    'quote_border_radius',
		    [
			    'label' => esc_html__('Border Radius', 'bighearts-core'),
			    'type' => Controls_Manager::DIMENSIONS,
			    'size_units' => ['px', '%'],
			    'default' => [
				    'top' => '10',
				    'left' => '10',
				    'right' => '10',
				    'bottom' => '10',
				    'unit' => 'px',
				    'isLinked' => true,
			    ],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-testimonials_quote' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
		    ]
	    );

	    $this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
			    'name' => 'quote_shadow',
			    'selector' => '{{WRAPPER}} .wgl-testimonials_quote',
		    ]
	    );

        $this->end_controls_section();

        /**
         * STYLE -> AUTHOR NAME
         */

        $this->start_controls_section(
            'section_style_author_name',
            [
                'label' => esc_html__('Author Name', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'name_tag',
            [
                'label' => esc_html__('HTML tag', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'h3',
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
            ]
        );

        $this->add_responsive_control(
            'name_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials_name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('name_colors');

        $this->start_controls_tab(
            'tab_name_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'name_color_idle',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials_name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_name_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'name_color_hover',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials_name:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_name',
                'selector' => '{{WRAPPER}} .wgl-testimonials_name',
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> AUTHOR POSITION
         */

        $this->start_controls_section(
            'section_style_author_position',
            [
                'label' => esc_html__('Author Position', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'position_tag',
            [
                'label' => esc_html__('HTML tag', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'span',
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
            ]
        );

        $this->add_responsive_control(
            'position_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '7',
                    'left' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials_position' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('position_colors');

        $this->start_controls_tab(
            'position_color_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'custom_position_color',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials_position' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_position_hover',
            [
                'label' => esc_html__('Hover', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'position_color_hover',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials_position:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_position',
                'selector' => '{{WRAPPER}} .wgl-testimonials_position',
            ]
        );

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

        $this->add_responsive_control(
            'date_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials_date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'custom_date_color',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#a2a2a2',
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials_date' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_date',
                'selector' => '{{WRAPPER}} .wgl-testimonials_date',
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> ITEM BOX
         */

        $this->start_controls_section(
            'section_style_item_box',
            [
                'label' => esc_html__('Item Box', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background_item',
                'label' => esc_html__('Background', 'bighearts-core'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .wgl-testimonials_item',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'testimonials_shadow',
                'selector' => '{{WRAPPER}} .wgl-testimonials_item',
                'fields_options' => [
	                'box_shadow_type' => [
		                'default' => 'yes'
	                ],
	                'box_shadow' => [
		                'default' => [
			                'horizontal' => 0,
			                'vertical' => 8,
			                'blur' => 15,
			                'spread' => 0,
			                'color' => 'rgba(0, 0, 0, 0.1)',
		                ]
	                ]
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'testimonials_border',
                'label' => esc_html__('Border', 'bighearts-core'),
                'selector' => '{{WRAPPER}} .wgl-testimonials_item',
            ]
        );

        $this->add_responsive_control(
            'item_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials_item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials_item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'item_border_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 10,
                    'left' => 10,
                    'right' => 10,
                    'bottom' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials_item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

	    $this->add_control(
		    'quote_icon',
		    [
			    'label' => esc_html__('Enable Quote Icon', 'bighearts-core'),
			    'type' => Controls_Manager::SWITCHER,
			    'default' => 'yes',
			    'separator' => 'before',
			    'selectors' => [
				    '{{WRAPPER}} .wgl-testimonials_item:before' => 'display: block;',
			    ],
		    ]
	    );

        $this->add_control(
            'quote_icon_color',
            [
                'label' => esc_html__('Quote Icon Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'condition' => ['quote_icon' => 'yes'],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials_item:before' => 'color: {{VALUE}};',
                ],
            ]
        );

	    $this->add_control(
		    'quote_icon_margin',
		    [
			    'label' => esc_html__('Icon Margin', 'bighearts-core'),
			    'type' => Controls_Manager::DIMENSIONS,
			    'size_units' => ['px', '%'],
			    'condition' => ['quote_icon' => 'yes'],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-testimonials_item:before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
		    ]
	    );

	    $this->end_controls_section();
    }

    protected function render()
    {
        $atts = $this->get_settings_for_display();

        echo (new WglTestimonials())->render($this, $atts);
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
