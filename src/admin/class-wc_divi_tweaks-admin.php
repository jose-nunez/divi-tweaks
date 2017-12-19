<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       webchemistry.com.au
 * @since      1.0.0
 *
 * @package    Wc_divi_tweaks
 * @subpackage Wc_divi_tweaks/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wc_divi_tweaks
 * @subpackage Wc_divi_tweaks/admin
 * @author     Jose Nunez <dev@webchemistry.com.au>
 */
class Wc_divi_tweaks_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		// wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wc_divi_tweaks-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		// wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wc_divi_tweaks-admin.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Register the Menu item for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function add_menu(){
		// add_menu_page('Divi Tweaks','Divi Tweaks','administrator',__FILE__,array($this,'settings_page'),'');
		add_submenu_page('options-general.php','Divi Tweaks','Divi Tweaks','administrator',__FILE__,array($this,'settings_page'));
		// add_submenu_page($this->is_divi()? 'et_divi_options' : 'options-general.php','Divi Tweaks','Divi Tweaks','administrator',__FILE__,array($this,'settings_page'));
	}
	/**
	 * Shows main admin page.
	 *
	 * @since    1.0.0
	 */
	public function settings_page(){
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		require_once plugin_dir_path( dirname( __FILE__ ) ) . '/admin/partials/wc_divi_tweaks-admin-display.php';
	}

	private function is_divi() {	
		// Check template name
		$template = get_template();
		if (strpos($template, 'Divi')!==false) { return true; }
		
		// Check theme name
		$theme = wp_get_theme($template);
		if (strpos(@$theme->Name, 'Divi')!==false) { return true; }
		
		// Doesn't seem to be Divi Theme
		return false;
	}

}
