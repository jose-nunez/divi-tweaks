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
				
				settings_fields( 'wc_divi_tweaks_group' );
				do_settings_sections( 'wc_divi_tweaks_settings_1' );
				do_settings_sections( 'wc_divi_tweaks_settings_2' );
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

		add_settings_section(
			'wc_divi_tweaks_settings_section_1', // ID
			'First options section', // Title
			array( $this, 'print_section_info' ), // Callback
			'wc_divi_tweaks_settings_1' // Page
		);

		add_settings_field(
			'field11', // ID
			'<label for="field11">This is the field 11</label>', // Title
			array( $this, 'field11' ), // Callback
			'wc_divi_tweaks_settings_1', // Page
			'wc_divi_tweaks_settings_section_1' // Section
		);
		add_settings_field(
			'field12', // ID
			'<label for="field12">This is the field 12</label>', // Title
			array( $this, 'field12' ), // Callback
			'wc_divi_tweaks_settings_1', // Page
			'wc_divi_tweaks_settings_section_1' // Section
		);



		add_settings_section(
			'wc_divi_tweaks_settings_section_2', // ID
			'Second options section', // Title
			array( $this, 'print_section_info' ), // Callback
			'wc_divi_tweaks_settings_2' // Page
		);

		add_settings_field(
			'field21', // ID
			'<label for="field21">This is the field 21</label>', // Title
			array( $this, 'field21' ), // Callback
			'wc_divi_tweaks_settings_2', // Page
			'wc_divi_tweaks_settings_section_2' // Section
		);
		add_settings_field(
			'field22', // ID
			'<label for="field22">This is the field 22</label>', // Title
			array( $this, 'field22' ), // Callback
			'wc_divi_tweaks_settings_2', // Page
			'wc_divi_tweaks_settings_section_2' // Section
		);

	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 */
	public function sanitize( $input )
	{
		// return $input;
		$new_input = array();
		if( isset( $input['field11'] ) ) $new_input['field11'] = boolval( $input['field11'] );
		if( isset( $input['field12'] ) ) $new_input['field12'] = absint( $input['field12'] );
		
		if( isset( $input['field21'] ) ) $new_input['field21'] = boolval( $input['field21'] );
		if( isset( $input['field22'] ) ) $new_input['field22'] = absint( $input['field22'] );
		return $new_input;
	}

	/**
	 * Print the Section text
	 */
	public function print_section_info(){
		print '<p style="max-width: 600px;"><strong>This</strong> is some section info</p>';
	}
	
	
	public function field12(){
		$options = get_option( 'wc_divi_tweaks_option' );
		echo    '<label><input type="radio" name="wc_divi_tweaks_option[field12]" value="1" ' . checked(1, $options['field12'], false) . '> Val 1</label>'
				.'<br /><br />'
				.'<label><input type="radio" name="wc_divi_tweaks_option[field12]" value="2" ' . checked(2, $options['field12'], false) . '> Val 2</label>'
				.'<br /><br />'
				.'<label><input type="radio" name="wc_divi_tweaks_option[field12]" value="0" ' . checked(0, $options['field12'], false) . '> Val 0</label>'
				;
	}

	public function field11(){
		$options = get_option( 'wc_divi_tweaks_option' );
		echo '<input type="checkbox" id="field11" name="wc_divi_tweaks_option[field11]"  value="true" ' . checked(true, $options['field11'], false ) . '/>';
	}


	public function field22(){
		$options = get_option( 'wc_divi_tweaks_option' );
		echo    '<label><input type="radio" name="wc_divi_tweaks_option[field22]" value="1" ' . checked(1, $options['field22'], false) . '> Val 1</label>'
				.'<br /><br />'
				.'<label><input type="radio" name="wc_divi_tweaks_option[field22]" value="2" ' . checked(2, $options['field22'], false) . '> Val 2</label>'
				.'<br /><br />'
				.'<label><input type="radio" name="wc_divi_tweaks_option[field22]" value="0" ' . checked(0, $options['field22'], false) . '> Val 0</label>'
				;
	}

	public function field21(){
		$options = get_option( 'wc_divi_tweaks_option' );
		echo '<input type="checkbox" id="field21" name="wc_divi_tweaks_option[field21]"  value="true" ' . checked(true, $options['field21'], false ) . '/>';
	}













}
