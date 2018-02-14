<?php

/**
 * Fired during plugin activation
 *
 * @link       webchemistry.com.au
 * @since      1.0.0
 *
 * @package    Wc_divi_tweaks
 * @subpackage Wc_divi_tweaks/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wc_divi_tweaks
 * @subpackage Wc_divi_tweaks/includes
 * @author     Jose Nunez <dev@webchemistry.com.au>
 */
class Wc_divi_tweaks_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		add_option('tweak_active',array());
	}

}
