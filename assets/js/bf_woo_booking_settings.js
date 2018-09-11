jQuery(function ($) {
    if(typeof $("form").data("validator") !== 'undefined'){

        var prev_igonre = $("form").data("validator").settings.ignore;

        $("form").data("validator").settings.ignore = "#_wc_booking_cost, #_wc_booking_block_cost, #_wc_display_cost, :disabled, " + prev_igonre;
    }

    if (typeof general_settings_param !== 'undefined') {
        if(general_settings_param.product_type_options){
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
});