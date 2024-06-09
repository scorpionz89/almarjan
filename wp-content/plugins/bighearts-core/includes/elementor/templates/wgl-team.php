<?php
/*
 * This template can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/templates/wgl-team.php`.
 */
namespace WglAddons\Templates;

defined('ABSPATH') || exit; // Abort, if called directly.

use WglAddons\Includes\{
    Wgl_Loop_Settings,
    Wgl_Carousel_Settings
};

/**
 * WGL Elementor Team Template
 *
 *
 * @package bighearts-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 * @version 1.0.11
 */
class WGL_Team
{
    private static $instance;
    private $attributes;

    public function render($attributes, $content = null)
    {
        $this->attributes = $attributes;

        $wrapper_classes = 'team-col_' . $attributes['posts_per_line'];
        $wrapper_classes .= ' a' . $attributes['info_align'];

        ob_start();
            $this->render_wgl_team($attributes);
        $posts_html = ob_get_clean();

        if ($attributes['use_carousel']) {
            $posts_html = $this->_apply_carousel_settings($posts_html);
        }

        echo '<div class="wgl_module_team ', esc_attr($wrapper_classes), '">',
            '<div class="team-items_wrap">',
                $posts_html,
            '</div>',
        '</div>';
    }

    public function render_wgl_team($atts)
    {
        extract($atts);

        //* Dimensions for team images
        switch ($posts_per_line) {
            default:
            case '1':
            case '2': $team_image_dims = ['width' => '800', 'height' => '800']; break;
            case '3': $team_image_dims = ['width' => '720', 'height' => '780'];  break;
            case '4':
            case '5':
            case '6': $team_image_dims = ['width' => '540', 'height' => '600'];  break;
        }

        list($query_args) = Wgl_Loop_Settings::buildQuery($atts);
        $query_args['post_type'] = 'team';
        $wgl_posts = new \WP_Query($query_args);

        $team_post = '';

        while ($wgl_posts->have_posts()) {
            $wgl_posts -> the_post();
            $team_post .= $this->render_wgl_team_item(false, $atts, $team_image_dims);
        }
        wp_reset_postdata();

        echo $team_post;
    }

