<?php

// All shipping methods free if reached min_amount. Min_amount set from woocommerce free shipping method and than hided by this php snippet.
// Set shiping methods free if $min_amount is reached
add_filter('woocommerce_package_rates', 'apply_static_rate', 10, 2);
function apply_static_rate($rates, $package) {
	
	$has_free_shipping = false;

    foreach ($rates as $rate_key => $rate) {
        if ('free_shipping' === $rate->method_id) {
            $has_free_shipping = true;
            break;
        }
    }
	if ($has_free_shipping) {
		// Get the path to the plugins directory
		// $plugins_dir = WP_PLUGIN_DIR;

		// $exchange_rate = 1; //initialize exchange rate to 1

		// // Build the path to the plugin's main file
		// $plugin_path = $plugins_dir . '/booster-elite-for-woocommerce/booster-elite-for-woocommerce.php';
		// // Check if the plugin is installed
		// if ( file_exists( $plugin_path ) ) {
		//   // Check if the plugin is activated
		//   if ( is_plugin_active( 'booster-elite-for-woocommerce/booster-elite-for-woocommerce.php' ) ) {
		// 	  // plugin is active
		// 	  $user_selected_currency = wcj_get_current_currency_code( 'multicurrency' );
		// 	  $exchange_rate = wcj_get_currency_exchange_rate( 'multicurrency', $user_selected_currency );
		//   } 
		// }
		// Get the shipping zone matching the package
		$shipping_zone = WC_Shipping_Zones::get_zone_matching_package( $package );
		// Get the shipping zone ID
		$shipping_zone_id = $shipping_zone->get_id();
		// Get the shipping methods for the shipping zone
		$shipping_methods = $shipping_zone->get_shipping_methods();

		$minimum_order_amount = 0;
		foreach ($shipping_methods as $shipping_method) {
		// Check if it is a free shipping method

			if ($shipping_method->id === 'free_shipping') {
				// Get the minimum order amount
				$minimum_order_amount = $shipping_method->min_amount;
			}
		}


		// $min_amount = 0;

		// $min_amount = $minimum_order_amount * $exchange_rate;

		$current = WC()->cart->subtotal;

		if ( $current < $minimum_order_amount || $minimum_order_amount == 0 ) {
			return $rates;
		} else {
			foreach($rates as $key => $value) {

				$rates[$key]->cost  =   0;    // your amount
				// remove the native WooCommerce free shipping method
				if (strpos($key, 'free_shipping') !== false) {
					unset($rates[$key]);
				}
			}

			return $rates;
		}
	} else {
        return $rates;
    }
}

?>