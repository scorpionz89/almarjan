<?php
/**
 * Current file can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/widgets/wgl-button-widget.php`.
 */
namespace WglAddons\Widgets;

defined( 'ABSPATH' ) || exit;

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Group_Control_Border,
    Group_Control_Typography,
    Group_Control_Box_Shadow
};
use WglAddons\{
    BigHearts_Global_Variables as BigHearts_Globals,
    Includes\Wgl_Icons,
    Templates\WGL_Button
};

/**
 * Button Widget
 *
 *
 * @package bighearts-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 * @version 1.1.5
 */
class Wgl_Button_Widget extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-button';
    }

    public function get_title()
    {
        return esc_html__('WGL Button', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-button';
    }

    /**
     * @since 1.1.5
     */
    public function get_keywords()
    {
        return [ 'button' ];
    }

    public function get_categories()
    {
        return ['wgl-extensions'];
    }

    public static function get_button_sizes()
    {
        return [
            'sm' => esc_html__('Small', 'bighearts-core'),
            'md' => esc_html__('Medium', 'bighearts-core'),
            'lg' => esc_html__('Large', 'bighearts-core'),
            'xl' => esc_html__('Extra Large', 'bighearts-core'),
        ];
    }

    protected function register_controls()
    {
        /** CONTENT -> GENERAL */

        $this->start_controls_section(
            'section_content_general',
            [ 'label' => esc_html__( 'General', 'bighearts-core' ) ]
        );

        $this->add_control(
            'text',
            [
                'label' => esc_html__( 'Text', 'bighearts-core' ),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'placeholder' => esc_attr__( 'ex: LEARN MORE', 'bighearts-core' ),
                'default' => esc_html__( 'LEARN MORE', 'bighearts-core' ),
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'bighearts-core'),
                'type' => Controls_Manager::URL,
			    'dynamic' => [  'active' => true],
                'placeholder' => esc_attr__('https://your-link.com', 'bighearts-core'),
                'default' => ['url' => '#'],
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__( 'Alignment', 'bighearts-core' ),
                'type' => Controls_Manager::CHOOSE,
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
                    'justify' => [
                        'title' => esc_html__('Full Width', 'bighearts-core'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'prefix_class' => 'a%s',
            ]
        );

        $this->add_control(
            'size',
            [
                'label' => esc_html__('Size', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'options' => self::get_button_sizes(),
                'default' => 'lg',
                'style_transfer' => true,
            ]
        );

        $this->end_controls_section();

        $output['icon_align'] = [
            'label' => esc_html__('Position', 'bighearts-core'),
            'type' => Controls_Manager::SELECT,
            'condition' => ['icon_type!' => ''],
            'options' => [
                'left' => esc_html__('Before', 'bighearts-core'),
                'right' => esc_html__('After', 'bighearts-core'),
            ],
            'default' => 'left',
        ];

        $output['icon_indent'] = [
            'label' => esc_html__('Offset', 'bighearts-core'),
            'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
            'dynamic' => [  'active' => true],
            'condition' => ['icon_type!' => ''],
            'range' => [
                'px' => ['max' => 50],
            ],
            'selectors' => [
                '{{WRAPPER}} .align-icon-right .media-wrapper' => 'margin-left: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .align-icon-left .media-wrapper' => 'margin-right: {{SIZE}}{{UNIT}};',
            ],
        ];

        Wgl_Icons::init(
            $this,
            [
                'output' => $output,
                'section' => true,
            ]
        );

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

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'selector' => '{{WRAPPER}} .wgl-button',
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'button_color_idle',
            [
                'label' => esc_html__( 'Text Color', 'bighearts-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .wgl-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_color_idle',
            [
                'label' => esc_html__( 'Border Color', 'bighearts-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'condition' => ['border_border!' => ''],
                'default' => BigHearts_Globals::get_btn_color_idle(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-button' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_idle',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_btn_color_idle(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .wgl-button',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [ 'label' => esc_html__( 'Hover', 'bighearts-core' ) ]
        );

        $this->add_control(
            'button_color_hover',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .wgl-button:hover,
                     {{WRAPPER}} .wgl-button:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => esc_html__( 'Border Color', 'bighearts-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'condition' => ['border_border!' => ''],
                'default' => BigHearts_Globals::get_btn_color_hover(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-button:hover,
                     {{WRAPPER}} .wgl-button:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_hover',
            [
                'label' => esc_html__( 'Background Color', 'bighearts-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_btn_color_hover(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-button:hover,
                     {{WRAPPER}} .wgl-button:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_hover_box_shadow',
                'selector' => '{{WRAPPER}} .wgl-button:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'separator' => 'before',
                'fields_options' => [
                    'color' => ['type' => Controls_Manager::HIDDEN],
                ],
                'selector' => '{{WRAPPER}} .wgl-button',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'bighearts-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /** STYLE -> MEDIA */

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__( 'Media (icon/image)', 'bighearts-core' ),
                'condition' => [ 'icon_type!' => '' ],
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'media_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => 'vertical',
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_icon',
            [
                'condition' => [ 'icon_type' => 'font' ],
            ]
        );

        $this->start_controls_tab(
            'tab_icon_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'icon_color_idle',
            [
                'label' => esc_html__('Icon Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-button:hover .elementor-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__('Font Size', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'condition' => ['icon_type' => 'font'],
                'separator' => 'before',
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['max' => 80],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> ANIMATION
         */

        $this->start_controls_section(
            'section_style_animation',
            [
                'label' => esc_html__('Animation', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => esc_html__('Button Hover', 'bighearts-core'),
                'type' => Controls_Manager::HOVER_ANIMATION,
                'separator' => 'after',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * @since 1.0.0
     * @version 1.1.5
     */
    protected function render()
    {
        ( new WGL_Button() )->render(
            $this,
            $this->get_settings_for_display()
        );
    }

    /**
     * @since 1.1.5
     */
    public function wpml_support_module()
    {
        add_filter( 'wpml_elementor_widgets_to_translate', [ $this, 'wpml_widgets_to_translate_filter' ] );
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
