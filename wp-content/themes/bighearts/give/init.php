<?php

defined('ABSPATH') || exit;

use WglAddons\{
    BigHearts_Global_Variables as BigHearts_Globals,
    Includes\Wgl_Elementor_Helper
};
use BigHearts_Theme_Helper as BigHearts;

/**
 * Give-WP plugin configuration
 *
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 * @version 1.0.13
 */
class BigHearts_Give_Wp
{
    private static $_instance;
    protected $sidebar_data;
    protected $form_template;

    /**
     * @since 1.0.0
     * @version 1.0.13
     */
    public function __construct()
    {
        $this->plugin_settings_adjustments();
        $this->single_page_configuration();
        $this->archive_page_configuration();
    }

    public function plugin_settings_adjustments()
    {
        add_filter('give_forms_donation_goal_metabox_fields', [$this, 'reassign_metabox_defaults'], 10, 2);
        add_filter('give_forms_single_sidebar', [$this, 'modify_sidebar_registration']);
        add_filter('update_post_metadata', [$this, 'update_meta_elementor'], 10, 5);
        add_filter('give_get_default_form_shortcode_args', [$this, 'update_give_get_default_form_shortcode_args'], 10, 5);
    }

    function update_give_get_default_form_shortcode_args() {
        $default = [
            'id'                    => '',
            'show_title'            => true,
            'show_goal'             => true,
            'show_content'          => '',
            'float_labels'          => '',
            'display_style'         => '',
            'continue_button_title' => '',
            'progress_bar_color'    => BigHearts_Globals::get_primary_color(),

            // This attribute belong to form template functionality.
            // You can use this attribute to set modal open button background color.
            'button_color'          => '#28C77B',
        ];

        return $default;
    }

    public function reassign_metabox_defaults($options, $post_id)
    {
        /**
         * Donation Goal Tab
         */
        if ('give_forms_donation_goal_metabox_fields' === current_filter()) {
            if (
                isset($options[5]['id'])
                && '_give_goal_color' === $options[5]['id']
            ) {
                $index = 5;
            } else {
                $index = $this->_find_new_index_of_option('_give_goal_color', $options);
            }
            /** Set `Progress Bar Color` to theme primary color */
            $index && $options[$index]['default'] = BigHearts_Globals::get_primary_color();
        }

        return $options;
    }

    protected function _find_new_index_of_option($search_id, $options_array)
    {
        error_log("BigHearts: `reassign_metabox_defaults()` revealed that $search_id option recieved new index from plugin developers");
        foreach ($options_array as $k => $v) {
            if ($v['id'] !== $search_id) {
                continue;
            }
            $index = $k;
            break;
        }

        return $index ?? false;
    }

    public function modify_sidebar_registration($params)
    {
        $params['before_widget'] = '<div id="%1$s" class="widget bighearts_widget %2$s">';
        $params['before_title'] = '<div class="title-wrapper"><span class="title">';
        $params['after_title'] = '</span><span class="title__line"></span></div>';

        return $params;
    }

    /**
     *  Database writing of elementor content with pre-escaping of characters
     *
     *  Give-WP 2.8.0 does not escape characters, which leads to the inability to save content to the database
     */
    public function update_meta_elementor($check, $post_id, $meta_key, $meta_value, $prev_value)
    {
        if (!$post_id) {
            // Bailout.
            return;
        }

        $post_data = get_post($post_id);

        if ('give_forms' !== get_post_type($post_data->ID)) {
            // Bailout.
            return;
        }

        if ('_elementor_data' === $meta_key) {

            $meta_value = wp_slash($meta_value);

            global $wpdb;

            $formmeta = $wpdb->prefix . 'give_formmeta';

            $wpdb->query(
                "UPDATE " . $formmeta . "
		        SET meta_value = '" . $meta_value . "'
                WHERE form_id = '" . $post_data->ID . "'
                AND meta_key = '_elementor_data'"
            );

            $wpdb->query(
                $wpdb->prepare(
                    "
                        INSERT INTO $wpdb->postmeta
                        ( post_id, meta_key, meta_value )
                        VALUES ( %d, %s, %s )
                    ",
                    [
                        $post_data->ID,
                        '_elementor_data',
                        $meta_value,
                    ]
                )
            );

            $wpdb->show_errors();
        }
    }

