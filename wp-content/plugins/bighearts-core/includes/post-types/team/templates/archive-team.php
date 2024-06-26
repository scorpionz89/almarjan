<?php
/**
* Template for Team CPT archive page
*
* @package bighearts-core\includes\post-types\team
* @author WebGeniusLab <webgeniuslab@gmail.com>
* @since 1.0.0
*/

use WglAddons\Templates\WGL_Team;

$defaults = [
    'posts_per_line' => '4',
    'grid_gap' => '30',
    'hide_title' => '',
    'single_link_heading' => true,
    'hide_soc_icons' => '',
    'hide_department' => '',
    'hide_highlited_info' => '',
    'hide_signature' => '',
    'hide_content' => true,
    'letter_count' => '100',
    'single_link_wrapper' => true,
    // Query
    'post_type' => 'team',
    'number_of_posts' => 'all',
    'order_by' => 'date',
];

extract($defaults);

$style_gap = ($grid_gap != '0') ? ' style="margin-right: -' . esc_attr($grid_gap / 2) . 'px; margin-left: -' . esc_attr($grid_gap / 2) . 'px;"' : '';

$team_classes = ' team-col_' . $posts_per_line;
$team_classes .= ' aleft';

// Render
get_header();

echo '<div class="wgl-container">',
    '<div id="main-content">',
        '<div class="wgl_module_team', esc_attr($team_classes), '">',
            '<div class="team-items_wrap socials-official-idle socials-official-hover"', $style_gap, '>',
                (new WGL_Team())->render_wgl_team($defaults),
            '</div>',
        '</div>',
    '</div>',
'</div>';

get_footer();
