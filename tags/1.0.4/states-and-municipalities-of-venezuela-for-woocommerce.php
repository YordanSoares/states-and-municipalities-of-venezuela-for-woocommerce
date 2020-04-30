<?php

/*
 * Plugin Name: States and Municipalities of Venezuela for WooCommerce 
 * Description: This plugins allows you to choose the States and Municipalities of Venezuela into the WooCommerce Options.
 * Version: 1.0.4
 * Author: Yordan Soares
 * Author URI: https://yordansoar.es/
 * Contributors: yordansoares
 * License: GPLv3
 * Text Domain: states-and-municipalities-of-venezuela-for-woocommerce
 * Domain Path: /languages
 * Requires at least: 4.0 +
 * Tested up to: 5.3.2
 * WC requires at least: 3.0.x
 * WC tested up to: 3.8.1
*/

// Exit if file is open directly
if (!defined('ABSPATH')) {
	exit;
}

// Check if WooCommerce is active
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
	// Define the constants for plugin URL and PATH
	define('SMVW_PLUGIN_URL', plugin_dir_url(__FILE__));
	define('SMVW_PLUGIN_PATH', plugin_dir_path(__FILE__));

	// Prepara the init function
	function smvw_init() {

		// Load text domain for internationalitation
		load_plugin_textdomain('states-and-municipalities-of-venezuela-for-woocommerce', FALSE,	dirname(plugin_basename(__FILE__)) . '/languages'	);		

		// Get the Class WC_Venezuelan_Municipalities_Select
		require_once('includes/class-wc-venezuelan-municipalities-select.php');

		// Instantiate the Class WC_Venezuelan_Municipalities_Select in $_GLOBALS variable
		$GLOBALS['wc_municipality_select'] = new WC_Venezuelan_Municipalities_Select(__FILE__);

		// Get the States of Venezuela
		require_once('states/VE.php');

		// Insert the States into WooCommerce Options
		add_filter('woocommerce_states', 'smvw_venezuelan_states');

		// Change the order of State and City fields to have more sense with the steps of form
		function smvw_change_state_and_city_order($fields)	{

			$fields['state']['priority'] = 70;
			$fields['city']['priority'] = 80;

			return $fields;
		}
		add_filter('woocommerce_default_address_fields', 'smvw_change_state_and_city_order');
	}
	add_action('plugins_loaded', 'smvw_init');

	// If WooCommerce isn't active...
} else {

	function smvw_woocommerce_required() {
		// ...shows a notice to asking for WooCommerce activation
		echo '
		<div class="notice notice-error is-dismissible">
			<p>' . wp_sprintf( __('%sStates and Municipalities of Venezuela for WooCommerce%s plugin requires %sWooCommerce%s activated. The plugin was deactivated until you active %sWooCommerce%s', 'states-and-municipalities-of-venezuela-for-woocommerce' ), '<strong>', '</strong>', '<strong>', '</strong>', '<strong>', '</strong>') . '</p>
		</div>
		';
		// And deactivate the plugin until WooCommerce is active
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}
	add_action('admin_notices', 'smvw_woocommerce_required');
}