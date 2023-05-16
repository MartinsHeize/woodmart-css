jQuery(document).ready(function($) {
    // Check if HTML has lang="lv" attribute
    if ($('html').attr('lang') === 'it-IT') {
      
        // Attach click event handler to the button
        $('#b2bking_checkout_registration_validate_vat_button').on('click', function() {
            var buttonText = $('#b2bking_checkout_registration_validate_vat_button').text();
            if (buttonText === 'Validating...') {
                // Change the button text
                $('#b2bking_checkout_registration_validate_vat_button').text('Convalida...');
            }

            // Attach Ajax start event handler
            $(document).one('ajaxStart', function() {
                var buttonText2 = $('#b2bking_checkout_registration_validate_vat_button').text();
                // Check if the button exists
                if ($('#b2bking_checkout_registration_validate_vat_button').length) {
                if (buttonText2 === 'VAT Validated Successfully') {
                    $('#b2bking_checkout_registration_validate_vat_button').text('IVA convalidata con successo');
                } else if (buttonText2 === 'Validating...') {
                    // Change the button text
                    $('#b2bking_checkout_registration_validate_vat_button').text('Convalida...');
                }
                }
            });

            // Attach Ajax complete event handler
            $(document).one('ajaxComplete', function() {
                if ($('#b2bking_checkout_registration_validate_vat_button').length) {
                var buttonText3 = $('#b2bking_checkout_registration_validate_vat_button').text();
                
                if (buttonText3 === 'Invalid VAT. Click to try again') {
                    $('#b2bking_checkout_registration_validate_vat_button').text('Partita IVA non valida. Fai clic per riprovare');
                } else if (buttonText3 === 'VAT Validated Successfully') {
                    $('#b2bking_checkout_registration_validate_vat_button').text('IVA convalidata con successo');
                } else if (buttonText3 === 'Convalida...') {
                    $('#b2bking_checkout_registration_validate_vat_button').text('Validate VAT');
                }
                }
            });
        });
    }
});

jQuery(document).ready(function($) {
    if ($('html').attr('lang') === 'it-IT') {
        if ($('#b2bking_checkout_registration_validate_vat_button').length) {
            var buttonText = $('#b2bking_checkout_registration_validate_vat_button').text();
            if (buttonText === 'VAT Validated Successfully') {
                $('#b2bking_checkout_registration_validate_vat_button').text('IVA convalidata con successo');
            }
        }
    }
});
