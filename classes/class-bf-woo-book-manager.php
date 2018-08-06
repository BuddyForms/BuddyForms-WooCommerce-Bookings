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

class bf_woo_booking_manager {

    protected static $version = '1.0.0';
    private static $plugin_slug = 'bf_woo_booking';

    public function __construct() {
        require_once 'class-bf-woo-book-log.php';
        new bf_woo_booking_log();
        try {
            $this->bf_woo_booking_includes();
        } catch ( Exception $ex ) {
	        bf_woo_booking_log::log( array(
                'action'         => get_class( $this ),
                'object_type'    => self::get_slug(),
                'object_subtype' => 'loading_dependency',
                'object_name'    => $ex->getMessage(),
            ) );

        }
    }

    public function bf_woo_booking_includes() {
        require_once 'class-bf-woo-book-form-builder.php';
        new bf_woo_booking_builder();
        require_once 'class-bf-woo-book-form-elements.php';
        new bf_woo_booking_elements();
    }

    public static function get_slug() {
        return self::$plugin_slug;
    }

    static function get_version() {
        return self::$version;
    }
}