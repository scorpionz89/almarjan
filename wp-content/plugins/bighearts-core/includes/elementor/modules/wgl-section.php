<?php
namespace WglAddons\Modules;

defined('ABSPATH') || exit;

use Elementor\{
    Controls_Manager,
    Group_Control_Typography,
    Repeater,
    Plugin,
    Utils
};
use WglAddons\BigHearts_Global_Variables as BigHearts_Globals;

/**
 * Wgl Elementor Section
 *
 *
 * @package bighearts-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 */
class Wgl_Section
{
    public $sections = [];

    public function __construct()
    {
        add_action('elementor/init', [$this, 'add_hooks']);
    }

    public function add_hooks()
    {
        // Add WGL extension control section to Section panel
        add_action('elementor/element/section/section_typo/after_section_end', [$this, 'extened_animation_options'], 10, 2);

        // add_action( 'elementor/element/section/section_layout/after_section_end', [ $this, 'extends_header_params'], 10, 2 );
        add_action('elementor/element/column/layout/after_section_end', [$this, 'extends_column_params'], 10, 2);

        add_action('elementor/frontend/section/before_render', [$this, 'extened_row_render'], 10, 1);

        add_action('elementor/frontend/column/before_render', [$this, 'extened_column_render'], 10, 1);

        add_action('elementor/frontend/before_enqueue_scripts', [$this, 'enqueue_scripts']);

        add_action('elementor/element/wp-post/document_settings/after_section_end', [$this, 'header_metaboxes'], 10, 1);
    }

