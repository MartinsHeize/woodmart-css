jQuery(document).ready(function($) {
	// Check if the lang attribute is "lv"
	if ($('html').attr('lang') === 'lv') {
        $(document).ajaxComplete(function() {
                // Find and replace the text for the delivery method
                $('#payment_method_spell + label').text('Izvēlieties maksājuma veidu');

                // Translate options in the select element
                $('#spell-country option[value="EE"]').text('Igaunija');
                $('#spell-country option[value="LT"]').text('Lietuva');
                $('#spell-country option[value="LV"]').text('Latvija');
                $('#spell-country option[value="any"]').text('Citi');
            
        });
	}

    if ($('html').attr('lang') === 'cs-CZ') {
        $(document).ajaxComplete(function() {
                // Find and replace the text for the delivery method
                $('#payment_method_spell + label').text('Vyberte způsob platby');

                // Translate options in the select element
                $('#spell-country option[value="EE"]').text('Estonsko');
                $('#spell-country option[value="LT"]').text('Litva');
                $('#spell-country option[value="LV"]').text('Lotyšsko');
                $('#spell-country option[value="any"]').text('Ostatní');
            
        });
	}

    if ($('html').attr('lang') === 'de-DE') {
        $(document).ajaxComplete(function() {
                // Find and replace the text for the delivery method
                $('#payment_method_spell + label').text('Wählen Sie eine Bezahlungsart');
    
                // Translate options in the select element
                $('#spell-country option[value="EE"]').text('Estland');
                $('#spell-country option[value="LT"]').text('Litauen');
                $('#spell-country option[value="LV"]').text('Lettland');
                $('#spell-country option[value="any"]').text('Die Anderen');
            
        });
    }
});