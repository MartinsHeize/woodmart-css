// Show/Hide B2BKing VAT field conditional logic for Checkout field editor Legal/Person radio field
jQuery(document).ready(function($) {
    if ($("input[type='radio'][value='Juridiska']").is(":checked")) {
        // Show the elements initially if legal
        $(".b2bking_vat_visible.b2bking_vat_field_container, #b2bking_checkout_registration_validate_vat_button").show();
    } else if ($("input[type='radio'][value='Fiziska']").is(":checked")) {
        // Hide the elements initially if not legal
        $(".b2bking_vat_visible.b2bking_vat_field_container, #b2bking_checkout_registration_validate_vat_button").hide();
    }

    // Listen for changes in the radio button
    $("input[type='radio'][value='Juridiska']").change(function() {
        if ($(this).is(":checked")) {
            // Show the elements if the radio button is checked
            $(".b2bking_vat_visible.b2bking_vat_field_container, #b2bking_checkout_registration_validate_vat_button").show();
        }
    });

    // Listen for changes in the radio button
    $("input[type='radio'][value='Fiziska']").change(function() {
        if ($(this).is(":checked")) {
            // Hide the elements if the radio button is checked
            $(".b2bking_vat_visible.b2bking_vat_field_container, #b2bking_checkout_registration_validate_vat_button").hide();
        }
    });
});