<?php
/**
 * Current file can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/widgets/wgl-clients.php`.
 */
namespace WglAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Control_Media,
    Group_Control_Border,
    Group_Control_Box_Shadow,
    Group_Control_Background,
    Repeater,
    Utils
};
use WglAddons\Includes\{
    Wgl_Carousel_Settings,
    Wgl_Elementor_Helper
};

/**
 * Clients Widget
 *
 *
 * @package bighearts-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 * @version 1.1.5
 */
class Wgl_Clients extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-clients';
    }

    public function get_title()
    {
        return esc_html__( 'WGL Clients', 'bighearts-core' );
    }

    public function get_icon()
    {
        return 'wgl-clients';
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
        /** CONTENT -> GENERAL */

        $this->start_controls_section(
            'section_content_general',
            [ 'label' => esc_html__('General', 'bighearts-core') ]
        );

        $this->add_control(
            'item_grid',
            [
                'label' => esc_html__('Grid Columns Amount', 'bighearts-core'),
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

        $repeater = new Repeater();

        $repeater->add_control(
            'thumbnail',
            [
                'label' => esc_html__('Thumbnail', 'bighearts-core'),
                'type' => Controls_Manager::MEDIA,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
                'default' => [ 'url' => Utils::get_placeholder_image_src() ],
            ]
        );

        $repeater->add_control(
            'hover_thumbnail',
            [
                'label' => esc_html__('Hover Thumbnail', 'bighearts-core'),
                'type' => Controls_Manager::MEDIA,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
                'description' => esc_html__('For \'Toggle Image\' animations only.', 'bighearts-core' ),
                'default' => [ 'url' => '' ],
            ]
        );

        $repeater->add_control(
            'client_link',
            [
                'label' => esc_html__('Add Link', 'bighearts-core'),
                'type' => Controls_Manager::URL,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => esc_html__('Items', 'bighearts-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '<# var titleField;
                    if ( thumbnail.alt ) { titleField = thumbnail.alt }
                    else if ( thumbnail.id ) { titleField = "' . esc_html__( 'Media #', 'pembe-core' ) . '" + thumbnail.id }
                    #>{{{ titleField }}}',
            ]
        );

        $this->add_control(
            'item_anim',
            [
                'label' => esc_html__('Thumbnail Animation', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => [
                    'none' => esc_html__('None', 'bighearts-core'),
                    'ex_images' => esc_html__('Toggle Image - Fade', 'bighearts-core'),
                    'ex_images_ver' => esc_html__('Toggle Image - Vertical', 'bighearts-core'),
                    'grayscale' => esc_html__('Grayscale', 'bighearts-core'),
                    'opacity' => esc_html__('Opacity', 'bighearts-core'),
                    'zoom' => esc_html__('Zoom', 'bighearts-core'),
                    'contrast' => esc_html__('Contrast', 'bighearts-core'),
                    'blur-1' => esc_html__('Blur 1', 'bighearts-core'),
                    'blur-2' => esc_html__('Blur 2', 'bighearts-core'),
                    'invert' => esc_html__('Invert', 'bighearts-core'),
                ],
                'default' => 'ex_images',
            ]
        );

        $this->add_control(
            'height',
            [
                'label' => esc_html__('Custom Items Height', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'condition' => [ 'item_anim' => 'ex_images_bg' ],
                'range' => [
                    'px' => [ 'min' => 50, 'max' => 300 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .clients_image' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'alignment_h',
            [
                'label' => esc_html__( 'Horizontal Alignment', 'bighearts-core' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'toggle' => true,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'bighearts-core' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'bighearts-core' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'bighearts-core' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .clients_image' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'alignment_v',
            [
                'label' => esc_html__( 'Vertical Alignment', 'bighearts-core' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'toggle' => true,
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
                    '{{WRAPPER}} .wgl-clients' => 'align-items: {{VALUE}};',
                    '{{WRAPPER}} .slick-track' => 'align-items: {{VALUE}}; display: flex;',
                ],
            ]
        );

        $this->end_controls_section();

        /** CONTENT -> CAROUSEL OPTIONS */

        Wgl_Carousel_Settings::options( $this );

        /** STYLES -> ITEMS */

        $this->start_controls_section(
            'section_style_items',
            [
                'label' => esc_html__('Items', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .clients_image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .clients_image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .clients_image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_items',
            [ 'separator' => 'before' ]
        );

        $this->start_controls_tab(
            'tab_item_idle',
            [ 'label' => esc_html__('Idle', 'bighearts-core') ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_idle',
                'selector' => '{{WRAPPER}} .clients_image',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_idle',
                'selector' => '{{WRAPPER}} .clients_image',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_item_hover',
            [ 'label' => esc_html__('Hover', 'bighearts-core') ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_hover',
                'selector' => '{{WRAPPER}} .clients_image:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_hover',
                'selector' => '{{WRAPPER}} .clients_image:hover',
            ]
        );

        $this->add_control(
            'item_transition',
            [
                'label' => esc_html__( 'Transition Duration', 'bighearts-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'size_units' => [ 's' ],
                'range' => [
                    's' => [ 'min' => 0, 'max' => 2, 'step' => 0.1 ],
                    'ms' => [ 'min' => 0, 'max' => 2000, 'step' => 100 ],
                ],
                'default' => [ 'size' => 0.4, 'unit' => 's' ],
                'selectors' => [
                    '{{WRAPPER}} .clients_image' => 'transition: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /** STYLES -> THUMBNAIL */

        $this->start_controls_section(
            'section_style_images',
            [
                'label' => esc_html__( 'Thumbnail', 'bighearts-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_images' );

        $this->start_controls_tab(
            'tab_image_idle',
            [ 'label' => esc_html__('Idle', 'bighearts-core') ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_idle',
                'selector' => '{{WRAPPER}} .image_wrapper > img',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_idle',
                'selector' => '{{WRAPPER}} .image_wrapper > img',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_image_hover',
            [ 'label' => esc_html__('Hover', 'bighearts-core') ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_hover',
                'selector' => '{{WRAPPER}} .image_wrapper:hover > img',
            ]
        );


        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_hover',
                'selector' => '{{WRAPPER}} .image_wrapper:hover > img',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

    }

    protected function render()
    {
        $content = '';
        $settings = $this->get_settings_for_display();
        extract($settings);

        if ($use_carousel) {
            $carousel_options = [
                'slide_to_show' => $item_grid,
                'autoplay' => $autoplay,
                'autoplay_speed' => $autoplay_speed,
                'fade_animation' => $fade_animation,
                'slides_to_scroll' => $slides_to_scroll,
                'infinite' => true,
                'use_pagination' => $use_pagination,
                'pag_type' => $pag_type,
                'pag_offset' => $pag_offset,
                'pag_align' => $pag_align,
                'custom_pag_color' => $custom_pag_color,
                'pag_color' => $pag_color,
                // Prev/next
                'use_prev_next' => $use_prev_next,
                'prev_next_position' => $prev_next_position,
                'custom_prev_next_color' => $custom_prev_next_color,
                'prev_next_color' => $prev_next_color,
                'prev_next_color_hover' => $prev_next_color_hover,
                'prev_next_bg_idle' => $prev_next_bg_idle,
                'prev_next_bg_hover' => $prev_next_bg_hover,
                'prev_next_border_idle' => $prev_next_border_idle,
                'prev_next_border_hover' => $prev_next_border_hover,
                // Responsive
                'custom_resp' => $custom_resp,
                'resp_medium' => $resp_medium,
                'resp_medium_slides' => $resp_medium_slides,
                'resp_tablets' => $resp_tablets,
                'resp_tablets_slides' => $resp_tablets_slides,
                'resp_mobile' => $resp_mobile,
                'resp_mobile_slides' => $resp_mobile_slides,
            ];

            wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick.min.js');

            //* ↓ Possibility to fix box-shadow issue with Elementor capabilities only
            $styles = '';
            if (isset($_margin['left'])) {
                $styles .= '.elementor-element-' . $this->get_id() .' .slick-slider .slick-list { '
                    . 'margin-left: ' . $_margin['left'] . $_margin['unit'] . ';'
                    . 'margin-right: ' . $_margin['right'] . $_margin['unit'] . ';'
                . ' } ';
            }
            if (isset($_padding['left'])) {
                $styles .= '.elementor-element-' . $this->get_id() .' .slick-slider .slick-list { '
                    . 'padding-left: ' . $_padding['left'] . $_padding['unit'] . ';'
                    . 'padding-right: ' . $_padding['right'] . $_padding['unit'] . ';'
                . ' } ';
            }
            if ($styles) Wgl_Elementor_Helper::enqueue_css($styles);
            //* ↑ fix box-shadow issue
        }

        $this->add_render_attribute(
            'clients',
            [
                'class' => [
                    'wgl-clients',
                    'clearfix',
                    'anim-' . $item_anim,
                    'items-' . $item_grid,
                ],
                'data-carousel' => $use_carousel
            ]
        );

        foreach ($settings['list'] as $index => $item) {

            if (!empty($item['client_link']['url'])) {
                $client_link = $this->get_repeater_setting_key('client_link', 'list', $index);
                $this->add_render_attribute($client_link, 'class', 'image_link image_wrapper');
                $this->add_link_attributes($client_link, $item['client_link']);
            }

            $class_image = $use_carousel ? 'carousel-img clients-img' : 'clients-img';

            $client_image = $this->get_repeater_setting_key('thumbnail', 'list', $index);
            $url_idle = $item['thumbnail']['url'] ?? false;
            $this->add_render_attribute($client_image, [
                'class' => esc_attr(apply_filters('bighearts/image/class', $class_image)) . ' main_image',
                'alt' => Control_Media::get_image_alt($item['thumbnail']),
            ]);
            if ($url_idle) $this->add_render_attribute($client_image, 'src', esc_url($url_idle));

            $client_hover_image = $this->get_repeater_setting_key('hover_thumbnail', 'list', $index);
            $url_hover = $item['hover_thumbnail']['url'] ?? false;
            $this->add_render_attribute($client_hover_image, [
                'class' => esc_attr(apply_filters('bighearts/image/class', $class_image)) . ' hover_image',
                'alt' => Control_Media::get_image_alt($item['hover_thumbnail']),
            ]);
            if ($url_hover) $this->add_render_attribute($client_hover_image, 'src', esc_url($url_hover));

            ob_start();

            echo '<div class="clients_image">';
                if (!empty($item['client_link']['url'])) {
                    echo '<a ', $this->get_render_attribute_string($client_link), '>';
                } else {
                    echo '<div class="image_wrapper">';
                }
                    if (
                        $url_hover
                        && ($item_anim == 'ex_images' || $item_anim == 'ex_images_bg' || $item_anim == 'ex_images_ver')
                    ) {
                        echo '<img ', $this->get_render_attribute_string($client_hover_image), ' />';
                    }

                    echo '<img ', $this->get_render_attribute_string($client_image), ' />';

                if (!empty($item['client_link']['url'])) {
                    echo '</a>';
                } else {
                    echo '</div>';
                }
            echo '</div>';

            $content .= ob_get_clean();
        }

        // Render
        echo '<div ', $this->get_render_attribute_string('clients'), '>';
            if ($use_carousel) {
                echo Wgl_Carousel_Settings::init($carousel_options, $content, false);
            } else {
                echo $content;
            }
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