    /**
     * @since 1.0.0
     * @version 1.0.11
     */
    public function render_wgl_team_item($single_member, $item_atts, $team_image_dims)
    {
        extract($item_atts);

        $info_array = $info_bg_url = null;
        $t_info = $t_icons = $icons_wrap = '';

        $id = get_the_ID();
        $post = get_post($id);
        $permalink = esc_url(get_permalink($id));
        $highlighted_info = get_post_meta($id, 'department', true);

        if ($single_member) {
            $info_array = get_post_meta($id, 'info_items', true);
            $info_bg_id = get_post_meta($id, 'mb_info_bg', true);
            $info_bg_url = wp_get_attachment_url($info_bg_id, 'full');
        }

        //* Info
        if ($info_array) {
            for ($i = 0, $count = count($info_array); $i < $count; $i++) {
                $info = $info_array[$i];
                $info_name = !empty($info['name']) ? $info['name'] : '';
                $info_description = !empty($info['description']) ? $info['description'] : '';
                $info_link = !empty($info['link']) ? $info['link'] : '';

                if (
                    $single_member
                    && (!empty($info_name) || !empty($info_description))
                ) {
                    $t_info .= '<div class="team-info_item">';
                        $t_info .= !empty($info_name) ? '<h5>' . esc_html($info_name) . '</h5>' : '';
                        $t_info .= !empty($info_link) ? '<a href="'.esc_url($info_link).'">' : '';
                            $t_info .= '<span>' . esc_html($info_description) . '</span>';
                        $t_info .= !empty($info_link) ? '</a>' : '';
                    $t_info .= '</div>';
                }
            }
        }

        //* Social icons
        $social_array = get_post_meta($id, 'soc_icon', true);
        if (!$hide_soc_icons && $social_array) {
            for ($i = 0, $count = count($social_array); $i < $count; $i++) {
                $icon = $social_array[$i];
                $icon_name = $icon['select'] ?: '';
                $icon_link = $icon['link'] ?: '#';
                if ($icon['select']) {
                    $t_icons .= '<a href="' . $icon_link . '" class="team-icon"><i class="' . $icon_name . '"></i></a>';
                }
            }
            if ($t_icons) {
                $icons_wrap = '<div class="team__icons">'
                        . '<span class="team-icon fas fa-share-alt"></span>'
                        . $t_icons
                    . '</div>';
            }
        }

        $image_class = 'team-img';
        if (!empty($use_carousel)) {
            $image_class .= ' carousel-img';
        }

        //* Featured Image
        $featured_image = '';
        $wp_get_attachment_url = wp_get_attachment_url(get_post_thumbnail_id($id), 'single-post-thumbnail');
        if ($wp_get_attachment_url) {
            $img_url = aq_resize($wp_get_attachment_url, $team_image_dims['width'], $team_image_dims['height'], true, true, true);
            $img_alt = get_post_meta(get_post_thumbnail_id($id), '_wp_attachment_image_alt', true);
            $featured_image = sprintf(
                '<%s class="team__image"><img class="%s" src="%s" alt="%s" /></%s>',
                $single_link_wrapper && ! $single_member ? 'a href="' . $permalink . '"' : 'div',
                apply_filters('bighearts/image/class', $image_class),
                esc_url($img_url),
                $img_alt ?: '',
                $single_link_wrapper && ! $single_member ? 'a' : 'div'
            );
        }

        //* Title
        $title = '';
        if (!$hide_title) {
            $title .= '<h2 class="team-title">'
                    . ($single_link_heading && ! $single_member ? '<a href="' . $permalink . '">' : '')
                        . get_the_title()
                    . ($single_link_heading && ! $single_member ? '</a>' : '')
                . '</h2>';
        }

        //* Excerpt
        if (!$hide_content) {
            $excerpt = $post->post_excerpt ?: $post->post_content;
            $excerpt = $single_member ? $post->post_excerpt : $excerpt;
            $excerpt = preg_replace('~\[[^\]]+\]~', '', $excerpt);
            $excerpt = strip_tags($excerpt);
            if ($letter_count) {
                $excerpt = \BigHearts_Theme_Helper::modifier_character($excerpt, $letter_count, '');
            }
        }

        //* Signature
        if (!$hide_signature) {
            $signature = get_post_meta($id, 'mb_signature', true);
            $image_signature = wp_get_attachment_url($signature, 'full');
            $alt_signature =  '' === get_post_meta($signature, '_wp_attachment_image_alt', true)
                ? ''
                : trim(strip_tags(get_post_meta($signature, '_wp_attachment_image_alt', true)));
        }

        //* Render grid
        if (!$single_member) {

            echo '<div class="team-item">';
            echo '<div class="team-item_wrap">';

                if ($featured_image) {
                    echo '<div class="team__media-wrapper">',
                        '<div class="team__image-wrapper">',
                            $icons_wrap,
                            $featured_image,
                        '</div>',
                    '</div>';
                }

                if (!$featured_image && !$hide_soc_icons) {
                    echo $icons_wrap;
                }

                if (
                    !$hide_content
                    || !$hide_title
                    || !$hide_highlited_info
                ) {
                    echo '<div class="team-item_info">';

                        echo $title;

                        if (
                            !$hide_highlited_info
                            || !$hide_signature
                        ) {
                            echo '<div class="team-item_meta">';

                            if (!$hide_highlited_info && $highlighted_info) {
                                echo '<div class="team-department">',
                                    esc_html($highlighted_info),
                                '</div>';
                            }


                            if (!$hide_signature && $signature) {
                                echo '<div class="team-signature">',
                                    '<img',
                                        ' src="', esc_url($image_signature), '"',
                                        ' alt="', esc_attr($alt_signature), '"',
                                        '>',
                                '</div>';
                            }

                            echo '</div>';
                        }

                        if (!$hide_content && $excerpt) {
                            echo '<div class="team-item_excerpt">',
                                $excerpt,
                            '</div>';
                        }

                    echo '</div>';
                }

            echo '</div>'; //* item_wrap
            echo '</div>';

        } else {
            //* Render single

            echo '<div class="team-single_wrapper"', ($info_bg_url ? ' style="background-image: url(' . esc_url($info_bg_url) . ')"' : ''), '>';

                if ($featured_image) {
                    echo '<div class="team-image_wrap">',
                        $featured_image,
                    '</div>';
                }

                echo '<div class="team-info_wrapper">',
                    $title,
                    ($highlighted_info ? '<div class="team-info_item highlighted"><span>' . esc_html($highlighted_info) . '</span></div>' : ''),
                    (!$hide_content && $excerpt ? '<div class="team-info_excerpt">' . $excerpt . '</div>' : ''),
                    $t_info,
                    ($icons_wrap ? '<div class="team-info_desc">' . $icons_wrap . '</div>' : ''),
                '</div>';

                if ($signature) {
                    echo '<div class="team-info_signature">',
                        '<img',
                            ' src="', esc_url($image_signature), '"',
                            ' alt="', esc_attr($alt_signature), '"',
                            '/>',
                    '</div>';
                }

            echo '</div>';

        }
    }

    protected function _apply_carousel_settings($posts_html)
    {
        $_ = $this->attributes; // assign shorthand for attributes array

        $options = [
            'slide_to_show' => $_['posts_per_line'],
            'slides_to_scroll' => $_['slides_to_scroll'],
            'infinite' => $_['infinite'],
            'center_mode' => $_['center_mode'],
            'autoplay' => $_['autoplay'],
            'autoplay_speed' => $_['autoplay_speed'],
            'use_pagination' => $_['use_pagination'],
            'pag_type' => $_['pag_type'],
            'pag_offset' => $_['pag_offset'],
            'custom_pag_color' => $_['custom_pag_color'],
            'pag_color' => $_['pag_color'],
            'use_prev_next' => $_['use_prev_next'],

            'prev_next_position' => $_['prev_next_position'],
            'custom_prev_next_color' => $_['custom_prev_next_color'],
            'prev_next_color' => $_['prev_next_color'],
            'prev_next_color_hover' => $_['prev_next_color_hover'],
            'prev_next_bg_idle' => $_['prev_next_bg_idle'],
            'prev_next_bg_hover' => $_['prev_next_bg_hover'],
            'prev_next_border_idle' => $_['prev_next_border_idle'],
            'prev_next_border_hover' => $_['prev_next_border_hover'],

            'custom_resp' => $_['custom_resp'],
            'resp_medium_slides' => $_['resp_medium_slides'],
            'resp_tablets_slides' => $_['resp_tablets_slides'],
            'resp_mobile_slides' => $_['resp_mobile_slides'],
        ];

        $_['resp_medium'] && $options['resp_medium'] = $_['resp_medium'];
        $_['resp_tablets'] && $options['resp_tablets'] = $_['resp_tablets'];
        $_['resp_mobile'] && $options['resp_mobile'] = $_['resp_mobile'];

        return Wgl_Carousel_Settings::init($options, $posts_html);
    }

    public static function get_instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}