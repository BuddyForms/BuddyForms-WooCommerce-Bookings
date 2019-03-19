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

class bf_woo_booking_builder
{
    public function __construct()
    {
        add_filter('bf_woo_element_woo_implemented_tab', array($this, 'buddyforms_bookeable_product_implemented_tabs'), 1, 1);
        add_filter('bf_woo_booking_default_options', array($this, 'buddyforms_bookeable_product_default_options'), 1, 3);
        add_action('include_bf_woo_booking_scripts', array($this, 'buddyforms_woo_bookings_script'));
        add_filter('bf_woo_element_product_type_array', array($this, 'buddyforms_bookeable_is_active'), 1, 1);
    }

    public function buddyforms_bookeable_is_active($products_type){
        $products_type['booking'] = __('Bookable product', 'woocommerce');
        return $products_type;
    }

    public function buddyforms_bookeable_product_default_options($form_fields, $product_type_default, $field_id)
    {
        global  $buddyform;
        $duration_type_default = 'fixed';
        $duration = 1;
        $duration_unit = 'day';
        $cancel_limit = 1;
        $cancel_limit_unit = 'day';
        $min_duration = 1;
        $max_duration = 1;
        $enable_range_picker = false;
        $requires_confirmation = false;
        $can_be_cancelled = false;
        $calendar_display_mode = '';
        if (isset($buddyform['form_fields'][$field_id]['wc_booking_duration_type'])) {
            $duration_type_default = $buddyform['form_fields'][$field_id]['wc_booking_duration_type'];
        }

        if (isset($buddyform['form_fields'][$field_id]['wc_booking_duration'])) {
            $duration = $buddyform['form_fields'][$field_id]['wc_booking_duration'];
        }
        if (isset($buddyform['form_fields'][$field_id]['wc_booking_duration_unit'])) {
            $duration_unit = $buddyform['form_fields'][$field_id]['wc_booking_duration_unit'];
        }

        if (isset($buddyform['form_fields'][$field_id]['wc_booking_min_duration'])) {
            $min_duration = $buddyform['form_fields'][$field_id]['wc_booking_min_duration'];
        }
        if (isset($buddyform['form_fields'][$field_id]['wc_booking_max_duration'])) {
            $max_duration = $buddyform['form_fields'][$field_id]['wc_booking_max_duration'];
        }
        if (isset($buddyform['form_fields'][$field_id]['wc_booking_enable_range_picker'])) {
            $enable_range_picker = $buddyform['form_fields'][$field_id]['wc_booking_enable_range_picker'];
        }

        if (isset($buddyform['form_fields'][$field_id]['wc_booking_calendar_display_mode'])) {
            $calendar_display_mode = $buddyform['form_fields'][$field_id]['wc_booking_calendar_display_mode'];
        }

        if (isset($buddyform['form_fields'][$field_id]['wc_booking_requires_confirmation'])) {
            $requires_confirmation = $buddyform['form_fields'][$field_id]['wc_booking_requires_confirmation'];
        }
        if (isset($buddyform['form_fields'][$field_id]['wc_booking_user_can_cancel'])) {
            $can_be_cancelled = $buddyform['form_fields'][$field_id]['wc_booking_user_can_cancel'];
        }

        if (isset($buddyform['form_fields'][$field_id]['wc_booking_cancel_limit'])) {
            $cancel_limit = $buddyform['form_fields'][$field_id]['wc_booking_cancel_limit'];
        }
        if (isset($buddyform['form_fields'][$field_id]['wc_booking_cancel_limit_unit'])) {
            $cancel_limit_unit = $buddyform['form_fields'][$field_id]['wc_booking_cancel_limit_unit'];
        }

        $booking_fields_hidden = 'false';
        if (isset($buddyform['form_fields'][$field_id]['booking_fields_hidden'])) {
            $booking_fields_hidden = $buddyform['form_fields'][$field_id]['booking_fields_hidden'];
        }
        $element = new Element_Checkbox('<b>Booking Fields Hidden</b>', 'buddyforms_options[form_fields][' . $field_id . '][booking_fields_hidden]', array('hidden' => __('Make the Booking Fields  Hidden', 'buddyforms')), array(
            'id' => $field_id . '_booking_fields_hidden',
            'class' => 'bf_hidden_checkbox',
            'value' => $booking_fields_hidden,
        ));

        //Booking duration type
        $element_duration_type = new Element_Select(
            '<b>' . __('Booking duration: ', 'buddyforms') . '</b>',
            'buddyforms_options[form_fields][' . $field_id . '][wc_booking_duration_type]',
            array('fixed' => 'Fixed blocks of', 'customer' => 'Customer defined blocks of'),
            array(
                'id' => $field_id . '_wc_booking_duration_type',
                'class' => '',
                'value' => $duration_type_default,
                'selected' => isset($duration_type_default) ? $duration_type_default : 'false',
            )
        );

        //Booking duration

        $element_duration = new Element_Number(
            '<b>' . __('duration: ', 'buddyforms') . ' </b>',
            'buddyforms_options[form_fields][' . $field_id . '][wc_booking_duration]',
            array(
                'id' => $field_id . '_wc_booking_duration',
                'class' => '',
                'value' => $duration, 'min' => 1,
            )
        );

        //Booking duration unit
        $element_duration_unit = new Element_Select(
            '<b>' . __('Booking duration unit: ', 'buddyforms') . '</b>',
            'buddyforms_options[form_fields][' . $field_id . '][wc_booking_duration_unit]',
            array(
                'month' => 'Month(s)',
                'day' => 'Day(s)',
                'hour' => 'Hour(s)',
                'minute' => 'Minute(s)',
            ),
            array(
                'id' => $field_id . '_wc_booking_duration_unit',
                'class' => '',
                'value' => $duration_unit,
                'selected' => isset($duration_unit) ? $duration_unit : 'false',
            )
        );

        //Min Booking duration
        $element_min_duration = new Element_Number(
            '<b>' . __('Minimum duration: ', 'buddyforms') . ' </b>',
            'buddyforms_options[form_fields][' . $field_id . '][wc_booking_min_duration]',
            array(
                'id' => $field_id . '_wc_booking_min_duration',
                'class' => '',
                'value' => $min_duration, 'min' => 1,
            )
        );

        //Max Booking duration
        $element_max_duration = new Element_Number(
            '<b>' . __('Maximum duration: ', 'buddyforms') . ' </b>',
            'buddyforms_options[form_fields][' . $field_id . '][wc_booking_max_duration]',
            array(
                'id' => $field_id . '_wc_booking_max_duration',
                'class' => '',
                'value' => $max_duration, 'min' => 1,
            )
        );

        //Enable Calendar Range Picker Element
        $element_enable_range_picker = new Element_Checkbox(
            '<b>' . __('Enable Calendar Range Picker? ', 'buddyforms') . ' </b>',
            'buddyforms_options[form_fields][' . $field_id . '][wc_booking_enable_range_picker]',
            array('yes' => esc_html('Lets the user select a start and end date on the calendar - duration will be calculated automatically.')),
            array(
                'id' => $field_id . '_wc_booking_enable_range_picker',
                'value' => $enable_range_picker,
                'class' => '',
            )
        );

        //Calendar Display Mode
        $element_calendar_display_mode = new Element_Select(
            '<b>' . __('Calendar display mode ', 'buddyforms') . '</b>',
            'buddyforms_options[form_fields][' . $field_id . '][wc_booking_calendar_display_mode]',
            array('' => 'Display calendar on click',
                'always_visible' => 'Calendar always visible', ),
            array(
                'id' => $field_id . '_wc_booking_calendar_display_mode',
                'class' => '',
                'value' => $calendar_display_mode,
                'selected' => isset($calendar_display_mode) ? $calendar_display_mode : '',
            )
        );

        //Requires Confirmation
        $element_requires_confirmation = new Element_Checkbox(
            '<b>' . __('Requires confirmation?', 'buddyforms') . ' </b>',
            'buddyforms_options[form_fields][' . $field_id . '][wc_booking_requires_confirmation]',
            array('yes' => esc_html('Check this box if the booking requires admin approval/confirmation. Payment will not be taken during checkout.')),
            array(
                'id' => $field_id . '_wc_booking_requires_confirmation',
                'value' => $requires_confirmation,
                'class' => '',
            )
        );

        //Can be cancelled
        $element_can_be_cancelled = new Element_Checkbox(
            '<b>' . __('Can be cancelled? ', 'buddyforms') . ' </b>',
            'buddyforms_options[form_fields][' . $field_id . '][wc_booking_user_can_cancel]',
            array('yes' => esc_html('Check this box if the booking can be cancelled by the customer after it has been purchased. A refund will not be sent automatically.')),
            array(
                'id' => $field_id . '_wc_booking_user_can_cancel',
                'value' => $can_be_cancelled,
                'class' => '',
            )
        );
        //Booking can be cancelled until
        $element_cancel_limit = new Element_Number(
            '<b>' . __('Cancel Limit ', 'buddyforms') . ' </b>',
            'buddyforms_options[form_fields][' . $field_id . '][wc_booking_cancel_limit]',
            array(
                'id' => $field_id . '_wc_booking_cancel_limit',
                'class' => '',
                'value' => $cancel_limit, 'min' => 1,
            )
        );

        //Bokking Cancel Limit Unit
        $element_cancel_limit_unit = new Element_Select(
            '<b>' . __('Cancel Limit Unit: ', 'buddyforms') . '</b>',
            'buddyforms_options[form_fields][' . $field_id . '][wc_booking_cancel_limit_unit]',
            array('month' => 'Month(s)',
                'day' => 'Day(s)',
                'hour' => 'Hour(s)',
                'minute' => 'Minute(s)', ),
            array(
                'id' => $field_id . '_wc_booking_cancel_limit_unit',
                'class' => '',
                'value' => $cancel_limit_unit,
                'selected' => isset($cancel_limit_unit) ? $cancel_limit_unit : 'false',
            )
        );



        if ($product_type_default === 'booking') {
            // if the Booking field checkbox is unchecked
            if ($booking_fields_hidden === 'false') {
                $element_duration_type->setAttribute('class', 'hidden');
                $element_duration->setAttribute('class', 'hidden');
                $element_duration_unit->setAttribute('class', 'hidden');
                $element_min_duration->setAttribute('class', 'hidden');
                $element_max_duration->setAttribute('class', 'hidden');
                $element_enable_range_picker->setAttribute('class', 'hidden');
                $element_calendar_display_mode->setAttribute('class', 'hidden');
                $element_requires_confirmation->setAttribute('class', 'hidden');
                $element_can_be_cancelled->setAttribute('class', 'hidden');
                $element_cancel_limit->setAttribute('class', 'hidden');
                $element_cancel_limit_unit->setAttribute('class', 'hidden');
            } else {
                //if the Booking field checkbox is checked
                if (isset($booking_fields_hidden[0])) {
                    if ($duration_type_default === 'fixed') {
                        $element_min_duration->setAttribute('class', 'hidden');
                        $element_max_duration->setAttribute('class', 'hidden');
                        $element_enable_range_picker->setAttribute('class', 'hidden');
                    }
                    if ($can_be_cancelled === false) {
                        $element_cancel_limit->setAttribute('class', 'hidden');
                        $element_cancel_limit_unit->setAttribute('class', 'hidden');
                    }
                }
            }
        } else {
            $element->setAttribute('class', 'hidden');
            $element_duration_type->setAttribute('class', 'hidden');
            $element_duration->setAttribute('class', 'hidden');
            $element_duration_unit->setAttribute('class', 'hidden');
            $element_min_duration->setAttribute('class', 'hidden');
            $element_max_duration->setAttribute('class', 'hidden');
            $element_enable_range_picker->setAttribute('class', 'hidden');
            $element_calendar_display_mode->setAttribute('class', 'hidden');
            $element_requires_confirmation->setAttribute('class', 'hidden');
            $element_can_be_cancelled->setAttribute('class', 'hidden');
            $element_cancel_limit->setAttribute('class', 'hidden');
            $element_cancel_limit_unit->setAttribute('class', 'hidden');
        }

        $form_fields['general']['booking_fields_hidden'] = $element;
        $form_fields['general']['wc_booking_duration_type'] = $element_duration_type;
        $form_fields['general']['wc_booking_duration'] = $element_duration;
        $form_fields['general']['wc_booking_duration_unit'] = $element_duration_unit;
        $form_fields['general']['wc_booking_min_duration'] = $element_min_duration;
        $form_fields['general']['wc_booking_max_duration'] = $element_max_duration;
        $form_fields['general']['wc_booking_enable_range_picker'] = $element_enable_range_picker;
        $form_fields['general']['wc_booking_calendar_display_mode'] = $element_calendar_display_mode;
        $form_fields['general']['wc_booking_requires_confirmation'] = $element_requires_confirmation;
        $form_fields['general']['wc_booking_user_can_cancel'] = $element_can_be_cancelled;


        $form_fields['general']['wc_booking_cancel_limit'] = $element_cancel_limit;
        $form_fields['general']['wc_booking_cancel_limit_unit'] = $element_cancel_limit_unit;



        return $form_fields;
    }

    public function buddyforms_woo_bookings_script()
    {
        wp_enqueue_script('bf_woo_bookings_settings_js', buddyforms_woocommerce_booking::$assets_js . 'bf_admin_woo_booking_settings.js', array('jquery'), null, true);
    }

    public function buddyforms_bookeable_product_implemented_tabs($tabs)
    {
        $product_data_tabs = apply_filters('woocommerce_product_data_tabs', array());
        $bookings_tabs = array();
        if (! empty($product_data_tabs)) {
            $bookings_tabs = array_keys($product_data_tabs);
        }

        return array_merge($bookings_tabs, $tabs);
    }
}
