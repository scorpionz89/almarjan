<?php

use BigHearts_Theme_Helper as BigHearts;

$single = BigHearts_Single_Post::getInstance();
$single->set_post_data();
$post_format = $single->get_post_format();

$use_author_info = BigHearts::get_option('single_author_info');
$use_tags = BigHearts::get_option('single_meta_tags') && has_tag();
$use_shares = BigHearts::get_option('single_share') && function_exists('wgl_theme_helper');
$use_likes = BigHearts::get_option('single_likes') && function_exists('wgl_simple_likes');
$use_views = BigHearts::get_option('single_views');

$video_style = 'video' === $post_format && function_exists('rwmb_meta') ? rwmb_meta('post_format_video_style') : '';

//* Render
echo '<article class="blog-post blog-post-single-item format-', esc_attr($post_format), '">';
echo '<div ', post_class('single_meta'), '>';
echo '<div class="item_wrapper">';
echo '<div class="blog-post_content">';

    //* Media
    if (
        'standard-image' !==  $post_format
        && 'standard' !== $post_format
        && 'bg_video' !==  $video_style
    ) {
        //* affected post types: gallery, link, quote, audio, video-popup.
        $single->render_featured();
    }

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

echo '</div>'; //* blog-post_content
echo '</div>'; //* item_wrapper
echo '</div>';
echo '</article>';
