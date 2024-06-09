<?php
/**
 * This template can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/templates/wgl-portfolio.php`.
 */
namespace WglAddons\Templates;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\Icons_Manager;
use WglAddons\Includes\{
    Wgl_Loop_Settings,
    Wgl_Elementor_Helper,
    Wgl_Carousel_Settings
};
use BigHearts_Theme_Helper as BigHearts;
use BigHearts_Dynamic_Styles as Styles;

/**
 * WGL Elementor Portfolio Template
 *
 *
 * @package bighearts-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 * @version 1.1.3
 */
class WglPortfolio
{
    private static $instance;
    public static $image_class;
    public $post_count;
    public $item;
    public $masonry;

    public function render($atts, $self = false)
    {
        $this->item = $self;

        extract($atts);

        //* Build Query
        list($query_args) = Wgl_Loop_Settings::buildQuery($atts);

        $query_args['paged'] = get_query_var('paged') ?: 1;
        $query_args['post_type'] = 'portfolio';

        //* Add Query Not In Post in the Related Posts (Metaboxes)
        if (!empty($featured_render)) {
            $query_args['post__not_in'] = [get_the_id()];
        }

        $query_results = new \WP_Query($query_args);

        $atts['post_count'] = $this->post_count = $query_results->post_count;
        $atts['found_posts'] = $query_results->found_posts;
        $atts['query_args'] = $query_args;

        $atts['item_id'] = $item_id = uniqid('portfolio_module_');

        $this->register_css($atts, $item_id);

        //* Metaxobes Related Items
        if (!empty($featured_render)) {
            $portfolio_layout = 'related';
        }
        if (!empty($featured_render) && !empty($mb_pf_carousel_r)) {
            $portfolio_layout = 'carousel';
        }

        if (
            !empty($show_filter)
            || 'masonry2' === $portfolio_layout
            || 'masonry3' === $portfolio_layout
            || 'masonry4' === $portfolio_layout
        ) {
            $this->masonry = $portfolio_layout = 'masonry';
        }

        //* Classes
        $container_classes = '0px' === $grid_gap ? ' no_gap' : '';
        $container_classes .= $add_animation ? ' appear-animation' : '';
        $container_classes .= $add_animation && !empty($appear_animation) ? ' anim-' . $appear_animation : '';

        $out = '<section class="wgl_cpt_section">';
        $out .= '<div class="wgl-portfolio" id="' . esc_attr($item_id) . '">';

        wp_enqueue_script('imagesloaded');
        if ($add_animation) {
            wp_enqueue_script('jquery-appear', get_template_directory_uri() . '/js/jquery.appear.js');
        }
        if ('masonry' === $portfolio_layout) {
            wp_enqueue_script('isotope', WGL_ELEMENTOR_ADDONS_URL . 'assets/js/isotope.pkgd.min.js', ['imagesloaded']);
        }

        if ($show_filter) {
            $filter_class = $portfolio_layout != 'carousel' ? 'isotope-filter' : '';
            $filter_class .= $filter_align ? ' filter-' . $filter_align : '';
            $out .= '<div class="portfolio__filter ' . esc_attr($filter_class) . '">';
            $out .= $this->getCategories($query_args, $query_results);
            $out .= '</div>';
        }

        $style_gap = !empty($grid_gap) ? ' style="margin-right:-' . ((int) $grid_gap / 2) . 'px; margin-left:-' . ((int) $grid_gap / 2) . 'px; margin-bottom:-' . $grid_gap . ';"' : '';

        $out .= '<div class="wgl-portfolio_wrapper">';
        $out .= '<div class="wgl-portfolio_container container-grid row '
            . esc_attr($this->row_class($atts, $portfolio_layout))
            . esc_attr($container_classes) . '" '
            . $style_gap
            . '>';
        $out .= $this->output_loop_query($query_results, $atts);
        $out .= '</div>';
        $out .= '</div>';

        wp_reset_postdata();

        if ('pagination' === $navigation) {
            global $paged;
            if (empty($paged)) {
                $paged = get_query_var('page') ?: 1;
            }

            $out .= BigHearts::pagination($query_results, $nav_align);
        }

        if (
            'load_more' === $navigation
            && ($atts['post_count'] < $atts['found_posts'])
        ) {
            $out .= $this->loadMore($atts, $load_more_text);
        }

        if (
            'infinite' === $navigation
            && ($atts['post_count'] < $atts['found_posts'])
        ) {
            $out .= $this->infinite_more($atts);
        }

        $out .= '</div>';
        $out .= '</section>';

        return $out;
    }

