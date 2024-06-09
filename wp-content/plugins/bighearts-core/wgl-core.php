<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://themeforest.net/user/webgeniuslab
 * @since             1.0.0
 * @package           bighearts-core
 *
 * @wordpress-plugin
 * Plugin Name:       BigHearts Core
 * Plugin URI:        https://themeforest.net/user/webgeniuslab
 * Description:       Core plugin for BigHearts Theme.
 * Version:           3.0.3
 * Author:            WebGeniusLab
 * Author URI:        https://themeforest.net/user/webgeniuslab
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bighearts-core
 * Domain Path:       /languages
 */

defined('WPINC') || die;  // Abort, if called directly.

define('WGL_CORE_URL', plugins_url('/', __FILE__));
define('WGL_CORE_PATH', plugin_dir_path(__FILE__));
define('WGL_CORE_FILE', __FILE__);

/**
 * Current version of the plugin.
 */
$plugin_data = get_file_data( __FILE__, [ 'version' => 'Version' ] );
define( 'WGL_CORE_VERSION', $plugin_data[ 'version' ] );

class BigHearts_CorePlugin
{
    private static $minimum_php_version = '7.0';

    public function __construct()
    {
        add_action('admin_init', [$this, 'check_version']);
        if (!self::theme_is_compatible()) {
            return;
        }

        if (version_compare(PHP_VERSION, self::$minimum_php_version, '<')) {
            add_action('admin_notices', [$this, 'fail_php_version']);
        }

        add_action('before_give_init', function() {
            add_filter('give_register_form_template', [$this, 'inject_give_form_template']);
        });
    }

    /**
     * The backup sanity check, in case the plugin is activated in a weird way,
     * or the theme change after activation.
     */
    public function check_version()
    {
        if (
            !self::theme_is_compatible()
            && is_plugin_active(plugin_basename(__FILE__))
        ) {
            deactivate_plugins(plugin_basename(__FILE__));
            add_action('admin_notices', [$this, 'disabled_notice']);
            if (isset($_GET['activate'])) {
                unset($_GET['activate']);
            }
        }
    }

    public function fail_php_version()
    {
        $message = sprintf(
            __('BigHearts Core plugin requires PHP version %s+. Your current PHP version is %s.', 'bighearts-core'),
            self::$minimum_php_version,
            PHP_VERSION
        );

        echo '<div class="error"><p>', esc_html($message), '</p></div>';
    }

    public static function activation_check()
    {
        if (!self::theme_is_compatible()) {
            deactivate_plugins(plugin_basename(__FILE__));
            wp_die(__('BigHearts Core plugin compatible with BigHearts theme only!', 'bighearts-core'));
        }
    }

    public function disabled_notice()
    {
        echo '<strong>',
            esc_html__('BigHearts Core plugin compatible with BigHearts theme only!', 'bighearts-core'),
        '</strong>';
    }

    public static function theme_is_compatible()
    {
        $plugin_name = trim(dirname(plugin_basename(__FILE__)));
        $theme_name = self::get_theme_slug();

        return false !== stripos($plugin_name, $theme_name);
    }

    public static function get_theme_slug()
    {
        return str_replace('-child', '', wp_get_theme()->get('TextDomain'));
    }

    /**
     * Inject custom form template Class under the hood of Give-WP plugin.
     *
     * Method must be invoked before `plugins_loaded` hook.
     */
    public function inject_give_form_template($registered_list)
    {
        require_once get_theme_file_path('/give/templates/bighearts-template.php');

        unset($registered_list['legacy']);
        $new_template = ['legacy' => \Give\Views\Form\Templates\Legacy\BigHearts::class];
        $new_list = $new_template + $registered_list;

        return $new_list;
    }
}

new BigHearts_CorePlugin();

register_activation_hook(__FILE__, ['BigHearts_CorePlugin', 'activation_check']);


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wgl-core-activator.php
 */
function activate_bighearts_core()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-wgl-core-activator.php';
    BigHearts_Core_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wgl-core-deactivator.php
 */
function deactivate_bighearts_core()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-wgl-core-deactivator.php';
    BigHearts_Core_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_bighearts_core');
register_deactivation_hook(__FILE__, 'deactivate_bighearts_core');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-wgl-core.php';

/**
 * Start execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 1.0.0
 */
function run_bighearts_core()
{
    (new BigHearts_Core())->run();
}

run_bighearts_core();
