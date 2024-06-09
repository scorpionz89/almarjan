<?php

defined('ABSPATH') || exit;

if (!class_exists('BigHearts_Header_Cart')) {
    class BigHearts_Header_Cart extends BigHearts_Get_Header
    {
        public function __construct()
        {
            if (!class_exists('\WooCommerce')) {
                return;
            }

            $this->header_vars();

            global $wgl_woo_cart;
            if (!empty($wgl_woo_cart)) {
                echo '<div class="wgl-cart-header">',
                    '<div class="wgl-mini-cart_wrapper">',
                    '<div class="mini-cart woocommerce">',
                        self::woo_cart(),
                    '</div>',
                    '</div>',
                '</div>';
            }
        }
    }

    new BigHearts_Header_Cart();
}
