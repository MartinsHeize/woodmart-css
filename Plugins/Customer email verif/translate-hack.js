if (jQuery('html').attr('lang') === 'lv') {
    // This function will be called when the .cev_pin_box is added to the DOM
    function updatePlaceholder(observer) {
        var $pinBox = jQuery('.cev_pin_box');
        if ($pinBox.length) {
        $pinBox.attr('placeholder', 'Ievadiet verifikācijas kodu'); // Placeholder in Latvian
        observer.disconnect(); // Disconnect after changing the placeholder
        }
    }

    // Set up a mutation observer to watch for changes in the DOM
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
        if (mutation.addedNodes && mutation.addedNodes.length > 0) {
            // DOM has changed, check if the .cev_pin_box has been added
            updatePlaceholder(observer);
        }
        });
    });

    // Start observing the body for added nodes
    observer.observe(document.body, {
        childList: true, // observe direct children
        subtree: true, // and lower descendants too
    });
}
  