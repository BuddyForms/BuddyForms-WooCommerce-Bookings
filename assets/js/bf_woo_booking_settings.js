/**
 * Created by Victor on 22/08/2018.
 */
jQuery(function ($) {
    var prev_igonre =  $("form").data("validator").settings.ignore;
    var new_igonre = "#_wc_booking_cost, #_wc_booking_block_cost, #_wc_display_cost, :disabled, "+prev_igonre;
    $("form").data("validator").settings.ignore = new_igonre;
});