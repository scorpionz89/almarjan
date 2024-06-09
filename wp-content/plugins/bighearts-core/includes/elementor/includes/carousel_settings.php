<?php
namespace WglAddons\Includes;

defined('ABSPATH') || exit;

use Elementor\{
    Frontend,
    Controls_Manager,
    Group_Control_Box_Shadow
};
use WglAddons\{
    BigHearts_Global_Variables as BigHearts_Globals,
    Includes\Wgl_Elementor_Helper
};

if (!class_exists('Wgl_Carousel_Settings')) {
    /**
     * WGL Elementor Carousel Settings
     *
     *
     * @package bighearts-core\includes\elementor
     * @author WebGeniusLab <webgeniuslab@gmail.com>
     * @since 1.0.0
     * @version 1.0.8
     */
    class Wgl_Carousel_Settings
    {
        private static $instance;

        public static function get_instance()
        {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        public static function options($self, $array = [])
        {
            $desktop_width = get_option('elementor_container_width') ?: '1140';
            $tablet_width = get_option('elementor_viewport_lg') ?: '1025';
            $mobile_width = get_option('elementor_viewport_md') ?: '768';

            $self->start_controls_section(
                'wgl_carousel_section',
                ['label' => esc_html__('Carousel Options', 'bighearts-core')]
            );

            $self->add_control(
                'use_carousel',
                [
                    'label' => esc_html__('Use Carousel', 'bighearts-core'),
                    'type' => Controls_Manager::SWITCHER,
                ]
            );

            $self->add_control(
                'autoplay',
                [
                    'label' => esc_html__('Autoplay', 'bighearts-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'condition' => ['use_carousel' => 'yes'],
                    'label_on' => esc_html__('On', 'bighearts-core'),
                    'label_off' => esc_html__('Off', 'bighearts-core'),
                ]
            );

            $self->add_control(
                'autoplay_speed',
                [
                    'label' => esc_html__('Autoplay Speed', 'bighearts-core'),
                    'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                    'condition' => ['autoplay' => 'yes'],
                    'min' => 1,
                    'step' => 1,
                    'default' => '3000',
                ]
            );

            $self->add_control(
                'fade_animation',
                [
                    'label' => esc_html__('Fade Animation', 'bighearts-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'condition' => [
                        'use_carousel' => 'yes',
                        'posts_per_line' => '1',
                    ],
                    'label_on' => esc_html__('On', 'bighearts-core'),
                    'label_off' => esc_html__('Off', 'bighearts-core'),
                ]
            );

            $self->add_control(
                'slides_to_scroll',
                [
                    'label' => esc_html__('Slide per single item', 'bighearts-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'condition' => ['use_carousel' => 'yes'],
                    'label_on' => esc_html__('On', 'bighearts-core'),
                    'label_off' => esc_html__('Off', 'bighearts-core'),
                ]
            );

            $self->add_control(
                'infinite',
                [
                    'label' => esc_html__('Infinite Loop Sliding', 'bighearts-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'condition' => ['use_carousel' => 'yes'],
                    'label_on' => esc_html__('On', 'bighearts-core'),
                    'label_off' => esc_html__('Off', 'bighearts-core'),
                ]
            );

            $self->add_control(
                'center_mode',
                [
                    'label' => esc_html__('Center Mode', 'bighearts-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'condition' => ['use_carousel' => 'yes'],
                    'label_on' => esc_html__('On', 'bighearts-core'),
                    'label_off' => esc_html__('Off', 'bighearts-core'),
                ]
            );

            $self->add_control(
                'pagination_divider',
                [
                    'type' => Controls_Manager::DIVIDER,
                    'condition' => ['use_pagination!' => ''],
                ]
            );

            $self->add_control(
                'use_pagination',
                [
                    'label' => esc_html__('Add Pagination control', 'bighearts-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'condition' => ['use_carousel' => 'yes'],
                    'label_on' => esc_html__('On', 'bighearts-core'),
                    'label_off' => esc_html__('Off', 'bighearts-core'),
                ]
            );

            $self->add_control(
                'pag_type',
                [
                    'label' => esc_html__('Pagination Type', 'bighearts-core'),
                    'type' => 'wgl-radio-image',
                    'condition' => [
                        'use_pagination' => 'yes',
                        'use_carousel' => 'yes',
                    ],
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
                            'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_elementor_addon/icons/pag_line_circle.png',
                        ],
                    ],
                    'default' => 'line_circle',
                ]
            );

            $self->add_control(
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

            $self->add_control(
                'pag_offset',
                [
                    'label' => esc_html__('Pagination Top Offset', 'bighearts-core'),
                    'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                    'condition' => ['use_pagination' => 'yes'],
                    'min' => -500,
                    'step' => 1,
                    'default' => 10,
                    'selectors' => [
                        '{{WRAPPER}} .wgl-carousel .slick-dots' => 'margin-top: {{VALUE}}px;',
                    ],
                ]
            );

            $self->add_control(
                'custom_pag_color',
                [
                    'label' => esc_html__('Custom Pagination Color', 'bighearts-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'condition' => ['use_pagination' => 'yes'],
                    'label_on' => esc_html__('On', 'bighearts-core'),
                    'label_off' => esc_html__('Off', 'bighearts-core'),
                ]
            );

            $self->add_control(
                'pag_color',
                [
                    'label' => esc_html__('Color', 'bighearts-core'),
                    'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
			        'dynamic' => [  'active' => true],
                    'condition' => ['custom_pag_color' => 'yes'],
                    'selectors' => [
                        '{{WRAPPER}} .pagination_circle .slick-dots li button,
                        {{WRAPPER}} .pagination_line .slick-dots li button:before,
                        {{WRAPPER}} .pagination_line_circle .slick-dots li button,
                        {{WRAPPER}} .pagination_square .slick-dots li button,
                        {{WRAPPER}} .pagination_square_border .slick-dots li button:before,
                        {{WRAPPER}} .pagination_circle_border .slick-dots li button:before ' => 'background: {{VALUE}} !important;',

                        '{{WRAPPER}} .pagination_circle_border .slick-dots li.slick-active button,
                        {{WRAPPER}} .pagination_square_border .slick-dots li.slick-active button' => 'border-color: {{VALUE}} !important;'
                    ],
                    'global' => [],
                ]
            );

            $self->add_control(
                'navigation_divider',
                [
                    'type' => Controls_Manager::DIVIDER,
                    'conditions' => [
                        'relation' => 'or',
                        'terms' => [[
                            'terms' => [[
                                'name' => 'use_pagination',
                                'operator' => '!=',
                                'value' => '',
                            ]]
                        ], [
                            'terms' => [[
                                'name' => 'use_prev_next',
                                'operator' => '!=',
                                'value' => '',
                            ]]
                        ],],
                    ],
                ]
            );

            $self->add_control(
                'use_prev_next',
                [
                    'label' => esc_html__('Add Prev/Next buttons', 'bighearts-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'condition' => ['use_carousel' => 'yes'],
                    'label_on' => esc_html__('On', 'bighearts-core'),
                    'label_off' => esc_html__('Off', 'bighearts-core'),
                ]
            );

            $self->add_control(
                'prev_next_position',
                [
                    'label' => esc_html__('Arrows Positioning', 'bighearts-core'),
                    'type' => Controls_Manager::SELECT,
                    'condition' => ['use_prev_next!' => ''],
                    'options' => [
                        '' => esc_html__('Opposite each other', 'bighearts-core'),
                        'right' => esc_html__('Bottom right corner', 'bighearts-core'),
                    ],
                ]
            );

            $self->add_responsive_control(
                'prev_next_offset',
                [
                    'label' => esc_html__('Arrows Vertical Offset', 'bighearts-core'),
                    'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                    'condition' => ['use_prev_next!' => ''],
                    'size_units' => ['px', '%', 'rem'],
                    'range' => [
                        'px' => ['max' => 300],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .slick-arrow' => 'top: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .prev_next_pos_right .slick-arrow' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
                    ],
                ]
            );

            $self->add_control(
                'custom_prev_next_color',
                [
                    'label' => esc_html__('Customize Prev/Next Buttons', 'bighearts-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'condition' => ['use_prev_next' => 'yes'],
                ]
            );

            $self->start_controls_tabs(
                'arrows_style',
                [
                    'condition' => [
                        'use_prev_next' => 'yes',
                        'custom_prev_next_color' => 'yes'
                    ]
                ]
            );

            $self->start_controls_tab(
                'arrows_button_normal',
                ['label' => esc_html__('Idle', 'bighearts-core')]
            );

            $self->add_control(
                'prev_next_color',
                [
                    'label' => esc_html__('Button Icon Color', 'bighearts-core'),
                    'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                    'default' => BigHearts_Globals::get_h_font_color(),
                    'global' => [],
                ]
            );

            $self->add_control(
                'prev_next_bg_idle',
                [
                    'label' => esc_html__('Button Background Color', 'bighearts-core'),
                    'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                    'default' => '#ffffff',
                    'global' => [],
                ]
            );

            $self->add_control(
                'prev_next_border_idle',
                [
                    'label' => esc_html__('Button Border Color', 'bighearts-core'),
                    'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                    'default' => BigHearts_Globals::get_btn_color_hover(),
                    'global' => [],
                ]
            );

            $self->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'prev_next_idle',
                    'selector' => '{{WRAPPER}} .slick-arrow',
                ]
            );

            $self->end_controls_tab();

            $self->start_controls_tab(
                'arrows_button_hover',
                ['label' => esc_html__('Hover', 'bighearts-core')]
            );

            $self->add_control(
                'prev_next_color_hover',
                [
                    'label' => esc_html__('Button Icon Color', 'bighearts-core'),
                    'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                    'default' => '#ffffff',
                    'global' => [],
                ]
            );

            $self->add_control(
                'prev_next_bg_hover',
                [
                    'label' => esc_html__('Button Background Color', 'bighearts-core'),
                    'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                    'default' => BigHearts_Globals::get_btn_color_idle(),
                    'global' => [],
                ]
            );

	        $self->add_control(
		        'prev_next_border_hover',
		        [
			        'label' => esc_html__('Button Border Color', 'bighearts-core'),
                    'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
			        'default' => BigHearts_Globals::get_btn_color_idle(),
                    'global' => [],
		        ]
            );

            $self->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'prev_next_hover',
                    'selector' => '{{WRAPPER}} .slick-arrow:hover',
                ]
            );

            $self->end_controls_tab();
            $self->end_controls_tabs();

            $self->add_control(
                'responsive_divider',
                [
                    'type' => Controls_Manager::DIVIDER,
                    'conditions' => [
                        'relation' => 'or',
                        'terms' => [[
                            'terms' => [[
                                'name' => 'use_prev_next',
                                'operator' => '!=',
                                'value' => '',
                            ]]
                        ], [
                            'terms' => [[
                                'name' => 'custom_resp',
                                'operator' => '!=',
                                'value' => '',
                            ]]
                        ],],
                    ],
                ]
            );

            $self->add_control(
                'custom_resp',
                [
                    'label' => esc_html__('Customize Responsive', 'bighearts-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'condition' => ['use_carousel' => 'yes'],
                    'label_on' => esc_html__('On', 'bighearts-core'),
                    'label_off' => esc_html__('Off', 'bighearts-core'),
                ]
            );

            $self->add_control(
                'heading_desktop',
                [
                    'label' => esc_html__('Desktop Settings', 'bighearts-core'),
                    'type' => Controls_Manager::HEADING,
                    'condition' => ['custom_resp' => 'yes'],
                ]
            );

            $self->add_control(
                'resp_medium',
                [
                    'label' => esc_html__('Desktop Screen Breakpoint', 'bighearts-core'),
                    'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                    'condition' => ['custom_resp' => 'yes'],
                    'min' => 500,
                    'default' => $desktop_width,
                ]
            );

            $self->add_control(
                'resp_medium_slides',
                [
                    'label' => esc_html__('Slides to show', 'bighearts-core'),
                    'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                    'condition' => ['custom_resp' => 'yes'],
                    'min' => 1,
                ]
            );

            $self->add_control(
                'heading_tablet',
                [
                    'label' => esc_html__('Tablet Settings', 'bighearts-core'),
                    'type' => Controls_Manager::HEADING,
                    'condition' => ['custom_resp' => 'yes'],
                    'separator' => 'before',
                ]
            );

            $self->add_control(
                'resp_tablets',
                [
                    'label' => esc_html__('Tablet Screen Breakpoint', 'bighearts-core'),
                    'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                    'condition' => ['custom_resp' => 'yes'],
                    'min' => 400,
                    'default' => $tablet_width,
                ]
            );

            $self->add_control(
                'resp_tablets_slides',
                [
                    'label' => esc_html__('Slides to show', 'bighearts-core'),
                    'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                    'condition' => ['custom_resp' => 'yes'],
                    'min' => 1,
                    'step' => 1,
                ]
            );

            $self->add_control(
                'heading_mobile',
                [
                    'label' => esc_html__('Mobile Settings', 'bighearts-core'),
                    'type' => Controls_Manager::HEADING,
                    'condition' => ['custom_resp' => 'yes'],
                    'separator' => 'before',
                ]
            );

            $self->add_control(
                'resp_mobile',
                [
                    'label' => esc_html__('Mobile Screen Breakpoint', 'bighearts-core'),
                    'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                    'condition' => ['custom_resp' => 'yes'],
                    'min' => 300,
                    'default' => $mobile_width,
                ]
            );

            $self->add_control(
                'resp_mobile_slides',
                [
                    'label' => esc_html__('Slides to show', 'bighearts-core'),
                    'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                    'condition' => ['custom_resp' => 'yes'],
                    'min' => 1,
                ]
            );

            $self->end_controls_section();
        }

        /**
         * @since 1.0.0
         * @version 1.0.8
         */
        public static function init($atts, $items = [], $templates = false)
        {
            wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick.min.js');

            extract(
                shortcode_atts([
                    //* General
                    'slide_to_show' => '1',
                    'speed' => '300',
                    'autoplay' => true,
                    'autoplay_speed' => '3000',
                    'slides_to_scroll' => false,
                    'infinite' => false,
                    'adaptive_height' => false,
                    'fade_animation' => false,
                    'variable_width' => false,
                    'extra_class' => '',
                    //* Navigation
                    'use_pagination' => true,
                    'use_navigation' => false,
                    'pag_type' => 'circle_border',
                    'nav_type' => 'element',
                    'pag_align' => 'center',
                    'custom_pag_color' => false,
                    'pag_color' => BigHearts_Globals::get_h_font_color(),
                    'center_mode' => false,
                    'use_prev_next' => false,
                    'prev_next_position' => '',
                    'custom_prev_next_color' => false,
                    'prev_next_color' => BigHearts_Globals::get_h_font_color(),
                    'prev_next_color_hover' => '#ffffff',
                    'prev_next_border_idle' => BigHearts_Globals::get_btn_color_hover(),
                    'prev_next_border_hover' => BigHearts_Globals::get_btn_color_idle(),
                    'prev_next_bg_idle' => '#ffffff',
                    'prev_next_bg_hover' => BigHearts_Globals::get_btn_color_idle(),
                    //* Responsive
                    'custom_resp' => false,
                    'resp_medium' => '1201',
                    'resp_medium_slides' => '',
                    'resp_tablets' => '1025',
                    'resp_tablets_slides' => '',
                    'resp_mobile' => '768',
                    'resp_mobile_slides' => '',
                ], $atts)
            );

            if ($custom_prev_next_color || $custom_pag_color) {
                $carousel_id = uniqid('bighearts_carousel_');
            }
            $carousel_id_attr = isset($carousel_id) ? ' id=' . $carousel_id : '';

            //* Custom styles
            ob_start();
                if ($custom_prev_next_color) {
                    if ($prev_next_bg_idle) {
                        echo "#$carousel_id .slick-arrow { background-color: ", esc_attr($prev_next_bg_idle), '; }';
                    }
                    if ($prev_next_bg_hover) {
                        echo "#$carousel_id .slick-arrow:hover { background-color: ", esc_attr($prev_next_bg_hover), '; }';
                    }
                    if ($prev_next_border_idle) {
                        echo "#$carousel_id .slick-arrow { border-color: ", esc_attr($prev_next_border_idle), ";}";
                    }
                    if ($prev_next_border_hover) {
                        echo "#$carousel_id .slick-arrow:hover { border-color: ", esc_attr($prev_next_border_hover), '; }';
                    }
                    if ($prev_next_color) {
                        echo "#$carousel_id .slick-arrow { color: ", esc_attr($prev_next_color), '; }';
                    }
                    if ($prev_next_color_hover) {
                        echo "#$carousel_id .slick-arrow:hover { color: ", esc_attr($prev_next_color_hover), '; }';
                    }
                    echo "#$carousel_id .slick-arrow:hover:before { opacity: 0; } ";
                }
                if ($custom_pag_color && $pag_color) {
                    echo "#$carousel_id.pagination_circle .slick-dots li button,",
                        "#$carousel_id.pagination_line .slick-dots li button:before,",
                        "#$carousel_id.pagination_line_circle .slick-dots li button,",
                        "#$carousel_id.pagination_square .slick-dots li button,",
                        "#$carousel_id.pagination_square_border .slick-dots li button:before,",
                        "#$carousel_id.pagination_circle_border .slick-dots li button:before { ",
                            'background: ', esc_attr($pag_color), ';',
                        '}',
                        "#$carousel_id.pagination_circle_border .slick-dots li.slick-active button,",
                        "#$carousel_id.pagination_square_border .slick-dots li.slick-active button { ",
                            'border-color: ', esc_attr($pag_color), ';',
                    '}';
                }
            $styles = ob_get_clean();
            Wgl_Elementor_Helper::enqueue_css($styles);

            switch ($slide_to_show) {
                case '2':
                    $responsive_medium = 2;
                    $responsive_tablets = 2;
                    $responsive_mobile = 1;
                    break;
                case '3':
                    $responsive_medium = 3;
                    $responsive_tablets = 2;
                    $responsive_mobile = 1;
                    break;
                case '4':
                case '5':
                case '6':
                    $responsive_medium = 4;
                    $responsive_tablets = 2;
                    $responsive_mobile = 1;
                    break;
                default:
                    $responsive_medium = 1;
                    $responsive_tablets = 1;
                    $responsive_mobile = 1;
                    break;
            }

            //* If custom responsive
            if ($custom_resp) {
                $responsive_medium = !empty($resp_medium_slides) ? (int) $resp_medium_slides : $responsive_medium;
                $responsive_tablets = !empty($resp_tablets_slides) ? (int) $resp_tablets_slides : $responsive_tablets;
                $responsive_mobile = !empty($resp_mobile_slides) ? (int) $resp_mobile_slides : $responsive_mobile;
            }

            if ($slides_to_scroll) {
                $responsive_sltscrl_medium = $responsive_sltscrl_tablets = $responsive_sltscrl_mobile = 1;
            } else {
                $responsive_sltscrl_medium = $responsive_medium;
                $responsive_sltscrl_tablets = $responsive_tablets;
                $responsive_sltscrl_mobile = $responsive_mobile;
            }

            $data_array = [];
            $data_array['slidesToShow'] = (int) $slide_to_show;
            $data_array['slidesToScroll'] = $slides_to_scroll ? 1 : (int) $slide_to_show;
            $data_array['infinite'] = $infinite ? true : false;
            $data_array['variableWidth'] = $variable_width ? true : false;

            $data_array['autoplay'] = $autoplay ? true : false;
            $data_array['autoplaySpeed'] = $autoplay_speed ?: '';
            $data_array['speed'] = $speed ? (int) $speed : '300';
            if ($center_mode) {
                $data_array['centerMode'] = $center_mode ? true : false;
                $data_array['centerPadding'] = '0px';
            }

            $data_array['arrows'] = $use_prev_next ? true : false;
            $data_array['dots'] = $use_pagination ? true : false;
            $data_array['adaptiveHeight'] = $adaptive_height ? true : false;

            //* Responsive settings
            $data_array['responsive'][0]['breakpoint'] = (int) $resp_medium;
            $data_array['responsive'][0]['settings']['slidesToShow'] = (int) esc_attr($responsive_medium);
            $data_array['responsive'][0]['settings']['slidesToScroll'] = (int) esc_attr($responsive_sltscrl_medium);

            $data_array['responsive'][1]['breakpoint'] = (int) $resp_tablets;
            $data_array['responsive'][1]['settings']['slidesToShow'] = (int) esc_attr($responsive_tablets);
            $data_array['responsive'][1]['settings']['slidesToScroll'] = (int) esc_attr($responsive_sltscrl_tablets);

            $data_array['responsive'][2]['breakpoint'] = (int) $resp_mobile;
            $data_array['responsive'][2]['settings']['slidesToShow'] = (int) esc_attr($responsive_mobile);
            $data_array['responsive'][2]['settings']['slidesToScroll'] = (int) esc_attr($responsive_sltscrl_mobile);

            $prev_next_position_class = $use_prev_next && !empty($prev_next_position) ? ' prev_next_pos_' . $prev_next_position : '';
            $data_attribute = " data-slick='" . json_encode($data_array, true) . "'";

            //* Classes
            $wrapper_classes = $use_pagination ? ' pagination_' . $pag_type : '';
            $wrapper_classes .= $use_navigation ? ' navigation_' . $nav_type : '';
            $wrapper_classes .= $use_pagination ? ' pag_align_' . $pag_align : '';
            $wrapper_classes .= $prev_next_position_class;
            $wrapper_classes .= $extra_class;

            $carousel_classes = $fade_animation ? ' fade_slick' : '';

            //* Render
            $output = '<div class="wgl-carousel_wrapper">';
            $output .= '<div' . $carousel_id_attr . ' class="wgl-carousel' . esc_attr($wrapper_classes) . '">';
            $output .= '<div class="wgl-carousel_slick' . $carousel_classes . '"' . $data_attribute . '>';

            if (!empty($templates)) {
                if (!empty($items)) {
                    ob_start();
                    foreach ($items as $id) if ($id) {
                        echo '<div class="item">',
                            (new Frontend)->get_builder_content_for_display($id, true),
                        '</div>';
                    }
                    $output .= ob_get_clean();
                }
            } else {
                $output .= $items;
            }

            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';

            return $output;
        }
    }

    new Wgl_Carousel_Settings();
}
