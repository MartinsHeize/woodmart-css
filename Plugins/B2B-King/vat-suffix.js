// Change price suffix text for other languages than English.
jQuery(document).ready(function($) {
    // Mapping object for language specific replacements
    var languageReplacements = {
        'lv': {
            ' inc. VAT': ' ar PVN',
            ' ex. VAT': ' bez PVN'
        },
        'lt-LT': {
            ' inc. VAT': ' + PVM',
            ' ex. VAT': ' be PVM'
        },
        'et': {
            ' inc. VAT': ' + KM',
            ' ex. VAT': ' ilma KM'
        },
        'ru-RU': {
            ' inc. VAT': ' с НДС',
            ' ex. VAT': ' без НДС'
        },
        'pl-PL': {
            ' inc. VAT': ' z podatkiem VAT',
            ' ex. VAT': ' bez VAT'
        },
        'cs-CZ': {
            ' inc. VAT': ' vč. káď',
            ' ex. VAT': ' např. káď'
        }
    };

    // Function to perform the text replacement
    function replaceText() {
        var lang = $('html').attr('lang');
        
        if (lang in languageReplacements) {
            $('.woocommerce-price-suffix').each(function() {
                var suffixText = $(this).text();
                var replacements = languageReplacements[lang];
                if (suffixText in replacements) {
                    $(this).text(replacements[suffixText]);
                }
            });
        }
    }

    // Check if HTML doesn't have lang="en-GB" attribute on document ready
    if ($('html').attr('lang') !== 'en-GB') {
        replaceText();
    }

    // Handle AJAX complete event for dynamic content
    $(document).ajaxComplete(function() {
        if ($('html').attr('lang') !== 'en-GB') {
            setTimeout(function() {
                replaceText();
            }, 1000);
        }
    });
});


// Translate VAT input field label on my-account profile info page
jQuery(document).ready(function($) {
    if ($('body').hasClass('woocommerce-account')) {
      var lang = $('html').attr('lang');
      
      if (lang === 'lv') {
        $('label:contains("VAT")').text('PVN');
      }

      if (lang === 'lt-LT') {
        $('label:contains("VAT")').text('PVM');
      }

      if (lang === 'et') {
        $('label:contains("VAT")').text('KM');
      }

      if (lang === 'RU') {
        $('label:contains("VAT")').text('НДС');
      }

      if (lang === 'cs-CZ') {
        $('label:contains("VAT")').text('Káď');
      }
    }
});


