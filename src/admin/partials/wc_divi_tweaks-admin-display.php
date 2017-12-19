<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       webchemistry.com.au
 * @since      1.0.0
 *
 * @package    Wc_divi_tweaks
 * @subpackage Wc_divi_tweaks/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div>
	
	<?php 
	
	echo '<pre>';print_r(apply_filters('wcdt_add_tweak'));echo '</pre>';

	print_r(get_option('tweak_active')); 
	echo do_shortcode('[holishort]');
	echo do_shortcode('[otrotweakshort]'); 
	echo do_shortcode('[particles_short]'); 
	echo do_shortcode('[testmodule_short]'); 

	?>

</div>