<?php
/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * 
 * @link https://themeforest.net/user/webgeniuslab
 * 
 * @package bighearts-core\includes
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 */
class BigHearts_Core_i18n
{
    /**
     * Load the plugin text domain for translation.
     *
     * @since 1.0.0
     */
    public function load_plugin_textdomain()
    {
        load_plugin_textdomain(
            'bighearts-core',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }
}
