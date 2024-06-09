<?php
/**
 * This template can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/templates/wgl-give-wp.php`.
 */
namespace WglAddons\Templates;

defined('ABSPATH') || exit; //* Abort, if called directly.

use WglAddons\Includes\{
    Wgl_Loop_Settings,
    Wgl_Carousel_Settings
};
use BigHearts_Theme_Helper as BigHearts;

/**
 * Give-WP Donations Forms Template
 *
 *
 * @package bighearts-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 * @version 1.0.7
 */
class WGL_Give_Donations
{
    private $attributes;
    private $query;

    public function render($attributes = [])
    {
        $this->attributes = $attributes;
        $this->query = $this->_formalize_query();

        if (!$this->query->have_posts()) {
            //* Bailout, if nothing to render
            return;
        }

        $_ = $attributes; //* assign shorthand for attributes array

        echo '<section class="wgl-donation">';

        $this->_render_header_section();

        echo '<div class="wgl-donation__grid', $this->_get_wrapper_classes(), '">';

        if ('carousel' === $_['widget_layout']) {
            ob_start();
        }

        //* Loop through query
        while ($this->query->have_posts()) {
            $this->_render_give_form_html();
        }
        wp_reset_postdata();

        if ('carousel' === $_['widget_layout']) {
            $give_form_posts = ob_get_clean();
            echo $this->_apply_carousel_settings($give_form_posts);
        }

        echo '</div>'; //* wgl-donation__grid

        $this->_render_navigation_section();

        echo '</section>';
    }

    protected function _formalize_query()
    {
        list($query_args) = Wgl_Loop_Settings::buildQuery($this->attributes);

        $query_args['post_type'] = 'give_forms';

        //* Add Page to Query
        global $paged;
        if (empty($paged)) {
            $paged = get_query_var('page') ?: 1;
        }
        $query_args['paged'] = $paged;

        return Wgl_Loop_Settings::cache_query($query_args);
    }

    protected function _render_header_section()
    {
        $widget_title = $this->attributes['widget_title'] ?? '';
        $widget_subtitle = $this->attributes['widget_subtitle'] ?? '';

        if (
            !$widget_title
            && !$widget_subtitle
        ) {
            return;
        }

        echo '<header>';

        if ($widget_subtitle) {
            echo '<p class="wgl-donation__subtitle">',
                wp_kses($widget_subtitle, $this->_get_kses_allowed_html()),
            '</p>';
        }

        if ($widget_title) {
            echo '<h3 class="wgl-donation__title">',
                wp_kses($widget_title, $this->_get_kses_allowed_html()),
            '</h3>';
        }

        echo '</header>';
    }

    protected function _get_wrapper_classes()
    {
        $class = ' grid-col--' . $this->attributes['grid_columns'];
        $class .= $this->attributes['horizontal_layout'] ? ' horizontal-layout' : '';
        $class .= 'carousel' === $this->attributes['widget_layout'] ? ' carousel' : '';

        return esc_attr($class);
    }

    /**
     * @since 1.0.0
     * @version 1.0.7
     */
    protected function _render_give_form_html()
    {
        $this->query->the_post();
        $form_id = get_post()->ID;

        // Is categories enabled?
        $give_cats = give_is_setting_enabled(give_get_option('categories', 'disabled'));
        $hide_cats = $this->attributes['hide_cats'] ?? false;
        $this->attributes['categories_enabled'] = $categories_enabled = $give_cats && !$hide_cats;

        extract($this->attributes);

        echo '<article class="wgl-donation__card">';
        echo '<div class="card__container">';

        // Featured Image
        $media_enabled = !$hide_media && has_post_thumbnail();
        $media_enabled && $this->_render_featured_image();

        echo '<div class="card__content">';

        if (
            $categories_enabled
            && ($horizontal_layout || !$media_enabled)
        ) {
            \BigHearts_Give_Wp::render_form_taxonomies($form_id);
        }

        $hide_title || $this->_render_title();
        $hide_excerpt || $this->_render_excerpt();

        // Goal Progress
        if (
            (!$hide_goal_bar || !$hide_goal_stats)
            && give_is_setting_enabled(give_get_meta($form_id, '_give_goal_option', true))
        ) {
            $stats = give_goal_progress_stats($form_id);

            echo '<div class="card__progress">';
            $hide_goal_bar || $this->_render_goal_bar($stats);
            $hide_goal_stats || $this->_render_goal_stats($stats);
            echo '</div>';
        }

        echo '</div>'; // card__content
        echo '</div>';
        echo '</article>';
    }

