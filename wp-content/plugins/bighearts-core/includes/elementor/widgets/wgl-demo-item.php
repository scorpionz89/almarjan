<?php
/**
 * Current file can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/widgets/wgl-demo-item.php`.
 */
namespace WglAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Control_Media,
    Group_Control_Box_Shadow,
    Group_Control_Typography,
    Utils
};
use WglAddons\BigHearts_Global_Variables as BigHearts_Globals;

/**
 * @since 1.0.0
 * @version 1.1.5
 */
class Wgl_Demo_Item extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-demo-item';
    }

    public function get_title()
    {
        return esc_html__('WGL Demo Item', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-demo-item';
    }

    public function get_categories()
    {
        return [ 'wgl-extensions' ];
    }

    protected function register_controls()
    {
        /*-----------------------------------------------------------------------------------*/
        /*  Content
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'wgl_demo_item_section',
            ['label' => esc_html__('Demo Item Settings', 'bighearts-core')]
        );

        $this->add_control(
            'demo_title',
            [
                'label' => esc_html__('Title', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
                'default' => esc_html__('This is the heading​', 'bighearts-core'),
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

        $this->add_control(
            'thumbnail',
            [
                'label' => esc_html__('Image', 'bighearts-core'),
                'type' => Controls_Manager::MEDIA,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'coming_soon',
            [
                'label' => esc_html__('Coming Soon', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'add_button',
            [
                'label' => esc_html__('Add Button', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['coming_soon' => ''],
                'label_on' => esc_html__('On', 'bighearts-core'),
                'label_off' => esc_html__('Off', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'button_title',
            [
                'label' => esc_html__('Button Title', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'condition' => [
                    'add_button' => 'yes',
                    'coming_soon' => '',
                ],
                'label_block' => true,
                'default' => esc_html__('View Demo', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'demo_link',
            [
                'label' => esc_html__('Demo Link', 'bighearts-core'),
                'type' => Controls_Manager::URL,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
                'condition' => [
                    'add_button' => 'yes',
                    'coming_soon' => '',
                ]
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  Carousel styles
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__('Demo Item Styles', 'bighearts-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label' => esc_html__('Image Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .demo-item_image, {{WRAPPER}} .demo-item_image-link:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_box_shadow',
				'selector' => '{{WRAPPER}} .demo-item_image',
			]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_title',
                'selector' => '{{WRAPPER}} .demo-item_title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Title Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 30,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .demo-item_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'title_color_tab' );

        $this->start_controls_tab(
            'custom_title_color_idle',
            [ 'label' => esc_html__('Idle' , 'bighearts-core') ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .demo-item_title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_title_color_hover',
            [ 'label' => esc_html__('Hover' , 'bighearts-core') ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__('Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .demo-item_title-wrap:hover .demo-item_title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'coming_color',
            [
                'label' => esc_html__('Coming Soon Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'separator' => 'before',
                'default' => BigHearts_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .demo-item_label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $_s = $this->get_settings_for_display();

        $this->add_render_attribute('demo', 'class', [
            'wgl-demo-item',
            (bool)$_s['coming_soon'] ? 'coming-soon' : ''
        ]);

        $this->add_render_attribute('demo_button', 'class', [
            'wgl-button',
            'elementor-button',
        ]);
        if (!empty($_s['demo_link']['url'])) {
            $this->add_link_attributes('demo_button', $_s['demo_link']);
        }

        $this->add_render_attribute('demo_link', 'class', 'demo-item_image-link');
        if (!empty($_s['demo_link']['url'])) {
            $this->add_link_attributes('demo_link', $_s['demo_link']);
        }

        $this->add_render_attribute('title_link', 'class', 'demo-item_title-link');
        if (!empty($_s['demo_link']['url'])) {
            $this->add_link_attributes('title_link', $_s['demo_link']);
        }

        $this->add_render_attribute('demo_img', [
            'class' => 'demo-item_image',
            'src' => isset($_s['thumbnail']['url']) ? esc_url($_s['thumbnail']['url']) : '',
            'alt' => Control_Media::get_image_alt( $_s['thumbnail'] ),
        ]);

        ?>
        <div <?php echo $this->get_render_attribute_string('demo'); ?>>
            <div class="demo-item_title-wrap"><?php
                if (!empty($_s['thumbnail'])) {?>
                    <div class="demo-item_image-wrap">
                        <a <?php echo $this->get_render_attribute_string('demo_link'); ?>><img <?php echo $this->get_render_attribute_string('demo_img'); ?> /></a><?php
                        if (!empty($_s['button_title'])) {?>
                            <a <?php echo $this->get_render_attribute_string('demo_button'); ?>><?php echo esc_html($_s[ 'button_title' ]);?></a><?php
                        }
                        if ((bool)$_s['coming_soon']) {?>
                            <h5 class="demo-item_label"><?php echo esc_html__('Coming Soon', 'bighearts-core'); ?></h5><?php
                        }?>
                    </div><?php
                }
                if (!empty($_s['demo_title'])) {
                    echo '<a ', $this->get_render_attribute_string('title_link'), '>',
                        '<', $_s['title_tag'], ' class="demo-item_title">',
                            $_s['demo_title'],
                        '</', $_s['title_tag'], '>',
                    '</a>';
                }
                ?>
            </div>
        </div>

        <?php
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