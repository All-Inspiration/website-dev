<?php
/**
 * Customizer Library
 *
 * @package        laveo_customizer
 * @author         Devin Price, The Theme Foundry
 * @license        GPL-2.0+
 * @version        1.3.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Continue if the laveo_customizer isn't already in use.
if ( ! class_exists( 'laveo_customizer' ) ) :

	// Helper functions to output the customizer controls.
	require plugin_dir_path( __FILE__ ) . 'libs/interface.php';

	// Helper functions for customizer sanitization.
	require plugin_dir_path( __FILE__ ) . 'libs/sanitization.php';

	// Helper functions for fonts.
	require plugin_dir_path( __FILE__ ) . 'libs/fonts.php';

	// Utility functions for the customizer.
	require plugin_dir_path( __FILE__ ) . 'libs/utilities.php';

	// Customizer preview functions.
	require plugin_dir_path( __FILE__ ) . 'libs/preview.php';

	function loadAdminScripts() {
	    wp_enqueue_script( 'chosen-admin-script', get_template_directory_uri() . '/inc/admin/customizer/js/chosen.jquery.min.js', array( 'jquery' ), '1.0', true );
 		wp_enqueue_style( 'chosen-admin-style', get_template_directory_uri() . '/inc/admin/customizer//css/chosen.css' );
	}
	add_action( 'admin_enqueue_scripts', 'loadAdminScripts' );
	/**
	 * Class wrapper with useful methods for interacting with the theme customizer.
	 */
	class laveo_customizer {

		/**
		 * The one instance of laveo_customizer.
		 *
		 * @since 1.0.0.
		 *
		 * @var   laveo_customizer_Styles    The one instance for the singleton.
		 */
		private static $instance;

		/**
		 * The array for storing $options.
		 *
		 * @since 1.0.0.
		 *
		 * @var   array    Holds the options array.
		 */

		public $options = array();

		/**
		 * Instantiate or return the one laveo_customizer instance.
		 *
		 * @since  1.0.0.
		 *
		 * @return laveo_customizer
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function add_options( $options = array() ) {
			$this->options = array_merge( $options, $this->options );
		}

		public function get_options() {
			return $this->options;
		}

	}

endif;