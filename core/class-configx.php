<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'Config_X' ) ) :

	/**
	 * Main Config_X Class.
	 *
	 * @package		CONFIGX
	 * @subpackage	Classes/Config_X
	 * @since		1.0.0
	 * @author		Syed Ali Haider
	 */
	final class Config_X {

		/**
		 * The real instance
		 *
		 * @access	private
		 * @since	1.0.0
		 * @var		object|Config_X
		 */
		private static $instance;

		/**
		 * CONFIGX helpers object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Config_X_Helpers
		 */
		public $helpers;

		/**
		 * CONFIGX settings object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Config_X_Settings
		 */
		public $settings;

		/**
		 * Throw error on object clone.
		 *
		 * Cloning instances of the class is forbidden.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to clone this class.', 'configx' ), '1.0.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to unserialize this class.', 'configx' ), '1.0.0' );
		}

		/**
		 * Main Config_X Instance.
		 *
		 * Insures that only one instance of Config_X exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @access		public
		 * @since		1.0.0
		 * @static
		 * @return		object|Config_X	The one true Config_X
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Config_X ) ) {
				self::$instance					= new Config_X;
				self::$instance->base_hooks();
				self::$instance->includes();
				self::$instance->helpers		= new Config_X_Helpers();
				self::$instance->settings		= new Config_X_Settings();

				//Fire the plugin logic
				new Config_X_Run();

				/**
				 * Fire a custom action to allow dependencies
				 * after the successful plugin setup
				 */
				do_action( 'CONFIGX/plugin_loaded' );
			}

			return self::$instance;
		}

		/**
		 * Include required files.
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function includes() {
			require_once CONFIGX_PLUGIN_DIR . 'core/includes/classes/class-configx-helpers.php';
			require_once CONFIGX_PLUGIN_DIR . 'core/includes/classes/class-configx-settings.php';

			require_once CONFIGX_PLUGIN_DIR . 'core/includes/classes/class-configx-run.php';
		}

		/**
		 * Add base hooks for the core functionality
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function base_hooks() {
			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @access  public
		 * @since   1.0.0
		 * @return  void
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'configx', FALSE, dirname( plugin_basename( CONFIGX_PLUGIN_FILE ) ) . '/languages/' );
		}

	}

endif; // End if class_exists check.