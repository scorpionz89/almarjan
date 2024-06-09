<?php

defined('ABSPATH') || exit;

use BigHearts_Theme_Helper as BigHearts;

/**
 * The template for displaying image attachments
 *
 * @package bighearts
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 */

get_header();

$sb = BigHearts::get_sidebar_data();
$container_class = $sb['container_class'] ?? '';
$row_class = $sb['row_class'] ?? '';
$column = $sb['column'] ?? '12';

echo '<div class="wgl-container', apply_filters('bighearts/container/class', $container_class), '">';
echo '<div class="row', apply_filters('bighearts/row/class', $row_class), '">';
    echo '<div id="main-content" class="wgl_col-', apply_filters('bighearts/column/class', $column), '">';
        while (have_posts()) :
            the_post();

            /**
            * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
            * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
            */
            $attachments = array_values(get_children([
                'post_parent' => $post->post_parent,
                'post_status' => 'inherit',
                'post_type' => 'attachment',
                'post_mime_type' => 'image',
                'order' => 'ASC',
                'orderby' => 'menu_order ID',
            ]));

            foreach ($attachments as $k => $attachment) {
                if ($attachment->ID == $post->ID) {
                    break;
                }
            }
            $k++;

            // If there is more than 1 attachment in a gallery
            if (count($attachments) > 1) {
                if (isset($attachments[$k])) {
                    // get the URL of the next image attachment
                    $next_attachment_url = get_attachment_link($attachments[ $k ]->ID);
                } else {
                    // or get the URL of the first image attachment
                    $next_attachment_url = get_attachment_link($attachments[0]->ID);
                }
            } else {
                // or, if there's only 1 image, get the URL of the image
                $next_attachment_url = wp_get_attachment_url();
            }

            echo '<div class="blog-post">';
            echo '<div class="single_meta attachment_media">';
            echo '<div class="blog-post_content">';

                echo '<h4 class="blog-post_title">', esc_html(get_the_title()), '</h4>';

                echo '<div class="meta-data">';
                    BigHearts::posted_meta_on();
                echo '</div>';

                $attachment_size = [1170, 725];
                echo '<div class="blog-post_media">',
                    '<a href="', esc_url($next_attachment_url), '" title="', the_title_attribute(), '" rel="attachment">',
                        wp_get_attachment_image(get_the_ID(), $attachment_size),
                    '</a>',
                '</div>';

                the_content();

                BigHearts::link_pages();

            echo '</div>';
            echo '</div>';
            echo '</div>';

            if (comments_open() || '0' != get_comments_number()) {
                comments_template();
            }
        endwhile;
        wp_reset_postdata();

    echo '</div>';

    $sb && BigHearts::render_sidebar($sb);

echo '</div>';
echo '</div>';

get_footer();
