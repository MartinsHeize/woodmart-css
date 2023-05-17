///////////////////////////////////////////////
// Translating registering role dropdown values
jQuery(document).ready(function($) {
    // Get the current language from the HTML lang attribute
    var currentLanguage = $('html').attr('lang');

    // Define the translation mappings for each language
    var translations = {
        'lv': {
            'Individual Customer': 'Individuāls Klients',
            'B2B (requires approval)': 'B2B (nepieciešams apstiprinājums)'
        },
        'pl-PL': {
            'Individual Customer': 'Klient indywidualny',
            'B2B (requires approval)': 'B2B (wymaga zatwierdzenia)'
        },
        'ru-RU': {
            'Individual Customer': 'Индивидуальный клиент',
            'B2B (requires approval)': 'B2B (требуется одобрение)'
        }
    };

    // Get the dropdown element
    var dropdown = $('#b2bking_registration_roles_dropdown');

    // Replace the option text based on the current language
    if (currentLanguage in translations) {
        var translation = translations[currentLanguage];
        dropdown.find('option:contains("Individual Customer")').text(translation['Individual Customer']);
        dropdown.find('option:contains("B2B (requires approval)")').text(translation['B2B (requires approval)']);
    }
});