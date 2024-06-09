<?php

defined('ABSPATH') || exit;

if (!class_exists('BigHearts_Core')) {
    return;
}

if (!class_exists('Wgl_Cat_Images')) {
    /**
     * WGL Categories Images
     *
     *
     * @package bighearts\core\class
     * @author WebGeniusLab <webgeniuslab@gmail.com>
     * @since 1.0.0
     */
    class Wgl_Cat_Images
    {
        /**
         * @see https://catapultthemes.com/adding-an-image-upload-field-to-categories/
         */
        public function init()
        {
            add_action('category_add_form_fields', [$this, 'meta_fields_for_cat_creating'], 10, 2);
            add_action('give_forms_category_add_form_fields', [$this, 'meta_fields_for_cat_creating'], 10, 2);

            add_action('category_edit_form_fields', [$this, 'meta_fields_for_cat_editing'], 10, 2);
            add_action('give_forms_category_edit_form_fields', [$this, 'meta_fields_for_cat_editing'], 10, 2);

            add_action('created_category', [$this, 'updating_meta_fields'], 10, 2);
            add_action('created_give_forms_category', [$this, 'updating_meta_fields'], 10, 2);

            add_action('edited_category', [$this, 'updating_meta_fields'], 10, 2);
            add_action('edited_give_forms_category', [$this, 'updating_meta_fields'], 10, 2);

            add_action('admin_enqueue_scripts', [$this, 'enqueue_styles_and_scripts']);

            // Add form
            add_action('product_cat_add_form_fields', [$this, 'add_category_icons']);
            add_action('product_cat_edit_form_fields', [$this, 'update_category_product_icons'], 10);
            add_action('created_term', [$this, 'save_category_fields_icon'], 10, 3);
            add_action('edit_term', [$this, 'save_category_fields_icon'], 10, 3);
        }

        public function enqueue_styles_and_scripts()
        {
            wp_enqueue_script('bighearts-cat-meta', get_template_directory_uri() . '/core/admin/js/cat_img_upload.js');

            wp_enqueue_media();

            $screen = get_current_screen();
            if (
                !is_null($screen)
                && 'edit-category' !== $screen->id
            ) {
                // Bailout.
                return;
            }

            wp_enqueue_script('wp-color-picker');
            wp_enqueue_style('wp-color-picker');
        }

        public function meta_fields_for_cat_creating($taxonomy_name)
        {
            echo '<div class="form-field term-colorpicker-wrap">',
                '<label for="term-colorpicker">',
                    esc_html__('Background Idle', 'bighearts'),
                '</label>',
                '<input',
                    ' name="_' . esc_attr($taxonomy_name) . '_color_idle"',
                    ' value=""',
                    ' class="colorpicker"',
                    ' id="term-colorpicker"',
                    '>',
            '</div>';

            echo '<div class="form-field term-colorpicker-wrap">',
                '<label for="term-colorpicker">',
                    esc_html__('Background Hover', 'bighearts'),
                '</label>',
                '<input',
                    ' name="_' . esc_attr($taxonomy_name) . '_color_hover"',
                    ' value=""',
                    ' class="colorpicker"',
                    ' id="term-colorpicker"',
                    '>',
            '</div>';

            ?>
            <div class="form-field term-group wgl-image-form">
                <label for="category-image-id"><?php esc_html_e('Background Image', 'bighearts'); ?></label>
                <input type="hidden" id="category-image-id" name="category-image-id" class="custom_media_url" value="">
                <div class="category-image-wrapper"></div>
                <p>
                    <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php esc_attr_e('Add Image', 'bighearts'); ?>" />
                    <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php esc_attr_e('Remove Image', 'bighearts'); ?>" />
                </p>
            </div>
            <div class="form-field term-group wgl-image-form">
                <label for="category-icon-image-id"><?php esc_html_e('Icon Image', 'bighearts'); ?></label>
                <input type="hidden" id="category-icon-image-id" name="category-icon-image-id" class="custom_media_url" value="">
                <div class="category-image-wrapper"></div>
                <p>
                    <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button_icon" name="ct_tax_media_button" value="<?php esc_attr_e('Add Image', 'bighearts'); ?>" />
                    <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove_icon" name="ct_tax_media_remove" value="<?php esc_attr_e('Remove Image', 'bighearts'); ?>" />
                </p>
            </div>
            <?php
        }

        /**
         * Add a form field in the new category page
         * @since 1.0.0
         */
        public function add_category_icons()
        {
            ?>
            <div class="form-field term-group wgl-image-form">
                <label for="category-icon-image-id"><?php esc_html_e('Icon Image', 'bighearts'); ?></label>
                <input type="hidden" id="category-icon-image-id" name="category-icon-image-id" class="custom_media_url" value="">
                <div class="category-image-wrapper"></div>
                <p>
                    <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button_icon" name="ct_tax_media_button" value="<?php esc_attr_e('Add Image', 'bighearts'); ?>" />
                    <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove_icon" name="ct_tax_media_remove" value="<?php esc_attr_e('Remove Image', 'bighearts'); ?>" />
                </p>
            </div>
            <?php
        }

        public function meta_fields_for_cat_editing($term, $taxonomy)
        {
            $term_color_idle = get_term_meta($term->term_id, '_' . $term->taxonomy . '_color_idle', true);
            $placeholder_idle = '';
            $cat_color_idle = $term_color_idle ? "#{$term_color_idle}" : $placeholder_idle;
            echo '<tr class="form-field term-colorpicker-wrap">',
                '<th scope="row"><label for="term-colorpicker">',
                    esc_html__('Background Idle', 'bighearts'),
                '</label></th>',
                '<td>',
                    '<input',
                    ' name="_' . esc_attr($term->taxonomy) . '_color_idle"',
                    ' value="', esc_attr($cat_color_idle), '"',
                    ' class="colorpicker"',
                    ' id="term-colorpicker"',
                    '>',
                '</td>',
            '</tr>';

            $term_color_hover = get_term_meta($term->term_id, '_' . $term->taxonomy . '_color_hover', true);
            $placeholder_hover = '';
            $cat_color_hover = $term_color_hover ? "#{$term_color_hover}" : $placeholder_hover;
            echo '<tr class="form-field term-colorpicker-wrap">',
                '<th scope="row"><label for="term-colorpicker">',
                    esc_html__('Background Hover', 'bighearts'),
                '</label></th>',
                '<td>',
                    '<input',
                    ' name="_' . esc_attr($term->taxonomy) . '_color_hover"',
                    ' value="', esc_attr($cat_color_hover), '"',
                    ' class="colorpicker"',
                    ' id="term-colorpicker"',
                    '>',
                '</td>',
            '</tr>';

            ?>
            <tr class="form-field term-group-wrap wgl-image-form">
                <th scope="row">
                    <label for="category-image-id"><?php esc_html_e('Background Image', 'bighearts'); ?></label>
                </th>
                <td>
                    <?php $image_id = get_term_meta($term->term_id, 'category-image-id', true); ?>
                    <input type="hidden" id="category-image-id" name="category-image-id" class="custom_media_url" value="<?php esc_attr($image_id); ?>">
                    <div class="category-image-wrapper">
                        <?php
                        if ($image_id) {
                            echo wp_get_attachment_image($image_id, 'thumbnail');
                        }
                        ?>
                    </div>
                    <p>
                        <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php esc_attr_e('Add Image', 'bighearts'); ?>" />
                        <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php esc_attr_e('Remove Image', 'bighearts'); ?>" />
                    </p>
                </td>
            </tr>
            <tr class="form-field term-group-wrap wgl-image-form">
                <th scope="row">
                    <label for="category-icon-image-id"><?php esc_html_e('Icon Image', 'bighearts'); ?></label>
                </th>
                <td>
                    <?php $image_id = get_term_meta($term->term_id, 'category-icon-image-id', true); ?>
                    <input type="hidden" id="category-icon-image-id" name="category-icon-image-id" class="custom_media_url" value="<?php echo esc_attr($image_id); ?>">
                    <div class="category-image-wrapper">
                        <?php
                        if ($image_id) {
                            echo wp_get_attachment_image($image_id, 'thumbnail');
                        }
                        ?>
                    </div>
                    <p>
                        <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button_icon" name="ct_tax_media_button" value="<?php esc_attr_e('Add Image', 'bighearts'); ?>" />
                        <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove_icon" name="ct_tax_media_remove" value="<?php esc_attr_e('Remove Image', 'bighearts'); ?>" />
                    </p>
                </td>
            </tr>
            <?php
        }

        /**
         * @since 1.0.0
         */
        public function update_category_product_icons($term)
        {
            ?>
            <tr class="form-field term-group-wrap wgl-image-form">
                <th scope="row">
                    <label for="category-icon-image-id"><?php esc_html_e('Icon Image', 'bighearts'); ?></label>
                </th>
                <td>
                    <?php $image_id = get_term_meta($term->term_id, 'category-icon-image-id', true); ?>
                    <input type="hidden" id="category-icon-image-id" name="category-icon-image-id" class="custom_media_url" value="<?php echo esc_attr($image_id); ?>">
                    <div class="category-image-wrapper"><?php
                        if ($image_id) {
                            echo wp_get_attachment_image($image_id, 'thumbnail');
                        }
                        ?>
                    </div>
                    <p>
                        <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button_icon" name="ct_tax_media_button" value="<?php esc_attr_e('Add Image', 'bighearts'); ?>" />
                        <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove_icon" name="ct_tax_media_remove" value="<?php esc_attr_e('Remove Image', 'bighearts'); ?>" />
                    </p>
                </td>
            </tr>
            <?php
        }

        public function updating_meta_fields($term_id, $tt_id)
        {
            $term_obj = get_term_by('term_taxonomy_id', $term_id);
            $taxonomy_name = $term_obj->taxonomy;

            empty($_POST['_' . $taxonomy_name . '_color_idle'])
                ? delete_term_meta($term_id, '_' . $taxonomy_name . '_color_idle')
                : update_term_meta($term_id, '_' . $taxonomy_name . '_color_idle', sanitize_hex_color_no_hash($_POST['_' . $taxonomy_name . '_color_idle']));

            empty($_POST['_' . $taxonomy_name . '_color_hover'])
                ? delete_term_meta($term_id, '_' . $taxonomy_name . '_color_hover')
                : update_term_meta($term_id, '_' . $taxonomy_name . '_color_hover', sanitize_hex_color_no_hash($_POST['_' . $taxonomy_name . '_color_hover']));

            if (empty($_POST['category-image-id'])) {
                delete_term_meta($term_id, 'category-image-id');
            } else {
                $image = sanitize_text_field($_POST['category-image-id']);
                update_term_meta($term_id, 'category-image-id', $image);
            }

            if (empty($_POST['category-icon-image-id'])) {
                delete_term_meta($term_id, 'category-icon-image-id');
            } else {
                $image = sanitize_text_field($_POST['category-icon-image-id']);
                update_term_meta($term_id, 'category-icon-image-id', $image);
            }
        }

        /**
         * Update the form field value
         */
        public function save_category_fields_icon($term_id, $tt_id)
        {
            if (empty($_POST['category-icon-image-id'])) {
                update_term_meta($term_id, 'category-icon-image-id', '');
            } else {
                $image = sanitize_text_field($_POST['category-icon-image-id']);
                update_term_meta($term_id, 'category-icon-image-id', $image);
            }
        }
    }

    (new Wgl_Cat_Images())->init();
}