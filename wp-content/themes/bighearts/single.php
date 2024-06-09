<?php

defined('ABSPATH') || exit;

use WglAddons\Templates\WGL_Blog;
use BigHearts_Theme_Helper as BigHearts;

/**
 * The dedault template for single posts rendering
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bighearts
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 * @since 1.0.9
 */

get_header();
the_post();

$sb = BigHearts::get_sidebar_data('single');
$container_class = $sb['container_class'] ?? '';
$row_class = $sb['row_class'] ?? '';
$column = $sb['column'] ?? '12';
$layout = $sb['layout'] ?? '';

$single_type = BigHearts::get_mb_option('single_type_layout', 'mb_post_layout_conditional', 'custom') ?: 2;

$row_class .= ' single_type-' . $single_type;

if ('3' === $single_type) {
    $featured_bg_style = 'background-color: ' . BigHearts::get_option('page_title_bg_image')['background-color'] . ';'
        .  ' margin-bottom: ' . (int) BigHearts::get_mb_option('page_title_margin', 'mb_page_title_switch', 'on')['margin-bottom'] . 'px;';

    echo '<div class="post_featured_bg" style="', $featured_bg_style,'">';
        get_template_part('templates/post/single/post', $single_type . '_image');
    echo '</div>';
}

//* Render
echo '<div class="wgl-container', apply_filters('bighearts/container/class', $container_class), '">';
echo '<div class="row', apply_filters('bighearts/row/class', $row_class), '">';

    echo '<div id="main-content" class="wgl_col-', apply_filters('bighearts/column/class', $column), '">';

        get_template_part('templates/post/single/post', $single_type);

        //* Navigation
        get_template_part('templates/post/post-navigation');

        //* ↓ Related Posts
        $related_posts_enabled = BigHearts::get_option('single_related_posts');

        if (
            class_exists('RWMB_Loader')
            && ($mb_blog_show = rwmb_meta('mb_blog_show_r'))
            && 'default' !== $mb_blog_show
        ) {
            $related_posts_enabled = 'off' === $mb_blog_show ? null : $mb_blog_show;
        }

        if (
            $related_posts_enabled
            && class_exists('BigHearts_Core')
            && class_exists('\Elementor\Plugin')
        ) {
            global $wgl_related_posts;
            $wgl_related_posts = true;

            $related_cats = [];
            $cats = BigHearts::get_option('blog_cat_r');
            if (!empty($cats)) {
                $related_cats[] = implode(',', $cats);
            }

            if (
                class_exists('RWMB_Loader')
                && get_queried_object_id() !== 0
                && 'custom' === $mb_blog_show
            ) {
                $related_cats = get_post_meta(get_the_id(), 'mb_blog_cat_r');
            }
            //* Render
            echo '<section class="single related_posts">';
                //* Get Cats_Slug
                if ($categories = get_the_category()) {
                    $post_categ = $post_category_compile = '';
                    foreach ($categories as $category) {
                        $post_categ = $post_categ . $category->slug . ',';
                    }
                    $post_category_compile .= '' . trim($post_categ, ',') . '';

                    if (!empty($related_cats[0])) {
                        $categories = get_categories(['include' => $related_cats[0]]);
                        $post_categ = $post_category_compile = '';
                        foreach ($categories as $category) {
                            $post_categ = $post_categ . $category->slug . ',';
                        }
                        $post_category_compile .= trim($post_categ, ',');
                    }

                    $related_cats = $post_category_compile;
                }

                $related_module_title = BigHearts::get_mb_option('blog_title_r', 'mb_blog_show_r', 'custom');

                echo '<div class="bighearts_module_title">',
                    '<h4>',
                        esc_html($related_module_title) ?: esc_html__('Related Posts', 'bighearts'),
                    '</h4>',
                '</div>';

                $carousel_layout = BigHearts::get_mb_option('blog_carousel_r', 'mb_blog_show_r', 'custom');
                $columns_amount = BigHearts::get_mb_option('blog_column_r', 'mb_blog_show_r', 'custom');
                $posts_amount = BigHearts::get_mb_option('blog_number_r', 'mb_blog_show_r', 'custom');

                $related_posts_atts = [
                    'blog_layout' => $carousel_layout ? 'carousel' : 'grid',
                    'navigation_type' => 'none',
                    'use_navigation' => null,
                    'hide_content' => true,
                    'hide_share' => false,
                    'hide_likes' => true,
                    'hide_views' => true,
                    'meta_author' => false,
                    'meta_comments' => true,
                    'read_more_hide' => true,
                    'read_more_text' => esc_html__('Read More', 'bighearts'),
                    'heading_tag' => 'h4',
                    'content_letter_count' => 90,
                    'img_size_string' => '840x690',
                    'img_size_array' => '',
                    'img_aspect_ratio' => '',
                    'items_load' => 4,
                    'load_more_text' => esc_html__('Load More', 'bighearts'),
                    'blog_columns' => $columns_amount ?? (('none' == $layout) ? '4' : '6'),
                    //* Carousel
                    'autoplay' => '',
                    'autoplay_speed' => 3000,
                    'slides_to_scroll' => '',
                    'infinite_loop' => false,
                    'use_pagination' => '',
                    'pag_type' => 'circle',
                    'pag_offset' => '',
                    'custom_resp' => true,
                    'resp_medium' => '',
                    'pag_color' => '',
                    'custom_pag_color' => '',
                    'resp_tablets_slides' => '',
                    'resp_tablets' => '',
                    'resp_medium_slides' => '',
                    'resp_mobile' => '768',
                    'resp_mobile_slides' => '1',
                    //* Query
                    'number_of_posts' => (int) $posts_amount,
                    'categories' => $related_cats,
                    'order_by' => 'rand',
                    'exclude_any' => 'yes',
                    'by_posts' => [$post->post_name => $post->post_title] //* exclude current post
                ];

                (new WGL_Blog())->render($related_posts_atts);

            echo '</section>';

            unset($wgl_related_posts); //* destroy globar var
        }
        //* ↑ related posts

        //* Comments
        if (comments_open() || get_comments_number()) {
            echo '<div class="row">';
            echo '<div class="wgl_col-12">';
                comments_template();
            echo '</div>';
            echo '</div>';
        }

    echo '</div>'; //* #main-content

    $sb && BigHearts::render_sidebar($sb);

echo '</div>';
echo '</div>';

get_footer();
