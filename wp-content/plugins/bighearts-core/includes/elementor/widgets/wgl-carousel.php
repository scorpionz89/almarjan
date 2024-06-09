<?php
/**
 * Current file can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/widgets/wgl-carousel.php`.
 */
namespace WglAddons\Widgets;

defined( 'ABSPATH' ) || exit;

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Repeater
};
use WglAddons\{
    BigHearts_Global_Variables as BigHearts_Globals,
    Includes\Wgl_Carousel_Settings,
    Includes\Wgl_Elementor_Helper
};

/**
 * Carousel Widget
 *
 *
 * @package bighearts-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 * @version 1.1.5
 */
class Wgl_Carousel extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-carousel';
    }

    public function get_title()
    {
        return esc_html__('WGL Carousel', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-carousel';
    }

    /**
     * @version 1.1.5
     */
    public function get_keywords()
    {
        return [ 'carousel', 'slider', 'slick' ];
    }

    public function get_script_depends()
    {
        return [ 'slick' ];
    }

    public function get_categories()
    {
        return [ 'wgl-extensions' ];
    }

    protected function register_controls()
    {
        /** CONTENT -> CONTENT */

        $this->start_controls_section(
            'wgl_carousel_section',
            [ 'label' => esc_html__( 'Content' , 'bighearts-core' ) ]
        );

        $self = new REPEATER();

        $self->add_control(
            'content',
            [
                'label' => esc_html__('Content', 'bighearts-core'),
                'type' => Controls_Manager::SELECT2,
                'options' => Wgl_Elementor_Helper::get_instance()->get_elementor_templates(),
            ]
        );

        $this->add_control(
            'content_repeater',
            [
                'label' => esc_html__('Templates', 'bighearts-core'),
                'type' => Controls_Manager::REPEATER,
                'description' => esc_html__('Slider content is a template which you can choose from Elementor library. Each template will be a slider content', 'bighearts-core'),
                'fields' => $self->get_controls(),
                'title_field' => esc_html__('Template:', 'bighearts-core') . ' {{{ content }}}'
            ]
        );


        $this->add_control(
            'slide_to_show',
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
                'default' => '1',
            ]
        );

        $this->add_control(
            'speed',
            [
                'label' => esc_html__('Animation Speed', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'min' => 1,
                'default' => '3000',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => esc_html__('Autoplay Speed', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['autoplay' => 'yes'],
                'min' => 1,
                'default' => '3000',
            ]
        );

        $this->add_control(
            'slides_to_scroll',
            [
                'label' => esc_html__('Slide One Item per time', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'infinite',
            [
                'label' => esc_html__('Infinite loop sliding', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'adaptive_height',
            [
                'label' => esc_html__('Adaptive Height', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'fade_animation',
            [
                'label' => esc_html__('Fade Animation', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['slide_to_show' => '1'],
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'navigation_section',
            ['label' => esc_html__('Navigation', 'bighearts-core')]
        );

        $this->add_control(
            'h_pag_controls',
            [
                'label' => esc_html__('Pagination Controls', 'bighearts-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'use_pagination',
            [
                'label' => esc_html__('Add Pagination control', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'pag_type',
            [
                'label' => esc_html__('Pagination Type', 'bighearts-core'),
                'type' => 'wgl-radio-image',
                'condition' => ['use_pagination' => 'yes'],
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
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/pag_circle.png',
                    ],
                ],
                'default' => 'line_circle',
            ]
        );

        $this->add_control(
            'pag_align',
            [
                'label' => esc_html__('Pagination Aligning', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['use_pagination' => 'yes'],
                'options' => [
                    'left' => esc_html__('Left', 'bighearts-core'),
                    'right' => esc_html__('Right', 'bighearts-core'),
                    'center' => esc_html__('Center', 'bighearts-core'),
                ],
                'default' => 'center',
            ]
        );

        $this->add_control(
            'pag_offset',
            [
                'label' => esc_html__('Pagination Top Offset', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'condition' => ['use_pagination' => 'yes'],
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1000, 'step' => 5],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-carousel .slick-dots' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]

        );

        $this->add_control(
            'custom_pag_color',
            [
                'label' => esc_html__('Custom Pagination Color', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['use_pagination' => 'yes'],
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'pag_color',
            [
                'label' => esc_html__('Pagination Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'condition' => ['custom_pag_color' => 'yes'],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .pagination_circle .slick-dots li button,
                    {{WRAPPER}} .pagination_line .slick-dots li button:before,
                    {{WRAPPER}} .pagination_line_circle .slick-dots li button,
                    {{WRAPPER}} .pagination_square .slick-dots li button,
                    {{WRAPPER}} .pagination_square_border .slick-dots li button:before,
                    {{WRAPPER}} .pagination_circle_border .slick-dots li button:before ' => 'background: {{VALUE}}',

                    '{{WRAPPER}} .pagination_circle_border .slick-dots li.slick-active button,
                    {{WRAPPER}} .pagination_square_border .slick-dots li.slick-active button' => 'border-color: {{VALUE}}'
                ],
                'global' => [],
            ]
        );

        $this->add_control(
            'hr_prev_next',
            ['type' => Controls_Manager::DIVIDER]
        );

        $this->add_control(
            'divider_4',
            [
                'label' => esc_html__('Prev/Next Buttons', 'bighearts-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'use_prev_next',
            [
                'label' => esc_html__('Add Prev/Next buttons', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $this->add_control(
            'custom_prev_next_offset',
            [
                'label' => esc_html__('Custom offset', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['use_prev_next!' => ''],
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'prev_next_offset',
            [
                'label' => esc_html__('Buttons Top Offset', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'condition' => ['use_prev_next!' => ''],
                'size_units' => ['%'],
                'range' => [
                    '%' => ['min' => 0, 'max' => 1000],
                ],
                'default' => ['size' => 50, 'unit' => '%'],
                'selectors' => [
                    '{{WRAPPER}} .wgl-carousel .slick-next,
                     {{WRAPPER}} .wgl-carousel .slick-prev' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'custom_prev_next_color',
            [
                'label' => esc_html__('Customize Colors', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['use_prev_next!' => ''],
            ]
        );

        $this->add_control(
            'prev_next_color',
            [
                'label' => esc_html__('Prev/Next Buttons Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'condition' => ['custom_prev_next_color' => 'yes'],
                'default' => BigHearts_Globals::get_primary_color(),
                'global' => [],
            ]
        );

        $this->add_control(
            'prev_next_bg_idle',
            [
                'label' => esc_html__('Buttons Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'condition' => ['custom_prev_next_color' => 'yes'],
                'default' => '#ffffff',
                'global' => [],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'responsive_section',
            ['label' => esc_html__('Responsive', 'bighearts-core')]
        );

        $this->add_control(
            'custom_resp',
            [
                'label' => esc_html__('Customize Responsive', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'heading_desktop',
            [
                'label' => esc_html__('Desktop Settings', 'bighearts-core'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['custom_resp' => 'yes'],
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'resp_medium',
            [
                'label' => esc_html__('Desktop Screen Breakpoint', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['custom_resp' => 'yes'],
                'min' => 500,
                'default' => '1025',
            ]
        );

        $this->add_control(
            'resp_medium_slides',
            [
                'label' => esc_html__('Slides to show', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['custom_resp' => 'yes'],
                'min' => 1,
            ]
        );

        $this->add_control(
            'heading_tablet',
            [
                'label' => esc_html__('Tablet Settings', 'bighearts-core'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['custom_resp' => 'yes'],
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'resp_tablets',
            [
                'label' => esc_html__('Tablet Screen Breakpoint', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['custom_resp' => 'yes'],
                'min' => 400,
                'default' => '993',
            ]
        );

        $this->add_control(
            'resp_tablets_slides',
            [
                'label' => esc_html__('Slides to show', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['custom_resp' => 'yes'],
                'min' => 1,
            ]
        );

        $this->add_control(
            'heading_mobile',
            [
                'label' => esc_html__('Mobile Settings', 'bighearts-core'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['custom_resp' => 'yes'],
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'resp_mobile',
            [
                'label' => esc_html__('Mobile Screen Breakpoint', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['custom_resp' => 'yes'],
                'min' => 1,
                'default' => '601',
            ]
        );

        $this->add_control(
            'resp_mobile_slides',
            [
                'label' => esc_html__('Slides to show', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['custom_resp' => 'yes'],
                'min' => 1,
            ]
        );

        $this->end_controls_section();
    }

    /**
     * @version 1.1.5
     */
    protected function render()
    {
        $content = [];
        foreach ( $this->get_settings_for_display( 'content_repeater' ) as $template ) {
            array_push( $content, $template[ 'content' ] );
        }

        echo Wgl_Carousel_Settings::init( $this->get_settings_for_display(), $content, true );
    }
}
