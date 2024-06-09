<?php

use BigHearts_Theme_Helper as BigHearts;

$single = BigHearts_Single_Post::getInstance();
$single->set_post_data();
$single->set_image_data();
$single->set_post_views(get_the_ID());

$hide_all_meta = BigHearts::get_option('single_meta');
$use_author_info = BigHearts::get_option('single_author_info');
$use_tags = BigHearts::get_option('single_meta_tags') && has_tag();
$use_likes = BigHearts::get_option('single_likes') && function_exists('wgl_simple_likes');
$use_shares = BigHearts::get_option('single_share') && function_exists('wgl_theme_helper');
$use_views = BigHearts::get_option('single_views');

$has_media = $single->meta_info_render;

$meta_cats = $meta_data = [];
if (!$hide_all_meta) {
    $meta_cats['category'] = !BigHearts::get_option('single_meta_categories');
    $meta_data['date'] = !BigHearts::get_option('single_meta_date');
    $meta_data['author'] = !BigHearts::get_option('single_meta_author');
    $meta_data['comments'] = !BigHearts::get_option('single_meta_comments');
}

// Render
echo '<article class="blog-post blog-post-single-item format-', esc_attr($single->get_post_format()), '">';
echo '<div ', post_class('single_meta'), '>';
echo '<div class="item_wrapper">';
echo '<div class="blog-post_content">';

    // Categories
    $hide_all_meta || $single->render_post_meta($meta_cats);

    // Meta Data
    $hide_all_meta || $single->render_post_meta($meta_data);

    echo '<h2 class="blog-post_title">', get_the_title(), '</h2>';

    // Media
	$single->render_featured();

    the_content();

    BigHearts::link_pages();

    if (
        $use_tags
        || $use_shares
        || $use_views
        || $use_likes
    ) {
        echo '<div class="single_post_info">';

            $use_tags && the_tags('<div class="tagcloud-wrapper"><div class="tagcloud">', ' ', '</div></div>');

            if ($use_shares) {
                echo wgl_theme_helper()->render_post_list_share();
            }

            $use_views && $single->get_post_views(get_the_ID());

            $use_likes && wgl_simple_likes()->likes_button(get_the_ID());

        echo '</div>';

        echo '<div class="post_info-divider"></div>';

    } else {

        echo '<div class="post_info-divider"></div>';

    }

    $use_author_info && $single->render_author_info();

    echo '<div class="clear"></div>';

echo '</div>'; // blog-post_content
echo '</div>'; // item_wrapper
echo '</div>';
echo '</article>';
