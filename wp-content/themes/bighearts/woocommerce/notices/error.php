<?php
/**
 * Show error messages
 *
 * This template is overridden by WebGeniusLab team.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 8.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! $notices ) {
	return;
}

?>

<div class="bighearts_module_message_box type_error closable">
	<div class="message_icon_wrap" role="alert"><i class="message_icon"></i></div>
	<div class="message_content">
		<div class="message_text">
		<ul class="woocommerce-error" role="alert">
			<?php foreach ( $notices as $notice ) : ?>
                <li<?php echo wc_get_notice_data_attr( $notice ); ?>>
					<?php echo wc_kses_notice( $notice['notice'] ); ?>
                </li>
			<?php endforeach; ?>
		</ul>
		</div>
	</div>
	<span class="message_close_button"></span>
</div>
