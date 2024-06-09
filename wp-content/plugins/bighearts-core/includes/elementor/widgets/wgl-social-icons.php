<?php
/**
 * This template can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/widgets/wgl-social-icons.php`.
 */
namespace WglAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Repeater,
    Icons_Manager,
    Group_Control_Border,
    Group_Control_Box_Shadow
};

class Wgl_Social_Icons extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-social-icons';
    }

    public function get_title()
    {
        return esc_html__('WGL Social Icons', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-social-icons';
    }

    public function get_categories()
    {
        return ['wgl-extensions'];
    }

    public function get_script_depends()
    {
        return ['jquery-appear'];
    }

    public function get_keywords()
    {
        return ['social', 'icon', 'link'];
    }

    protected function register_controls()
    {
        /**
         * CONTENT -> GENERAL
         */

        $this->start_controls_section(
            'section_content_general',
            ['label' => esc_html__('General', 'bighearts-core') ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'social_icon_fontawesome',
            [
                'label' => esc_html__('Icon', 'bighearts-core'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'social',
                'label_block' => true,
                'default' => [
                    'value' => 'fab fa-wordpress',
                    'library' => 'fa-brands',
                ],
                'recommended' => [
                    'fa-brands' => [
                        'android',
                        'apple',
                        'behance',
                        'bitbucket',
                        'codepen',
                        'delicious',
                        'deviantart',
                        'digg',
                        'dribbble',
                        'bighearts-core',
                        'facebook',
                        'flickr',
                        'foursquare',
                        'free-code-camp',
                        'github',
                        'gitlab',
                        'globe',
                        'houzz',
                        'instagram',
                        'jsfiddle',
                        'linkedin',
                        'medium',
                        'meetup',
                        'mixcloud',
                        'odnoklassniki',
                        'pinterest',
                        'product-hunt',
                        'reddit',
                        'shopping-cart',
                        'skype',
                        'slideshare',
                        'snapchat',
                        'soundcloud',
                        'spotify',
                        'stack-overflow',
                        'steam',
                        'stumbleupon',
                        'telegram',
                        'thumb-tack',
                        'tripadvisor',
                        'tumblr',
                        'twitch',
                        'twitter',
                        'viber',
                        'vimeo',
                        'vk',
                        'weibo',
                        'weixin',
                        'whatsapp',
                        'wordpress',
                        'xing',
                        'yelp',
                        'youtube',
                        '500px',
                    ],
                    'fa-solid' => [
                        'envelope',
                        'link',
                        'rss',
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'social_icon_title',
            [
                'label' => esc_html__('Title', 'bighearts-core'),
                'type' => Controls_Manager::TEXT,
			    'dynamic' => [  'active' => true],
                'placeholder' => esc_attr__('Title', 'bighearts-core'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'bighearts-core'),
                'type' => Controls_Manager::URL,
			    'dynamic' => [  'active' => true],
                'label_block' => true,
                'default' => ['is_external' => 'true'],
                'placeholder' => esc_attr__('https://your-link.com', 'bighearts-core'),
            ]
        );

        $repeater->add_control(
            'item_icon_color',
            [
                'label' => esc_html__('Color Palette', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Official', 'bighearts-core'),
                    'custom' => esc_html__('Custom', 'bighearts-core'),
                ],
            ]
        );

        $repeater->start_controls_tabs(
            'r_tabs_icon',
            [
                'condition' => ['item_icon_color' => 'custom']
            ]
        );

        $repeater->start_controls_tab(
            'r_tab_icon_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $repeater->add_control(
            'r_icon_color_idle',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.elementor-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}}.elementor-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_control(
            'r_icon_bg_idle',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.elementor-social-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

        $repeater->add_control(
            'r_icon_border_color_idle',
            [
                'label' => esc_html__('Border Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.elementor-icon' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'r_tab_icon_hover',
            ['label' => esc_html__('Hover', 'bighearts-core') ]
        );

        $repeater->add_control(
            'r_icon_color_hover',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.elementor-icon:hover i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}}.elementor-icon:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_control(
            'r_icon_bg_hover',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.elementor-icon:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_control(
            'r_icon_border_color_hover',
            [
                'label' => esc_html__('Border Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.elementor-icon:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $repeater->end_controls_tab();
        $repeater->end_controls_tabs();

        $this->add_control(
            'social_icon_list',
            [
                'label' => esc_html__('Social Icons', 'bighearts-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'social_icon_title' => esc_html__('Twitter', 'bighearts-core'),
                        'social_icon_fontawesome' => [
                            'value' => 'fab fa-twitter',
                            'library' => 'fa-brands',
                        ],
                    ],
                    [
                        'social_icon_title' => esc_html__('Facebook', 'bighearts-core'),
                        'social_icon_fontawesome' => [
                            'value' => 'fab fa-facebook',
                            'library' => 'fa-brands',
                        ],
                    ],
                    [
                        'social_icon_title' => esc_html__('Instagram', 'bighearts-core'),
                        'social_icon_fontawesome' => [
                            'value' => 'fab fa-instagram',
                            'library' => 'fa-brands',
                        ],
                    ],
                ],
                'title_field' => '{{{ social_icon_title }}}',
            ]
        );

        $this->add_control(
            'shape',
            [
                'label' => esc_html__('Shape', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'rounded' => esc_html__('Rounded', 'bighearts-core'),
                    'square' => esc_html__('Square', 'bighearts-core'),
                    'circle' => esc_html__('Circle', 'bighearts-core'),
                ],
                'default' => 'rounded',
                'prefix_class' => 'elementor-shape-',
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__( 'Alignment', 'bighearts-core' ),
                'type' => Controls_Manager::CHOOSE,
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => esc_html__('View', 'bighearts-core'),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> ICON
         */

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Icon', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Color Palette', 'bighearts-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'default' => esc_html__('Official', 'bighearts-core'),
                    'custom' => esc_html__('Custom', 'bighearts-core'),
                ],
                'default' => 'default',
            ]
        );

        $this->start_controls_tabs(
            'tabs_icon',
            [
                'condition' => ['icon_color' => 'custom']
            ]
        );

        $this->start_controls_tab(
            'tab_icon_idle',
            ['label' => esc_html__('Idle', 'bighearts-core')]
        );

        $this->add_control(
            'icon_color_idle',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_bg_idle',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_border_color_idle',
            [
                'label' => esc_html__('Border Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_shadow_color_idle',
                'selector' => '{{WRAPPER}} .elementor-icon',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            ['label' => esc_html__('Hover', 'bighearts-core')]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label' => esc_html__('Text Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon:hover i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-icon:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_bg_hover',
            [
                'label' => esc_html__('Background Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_border_color_hover',
            [
                'label' => esc_html__('Border Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_shadow_color_hover',
                'selector' => '{{WRAPPER}} .elementor-icon:hover',
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => esc_html__('Hover Animation', 'bighearts-core'),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'section_social_divider',
            ['type' => Controls_Manager::DIVIDER]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'range' => [
                    'px' => ['min' => 6, 'max' => 300],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_padding',
            [
                'label' => esc_html__('Container Size', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'range' => [
                    'em' => ['min' => 0, 'max' => 5 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'padding: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $icon_spacing = is_rtl() ? 'margin-left: {{SIZE}}{{UNIT}};' : 'margin-right: {{SIZE}}{{UNIT}};';

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label' => esc_html__('Containers Gap', 'bighearts-core'),
                'type' => Controls_Manager::SLIDER,
			    'dynamic' => [  'active' => true],
                'range' => [
                    'px' => ['min' => 0, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon:not(:last-child)' => $icon_spacing,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .elementor-icon',
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $_s = $this->get_settings_for_display();
        $fallback_defaults = [
            'fa fa-facebook',
            'fa fa-twitter',
            'fa fa-google-plus',
        ];

        $class_animation = '';

        if (!empty($_s['hover_animation'])) {
            $class_animation = ' elementor-animation-' . $_s['hover_animation'];
        }

        $migration_allowed = Icons_Manager::is_migration_allowed();

        // Render
        echo '<div class="wgl-social-icons elementor-social-icons-wrapper">';
        foreach ($_s['social_icon_list'] as $index => $item) {

            $migrated = isset($item['__fa4_migrated'][$item['social_icon_fontawesome']]);
            $is_new = $migration_allowed;
            $social = '';

            // add old default
            if (empty($item['social']) && !$migration_allowed) {
                $item['social'] = $fallback_defaults[$index] ?? 'fa fa-wordpress';
            }

            if (!empty($item['social'])) {
                $social = str_replace('fa fa-', '', $item['social']);
            }

            if (
                ($is_new || $migrated)
                && 'svg' !== $item['social_icon_fontawesome']['library']
            ) {
                $social = explode(' ', $item['social_icon_fontawesome']['value'], 2);
                if (empty($social[1])) {
                    $social = '';
                } else {
                    $social = str_replace('fa-', '', $social[1]);
                }
            }

            if ('svg' === $item['social_icon_fontawesome']['library']) {
                $social = '';
            }

            $link_key = 'link_' . $index;

            $this->add_render_attribute(
                $link_key,
                [
                    'class' => [
                        'elementor-icon',
                        'elementor-social-icon',
                        'elementor-social-icon-' . $social . $class_animation,
                        'elementor-repeater-item-' . $item['_id'],
                    ]
                ]
            );

            $this->add_link_attributes($link_key, $item['link']);

            if ($item['social_icon_title']) {
                $this->add_render_attribute($link_key, 'title', $item['social_icon_title']);
            }

            echo '<a ', $this->get_render_attribute_string($link_key), '>';
                echo '<span class="elementor-screen-only">', ucwords($social), '</span>';

                if ($is_new || $migrated) {
                    ob_start();
                        Icons_Manager::render_icon($item['social_icon_fontawesome']);
                    echo ob_get_clean();
                } else {
                    echo '<i class="icon ', esc_attr($item['social']), '"></i>';
                }
            echo '</a>';
        }
        echo '</div>'; // wgl-social-icons
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
