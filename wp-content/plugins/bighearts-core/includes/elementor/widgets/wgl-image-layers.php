<?php
/**
 * This template can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/widgets/wgl-image-layers.php`.
 */
namespace WglAddons\Widgets;

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Control_Media,
    Repeater
};

/**
 * @since 1.0.0
 * @version 1.1.2
 */
class Wgl_Image_Layers extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-image-layers';
    }

    public function get_title()
    {
        return esc_html__( 'WGL Image Layers', 'bighearts-core' );
    }

    public function get_icon()
    {
        return 'wgl-image-layers';
    }

    public function get_categories()
    {
        return [ 'wgl-extensions' ];
    }

    public function get_script_depends()
    {
        return [ 'jquery-appear' ];
    }

    /**
     * @version 1.1.2
     */
    protected function register_controls()
    {
        /** CONTENT -> GENERAL */

        $this->start_controls_section(
            'content_general',
            [ 'label' => esc_html__( 'General', 'bighearts-core' ) ]
        );

        $this->add_control(
            'interval',
            [
                'label' => esc_html__( 'Images Appearing Interval (ms)', 'bighearts-core' ),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'min' => 0,
				'step' => 50,
				'default' => 600,
            ]
        );

        $this->add_control(
            'transition',
            [
                'label' => esc_html__( 'Transition Duration (ms)', 'bighearts-core' ),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'min' => 0,
				'step' => 50,
				'default' => 800,
                'selectors' => [
                    '{{WRAPPER}} .img-layer_image' => 'transition: {{VALUE}}ms;',
                ],
            ]
        );

        $this->add_control(
            'image_link',
            [
                'label' => esc_html__( 'Add Widget Link', 'bighearts-core' ),
                'type' => Controls_Manager::URL,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        /** CONTENT -> CONTENT */

        $this->start_controls_section(
            'content_content',
            [ 'label' => esc_html__( 'Content', 'bighearts-core' ) ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'thumbnail',
            [
                'label' => esc_html__( 'Image', 'bighearts-core' ),
                'type' => Controls_Manager::MEDIA,
			    'dynamic' => [  'active' => true],
                'default' => [ 'url' => '' ],
                'label_block' => true,
            ]
        );

        $repeater->add_responsive_control(
            'top_offset',
            [
                'label' => esc_html__( 'Top Offset', 'bighearts-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [ 'min' => -400, 'max' => 400 ],
                    '%' => [ 'min' => -100 ],
                ],
                'default' => [ 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'left_offset',
            [
                'label' => esc_html__( 'Left Offset', 'bighearts-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [ 'min' => -400, 'max' => 400 ],
                    '%' => [ 'min' => -100 ],
                ],
                'default' => [ 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater->add_control(
            'image_animation',
            [
                'label' => esc_html__( 'Layer Animation', 'bighearts-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'fade_in' => esc_html__( 'Fade In', 'bighearts-core' ),
                    'slide_up' => esc_html__( 'Slide Up', 'bighearts-core' ),
                    'slide_down' => esc_html__( 'Slide Down', 'bighearts-core' ),
                    'slide_left' => esc_html__( 'Slide Left', 'bighearts-core' ),
                    'slide_right' => esc_html__( 'Slide Right', 'bighearts-core' ),
                    'slide_big_up' => esc_html__( 'Slide Big Up', 'bighearts-core' ),
                    'slide_big_down' => esc_html__( 'Slide Big Down', 'bighearts-core' ),
                    'slide_big_left' => esc_html__( 'Slide Big Left', 'bighearts-core' ),
                    'slide_big_right' => esc_html__( 'Slide Big Right', 'bighearts-core' ),
                    'flip_x' => esc_html__( 'Flip Horizontally', 'bighearts-core' ),
                    'flip_y' => esc_html__( 'Flip Vertically', 'bighearts-core' ),
                    'zoom_in' => esc_html__( 'Zoom In', 'bighearts-core' ),
                ],
                'default' => 'fade_in',
            ]
        );

        $repeater->add_control(
            'image_order',
            [
                'label' => esc_html__( 'Image z-index', 'bighearts-core' ),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
				'step' => 1,
                'default' => 1,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'z-index: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => esc_html__( 'Layers', 'bighearts-core' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->end_controls_section();
    }

    /**
     * @version 1.1.2
     */
    protected function render()
    {
        $content = '';
        $animation_delay = 0;

        $has_link = $this->get_settings_for_display( 'image_link' )[ 'url' ] ?? '';

        if ( $has_link ) {
            $this->add_render_attribute( 'image_link', 'class', 'image_link' );
            $this->add_link_attributes( 'image_link', $this->get_settings_for_display( 'image_link' ) );
        }

        foreach ( $this->get_settings_for_display( 'items' ) as $index => $item ) {
            if ( empty( $item[ 'thumbnail' ][ 'url' ] ) ) {
                continue;
            }

            $image_layer = $this->get_repeater_setting_key( 'image_layer', 'items' , $index );
            $this->add_render_attribute( $image_layer, [
                'src' => esc_url( $item[ 'thumbnail' ][ 'url' ] ),
                'alt' => Control_Media::get_image_alt( $item[ 'thumbnail' ] ),
                'title' => Control_Media::get_image_title( $item[ 'thumbnail' ] ),
            ] );

            $image_wrapper = $this->get_repeater_setting_key( 'image_wrapper', 'items' , $index );
            $this->add_render_attribute( $image_wrapper, [
                'class' => [
                    'img-layer_image-wrapper',
                    esc_attr( $item[ 'image_animation' ] ),
                    'elementor-repeater-item-' . $item[ '_id' ]
                ],
            ] );

            $animation_delay = $animation_delay + $this->get_settings_for_display( 'interval' );
            $transition_delay = 'transition-delay: ' . $animation_delay . 'ms;';

            $layer_image = $this->get_repeater_setting_key( 'layer_image', 'items' , $index );
            $this->add_render_attribute( $layer_image, [
                'class' => 'img-layer_image',
                'style' => $transition_delay,
            ] );

            $content .= '<div ' . $this->get_render_attribute_string( $image_wrapper ) . '>'
                . '<div class="img-layer_item">'
                    . '<div ' . $this->get_render_attribute_string( $layer_image ) . '>'
                        . '<img ' . $this->get_render_attribute_string( $image_layer ) . '>'
                    . '</div>'
                . '</div>'
            . '</div>';
        }

        echo '<div class="wgl-image-layers">',
            ( $has_link ? '<a ' . $this->get_render_attribute_string( 'image_link' ) . '>' : '' ),
                $content,
            ( $has_link ? '</a>' : '' ),
        '</div>';
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
