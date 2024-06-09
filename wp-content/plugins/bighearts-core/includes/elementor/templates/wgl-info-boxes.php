<?php
/**
 * This template can be overridden by copying it to `bighearts[-child]/bighearts-core/elementor/templates/wgl-info-boxes.php`.
 */
namespace WglAddons\Templates;

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

use WglAddons\Includes\Wgl_Icons;

/**
 * WGL Elementor Info Box Template
 *
 *
 * @package bighearts-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 * @version 1.1.2
 */
class WGL_Info_Box
{
    private static $instance;
    private $self;

    /**
     * @since 1.0.0
     * @version 1.1.2
     */
    public function render( $self, $atts )
    {
        $this->self = $self;

        extract( $atts );

        $ib_media = $ib_button = $module_link_html = '';

        //* Wrapper classes
        $wrapper_classes = $layout ? ' wgl-layout-' . $layout : '';

        //* Title
        $infobox_title = '<div class="wgl-infobox-title_wrapper">';
	    $infobox_title .= !empty($ib_title) ? '<' . esc_attr($title_tag) . ' class="wgl-infobox_title">' : '';
	    $infobox_title .= !empty($ib_title) ? '<span class="wgl-infobox_title-idle">' . wp_kses($ib_title, self::get_kses_allowed_html()) . '</span>' : '';
	    $infobox_title .= (!empty($ib_title) && !empty($ib_title_add)) ? '<span class="wgl-infobox_title-add">' . wp_kses($ib_title_add, self::get_kses_allowed_html()) . '</span>' : '';
	    $infobox_title .= !empty($ib_title) ? '</' . esc_attr($title_tag) . '>' : '';
	    $infobox_title .= !empty($ib_subtitle) ? '<div class="wgl-infobox_subtitle">' . wp_kses($ib_subtitle, self::get_kses_allowed_html()) . '</div>' : '';
	    $infobox_title .= '</div>';

        //* Media
        if (!empty($icon_type)) {
            $media = new Wgl_Icons;
            $ib_media .= $media->build($self, $atts, []);
        }

        //* Link
        if (!empty($link['url'])) {
            $self->add_link_attributes('link', $link);
        }

        //* Read more button
        if ($add_read_more) {
            $self->add_render_attribute('btn', 'class', 'wgl-infobox_button button-read-more');

            $ib_button = '<div class="wgl-infobox-button_wrapper">';
            $ib_button .= sprintf(
                '<%s %s %s>',
                $module_link ? 'div' : 'a',
                $module_link ? '' : $self->get_render_attribute_string('link'),
                $self->get_render_attribute_string('btn')
            );
            $ib_button .= $read_more_text ? '<span>' . esc_html($read_more_text) . '</span>' : '';
            $ib_button .= $module_link ? '</div>' : '</a>';
            $ib_button .= '</div>';
        }

        if ($module_link && !empty($link['url'])) {
            $module_link_html = '<a class="wgl-infobox__link" ' . $self->get_render_attribute_string('link') . '></a>';
        }

        //* Render
        echo $module_link_html,
            '<div class="wgl-infobox">',
                '<div class="wgl-infobox_wrapper', esc_attr($wrapper_classes), '">',
                    $ib_media,
                    '<div class="content_wrapper">',
                        $infobox_title,
                        $this->render_content(),
                        $read_more_inline ? '' : $ib_button,
                    '</div>',
                    $read_more_inline ? $ib_button : '',
                '</div>',
            '</div>';
    }

    /**
     * @since 1.1.2
     */
    protected function render_content()
    {
        if ( ! $this->self->get_settings_for_display( 'ib_content' ) ) {
            // Bailout.
            return;
        }

        $content_tag = $this->self->get_settings_for_display( 'content_tag' );

        echo '<', esc_attr( $content_tag ), ' class="wgl-infobox_content">',
            $this->self->get_settings_for_display( 'ib_content' ),
        '</', esc_attr( $content_tag ), '>';
    }

    /**
     * @since 1.0.0
     * @version 1.1.2
     */
    protected static function get_kses_allowed_html()
    {
        $allowed_attributes = [
            'id' => true,
            'class' => true,
            'style' => true,
        ];

        return [
            'a' => $allowed_attributes + [
                'href' => true,
                'title' => true,
                'rel' => true,
                'target' => true,
            ],
            'br' => $allowed_attributes,
            'wbr' => $allowed_attributes,
            'b' => $allowed_attributes,
            'strong' => $allowed_attributes,
            'em' => $allowed_attributes,
            'i' => $allowed_attributes,
            'small' => $allowed_attributes,
            'sup' => $allowed_attributes,
            'sub' => $allowed_attributes,
            'span' => $allowed_attributes,
            'p' => $allowed_attributes,
        ];
    }

    public static function get_instance()
    {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
