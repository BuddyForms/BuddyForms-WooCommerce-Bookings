jQuery(function (jQuery) {
    jQuery('#sortable_buddyforms_elements li.bf_woocommerce ').each(function () {
        var field_row = jQuery(this),
            field_row_id = field_row.attr('id'),
            field_id = field_row_id.replace('field_', ''),
            booking_duration_type_row = field_row.find("#table_row_" + field_id + "_wc_booking_duration_type"),
            booking_duration_row = field_row.find("#table_row_" + field_id + "_wc_booking_duration"),
            booking_duration_unit_row = field_row.find("#table_row_" + field_id + "_wc_booking_duration_unit"),
            booking_min_duration_row = field_row.find("#table_row_" + field_id + "_wc_booking_min_duration"),
            booking_max_duration_row = field_row.find("#table_row_" + field_id + "_wc_booking_max_duration"),
            booking_enable_range_picker_row = field_row.find("#table_row_" + field_id + "_wc_booking_enable_range_picker"),
            booking_calendar_display_mode_row = field_row.find("#table_row_" + field_id + "_wc_booking_calendar_display_mode"),
            booking_requires_confirmation_row = field_row.find("#table_row_" + field_id + "_wc_booking_requires_confirmation"),
            booking_can_be_cancelled_row = field_row.find("#table_row_" + field_id + "_wc_booking_user_can_cancel"),
            booking_cancel_limit_row = field_row.find("#table_row_" + field_id + "_wc_booking_cancel_limit"),
            booking_cancel_limit_unit_row = field_row.find("#table_row_" + field_id + "_wc_booking_cancel_limit_unit"),
            virtual_row = field_row.find("#table_row_" + field_id + "_virtual"),
            booking_has_person_row = field_row.find("#table_row_" + field_id + "_wc_booking_has_persons"),
            booking_has_resources_row = field_row.find("#table_row_" + field_id + "_wc_booking_has_resources"),
            booking_fields_hidden_row =field_row.find("#table_row_" + field_id + "_booking_fields_hidden"),
            downloadable_row = field_row.find("#table_row_" + field_id + "_downloadable"),
            virtual = field_row.find("#_virtual-0"),
            booking_has_person = field_row.find("#_wc_booking_has_persons-0"),
            booking_has_resources = field_row.find("#_wc_booking_has_resources-0"),
            booking_fields_hidden =field_row.find("#" + field_id + "_booking_fields_hidden-0"),
            booking_duration_type = field_row.find("#"+field_id+"_wc_booking_duration_type"),
            booking_duration      = field_row.find("#"+field_id+"_wc_booking_duration"),
            booking_duration_unit      = field_row.find("#"+field_id+"_wc_booking_duration_unit"),
            booking_min_duration = field_row.find("#"+field_id+"_wc_booking_min_duration"),
            booking_max_duration = field_row.find("#"+field_id+"_wc_booking_max_duration"),
            booking_enable_range_picker = field_row.find("#" + field_id + "_wc_booking_enable_range_picker-0"),
            booking_calendar_display_mode = field_row.find("#" + field_id + "_wc_booking_calendar_display_mode"),
            booking_requires_confirmation = field_row.find("#" + field_id + "_wc_booking_requires_confirmation-0"),
            booking_can_be_cancelled = field_row.find("#" + field_id + "_wc_booking_user_can_cancel-0"),
            booking_cancel_limit = field_row.find("#" + field_id + "_wc_booking_cancel_limit"),
            booking_cancel_limit_unit = field_row.find("#" + field_id + "_wc_booking_cancel_limit_unit"),

            downloadable = field_row.find("#_downloadable-0");
        jQuery('select[name="buddyforms_options[form_fields][' + field_id + '][product_type_default]"]').bind('change',function () {
            var product_type = jQuery(this).val();
            switch(product_type) {
                case 'simple':
                    booking_fields_hidden_row.hide();
                    booking_has_person_row.hide();
                    booking_has_resources_row.hide();

                    booking_duration_type_row.hide();
                    booking_duration_row.hide();
                    booking_duration_unit_row.hide();
                    booking_min_duration_row.hide();
                    booking_max_duration_row.hide();
                    booking_enable_range_picker_row.hide();
                    booking_calendar_display_mode_row.hide();
                    booking_requires_confirmation_row.hide();
                    booking_can_be_cancelled_row.hide();
                    booking_cancel_limit_row.hide();
                    booking_cancel_limit_unit_row.hide();
                    break;
                case 'booking':
                    booking_has_person_row.show();
                    booking_has_resources_row.show();

                    booking_has_person.parent().show();
                    booking_has_resources.parent().show();

                    booking_has_person.show();
                    booking_has_resources.show();
                    booking_fields_hidden_row.show();
                    booking_fields_hidden.parent().show();
                    booking_fields_hidden.show();


                    booking_duration_type_row.hide();
                    booking_duration_row.hide();
                    booking_duration_unit_row.hide();
                    booking_min_duration_row.hide();
                    booking_max_duration_row.hide();
                    booking_enable_range_picker_row.hide();
                    booking_calendar_display_mode_row.hide();
                    booking_requires_confirmation_row.hide();
                    booking_can_be_cancelled_row.hide();
                    booking_cancel_limit_row.hide();
                    booking_cancel_limit_unit_row.hide();

                    break;
                default:
                    booking_has_person_row.hide();
                    booking_has_resources_row.hide();
            }

            booking_has_person.attr('checked', false).change();
            booking_has_resources.attr('checked', false).change();
            booking_fields_hidden.attr('checked', false).change();
            booking_fields_hidden.prop('checked', false);

            booking_can_be_cancelled.attr('checked', false).change();
            booking_can_be_cancelled.prop('checked', false);
            booking_enable_range_picker.attr('checked', false).change();
            booking_enable_range_picker.prop('checked', false);


        })

        jQuery('input[name="buddyforms_options[form_fields][' + field_id + '][booking_fields_hidden][]"]').click(function () {

            if (!jQuery(this).is(':checked')) {

                booking_duration_type_row.hide();
                booking_duration_row.hide();
                booking_duration_unit_row.hide();
                booking_min_duration_row.hide();
                booking_max_duration_row.hide();
                booking_enable_range_picker_row.hide();
                booking_calendar_display_mode_row.hide();
                booking_requires_confirmation_row.hide();
                booking_can_be_cancelled_row.hide();
                booking_cancel_limit_row.hide();
                booking_cancel_limit_unit_row.hide();

                booking_can_be_cancelled.attr('checked', false).change();
                booking_can_be_cancelled.prop('checked', false);



            }else{

                booking_duration_type_row.show();
                booking_duration_type.show();

                booking_duration_row.show();
                booking_duration.show();

                booking_duration_unit_row.show();
                booking_duration_unit.show();
                booking_calendar_display_mode_row.show();
                booking_calendar_display_mode.show();

                booking_requires_confirmation_row.show();
                booking_requires_confirmation.parent().show();
                booking_requires_confirmation.show();


                booking_can_be_cancelled_row.show();
                booking_can_be_cancelled.parent().show();
                booking_can_be_cancelled.show();



                if(booking_duration_type.val()=="fixed"){
                    booking_min_duration_row.hide();
                    booking_max_duration_row.hide();
                    booking_enable_range_picker_row.hide();
                }else if(booking_duration_type.val()=="customer"){
                    booking_min_duration_row.show();
                    booking_max_duration_row.show();
                    booking_min_duration.show();
                    booking_max_duration.show();
                    booking_enable_range_picker_row.show();
                    booking_enable_range_picker.parent().show();
                    booking_enable_range_picker.show();
                }

                if(booking_can_be_cancelled.attr("checked")){

                    booking_cancel_limit_row.show();
                    booking_cancel_limit_unit_row.show();
                    booking_cancel_limit.show();
                    booking_cancel_limit_unit.show();
                }
                else{
                    booking_cancel_limit_row.hide();
                    booking_cancel_limit_unit_row.hide();
                }




            }
            booking_can_be_cancelled.attr('checked', false).change();
            booking_can_be_cancelled.prop('checked', false)
            booking_enable_range_picker.attr('checked', false).change();
            booking_enable_range_picker.prop('checked', false);
        });

        jQuery('input[name="buddyforms_options[form_fields][' + field_id + '][wc_booking_user_can_cancel][]"]').click(function () {

            if (!jQuery(this).is(':checked')) {
                booking_cancel_limit_row.hide();
                booking_cancel_limit_unit_row.hide();
            }else{

                booking_cancel_limit_row.show();
                booking_cancel_limit_unit_row.show();
                booking_cancel_limit.show();
                booking_cancel_limit_unit.show();
            }
        });
        jQuery('select[name="buddyforms_options[form_fields][' + field_id + '][wc_booking_duration_type]"]').bind('change',function () {
            var product_type = jQuery(this).val();
            switch(product_type) {
                case 'fixed':

                    booking_min_duration_row.hide();
                    booking_max_duration_row.hide();
                    booking_enable_range_picker_row.hide();
                    break;
                case 'customer':
                    booking_min_duration_row.show();
                    booking_max_duration_row.show();
                    booking_min_duration.show();
                    booking_max_duration.show();
                    booking_enable_range_picker_row.show();
                    booking_enable_range_picker.show();
                    booking_enable_range_picker.parent().show();


                    break;
                default:

            }
        })
    })
});