    /**
     * @since 1.0.0
     * @version 1.0.7
     */
    protected function _render_featured_image()
    {
        $full_url = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));

        if (
            !$full_url
            || !$this->attributes
        ) {
            // Bailout, if there is no featured image
            return;
        }

        extract($this->attributes);

        $img_alt = trim(get_post_meta($full_url, '_wp_attachment_image_alt', true));

        if (
            'default' === $img_size_string
            || !class_exists('WglAddons\Includes\Wgl_Elementor_Helper')
        ) {
            list(
                $img_url,
                $img_srcset,
                $img_sizes
            ) = $this->_get_image_attributes($full_url);
        } else {
            $dims = \WglAddons\Includes\Wgl_Elementor_Helper::get_image_dimensions(
                $img_size_array ?: $img_size_string,
                $img_aspect_ratio ?? ''
            );

            $img_url = aq_resize($full_url, $dims['width'], $dims['height'], true, true, true) ?: $full_url;
        }

        $categories = '';
        if ($categories_enabled && !$horizontal_layout) {
            ob_start();
            \BigHearts_Give_Wp::render_form_taxonomies(get_the_ID());
            $categories = ob_get_clean();
        }
        $extra_class = $categories ? ' has-categories' : '';

        $class_image = 'carousel' === $widget_layout ? 'carousel-img donation-img' : 'donation-img';
        printf(
            '<div class="card__media%s">'
                . '%s'
                . '<img'
                    . " src='$img_url'"
                    . " class='".esc_attr(apply_filters('bighearts/image/class', $class_image))."'"
                    . (isset($img_srcset) ? " srcset='$img_srcset'" : '')
                    . (isset($img_sizes) ? " sizes='$img_sizes'" : '')
                    . " alt='$img_alt'"
                . '>'
                . '%s'
                . '%s'
                . '</div>',
            $extra_class,
            $media_link ? '<a href="' . get_permalink() . '">' : '',
            $media_link ? '</a>' : '',
            $categories
        );
    }

    protected function _get_image_attributes(String $full_url)
    {
        $_ = $this->attributes; // assign shorthand for attributes array

        //* Featured Image Dimensions
        $dims = [
            'lg' => ['width' => '800', 'height' => '588'], //* ratio 1.359
            'md' => ['width' => '740', 'height' => '545'],
            'sm' => ['width' => '540', 'height' => '588'],
        ];

        $img_lg_url = aq_resize($full_url, $dims['lg']['width'], $dims['lg']['height'], $_['media_crop'], true, true) ?: $full_url;
        $img_md_url = aq_resize($full_url, $dims['md']['width'], $dims['md']['height'], $_['media_crop'], true, true) ?: '';
        $img_sm_url = aq_resize($full_url, $dims['sm']['width'], $dims['sm']['height'], $_['media_crop'], true, true) ?: '';

        $img_srcset = $img_sm_url ? esc_url($img_sm_url) . ' 435w,' : '';
        if ($img_md_url) {
            $img_srcset .= esc_url($img_md_url);
            $img_srcset .= $_['horizontal_layout'] ? ' 704w' : ' 600w';
        }

        if (
            '1' == $_['grid_columns']
            && !$_['horizontal_layout']
        ) {
            $img_url = $full_url;
            $img_sizes = '(max-width: 600px) ' . $dims['sm']['width'] . 'px, (max-width: 992px) ' . $dims['md']['width'] . 'px, 1170px';
            $img_srcset .= ',' . esc_url($full_url) . ' 1170w';
        } else {
            $img_url = $img_lg_url;
            $img_sizes = '(min-width: 600px) 600px, 435px';
        }

        return [$img_url, $img_srcset, $img_sizes];
    }

    protected function _render_title()
    {
        $title = get_the_title();

        if (!$title) {
            // Bailout.
            return;
        }

        printf(
            '<%1$s class="card__title"><a href="%2$s">%3$s</a></%1$s>',
            esc_html($this->attributes['heading_tag'] ?? 'h4'),
            esc_url(get_permalink()),
            wp_kses($title, $this->_get_kses_allowed_html())
        );
    }

    /**
     * Render the post's Excerpt or Content
     */
    protected function _render_excerpt()
    {
        $formID = get_the_ID();

        if (has_excerpt($formID)) :
            $excerpt = get_the_excerpt($formID);
        else :
            $mb_content = give_get_meta($formID, '_give_form_content', true); //* metabox field content
            $el_content = get_the_content(null, false, $formID); //* elementor content

            $excerpt = $el_content ?: $mb_content;
        endif;

        if (!$excerpt) {
            //* Bailout, if nothing to render
            return;
        }

        $excerpt_limited = $this->attributes['excerpt_limited'] ?? true;
        $excerpt_chars = !empty($this->attributes['excerpt_chars']) ? $this->attributes['excerpt_chars'] : 100;

        $excerpt_stripped = strip_tags($excerpt);
        $excerpt = $excerpt_limited ? BigHearts::modifier_character($excerpt_stripped, $excerpt_chars) : $excerpt_stripped;
        $excerpt = trim($excerpt);

        echo '<p class="card__excerpt">', $excerpt, '</p>';
    }

    /**
     * @since 1.0.0
     * @version 1.0.6
     */
    protected function _render_goal_bar(Array $stats)
    {
        $bar_width = $stats['goal'] ? (int) ($stats['raw_actual'] / $stats['raw_goal'] * 100) : 0;

        if ('donors' !== $stats['format']) {
            $bar_width = $stats['raw_actual'] >= $stats['raw_goal'] ? 100 : $bar_width;
        }

        echo '<div class="progress__bar">',
            '<div class="bar__container" style="width: ', $bar_width, '%">',
                '<span class="bar__label">', $bar_width, '%</span>',
            '</div>',
        '</div>';
    }

    protected function _render_goal_stats(Array $stats)
    {
        if (
            'percentage' === $stats['format']
            || !$stats['goal']
        ) {
            return;
        }

        $raised_style = isset($this->attributes['raised_color'])
            ? ' style="color: ' . $this->attributes['raised_color'] . '"'
            : '';

        $goal_label = esc_html__('Goal:', 'bighearts-core');
        $raised_label = esc_html__('Raised:', 'bighearts-core');
        $lack_label = esc_html__('To Go:', 'bighearts-core');
        $lack_value = give_format_amount($stats['raw_goal'] - $stats['raw_actual']);

        if ('donors' === $stats['format']) {
            $raised_label = esc_html__('Donors:', 'bighearts-core');
            $lack_label = esc_html__('Awaiting:', 'bighearts-core');
        }

        if ('amount' === $stats['format']) {
            $lack_value =  give_currency_filter($lack_value);
        }

        $lack_value = preg_replace('/-/', '+', $lack_value);

        echo '<div class="progress__stats">',

            '<div class="stats__goal">',
                '<div class="stats__info">',
                    '<span class="stats__label">',
                        apply_filters('bighearts/give/goal_stats/goal_label', $goal_label),
                    '</span>',
                    '<span class="stats__value">',
                        $stats['goal'],
                    '</span>',
                '</div>',
            '</div>',

            '<div class="stats__raised">',
                '<div class="stats__info">',
                    '<div class="stats__info--aligned">',
                        '<span class="stats__label">',
                            apply_filters('bighearts/give/goal_stats/raised_label', $raised_label),
                        '</span>',
                        '<span class="stats__value"', $raised_style, '>',
                            $stats['actual'],
                        '</span>',
                    '</div>',
                '</div>',
            '</div>',

            '<div class="stats__lack">',
                '<div class="stats__info">',
                    '<span class="stats__label">',
                        apply_filters('bighearts/give/goal_stats/lack_label', $lack_label),
                    '</span>',
                    '<span class="stats__value">',
                        $lack_value,
                    '</span>',
                '</div>',
            '</div>',

        '</div>';
    }

    protected function _apply_carousel_settings($give_form_posts)
    {
        $_ = $this->attributes; // assign shorthand for attributes array

        $options = [
            'slide_to_show' => $_['grid_columns'],
            'autoplay' => $_['autoplay'],
            'autoplay_speed' => $_['autoplay_speed'],
            'infinite' => $_['infinite_loop'],
            'slides_to_scroll' => $_['slide_single'],
            'use_pagination' => $_['use_pagination'],
            'use_navigation' => $_['use_navigation'],
            'use_prev_next' => $_['use_navigation'] ? true : false,
            'pag_type' => $_['pag_type'],
            'custom_pag_color' => $_['custom_pag_color'],
            'pag_color' => $_['pag_color'],
            'custom_resp' => $_['custom_resp'],
            'resp_medium_slides' => $_['resp_medium_slides'],
            'resp_tablets_slides' => $_['resp_tablets_slides'],
            'resp_mobile_slides' => $_['resp_mobile_slides'],
            'adaptive_height' => true
        ];

        $_['resp_medium'] && $options['resp_medium'] = $_['resp_medium'];
        $_['resp_tablets'] && $options['resp_tablets'] = $_['resp_tablets'];
        $_['resp_mobile'] && $options['resp_mobile'] = $_['resp_mobile'];

        return Wgl_Carousel_Settings::init($options, $give_form_posts);
    }

    protected function _render_navigation_section()
    {
        if ('pagination' === $this->attributes['navigation_type']) {
            echo BigHearts::pagination($this->query, $this->attributes['navigation_align']);
        }
    }

    protected function _get_kses_allowed_html()
    {
        return [
            'a' => [
                'id' => true, 'class' => true, 'style' => true,
                'href' => true, 'title' => true,
                'rel' => true, 'target' => true,
            ],
            'br' => ['id' => true, 'class' => true, 'style' => true],
            'em' => ['id' => true, 'class' => true, 'style' => true],
            'b' => ['id' => true, 'class' => true, 'style' => true],
            'strong' => ['id' => true, 'class' => true, 'style' => true],
            'span' => ['id' => true, 'class' => true, 'style' => true],
        ];
    }
}
