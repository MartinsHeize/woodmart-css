<?php

add_action('wp_footer', 'add_vat_validation_message_element');
function add_vat_validation_message_element() {
    if (is_checkout()) { ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var vatFieldWrapper = document.querySelector('#eu_vat_number_field .woocommerce-input-wrapper');
                if (vatFieldWrapper && !document.getElementById('vat-validation-message')) {
                    var vatMessage = document.createElement('div');
                    vatMessage.id = 'vat-validation-message';
                    vatMessage.style.marginTop = '10px';
                    vatMessage.style.color = 'black';
                    vatFieldWrapper.appendChild(vatMessage);
                }
            });
        </script>
    <?php }
}

add_action('wp_footer', 'enqueue_custom_checkout_script');
function enqueue_custom_checkout_script() {
    if (is_checkout()) {?>
        <script>
            jQuery(document).ready(function($) {
                // Pievieno validation message elementu, ja tas neeksistē
                if ($('#vat-validation-message').length === 0) {
                    $('#eu_vat_number_field .woocommerce-input-wrapper').append('<div id="vat-validation-message" style="margin-top: 10px; color: red;"></div>');
                }

                $('input[name="eu_vat_number"]').on('blur', function() {
                    var vatNumber = $(this).val();
                    var vatMessage = $('#vat-validation-message');

                    if (vatNumber) {
                        $.ajax({
                            type: 'POST',
                            url: wc_checkout_params.ajax_url,
                            data: {
                                action: 'validate_vat_number',
                                vat_number: vatNumber,
                            },
                            success: function(response) {
                                if (response.success) {
                                    if (response.data.country_is_lv) {
                                        vatMessage.text('Valid VAT number in Latvia. Taxes will not be removed.').css('color', 'black');
                                    } else {
                                        vatMessage.text('VAT number is valid. Taxes will be removed.').css('color', 'green');
                                    }
                                } else {
                                    if (response.data && response.data.message) {
                                        if (response.data.message === 'VAT number is not valid') {
                                            vatMessage.text('Invalid VAT number.').css('color', 'red');
                                        } else {
                                            vatMessage.text(response.data.message).css('color', 'red');
                                        }
                                    } else {
                                        vatMessage.text('Error parsing the VAT number.').css('color', 'red');
                                    }
                                }
                                $('body').trigger('update_checkout');
                            }
                        });
                    }
                });

                var vatNumber = $('input[name="eu_vat_number"]').val();
                if (vatNumber) {
                    $('input[name="eu_vat_number"]').trigger('blur');
                }
            });
        </script>
    <?php }
}

add_action('wp_ajax_validate_vat_number', 'validate_vat_number');
add_action('wp_ajax_nopriv_validate_vat_number', 'validate_vat_number');
function validate_vat_number() {
    $vat_number = sanitize_text_field($_POST['vat_number']);
    $vat_country_code = substr($vat_number, 0, 2);

    $url = "https://ec.europa.eu/taxation_customs/vies/rest-api/ms/$vat_country_code/vat/$vat_number";

    $context_options = array(
        "ssl" => array(
            "verify_peer" => false,
            "verify_peer_name" => false,
        ),
    );
    $context = stream_context_create($context_options);

    $response = file_get_contents($url, false, $context);

    if ($response === false) {
        $error = error_get_last();
        wp_send_json_error(['message' => 'Error with remote request', 'error' => $error['message'], 'url' => $url]);
    }

    $data = json_decode($response);

    if (isset($data->isValid) && $data->isValid) {
        if ($vat_country_code === 'LV') {
            WC()->session->set('tax_exempt', false);
            wp_send_json_success(['country_is_lv' => true]);
        } else {
            WC()->session->set('tax_exempt', true);
            wp_send_json_success(['country_is_lv' => false]);
        }
    } else {
        WC()->session->set('tax_exempt', false);
        wp_send_json_error(['message' => 'VAT number is not valid']);
    }
}

add_action('woocommerce_checkout_update_order_review', 'apply_tax_exemption');
function apply_tax_exemption() {
    if (WC()->session->get('tax_exempt')) {
        WC()->customer->set_is_vat_exempt(true);
    } else {
        WC()->customer->set_is_vat_exempt(false);
    }
}

add_action('woocommerce_checkout_order_processed', 'clear_tax_exemption_preference');
function clear_tax_exemption_preference($order_id) {
    WC()->session->set('tax_exempt', false);
    WC()->customer->set_is_vat_exempt(false);
}