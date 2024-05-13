<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Config_X_Run
 *
 * Thats where we bring the plugin to life
 *
 * @package		CONFIGX
 * @subpackage	Classes/Config_X_Run
 * @author		Syed Ali Haider
 * @since		1.0.0
 */
class Config_X_Run{

	/**
	 * Our Config_X_Run constructor 
	 * to run the plugin logic.
	 *
	 * @since 1.0.0
	 */
	function __construct(){
		$this->add_hooks();
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOKS
	 * ###
	 * ######################
	 */

	/**
	 * Registers all WordPress and plugin related hooks
	 *
	 * @access	private
	 * @since	1.0.0
	 * @return	void
	 */
	private function add_hooks(){
	
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_backend_scripts_and_styles' ), 20 );
		add_action( 'admin_bar_menu', array( $this, 'add_admin_bar_menu_items' ), 100, 1 );
	
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOK CALLBACKS
	 * ###
	 * ######################
	 */

	/**
	 * Enqueue the backend related scripts and styles for this plugin.
	 * All of the added scripts andstyles will be available on every page within the backend.
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function enqueue_backend_scripts_and_styles() {
		wp_enqueue_style( 'configx-backend-styles', CONFIGX_PLUGIN_URL . 'core/includes/assets/css/backend-styles.css', array(), CONFIGX_VERSION, 'all' );
		wp_enqueue_script( 'configx-backend-scripts', CONFIGX_PLUGIN_URL . 'core/includes/assets/js/backend-scripts.js', array(), CONFIGX_VERSION, false );
		wp_localize_script( 'configx-backend-scripts', 'configx', array(
			'plugin_name'   	=> __( CONFIGX_NAME, 'configx' ),
		));
	}

	/**
	 * Add a new menu item to the WordPress topbar
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @param	object $admin_bar The WP_Admin_Bar object
	 *
	 * @return	void
	 */
	public function add_admin_bar_menu_items( $admin_bar ) {

		$admin_bar->add_menu( array(
			'id'		=> 'configx-id', // The ID of the node.
			'title'		=> __( 'Demo Menu Item', 'configx' ), // The text that will be visible in the Toolbar. Including html tags is allowed.
			'parent'	=> false, // The ID of the parent node.
			'href'		=> '#', // The ‘href’ attribute for the link. If ‘href’ is not set the node will be a text node.
			'group'		=> false, // This will make the node a group (node) if set to ‘true’. Group nodes are not visible in the Toolbar, but nodes added to it are.
			'meta'		=> array(
				'title'		=> __( 'Demo Menu Item', 'configx' ), // The title attribute. Will be set to the link or to a div containing a text node.
				'target'	=> '_blank', // The target attribute for the link. This will only be set if the ‘href’ argument is present.
				'class'		=> 'configx-class', // The class attribute for the list item containing the link or text node.
				'html'		=> false, // The html used for the node.
				'rel'		=> false, // The rel attribute.
				'onclick'	=> false, // The onclick attribute for the link. This will only be set if the ‘href’ argument is present.
				'tabindex'	=> false, // The tabindex attribute. Will be set to the link or to a div containing a text node.
			),
		));

		$admin_bar->add_menu( array(
			'id'		=> 'configx-sub-id',
			'title'		=> __( 'My sub menu title', 'configx' ),
			'parent'	=> 'configx-id',
			'href'		=> '#',
			'group'		=> false,
			'meta'		=> array(
				'title'		=> __( 'My sub menu title', 'configx' ),
				'target'	=> '_blank',
				'class'		=> 'configx-sub-class',
				'html'		=> false,    
				'rel'		=> false,
				'onclick'	=> false,
				'tabindex'	=> false,
			),
		));

	}

}