    function header_metaboxes($page)
    {
        if (get_post_type() !== 'header') {
            return;
        }

        $page->start_controls_section(
            'header_options',
            [
                'label' => esc_html__('WGL Header Options', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_SETTINGS
            ]
        );

        $page->add_control(
            'use_custom_logo',
            [
                'label' => esc_html__('Use Custom Mobile Logo?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $page->add_control(
            'custom_logo',
            [
                'label' => esc_html__('Custom Logo', 'bighearts-core'),
                'type' => Controls_Manager::MEDIA,
			    'dynamic' => [  'active' => true],
                'condition' => ['use_custom_logo' => 'yes'],
                'label_block' => true,
                'default' => ['url' => Utils::get_placeholder_image_src() ],
            ]
        );

        $page->add_control(
            'enable_logo_height',
            [
                'label' => esc_html__('Enable Logo Height?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['use_custom_logo' => 'yes'],
            ]
        );

        $page->add_control(
            'logo_height',
            [
                'label' => esc_html__('Logo Height', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => [
                    'use_custom_logo' => 'yes',
                    'enable_logo_height' => 'yes',
                ],
                'min' => 1,
            ]
        );

        $page->add_control(
            'hr_mobile_logo',
            ['type' => Controls_Manager::DIVIDER ]
        );

        $page->add_control(
            'use_custom_menu_logo',
            [
                'label' => esc_html__('Use Custom Mobile Menu Logo?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $page->add_control(
            'custom_menu_logo',
            [
                'label' => esc_html__('Custom Logo', 'bighearts-core'),
                'type' => Controls_Manager::MEDIA,
			    'dynamic' => [  'active' => true],
                'condition' => ['use_custom_menu_logo' => 'yes'],
                'label_block' => true,
                'default' => ['url' => Utils::get_placeholder_image_src() ],
            ]
        );

        $page->add_control(
            'enable_menu_logo_height',
            [
                'label' => esc_html__('Enable Logo Height?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['use_custom_menu_logo' => 'yes'],
            ]
        );

        $page->add_control(
            'logo_menu_height',
            [
                'label' => esc_html__('Logo Height', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => [
                    'use_custom_menu_logo' => 'yes',
                    'enable_menu_logo_height' => 'yes',
                ],
                'min' => 1,
            ]
        );

        $page->add_control(
            'hr_mobile_menu_logo',
            ['type' => Controls_Manager::DIVIDER ]
        );

        $page->add_control(
            'mobile_breakpoint',
            [
                'label' => esc_html__('Mobile Header resolution breakpoint', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'min' => 5,
                'max' => 1920,
                'default' => 1200,
            ]
        );

        $page->add_control(
            'header_on_bg',
            [
                'label' => esc_html__('Over content', 'bighearts-core'),
                'description' => esc_html__('Set Header to display over content.', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $page->end_controls_section();
    }

    public function extened_row_render(\Elementor\Element_Base $element)
    {
        if ('section' !== $element->get_name()) {
            return;
        }

        $settings = $element->get_settings();
        $data = $element->get_data();

        // Background Text Extenions
        if (!empty($settings['add_background_text'])) {
            wp_enqueue_script('jquery-appear', esc_url(get_template_directory_uri() . '/js/jquery.appear.js'));
            wp_enqueue_script('anime', esc_url(get_template_directory_uri() . '/js/anime.min.js'));
        }

        // Parallax Extenions
        if (
            isset($settings['add_background_animation'])
            && !empty($settings['add_background_animation'])
            && !(bool) Plugin::$instance->editor->is_edit_mode()
        ) {
            wp_enqueue_script('parallax', esc_url(get_template_directory_uri() . '/js/parallax.min.js'));
            wp_enqueue_script('jquery-paroller', esc_url(get_template_directory_uri() . '/js/jquery.paroller.min.js'));
            wp_enqueue_style('animate', esc_url(get_template_directory_uri() . '/css/animate.css'));
        }

        $this->sections[$data['id']] = $data['settings'];
    }

    public function extened_column_render(\Elementor\Element_Base $element)
    {
        if ('column' !== $element->get_name()) {
            return;
        }

        $settings = $element->get_settings();
        $data     = $element->get_data();

        if (isset($settings['apply_sticky_column']) && !empty($settings['apply_sticky_column'])) {

            wp_enqueue_script('theia-sticky-sidebar', get_template_directory_uri() . '/js/theia-sticky-sidebar.min.js');
        }
    }

    public function enqueue_scripts()
    {
        if (Plugin::$instance->preview->is_preview_mode()) {
            wp_enqueue_style('animate', esc_url(get_template_directory_uri() . '/css/animate.css'));

            wp_enqueue_script('parallax', esc_url(get_template_directory_uri() . '/js/parallax.min.js'));
            wp_enqueue_script('jquery-paroller', esc_url(get_template_directory_uri() . '/js/jquery.paroller.min.js'));

            wp_enqueue_script('theia-sticky-sidebar', get_template_directory_uri() . '/js/theia-sticky-sidebar.min.js');
        }

        // Add options in the section
        wp_enqueue_script('wgl-parallax', esc_url(WGL_ELEMENTOR_ADDONS_URL . 'assets/js/wgl_elementor_sections.js'), ['jquery'], false, true);

        // Add options in the column
        wp_enqueue_script('wgl-column', esc_url(WGL_ELEMENTOR_ADDONS_URL . 'assets/js/wgl_elementor_column.js'), ['jquery'], false, true);

        wp_localize_script('wgl-parallax', 'wgl_parallax_settings', [
            $this->sections,
            'svgURL' => esc_url(WGL_ELEMENTOR_ADDONS_URL . 'assets/shapes/'),
        ]);
    }

    public function extened_animation_options($widget, $args)
    {
        $widget->start_controls_section(
            'extened_animation',
            [
                'label' => esc_html__('WGL Background Text', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $widget->add_control(
            'add_background_text',
            [
                'label' => esc_html__('Add Background Text?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'add-background-text',
                'prefix_class' => 'wgl-',
            ]
        );

        $widget->add_control(
            'background_text',
            [
                'label' => esc_html__('Background Text', 'bighearts-core'),
                'type' => Controls_Manager::TEXTAREA,
			    'dynamic' => [  'active' => true],
                'condition' => ['add_background_text!' => ''],
                'label_block' => true,
                'default' => esc_html__('Text', 'bighearts-core'),
                'selectors' => [
                    '{{WRAPPER}}.wgl-add-background-text:before' => 'content: "{{VALUE}}"',
                    '{{WRAPPER}} .wgl-background-text' => 'content: "{{VALUE}}"',
                ],
            ]
        );

        $widget->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'background_text_typo',
                'condition' => ['add_background_text' => 'add-background-text'],
                'selector' => '{{WRAPPER}}.wgl-add-background-text:before, {{WRAPPER}} .wgl-background-text',
            ]
        );

        $widget->add_responsive_control(
            'background_text_indent',
            [
                'label' => esc_html__('Text Indent', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'condition' => ['add_background_text!' => ''],
                'size_units' => ['px', 'vw'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 250],
                    'vw' => ['min' => 0, 'max' => 30],
                ],
                'default' => ['size' => 8.9, 'unit' => 'vw'],
                'selectors' => [
                    '{{WRAPPER}}.wgl-add-background-text:before' => 'margin-left: calc({{SIZE}}{{UNIT}} / 2);',
                    '{{WRAPPER}} .wgl-background-text .letter:last-child' => 'margin-right: -{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_control(
            'background_text_color',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'condition' => ['add_background_text!' => ''],
                'default' => '#f1f1f1',
                'selectors' => [
                    '{{WRAPPER}}.wgl-add-background-text:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wgl-background-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'background_text_spacing',
            [
                'label' => esc_html__('Top Spacing', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'condition' => ['add_background_text!' => ''],
                'range' => [
                    'px' => ['min' => -100, 'max' => 400],
                ],
                'default' => ['size' => 0, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}}.wgl-add-background-text:before' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wgl-background-text' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_control(
            'apply_animation_background_text',
            [
                'label' => esc_html__('Apply Animation?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['add_background_text!' => ''],
                'return_value' => 'animation-background-text',
                'default' => 'animation-background-text',
                'prefix_class' => 'wgl-',
            ]
        );

        $widget->end_controls_section();

        $widget->start_controls_section(
            'extened_parallax',
            [
                'label' => esc_html__('WGL Parallax', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $widget->add_control(
            'add_background_animation',
            [
                'label' => esc_html__('Add Extended Background Animation?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'image_effect',
            [
                'label' => esc_html__('Parallax Effect', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'scroll' => esc_html__('Scroll', 'bighearts-core'),
                    'mouse' => esc_html__('Mouse', 'bighearts-core'),
                    'css_animation' => esc_html__('CSS Animation', 'bighearts-core'),
                ],
                'default' => 'scroll',
            ]
        );

        $repeater->add_responsive_control(
            'animation_name',
            [
                'label' => esc_html__('Animation', 'bighearts-core'),
                'type' => Controls_Manager::SELECT2,
                'default' => 'fadeIn',
                'options' => [
                    'bounce' => 'bounce',
                    'flash' => 'flash',
                    'pulse' => 'pulse',
                    'rubberBand' => 'rubberBand',
                    'shake' => 'shake',
                    'swing' => 'swing',
                    'tada' => 'tada',
                    'wobble' => 'wobble',
                    'jello' => 'jello',
                    'bounceIn' => 'bounceIn',
                    'bounceInDown' => 'bounceInDown',
                    'bounceInUp' => 'bounceInUp',
                    'bounceOut' => 'bounceOut',
                    'bounceOutDown' => 'bounceOutDown',
                    'bounceOutLeft' => 'bounceOutLeft',
                    'bounceOutRight' => 'bounceOutRight',
                    'bounceOutUp' => 'bounceOutUp',
                    'fadeIn' => 'fadeIn',
                    'fadeInDown' => 'fadeInDown',
                    'fadeInDownBig' => 'fadeInDownBig',
                    'fadeInLeft' => 'fadeInLeft',
                    'fadeInLeftBig' => 'fadeInLeftBig',
                    'fadeInRightBig' => 'fadeInRightBig',
                    'fadeInUp' => 'fadeInUp',
                    'fadeInUpBig' => 'fadeInUpBig',
                    'fadeOut' => 'fadeOut',
                    'fadeOutDown' => 'fadeOutDown',
                    'fadeOutDownBig' => 'fadeOutDownBig',
                    'fadeOutLeft' => 'fadeOutLeft',
                    'fadeOutLeftBig' => 'fadeOutLeftBig',
                    'fadeOutRightBig' => 'fadeOutRightBig',
                    'fadeOutUp' => 'fadeOutUp',
                    'fadeOutUpBig' => 'fadeOutUpBig',
                    'flip' => 'flip',
                    'flipInX' => 'flipInX',
                    'flipInY' => 'flipInY',
                    'flipOutX' => 'flipOutX',
                    'flipOutY' => 'flipOutY',
                    'fadeOutDown' => 'fadeOutDown',
                    'lightSpeedIn' => 'lightSpeedIn',
                    'lightSpeedOut' => 'lightSpeedOut',
                    'rotateIn' => 'rotateIn',
                    'rotateInDownLeft' => 'rotateInDownLeft',
                    'rotateInDownRight' => 'rotateInDownRight',
                    'rotateInUpLeft' => 'rotateInUpLeft',
                    'rotateInUpRight' => 'rotateInUpRight',
                    'rotateOut' => 'rotateOut',
                    'rotateOutDownLeft' => 'rotateOutDownLeft',
                    'rotateOutDownRight' => 'rotateOutDownRight',
                    'rotateOutUpLeft' => 'rotateOutUpLeft',
                    'rotateOutUpRight' => 'rotateOutUpRight',
                    'slideInUp' => 'slideInUp',
                    'slideInDown' => 'slideInDown',
                    'slideInLeft' => 'slideInLeft',
                    'slideInRight' => 'slideInRight',
                    'slideOutUp' => 'slideOutUp',
                    'slideOutDown' => 'slideOutDown',
                    'slideOutLeft' => 'slideOutLeft',
                    'slideOutRight' => 'slideOutRight',
                    'zoomIn' => 'zoomIn',
                    'zoomInDown' => 'zoomInDown',
                    'zoomInLeft' => 'zoomInLeft',
                    'zoomInRight' => 'zoomInRight',
                    'zoomInUp' => 'zoomInUp',
                    'zoomOut' => 'zoomOut',
                    'zoomOutDown' => 'zoomOutDown',
                    'zoomOutLeft' => 'zoomOutLeft',
                    'zoomOutUp' => 'zoomOutUp',
                    'hinge' => 'hinge',
                    'rollIn' => 'rollIn',
                    'rollOut' => 'rollOut'
                ],
                'condition' => [
                    'image_effect' => 'css_animation',
                ],
            ]
        );

        $repeater->add_control(
            'animation_name_iteration_count',
            [
                'label' => esc_html__('Animation Iteration Count', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['image_effect' => 'css_animation'],
                'options' => [
                    'infinite' => esc_html__('Infinite', 'bighearts-core'),
                    '1' => esc_html__('1', 'bighearts-core'),
                ],
                'default' => '1',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'animation-iteration-count: {{VALUE}};'
                ],
            ]
        );

        $repeater->add_control(
            'animation_name_speed',
            [
                'label' => esc_html__('Animation speed', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['image_effect' => 'css_animation'],
                'min' => 1,
                'step' => 100,
                'default' => '1',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'animation-duration: {{VALUE}}s;'
                ],
            ]
        );

        $repeater->add_control(
            'animation_name_direction',
            [
                'label' => esc_html__('Animation Direction', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['image_effect' => 'css_animation'],
                'options' => [
                    'normal' => esc_html__('Normal', 'bighearts-core'),
                    'reverse' => esc_html__('Reverse', 'bighearts-core'),
                    'alternate' => esc_html__('Alternate', 'bighearts-core'),
                ],
                'default' => 'normal',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'animation-direction: {{VALUE}};'
                ],
            ]
        );

        $repeater->add_control(
            'image_bg',
            [
                'label' => esc_html__('Parallax Image', 'bighearts-core'),
                'type' => Controls_Manager::MEDIA,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
                'default' => ['url' => ''],
            ]
        );

        $repeater->add_control(
            'parallax_dir',
            [
                'label' => esc_html__('Parallax Direction', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['image_effect' => 'scroll'],
                'options' => [
                    'vertical' => esc_html__('Vertical', 'bighearts-core'),
                    'horizontal' => esc_html__('Horizontal', 'bighearts-core'),
                ],
                'default' => 'vertical',
            ]
        );

        $repeater->add_control(
            'parallax_factor',
            [
                'label' => esc_html__('Parallax Factor', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'description' => esc_html__('Set elements offset and speed. It can be positive (0.3) or negative (-0.3). Less means slower.', 'bighearts-core'),
                'min' => -3,
                'max' => 3,
                'step' => 0.01,
                'default' => 0.03,
            ]
        );

        $repeater->add_responsive_control(
            'position_top',
            [
                'label' => esc_html__('Top Offset', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'description' => esc_html__('Set figure vertical offset from top border.', 'bighearts-core'),
                'size_units' => ['%', 'px'],
                'range' => [
                    '%' => ['min' => -100, 'max' => 100],
                    'px' => ['min' => -200, 'max' => 1000, 'step' => 5],
                ],
                'default' => ['size' => 0, 'unit' => '%'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'position_left',
            [
                'label' => esc_html__('Left Offset', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'description' => esc_html__('Set figure horizontal offset from left border.', 'bighearts-core'),
                'size_units' => ['%', 'px'],
                'range' => [
                    '%' => ['min' => -100, 'max' => 100],
                    'px' => ['min' => -200, 'max' => 1000, 'step' => 5],
                ],
                'default' => ['size' => 0, 'unit' => '%'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'left: {{SIZE}}{{UNIT}}',

                ],
            ]
        );

        $repeater->add_control(
            'image_index',
            [
                'label' => esc_html__('Image z-index', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'default' => -1,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'z-index: {{UNIT}};',
                ],
            ]
        );

        $repeater->add_control(
            'hide_on_mobile',
            [
                'label' => esc_html__('Hide On Mobile?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $repeater->add_control(
            'hide_mobile_resolution',
            [
                'label' => esc_html__('Screen Resolution', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => ['hide_on_mobile' => 'yes'],
                'default' => 768,
            ]
        );

        $widget->add_control(
            'items_parallax',
            [
                'label' => esc_html__('Layers', 'bighearts-core'),
                'type' => Controls_Manager::REPEATER,
                'condition' => ['add_background_animation' => 'yes'],
                'fields' => $repeater->get_controls(),
            ]
        );

        $widget->end_controls_section();

        $widget->start_controls_section(
            'extened_shape',
            [
                'label' => esc_html__('WGL Shape Divider', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $widget->start_controls_tabs('tabs_wgl_shape_dividers');

        $shapes_options = [
            '' => esc_html__('None', 'bighearts-core'),
            'torn_line' => esc_html__('Torn Line', 'bighearts-core'),
        ];

        foreach ([
            'top' => esc_html__('Top', 'bighearts-core'),
            'bottom' => esc_html__('Bottom', 'bighearts-core'),
        ] as $side => $side_label) {
            $base_control_key = "wgl_shape_divider_$side";

            $widget->start_controls_tab(
                "tab_$base_control_key",
                [
                    'label' => $side_label,
                ]
            );

            $widget->add_control(
                $base_control_key,
                [
                    'label' => esc_html__('Type', 'bighearts-core'),
                    'type' => Controls_Manager::SELECT,
                    'options' => $shapes_options,
                ]
            );

            $widget->add_control(
                $base_control_key . '_color',
                [
                    'label' => esc_html__('Color', 'bighearts-core'),
                    'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
			        'dynamic' => [  'active' => true],
                    'condition' => ["wgl_shape_divider_$side!" => ''],
                    'selectors' => [
                        "{{WRAPPER}} > .wgl-elementor-shape-$side path" => 'fill: {{VALUE}};',
                    ],
                ]
            );

            $widget->add_responsive_control(
                $base_control_key . '_height',
                [
                    'label' => esc_html__('Height', 'bighearts-core'),
                    'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                    'condition' => [ "wgl_shape_divider_$side!" => ''],
                    'range' => [
                        'px' => ['max' => 500],
                    ],
                    'selectors' => [
                        "{{WRAPPER}} > .wgl-elementor-shape-$side svg" => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $widget->add_control(
                $base_control_key . '_flip',
                [
                    'label' => __('Flip', 'bighearts-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'condition' => [ "wgl_shape_divider_$side!" => ''],
                    'selectors' => [
                        "{{WRAPPER}} > .wgl-elementor-shape-$side svg" => 'transform: translateX(-50%) rotateY(180deg)',
                    ],
                ]
            );

            $widget->add_control(
                $base_control_key . '_invert',
                [
                    'label' => __('Invert', 'bighearts-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'condition' => [ "wgl_shape_divider_$side!" => ''],
                    'selectors' => [
                        "{{WRAPPER}} > .wgl-elementor-shape-$side" => 'transform: rotate(180deg);',
                    ],
                ]
            );

            $widget->add_control(
                $base_control_key . '_above_content',
                [
                    'label' => esc_html__('Z-index', 'bighearts-core'),
                    'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                    'condition' => [ "wgl_shape_divider_$side!" => ''],
                    'default' => 0,
                    'selectors' => [
                        "{{WRAPPER}} > .wgl-elementor-shape-$side" => 'z-index: {{UNIT}}',
                    ],
                ]
            );

            $widget->end_controls_tab();
        }

        $widget->end_controls_tabs();
        $widget->end_controls_section();
    }

    public function extends_header_params($widget, $args)
    {
        $widget->start_controls_section(
            'extened_header',
            [
                'label' => esc_html__('WGL Header Layout', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_LAYOUT
            ]
        );

        $widget->add_control(
            'apply_sticky_row',
            [
                'label' => esc_html__('Apply Sticky?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'sticky-on',
                'prefix_class' => 'wgl-',
            ]
        );

        $widget->end_controls_section();
    }

    public function extends_column_params($widget, $args)
    {

        $widget->start_controls_section(
            'extened_header',
            [
                'label' => esc_html__('WGL Column Options', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_LAYOUT
            ]
        );

        $widget->add_control(
            'apply_sticky_column',
            [
                'label' => esc_html__('Enable Sticky?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
                'return_value' => 'sidebar',
                'prefix_class' => 'sticky-',
            ]
        );

        $widget->end_controls_section();
    }
}