    /**
     * @since 1.0.0
     * @version 1.0.13
     */
    public function single_page_configuration()
    {
        $this->sidebar_parameters_definition();

        add_action('wp', function() {
            $queried_post_type = get_queried_object()->post_type ?? '';
            if ('give_forms' === $queried_post_type) {
                $form_template = Give\Helpers\Form\Template::getActiveID();
                $this->form_template = $form_template ?: 'legacy';
            }
        });

        add_filter('give_default_wrapper_start', [$this, 'build_single_page_structure']);
        add_filter('give_left_sidebar_pre_wrap', [$this, 'disable_featured_image_sidebar_layout']);
        add_filter('single_give_form_image_html', [$this, 'disable_featured_image_placeholder']);

        add_action('give_before_single_form_summary', function () {
            remove_action('give_before_single_form_summary', 'give_get_forms_sidebar', 20);
        }, 1);
        if (give_is_setting_enabled(give_get_option('categories', 'disabled'))) {
            add_action('give_before_single_form_summary', function() {
                self::render_form_taxonomies();
            }, 15);
        }

        add_action('give_before_main_content', [$this, 'determine_form_content_positioning']);

        if (give_is_setting_enabled(give_get_option('tags', 'disabled'))) {
            add_action('give_after_single_form_summary', function() {
                self::render_form_taxonomies(0, 'give_forms_tag');
            }, 20);
        }
    }

    /**
     * @since 1.0.0
     * @version 1.0.13
     */
    public function sidebar_parameters_definition()
    {
        add_filter('give_form_title', [$this, 'modify_sidebar_widget_title']);

        add_action('wp', function () {
            $queried_post_type = get_queried_object()->post_type ?? '';
            if ('give_forms' === $queried_post_type) {
                $this->sidebar_data = BigHearts::get_sidebar_data('give-single');
            }
        });
    }

    public function modify_sidebar_widget_title($title)
    {
        $title = str_replace('<h2 class="give-form-title">', '<div class="title-wrapper"><span class="title">', $title);
        $title = str_replace('</h2>', '</span><span class="title__line"></span></div>', $title);

        return $title;
    }

    public function build_single_page_structure()
    {
        add_filter('give_default_wrapper_end', function () {
            if (!empty($this->sidebar_data)) {
                ob_start();
                BigHearts::render_sidebar($this->sidebar_data);
                $sidebar = ob_get_clean();
            }

            /** Closing tags for the Page container, with injection of Sidebar content */
            return '</div>'
                . ($sidebar ?? '')
                . '</div>'
                . '</div>';
        });

        $layout = $this->sidebar_data['layout'] ?? '';
        $row_class = 'right' === $layout
            ? ' sidebar_right'
            : ('left' === $layout ? ' sidebar_left' : '');

        $column_class = 'wgl_col-' . ($this->sidebar_data['column'] ?? 12);

        return '<div class="wgl-container">'
            . '<div class="row' . $row_class . '">'
            . '<div id="main-content" class="' . $column_class . '">';
    }

    public function disable_featured_image_sidebar_layout()
    {
        if ($this->is_not_legacy_form_template()) {
            return;
        }

        if(has_post_thumbnail()) {
            $featured_img_url = get_the_post_thumbnail_url(get_the_ID());
            if(!$featured_img_url){
                $class = ' has-no-image';
            }
        }elseif (!has_post_thumbnail()){
            $class = ' has-no-image';
        }

        return '<div class="give-form__feature-image' . ($class ?? '') . '">';
    }

    public function is_not_legacy_form_template()
    {
        return 'legacy' !== $this->form_template;
    }

    public function disable_featured_image_placeholder($img_src)
    {
        if ($this->is_not_legacy_form_template()) {
            return $img_src;
        }

        if (strpos($img_src, 'give-placeholder.png')) {
            return;
        }

        return $img_src;
    }

    public function determine_form_content_positioning()
    {
        if ($this->is_not_legacy_form_template()) {
            return;
        }

        $post_id = get_post()->ID;

        if ('disabled' === give_get_meta($post_id, '_give_display_content', true)) {
            //* Bailout, if content is disabled
            return;
        }

        $give_content_placement = give_get_meta($post_id, '_give_content_placement', true) ?: 'bighearts_after_form';
        if ('bighearts_after_form' === $give_content_placement) {
            //* Reassign hook in order to render content after donation form
            remove_action('give_pre_form_output', 'give_form_content', 10);
            add_action('give_after_single_form_summary', [$this, 'render_form_content']);
        }
    }

