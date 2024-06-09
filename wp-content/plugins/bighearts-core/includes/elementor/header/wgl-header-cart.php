<?php
namespace WglAddons\Widgets;

defined('ABSPATH') || exit; // Abort, If called directly.

use Elementor\{
    Plugin,
    Widget_Base,
    Controls_Manager
};
use WglAddons\BigHearts_Global_Variables as BigHearts_Globals;

/**
 * Cart widget for Header CPT
 *
 *
 * @package bighearts-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 */
class Wgl_Header_Cart extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-header-cart';
    }

    public function get_title()
    {
        return esc_html__('WooCart', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-header-cart';
    }

    public function get_categories()
    {
        return ['wgl-header-modules'];
    }

    public function get_script_depends()
    {
        return [ 'wgl-elementor-extensions-widgets' ];
    }

    protected function register_controls()
    {
        /** CONTENT -> GENERAL */

        $this->start_controls_section(
            'section_search_settings',
            [ 'label' => esc_html__('General', 'bighearts-core') ]
        );

        $this->add_control(
            'cart_height',
            [
                'label' => esc_html__('Cart Icon Height', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart' => 'height: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'cart_align',
            [
                'label' => esc_html__( 'Alignment', 'bighearts-core' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'toggle' => true,
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
                'selectors' => [
                    '{{WRAPPER}} .wgl-mini-cart_wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /** STYLE -> GENERAL */

        $this->start_controls_section(
            'section_style_general',
            [
                'label' => esc_html__( 'General', 'bighearts-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('icon_style_tabs');

        $this->start_controls_tab(
            'tab_idle',
            [ 'label' => esc_html__('Idle' , 'bighearts-core') ]
        );

        $this->add_control(
            'icon_color_idle',
            [
                'label' => esc_html__('Icon Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .mini-cart .wgl-cart' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'counter_bg_idle',
            [
                'label' => esc_html__('Items Counter Background', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .woo_mini-count > span' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_hover',
            [ 'label' => esc_html__('Hover' , 'bighearts-core') ]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart:hover .wgl-cart' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'counter_bg_hover',
            [
                'label' => esc_html__('Items Counter Background', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart:hover .woo_mini-count > span' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    public function render()
    {
        if (!class_exists('\WooCommerce')) {
            return;
        }

        global $wgl_woo_cart;
        $wgl_woo_cart = true;

        echo '<div class="wgl-mini-cart_wrapper">',
            '<div class="mini-cart woocommerce">',
                $this->icon_cart(),
            '</div>',
        '</div>';
    }

    public function icon_cart()
    {
        ob_start();
        $link = function_exists('wc_get_cart_url') ? wc_get_cart_url() : \WooCommerce::instance()->cart->get_cart_url();

        $this->add_render_attribute('cart', 'class', 'wgl-cart woo_icon elementor-cart');
        $this->add_render_attribute('cart', 'role', 'button' );
        $this->add_render_attribute('cart', 'title', esc_attr__('Click to open Shopping Cart', 'bighearts-core'));

        echo '<a ', \BigHearts_Theme_Helper::render_html($this->get_render_attribute_string('cart')), '>';
            echo '<span class="woo_mini-count flaticon-basket">';
                if ((!(bool) Plugin::$instance->editor->is_edit_mode())) {
                    echo \WooCommerce::instance()->cart->cart_contents_count > 0
                        ? '<span>' . esc_html( \WooCommerce::instance()->cart->cart_contents_count ) .'</span>'
                        : '';
                }
            echo '</span>';
        echo '</a>';

        return ob_get_clean();
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