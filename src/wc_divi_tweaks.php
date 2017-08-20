<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              webchemistry.com.au
 * @since             1.0.0
 * @package           Wc_divi_tweaks
 *
 * @wordpress-plugin
 * Plugin Name:       Divi Tweaks
 * Plugin URI:        webchemistry.com.au
 * Description:       Cool tweaks for all your Divi themes
 * Version:           1.0.0
 * Author:            Jose Nunez
 * Author URI:        webchemistry.com.au
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wc_divi_tweaks
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

function activate_wc_divi_tweaks() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc_divi_tweaks-activator.php';
	Wc_divi_tweaks_Activator::activate();
}

function deactivate_wc_divi_tweaks() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc_divi_tweaks-deactivator.php';
	Wc_divi_tweaks_Deactivator::deactivate();
}
register_activation_hook( __FILE__, 'activate_wc_divi_tweaks' );
register_deactivation_hook( __FILE__, 'deactivate_wc_divi_tweaks' );


require plugin_dir_path( __FILE__ ) . 'includes/class-wc_divi_tweaks.php';

function run_wc_divi_tweaks() {

	$plugin = new Wc_divi_tweaks();
	$plugin->run();

}
run_wc_divi_tweaks();
