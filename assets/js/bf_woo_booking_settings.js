var bfWooBooking = {
    generalTabFilter: function (hidden_fields, product_type_default) {
        if (product_type_default === 'booking') {
            if (general_settings_param.booking_fields_hidden && general_settings_param.booking_fields_hidden[0] && general_settings_param.booking_fields_hidden[0] === 'hidden') {
                hidden_fields.push(true);
            } else {
                hidden_fields.push(false);
            }
        }
        return hidden_fields
    },
    onReady: function () {
        var formSlug = jQuery('input[name="form_slug"]');
        if (formSlug.length > 0 && formSlug.val()) {
            var buddyformsForm = jQuery("form[id='buddyforms_form_" + formSlug.val() + "']");
            var formValidator = buddyformsForm.data("validator");
            if (formValidator && formValidator.settings) {
                var prev_ignore = formValidator.settings.ignore;
                formValidator.settings.ignore = '#woocommerce-product-data input[type="number"][step="0.01"], :disabled, ' + prev_ignore;
                if (typeof general_settings_param !== 'undefined') {
                    if (general_settings_param.product_type_hidden && general_settings_param.product_type_hidden[0] &&
                        general_settings_param.product_type_hidden[0] === 'hidden') {

                        //product_type_default
                        var product_type = jQuery("#product-type");
                        if (general_settings_param.product_type_default) {
                            product_type.val(general_settings_param.product_type_default).change();
                        }

                        //Product Type Options
                        if (general_settings_param.product_type_options) {
                            var booking_has_persons_val = (general_settings_param.product_type_options['_wc_booking_has_persons'] !== undefined);
                            var booking_has_resources_val = (general_settings_param.product_type_options['_wc_booking_has_resources'] !== undefined);
                            if (booking_has_persons_val) {
                                jQuery('#_wc_booking_has_persons').attr('checked', true).change();
                                jQuery('#_wc_booking_has_persons').prop('checked', true);
                            }
                            if (booking_has_resources_val) {
                                jQuery('#_wc_booking_has_resources').attr('checked', true).change();
                                jQuery('#_wc_booking_has_resources').prop('checked', true);
                            }
                        }//End Product Type Options

                        //Booking General Tab
                        //Check if Booking Fields are set to hidden
                        if (general_settings_param.booking_fields_hidden && general_settings_param.booking_fields_hidden[0] &&
                            general_settings_param.booking_fields_hidden[0] === 'hidden') {



                            //Set value for booking duration type
                            var wc_booking_duration_type = jQuery('select#_wc_booking_duration_type');
                            if (general_settings_param.wc_booking_duration_type) {
                                var duration_type_default_value = general_settings_param.wc_booking_duration_type;
                                wc_booking_duration_type.val(duration_type_default_value).change();

                                //hide element
                                wc_booking_duration_type.hide();
                                jQuery('label[for="_wc_booking_duration_type"]').hide();
                            }

                            //Set value for booking duration

                            var wc_booking_duration = jQuery('#_wc_booking_duration');
                            if (general_settings_param.wc_booking_duration) {
                                var duration_default_value = general_settings_param.wc_booking_duration;
                                wc_booking_duration.val(duration_default_value);

                                //hide element
                                wc_booking_duration.hide();
                            }

                            //Set value for booking duration unit
                            var wc_booking_duration_unit = jQuery('select#_wc_booking_duration_unit');
                            if (general_settings_param.wc_booking_duration_unit) {
                                var duration_unit_default_value = general_settings_param.wc_booking_duration_unit;
                                wc_booking_duration_unit.val(duration_unit_default_value).change();

                                //hide element
                                wc_booking_duration_unit.hide();
                            }

                            //set min and max duration default value
                            //Check if Booking duration type is customer

                            if (wc_booking_duration_type.val() == "customer") {

                                jQuery("#min_max_duration").hide();

                                var wc_booking_min_duration = jQuery('#_wc_booking_min_duration');
                                if (general_settings_param.wc_booking_min_duration) {
                                    var min_duration_default_value = general_settings_param.wc_booking_min_duration;
                                    wc_booking_min_duration.val(min_duration_default_value);
                                }

                                var wc_booking_max_duration = jQuery('#_wc_booking_max_duration');
                                if (general_settings_param.wc_booking_max_duration) {
                                    var max_duration_default_value = general_settings_param.wc_booking_max_duration;
                                    wc_booking_max_duration.val(max_duration_default_value);
                                }

                            }

                            //set default value for calendar display mode
                            var wc_booking_calendar_display_mode = jQuery('select#_wc_booking_calendar_display_mode');
                            if (general_settings_param.wc_booking_calendar_display_mode) {
                                var alendar_display_mode = general_settings_param.wc_booking_calendar_display_mode;
                                wc_booking_calendar_display_mode.val(alendar_display_mode).change();
                                jQuery("._wc_booking_calendar_display_mode_field").hide();

                            } else {
                                wc_booking_calendar_display_mode.val("").change();
                                jQuery("._wc_booking_calendar_display_mode_field").hide();
                            }

                            //set default value for requires confirmation field
                            var wc_booking_requires_confirmation = jQuery('#_wc_booking_requires_confirmation');
                            if (general_settings_param.wc_booking_requires_confirmation) {
                                wc_booking_requires_confirmation.attr('checked', true).change();
                                wc_booking_requires_confirmation.prop('checked', true);

                                jQuery("._wc_booking_requires_confirmation_field").hide();
                            } else {
                                jQuery("._wc_booking_requires_confirmation_field").hide();
                            }

                            //set default value for can be cancelled  field
                            var wc_booking_user_can_cancel = jQuery('#_wc_booking_user_can_cancel');
                            if (general_settings_param.wc_booking_user_can_cancel) {
                                wc_booking_user_can_cancel.attr('checked', true).change();
                                wc_booking_user_can_cancel.prop('checked', true);

                                jQuery("._wc_booking_user_can_cancel_field").hide();
                            } else {
                                jQuery("._wc_booking_user_can_cancel_field").hide();
                            }

                            //set default value for can be cancelled unitl
                            //ask if user can cancel is checked
                            if (wc_booking_user_can_cancel.attr('checked')) {

                                //set default value for cancel limit field
                                var wc_booking_cancel_limit = jQuery('#_wc_booking_cancel_limit');
                                if (general_settings_param.wc_booking_cancel_limit) {
                                    var cancel_limit = general_settings_param.wc_booking_cancel_limit;
                                    wc_booking_cancel_limit.val(cancel_limit);
                                }

                                //Set value for cancel limit unit
                                var wc_booking_cancel_limit_unit = jQuery('select#_wc_booking_cancel_limit_unit');
                                if (general_settings_param.wc_booking_cancel_limit_unit) {
                                    var cancel_limit_unit = general_settings_param.wc_booking_cancel_limit_unit;
                                    wc_booking_cancel_limit_unit.val(cancel_limit_unit).change();
                                }

                                jQuery(".booking-cancel-limit").hide();
                            }
                        }
                    }
                }
            }
        }
    },
    init: function () {
        var productType = jQuery('#product-type');
        if (productType.length > 0) {
            var isBookingPresent = productType.has('option[value="booking"]').length > 0;
            if (BF_Woo_Element_Hook && isBookingPresent) {
                BF_Woo_Element_Hook.add_filter('bf_woo_element_general_tab_filter', bfWooBooking.generalTabFilter);
                BF_Woo_Element_Hook.add_action('bf_woo_element_ready', bfWooBooking.onReady);
            }
        }
    }
};

jQuery(document).ready(function () {
    bfWooBooking.init();
});