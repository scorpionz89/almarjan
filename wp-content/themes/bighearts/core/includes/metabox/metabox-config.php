<?php

if (!class_exists('RWMB_Loader')) return;

use WglAddons\BigHearts_Global_Variables as BigHearts_Globals;
use BigHearts_Theme_Helper as BigHearts;

/**
 * @since 1.0.0
 * @version 1.1.2
 */
class BigHearts_Metaboxes
{
    public function __construct()
    {
        // Team
        add_filter( 'rwmb_meta_boxes', [ $this, 'team_meta_boxes' ] );

        // Portfolio
        add_filter( 'rwmb_meta_boxes', [ $this, 'portfolio_meta_boxes' ] );
        add_filter( 'rwmb_meta_boxes', [ $this, 'portfolio_post_settings_meta_boxes' ] );
        add_filter( 'rwmb_meta_boxes', [ $this, 'portfolio_related_meta_boxes' ] );

        // Blog
        add_filter( 'rwmb_meta_boxes', [ $this, 'blog_settings_meta_boxes' ] );
        add_filter( 'rwmb_meta_boxes', [ $this, 'blog_meta_boxes' ] );
        add_filter( 'rwmb_meta_boxes', [ $this, 'blog_related_meta_boxes' ] );

        // Page
        add_filter( 'rwmb_meta_boxes', [ $this, 'page_layout_meta_boxes' ] );

        // Colors
        add_filter( 'rwmb_meta_boxes', [ $this, 'page_color_meta_boxes' ] );

        // Header Builder
        add_filter( 'rwmb_meta_boxes', [ $this, 'page_header_meta_boxes' ] );

        // Title
        add_filter( 'rwmb_meta_boxes', [ $this, 'page_title_meta_boxes' ] );

        // Side Panel
        add_filter( 'rwmb_meta_boxes', [ $this, 'page_side_panel_meta_boxes' ] );

        // Social Shares
        add_filter( 'rwmb_meta_boxes', [ $this, 'page_soc_icons_meta_boxes' ] );

        // Footer
        add_filter( 'rwmb_meta_boxes', [ $this, 'page_footer_meta_boxes' ] );

        // Copyright
        add_filter( 'rwmb_meta_boxes', [ $this, 'page_copyright_meta_boxes' ] );
    }

    public function team_meta_boxes($meta_boxes)
    {
        $meta_boxes[] = [
            'title' => esc_html__('Team Options', 'bighearts'),
            'post_types' => ['team'],
            'context' => 'advanced',
            'fields' => [
                [
                    'id' => 'department',
                    'name' => esc_html__('Highlighted Info', 'bighearts'),
                    'type' => 'text',
                    'class' => 'field-inputs'
                ],
                [
                    'name' => esc_html__('Signature', 'bighearts'),
                    'id' => 'mb_signature',
                    'type' => 'file_advanced',
                    'max_file_uploads' => 1,
                    'mime_type' => 'image',
                ],
                [
                    'id' => 'info_items',
                    'name' => esc_html__('Member Info', 'bighearts'),
                    'type' => 'social',
                    'clone' => true,
                    'sort_clone' => true,
                    'options' => [
                        'name' => [
                            'name' => esc_html__('Name', 'bighearts'),
                            'type_input' => 'text'
                        ],
                        'description' => [
                            'name' => esc_html__('Description', 'bighearts'),
                            'type_input' => 'text'
                        ],
                        'link' => [
                            'name' => esc_html__('Link', 'bighearts'),
                            'type_input' => 'text'
                        ],
                    ],
                ],
                [
                    'id' => 'soc_icon',
                    'name' => esc_html__('Social Icons', 'bighearts'),
                    'type' => 'select_icon',
                    'placeholder' => esc_attr__('Select an icon', 'bighearts'),
                    'clone' => true,
                    'sort_clone' => true,
                    'multiple' => false,
                    'options' => WglAdminIcon()->get_icons_name(),
                    'std' => 'default',
                ],
                [
                    'name' => esc_html__('Info Background Image', 'bighearts'),
                    'id' => 'mb_info_bg',
                    'type' => 'file_advanced',
                    'max_file_uploads' => 1,
                    'mime_type' => 'image',
                ],
            ],
        ];

        return $meta_boxes;
    }

