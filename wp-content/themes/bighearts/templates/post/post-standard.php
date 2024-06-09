<?php

use BigHearts_Theme_Helper as BigHearts;
use WglAddons\Includes\Wgl_Elementor_Helper;

global $wgl_blog_atts;

// Default settings for blog item
$trim = true;
if (!$wgl_blog_atts) {
    global $wp_query;

    $trim = false;

    $wgl_blog_atts = [
        'query' => $wp_query,
        // General
        'blog_layout' => 'grid',
        // Content
        'blog_columns' => BigHearts::get_option('blog_list_columns') ?: '12',
        'hide_media' => BigHearts::get_option('blog_list_hide_media'),
        'hide_content' => BigHearts::get_option('blog_list_hide_content'),
        'hide_blog_title' => BigHearts::get_option('blog_list_hide_title'),
        'hide_all_meta' => BigHearts::get_option('blog_list_meta'),
        'meta_author' => BigHearts::get_option('blog_list_meta_author'),
        'meta_comments' => BigHearts::get_option('blog_list_meta_comments'),
        'meta_categories' => BigHearts::get_option('blog_list_meta_categories'),
        'meta_date' => BigHearts::get_option('blog_list_meta_date'),
        'hide_likes' => !BigHearts::get_option('blog_list_likes'),
        'hide_views' => !BigHearts::get_option('blog_list_views'),
        'hide_share' => !BigHearts::get_option('blog_list_share'),
        'read_more_hide' => BigHearts::get_option('blog_list_read_more'),
        'content_letter_count' => BigHearts::get_option('blog_list_letter_count') ?: '85',
        'heading_tag' => 'h3',
        'read_more_text' => esc_html__('Read More', 'bighearts'),
        'items_load' => 4,
    ];
}

// Extract arrived|default variables
extract($wgl_blog_atts);

global $wgl_query_vars;
if (!empty($wgl_query_vars)) {
    $query = $wgl_query_vars;
}

$kses_allowed_html = [
    'a' => [
        'id'  => true, 'class' => true, 'style' => true,
        'href' => true, 'title' => true,
        'rel' => true, 'target' => true,
    ],
    'br' => ['id'  => true, 'class' => true, 'style' => true],
    'b' => ['id'  => true, 'class' => true, 'style' => true],
    'em' => ['id'  => true, 'class' => true, 'style' => true],
    'strong' => ['id'  => true, 'class' => true, 'style' => true],
    'span' => ['id'  => true, 'class' => true, 'style' => true],
];

// Variables validation
$img_size = $img_size ?? 'full';
$img_aspect_ratio = $img_aspect_ratio ?? '';
$hide_share = $hide_share && function_exists('wgl_theme_helper');
$media_link = $media_link ?? false;
$hide_views = $hide_views ?? false;

// Meta
$meta_cats = $meta_data_date = $meta_data = [];
if (!$hide_all_meta) {
    $meta_cats['category'] = !$meta_categories;
    $meta_data_date['date'] = !$meta_date;
    $meta_data['author'] = !$meta_author;
    $meta_data['comments'] = !$meta_comments;
    $meta_data['views'][0] = !$hide_views;
}
$meta_extras['likes'] = !$hide_likes;
$meta_extras['share'] = !$hide_share;

// Loop through query
while ($query->have_posts()) :
    $query->the_post();

    $post_img_size = class_exists('WglAddons\Includes\Wgl_Elementor_Helper')
        ? Wgl_Elementor_Helper::get_image_dimensions($img_size, $img_aspect_ratio)
        : 'full';

    $single = BigHearts_Single_Post::getInstance();
    $single->set_post_data();
    $single->set_image_data($media_link = true, $post_img_size);
    $single->set_image_class($blog_layout);

    $post_format = $single->get_post_format();

    $meta_data['views'][1] = !$hide_views ? $single->get_post_views(get_the_ID(), true) : '';

    $has_media = $single->meta_info_render;

    $blog_post_classes = ' format-' . $post_format
        . ($hide_media ? ' hide_media' : '')
        . (is_sticky() ? ' sticky-post' : '')
        . (!$has_media ? ' format-no_featured' : '');

    // Render
    echo '<div class="wgl_col-', esc_attr($blog_columns), ' item">';
    echo '<div class="blog-post', esc_attr($blog_post_classes), '">';
    echo '<div class="blog-post_wrapper">';

    // Media
    if (!$hide_media && $has_media) {
        $single->render_featured([
            'media_link' => $media_link,
            'image_size' => $post_img_size,
            'hide_all_meta' => $hide_all_meta,
            'meta_cats' => $meta_cats
        ]);
    }

    echo '<div class="blog-post_content">';

    // Media alt (link, quote, audio...)
    if (!$hide_media && !$has_media) {
        $single->render_featured();
    }

    // Cats
    if (!$has_media && !$hide_all_meta) {
        $single->render_post_meta($meta_cats);
    }

    // Date
    if (!$hide_all_meta) {
        $single->render_post_meta($meta_data_date);
    }

    // Title
    if (
        !$hide_blog_title
        && !empty($title = get_the_title())
    ) {
        printf(
            '<%1$s class="blog-post_title"><a href="%2$s">%3$s</a></%1$s>',
            esc_html($heading_tag),
            esc_url(get_permalink()),
            wp_kses($title, $kses_allowed_html)
        );
    }

    // Excerpt|Content
    if (!$hide_content) {
        $single->render_excerpt($content_letter_count, $trim);
    }

    // Read more
    if (!$read_more_hide) {
        echo '<div class="read-more-wrap">',
            '<a href="', esc_url(get_permalink()), '" class="button-read-more">',
            '<span>',
            esc_html($read_more_text),
            '</span>',
            '</a>',
        '</div>';
    }

    BigHearts::link_pages();

    echo '</div>'; // blog-post_content

    // Meta wrapper
    if (
        !$hide_all_meta
        || !$hide_likes
        || !$hide_share
    ) {
        $meta_wrap_opened = true;
        echo '<div class="blog-post_meta-wrap">';
    }

    // Meta Data
    if (!$hide_all_meta) {
        $single->render_post_meta($meta_data);
    }

    if ($meta_wrap_opened ?? false) {
        ob_start();
        $single->render_post_meta($meta_extras);
        $meta_extras_html = ob_get_clean();
        if ($meta_extras_html) {
            echo '<div class="meta-info">', $meta_extras_html, '</div>';
        }

        echo '</div>'; // blog-post_meta-wrap
    }

    echo '</div>'; // blog-post_wrapper
    echo '</div>';
    echo '</div>';

endwhile;
wp_reset_postdata();
