<?php
/**
 * This template can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/widgets/wgl-team.php`.
 */
namespace WglAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Group_Control_Border,
    Group_Control_Css_Filter,
    Group_Control_Typography,
    Group_Control_Background,
    Group_Control_Box_Shadow
};
use WglAddons\{
    BigHearts_Global_Variables as BigHearts_Globals,
    Includes\Wgl_Loop_Settings,
    Includes\Wgl_Carousel_Settings,
    Templates\WGL_Team as Team_Template
};

class Wgl_Team extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-team';
    }

    public function get_title()
    {
        return esc_html__('WGL Team', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-team';
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
            ['label' => esc_html__('General', 'bighearts-core')]
        );

        $this->add_control(
            'posts_per_line',
            [
                'label' => esc_html__('Columns Amount', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '1' => esc_html__('1 (one)', 'bighearts-core'),
                    '2' => esc_html__('2 (two)', 'bighearts-core'),
                    '3' => esc_html__('3 (three)', 'bighearts-core'),
                    '4' => esc_html__('4 (four)', 'bighearts-core'),
                    '5' => esc_html__('5 (five)', 'bighearts-core'),
                    '6' => esc_html__('6 (six)', 'bighearts-core'),
                ],
                'default' => '4',
            ]
        );

        $this->add_control(
            'info_align',
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
            ]
        );

        $this->add_control(
            'single_link_wrapper',
            [
                'label' => esc_html__('Add Link on Image', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'single_link_heading',
            [
                'label' => esc_html__('Add Link on Heading', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
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
            'hide_title',
            [
                'label' => esc_html__('Hide Title', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'hide_highlited_info',
            [
                'label' => esc_html__('Hide Highlighted Info', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'hide_signature',
            [
                'label' => esc_html__('Hide Signature', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'hide_soc_icons',
            [
                'label' => esc_html__('Hide Social Icons', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'hide_content',
            [
                'label' => esc_html__('Hide Excerpt/Content', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'letter_count',
            [
                'label' => esc_html__('Limit the Excerpt/Content letters', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['hide_content!' => 'yes'],
                'min' => 1,
                'default' => '100',
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> CAROUSEL OPTIONS
         */

        Wgl_Carousel_Settings::options($this);

        /**
         * SETTINGS -> QUERY
         */

        Wgl_Loop_Settings::init(
            $this,
            [
                'post_type' => 'team',
                'hide_cats' => true,
                'hide_tags' => true
            ]
        );

        /**
         * STYLE -> GENERAL
         */

        $this->start_controls_section(
            'section_style_items',
            [
                'label' => esc_html__( 'General', 'bighearts-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'item_margin',
            [
                'label' => esc_html__('Items Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 20,
                    'left' => 15,
                    'right' => 15,
                    'bottom' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .team-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .team-items_wrap' => 'margin-left: -{{LEFT}}{{UNIT}}; margin-right: -{{RIGHT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__('Items Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .team-item_wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'item_border_radius',
            [
                'label' => esc_html__('Items Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .team-item_wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_items',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'tab_item_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_idle',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .team-item_wrap',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_idle',
                'selector' => '{{WRAPPER}} .team-item_wrap',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_item_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .team-item_wrap:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_hover',
                'selector' => '{{WRAPPER}} .team-item_wrap:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> IMAGE
         */

        $this->start_controls_section(
            'background_style_section',
            [
                'label' => esc_html__('Image', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 22,
                    'left' => 0,
                ],
                'mobile_default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 22,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .team__media-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .team__image,
                     {{WRAPPER}} .team__image img,
                     {{WRAPPER}} .team__image:before,
                     {{WRAPPER}} .team__image:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'overlay_heading',
            [
                'label' => esc_html__('Overlays Colors', 'bighearts-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('tabs_overlays');

        $this->start_controls_tab(
            'tab_overlay_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'overlay_idle',
                'selector' => '{{WRAPPER}} .team__image:before',
            ]
        );

        $this->add_control(
			'overlay_blend_mode',
			[
				'label' => esc_html__('Blend Mode', 'bighearts-core'),
				'type' => Controls_Manager::SELECT,
                'separator' => 'none',
				'options' => [
					'' => esc_html__( 'Normal', 'bighearts-core' ),
					'multiply' => esc_html__('Multiply', 'bighearts-core'),
					'screen' => esc_html__('Screen', 'bighearts-core'),
					'overlay' => esc_html__('Overlay', 'bighearts-core'),
					'darken' => esc_html__('Darken', 'bighearts-core'),
					'lighten' => esc_html__('Lighten', 'bighearts-core'),
					'color-dodge' => esc_html__('Color Dodge', 'bighearts-core'),
					'saturation' => esc_html__('Saturation', 'bighearts-core'),
					'color' => esc_html__('Color', 'bighearts-core'),
					'difference' => esc_html__('Difference', 'bighearts-core'),
					'exclusion' => esc_html__('Exclusion', 'bighearts-core'),
					'hue' => esc_html__('Hue', 'bighearts-core'),
					'luminosity' => esc_html__('Luminosity', 'bighearts-core'),
				],
				'selectors' => [
					'{{WRAPPER}} .team__image:before' => 'mix-blend-mode: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'overlay_css_filters',
				'selector' => '{{WRAPPER}} .team__image img',
			]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_overlay_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'overlay_hover',
                'fields_options' => [
                    'background' => [ 'default' => 'classic' ],
                    'color' => [ 'default' => '#222328' ],
                ],
                'selector' => '{{WRAPPER}} .team__image:after',
            ]
        );

        $this->add_control(
			'overlay_hover_blend_mode',
			[
				'label' => esc_html__( 'Blend Mode', 'bighearts-core' ),
				'type' => Controls_Manager::SELECT,
                'separator' => 'none',
				'options' => [
					'' => esc_html__( 'Normal', 'bighearts-core' ),
					'multiply' => esc_html__('Multiply', 'bighearts-core'),
					'screen' => esc_html__('Screen', 'bighearts-core'),
					'overlay' => esc_html__('Overlay', 'bighearts-core'),
					'darken' => esc_html__('Darken', 'bighearts-core'),
					'lighten' => esc_html__('Lighten', 'bighearts-core'),
					'color-dodge' => esc_html__('Color Dodge', 'bighearts-core'),
					'saturation' => esc_html__('Saturation', 'bighearts-core'),
					'color' => esc_html__('Color', 'bighearts-core'),
					'difference' => esc_html__('Difference', 'bighearts-core'),
					'exclusion' => esc_html__('Exclusion', 'bighearts-core'),
					'hue' => esc_html__('Hue', 'bighearts-core'),
					'luminosity' => esc_html__('Luminosity', 'bighearts-core'),
				],
                'default' => 'color',
				'selectors' => [
					'{{WRAPPER}} .team__image:after' => 'mix-blend-mode: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'overlay_hover_css_filters',
                'fields_options' => [
                    'css_filter' => [
                        'default' => 'custom'
                    ],
                    'brightness' => [
                        'default' => [ 'size' => 94 ]
                    ],
                    'contrast' => [
                        'default' => [ 'size' => 101 ]
                    ],
                    'saturate' => [
                        'default' => [ 'size' => 0 ]
                    ],
                ],
                'selector' => '{{WRAPPER}} .team-item_wrap:hover .team__image img',
			]
        );

        $this->add_control(
			'overlay_hover_transition',
			[
				'label' => esc_html__('Transition Duration', 'bighearts-core'),
				'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
				'range' => [
                    'px' => ['max' => 3, 'step' => 0.1],
				],
                'default' => ['size' => 0.3],
				'selectors' => [
					'{{WRAPPER}} .team-item_wrap img' => 'transition-duration: {{SIZE}}s',
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
                'name' => 'title',
                'selector' => '{{WRAPPER}} .team-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .team-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .team-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'title_border',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .team-title',
            ]
        );

        $this->start_controls_tabs(
            'tabs_title',
            ['separator' => 'before']
        );

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
                'default' => BigHearts_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .team-title' => 'color: {{VALUE}}',
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
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .team-title:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> HIGHLIGHTED INFO
         */

        $this->start_controls_section(
            'section_style_highlighted_info',
            [
                'label' => esc_html__('Highlighted Info', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'meta_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .team-item_meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'meta_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 10,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .team-item_meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'meta_border',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .team-item_meta',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                    'width' => ['default' => [
                        'top' => 1,
                        'right' => 0,
                        'bottom' => 0,
                        'left' => 0,
                    ]],
                    'color' => ['default' => '#eeeeee'],
                ],
            ]
        );

        $this->add_control(
            'meta_heading',
            [
                'label' => esc_html__('Meta', 'bighearts-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'meta',
                'selector' => '{{WRAPPER}} .team-department',
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label' => esc_html__('Meta Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .team-department' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> SIGNATURE
         */

        $this->start_controls_section(
            'section_style_meta',
            [
                'label' => esc_html__('Signature', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'signature_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .team-signature' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> SOCIALS
         */

        $this->start_controls_section(
            'section_style_socials',
            [
                'label' => esc_html__('Socials', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_soc_style_wrapper' );

        $this->start_controls_tab(
            'tab_soc_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'soc_bg_color',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl_module_team .team__icons' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_soc_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'soc_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl_module_team .team-item_wrap:hover .team__icons' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->start_controls_tabs(
            'tabs_socials',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'tab_socials_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'socials_color_idle',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .team-icon' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'socials_official_colors_idle',
            [
                'type' => Controls_Manager::HIDDEN,
                'condition' => ['socials_color_idle' => ''],
                'default' => 'idle',
                'prefix_class' => 'socials-official-'
            ]
        );

        $this->add_control(
            'socials_bg_idle',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .team-icon' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'first_social_color_idle',
            [
                'label' => esc_html__('First Icon Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .team-icon:first-child' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'first_social_bg_idle',
            [
                'label' => esc_html__('First Icon Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .team-icon:first-child' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_socials_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'socials_color_hover',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .team-icon:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'socials_official_colors_hover',
            [
                'type' => Controls_Manager::HIDDEN,
                'condition' => ['socials_color_hover' => ''],
                'default' => 'hover',
                'prefix_class' => 'socials-official-'
            ]
        );

        $this->add_control(
            'socials_bg_hover',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .team-icon:hover' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'first_social_color_hover',
            [
                'label' => esc_html__('First Icon Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .team-item_wrap:hover .team-icon:first-child' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'first_social_bg_hover',
            [
                'label' => esc_html__('First Icon Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .team-item_wrap:hover .team-icon:first-child' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> EXCERPT/CONTENT
         */

        $this->start_controls_section(
            'section_style_excerpt',
            [
                'label' => esc_html__('Excerpt / Content', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['hide_content' => ''],
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .team-item_excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .team-item_excerpt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt',
                'selector' => '{{WRAPPER}} .team-item_excerpt',
            ]
        );

        $this->start_controls_tabs(
            'tabs_excerpt',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'tab_excerpt_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'excerpt_color_idle',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .team-item_excerpt' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_excerpt_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'excerpt_color_hover',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .team-item_wrap:hover .team-item_excerpt' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render()
    {
        (new Team_Template())->render($this->get_settings_for_display());
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
