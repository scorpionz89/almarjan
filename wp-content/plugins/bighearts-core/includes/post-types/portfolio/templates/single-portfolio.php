<?php

defined('ABSPATH') || exit;

use WglAddons\Templates\WglPortfolio;
use BigHearts_Theme_Helper as BigHearts;

/**
* Template for Portfolio CPT single page
*
* @package bighearts-core\includes\post-types
* @author WebGeniusLab <webgeniuslab@gmail.com>
* @since 1.0.0
*/

get_header();

$sb = BigHearts::get_sidebar_data('portfolio_single');
$container_class = $sb['container_class'] ?? '';
$row_class = $sb['row_class'] ?? '';
$column = $sb['column'] ?? '12';

$defaults = [
    'posts_per_row' => '1',
    'portfolio_layout' => '',
    'portfolio_icon_pack' => '',
];


echo '<div class="wgl-portfolio-single_wrapper">';
echo '<div class="wgl-container single_portfolio', apply_filters('bighearts/container/class', $container_class), '">';
echo '<div class="row', apply_filters('bighearts/row/class', $row_class), '">';
    echo '<div id="main-content" class="wgl_col-', apply_filters('bighearts/column/class', $column), '">';

        while (have_posts()) :
            the_post();
            echo (new WglPortfolio())->wgl_portfolio_single_item($defaults, $item_class = '');
        endwhile;
        wp_reset_postdata();

        //* Navigation
        get_template_part('templates/post/post-navigation');

        //* ↓ Related
        $related_switch = BigHearts::get_option('portfolio_related_switch');
        if (class_exists('RWMB_Loader')) {
            $mb_related_switch = rwmb_meta('mb_portfolio_related_switch');
            if ('on' === $mb_related_switch) {
                $related_switch = true;
            } elseif ('off' === $mb_related_switch) {
                $related_switch = false;
            }
        }

        if (
            $related_switch
            && class_exists('BigHearts_Core')
            && class_exists('Elementor\Plugin')
        ) {
            $mb_pf_cat_r = [];
            if (class_exists('RWMB_Loader')) {
                $mb_pf_cat_r = get_post_meta(get_the_id(), 'mb_pf_cat_r'); // store terms’ IDs in the post meta and doesn’t set post terms.
            }

            $cats = get_the_terms(get_the_id(), 'portfolio-category') ?: [];
            $cat_slugs = [];
            foreach ($cats as $cat) {
                $cat_slugs[] = 'portfolio-category:' . $cat->slug;
            }

            if (!empty($mb_pf_cat_r[0])) {
                $cat_slugs = [];
                $list = get_terms('portfolio-category', ['include' => $mb_pf_cat_r[0]]);
                foreach ($list as $value) {
                    $cat_slugs[] = 'portfolio-category:' . $value->slug;
                }
            }

            $carousel_layout = BigHearts::get_mb_option('pf_carousel_r', 'mb_portfolio_related_switch', 'on');
            $columns_amount = BigHearts::get_mb_option('pf_column_r', 'mb_portfolio_related_switch', 'on');
            $posts_number = BigHearts::get_mb_option('pf_number_r', 'mb_portfolio_related_switch', 'on') ?: '12';

            $related_atts = [
                'portfolio_layout' => 'related',
                'image_anim' => 'sub_layer',
                'link_destination' => 'single',
                'gallery_mode' => false,
                'linked_title' => 'yes',
                'linked_image' => 'yes',
                'add_animation' => '',
                'show_filter' => '',
                'info_position' => 'inside_image',
                'show_portfolio_title' => 'true',
                'show_meta_categories' => 'true',
                'show_content' => '',
                'grid_gap' => '30px',
                'featured_render' => '1',
                'items_load' => $columns_amount,
                'img_size_string' => '740x740',
                'img_size_array' => '',
                'img_aspect_ratio' => '',
                'portfolio_icon_type' => '',
                // Carousel
                'autoplay' => true,
                'autoplay_speed' => '5000',
                'c_infinite_loop' => true,
                'c_slide_per_single' => 1,
                'mb_pf_carousel_r' => $carousel_layout,
                'posts_per_row' => $columns_amount,
                'use_pagination' => false,
                'arrows_center_mode' => '',
                'center_info' => '',
                'use_prev_next' => '',
                'center_mode' => '',
                'variable_width' => '',
                'navigation' => '',
                'pag_type' => 'circle',
                'pag_offset' => '',
                'pag_color' => '',
                'custom_resp' => true,
                'resp_medium' => '',
                'custom_pag_color' => '',
                'resp_tablets_slides' => '',
                'resp_tablets' => '',
                'resp_medium_slides' => '',
                'resp_mobile' => '768',
                'resp_mobile_slides'=> '1',
                // Query
                'number_of_posts' => $posts_number,
                'order_by' => 'menu_order',
                'post_type' => 'portfolio',
                'taxonomies' => $cat_slugs,
            ];

            $carousel_layout || wp_enqueue_script('isotope');

            $related_posts = new WglPortfolio();
            $featured_post = $related_posts->render($related_atts);

            if ($related_posts->post_count > 0) {
                echo '<section class="related_portfolio">';

                    $related_module_title = BigHearts::get_mb_option('pf_title_r', 'mb_portfolio_related_switch', 'on');
                    if (!empty($related_module_title)) {
                        echo '<div class="bighearts_module_title">',
                            '<h4>',
                                esc_html($related_module_title),
                            '</h4>',
                        '</div>';
                    }

                    echo $featured_post;

                echo '</section>';
            }
        }
        //* ↑ related

        //* Comments
        if (comments_open() || get_comments_number()) {
            echo '<div class="row">';
            echo '<div class="wgl_col-12">';
                comments_template('', true);
            echo '</div>';
            echo '</div>';
        }

    echo '</div>';

    $sb && BigHearts::render_sidebar($sb);

echo '</div>';
echo '</div>';
echo '</div>';


get_footer();
