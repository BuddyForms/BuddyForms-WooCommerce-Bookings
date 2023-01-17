<?php
/*
 * @package WordPress
 * @subpackage Woocommerce, BuddyForms
 * @author ThemKraft Dev Team
 * @copyright 2018, ThemeKraft Team
 * @link https://github.com/BuddyForms/BuddyForms-WooCommerce-Booking.git
 * @license GPLv2 or later
 */


if (! defined('ABSPATH')) {
    exit;
}

class bf_woo_booking_fs
{
    /**
     * Instance of this class.
     *
     * @var object
     */
    protected static $instance = null;

    public function __construct()
    {
        if ($this->bfeb_fs_is_parent_active_and_loaded()) {
            // If parent already included, init add-on.
            $this->bfeb_fs_init();
        } elseif ($this->bfeb_fs_is_parent_active()) {
            // Init add-on only after the parent is loaded.
            add_action('buddyforms_core_fs_loaded', array($this, 'bfeb_fs_init'));
        } else {
            // Even though the parent is not activated, execute add-on for activation / uninstall hooks.
            $this->bfeb_fs_init();
        }
    }

    public function bfeb_fs_is_parent_active_and_loaded()
    {
        // Check if the parent's init SDK method exists.
        return function_exists('buddyforms_core_fs');
    }

    public function bfeb_fs_is_parent_active()
    {
        $active_plugins_basenames = get_option('active_plugins');

        if (is_multisite()) {
            $network_active_plugins = get_site_option('active_sitewide_plugins', array());
            $active_plugins_basenames = array_merge($active_plugins_basenames, array_keys($network_active_plugins));
        }

        foreach ($active_plugins_basenames as $plugin_basename) {
            if (strpos($plugin_basename, 'buddyforms/') === 0 ||
                 strpos($plugin_basename, 'buddyforms-premium/') === 0
            ) {
                return true;
            }
        }

        return false;
    }

    public function bfeb_fs_init()
    {
        if ($this->bfeb_fs_is_parent_active_and_loaded()) {
            // Init Freemius.
            $this->bf_woo_booking_fs();
        }
    }

    /**
     * @return Freemius
     */
    public static function getFreemius()
    {
        global $bf_woo_booking_fs;

        return $bf_woo_booking_fs;
    }

    // Create a helper function for easy SDK access.

    /**
     * Return an instance of this class.
     *
     * @return object A single instance of this class.
     */
    public static function get_instance()
    {
        // If the single instance hasn't been set, set it now.
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function bf_woo_booking_fs()
    {
        global $bf_woo_booking_fs;

        if (! isset($bf_woo_booking_fs)) {
            // Include Freemius SDK.
            if (file_exists(dirname(dirname(__FILE__)) . '/buddyforms/includes/resources/freemius/start.php')) {
                // Try to load SDK from parent plugin folder.
                require_once dirname(dirname(__FILE__)) . '/buddyforms/includes/resources/freemius/start.php';
            } elseif (file_exists(dirname(dirname(__FILE__)) . '/buddyforms-premium/includes/resources/freemius/start.php')) {
                // Try to load SDK from premium parent plugin folder.
                require_once dirname(dirname(__FILE__)) . '/buddyforms-premium/includes/resources/freemius/start.php';
            }

            $bf_woo_booking_fs = fs_dynamic_init(array(
                'id'                  => '2509',
                'slug'                => 'buddyforms-woocommerce-bookings',
                'type'                => 'plugin',
                'public_key'          => 'pk_6213aaa69dd537cf03625ba531444',
                'is_premium'          => true,
                'is_premium_only'     => true,
                // If your addon is a serviceware, set this option to false.
                'has_premium_version' => true,
                'has_paid_plans'      => true,
                'is_org_compliant'    => false,
                'trial'               => array(
                    'days'               => 7,
                    'is_require_payment' => true,
                ),
                'parent'              => array(
                    'id'         => '391',
                    'slug'       => 'buddyforms',
                    'public_key' => 'pk_dea3d8c1c831caf06cfea10c7114c',
                    'name'       => 'BuddyForms',
                ),
                'menu'           => array(
                    'first-path' => 'plugins.php',
                    'support'    => false,
                ),
                'bundle_license_auto_activation' => true,
            ));
        }

        return $bf_woo_booking_fs;
    }
}
