<?php
/*
 * Plugin Name: BuddyForms -> Woocommerce Booking
 * Plugin URI: http://buddyforms.com/downloads/
 * Description: Add Woocommerce Booking Element to your BuddyForms
 * Version: 1.0.0
 * Author: ThemeKraft Team
 * Author URI: https://profiles.wordpress.org/svenl77
 * License: GPLv2 or later
 * Text Domain: buddyforms-woocommerce-booking
 *
 * @package bf_woo_elem
 * *****************************************************************************
 * WC requires at least: 3.0.0
 * WC tested up to: 3.4.1
 *****************************************************************************
 *
 * This script is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 ****************************************************************************
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'buddyforms_woocommerce_booking' ) ) {

	require_once dirname( __FILE__ ) . '/classes/class-bf-woo-book-fs.php';
	new bf_woo_booking_fs();

	class buddyforms_woocommerce_booking {

		public static $assets_css;
		public static $assets_js;
		public static $views;

		/**
		 * Instance of this class
		 *
		 * @var $instance buddyforms_woocommerce_booking
		 */
		protected static $instance = null;

		private function __construct() {
			$this->constants();
			$this->load_plugin_textdomain();
			require_once 'classes/class-bf-woo-book-requirements.php';
			new bf_woo_booking_requirements();
			if ( bf_woo_booking_requirements::is_buddy_form_active() && bf_woo_booking_requirements::is_woocommerce_active() ) {
				require_once 'classes/class-bf-woo-book-manager.php';
				new bf_woo_booking_manager();
			} else {
				//TODO add an admin message if buddyforms or woo are not active
			}
		}

		private function constants() {
			self::$assets_css = plugin_dir_url( __FILE__ ) . 'assets/css/';
			self::$assets_js = plugin_dir_url( __FILE__ ) . 'assets/js/';
			self::$views = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;
		}

		/**
		 * Return an instance of this class.
		 *
		 * @return object A single instance of this class.
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( null === self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'bf_woo_booking', false, basename( dirname( __FILE__ ) ) . '/languages' );
		}
	}

	add_action( 'plugins_loaded', array( 'buddyforms_woocommerce_booking', 'get_instance' ), 1 );
}