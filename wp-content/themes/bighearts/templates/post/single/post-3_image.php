<?php

use BigHearts_Theme_Helper as BigHearts;

$single = BigHearts_Single_Post::getInstance();
$single->set_post_data();
$single->set_image_data();
$single->set_post_views(get_the_ID());

$hide_all_meta = BigHearts::get_option('single_meta');

$meta_cats = $meta_data = [];
if (!$hide_all_meta) {
    $meta_cats['category'] = !BigHearts::get_option('single_meta_categories');
    $meta_data['date'] = !BigHearts::get_option('single_meta_date');
    $meta_data['author'] = !BigHearts::get_option('single_meta_author');
    $meta_data['comments'] = !BigHearts::get_option('single_meta_comments');
}

$page_title_padding = BigHearts::get_mb_option('single_padding_layout_3', 'mb_post_layout_conditional', 'custom');
$page_title_padding_top = !empty($page_title_padding['padding-top']) ? (int)$page_title_padding['padding-top'] : '';
$page_title_padding_bottom = !empty($page_title_padding['padding-bottom']) ? (int)$page_title_padding['padding-bottom'] : '';
$page_title_styles = !empty($page_title_padding_top) ? 'padding-top: '. (int) $page_title_padding_top .'px;' : '';
$page_title_styles .= !empty($page_title_padding_bottom) ? 'padding-bottom: '. (int) $page_title_padding_bottom .'px;' : '';
$page_title_styles = $page_title_styles ? ' style="' . esc_attr($page_title_styles) . '"' : '';

$animation_enabled = BigHearts::get_mb_option('single_apply_animation', 'mb_post_layout_conditional', 'custom');
$data_attr_content = $post_class = '';
if ($animation_enabled) {
    wp_enqueue_script('skrollr', get_template_directory_uri() . '/js/skrollr.min.js');

    $data_attr_content = ' data-center="opacity: 1" data-100-top="opacity: 1" data-0-top="opacity: 0.1" data-anchor-target=".blog-post-single-item .blog-post_content"';
    $post_class = ' blog_skrollr_init';
}

// Render
echo '<div class="blog-post', $post_class, ' blog-post-single-item format-', esc_attr($single->get_post_format()), '"', $page_title_styles, '>';
echo '<div ', post_class('single_meta'), '>';
echo '<div class="item_wrapper">';
echo '<div class="blog-post_content">';

    // Media
    $single->render_featured_image_as_background();

    echo '<div class="wgl-container">';
    echo '<div class="row">';
    echo '<div class="content-container wgl_col-12"', $data_attr_content, '>';

        // Categories
        $hide_all_meta || $single->render_post_meta($meta_cats);

        echo '<h1 class="blog-post_title">', get_the_title(), '</h1>';

        // Meta Data
        $hide_all_meta || $single->render_post_meta($meta_data);

    echo '</div>';
    echo '</div>';
    echo '</div>';

echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
