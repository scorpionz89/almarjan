<?php
/**
 * Current file can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/widgets/wgl-pie-chart.php`.
 */
namespace WglAddons\Widgets;

defined('ABSPATH') || exit;

use Elementor\{
	Widget_Base,
	Controls_Manager,
	Group_Control_Typography
};
use WglAddons\BigHearts_Global_Variables as BigHearts_Globals;

/**
 * Pie Chart Widget
 *
 * @since 1.0.0
 * @version 1.1.5
 */
class Wgl_Pie_Chart extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-pie-chart';
    }

    public function get_title()
    {
        return esc_html__('WGL Pie Chart', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-pie-chart';
    }

    public function get_categories()
    {
        return ['wgl-extensions'];
    }

    public function get_script_depends()
    {
        return [
            'jquery-easypiechart',
            'jquery-appear'
        ];
    }

    /**
     * @since 1.0.0
     * @version 1.0.9
     */
	protected function register_controls()
	{
		$this->start_controls_section(
			'wgl_pie_chart_section',
			['label' => esc_html__('Pie Chart Settings', 'bighearts-core')]
		);

        $this->add_control(
            'value',
            [
                'label' => esc_html__('Value', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
                'range' => [
                    '%' => ['min' => 0, 'max' => 100],
                ],
                'default' => ['size' => 75, 'unit' => '%'],
            ]
        );

		$this->add_control(
			'chart_align',
			array(
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
				'label_block' => false,
				'default' => 'left',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .wgl-pie_chart' => 'text-align: {{VALUE}};',
				],
			)
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__('Title', 'bighearts-core'),
				'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
				'label_block' => true,
				'default' => esc_html__('ANNUAL PROGRAM', 'bighearts-core'),
			]
		);

		$this->add_control(
			'description',
			[
				'label' => esc_html__('Description', 'bighearts-core'),
				'type' => Controls_Manager::TEXTAREA,
			    'dynamic' => [  'active' => true],
				'label_block' => true,
				'default' => esc_html__('Euismod quis viverra nibh craspul prelit aliquet sagittis.', 'bighearts-core'),
			]
		);

		$this->end_controls_section();

		/**
		 * STYLE -> VALUE
		 */

		$this->start_controls_section(
			'value_style_section',
			array(
				'label' => esc_html__('Value', 'bighearts-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name' => 'pie_chart_value_typo',
				'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_family' => ['default' => \Wgl_Addons_Elementor::$typography_1['font_family']],
                    'font_weight' => ['default' => \Wgl_Addons_Elementor::$typography_1['font_weight']],
                ],
				'selector' => '{{WRAPPER}} .wgl-pie_chart .percent',
			)
		);

		$this->add_control(
			'custom_value_color',
			array(
				'label' => esc_html__('Color', 'bighearts-core'),
				'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
				'default' => BigHearts_Globals::get_h_font_color(),
				'selectors' => array(
					'{{WRAPPER}} .wgl-pie_chart .percent' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * STYLE -> TITLE
		 */

		$this->start_controls_section(
			'title_section',
			array(
				'label' => esc_html__('Title', 'bighearts-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name' => 'pie_chart_title_typo',
				'selector' => '{{WRAPPER}} .wgl-pie_chart .pie_chart_title',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label' => esc_html__('Color', 'bighearts-core'),
				'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
				'default' => BigHearts_Globals::get_h_font_color(),
				'selectors' => array(
					'{{WRAPPER}} .wgl-pie_chart .pie_chart_title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__('Margin', 'bighearts-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'default' => [
					'top' => '24',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px',
					'isLinked' => false
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-pie_chart .pie_chart_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * STYLE -> DESCRIPTION
		 */

		$this->start_controls_section(
			'description_section',
			[
				'label' => esc_html__('Description', 'bighearts-core'),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['description!' => ''],
            ]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name' => 'pie_chart_desc_typo',
				'selector' => '{{WRAPPER}} .wgl-pie_chart .pie_chart_description',
			)
		);

		$this->add_control(
			'desc_color',
			array(
				'label' => esc_html__('Color', 'bighearts-core'),
				'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
				'default' => BigHearts_Globals::get_main_font_color(),
				'selectors' => array(
					'{{WRAPPER}} .wgl-pie_chart .pie_chart_description' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'desc_margin',
			[
				'label' => esc_html__('Margin', 'bighearts-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'default' => [
					'top' => '7',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px',
					'isLinked' => false
				],
				'selectors' => [
					'{{WRAPPER}} .wgl-pie_chart .pie_chart_description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * STYLE -> PIE CHART
		 */

		$this->start_controls_section(
			'bar_style_section',
			array(
				'label' => esc_html__('Pie Chart', 'bighearts-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'size_chart',
			[
				'label' => esc_html__('Size Chart', 'bighearts-core'),
				'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
				'label_block' => true,
				'range' => [
					'px' => ['min' => 1, 'max' => 500],
				],
				'default' => ['size' => 165, 'unit' => 'px'],
			]
		);

		$this->add_control(
			'track_color',
			array(
				'label' => esc_html__('Track Color', 'bighearts-core'),
				'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
				'default' => '#eaeaea',
			)
		);

		$this->add_control(
			'bar_color',
			array(
				'label' => esc_html__('Bar Color', 'bighearts-core'),
				'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
				'default' => BigHearts_Globals::get_primary_color(),
			)
		);

		$this->add_control(
			'line_width',
			[
				'label' => esc_html__('Line Width', 'bighearts-core'),
				'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
				'min' => 0,
				'step' => 1,
				'default' => 8,
			]
		);

		$this->end_controls_section();

	}

    /**
     * @since 1.0.0
     * @version 1.0.9
     */
    public function render()
    {
        $_s = $this->get_settings_for_display();
        extract($_s);

        wp_enqueue_script('jquery-easypiechart', get_template_directory_uri() . '/js/jquery.easypiechart.min.js');
        wp_enqueue_script('jquery-appear', get_template_directory_uri() . '/js/jquery.appear.js');

        $this->add_render_attribute('chart', [
            'class' => 'chart',
            'data-percent' => (int) esc_attr($value['size']),
            'data-track-color' => esc_attr($track_color),
            'data-bar-color' => esc_attr($bar_color),
            'data-line-width' => (int) esc_attr($line_width),
            'data-size' => (int) esc_attr($size_chart['size']),
        ]);

        // Render
        echo '<div class="wgl-pie_chart">';
        echo '<div class="pie-chart_wrap">';

            echo '<div ', $this->get_render_attribute_string('chart'), '>',
                '<span class="percent">0</span>',
            '</div>';

            if ($title) {
                echo '<span class="pie_chart_title">',
                    wp_kses($title, self::get_kses_allowed_html()),
                '</span>';
            }

            if ($description) {
                echo '<span class="pie_chart_description">',
                    wp_kses($description, self::get_kses_allowed_html()),
                '</span>';
            }

        echo '</div>';
        echo '</div>';
    }

    /**
     * @since 1.0.9
     */
    protected static function get_kses_allowed_html()
    {
        return [
            'a' => [
                'id' => true, 'class' => true, 'style' => true,
                'href' => true, 'title' => true,
                'rel' => true, 'target' => true,
            ],
            'br' => ['id' => true, 'class' => true, 'style' => true],
            'em' => ['id' => true, 'class' => true, 'style' => true],
            'b' => ['id' => true, 'class' => true, 'style' => true],
            'strong' => ['id' => true, 'class' => true, 'style' => true],
            'small' => ['id' => true, 'class' => true, 'style' => true],
            'sup' => ['id' => true, 'class' => true, 'style' => true],
            'sub' => ['id' => true, 'class' => true, 'style' => true],
            'span' => ['id' => true, 'class' => true, 'style' => true],
            'ul' => ['id' => true, 'class' => true, 'style' => true],
            'ol' => ['id' => true, 'class' => true, 'style' => true],
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