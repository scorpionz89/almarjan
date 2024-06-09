<?php
namespace WglAddons\Widgets;

defined('ABSPATH') || exit; // Abort, If called directly.

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Group_Control_Typography
};

/**
 * Search widget for Header CPT
 *
 *
 * @package bighearts-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 */
class Wgl_Header_Search extends Widget_Base
{
    public function get_name()
    {
        return 'wgl-header-search';
    }

    public function get_title()
    {
        return esc_html__('WGL Search', 'bighearts-core');
    }

    public function get_icon()
    {
        return 'wgl-header-search';
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
        /**
         * CONTENT -> GENERAL
         */

        $this->start_controls_section(
            'section_content_general',
            ['label' => esc_html__('General', 'bighearts-core')]
        );

        $this->add_control(
            'search_alignment',
            [
                'label' => esc_html__( 'Alignment', 'bighearts-core' ),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
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
                    '{{WRAPPER}} .wgl-search' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'search_post_type',
            [
                'label' => esc_html__('Search Post Types', 'bighearts-core'),
                'type' => Controls_Manager::SELECT2,
                'options' => self::post_type_options(),
                'multiple' => true,
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> SEARCH
         */

        $this->start_controls_section(
            'section_style_search',
            [
                'label' => esc_html__('Search', 'bighearts-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'search',
                'selector' => '{{WRAPPER}} .header_search-button',
                'exclude' => ['font_family', 'text_transform', 'font_style', 'text_decoration', 'letter_spacing'],
            ]
        );

        $this->start_controls_tabs('icon');

        $this->start_controls_tab(
            'tab_icon_idle',
            ['label' => esc_html__('Idle' , 'bighearts-core')]
        );

        $this->add_control(
            'icon_color_idle',
            [
                'label' => esc_html__('Icon Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .header_search-button,
                     {{WRAPPER}} .header_search-close' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            ['label' => esc_html__('Hover' , 'bighearts-core')]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .header_search-button:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_active',
            ['label' => esc_html__('Active' , 'bighearts-core')]
        );

        $this->add_control(
            'icon_color_active',
            [
                'label' => esc_html__('Icon Color', 'bighearts-core'),
                'type' => Controls_Manager::COLOR,
			    'dynamic' => [  'active' => true],
                'selectors' => [
                    '{{WRAPPER}} .header_search-close' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'search_padding',
            [
                'label' => esc_html__('Padding', 'bighearts-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header_search' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public static function post_type_options()
    {
        $args = array(
            'public'   => true,
            '_builtin' => false,
        );
        $output = 'names';
        $operator = 'and';
        $content = [
            '' => esc_html__('Default', 'bighearts-core'),
            'post' => 'post',
            'page' => 'page',
        ];
        $post_types = get_post_types($args, $output, $operator);
        foreach ($post_types  as $post_type) {
            $content[$post_type] = $post_type;
        }

        return $content ?? [];
    }

    public function render()
    {
        $_s = $this->get_settings_for_display();
        $description = esc_html__('Type To Search', 'bighearts-core');
        $search_style = \BigHearts_Theme_Helper::get_option('search_style') ?? 'standard';
        $search_counter = null;
        $unique_id = uniqid('search-form-');

        if (class_exists('\BigHearts_Get_Header')) {
            $search_counter = \BigHearts_Get_Header::$search_form_counter ?? null;
        }

        $search_class = ' search_' . \BigHearts_Theme_Helper::get_option('search_style');

        $inputs = '';
        if (!empty($_s['search_post_type'])) {
            if (count($_s['search_post_type']) === 1) {
                $inputs .= '<input type="hidden" name="post_type" value="'.$_s['search_post_type'][0].'" />';
            } else{
                foreach ($_s['search_post_type'] as $key => $value) {
                    $inputs .= '<input type="hidden" name="post_type[]" value="'.$value.'" />';
                }
            }
		}

        $render_search = true;
        if ($search_style === 'alt') {
            // the only search form in Default and Sticky headers is allowed
            $render_search = $search_counter > 0 ? false : true;

            if (isset($search_counter)) \BigHearts_Get_Header::$search_form_counter++;
        }

        $this->add_render_attribute('search', 'class', ['wgl-search elementor-search header_search-button-wrapper']);
        $this->add_render_attribute('search', 'role', 'button');

        echo '<div class="header_search', esc_attr($search_class), '">';

        echo '<div ', $this->get_render_attribute_string('search'), '>',
            '<div class="header_search-button flaticon-loupe"></div>',
            '<div class="header_search-close"></div>',
        '</div>';

        if ($render_search) {
            echo '<div class="header_search-field">';
            if ($search_style === 'alt') {
                echo '<div class="header_search-wrap">',
                    '<div class="bighearts_module_double_headings aleft">',
                    '<h3 class="header_search-heading_description heading_title">',
                        apply_filters('bighearts/search/description', $description),
                    '</h3>',
                    '</div>',
                    '<div class="header_search-close"></div>',
                '</div>';
            }
            // search form
			echo '<form role="search" method="get" action="', esc_url(home_url('/')), '" class="search-form">',
				'<input',
					' required',
					' type="text"',
					' id="', esc_attr($unique_id), '"',
					' class="search-field"',
					' placeholder="', esc_attr_x('Search &hellip;', 'placeholder', 'bighearts-core'), '"',
					' value="', get_search_query(), '"',
					' name="s"',
					'>',
				'<input class="search-button" type="submit" value="', esc_attr__('Search', 'bighearts-core'), '">',
				$inputs;
				echo '<i class="search__icon flaticon-loupe"></i>',
			'</form>';

            echo '</div>'; // header_search-field
        }

        echo '</div>';
    }
}