    public function output_loop_query($q, $params)
    {
        extract($params);
        $out = '';
        $count = 0;
        $i = 0;

        switch ($portfolio_layout) {
            default:
            case 'masonry4':
                $max_count = 6;
                break;

            case 'masonry2':
            case 'masonry3':
	            $max_count = 8;
                break;
        }

        //* Metaxobes Related Items
        if (!empty($featured_render)) {
            $portfolio_layout = 'related';
        }
        if (!empty($featured_render) && !empty($mb_pf_carousel_r)) {
            $portfolio_layout = 'carousel';
        }

        $per_page = $q->query['posts_per_page'];

        if ($q->have_posts()) :
            ob_start();
            if (
                'masonry2' === $portfolio_layout
                || 'masonry3' === $portfolio_layout
                || 'masonry4' === $portfolio_layout
            ) {
                echo '<div class="wgl-portfolio-list_item-size" style="width: 25%;"></div>';
            }

            while ($q->have_posts()) :
                $q->the_post();

                if ($count < $max_count) {
                    $count++;
                } else {
                    $count = 1;
                }

                $item_class = $this->grid_class($params, $count);

                switch ($portfolio_layout) {
                    case 'single':
                        $this->wgl_portfolio_single_item($params, $item_class);
                        break;

                    default:
                        $i++;
                        if (
                            'custom_link' === $navigation
                            && 'below_items' === $link_position
                            && 1 === $i
                        ) {
                            $class = $this->grid_class($params, $i, true);
                            $this->wgl_portfolio_item($params, $class, $i, $grid_gap, true);
                        }

                        $this->wgl_portfolio_item($params, $item_class, $count, $grid_gap);

                        if (
                            'custom_link' === $navigation
                            && 'after_items' === $link_position
                            && $i === $per_page
                        ) {
                            $class = $this->grid_class($params, $i, true);
                            $this->wgl_portfolio_item($params, $class, $i, $grid_gap, true);
                        }
                        break;
                }

            endwhile;
            $render = ob_get_clean();

            $out .= 'carousel' === $portfolio_layout ? $this->wgl_portfolio_carousel_item($params, $item_class, $render) : $render;
        endif;

        return $out;
    }

    public function wgl_portfolio_carousel_item($params, $item_class, $items)
    {
        extract($params);
        $extra_class = $arrows_center_mode ? ' arrows_center_mode' : '';
        $extra_class .= $center_info ? ' center_info' : '';

        $options = [
            'slide_to_show' => $posts_per_row,
            'autoplay' => $autoplay,
            'autoplay_speed' => $autoplay_speed,
            'use_pagination' => $use_pagination,
            'pag_type' => $pag_type,
            'pag_offset' => $pag_offset,
            'custom_pag_color' => $custom_pag_color,
            'pag_color' => $pag_color,
            'use_prev_next' => $use_prev_next,
            'infinite' => $c_infinite_loop,
            'slides_to_scroll' => $c_slide_per_single,
            'adaptive_height' => false,
            'center_mode' => $center_mode,
            'variable_width' => $variable_width,
            //* Responsive
            'custom_resp' => $custom_resp,
            'resp_medium_slides' => $resp_medium_slides,
            'resp_tablets_slides' => $resp_tablets_slides,
            'resp_mobile_slides' => $resp_mobile_slides,
            //* Extra
            'extra_class' => $extra_class,
        ];

        $resp_medium && $options['resp_medium'] = $resp_medium;
        $resp_tablets && $options['resp_tablets'] = $resp_tablets;
        $resp_mobile && $options['resp_mobile'] = $resp_mobile;

        ob_start();
        echo Wgl_Carousel_Settings::init($options, $items);

        return ob_get_clean();
    }

    private function register_css($params, $item_id)
    {
        extract($params);

        ob_start();
        //* Fix Gap
        if ((int) $grid_gap == '0') {
            echo "#$item_id .wgl-portfolio-item_image img,
                  #$item_id .inside_image .wgl-portfolio-item_image {
                      border-radius: 0px;
                  }";
        }
        $styles = ob_get_clean();

