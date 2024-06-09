<?php
namespace WglAddons\Widgets;

defined('ABSPATH') || exit; // Abort, If called directly.

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Utils
};

/**
 * Logo widget for Header CPT
 *
 *
 * @package bighearts-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 */
class Wgl_Header_Logo extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-header-logo';
    }

    public function get_title()
    {
        return esc_html__('WGL Logo', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-header-logo';
    }

    public function get_categories()
    {
        return ['wgl-header-modules'];
    }

    protected function register_controls()
    {
        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_general',
            ['label' => esc_html__('General', 'bighearts-core')]
        );

        $this->add_control(
            'use_custom_logo',
            [
                'label' => esc_html__('Use Custom Logo?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'custom_logo',
            [
                'label' => esc_html__('Custom Logo', 'bighearts-core'),
                'type' => Controls_Manager::MEDIA,
			    'dynamic' => [  'active' => true],
                'condition' => ['use_custom_logo!' => ''],
                'label_block' => true,
                'default' => ['url' => Utils::get_placeholder_image_src()],
            ]
        );

        $this->add_control(
            'enable_logo_height',
            [
                'label' => esc_html__('Enable Logo Height?', 'bighearts-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['use_custom_logo!' => ''],
            ]
        );

        $this->add_control(
            'logo_height',
            [
                'label' => esc_html__('Logo Height', 'bighearts-core'),
                'type' => Controls_Manager::NUMBER,
			    'dynamic' => [  'active' => true],
                'condition' => [
                    'use_custom_logo!' => '',
                    'enable_logo_height!' => '',
                ],
                'min' => 1,
                'default' => 90,
            ]
        );

        $this->add_control(
            'logo_align',
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
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .wgl-logotype-container' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function render()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        $custom_size = false;

        $logo = !empty($custom_logo) ? $custom_logo : false;

        if (
            $logo
            && !empty($enable_logo_height)
            && !empty($logo_height)
        ) {
            $custom_size = $logo_height;
        }

        require_once (get_theme_file_path('/templates/header/components/logo.php'));

        new \BigHearts_Get_Logo('bottom', false, $logo, $custom_size);
    }
}
