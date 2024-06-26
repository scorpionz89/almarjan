<?php
global $wgl_blog_atts;

// Default settings for blog item
$trim = true;
if (!$wgl_blog_atts) {
    $opt_likes = BigHearts_Theme_Helper::get_option('blog_list_likes');
    $opt_share = BigHearts_Theme_Helper::get_option('blog_list_share');
    $opt_meta_author = BigHearts_Theme_Helper::get_option('blog_list_meta_author');
    $opt_meta_comments = BigHearts_Theme_Helper::get_option('blog_list_meta_comments');
    $opt_meta_categories = BigHearts_Theme_Helper::get_option('blog_list_meta_categories');
    $opt_meta_date = BigHearts_Theme_Helper::get_option('blog_list_meta_date');
    $opt_read_more = BigHearts_Theme_Helper::get_option('blog_list_read_more');

    global $wp_query;
    $wgl_blog_atts = [
        'query' => $wp_query,
        // General
        'blog_layout' => 'grid',
        // Content
        'blog_columns' => BigHearts_Theme_Helper::get_option('blog_list_columns') ?: '12',
        'hide_media' => BigHearts_Theme_Helper::get_option('blog_list_hide_media'),
        'hide_content' => BigHearts_Theme_Helper::get_option('blog_list_hide_content'),
        'hide_blog_title' => BigHearts_Theme_Helper::get_option('blog_list_hide_title'),
        'hide_all_meta' => BigHearts_Theme_Helper::get_option('blog_list_meta'),
        'meta_author' => $opt_meta_author,
        'meta_comments' => $opt_meta_comments,
        'meta_categories' => $opt_meta_categories,
        'meta_date' => $opt_meta_date,
        'hide_likes' => !$opt_likes,
        'hide_share' => !$opt_share,
        'hide_views' => true,
        'read_more_hide' => $opt_read_more,
        'content_letter_count' => BigHearts_Theme_Helper::get_option('blog_list_letter_count') ?: '85',
        'crop_square_img' => true,
        'heading_tag' => 'h3',
        'read_more_text' => esc_html__('Read More', 'bighearts'),
        'items_load'  => 4,
    ];
    $trim = false;
}

extract($wgl_blog_atts);

if ($crop_square_img) {
    $image_size = '';
} else {
    $image_size = 'full';
}

global $wgl_query_vars;
if (!empty($wgl_query_vars)){
    $query = $wgl_query_vars;
}

$kses_allowed_html = [
    'a' => [
        'href' => true,
        'title' => true,
    ],
    'br' => [],
    'b' => [],
    'em' => [],
    'strong' => []
];

$blog_styles = '';

$blog_attr = !empty($blog_styles) ? ' style="'.esc_attr($blog_styles).'"' : '';

