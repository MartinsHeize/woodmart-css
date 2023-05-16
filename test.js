jQuery(document).ready(function($) {
    // Check if HTML has lang="lv" attribute
    if ($('html').attr('lang') === 'lv') {
      console.log('??');
      
      // Attach click event handler to the button
      $('#b2bking_checkout_registration_validate_vat_button').on('click', function() {
        console.log('click??');
        var buttonText = $('#b2bking_checkout_registration_validate_vat_button').text();
        if (buttonText === 'Validating...') {
            // Change the button text
            $('#b2bking_checkout_registration_validate_vat_button').text('Notiek apstiprināšana...');
        }
        // Attach Ajax start event handler
        $(document).one('ajaxStart', function() {
          console.log('ajaxStart');
          var buttonText = $('#b2bking_checkout_registration_validate_vat_button').text();
          $('#b2bking_checkout_registration_validate_vat_button').text('Notiek apstiprināšana...');
          // Check if the button exists
          if ($('#b2bking_checkout_registration_validate_vat_button').length) {

            
            if (buttonText === 'VAT Validated Successfully') {
                $('#b2bking_checkout_registration_validate_vat_button').text('PVN Derīgs');
            } else if (buttonText === 'Validating...') {
                // Change the button text
                $('#b2bking_checkout_registration_validate_vat_button').text('Notiek apstiprināšana...');
            }
          }
        });

        // Attach Ajax complete event handler
        $(document).one('ajaxComplete', function() {
            console.log('ajaxComplete');
            if ($('#b2bking_checkout_registration_validate_vat_button').length) {
            var buttonText = $('#b2bking_checkout_registration_validate_vat_button').text();
            
            if (buttonText === 'Invalid VAT. Click to try again') {
                $('#b2bking_checkout_registration_validate_vat_button').text('Nederīgs PVN. Noklikšķiniet, lai mēģinātu vēlreiz');
            } else if (buttonText === 'VAT Validated Successfully') {
                $('#b2bking_checkout_registration_validate_vat_button').text('PVN Derīgs');
            } else if (buttonText === 'Notiek apstiprināšana...') {
                $('#b2bking_checkout_registration_validate_vat_button').text('Validate VAT');
            }
            }
        });
      });
      

    }
  });
  

jQuery(document).ready(function($) {
    if ($('html').attr('lang') === 'lv') {
        if ($('#b2bking_checkout_registration_validate_vat_button').length) {
            var buttonText = $('#b2bking_checkout_registration_validate_vat_button').text();
            if (buttonText === 'VAT Validated Successfully') {
                $('#b2bking_checkout_registration_validate_vat_button').text('PVN Derīgs');
            }
        }
    }
});