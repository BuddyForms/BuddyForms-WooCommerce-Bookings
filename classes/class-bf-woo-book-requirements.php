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

class bf_woo_booking_requirements {

	public function __construct() {
		require_once 'includes/tgm/class-tgm-plugin-activation.php';

		add_action( 'init', array( $this, 'setup_init' ), 1, 1 );
	}

	public static function is_woocommerce_active() {
		self::load_plugins_dependency();

		return self::check_if_plugin_is_active( 'WooCommerce' );
	}

	static function  check_if_plugin_is_active($plugin_name){
	    //up 2 levels to get the plugin root folder
        $path =  dirname(dirname(dirname(__FILE__)));
        $active_plugin_site = get_option('active_plugins');
        foreach (  $active_plugin_site as $key =>$value ){
            $info = get_plugin_data( $path.DIRECTORY_SEPARATOR.$value, $markup = true, $translate = true );
            $text_domain = $info['Name'];
            if($text_domain === $plugin_name){
                return true;
            }
        }
        return false;

    }

	public static function is_bf_woo_elem_active() {
		//self::load_plugins_dependency();
        return self::check_if_plugin_is_active( 'BuddyForms WooCommerce Form Elements' );



	}

	public static function is_woo_booking_active() {
		self::load_plugins_dependency();

		return self::check_if_plugin_is_active( 'BuddyForms Woocommerce Booking' );
	}

	public static function load_plugins_dependency() {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}

	public static function is_buddy_form_active() {
		self::load_plugins_dependency();

		return  self::check_if_plugin_is_active( 'BuddyForms' ) ;
	}

	public function setup_init() {
		// Only Check for requirements in the admin
		if ( ! is_admin() ) {
			return;
		}
		add_action( 'bf_woo_booking_tmpga_register', array( $this, 'setup_and_check' ) );
		add_action( 'in_admin_footer', array( $this, 'remove_woo_footer' ) );
	}

	public function remove_woo_footer() {
		$current_screen = get_current_screen();
		if ( isset( $current_screen->id ) && $current_screen->id == 'admin_page_bf_woo_booking-install-plugins' && class_exists( 'WC_Admin' ) ) {
			$this->remove_anonymous_callback_hook( 'admin_footer_text', 'WC_Admin', 'admin_footer_text' );
		}
	}

	private function remove_anonymous_callback_hook( $tag, $class, $method ) {
		$filters = $GLOBALS['wp_filter'][ $tag ];

		if ( empty ( $filters ) || empty( $filters->callbacks ) ) {
			return;
		}

		foreach ( $filters->callbacks as $priority => $filter ) {
			foreach ( $filter as $identifier => $function ) {
				if ( is_array( $function ) && is_a( $function['function'][0], $class ) && $method === $function['function'][1] ) {
					remove_filter( $tag, array( $function['function'][0], $method ), $priority );
				}
			}
		}
	}

	public function setup_and_check() {
		// Create the required plugins array
		$plugins['buddypress'] = array(
			'name'     => 'BuddyPress',
			'slug'     => 'buddypress',
			'required' => true,
		);

		if ( ! defined( 'BUDDYFORMS_PRO_VERSION' ) ) {
			$plugins['buddyforms'] = array(
				'name'     => 'BuddyForms',
				'slug'     => 'buddyforms',
				'required' => true,
			);
		}

		$config = array(
			'id'           => 'bf_woo_booking',
			'menu'         => 'bf_woo_booking-install-plugins',
			// Menu slug.
			'parent_slug'  => 'plugins.php',
			// Parent menu slug.
			'capability'   => 'manage_options',
			// Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,
			// Show admin notices or not.
			'dismissable'  => false,
			// If false, a user cannot dismiss the nag message.
			'is_automatic' => true,
			// Automatically activate plugins after installation or not.
			'strings'      => array(
				'notice_can_install_required'    => _n_noop(
				/* translators: 1: plugin name(s). */
					'One of the <u>ThemKraft</u> plugin requires the following plugin: %1$s.',
					'One of the <u>ThemKraft</u> plugin requires the following plugins: %1$s.',
					'bf_woo_booking'
				),
				'notice_can_install_recommended' => _n_noop(
				/* translators: 1: plugin name(s). */
					'One of the <u>ThemKraft</u> plugin recommends the following plugin: %1$s.',
					'One of the <u>ThemKraft</u> plugin recommends the following plugins: %1$s.',
					'bf_woo_booking'
				),
				'notice_can_activate_required'   => _n_noop(
				/* translators: 1: plugin name(s). */
					'The following is a required plugin for one of the <u>ThemKraft</u> and is currently inactive: %1$s.',
					'The following is a required plugins for one of the <u>ThemKraft</u> and they are currently inactive: %1$s.',
					'bf_woo_booking'
				),
				'notice_ask_to_update'           => _n_noop(
				/* translators: 1: plugin name(s). */
					'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this plugin: %1$s.',
					'The following plugins need to be updated to their latest version to ensure maximum compatibility with this plugin: %1$s.',
					'bf_woo_booking'
				),
			),
		);

		// Call the tgmpa function to register the required plugins
		bf_woo_booking_tmpga( $plugins, $config );
	}
}

