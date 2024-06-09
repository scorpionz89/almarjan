<?php

/**
 * Load Theme Dependencies
 */
require_once get_theme_file_path('/core/class/theme-dependencies.php');


/**
 * Sequence of theme specific actions
 */

add_action('after_setup_theme', function() {
    $content_width = $content_width ?? 940;
}, 0);

add_action('after_setup_theme', function() {
    add_theme_support('title-tag');
});

add_action('init', function() {
    add_post_type_support('page', 'excerpt');
});

/** Add a pingback url auto-discovery for single posts, pages or attachments. */
add_action('wp_head', function() {
    if (is_singular() && pings_open()) {
        echo '<link rel="pingback" href="', esc_url(get_bloginfo('pingback_url')), '">';
    }
});


/**
 * Sequence of theme specific filters
 */

add_filter('bighearts/header/enable', 'bighearts_header_enable');

add_filter('bighearts/page_title/enable', 'bighearts_page_title_enable');

add_filter('bighearts/footer/enable', 'bighearts_footer_enable');

add_action('bighearts/preloader', 'BigHearts_Theme_Helper::preloader');

add_action('bighearts/after_main_content', 'bighearts_after_main_content');

add_filter('comment_form_fields', 'bighearts_comment_form_fields');

add_filter('mce_buttons_2', function($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
});

add_filter('tiny_mce_before_init', 'bighearts_tiny_mce_before_init');

add_action('current_screen', function() {
    add_editor_style('css/font-awesome-5.min.css');
});

add_filter('wp_list_categories', 'bighearts_categories_postcount_filter');
add_filter('woocommerce_layered_nav_term_html', 'bighearts_categories_postcount_filter');

add_filter('get_archives_link', 'bighearts_render_archive_widgets', 10, 6);

add_filter('bighearts/extra_css', function($styles) {
    global $bighearts_dynamic_css;
    if (!isset($bighearts_dynamic_css['style'])) {
        $bighearts_dynamic_css = [];
        $bighearts_dynamic_css['style'] = $styles;
    } else {
        $bighearts_dynamic_css['style'] .= $styles;
    }
});

/* Add Custom Image Link field to media uploader for WGL Gallery module */
function bighearts_attachment_custom_link_field($form_fields, $post)
{
    $form_fields['custom_image_link'] = array(
        'label' => esc_html__('Custom Image Link','bighearts'),
        'input' => 'text',
        'value' => get_post_meta($post->ID, 'custom_image_link', true),
        'helps' => esc_html__('This option works only for the WGL Gallery module.','bighearts'),
    );
    return $form_fields;
}
add_filter('attachment_fields_to_edit', 'bighearts_attachment_custom_link_field', 10, 2);
/* Save values of Custom Image Link in media uploader */
function bighearts_attachment_custom_link_field_save($post, $attachment)
{
    if (isset($attachment['custom_image_link']))
        update_post_meta($post['ID'], 'custom_image_link', $attachment['custom_image_link']);

    return $post;
}

add_filter('attachment_fields_to_save', 'bighearts_attachment_custom_link_field_save', 10, 2);

add_filter( 'wpcf7_autop_or_not', '__return_false');

/* Temporary disable update for the Give WP plugin */
function bighearts_give_wp_updates_disable( $value ) {
    if ( isset( $value ) && is_object( $value ) ) {
        unset( $value->response[ 'give/give.php' ] );
    }

    return $value;
}
add_filter( 'site_transient_update_plugins', 'bighearts_give_wp_updates_disable' );
