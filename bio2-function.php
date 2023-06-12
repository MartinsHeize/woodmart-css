<?php
/**
 * Enqueue script and styles for child theme
 */
function woodmart_child_enqueue_styles() {
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'woodmart-style' ), woodmart_get_theme_info( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'woodmart_child_enqueue_styles', 10010 );

// Add delivery info icon block after product meta in single product view
add_action( 'woocommerce_product_meta_end', 'single_delivery_block' );

/**
 * Function for `woocommerce_product_meta_end` action-hook.
 * 
 * @return void
 */
function single_delivery_block(){
	echo do_shortcode( '[html_block id="3994"]' );
}

// //Show translated text domain
// add_filter( 'gettext', 'filter_gettext', 10, 3 );
// function filter_gettext( $translation, $text, $domain ) {
//     if ( $text === 'Comments %s' && $domain === 'default' ) {
//         $translation = 'Отзывы %s';
//     }
//     return $translation.'(T- '.$domain.')';
// }


/**
 * Force WooCommerce terms and conditions link to open in a new page when clicked on the checkout page
 *
 * @author   Golden Oak Web Design <info@goldenoakwebdesign.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GPLv2+
 */
function golden_oak_web_design_woocommerce_checkout_terms_and_conditions() {
  remove_action( 'woocommerce_checkout_terms_and_conditions', 'wc_terms_and_conditions_page_content', 30 );
}
add_action( 'wp', 'golden_oak_web_design_woocommerce_checkout_terms_and_conditions' );


// // Set shiping methods free if $min_amount is reached
// add_filter('woocommerce_package_rates', 'apply_static_rate', 10, 2);
// function apply_static_rate($rates, $package) {

// // 	$isFree = " - 0.00 €";

//     $min_amount = 0;
	
// 	if ( isset( $rates['flat_rate:9'] ) || isset( $rates['flat_rate:11'] ) || isset( $rates['flat_rate:12'] ) || isset( $rates['flat_rate:19'] ) || isset( $rates['flat_rate:18'] ) || isset( $rates['flat_rate:27'] ) ) {
//       $min_amount = 20; //change this to your free shipping threshold for LV (16.52 w/o vat)
// 	} 
// 	if ( isset( $rates['flat_rate:1'] ) || isset( $rates['flat_rate:17'] ) ) {
//       $min_amount = 40; //change this to your free shipping threshold for LT, EE (33.05 w/o vat)
// 	}
// 	if ( isset( $rates['flat_rate:3'] ) ) {
//       $min_amount = 75; //change this to your free shipping threshold for EU (61.98 w/o vat)
// 	}
// 	if ( isset( $rates['flat_rate:7'] ) ) {
//       $min_amount = 150; //change this to your free shipping threshold for US, CAN (123.96 w/o vat)
// 	}
//    $current = WC()->cart->subtotal;
//    if ( $current < $min_amount || $min_amount == 0 ) {
//       return $rates;
//    } else {
//         foreach($rates as $key => $value) {
//             $rates[$key]->cost  =   0;    // your amount
// // 			$rates[$key]->label .= $isFree;
//         }
//         return $rates;
//    }
// }

// New Āll shippinmg free if reached min_amount. Min_amount set from woocommerce free shipping method and than hided
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

// disable coments only for blog posts
function disable_comments_for_posts($open, $post_id) {
  $post = get_post($post_id);
  if ($post->post_type == 'post') {
    $open = false;
  }
  return $open;
}
add_filter( 'comments_open', 'disable_comments_for_posts', 10, 2 );

function change_reviews_text($translated) {
    if (get_locale() == 'fi') {
        $translated = str_ireplace('Please select suitable payment option!', 'Valitse sopiva maksutapa!', $translated);
        return $translated;
    }
    if (get_locale() == 'sv-SE') {
        $translated = str_ireplace('Please select suitable payment option!', 'Välj lämpligt betalningsalternativ!', $translated);
        return $translated;
    }
    return $translated;
}
add_filter( 'gettext', 'change_reviews_text' );

// Reorder WooCommerce product tabs
add_filter( 'woocommerce_product_tabs', 'reorder_product_tabs', 98 );
function reorder_product_tabs( $tabs ) {
    // Change the priority of the description tab to 30
    $tabs['description']['priority'] = 30;

    // Change the priority of the reviews tab to 20
    $tabs['reviews']['priority'] = 20;

    return $tabs;
}

// Reverse the order of WooCommerce product reviews
function wpcodetips_reverse_reviews($reviewArguments){
    // Interject the reverse top level argument and set it to true
    $reviewArguments['reverse_top_level'] = true;

    // Return the arguments back again after alteration
    return $reviewArguments;
}
add_filter('woocommerce_product_review_list_args','wpcodetips_reverse_reviews');


// Unset Makecommerce if cart contains subscription product and if cart not contain subscription product, unset stripe

add_filter('woocommerce_available_payment_gateways', 'unset_payment_method_based_on_subscription', 10, 1);
function unset_payment_method_based_on_subscription($available_gateways) {
    if (WC_Subscriptions_Cart::cart_contains_subscription()) {
        // Replace 'payment_method_to_unset' with the desired payment method ID to unset
        unset($available_gateways['makecommerce']);
    }
    else {
        unset($available_gateways['stripe']);
    }
    return $available_gateways;
}

// // Currency swicher added in footer
// add_action( 'wp_head', 'global_shortcode_function' );
// function global_shortcode_function() {
// echo do_shortcode( '[wcj_currency_select_drop_down_list]' );
// }