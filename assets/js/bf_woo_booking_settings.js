jQuery(function ($) {
    $( document ).ready(function() {

        var formSlug = jQuery('input[name="form_slug"]');
        if (formSlug.length > 0 && formSlug.val()) {
            var buddyformsForm = jQuery("form[id='buddyforms_form_" + formSlug.val() + "']");
            var formValidator = buddyformsForm.data("validator");
            if (formValidator && formValidator.settings) {
                var prev_ignore = formValidator.settings.ignore;
                formValidator.settings.ignore = "#_wc_booking_cost, #_wc_booking_block_cost, #_wc_display_cost, :disabled, " + prev_ignore;
                if (typeof general_settings_param !== 'undefined') {

                    if (general_settings_param.product_type_options) {
                        var booking_has_persons_val = (general_settings_param.product_type_options['_wc_booking_has_persons'] !== undefined);
                        var booking_has_resources_val = (general_settings_param.product_type_options['_wc_booking_has_resources'] !== undefined);
                        if (booking_has_persons_val) {
                            $('#_wc_booking_has_persons').click();
                        }
                        if (booking_has_resources_val) {
                            $('#_wc_booking_has_resources').click();
                        }
                   }
                }
            }
        }
    });
});