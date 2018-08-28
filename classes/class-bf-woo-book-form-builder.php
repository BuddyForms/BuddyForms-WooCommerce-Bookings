<?php
/*
 * @package WordPress
 * @subpackage Woocommerce, BuddyForms
 * @author ThemKraft Dev Team
 * @copyright 2018, ThemeKraft Team
 * @link https://github.com/BuddyForms/BuddyForms-WooCommerce-Booking.git
 * @license GPLv2 or later
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class bf_woo_booking_builder {

	public function __construct() {
        add_filter( 'bf_woo_element_woo_implemented_tab', array( $this, 'buddyforms_bookeable_product_implemented_tabs' ),1,1 );
        add_action( 'include_bf_woo_booking_scripts',  array( $this, 'buddyforms_woo_bookings_script' ) );


	}

	public function buddyforms_woo_bookings_script(){
        wp_enqueue_script( 'bf_woo_bookings_settings_js', buddyforms_woocommerce_booking::$assets_js . 'bf_admin_woo_booking_settings.js', array( 'jquery' ), null , true );
    }

	public function buddyforms_bookeable_product_implemented_tabs($tabs){

        $product_data_tabs             = apply_filters( 'woocommerce_product_data_tabs', array() );
        $bookings_tabs = array();
        foreach ($product_data_tabs as $key => $value){
            $bookings_tabs[] = $key;
        }

	    return array_merge( $bookings_tabs, $tabs );

    }

}

