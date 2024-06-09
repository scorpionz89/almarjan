<?php
/**
 * Current file can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/widgets/wgl-counter.php`.
 */
namespace WglAddons\Widgets;

defined( 'ABSPATH' ) || exit;

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Group_Control_Border,
    Group_Control_Typography,
    Group_Control_Box_Shadow,
    Group_Control_Background
};
use WglAddons\{
    BigHearts_Global_Variables as BigHearts_Globals,
    Includes\Wgl_Icons
};

/**
 * Counter Widget
 *
 *
 * @package bighearts-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 * @version 1.1.5
 */
class Wgl_Counter extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-counter';
    }

    public function get_title()
    {
        return esc_html__('WGL Counter', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-counter';
    }

    /** @since 1.1.5 */
    public function get_keywords()
    {
        return [ 'counter' ];
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
        /** CONTENT -> GENERAL */

        $this->start_controls_section(
            'wgl_counter_content',
            ['label' => esc_html__('General', 'bighearts-core')]
        );

        Wgl_Icons::init(
            $this,
            [
                'label' => esc_html__('Counter ', 'bighearts-core'),
                'output' => '',
                'section' => false,
            ]
        );

        $this->add_control(
            'layout',
            [
                'label' => esc_html__('Layout', 'bighearts-core'),
                'type' => 'wgl-radio-image',
                'condition' => [ 'icon_type!' => '' ],
                'options' => [
                    'top' => [
                        'title' => esc_html__( 'Top', 'bighearts-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/style_def.png',
                    ],
                    'left' => [
                        'title' => esc_html__( 'Left', 'bighearts-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/style_left.png',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'bighearts-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/style_right.png',
                    ],
                ],
                'default' => 'top',
            ]
        );

        $this->add_control(
            'counter_title',
            [
                'label' => esc_html__( 'Title', 'bighearts-core' ),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'separator' => 'before',
                'label_block' => true,
                'default' => esc_html_x('THIS IS THE', 'counter title', 'bighearts-core').'<br>'.esc_html_x('HEADING', 'counter title', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'title_block',
            [
                'label' => esc_html__('Title Full Width', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'start_value',
            [
                'label' => esc_html__('Start Value', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'separator' => 'before',
                'min' => 0,
                'step' => 10,
                'default' => 0,
            ]
        );

        $this->add_control(
            'end_value',
            [
                'label' => esc_html__('End Value', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'min' => 1,
                'step' => 10,
                'default' => 120,
            ]
        );

        $this->add_control(
            'prefix',
            [
                'label' => esc_html__('Counter Prefix', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
            ]
        );

        $this->add_control(
            'suffix',
            [
                'label' => esc_html__('Counter Suffix', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'placeholder' => esc_attr__('ex: +', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'speed',
            [
                'label' => esc_html__('Animation Speed', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'min' => 100,
                'step' => 100,
                'default' => 2000,
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__( 'Alignment', 'bighearts-core' ),
                'type' => Controls_Manager::CHOOSE,
                'separator' => 'before',
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
                'prefix_class' => 'a%s',
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> GENERAL
         */

        $this->start_controls_section(
            'counter_style_section',
            [
                'label' => esc_html__( 'General', 'bighearts-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'counter_offset',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'counter_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'counter_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'bighearts-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('counter_color_tab');

        $this->start_controls_tab(
            'custom_counter_color_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'bg_counter_color',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'counter_border',
                'label' => esc_html__('Border Type', 'bighearts-core'),
                'selector' => '{{WRAPPER}} .wgl-counter',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'counter_shadow',
                'selector' => '{{WRAPPER}} .wgl-counter',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_counter_color_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'counter_border_hover',
                'selector' => '{{WRAPPER}}:hover .wgl-counter',
            ]
        );

        $this->add_control(
            'bg_counter_color_hover',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}}:hover .wgl-counter' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'counter_shadow_hover',
                'selector' => '{{WRAPPER}}:hover .wgl-counter',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /** STYLE -> MEDIA */

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__( 'Media (icon/image)', 'bighearts-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'icon_type!' => '' ],
            ]
        );

        $this->add_control(
            'primary_color',
            [
                'label' => esc_html__('Icon Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'condition' => [ 'icon_type' => 'font' ],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'condition' => [ 'icon_type' => 'font' ],
                'range' => [
                    'px' => [ 'min' => 13, 'max' => 100 ],
                ],
                'default' => [ 'size' => 52 ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '16',
                    'left' => '0',
                ],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'counter_icon_border_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'counter_icon_border',
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'pembe-core' ) ],
                    'color' => [ 'label' => esc_html__( 'Border Color', 'pembe-core' ) ],
                ],
                'selector' => '{{WRAPPER}} .media-wrapper',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'media_background',
                'fields_options' => [
                    'color' => [ 'label' => esc_html__( 'Background Color', 'pembe-core' ) ],
                    'image' => [ 'label' => esc_html__( 'Background Image', 'pembe-core' ) ],
                ],
                'selector' => '{{WRAPPER}} .media-wrapper',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'counter_icon_shadow',
                'selector' => '{{WRAPPER}} .media-wrapper',
            ]
        );

        $this->end_controls_section();


        /** STYLE -> VALUE */

        $this->start_controls_section(
            'value_style_section',
            [
                'label' => esc_html__('Value', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'value_offset',
            [
                'label' => esc_html__('Value Offset', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter_value-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_value',
                'selector' => '{{WRAPPER}} .wgl-counter_value-wrap',
            ]
        );

        $this->add_control(
            'value_color',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter_value-wrap' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /** STYLE -> TITLE */

        $this->start_controls_section(
            'title_style_section',
            [
                'label' => esc_html__('Title', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_title',
                'selector' => '{{WRAPPER}} .wgl-counter_title',
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
            'title_offset',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'size_units' => [ 'px', 'em', '%' ],
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => '4',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '19',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__( 'Padding', 'pembe-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter_title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'title_border',
                'fields_options' => [
                    'width' => [ 'label' => esc_html__( 'Border Width', 'pembe-core' ) ],
                    'color' => [ 'label' => esc_html__( 'Border Color', 'pembe-core' ) ],
                ],
                'selector' => '{{WRAPPER}} .wgl-counter_title',
            ]
        );

        $this->add_responsive_control(
            'title_radius',
            [
                'label' => esc_html__( 'Border Radius', 'pembe-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter_title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Text Color', 'bighearts-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter_title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_bg',
            [
                'label' => esc_html__( 'Background Color', 'pembe-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .wgl-counter_title' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function render()
    {
        $_s = $this->get_settings_for_display();

        $this->add_render_attribute(
            [
                'counter' => [
                    'class' => [
                        'wgl-counter',
                        $_s['title_block'] ? 'title-block' : 'title-inline',
                    ],
                ],
                'counter-wrap' => [
                    'class' => [
                        'wgl-counter_wrap',
                        $_s['layout'] ? 'wgl-layout-' . $_s['layout'] : '',
                    ],
                ],
                'counter_value' => [
                    'class' => 'wgl-counter__value',
                    'data-start-value' => $_s['start_value'],
                    'data-end-value' => $_s['end_value'],
                    'data-speed' => $_s['speed'],
                ],
            ]
        );

        //* Icon/Image
        ob_start();
        if (!empty($_s['icon_type'])) {
            $icons = new Wgl_Icons;
            echo $icons->build($this, $_s, []);
        }
        $counter_media = ob_get_clean();

        $_s['prefix'] = !empty($_s['prefix']) ? $_s['prefix'] : '';

        //* Render
        echo '<div ', $this->get_render_attribute_string( 'counter' ), '>';
        echo '<div ', $this->get_render_attribute_string( 'counter-wrap' ), '>';
            if ($_s[ 'icon_type' ] != '' && $counter_media) {
                echo '<div class="media-wrap">',
                    $counter_media,
                '</div>';
            }

            echo '<div class="content-wrap">';
            echo '<div class="wgl-counter_value-wrap">';

                if ($_s[ 'prefix' ]) {
                    echo '<span class="wgl-counter__prefix">', $_s[ 'prefix' ], '</span>';
                }

                if (!empty($_s[ 'end_value' ])) {
                    echo '<div class="wgl-counter__placeholder-wrap">';
                    echo '<span class="wgl-counter__placeholder">',
                        $_s[ 'end_value' ],
                    '</span>';

                    echo '<span ', $this->get_render_attribute_string( 'counter_value' ), '>',
                        $_s[ 'start_value' ],
                    '</span>';
                    echo '</div>';
                }

                if (!empty($_s[ 'suffix' ])) {
                    echo '<span class="wgl-counter__suffix">',
                        $_s[ 'suffix' ],
                    '</span>';
                }
            echo '</div>'; // wgl-counter_value-wrap

            if (!empty($_s[ 'counter_title' ])) {
                echo '<', $_s[ 'title_tag' ], ' class="wgl-counter_title">',
                    $_s[ 'counter_title' ],
                '</', $_s[ 'title_tag' ], '>';
            }
            echo '</div>'; // content-wrap
        echo '</div>';
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
