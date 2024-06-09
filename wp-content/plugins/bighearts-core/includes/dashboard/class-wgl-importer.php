<?php
defined('ABSPATH') || exit;

if (!class_exists('WGL_Importer')) {
    /**
     * WGL Import v2
     *
     *
     * @package wgl-extensions\includes\dashboard
     * @author WebGeniusLab <webgeniuslab@gmail.com>
     * @version 1.0.0
     * @since 1.0.7
     */
    class WGL_Importer
    {
        /**
         * @var \WGL_Importer $instance
         */
        private static $instance;

        public static function instance()
        {
            if ( ! self::$instance ) {
                self::$instance = new self;
                self::$instance->hooks();
            }

            return self::$instance;
        }

        public static function get_instance()
        {
            if ( ! self::$instance ) {
                self::$instance = new self;
                self::$instance->hooks();
            }

            return self::$instance;
        }

        private function hooks()
        {
           
            /* ----------------------------------------------------------------------------- */
            /* Add Menu Page */
            /* ----------------------------------------------------------------------------- */
            if(defined('WGL_CORE_PATH') && is_dir(WGL_CORE_PATH  . '/includes/wgl_importer')){
                require_once plugin_dir_path(dirname(__FILE__)) . 'dashboard/controllers/config.php';
            }
            
            add_filter( 'wgl_panel_submenu', [ $this, 'admin_menu_panel' ] );
            add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );
        }

        public function admin_menu_panel($args)
        {   
            $inserted = [
                esc_html__('Demo Import', 'wgl-extensions'), // page_title
                esc_html__('Demo Import', 'wgl-extensions'), // menu_title
                'edit_posts', // capability
                'wgl-import-panel', // menu_slug
                [ $this, 'theme_import' ], // function that will render its output
            ]; // not necessarily an array, see manual quote
 
            $first_half_arr = array_slice($args[0], 0, 4);
            $second_half_arr = array_slice($args[0], 4, count($args[0]) - 4);
            $first_half_arr[] = $inserted;
            $args[0] = array_merge($first_half_arr, $second_half_arr);
            return $args;
        }

        public function theme_dashboard_heading()
        {
            global $submenu;

            $menu_items = '';

            if (isset($submenu['wgl-dashboard-panel'])):
              $menu_items = $submenu['wgl-dashboard-panel'];
            endif;

            if (!empty($menu_items)) :
            ?>
              <div class="wrap wgl-wrapper-notify">
                <div class="nav-tab-wrapper">
                  <?php foreach ($menu_items as $item):
                    $class = isset($_GET['page']) && $_GET['page'] == $item[2] ? ' nav-tab-active' : '';
                    ?>
                    <a href="<?php echo esc_url(admin_url('admin.php?page='.$item[2].''));?>"
                        class="nav-tab<?php echo esc_attr($class);?>"
                    >
                        <?php echo esc_html($item[0]); ?>

                    </a>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endif;
        }

        public function theme_import()
        {

            $this->theme_dashboard_heading();

            /**
             * View Importer
             */
            if(defined('WGL_CORE_PATH') && is_dir(WGL_CORE_PATH  . '/includes/wgl_importer')){
                require_once plugin_dir_path(dirname(__FILE__)) . 'dashboard/view/importer.php';
            }else{
                $path = str_replace( '-child', '', wp_get_theme()->get( 'TextDomain' ) ) . '-core' .'/wgl-core.php';
                $link = wp_nonce_url(admin_url('plugins.php?action=activate&plugin='.$path), 'activate-plugin_'.$path);
                echo '<div class="wrapper-notify-demo">' . esc_html__('Please Activate:', 'pembe-core') . '&nbsp' . '<a href="'.$link.'">';
                    echo str_replace( '-child', '', wp_get_theme()->get( 'TextDomain' ) ) . '-core' . '</div>';
                echo '</a>';
            }
        }

        public function admin_scripts()
        {
            if( isset($_GET['page']) && 'wgl-import-panel' === $_GET['page']){
                wp_enqueue_style( 'rwmb-select2', RWMB_CSS_URL . 'select2/select2.css', array(), '4.0.1' );
                wp_enqueue_style( 'rwmb-select-advanced', RWMB_CSS_URL . 'select-advanced.css', array(), RWMB_VER );
                wp_enqueue_script( 'rwmb-select2', RWMB_JS_URL . 'select2/select2.min.js', array( 'jquery' ), '4.0.2', true );

                wp_enqueue_script(
                    'wgl-importer',
                    plugin_dir_url(__FILE__) . 'assets/js/import.js',
                    ['jquery'],
                    time(),
                    true
                );

                wp_enqueue_style( 
                    'wgl-importer', 
                    plugin_dir_url( __FILE__ ) . 'assets/css/import.css', 
                    array(), 
                    time(), 
                    'all' 
                );
            }
        }
    }
}

WGL_Importer::get_instance();


?>