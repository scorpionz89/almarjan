<?php
/**
 * Product Loop Start
 *
 * This template is overridden by WebGeniusLab team.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$animation = (bool) BigHearts_Theme_Helper::get_option('use_animation_shop');
$animation_style = BigHearts_Theme_Helper::get_option('shop_catalog_animation_style');

$classes = (bool)$animation ? ' appear-animation' : "";
$classes .= (bool)$animation && !empty($animation_style) ? ' anim-'.$animation_style : "";

echo '<ul class="wgl-products'.esc_attr($classes).'">';
