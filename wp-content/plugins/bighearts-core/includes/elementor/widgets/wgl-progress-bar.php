<?php
/**
 * This template can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/widgets/wgl-progress-bar.php`.
 */
namespace WglAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Group_Control_Border,
    Group_Control_Typography,
    Group_Control_Box_Shadow
};
use WglAddons\BigHearts_Global_Variables as BigHearts_Globals;

class Wgl_Progress_Bar extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-progress-bar';
    }

    public function get_title()
    {
        return esc_html__('WGL Progress Bar', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-progress-bar';
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
        /**
         * CONTENT -> GENERAL
         */

        $this->start_controls_section(
            'section_content_general',
            [ 'label' => esc_html__('General', 'bighearts-core') ]
        );

        $this->add_control(
            'progress_title',
            [
                'label' => esc_html__('Title', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'placeholder' => esc_attr__('ex: DONATION', 'bighearts-core'),
                'default' => esc_html__('DONATION', 'bighearts-core'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'value',
            [
                'label' => esc_html__('Value', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'default' => [ 'size' => 70, 'unit' => '%' ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'units',
            [
                'label' => esc_html__('Units', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
                'placeholder' => esc_attr__('ex: %, px, points, etc.', 'bighearts-core'),
                'default' => esc_html__('%', 'bighearts-core'),
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
                'name' => 'progress_title_typo',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_family' => ['default' => \Wgl_Addons_Elementor::$typography_1['font_family']],
                    'font_weight' => ['default' => \Wgl_Addons_Elementor::$typography_1['font_weight']],
                ],
                'selector' => '{{WRAPPER}} .progress_label_wrap',
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
                'default' => 'div',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => esc_attr(BigHearts_Globals::get_h_font_color()),
                'selectors' => [
                    '{{WRAPPER}} .progress_label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .progress_label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> VALUE
         */

        $this->start_controls_section(
            'section_style_value',
            [
                'label' => esc_html__('Value', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'progress_value_typo',
                'selector' => '{{WRAPPER}} .progress_value_wrap',
            ]
        );

        $this->add_control(
            'value_color',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .progress_value_wrap' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'value_bg',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .progress_value_wrap' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'value_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .progress_value_wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'value_border_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .progress_value_wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'value_position',
            [
                'label' => esc_html__('Value Position', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'fixed' => esc_html__('Fixed', 'bighearts-core'),
                    'dynamic' => esc_html__('Dynamic', 'bighearts-core'),
                ],
                'default' => 'fixed',
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> PROGRESS BAR
         */

        $this->start_controls_section(
            'section_style_bar',
            [
                'label' => esc_html__('Bar', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bar_height_filled',
            [
                'label' => esc_html__('Filled Bar Height', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
                'range' => [
                    'px' => [ 'min' => 1, 'max' => 50 ],
                ],
                'default' => [ 'size' => 8 ],
                'selectors' => [
                    '{{WRAPPER}} .progress_bar_wrap .progress_bar' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .progress_bar_wrap .progress_bar:after' => 'height: calc({{SIZE}}{{UNIT}} * 1.75); width: calc({{SIZE}}{{UNIT}} * 1.75);',
                ],
            ]
        );

        $this->add_control(
            'bar_height_empty',
            [
                'label' => esc_html__('Empty Bar Height', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
                'range' => [
                    'px' => [ 'min' => 1, 'max' => 50 ],
                ],
                'default' => [ 'size' => 8 ],
                'selectors' => [
                    '{{WRAPPER}} .progress_bar_wrap' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'bar_bg_empty',
            [
                'label' => esc_html__('Empty Bar Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#eaeaea',
                'selectors' => [
                    '{{WRAPPER}} .progress_bar_wrap' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'bar_color_filled',
            [
                'label' => esc_html__('Filled Bar Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .progress_bar' => 'background-color: {{VALUE}};',
                ],
            ]
        );

	    $this->add_control(
		    'bar_delimiter',
		    [
			    'label' => esc_html__('Show Delimiter', 'bighearts-core'),
			    'type' => Controls_Manager::SWITCHER,
			    'selectors' => [
				    '{{WRAPPER}} .progress_bar:after' => 'opacity: 1;',
			    ],
		    ]
	    );

	    $this->add_responsive_control(
            'bar_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .progress_bar_wrap-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'bar_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '11',
                    'right' => '0',
                    'bottom' => '8',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .progress_bar_wrap-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'bar_border_radius',
            [
	            'label' => esc_html__('Border Radius', 'bighearts-core'),
	            'type' => Controls_Manager::DIMENSIONS,
	            'size_units' => [ 'px', '%' ],
	            'default' => [
		            'top' => '4',
		            'right' => '4',
		            'bottom' => '4',
		            'left' => '4',
		            'unit' => 'px',
		            'isLinked' => true,
	            ],
                'selectors' => [
                    '{{WRAPPER}} .progress_bar_wrap,
                     {{WRAPPER}} .progress_bar,
                     {{WRAPPER}} .progress_bar_wrap-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'bar_box_shadow',
                'selector' => '{{WRAPPER}} .progress_bar_wrap',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .progress_bar_wrap-wrap',
            ]
        );

        $this->end_controls_section();

    }

    public function render()
    {
        $_s = $this->get_settings_for_display();

        $this->add_render_attribute('progress_bar', 'class', [
            'wgl-progress_bar',
            $_s['value_position'] == 'dynamic' ? 'dynamic-value' : '',
        ]);

        $this->add_render_attribute('bar', [
            'class' => 'progress_bar',
            'data-width' => esc_attr((int)$_s['value']['size']),
        ]);

        $this->add_render_attribute('label', 'class', 'progress_label');

        // Render
        echo '<div ', $this->get_render_attribute_string('progress_bar'), '>';
            echo '<div class="progress_wrap">';

                echo '<div class="progress_label_wrap">';
                    if (!empty($_s['progress_title'])) {
                        echo '<', esc_attr($_s['title_tag']), ' ',
                            $this->get_render_attribute_string('label'),
                            '>',
                            esc_html($_s['progress_title']),
                            '</', esc_attr($_s['title_tag']), '>';
                    }
                    echo '<div class="progress_value_wrap">';
                        echo '<span class="progress_value">0</span>';
                        if (!empty($_s['units'])) {
                            echo '<span class="progress_units">',
                                esc_html($_s['units']),
                            '</span>';
                        }
                    echo '</div>';
                echo '</div>';

                echo '<div class="progress_bar_wrap-wrap">',
                    '<div class="progress_bar_wrap">',
                        '<div ', $this->get_render_attribute_string('bar'), '></div>',
                    '</div>',
                '</div>';

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
