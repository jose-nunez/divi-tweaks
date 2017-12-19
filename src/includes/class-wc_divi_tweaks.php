<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       webchemistry.com.au
 * @since      1.0.0
 *
 * @package    Wc_divi_tweaks
 * @subpackage Wc_divi_tweaks/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wc_divi_tweaks
 * @subpackage Wc_divi_tweaks/includes
 * @author     Jose Nunez <dev@webchemistry.com.au>
 */
class Wc_divi_tweaks {
	protected $loader;
	protected $plugin_name;
	protected $version;

	public function __construct() {

		$this->plugin_name = 'divi-tweaks';
		$this->version = '1.0.0';

		$this->tweak_list;
		$this->tweak_active;
		$this->tweaks_folder = dirname( __FILE__ ).'/../tweaks/';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		$this->load_tweaks_satus();
		$this->lookup_tweaks();

	}

	private function load_dependencies() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wc_divi_tweaks-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wc_divi_tweaks-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wc_divi_tweaks-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wc_divi_tweaks-public.php';
		$this->loader = new Wc_divi_tweaks_Loader();
	}

	private function set_locale() {

		$plugin_i18n = new Wc_divi_tweaks_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	private function define_admin_hooks() {

		$plugin_admin = new Wc_divi_tweaks_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_menu' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'admin_init' );

	}

	private function define_public_hooks() {

		$plugin_public = new Wc_divi_tweaks_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	public function run() {
		$this->loader->run();
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}


	private function load_tweaks_satus(){
		$this->tweak_active = get_option('tweak_active');
	}
	/**
	 * Scans for folders and files containing tweaks. Each tweak must implement hook 'wcdt_add_tweak' in order to be included
	 * in the plugin
	 *
	 * @since    1.0.0
	 */
	private function lookup_tweaks(){
		$directory = $this->tweaks_folder;
		if(!is_dir($directory)) return false;
		$scanned_directory = array_diff(scandir($directory), array('..', '.'));
		foreach ($scanned_directory as $key => $file_folder) {
			if(is_dir($directory.$file_folder)){
				$tweak_index = $directory.$file_folder.'/'.$file_folder.'.php';
				if(is_file($tweak_index))include $tweak_index;
			}
			else if(is_file($directory.$file_folder)) include $directory.$file_folder;
		}

		$this->tweak_list = apply_filters('wcdt_add_tweak',array());
		foreach ($this->tweak_list as $slug => $tweak) {
			if(!isset($this->tweak_active[$tweak['slug']])) $this->tweak_active[$tweak['slug']] = false;
			/* Rewrite actives */$this->tweak_active[$tweak['slug']] = true;
		}

		update_option('tweak_active',$this->tweak_active);
		do_action('wcdt_init_tweak',$this->tweak_active);
	}
}