        $styles && Wgl_Elementor_Helper::enqueue_css($styles);
    }

    private function row_class($params, $pf_layout)
    {
        extract($params);

        switch ($pf_layout) {
            case 'carousel':
                $class = 'carousel';
                self::$image_class = 'carousel-img';
                break;
            case 'related':
                $class = !empty($mb_pf_carousel_r) ? 'carousel' : 'isotope';
                break;
            case 'masonry':
                $class = 'isotope';
                self::$image_class = 'isotope-img';
                break;
            default:
                $class = 'grid';
                break;
        }

        if ($posts_per_row) {
            $class .= ' col-' . $posts_per_row;
        }

        return $class;
    }

    public function grid_class($params, $count, $link = false)
    {
        $class = '';

        switch ($params['portfolio_layout']) {
            case 'masonry2':
                if (1 == $count || 7 == $count) {
                    $class .= 'wgl_col-6';
                } else {
                    $class .= 'wgl_col-3';
                }
                break;

            case 'masonry3':
		        if (1 == $count || 2 == $count || 5 == $count || 6 == $count) {
                    $class .= 'wgl_col-6';
                } else {
                    $class .= 'wgl_col-3';
                }
		        break;

            case 'masonry4':
                if (1 == $count || 6 == $count) {
                    $class .= 'wgl_col-6';
                } else {
                    $class .= 'wgl_col-3';
                }
                break;
        }

        if (!$link) {
            $class .= $this->post_cats_class();
        }

        return $class;
    }

    private function post_cats_links($cat)
    {
        if (!$cat) {
            //* Bailout.
            return;
        }

        $p_cats = wp_get_post_terms(get_the_id(), 'portfolio-category');
        $p_cats_str = $p_cats_links = '';
        if (!empty($p_cats)) {
            $p_cats_links = '<span class="post_cats">';
            for ($i = 0, $count = count($p_cats); $i < $count; $i++) {
                $p_cat_term = $p_cats[$i];
                $p_cat_name = $p_cat_term->name;
                $p_cats_str .= ' ' . $p_cat_name;
                $p_cats_link = get_category_link($p_cat_term->term_id);
                $p_cats_links .= '<a href=' . esc_html($p_cats_link) . ' class="portfolio-category">#' . esc_html($p_cat_name) . '</a>';
            }
            $p_cats_links .= '</span>';
        }

        return $p_cats_links;
    }

    private function post_cats_class()
    {
        $p_cats = wp_get_post_terms(get_the_id(), 'portfolio-category');
        $p_cats_class = '';
        for ($i = 0, $count = count($p_cats); $i < $count; $i++) {
            $p_cat_term = $p_cats[$i];
            $p_cats_class .= ' ' . $p_cat_term->slug;
        }

        return $p_cats_class;
    }

    private function chars_count($cols = null)
    {
        switch ($cols) {
            case '1':
                $number = 300;
                break;
            default:
            case '2':
                $number = 145;
                break;
            case '3':
                $number = 70;
                break;
            case '4':
                $number = 55;
                break;
        }

        return $number;
    }

    private function post_content($params)
    {
        extract($params);

        if (!$show_content) {
            //* Bailout.
            return;
        }

        $post = get_post(get_the_id());

        $chars_count = !empty($content_letter_count) ? $content_letter_count : $this->chars_count($posts_per_row);
        $content = !empty($post->post_excerpt) ? $post->post_excerpt : $post->post_content;
        $content = preg_replace('~\[[^\]]+\]~', '', $content);
        $content = strip_tags($content);
        $content = BigHearts::modifier_character($content, $chars_count, '');

        if ($content) {
            $out = '<div class="wgl-portfolio-item_content">'
                . sprintf('<div class="content">%s</div>', $content)
                . '</div>';
        }

        return $out ?? '';
    }

    public function wgl_portfolio_item(
        $params,
        $class,
        $count,
        $grid_gap,
        $custom_link = false
    ) {
        extract($params);

        $post_meta = $this->post_cats_links($show_meta_categories);

        $wrapper_class = isset($info_position) ? ' ' . $info_position : '';
        $wrapper_class .= 'inside_image' === $info_position ? ' ' . $image_anim . '_animation' : '';
        $wrapper_class .= $gallery_mode ? ' gallery_mode' : '';

        $style_gap = !empty($grid_gap) ? ' style="padding-right:' . ((int) $grid_gap / 2) . 'px; padding-left:' . ((int) $grid_gap / 2) . 'px; padding-bottom:' . $grid_gap . '"' : '';

        $link_params['link_destination'] = $params['link_destination'] ?? '';
        $link_params['link_target'] = $params['link_target'] ?? '';
        $link_params['additional_class'] = ' portfolio_link';
        $link = $this->render_link($link_params);

        echo '<article class="wgl-portfolio-list_item item ', esc_attr($class), '" ', $style_gap, '>';

        if ($custom_link) {
            $this->custom_link_item($params);
        } else {
            echo '<div class="wgl-portfolio-item_wrapper', esc_attr($wrapper_class), '">';
            echo '<div class="wgl-portfolio-item_image">';

            $img_id = get_post_thumbnail_id(get_the_ID());
            $img_url = wp_get_attachment_image_url($img_id, 'full');
            if ($img_url) {
                $img_alt = trim(strip_tags(get_post_meta($img_id, '_wp_attachment_image_alt', true)));
                $img_dims = Wgl_Elementor_Helper::get_image_dimensions(
                    $img_size_array ?: $img_size_string,
                    $img_aspect_ratio ?: ''
                );

                echo self::getImgUrl($params, $img_url, $count, $grid_gap, $img_dims, $img_alt);
            }

            if ('under_image' === $info_position) {
                echo '<div class="overlay"></div>';

                echo $linked_image ? $link : '';
            }

            echo '</div>';

            if ($gallery_mode) {
                echo '<a',
                    ' href="', esc_url($img_url), '"',
                    ' class="overlay swipebox"',
                    ' data-elementor-open-lightbox="yes"',
                    ' data-elementor-lightbox-slideshow="'.esc_attr($params['item_id']).'"',
                    '>',
                    '<i aria-hidden="true" class="flaticon flaticon-search"></i>',
                '</a>';
            } else {
                $this->standard_mode_enabled($params, $link, $post_meta);
            }

            if (
                'under_image' !== $info_position
                && 'sub_layer' !== $image_anim
                && !$gallery_mode
            ) {
                echo '<div class="overlay"></div>';
            }

            if ('sub_layer' === $image_anim && $linked_image) {
                echo $link;
            }

            echo '</div>';
        }

        echo '</article>';
    }

    public function custom_link_item($params)
    {
        extract($params);

        $this->item->add_render_attribute('link', 'class', 'wgl-portfolio_item_link');

        if (!empty($item_link['url'])) {
            $this->item->add_link_attributes('link', $item_link);
        }

        $wrapper_class = ' align_' . $link_align;

        echo '<div class="wgl-portfolio-link_wrapper', esc_attr($wrapper_class), '">',
            '<a ', $this->item->get_render_attribute_string('link'), '>',
            esc_html($load_more_text),
            '</a>',
        '</div>';
    }

    public function render_link($params)
    {
        extract($params);

        $href = $href ?? get_permalink();
        $target = !empty($link_target) ? ' target="_blank"' : '';
        $additional_class = $additional_class ?? '';
        $link_content = $link_content ?? '';

        switch ($link_destination) {
            case 'popup':
                $attachment_url = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
                $link = '<a href="' . $attachment_url . '" class="swipebox' . $additional_class . '" data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="'.esc_attr($params['item_id']).'">'
                    . $link_content
                    . '</a>';
                break;

            default:
            case 'single':
                $link = '<a href="' . esc_url($href) . '"' . $target . ' class="single_link' . $additional_class . '">'
                    . $link_content
                    . '</a>';
                break;

            case 'custom':
                if (
                    class_exists('RWMB_Loader')
                    && rwmb_meta('mb_portfolio_link')
                    && !empty(rwmb_meta('portfolio_custom_url'))
                ) {
                    $href = rwmb_meta('portfolio_custom_url');
                }
                $link = '<a href="' . esc_url($href) . '"' . $target . ' class="custom_link' . $additional_class . '">'
                    . $link_content
                    . '</a>';
                break;
        }

        return $link;
    }

    public function standard_mode_enabled($params, $link, $post_meta)
    {
        extract($params);

        $link_params['link_destination'] = $params['link_destination'] ?? '';
        $link_params['link_target'] = $params['link_target'] ?? '';
        $linked_title = $linked_title ?? '';

        echo '<div class="wgl-portfolio-item_description">';

        if (
            $show_portfolio_title
            || $post_meta
            || $show_content
            || 'font' === $portfolio_icon_type
        ) {
            echo '<div class="portfolio__description">';

            if ('font' === $portfolio_icon_type) {
                $is_new = Icons_Manager::is_migration_allowed();

                if ($is_new) {
                    ob_start();
                    Icons_Manager::render_icon($portfolio_icon, ['aria-hidden' => 'true']);
                    $icon_output = ob_get_clean();
                } else {
                    $icon_output = '<i class="icon ' . esc_attr($portfolio_icon) . '"></i>';
                }
                $link_params['link_content'] = $icon_output;
                echo '<div class="portfolio-item__icon">',
                    ($linked_icon ? $this->render_link($link_params) : $icon_output),
                    '</div>';
            }

            if ($show_portfolio_title) {
                $link_params['link_content'] = get_the_title();

                echo '<div class="portfolio-item__title">',
                    '<h4 class="title">',
                    ($linked_title ? $this->render_link($link_params) : '<span>' . get_the_title() . '</span>'),
                    '</h4>',
                '</div>';
            }

            if ($post_meta) {
                echo '<div class="portfolio__item-meta">', $post_meta, '</div>';
            }

            if ($show_content) {
                echo $this->post_content($params);
            }

            echo '</div>';
        }

        //* Image link
        if (
            $linked_image
            && 'under_image' !== $info_position
            && 'sub_layer' !== $image_anim
        ) {
           echo $link;
        }

        echo '</div>';
    }

    /**
     * @version 1.1.3
     */
    protected function single_post_date()
    {
        $this->hide_all_meta = $this->hide_all_meta ?? BigHearts::get_option( 'portfolio_single_meta' );

        if (
            class_exists( 'RWMB_Loader' )
            && 'default' !== ( $mb_date = rwmb_meta( 'mb_portfolio_single_meta_date' ) )
        ) {
            $date_enabled = (bool) $mb_date;
        }
        $date_enabled = $date_enabled ?? ( $this->hide_all_meta ?: BigHearts::get_option( 'portfolio_single_meta_date' ) );

        if ( ! $date_enabled ) {
            // Bailout.
            return;
        }

        return '<span class="post_date">'
                . '<i class="post_date-icon flaticon-calendar"></i>'
                . get_the_time( 'F' )
                . ' '
                . get_the_time( 'd' )
            . '</span>';
    }

    private function single_post_likes()
    {
        if (
            BigHearts::get_option('portfolio_single_meta_likes')
            && function_exists('wgl_simple_likes')
        ) {
            return wgl_simple_likes()->get_likes_button(get_the_ID());
        }
    }

    private function single_post_author()
    {
        if (BigHearts::get_option('portfolio_single_meta_author')) {
            return '<span class="post_author">'
                . esc_html__('by ', 'bighearts-core')
                . '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">'
                . esc_html(get_the_author_meta('display_name'))
                . '</a>'
                . '</span>';
        }
    }

    private function single_post_comments()
    {
        if (BigHearts::get_option('portfolio_single_meta_comments')) {
            $comments_num = get_comments_number(get_the_ID());

            return '<span class="comments_post">'
                . '<a href="' . esc_url(get_comments_link()) . '">'
                . esc_html($comments_num)
                . ' '
                . esc_html(_n('Comment', 'Comments', $comments_num, 'bighearts-core'))
                . '</a>'
                . '</span>';
        }
    }

    /**
     * @version 1.1.3
     */
    protected function single_post_cats()
    {
        $this->hide_all_meta = $this->hide_all_meta ?? BigHearts::get_option( 'portfolio_single_meta' );

        if (
            class_exists( 'RWMB_Loader' )
            && 'default' !== ( $mb_categories = rwmb_meta( 'mb_portfolio_single_meta_categories' ) )
        ) {
            $cats_enabled = (bool) $mb_categories;
        }
        $cats_enabled = $cats_enabled ?? ( $this->hide_all_meta ?: BigHearts::get_option( 'portfolio_single_meta_categories' ) );

        if ( ! $cats_enabled ) {
            // Bailout, if disabled.
            return;
        }

        $categories_arr = wp_get_post_terms( get_the_id(), 'portfolio-category' );

        if (
            is_wp_error( $categories_arr )
            || ! $categories_count = count( $categories_arr )
        ) {
            // Bailout, if nothing to render.
            return;
        }

        $categories_html = '';
        for ( $i = 0; $i < $categories_count; $i++ ) {
            $term = $categories_arr[ $i ];
            $link = get_category_link( $term->term_id );

            $categories_html .= '<span>'
                    . '<a'
                        . ' href="' . esc_url( $link ) . '"'
                        . ' class="portfolio-category"'
                        . '>'
                        . esc_html( $term->name )
                    . '</a>'
                . '</span>';
        }

        return '<span class="post_categories">' . $categories_html . '</span>';
    }

    private function single_portfolio_info()
    {
        $mb_info = rwmb_meta('mb_portfolio_info_items');

        if (!$mb_info) {
            //* Bailout.
            return;
        }

        $meta_info = '';

        for ($i = 0, $count = count($mb_info); $i < $count; $i++) {
            $info = $mb_info[$i];
            $name = !empty($info['name']) ? $info['name'] : '';
            $description = !empty($info['description']) ? $info['description'] : '';
            $link = !empty($info['link']) ? $info['link'] : '';

            if ($name && $description) {
                $meta_info .= '<div class="portfolio__custom-meta">';
                $meta_info .= '<h5>' . $name . '</h5>';
                $meta_info .= $link ? '<a href="' . esc_url($link) . '">' : '';
                $meta_info .= '<span>' . $description . '</span>';
                $meta_info .= $link ? '</a>' : '';
                $meta_info .= '</div>';
            }
        }

        return $meta_info;
    }

    /**
     * @version 1.1.3
     */
    public function wgl_portfolio_single_item($parameters, $item_class = '')
    {
        //* MetaBoxes
        $p_id = get_the_ID();
        $featured_image = $mb_hide_all_meta = $mb_show_title = true;
        $featured_image_replace = false;
        $img_data = wp_get_attachment_image_src(get_post_thumbnail_id($p_id), 'full');
        $img_dims = [
            'width' => $img_data[1] ?? '1170',
            'height' => $img_data[2] ?? '650'
        ];

        if ( class_exists( 'RWMB_Loader' ) ) {
            $featured_image = BigHearts::get_mb_option('portfolio_featured_image_type', 'mb_portfolio_featured_image_conditional', 'custom');
	        if ('replace' === $featured_image) {
                $featured_image_replace = BigHearts::get_mb_option('portfolio_featured_image_replace', 'mb_portfolio_featured_image_conditional', 'custom');
            }

            $mb_show_title = rwmb_meta('mb_portfolio_title');

            $mb_hide_all_meta = BigHearts::get_option('portfolio_single_meta');
        }

        $post_date = $this->single_post_date();
        $post_comments = $this->single_post_comments();
        $post_cats = $this->single_post_cats();
        $post_author = $this->single_post_author();
        $portfolio_info = $this->single_portfolio_info();

        $meta_data = $post_date . $post_author . $post_comments;

        $image_id = 0;
        if (
            $featured_image_replace
            && 'custom' === rwmb_meta('mb_portfolio_featured_image_conditional')
        ) {
            $image_id = array_values($featured_image_replace)[0]['ID'] ?? 0;
        }
        $image_id = $image_id ?: get_post_thumbnail_id($p_id);

        $attachment_url = wp_get_attachment_url($image_id);

        //* Featured image
        ob_start();
        if ('off' !== $featured_image) {
            echo '<div class="wgl-portfolio-item_image">',
                self::getImgUrl($parameters, $attachment_url, false, false, $img_dims),
            '</div>';
        }
        $p_featured_image = ob_get_clean();

        //* Title
        $p_title = $mb_show_title ? '<h1 class="portfolio-item__title">' . get_the_title() . '</h1>' : '';

        //* Meta
        $p_meta = '';
        if (!$mb_hide_all_meta && $meta_data) {
            $p_meta = '<div class="meta-data">'
                . $meta_data
                . '</div>';
        }

        //* Custom meta fields
        $p_annotation = '';
        if ($portfolio_info) {
            $p_annotation = '<div class="wgl-portfolio__item-info">'
                . '<div class="portfolio__custom-annotation">' . $portfolio_info . '</div>'
                . '</div>';
        }

        $content = apply_filters('the_content', get_post_field('post_content', get_the_id()));

        $layout_sequence = '';
        switch (BigHearts::get_mb_option('portfolio_single_type_layout', 'mb_portfolio_post_conditional', 'custom')) {
            case '1':
                $layout_sequence .= $post_cats;
                $layout_sequence .= $p_meta;
                $layout_sequence .= $p_title;
                $layout_sequence .= $p_annotation;
                $layout_sequence .= $p_featured_image;
                break;
            default:
            case '2':
                $layout_sequence .= $p_featured_image;
                $layout_sequence .= $post_cats;
                $layout_sequence .= $p_meta;
                $layout_sequence .= $p_title;
                $layout_sequence .= $p_annotation;
                break;
        }

        //* Render
        echo '<article class="wgl-portfolio-single_item single_meta">';
        echo '<div class="wgl-portfolio-item_wrapper">';
        echo '<div class="portfolio-item__meta-wrap">',
            $layout_sequence,
        '</div>';

        if ($content) {
            echo '<div class="wgl-portfolio-item_content">',
                '<div class="content">',
                '<div class="wrapper">',
                $content,
                '</div>',
                '</div>',
            '</div>';
        }

        $tags_html = $this->get_post_tags();
        $shares_html = $this->get_post_socials();
        $likes_html = $this->single_post_likes();

        if (
            $tags_html
            || $shares_html
            || $likes_html
        ) {
            echo '<div class="single_post_info post_info-portfolio">',
                $tags_html,
                $shares_html,
                $likes_html,
            '</div>';
        }

        echo '<div class="post_info-divider"></div>';

        echo '</div>';
        echo '</article>';
    }

    /**
     * @since 1.1.3
     */
    protected function get_post_tags()
    {
        if (
            class_exists( 'RWMB_Loader' )
            && 'default' !== ( $mb_tags = rwmb_meta( 'mb_portfolio_above_content_cats' ) )
        ) {
            $tags_enabled = (bool) $mb_tags;
        }
        $tags_enabled = $tags_enabled ?? BigHearts::get_option( 'portfolio_above_content_cats' );

        if ( ! $tags_enabled ) {
            // Bailout.
            return;
        }

        $before = '<div class="tagcloud-wrapper"><div class="tagcloud">';
        $after = '</div></div>';
        $sep = ' ';

        return $this->getTags( $before, $sep, $after );
    }

    /**
     * @since 1.1.3
     */
    protected function get_post_socials()
    {
        if (
            class_exists( 'RWMB_Loader' )
            && 'default' !== ( $mb_shares = rwmb_meta( 'mb_portfolio_above_content_share' ) )
        ) {
            $shares_enabled = (bool) $mb_shares;
        }
        $shares_enabled = $shares_enabled ?? BigHearts::get_option( 'portfolio_above_content_share' );

        if (
            ! $shares_enabled
            || ! function_exists( 'wgl_theme_helper' )
        ) {
            // Bailout.
            return;
        }

        ob_start();
            wgl_theme_helper()->render_post_list_share();
        return ob_get_clean();
    }

    /**
     * @since 1.0.0
     * @version 1.0.5
     */
    static public function getImgUrl(
        $params,
        $url,
        $count,
        $grid_gap,
        $dims,
        $alt = ''
    ) {
        if (!$url) {
            return '';
        }

        $dynamic_styles = function_exists('bighearts_dynamic_styles')
            ? bighearts_dynamic_styles()
            : (new Styles());

        $elementor_container_width = (int) $dynamic_styles->get_elementor_container_width();

	    /* 30 - Default Elementor Columns Gap */
	    $full = apply_filters( 'elementor/templates/wgl-portfolio/img_size', $elementor_container_width - 30 ) - (int) $grid_gap;
        $half = ($full / 2) - ((int) $grid_gap );

        if ('masonry2' === $params['portfolio_layout']) {
            switch ($count) {
                case '2':
                case '6':
	                $dims = ['width' => $half, 'height' => $full];
	            break;
                default:
                    $dims = ['width' => $full, 'height' => $full];
            }
        } elseif ('masonry3' === $params['portfolio_layout']) {
            switch ($count) {
                case '2':
                case '5':
                    $dims = ['width' => $full, 'height' => $half];
                    break;
                default:
                    $dims = ['width' => $full, 'height' => $full];
            }
        } elseif ('masonry4' === $params['portfolio_layout']) {
            switch ($count) {
                case '1':
                case '6':
                    $dims = ['width' => $full, 'height' => $half];
                    break;
                default:
                    $dims = ['width' => $full, 'height' => $full];
            }
        }

        $src = aq_resize($url, $dims['width'], $dims['height'], true, true, true) ?: $url;

        return '<img
            '.(!empty(self::$image_class) ? ' class="' . apply_filters('bighearts/image/class', self::$image_class . ' pf-img').'"' : '').
            'src="' . esc_url($src) . '" alt="' . $alt . '">';
    }

    public function getTags(
        $before = null,
        $sep = ', ',
        $after = ''
    ) {
        if (is_null($before)) {
            $before = esc_html__('Tags: ', 'bighearts-core');
        }

        $the_tags = $this->get_the_tag_list($before, $sep, $after);

        return !is_wp_error($the_tags) ? $the_tags : false;
    }

    /**
     * Filters the tags list for a given post.
     */
    private function get_the_tag_list(
        $before = '',
        $sep = '',
        $after = '',
        $id = 0
    ) {
        global $post;

        return apply_filters(
            'the_tags',
            get_the_term_list(
                $post->ID,
                'portfolio_tag',
                $before,
                $sep,
                $after
            ),
            $before,
            $sep,
            $after,
            $post->ID
        );
    }

    public function getCategories($params, $query)
    {
        $data_category = $params['tax_query'] ?? [];
        $include = $exclude = [];

        if (!is_tax() && !empty($data_category[0])) {
            if ('IN' === $data_category[0]['operator']) {
                foreach ($data_category[0]['terms'] as $value) {
                    $idObj = get_term_by('slug', $value, 'portfolio-category');
                    $id_list[] = $idObj->term_id;
                }

                $include = implode(',', $id_list);
            } elseif ('NOT IN' === $data_category[0]['operator']) {
                foreach ($data_category[0]['terms'] as $value) {
                    $idObj = get_term_by('slug', $value, 'portfolio-category');
                    $id_list[] = $idObj->term_id;
                }

                $exclude = implode(',', $id_list);
            }
        }

        $cats = get_terms([
            'taxonomy' => 'portfolio-category',
            'include' => $include,
            'exclude' => $exclude,
            'hide_empty' => true
        ]);

        $out = '<a href="#" data-filter=".item" class="active">' . esc_html__('All works', 'bighearts-core') . '<span class="number_filter"></span></a>';
        foreach ($cats as $cat) if ($cat->count > 0) {
            $out .= '<a href="' . get_term_link($cat->term_id, 'portfolio-category') . '" data-filter=".' . $cat->slug . '">';
            $out .= $cat->name;
            $out .= '<span class="number_filter"></span>';
            $out .= '</a>';
        }

        return $out;
    }

    public function loadMore($params, $load_more_text)
    {
        if (empty($load_more_text)) {
            return;
        }

        $uniq = uniqid();
        $ajax_data_str = htmlspecialchars(json_encode($params), ENT_QUOTES, 'UTF-8');

        return '<div class="clear"></div>'
            . '<div class="load_more_wrapper">'
            . '<div class="button_wrapper">'
            . '<a href="#" class="load_more_item"><span>' . $load_more_text . '</span></a>'
            . '</div>'
            . '<form class="posts_grid_ajax">'
            . "<input type='hidden' class='ajax_data' name='{$uniq}_ajax_data' value='$ajax_data_str' />"
            . '</form>'
            . '</div>';
    }

    public function infinite_more($params)
    {
        $uniq = uniqid();
        wp_enqueue_script('waypoints');
        $ajax_data_str = htmlspecialchars(json_encode($params), ENT_QUOTES, 'UTF-8');

        return '<div class="clear"></div>'
            . '<div class="text-center load_more_wrapper">'
            . '<div class="infinity_item">'
            . '<span class="wgl-ellipsis">'
            . '<span></span><span></span>'
            . '<span></span><span></span>'
            . '</span>'
            . '</div>'
            . '<form class="posts_grid_ajax">'
            . "<input type='hidden' class='ajax_data' name='".esc_attr($uniq)."_ajax_data' value='".esc_attr($ajax_data_str)."' />"
            . '</form>'
            . '</div>';
    }

    public static function get_instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
