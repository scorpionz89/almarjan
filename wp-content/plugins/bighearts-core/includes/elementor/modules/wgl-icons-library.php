<?php

namespace WglAddons\Modules;

defined('ABSPATH') || exit;

use WglAddons\{
    Includes\Wgl_Elementor_Helper,
    BigHearts_Global_Variables as BigHearts_Globals
};

/**
 * Wgl Elementor Custom Icon Control
 *
 *
 * @package bighearts-core\includes\elementor
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 */
class Wgl_Icons_Library
{
    public function __construct()
    {
        add_filter('elementor/icons_manager/additional_tabs', [$this, 'extended_icons_library']);
    }

    public function extended_icons_library()
    {
        return [
            'wgl_icons' => [
                'name' => 'wgl_icons',
                'label' => esc_html__('WGL Icons Library', 'bighearts-core'),
                'prefix' => 'flaticon-',
                'displayPrefix' => 'flaticon',
                'labelIcon' => 'flaticon',
                'icons' => Wgl_Elementor_Helper::get_instance()->get_wgl_icons(),
                'native' => true,
            ]
        ];
    }
}
