<?php

defined('ABSPATH') || exit;

use WglAddons\Templates\WglPortfolio;
use BigHearts_Theme_Helper as BigHearts;

/**
* Template for Portfolio CPT archive page
*
* @package bighearts-core\includes\post-types
* @author WebGeniusLab <webgeniuslab@gmail.com>
* @since 1.0.0
*/

$term_id = get_queried_object()->term_id ?? '';

// Show Filter Options
$show_filter = $term_id ? BigHearts::get_option('portfolio_list_show_filter') : '';
$list_terms = BigHearts::get_option('portfolio_list_filter_cats');

if (!empty($show_filter) && !empty($list_terms)) {
    $term_id = $list_terms;
}

$term_slug = [];
$cat_title = $cat_descr = '';


// Taxonomies
$tax_obj = get_queried_object();
$term_id = $tax_obj->term_id ?? '';
if ($term_id) {
    $taxonomies[] = $tax_obj->taxonomy . ': ' . $tax_obj->slug;
    $tax_description = $tax_obj->description;
}

$defaults = [
    'portfolio_layout' => 'masonry',
    'link_destination' => 'single',
    'linked_image' => true,
    'linked_title' => true,
    'add_animation' => null,
    'navigation' => 'pagination',
    'nav_align' => 'left',
    'posts_per_row' => BigHearts::get_option('portfolio_list_columns'),
    'show_portfolio_title' => BigHearts::get_option('portfolio_list_show_title'),
    'show_meta_categories' => BigHearts::get_option('portfolio_list_show_cat'),
    'show_content' => BigHearts::get_option('portfolio_list_show_content'),
    'show_filter' => $show_filter,
    'filter_align' => 'center',
    'items_load' => '4',
    'grid_gap' => '30px',
    'info_position' => 'inside_image',
    'image_anim' => 'sub_layer',
    'gallery_mode' => false,
    'img_size_string' => '740x740',
    'img_size_array' => '',
    'img_aspect_ratio' => '',
    'portfolio_icon_type' => '',
    // Query
    'number_of_posts' => '12',
    'order_by' => 'menu_order',
    'order' => 'DSC',
    'post_type' => 'portfolio',
    'taxonomies' => $taxonomies ?? [],
];

// Sidebar parameters
$sb = BigHearts::get_sidebar_data('portfolio_list');
$container_class = $sb['container_class'] ?? '';
$row_class = $sb['row_class'] ?? '';
$column = $sb['column'] ?? '12';

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
                ($tax_description ? '<div class="archive__tax_description">' . esc_html($tax_description) . '</div>' : ''),
            '</div>';
        }

        echo (new WglPortfolio())->render($defaults);

    echo '</div>';

    $sb && BigHearts::render_sidebar($sb);

echo '</div>';
echo '</div>';

get_footer();
