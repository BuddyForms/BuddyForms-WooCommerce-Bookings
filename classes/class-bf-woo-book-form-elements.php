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

class bf_woo_booking_elements {

	public function __construct() {
		add_action( 'buddyforms_bookeable_product_display_element', array( $this, 'buddyforms_bookeable_product' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'styles_and_scripts' ), 9999 );
	}

	public function buddyforms_bookeable_product() {
		require_once( WC_BOOKINGS_ABSPATH . 'includes/admin/class-wc-bookings-admin.php' );
		$this->init_tabs();
	}

	public function add_tab() {

		include( WC_BOOKINGS_ABSPATH . 'includes/admin/views/html-booking-tab.php' );
	}

	public function booking_panels() {
		global $post, $bookable_product;

		if ( empty( $bookable_product ) || $bookable_product->get_id() !== $post->ID ) {
			$bookable_product = new WC_Product_Booking( $post->ID );
		}

		$restricted_meta = $bookable_product->get_restricted_days();

		for ( $i = 0; $i < 7; $i ++ ) {

			if ( $restricted_meta && in_array( $i, $restricted_meta ) ) {
				$restricted_days[ $i ] = $i;
			} else {
				$restricted_days[ $i ] = false;
			}
		}

		wp_enqueue_script( 'wc_bookings_writepanel_js' );
		include( WC_BOOKINGS_ABSPATH . 'includes/admin/views/html-booking-resources.php' );
		include( WC_BOOKINGS_ABSPATH . 'includes/admin/views/html-booking-availability.php' );
		include( WC_BOOKINGS_ABSPATH . 'includes/admin/views/html-booking-pricing.php' );
		include( WC_BOOKINGS_ABSPATH . 'includes/admin/views/html-booking-persons.php' );
	}

	public static function get_booking_resources() {
		$resources = array();
		try {
			$ids = WC_Data_Store::load( 'product-booking-resource' )->get_bookable_product_resource_ids();
			foreach ( $ids as $id ) {
				$resources[] = new WC_Product_Booking_Resource( $id );
			}

		} catch ( Exception $ex ) {
			bf_woo_booking_log::log( array(
				'action'         => 'bf_woo_booking_elements',
				'object_type'    => bf_woo_booking_manager::get_slug(),
				'object_subtype' => 'loading_dependency',
				'object_name'    => $ex->getMessage(),
			) );
		}

		return $resources;
	}

	public function register_tab( $tabs ) {
		$tabs['bookings_resources']    = array(
			'label'  => __( 'Resources', 'woocommerce-bookings' ),
			'target' => 'bookings_resources',
			'class'  => array(
				'show_if_booking',
			),
		);
		$tabs['bookings_availability'] = array(
			'label'  => __( 'Availability', 'woocommerce-bookings' ),
			'target' => 'bookings_availability',
			'class'  => array(
				'show_if_booking',
			),
		);
		$tabs['bookings_pricing']      = array(
			'label'  => __( 'Costs', 'woocommerce-bookings' ),
			'target' => 'bookings_pricing',
			'class'  => array(
				'show_if_booking',
			),
		);
		$tabs['bookings_persons']      = array(
			'label'  => __( 'Persons', 'woocommerce-bookings' ),
			'target' => 'bookings_persons',
			'class'  => array(
				'show_if_booking',
			),
		);

		return $tabs;
	}

	public function init_tabs() {
		if ( version_compare( WC_VERSION, '2.6', '<' ) ) {
			add_action( 'woocommerce_product_write_panel_tabs', array( $this, 'add_tab' ), 5 );
			add_action( 'woocommerce_product_write_panels', array( $this, 'booking_panels' ) );
		} else {
			add_filter( 'woocommerce_product_data_tabs', array( $this, 'register_tab' ) );
			add_action( 'woocommerce_product_data_panels', array( $this, 'booking_panels' ) );
		}

	}

	public function styles_and_scripts() {
		global $post, $wp_scripts;

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_enqueue_style( 'wc_bookings_admin_styles', WC_BOOKINGS_PLUGIN_URL . '/assets/css/admin.css', null, WC_BOOKINGS_VERSION );
		wp_register_script( 'wc_bookings_writepanel_js', WC_BOOKINGS_PLUGIN_URL . '/assets/js/writepanel' . $suffix . '.js', array( 'jquery', 'jquery-ui-datepicker' ), WC_BOOKINGS_VERSION, true );
		wp_register_script( 'wc_bookings_settings_js', WC_BOOKINGS_PLUGIN_URL . '/assets/js/settings' . $suffix . '.js', array( 'jquery' ), WC_BOOKINGS_VERSION, true );

		$params = array(
			'i18n_remove_person'     => esc_js( __( 'Are you sure you want to remove this person type?', 'woocommerce-bookings' ) ),
			'nonce_unlink_person'    => wp_create_nonce( 'unlink-bookable-person' ),
			'nonce_add_person'       => wp_create_nonce( 'add-bookable-person' ),
			'i18n_remove_resource'   => esc_js( __( 'Are you sure you want to remove this resource?', 'woocommerce-bookings' ) ),
			'nonce_delete_resource'  => wp_create_nonce( 'delete-bookable-resource' ),
			'nonce_add_resource'     => wp_create_nonce( 'add-bookable-resource' ),
			'i18n_minutes'           => esc_js( __( 'minutes', 'woocommerce-bookings' ) ),
			'i18n_hours'             => esc_js( __( 'hours', 'woocommerce-bookings' ) ),
			'i18n_days'              => esc_js( __( 'days', 'woocommerce-bookings' ) ),
			'i18n_new_resource_name' => esc_js( __( 'Enter a name for the new resource', 'woocommerce-bookings' ) ),
			'post'                   => isset( $post->ID ) ? $post->ID : '',
			'plugin_url'             => WC()->plugin_url(),
			'ajax_url'               => admin_url( 'admin-ajax.php' ),
			'calendar_image'         => WC()->plugin_url() . '/assets/images/calendar.png',
		);
		wp_enqueue_script( 'bf_woo_bookings_settings_js', buddyforms_woocommerce_booking::$assets_js . 'bf_woo_booking_settings.js', array( 'jquery' ), null, true );
		wp_localize_script( 'wc_bookings_writepanel_js', 'wc_bookings_writepanel_js_params', $params );
	}
}