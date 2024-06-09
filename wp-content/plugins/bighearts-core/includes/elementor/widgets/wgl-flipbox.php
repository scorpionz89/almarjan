<?php
/**
 * Current file can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/widgets/wgl-flipbox.php`.
 */
namespace WglAddons\Widgets;

defined( 'ABSPATH' ) || exit;

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Group_Control_Border,
	Group_Control_Typography,
	Group_Control_Box_Shadow,
	Group_Control_Background,
    Icons_Manager
};
use WglAddons\{
    BigHearts_Global_Variables as BigHearts_Globals,
    Includes\Wgl_Icons
};

/**
 * Flip Box Widget
 *
 *
 * @package bighearts-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 * @version 1.1.5
 */
class Wgl_Flipbox extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-flipbox';
    }

    public function get_title()
    {
        return esc_html__('WGL Flipbox', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-flipbox';
    }

    public function get_categories()
    {
        return ['wgl-extensions'];
    }

    protected function register_controls()
    {
        /** CONTENT -> GENERAL */

        $this->start_controls_section(
            'section_content_general',
            ['label' => esc_html__('General', 'bighearts-core')]
        );

        $this->add_control(
            'dev_view',
            [
                'label' => esc_html__('Show Back Side', 'bighearts-core'),
                'description' => esc_html__('This option does not affect the result in any way', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '-active',
                'prefix_class' => 'dev_view'
            ]
        );

        $this->add_control(
            'flip_direction',
            [
                'label' => esc_html__('Flip Direction', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'flip_right' => esc_html__('Right', 'bighearts-core'),
                    'flip_left' => esc_html__('Left', 'bighearts-core'),
                    'flip_top' => esc_html__('Top', 'bighearts-core'),
                    'flip_bottom' => esc_html__('Bottom', 'bighearts-core'),
                ],
                'default' => 'flip_right',
            ]
        );

        $this->add_control(
            'flipbox_height',
            [
                'label' => esc_html__( 'Widget Height', 'bighearts-core' ),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'min' => 150,
                'step' => 10,
                'default' => 300,
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox' => 'height: {{VALUE}}px;',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_item',
            [ 'separator' => 'before' ]
        );

        $this->start_controls_tab(
            'tab_item_front',
            ['label' => esc_html__('Front', 'bighearts-core')]
        );

        $this->add_control(
            'h_alignment_front',
            [
                'label' => esc_html__( 'Horizontal Alignment', 'bighearts-core' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'v_alignment_front',
            [
                'label' => esc_html__( 'Vertical Alignment', 'bighearts-core' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'toggle' => false,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Top', 'bighearts-core' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'bighearts-core' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Bottom', 'bighearts-core' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_item_back',
            ['label' => esc_html__('Back', 'bighearts-core')]
        );

        $this->add_control(
            'h_alignment_back',
            [
                'label' => esc_html__( 'Horizontal Alignment', 'bighearts-core' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_content:after' => '{{VALUE}}: 0;',
                ],
            ]
        );

        $this->add_control(
            'v_alignment_back',
            [
                'label' => esc_html__( 'Vertical Alignment', 'bighearts-core' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'toggle' => false,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Top', 'bighearts-core' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'bighearts-core' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Bottom', 'bighearts-core' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /** CONTENT -> MEDIA */

        $this->start_controls_section(
            'section_content_media',
            ['label' => esc_html__('Media', 'bighearts-core')]
        );

        $this->start_controls_tabs( 'flipbox_icon' );

        $this->start_controls_tab(
            'flipbox_front_icon',
            ['label' => esc_html__('Front', 'bighearts-core')]
        );

        Wgl_Icons::init(
            $this,
            [
                'label' => esc_html__('Flipbox ', 'bighearts-core'),
                'output' => '',
                'section' => false,
                'prefix' => 'front_'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'flipbox_back_icon',
            ['label' => esc_html__('Back', 'bighearts-core')]
        );

        Wgl_Icons::init(
            $this,
            [
                'label' => esc_html__('Flipbox ', 'bighearts-core'),
                'output' => '',
                'section' => false,
                'prefix' => 'back_'
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /** CONTENT -> CONTENT */

        $this->start_controls_section(
            'section_content_content',
            ['label' => esc_html__('Content', 'bighearts-core')]
        );

        $this->start_controls_tabs('tabs_content');

        $this->start_controls_tab(
            'tab_content_front',
            ['label' => esc_html__('Front', 'bighearts-core')]
        );

        $this->add_control(
            'title_front',
            [
                'label' => esc_html__('Title', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
                'placeholder' => esc_attr__( 'Front Heading', 'bighearts-core' ),
                'default' => esc_html__( 'Front Heading', 'bighearts-core' ),
            ]
        );

        $this->add_control(
            'additional_title_style',
            [
                'label' => esc_html__('Use «BigHearts Style» Front', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['title_front!' => ''],
                'prefix_class' => 'additional_title_',
                'render_type' => 'template',
                'default' => true,
            ]
        );

        $this->add_control(
            'content_front',
            [
                'label' => esc_html__( 'Content', 'bighearts-core' ),
                'type' => Controls_Manager::WYSIWYG,
			    'dynamic' => [  'active' => true],
                'condition' => ['additional_title_style' => ''],
                'separator' => 'before',
                'label_block' => true,
                'placeholder' => esc_attr__( 'Front Content', 'bighearts-core' ),
                'default' => esc_html__('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis.', 'bighearts-core'),
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_content_back',
            ['label' => esc_html__('Back', 'bighearts-core')]
        );

        $this->add_control(
            'back_title',
            [
                'label' => esc_html__('Title', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
                'placeholder' => esc_attr__('Back Heading​', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'back_content',
            [
                'label' => esc_html__('Content', 'bighearts-core'),
                'type' => Controls_Manager::WYSIWYG,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
                'placeholder' => esc_attr__('Back Content', 'bighearts-core'),
                'default' => esc_html__('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'back_content_trail',
            [
                'label' => esc_html__('Add Content Trailing Line', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['back_content!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_content' => 'margin-bottom: 1em;',
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_content:after' => 'content: \'\'',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /** CONTENT -> LINK */

        $this->start_controls_section(
            'section_content_link',
            ['label' => esc_html__('Link', 'bighearts-core')]
        );

        $this->add_control(
            'add_item_link',
            [
                'label' => esc_html__('Add Link To Whole Item', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [ 'add_read_more' => '' ],
            ]
        );

        $this->add_control(
            'item_link',
            [
                'label' => esc_html__('Link', 'bighearts-core'),
                'type' => Controls_Manager::URL,
			    'dynamic' => [  'active' => true],
                'condition' => [ 'add_item_link!' => '' ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'add_read_more',
            [
                'label' => esc_html__('Add \'Read More\' Button', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [ 'add_item_link' => '' ],
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => esc_html__('Button Text', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'condition' => [ 'add_read_more!' => '' ],
                'label_block' => true,
                'default' => esc_html__('READ MORE', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Button Link', 'bighearts-core'),
                'type' => Controls_Manager::URL,
			    'dynamic' => [  'active' => true],
                'condition' => [ 'add_read_more!' => '' ],
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> FRONT ICON
         */

        $this->start_controls_section(
	        'section_content_front_icon',
            [ 'label' => esc_html__('Front Icon', 'bighearts-core') ]
        );

	    $this->add_control(
		    'add_front_icon',
		    [
			    'label' => esc_html__('Add Front Icon', 'bighearts-core'),
			    'type' => Controls_Manager::SWITCHER,
			    'label_on' => esc_html__('On', 'bighearts-core'),
			    'label_off' => esc_html__('Off', 'bighearts-core'),
			    'default' => 'yes',
		    ]
	    );

	    $this->add_control(
		    'front_icon_alignment',
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
			    'condition' => ['add_front_icon' => 'yes'],
			    'toggle' => true,
			    'prefix_class' => 'front_icon_alignment-',
			    'selectors' => [
				    '{{WRAPPER}} .wgl-flipbox_front_icon-wrapper' => 'text-align: {{VALUE}};',
			    ],
		    ]
	    );

	    $this->add_control(
		    'add_front_icon_fontawesome',
		    [
			    'label' => esc_html__('Icon', 'bighearts-core'),
			    'type' => Controls_Manager::ICONS,
			    'condition' => ['add_front_icon' => 'yes'],
			    'label_block' => true,
			    'description' => esc_html__('Select icon from available libraries.', 'bighearts-core'),
			    'default' => [
				    'library' => 'flaticon',
				    'value' => 'flaticon-right-arrow',
			    ],

		    ]
	    );

	    $this->add_responsive_control(
		    'front_icon_size',
		    [
			    'label' => esc_html__('Icon Size', 'bighearts-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
			    'condition' => [
				    'add_front_icon' => 'yes',
				    'add_front_icon_fontawesome!' => [
					    'value' => '',
					    'library' => '',
				    ]
			    ],
			    'range' => [
				    'px' => ['min' => 10, 'max' => 100 ],
			    ],
			    'default' => ['size' => 19 ],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-flipbox_front_icon i' => 'font-size: {{SIZE}}{{UNIT}};',
			    ],
		    ]
	    );

	    $this->add_responsive_control(
		    'front_icon_spacing',
		    [
			    'label' => esc_html__('Icon Wrapper Size', 'bighearts-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
			    'condition' => [
				    'add_front_icon' => 'yes',
				    'add_front_icon_fontawesome!' => [
					    'value' => '',
					    'library' => '',
				    ]
			    ],
			    'range' => [
				    'px' => ['min' => 10, 'max' => 100 ],
			    ],
			    'default' => ['size' => 40 ],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-flipbox_front_icon i' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
			    ],
		    ]
	    );

	    $this->end_controls_section();

        /**
         * STYLE -> GENERAL
         */

        $this->start_controls_section(
            'section_style_general',
            [
                'label' => esc_html__( 'General', 'bighearts-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('flipbox_style');

        $this->start_controls_tab(
            'flipbox_front_style',
            ['label' => esc_html__('Front', 'bighearts-core')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'front_background',
                'fields_options' => [
	                'background' => [ 'default' => 'classic' ],
	                'color' => [ 'default' => BigHearts_Globals::get_h_font_color() ],
                ],
                'selector' => '{{WRAPPER}} .wgl-flipbox_front',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'flipbox_back_style',
            ['label' => esc_html__('Back', 'bighearts-core')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'back_background',
                'fields_options' => [
	                'background' => [ 'default' => 'classic' ],
	                'color' => [ 'default' => BigHearts_Globals::get_secondary_color() ],
                ],
                'selector' => '{{WRAPPER}} .wgl-flipbox_back',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'flipbox_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'separator' => 'before',
                'default' => [
                    'top' => '40',
                    'right' => '30',
                    'bottom' => '40',
                    'left' => '30',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front,
                     {{WRAPPER}} .wgl-flipbox_back' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'flipbox_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front,
                     {{WRAPPER}} .wgl-flipbox_back' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'flipbox_border_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '10',
                    'right' => '10',
                    'bottom' => '10',
                    'left' => '10',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front,
                     {{WRAPPER}} .wgl-flipbox_back' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'flipbox_border',
                'separator' => 'before',
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'pembe-core' ) ],
                    'color' => [ 'label' => esc_html__( 'Border Color', 'pembe-core' ) ],
                ],
                'selector' => '{{WRAPPER}} .wgl-flipbox_front,'
                            . '{{WRAPPER}} .wgl-flipbox_back',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'flipbox_shadow',
                'selector' => '{{WRAPPER}} .wgl-flipbox_front, {{WRAPPER}} .wgl-flipbox_back',
            ]
        );

        $this->end_controls_section();

        /** STYLE -> MEDIA */

        $this->start_controls_section(
            'section_style_media',
            [
                'label' => esc_html__('Media', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_media' );

        $this->start_controls_tab(
            'tab_media_front',
            ['label' => esc_html__('Front', 'bighearts-core')]
        );

        $this->add_responsive_control(
            'media_margin_front',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_media-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color_front',
            [
                'label' => esc_html__('Icon Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'condition' => [ 'front_icon_type' => 'font' ],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .elementor-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                    '{{WRAPPER}} .wgl-flipbox_front .elementor-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size_front',
            [
                'label' => esc_html__('Icon Size', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'condition' => [ 'front_icon_type' => 'font' ],
                'range' => [
                    'px' => [ 'min' => 16, 'max' => 100 ],
                ],
                'default' => [ 'size' => 55, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_width_front',
            [
                'label' => esc_html__('Image Width', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'condition' => [
                    'front_icon_type' => 'image',
                    'front_thumbnail[url]!' => '',
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [ 'min' => 50, 'max' => 800 ],
                    '%' => [ 'min' => 5, 'max' => 100 ],
                ],
                'default' => [ 'size' => 75, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-image-box_img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_media_back',
            ['label' => esc_html__('Back', 'bighearts-core')]
        );

        $this->add_responsive_control(
            'media_margin_back',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_media-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color_back',
            [
                'label' => esc_html__('Icon Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'condition' => [ 'back_icon_type' => 'font' ],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .elementor-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                    '{{WRAPPER}} .wgl-flipbox_back .elementor-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size_back',
            [
                'label' => esc_html__('Icon Size', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'condition' => [ 'back_icon_type' => 'font' ],
                'range' => [
                    'px' => [ 'min' => 16, 'max' => 100 ],
                ],
                'default' => [ 'size' => 55, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_width_back',
            [
                'label' => esc_html__('Image Width', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'condition' => [
                    'back_icon_type' => 'image',
                    'back_thumbnail[url]!' => '',
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [ 'min' => 50, 'max' => 800 ],
                    '%' => [ 'min' => 5, 'max' => 100 ],
                ],
                'default' => [ 'size' => 50, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-image-box_img' => 'width: {{SIZE}}{{UNIT}};',
                ],
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
            ]
        );

        $this->start_controls_tabs( 'tabs_title' );

        $this->start_controls_tab(
            'front_title_style',
            ['label' => esc_html__('Front', 'bighearts-core')]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_front',
                'selector' => '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_title span',
            ]
        );

        $this->add_control(
            'title_tag_front',
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

        $this->add_control(
            'title_color_front',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_title span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_bg_color_front',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'condition' => ['additional_title_style!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_title span' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_icon_color_front',
            [
                'label' => esc_html__('Icon Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'condition' => ['additional_title_style!' => ''],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_title span:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_icon_bg_color_front',
            [
                'label' => esc_html__('Icon Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'condition' => ['additional_title_style!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_title span:before' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin_front',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_title span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'back_title_style',
            ['label' => esc_html__('Back', 'bighearts-core')]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_back',
                'selector' => '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_title span',
            ]
        );

        $this->add_control(
            'title_tag_back',
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

        $this->add_control(
            'title_color_back',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_title span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin_back',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 15,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_title span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /** STYLE -> CONTENT */

        $this->start_controls_section(
            'content_style_section',
            [
                'label' => esc_html__('Content', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_content_styles' );

        $this->start_controls_tab(
            'front_content_style',
            ['label' => esc_html__('Front', 'bighearts-core')]
        );

        $this->add_responsive_control(
            'front_content_offset',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_front_fonts_content',
                'selector' => '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_content',
            ]
        );

        $this->add_control(
            'front_content_color',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_front .wgl-flipbox_content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'back_content_style',
            ['label' => esc_html__('Back', 'bighearts-core')]
        );

        $this->add_responsive_control(
            'back_content_offset',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
	                'top' => '14',
	                'right' => '0',
	                'bottom' => '0',
	                'left' => '0',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_back_fonts_content',
                'selector' => '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_content',
            ]
        );

        $this->add_control(
            'back_content_color',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .wgl-flipbox_back .wgl-flipbox_content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /** STYLE -> BUTTON */

        $this->start_controls_section(
            'section_style_button',
            [
                'label' => esc_html__('Button', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'add_read_more!' => '' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_button',
                'selector' => '{{WRAPPER}} .wgl-button',
            ]
        );

        $this->add_responsive_control(
            'custom_button_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
	                'top' => '13',
	                'right' => '0',
	                'bottom' => '13',
	                'left' => '0',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'custom_button_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '15',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_button',
            [ 'separator' => 'before' ]
        );

        $this->start_controls_tab(
            'tab_button_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'button_color_idle',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .wgl-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_idle',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_idle',
                'label' => esc_html__('Border Type', 'bighearts-core'),
                'fields_options' => [
	                'width' => [
		                'selectors' => [
			                '{{SELECTOR}}' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			                '{{SELECTOR}}:before, {{SELECTOR}}:after' => 'display: none;',
		                ],
	                ],
                ],
                'selector' => '{{WRAPPER}} .wgl-button',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_idle',
                'selector' => '{{WRAPPER}} .wgl-button',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            ['label' => esc_html__('Hover' , 'bighearts-core')]
        );

        $this->add_control(
            'button_bg_hover',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-button:hover' => 'background: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'button_color_hover',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-button:hover' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_hover',
                'condition' => [ 'button_idle_border!' => '' ],
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'pembe-core' ) ],
                    'color' => [ 'label' => esc_html__( 'Border Color', 'pembe-core' ) ],
                ],
                'selector' => '{{WRAPPER}} .wgl-button:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_hover',
                'selector' => '{{WRAPPER}} .wgl-button:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /** STYLE -> FRONT ICON */

	    $this->start_controls_section(
		    'front_icon_style_section',
		    [
			    'label' => esc_html__('Front Icon', 'bighearts-core'),
			    'tab' => Controls_Manager::TAB_STYLE,
			    'condition' => ['add_front_icon!' => ''],
		    ]
	    );

	    $this->add_responsive_control(
		    'front_icon_margin',
		    [
			    'label' => esc_html__('Margin', 'bighearts-core'),
			    'type' => Controls_Manager::DIMENSIONS,
			    'size_units' => ['px', '%'],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-flipbox_front_icon-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
		    ]
	    );

	    $this->add_responsive_control(
		    'front_icon_padding',
		    [
			    'label' => esc_html__('Padding', 'bighearts-core'),
			    'type' => Controls_Manager::DIMENSIONS,
			    'size_units' => [ 'px', 'em', '%' ],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-flipbox_front_icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
		    ]
	    );

	    $this->add_responsive_control(
		    'front_icon_border_radius',
		    [
			    'label' => esc_html__('Border Radius', 'bighearts-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
			    'range' => [
				    'px' => ['min' => 0, 'max' => 50, 'step' => 1 ],
			    ],
			    'default' => ['size' => 25, 'unit' => 'px'],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-flipbox_front_icon, {{WRAPPER}} .wgl-flipbox_front_icon i' => 'border-radius: {{SIZE}}px;',
			    ],
		    ]
	    );

	    $this->add_control(
		    'front_icon_color_idle',
		    [
			    'label' => esc_html__('Icon Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
			    'default' => BigHearts_Globals::get_btn_color_idle(),
			    'selectors' => [
				    '{{WRAPPER}} .wgl-flipbox_front_icon i' => 'color: {{VALUE}};',
			    ],
		    ]
	    );

	    $this->add_control(
		    'front_icon_bg_idle',
		    [
			    'label' => esc_html__('Icon Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
			    'default' => '#ffffff',
			    'selectors' => [
				    '{{WRAPPER}} .wgl-flipbox_front_icon i' => 'background-color: {{VALUE}};',
			    ],
		    ]
	    );

	    $this->add_control(
		    'front_icon_bg_outer_idle',
		    [
			    'label' => esc_html__( 'Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
			    'default' => BigHearts_Globals::get_btn_color_idle(),
			    'selectors' => [
				    '{{WRAPPER}} .wgl-flipbox_front_icon' => 'background-color: {{VALUE}};',
			    ],
		    ]
	    );

	    $this->add_control(
		    'front_icon_icon_rotate_idle',
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
				    '{{WRAPPER}} .wgl-flipbox_front_icon i' => 'transform: rotate({{SIZE}}{{UNIT}});',
			    ],
		    ]
	    );

	    $this->end_controls_section();
    }

    public function render()
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
        ];

        $this->add_render_attribute('flipbox', 'class', ['wgl-flipbox', 'type_'.$_s['flip_direction'] ]);

        $this->add_render_attribute('flipbox_link', 'class', ['wgl-button', 'button-read-more']);
        if (isset($_s['link']['url'])) $this->add_link_attributes('flipbox_link', $_s['link']);

        $this->add_render_attribute('item_link', 'class', 'wgl-flipbox_item-link');
        if (isset($_s['item_link']['url'])) $this->add_link_attributes('item_link', $_s['item_link']);

        //* Icon/Image
        ob_start();
        if (!empty($_s['front_icon_type'])) {
            $icons = new Wgl_Icons;
            echo $icons->build($this, $_s, 'front_');
        }
        $front_media = ob_get_clean();

        ob_start();
        if (!empty($_s['back_icon_type'])) {
            $icons = new Wgl_Icons;
            echo $icons->build($this, $_s, 'back_');
        }
        $back_media = ob_get_clean();

	    //* Front Icon
	    if ($_s['add_front_icon']) {
		    $icon_font = $_s['add_front_icon_fontawesome'];

		    $migrated = isset($_s['__fa4_migrated']['add_front_icon_fontawesome']);
		    $is_new = Icons_Manager::is_migration_allowed();
		    $icon_output = "";

		    if ( $is_new || $migrated ) {
			    ob_start();
			    Icons_Manager::render_icon( $_s['add_front_icon_fontawesome'], ['aria-hidden' => 'true'] );
			    $icon_output .= ob_get_clean();
		    } else {
			    $icon_output .= '<i class="icon '.esc_attr($icon_font).'"></i>';
		    }

		    if (!empty($icon_output)){
			    $front_icon = '<div class="wgl-flipbox_front_icon-wrapper">';
				    $front_icon .= '<div class="wgl-flipbox_front_icon">';
					    $front_icon .= $icon_output;
				    $front_icon .= '</div>';
			    $front_icon .= '</div>';
		    }
	    }

        // Render
        ?>
        <div <?php echo $this->get_render_attribute_string('flipbox'); ?>>
            <div class="wgl-flipbox_wrap">
                <div class="wgl-flipbox_front"><?php
                    if ($_s['front_icon_type'] && $front_media) { ?>
                        <div class="wgl-flipbox_media-wrap">
                            <?php echo $front_media; ?>
                        </div><?php
                    }
                    if (!empty($_s['title_front'])) {
                        echo '<'. $_s['title_tag_front']. ' class="wgl-flipbox_title">'; ?>
                            <span>
                                <?php echo wp_kses($_s['title_front'], $kses_allowed_html); ?>
                            </span><?php
                        echo '</'. $_s['title_tag_front']. '>';
                    }
                    if (!empty($_s['content_front'])) { ?>
                        <div class="wgl-flipbox_content">
                            <?php echo wp_kses($_s['content_front'], $kses_allowed_html); ?>
                        </div><?php
                    }
	                if ( ! empty( $front_icon ) ) {
		                echo $front_icon;
	                } ?>
                </div>
                <div class="wgl-flipbox_back"><?php
                    if ($_s['back_icon_type'] && $back_media) { ?>
                        <div class="wgl-flipbox_media-wrap">
                            <?php echo $back_media; ?>
                        </div><?php
                    }
                    if (!empty($_s['back_title'])) {
                        echo '<'. $_s['title_tag_back']. ' class="wgl-flipbox_title">'; ?>
                            <span>
                                <?php echo wp_kses($_s['back_title'], $kses_allowed_html); ?>
                            </span><?php
                        echo '</'. $_s['title_tag_back']. '>';
                    }
                    if (!empty($_s['back_content'])) { ?>
                        <div class="wgl-flipbox_content">
                            <?php echo wp_kses($_s['back_content'], $kses_allowed_html); ?>
                        </div><?php
                    }
                    if ($_s['add_read_more']) { ?>
                        <div class="wgl-flipbox_button-wrap">
                            <a <?php echo $this->get_render_attribute_string('flipbox_link'); ?>>
                                <?php echo esc_html_e($_s['read_more_text']); ?>
                            </a>
                        </div><?php
                    }?>
                </div>
            </div><?php

            if ($_s['add_item_link']) { ?>
                <a <?php echo $this->get_render_attribute_string('item_link'); ?>></a><?php
            }?>
        </div><?php

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
