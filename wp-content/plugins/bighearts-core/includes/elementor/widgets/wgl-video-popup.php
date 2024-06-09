<?php
/**
 * This template can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/widgets/wgl-video-popup.php`.
 */
namespace WglAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{
    Widget_Base,
    Embed,
    Controls_Manager,
    Group_Control_Border,
    Group_Control_Box_Shadow,
    Group_Control_Typography,
    Group_Control_Background
};
use WglAddons\BigHearts_Global_Variables as BigHearts_Globals;

class Wgl_Video_Popup extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-video-popup';
    }

    public function get_title()
    {
        return esc_html__('WGL Video Popup', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-video-popup';
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
            'wgl_video_popup_section',
            ['label' => esc_html__('General', 'bighearts-core')]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'default' => esc_html__('Watch Video','bighearts-core'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Video Link', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'description' => esc_html__('Link from youtube or vimeo.', 'bighearts-core'),
                'separator' => 'after',
                'label_block' => true,
                'placeholder' => esc_attr__('https://www.youtube.com/watch?v=', 'bighearts-core'),
                'default' => 'https://www.youtube.com/watch?v=TKnufs85hXk',
            ]
        );

        $this->add_responsive_control(
            'title_pos',
            [
                'label' => esc_html__('Title Position', 'bighearts-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'top' => [
                        'title' => esc_html__( 'Top', 'bighearts-core' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                    'left' => [
                        'title' => esc_html__( 'Left', 'bighearts-core' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'bot' => [
                        'title' => esc_html__( 'Bottom', 'bighearts-core' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'bighearts-core' ),
                        'icon' => 'eicon-h-align-left',
                    ],

                ],
                'label_block' => false,
                'default' => 'right',
                'toggle' => true,
            ]
        );

        $this->add_responsive_control(
            'alignment',
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
                    'inline' => [
                        'title' => esc_html__('Inline', 'bighearts-core'),
                        'icon' => 'eicon-h-align-stretch',
                    ],
                ],
                'prefix_class' => 'align%s-',
                'default' => 'center',
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> ANIMATION
         */

        $this->start_controls_section(
            'section_content_animation',
            [
                'label' => esc_html__('Animation', 'bighearts-core'),
                'condition' => ['title!' => ''],
            ]
        );

        $this->add_control(
            'animation_style',
            [
                'label' => esc_html__('Animation Style', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('No animation', 'bighearts-core'),
                    'ring_static' => esc_html__('Static Ring', 'bighearts-core'),
                    'ring_pulse' => esc_html__('Pulsing Ring', 'bighearts-core'),
                    'circles' => esc_html__('Divergent Rings', 'bighearts-core'),
                ],
                'default' => '',
            ]
        );

        $this->add_control(
            'anim_color',
            [
                'label' => esc_html__('Animation Element Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'condition' => ['animation_style!' => ''],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .videobox_animation' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .animation_ring_pulse .videobox_animation' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'always_run_animation',
            [
                'label' => esc_html__('Run Animation Until Hover', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'animation_style!' => ['', 'ring_static']
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
                'condition' => ['title!' => ''],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
	                'top' => '0',
	                'right' => '0',
	                'bottom' => '0',
	                'left' => '19',
	                'unit' => 'px',
	                'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .title' => 'color: {{VALUE}};',
                ],
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

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title',
                'selector' => '{{WRAPPER}} .title',
            ]
        );

        $this->add_control(
            'title_divider',
            [
                'label' => esc_html__('Title Divider', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
                'default' => false,
                'prefix_class' => 'divider_',
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
            ]
        );

        $this->add_responsive_control(
            'button_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .videobox_link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_size',
            [
                'label' => esc_html__('Button Size', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'size_units' => ['px'],
                'range' => [
                    'px' => ['max' => 200],
                ],
                'default' => ['size' => 100, 'unit' => 'px'],
                'description' => esc_html__('Button diameter in pixels.', 'bighearts-core'),
                'selectors' => [
                    '{{WRAPPER}} .videobox_link' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('item_color_tab');

        $this->start_controls_tab(
            'custom_item_color_normal',
            ['label' => esc_html__('Normal' , 'bighearts-core')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'bg_color',
                'label' => esc_html__('Button Background', 'bighearts-core'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .videobox_link',
                'fields_options' => [
                    'background' => ['default' => 'classic'],
                    'color' => ['default' => BigHearts_Globals::get_primary_color() ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'label' => esc_html__('Border Type', 'bighearts-core'),
                'selector' => '{{WRAPPER}} .videobox_link',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow',
                'selector' => '{{WRAPPER}} .videobox_link',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_item_color_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'bg_color_hover',
                'label' => esc_html__('Button Background', 'bighearts-core'),
                'types' => ['classic', 'gradient'],
                'fields_options' => [
	                'background' => ['default' => 'classic'],
	                'color' => ['default' => BigHearts_Globals::get_secondary_color() ],
                ],
                'selector' => '{{WRAPPER}} .videobox_link:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border_hover',
                'label' => esc_html__('Border Type', 'bighearts-core'),
                'selector' => '{{WRAPPER}} .videobox_link:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow_hover',
                'selector' => '{{WRAPPER}} .videobox_link:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'triangle_size',
            [
                'label' => esc_html__('Triangle Size', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'separator' => 'before',
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['max' => 100],
                ],
                'default' => ['size' => 24, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .videobox_icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'triangle_color',
            [
                'label' => esc_html__('Triangle Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .videobox_icon' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'triangle_corners',
            [
                'label' => esc_html__('Triangle Rounded Corners', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
                'default' => false,
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $_s = $this->get_settings_for_display();

        $this->add_render_attribute('video-wrap', 'class', [
            'wgl-video_popup',
            $_s['animation_style'] ? 'animation_' . $_s['animation_style'] : '',
            'title_pos-' . $_s['title_pos'],
            !empty($_s['bg_image']['url']) ? 'with_image' : '',
            $_s['always_run_animation'] ? 'idle-animation' : '',
        ]);

        $animated_element = '';
        switch ($_s['animation_style']) {
            case 'circles':
                $animated_element .= '<div class="videobox_animation circle_1"></div>';
                $animated_element .= '<div class="videobox_animation circle_2"></div>';
                $animated_element .= '<div class="videobox_animation circle_3"></div>';
                break;
            case 'ring_pulse':
            case 'ring_static':
                $animated_element .= '<div class="videobox_animation"></div>';
                break;
        }

        // Triangle svg
        switch ($_s['triangle_corners']) {
            default:
            case false:
                $triangle_svg = '<svg class="videobox_icon" viewBox="0 0 10 10"><polygon points="1,0 1,10 8.5,5"/></svg>';
                break;
            case true:
                $triangle_svg = '<svg class="videobox_icon" viewBox="0 0 232 232"><path d="M203,99L49,2.3c-4.5-2.7-10.2-2.2-14.5-2.2 c-17.1,0-17,13-17,16.6v199c0,2.8-0.07,16.6,17,16.6c4.3,0,10,0.4,14.5-2.2 l154-97c12.7-7.5,10.5-16.5,10.5-16.5S216,107,204,100z"/></svg>';
                break;
        }

        // Render
        echo '<div ', $this->get_render_attribute_string('video-wrap'), '>';
        echo '<div class="videobox_content">';
            if (!empty($_s['bg_image']['url'])) {
                echo '<div class="videobox_background">',
                    wp_get_attachment_image($_s['bg_image']['id'], 'full'),
                '</div>',
                '<div class="videobox_link_wrapper">';
            }
            if (!empty($_s['title'])) {
                echo '<', $_s['title_tag'], ' class="title">',
                    esc_html__($_s['title']),
                '</', $_s['title_tag'], '>';
            }

            $lightbox_url = Embed::get_embed_url( $_s['link'], ['loop' => 0], [] );

            $lightbox_options = [
                'type' => 'video',
                'url' => $lightbox_url,
                'modalOptions' => [
                    'id' => 'elementor-lightbox-' . $this->get_id(),
                ],
            ];

            $this->add_render_attribute( 'video-lightbox', [
                'class' => 'videobox_link videobox',
                'data-elementor-open-lightbox' => 'yes',
                'data-elementor-lightbox' =>  wp_json_encode( $lightbox_options ),
            ] );

            echo '<div ', $this->get_render_attribute_string( 'video-lightbox' ) , '>';
                echo $triangle_svg;
                echo $animated_element;
            echo '</div>';
            if (!empty($_s['bg_image']['url'])) {
                echo '</div>';
            }
        echo '</div>'; // videobox_content
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