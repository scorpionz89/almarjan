<?php
/**
* Template for Give-WP archive page
*
* @package bighearts\give
* @author WebGeniusLab <webgeniuslab@gmail.com>
*/

use BigHearts_Theme_Helper as BigHearts;
use WglAddons\{
    BigHearts_Global_Variables as BigHearts_Globals,
    Templates\WGL_Give_Donations
};

// Sidebar settings
$sb = BigHearts::get_sidebar_data('give-archive');
$container_class = $sb['container_class'] ?? '';
$row_class = $sb['row_class'] ?? '';
$column = $sb['column'] ?? '12';

// Taxonomies
$tax_obj = get_queried_object();
$term_id = $tax_obj->term_id ?? '';
if ($term_id) {
    $taxonomies[] = $tax_obj->taxonomy . ': ' . $tax_obj->slug;
    $tax_description = $tax_obj->description;
}

$atts = [
    'widget_layout' => 'grid',
    'grid_columns' => BigHearts::get_option('give-archive_columns'),
    'horizontal_layout' => false,
    // Appearance
    'hide_media' => BigHearts::get_option('give-archive_hide-media'),
    'media_crop' => true,
    'media_link' => true,
    'hide_cats' => BigHearts::get_option('give-archive_hide-categories'),
    'hide_title' => BigHearts::get_option('give-archive_hide-title'),
    'hide_excerpt' => BigHearts::get_option('give-archive_hide-content'),
    'excerpt_limited' => BigHearts::get_option('give-archive_content-limit'),
    'excerpt_chars' => BigHearts::get_option('give-archive_content_count'),
    'hide_goal_bar' => BigHearts::get_option('give-archive_hide-goal-bar'),
    'hide_goal_stats' => BigHearts::get_option('give-archive_hide-goal-stats'),
    'img_size_string' => 'default',
    'img_size_array' => '',
    'img_aspect_ratio' => '',
    // Navigation
    'navigation_type' => 'pagination',
    'navigation_align' => 'left',
    // Query
    'post_type' => 'give_forms',
    'number_of_posts' => '12',
    'order' => 'DSC',
    'order_by' => 'date',
    'taxonomies' => $taxonomies ?? [],
    // Extra
    'stats_raised_color' => BigHearts::average_between_two_colors(
        BigHearts_Globals::get_primary_color(),
        BigHearts_Globals::get_secondary_color()
    ),
];

// Render
get_header();

echo '<div class="wgl-container', apply_filters('bighearts/container/class', $container_class), '">';
echo '<div class="row', apply_filters('bighearts/row/class', $row_class), '">';

    echo '<div id="main-content" class="wgl_col-', apply_filters('bighearts/column/class', $column), '">';

        if ($term_id) {
            echo '<div class="archive__heading">',
                '<h4 class="archive__tax_title">',
                    get_the_archive_title(),
                '</h4>',
                $tax_description ? '<div class="archive__tax_description">' . esc_html($tax_description) . '</div>' : '',
            '</div>';
        }

        echo '<div class="elementor-widget-wgl-give-forms">',
            (new WGL_Give_Donations())->render($atts),
        '</div>';

    echo '</div>';

    $sb && BigHearts::render_sidebar($sb);

echo '</div>';
echo '</div>';

get_footer();