while ($query->have_posts()) : $query->the_post();

    echo '<div class="wgl_col-'.esc_attr($blog_columns).' item">';

    $single = BigHearts_Single_Post::getInstance();
    $single->set_post_data();

    $title = get_the_title();

    $blog_item_classes = ' format-'.$single->get_post_format();
    $blog_item_classes .= (bool)$hide_media ? ' hide_media' : '';
    $blog_item_classes .= is_sticky() ? ' sticky-post' : '';

    $has_media = $single->render_bg_image;

    if ((bool)$hide_media){
        $has_media = false;
    }

    $blog_item_classes .= !(bool) $has_media ? ' format-no_featured' : '';

    $meta_to_show = array(
        'comments' => !(bool)$meta_comments,
        'author' => !(bool)$meta_author,
        'date' => !(bool)$meta_date,
    );
    $meta_to_show_cats = array(
        'category' => !(bool)$meta_categories,
    );

    ?>
    <div class="blog-post <?php echo esc_attr($blog_item_classes); ?>"<?php echo BigHearts_Theme_Helper::render_html($blog_attr);?>>
        <div class="blog-post-hero_wrapper">

            <?php
            // Media blog post

            $media_link = true;
            ?>

            <div class="blog-post-hero-content_front">

                <div class="blog-post-hero_content">
                <?php

                    //Post Meta render cats
                    if (!$hide_all_meta && !empty($meta_to_show_cats) ) {
                        echo '<div class="blog-post_cats">';
                            $single->render_post_meta($meta_to_show_cats);
                        echo '</div>';
                    }

                    // Blog Title
                    if (!(bool) $hide_blog_title && !empty($title) ) :
                        printf(
                            '<%1$s class="blog-post_title"><a href="%2$s">%3$s</a></%1$s>',
                            esc_html($heading_tag),
                            esc_url(get_permalink()),
                            wp_kses($title, $kses_allowed_html)
                        );
                    endif;
                    //Post Meta render comments,author
                    if (!$hide_all_meta ) {
                        $single->render_post_meta($meta_to_show);
                    }
                    ?>

                    <div class='blog-post-hero_meta-desc'>
                        <?php
                            if (!(bool)$hide_share || !(bool)$hide_likes) {
                                echo '<div class="meta-data">';
                            }

                            echo "<div class='divider_post_info'></div>";

                            // Likes in blog
                            if (!(bool)$hide_share || !(bool)$hide_likes) echo '<div class="blog-post_info-wrap">';

                            // Render shares
                            if (!(bool)$hide_share && function_exists('wgl_theme_helper') ) :
                                echo wgl_theme_helper()->render_post_list_share();
                            endif;

                            if (!(bool)$hide_likes && function_exists('wgl_simple_likes')) {
                                echo wgl_simple_likes()->get_likes_button(get_the_ID());
                            }

                            if (!(bool)$hide_share || !(bool)$hide_likes ): ?>
                                </div>
                                </div>
                            <?php
                            endif;


                    echo '</div>';

                    BigHearts_Theme_Helper::link_pages();

                echo '</div>';
            echo '</div>';

            echo '<div class="blog-post-hero-content_back">';
                echo '<div class="blog-post-hero_content">';

                    // Post Meta render cats
                    if (!$hide_all_meta && !empty($meta_to_show_cats) ) {
                        echo '<div class="blog-post_cats">';
                            $single->render_post_meta($meta_to_show_cats);
                        echo '</div>';
                    }

                    //* Blog Title
                    if (!(bool) $hide_blog_title && !empty($title)) :
                        printf(
                            '<p class="blog-post_title"><a href="%1$s">%2$s</a></p>',
                            esc_url(get_permalink()),
                            wp_kses($title, $kses_allowed_html)
                        );
                    endif;

                    //* Post Meta render comments,author
                    if (!$hide_all_meta ) {
                        $single->render_post_meta($meta_to_show);
                    }
                    // Content Blog
                    if (!(bool)$hide_content ) {
                        $single->render_excerpt($content_letter_count, $trim, !(bool)$read_more_hide, $read_more_text);
                    }

                    ?>
                    <div class='blog-post-hero_meta-desc'>
                        <?php
                            if (!(bool)$hide_share || !(bool)$hide_likes) {
                                echo '<div class="meta-data">';
                            }

                            echo "<div class='divider_post_info'></div>";
                            // Read more link
                            if (!(bool)$read_more_hide ) :
                                ?>
                                <a href="<?php echo esc_url(get_permalink()); ?>" class="button-read-more standard_post"><?php echo esc_html($read_more_text); ?></a>
                                <?php
                            endif;


                            // Likes in blog
                            if (!(bool)$hide_share || !(bool)$hide_likes) echo '<div class="blog-post_info-wrap">';

                            // Render shares
                            if (!(bool)$hide_share && function_exists('wgl_theme_helper') ) :
                                echo wgl_theme_helper()->render_post_list_share();
                            endif;

                            if (!(bool)$hide_likes && function_exists('wgl_simple_likes')) {
                                echo wgl_simple_likes()->get_likes_button(get_the_ID());
                            }

                            if (!(bool)$hide_share || !(bool)$hide_likes ): ?>
                                </div>
                                </div>
                            <?php
                            endif;

                        ?>
                    </div>

                    <?php
                    BigHearts_Theme_Helper::link_pages();
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php

    echo '</div>';

endwhile;
wp_reset_postdata();
