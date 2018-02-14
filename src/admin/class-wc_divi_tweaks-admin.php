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
	public function __construct( $plugin_name, $version , $tweak_list , $tweak_active) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->tweak_list = $tweak_list;
		$this->tweak_active = $tweak_active;
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
		add_submenu_page(
			'options-general.php',
			// $this->is_divi()? 'et_divi_options' : 'options-general.php',
			'Divi Tweaks',
			'Divi Tweaks',
			'administrator',
			$this->plugin_name,
			array($this,'settings_page')
		);
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



	/**
	 * Shows main admin page.
	 *
	 * @since    1.0.0
	 */
	public function settings_page(){
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		// require_once plugin_dir_path( dirname( __FILE__ ) ) . '/admin/partials/wc_divi_tweaks-admin-display.php';
		?>
		
		<div class="wrap">
			<h1>Divi Tweaks</h1>
			<form method="post" action="options.php">

			<?php
				// This prints out all hidden setting fields
				// echo '<pre>';print_r($this->tweak_list);echo '</pre>';
				// echo '<pre>';print_r($this->tweak_active);echo '</pre>';
				settings_fields( 'wc_divi_tweaks_group' );

				foreach ($this->settings as $key => $setting) {
					do_settings_sections( $setting );
					echo '<hr />';
				}

				submit_button('Go Forrest');
			?>
			</form>
			
			<p>Developed by <a href="https://webchemistry.com.au" target="_blank"><img src="<?=plugins_url('../public/img/wc-logo.png',__FILE__)?>" style="vertical-align: middle;" alt="Web Chemistry"></a></p>
		</div>

		<?php 
	}


	public function admin_init(){

		// die('toy llamando al menos!!');

		register_setting(
			'wc_divi_tweaks_group', // Option group
			'wc_divi_tweaks_option', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);
		register_setting(
			'wc_divi_tweaks_group', // Option group
			'tweak_active', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);

		foreach ($this->tweak_list as $key => $tweak) {
			$section = 'wc_divi_tweaks_settings_section_'.$tweak['slug'];
			$settings = 'wc_divi_tweaks_settings_'.$tweak['slug'];
			add_settings_section(
				$section, // ID
				$tweak['tite'], // Title
				array($this , 'print_section_info'), // Callback
				$settings, // Page
				array('description'=> $tweak['description'] )
			);

			// SET ACTIVE OR INACTIVE
			add_settings_field(
				$tweak['slug'], // ID
				'<label for="'.$tweak['slug'].'">Active</label>', // Title
				array( $this , 'tweakActiveField' ), // Callback
				$settings, // Page
				$section, // Section
				array('id' => $tweak['slug'],)
			);

			// TWEAK CUSTOM SETTINGS
			if($tweak['settings']) {
				foreach($tweak['settings'] as $key => $setting) {
					add_settings_field(
						$setting['name'], // ID
						'<label for="'.$setting['name'].'">'.$setting['description'].'</label>', // Title
						array( $this , 'createInputField' ), // Callback
						$settings, // Page
						$section, // Section
						array('id' => $setting['name'],)
					);
				}
			}
			$this->settings[] = $settings;
		}
	}

	function createInputField($args){
		$options = get_option( 'wc_divi_tweaks_option' );
		echo '<input type="checkbox" id="'.$args['id'].'" name="wc_divi_tweaks_option['.$args['id'].']" ' . checked($options[$args['id']],'on', false ) . '/>';
	}

	function tweakActiveField($args){
		$options = get_option( 'tweak_active' );
		echo '<input type="checkbox" id="'.$args['id'].'" name="tweak_active['.$args['id'].']" ' . checked($options[$args['id']],'on', false ) . '/>';
	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 */
	public function sanitize( $input )
	{
		return $input;
		/*$new_input = array();
		if( isset( $input['field11'] ) ) $new_input['field11'] = boolval( $input['field11'] );
		if( isset( $input['field12'] ) ) $new_input['field12'] = absint( $input['field12'] );
		
		if( isset( $input['field21'] ) ) $new_input['field21'] = boolval( $input['field21'] );
		if( isset( $input['field22'] ) ) $new_input['field22'] = absint( $input['field22'] );*/
		// return $new_input;
	}

	/**
	 * Print the Section text
	 */
	public function print_section_info($args){
		// print '<p style="max-width: 600px;"><strong>This</strong> is some section info</p>';
		echo $args['description'];
	}

}
