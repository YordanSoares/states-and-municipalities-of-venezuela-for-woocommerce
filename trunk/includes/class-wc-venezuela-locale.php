<?php 

/**
 * Localization of Venezuela for WooCommerce
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WC_Venezuela_Custom_Locale' ) ) {
	class WC_Venezuela_Custom_Locale {
		
		public function __construct() {			
			add_filter( 'woocommerce_get_country_locale', array( $this, 'woocommerce_venezuela_locale' ), 10, 1 );
		}
	
		public function woocommerce_venezuela_locale($locale) {
			
			$locale['VE'] = array(
				'postcode' => array(
					'required' => false,
					'hidden'   => true,
				),
				'state'    => array(
					'label'    => __( 'State', 'states-and-municipalities-of-venezuela-for-woocommerce' ),
					'required' => true,
					'priority'     => 70,
				),
				'city'     => array(
					'label'    => __( 'Municipality', 'states-and-municipalities-of-venezuela-for-woocommerce' ),
					'required' => true,
					'priority'     => 80,
				),
			);
			
			return $locale;
		}
	}
	new WC_Venezuela_Custom_Locale();
}