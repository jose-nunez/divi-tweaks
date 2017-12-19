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
	
	/*echo '<pre>';print_r(apply_filters('wcdt_add_tweak'));echo '</pre>';
	print_r(get_option('tweak_active')); 
	echo do_shortcode('[holishort]');
	echo do_shortcode('[otrotweakshort]'); 
	echo do_shortcode('[particles_short]'); 
	echo do_shortcode('[testmodule_short]'); */

	// Set class property
	// $this->options = get_option( 'seo_image_option' );
	?>
	<div class="wrap">
		<h1>Divi Tweaks</h1>
		<form method="post" action="options.php">

		<?php
			// This prints out all hidden setting fields
			
			/*settings_fields( 'wc_divi_tweaks_group' );
			do_settings_sections( 'wc_divi_tweaks_settings_1' );
			do_settings_sections( 'wc_divi_tweaks_settings_2' );
			submit_button('Go Forrest');*/
		?>
		</form>
		<p>Developed by <a href="https://webchemistry.com.au" target="_blank"><img src="<?=plugins_url('../../public/img/wc-logo.png',__FILE__)?>" style="vertical-align: middle;" alt="Web Chemistry"></a></p>
		
	</div>
</div>