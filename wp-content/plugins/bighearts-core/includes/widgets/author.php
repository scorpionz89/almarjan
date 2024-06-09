<?php

class Author extends WP_Widget
{
    // If WPML is active and was setup to have more than one language this website is multilingual.
    private $isMultilingual = false; // Is this site multilingual?

    function __construct()
    {
        parent::__construct(
            'combined_image_author_widget', // Base ID
            esc_html__( 'WGL Blog Author', 'bighearts-core' ), // Name
            array( 'description' => esc_html__('WGL Widget ', 'bighearts-core'), ) // Args
        );

        if (is_admin() === true) {
            add_action('admin_enqueue_scripts', array($this, 'enqueue_backend_scripts') );
        }
    }


    public function enqueue_backend_scripts()
    {
        wp_enqueue_media(); //Enable the WP media uploader
        wp_enqueue_script('bighearts-upload-img', get_template_directory_uri() . '/core/admin/js/img_upload.js', ['jquery'], false, true);
    }


    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        $title_name = 'title';
        $author_name = 'name';
        $author_title_name = 'author_title';
        $text_name = 'text';
        $image_name = 'image';
        $author_image_url = $instance[$image_name] ?? '';
        $image_signature = $instance['signature'] ?? '';
        $bg_image = $instance['bg'] ?? '';
        $attachment_id = attachment_url_to_postid($instance[$image_name]);

        $alt = $alt_s = '';

        $kses_allowed_html = [
            'a' => [
                'id' => true, 'class' => true, 'style' => true,
                'href' => true, 'title' => true,
                'rel' => true, 'target' => true,
            ],
            'br' => ['id' => true, 'class' => true, 'style' => true],
            'em' => ['id' => true, 'class' => true, 'style' => true],
            'strong' => ['id' => true, 'class' => true, 'style' => true],
            'span' => ['id' => true, 'class' => true, 'style' => true],
        ];

        // if no alt attribute is filled out then echo "Featured Image of article: Article Name"
        if ('' === get_post_meta($attachment_id, '_wp_attachment_image_alt', true)) {
            $alt = the_title_attribute(array('before' => esc_html__('Featured author image: ', 'bighearts-core'), 'echo' => false));
        } else {
            $alt = trim(strip_tags(get_post_meta($attachment_id, '_wp_attachment_image_alt', true)));
        }

        // Get Image Signature
        $attachment_id_s = attachment_url_to_postid($image_signature);
        // if no alt attribute is filled out then echo "Featured Image of article: Article Name"
        if ('' === get_post_meta($attachment_id_s, '_wp_attachment_image_alt', true)) {
            $alt_s = the_title_attribute(array('before' => esc_html__('Featured author signature: ', 'bighearts-core'), 'echo' => false));
        } else {
            $alt_s = trim(strip_tags(get_post_meta($attachment_id_s, '_wp_attachment_image_alt', true)));
        }

        $title = $instance[$title_name] ?? false;
		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        $author_name = $instance[$author_name] ?? false;
        $title_author = $instance[$author_title_name] ?? false;
        $text = $instance[$text_name] ?? '';

        $socials = [];
        foreach (wgl_user_social_medias_arr() as $soc_name => $value) {
            $socials[$soc_name] = !empty($instance[$soc_name]) ? $instance[$soc_name] : '';
        }

        $wrapper_style = $bg_image ? ' style="background-image: url('.esc_url($bg_image).');"' : '';

        // Render
        echo '<div class="widget bighearts_widget widget_author">';

        if ($title) {
            echo '<div class="title-wrapper">',
                '<span class="title">',
                $title,
                '</span>',
                '<span class="title__line"></span>',
            '</div>';
        }

        echo '<div class="author-widget_wrapper"', $wrapper_style, '>';

            if ($author_image_url) {
                echo '<div class="author-widget_img-wrapper">',
                    '<img',
                        ' class="author-widget_img"',
                        ' src="', esc_url(aq_resize($author_image_url, '350', '350', true, true, true)), '"',
                        ' alt="', esc_attr($alt), '"',
                        '>',
                '</div>';
            }

            if ($image_signature) {
                echo '<div class="author-widget_img_sign-wrapper">',
                    '<img',
                    ' class="author-widget_sign"',
                    ' src="', esc_url($image_signature), '"',
                    ' alt="', esc_attr($alt_s), '"',
                    '>',
                '</div>';
            }

            if ($author_name) {
                echo '<h4 class="author-widget_title">',
                    wp_kses($author_name, $kses_allowed_html),
                '</h4>';
            }

            if ($title_author) {
                echo '<p class="author-widget_desc">',
                    wp_kses($title_author, $kses_allowed_html),
                '</p>';
            }

            if ($text) {
                echo '<p class="author-widget_text">',
                    wp_kses($text, $kses_allowed_html),
                '</p>';
            }

