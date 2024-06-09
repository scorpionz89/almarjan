<?php

defined('ABSPATH') || exit;

use BigHearts_Theme_Helper as BigHearts;

/**
 * The Full-width template
 *
 * @package bighearts
 * @since 1.0.0
 */

get_header();
the_post();

$sb = BigHearts::get_sidebar_data();
$container_class = $sb['container_class'] ?? '';
$row_class = $sb['row_class'] ?? '';
$column = $sb['column'] ?? '12';

// Render
echo '<div class="wgl-container full-width">';
echo '<div class="row', apply_filters('bighearts/row/class', $row_class), '">';

    echo '<div id="main-content" class="wgl_col-', apply_filters('bighearts/column/class', $column), '">';

        the_content(esc_html__('Read more!', 'bighearts'));

        BigHearts::link_pages();

        if (comments_open() || get_comments_number()) {
            comments_template();
        }

    echo '</div>';

    $sb && BigHearts::render_sidebar($sb);

echo '</div>';
echo '</div>';

get_footer();