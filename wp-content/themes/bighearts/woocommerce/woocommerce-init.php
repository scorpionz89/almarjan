<?php

defined('ABSPATH') || exit;

use WglAddons\Includes\Wgl_Elementor_Helper;
use BigHearts_Theme_Helper as BigHearts;

if (!class_exists('BigHearts_Woocoommerce') ) {
    /**
     * BigHearts Woocommerce
     *
     *
     * @package bighearts\woocoomerce
     * @author WebGeniusLab <webgeniuslab@gmail.com>
     * @since 1.0.0
     */
    class BigHearts_Woocoommerce
    {
        private $row_class;
        private $container_class;
        private $column;
        private $content;

        public function __construct()
        {
            add_action('after_setup_theme', [$this, 'setup']);
            add_action('woocommerce_init', [$this, 'init']);
            add_filter('woocommerce_show_page_title', '__return_false' );
        }

        public function setup()
        {
            // Declare WooCommerce support.
            add_theme_support(
                'woocommerce',
                apply_filters(
                    'bighearts_woocommerce_args',
                    [
                        'single_image_width' => 1080,
                        'thumbnail_image_width' => 540,
                        'gallery_thumbnail_image_width' => 240,
                        'product_grid' => [
                            'default_columns' => (int) BigHearts::get_option('shop_column'),
                            'default_rows' => 4,
                            'min_columns' => 1,
                            'max_columns' => 6,
                            'min_rows' => 1,
                        ],
                    ]
                )
            );

            add_theme_support('wc-product-gallery-zoom');
            add_theme_support('wc-product-gallery-lightbox');
            add_theme_support('wc-product-gallery-slider');
            // Declare support for title theme feature.
            add_theme_support('title-tag');

            // Declare support for selective refreshing of widgets.
            add_theme_support('customize-selective-refresh-widgets');
        }

        public function init ()
        {
            remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
            remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
            remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
            remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
            remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
            remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
            remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
            remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
            remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
            remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
            remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
            remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
            remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

            add_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 10);
            add_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 20);

            // Page Template
            add_action('woocommerce_before_main_content', [$this, 'wgl_page_template_open'], 10);

            // ↓ Wrapper Sorting
            add_action('woocommerce_before_shop_loop', [$this, 'wgl_sorting_wrapper_open'], 9);
            add_action('woocommerce_before_shop_loop', [$this, 'wgl_sorting_wrapper_close'], 31);
            // ↑ wrapper sorting

            // ↓ Loop
            add_action('woocommerce_shop_loop_item_title', [$this, 'template_loop_product_open'], 5);
            add_action('woocommerce_after_shop_loop_item', [$this, 'template_loop_product_close'], 15);

            add_action('woocommerce_shop_loop_item_title', [$this, 'template_loop_product_title'], 10 );
            add_filter('loop_shop_per_page', [$this, 'loop_products_per_page'], 20 );
            add_action('woocommerce_before_shop_loop_item_title', [$this, 'woocommerce_template_loop_product_thumbnail' ], 10);
            // ↑ loop

            // Single
            add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 55 );

            // ↓ Widgets
            add_action('woocommerce_before_mini_cart', [$this, 'minicart_wrapper_open']);
            add_action('woocommerce_after_mini_cart', [$this, 'minicart_wrapper_close']);
            add_action('wp_ajax_woocommerce_remove_from_cart', [$this, 'ajax_remove_from_cart' ], 1000);
            add_action('wp_ajax_nopriv_woocommerce_remove_from_cart', [$this, 'ajax_remove_from_cart' ], 1000);

            if (defined('WC_VERSION') && version_compare(WC_VERSION, '3.0', '<')) {
                add_filter('add_to_cart_fragments', [$this, 'header_add_to_cart_fragment']);
            } else {
                add_filter('woocommerce_add_to_cart_fragments', [$this, 'header_add_to_cart_fragment']);
            }
            // ↑ widgets

            add_filter('woocommerce_product_thumbnails_columns', [$this, 'thumbnail_columns']);
            add_filter('woocommerce_output_related_products_args', [$this, 'related_products_args']);

            // Legacy WooCommerce columns filter.
            if (defined('WC_VERSION') && version_compare(WC_VERSION, '3.3', '<')) {
                add_filter('loop_shop_columns', [$this, 'loop_columns']);
            }

            // tabs remove heading filter
            add_filter('woocommerce_product_description_heading', '__return_false' );

            add_action('woocommerce_before_shop_loop', [$this, 'wgl_product_columns_wrapper_open'], 40);
            add_action('woocommerce_after_shop_loop', [$this, 'wgl_product_columns_wrapper_close'], 40);

            add_filter('comment_form_fields', [$this, 'wgl_comments_fiels']);
            add_filter('woocommerce_product_review_comment_form_args', [$this, 'wgl_filter_comments'], 10, 1);
            add_filter('woocommerce_product_review_list_args', [$this, 'wgl_filter_reviews'], 10, 1);
            add_filter('woocommerce_review_gravatar_size', [$this, 'wgl_review_gravatar_size'], 10, 1);

            add_filter('woocommerce_cart_item_thumbnail', [$this, 'wgl_image_thumbnails'], 10, 3);

            // Filter pagination
            add_filter('woocommerce_pagination_args', [$this, 'wgl_filter_pagination']);

            // ↓ Cart
            add_action('woocommerce_before_cart_totals', [$this, 'wgl_cart_totals_line'], 20);
            remove_action('woocommerce_cart_is_empty', 'wc_empty_cart_message', 10);
            add_action('woocommerce_cart_is_empty', [$this, 'wgl_empty_cart_message'], 10);
        }

        /** WGL Reviews filter */
        function wgl_filter_reviews($array)
        {
            return [ 'callback' => [ $this, 'wgl_templates_reviews' ] ];
        }

        public function wgl_templates_reviews($comment, $args, $depth)
        {
            $GLOBALS['comment'] = $comment;
            ?>
            <li <?php comment_class('comment'); ?> id="li-comment-<?php comment_ID() ?>">

                <div id="comment-<?php comment_ID(); ?>" class="stand_comment">
                    <div class="thiscommentbody">
                        <div class="commentava">
                            <?php
                            /**
                             * The woocommerce_review_before hook
                             *
                             * @hooked woocommerce_review_display_gravatar - 10
                             */
                            do_action('woocommerce_review_before', $comment);
                            ?>
                        </div>
                        <div class="comment_info">
                            <div class="comment_author_says">
                            <?php
                                /**
                                 * The woocommerce_review_meta hook.
                                 *
                                 * @hooked woocommerce_review_display_meta - 20
                                 * @hooked WC_Structured_Data::generate_review_data() - 20
                                 */
                                $this->review_comments_meta_info($comment);
                            ?>
                            </div>
                        </div>
                        <div class="comment_content">
                            <?php

                            do_action('woocommerce_review_before_comment_text', $comment);

                            /**
                             * The woocommerce_review_comment_text hook
                             *
                             * @hooked woocommerce_review_display_comment_text - 10
                             */
                            do_action('woocommerce_review_comment_text', $comment);

                            do_action('woocommerce_review_after_comment_text', $comment); ?>

                        </div>
                    </div>
                </div>
            <?php
        }

        public function wgl_review_gravatar_size()
        {
            return 120;
        }

        function review_comments_meta_info($comment)
        {
            global $comment;

            $verified = function_exists('wc_review_is_from_verified_owner') ? wc_review_is_from_verified_owner( $comment->comment_ID ) : '';

            if ('0' === $comment->comment_approved) { ?>
                <em class="woocommerce-review__awaiting-approval">
                    <?php esc_html_e('Your review is awaiting approval', 'bighearts'); ?>
                </em>

            <?php } else { ?>
                <div class="comments_author">
                    <?php comment_author(); ?>

                    <div class="raiting-meta-data">
                        <?php
                        /**
                        * The woocommerce_review_before_comment_meta hook.
                        *
                        * @hooked woocommerce_review_display_rating - 10
                        */
                        do_action('woocommerce_review_before_comment_meta', $comment);
                        ?>
                    </div>
                </div>

                <?php
                if ('yes' === get_option( 'woocommerce_review_rating_verification_label' ) && $verified) {
                    echo '<em class="woocommerce-review__verified verified">(' . esc_attr__('verified owner', 'bighearts') . ')</em> ';
                }
                ?>
                <div class="meta-data">
                    <time class="woocommerce-review__published-date" datetime="<?php echo esc_attr( get_comment_date('c') ); ?>"><?php echo esc_html( get_comment_date( wc_date_format() ) ); ?></time>
                </div>

            <?php
            }
        }

        /**/
        /* WGL Comments Form Filter */
        /**/
        function wgl_filter_comments($comment_form)
        {
            $commenter = wp_get_current_commenter();

            $comment_form = [
                'title_reply' => have_comments() ? esc_html__('Add a review', 'bighearts') : sprintf( esc_html__('Be the first to review &ldquo;%s&rdquo;', 'bighearts'), get_the_title() ),
                'title_reply_to' => esc_html__( 'Leave a Reply to %s', 'bighearts' ),
                'title_reply_before' => '<span id="reply-title" class="comment-reply-title">',
                'title_reply_after' => '</span>',
                'comment_notes_after' => '',
                'fields' => [
                    'author' => '<p class="comment-form-author">' . '<label for="author"></label> ' .
                    '<input id="author" name="author" placeholder="'.esc_attr__( 'Name', 'bighearts' ).'" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" required /></p>',
                    'email' => '<p class="comment-form-email"><label for="email"></label> ' .
                    '<input id="email" name="email" placeholder="'. esc_attr__( 'Email', 'bighearts' ).'" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" required /></p>',
                ],
                'label_submit' => esc_html__('Submit', 'bighearts'),
                'logged_in_as' => '',
                'comment_field' => '',
            ];

            if ($account_page_url = wc_get_page_permalink('myaccount')) {
                $kses_allowed_html = [
                    'a' => ['href' => true],
                ];
                $comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( wp_kses( __( 'You must be <a href="%s">logged in</a> to post a review.', 'bighearts' ), $kses_allowed_html), esc_url( $account_page_url ) ) . '</p>';
            }

            if (get_option('woocommerce_enable_review_rating') === 'yes') {
                $comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__('Your rating', 'bighearts') . '</label><select name="rating" id="rating" required>
                <option value="">' . esc_html__('Rate&hellip;', 'bighearts') . '</option>
                <option value="5">' . esc_html__('Perfect', 'bighearts') . '</option>
                <option value="4">' . esc_html__('Good', 'bighearts') . '</option>
                <option value="3">' . esc_html__('Average', 'bighearts') . '</option>
                <option value="2">' . esc_html__('Not that bad', 'bighearts') . '</option>
                <option value="1">' . esc_html__('Very poor', 'bighearts') . '</option>
                </select></div>';
            }

            $comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment"></label><textarea id="comment" name="comment" cols="45" rows="8" placeholder="'.esc_attr__('Your review', 'bighearts').'" required></textarea></p>';

            return $comment_form;
        }

        /**
        * Comments Field Reorder
        */
        function wgl_comments_fiels($fields)
        {
            if (is_product()) {
                $comment_field = $fields['comment'];
                unset($fields['comment']);
                $fields['comment'] = $comment_field;
            }

            return $fields;
        }

        /** LOOP */
        public function loop_products_per_page()
        {
            return (int) BigHearts::get_option('shop_products_per_page');
        }

        /** WIDGETS */
        public function ajax_remove_from_cart()
        {
            global $woocommerce;
            $woocommerce->cart->set_quantity( $_POST['remove_item'], 0 );

            $ver = explode('.', WC_VERSION);

            if ($ver[1] == 1 && $ver[2] >= 2 ) :
                $wc_ajax = new WC_AJAX();
                $wc_ajax->get_refreshed_fragments();
            else :
                woocommerce_get_refreshed_fragments();
            endif;

            die();
        }

        public function header_add_to_cart_fragment($fragments)
        {
            ob_start();
            echo '<span class="woo_mini-count flaticon-basket">',
                WC()->cart->cart_contents_count > 0 ? '<span>' . esc_html(WC()->cart->cart_contents_count) .'</span>' : '',
            '</span>';
            $fragments['.woo_mini-count'] = ob_get_clean();

            ob_start();
            woocommerce_mini_cart();
            $fragments['div.woo_mini_cart'] = ob_get_clean();

            return $fragments;
        }

        public function minicart_wrapper_open()
        {
            echo '<div class="woo_mini_cart">';
        }

        public function minicart_wrapper_close()
        {
            echo '</div>';
        }
        /** WIDGETS */

        public function woocommerce_template_loop_product_thumbnail($widget_image_size = [])
        {
            global $product;

            $sale_banner = $secondary_image = '';
            $permalink = get_the_permalink();

            // Sale Product
            ob_start();
            woocommerce_show_product_loop_sale_flash();
            $sale = ob_get_clean();

            // Add To cart product
            ob_start();
            woocommerce_template_loop_add_to_cart();
            $add_to_cart = ob_get_clean();

            if (method_exists($product, 'get_gallery_image_ids')) {
                $attachment_ids = $product->get_gallery_image_ids();

                if (
                    $attachment_ids
                    && isset($attachment_ids['0'])
                ) {
                    $secondary_image_id = $attachment_ids['0'];
                    $secondary_image = wp_get_attachment_image($secondary_image_id, apply_filters('shop_catalog', 'shop_catalog'));
                }
            }
            if ($sale) {
                $sale_banner = '<div class="woo_banner_wrapper">'
                    . '<div class="woo_banner">'
                        . '<div class="woo_banner_text">'
                            . $sale
                        . '</div>'
                    . '</div>'
                . '</div>';
            }

            echo '<div class="woo_product_image shop_media">';
                echo '<div class="picture ', (empty($secondary_image) ? ' no_effects' : ''), '">';
                    echo !empty($sale_banner) ? $sale_banner : '';
                    if (function_exists('woocommerce_get_product_thumbnail')) {
                        echo '<a class="woo_post-link" href=' . esc_url($permalink) . '>';
                            if (!empty($widget_image_size)){
                                echo BigHearts::render_html($this->widget_thumbnail($widget_image_size));
                            } else {
                                echo woocommerce_get_product_thumbnail().
                                $secondary_image ?: "";
                            }
                        echo '</a>';
                    }
                    echo !empty($add_to_cart) ? $add_to_cart : '';
                echo '</div>';
            echo '</div>';
        }

        public function widget_thumbnail($widget_image_size)
        {
            global $product;
            $featured_image_sec = '';

            // Main Image
            $thumb_id = get_post_thumbnail_id(get_the_ID());
            $image_full_size = wp_get_attachment_image_src($thumb_id, 'full');
            $attachment_url = !empty($image_full_size[0]) ? $image_full_size[0] : '';
            $thumb_alt = trim(strip_tags(get_post_meta($thumb_id, '_wp_attachment_image_alt', true)));
            $image_dims = Wgl_Elementor_Helper::get_image_dimensions(
                ('custom' == $widget_image_size['img_size_string'] ? $widget_image_size['img_size_array'] : $widget_image_size['img_size_string']),
                $widget_image_size['img_aspect_ratio']
            );
            if (null == $image_dims) {
                return;
            }
            $wgl_featured_image_url = aq_resize($attachment_url, $image_dims['width'], $image_dims['height'], true, true, true);

            // Second Image
            if (method_exists($product, 'get_gallery_image_ids')) {
                $attachment_ids = $product->get_gallery_image_ids();
                if ($attachment_ids && isset($attachment_ids['0'])) {
                    $secondary_image_id = $attachment_ids['0'];
                    $image_full_size_sec = wp_get_attachment_image_src($secondary_image_id, 'full');
                    $attachment_url_sec = !empty($image_full_size_sec[0]) ? $image_full_size_sec[0] : '';
                    $thumb_alt_sec = trim(strip_tags(get_post_meta((int)$secondary_image_id, '_wp_attachment_image_alt', true)));
                    $wgl_featured_image_url_sec = aq_resize($attachment_url_sec, $image_dims['width'], $image_dims['height'], true, true, true);
                    $featured_image_sec = '<img class="attachment-shop_catalog" src="' . esc_url($wgl_featured_image_url_sec) . '" alt="' . esc_attr($thumb_alt_sec) . '" />';
                }
            }

            $featured_image = '<img src="' . esc_url($wgl_featured_image_url) . '" alt="' . esc_attr($thumb_alt) . '" />';
            $featured_image .= $featured_image_sec ?? '';

            return $featured_image;
        }

        /**
         * Product gallery thumbnail columns
         */
        public function thumbnail_columns()
        {
            return 4;
        }

        /**
         * Related Products Args
         *
         *
         * @param array $args related products args.
         * @return array $args related products args
         */
        public function related_products_args($args)
        {
            $args = [
                'posts_per_page' => (int) BigHearts::get_option('shop_r_products_per_page'),
                'columns' => (int) BigHearts::get_option('shop_related_columns'),
            ];

            return $args;
        }

        /**
         * Columns Products
         *
         * @param array $args columns products args.
         */
        public function loop_columns($args)
        {
            return (int) BigHearts::get_option('shop_column'); // 3 products per row
        }

        public function wgl_product_columns_wrapper()
        {
            $columns = (int) BigHearts::get_option('shop_column');
            echo '<div class="wgl-products-catalog wgl-products-wrapper columns-' . absint($columns) . '">';
        }

        public function template_loop_product_title()
        {
            global $product;

            $link = apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product);
            echo '<h2 class="woocommerce-loop-product__title"><a href="' . esc_url($link) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">' . get_the_title() . '</a></h2>';
        }

        public function wgl_sorting_wrapper_open()
        {
            echo '<div class="wgl-woocommerce-sorting">';
        }

        public function wgl_sorting_wrapper_close()
        {
            echo '</div>';
        }

        public function wgl_product_columns_wrapper_open()
        {
            $columns = (int) BigHearts::get_option('shop_column');
            echo '<div class="wgl-products-catalog wgl-products-wrapper columns-' . absint($columns) . '">';
        }

        public function wgl_product_columns_wrapper_close()
        {
            echo '</div>';
        }

        public function template_loop_product_open()
        {
            echo '<div class="woo_product_content">';
        }

        public function template_loop_product_close()
        {
            echo '</div>';
        }

        public function get_sidebar_data()
        {
            $shop_template = is_single() ? 'single' : 'catalog';

            return BigHearts::get_sidebar_data('shop_' . $shop_template);
        }

        public function wgl_page_template_open()
        {
            $sb = $this->get_sidebar_data();

            echo '<div class="wgl-container single_product', esc_attr($sb['container_class'] ?? ''), '">',
                '<div class="row', esc_attr($sb['row_class'] ?? ''), '">',
                '<div id="main-content" class="wgl_col-', (int) esc_attr($sb['column'] ?? ''), '">';

            add_action('woocommerce_after_main_content', function () use ($sb) {
                echo '</div>';
                $sb && BigHearts::render_sidebar($sb);
                echo '</div>';
                echo '</div>';
            }, 10);
        }

        public function wgl_filter_pagination()
        {
            $total = $total ?? wc_get_loop_prop('total_pages');
            $current = $current ?? wc_get_loop_prop('current_page');
            $base = $base ?? esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
            $format = $format ?? '';

            if ($total <= 1) {
                return false;
            }

            return [ // WPCS: XSS ok.
                'base' => $base,
                'format' => $format,
                'add_args' => false,
                'current' => max(1, $current),
                'total' => $total,
                'prev_text' => '<i class="flaticon-left-arrow-1"></i>',
                'next_text' => '<i class="flaticon-right-arrow-1"></i>',
                'type' => 'list',
                'end_size' => 3,
                'mid_size' => 3,
            ];
        }

        public function wgl_image_thumbnails($image, $cart_item, $cart_item_key)
        {
            $class = 'attachment-woocommerce_thumbnail size-woocommerce_thumbnail wgl-woocommerce_thumbnail'; // Default cart thumbnail class.
            if (function_exists('aq_resize')) {
                $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

                $image_data = wp_get_attachment_metadata($_product->get_image_id());
                $image_meta_title = $image_data['image_meta']['title'] ?? '';
                $width = '70';
                $height = '70';
                $image_url = wp_get_attachment_image_url($_product->get_image_id(), 'full', false);
                $image_url = aq_resize($image_url, $width, $height, true, true, true);

                $image = '<img'
                    . ' class="'. esc_attr($class) .'"'
                    . ' src="' . esc_url($image_url) . '"'
                    . ' alt="' . esc_attr($image_meta_title) . '"'
                    . '>';
            }

            return $image;
        }

	    /** CART */
        public function wgl_cart_totals_line()
        {
            ?><div class="title-wrapper">
                <h2 class="title"><?php esc_html_e('Shopping Cart', 'bighearts'); ?></h2>
            </div><?php
	    }

	    public function wgl_empty_cart_message() { ?>
            <div class="woocommerce-info bighearts_module_message_box type_info">
                <div class="message_icon_wrap"><i class="message_icon "></i></div>
                <div class="message_content">
                    <div class="message_text cart-empty"><?php esc_html_e( 'Your cart is currently empty.', 'bighearts' ); ?></div>
                </div>
            </div><?php
	    }
    }
}

