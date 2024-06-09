<?php
/**
 * Current file can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/widgets/wgl-double-headings.php`.
 */
namespace WglAddons\Widgets;

defined( 'ABSPATH' ) || exit;

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Group_Control_Typography
};
use WglAddons\BigHearts_Global_Variables as BigHearts_Globals;

/**
 * Double Heading Widget
 *
 *
 * @package bighearts-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 * @version 1.1.5
 */
class Wgl_Double_Headings extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-double-headings';
    }

    public function get_title()
    {
        return esc_html__( 'WGL Double Heading', 'bighearts-core' );
    }

    public function get_icon()
    {
        return 'wgl-double-headings';
    }

    public function get_categories()
    {
        return [ 'wgl-extensions' ];
    }

    protected function register_controls()
    {
        /** CONTENT -> GENERAL */

        $this->start_controls_section(
            'wgl_double_headings_section',
            ['label' => esc_html__('General', 'bighearts-core')]
        );

        $this->add_control(
            'presubtitle',
            [
                'label' => esc_html__('Subtitle Prefix', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
                'placeholder' => esc_attr__('ex: 01', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label' => esc_html__('Subtitle', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
                'placeholder' => esc_attr__('ex: About Us', 'bighearts-core'),
                'default' => esc_html__('Subtitle', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'dbl_title',
            [
                'label' => esc_html__('Title', 'bighearts-core'),
                'type' => Controls_Manager::TEXTAREA,
			    'dynamic' => [  'active' => true],
                'rows' => 1,
                'placeholder' => esc_attr__('1st part', 'bighearts-core'),
                'default' => esc_html_x('Title', 'WGL Double Heading', 'bighearts-core'),
            ]
        );

        $this->add_control(
            'alignment',
            [
                'label' => esc_html__( 'Alignment', 'bighearts-core' ),
                'type' => Controls_Manager::CHOOSE,
                'separator' => 'before',
                'toggle' => false,
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
                'default' => 'left',
                'prefix_class' => 'a',
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Title Link', 'bighearts-core'),
                'type' => Controls_Manager::URL,
			    'dynamic' => [  'active' => true],
                'placeholder' => esc_attr__('https://your-link.com', 'bighearts-core'),
            ]
        );

        $this->end_controls_section();

        /** STYLES -> TITLE */

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
                'name' => 'title_all',
                'selector' => '{{WRAPPER}} .dbl__title',
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

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_1st',
                'condition' => ['dbl_title!' => ''],
                'selector' => '{{WRAPPER}} .dbl-title_1',
            ]
        );

        $this->add_control(
            'title_1st_color',
            [
                'label' => esc_html__('Title Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'condition' => ['dbl_title!' => ''],
                'default' => BigHearts_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .dbl-title_1' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /** STYLES -> SUBTITLE */

        $this->start_controls_section(
            'section_style_subtitle',
            [
                'label' => esc_html__('Subtitle', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['subtitle!' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typo',
                'selector' => '{{WRAPPER}} .dbl__subtitle',
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'default' => BigHearts_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .dbl__subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'subtitle_margin',
            [
                'label' => esc_html__('Margin', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
	                'top' => '0',
	                'right' => '0',
	                'bottom' => '5',
	                'left' => '0',
                ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .dbl__subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $_s = $this->get_settings_for_display();

        if (!empty($_s['link']['url'])) {
            $this->add_render_attribute('link', 'class', 'dbl__link');
            $this->add_link_attributes('link', $_s['link']);
        }

        $this->add_render_attribute('heading_wrapper', 'class', 'wgl-double_heading'); ?>
        <div <?php echo $this->get_render_attribute_string('heading_wrapper'); ?>><?php
            if ($_s['subtitle'] || $_s['presubtitle']) { ?>
                <div class="dbl__subtitle"><?php
                    if ($_s['presubtitle']) echo '<span>'. $_s['presubtitle']. '</span>';
                    if ($_s['subtitle']) echo '<span>'. $_s['subtitle']. '</span>';?>
                </div><?php
            }

            if ( $_s['dbl_title'] ) {

                if (!empty($_s['link']['url'])){ ?><a <?php echo $this->get_render_attribute_string('link'); ?>><?php }

                echo '<'. $_s['title_tag']. ' class="dbl__title-wrapper">';
                    if ($_s['dbl_title']) ?><span class="dbl__title dbl-title_1"><?php echo $_s['dbl_title']; ?></span><?php
                echo '</'. $_s['title_tag']. '>';

                if (!empty($_s['link']['url'])){ ?></a><?php }

            }?>
        </div><?php
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
