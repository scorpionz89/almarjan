<?php

use WglAddons\Templates\WGL_Team;
use BigHearts_Theme_Helper as BigHearts;

/**
* Single Page Template for Team CPT
*
* @package bighearts-core\includes\post-types\team
* @author WebGeniusLab <webgeniuslab@gmail.com>
* @since 1.0.0
*/

$sb = BigHearts::get_sidebar_data();
$container_class = $sb['container_class'] ?? '';
$row_class = $sb['row_class'] ?? '';
$column = $sb['column'] ?? '12';

$limit_characters = BigHearts::get_option('team_single_content');

$defaults = [
    'title' => '',
    'posts_per_line' => '2',
    'grid_gap' => '',
    'info_align' => 'left',
    'single_link_wrapper' => '',
    'single_link_heading' => true,
    'hide_title' => '',
    'hide_highlited_info' => '',
    'hide_signature' => '',
    'hide_soc_icons' => '',
    'grayscale_anim' => '',
    'info_anim' => '',
    'hide_content' => BigHearts::get_option('team_single_hide_content'),
    'letter_count' => $limit_characters ? BigHearts::get_option('team_single_letter_count') : false,
];

extract($defaults);

$team_image_dims = ['width' => '740', 'height' => '740']; // ratio = 1


// Render
get_header();

echo '<div class="wgl-container', apply_filters('bighearts/container/class', $container_class),'">';
echo '<div class="row', apply_filters('bighearts/row/class', $row_class), '">';

    echo '<div id="main-content" class="wgl_col-', apply_filters('bighearts/column/class', $column), '">';

        while (have_posts()) :
            the_post();

            echo '<div class="row single_team_page">',
                '<div class="wgl_col-12">',
                    (new WGL_Team())->render_wgl_team_item(true, $defaults, $team_image_dims, false),
                '</div>',
                '<div class="wgl_col-12">',
                    the_content( esc_html__('Read more!', 'bighearts-core') ),
                '</div>',
            '</div>';
        endwhile;
        wp_reset_postdata();

    echo '</div>';

    $sb && BigHearts::render_sidebar($sb);

echo '</div>';
echo '</div>';

get_footer();
