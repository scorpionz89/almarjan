<?php
/**
 * Current file can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/widgets/wgl-accordion-service.php`.
 */
namespace WglAddons\Widgets;

defined( 'ABSPATH' ) || exit;

use Elementor\{
    Widget_Base,
	Controls_Manager,
	Control_Media,
	Repeater,
	Utils,
	Icons_Manager,
	Group_Control_Typography,
    Group_Control_Border,
	Group_Control_Image_Size,
    Group_Control_Background,
	Group_Control_Box_Shadow
};
use WglAddons\BigHearts_Global_Variables as BigHearts_Globals;

/**
 * Accordion Service Widget
 *
 *
 * @package bighearts-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 * @version 1.1.5
 */
class Wgl_Accordion_Service extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-accordion-service';
    }

    public function get_title()
    {
        return esc_html__('WGL Accordion Service', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-accordion-services';
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
            'item_col',
            [
                'label' => esc_html__('Grid Columns Amount', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '2' => esc_html__('2 (two)', 'bighearts-core'),
                    '3' => esc_html__('3 (three)', 'bighearts-core'),
                    '4' => esc_html__('4 (four)', 'bighearts-core'),
                ],
                'default' => '3',
                'prefix_class' => 'grid-col-'
            ]
        );

        $this->add_responsive_control(
            'item_min_height',
            [
                'label' => esc_html__('Items Min Height', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'range' => [
                    'px' => ['min' => 200, 'max' => 1000],
                ],
                'default' => ['size' => 350],
                'selectors' => [
                    '{{WRAPPER}} .service__item' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> ITEMS
         */

        $this->start_controls_section(
            'section_content_items',
            ['label' => esc_html__('Items', 'bighearts-core')]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'bg_color',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .service__thumbnail:before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_control(
            'thumbnail',
            [
                'label' => esc_html__('Thumbnail', 'bighearts-core'),
                'type' => Controls_Manager::MEDIA,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .service__thumbnail:before' => 'background-image: url({{URL}});',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'bg_position',
            [
                'label' => esc_html__('Position', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['thumbnail[url]!' => ''],
                'options' => [
                    'center center' => esc_html__('Center Center', 'bighearts-core'),
                    'center left' => esc_html__('Center Left', 'bighearts-core'),
                    'center right' => esc_html__('Center Right', 'bighearts-core'),
                    'top center' => esc_html__('Top Center', 'bighearts-core'),
                    'top left' => esc_html__('Top Left', 'bighearts-core'),
                    'top right' => esc_html__('Top Right', 'bighearts-core'),
                    'bottom center' => esc_html__('Bottom Center', 'bighearts-core'),
                    'bottom left' => esc_html__('Bottom Left', 'bighearts-core'),
                    'bottom right' => esc_html__('Bottom Right', 'bighearts-core'),
                ],
                'default' => 'center center',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .service__thumbnail:before' => 'background-position: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'bg_repeat',
            [
                'label' => esc_html__('Repeat', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['thumbnail[url]!' => ''],
                'options' => [
                    'no-repeat' => esc_html__('No-repeat', 'bighearts-core'),
                    'repeat' => esc_html__('Repeat', 'bighearts-core'),
                    'repeat-x' => esc_html__('Repeat X', 'bighearts-core'),
                    'repeat-y' => esc_html__('Repeat Y', 'bighearts-core'),
                ],
                'default' => 'no-repeat',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .service__thumbnail:before' => 'background-repeat: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'bg_size',
            [
                'label' => esc_html__('Size', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['thumbnail[url]!' => ''],
                'options' => [
                    'cover' => esc_html__('Cover', 'bighearts-core'),
                    'contain' => esc_html__('Contain', 'bighearts-core'),
                    'auto' => esc_html__('Auto', 'bighearts-core'),
                ],
                'default' => 'cover',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .service__thumbnail:before' => 'background-size: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_control(
            'item_title',
            [
                'label' => esc_html__('Title', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'separator' => 'before',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_content',
            [
                'label' => esc_html__('Content', 'bighearts-core'),
                'type' => Controls_Manager::TEXTAREA,
			    'dynamic' => [  'active' => true],
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'bighearts-core'),
                'type' => Controls_Manager::URL,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'content_media_type',
            [
                'label' => esc_html__( 'Media Type', 'bighearts-core' ),
                'type' => Controls_Manager::CHOOSE,
                'separator' => 'before',
                'label_block' => false,
                'toggle' => false,
                'options' => [
                    '' => [
                        'title' => esc_html__( 'None', 'bighearts-core' ),
                        'icon' => 'fa fa-ban',
                    ],
                    'font' => [
                        'title' => esc_html__( 'Icon', 'bighearts-core' ),
                        'icon' => 'far fa-smile',
                    ],
                    'image' => [
                        'title' => esc_html__( 'Image', 'bighearts-core' ),
                        'icon' => 'fa fa-image',
                    ]
                ],
                'default' => '',
            ]
        );

        $repeater->add_control(
            'content_icon',
            [
                'label' => esc_html__('Icon', 'bighearts-core'),
                'type' => Controls_Manager::ICONS,
                'condition' => ['content_media_type' => 'font'],
                'label_block' => true,
                'description' => esc_html__('Select icon from available libraries.', 'bighearts-core'),
            ]
        );

        $repeater->add_control(
            'content_thumbnail',
            [
                'label' => esc_html__('Image', 'bighearts-core'),
                'type' => Controls_Manager::MEDIA,
			    'dynamic' => [  'active' => true],
                'condition' => ['content_media_type' => 'image'],
                'label_block' => true,
                'default' => ['url' => Utils::get_placeholder_image_src()],
            ]
        );

	    $repeater->add_control(
		    'items_front_icon_color_idle',
		    [
			    'label' => esc_html__('Front Icon Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'separator' => 'before',
			    'default' => BigHearts_Globals::get_btn_color_idle(),
			    'selectors' => [
				    '{{WRAPPER}} {{CURRENT_ITEM}} .wgl-service-front_icon i' => 'color: {{VALUE}};',
				    '{{WRAPPER}} {{CURRENT_ITEM}} .wgl-service-front_icon svg' => 'fill: {{VALUE}};',
				    '{{WRAPPER}} {{CURRENT_ITEM}} .wgl-service-front_icon' => 'background-color: {{VALUE}};',
			    ],
		    ]
	    );

	    $repeater->add_control(
		    'items_front_icon_bg_idle',
		    [
			    'label' => esc_html__('Front Icon Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
			    'default' => '#ffffff',
			    'selectors' => [
				    '{{WRAPPER}} {{CURRENT_ITEM}} .wgl-service-front_icon i' => 'background-color: {{VALUE}};',
			    ],
		    ]
	    );

	    $repeater->add_control(
		    'items_content_bg',
		    [
			    'label' => esc_html__('Background', 'bighearts-core'),
			    'type' => Controls_Manager::MEDIA,
			    'dynamic' => [  'active' => true],
			    'label_block' => true,
			    'selectors' => [
				    '{{WRAPPER}} {{CURRENT_ITEM}} .service__content' => 'background-image: url({{URL}});',
			    ],
		    ]
	    );

	    $this->add_control(
            'items',
            [
                'label' => esc_html__('Items', 'bighearts-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{item_title}}',
                'default' => [
                    ['item_title' => esc_html__('Title 1', 'bighearts-core')],
                    ['item_title' => esc_html__('Title 2', 'bighearts-core')],
                    ['item_title' => esc_html__('Title 3', 'bighearts-core')],
                ],
            ]
        );

	    $this->end_controls_section();

	    /**
         * CONTENT -> LINK
         */

        $this->start_controls_section(
            'section_content_link',
            ['label' => esc_html__('Link', 'bighearts-core')]
        );

        $this->add_control(
            'thumbnail_link',
            [
                'label' => esc_html__('Thumbnail Clickable', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'read_more_link',
            [
                'label' => esc_html__('Add \'Read More\' Button', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => esc_html__('Button Text', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'default' => esc_html__('LEARN MORE', 'bighearts-core'),
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
			    'default' => 'right',
			    'condition' => ['add_front_icon' => 'yes'],
			    'toggle' => true,
			    'prefix_class' => 'front_icon_alignment-',
			    'selectors' => [
				    '{{WRAPPER}} .wgl-service-front_icon-wrapper' => 'text-align: {{VALUE}};',
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
				    'value' => 'flaticon-plus',
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
				    '{{WRAPPER}} .wgl-service-front_icon i' => 'font-size: {{SIZE}}{{UNIT}};',
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
			    'default' => ['size' => 46 ],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-service-front_icon i' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
			    ],
		    ]
	    );

	    $this->end_controls_section();

	    /**
         * STYLE -> ITEM
         */

        $this->start_controls_section(
            'section_style_item',
            [
                'label' => esc_html__('Item', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'item_radius',
            [
                'label' => esc_html__( 'Border Radius', 'bighearts-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '10',
                    'left' => '10',
                    'right' => '10',
                    'bottom' => '10',
                ],
                'selectors' => [
                    '{{WRAPPER}} .service__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'content_heading',
            [
                'label' => esc_html__('Content', 'bighearts-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '10.5',
                    'left' => '10.5',
                    'right' => '10.5',
                    'bottom' => '10.5',
                    'unit' => '%',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .service__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

	    $this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
			    'name' => 'content_bg',
			    'label' => esc_html__('Background', 'bighearts-core'),
			    'types' => [ 'classic', 'gradient' ],
			    'selector' => '{{WRAPPER}} .service__content',
		    ]
	    );

	    $this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
			    'name' => 'custom_desc_mask_shadow',
			    'selector' => '{{WRAPPER}} .service__content',
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
            'icon_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '0',
                    'left' => '0',
                    'right' => '0',
                    'bottom' => '17',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .content__media.icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .content__media.icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .content__media.icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'range' => [
                    'px' => ['min' => 10, 'max' => 100],
                ],
                'default' => ['size' => 50],
                'selectors' => [
                    '{{WRAPPER}} .content__media.icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

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
                'selector' => '{{WRAPPER}} .content__title',
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
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => '10',
                    'left' => '0',
                    'right' => '0',
                    'bottom' => '25',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .service__content .content__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_thumb_color',
            [
                'label' => esc_html__('Title Color on the Left Side', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .service__thumbnail .content__title' => 'color: {{VALUE}};--text-shadow-color: {{VALUE}};',
                    '{{WRAPPER}} .service__item.active .service__thumbnail .content__title' => '--text-shadow-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
	            'label' => esc_html__('Title Color on the Right Side', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .service__content .content__title' => 'color: {{VALUE}};',
                ],
            ]
        );

	    $this->add_responsive_control(
		    'title_anim_delay',
		    [
			    'label' => esc_html__('Delay for Title Animation', 'bighearts-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
			    'range' => [
				    'px' => ['min' => 0, 'max' => 100, 'step' => 1 ],
			    ],
		    ]
	    );

	    $this->end_controls_section();

        /**
         * STYLE -> DESCRIPTION
         */

        $this->start_controls_section(
            'section_style_description',
            [
                'label' => esc_html__('Description', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_family' => ['default' => \Wgl_Addons_Elementor::$typography_3['font_family']],
                    'font_weight' => ['default' => \Wgl_Addons_Elementor::$typography_3['font_weight']],
                ],
                'selector' => '{{WRAPPER}} .content__description',
            ]
        );

        $this->add_control(
            'description_tag',
            [
                'label' => esc_html__('HTML Tag', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'div',
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
            'description_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .content__description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .content__description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> BUTTON
         */

        $this->start_controls_section(
            'section_style_button',
            [
                'label' => esc_html__('Button', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['read_more_text!' => ''],
            ]
        );

        $this->add_responsive_control(
            'button_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => '18',
                    'left' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .content__button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__( 'Padding', 'bighearts-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 10,
                    'left' => 20,
                    'right' => 20,
                    'bottom' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .content__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_radius',
            [
                'label' => esc_html__( 'Border Radius', 'bighearts-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .content__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'button' );

        $this->start_controls_tab(
            'custom_button_color_idle',
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
                    '{{WRAPPER}} .content__button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_idle',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .content__button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_idle',
                'selector' => '{{WRAPPER}} .content__button',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_button_color_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'button_color_hover',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .content__button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_hover',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .content__button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_hover',
                'selector' => '{{WRAPPER}} .content__button:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

	    /**
	     * STYLE -> FRONT ICON
	     */

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
				    '{{WRAPPER}} .wgl-service-front_icon-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
		    ]
	    );

	    $this->add_responsive_control(
		    'front_icon_padding',
		    [
			    'label' => esc_html__('Padding', 'bighearts-core'),
			    'type' => Controls_Manager::DIMENSIONS,
			    'size_units' => ['px', 'em', '%'],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-service-front_icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			    'default' => ['size' => 28, 'unit' => 'px'],
			    'selectors' => [
				    '{{WRAPPER}} .wgl-service-front_icon, {{WRAPPER}} .wgl-service-front_icon i' => 'border-radius: {{SIZE}}px;',
			    ],
		    ]
	    );


	    $this->start_controls_tabs(
		    'front_icon_tabs',
		    ['separator' => 'before']
	    );

	    $this->start_controls_tab(
		    'front_icon_tabs_idle',
		    ['label' => esc_html__('Idle', 'bighearts-core')]
	    );

	    $this->add_control(
		    'front_icon_rotate_idle',
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
				    '{{WRAPPER}} .wgl-service-front_icon i' => 'transform: rotate({{SIZE}}{{UNIT}});',
			    ],
		    ]
	    );
	    $this->end_controls_tab();

	    $this->start_controls_tab(
		    'front_icon_tabs_active',
		    ['label' => esc_html__('Active', 'bighearts-core')]
	    );

	    $this->add_control(
		    'front_icon_rotate_active',
		    [
			    'label' => esc_html__('Rotate', 'bighearts-core'),
			    'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
			    'size_units' => ['deg', 'turn'],
			    'range' => [
				    'deg' => ['max' => 360],
				    'turn' => ['min' => 0, 'max' => 1, 'step' => 0.1],
			    ],
			    'default' => [
			    	'size' => 45,
			    	'unit' => 'deg'
			    ],
			    'selectors' => [
				    '{{WRAPPER}} .service__item.active .wgl-service-front_icon i' => 'transform: rotate({{SIZE}}{{UNIT}});',
			    ],
		    ]
	    );

	    $this->end_controls_tab();
	    $this->end_controls_tabs();
	    $this->end_controls_section();
    }

    /**
     * @version 1.1.5
     */
    public function render()
    {
        $_s = $this->get_settings_for_display();

        $this->add_render_attribute(
        	'services',[
	        'class' => ['wgl-accordion-services'],
        ]);

	    // Front Icon
	    if ($_s['add_front_icon']) {
		    $icon_font = $_s['add_front_icon_fontawesome'];

		    $migrated = isset($_s['__fa4_migrated']['add_front_icon_fontawesome']);
		    $is_new = Icons_Manager::is_migration_allowed();
		    $icon_output = '';

		    if ( $is_new || $migrated ) {
			    ob_start();
			    Icons_Manager::render_icon( $_s['add_front_icon_fontawesome'], ['aria-hidden' => 'true'] );
			    $icon_output .= ob_get_clean();
		    } else {
			    $icon_output .= '<i class="icon '.esc_attr($icon_font).'"></i>';
		    }

		    if (!empty($icon_output)){
			    $front_icon = '<div class="wgl-service-front_icon-wrapper">';
				    $front_icon .= '<div class="wgl-service-front_icon">';
				        $front_icon .= $icon_output;
				    $front_icon .= '</div>';
			    $front_icon .= '</div>';
		    }
	    }

        echo '<div ', $this->get_render_attribute_string('services'), '>';

            foreach ($_s['items'] as $index => $item) {
                $has_link = ! empty( $item[ 'link' ][ 'url' ] );

                if ($has_link) {
                    $link = $this->get_repeater_setting_key('link', 'items', $index);
                    $this->add_link_attributes($link, $item['link']);
                }

	            if ( ! empty( $item[ 'item_title' ] ) ) {
		            $item[ 'item_title' ] = wp_kses( $item['item_title'], self::get_kses_allowed_html() );
		            $title_bool = true;
	            } else {
		            $title_bool = false;
	            }

                echo '<div class="service__item elementor-repeater-item-', $item['_id'], '">';

                    // Thumbnail
                    printf(
                        '<%1$s class="service__thumbnail">%2$s %3$s</%1$s>',
                        !empty($_s['thumbnail_link']) && $has_link ? 'a ' . $this->get_render_attribute_string($link) : 'div',
	                    $title_bool ? '<div class="content__title">'.$item['item_title'].'</div>' : '',
	                    ! empty( $front_icon ) ? $front_icon : ''
                    );

                    echo '<div class="service__content">';

                    // ↓ Media
                    if ( $item[ 'content_media_type' ] != '' ) {
                        if (
                            $item[ 'content_media_type' ] === 'font'
                            && ! empty( $item[ 'content_icon' ] )
                        ) {
                            $media_class = ' icon';
                            $migrated = isset($item['__fa4_migrated'][$item['content_icon']]);
                            $is_new = Icons_Manager::is_migration_allowed();
                            if ($is_new || $migrated) {
                                ob_start();
                                Icons_Manager::render_icon($item['content_icon']);
                                $media_html = ob_get_clean();
                            } else {
                                $media_html = '<i class="icon ' . esc_attr($item['content_icon']) . '"></i>';
                            }
                        }

                        if (
                            $item[ 'content_media_type' ] === 'image'
                            && ! empty( $item[ 'content_thumbnail' ][ 'url' ] )
                        ) {
                            $media_class = ' image';

                            $this->add_render_attribute('thumbnail', 'src', $item['content_thumbnail']['url']);
                            $this->add_render_attribute('thumbnail', 'alt', Control_Media::get_image_alt($item['content_thumbnail']));
                            $this->add_render_attribute('thumbnail', 'title', Control_Media::get_image_title($item['content_thumbnail']));

                            $media_html = Group_Control_Image_Size::get_attachment_image_html($item, 'thumbnail', 'content_thumbnail');
                        }

                        echo '<span class="content__media', $media_class ?? '', '">',
                            $media_html ?? '',
                        '</span>';
                    }
                    // ↑ media

                    //* Title
                    if ($title_bool) {
	                    //* cropping title
	                    $delay = 350;
	                    $_delay = !!$_s['title_anim_delay']['size'] ? floor($_s['title_anim_delay']['size']) : 50;
	                    $title = '<span class="title_anim">';
	                        $item['item_title'] = preg_replace("/<br\W*?\/?>/", "⇙", $item['item_title']);
		                    $len = mb_strlen($item['item_title']);
	                        $title .= '<span class="word">';
		                    for ($k = 0; $k < $len; $k++) {
		                    	$letter = mb_substr( $item['item_title'], $k, 1 );
			                    if ('⇙' === $letter){
				                    $title .= '<br/>';
			                    }else if (' ' === $letter){
				                    $title .= '<span class="space"> </span></span><span class="word">';
			                    }else{
				                    $title .= '<span class="letter" style="transition-delay:'.$delay.'ms">'.$letter.'</span>';
			                    }
			                    $delay += $_delay;
		                    }
	                        $title .= '</span>';
	                    $title .= '</span>';
	                    echo '<', $_s['title_tag'], ' class="content__title">',
	                        $title,
	                    '</', $_s['title_tag'], '>';
                    }

                    // Description
                    if ( ! empty( $item[ 'item_content' ] ) ) {
                        echo '<', $_s[ 'description_tag' ], ' class="content__description">',
                            wp_kses( $item[ 'item_content' ], self::get_kses_allowed_html() ),
                            '</', $_s[ 'description_tag' ], '>';
                    }

                    // Read More
                    if ( ! empty( $_s[ 'read_more_link' ] ) && $has_link ) {
                        echo '<a ', $this->get_render_attribute_string( $link ), ' class="content__button" role="button">',
                            $_s[ 'read_more_text' ],
                        '</a>';
                    }

                    echo '</div>'; // service__content

                echo '</div>';
            }

        echo '</div>';
    }

    /**
     * @since 1.1.5
     */
    protected static function get_kses_allowed_html()
    {
        $allowed_attributes = [
            'id' => true,
            'class' => true,
            'style' => true,
        ];

        return [
            'a' => $allowed_attributes + [
                'href' => true,
                'title' => true,
                'rel' => true,
                'target' => true,
            ],
            'br' => $allowed_attributes,
            'wbr' => $allowed_attributes,
            'b' => $allowed_attributes,
            'strong' => $allowed_attributes,
            'em' => $allowed_attributes,
            'i' => $allowed_attributes,
            'small' => $allowed_attributes,
            'sup' => $allowed_attributes,
            'sub' => $allowed_attributes,
            'span' => $allowed_attributes,
            'p' => $allowed_attributes,
        ];
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
