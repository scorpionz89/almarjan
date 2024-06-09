<?php

defined('ABSPATH') || exit;

use BigHearts_Theme_Helper as BigHearts;

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bighearts
 * @since 1.0.0
 */

get_header();

$sb = BigHearts::get_sidebar_data();
$container_class = $sb['container_class'] ?? '';
$row_class = $sb['row_class'] ?? '';
$column = $sb['column'] ?? '12';

// Render
echo '<div class="wgl-container', apply_filters('bighearts/container/class', $container_class), '">';
echo '<div class="row', apply_filters('bighearts/row/class', $row_class), '">';

    echo '<div id="main-content" class="wgl_col-', apply_filters('bighearts/column/class', $column), '">';

        // Blog Archive Template
        get_template_part('templates/post/posts-list');

        echo BigHearts::pagination();

    echo '</div>';

    $sb && BigHearts::render_sidebar($sb);

echo '</div>';
echo '</div>';

get_footer();
