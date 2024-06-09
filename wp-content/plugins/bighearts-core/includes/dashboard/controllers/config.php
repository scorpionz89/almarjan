<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !defined( 'WGL_CORE_URL' ) ) exit;

if ( !class_exists( 'WGL_Importer_Controller' ) ) {
    /**
     * 
     * @package     WGL_Importer_Controller - Models for Importing demo content
     * @author      WebGeniusLab
     * @version     1.0.0
     * @since       1.0.7
     */
    class WGL_Importer_Controller
    {
        public static $instance;
        static $version = "1.0.0";
        protected $parent;
        private $filesystem = [];
        public $extension_dir;
        public $demo_data_dir;
        public $wgl_import_files = [];
        public $active_import_id;
        public $active_import;

        /**
         * Class Constructor
         *
         * @since       1.0
         * @access      public
         * @return      void
         */
        public function __construct()
        {
            if ( !is_admin() ) return;

            if ( empty( $this->extension_dir ) ) {
                $dir_name = WGL_CORE_PATH . 'includes/wgl_importer/';
                $demo_dir = trailingslashit( str_replace( '\\', '/', $dir_name ) );

                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __DIR__ ) ) );
                $this->demo_data_dir = apply_filters( "wgl_importer_dir_path", $demo_dir . 'demo-data/' );
            }

            add_action( 'admin_init', [$this, 'getImports'] );
            add_filter( 'wgl_importer_files', [ $this, 'addImportFiles' ] );  

            add_action( 'wp_ajax_wgl_importer', [ $this, 'ajax_importer' ] );
            add_action( 'wp_ajax_nopriv_wgl_importer', [ $this, 'ajax_importer' ]);
                                    
            //Remove Elementor Filter
            remove_filter( 'wp_import_post_meta', 'Elementor\Compatibility::on_wp_import_post_meta');
            add_filter( 'wp_import_post_meta', [ $this, 'wgl_wp_import_post_meta' ] );
        
            add_action('wgl_importer_custom_page_slider', [ $this, 'wgl_slider_importer' ], 10, 1);
        }

        /**
         * Process post meta before WGL WP import.
         *
         * Normalize Elementor post meta on import, We need the `wp_slash` in order
         * to avoid the unslashing during the `add_post_meta`.
         *
         * Fired by `wp_import_post_meta` filter.
         *
         * @since 1.0.0
         * @access public
         *
         * @param array $post_meta Post meta.
         *
         * @return array Updated post meta.
         */
        public function wgl_wp_import_post_meta( $post_meta ) {
            foreach ( $post_meta as &$meta ) {
                if ( '_elementor_data' === $meta['key'] ) {
                    $meta['value'] = wp_slash( $meta['value'] );
                    break;
                }
            }

            return $post_meta;
        }

        /**
         * Get the demo folders/files
         * Provided fallback where some host require FTP info
         *
         * @return array list of files for demos
         */
        public function demoFiles()
        {
            global $wp_filesystem;
            if(!$wp_filesystem){
                return;
            }
            $dir_array = $wp_filesystem->dirlist( $this->demo_data_dir, false, true );

            if ( !empty( $dir_array ) && is_array( $dir_array ) ) {
                uksort( $dir_array, 'strcasecmp' );

                return $dir_array;
            } else {
                $dir_array = [];

                $demo_directory = array_diff( scandir( $this->demo_data_dir ), array( '..', '.' ) );

                if ( !empty( $demo_directory ) && is_array( $demo_directory ) ) {
                    foreach ( $demo_directory as $key => $value ) {
                        if ( is_dir( $this->demo_data_dir.$value ) ) {

                            $dir_array[$value] = array( 'name' => $value, 'type' => 'd', 'files'=> [] );

                            $demo_content = array_diff( scandir( $this->demo_data_dir.$value ), array( '..', '.' ) );

                            foreach ( $demo_content as $d_key => $d_value ) {
                                if ( is_file( $this->demo_data_dir.$value.'/'.$d_value ) ) {
                                    $dir_array[$value]['files'][$d_value] = array( 'name'=> $d_value, 'type' => 'f' );
                                }
                            }
                        }
                    }

                    uksort( $dir_array, 'strcasecmp' );
                }
            }
            return $dir_array;
        }

        public function getImports()
        {
            if (!empty($this->wgl_import_files)) {
                return $this->wgl_import_files;
            }

            $imports = $this->demoFiles();

            $imported = get_option( 'wgl_imported_demos' );

            if (!empty($imports) && is_array($imports)) {
                $x = 1;
                foreach ( $imports as $import ) {

                    if (empty( $import['files'])) {
                        continue;
                    }

                    if ( $import['type'] == "d" && !empty( $import['name'] ) ) {
                        $this->wgl_import_files['wbc-import-'.$x] = $this->wgl_import_files['wbc-import-'.$x] ?? [];
                        $this->wgl_import_files['wbc-import-'.$x]['directory'] = $import['name'];

                        if (
                            !empty($imported)
                            && is_array($imported)
                            && array_key_exists('wbc-import-'.$x, $imported)
                        ) {
                            $this->wgl_import_files['wbc-import-'.$x]['imported'] = 'imported';
                        }

                        $this->wgl_import_files['wbc-import-'.$x]['content_file'] = 'content.xml';
                        $content_list = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10');
                        foreach ($content_list as $key => $value) {
                            $key_s = $key + 1;
                            $this->wgl_import_files['wbc-import-'.$x]['content_file'.$key_s] = 'content_'.$value.'.xml';
                        }

                        if('pages' === $import['name']){
                            foreach ( $import['files'] as $f ) {
                                $this->wgl_import_files['wbc-import-'.$x]['custom_pages'][] = $f['name'];
                            }                        
                        }

                        if('cpt' === $import['name']){
                            foreach ( $import['files'] as $f ) {
                                $this->wgl_import_files['wbc-import-'.$x]['cpt'][] = $f['name'];
                            }                        
                        }


                        foreach ( $import['files'] as $file ) {
                            switch ( $file['name'] ) {
                                case 'theme-options.txt':
                                case 'theme-options.json':
                                    $this->wgl_import_files['wbc-import-'.$x]['theme_options'] = $file['name'];
                                    break;

                                case 'widgets.json':
                                case 'widgets.txt':
                                    $this->wgl_import_files['wbc-import-'.$x]['widgets'] = $file['name'];
                                    break;
                                
                                case 'give_form_sql.json':
                                    $this->wgl_import_files['wbc-import-'.$x]['give_form'] = $file['name'];
                                    break;

                                case 'screen-image.png':
                                case 'screen-image.jpg':
                                case 'screen-image.gif':
                                    $this->wgl_import_files['wbc-import-'.$x]['image'] = $file['name'];
                                    break;
                            }
                        }

                        if ( !isset( $this->wgl_import_files['wbc-import-'.$x]['content_file'] ) ) {
                            unset( $this->wgl_import_files['wbc-import-'.$x] );
                            if ($x > 1) $x--;
                        }
                    }

                    $x++;
                }
            }
        }

        public function addImportFiles( $wgl_import_files )
        {
            if ( !is_array( $wgl_import_files ) || empty( $wgl_import_files ) ) {
                $wgl_import_files = [];
            }

            $wgl_import_files = wp_parse_args( $wgl_import_files, $this->wgl_import_files );

            return $wgl_import_files;
        }

        public function ajax_importer()
        {
            if (
                !isset($_REQUEST['nonce'])
                || !wp_verify_nonce($_REQUEST['nonce'], "wgl_importer")
            ) {
                die( 0 );
            }

            if (
                isset($_REQUEST['type'])
                && $_REQUEST['type'] == "import-demo-content"
            ) {

                if(isset($_REQUEST['without_image'])){
                    global $skip_image_demo_content;
                    $skip_image_demo_content = true;
                }

                if(isset($_REQUEST['type_option'])){
                    $option = $_REQUEST['demo_import_pages_id'] ?? [];
                }else{
                    $option = $_REQUEST['demo_import_full_id'] ?? [];
                }
                
               
                $this->active_import_id = $option;

                $import_parts = $this->wgl_import_files[$this->active_import_id];
       
                if(!isset($_REQUEST['custom_pages'])){
                    $import_parts['content_file'] = $import_parts['content_file'.$_REQUEST['content']];
                }else{
                    $length = 0;
                    if(isset($_REQUEST['selectedPages']) && !empty($_REQUEST['selectedPages'])){
                        $length = count($_REQUEST['selectedPages']);
                        if($length >= (int) $_REQUEST['content']){
                            $import_parts['content_file'] = $_REQUEST['selectedPages'][(int) $_REQUEST['content'] - 1].'.xml';
                            $this->wgl_import_files[$this->active_import_id]['content_file'] = $_REQUEST['selectedPages'][(int) $_REQUEST['content'] - 1].'.xml';
                        }else{
                            $this->wgl_import_files[$this->active_import_id]['wgl_content_end_importer'] = true;
                        }    
                    }
                    
                    if(isset($_REQUEST['selectedCPT']) && !empty($_REQUEST['selectedCPT'])){
                        
                        if($length < (int) $_REQUEST['content']){

                            $length += count($_REQUEST['selectedCPT']);
                            
                            $allValues = array_values($_REQUEST['selectedCPT']);
                            
                            $this->active_import_id = $_REQUEST['demo_import_cpt_id'] ?? [];
                            $import_parts = $this->wgl_import_files[$this->active_import_id];
                            $this->wgl_import_files[$this->active_import_id]['custom_directory'] = 'cpt';   

                            if($length >= (int) $_REQUEST['content']){
                                $import_parts['content_file'] = $allValues[$length -  (int) $_REQUEST['content']].'.xml';
                                $this->wgl_import_files[$this->active_import_id]['content_file'] = $allValues[$length - (int) $_REQUEST['content']].'.xml';                        
                            }else{
                                $this->wgl_import_files[$this->active_import_id]['wgl_content_end_importer'] = true;
                            }      
                        }else{
                           $this->wgl_import_files[$this->active_import_id]['wgl_content_end_importer'] = false;
                        }
                    }

                    if(!(isset($_REQUEST['selectedPages']) && !empty($_REQUEST['selectedPages']))
                        && !(isset($_REQUEST['selectedCPT']) && !empty($_REQUEST['selectedCPT']))){
                        $this->wgl_import_files[$this->active_import_id]['wgl_content_end_importer'] = true;
                    }
                }


                $this->active_import = array( $this->active_import_id => $import_parts );

                if(isset($_REQUEST['type_option']) && is_array($_REQUEST['type_option'])){
                    foreach ($_REQUEST['type_option'] as $key => $value) {
                        switch ($value) {
                            case 'options':
                                $this->wgl_import_files[$this->active_import_id]['theme_options'] = 'theme-options.json';        
                                $this->wgl_import_files[$this->active_import_id]['type'][] = 'options';   
                                $this->wgl_import_files[$this->active_import_id]['custom_directory'] = 'full';                   
                                break;
                            case 'widgets':
                                $this->wgl_import_files[$this->active_import_id]['widgets'] = 'widgets.json';       
                                $this->wgl_import_files[$this->active_import_id]['type'][] = 'widgets';    
                                $this->wgl_import_files[$this->active_import_id]['custom_directory'] = 'full';                 
                                    break;
                            case 'rev_slider':
                                $this->wgl_import_files[$this->active_import_id]['rev-slider'] = true;       
                                $this->wgl_import_files[$this->active_import_id]['type'][] = 'rev-slider';   
                                $this->wgl_import_files[$this->active_import_id]['custom_directory'] = 'full';                  
                                break;
                                
                        }
                    }
                }   
                
                $custom_import = false;
                if(isset($_REQUEST['custom_pages'])){
                    $count_pages = (int) $_REQUEST['count_pages'];
                    $content = (int) $_REQUEST['content'];
                    if($count_pages === $content){
                        $custom_import = true;
                        $this->wgl_import_files[$this->active_import_id]['wgl_custom_end_importer'] = true;
                        do_action('wgl_importer_elementor_default_kit');
                    }
                }

                if(isset($_REQUEST['re_import_item'])){
                    $this->wgl_import_files[$this->active_import_id]['wgl_custom_end_importer'] = false;
                }
            
                include $this->extension_dir.'inc/init-installer.php';
                $installer = new Radium_Theme_Demo_Data_Importer( $this, isset($_REQUEST['custom_pages']) && !empty($_REQUEST['custom_pages']) ? 0 : $_REQUEST['content'] );

                if($custom_import){
                    if (!class_exists('Elementor')) {
                        \Elementor\Plugin::$instance->files_manager->clear_cache();
                    }                   
                }

                die();
            }

            die();
        }

        function wgl_slider_importer($slide)
        { 
            /**
             * Slider(s) Import
             */
            if (class_exists('RevSlider')) {
                $rev_slider_template_path = $this->demo_data_dir . 'full';
                if (is_array($slide)) {
                    foreach ($slide as $key => $value) {
                        if (file_exists($rev_slider_template_path . $value . '.zip')) {
                            $slider[$key] = new RevSlider();
                            $slider[$key]->importSliderFromPost(true, true, $rev_slider_template_path . $value . '.zip');
                        }
                    }
                } elseif (file_exists($rev_slider_template_path . $slide . '.zip')) {
                    $slider = new RevSlider();
                    $slider->importSliderFromPost(true, true, $rev_slider_template_path . $slide . '.zip');
                }
            }
    
        }

        public static function get_instance()
        {
            return self::$instance;
        }

    } // class
} // if

new WGL_Importer_Controller();
