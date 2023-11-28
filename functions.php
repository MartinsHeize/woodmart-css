<?php
/**
 * Enqueue script and styles for child theme
 */
function woodmart_child_enqueue_styles() {
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'woodmart-style' ), woodmart_get_theme_info( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'woodmart_child_enqueue_styles', 10010 );

/**
 * Customizes WooCommerce email styles.
 * Specifically, this code snippet ensures that the product attributes 
 * wrapped in <strong> tags within emails have a normal font weight, 
 * overriding the default bold style.
 */
function custom_woocommerce_email_styles( $css ) {
    // Override styles for <strong> within attributes to make it appear normal
    $css .= '.order_item .wc-item-meta li strong { font-weight: normal!important; }';
    return $css;
}
add_filter( 'woocommerce_email_styles', 'custom_woocommerce_email_styles' );


function change_reviews_text($translated) {
   if (get_locale() == 'lv') {
    $translated = str_ireplace('On backorder', 'Pēc pasūtījuma', $translated);
   return $translated;
}
	if (get_locale() == 'ru_RU') {
		$translated = str_ireplace('On backorder', 'Дозаказ', $translated);
   		return $translated;
	}
	 return $translated;
 }
 add_filter( 'gettext', 'change_reviews_text' );

 function change_place_order_text($translated) {
   if (get_locale() == 'lv') {
    $translated = str_ireplace('email', 'e-pasts', $translated);
   return $translated;
}
	if (get_locale() == 'ru_RU') {
		$translated = str_ireplace('email', 'e-почта', $translated);
   		return $translated;
	}
	 return $translated;
 }
 add_filter( 'gettext', 'change_place_order_text' );

function change_order_refunded_text($translated) {
   if (get_locale() == 'lv') {
    $translated = str_ireplace('Order fully refunded.', 'Pasūtījums atmaksāts.', $translated);
   return $translated;
}
	if (get_locale() == 'ru_RU') {
		$translated = str_ireplace('Order fully refunded.', 'Заказ полностью возвращен.', $translated);
   		return $translated;
	}
	 return $translated;
 }
 add_filter( 'gettext', 'change_order_refunded_text' );

 function change_order_refunded_dot_text($translated) {
   if (get_locale() == 'lv') {
    $translated = str_ireplace('Order fully refunded', 'Pasūtījums atmaksāts', $translated);
   return $translated;
}
	if (get_locale() == 'ru_RU') {
		$translated = str_ireplace('Order fully refunded', 'Заказ полностью возвращен', $translated);
   		return $translated;
	}
	 return $translated;
 }
 add_filter( 'gettext', 'change_order_refunded_dot_text' );

// Shortcode for current year used in footer.
function current_year_shortcode() {
    $year = date('Y'); // Get current year
    return $year;
}
add_shortcode('current_year', 'current_year_shortcode');

// Change terms link in checkout to open in new tab instead of opening accordion in same page
add_action( 'wp_footer', 'fww_add_jscript_checkout', 9999 );
function fww_add_jscript_checkout() {
   global $wp;
   if ( is_checkout() && empty( $wp->query_vars['order-pay'] ) && ! isset( $wp->query_vars['order-received'] ) ) {
      ?>
		<script type="text/javascript">
			jQuery(".woocommerce-checkout").on( 'click', 'a.woocommerce-terms-and-conditions-link', function(event) {
				event.stopPropagation();
				let TermsPageLink = jQuery('a.woocommerce-terms-and-conditions-link').attr('href');
				window.open(TermsPageLink, '_blank');
				return false;
			});
			
		</script>
		<?php
   }
}

// // php console log version for testing
function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
  ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

/**
 * Disable messages about the mobile apps in WooCommerce emails.
 * https://wordpress.org/support/topic/remove-process-your-orders-on-the-go-get-the-app/
 */
function mtp_disable_mobile_messaging( $mailer ) {
    remove_action( 'woocommerce_email_footer', array( $mailer->emails['WC_Email_New_Order'], 'mobile_messaging' ), 9 );
}
add_action( 'woocommerce_email', 'mtp_disable_mobile_messaging' );

/**
 * Customize WooCommerce Breadcrumbs
 * 
 * This WordPress snippet modifies the default WooCommerce breadcrumb trail
 * to include a "Shop" link when viewing a product category page.
 * The breadcrumb trail will display as "Home / Shop / Category".
 * 
 */

 add_filter('woocommerce_get_breadcrumb', 'customize_woocommerce_breadcrumbs', 20, 2);

 function customize_woocommerce_breadcrumbs($crumbs, $breadcrumb) {
     // Get the current WooCommerce query object
     global $wp_query;
 
     // Check if we're on a product category page
     if (is_product_category()) {
         // New breadcrumb array
         $new_crumbs = [];
 
         foreach ($crumbs as $key => $crumb) {
             // Add the crumb to the new breadcrumb array
             $new_crumbs[] = $crumb;
 
             // If the crumb is the "Home" crumb, insert the "Shop" crumb after it
             if ($key === 0) {
                 $shop_page_id = wc_get_page_id('shop');
                 $shop_page = get_post($shop_page_id);
 
                 if ($shop_page_id && $shop_page) {
                     $shop_crumb = [get_the_title($shop_page_id), get_permalink($shop_page_id)];
                     $new_crumbs[] = $shop_crumb;
                 }
             }
         }
 
         // Use the modified breadcrumb array
         $crumbs = $new_crumbs;
     }
 
     return $crumbs;
 }

?>