    public function render_form_content()
    {
        $metabox_content = give_get_meta(get_post()->ID, '_give_form_content', true);

        $elementor_content = '';
        if (did_action('elementor/loaded')) {
			$elementor_content = apply_filters('the_content', get_the_content());
        }

        $content = $elementor_content ?: $metabox_content;

        if (!$content) {
            //* Bailout, if no any content
            return;
        }

        echo '<div class="give-form-content-wrap outside">',
            $content,
            '</div>';
    }

    public static function render_form_taxonomies($postID = 0, $taxomomy = 'give_forms_category')
    {
        $postID || $postID = get_post()->ID;

        $terms = get_the_terms($postID, $taxomomy);
        if (!empty($terms) && !is_wp_error($terms)) {
            $extra_css_array = [];
            foreach ($terms as $cat) {
                if ('give_forms_category' === $taxomomy) {
                    //*  ↓ Custom background
                    $cat_slug = 'give-cat-' . $cat->slug;
                    $cat_color_idle = get_term_meta($cat->term_id, '_give_forms_category_color_idle', true);
                    $cat_color_hover = get_term_meta($cat->term_id, '_give_forms_category_color_hover', true);
                    $class = '';

                    if ($cat_color_idle || $cat_color_hover) {
                        $class .= $cat_slug;
                    }
                    if ($cat_color_idle) {
                        $class .= ' cat-custom-color-idle';
                    }
                    if ($cat_color_hover) {
                        $class .= ' cat-custom-color-hover';
                        if (empty($extra_css_array[$cat_slug])) {
                            $extra_css_array[$cat_slug] = '#' . esc_attr($cat_color_hover);
                        }
                    }

                    $style = $cat_color_idle
                        ? ' style="background-color: #' . esc_attr($cat_color_idle) . '; border-color: #' . esc_attr($cat_color_idle) . ';"'
                        : '';
                    //* ↑ custom background

                    $tax_html = '<span>'
                            . '<a'
                                . ' href="' . get_term_link($cat, $cat->taxonomy) . '"'
                                . ($class ? ' class="' . $class . '"' : '')
                                . $style
                                . ' rel="tag"'
                                . '>'
                                    . $cat->name
                            . '</a>'
                        . '</span>';
                } else {
                    $tax_html = '<a'
                            . ' href="' . get_term_link($cat, $cat->taxonomy) . '"'
                            . ' rel="tag"'
                            . '>'
                                . $cat->name
                        . '</a>';
                }

                if (!empty($extra_css_array)) {
                    $extra_css_string = '';
                    foreach ($extra_css_array as $k => $v) {
                        $extra_css_string .= ".{$k}:hover { background-color: {$v} !important; border-color: {$v} !important; }";
                    }
                    Wgl_Elementor_Helper::enqueue_css($extra_css_string);
                }
            }
        }

        if (empty($tax_html)) {
            //* Bailout, if nothing to render
            return;
        }

        if ('give_forms_category' === $taxomomy) {
            echo '<div class="post_categories">',
                $tax_html,
            '</div>';
        } else {
            echo '<div class="single_post_info">',
                '<div class="tagcloud-wrapper">',
                    '<div class="tagcloud">',
                    $tax_html,
                    '</div>',
                '</div>',
            '</div>';
        }
    }

    public function archive_page_configuration()
    {
        add_filter('archive_template', [$this, 'get_archive_template_path']);
    }

    public function get_archive_template_path($archive_template)
    {
        if (
            is_post_type_archive('give_forms')
            || is_tax(['give_forms_category', 'give_forms_tags'])
        ) {
            if (file_exists(get_template_directory() . '/archive-give_forms.php')) {
                return $archive_template;
            }

            return get_template_directory() . '/give/archive-give_forms.php';
        }

        return $archive_template;
    }

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }
}

function BigHearts_Give_Wp()
{
    return BigHearts_Give_Wp::instance();
}

BigHearts_Give_Wp();
