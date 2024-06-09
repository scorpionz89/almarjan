<?php
/**
 * Current file can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/widgets/wgl-circuit-service.php`.
 */
namespace WglAddons\Widgets;

defined( 'ABSPATH' ) || exit;

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Control_Media,
    Group_Control_Box_Shadow,
    Group_Control_Typography,
    Group_Control_Image_Size,
    Repeater,
    Utils,
    Icons_Manager
};
use WglAddons\{
    BigHearts_Global_Variables as BigHearts_Globals,
    Includes\Wgl_Icons
};

/**
 * Circuit Service Widget
 *
 *
 * @package bighearts-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 * @version 1.1.5
 */
class Wgl_Circuit_Service extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-circuit-service';
    }

    public function get_title()
    {
        return esc_html__('WGL Circuit Service', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-circuit-service';
    }

    public function get_categories()
    {
        return ['wgl-extensions'];
    }

    protected function register_controls()
    {
        /** CONTENT -> GENERAL */

        $this->start_controls_section(
            'wgl_ib_content',
            [ 'label' => esc_html__( 'General', 'bighearts-core' ) ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'service_icon_type',
            [
                'label' => esc_html__( 'Add Icon/Image', 'bighearts-core' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    '' => [
                        'title' => esc_html__( 'None', 'bighearts-core' ),
                        'icon' => 'fa fa-ban',
                    ],
                    'font' => [
                        'title' => esc_html__( 'Icon', 'bighearts-core' ),
                        'icon' => 'far fa-smile',
                    ],
                    'image' => [
                        'title' => esc_html__( 'Image', 'bighearts-core' ),
                        'icon' => 'fa fa-image',
                    ]
                ],
                'default' => '',
            ]
        );

        $repeater->add_control(
            'service_icon_fontawesome',
            [
                'label' => esc_html__( 'Icon', 'bighearts-core' ),
                'type' => Controls_Manager::ICONS,
                'condition' => [ 'service_icon_type' => 'font' ],
                'label_block' => true,
                'description' => esc_html__( 'Select icon from available libraries.', 'bighearts-core' ),
            ]
        );

        $repeater->add_control(
            'service_icon_thumbnail',
            [
                'label' => esc_html__('Image', 'bighearts-core'),
                'type' => Controls_Manager::MEDIA,
			    'dynamic' => [  'active' => true],
                'condition' => [
                    'service_icon_type' => 'image',
                ],
                'label_block' => true,
                'default' => [ 'url' => Utils::get_placeholder_image_src() ],
            ]
        );

        $repeater->add_control(
            'service_title',
            [
                'label' => esc_html__('Service Title', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'service_text',
            [
                'label' => esc_html__('Service Text', 'bighearts-core'),
                'type' => Controls_Manager::TEXTAREA,
			    'dynamic' => [  'active' => true],
            ]
        );

        $repeater->add_control(
            'service_link',
            [
                'label' => esc_html__('Add Link', 'bighearts-core'),
                'type' => Controls_Manager::URL,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => esc_html__('Service', 'bighearts-core'),
                'type' => Controls_Manager::REPEATER,
                'render_type' => 'template',
                'fields' => $repeater->get_controls(),
                'title_field' => '{{service_title}}',
                'default' => [
                    [ 'service_title' => esc_html__('Title 1', 'bighearts-core')],
                    [ 'service_title' => esc_html__('Title 2', 'bighearts-core')],
                    [ 'service_title' => esc_html__('Title 3', 'bighearts-core')],
                ],
            ]
        );

        $this->end_controls_section();

        /** STYLE -> ITEM */

        $this->start_controls_section(
            'section_style_item',
            [
                'label' => esc_html__('Item', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'item_space',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => 24,
                    'right' => 24,
                    'bottom' => 24,
                    'left' => 24,
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_content-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'label' => esc_html__('Title Offset', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_title',
                'selector' => '{{WRAPPER}} .wgl-services_title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /** STYLE -> CONTENT */

        $this->start_controls_section(
            'content_style_section',
            [
                'label' => esc_html__('Content', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_tag',
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

        $this->add_responsive_control(
            'content_offset',
            [
                'label' => esc_html__('Content Offset', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_content',
                'selector' => '{{WRAPPER}} .wgl-services_text',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_family' => ['default' => \Wgl_Addons_Elementor::$typography_3['font_family']],
                    'font_weight' => ['default' => \Wgl_Addons_Elementor::$typography_3['font_weight']],
                ],
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_main_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /** STYLE -> ICON */

        $this->start_controls_section(
            'icon_style_section',
            [
                'label' => esc_html__('Icon', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_icon_style' );

        $this->start_controls_tab(
            'tab_icon_idle',
            [ 'label' => esc_html__('Idle', 'bighearts-core') ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Color', 'bighearts-core' ),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wgl-services_icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_bg_color',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_icon-wrap' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_box_shadow_idle',
                'selector' => '{{WRAPPER}} .wgl-services_item .wgl-services_icon-wrap',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            [ 'label' => esc_html__('Hover', 'bighearts-core') ]
        );
        $this->add_control(
            'icon_color_hover',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_item.active .wgl-services_icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wgl-services_item.active .wgl-services_icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_item.active .wgl-services_icon-wrap' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_box_shadow_hover',
                'selector' => '{{WRAPPER}} .wgl-services_item.active .wgl-services_icon-wrap',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'bighearts-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'range' => [
                    'px' => [ 'min' => 10, 'max' => 100 ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'desktop_default' => [ 'size' => 38 ],
                'tablet_default' => [ 'size' => 20 ],
                'mobile_default' => [ 'size' => 20 ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_bg_h',
            [
                'label' => esc_html__( 'Icon Background Size', 'bighearts-core' ),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'render_type' => 'template',
                'range' => [
                    'px' => [ 'min' => 20, 'max' => 200 ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'desktop_default' => [ 'size' => 90 ],
                'tablet_default' => [ 'size' => 60 ],
                'mobile_default' => [ 'size' => 40 ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-services_icon-wrap' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wgl-circuit-service:before' => 'left: calc({{SIZE}}{{UNIT}} / 2); top: calc({{SIZE}}{{UNIT}} / 2); width: calc(100% - {{SIZE}}{{UNIT}}); height: calc(100% - {{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function render()
    {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'services', 'class', 'wgl-circuit-service' );

        echo '<div ', $this->get_render_attribute_string( 'services' ), '>';

            foreach ( $settings[ 'items' ] as $index => $item ) {

                if ( ! empty( $item[ 'service_link' ][ 'url' ] ) ) {
                    $service_link = $this->get_repeater_setting_key( 'service_link', 'items', $index );
                    $this->add_render_attribute( $service_link, 'class', 'wgl-services_link' );
                    $this->add_link_attributes( $service_link, $item[ 'service_link' ] );
                }

                echo '<div class="wgl-services_item">';

                    // Icon/Image service
                    if ( $item[ 'service_icon_type' ] != '' ) {

                        echo '<div class="wgl-services_icon-wrap">';

                        if (
                            'font' === $item[ 'service_icon_type' ]
                            && ! empty( $item[ 'service_icon_fontawesome' ] )
                        ) {
                            $icon_font = $item[ 'service_icon_fontawesome' ];
                            $icon_out = '';
                            // add icon migration
                            $migrated = isset( $item[ '__fa4_migrated' ][ $item[ 'service_icon_fontawesome' ] ] );
                            $is_new = Icons_Manager::is_migration_allowed();
                            if ( $is_new || $migrated ) {
                                ob_start();
                                Icons_Manager::render_icon( $item[ 'service_icon_fontawesome' ], [ 'aria-hidden' => 'true' ] );
                                $icon_out .= ob_get_clean();
                            } else {
                                $icon_out .= '<i class="icon ' . esc_attr( $icon_font ) . '"></i>';
                            }

                            echo '<span class="wgl-services_icon">',
                                $icon_out,
                            '</span>';
                        }

                        if (
                            'image' === $item[ 'service_icon_type' ]
                            && ! empty( $item[ 'service_icon_thumbnail' ] )
                        ) {
                            if ( ! empty( $item[ 'service_icon_thumbnail' ][ 'url' ] ) ) {
                                $this->add_render_attribute( 'thumbnail', 'src', $item[ 'service_icon_thumbnail' ][ 'url' ] );
                                $this->add_render_attribute( 'thumbnail', 'alt', Control_Media::get_image_alt( $item[ 'service_icon_thumbnail' ] ) );
                                $this->add_render_attribute( 'thumbnail', 'title', Control_Media::get_image_title( $item[ 'service_icon_thumbnail' ] ) );
                                ?>
                                <span class="wgl-services_icon wgl-services_icon-image">
                                <?php
                                    echo Group_Control_Image_Size::get_attachment_image_html( $item, 'thumbnail', 'service_icon_thumbnail' );
                                ?>
                                </span>
                                <?php
                            }
                        }

                        echo '</div>';
                    }

                    echo '<div class="wgl-services_content-wrap">';

                    if ( ! empty( $item[ 'service_title' ] ) ) { ?>
                        <<?php echo $settings[ 'title_tag' ]; ?> class="wgl-services_title"><?php
                            echo wp_kses( $item[ 'service_title' ], self::get_kses_allowed_html() );
                        ?></<?php echo $settings[ 'title_tag' ]; ?>><?php
                    }

                    if ( ! empty( $item[ 'service_text' ] ) ) { ?>
                        <<?php echo $settings[ 'content_tag' ]; ?> class="wgl-services_text"><?php
                            echo wp_kses( $item[ 'service_text' ], self::get_kses_allowed_html() );
                        ?></<?php echo $settings[ 'content_tag' ]; ?>><?php
                    }

                    if ( ! empty( $item[ 'service_link' ][ 'url' ] ) ) {
                        echo '<a ', $this->get_render_attribute_string( $service_link ), '></a>';
                    }

                    echo '</div>';
                echo '</div>';
            }

        echo '</div>';
    }

    /**
     * @since 1.1.5
     */
    protected static function get_kses_allowed_html()
    {
        $allowed_attributes = [
            'id' => true,
            'class' => true,
            'style' => true,
        ];

        return [
            'a' => $allowed_attributes + [
                'href' => true,
                'title' => true,
                'rel' => true,
                'target' => true,
            ],
            'br' => $allowed_attributes,
            'wbr' => $allowed_attributes,
            'b' => $allowed_attributes,
            'strong' => $allowed_attributes,
            'em' => $allowed_attributes,
            'i' => $allowed_attributes,
            'small' => $allowed_attributes,
            'sup' => $allowed_attributes,
            'sub' => $allowed_attributes,
            'span' => $allowed_attributes,
            'p' => $allowed_attributes,
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
