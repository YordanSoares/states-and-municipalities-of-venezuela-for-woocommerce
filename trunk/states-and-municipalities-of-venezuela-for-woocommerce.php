<?php

/*
 * Plugin Name: States and Municipalities of Venezuela for WooCommerce 
 * Description: This plugins allows you to choose the States and Municipalities of Venezuela into the WooCommerce Options.
 * Version: 1.1
 * Author: Yordan Soares
 * Author URI: https://yordansoar.es/
 * Contributors: yordansoares
 * License: GPLv3
 * Text Domain: states-and-municipalities-of-venezuela-for-woocommerce
 * Domain Path: /languages
 * Requires at least: 4.0 +
 * Tested up to: 5.5
 * WC requires at least: 3.0.x
 * WC tested up to: 4.5
*/

// Exit if file is open directly
if (!defined('ABSPATH')) {
	exit;
}

// Check if WooCommerce is active
if (!function_exists('smvw_is_woocommerce_active')) {
	function smvw_is_woocommerce_active()
	{
		$active_plugins = (array) get_option('active_plugins', array());
		// Check if the WP install is multisite
		if (is_multisite()) {
			$active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
		}
		return in_array('woocommerce/woocommerce.php', $active_plugins) || array_key_exists('woocommerce/woocommerce.php', $active_plugins) || class_exists('WooCommerce');
	}
}

if (smvw_is_woocommerce_active()) {
	// Prepare the init function
	function smvw_init()
	{
		// Define the constants for plugin URL and PATH
		define('SMVW_PLUGIN_URL', plugin_dir_url(__FILE__));
		define('SMVW_PLUGIN_PATH', plugin_dir_path(__FILE__));

		// Load text domain for internationalitation
		load_plugin_textdomain('states-and-municipalities-of-venezuela-for-woocommerce', FALSE,	dirname(plugin_basename(__FILE__)) . '/languages');

		// Get the Class WC_Venezuelan_Municipalities_Select
		require_once('includes/class-wc-venezuelan-municipalities-select.php');

		// Instantiate the Class WC_Venezuelan_Municipalities_Select in $_GLOBALS variable
		$GLOBALS['wc_municipality_select'] = new WC_Venezuelan_Municipalities_Select(__FILE__);

		// Get the States of Venezuela
		require_once('states/VE.php');

		// Insert the States into WooCommerce Options
		add_filter('woocommerce_states', 'smvw_venezuelan_states');

		// Change the order of State and City fields to have more sense with the steps of form
		function smvw_change_state_and_city_order($fields)
		{

			$fields['state']['priority'] = 70;
			$fields['state']['label'] = __('State', 'states-and-municipalities-of-venezuela-for-woocommerce');
			$fields['city']['priority'] = 80;
			$fields['city']['label'] = __('Municipality', 'states-and-municipalities-of-venezuela-for-woocommerce');

			return $fields;
		}
		add_filter('woocommerce_default_address_fields', 'smvw_change_state_and_city_order');
		// If WooCommerce isn't active...

	}

	// Fires the init function
	add_action('plugins_loaded', 'smvw_init', 10);
	
} else {

	function smvw_woocommerce_required()
	{
		// ...shows a notice to asking for WooCommerce activation
		echo '
		<div class="notice notice-error is-dismissible">
		<p>' . wp_sprintf(__('%sStates and Municipalities of Venezuela for WooCommerce%s plugin requires %sWooCommerce%s activated. The plugin was deactivated until you active %sWooCommerce%s', 'states-and-municipalities-of-venezuela-for-woocommerce'), '<strong>', '</strong>', '<strong>', '</strong>', '<strong>', '</strong>') . '</p>
		</div>
		';
		// And deactivate the plugin until WooCommerce is active
		deactivate_plugins(plugin_basename(__FILE__));
	}
	add_action('admin_notices', 'smvw_woocommerce_required');
}