    /**
     * @version 1.1.2
     */
    public function portfolio_meta_boxes( $meta_boxes )
    {
        $meta_boxes[] = [
            'title' => esc_html__('Portfolio Options', 'bighearts'),
            'post_types' => ['portfolio'],
            'context' => 'advanced',
            'fields' => [
                [
                    'id' => 'mb_portfolio_featured_image_conditional',
                    'name' => esc_html__('Featured Image', 'bighearts'),
                    'type' => 'button_group',
                    'multiple' => false,
                    'options' => [
                        'default' => esc_html__('Default', 'bighearts'),
                        'custom' => esc_html__('Custom', 'bighearts'),
                    ],
                    'std' => 'default',
                ],
                [
                    'id' => 'mb_portfolio_featured_image_type',
                    'name' => esc_html__('Featured Image Settings', 'bighearts'),
                    'type' => 'button_group',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_portfolio_featured_image_conditional', '=', 'custom']
                        ]],
                    ],
                    'multiple' => false,
                    'options' => [
                        'off' => esc_html__('Off', 'bighearts'),
                        'replace' => esc_html__('Replace', 'bighearts'),
                    ],
                    'std' => 'off',
                ],
                [
                    'id' => 'mb_portfolio_featured_image_replace',
                    'name' => esc_html__('Featured Image Replace', 'bighearts'),
                    'type' => 'image_advanced',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_portfolio_featured_image_conditional', '=', 'custom'],
                            ['mb_portfolio_featured_image_type', '=', 'replace'],
                        ]],
                    ],
                    'max_file_uploads' => 1,
                ],
                [
                    'id' => 'mb_portfolio_title',
                    'name' => esc_html__('Show Title on single', 'bighearts'),
                    'type' => 'switch',
                    'std' => 'true',
                ],
                [
                    'id' => 'mb_portfolio_link',
                    'name' => esc_html__('Add Custom Link for Portfolio Grid', 'bighearts'),
                    'type' => 'switch',
                ],
                [
                    'id' => 'portfolio_custom_url',
                    'name' => esc_html__( 'Custom URL for Portfolio Grid', 'bighearts' ),
                    'type' => 'text',
                    'attributes' => [
                        'data-conditional-logic' => [ [
                            [ 'mb_portfolio_link', '=', '1' ]
                        ] ],
                    ],
                    'class' => 'field-inputs',
                ],
                [
                    'id' => 'mb_portfolio_info_items',
                    'name' => esc_html__('Info', 'bighearts'),
                    'type' => 'social',
                    'desc' => esc_html__('Description', 'bighearts'),
                    'clone' => true,
                    'sort_clone' => true,
                    'options' => [
                        'name' => [
                            'name' => esc_html__('Name', 'bighearts'),
                            'type_input' => 'text'
                        ],
                        'description' => [
                            'name' => esc_html__('Description', 'bighearts'),
                            'type_input' => 'text'
                        ],
                        'link' => [
                            'name' => esc_html__('Url', 'bighearts'),
                            'type_input' => 'text'
                        ],
                    ],
                ],
                [
                    'id' => 'mb_portfolio_single_meta_categories',
                    'name' => esc_html__( 'Categories', 'bighearts' ),
                    'type' => 'button_group',
                    'multiple' => false,
                    'options' => [
                        'default' => esc_html__( 'Default', 'bighearts' ),
                        true => esc_html__( 'Enable', 'bighearts' ),
                        false => esc_html__( 'Disable', 'bighearts' ),
                    ],
                    'std' => 'default',
                ],
                [
                    'id' => 'mb_portfolio_single_meta_date',
                    'name' => esc_html__( 'Date', 'bighearts' ),
                    'type' => 'button_group',
                    'multiple' => false,
                    'options' => [
                        'default' => esc_html__( 'Default', 'bighearts' ),
                        true => esc_html__( 'Enable', 'bighearts' ),
                        false => esc_html__( 'Disable', 'bighearts' ),
                    ],
                    'std' => 'default',
                ],
                [
                    'id' => 'mb_portfolio_above_content_cats',
                    'name' => esc_html__( 'Tags', 'bighearts' ),
                    'type' => 'button_group',
                    'multiple' => false,
                    'options' => [
                        'default' => esc_html__( 'Default', 'bighearts' ),
                        true => esc_html__( 'Enable', 'bighearts' ),
                        false => esc_html__( 'Disable', 'bighearts' ),
                    ],
                    'std' => 'default',
                ],
                [
                    'id' => 'mb_portfolio_above_content_share',
                    'name' => esc_html__( 'Shares', 'bighearts' ),
                    'type' => 'button_group',
                    'multiple' => false,
                    'options' => [
                        'default' => esc_html__('Default', 'bighearts' ),
                        true => esc_html__( 'Enable', 'bighearts' ),
                        false => esc_html__( 'Disable', 'bighearts' ),
                    ],
                    'std' => 'default',
                ],
            ],
        ];

        return $meta_boxes;
    }

    public function portfolio_post_settings_meta_boxes($meta_boxes)
    {
        $meta_boxes[] = [
            'title' => esc_html__('Portfolio Post Settings', 'bighearts'),
            'post_types' => ['portfolio'],
            'context' => 'advanced',
            'fields' => [
                [
                    'id' => 'mb_portfolio_post_conditional',
                    'name' => esc_html__('Post Layout', 'bighearts'),
                    'type' => 'button_group',
                    'multiple' => false,
                    'options' => [
                        'default' => esc_html__('Default', 'bighearts'),
                        'custom' => esc_html__('Custom', 'bighearts'),
                    ],
                    'std' => 'default',
                ],
                [
                    'name' => esc_html__('Post Layout Settings', 'bighearts'),
                    'type' => 'wgl_heading',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_portfolio_post_conditional', '=', 'custom']
                        ]],
                    ],
                ],
                [
                    'id' => 'mb_portfolio_single_type_layout',
                    'name' => esc_html__('Layout', 'bighearts'),
                    'type' => 'button_group',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_portfolio_post_conditional', '=', 'custom']
                        ]],
                    ],
                    'multiple' => false,
                    'options' => [
                        '1' => esc_html__('Title First', 'bighearts'),
                        '2' => esc_html__('Image First', 'bighearts'),
                    ],
                    'std' => '2',
                ],
            ],
        ];

        return $meta_boxes;
    }

    public function portfolio_related_meta_boxes($meta_boxes)
    {
        $meta_boxes[] = [
            'title' => esc_html__('Related Portfolio', 'bighearts'),
            'post_types' => ['portfolio'],
            'context' => 'advanced',
            'fields' => [
                [
                    'id' => 'mb_portfolio_related_switch',
                    'name' => esc_html__('Portfolio Related', 'bighearts'),
                    'type' => 'button_group',
                    'inline' => true,
                    'multiple' => false,
                    'options' => [
                        'default' => esc_html__('Default', 'bighearts'),
                        'on' => esc_html__('On', 'bighearts'),
                        'off' => esc_html__('Off', 'bighearts'),
                    ],
                    'std' => 'default'
                ],
                [
                    'name' => esc_html__('Portfolio Related Settings', 'bighearts'),
                    'type' => 'wgl_heading',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_portfolio_related_switch', '=', 'on']
                        ]],
                    ],
                ],
                [
                    'id' => 'mb_pf_carousel_r',
                    'name' => esc_html__('Display items carousel for this portfolio post', 'bighearts'),
                    'type' => 'switch',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_portfolio_related_switch', '=', 'on']
                        ]],
                    ],
                    'std' => 1,
                ],
                [
                    'id' => 'mb_pf_title_r',
                    'name' => esc_html__('Title', 'bighearts'),
                    'type' => 'text',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_portfolio_related_switch', '=', 'on']
                        ]],
                    ],
                    'std' => esc_html__('Related Portfolio', 'bighearts'),
                ],
                [
                    'id' => 'mb_pf_cat_r',
                    'name' => esc_html__('Categories', 'bighearts'),
                    'type' => 'taxonomy_advanced',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_portfolio_related_switch', '=', 'on']
                        ]],
                    ],
                    'multiple' => true,
                    'taxonomy' => 'portfolio-category',
                ],
                [
                    'id' => 'mb_pf_column_r',
                    'name' => esc_html__('Columns', 'bighearts'),
                    'type' => 'button_group',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_portfolio_related_switch', '=', 'on']
                        ]],
                    ],
                    'multiple' => false,
                    'options' => [
                        '2' => esc_html__('2', 'bighearts'),
                        '3' => esc_html__('3', 'bighearts'),
                        '4' => esc_html__('4', 'bighearts'),
                    ],
                    'std' => '3',
                ],
                [
                    'id' => 'mb_pf_number_r',
                    'name' => esc_html__('Number of Related Items', 'bighearts'),
                    'type' => 'number',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_portfolio_related_switch', '=', 'on']
                        ]],
                    ],
                    'min' => 0,
                    'step' => 1,
                    'std' => 3,
                ],
            ],
        ];

        return $meta_boxes;
    }

    public function blog_settings_meta_boxes($meta_boxes)
    {
        $meta_boxes[] = [
            'title' => esc_html__('Post Settings', 'bighearts'),
            'post_types' => ['post'],
            'context' => 'advanced',
            'fields' => [
                [
                    'name' => esc_html__('Post Layout Settings', 'bighearts'),
                    'type' => 'wgl_heading',
                ],
                [
                    'id' => 'mb_post_layout_conditional',
                    'name' => esc_html__('Post Layout', 'bighearts'),
                    'type' => 'button_group',
                    'multiple' => false,
                    'options' => [
                        'default' => esc_html__('Default', 'bighearts'),
                        'custom' => esc_html__('Custom', 'bighearts'),
                    ],
                    'std' => 'default',
                ],
                [
                    'id' => 'mb_single_type_layout',
                    'name' => esc_html__('Post Layout Type', 'bighearts'),
                    'type' => 'button_group',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_post_layout_conditional', '=', 'custom']
                        ]],
                    ],
                    'multiple' => false,
                    'options' => [
                        '1' => esc_html__('Title First', 'bighearts'),
                        '2' => esc_html__('Image First', 'bighearts'),
                        '3' => esc_html__('Overlay Image', 'bighearts'),
                    ],
                    'std' => '1',
                ],
                [
                    'id' => 'mb_single_padding_layout_3',
                    'name' => esc_html__('Padding Top/Bottom', 'bighearts'),
                    'type' => 'wgl_offset',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_post_layout_conditional', '=', 'custom'],
                            ['mb_single_type_layout', '=', '3'],
                        ]],
                    ],
                    'options' => [
                        'mode' => 'padding',
                        'top' => true,
                        'right' => false,
                        'bottom' => true,
                        'left' => false,
                    ],
                    'std' => [
                        'padding-top' => esc_attr(BigHearts::get_option('single_padding_layout_3')['padding-top']),
                        'padding-bottom' => esc_attr(BigHearts::get_option('single_padding_layout_3')['padding-bottom']),
                    ],
                ],
                [
                    'id' => 'mb_single_apply_animation',
                    'name' => esc_html__('Apply Animation', 'bighearts'),
                    'type' => 'switch',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_post_layout_conditional', '=', 'custom'],
                            ['mb_single_type_layout', '=', '3'],
                        ]],
                    ],
                    'std' => 1,
                ],
                [
                    'name' => esc_html__('Featured Image Settings', 'bighearts'),
                    'type' => 'wgl_heading',
                ],
                [
                    'id' => 'mb_featured_image_conditional',
                    'name' => esc_html__('Featured Image', 'bighearts'),
                    'type' => 'button_group',
                    'multiple' => false,
                    'options' => [
                        'default' => esc_html__('Default', 'bighearts'),
                        'custom' => esc_html__('Custom', 'bighearts'),
                    ],
                    'std' => 'default',
                ],
                [
                    'id' => 'mb_featured_image_type',
                    'name' => esc_html__('Featured Image Settings', 'bighearts'),
                    'type' => 'button_group',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_featured_image_conditional', '=', 'custom']
                        ]],
                    ],
                    'multiple' => false,
                    'options' => [
                        'off' => esc_html__('Off', 'bighearts'),
                        'replace' => esc_html__('Replace', 'bighearts'),
                    ],
                    'std' => 'off',
                ],
                [
                    'id' => 'mb_featured_image_replace',
                    'name' => esc_html__('Featured Image Replace', 'bighearts'),
                    'type' => 'image_advanced',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_featured_image_conditional', '=', 'custom'],
                            ['mb_featured_image_type', '=', 'replace'],
                        ]],
                    ],
                    'max_file_uploads' => 1,
                ],
            ],
        ];

        return $meta_boxes;
    }

    public function blog_meta_boxes($meta_boxes)
    {
        $meta_boxes[] = [
            'title' => esc_html__('Post Format Layout', 'bighearts'),
            'post_types' => ['post'],
            'context' => 'advanced',
            'fields' => [
                // Standard Post Format
                [
                    'id' => 'post_format_standard',
                    'name' => esc_html__('Standard Post( Enabled only Featured Image for this post format)', 'bighearts'),
                    'type' => 'static-text',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['formatdiv', '=', '0']
                        ]],
                    ],
                ],
                // Gallery Post Format
                [
                    'name' => esc_html__('Gallery Settings', 'bighearts'),
                    'type' => 'wgl_heading',
                ],
                [
                    'id' => 'post_format_gallery',
                    'name' => esc_html__('Add Images', 'bighearts'),
                    'type' => 'image_advanced',
                    'max_file_uploads' => '',
                ],
                // Video Post Format
                [
                    'name' => esc_html__('Video Settings', 'bighearts'),
                    'type' => 'wgl_heading',
                ],
                [
                    'id' => 'post_format_video_style',
                    'name' => esc_html__('Video Style', 'bighearts'),
                    'type' => 'select',
                    'multiple' => false,
                    'options' => [
                        'bg_video' => esc_html__('Background Video', 'bighearts'),
                        'popup' => esc_html__('Popup', 'bighearts'),
                    ],
                    'std' => 'bg_video',
                ],
                [
                    'id' => 'start_video',
                    'name' => esc_html__('Start Video', 'bighearts'),
                    'type' => 'number',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['post_format_video_style', '=', 'bg_video'],
                        ]],
                    ],
                    'std' => '0',
                ],
                [
                    'id' => 'end_video',
                    'name' => esc_html__('End Video', 'bighearts'),
                    'type' => 'number',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['post_format_video_style', '=', 'bg_video'],
                        ]],
                    ],
                ],
                [
                    'id' => 'post_format_video_url',
                    'name' => esc_html__('oEmbed URL', 'bighearts'),
                    'type' => 'oembed',
                ],
                // Quote Post Format
                [
                    'name' => esc_html__('Quote Settings', 'bighearts'),
                    'type' => 'wgl_heading',
                ],
                [
                    'id' => 'post_format_qoute_text',
                    'name' => esc_html__('Quote Text', 'bighearts'),
                    'type' => 'textarea',
                ],
                [
                    'id' => 'post_format_qoute_name',
                    'name' => esc_html__('Author Name', 'bighearts'),
                    'type' => 'text',
                ],
                [
                    'id' => 'post_format_qoute_position',
                    'name' => esc_html__('Author Position', 'bighearts'),
                    'type' => 'text',
                ],
                [
                    'id' => 'post_format_qoute_avatar',
                    'name' => esc_html__('Author Avatar', 'bighearts'),
                    'type' => 'image_advanced',
                    'max_file_uploads' => 1,
                ],
                // Audio Post Format
                [
                    'name' => esc_html__('Audio Settings', 'bighearts'),
                    'type' => 'wgl_heading',
                ],
                [
                    'id' => 'post_format_audio_url',
                    'name' => esc_html__('oEmbed URL', 'bighearts'),
                    'type' => 'oembed',
                ],
                // Link Post Format
                [
                    'name' => esc_html__('Link Settings', 'bighearts'),
                    'type' => 'wgl_heading',
                ],
                [
                    'id' => 'post_format_link_url',
                    'name' => esc_html__('URL', 'bighearts'),
                    'type' => 'url',
                ],
                [
                    'id' => 'post_format_link_text',
                    'name' => esc_html__('Text', 'bighearts'),
                    'type' => 'text',
                ],
            ]
        ];

        return $meta_boxes;
    }

    public function blog_related_meta_boxes($meta_boxes)
    {
        $meta_boxes[] = [
            'title' => esc_html__('Related Blog Post', 'bighearts'),
            'post_types' => ['post'],
            'context' => 'advanced',
            'fields' => [
                [
                    'id' => 'mb_blog_show_r',
                    'name' => esc_html__('Related Options', 'bighearts'),
                    'type' => 'button_group',
                    'multiple' => false,
                    'options' => [
                        'default' => esc_html__('Default', 'bighearts'),
                        'custom' => esc_html__('Custom', 'bighearts'),
                        'off' => esc_html__('Off', 'bighearts'),
                    ],
                    'std' => 'default',
                ],
                [
                    'name' => esc_html__('Related Settings', 'bighearts'),
                    'type' => 'wgl_heading',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_blog_show_r', '=', 'custom']
                        ]],
                    ],
                ],
                [
                    'id' => 'mb_blog_title_r',
                    'name' => esc_html__('Title', 'bighearts'),
                    'type' => 'text',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_blog_show_r', '=', 'custom']
                        ]],
                    ],
                    'std' => esc_html__('Related Posts', 'bighearts'),
                ],
                [
                    'id' => 'mb_blog_cat_r',
                    'name' => esc_html__('Categories', 'bighearts'),
                    'type' => 'taxonomy_advanced',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_blog_show_r', '=', 'custom']
                        ]],
                    ],
                    'multiple' => true,
                    'taxonomy' => 'category',
                ],
                [
                    'id' => 'mb_blog_column_r',
                    'name' => esc_html__('Columns', 'bighearts'),
                    'type' => 'button_group',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_blog_show_r', '=', 'custom']
                        ]],
                    ],
                    'multiple' => false,
                    'options' => [
                        '12' => esc_html__('1', 'bighearts'),
                        '6' => esc_html__('2', 'bighearts'),
                        '4' => esc_html__('3', 'bighearts'),
                        '3' => esc_html__('4', 'bighearts'),
                    ],
                    'std' => '6',
                ],
                [
                    'name' => esc_html__('Number of Related Items', 'bighearts'),
                    'id' => 'mb_blog_number_r',
                    'type' => 'number',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_blog_show_r', '=', 'custom']
                        ]],
                    ],
                    'min' => 0,
                    'std' => 2,
                ],
                [
                    'id' => 'mb_blog_carousel_r',
                    'name' => esc_html__('Display items carousel for this blog post', 'bighearts'),
                    'type' => 'switch',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_blog_show_r', '=', 'custom']
                        ]],
                    ],
                    'std' => 1,
                ],
            ],
        ];

        return $meta_boxes;
    }

    public function page_layout_meta_boxes($meta_boxes)
    {
        $meta_boxes[] = [
            'title' => esc_html__('Page Sidebar Layout', 'bighearts'),
            'post_types' => ['page' , 'post', 'team', 'portfolio', 'product', 'give_forms'],
            'context' => 'advanced',
            'fields' => [
                [
                    'name' => esc_html__('Page Sidebar Layout', 'bighearts'),
                    'id' => 'mb_page_sidebar_layout',
                    'type' => 'wgl_image_select',
                    'options' => [
                        'default' => get_template_directory_uri() . '/core/admin/img/options/1c.png',
                        'none' => get_template_directory_uri() . '/core/admin/img/options/none.png',
                        'left' => get_template_directory_uri() . '/core/admin/img/options/2cl.png',
                        'right' => get_template_directory_uri() . '/core/admin/img/options/2cr.png',
                    ],
                    'std' => 'default',
                ],
                [
                    'name' => esc_html__('Sidebar Settings', 'bighearts'),
                    'type' => 'wgl_heading',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_sidebar_layout', '!=', 'default'],
                            ['mb_page_sidebar_layout', '!=', 'none'],
                        ]],
                    ],
                ],
                [
                    'id' => 'mb_page_sidebar_def',
                    'name' => esc_html__('Page Sidebar', 'bighearts'),
                    'type' => 'select',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_sidebar_layout', '!=', 'default'],
                            ['mb_page_sidebar_layout', '!=', 'none'],
                        ]],
                    ],
                    'placeholder' => esc_html__('Select a Sidebar', 'bighearts'),
                    'multiple' => false,
                    'options' => bighearts_get_all_sidebars(),
                ],
                [
                    'id' => 'mb_page_sidebar_def_width',
                    'name' => esc_html__('Page Sidebar Width', 'bighearts'),
                    'type' => 'button_group',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_sidebar_layout', '!=', 'default'],
                            ['mb_page_sidebar_layout', '!=', 'none'],
                        ]],
                    ],
                    'multiple' => false,
                    'options' => [
                        '9' => esc_html('25%'),
                        '8' => esc_html('33%'),
                    ],
                    'std' => '9',
                ],
                [
                    'id' => 'mb_sticky_sidebar',
                    'name' => esc_html__('Sticky Sidebar?', 'bighearts'),
                    'type' => 'switch',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_sidebar_layout', '!=', 'default'],
                            ['mb_page_sidebar_layout', '!=', 'none'],
                        ]],
                    ],
                ],
                [
                    'id' => 'mb_sidebar_gap',
                    'name' => esc_html__('Sidebar Side Gap', 'bighearts'),
                    'type' => 'select',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_sidebar_layout', '!=', 'default'],
                            ['mb_page_sidebar_layout', '!=', 'none'],
                        ]],
                    ],
                    'multiple' => false,
                    'options' => [
                        'def' => esc_html__('Default', 'bighearts'),
                        '0' => esc_html__('0', 'bighearts'),
                        '15' => esc_html__('15', 'bighearts'),
                        '20' => esc_html__('20', 'bighearts'),
                        '25' => esc_html__('25', 'bighearts'),
                        '30' => esc_html__('30', 'bighearts'),
                        '35' => esc_html__('35', 'bighearts'),
                        '40' => esc_html__('40', 'bighearts'),
                        '45' => esc_html__('45', 'bighearts'),
                        '50' => esc_html__('50', 'bighearts'),
                    ],
                    'std' => 'def',
                ],
            ]
        ];

        return $meta_boxes;
    }

    public function page_color_meta_boxes($meta_boxes)
    {
        $meta_boxes[] = [
            'title' => esc_html__('Page Colors', 'bighearts'),
            'post_types' => ['page' , 'post', 'team', 'portfolio', 'give_forms'],
            'context' => 'advanced',
            'fields' => [
                [
                    'id' => 'mb_page_colors_switch',
                    'name' => esc_html__('Page Colors', 'bighearts'),
                    'type' => 'button_group',
                    'inline' => true,
                    'multiple' => false,
                    'options' => [
                        'default' => esc_html__('Default', 'bighearts'),
                        'custom' => esc_html__('Custom', 'bighearts'),
                    ],
                    'std' => 'default',
                ],
                [
                    'name' => esc_html__('Main', 'bighearts'),
                    'type' => 'wgl_heading',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_colors_switch', '=', 'custom']
                        ]],
                    ],
                ],
                [
                    'id' => 'mb_theme-primary-color',
                    'name' => esc_html__('Primary Theme Color', 'bighearts'),
                    'type' => 'color',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_colors_switch', '=', 'custom'],
                        ]],
                    ],
                    'validate' => 'color',
                    'js_options' => ['defaultColor' => BigHearts_Globals::get_primary_color()],
                    'std' => BigHearts_Globals::get_primary_color(),
                ],
                [
                    'id' => 'mb_theme-secondary-color',
                    'name' => esc_html__('Secondary Theme Color', 'bighearts'),
                    'type' => 'color',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_colors_switch', '=', 'custom'],
                        ]],
                    ],
                    'validate' => 'color',
                    'js_options' => ['defaultColor' => BigHearts_Globals::get_secondary_color()],
                    'std' => BigHearts_Globals::get_secondary_color(),
                ],
                [
                    'id' => 'mb_body_background_color',
                    'name' => esc_html__('Body Background Color', 'bighearts'),
                    'type' => 'color',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_colors_switch', '=', 'custom'],
                        ]],
                    ],
                    'validate' => 'color',
                    'js_options' => ['defaultColor' => '#ffffff'],
                    'std' => '#ffffff',
                ],
                [
                    'name' => esc_html__('Button', 'bighearts'),
                    'type' => 'wgl_heading',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_colors_switch', '=', 'custom']
                        ]],
                    ],
                ],
                [
                    'id' => 'mb_button-color-idle',
                    'name' => esc_html__('Button Idle Color', 'bighearts'),
                    'type' => 'color',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_colors_switch', '=', 'custom'],
                        ]],
                    ],
                    'validate' => 'color',
                    'js_options' => [
                        'defaultColor' => esc_attr(BigHearts::get_option('button-color-idle'))
                    ],
                    'std' => esc_attr(BigHearts::get_option('button-color-idle')),
                ],
                [
                    'id' => 'mb_button-color-hover',
                    'name' => esc_html__('Button Hover Color', 'bighearts'),
                    'type' => 'color',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_colors_switch', '=', 'custom'],
                        ]],
                    ],
                    'validate' => 'color',
                    'js_options' => [
                        'defaultColor' => esc_attr(BigHearts::get_option('button-color-hover'))
                    ],
                    'std' => esc_attr(BigHearts::get_option('button-color-hover')),
                ],
                [
                    'name' => esc_html__('Back to Top', 'bighearts'),
                    'type' => 'wgl_heading',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_colors_switch', '=', 'custom']
                        ]],
                    ],
                ],
                [
                    'id' => 'mb_scroll_up_arrow_color',
                    'name' => esc_html__('Button Arrow Color', 'bighearts'),
                    'type' => 'color',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_colors_switch', '=', 'custom'],
                        ]],
                    ],
                    'validate' => 'color',
                    'js_options' => ['defaultColor' => '#f74f22'],
                    'std' => '#f74f22',
                ],
                [
                    'id' => 'mb_scroll_up_bg_color',
                    'name' => esc_html__('Button Background Color', 'bighearts'),
                    'type' => 'color',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_colors_switch', '=', 'custom'],
                        ]],
                    ],
                    'validate' => 'color',
                    'js_options' => ['defaultColor' => '#ffffff'],
                    'std' => '#ffffff',
                ],
            ]
        ];

        return $meta_boxes;
    }

    public function page_header_meta_boxes($meta_boxes)
    {
        $meta_boxes[] = [
            'title' => esc_html__('Header', 'bighearts'),
            'post_types' => ['page', 'post', 'portfolio', 'product', 'give_forms'],
            'context' => 'advanced',
            'fields' => [
                [
                    'id' => 'mb_customize_header_layout',
                    'name' => esc_html__('Header Settings', 'bighearts'),
                    'type' => 'button_group',
                    'multiple' => false,
                    'options' => [
                        'default' => esc_html__('default', 'bighearts'),
                        'custom' => esc_html__('custom', 'bighearts'),
                        'hide' => esc_html__('hide', 'bighearts'),
                    ],
                    'std' => 'default',
                ],
                [
                    'id' => 'mb_header_content_type',
                    'name' => esc_html__('Header Template', 'bighearts'),
                    'type' => 'button_group',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_customize_header_layout', '=', 'custom']
                        ]],
                    ],
                    'multiple' => false,
                    'options' => [
                        'default' => esc_html__('Default', 'bighearts'),
                        'custom' => esc_html__('Custom', 'bighearts')
                    ],
                    'std' => 'default',
                ],
                [
                    'id' => 'mb_customize_header',
                    'name' => esc_html__('Template', 'bighearts'),
                    'type' => 'post',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_customize_header_layout', '=', 'custom'],
                            ['mb_header_content_type', '=', 'custom'],
                        ]],
                    ],
                    'post_type' => 'header',
                    'multiple' => false,
                    'query_args' => [
                        'post_status' => 'publish',
                        'posts_per_page' => - 1,
                    ],
                    'std' => 'default',
                ],
                [
                    'id' => 'mb_header_sticky',
                    'name' => esc_html__('Sticky Header', 'bighearts'),
                    'type' => 'switch',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_customize_header_layout', '=', 'custom']
                        ]],
                    ],
                    'std' => 1,
                ],
                [
                    'id' => 'mb_sticky_header_content_type',
                    'name' => esc_html__('Sticky Header Template', 'bighearts'),
                    'type' => 'button_group',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_customize_header_layout', '=', 'custom'],
                            ['mb_header_sticky', '=', '1'],
                        ]],
                    ],
                    'multiple' => false,
                    'options' => [
                        'default' => esc_html__('Default', 'bighearts'),
                        'custom' => esc_html__('Custom', 'bighearts')
                    ],
                    'std' => 'default',
                ],
                [
                    'id' => 'mb_customize_sticky_header',
                    'name' => esc_html__('Template', 'bighearts'),
                    'type' => 'post',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_customize_header_layout', '=', 'custom'],
                            ['mb_sticky_header_content_type', '=', 'custom'],
                            ['mb_header_sticky', '=', '1'],
                        ]],
                    ],
                    'multiple' => false,
                    'post_type' => 'header',
                    'query_args' => [
                        'post_status' => 'publish',
                        'posts_per_page' => - 1,
                    ],
                    'std' => 'default',
                ],
                [
                    'id' => 'mb_mobile_menu_custom',
                    'name' => esc_html__('Mobile Menu Template', 'bighearts'),
                    'type' => 'button_group',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_customize_header_layout', '=', 'custom']
                        ]],
                    ],
                    'multiple' => false,
                    'options' => [
                        'default' => esc_html__('Default', 'bighearts'),
                        'custom' => esc_html__('Custom', 'bighearts')
                    ],
                    'std' => 'default',
                ],
                [
                    'id' => 'mb_mobile_menu_header',
                    'name' => esc_html__('Mobile Menu ', 'bighearts'),
                    'type' => 'select',
                    'attributes' => [
                        'data-conditional-logic'  =>  [[
                            ['mb_customize_header_layout', '=', 'custom'],
                            ['mb_mobile_menu_custom', '=', 'custom']
                        ]],
                    ],
                    'multiple' => false,
                    'options' => $menus = bighearts_get_custom_menu(),
                    'default' => reset($menus),
                ],
            ]
        ];

        return $meta_boxes;
    }

    /**
     * @since 1.0.0
     * @version 1.0.9
     */
    public function page_title_meta_boxes($meta_boxes)
    {
        $meta_boxes[] = [
            'title' => esc_html__('Page Title', 'bighearts'),
            'post_types' => ['page', 'post', 'team', 'portfolio', 'product', 'give_forms'],
            'context' => 'advanced',
            'fields' => [
                [
                    'id' => 'mb_page_title_switch',
                    'name' => esc_html__('Page Title', 'bighearts'),
                    'type' => 'button_group',
                    'inline' => true,
                    'multiple' => false,
                    'options' => [
                        'default' => esc_html__('Default', 'bighearts'),
                        'on' => esc_html__('On', 'bighearts'),
                        'off' => esc_html__('Off', 'bighearts'),
                    ],
                    'std' => 'default',
                ],
                [
                    'name' => esc_html__('Page Title Settings', 'bighearts'),
                    'type' => 'wgl_heading',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_switch', '=', 'on']
                        ]],
                    ],
                ],
                [
                    'id' => 'mb_page_title_bg_switch',
                    'name' => esc_html__('Use Background Image/Color?', 'bighearts'),
                    'type' => 'switch',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_switch', '=', 'on']
                        ]],
                    ],
                    'std' => true,
                ],
                [
                    'id' => 'mb_page_title_bg',
                    'name' => esc_html__('Background', 'bighearts'),
                    'type' => 'wgl_background',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_switch', '=', 'on'],
                            ['mb_page_title_bg_switch', '=', true ],
                        ]],
                    ],
                    'image' => '',
                    'position' => 'bottom center',
                    'attachment' => 'scroll',
                    'size' => 'cover',
                    'repeat' => 'no-repeat',
                    'color' => esc_attr(BigHearts::get_option('page_title_bg_image')['background-color']),
                ],
                [
                    'id' => 'mb_page_title_height',
                    'name' => esc_html__('Min Height', 'bighearts'),
                    'type' => 'number',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_switch', '=', 'on'],
                            ['mb_page_title_bg_switch', '=', true],
                        ]],
                    ],
                    'desc' => esc_html__('Choose `0px` in order to use `min-height: auto;`', 'bighearts'),
                    'min' => 0,
                    'std' => esc_attr((int) BigHearts::get_option('page_title_height')['height']),
                ],
                [
                    'id' => 'mb_page_title_align',
                    'name' => esc_html__('Title Alignment', 'bighearts'),
                    'type' => 'button_group',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_switch', '=', 'on']
                        ]],
                    ],
                    'multiple' => false,
                    'options' => [
                        'left' => esc_html__('left', 'bighearts'),
                        'center' => esc_html__('center', 'bighearts'),
                        'right' => esc_html__('right', 'bighearts'),
                    ],
                    'std' => esc_attr(BigHearts::get_option('page_title_align')),
                ],
                [
                    'id' => 'mb_page_title_padding',
                    'name' => esc_html__('Paddings Top/Bottom', 'bighearts'),
                    'type' => 'wgl_offset',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_switch', '=', 'on']
                        ]],
                    ],
                    'options' => [
                        'mode' => 'padding',
                        'top' => true,
                        'right' => false,
                        'bottom' => true,
                        'left' => false,
                    ],
                    'std' => [
                        'padding-top' => esc_attr((int) BigHearts::get_option('page_title_padding')['padding-top'] ?? ''),
                        'padding-bottom' => esc_attr((int) BigHearts::get_option('page_title_padding')['padding-bottom'] ?? ''),
                    ],
                ],
                [
                    'id' => 'mb_page_title_margin',
                    'name' => esc_html__('Margin Bottom', 'bighearts'),
                    'type' => 'wgl_offset',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_switch', '=', 'on']
                        ]],
                    ],
                    'options' => [
                        'mode' => 'margin',
                        'top' => false,
                        'right' => false,
                        'bottom' => true,
                        'left' => false,
                    ],
                    'std' => ['margin-bottom' => esc_attr((int) BigHearts::get_option('page_title_margin')['margin-bottom'] ?? '')],
                ],
                [
                    'id' => 'mb_page_title_border_switch',
                    'name' => esc_html__('Border Top Switch', 'bighearts'),
                    'type' => 'switch',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_switch', '=', 'on']
                        ]],
                    ],
                ],
                [
                    'id' => 'mb_page_title_border_color',
                    'name' => esc_html__('Border Top Color', 'bighearts'),
                    'type' => 'color',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_border_switch', '=',true]
                        ]],
                    ],
                    'js_options' => ['defaultColor' => '#e5e5e5'],
                    'std' => '#e5e5e5',
                ],
                [
                    'id' => 'mb_page_title_parallax',
                    'name' => esc_html__('Parallax Switch', 'bighearts'),
                    'type' => 'switch',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_switch', '=', 'on']
                        ]],
                    ],
                ],
                [
                    'id' => 'mb_page_title_parallax_speed',
                    'name' => esc_html__('Parallax Speed', 'bighearts'),
                    'type' => 'number',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_parallax', '=', true],
                            ['mb_page_title_switch', '=', 'on'],
                        ]],
                    ],
                    'step' => 0.1,
                    'std' => 0.3,
                ],
                [
                    'id' => 'mb_page_change_tile_switch',
                    'name' => esc_html__('Custom Page Title Text', 'bighearts'),
                    'type' => 'switch',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_switch', '=', 'on']
                        ]],
                    ],
                ],
                [
                    'id' => 'mb_page_change_tile',
                    'name' => esc_html__('Page Title Text', 'bighearts'),
                    'type' => 'text',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_change_tile_switch', '=', '1'],
                            ['mb_page_title_switch', '=', 'on'],
                        ]],
                    ],
                ],
                [
                    'id' => 'mb_page_title_tag',
                    'name' => esc_html__('Title HTML tag', 'bighearts'),
                    'type' => 'select',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_switch', '=', 'on']
                        ]],
                    ],
                    'options' => [
                        'def' => 'Theme Default',
                        'div' => '‹div›',
                        'h1' => '‹h1›',
                        'h2' => '‹h2›',
                        'h3' => '‹h3›',
                        'h4' => '‹h4›',
                        'h5' => '‹h5›',
                        'h6' => '‹h6›',
                    ],
                    'default' => 'def'
                ],
                [
                    'id' => 'mb_page_title_breadcrumbs_switch',
                    'name' => esc_html__('Show Breadcrumbs', 'bighearts'),
                    'type' => 'switch',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_switch', '=', 'on']
                        ]],
                    ],
                    'std' => 1,
                ],
                [
                    'id' => 'mb_page_title_breadcrumbs_align',
                    'name' => esc_html__('Breadcrumbs Alignment', 'bighearts'),
                    'type' => 'button_group',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_switch', '=', 'on'],
                            ['mb_page_title_breadcrumbs_switch', '=', '1']
                        ]],
                    ],
                    'multiple' => false,
                    'options' => [
                        'left' => esc_html__('left', 'bighearts'),
                        'center' => esc_html__('center', 'bighearts'),
                        'right' => esc_html__('right', 'bighearts'),
                    ],
                    'std' => esc_attr(BigHearts::get_option('page_title_breadcrumbs_align')),
                ],
                [
                    'id' => 'mb_page_title_breadcrumbs_block_switch',
                    'name' => esc_html__('Breadcrumbs Full Width', 'bighearts'),
                    'type' => 'switch',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_switch', '=', 'on'],
                            ['mb_page_title_breadcrumbs_switch', '=', '1']
                        ]],
                    ],
                    'std' => true,
                ],
                [
                    'name' => esc_html__('Page Title Typography', 'bighearts'),
                    'type' => 'wgl_heading',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_switch', '=', 'on']
                        ]],
                    ],
                ],
                [
                    'id' => 'mb_page_title_font',
                    'name' => esc_html__('Page Title Font', 'bighearts'),
                    'type' => 'wgl_font',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_switch', '=', 'on']
                        ]],
                    ],
                    'options' => [
                        'font-size' => true,
                        'line-height' => true,
                        'font-weight' => false,
                        'color' => true,
                    ],
                    'std' => [
                        'font-size' => '48',
                        'line-height' => '62',
                        'color' => '#ffffff',
                    ],
                ],
                [
                    'id' => 'mb_page_title_breadcrumbs_font',
                    'name' => esc_html__('Page Title Breadcrumbs Font', 'bighearts'),
                    'type' => 'wgl_font',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_switch', '=', 'on']
                        ]],
                    ],
                    'options' => [
                        'font-size' => true,
                        'line-height' => true,
                        'font-weight' => false,
                        'color' => true,
                    ],
                    'std' => [
                        'font-size' => esc_attr((int) BigHearts::get_option('page_title_breadcrumbs_font')['font-size']),
                        'line-height' => esc_attr((int) BigHearts::get_option('page_title_breadcrumbs_font')['line-height']),
                        'color' => esc_attr(BigHearts::get_option('page_title_breadcrumbs_font')['color']),
                    ],
                ],
                [
                    'name' => esc_html__('Responsive Layout', 'bighearts'),
                    'type' => 'wgl_heading',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_switch', '=', 'on']
                        ]],
                    ],
                ],
                [
                    'id' => 'mb_page_title_resp_switch',
                    'name' => esc_html__('Responsive Layout On/Off', 'bighearts'),
                    'type' => 'switch',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_switch', '=', 'on']
                        ]],
                    ],
                ],
                [
                    'id' => 'mb_page_title_resp_resolution',
                    'name' => esc_html__('Screen breakpoint', 'bighearts'),
                    'type' => 'number',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_switch', '=', 'on'],
                            ['mb_page_title_resp_switch', '=', '1'],
                        ]],
                    ],
                    'min' => 1,
                    'std' => esc_attr(BigHearts::get_option('page_title_resp_resolution')),
                ],
                [
                    'id' => 'mb_page_title_resp_padding',
                    'name' => esc_html__('Padding Top/Bottom', 'bighearts'),
                    'type' => 'wgl_offset',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_switch', '=', 'on'],
                            ['mb_page_title_resp_switch', '=', '1'],
                        ]],
                    ],
                    'options' => [
                        'mode' => 'padding',
                        'top' => true,
                        'right' => false,
                        'bottom' => true,
                        'left' => false,
                    ],
                    'std' => [
                        'padding-top' => esc_attr(BigHearts::get_option('page_title_resp_padding')['padding-top']),
                        'padding-bottom' => esc_attr(BigHearts::get_option('page_title_resp_padding')['padding-bottom']),
                    ],
                ],
                [
                    'id' => 'mb_page_title_resp_font',
                    'name' => esc_html__('Page Title Font', 'bighearts'),
                    'type' => 'wgl_font',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_switch', '=', 'on'],
                            ['mb_page_title_resp_switch', '=', '1'],
                        ]],
                    ],
                    'options' => [
                        'font-size' => true,
                        'line-height' => true,
                        'font-weight' => false,
                        'color' => true,
                    ],
                    'std' => [
                        'font-size' => '38',
                        'line-height' => '48',
                        'color' => '#ffffff',
                    ],
                ],
                [
                    'id' => 'mb_page_title_resp_breadcrumbs_switch',
                    'name' => esc_html__('Show Breadcrumbs', 'bighearts'),
                    'type' => 'switch',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_switch', '=', 'on'],
                            ['mb_page_title_resp_switch', '=', '1'],
                        ]],
                    ],
                    'std' => 1,
                ],
                [
                    'id' => 'mb_page_title_resp_breadcrumbs_font',
                    'name' => esc_html__('Page Title Breadcrumbs Font', 'bighearts'),
                    'type' => 'wgl_font',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_page_title_switch', '=', 'on'],
                            ['mb_page_title_resp_switch', '=', '1'],
                            ['mb_page_title_resp_breadcrumbs_switch', '=', '1'],
                        ]],
                    ],
                    'options' => [
                        'font-size' => true,
                        'line-height' => true,
                        'font-weight' => false,
                        'color' => true,
                    ],
                    'std' => [
                        'font-size' => esc_attr((int) BigHearts::get_option('page_title_breadcrumbs_font')['font-size']),
                        'line-height' => esc_attr((int) BigHearts::get_option('page_title_breadcrumbs_font')['line-height']),
                        'color' => esc_attr(BigHearts::get_option('page_title_breadcrumbs_font')['color']),
                    ],
                ],
            ],
        ];

        return $meta_boxes;
    }

    public function page_side_panel_meta_boxes($meta_boxes)
    {
        $meta_boxes[] = [
            'title' => esc_html__('Side Panel', 'bighearts'),
            'post_types' => ['page'],
            'context' => 'advanced',
            'fields' => [
                [
                    'id' => 'mb_customize_side_panel',
                    'name' => esc_html__('Side Panel', 'bighearts'),
                    'type' => 'button_group',
                    'multiple' => false,
                    'inline' => true,
                    'options' => [
                        'default' => esc_html__('Default', 'bighearts'),
                        'custom' => esc_html__('Custom', 'bighearts'),
                    ],
                    'std' => 'default',
                ],
                [
                    'name' => esc_html__('Side Panel Settings', 'bighearts'),
                    'type' => 'wgl_heading',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_customize_side_panel', '=', 'custom']
                        ]],
                    ],
                ],
                [
                    'id' => 'mb_side_panel_content_type',
                    'name' => esc_html__('Content Type', 'bighearts'),
                    'type' => 'button_group',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_customize_side_panel', '=', 'custom']
                        ]],
                    ],
                    'multiple' => false,
                    'options' => [
                        'widgets' => esc_html__('Widgets', 'bighearts'),
                        'pages' => esc_html__('Page', 'bighearts')
                    ],
                    'std' => 'widgets',
                ],
                [
                    'id' => 'mb_side_panel_page_select',
                    'name' => esc_html__('Select a page', 'bighearts'),
                    'type' => 'post',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_customize_side_panel', '=', 'custom'],
                            ['mb_side_panel_content_type', '=', 'pages']
                        ]],
                    ],
                    'post_type' => 'side_panel',
                    'field_type' => 'select_advanced',
                    'placeholder' => esc_html__('Select a page', 'bighearts'),
                    'query_args' => [
                        'post_status' => 'publish',
                        'posts_per_page' => - 1,
                    ],
                ],
                [
                    'id' => 'mb_side_panel_spacing',
                    'name' => esc_html__('Paddings', 'bighearts'),
                    'type' => 'wgl_offset',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_customize_side_panel', '=', 'custom']
                        ]],
                    ],
                    'options' => [
                        'mode' => 'padding',
                        'top' => true,
                        'right' => true,
                        'bottom' => true,
                        'left' => true,
                    ],
                    'std' => [
                        'padding-top' => esc_attr(BigHearts::get_option('side_panel_spacing')['padding-top'] ?? ''),
                        'padding-right' => esc_attr(BigHearts::get_option('side_panel_spacing')['padding-right'] ?? ''),
                        'padding-bottom' => esc_attr(BigHearts::get_option('side_panel_spacing')['padding-bottom'] ?? ''),
                        'padding-left' => esc_attr(BigHearts::get_option('side_panel_spacing')['padding-left'] ?? ''),
                    ],
                ],
                [
                    'id' => 'mb_side_panel_title_color',
                    'name' => esc_html__('Title Color', 'bighearts'),
                    'type' => 'color',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_customize_side_panel', '=', 'custom']
                        ]],
                    ],
                    'js_options' => ['defaultColor' => esc_attr(BigHearts::get_option('side_panel_title_color'))],
                    'std' => esc_attr(BigHearts::get_option('side_panel_title_color')),
                ],
                [
                    'id' => 'mb_side_panel_text_color',
                    'name' => esc_html__('Text Color', 'bighearts'),
                    'type' => 'color',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_customize_side_panel', '=', 'custom']
                        ]],
                    ],
                    'js_options' => [
                        'defaultColor' => esc_attr(BigHearts::get_option('side_panel_text_color')['rgba'] ?? '')
                    ],
                    'std' => esc_attr(BigHearts::get_option('side_panel_text_color')['rgba'] ?? ''),
                ],
                [
                    'id' => 'mb_side_panel_bg',
                    'name' => esc_html__('Background Color', 'bighearts'),
                    'type' => 'color',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_customize_side_panel', '=', 'custom']
                        ]],
                    ],
                    'alpha_channel' => true,
                    'js_options' => [
                        'defaultColor' => esc_attr(BigHearts::get_option('side_panel_bg')['rgba'] ?? '')
                    ],
                    'std' => esc_attr(BigHearts::get_option('side_panel_bg')['rgba'] ?? ''),
                ],
                [
                    'id' => 'mb_side_panel_text_alignment',
                    'name' => esc_html__('Text Align', 'bighearts'),
                    'type' => 'button_group',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_customize_side_panel', '=', 'custom']
                        ]],
                    ],
                    'multiple' => false,
                    'options' => [
                        'left' => esc_html__('Left', 'bighearts'),
                        'center' => esc_html__('Center', 'bighearts'),
                        'right' => esc_html__('Right', 'bighearts'),
                    ],
                    'std' => esc_attr(BigHearts::get_option('side_panel_text_alignment')),
                ],
                [
                    'id' => 'mb_side_panel_width',
                    'name' => esc_html__('Width', 'bighearts'),
                    'type' => 'number',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_customize_side_panel', '=', 'custom']
                        ]],
                    ],
                    'min' => 0,
                    'std' => esc_attr(BigHearts_Theme_Helper::get_option('side_panel_width')['width'] ?? ''),
                ],
                [
                    'id' => 'mb_side_panel_position',
                    'name' => esc_html__('Position', 'bighearts'),
                    'type' => 'button_group',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_customize_side_panel', '=', 'custom']
                        ]],
                    ],
                    'multiple' => false,
                    'options' => [
                        'left' => esc_html__('Left', 'bighearts'),
                        'right' => esc_html__('Right', 'bighearts'),
                    ],
                    'std' => esc_attr(BigHearts_Theme_Helper::get_option('side_panel_position')),
                ],
            ]
        ];

        return $meta_boxes;
    }

    public function page_soc_icons_meta_boxes($meta_boxes)
    {
        $meta_boxes[] = [
            'title' => esc_html__('Social Shares', 'bighearts'),
            'post_types' => ['page'],
            'context' => 'advanced',
            'fields' => [
                [
                    'id' => 'mb_customize_soc_shares',
                    'name' => esc_html__('Social Shares', 'bighearts'),
                    'type' => 'button_group',
                    'inline' => true,
                    'multiple' => false,
                    'options' => [
                        'default' => esc_html__('Default', 'bighearts'),
                        'on' => esc_html__('On', 'bighearts'),
                        'off' => esc_html__('Off', 'bighearts'),
                    ],
                    'std' => 'default',
                ],
                [
                    'id' => 'mb_soc_icon_style',
                    'name' => esc_html__('Socials visibility', 'bighearts'),
                    'type' => 'button_group',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_customize_soc_shares', '=', 'on']
                        ]],
                    ],
                    'multiple' => false,
                    'options' => [
                        'standard' => esc_html__('Always', 'bighearts'),
                        'hovered' => esc_html__('On Hover', 'bighearts'),
                    ],
                    'std' => 'standard',
                ],
                [
                    'id' => 'mb_soc_icon_offset',
                    'name' => esc_html__('Offset Top', 'bighearts'),
                    'type' => 'number',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_customize_soc_shares', '=', 'on']
                        ]],
                    ],
                    'min' => 0,
                    'std' => 250,
                ],
                [
                    'id' => 'mb_soc_icon_offset_units',
                    'name' => esc_html__('Offset Top Units', 'bighearts'),
                    'type' => 'button_group',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_customize_soc_shares', '=', 'on']
                        ]],
                    ],
                    'desc' => esc_html__('If measurement units defined as "%" then social buttons will be fixed relative to viewport.', 'bighearts'),
                    'multiple' => false,
                    'options' => [
                        'pixel' => esc_html__('pixels (px)', 'bighearts'),
                        'percent' => esc_html__('percents (%)', 'bighearts'),
                    ],
                    'std' => 'pixel',
                ],
                [
                    'id' => 'mb_soc_icon_facebook',
                    'name' => esc_html__('Facebook Button', 'bighearts'),
                    'type' => 'switch',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_customize_soc_shares', '=', 'on']
                        ]],
                    ],
                ],
                [
                    'id' => 'mb_soc_icon_twitter',
                    'name' => esc_html__('Twitter Button', 'bighearts'),
                    'type' => 'switch',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_customize_soc_shares', '=', 'on']
                        ]],
                    ],
                ],
                [
                    'id' => 'mb_soc_icon_linkedin',
                    'name' => esc_html__('Linkedin Button', 'bighearts'),
                    'type' => 'switch',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_customize_soc_shares', '=', 'on']
                        ]],
                    ],
                ],
                [
                    'id' => 'mb_soc_icon_pinterest',
                    'name' => esc_html__('Pinterest Button', 'bighearts'),
                    'type' => 'switch',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_customize_soc_shares', '=', 'on']
                        ]],
                    ],
                ],
                [
                    'id' => 'mb_soc_icon_tumblr',
                    'name' => esc_html__('Tumblr Button', 'bighearts'),
                    'type' => 'switch',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_customize_soc_shares', '=', 'on']
                        ]],
                    ],
                ],
            ]
        ];

        return $meta_boxes;
    }

    public function page_footer_meta_boxes($meta_boxes)
    {
        $meta_boxes[] = [
            'title' => esc_html__('Footer', 'bighearts'),
            'post_types' => ['page'],
            'context' => 'advanced',
            'fields' => [
                [
                    'id' => 'mb_footer_switch',
                    'name' => esc_html__('Footer', 'bighearts'),
                    'type' => 'button_group',
                    'multiple' => false,
                    'options' => [
                        'default' => esc_html__('Default', 'bighearts'),
                        'on' => esc_html__('On', 'bighearts'),
                        'off' => esc_html__('Off', 'bighearts'),
                    ],
                    'std' => 'default',
                ],
                [
                    'name' => esc_html__('Footer Settings', 'bighearts'),
                    'type' => 'wgl_heading',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_footer_switch', '=', 'on']
                        ]],
                    ],
                ],
                [
                    'id' => 'mb_footer_content_type',
                    'name' => esc_html__('Content Type', 'bighearts'),
                    'type' => 'button_group',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_footer_switch', '=', 'on']
                        ]],
                    ],
                    'multiple' => false,
                    'options' => [
                        'widgets' => esc_html__('Widgets', 'bighearts'),
                        'pages' => esc_html__('Page', 'bighearts')
                    ],
                    'std' => 'pages',
                ],
                [
                    'id' => 'mb_footer_page_select',
                    'name' => esc_html__('Select a page', 'bighearts'),
                    'type' => 'post',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_footer_switch', '=', 'on'],
                            ['mb_footer_content_type', '=', 'pages']
                        ]],
                    ],
                    'post_type' => 'footer',
                    'field_type' => 'select_advanced',
                    'placeholder' => esc_html__('Select a page', 'bighearts'),
                    'query_args' => [
                        'post_status' => 'publish',
                        'posts_per_page' => - 1,
                    ],
                ],
                [
                    'id' => 'mb_footer_spacing',
                    'name' => esc_html__('Paddings', 'bighearts'),
                    'type' => 'wgl_offset',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_footer_switch', '=', 'on'],
                            ['mb_footer_content_type', '=', 'widgets'],
                        ]],
                    ],
                    'options' => [
                        'mode' => 'padding',
                        'top' => true,
                        'right' => true,
                        'bottom' => true,
                        'left' => true,
                    ],
                    'std' => [
                        'padding-top' => '0',
                        'padding-right' => '0',
                        'padding-bottom' => '0',
                        'padding-left' => '0'
                    ],
                ],
                [
                    'id' => 'mb_footer_bg',
                    'name' => esc_html__('Background', 'bighearts'),
                    'type' => 'wgl_background',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_footer_switch', '=', 'on'],
                            ['mb_footer_content_type', '=', 'widgets'],
                        ]],
                    ],
                    'image' => '',
                    'position' => 'center center',
                    'attachment' => 'scroll',
                    'size' => 'cover',
                    'repeat' => 'no-repeat',
                    'color' => '#ffffff',
                ],
                [
                    'id' => 'mb_footer_add_border',
                    'name' => esc_html__('Add Border Top', 'bighearts'),
                    'type' => 'switch',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_footer_switch', '=', 'on'],
                            ['mb_footer_content_type', '=', 'widgets'],
                        ]],
                    ],
                ],
                [
                    'id' => 'mb_footer_border_color',
                    'name' => esc_html__('Border Color', 'bighearts'),
                    'type' => 'color',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_footer_switch', '=', 'on'],
                            ['mb_footer_add_border', '=', '1'],
                        ]],
                    ],
                    'alpha_channel' => true,
                    'js_options' => ['defaultColor' => '#e5e5e5'],
                    'std' => '#e5e5e5',
                ],
            ],
        ];

        return $meta_boxes;
    }

    public function page_copyright_meta_boxes($meta_boxes)
    {
        $meta_boxes[] = [
            'title' => esc_html__('Copyright', 'bighearts'),
            'post_types' => ['page'],
            'context' => 'advanced',
            'fields' => [
                [
                    'id' => 'mb_copyright_switch',
                    'name' => esc_html__('Copyright', 'bighearts'),
                    'type' => 'button_group',
                    'multiple' => false,
                    'options' => [
                        'default' => esc_html__('Default', 'bighearts'),
                        'on' => esc_html__('On', 'bighearts'),
                        'off' => esc_html__('Off', 'bighearts'),
                    ],
                    'std' => 'default',
                ],
                [
                    'name' => esc_html__('Copyright Settings', 'bighearts'),
                    'type' => 'wgl_heading',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_copyright_switch', '=', 'on']
                        ]],
                    ],
                ],
                [
                    'id' => 'mb_copyright_editor',
                    'name' => esc_html__('Editor', 'bighearts'),
                    'type' => 'textarea',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_copyright_switch', '=', 'on']
                        ]],
                    ],
                    'cols' => 20,
                    'rows' => 3,
                    'std' => esc_html__('Copyright © 2020 BigHearts by WebGeniusLab. All Rights Reserved', 'bighearts')
                ],
                [
                    'id' => 'mb_copyright_text_color',
                    'name' => esc_html__('Text Color', 'bighearts'),
                    'type' => 'color',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_copyright_switch', '=', 'on']
                        ]],
                    ],
                    'js_options' => ['defaultColor' => '#838383'],
                    'std' => '#838383',
                ],
                [
                    'id' => 'mb_copyright_bg_color',
                    'name' => esc_html__('Background Color', 'bighearts'),
                    'type' => 'color',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_copyright_switch', '=', 'on']
                        ]],
                    ],
                    'js_options' => ['defaultColor' => '#171a1e'],
                    'std' => '#171a1e',
                ],
                [
                    'id' => 'mb_copyright_spacing',
                    'name' => esc_html__('Paddings', 'bighearts'),
                    'type' => 'wgl_offset',
                    'attributes' => [
                        'data-conditional-logic' => [[
                            ['mb_copyright_switch', '=', 'on']
                        ]],
                    ],
                    'options' => [
                        'mode' => 'padding',
                        'top' => true,
                        'right' => false,
                        'bottom' => true,
                        'left' => false,
                    ],
                    'std' => [
                        'padding-top' => '10',
                        'padding-bottom' => '10',
                    ],
                ],
            ],
        ];

        return $meta_boxes;
    }
}

new BigHearts_Metaboxes();
