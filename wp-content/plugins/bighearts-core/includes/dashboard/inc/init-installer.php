<?php
/**
 * Extension-Boilerplate
 * @link https://github.com/ReduxFramework/extension-boilerplate
 *
 * Radium Importer - Modified For ReduxFramework
 * @link https://github.com/FrankM1/radium-one-click-demo-install
 *
 * @package     wgl_Importer - Extension for Importing demo content
 * @author      Webcreations907
 * @version     1.0.1
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if ( !class_exists( 'Radium_Theme_Demo_Data_Importer' ) ) {

	require_once dirname( __FILE__ ) .'/importer/radium-importer.php'; //load admin theme data importer

	class Radium_Theme_Demo_Data_Importer extends Radium_Theme_Importer {

		// Protected vars
		protected $parent;
		protected $part;


		/**
		 * Holds a copy of the object for easy reference.
		 *
		 * @since 0.0.1
		 *
		 * @var object
		 */
		private static $instance;

		/**
		 * Theme Option name from ReduxFramework
		 *
		 * @var string
		 */
		public $theme_option_name       = '';


		/**
		 * themeoptions file name for ReduxFramework import
		 *
		 * @var string
		 */
		public $theme_options_file_name = '';

		/**
		 * give_form_sql.json file name
		 *
		 * @var string
		 */
		public $give_form_file_name = '';

		/**
		 * rev-slider zip files for Revolution Slider import
		 *
		 * @var string
		 */
		public $rev_slider_zip_name = '';

		/**
		 * Widgets.json file name
		 *
		 * @var string
		 */
		public $widgets_file_name   =  '';

		/**
		 * Content.xml file for importing sample content
		 *
		 * @var string
		 */
		public $content_demo_file_name  =  '';

		/**
		 * Content.xml file for importing sample content
		 *
		 * @var string
		 */
		public $import_type  =  [];

		/**
		 * @var string
		 */
		public $custom_end  =  false;

		/**
		 * @var string
		 */
		public $content_end  =  false;


		/**
		 * Holds a copy of the widget settings
		 *
		 * @since 0.0.2
		 *
		 * @var object
		 */
		public $widget_import_results;

		/**
		 * Constructor. Hooks all interactions to initialize the class.
		 *
		 * @since 0.0.1
		 */
		public function __construct( $parent, $part ) {
			$this->parent      = $parent;
			$this->part = $part;
			/*parent::$part = $part;*/

			$this->active_import = $this->parent->active_import;

			$this->active_import_id = $this->parent->active_import_id;

			$this->initSettings();

			self::$instance = $this;

			parent::__construct();

		}

		public function initSettings() {

			if ( is_dir( $this->parent->demo_data_dir ) ) {
				$this->demo_files_path = $this->parent->demo_data_dir;
			}

			if ( isset( $this->active_import_id ) && !empty( $this->active_import_id ) ) {

				$demo_import_array             = $this->parent->wgl_import_files[$this->active_import_id];

				$this->content_demo_file_name  = ( isset( $demo_import_array['content_file'.$this->part] ) ) ? $demo_import_array['content_file'.$this->part] : '';

				if ($this->part == '0') {
					$this->content_demo_file_name  = ( isset( $demo_import_array['content_file'] ) ) ? $demo_import_array['content_file'] : '';
				}
				$this->custom_dir  = ( isset( $this->demo_files_path ) && !empty( $this->demo_files_path ) ) ? $this->demo_files_path : '';
				$this->demo_files_path         = ( isset( $this->demo_files_path ) && !empty( $this->demo_files_path ) ) ? $this->demo_files_path.$demo_import_array['directory'].'/' : '';

				$this->theme_options_file_name = '';
				$this->widgets_file_name       = '';
				$this->give_form_file_name = '';
				$this->rev_slider_zip_name     = '';

				if ($this->part == '0') {
					$this->theme_options_file_name = ( isset( $demo_import_array['theme_options'] ) ) ? $demo_import_array['theme_options'] : '';
					$this->give_form_file_name = ( isset( $demo_import_array['give_form'] ) ) ? $demo_import_array['give_form'] : '';
					$this->widgets_file_name       = ( isset( $demo_import_array['widgets'] ) ) ? $demo_import_array['widgets'] : '';
					$this->rev_slider_zip_name       = ( isset( $demo_import_array['rev-slider'] ) ) ? $demo_import_array['rev-slider'] : '';
					$this->import_type =  isset($this->parent->wgl_import_files[$this->active_import_id]['type']) ? $this->parent->wgl_import_files[$this->active_import_id]['type'] : [];
					$this->custom_end =  isset($this->parent->wgl_import_files[$this->active_import_id]['wgl_custom_end_importer']) ? $this->parent->wgl_import_files[$this->active_import_id]['wgl_custom_end_importer'] : '';
					$this->content_end =  isset($this->parent->wgl_import_files[$this->active_import_id]['wgl_content_end_importer']) ? $this->parent->wgl_import_files[$this->active_import_id]['wgl_content_end_importer'] : '';

					$this->demo_custom_path         = ( isset( $this->demo_files_path ) && !empty( $this->demo_files_path ) && isset($demo_import_array['custom_directory']) ) ?  $this->custom_dir.$demo_import_array['custom_directory'].'/' : '';
				}

				if ($this->part == '10') {
					$this->custom_end = !isset($this->parent->wgl_import_files[$this->active_import_id]['wgl_custom_end_importer']) ? true : false;
					$this->give_form_file_name 	   = ( isset( $demo_import_array['give_form'] ) ) ? $demo_import_array['give_form'] : '';
					$this->theme_options_file_name = ( isset( $demo_import_array['theme_options'] ) ) ? $demo_import_array['theme_options'] : '';
					$this->widgets_file_name       = ( isset( $demo_import_array['widgets'] ) ) ? $demo_import_array['widgets'] : '';
				}

				$opt_name = '';
				$reduxArgs = new Redux;
				$reduxArgs = $reduxArgs::$args;
				$keys = array_keys($reduxArgs);
				$opt_name = $keys[0];

				$this->theme_option_name       =  $opt_name;

			}

		}

		/**
		 * Add menus
		 *
		 * @since 0.0.1
		 */
		public function set_demo_menus() {
			do_action( 'wgl_importer_before_widget_import', $this->active_import, $this->demo_files_path );

		}

	}//class
}//function_exists
?>