            if (!empty($socials)) {
                echo '<div class="author-widget_social">';
                foreach ($socials as $name => $link) if ($link) {
                    $icon_pref = 'fab fa-';
                    if ($name == 'telegram') $icon_pref = 'flaticon-';
                    echo '<a',
                        ' class="author-widget_social-link ', esc_attr($icon_pref), esc_attr($name), '"',
                        ' href="', esc_url($link), '"',
                        '></a>';
                }
                echo '</div>';
            }

        echo '</div>'; // author-widget_wrapper
        echo '</div>';
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {
        $title_name = 'title';
        $author_name = 'name';
        $text_name = 'text';
        $author_title_name = 'author_title';
        $image_name = 'image';
        $image_signature = 'signature';
        $bg_image = 'bg';

        $title = $instance[$title_name] ?? '';
        $name = $instance[$author_name] ?? '';
        $text = $instance[$text_name] ?? '';
        $author_title = $instance[$author_title_name] ?? '';
        $image = $instance[$image_name] ?? '';
        $signature = $instance[$image_signature] ?? '';
        $bg = $instance[$bg_image] ?? '';

        foreach (wgl_user_social_medias_arr() as $soc_name => $value) {
            ${$soc_name} = !empty($instance[$soc_name]) ? $instance[$soc_name] : '';
        }

        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id($title_name)); ?>"><?php esc_html_e('Title:', 'bighearts-core' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id($title_name)); ?>" name="<?php echo esc_attr($this->get_field_name($title_name)); ?>" type="text" value="<?php echo esc_attr($title ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id($author_name)); ?>"><?php esc_html_e('Author Name:', 'bighearts-core' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id($author_name )); ?>" name="<?php echo esc_attr($this->get_field_name($author_name)); ?>" type="text" value="<?php echo esc_attr($name ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id($author_title_name)); ?>"><?php esc_html_e('Author Title:', 'bighearts-core' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id($author_title_name)); ?>" name="<?php echo esc_attr($this->get_field_name($author_title_name)); ?>" type="text" value="<?php echo esc_attr($author_title ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id($text_name)); ?>"><?php esc_html_e('Text:', 'bighearts-core' ); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id($text_name)); ?>" name="<?php echo esc_attr($this->get_field_name($text_name)); ?>" row="2"><?php echo esc_html( $text ); ?></textarea>
        </p>

        <p>
          <label for="<?php echo esc_attr($this->get_field_id($image_name)); ?>"><?php esc_html_e('Author Image:', 'bighearts-core' ); ?></label><br />
            <img class="bighearts_media_image" src="<?php if (!empty($instance[$image_name])) {echo esc_url($instance[$image_name] );} ?>" style="max-width: 100%" />
            <input type="text" class="widefat bighearts_media_url" name="<?php echo esc_attr($this->get_field_name($image_name)); ?>" id="<?php echo esc_attr($this->get_field_id($image_name)); ?>" value="<?php echo esc_attr($image ); ?>">
            <a href="#" class="button bighearts_media_upload"><?php esc_html_e('Upload', 'bighearts-core'); ?></a>
        </p>

        <p>
          <label for="<?php echo esc_attr($this->get_field_id($bg_image)); ?>"><?php esc_html_e('Background Image:', 'bighearts-core' ); ?></label><br />
            <img class="bighearts_media_image" src="<?php if (!empty($instance[$bg_image])) {echo esc_url( $instance[$bg_image] );} ?>" style="max-width: 100%" />
            <input type="text" class="widefat bighearts_media_url" name="<?php echo esc_attr($this->get_field_name($bg_image)); ?>" id="<?php echo esc_attr($this->get_field_id($bg_image)); ?>" value="<?php echo esc_attr($bg ); ?>">
            <a href="#" class="button bighearts_media_upload"><?php esc_html_e('Upload', 'bighearts-core'); ?></a>
        </p>

        <p>
          <label for="<?php echo esc_attr($this->get_field_id($image_signature)); ?>"><?php esc_html_e('Author Signature:', 'bighearts-core' ); ?></label><br />
            <img class="bighearts_media_image" src="<?php if (!empty($instance[$image_signature])) {echo esc_url( $instance[$image_signature] );} ?>" style="max-width: 100%" />
            <input type="text" class="widefat bighearts_media_url" name="<?php echo esc_attr($this->get_field_name($image_signature)); ?>" id="<?php echo esc_attr($this->get_field_id($image_signature)); ?>" value="<?php echo esc_attr($signature ); ?>">
            <a href="#" class="button bighearts_media_upload"><?php esc_html_e('Upload', 'bighearts-core'); ?></a>
        </p>

        <?php
        foreach (wgl_user_social_medias_arr() as $soc_name => $value) { ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id($soc_name)); ?>" style="text-transform: capitalize;"><?php echo esc_html($value.' link:'); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id($soc_name)); ?>" name="<?php echo esc_attr($this->get_field_name($soc_name )); ?>" type="text" value="<?php echo esc_attr(${$soc_name} ); ?>">
            </p>
            <?php
        }
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        return $new_instance;
    }

}

function author_register_widgets()
{
    register_widget('author');
}

add_action('widgets_init', 'author_register_widgets');
