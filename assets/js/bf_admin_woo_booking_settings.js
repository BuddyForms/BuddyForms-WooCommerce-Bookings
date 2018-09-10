jQuery(function (jQuery) {
    jQuery('#sortable_buddyforms_elements li.bf_woocommerce ').each(function () {
        var field_row = jQuery(this),
            field_row_id = field_row.attr('id'),
            field_id = field_row_id.replace('field_', ''),
            virtual_row = field_row.find("#table_row_" + field_id + "_virtual"),
            booking_has_person_row = field_row.find("#table_row_" + field_id + "_wc_booking_has_persons"),
            booking_has_resources_row = field_row.find("#table_row_" + field_id + "_wc_booking_has_resources"),
            downloadable_row = field_row.find("#table_row_" + field_id + "_downloadable"),
            virtual = field_row.find("#_virtual-0"),
            booking_has_person = field_row.find("#_wc_booking_has_persons-0"),
            booking_has_resources = field_row.find("#_wc_booking_has_resources-0"),
            downloadable = field_row.find("#_downloadable-0");
        jQuery('select[name="buddyforms_options[form_fields][' + field_id + '][product_type_default]"]').bind('change',function () {
            var product_type = jQuery(this).val();
            switch(product_type) {
                case 'simple':

                    booking_has_person_row.hide();
                    booking_has_resources_row.hide();
                    break;
                case 'booking':
                    booking_has_person_row.show();
                    booking_has_resources_row.show();

                    booking_has_person.parent().show();
                    booking_has_resources.parent().show();

                    booking_has_person.show();
                    booking_has_resources.show();

                    break;
                default:
                    booking_has_person_row.hide();
                    booking_has_resources_row.hide();
            }

            booking_has_person.attr('checked', false).change();
            booking_has_resources.attr('checked', false).change();
        })
    })
});