/** Config and enable extension */
new BigHearts_Woocoommerce();

// BigHearts Woocoommerce Helpers

if (!function_exists('bighearts_woocommerce_breadcrumb')) {
    /**
     * Output the WooCommerce Breadcrumb.
     *
     * @param array $args Arguments.
     */
    function bighearts_woocommerce_breadcrumb($args = [])
    {
        $args = wp_parse_args($args, apply_filters('woocommerce_breadcrumb_defaults', [
            'delimiter' => '&nbsp;&#47;&nbsp;',
            'wrap_before' => '',
            'wrap_after' => '',
            'before' => '',
            'after' => '',
            'home' => esc_html_x('Home', 'breadcrumb', 'bighearts'),
        ]));

        $breadcrumbs = new WC_Breadcrumb();

        $args['breadcrumb'] = $breadcrumbs->generate();

        /**
         * WooCommerce Breadcrumb hook
         *
         * @hooked WC_Structured_Data::generate_breadcrumblist_data() - 10
         */
        do_action('woocommerce_breadcrumb', $breadcrumbs, $args);

        extract($args);

        $out = '';
        if (!empty($breadcrumb)) {

            $out .= BigHearts::render_html($wrap_before);

            foreach ($breadcrumb as $key => $crumb) {

                $out .= BigHearts::render_html($before);

                if (!empty($crumb[1]) && sizeof($breadcrumb) !== $key + 1) {
                    $out .= '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
                } else {
                    $out .= '<span class="current">' . $crumb[0] . '</span>';
                }

                $out .= BigHearts::render_html($after);

                if (sizeof($breadcrumb) !== $key + 1) {
                    $out .= BigHearts::render_html($delimiter);
                }
            }
            $out .= BigHearts::render_html($wrap_after);
        }

        return $out;
    }
}
