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
        add_filter( 'bf_woo_booking_default_options', array( $this, 'buddyforms_bookeable_product_default_options' ),1,3 );
        add_action( 'include_bf_woo_booking_scripts',  array( $this, 'buddyforms_woo_bookings_script' ) );


	}

	public function buddyforms_bookeable_product_default_options($form_fields,$product_type_default,$field_id){
        global  $buddyform;
        $duration_type_default = 'fixed';
        $duration = 1;
        $duration_unit = 'day';
        if ( isset( $buddyform['form_fields'][ $field_id ]['wc_booking_duration_type'] ) ) {
            $duration_type_default = $buddyform['form_fields'][ $field_id ]['wc_booking_duration_type'];
        }

        if ( isset( $buddyform['form_fields'][ $field_id ]['wc_booking_duration'] ) ) {
            $duration = $buddyform['form_fields'][ $field_id ]['wc_booking_duration'];
        }
        if ( isset( $buddyform['form_fields'][ $field_id ]['wc_booking_duration_unit'] ) ) {
            $duration_unit = $buddyform['form_fields'][ $field_id ]['wc_booking_duration_unit'];
        }


	    $element_duration_type = new Element_Select( '<b>' . __( 'Booking duration: ', 'buddyforms' ) . '</b>',
            "buddyforms_options[form_fields][" . $field_id . "][wc_booking_duration_type]",
            array('fixed'=>'Fixed blocks of','customer'=>'Customer defined blocks of'),
            array(
                'id'    => $field_id . '_wc_booking_duration_type',
                'class' => "",
                'value' =>$duration_type_default ,
                'selected' => isset( $duration_type_default ) ? $duration_type_default : 'false',
            )
        );

        $element_duration = new Element_Number( '<b>' . __( 'duration: ', 'buddyforms' ) . ' </b>', "buddyforms_options[form_fields][" . $field_id . "][wc_booking_duration]",
            array(
                'id'    =>  $field_id. 'wc_booking_duration',
                'class' => "",
                'value' => $duration,'min'=>1
            )
        );


        $element_duration_unit = new Element_Select( '<b>' . __( 'Booking duration unit: ', 'buddyforms' ) . '</b>',
            "buddyforms_options[form_fields][" . $field_id . "][wc_booking_duration_unit]",
            array('month'=>'Month(s)',
                 'day'   =>'Day(s)',
                 'hour'  =>'Hour(s)',
                 'minute'=>'Minute(s)'),
            array(
                'id'    => $field_id . '_wc_booking_duration_unit',
                'class' => "",
                'value' =>$duration_unit ,
                'selected' => isset( $duration_unit ) ? $duration_unit : 'false',
            )
        );

	    if($product_type_default != "booking"){

            $element_duration_type->setAttribute( 'class', 'hidden' );
            $element_duration->setAttribute( 'class', 'hidden' );
            $element_duration_unit->setAttribute( 'class', 'hidden' );
        }

        $form_fields['general']['wc_booking_duration_type'] = $element_duration_type;
        $form_fields['general']['wc_booking_duration'] = $element_duration;
        $form_fields['general']['wc_booking_duration_unit'] = $element_duration_unit;

	    return $form_fields;

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

